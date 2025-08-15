<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LandlordsController extends Controller
{
    public function index()
    {
        return view('landlords');
    }

    public function loadLandlords(Request $request)
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

            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/landlords');

            if ($response->successful()) {
                $apiData = $response->json();
                $landlords = $apiData['data'] ?? $apiData['landlords'] ?? $apiData ?? [];
                
                return response()->json([
                    'success' => true,
                    'landlords' => $landlords
                ]);
            } elseif ($response->status() === 401) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } else {
                return response()->json([
                    'error' => 'Failed to fetch landlords from API.'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Landlords API Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while loading landlords.'
            ], 500);
        }
    }

    public function thisWeek()
    {
        return view('landlords-this-week');
    }

    public function loadLandlordsThisWeek(Request $request)
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

            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/landlords/this-week');

            if ($response->successful()) {
                $apiData = $response->json();
                $landlords = $apiData['data'] ?? $apiData['landlords'] ?? $apiData ?? [];
                
                return response()->json([
                    'success' => true,
                    'landlords' => $landlords
                ]);
            } elseif ($response->status() === 401) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } else {
                return response()->json([
                    'error' => 'Failed to fetch landlords from API.'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Landlords This Week API Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while loading landlords.'
            ], 500);
        }
    }

    public function thisMonth()
    {
        return view('landlords-this-month');
    }

    public function loadLandlordsThisMonth(Request $request)
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

            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/landlords/this-month');

            if ($response->successful()) {
                $apiData = $response->json();
                $landlords = $apiData['data'] ?? $apiData['landlords'] ?? $apiData ?? [];
                
                return response()->json([
                    'success' => true,
                    'landlords' => $landlords
                ]);
            } elseif ($response->status() === 401) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } else {
                return response()->json([
                    'error' => 'Failed to fetch landlords from API.'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Landlords This Month API Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while loading landlords.'
            ], 500);
        }
    }

    public function thisYear()
    {
        return view('landlords-this-year');
    }

    public function loadLandlordsThisYear(Request $request)
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

            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/landlords/this-year');

            if ($response->successful()) {
                $apiData = $response->json();
                $landlords = $apiData['data'] ?? $apiData['landlords'] ?? $apiData ?? [];
                
                return response()->json([
                    'success' => true,
                    'landlords' => $landlords
                ]);
            } elseif ($response->status() === 401) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } else {
                return response()->json([
                    'error' => 'Failed to fetch landlords from API.'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Landlords This Year API Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while loading landlords.'
            ], 500);
        }
    }
}