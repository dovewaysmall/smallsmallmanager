<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UnconvertedUsersController extends Controller
{
    public function index()
    {
        return view('unconverted-users');
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