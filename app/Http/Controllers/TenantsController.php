<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TenantsController extends Controller
{
    public function index()
    {
        return view('tenants');
    }

    public function show($userID)
    {
        return view('tenant-detail', compact('userID'));
    }

    public function thisWeek()
    {
        return view('tenants-this-week');
    }

    public function thisMonth()
    {
        return view('tenants-this-month');
    }

    public function thisYear()
    {
        return view('tenants-this-year');
    }

    public function loadTenants(Request $request)
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

            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/tenants');

            if ($response->successful()) {
                $apiData = $response->json();
                $tenants = $apiData['data'] ?? $apiData['tenants'] ?? $apiData ?? [];
                
                return response()->json([
                    'success' => true,
                    'tenants' => $tenants
                ]);
            } elseif ($response->status() === 401) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } else {
                return response()->json([
                    'error' => 'Failed to fetch tenants from API.'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Tenants API Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while loading tenants.'
            ], 500);
        }
    }

    public function loadTenantsThisWeek(Request $request)
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

            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/tenants/this-week');

            if ($response->successful()) {
                $apiData = $response->json();
                $tenants = $apiData['data'] ?? $apiData['tenants'] ?? $apiData ?? [];
                
                return response()->json([
                    'success' => true,
                    'tenants' => $tenants
                ]);
            } elseif ($response->status() === 401) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } else {
                return response()->json([
                    'error' => 'Failed to fetch tenants from API.'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Tenants This Week API Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while loading tenants.'
            ], 500);
        }
    }

    public function loadTenantsThisMonth(Request $request)
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

            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/tenants/this-month');

            if ($response->successful()) {
                $apiData = $response->json();
                $tenants = $apiData['data'] ?? $apiData['tenants'] ?? $apiData ?? [];
                
                return response()->json([
                    'success' => true,
                    'tenants' => $tenants
                ]);
            } elseif ($response->status() === 401) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } else {
                return response()->json([
                    'error' => 'Failed to fetch tenants from API.'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Tenants This Month API Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while loading tenants.'
            ], 500);
        }
    }

    public function loadTenantsThisYear(Request $request)
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

            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/tenants/this-year');

            if ($response->successful()) {
                $apiData = $response->json();
                $tenants = $apiData['data'] ?? $apiData['tenants'] ?? $apiData ?? [];
                
                return response()->json([
                    'success' => true,
                    'tenants' => $tenants
                ]);
            } elseif ($response->status() === 401) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } else {
                return response()->json([
                    'error' => 'Failed to fetch tenants from API.'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Tenants This Year API Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while loading tenants.'
            ], 500);
        }
    }
}