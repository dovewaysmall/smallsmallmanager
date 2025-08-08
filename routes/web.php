<?php

// SmallSmall Manager Routes
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\AuthController;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// Test route to clear session manually
Route::get('/test-expire', function () {
    session()->flush();
    return redirect()->route('dashboard');
})->name('test.expire');

Route::get('/dashboard', function () {
    $userCount = 0;
    $inspectionCount = 0;
    $transactionCount = 0;
    $tenantCount = 0;
    
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
        }
    } catch (\Exception $e) {
        $userCount = 0;
        $inspectionCount = 0;
        $transactionCount = 0;
        $tenantCount = 0;
    }
    
    return view('dashboard', compact('userCount', 'inspectionCount', 'transactionCount', 'tenantCount'));
})->name('dashboard');

Route::get('/users', function () {
    return view('users');
})->name('users');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
