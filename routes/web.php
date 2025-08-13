<?php

// SmallSmall Manager Routes
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\InspectionsController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\TenantsController;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// Test route to clear session manually
Route::get('/test-expire', function () {
    session()->flush();
    return redirect()->route('dashboard');
})->name('test.expire');

// Test API connectivity
Route::get('/test-api', function () {
    try {
        $response = \Illuminate\Support\Facades\Http::timeout(10)->get('http://api2.smallsmall.com');
        return response()->json([
            'status' => 'success',
            'api_status' => $response->status(),
            'api_response' => $response->body(),
            'message' => 'API server is reachable'
        ]);
    } catch (\Illuminate\Http\Client\ConnectionException $e) {
        return response()->json([
            'status' => 'connection_error',
            'message' => 'Cannot connect to API server',
            'error' => $e->getMessage()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'API test failed',
            'error' => $e->getMessage(),
            'error_class' => get_class($e)
        ]);
    }
})->name('test.api');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/users', [UsersController::class, 'index'])->name('users');
Route::post('/users/load', [UsersController::class, 'loadUsers'])->name('users.load');

Route::get('/inspections', [InspectionsController::class, 'index'])->name('inspections');
Route::post('/inspections/load', [InspectionsController::class, 'loadInspections'])->name('inspections.load');
Route::get('/inspections/this-week', [InspectionsController::class, 'thisWeek'])->name('inspections.this-week');
Route::post('/inspections/this-week/load', [InspectionsController::class, 'loadInspectionsThisWeek'])->name('inspections.this-week.load');
Route::get('/inspections/this-month', [InspectionsController::class, 'thisMonth'])->name('inspections.this-month');
Route::post('/inspections/this-month/load', [InspectionsController::class, 'loadInspectionsThisMonth'])->name('inspections.this-month.load');
Route::get('/inspections/this-year', [InspectionsController::class, 'thisYear'])->name('inspections.this-year');
Route::post('/inspections/this-year/load', [InspectionsController::class, 'loadInspectionsThisYear'])->name('inspections.this-year.load');
Route::get('/inspection/{id}', [InspectionsController::class, 'show'])->name('inspection.show');
Route::put('/inspection/{id}', [InspectionsController::class, 'update'])->name('inspection.update');

Route::get('/transactions', [TransactionsController::class, 'index'])->name('transactions');
Route::post('/transactions/load', [TransactionsController::class, 'loadTransactions'])->name('transactions.load');
Route::get('/transactions/this-week', [TransactionsController::class, 'thisWeek'])->name('transactions.this-week');
Route::post('/transactions/this-week/load', [TransactionsController::class, 'loadTransactionsThisWeek'])->name('transactions.this-week.load');
Route::get('/transactions/this-month', [TransactionsController::class, 'thisMonth'])->name('transactions.this-month');
Route::post('/transactions/this-month/load', [TransactionsController::class, 'loadTransactionsThisMonth'])->name('transactions.this-month.load');
Route::get('/transactions/this-year', [TransactionsController::class, 'thisYear'])->name('transactions.this-year');
Route::post('/transactions/this-year/load', [TransactionsController::class, 'loadTransactionsThisYear'])->name('transactions.this-year.load');

Route::get('/tenants', [TenantsController::class, 'index'])->name('tenants');
Route::post('/tenants/load', [TenantsController::class, 'loadTenants'])->name('tenants.load');
Route::get('/tenants/this-week', [TenantsController::class, 'thisWeek'])->name('tenants.this-week');
Route::post('/tenants/this-week/load', [TenantsController::class, 'loadTenantsThisWeek'])->name('tenants.this-week.load');
Route::get('/tenants/this-month', [TenantsController::class, 'thisMonth'])->name('tenants.this-month');
Route::post('/tenants/this-month/load', [TenantsController::class, 'loadTenantsThisMonth'])->name('tenants.this-month.load');
Route::get('/tenants/this-year', [TenantsController::class, 'thisYear'])->name('tenants.this-year');
Route::post('/tenants/this-year/load', [TenantsController::class, 'loadTenantsThisYear'])->name('tenants.this-year.load');
Route::get('/tenant/{userID}', [TenantsController::class, 'show'])->name('tenant.show');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout.get'); // Fallback for expired sessions
