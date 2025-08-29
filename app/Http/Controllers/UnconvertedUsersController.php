<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UnconvertedUsersController extends Controller
{
    public function index()
    {
        // Check authentication first
        $accessToken = session('access_token');
        if (!$accessToken) {
            session()->flush();
            return redirect()->route('login')->with('error', 'Session expired. Please login again.');
        }
        
        return view('unconverted-users');
    }

    public function show($id)
    {
        try {
            $accessToken = session('access_token');
            
            if (!$accessToken) {
                return redirect()->route('login')->with('error', 'Session expired. Please login again.');
            }

            $headers = [
                'Authorization' => "Bearer {$accessToken}",
                'Accept' => 'application/json',
            ];

            $url = "http://api2.smallsmall.com/api/users/unconverted/{$id}";
            Log::info("Making API request to: {$url}");
            Log::info("Request headers: " . json_encode($headers));

            $response = Http::timeout(30)->withHeaders($headers)->get($url);

            Log::info("API Response Status: " . $response->status());
            Log::info("API Response Body: " . $response->body());

            if ($response->successful()) {
                $apiData = $response->json();
                Log::info('Unconverted User Detail API Response: ' . json_encode($apiData));
                
                // Pass the complete API response to the view
                return view('unconverted-user-detail', ['user' => $apiData, 'id' => $id]);
            } elseif ($response->status() === 401) {
                return redirect()->route('login')->with('error', 'Session expired. Please login again.');
            } else {
                $responseBody = $response->json();
                $apiMessage = $responseBody['message'] ?? 'Unknown error';
                $errorMessage = "Failed to load user data. Status: " . $response->status() . ". Message: " . $apiMessage;
                Log::error($errorMessage);
                Log::error("Full response: " . $response->body());
                
                // Show user-friendly message
                $displayMessage = $response->status() === 404 ? 
                    "User not found or user is no longer unconverted (may have bookings)." : 
                    "Failed to load user data: " . $apiMessage;
                    
                return view('unconverted-user-detail', ['user' => null, 'id' => $id, 'error' => $displayMessage]);
            }
        } catch (\Exception $e) {
            Log::error('Unconverted User Detail API Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return view('unconverted-user-detail', ['user' => null, 'id' => $id, 'error' => 'An error occurred while loading user data: ' . $e->getMessage()]);
        }
    }

    public function loadUnconvertedUsers(Request $request)
    {
        try {
            $accessToken = session('access_token');
            
            if (!$accessToken) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            }

            $headers = [
                'Authorization' => "Bearer {$accessToken}",
                'Accept' => 'application/json',
            ];

            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/users/unconverted');

            if ($response->successful()) {
                $apiData = $response->json();
                $users = $apiData['data'] ?? $apiData['users'] ?? $apiData ?? [];
                
                // Log the structure of users to understand what ID field to use
                Log::info('Unconverted Users API Response Structure: ' . json_encode($apiData));
                if (!empty($users)) {
                    Log::info('First user structure: ' . json_encode($users[0]));
                }
                
                return response()->json([
                    'success' => true,
                    'users' => $users
                ]);
            } elseif ($response->status() === 401) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } else {
                return response()->json([
                    'error' => 'Failed to fetch unconverted users from API.'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Unconverted Users API Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while loading unconverted users.'
            ], 500);
        }
    }

    public function thisWeek()
    {
        return view('unconverted-users-this-week');
    }

    public function loadUnconvertedUsersThisWeek(Request $request)
    {
        try {
            $accessToken = session('access_token');
            
            if (!$accessToken) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            }

            $headers = [
                'Authorization' => "Bearer {$accessToken}",
                'Accept' => 'application/json',
            ];

            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/users/unconverted/this-week');

            if ($response->successful()) {
                $apiData = $response->json();
                $users = $apiData['data'] ?? $apiData['users'] ?? $apiData ?? [];
                
                return response()->json([
                    'success' => true,
                    'users' => $users
                ]);
            } elseif ($response->status() === 401) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } else {
                return response()->json([
                    'error' => 'Failed to fetch unconverted users from API.'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Unconverted Users This Week API Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while loading unconverted users.'
            ], 500);
        }
    }

    public function thisMonth()
    {
        return view('unconverted-users-this-month');
    }

    public function loadUnconvertedUsersThisMonth(Request $request)
    {
        try {
            $accessToken = session('access_token');
            
            if (!$accessToken) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            }

            $headers = [
                'Authorization' => "Bearer {$accessToken}",
                'Accept' => 'application/json',
            ];

            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/users/unconverted/this-month');

            if ($response->successful()) {
                $apiData = $response->json();
                $users = $apiData['data'] ?? $apiData['users'] ?? $apiData ?? [];
                
                return response()->json([
                    'success' => true,
                    'users' => $users
                ]);
            } elseif ($response->status() === 401) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } else {
                return response()->json([
                    'error' => 'Failed to fetch unconverted users from API.'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Unconverted Users This Month API Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while loading unconverted users.'
            ], 500);
        }
    }

    public function thisYear()
    {
        return view('unconverted-users-this-year');
    }

    public function loadUnconvertedUsersThisYear(Request $request)
    {
        try {
            $accessToken = session('access_token');
            
            if (!$accessToken) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            }

            $headers = [
                'Authorization' => "Bearer {$accessToken}",
                'Accept' => 'application/json',
            ];

            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/users/unconverted/this-year');

            if ($response->successful()) {
                $apiData = $response->json();
                $users = $apiData['data'] ?? $apiData['users'] ?? $apiData ?? [];
                
                return response()->json([
                    'success' => true,
                    'users' => $users
                ]);
            } elseif ($response->status() === 401) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } else {
                return response()->json([
                    'error' => 'Failed to fetch unconverted users from API.'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Unconverted Users This Year API Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while loading unconverted users.'
            ], 500);
        }
    }
}