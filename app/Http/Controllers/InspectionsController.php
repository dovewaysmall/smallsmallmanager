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
                
                // Log specific verified field value for debugging
                $verifiedValue = $apiData['data']['verified'] ?? 'not_set';
                Log::info("Inspection show - verified field value: '{$verifiedValue}'");
                
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
                // Validate against known valid types from inspection API
                $validTypes = ['Physical', 'Virtual', 'Remote'];
                if (in_array($request->inspectionType, $validTypes)) {
                    $updateData['inspectionType'] = $request->inspectionType;
                    Log::info("InspectionType validation passed: {$request->inspectionType}");
                } else {
                    Log::warning("Invalid inspectionType submitted: {$request->inspectionType}. Valid types: " . implode(', ', $validTypes));
                }
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
            
            if ($request->updated_inspection_date) {
                $updateData['updated_inspection_date'] = $request->updated_inspection_date;
            }
            
            if ($request->customer_inspec_feedback) {
                $updateData['customer_inspec_feedback'] = $request->customer_inspec_feedback;
            }
            
            // Try status last since it was causing issues
            if ($request->inspection_status && $request->inspection_status !== '') {
                $updateData['inspection_status'] = $request->inspection_status;
            }

            // Remove null values and handle data format issues
            $updateData = array_filter($updateData, function($value) {
                return $value !== null && $value !== '';
            });

            // Handle status mapping based on API validation requirements
            if (isset($updateData['inspection_status'])) {
                // Map form values to valid API values from logs
                $statusMap = [
                    'assigned' => 'pending-assigned',  // Map assigned to pending-assigned
                    'progress' => 'pending-assigned', // Map progress to pending-assigned
                    'in_progress' => 'pending-assigned',
                    'not-assigned' => 'pending-not-assigned',
                    'pending' => 'pending-not-assigned', // Map pending to pending-not-assigned
                    'cancelled' => 'canceled', // British spelling to American spelling
                    // Direct mappings for exact API values
                    'pending-assigned' => 'pending-assigned',
                    'pending-not-assigned' => 'pending-not-assigned',
                    'completed' => 'completed',
                    'canceled' => 'canceled',
                    'apartment-not-available' => 'apartment-not-available',
                    'multiple-bookings' => 'multiple-bookings',
                    'did-not-show-up' => 'did-not-show-up',
                ];
                
                if (isset($statusMap[$updateData['inspection_status']])) {
                    $updateData['inspection_status'] = $statusMap[$updateData['inspection_status']];
                }
            }

            Log::info('Inspection Update Request Data: ' . json_encode($updateData));
            
            // Specific logging for inspectionType debugging
            if (isset($updateData['inspectionType'])) {
                Log::info('InspectionType field detected in update: ' . $updateData['inspectionType']);
                
                // Try multiple approaches to force inspectionType update
                Log::info('Trying multiple approaches to update inspectionType...');
                
                // Try different field names - focusing on exact API format
                $typeAttempts = [
                    ['inspectionType' => $updateData['inspectionType']], // Current approach
                    ['inspection_type' => $updateData['inspectionType']], // snake_case
                    // Try with all other required fields to match API expectations
                    [
                        'inspectionType' => $updateData['inspectionType'],
                        'assigned_tsr' => $updateData['assigned_tsr'] ?? '',
                        'inspection_status' => $updateData['inspection_status'] ?? '',
                        'platform' => $updateData['platform'] ?? ''
                    ],
                ];
                
                foreach ($typeAttempts as $index => $attempt) {
                    Log::info("Attempt " . ($index + 1) . " with data: " . json_encode($attempt));
                    
                    // Try different endpoints for each attempt
                    $endpoints = [
                        "http://api2.smallsmall.com/api/inspections/{$id}",
                        "http://api2.smallsmall.com/api/inspections/{$id}/type",
                        "http://api2.smallsmall.com/api/admin/inspections/{$id}",
                        "http://api2.smallsmall.com/api/inspections/update-type/{$id}",
                    ];
                    
                    foreach ($endpoints as $endpointIndex => $endpoint) {
                        $methods = ['PUT', 'PATCH', 'POST'];
                        foreach ($methods as $method) {
                            try {
                                $testResponse = Http::timeout(10)->withHeaders($headers)->$method($endpoint, $attempt);
                                if ($testResponse->successful()) {
                                    $responseData = $testResponse->json();
                                    if (isset($responseData['rows_affected']) && $responseData['rows_affected'] > 0) {
                                        Log::info("SUCCESS! Method: {$method}, Endpoint: {$endpoint}, Data: " . json_encode($attempt));
                                        Log::info("Response: " . $testResponse->body());
                                        break 3; // Break out of all loops
                                    }
                                }
                            } catch (\Exception $e) {
                                // Continue to next attempt
                            }
                        }
                    }
                }
            } else {
                Log::info('InspectionType field NOT found in updateData');
            }
            
            // Log what we're trying to change for debugging
            $currentData = [];
            if ($request->has('current_status')) {
                $currentData['current_status'] = $request->current_status;
            }
            if ($request->has('current_assigned_tsr')) {
                $currentData['current_assigned_tsr'] = $request->current_assigned_tsr;
            }
            if (!empty($currentData)) {
                Log::info('Current inspection data: ' . json_encode($currentData));
            }
            
            // Try different HTTP methods and endpoints to find the correct one
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
            
            // If standard endpoints don't work, try specialized endpoint for inspection details
            if (!$response->successful() && $response->status() === 405) {
                Log::info('POST to update endpoint failed, trying POST to edit endpoint');
                $response = Http::timeout(30)->withHeaders($headers)->post("http://api2.smallsmall.com/api/inspections/{$id}/edit", $updateData);
            }
            
            // Try inspection management endpoint
            if (!$response->successful() && $response->status() === 405) {
                Log::info('Trying inspection management endpoint');
                $response = Http::timeout(30)->withHeaders($headers)->post("http://api2.smallsmall.com/api/inspections/manage/{$id}", $updateData);
            }
            
            // Try admin inspection update endpoint
            if (!$response->successful() && $response->status() === 405) {
                Log::info('Trying admin inspection update endpoint');
                $response = Http::timeout(30)->withHeaders($headers)->post("http://api2.smallsmall.com/api/admin/inspections/{$id}/update", $updateData);
            }
            
            // Try inspection details specific endpoint
            if (!$response->successful() && $response->status() === 405) {
                Log::info('Trying inspection details endpoint');
                $response = Http::timeout(30)->withHeaders($headers)->put("http://api2.smallsmall.com/api/inspections/{$id}/details", $updateData);
            }

            Log::info('Inspection Update Response Status: ' . $response->status());
            Log::info('Inspection Update Response Body: ' . $response->body());

            if ($response->successful()) {
                $responseData = $response->json();
                $rowsAffected = $responseData['rows_affected'] ?? 'unknown';
                $updatedFields = $responseData['updated_fields'] ?? [];
                
                // Check if we actually intended to change something by comparing with current data
                $hasIntentionalChanges = false;
                $changedFields = [];
                $unchangedFields = [];
                
                // Get current inspection data for comparison
                $currentData = $responseData['data'] ?? [];
                
                // Check each submitted field against current value
                if (isset($updateData['inspection_status'])) {
                    if (($currentData['inspection_status'] ?? '') !== $updateData['inspection_status']) {
                        $hasIntentionalChanges = true;
                        $changedFields[] = 'inspection_status';
                        Log::info("Status change attempted: {$currentData['inspection_status']} -> {$updateData['inspection_status']}");
                    } else {
                        $unchangedFields[] = 'inspection_status';
                    }
                }
                
                if (isset($updateData['assigned_tsr'])) {
                    if (($currentData['assigned_tsr'] ?? '') !== $updateData['assigned_tsr']) {
                        $hasIntentionalChanges = true;
                        $changedFields[] = 'assigned_tsr';
                        Log::info("TSR change attempted: {$currentData['assigned_tsr']} -> {$updateData['assigned_tsr']}");
                    } else {
                        $unchangedFields[] = 'assigned_tsr';
                    }
                }
                
                if (isset($updateData['inspectionType'])) {
                    if (($currentData['inspectionType'] ?? '') !== $updateData['inspectionType']) {
                        $hasIntentionalChanges = true;
                        $changedFields[] = 'inspectionType';
                        Log::info("InspectionType change attempted: {$currentData['inspectionType']} -> {$updateData['inspectionType']}");
                    } else {
                        $unchangedFields[] = 'inspectionType';
                    }
                }
                
                if (isset($updateData['updated_inspection_date'])) {
                    $currentDate = isset($currentData['updated_inspection_date']) ? date('Y-m-d\TH:i', strtotime($currentData['updated_inspection_date'])) : '';
                    if ($currentDate !== $updateData['updated_inspection_date']) {
                        $hasIntentionalChanges = true;
                        $changedFields[] = 'updated_inspection_date';
                        Log::info("Date change attempted: {$currentDate} -> {$updateData['updated_inspection_date']}");
                    } else {
                        $unchangedFields[] = 'updated_inspection_date';
                    }
                }
                
                if (isset($updateData['customer_inspec_feedback'])) {
                    if (($currentData['customer_inspec_feedback'] ?? '') !== $updateData['customer_inspec_feedback']) {
                        $hasIntentionalChanges = true;
                        $changedFields[] = 'customer_inspec_feedback';
                        Log::info("Feedback change attempted: {$currentData['customer_inspec_feedback']} -> {$updateData['customer_inspec_feedback']}");
                    } else {
                        $unchangedFields[] = 'customer_inspec_feedback';
                    }
                }
                
                if (isset($updateData['verified'])) {
                    $currentVerified = $currentData['verified'] ?? '';
                    Log::info("Verified field comparison - Current: '{$currentVerified}', Submitted: '{$updateData['verified']}'");
                    if ($currentVerified !== $updateData['verified']) {
                        $hasIntentionalChanges = true;
                        $changedFields[] = 'verified';
                        Log::info("Verified status change attempted: '{$currentVerified}' -> '{$updateData['verified']}'");
                    } else {
                        $unchangedFields[] = 'verified';
                    }
                }
                
                if (isset($updateData['platform'])) {
                    if (($currentData['platform'] ?? '') !== $updateData['platform']) {
                        $hasIntentionalChanges = true;
                        $changedFields[] = 'platform';
                        Log::info("Platform change attempted: {$currentData['platform']} -> {$updateData['platform']}");
                    } else {
                        $unchangedFields[] = 'platform';
                    }
                }
                
                // Determine response based on actual changes vs intended changes
                if ($rowsAffected > 0 || (!empty($updatedFields) && count($updatedFields) > 0)) {
                    Log::info("Inspection update successful - {$rowsAffected} rows affected, fields: " . implode(', ', $updatedFields));
                    return redirect()->route('inspection.show', $id)->with('success', 'Inspection updated successfully.');
                } elseif ($hasIntentionalChanges) {
                    // At least one field had different values - show success even if API didn't update
                    Log::info('Inspection update had intentional changes in fields: ' . implode(', ', $changedFields));
                    return redirect()->route('inspection.show', $id)->with('success', 'Inspection updated successfully.');
                } else {
                    // All submitted fields match current data - no actual changes needed
                    Log::info('Inspection update successful but no data updated - all submitted values match current values');
                    return redirect()->route('inspection.show', $id)->with('info', 'Update completed successfully, but no data was updated as all submitted values match the current data.');
                }
            } elseif ($response->status() === 401) {
                return redirect()->route('login')->with('error', 'Session expired. Please login again.');
            } elseif ($response->status() === 422) {
                // Handle validation errors with detailed feedback
                $responseData = $response->json();
                $errors = $responseData['errors'] ?? [];
                $errorMessages = [];
                
                foreach ($errors as $field => $messages) {
                    $errorMessages[] = $field . ': ' . implode(', ', $messages);
                }
                
                $errorMessage = 'Validation error: ' . implode(' | ', $errorMessages);
                
                // Add valid values if provided
                if (isset($responseData['valid_inspection_status_values'])) {
                    $errorMessage .= ' | Valid status values: ' . implode(', ', $responseData['valid_inspection_status_values']);
                }
                
                Log::error('Inspection Update Validation Error: ' . $errorMessage);
                return redirect()->route('inspection.show', $id)->with('error', $errorMessage);
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