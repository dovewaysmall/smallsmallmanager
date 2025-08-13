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

            $response = Http::timeout(30)->withHeaders($headers)->get("http://api2.smallsmall.com/api/inspections/{$id}");

            if ($response->successful()) {
                $apiData = $response->json();
                Log::info('Inspection API Response: ' . json_encode($apiData));
                
                // Pass the complete API response to access assigned_tsr and available_tsrs
                return view('inspection-detail', ['inspection' => $apiData, 'id' => $id]);
            } elseif ($response->status() === 401) {
                return redirect()->route('login')->with('error', 'Session expired. Please login again.');
            } else {
                return view('inspection-detail', ['inspection' => null, 'id' => $id, 'error' => 'Failed to load inspection data.']);
            }
        } catch (\Exception $e) {
            Log::error('Inspection Detail API Error: ' . $e->getMessage());
            return view('inspection-detail', ['inspection' => null, 'id' => $id, 'error' => 'An error occurred while loading inspection data.']);
        }
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