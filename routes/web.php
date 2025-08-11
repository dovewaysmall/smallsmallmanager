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

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/users', [UsersController::class, 'index'])->name('users');
Route::post('/users/load', [UsersController::class, 'loadUsers'])->name('users.load');

Route::get('/inspections', [InspectionsController::class, 'index'])->name('inspections');
Route::post('/inspections/load', [InspectionsController::class, 'loadInspections'])->name('inspections.load');

Route::get('/transactions', [TransactionsController::class, 'index'])->name('transactions');
Route::post('/transactions/load', [TransactionsController::class, 'loadTransactions'])->name('transactions.load');

Route::get('/tenants', [TenantsController::class, 'index'])->name('tenants');
Route::post('/tenants/load', [TenantsController::class, 'loadTenants'])->name('tenants.load');
Route::get('/tenant/{userID}', [TenantsController::class, 'show'])->name('tenant.show');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout.get'); // Fallback for expired sessions
