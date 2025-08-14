<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        $userCount = 0;
        $inspectionCount = 0;
        $transactionCount = 0;
        $tenantCount = 0;
        $propertyCount = 0;
        $newUsersThisMonth = 0;
        $inspectionsThisMonth = 0;
        
        try {
            $accessToken = session('access_token');
            
            if (!$accessToken) {
                session()->flush();
                return redirect()->route('login')->with('error', 'Session expired. Please login again.');
            }
            
            if ($accessToken) {
                $headers = [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Accept' => 'application/json',
                ];
                
                // Fetch user count
                $userResponse = Http::withHeaders($headers)->get('http://api2.smallsmall.com/api/users/count');
                if ($userResponse->successful()) {
                    $userData = $userResponse->json();
                    $userCount = $userData['count'] ?? $userData['total'] ?? $userData['users_count'] ?? 0;
                } elseif ($userResponse->status() === 401) {
                    session()->flush();
                    return redirect()->route('login')->with('error', 'Session expired. Please login again.');
                }
                
                // Fetch inspection count
                $inspectionResponse = Http::withHeaders($headers)->get('http://api2.smallsmall.com/api/inspections/count');
                if ($inspectionResponse->successful()) {
                    $inspectionData = $inspectionResponse->json();
                    $inspectionCount = $inspectionData['count'] ?? $inspectionData['total'] ?? $inspectionData['inspections_count'] ?? 0;
                } elseif ($inspectionResponse->status() === 401) {
                    session()->flush();
                    return redirect()->route('login')->with('error', 'Session expired. Please login again.');
                }
                
                // Fetch transaction count
                $transactionResponse = Http::withHeaders($headers)->get('http://api2.smallsmall.com/api/transactions/count');
                if ($transactionResponse->successful()) {
                    $transactionData = $transactionResponse->json();
                    $transactionCount = $transactionData['count'] ?? $transactionData['total'] ?? $transactionData['transactions_count'] ?? 0;
                } elseif ($transactionResponse->status() === 401) {
                    session()->flush();
                    return redirect()->route('login')->with('error', 'Session expired. Please login again.');
                }
                
                // Fetch tenant count
                $tenantResponse = Http::withHeaders($headers)->get('http://api2.smallsmall.com/api/tenants/count');
                if ($tenantResponse->successful()) {
                    $tenantData = $tenantResponse->json();
                    $tenantCount = $tenantData['count'] ?? $tenantData['total'] ?? $tenantData['tenants_count'] ?? 0;
                } elseif ($tenantResponse->status() === 401) {
                    session()->flush();
                    return redirect()->route('login')->with('error', 'Session expired. Please login again.');
                }
                
                // Fetch property count
                $propertyResponse = Http::withHeaders($headers)->get('http://api2.smallsmall.com/api/properties/count');
                if ($propertyResponse->successful()) {
                    $propertyData = $propertyResponse->json();
                    $propertyCount = $propertyData['count'] ?? $propertyData['total'] ?? $propertyData['properties_count'] ?? 0;
                } elseif ($propertyResponse->status() === 401) {
                    session()->flush();
                    return redirect()->route('login')->with('error', 'Session expired. Please login again.');
                }
                
                // Fetch new users this month count
                $newUsersResponse = Http::withHeaders($headers)->get('http://api2.smallsmall.com/api/users/count/monthly');
                if ($newUsersResponse->successful()) {
                    $newUsersData = $newUsersResponse->json();
                    $newUsersThisMonth = $newUsersData['count'] ?? $newUsersData['total'] ?? $newUsersData['new_users_count'] ?? 0;
                } elseif ($newUsersResponse->status() === 401) {
                    session()->flush();
                    return redirect()->route('login')->with('error', 'Session expired. Please login again.');
                }
                
                // Fetch inspections this month count
                $inspectionsThisMonthResponse = Http::withHeaders($headers)->get('http://api2.smallsmall.com/api/inspections/count/monthly');
                if ($inspectionsThisMonthResponse->successful()) {
                    $inspectionsThisMonthData = $inspectionsThisMonthResponse->json();
                    $inspectionsThisMonth = $inspectionsThisMonthData['count'] ?? $inspectionsThisMonthData['total'] ?? $inspectionsThisMonthData['inspections_count'] ?? 0;
                } elseif ($inspectionsThisMonthResponse->status() === 401) {
                    session()->flush();
                    return redirect()->route('login')->with('error', 'Session expired. Please login again.');
                }
                
                // Fetch pending inspections this month count
                $pendingInspectionsResponse = Http::withHeaders($headers)->get('http://api2.smallsmall.com/api/inspections/pending/count/this-month');
                $pendingInspectionsThisMonth = 0;
                if ($pendingInspectionsResponse->successful()) {
                    $pendingInspectionsData = $pendingInspectionsResponse->json();
                    $pendingInspectionsThisMonth = $pendingInspectionsData['pending_count'] ?? $pendingInspectionsData['count'] ?? $pendingInspectionsData['total'] ?? 0;
                } elseif ($pendingInspectionsResponse->status() === 401) {
                    session()->flush();
                    return redirect()->route('login')->with('error', 'Session expired. Please login again.');
                }
            }
        } catch (\Exception $e) {
            Log::error('Dashboard API Error: ' . $e->getMessage());
            $userCount = 0;
            $inspectionCount = 0;
            $transactionCount = 0;
            $tenantCount = 0;
            $propertyCount = 0;
            $newUsersThisMonth = 0;
            $inspectionsThisMonth = 0;
            $pendingInspectionsThisMonth = 0;
        }
        
        return view('dashboard', compact('userCount', 'inspectionCount', 'transactionCount', 'tenantCount', 'propertyCount', 'newUsersThisMonth', 'inspectionsThisMonth', 'pendingInspectionsThisMonth'));
    }

    public function getConversionRate()
    {
        try {
            $accessToken = session('access_token');
            
            if (!$accessToken) {
                return response()->json(['success' => false, 'error' => 'Session expired'], 401);
            }

            $headers = [
                'Authorization' => "Bearer {$accessToken}",
                'Accept' => 'application/json',
            ];

            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/users/conversion-rate/this-year');

            if ($response->successful()) {
                return response()->json($response->json());
            } elseif ($response->status() === 401) {
                return response()->json(['success' => false, 'error' => 'Session expired'], 401);
            } else {
                return response()->json(['success' => false, 'error' => 'Failed to fetch conversion rate'], 500);
            }
        } catch (\Exception $e) {
            Log::error('Conversion Rate API Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'An error occurred while fetching conversion rate'], 500);
        }
    }
}