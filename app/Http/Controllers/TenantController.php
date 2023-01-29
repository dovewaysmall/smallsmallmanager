<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TenantController extends Controller
{
    // public function index(){
    //     // return "API data";
    //     $response = Http::get("https://api.rentsmallsmall.io/api/tenant-api");
    //     $response->body();
    //     $data = $response->json();

    //     // foreach($data as $res){
    //     //     $res_count = $res->count();
    //     // }
    //     return view('tenant',['data'=>$data]);
    // }
    public function allTenants(){
                
        //landlord
        // $responseTenants = Http::get("https://api.smallsmall.com/api/tenant-api");
        $responseTenants = Http::get("https://api.smallsmall.com/api/booking-distinct-tenant-api");
        $responseTenants->body();
        $allTenants = $responseTenants->json();

        return view('allTenants',['allTenants'=>$allTenants]);
    }

    public function addTenant(){
        return view('addTenant');
    }

    public function addTenantSuccess(){
        return view('addTenantSuccess');

    }

    public function tenant($id){
        $responseTenant = Http::get("https://api.smallsmall.com/api/tenant-profile-api/".$id);
        $tenant = $responseTenant->json();

        $responseTenantRentalInfo = Http::get("https://api.smallsmall.com/api/tenant-rental-info/".$id);
        $tenantRentalInfo = $responseTenantRentalInfo->json();

        // $fullname = DB::table('user_tbl')->where('userID',$id)->select('firstName')->get();
        $responseSingleTenant = Http::get("https://api.smallsmall.com/api/tenant-api/".$id);
        //$responseLandlord->body();
        $singleTenant = $responseSingleTenant->json();

        $id = $id;
        $account_manager = $singleTenant[0]['account_manager'];
        // dd($account_manager);

        if($account_manager == ''){
            $account_manager_name = 'Not Assigned';
        }else{
            $responseAccountManagerName = Http::get("https://api.smallsmall.com/api/staffcx-api/".$account_manager);
            $account_manager_info = $responseAccountManagerName->json();
            // dd($account_manager_info);
            $account_manager_name = $account_manager_info[0]['firstName']. ' '.$responseAccountManagerName[0]['lastName'];
        }
        
        
        
        return view('tenant', ['id'=>$id, 'account_manager_name'=>$account_manager_name, 'account_manager'=>$account_manager, 'account_manager_name'=>$account_manager_name,'tenant'=>$tenant, 'tenantRentalInfo'=>$tenantRentalInfo, 'singleTenant' => $singleTenant]);

    }

    public function convertedTenants(){
        $responseConvertedTenants = Http::get("https://api.smallsmall.com/api/tenant-api");
        //$responseLandlord->body();
        $convertedTenants = $responseConvertedTenants->json();

        return view('convertedTenants');
    }

    public function assignAccountManager ($id){
        $responseCX = Http::get("https://api.smallsmall.com/api/usercx-api/");
        //$responseLandlord->body();
        $cx = $responseCX->json();
        // $id = DB::table()

        $responseUser = Http::get("https://api.smallsmall.com/api/user-api/".$id);
        $userID = $responseCX->json();

        return view('assignAccountManager', ['cx'=>$cx, 'userID'=>$userID, 'id'=>$id]);
    }

    public function accountManagerUpdateSuccess(){
        return view('accountManagerUpdateSuccess');
    }

    public function newSubscribersFinance(){
        $responseNewSubscribersFinance = Http::get("https://api.smallsmall.com/api/new-tenants-api");
        //$responseLandlord->body();
        $newSubscribersFinance = $responseNewSubscribersFinance->json();

        return view('newSubscribersFinance', ['newSubscribersFinance'=>$newSubscribersFinance]);
    }

    public function recurringSubscribersFinance(){
        $responseRecurringSubscribersFinance = Http::get("https://api.smallsmall.com/api/new-tenants-api");
        //$responseLandlord->body();
        $recurringSubscribersFinance = $responseRecurringSubscribersFinance->json();

        return view('recurringSubscribersFinance', ['recurringSubscribersFinance'=>$recurringSubscribersFinance]);
    }

    public function newSubscribersFinanceUpdate($id){
        $responseNewSubscribersFinanceUpdate = Http::get("https://api.smallsmall.com/staging/api/new-tenants-api/".$id);
        $newSubscribersFinanceUpdate = $responseNewSubscribersFinanceUpdate->json();

        return view('newSubscribersFinanceUpdate', ['responseNewSubscribersFinanceUpdate'=> $responseNewSubscribersFinanceUpdate]);
    }

    public function subscriptionDueThisMonth(){

        $responseSubscriptionDueThisMonth = Http::get("https://api.smallsmall.com/api/subscription-due-this-month-api");
        //$responseLandlord->body();
        $subscriptionDueThisMonth = $responseSubscriptionDueThisMonth->json();
        return view('subscriptionDueThisMonth', ['subscriptionDueThisMonth'=>$subscriptionDueThisMonth]);
    }
    
}
