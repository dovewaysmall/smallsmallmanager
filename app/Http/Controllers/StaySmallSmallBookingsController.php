<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaySmallSmallBookingsController extends Controller
{
    public function allStayBookings(){
                
        //landlord
        $responseBookings = Http::get("https://api.smallsmall.com/api/staysmallsmall-bookings-api");
        //$responseLandlord->body();
        $staySmallSmallAllBookings = $responseBookings->json();

        return view('staySmallSmallAllBookings',['staySmallSmallAllBookings'=>$staySmallSmallAllBookings]);
    }
    
    public function singleStaySmallSmallBooking($id){
        // $fullname = DB::table('user_tbl')->where('userID',$id)->select('firstName')->get();
        $responseSingleStaySmallSmallBooking = Http::get("https://api.smallsmall.com/api/staysmallsmall-bookings-api/".$id);
        //$responseLandlord->body();
        $singleStaySmallSmallBooking = $responseSingleStaySmallSmallBooking->json();
        
        return view('singleStaySmallSmallBooking', ['singleStaySmallSmallBooking' => $singleStaySmallSmallBooking]);

    }
    
    
}
