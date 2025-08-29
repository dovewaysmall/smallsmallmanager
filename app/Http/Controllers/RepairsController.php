<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Helpers\RoleHelper;

class RepairsController extends Controller
{
    public function index()
    {
        $canDelete = RoleHelper::canDelete();
        return view('repairs', compact('canDelete'));
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

    public function show($id)
    {
        return view('repair-detail', ['repairId' => $id]);
    }

    public function edit($id)
    {
        return view('repair-edit', ['repairId' => $id]);
    }

    public function update(Request $request, $id)
    {
        try {
            Log::info('=== REPAIR UPDATE REQUEST STARTED ===');
            Log::info('Repair ID: ' . $id);
            Log::info('Request data received:', $request->all());
            
            $accessToken = session('access_token');
            
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
                'property_id' => 'required|string|max:50',
                'title_of_repair' => 'required|string|max:100',
                'type_of_repair' => 'required|string|max:100',
                'cost_of_repair' => 'required|numeric|min:0',
                'repair_status' => 'required|in:pending,on going,completed',
                'description_of_the_repair' => 'nullable|string|max:1000',
                'feedback' => 'nullable|string|max:1000',
                'items_repaired' => 'required|string|max:1000',
                'who_is_handling_repair' => 'nullable|string|max:100',
            ]);
            Log::info('Validation passed');

            $headers = [
                'Authorization' => "Bearer {$accessToken}",
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ];

            // Prepare repair data matching the API schema
            $repairData = [
                'title_of_repair' => $request->title_of_repair,
                'property_id' => $request->property_id,
                'type_of_repair' => $request->type_of_repair,
                'items_repaired' => $request->items_repaired ?? '',
                'who_is_handling_repair' => $request->who_is_handling_repair ?: '',
                'description_of_the_repair' => $request->input('description_of_the_repair') ?: 'No additional description provided',
                'cost_of_repair' => (float) $request->cost_of_repair,
                'repair_status' => $request->repair_status,
                'feedback' => $request->feedback ?: '',
            ];
            
            Log::info('Sending repair update data to API:', $repairData);
            Log::info('API URL: http://api2.smallsmall.com/api/repairs/' . $id);

            // First, try to check if the API supports repair updates by testing the endpoint
            $testResponse = Http::timeout(10)->withHeaders($headers)->get('http://api2.smallsmall.com/api/repairs/' . $id);
            
            if (!$testResponse->successful()) {
                Log::warning('Cannot access repair by ID, repair might not exist: ' . $testResponse->status());
                return response()->json([
                    'success' => false,
                    'message' => 'Repair not found or cannot be accessed.',
                    'debug' => [
                        'test_status' => $testResponse->status(),
                        'repair_id' => $id
                    ]
                ], 404);
            }
            
            // Try PUT first, then fallback to POST if PUT is not supported
            $response = Http::timeout(30)->withHeaders($headers)->put('http://api2.smallsmall.com/api/repairs/' . $id, $repairData);
            
            // If PUT method is not supported (405 error), try with POST
            if ($response->status() === 405) {
                Log::info('PUT method not supported, trying POST to update endpoint');
                $response = Http::timeout(30)->withHeaders($headers)->post('http://api2.smallsmall.com/api/repairs/' . $id . '/update', $repairData);
                
                // If that also fails, try PATCH
                if ($response->status() === 405 || $response->status() === 404) {
                    Log::info('POST update also not supported, trying PATCH');
                    $response = Http::timeout(30)->withHeaders($headers)->patch('http://api2.smallsmall.com/api/repairs/' . $id, $repairData);
                }
            }

            Log::info('API Response Status: ' . $response->status());
            Log::info('API Response Body: ' . $response->body());

            if ($response->successful()) {
                $apiData = $response->json();
                Log::info('Repair updated successfully:', $apiData);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Repair updated successfully!',
                    'data' => $apiData
                ], 200);
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
                        'api_url' => 'http://api2.smallsmall.com/api/repairs/' . $id
                    ]
                ], 422);
            } else {
                $responseBody = $response->json();
                $statusCode = $response->status();
                
                Log::error('Repairs Update API error - Status: ' . $statusCode . ', Body: ' . $response->body());
                
                // Extract meaningful error message from API response
                $errorMessage = 'Failed to update repair. API returned an error.';
                if ($responseBody) {
                    if (isset($responseBody['message'])) {
                        $errorMessage = $responseBody['message'];
                    } elseif (isset($responseBody['error'])) {
                        $errorMessage = $responseBody['error'];
                    }
                }
                
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage,
                    'debug' => [
                        'status_code' => $statusCode,
                        'response_body' => $responseBody,
                        'sent_data' => $repairData,
                        'api_url' => 'http://api2.smallsmall.com/api/repairs/' . $id,
                        'headers_sent' => $headers
                    ]
                ], $statusCode >= 400 && $statusCode < 500 ? $statusCode : 500);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Update Repair API Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the repair.',
                'debug' => [
                    'error' => $e->getMessage(),
                    'line' => $e->getLine(),
                    'file' => $e->getFile()
                ]
            ], 500);
        }
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
                'property_id' => 'required|string|max:50',
                'title_of_repair' => 'required|string|max:100',
                'type_of_repair' => 'required|string|max:100',
                'cost_of_repair' => 'required|numeric|min:0',
                'repair_status' => 'required|in:pending,on going,completed',
                'description_of_the_repair' => 'sometimes|string|max:1000',
                'feedback' => 'sometimes|string|max:1000',
                'items_repaired' => 'required|string|max:1000',
                'who_is_handling_repair' => 'sometimes|string|max:100',
            ]);
            Log::info('Validation passed');

            $headers = [
                'Authorization' => "Bearer {$accessToken}",
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ];

            // Prepare repair data matching the updated API schema
            $repairData = [
                'title_of_repair' => $request->title_of_repair,
                'property_id' => $request->property_id,
                'type_of_repair' => $request->type_of_repair,
                'items_repaired' => $request->items_repaired ?? '',
                'who_is_handling_repair' => $request->who_is_handling_repair ?? null,
                'description_of_repair' => $request->input('description_of_the_repair', ''),
                'cost_of_repair' => (float) $request->cost_of_repair,
                'repair_status' => $request->repair_status,
                'feedback' => $request->feedback ?? null,
                'images' => []
            ];
            
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
                $responseBody = $response->json();
                $statusCode = $response->status();
                
                Log::error('Repairs API error - Status: ' . $statusCode . ', Body: ' . $response->body());
                
                // Extract meaningful error message from API response
                $errorMessage = 'Failed to create repair request. API returned an error.';
                $detailedErrors = [];
                
                if ($responseBody) {
                    if (isset($responseBody['message'])) {
                        $errorMessage = $responseBody['message'];
                    } elseif (isset($responseBody['error'])) {
                        $errorMessage = $responseBody['error'];
                    }
                    
                    // Extract validation errors if present
                    if (isset($responseBody['errors'])) {
                        $detailedErrors = $responseBody['errors'];
                    } elseif (isset($responseBody['data']['errors'])) {
                        $detailedErrors = $responseBody['data']['errors'];
                    }
                }
                
                // Build user-friendly error message
                $displayMessage = $errorMessage;
                if (!empty($detailedErrors)) {
                    $displayMessage .= "\n\nDetailed errors:";
                    foreach ($detailedErrors as $field => $errors) {
                        $errorList = is_array($errors) ? implode(', ', $errors) : $errors;
                        $displayMessage .= "\n• {$field}: {$errorList}";
                    }
                }
                
                return response()->json([
                    'success' => false,
                    'message' => $displayMessage,
                    'api_errors' => $detailedErrors,
                    'debug' => [
                        'status_code' => $statusCode,
                        'response_body' => $responseBody,
                        'sent_data' => $repairData,
                        'api_url' => 'http://api2.smallsmall.com/api/repairs',
                        'headers_sent' => $headers
                    ]
                ], $statusCode >= 400 && $statusCode < 500 ? $statusCode : 500);
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

    public function destroy($id)
    {
        try {
            Log::info('=== SOFT DELETE REPAIR REQUEST STARTED ===');
            Log::info('Repair ID to delete: ' . $id);
            
            $accessToken = session('access_token');
            
            if (!$accessToken) {
                Log::warning('No access token found in session');
                return response()->json([
                    'success' => false,
                    'error' => 'Session expired. Please login again.'
                ], 401);
            }

            $headers = [
                'Authorization' => "Bearer {$accessToken}",
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ];
            
            Log::info('Sending soft delete request to repairs API');
            Log::info('API URL: http://api2.smallsmall.com/api/repairs/' . $id);

            // Send DELETE request to API for soft delete
            $response = Http::timeout(30)->withHeaders($headers)->delete('http://api2.smallsmall.com/api/repairs/' . $id);

            Log::info('API Response Status: ' . $response->status());
            Log::info('API Response Body: ' . $response->body());

            if ($response->successful()) {
                Log::info('Repair soft deleted successfully');
                return response()->json([
                    'success' => true,
                    'message' => 'Repair deleted successfully!'
                ]);
            } elseif ($response->status() === 401) {
                Log::warning('Unauthorized response from repairs API');
                return response()->json([
                    'success' => false,
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } elseif ($response->status() === 404) {
                Log::warning('Repair not found for deletion');
                return response()->json([
                    'success' => false,
                    'error' => 'Repair not found.'
                ], 404);
            } else {
                $statusCode = $response->status();
                $responseBody = $response->body();
                
                Log::error('Delete Repair API error - Status: ' . $statusCode . ', Body: ' . $responseBody);
                
                return response()->json([
                    'success' => false,
                    'error' => 'Failed to delete repair. API returned status: ' . $statusCode
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Delete Repair API Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'error' => 'An error occurred while deleting the repair'
            ], 500);
        }
    }

}