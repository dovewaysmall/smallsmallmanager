<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TenantsController extends Controller
{
    public function index()
    {
        // Check authentication first
        $accessToken = session('access_token');
        if (!$accessToken) {
            session()->flush();
            return redirect()->route('login')->with('error', 'Session expired. Please login again.');
        }
        
        return view('tenants');
    }

    public function show($userID)
    {
        Log::info("Tenant detail page accessed for userID: {$userID}");
        return view('tenant-detail', compact('userID'));
    }

    public function getTenantDetails($userID)
    {
        try {
            Log::info('Getting tenant details', [
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

            // First try the specific tenant details endpoint
            Log::info('Fetching tenant details for userID: ' . $userID);
            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/tenant-details/' . $userID);
            
            Log::info('Tenant Details API Response Status: ' . $response->status());
            
            if ($response->successful()) {
                $apiData = $response->json();
                Log::info('Tenant Details API Response: ' . json_encode($apiData));
                
                if (isset($apiData['success']) && $apiData['success'] && isset($apiData['data'])) {
                    return response()->json([
                        'success' => true,
                        'tenant' => $apiData['data']
                    ]);
                }
            } elseif ($response->status() === 401) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            }
            
            // If specific endpoint fails, try getting from general tenants list
            Log::info('Tenant details endpoint failed, trying general tenants list');
            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/tenants');
            
            if ($response->successful()) {
                $apiData = $response->json();
                $tenants = $apiData['data'] ?? $apiData['tenants'] ?? $apiData ?? [];
                
                Log::info('Found ' . count($tenants) . ' tenants, searching for userID: ' . $userID);
                
                // Find the specific tenant by userID
                $tenant = null;
                foreach ($tenants as $t) {
                    if (isset($t['userID']) && $t['userID'] == $userID) {
                        $tenant = $t;
                        break;
                    }
                }
                
                if ($tenant) {
                    // Create the expected structure for the frontend
                    $tenantDetails = [
                        'tenant_info' => $tenant,
                        'bookings' => [],
                        'inspections' => [],
                        'bookings_count' => 0,
                        'inspections_count' => 0
                    ];
                    
                    Log::info('Found tenant in list: ' . json_encode($tenant));
                    return response()->json([
                        'success' => true,
                        'tenant' => $tenantDetails
                    ]);
                } else {
                    Log::warning('Tenant not found with userID: ' . $userID);
                    return response()->json([
                        'error' => 'Subscriber not found.'
                    ], 404);
                }
            } elseif ($response->status() === 401) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } else {
                Log::error('Failed to fetch tenants. Status: ' . $response->status() . ', Body: ' . $response->body());
                return response()->json([
                    'error' => 'Failed to fetch subscriber details from API.'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Tenant Details API Error: ' . $e->getMessage(), [
                'userID' => $userID,
                'stack_trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => 'An error occurred while loading tenant details.'
            ], 500);
        }
    }

    public function thisWeek()
    {
        return view('tenants-this-week');
    }

    public function thisMonth()
    {
        return view('tenants-this-month');
    }

    public function thisYear()
    {
        return view('tenants-this-year');
    }

    public function loadTenants(Request $request)
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

            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/tenants');

            if ($response->successful()) {
                $apiData = $response->json();
                $tenants = $apiData['data'] ?? $apiData['tenants'] ?? $apiData ?? [];
                
                return response()->json([
                    'success' => true,
                    'tenants' => $tenants
                ]);
            } elseif ($response->status() === 401) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } else {
                return response()->json([
                    'error' => 'Failed to fetch tenants from API.'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Tenants API Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while loading tenants.'
            ], 500);
        }
    }

    public function loadTenantsThisWeek(Request $request)
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

            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/tenants/this-week');

            if ($response->successful()) {
                $apiData = $response->json();
                $tenants = $apiData['data'] ?? $apiData['tenants'] ?? $apiData ?? [];
                
                return response()->json([
                    'success' => true,
                    'tenants' => $tenants
                ]);
            } elseif ($response->status() === 401) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } else {
                return response()->json([
                    'error' => 'Failed to fetch tenants from API.'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Tenants This Week API Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while loading tenants.'
            ], 500);
        }
    }

    public function loadTenantsThisMonth(Request $request)
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

            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/tenants/this-month');

            if ($response->successful()) {
                $apiData = $response->json();
                $tenants = $apiData['data'] ?? $apiData['tenants'] ?? $apiData ?? [];
                
                return response()->json([
                    'success' => true,
                    'tenants' => $tenants
                ]);
            } elseif ($response->status() === 401) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } else {
                return response()->json([
                    'error' => 'Failed to fetch tenants from API.'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Tenants This Month API Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while loading tenants.'
            ], 500);
        }
    }

    public function loadTenantsThisYear(Request $request)
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

            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/tenants/this-year');

            if ($response->successful()) {
                $apiData = $response->json();
                $tenants = $apiData['data'] ?? $apiData['tenants'] ?? $apiData ?? [];
                
                return response()->json([
                    'success' => true,
                    'tenants' => $tenants
                ]);
            } elseif ($response->status() === 401) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } else {
                return response()->json([
                    'error' => 'Failed to fetch tenants from API.'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Tenants This Year API Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while loading tenants.'
            ], 500);
        }
    }
}