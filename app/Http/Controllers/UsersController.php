<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UsersController extends Controller
{
    public function index()
    {
        // Check if user is authenticated
        if (!session('access_token')) {
            session()->flush();
            return redirect()->route('login')->with('error', 'Session expired. Please login again.');
        }
        
        // Return view immediately
        return view('users');
    }
    
    public function loadUsers(Request $request)
    {
        try {
            $accessToken = session('access_token');
            
            if (!$accessToken) {
                return response()->json(['error' => 'Session expired. Please login again.'], 401);
            }
            
            $headers = [
                'Authorization' => "Bearer {$accessToken}",
                'Accept' => 'application/json',
            ];
            
            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/users');
            
            if ($response->successful()) {
                $apiData = $response->json();
                $users = $apiData['data'] ?? $apiData['users'] ?? $apiData ?? [];
                return response()->json(['success' => true, 'users' => $users]);
            } elseif ($response->status() === 401) {
                return response()->json(['error' => 'Session expired. Please login again.'], 401);
            } else {
                return response()->json(['error' => 'Failed to load users. Please try again.'], 500);
            }
            
        } catch (\Exception $e) {
            Log::error('Users API Error: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while loading users.'], 500);
        }
    }
}
