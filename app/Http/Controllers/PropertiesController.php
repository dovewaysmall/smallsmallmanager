<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Helpers\RoleHelper;

class PropertiesController extends Controller
{
    public function index()
    {
        // Check authentication first
        $accessToken = session('access_token');
        if (!$accessToken) {
            session()->flush();
            return redirect()->route('login')->with('error', 'Session expired. Please login again.');
        }
        
        $canDelete = RoleHelper::canDelete();
        return view('properties', compact('canDelete'));
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

    public function deleteProperty($propertyId)
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
                'Content-Type' => 'application/json',
            ];

            Log::info("Attempting to delete property: {$propertyId}");
            
            $response = Http::timeout(30)->withHeaders($headers)->delete("http://api2.smallsmall.com/api/properties/{$propertyId}");

            Log::info("Delete Property API Response: Status {$response->status()}, Body: {$response->body()}");

            if ($response->successful()) {
                $responseData = $response->json();
                Log::info('Property deleted successfully', ['property_id' => $propertyId, 'response' => $responseData]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Property deleted successfully!',
                    'property_id' => $propertyId
                ]);
            } elseif ($response->status() === 401) {
                return response()->json([
                    'success' => false,
                    'message' => 'Session expired. Please login again.'
                ], 401);
            } elseif ($response->status() === 404) {
                return response()->json([
                    'success' => false,
                    'message' => 'Property not found or already deleted.'
                ], 404);
            } else {
                $errorData = $response->json();
                Log::error('Delete Property API Error', [
                    'property_id' => $propertyId,
                    'status_code' => $response->status(),
                    'response_body' => $errorData
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => $errorData['message'] ?? 'Failed to delete property. Please try again.'
                ], 400);
            }
        } catch (\Exception $e) {
            Log::error('Delete Property Error: ' . $e->getMessage(), [
                'property_id' => $propertyId,
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the property.'
            ], 500);
        }
    }

    public function show($propertyId)
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

            $response = Http::timeout(30)->withHeaders($headers)->get("http://api2.smallsmall.com/api/properties/{$propertyId}");

            if ($response->successful()) {
                $apiData = $response->json();
                Log::info('Property API Response: ' . json_encode($apiData));
                
                return view('property-detail', ['property' => $apiData, 'propertyId' => $propertyId]);
            } elseif ($response->status() === 401) {
                return redirect()->route('login')->with('error', 'Session expired. Please login again.');
            } else {
                return view('property-detail', ['property' => null, 'propertyId' => $propertyId, 'error' => 'Failed to load property data.']);
            }
        } catch (\Exception $e) {
            Log::error('Property Detail API Error: ' . $e->getMessage());
            return view('property-detail', ['property' => null, 'propertyId' => $propertyId, 'error' => 'An error occurred while loading property data.']);
        }
    }

    public function edit($propertyId)
    {
        try {
            $accessToken = session('access_token');
            
            Log::info("Property Edit - Attempting to edit property: {$propertyId}");
            Log::info("Property Edit - Property ID type: " . gettype($propertyId));
            Log::info("Property Edit - Property ID is numeric: " . (is_numeric($propertyId) ? 'YES' : 'NO'));
            
            if (!$accessToken) {
                Log::warning('Property Edit - No access token found');
                return redirect()->route('login')->with('error', 'Session expired. Please login again.');
            }

            $headers = [
                'Authorization' => "Bearer {$accessToken}",
                'Accept' => 'application/json',
            ];

            $apiUrl = "http://api2.smallsmall.com/api/properties/{$propertyId}";
            Log::info("Property Edit - Making API request to: {$apiUrl}");
            
            $response = Http::timeout(30)->withHeaders($headers)->get($apiUrl);

            Log::info("Property Edit - API Response Status: {$response->status()}");
            Log::info("Property Edit - API Response Body: {$response->body()}");

            if ($response->successful()) {
                $apiData = $response->json();
                Log::info('Property Edit - Successful response received');
                
                return view('property-edit', ['property' => $apiData, 'propertyId' => $propertyId]);
            } elseif ($response->status() === 401) {
                Log::warning('Property Edit - Unauthorized (401)');
                return redirect()->route('login')->with('error', 'Session expired. Please login again.');
            } elseif ($response->status() === 404) {
                Log::warning("Property Edit - Property not found (404) for ID: {$propertyId}");
                
                // Try to find the property in the general properties list as fallback
                Log::info('Property Edit - Attempting fallback: searching all properties');
                $fallbackResponse = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/properties');
                
                if ($fallbackResponse->successful()) {
                    $allProperties = $fallbackResponse->json();
                    $properties = $allProperties['data'] ?? $allProperties['properties'] ?? $allProperties ?? [];
                    
                    foreach ($properties as $property) {
                        if (($property['propertyID'] ?? '') === $propertyId || ($property['id'] ?? '') === $propertyId) {
                            Log::info("Property Edit - Found property in fallback search: {$propertyId}");
                            return view('property-edit', ['property' => ['data' => ['property' => $property]], 'propertyId' => $propertyId]);
                        }
                    }
                }
                
                return view('property-edit', [
                    'property' => null, 
                    'propertyId' => $propertyId, 
                    'error' => "Property with ID '{$propertyId}' not found."
                ]);
            } else {
                Log::error("Property Edit - API Error: Status {$response->status()} - {$response->body()}");
                return view('property-edit', [
                    'property' => null, 
                    'propertyId' => $propertyId, 
                    'error' => 'Failed to load property data. Status: ' . $response->status()
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Property Edit API Error: ' . $e->getMessage());
            return view('property-edit', [
                'property' => null, 
                'propertyId' => $propertyId, 
                'error' => 'An error occurred while loading property data: ' . $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, $propertyId)
    {
        try {
            $accessToken = session('access_token');
            
            Log::info("Property Update - Attempting to update property: {$propertyId}");
            Log::info("Property Update - Property ID type: " . gettype($propertyId));
            Log::info("Property Update - Property ID length: " . strlen($propertyId));
            Log::info("Property Update - Property ID is numeric: " . (is_numeric($propertyId) ? 'YES' : 'NO'));
            
            if (!$accessToken) {
                Log::warning('Property Update - No access token found');
                return redirect()->route('login')->with('error', 'Session expired. Please login again.');
            }

            $headers = [
                'Authorization' => "Bearer {$accessToken}",
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ];

            // Validate required fields first
            if (empty($request->propertyTitle)) {
                return redirect()->route('property.edit', $propertyId)->with('error', 'Property title is required.');
            }

            // Prepare data for API - match your sample format exactly
            $updateData = [];
            
            // Send all form fields to ensure complete update
            $updateData = [
                'propertyTitle' => $request->propertyTitle,
                'propertyDescription' => $request->propertyDescription ?? '',
                'address' => $request->address ?? '',
                'city' => $request->city ?? '',
                'bed' => (int)($request->bed ?? 0),
                'bath' => (int)($request->bath ?? 0),  
                'toilet' => (int)($request->toilet ?? 0),
                'price' => (string)($request->price ?? 0), // API expects string
                'serviceCharge' => (string)($request->serviceCharge ?? 0), // API expects string
                'securityDeposit' => (string)($request->securityDeposit ?? 0), // API expects string
                'available_date' => $request->available_date ?? null,
                'paymentPlan' => $request->paymentPlan ?? 'flexible',
            ];
            
            // Skip propertyType for now - it's causing validation issues
            // TODO: Figure out correct propertyType mapping later
            Log::info("Property Update - Skipping propertyType to avoid validation errors");
            
            // Log payment plan for debugging
            Log::info("Property Update - paymentPlan from form: '{$request->paymentPlan}'");
            Log::info("Property Update - paymentPlan in data: '{$updateData['paymentPlan']}'");
            
            // Handle status mapping
            if (!empty($request->status)) {
                $statusMap = [
                    'yes' => 'available',
                    'no' => 'inactive'
                ];
                $updateData['status'] = $statusMap[$request->status] ?? $request->status;
            }
            
            // Handle furnishing mapping  
            if (!empty($request->furnishing)) {
                $furnishingMap = [
                    '1' => 'furnished',
                    '0' => 'unfurnished'
                ];
                $updateData['furnishing'] = $furnishingMap[$request->furnishing] ?? $request->furnishing;
            }
            
            // Remove null values but keep empty strings and zeros
            $updateData = array_filter($updateData, function($value) {
                return $value !== null;
            });

            $apiUrl = "http://api2.smallsmall.com/api/properties/{$propertyId}";
            Log::info("Property Update - Making PUT request to: {$apiUrl}");
            Log::info("Property Update - Data: " . json_encode($updateData));
            
            $response = Http::timeout(30)->withHeaders($headers)->put($apiUrl, $updateData);

            Log::info('Property Update API Response Status: ' . $response->status());
            Log::info('Property Update API Response Body: ' . $response->body());

            if ($response->successful()) {
                $responseData = $response->json();
                Log::info("Property Update - Success: Property {$propertyId} updated successfully");
                Log::info("Property Update - API Response Data: " . json_encode($responseData));
                
                // Check if the API response indicates actual success
                if (isset($responseData['success']) && $responseData['success'] === false) {
                    $message = $responseData['message'] ?? 'Update failed despite 200 status';
                    Log::warning("Property Update - API returned success=false: {$message}");
                    return redirect()->route('property.edit', $propertyId)->with('error', $message);
                }
                
                return redirect()->route('property.show', $propertyId)->with('success', 'Property updated successfully!');
            } elseif ($response->status() === 401) {
                Log::warning('Property Update - Unauthorized (401)');
                return redirect()->route('login')->with('error', 'Session expired. Please login again.');
            } elseif ($response->status() === 404) {
                Log::error("Property Update - Property not found (404) for ID: {$propertyId}");
                
                // Check if property exists in the system first
                $checkResponse = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/properties');
                if ($checkResponse->successful()) {
                    $allProperties = $checkResponse->json();
                    $properties = $allProperties['data'] ?? $allProperties['properties'] ?? $allProperties ?? [];
                    
                    $propertyExists = false;
                    foreach ($properties as $property) {
                        if (($property['propertyID'] ?? '') === $propertyId || ($property['id'] ?? '') === $propertyId) {
                            $propertyExists = true;
                            break;
                        }
                    }
                    
                    if ($propertyExists) {
                        Log::info("Property Update - Property exists but update endpoint returned 404");
                        return redirect()->route('property.edit', $propertyId)->with('error', 'Property update endpoint not available. Please try again later.');
                    } else {
                        Log::info("Property Update - Property does not exist in system");
                        return redirect()->route('properties')->with('error', "Property with ID '{$propertyId}' no longer exists in the system.");
                    }
                } else {
                    return redirect()->route('property.edit', $propertyId)->with('error', 'Unable to verify property existence. Please try again later.');
                }
            } else {
                Log::error("Property Update - API Error: Status {$response->status()} - {$response->body()}");
                $errorData = $response->json();
                
                // Handle validation errors specifically
                if ($response->status() === 422 && isset($errorData['errors'])) {
                    $validationErrors = [];
                    foreach ($errorData['errors'] as $field => $messages) {
                        $validationErrors[] = $field . ': ' . implode(', ', $messages);
                    }
                    $errorMessage = 'Validation failed: ' . implode('; ', $validationErrors);
                } else {
                    $errorMessage = $errorData['message'] ?? 'Failed to update property. Status: ' . $response->status();
                }
                
                return redirect()->route('property.edit', $propertyId)->with('error', $errorMessage);
            }
        } catch (\Exception $e) {
            Log::error('Property Update Error: ' . $e->getMessage(), [
                'property_id' => $propertyId,
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('property.edit', $propertyId)->with('error', 'An error occurred while updating the property.');
        }
    }

    public function add()
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

            // Load landlords for the dropdown
            $landlordsResponse = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/landlords');
            $landlords = [];
            
            if ($landlordsResponse->successful()) {
                $landlordsData = $landlordsResponse->json();
                $landlords = $landlordsData['data'] ?? $landlordsData['landlords'] ?? $landlordsData ?? [];
                Log::info('Property Add - Loaded ' . count($landlords) . ' landlords');
            } else {
                Log::warning('Property Add - Failed to load landlords: ' . $landlordsResponse->status());
            }

            return view('property-add', ['landlords' => $landlords]);
        } catch (\Exception $e) {
            Log::error('Property Add - Error loading page: ' . $e->getMessage());
            return view('property-add', ['landlords' => []]);
        }
    }

    public function store(Request $request)
    {
        try {
            $accessToken = session('access_token');
            
            Log::info("Property Store - Attempting to create new property");
            Log::info("Property Store - Form landlordID value: '" . ($request->landlordID ?? 'NULL') . "'");
            Log::info("Property Store - All form data: " . json_encode($request->all()));
            
            if (!$accessToken) {
                Log::warning('Property Store - No access token found');
                return redirect()->route('login')->with('error', 'Session expired. Please login again.');
            }

            // Validate required fields
            $errors = [];
            if (empty($request->propertyTitle)) {
                $errors[] = 'Property title is required';
            }
            if (empty($request->propertyType)) {
                $errors[] = 'Property type is required';
            }
            if (empty($request->state)) {
                $errors[] = 'State is required';
            }
            if (empty($request->country)) {
                $errors[] = 'Country is required';
            }
            if (empty($request->landlordID)) {
                $errors[] = 'Property owner is required';
            }
            
            if (!empty($errors)) {
                return redirect()->route('properties.add')->with('error', implode(', ', $errors));
            }

            $headers = [
                'Authorization' => "Bearer {$accessToken}",
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ];

            // Prepare data for API - match sample format exactly
            $propertyData = [
                'propertyTitle' => $request->propertyTitle,
                'propertyDescription' => $request->propertyDescription ?? '',
                'propertyType' => $request->propertyType, // Required - text value (apartment, house, etc.)
                'price' => (int)($request->price ?? 0), // Sample shows numeric, not string
                'bed' => (int)($request->bed ?? 0),
                'bath' => (int)($request->bath ?? 0),  
                'toilet' => (int)($request->toilet ?? 0),
                'address' => $request->address ?? '',
                'city' => $request->city ?? '',
                'state' => $request->state, // Required - text value
                'country' => $request->country, // Required - text value
                'poster' => $request->landlordID, // Required field (max 20 chars)
                'property_owner' => $request->landlordID, // Optional database field
                'rentalCondition' => $request->rentalCondition ?? 'standard', // Required - cannot be null
                'serviceCharge' => (int)($request->serviceCharge ?? 0),
                'securityDeposit' => (int)($request->securityDeposit ?? 0),
                'securityDepositTerm' => '1', // Required - string representation of integer
                'available_date' => $request->available_date ?? null,
                'furnishing' => 'unfurnished', // Default value
                'featured_property' => false,
                'paymentPlan' => $request->paymentPlan ?? 'flexible',
            ];
            
            // Handle status mapping
            if (!empty($request->status)) {
                $statusMap = [
                    'yes' => 'available',
                    'no' => 'inactive'
                ];
                $propertyData['status'] = $statusMap[$request->status] ?? 'available';
            } else {
                $propertyData['status'] = 'available'; // Default status
            }
            
            // Handle furnishing mapping  
            if (!empty($request->furnishing)) {
                $furnishingMap = [
                    '1' => 'furnished',
                    '0' => 'unfurnished'
                ];
                $propertyData['furnishing'] = $furnishingMap[$request->furnishing] ?? $request->furnishing;
            }

            // Remove null values
            $propertyData = array_filter($propertyData, function($value) {
                return $value !== null;
            });

            $apiUrl = "http://api2.smallsmall.com/api/properties";
            Log::info("Property Store - Making POST request to: {$apiUrl}");
            Log::info("Property Store - Data: " . json_encode($propertyData));
            
            $response = Http::timeout(30)->withHeaders($headers)->post($apiUrl, $propertyData);

            Log::info('Property Store API Response Status: ' . $response->status());
            Log::info('Property Store API Response Body: ' . $response->body());
            
            // Log detailed request information for debugging
            Log::info('Property Store - Full Request Headers: ' . json_encode($headers));
            Log::info('Property Store - Request URL: ' . $apiUrl);
            Log::info('Property Store - Request Method: POST');
            Log::info('Property Store - Complete Payload: ' . json_encode($propertyData, JSON_PRETTY_PRINT));

            if ($response->successful()) {
                $responseData = $response->json();
                Log::info("Property Store - Success: New property created");
                
                // Check if the API response indicates actual success
                if (isset($responseData['success']) && $responseData['success'] === false) {
                    $message = $responseData['message'] ?? 'Creation failed despite 200 status';
                    Log::warning("Property Store - API returned success=false: {$message}");
                    return redirect()->route('properties.add')->with('error', $message);
                }
                
                // Get the new property ID from response
                $newPropertyId = $responseData['data']['id'] ?? $responseData['id'] ?? null;
                
                if ($newPropertyId) {
                    return redirect()->route('property.show', $newPropertyId)->with('success', 'Property created successfully!');
                } else {
                    return redirect()->route('properties')->with('success', 'Property created successfully!');
                }
            } elseif ($response->status() === 401) {
                Log::warning('Property Store - Unauthorized (401)');
                return redirect()->route('login')->with('error', 'Session expired. Please login again.');
            } else {
                Log::error("Property Store - API Error: Status {$response->status()} - {$response->body()}");
                $errorData = $response->json();
                
                // Handle validation errors specifically
                if ($response->status() === 422 && isset($errorData['errors'])) {
                    $validationErrors = [];
                    foreach ($errorData['errors'] as $field => $messages) {
                        $validationErrors[] = $field . ': ' . implode(', ', $messages);
                    }
                    $errorMessage = 'Validation failed: ' . implode('; ', $validationErrors);
                    
                    // Log detailed validation error information
                    Log::error("Property Store - Validation Errors: " . json_encode($errorData['errors'], JSON_PRETTY_PRINT));
                    Log::error("Property Store - Failed Fields: " . implode(', ', array_keys($errorData['errors'])));
                    
                } elseif ($response->status() === 500 && isset($errorData['error'])) {
                    // Handle database/server errors - show the actual database error
                    $dbError = $errorData['error'];
                    if (strpos($dbError, 'SQLSTATE') !== false) {
                        // Extract the meaningful part of the SQL error
                        if (preg_match('/General error: \d+ (.+?) \(Connection/', $dbError, $matches)) {
                            $errorMessage = 'Database error: ' . $matches[1];
                        } else {
                            $errorMessage = 'Database error: ' . $dbError;
                        }
                    } else {
                        $errorMessage = 'Server error: ' . $dbError;
                    }
                    Log::error("Property Store - Server Error Details: " . $errorData['error']);
                    
                } else {
                    $errorMessage = $errorData['message'] ?? 'Failed to create property. Status: ' . $response->status();
                    if (isset($errorData['error'])) {
                        $errorMessage .= ' Error: ' . $errorData['error'];
                    }
                    Log::error("Property Store - General Error: " . json_encode($errorData));
                }
                
                return redirect()->route('properties.add')->with('error', $errorMessage);
            }
        } catch (\Exception $e) {
            Log::error('Property Store Exception: ' . $e->getMessage(), [
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_data' => $request->all()
            ]);
            
            return redirect()->route('properties.add')->with('error', 'System error: ' . $e->getMessage());
        }
    }
}