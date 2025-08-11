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
}