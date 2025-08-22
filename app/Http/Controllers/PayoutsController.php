<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PayoutsController extends Controller
{
    public function index()
    {
        return view('payouts');
    }

    public function thisWeek()
    {
        return view('payouts-this-week');
    }

    public function thisMonth()
    {
        return view('payouts-this-month');
    }

    public function thisYear()
    {
        return view('payouts-this-year');
    }

    public function loadPayouts(Request $request)
    {
        try {
            Log::info('=== PAYOUTS API REQUEST STARTED ===');
            
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
            
            Log::info('Sending request to payouts API');
            Log::info('API URL: http://api2.smallsmall.com/api/payouts');

            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/payouts');

            Log::info('API Response Status: ' . $response->status());
            Log::info('API Response Body: ' . $response->body());

            if ($response->successful()) {
                $data = $response->json();
                Log::info('Payouts data received successfully');
                
                return response()->json([
                    'success' => true,
                    'payouts' => $data['data'] ?? $data['payouts'] ?? $data ?? [],
                    'total' => count($data['data'] ?? $data['payouts'] ?? $data ?? [])
                ]);
            } elseif ($response->status() === 401) {
                Log::warning('Unauthorized response from payouts API');
                return response()->json([
                    'success' => false,
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } else {
                $statusCode = $response->status();
                $responseBody = $response->body();
                
                Log::error('Payouts API error - Status: ' . $statusCode . ', Body: ' . $responseBody);
                
                return response()->json([
                    'success' => false,
                    'error' => 'Failed to load payouts data. API returned status: ' . $statusCode
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Payouts API Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'error' => 'An error occurred while loading payouts data'
            ], 500);
        }
    }

    public function loadPayoutsThisWeek(Request $request)
    {
        try {
            Log::info('=== PAYOUTS THIS WEEK API REQUEST STARTED ===');
            
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
            
            // Calculate date range for this week
            $startOfWeek = Carbon::now()->startOfWeek()->format('Y-m-d');
            $endOfWeek = Carbon::now()->endOfWeek()->format('Y-m-d');
            
            Log::info('Sending request to payouts API with date filter');
            Log::info("Date range: {$startOfWeek} to {$endOfWeek}");
            
            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/payouts', [
                'start_date' => $startOfWeek,
                'end_date' => $endOfWeek
            ]);

            Log::info('API Response Status: ' . $response->status());

            if ($response->successful()) {
                $data = $response->json();
                $payouts = $data['data'] ?? $data['payouts'] ?? $data ?? [];
                
                // Filter by date range if API doesn't support date parameters
                $filteredPayouts = collect($payouts)->filter(function ($payout) use ($startOfWeek, $endOfWeek) {
                    $payoutDate = $payout['created_at'] ?? $payout['payout_date'] ?? $payout['date'] ?? null;
                    if (!$payoutDate) return false;
                    
                    try {
                        $date = Carbon::parse($payoutDate)->format('Y-m-d');
                        return $date >= $startOfWeek && $date <= $endOfWeek;
                    } catch (\Exception $e) {
                        return false;
                    }
                })->values()->all();
                
                Log::info('Payouts this week data processed successfully');
                
                return response()->json([
                    'success' => true,
                    'payouts' => $filteredPayouts,
                    'total' => count($filteredPayouts),
                    'period' => 'this-week'
                ]);
            } elseif ($response->status() === 401) {
                Log::warning('Unauthorized response from payouts API');
                return response()->json([
                    'success' => false,
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } else {
                $statusCode = $response->status();
                $responseBody = $response->body();
                
                Log::error('Payouts This Week API error - Status: ' . $statusCode . ', Body: ' . $responseBody);
                
                return response()->json([
                    'success' => false,
                    'error' => 'Failed to load payouts data for this week. API returned status: ' . $statusCode
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Payouts This Week API Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'An error occurred while loading payouts data for this week'
            ], 500);
        }
    }

    public function loadPayoutsThisMonth(Request $request)
    {
        try {
            Log::info('=== PAYOUTS THIS MONTH API REQUEST STARTED ===');
            
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
            
            // Calculate date range for this month
            $startOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
            $endOfMonth = Carbon::now()->endOfMonth()->format('Y-m-d');
            
            Log::info('Sending request to payouts API with date filter');
            Log::info("Date range: {$startOfMonth} to {$endOfMonth}");
            
            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/payouts', [
                'start_date' => $startOfMonth,
                'end_date' => $endOfMonth
            ]);

            Log::info('API Response Status: ' . $response->status());

            if ($response->successful()) {
                $data = $response->json();
                $payouts = $data['data'] ?? $data['payouts'] ?? $data ?? [];
                
                // Filter by date range if API doesn't support date parameters
                $filteredPayouts = collect($payouts)->filter(function ($payout) use ($startOfMonth, $endOfMonth) {
                    $payoutDate = $payout['created_at'] ?? $payout['payout_date'] ?? $payout['date'] ?? null;
                    if (!$payoutDate) return false;
                    
                    try {
                        $date = Carbon::parse($payoutDate)->format('Y-m-d');
                        return $date >= $startOfMonth && $date <= $endOfMonth;
                    } catch (\Exception $e) {
                        return false;
                    }
                })->values()->all();
                
                Log::info('Payouts this month data processed successfully');
                
                return response()->json([
                    'success' => true,
                    'payouts' => $filteredPayouts,
                    'total' => count($filteredPayouts),
                    'period' => 'this-month'
                ]);
            } elseif ($response->status() === 401) {
                Log::warning('Unauthorized response from payouts API');
                return response()->json([
                    'success' => false,
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } else {
                $statusCode = $response->status();
                $responseBody = $response->body();
                
                Log::error('Payouts This Month API error - Status: ' . $statusCode . ', Body: ' . $responseBody);
                
                return response()->json([
                    'success' => false,
                    'error' => 'Failed to load payouts data for this month. API returned status: ' . $statusCode
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Payouts This Month API Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'An error occurred while loading payouts data for this month'
            ], 500);
        }
    }

    public function loadPayoutsThisYear(Request $request)
    {
        try {
            Log::info('=== PAYOUTS THIS YEAR API REQUEST STARTED ===');
            
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
            
            // Calculate date range for this year
            $startOfYear = Carbon::now()->startOfYear()->format('Y-m-d');
            $endOfYear = Carbon::now()->endOfYear()->format('Y-m-d');
            
            Log::info('Sending request to payouts API with date filter');
            Log::info("Date range: {$startOfYear} to {$endOfYear}");
            
            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/payouts', [
                'start_date' => $startOfYear,
                'end_date' => $endOfYear
            ]);

            Log::info('API Response Status: ' . $response->status());

            if ($response->successful()) {
                $data = $response->json();
                $payouts = $data['data'] ?? $data['payouts'] ?? $data ?? [];
                
                // Filter by date range if API doesn't support date parameters
                $filteredPayouts = collect($payouts)->filter(function ($payout) use ($startOfYear, $endOfYear) {
                    $payoutDate = $payout['created_at'] ?? $payout['payout_date'] ?? $payout['date'] ?? null;
                    if (!$payoutDate) return false;
                    
                    try {
                        $date = Carbon::parse($payoutDate)->format('Y-m-d');
                        return $date >= $startOfYear && $date <= $endOfYear;
                    } catch (\Exception $e) {
                        return false;
                    }
                })->values()->all();
                
                Log::info('Payouts this year data processed successfully');
                
                return response()->json([
                    'success' => true,
                    'payouts' => $filteredPayouts,
                    'total' => count($filteredPayouts),
                    'period' => 'this-year'
                ]);
            } elseif ($response->status() === 401) {
                Log::warning('Unauthorized response from payouts API');
                return response()->json([
                    'success' => false,
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } else {
                $statusCode = $response->status();
                $responseBody = $response->body();
                
                Log::error('Payouts This Year API error - Status: ' . $statusCode . ', Body: ' . $responseBody);
                
                return response()->json([
                    'success' => false,
                    'error' => 'Failed to load payouts data for this year. API returned status: ' . $statusCode
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Payouts This Year API Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'An error occurred while loading payouts data for this year'
            ], 500);
        }
    }

    public function show($id)
    {
        return view('payout-details');
    }

    public function receipt($id)
    {
        return view('receipt-pdf');
    }

    public function receiptFile($id)
    {
        try {
            Log::info("Looking for receipt file for payout ID: {$id}");
            
            // Load all payouts to find the one with this ID
            $accessToken = session('access_token');
            if (!$accessToken) {
                Log::error('No access token found in session');
                abort(404, 'Receipt not found');
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Accept' => 'application/json',
            ])->get('http://api2.smallsmall.com/api/payouts');

            if (!$response->successful()) {
                Log::error('API request failed', ['status' => $response->status()]);
                abort(404, 'Receipt not found');
            }

            $data = $response->json();
            if (!$data['success'] || !isset($data['payouts'])) {
                Log::error('No payouts data in API response');
                abort(404, 'Receipt not found');
            }

            // Find the specific payout
            $payout = collect($data['payouts'])->first(function ($p) use ($id) {
                return (string)($p['id'] ?? $p['payout_id']) === (string)$id;
            });

            if (!$payout) {
                Log::error("Payout not found with ID: {$id}");
                abort(404, 'Payout not found');
            }

            $receiptFileName = $payout['upload_receipt'] ?? null;
            if (!$receiptFileName) {
                Log::error("No receipt file found for payout: {$id}");
                abort(404, 'Receipt file not found');
            }

            $filePath = storage_path("app/public/receipts/{$receiptFileName}");
            
            if (!file_exists($filePath)) {
                Log::error("Receipt file does not exist: {$filePath}");
                
                // Return a placeholder image or redirect to PDF receipt instead of 404
                return redirect()->route('payout.receipt', ['id' => $id]);
            }

            // Determine the MIME type
            $mimeType = mime_content_type($filePath);
            $fileName = basename($filePath);
            
            Log::info("Serving receipt file: {$filePath}");
            
            return response()->file($filePath, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' . $fileName . '"'
            ]);

        } catch (\Exception $e) {
            Log::error('Error serving receipt file', ['error' => $e->getMessage()]);
            abort(404, 'Receipt not found');
        }
    }

    public function add()
    {
        return view('add-payout');
    }

    public function store(Request $request)
    {
        try {
            Log::info('=== ADD PAYOUT REQUEST STARTED ===');
            Log::info('Request method: ' . $request->method());
            Log::info('Request URL: ' . $request->url());
            Log::info('Request headers:', $request->headers->all());
            Log::info('All request data:', $request->all());
            Log::info('Files in request:', $request->allFiles());
            
            $accessToken = session('access_token');
            
            if (!$accessToken) {
                Log::warning('No access token found in session');
                return redirect()->route('login')->withErrors(['error' => 'Session expired. Please login again.']);
            }

            Log::info('About to start validation...');
            
            // Log each field for debugging
            Log::info('Validating landlord_id', ['value' => $request->get('landlord_id'), 'type' => gettype($request->get('landlord_id'))]);
            Log::info('Validating amount', ['value' => $request->get('amount'), 'type' => gettype($request->get('amount'))]);
            Log::info('Validating payout_status', ['value' => $request->get('payout_status'), 'type' => gettype($request->get('payout_status'))]);
            Log::info('Validating date_paid', ['value' => $request->get('date_paid'), 'type' => gettype($request->get('date_paid'))]);
            
            // Validate request data
            $validatedData = $request->validate([
                'landlord_id' => 'required|string|max:255',
                'amount' => 'required|numeric|min:0.01|max:999999999.99',
                'payout_status' => 'required|string|in:pending,processing,completed,failed',
                'upload_receipt' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
                'date_paid' => 'required|date'
            ], [
                'landlord_id.required' => 'Please select a landlord.',
                'landlord_id.string' => 'Landlord ID must be a string.',
                'amount.required' => 'Please enter the payout amount.',
                'amount.numeric' => 'Amount must be a valid number.',
                'amount.min' => 'Amount must be at least ₦0.01.',
                'payout_status.required' => 'Please select a payout status.',
                'payout_status.in' => 'Invalid payout status selected.',
                'upload_receipt.file' => 'Upload receipt must be a valid file.',
                'upload_receipt.mimes' => 'Receipt file must be PDF, JPG, PNG, DOC, or DOCX.',
                'upload_receipt.max' => 'Receipt file must be less than 5MB.',
                'date_paid.required' => 'Please select the payment date.',
                'date_paid.date' => 'Please enter a valid date.'
            ]);
            
            Log::info('Validation passed successfully!');

            $headers = [
                'Authorization' => "Bearer {$accessToken}",
                'Accept' => 'application/json',
            ];
            
            // Handle file upload if present
            $receiptFileName = null;
            if ($request->hasFile('upload_receipt')) {
                $file = $request->file('upload_receipt');
                $receiptFileName = 'receipt_' . date('M_Y') . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                
                // Store the file in storage/app/public/receipts
                $filePath = $file->storeAs('receipts', $receiptFileName, 'public');
                
                Log::info('Receipt file uploaded and stored: ' . $filePath);
            }
            
            $payoutData = [
                'landlord_id' => $validatedData['landlord_id'],
                'amount' => $validatedData['amount'],
                'payout_status' => $validatedData['payout_status'],
                'upload_receipt' => $receiptFileName,
                'date_paid' => $validatedData['date_paid']
            ];
            
            Log::info('Sending payout creation request to API', ['data' => $payoutData]);
            
            // Send as JSON - API expects filename string, not actual file
            $response = Http::timeout(30)
                ->withHeaders(array_merge($headers, ['Content-Type' => 'application/json']))
                ->post('http://api2.smallsmall.com/api/payouts', $payoutData);

            Log::info('API Response Status: ' . $response->status());

            if ($response->successful()) {
                Log::info('Payout created successfully');
                return redirect()->route('payouts')->with('success', 'Payout created successfully!');
            } else {
                $errorData = $response->json();
                $errorMessage = $errorData['message'] ?? $errorData['error'] ?? 'Failed to create payout';
                Log::error('Failed to create payout', ['message' => $errorMessage, 'response' => $errorData]);
                return back()->withErrors(['error' => $errorMessage])->withInput();
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Validation failed', ['errors' => $e->errors()]);
            
            // Add more context to validation errors
            $detailedErrors = [];
            foreach ($e->errors() as $field => $messages) {
                foreach ($messages as $message) {
                    $detailedErrors[] = "{$field}: {$message}";
                }
            }
            
            Log::info('Detailed validation errors', ['errors' => $detailedErrors]);
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error creating payout', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            $errorMessage = 'An unexpected error occurred while creating the payout.';
            if (app()->environment('local')) {
                $errorMessage .= ' Error details: ' . $e->getMessage();
            }
            
            return back()->withErrors(['error' => $errorMessage])->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            Log::info('=== SOFT DELETE PAYOUT REQUEST STARTED ===');
            Log::info('Payout ID to delete: ' . $id);
            
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
            
            Log::info('Sending soft delete request to payouts API');
            Log::info('API URL: http://api2.smallsmall.com/api/payouts/' . $id);

            // Send DELETE request to API for soft delete
            $response = Http::timeout(30)->withHeaders($headers)->delete('http://api2.smallsmall.com/api/payouts/' . $id);

            Log::info('API Response Status: ' . $response->status());
            Log::info('API Response Body: ' . $response->body());

            if ($response->successful()) {
                Log::info('Payout soft deleted successfully');
                return response()->json([
                    'success' => true,
                    'message' => 'Payout deleted successfully!'
                ]);
            } elseif ($response->status() === 401) {
                Log::warning('Unauthorized response from payouts API');
                return response()->json([
                    'success' => false,
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } elseif ($response->status() === 404) {
                Log::warning('Payout not found for deletion');
                return response()->json([
                    'success' => false,
                    'error' => 'Payout not found.'
                ], 404);
            } else {
                $statusCode = $response->status();
                $responseBody = $response->body();
                
                Log::error('Delete Payout API error - Status: ' . $statusCode . ', Body: ' . $responseBody);
                
                return response()->json([
                    'success' => false,
                    'error' => 'Failed to delete payout. API returned status: ' . $statusCode
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Delete Payout API Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'error' => 'An error occurred while deleting the payout'
            ], 500);
        }
    }
}