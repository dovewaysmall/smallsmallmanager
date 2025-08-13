<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VerificationsController extends Controller
{
    public function index()
    {
        return view('verifications');
    }

    public function loadVerifications(Request $request)
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

            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/verifications');

            if ($response->successful()) {
                $apiData = $response->json();
                $verifications = $apiData['data'] ?? $apiData['verifications'] ?? $apiData ?? [];
                
                return response()->json([
                    'success' => true,
                    'verifications' => $verifications
                ]);
            } elseif ($response->status() === 401) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } else {
                return response()->json([
                    'error' => 'Failed to fetch verifications from API.'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Verifications API Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while loading verifications.'
            ], 500);
        }
    }

    public function thisWeek()
    {
        return view('verifications-this-week');
    }

    public function loadVerificationsThisWeek(Request $request)
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

            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/verifications/this-week');

            if ($response->successful()) {
                $apiData = $response->json();
                $verifications = $apiData['data'] ?? $apiData['verifications'] ?? $apiData ?? [];
                
                return response()->json([
                    'success' => true,
                    'verifications' => $verifications
                ]);
            } elseif ($response->status() === 401) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } else {
                return response()->json([
                    'error' => 'Failed to fetch verifications from API.'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Verifications This Week API Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while loading verifications.'
            ], 500);
        }
    }

    public function thisMonth()
    {
        return view('verifications-this-month');
    }

    public function loadVerificationsThisMonth(Request $request)
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

            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/verifications/this-month');

            if ($response->successful()) {
                $apiData = $response->json();
                $verifications = $apiData['data'] ?? $apiData['verifications'] ?? $apiData ?? [];
                
                return response()->json([
                    'success' => true,
                    'verifications' => $verifications
                ]);
            } elseif ($response->status() === 401) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } else {
                return response()->json([
                    'error' => 'Failed to fetch verifications from API.'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Verifications This Month API Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while loading verifications.'
            ], 500);
        }
    }

    public function thisYear()
    {
        return view('verifications-this-year');
    }

    public function loadVerificationsThisYear(Request $request)
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

            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/verifications/this-year');

            if ($response->successful()) {
                $apiData = $response->json();
                $verifications = $apiData['data'] ?? $apiData['verifications'] ?? $apiData ?? [];
                
                return response()->json([
                    'success' => true,
                    'verifications' => $verifications
                ]);
            } elseif ($response->status() === 401) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } else {
                return response()->json([
                    'error' => 'Failed to fetch verifications from API.'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Verifications This Year API Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while loading verifications.'
            ], 500);
        }
    }
}