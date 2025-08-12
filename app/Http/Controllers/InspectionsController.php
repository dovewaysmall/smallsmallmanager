<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class InspectionsController extends Controller
{
    public function index()
    {
        return view('inspections');
    }

    public function thisWeek()
    {
        return view('inspections-this-week');
    }

    public function thisMonth()
    {
        return view('inspections-this-month');
    }

    public function thisYear()
    {
        return view('inspections-this-year');
    }

    public function loadInspections(Request $request)
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

            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/inspections');

            if ($response->successful()) {
                $apiData = $response->json();
                $inspections = $apiData['data'] ?? $apiData['inspections'] ?? $apiData ?? [];
                
                return response()->json([
                    'success' => true,
                    'inspections' => $inspections
                ]);
            } elseif ($response->status() === 401) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } else {
                return response()->json([
                    'error' => 'Failed to fetch inspections from API.'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Inspections API Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while loading inspections.'
            ], 500);
        }
    }

    public function loadInspectionsThisWeek(Request $request)
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

            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/inspections/this-week');

            if ($response->successful()) {
                $apiData = $response->json();
                $inspections = $apiData['data'] ?? $apiData['inspections'] ?? $apiData ?? [];
                
                return response()->json([
                    'success' => true,
                    'inspections' => $inspections
                ]);
            } elseif ($response->status() === 401) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } else {
                return response()->json([
                    'error' => 'Failed to fetch inspections from API.'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Inspections This Week API Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while loading inspections.'
            ], 500);
        }
    }

    public function loadInspectionsThisMonth(Request $request)
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

            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/inspections/this-month');

            if ($response->successful()) {
                $apiData = $response->json();
                $inspections = $apiData['data'] ?? $apiData['inspections'] ?? $apiData ?? [];
                
                return response()->json([
                    'success' => true,
                    'inspections' => $inspections
                ]);
            } elseif ($response->status() === 401) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } else {
                return response()->json([
                    'error' => 'Failed to fetch inspections from API.'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Inspections This Month API Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while loading inspections.'
            ], 500);
        }
    }

    public function loadInspectionsThisYear(Request $request)
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

            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/inspections/this-year');

            if ($response->successful()) {
                $apiData = $response->json();
                $inspections = $apiData['data'] ?? $apiData['inspections'] ?? $apiData ?? [];
                
                return response()->json([
                    'success' => true,
                    'inspections' => $inspections
                ]);
            } elseif ($response->status() === 401) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } else {
                return response()->json([
                    'error' => 'Failed to fetch inspections from API.'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Inspections This Year API Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while loading inspections.'
            ], 500);
        }
    }
}