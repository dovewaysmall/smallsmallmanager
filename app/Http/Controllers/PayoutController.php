<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;

class PayoutController extends Controller
{
    public function addPayout(){
        return view('addPayout');
    }

    public function addPayoutSuccess(){
        return view('addPayoutSuccess');
    }

    public function allPayouts(){
                
        //landlord
        $responseAllPayouts = Http::get("https://api.smallsmall.com/api/payout-api");
        //$responseLandlord->body();
        $allPayouts = $responseAllPayouts->json();

        return view('allPayout',['allPayouts'=>$allPayouts]);
    }
}
