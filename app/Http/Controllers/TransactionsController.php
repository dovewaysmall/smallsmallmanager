<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TransactionsController extends Controller
{
    public function index()
    {
        return view('transactions');
    }

    public function thisWeek()
    {
        return view('transactions-this-week');
    }

    public function thisMonth()
    {
        return view('transactions-this-month');
    }

    public function thisYear()
    {
        return view('transactions-this-year');
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

            $response = Http::timeout(30)->withHeaders($headers)->get("http://api2.smallsmall.com/api/transactions/{$id}");

            if ($response->successful()) {
                $apiData = $response->json();
                Log::info('Transaction API Response: ' . json_encode($apiData));
                
                return view('transaction-detail', ['transaction' => $apiData, 'id' => $id]);
            } elseif ($response->status() === 401) {
                return redirect()->route('login')->with('error', 'Session expired. Please login again.');
            } else {
                return view('transaction-detail', ['transaction' => null, 'id' => $id, 'error' => 'Failed to load transaction data.']);
            }
        } catch (\Exception $e) {
            Log::error('Transaction Detail API Error: ' . $e->getMessage());
            return view('transaction-detail', ['transaction' => null, 'id' => $id, 'error' => 'An error occurred while loading transaction data.']);
        }
    }

    public function loadTransactions(Request $request)
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

            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/transactions');

            if ($response->successful()) {
                $apiData = $response->json();
                $transactions = $apiData['data'] ?? $apiData['transactions'] ?? $apiData ?? [];
                
                return response()->json([
                    'success' => true,
                    'transactions' => $transactions
                ]);
            } elseif ($response->status() === 401) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } else {
                return response()->json([
                    'error' => 'Failed to fetch transactions from API.'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Transactions API Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while loading transactions.'
            ], 500);
        }
    }

    public function loadTransactionsThisWeek(Request $request)
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

            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/transactions/this-week');

            if ($response->successful()) {
                $apiData = $response->json();
                $transactions = $apiData['data'] ?? $apiData['transactions'] ?? $apiData ?? [];
                
                return response()->json([
                    'success' => true,
                    'transactions' => $transactions
                ]);
            } elseif ($response->status() === 401) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } else {
                return response()->json([
                    'error' => 'Failed to fetch transactions from API.'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Transactions This Week API Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while loading transactions.'
            ], 500);
        }
    }

    public function loadTransactionsThisMonth(Request $request)
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

            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/transactions/this-month');

            if ($response->successful()) {
                $apiData = $response->json();
                $transactions = $apiData['data'] ?? $apiData['transactions'] ?? $apiData ?? [];
                
                return response()->json([
                    'success' => true,
                    'transactions' => $transactions
                ]);
            } elseif ($response->status() === 401) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } else {
                return response()->json([
                    'error' => 'Failed to fetch transactions from API.'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Transactions This Month API Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while loading transactions.'
            ], 500);
        }
    }

    public function loadTransactionsThisYear(Request $request)
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

            $response = Http::timeout(30)->withHeaders($headers)->get('http://api2.smallsmall.com/api/transactions/this-year');

            if ($response->successful()) {
                $apiData = $response->json();
                $transactions = $apiData['data'] ?? $apiData['transactions'] ?? $apiData ?? [];
                
                return response()->json([
                    'success' => true,
                    'transactions' => $transactions
                ]);
            } elseif ($response->status() === 401) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } else {
                return response()->json([
                    'error' => 'Failed to fetch transactions from API.'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Transactions This Year API Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'An error occurred while loading transactions.'
            ], 500);
        }
    }

    public function deleteTransaction($id)
    {
        try {
            Log::info('Deleting transaction', ['id' => $id]);
            
            $accessToken = session('access_token');
            
            if (!$accessToken) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            }

            $headers = [
                'Authorization' => "Bearer {$accessToken}",
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ];

            Log::info('Transaction Delete API - Making request to: http://api2.smallsmall.com/api/transactions/' . $id);
            $response = Http::timeout(30)->withHeaders($headers)->delete('http://api2.smallsmall.com/api/transactions/' . $id);

            Log::info('Transaction Delete API - Response Status: ' . $response->status());
            Log::info('Transaction Delete API - Response Body: ' . $response->body());

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Transaction deleted successfully.'
                ]);
            } elseif ($response->status() === 401) {
                return response()->json([
                    'error' => 'Session expired. Please login again.'
                ], 401);
            } elseif ($response->status() === 404) {
                return response()->json([
                    'error' => 'Transaction not found.'
                ], 404);
            } else {
                return response()->json([
                    'error' => 'Failed to delete transaction.'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Transaction Delete API Error: ' . $e->getMessage(), [
                'id' => $id,
                'stack_trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => 'An error occurred while deleting the transaction.'
            ], 500);
        }
    }
}