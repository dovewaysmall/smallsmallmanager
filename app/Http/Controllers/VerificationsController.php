<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Helpers\RoleHelper;

class VerificationsController extends Controller
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
        return view('verifications', compact('canDelete'));
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

            $response = Http::timeout(30)->withHeaders($headers)->get("http://api2.smallsmall.com/api/verifications/{$id}");

            if ($response->successful()) {
                $apiData = $response->json();
                Log::info('Verification API Response: ' . json_encode($apiData));
                
                // Pass the complete API response to the view
                return view('verification-detail', ['verification' => $apiData, 'id' => $id]);
            } elseif ($response->status() === 401) {
                return redirect()->route('login')->with('error', 'Session expired. Please login again.');
            } else {
                return view('verification-detail', ['verification' => null, 'id' => $id, 'error' => 'Failed to load verification data.']);
            }
        } catch (\Exception $e) {
            Log::error('Verification Detail API Error: ' . $e->getMessage());
            return view('verification-detail', ['verification' => null, 'id' => $id, 'error' => 'An error occurred while loading verification data.']);
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

            // First, get the current verification data to obtain required fields
            $currentResponse = Http::timeout(30)->withHeaders($headers)->get("http://api2.smallsmall.com/api/verifications/{$id}");
            
            if (!$currentResponse->successful()) {
                Log::error('Failed to fetch current verification data for update');
                return redirect()->route('verification.show', $id)->with('error', 'Failed to fetch current verification data.');
            }
            
            $currentData = $currentResponse->json();
            $verificationData = $currentData['data'] ?? $currentData;
            
            // Log the current verification status to understand what values the API uses
            $currentVerificationStatus = $verificationData['Verified'] ?? $verificationData['verified'] ?? $verificationData['status'] ?? 'unknown';
            Log::info("Current verification status from API: '{$currentVerificationStatus}'");
            
            // Get submitted status and ensure lowercase for API
            $submittedStatus = $request->verification_status ?? 'received';
            $apiStatus = strtolower($submittedStatus); // Convert to lowercase for API
            
            Log::info("Form submitted status: '{$submittedStatus}' -> Sending to API: '{$apiStatus}'");
            
            // Prepare data for API update - userID must exist in user_tbl.userID
            $updateData = [
                'userID' => $verificationData['user_id'] ?? $verificationData['userID'] ?? '',
                'verified' => $apiStatus
            ];
            
            Log::info("Verification status update - UserID: {$updateData['userID']}, Verified: {$updateData['verified']}");
            Log::info('Verification Update Request Data: ' . json_encode($updateData));
            Log::info('Request Headers: ' . json_encode($headers));
            Log::info('API Endpoint: http://api2.smallsmall.com/api/verifications/update-status');
            
            // Use the correct endpoint for updating verification status
            $response = Http::timeout(30)->withHeaders($headers)->post("http://api2.smallsmall.com/api/verifications/update-status", $updateData);

            Log::info('Verification Update Response Status: ' . $response->status());
            Log::info('Verification Update Response Headers: ' . json_encode($response->headers()));
            Log::info('Verification Update Response Body: ' . $response->body());
            
            // Log more details for 500 errors
            if ($response->status() === 500) {
                Log::error('API returned 500 Internal Server Error');
                Log::error('Full response details: Status=' . $response->status() . ', Body=' . $response->body());
                Log::error('Sent data was: ' . json_encode($updateData));
            }

            if ($response->successful()) {
                $responseData = $response->json();
                $rowsAffected = $responseData['rows_affected'] ?? 'unknown';
                
                if ($rowsAffected > 0) {
                    Log::info("Verification update successful - {$rowsAffected} rows affected");
                    return redirect()->route('verification.show', $id)->with('success', 'Verification updated successfully.');
                } else {
                    Log::info('Verification update completed but no rows affected');
                    return redirect()->route('verification.show', $id)->with('info', 'Update completed successfully.');
                }
            } elseif ($response->status() === 401) {
                return redirect()->route('login')->with('error', 'Session expired. Please login again.');
            } elseif ($response->status() === 422) {
                // Handle validation errors
                $responseData = $response->json();
                $errors = $responseData['errors'] ?? [];
                $errorMessages = [];
                
                foreach ($errors as $field => $messages) {
                    $errorMessages[] = $field . ': ' . implode(', ', $messages);
                }
                
                $errorMessage = 'Validation error: ' . implode(' | ', $errorMessages);
                Log::error('Verification Update Validation Error: ' . $errorMessage);
                return redirect()->route('verification.show', $id)->with('error', $errorMessage);
            } else {
                Log::error('Verification Update API Error - Status: ' . $response->status() . ' - Body: ' . $response->body());
                return redirect()->route('verification.show', $id)->with('error', 'Failed to update verification. Status: ' . $response->status() . '. Please check the logs for details.');
            }
        } catch (\Exception $e) {
            Log::error('Verification Update API Error: ' . $e->getMessage());
            return redirect()->route('verification.show', $id)->with('error', 'An error occurred while updating verification data.');
        }
    }

    public function loadVerifications(Request $request)
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

            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/verifications');

            if ($response->successful()) {
                $apiData = $response->json();
                $verifications = $apiData['data'] ?? $apiData['verifications'] ?? $apiData ?? [];
                
                return response()->json([
                    'success' => true,
                    'verifications' => $verifications
                ]);
            } elseif ($response->status() === 401) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } else {
                return response()->json([
                    'error' => 'Failed to fetch verifications from API.'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Verifications API Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while loading verifications.'
            ], 500);
        }
    }

    public function thisWeek()
    {
        return view('verifications-this-week');
    }

    public function loadVerificationsThisWeek(Request $request)
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

            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/verifications/this-week');

            if ($response->successful()) {
                $apiData = $response->json();
                $verifications = $apiData['data'] ?? $apiData['verifications'] ?? $apiData ?? [];
                
                return response()->json([
                    'success' => true,
                    'verifications' => $verifications
                ]);
            } elseif ($response->status() === 401) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } else {
                return response()->json([
                    'error' => 'Failed to fetch verifications from API.'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Verifications This Week API Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while loading verifications.'
            ], 500);
        }
    }

    public function thisMonth()
    {
        return view('verifications-this-month');
    }

    public function loadVerificationsThisMonth(Request $request)
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

            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/verifications/this-month');

            if ($response->successful()) {
                $apiData = $response->json();
                $verifications = $apiData['data'] ?? $apiData['verifications'] ?? $apiData ?? [];
                
                return response()->json([
                    'success' => true,
                    'verifications' => $verifications
                ]);
            } elseif ($response->status() === 401) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } else {
                return response()->json([
                    'error' => 'Failed to fetch verifications from API.'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Verifications This Month API Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while loading verifications.'
            ], 500);
        }
    }

    public function thisYear()
    {
        return view('verifications-this-year');
    }

    public function loadVerificationsThisYear(Request $request)
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

            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/verifications/this-year');

            if ($response->successful()) {
                $apiData = $response->json();
                $verifications = $apiData['data'] ?? $apiData['verifications'] ?? $apiData ?? [];
                
                return response()->json([
                    'success' => true,
                    'verifications' => $verifications
                ]);
            } elseif ($response->status() === 401) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } else {
                return response()->json([
                    'error' => 'Failed to fetch verifications from API.'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Verifications This Year API Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while loading verifications.'
            ], 500);
        }
    }
}