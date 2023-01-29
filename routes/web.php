<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});

Route::get('/home',[HomeController::class, "index"])->middleware('auth');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

//Landlord
Route::get('/add-landlord',[App\Http\Controllers\LandlordController::class,'addLandlord'])->middleware('auth');
Route::get('/all-landlord',[App\Http\Controllers\LandlordController::class,'allLandlord'])->middleware('auth');
Route::get('/add-landlord-success',[App\Http\Controllers\LandlordController::class,'addLandlordSuccess'])->middleware('auth');

//Tenants
Route::get('/add-tenant',[App\Http\Controllers\TenantController::class,'addTenant'])->middleware('auth');
Route::get('/all-tenants',[App\Http\Controllers\TenantController::class,'allTenants'])->middleware('auth');
Route::get('/tenant/{id}',[App\Http\Controllers\TenantController::class,'tenant'])->middleware('auth');
Route::get('/assign-account-manager/{id}',[App\Http\Controllers\TenantController::class,'assignAccountManager'])->middleware('auth');
Route::get('/account-manager-update-success',[App\Http\Controllers\TenantController::class,'accountManagerUpdateSuccess'])->middleware('auth');
Route::get('/converted-tenants',[App\Http\Controllers\TenantController::class,'convertedTenants'])->middleware('auth');
Route::get('/new-subscribers-finance',[App\Http\Controllers\TenantController::class,'newSubscribersFinance'])->middleware('auth');
Route::get('/subscription-due-this-month',[App\Http\Controllers\TenantController::class,'subscriptionDueThisMonth'])->middleware('auth');
Route::get('/recurring-subscribers-finance',[App\Http\Controllers\TenantController::class,'recurringSubscribersFinance'])->middleware('auth');


//Payouts
Route::get('/add-payout',[App\Http\Controllers\PayoutController::class,'addPayout'])->middleware('auth');
Route::get('/add-payout-success',[App\Http\Controllers\PayoutController::class,'addPayoutSuccess'])->middleware('auth');
Route::get('/all-payouts',[App\Http\Controllers\PayoutController::class,'allPayouts'])->middleware('auth');

//Repairs
Route::get('/report-repair',[App\Http\Controllers\RepairController::class,'reportRepair']);
Route::get('/report-repair-success',[App\Http\Controllers\RepairController::class,'reportRepairSuccess'])->middleware('auth');

//Verifications
Route::get('/all-verifications',[App\Http\Controllers\VerificationController::class,'allVerifications'])->middleware('auth');
Route::get('/tenant-verification/{id}',[App\Http\Controllers\VerificationController::class,'tenantVerification'])->middleware('auth');
Route::get('/verification-status-update-success',[App\Http\Controllers\VerificationController::class,'verificationStatusUpdateSuccess'])->middleware('auth');
Route::get('/verification-status-update-failed',[App\Http\Controllers\VerificationController::class,'verificationStatusUpdateFailed'])->middleware('auth');
Route::get('/verification-profile/{id}',[App\Http\Controllers\VerificationController::class,'verificationProfile'])->middleware('auth');

//Properties
Route::get('/all-properties',[App\Http\Controllers\PropertyController::class,'allProperties'])->middleware('auth');
Route::get('/add-property',[App\Http\Controllers\PropertyController::class,'addProperty'])->middleware('auth');

