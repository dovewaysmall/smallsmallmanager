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
            
            Log::info('Properties API - Token exists: ' . ($accessToken ? 'YES' : 'NO'));
            
            if (!$accessToken) {
                Log::warning('No access token found in session');
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            }

            $headers = [
                'Authorization' => "Bearer {$accessToken}",
                'Accept' => 'application/json',
            ];

            Log::info('Properties API - Making request to: http://api2.smallsmall.com/api/properties');
            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/properties');

            Log::info('Properties API - Response Status: ' . $response->status());
            Log::info('Properties API - Response Body: ' . $response->body());

            if ($response->successful()) {
                $apiData = $response->json();
                
                // Handle different possible response structures
                $properties = $apiData['data'] ?? $apiData['properties'] ?? $apiData ?? [];
                
                // Ensure properties is an array
                if (!is_array($properties)) {
                    $properties = [];
                }
                
                Log::info('Properties API - Properties count: ' . count($properties));
                
                return response()->json([
                    'success' => true,
                    'properties' => $properties
                ]);
            } elseif ($response->status() === 401) {
                Log::warning('Properties API returned 401 Unauthorized');
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } else {
                Log::error('Properties API returned error: ' . $response->status() . ' - ' . $response->body());
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

    public function landlordProperties($landlordId)
    {
        Log::info("Landlord properties page accessed for landlordId: {$landlordId}");
        
        // Get landlord details to show name in heading
        $landlord = $this->getLandlordDetails($landlordId);
        $landlordName = 'Landlord';
        
        if ($landlord) {
            $firstName = $landlord['firstName'] ?? '';
            $lastName = $landlord['lastName'] ?? '';
            $landlordName = trim("{$firstName} {$lastName}") ?: ($landlord['email'] ?? 'Landlord');
        }
        
        return view('landlord-properties', compact('landlordId', 'landlordName'));
    }

    private function getLandlordDetails($landlordId)
    {
        try {
            $accessToken = session('access_token');
            
            if (!$accessToken) {
                return null;
            }

            $headers = [
                'Authorization' => "Bearer {$accessToken}",
                'Accept' => 'application/json',
            ];

            // Try to get specific landlord details from API
            $response = Http::timeout(30)->withHeaders($headers)->get("http://api2.smallsmall.com/api/landlords/{$landlordId}");

            if ($response->successful()) {
                $apiData = $response->json();
                
                if (isset($apiData['success']) && $apiData['success'] && isset($apiData['data'])) {
                    return $apiData['data']['landlord_info'] ?? null;
                }
            }
            
            // If specific endpoint doesn't work, try to find in the list
            $listResponse = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/landlords');
            
            if ($listResponse->successful()) {
                $listData = $listResponse->json();
                $landlords = $listData['data'] ?? $listData['landlords'] ?? $listData ?? [];
                
                // Find the landlord with matching userID
                foreach ($landlords as $landlord) {
                    if (($landlord['userID'] ?? null) === $landlordId || ($landlord['id'] ?? null) === $landlordId) {
                        return $landlord;
                    }
                }
            }
            
            return null;
        } catch (\Exception $e) {
            Log::error('Error getting landlord details: ' . $e->getMessage());
            return null;
        }
    }

    public function loadLandlordProperties(Request $request, $landlordId)
    {
        try {
            $accessToken = session('access_token');
            
            Log::info("Loading properties for landlord: {$landlordId}");
            
            if (!$accessToken) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            }

            $headers = [
                'Authorization' => "Bearer {$accessToken}",
                'Accept' => 'application/json',
            ];

            // Get all properties first
            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/properties');

            if ($response->successful()) {
                $apiData = $response->json();
                $allProperties = $apiData['data'] ?? $apiData['properties'] ?? $apiData ?? [];
                
                // Filter properties for this specific landlord
                $landlordProperties = [];
                foreach ($allProperties as $property) {
                    $propertyLandlordId = $property['landlordID'] ?? $property['landlord_id'] ?? $property['property_owner'] ?? null;
                    
                    // Try different comparison methods
                    if ($propertyLandlordId == $landlordId || 
                        (string)$propertyLandlordId === (string)$landlordId ||
                        (isset($property['landlord']) && 
                         (($property['landlord']['userID'] ?? null) == $landlordId || 
                          ($property['landlord']['id'] ?? null) == $landlordId))) {
                        $landlordProperties[] = $property;
                    }
                }
                
                Log::info("Found {count} properties for landlord {$landlordId}", [
                    'count' => count($landlordProperties),
                    'landlord_id' => $landlordId
                ]);
                
                return response()->json([
                    'success' => true,
                    'properties' => $landlordProperties
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
            Log::error("Landlord Properties API Error: " . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while loading properties.'
            ], 500);
        }
    }
}