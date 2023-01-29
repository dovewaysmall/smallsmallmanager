<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
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
    public function allUsers(){
                
        //landlord
        $responseUsers = Http::get("https://api.smallsmall.com/api/user-api");
        //$responseLandlord->body();
        $allUsers = $responseUsers->json();

        return view('allUsers',['allUsers'=>$allUsers]);
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
        
        return view('pages.tenant', ['tenant'=>$tenant, 'tenantRentalInfo'=>$tenantRentalInfo, 'singleTenant' => $singleTenant]);

    }

}