//Inspection
Route::get('/all-inspections',[App\Http\Controllers\InspectionController::class,'allInspections'])->middleware('auth');
Route::get('/inspection/{id}',[App\Http\Controllers\InspectionController::class,'inspection'])->middleware('auth');
Route::get('/inspection-update-success',[App\Http\Controllers\InspectionController::class,'inspectionUpdateSuccess'])->middleware('auth');
Route::get('/inspection-update-failed',[App\Http\Controllers\InspectionController::class,'inspectionUpdateFailed'])->middleware('auth');
Route::get('/all-inspections-tsr',[App\Http\Controllers\InspectionController::class,'allInspectionsTSR'])->middleware('auth');
Route::get('/all-pending-inspections-tsr',[App\Http\Controllers\InspectionController::class,'allPendingInspectionsTSR'])->middleware('auth');
Route::get('/all-completed-inspections-tsr',[App\Http\Controllers\InspectionController::class,'allCompletedInspectionsTSR'])->middleware('auth');
Route::get('/all-canceled-inspections-tsr',[App\Http\Controllers\InspectionController::class,'allCanceledInspectionsTSR'])->middleware('auth');
Route::get('/pending-inspection/{id}',[App\Http\Controllers\InspectionController::class,'pendingInspection'])->middleware('auth');
Route::get('/inspection-status-update-success',[App\Http\Controllers\InspectionController::class,'inspectionStatusUpdateSuccess'])->middleware('auth');
Route::get('/inspection-status-update-failed',[App\Http\Controllers\InspectionController::class,'inspectionStatusUpdateFailed'])->middleware('auth');
Route::get('/inspections-this-month',[App\Http\Controllers\InspectionController::class,'inspectionsThisMonth'])->middleware('auth');
Route::get('/inspection-feedback-cx/{id}',[App\Http\Controllers\InspectionController::class,'inspectionFeedbackCX'])->middleware('auth');
Route::get('/single-inspection/{id}',[App\Http\Controllers\InspectionController::class,'singleInspection'])->middleware('auth');
Route::get('/completed-inspections',[App\Http\Controllers\InspectionController::class,'completedInspections'])->middleware('auth');
Route::get('/completed-inspections-this-month',[App\Http\Controllers\InspectionController::class,'completedInspectionsThisMonth'])->middleware('auth');
Route::get('/completed-inspections-last-month',[App\Http\Controllers\InspectionController::class,'completedInspectionsLastMonth'])->middleware('auth');
Route::get('/canceled-inspections',[App\Http\Controllers\InspectionController::class,'canceledInspections'])->middleware('auth');
Route::get('/canceled-inspections-this-month',[App\Http\Controllers\InspectionController::class,'canceledInspectionsThisMonth'])->middleware('auth');
Route::get('/canceled-inspections-last-month',[App\Http\Controllers\InspectionController::class,'canceledInspectionsLastMonth'])->middleware('auth');
Route::get('/inspections-last-month',[App\Http\Controllers\InspectionController::class,'inspectionsLastMonth'])->middleware('auth');
Route::get('/inspection-post-inspec-feedback-success',[App\Http\Controllers\InspectionController::class,'inspectionPostInspecFeedbackSuccess'])->middleware('auth');
Route::get('/inspection-post-inspec-feedback-failed',[App\Http\Controllers\InspectionController::class,'inspectionPostInspecFeedbackFailed'])->middleware('auth');
Route::get('/assigned-inspections',[App\Http\Controllers\InspectionController::class,'assignedInspections'])->middleware('auth');

//Buysmallsmall Inspection
Route::get('/all-buy-inspections',[App\Http\Controllers\InspectionController::class,'allBuyInspections'])->middleware('auth');


//Account Manager
Route::get('/all-account-managers',[App\Http\Controllers\AccountManagerController::class,'allAccountManagers'])->middleware('auth');

//Users
Route::get('/all-users',[App\Http\Controllers\UserController::class,'allUsers'])->middleware('auth');

Route::get('/change-password', [App\Http\Controllers\SecurityController::class, 'changePassword'])->middleware('auth');

Route::post('/save-new-password', [App\Http\Controllers\SecurityController::class, 'saveNewPassword'])->middleware('auth');

Route::get('/single-buy-inspection/{id}',[App\Http\Controllers\InspectionController::class,'singleBuyInspection'])->middleware('auth');

//Staysmallsmall
Route::get('/all-stay-bookings',[App\Http\Controllers\StaySmallSmallBookingsController::class,'allStayBookings'])->middleware('auth');
Route::get('/single-staysmallsmall-booking/{id}',[App\Http\Controllers\StaySmallSmallBookingsController::class,'singleStaySmallSmallBooking'])->middleware('auth');



