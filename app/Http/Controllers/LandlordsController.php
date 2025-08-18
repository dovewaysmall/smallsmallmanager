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

    public function add()
    {
        return view('add-landlord');
    }

    public function store(Request $request)
    {
        // KNOWN ISSUE: The API endpoint at http://api2.smallsmall.com/api/landlords
        // has a database schema issue where the 'income' field is required but the API
        // does not process any income fields we send (income, gross_annual_income, 
        // annual_income, grossAnnualIncome). The API needs to be updated to handle 
        // income fields properly or the database schema needs a default value.
        //
        // Error: SQLSTATE[HY000]: General error: 1364 Field 'income' doesn't have a default value
        
        try {
            $accessToken = session('access_token');
            
            if (!$accessToken) {
                return response()->json([
                    'success' => false,
                    'message' => 'Session expired. Please login again.'
                ], 401);
            }

            // Validate the request
            $request->validate([
                'firstName' => 'required|string|max:255',
                'lastName' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'income' => 'required|numeric|min:0',
                'password' => 'required|string|min:8|max:255',
            ]);

            $headers = [
                'Authorization' => "Bearer {$accessToken}",
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ];

            $landlordData = [
                'firstName' => $request->firstName,
                'lastName' => $request->lastName,
                'email' => $request->email,
                'phone' => $request->phone,
                'income' => $request->income,
                'gross_annual_income' => $request->income * 12, // Try annual income
                'annual_income' => $request->income * 12, // Alternative naming
                'grossAnnualIncome' => $request->income * 12, // CamelCase variant
                'password' => $request->password
            ];

            Log::info('Sending to API - URL: http://api2.smallsmall.com/api/landlords');
            Log::info('Sending to API - Headers: ' . json_encode($headers));
            Log::info('Sending to API - Data: ' . json_encode($landlordData));
            
            $response = Http::timeout(30)->withHeaders($headers)->post('http://api2.smallsmall.com/api/landlords', $landlordData);

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Landlord added successfully!'
                ]);
            } elseif ($response->status() === 401) {
                return response()->json([
                    'success' => false,
                    'message' => 'Session expired. Please login again.'
                ], 401);
            } else {
                $errorData = $response->json();
                Log::error('API Response Error: ' . $response->body());
                Log::error('Request Data: ' . json_encode($landlordData));
                Log::error('Response Status: ' . $response->status());
                
                // Check for the specific income field database error
                $errorMessage = $errorData['error'] ?? $errorData['response_body']['error'] ?? '';
                $isIncomeError = str_contains($errorMessage, "Field 'income' doesn't have a default value");
                
                $userMessage = $isIncomeError 
                    ? 'Unable to create landlord due to a known API issue with income fields. Please contact the development team to fix the API endpoint.'
                    : ($errorData['message'] ?? 'Failed to add landlord. Please check your input and try again.');
                
                return response()->json([
                    'success' => false,
                    'message' => $userMessage,
                    'api_errors' => $errorData['errors'] ?? null,
                    'known_issue' => $isIncomeError,
                    'debug' => [
                        'status_code' => $response->status(),
                        'response_body' => $errorData,
                        'sent_data' => $landlordData,
                        'api_url' => 'http://api2.smallsmall.com/api/landlords'
                    ]
                ], 400);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Add Landlord API Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding the landlord.',
                'debug' => [
                    'error' => $e->getMessage(),
                    'line' => $e->getLine(),
                    'file' => $e->getFile()
                ]
            ], 500);
        }
    }

    public function show($userID)
    {
        Log::info("Landlord detail page accessed for userID: {$userID}");
        return view('landlord-detail', compact('userID'));
    }

    public function getLandlordDetails($userID)
    {
        try {
            Log::info('Getting landlord details', [
                'userID' => $userID,
                'userID_type' => gettype($userID),
                'userID_length' => strlen($userID)
            ]);
            
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

            // Try to get specific landlord details from API
            $response = Http::timeout(30)->withHeaders($headers)->get("http://api2.smallsmall.com/api/landlords/{$userID}");

            if ($response->successful()) {
                $apiData = $response->json();
                
                Log::info('API Response received:', $apiData);
                
                // Handle the actual API response structure
                if (isset($apiData['success']) && $apiData['success'] && isset($apiData['data'])) {
                    $landlordInfo = $apiData['data']['landlord_info'] ?? null;
                    $propertiesCount = $apiData['data']['property_count'] ?? 0;
                    $tenantsCount = $apiData['data']['tenant_count'] ?? 0;
                    $properties = $apiData['data']['properties'] ?? [];
                    
                    if ($landlordInfo) {
                        // Add the property and tenant counts to the landlord info
                        $landlordInfo['properties_count'] = $propertiesCount;
                        $landlordInfo['tenants_count'] = $tenantsCount;
                        $landlordInfo['properties'] = $properties;
                        
                        Log::info('Processed landlord data:', [
                            'properties_count' => $propertiesCount,
                            'tenants_count' => $tenantsCount,
                            'api_tenant_count' => $apiData['data']['tenant_count'] ?? 'not provided'
                        ]);
                        
                        return response()->json([
                            'success' => true,
                            'landlord' => $landlordInfo
                        ]);
                    }
                }
                
                return response()->json([
                    'success' => false,
                    'message' => 'Landlord not found or invalid API response structure.'
                ], 404);
            } elseif ($response->status() === 401) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } else {
                // If specific landlord endpoint doesn't exist, try to find in the list
                $listResponse = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/landlords');
                
                if ($listResponse->successful()) {
                    $listData = $listResponse->json();
                    $landlords = $listData['data'] ?? $listData['landlords'] ?? $listData ?? [];
                    
                    // Find the landlord with matching userID
                    $landlord = collect($landlords)->first(function ($landlord) use ($userID) {
                        return $landlord['userID'] === $userID || $landlord['id'] === $userID;
                    });
                    
                    if ($landlord) {
                        // For fallback method, we'll try to get property count manually
                        $propertiesCount = $this->getLandlordPropertiesCount($userID, $headers);
                        $tenantsCount = $this->getLandlordTenantsCount($userID, $headers);
                        
                        $landlord['properties_count'] = $propertiesCount;
                        $landlord['tenants_count'] = $tenantsCount;
                        
                        return response()->json([
                            'success' => true,
                            'landlord' => $landlord
                        ]);
                    } else {
                        return response()->json([
                            'success' => false,
                            'message' => 'Landlord not found.'
                        ], 404);
                    }
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to load landlord details from API.'
                    ], 500);
                }
            }
        } catch (\Exception $e) {
            Log::error('Landlord Details API Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while loading landlord details.'
            ], 500);
        }
    }

    private function getLandlordPropertiesCount($userID, $headers)
    {
        try {
            Log::info("Counting properties for landlord: {$userID}");
            
            // Try to get properties and count those owned by this landlord
            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/properties');
            
            if ($response->successful()) {
                $apiData = $response->json();
                $properties = $apiData['data'] ?? $apiData['properties'] ?? $apiData ?? [];
                
                Log::info('Properties API Response Structure:', [
                    'total_properties' => count($properties),
                    'sample_property' => $properties[0] ?? 'No properties found',
                    'api_data_keys' => array_keys($apiData)
                ]);
                
                // Count properties that belong to this landlord
                $count = 0;
                $matchedProperties = [];
                
                foreach ($properties as $property) {
                    // Log each property's landlord-related fields
                    $landlordId = $property['landlordID'] ?? $property['landlord_id'] ?? $property['owner_id'] ?? $property['ownerID'] ?? null;
                    
                    // Try different comparison methods (string/int conversion)
                    $strictMatch = $landlordId === $userID;
                    $looseMatch = $landlordId == $userID; // Loose comparison
                    $stringMatch = (string)$landlordId === (string)$userID;
                    $intMatch = (int)$landlordId === (int)$userID;
                    
                    Log::info('Property check:', [
                        'property_id' => $property['id'] ?? 'No ID',
                        'landlordID' => $property['landlordID'] ?? 'Not set',
                        'landlord_id' => $property['landlord_id'] ?? 'Not set',
                        'owner_id' => $property['owner_id'] ?? 'Not set',
                        'ownerID' => $property['ownerID'] ?? 'Not set',
                        'landlord_object' => isset($property['landlord']) ? $property['landlord'] : 'Not set',
                        'extracted_landlordId' => $landlordId,
                        'landlordId_type' => gettype($landlordId),
                        'target_userID' => $userID,
                        'target_userID_type' => gettype($userID),
                        'strict_match' => $strictMatch,
                        'loose_match' => $looseMatch,
                        'string_match' => $stringMatch,
                        'int_match' => $intMatch
                    ]);
                    
                    // Use more flexible matching
                    if ($looseMatch || $stringMatch || 
                        (isset($property['landlord']) && 
                         (($property['landlord']['userID'] ?? null) == $userID || 
                          ($property['landlord']['id'] ?? null) == $userID))) {
                        $count++;
                        $matchedProperties[] = $property['id'] ?? 'Unknown ID';
                        Log::info("MATCH FOUND! Property matched for landlord {$userID}");
                    }
                }
                
                Log::info("Properties count result: {$count} properties found for landlord {$userID}", [
                    'matched_properties' => $matchedProperties
                ]);
                
                return $count;
            } else {
                Log::error('Properties API failed:', [
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);
            }
            
            return 0;
        } catch (\Exception $e) {
            Log::error('Error counting landlord properties: ' . $e->getMessage());
            return 0;
        }
    }

    private function getLandlordTenantsCount($userID, $headers)
    {
        try {
            // Try to get tenants and count those associated with this landlord
            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/tenants');
            
            if ($response->successful()) {
                $apiData = $response->json();
                $tenants = $apiData['data'] ?? $apiData['tenants'] ?? $apiData ?? [];
                
                // Count tenants that belong to this landlord
                $count = 0;
                foreach ($tenants as $tenant) {
                    // Check various possible field names for landlord ID
                    $landlordId = $tenant['landlordID'] ?? $tenant['landlord_id'] ?? null;
                    
                    if ($landlordId === $userID || 
                        (isset($tenant['landlord']) && ($tenant['landlord']['userID'] === $userID || $tenant['landlord']['id'] === $userID)) ||
                        (isset($tenant['property']) && isset($tenant['property']['landlord']) && 
                         ($tenant['property']['landlord']['userID'] === $userID || $tenant['property']['landlord']['id'] === $userID))) {
                        $count++;
                    }
                }
                
                return $count;
            }
            
            return 0;
        } catch (\Exception $e) {
            Log::error('Error counting landlord tenants: ' . $e->getMessage());
            return 0;
        }
    }

    public function edit($userID)
    {
        Log::info("Landlord edit page accessed for userID: {$userID}");
        return view('edit-landlord', compact('userID'));
    }

    public function update(Request $request, $userID)
    {
        try {
            Log::info('Updating landlord details', [
                'userID' => $userID,
                'data' => $request->all()
            ]);
            
            $accessToken = session('access_token');
            
            if (!$accessToken) {
                return response()->json([
                    'success' => false,
                    'message' => 'Session expired. Please login again.'
                ], 401);
            }

            // Validate the request based on actual API expectations
            $request->validate([
                'firstName' => 'sometimes|string|max:255',
                'lastName' => 'sometimes|string|max:255', 
                'email' => 'sometimes|email|max:255',
                'phone' => 'sometimes|string|max:20',
                'verified' => 'sometimes|boolean',
            ]);

            $headers = [
                'Authorization' => "Bearer {$accessToken}",
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ];

            // Only send fields that are actually provided and supported by API
            $updateData = [];
            
            if ($request->has('firstName') && $request->firstName !== null) {
                $updateData['firstName'] = $request->firstName;
            }
            
            if ($request->has('lastName') && $request->lastName !== null) {
                $updateData['lastName'] = $request->lastName;
            }
            
            if ($request->has('email') && $request->email !== null) {
                $updateData['email'] = $request->email;
            }
            
            if ($request->has('phone') && $request->phone !== null) {
                $updateData['phone'] = $request->phone;
            }
            
            if ($request->has('verified') && $request->verified !== null) {
                $updateData['verified'] = (bool) $request->verified;
            }

            Log::info('Sending update to API', [
                'url' => "http://api2.smallsmall.com/api/landlords/{$userID}",
                'data' => $updateData
            ]);
            
            $response = Http::timeout(30)->withHeaders($headers)->put("http://api2.smallsmall.com/api/landlords/{$userID}", $updateData);

            if ($response->successful()) {
                Log::info('Landlord updated successfully');
                return response()->json([
                    'success' => true,
                    'message' => 'Landlord updated successfully!'
                ]);
            } elseif ($response->status() === 401) {
                return response()->json([
                    'success' => false,
                    'message' => 'Session expired. Please login again.'
                ], 401);
            } else {
                $errorData = $response->json();
                Log::error('API Update Error: ' . $response->body());
                
                return response()->json([
                    'success' => false,
                    'message' => $errorData['message'] ?? 'Failed to update landlord. Please check your input and try again.',
                    'api_errors' => $errorData['errors'] ?? null,
                    'debug' => [
                        'status_code' => $response->status(),
                        'response_body' => $errorData,
                        'sent_data' => $updateData,
                        'api_url' => "http://api2.smallsmall.com/api/landlords/{$userID}"
                    ]
                ], 400);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Update Landlord API Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the landlord.',
                'debug' => [
                    'error' => $e->getMessage(),
                    'line' => $e->getLine(),
                    'file' => $e->getFile()
                ]
            ], 500);
        }
    }
}