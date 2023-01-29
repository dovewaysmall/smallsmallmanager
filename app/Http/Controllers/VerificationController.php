<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function allVerifications(){
                
        //landlord
        $responseVerification = Http::get("https://api.smallsmall.com/api/verification-api");
        //$responseLandlord->body();
        $allVerifications = $responseVerification->json();

        return view('allVerifications',['allVerifications'=>$allVerifications]);
    }

    public function tenantVerification($id){
        $responseTenantVerification = Http::get("https://api.smallsmall.com/api/verification-api/".$id);
        $singleTenantVerifications = $responseTenantVerification->json();
        return view('tenant-verification',['singleTenantVerifications'=>$singleTenantVerifications]);
    }

    public function verificationStatusUpdateSuccess(){
        return view('verificationStatusUpdateSuccess');
    }

    public function verificationStatusUpdateFailed(){
        return view('verificationStatusUpdateFailed');
    }
    
    public function verificationProfile($id){
        // $fullname = DB::table('user_tbl')->where('userID',$id)->select('firstName')->get();
        $responseSingleVerification = Http::get("https://api.smallsmall.com/api/verification-api/".$id);
        //$responseLandlord->body();
        $singleVerification = $responseSingleVerification->json();
        
        return view('verificationProfile', ['singleVerification' => $singleVerification]);

    }
}
