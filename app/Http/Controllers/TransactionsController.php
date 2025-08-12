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
}