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

    public function assignPropertyOwner($propertyId)
    {
        return view('assign-property-owner', compact('propertyId'));
    }

    public function getPropertyDetails($propertyId)
    {
        try {
            $accessToken = session('access_token');
            
            if (!$accessToken) {
                return response()->json([
                    'success' => false,
                    'message' => 'Session expired. Please login again.'
                ], 401);
            }

            $headers = [
                'Authorization' => "Bearer {$accessToken}",
                'Accept' => 'application/json',
            ];

            $response = Http::timeout(30)->withHeaders($headers)->get("http://api2.smallsmall.com/api/properties/{$propertyId}");

            if ($response->successful()) {
                $apiData = $response->json();
                
                return response()->json([
                    'success' => $apiData['success'] ?? true,
                    'message' => $apiData['message'] ?? 'Property retrieved successfully',
                    'data' => $apiData['data'] ?? $apiData
                ]);
            } elseif ($response->status() === 401) {
                return response()->json([
                    'success' => false,
                    'message' => 'Session expired. Please login again.'
                ], 401);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to fetch property details from API.'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Property Details API Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while loading property details.'
            ], 500);
        }
    }

    public function assignPropertyOwnerAPI(Request $request)
    {
        try {
            $accessToken = session('access_token');
            
            if (!$accessToken) {
                return response()->json([
                    'success' => false,
                    'message' => 'Session expired. Please login again.'
                ], 401);
            }


            // Get data from request - try JSON first, then form data
            $propertyId = $request->input('property_id');
            $landlordId = $request->input('landlord_id');
            
            // If not found in input, try JSON
            if (!$propertyId || !$landlordId) {
                $json = json_decode($request->getContent(), true);
                if ($json) {
                    $propertyId = $propertyId ?: ($json['property_id'] ?? null);
                    $landlordId = $landlordId ?: ($json['landlord_id'] ?? null);
                }
            }

            if (!$propertyId || !$landlordId) {
                Log::error('Missing required data for property assignment', [
                    'property_id' => $propertyId,
                    'landlord_id' => $landlordId,
                    'all_input' => $request->all(),
                    'content_type' => $request->header('Content-Type'),
                    'raw_body' => $request->getContent(),
                    'json_decoded' => json_decode($request->getContent(), true)
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => "Property ID and Landlord ID are required."
                ], 400);
            }

            $headers = [
                'Authorization' => "Bearer {$accessToken}",
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ];

            $updateData = [
                'property_owner' => $landlordId
            ];

            $response = Http::timeout(30)->withHeaders($headers)->put("http://api2.smallsmall.com/api/properties/{$propertyId}", $updateData);

            if ($response->successful()) {
                $apiData = $response->json();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Property owner assigned successfully.',
                    'data' => $apiData['data'] ?? $apiData
                ]);
            } elseif ($response->status() === 401) {
                return response()->json([
                    'success' => false,
                    'message' => 'Session expired. Please login again.'
                ], 401);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to assign property owner. API responded with: ' . $response->body()
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Assign Property Owner API Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while assigning property owner.'
            ], 500);
        }
    }
}