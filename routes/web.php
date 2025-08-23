<?php

// SmallSmall Manager Routes
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\UnconvertedUsersController;
use App\Http\Controllers\InspectionsController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\TenantsController;
use App\Http\Controllers\PropertiesController;
use App\Http\Controllers\LandlordsController;
use App\Http\Controllers\VerificationsController;
use App\Http\Controllers\RepairsController;
use App\Http\Controllers\PayoutsController;

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

Route::get('/unconverted-users', [UnconvertedUsersController::class, 'index'])->name('unconverted-users');
Route::post('/unconverted-users/load', [UnconvertedUsersController::class, 'loadUnconvertedUsers'])->name('unconverted-users.load');
Route::get('/unconverted-users/this-week', [UnconvertedUsersController::class, 'thisWeek'])->name('unconverted-users.this-week');
Route::post('/unconverted-users/this-week/load', [UnconvertedUsersController::class, 'loadUnconvertedUsersThisWeek'])->name('unconverted-users.this-week.load');
Route::get('/unconverted-users/this-month', [UnconvertedUsersController::class, 'thisMonth'])->name('unconverted-users.this-month');
Route::post('/unconverted-users/this-month/load', [UnconvertedUsersController::class, 'loadUnconvertedUsersThisMonth'])->name('unconverted-users.this-month.load');
Route::get('/unconverted-users/this-year', [UnconvertedUsersController::class, 'thisYear'])->name('unconverted-users.this-year');
Route::post('/unconverted-users/this-year/load', [UnconvertedUsersController::class, 'loadUnconvertedUsersThisYear'])->name('unconverted-users.this-year.load');
Route::get('/unconverted-users/{id}', [UnconvertedUsersController::class, 'show'])->name('unconverted-users.show');

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

Route::get('/properties', [PropertiesController::class, 'index'])->name('properties');
Route::post('/properties/load', [PropertiesController::class, 'loadProperties'])->name('properties.load');
Route::get('/properties/this-week', [PropertiesController::class, 'thisWeek'])->name('properties.this-week');
Route::post('/properties/this-week/load', [PropertiesController::class, 'loadPropertiesThisWeek'])->name('properties.this-week.load');
Route::get('/properties/this-month', [PropertiesController::class, 'thisMonth'])->name('properties.this-month');
Route::post('/properties/this-month/load', [PropertiesController::class, 'loadPropertiesThisMonth'])->name('properties.this-month.load');
Route::get('/properties/this-year', [PropertiesController::class, 'thisYear'])->name('properties.this-year');
Route::post('/properties/this-year/load', [PropertiesController::class, 'loadPropertiesThisYear'])->name('properties.this-year.load');
Route::get('/landlord/{landlordId}/properties', [PropertiesController::class, 'landlordProperties'])->name('landlord.properties');
Route::post('/landlord/{landlordId}/properties/load', [PropertiesController::class, 'loadLandlordProperties'])->name('landlord.properties.load');
Route::get('/assign-property-owner/{propertyId}', [PropertiesController::class, 'assignPropertyOwner'])->name('assign-property-owner');
Route::get('/api/property-details/{propertyId}', [PropertiesController::class, 'getPropertyDetails'])->name('api.property-details');
Route::post('/api/assign-property-owner', [PropertiesController::class, 'assignPropertyOwnerAPI'])->name('api.assign-property-owner');

Route::get('/landlords', [LandlordsController::class, 'index'])->name('landlords');
Route::post('/landlords/load', [LandlordsController::class, 'loadLandlords'])->name('landlords.load');
Route::get('/landlords/add', [LandlordsController::class, 'add'])->name('landlords.add');
Route::post('/landlords/store', [LandlordsController::class, 'store'])->name('landlords.store');
Route::get('/landlord/{userID}', [LandlordsController::class, 'show'])->name('landlord.show');
Route::get('/landlord/{userID}/edit', [LandlordsController::class, 'edit'])->name('landlord.edit');
Route::get('/api/landlord-details/{userID}', [LandlordsController::class, 'getLandlordDetails'])->name('api.landlord-details');
Route::put('/api/landlord-update/{userID}', [LandlordsController::class, 'update'])->name('api.landlord-update');
Route::get('/landlords/this-week', [LandlordsController::class, 'thisWeek'])->name('landlords.this-week');
Route::post('/landlords/this-week/load', [LandlordsController::class, 'loadLandlordsThisWeek'])->name('landlords.this-week.load');
Route::get('/landlords/this-month', [LandlordsController::class, 'thisMonth'])->name('landlords.this-month');
Route::post('/landlords/this-month/load', [LandlordsController::class, 'loadLandlordsThisMonth'])->name('landlords.this-month.load');
Route::get('/landlords/this-year', [LandlordsController::class, 'thisYear'])->name('landlords.this-year');
Route::post('/landlords/this-year/load', [LandlordsController::class, 'loadLandlordsThisYear'])->name('landlords.this-year.load');

