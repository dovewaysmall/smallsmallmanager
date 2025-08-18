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
}