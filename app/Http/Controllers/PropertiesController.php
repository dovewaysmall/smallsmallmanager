<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PropertiesController extends Controller
{
    public function index()
    {
        return view('properties');
    }

    public function loadProperties(Request $request)
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

            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/properties');

            if ($response->successful()) {
                $apiData = $response->json();
                $properties = $apiData['data'] ?? $apiData['properties'] ?? $apiData ?? [];
                
                return response()->json([
                    'success' => true,
                    'properties' => $properties
                ]);
            } elseif ($response->status() === 401) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } else {
                return response()->json([
                    'error' => 'Failed to fetch properties from API.'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Properties API Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while loading properties.'
            ], 500);
        }
    }

    public function thisWeek()
    {
        return view('properties-this-week');
    }

    public function loadPropertiesThisWeek(Request $request)
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

            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/properties/this-week');

            if ($response->successful()) {
                $apiData = $response->json();
                $properties = $apiData['data'] ?? $apiData['properties'] ?? $apiData ?? [];
                
                return response()->json([
                    'success' => true,
                    'properties' => $properties
                ]);
            } elseif ($response->status() === 401) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } else {
                return response()->json([
                    'error' => 'Failed to fetch properties from API.'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Properties This Week API Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while loading properties.'
            ], 500);
        }
    }

    public function thisMonth()
    {
        return view('properties-this-month');
    }

    public function loadPropertiesThisMonth(Request $request)
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

            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/properties/this-month');

            if ($response->successful()) {
                $apiData = $response->json();
                $properties = $apiData['data'] ?? $apiData['properties'] ?? $apiData ?? [];
                
                return response()->json([
                    'success' => true,
                    'properties' => $properties
                ]);
            } elseif ($response->status() === 401) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } else {
                return response()->json([
                    'error' => 'Failed to fetch properties from API.'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Properties This Month API Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while loading properties.'
            ], 500);
        }
    }

    public function thisYear()
    {
        return view('properties-this-year');
    }

    public function loadPropertiesThisYear(Request $request)
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

            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/properties/this-year');

            if ($response->successful()) {
                $apiData = $response->json();
                $properties = $apiData['data'] ?? $apiData['properties'] ?? $apiData ?? [];
                
                return response()->json([
                    'success' => true,
                    'properties' => $properties
                ]);
            } elseif ($response->status() === 401) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } else {
                return response()->json([
                    'error' => 'Failed to fetch properties from API.'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Properties This Year API Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while loading properties.'
            ], 500);
        }
    }
}