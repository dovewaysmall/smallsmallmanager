<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RepairsController extends Controller
{
    public function index()
    {
        return view('repairs');
    }

    public function loadRepairs(Request $request)
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

            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/repairs');

            if ($response->successful()) {
                $apiData = $response->json();
                $repairs = $apiData['data'] ?? $apiData['repairs'] ?? $apiData ?? [];
                
                return response()->json([
                    'success' => true,
                    'repairs' => $repairs
                ]);
            } elseif ($response->status() === 401) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } else {
                return response()->json([
                    'error' => 'Failed to fetch repairs from API.'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Repairs API Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while loading repairs.'
            ], 500);
        }
    }

    public function thisWeek()
    {
        return view('repairs-this-week');
    }

    public function loadRepairsThisWeek(Request $request)
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

            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/repairs/this-week');

            if ($response->successful()) {
                $apiData = $response->json();
                $repairs = $apiData['data'] ?? $apiData['repairs'] ?? $apiData ?? [];
                
                return response()->json([
                    'success' => true,
                    'repairs' => $repairs
                ]);
            } elseif ($response->status() === 401) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } else {
                return response()->json([
                    'error' => 'Failed to fetch repairs from API.'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Repairs This Week API Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while loading repairs.'
            ], 500);
        }
    }

    public function thisMonth()
    {
        return view('repairs-this-month');
    }

    public function loadRepairsThisMonth(Request $request)
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

            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/repairs/this-month');

            if ($response->successful()) {
                $apiData = $response->json();
                $repairs = $apiData['data'] ?? $apiData['repairs'] ?? $apiData ?? [];
                
                return response()->json([
                    'success' => true,
                    'repairs' => $repairs
                ]);
            } elseif ($response->status() === 401) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } else {
                return response()->json([
                    'error' => 'Failed to fetch repairs from API.'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Repairs This Month API Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while loading repairs.'
            ], 500);
        }
    }

    public function thisYear()
    {
        return view('repairs-this-year');
    }

    public function loadRepairsThisYear(Request $request)
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

            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/repairs/this-year');

            if ($response->successful()) {
                $apiData = $response->json();
                $repairs = $apiData['data'] ?? $apiData['repairs'] ?? $apiData ?? [];
                
                return response()->json([
                    'success' => true,
                    'repairs' => $repairs
                ]);
            } elseif ($response->status() === 401) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } else {
                return response()->json([
                    'error' => 'Failed to fetch repairs from API.'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Repairs This Year API Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while loading repairs.'
            ], 500);
        }
    }

    public function add()
    {
        return view('add-repair');
    }

    public function store(Request $request)
    {
        try {
            Log::info('=== REPAIR STORE REQUEST STARTED ===');
            Log::info('Request data received:', $request->all());
            Log::info('Request method: ' . $request->method());
            Log::info('Request headers:', $request->headers->all());
            
            $accessToken = session('access_token');
            Log::info('Access token status:', ['has_token' => !!$accessToken, 'token_length' => $accessToken ? strlen($accessToken) : 0]);
            
            if (!$accessToken) {
                Log::warning('No access token found in session');
                return response()->json([
                    'success' => false,
                    'message' => 'Session expired. Please login again.'
                ], 401);
            }

            // Validate the request
            Log::info('Starting validation...');
            $request->validate([
                'property_id' => 'required|string',
                'description' => 'required|string|max:1000',
                'priority' => 'required|in:low,medium,high,urgent',
                'category' => 'sometimes|string|max:255',
                'tenant_id' => 'sometimes|string',
                'assignee' => 'sometimes|string|max:255',
            ]);
            Log::info('Validation passed');

            $headers = [
                'Authorization' => "Bearer {$accessToken}",
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ];

            // Get the landlord/owner ID from the property
            $apartmentOwnerId = $this->getPropertyOwnerId($request->property_id, $headers);
            
            // Build the repair description with property info since we can't store property_id separately
            $description = $request->description;
            if ($request->filled('property_id')) {
                $description = "[Property ID: {$request->property_id}] " . $description;
            }
            
            // Include all potentially required fields based on common repair database schemas
            $repairData = [
                'items_repaired' => $description, // Required: repair description with property info
                'apartment_owner_id' => $apartmentOwnerId, // Required: landlord/owner ID
                'repair_amount' => 0, // Required: default to 0 since amount isn't known at creation
                'repair_status' => 'pending', // Common field: status of repair
                'repair_done_by' => $request->assignee ?? '', // Optional: who will do the repair
                'property_id' => $request->property_id, // Property ID (if API accepts it)
            ];

            // Build the full description with all our metadata since we can only use these fields
            $fullDescription = $description;
            
            // Add priority to description
            if ($request->filled('priority')) {
                $priorityText = match($request->priority) {
                    'urgent' => '[URGENT] ',
                    'high' => '[HIGH PRIORITY] ',
                    'medium' => '[MEDIUM PRIORITY] ',
                    'low' => '[LOW PRIORITY] ',
                    default => ''
                };
                $fullDescription = $priorityText . $fullDescription;
            }

            // Add category to description if provided
            if ($request->filled('category')) {
                $fullDescription = '[' . strtoupper($request->category) . '] ' . $fullDescription;
            }

            // Add assignee info to description since we can't use repair_done_by
            if ($request->filled('assignee')) {
                $fullDescription = $fullDescription . ' [Assigned to: ' . $request->assignee . ']';
            }

            // Update the description with all metadata
            $repairData['items_repaired'] = $fullDescription;
            
            // Don't include any other fields that might cause database errors
            
            Log::info('Sending repair data to API:', $repairData);
            Log::info('API URL: http://api2.smallsmall.com/api/repairs');
            Log::info('API Headers:', $headers);

            $response = Http::timeout(30)->withHeaders($headers)->post('http://api2.smallsmall.com/api/repairs', $repairData);

            Log::info('API Response Status: ' . $response->status());
            Log::info('API Response Body: ' . $response->body());

            if ($response->successful()) {
                $apiData = $response->json();
                Log::info('Repair created successfully:', $apiData);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Repair request has been created successfully!',
                    'data' => $apiData
                ], 201);
            } elseif ($response->status() === 401) {
                Log::warning('Unauthorized response from repairs API');
                return response()->json([
                    'success' => false,
                    'message' => 'Session expired. Please login again.'
                ], 401);
            } elseif ($response->status() === 422) {
                // Validation errors from API
                $apiErrors = $response->json();
                Log::warning('Validation errors from repairs API:', $apiErrors);
                
                return response()->json([
                    'success' => false,
                    'message' => 'API validation failed.',
                    'api_errors' => $apiErrors['errors'] ?? $apiErrors,
                    'debug' => [
                        'status_code' => $response->status(),
                        'response_body' => $apiErrors,
                        'sent_data' => $repairData,
                        'api_url' => 'http://api2.smallsmall.com/api/repairs'
                    ]
                ], 422);
            } else {
                Log::error('Repairs API error - Status: ' . $response->status() . ', Body: ' . $response->body());
                
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create repair request. API returned an error.',
                    'debug' => [
                        'status_code' => $response->status(),
                        'response_body' => $response->json(),
                        'sent_data' => $repairData,
                        'api_url' => 'http://api2.smallsmall.com/api/repairs'
                    ]
                ], 500);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Add Repair API Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the repair request.',
                'debug' => [
                    'error' => $e->getMessage(),
                    'line' => $e->getLine(),
                    'file' => $e->getFile()
                ]
            ], 500);
        }
    }

    private function getPropertyOwnerId($propertyId, $headers)
    {
        try {
            Log::info("Getting property owner ID for property: {$propertyId}");
            
            // Try to get property details from API
            $response = Http::timeout(30)->withHeaders($headers)->get("http://api2.smallsmall.com/api/properties/{$propertyId}");
            
            if ($response->successful()) {
                $propertyData = $response->json();
                Log::info('Property data received:', $propertyData);
                
                // Try different possible field names for owner ID
                $ownerId = $propertyData['data']['landlordID'] ?? 
                          $propertyData['data']['landlord_id'] ?? 
                          $propertyData['data']['owner_id'] ?? 
                          $propertyData['data']['ownerID'] ?? 
                          $propertyData['landlordID'] ?? 
                          $propertyData['landlord_id'] ?? 
                          $propertyData['owner_id'] ?? 
                          $propertyData['ownerID'] ?? 
                          null;
                
                Log::info("Extracted owner ID: {$ownerId}");
                
                if ($ownerId) {
                    return $ownerId;
                }
            } else {
                Log::warning("Failed to get property details: " . $response->status());
                Log::warning("Response: " . $response->body());
            }
            
            // Fallback: use the property ID itself (might work in some cases)
            Log::warning("Using property ID as owner ID fallback");
            return $propertyId;
            
        } catch (\Exception $e) {
            Log::error('Error getting property owner ID: ' . $e->getMessage());
            return $propertyId; // Fallback
        }
    }
}