Route::get('/verifications', [VerificationsController::class, 'index'])->name('verifications');
Route::post('/verifications/load', [VerificationsController::class, 'loadVerifications'])->name('verifications.load');
Route::get('/verifications/this-week', [VerificationsController::class, 'thisWeek'])->name('verifications.this-week');
Route::post('/verifications/this-week/load', [VerificationsController::class, 'loadVerificationsThisWeek'])->name('verifications.this-week.load');
Route::get('/verifications/this-month', [VerificationsController::class, 'thisMonth'])->name('verifications.this-month');
Route::post('/verifications/this-month/load', [VerificationsController::class, 'loadVerificationsThisMonth'])->name('verifications.this-month.load');
Route::get('/verifications/this-year', [VerificationsController::class, 'thisYear'])->name('verifications.this-year');
Route::post('/verifications/this-year/load', [VerificationsController::class, 'loadVerificationsThisYear'])->name('verifications.this-year.load');
Route::get('/verifications/{id}', [VerificationsController::class, 'show'])->name('verification.show');
Route::put('/verifications/{id}', [VerificationsController::class, 'update'])->name('verification.update');

Route::get('/repairs', [RepairsController::class, 'index'])->name('repairs');
Route::post('/repairs/load', [RepairsController::class, 'loadRepairs'])->name('repairs.load');
Route::get('/repairs/add', [RepairsController::class, 'add'])->name('repairs.add');
Route::post('/repairs/store', [RepairsController::class, 'store'])->name('repairs.store');
Route::get('/repair/{id}', [RepairsController::class, 'show'])->name('repair.show');
Route::get('/repair/{id}/edit', [RepairsController::class, 'edit'])->name('repair.edit');
Route::put('/repair/{id}', [RepairsController::class, 'update'])->name('repair.update');
Route::delete('/repair/{id}', [RepairsController::class, 'destroy'])->name('repair.destroy');
Route::get('/repairs/this-week', [RepairsController::class, 'thisWeek'])->name('repairs.this-week');
Route::post('/repairs/this-week/load', [RepairsController::class, 'loadRepairsThisWeek'])->name('repairs.this-week.load');
Route::get('/repairs/this-month', [RepairsController::class, 'thisMonth'])->name('repairs.this-month');
Route::post('/repairs/this-month/load', [RepairsController::class, 'loadRepairsThisMonth'])->name('repairs.this-month.load');
Route::get('/repairs/this-year', [RepairsController::class, 'thisYear'])->name('repairs.this-year');
Route::post('/repairs/this-year/load', [RepairsController::class, 'loadRepairsThisYear'])->name('repairs.this-year.load');

Route::get('/payouts', [PayoutsController::class, 'index'])->name('payouts');
Route::post('/payouts/load', [PayoutsController::class, 'loadPayouts'])->name('payouts.load');
Route::get('/payouts/add', [PayoutsController::class, 'add'])->name('payouts.add');
Route::post('/payouts/store', [PayoutsController::class, 'store'])->name('payouts.store');
Route::get('/payout/{id}', [PayoutsController::class, 'show'])->name('payout.show');
Route::get('/payout/{id}/receipt', [PayoutsController::class, 'receipt'])->name('payout.receipt');
Route::get('/payout/{id}/file', [PayoutsController::class, 'receiptFile'])->name('payout.receipt.file');
Route::delete('/payout/{id}', [PayoutsController::class, 'destroy'])->name('payout.destroy');
Route::get('/payouts/this-week', [PayoutsController::class, 'thisWeek'])->name('payouts.this-week');
Route::post('/payouts/this-week/load', [PayoutsController::class, 'loadPayoutsThisWeek'])->name('payouts.this-week.load');
Route::get('/payouts/this-month', [PayoutsController::class, 'thisMonth'])->name('payouts.this-month');
Route::post('/payouts/this-month/load', [PayoutsController::class, 'loadPayoutsThisMonth'])->name('payouts.this-month.load');
Route::get('/payouts/this-year', [PayoutsController::class, 'thisYear'])->name('payouts.this-year');
Route::post('/payouts/this-year/load', [PayoutsController::class, 'loadPayoutsThisYear'])->name('payouts.this-year.load');

// Dashboard API routes
Route::get('/api/dashboard/data', [DashboardController::class, 'getDashboardData'])->name('api.dashboard.data');
Route::post('/api/conversion-rate/this-year', [DashboardController::class, 'getConversionRate'])->name('api.conversion-rate.this-year');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout.get'); // Fallback for expired sessions
