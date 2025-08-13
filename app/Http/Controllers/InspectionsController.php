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

    public function update($id, Request $request)
    {
        try {
            $accessToken = session('access_token');
            
            if (!$accessToken) {
                return redirect()->route('login')->with('error', 'Session expired. Please login again.');
            }

            $headers = [
                'Authorization' => "Bearer {$accessToken}",
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ];

            // Prepare data for API update - start with safe fields only
            $updateData = [];
            
            // Add fields one by one to identify which ones cause issues
            if ($request->assigned_tsr) {
                $updateData['assigned_tsr'] = $request->assigned_tsr;
            }
            
            if ($request->inspectionType) {
                $updateData['inspectionType'] = $request->inspectionType;
            }
            
            if ($request->platform) {
                $updateData['platform'] = $request->platform;
            }
            
            if ($request->verified) {
                $updateData['verified'] = $request->verified;
            }
            
            if ($request->comment) {
                $updateData['comment'] = $request->comment;
            }
            
            // Try status last since it was causing issues
            if ($request->inspection_status && $request->inspection_status !== '') {
                $updateData['inspection_status'] = $request->inspection_status;
            }

            // Remove null values and handle data format issues
            $updateData = array_filter($updateData, function($value) {
                return $value !== null && $value !== '';
            });

            // Handle potential database field length issues
            if (isset($updateData['inspection_status'])) {
                // Map longer status names to shorter database values if needed
                $statusMap = [
                    'pending-assigned' => 'assigned',  // If the database expects shorter values
                    'in_progress' => 'progress',
                ];
                
                if (isset($statusMap[$updateData['inspection_status']])) {
                    $updateData['inspection_status'] = $statusMap[$updateData['inspection_status']];
                }
            }

            Log::info('Inspection Update Request Data: ' . json_encode($updateData));
            
            // Try different HTTP methods to find the correct one
            $response = Http::timeout(30)->withHeaders($headers)->patch("http://api2.smallsmall.com/api/inspections/{$id}", $updateData);
            
            // If PATCH doesn't work, try PUT
            if (!$response->successful() && $response->status() === 405) {
                Log::info('PATCH failed with 405, trying PUT');
                $response = Http::timeout(30)->withHeaders($headers)->put("http://api2.smallsmall.com/api/inspections/{$id}", $updateData);
            }
            
            // If PUT doesn't work, try different endpoint with POST
            if (!$response->successful() && $response->status() === 405) {
                Log::info('PUT failed with 405, trying POST to update endpoint');
                $response = Http::timeout(30)->withHeaders($headers)->post("http://api2.smallsmall.com/api/inspections/update/{$id}", $updateData);
            }

            Log::info('Inspection Update Response Status: ' . $response->status());
            Log::info('Inspection Update Response Body: ' . $response->body());

            if ($response->successful()) {
                return redirect()->route('inspection.show', $id)->with('success', 'Inspection updated successfully.');
            } elseif ($response->status() === 401) {
                return redirect()->route('login')->with('error', 'Session expired. Please login again.');
            } else {
                Log::error('Inspection Update API Error - Status: ' . $response->status() . ' - Body: ' . $response->body());
                return redirect()->route('inspection.show', $id)->with('error', 'Failed to update inspection. Status: ' . $response->status() . '. Please check the logs for details.');
            }
        } catch (\Exception $e) {
            Log::error('Inspection Update API Error: ' . $e->getMessage());
            return redirect()->route('inspection.show', $id)->with('error', 'An error occurred while updating inspection data.');
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