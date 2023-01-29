<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        // return "API data";
        $response = Http::get("https://api.smallsmall.com/api/tenant-api");
        $response->body();
        $tenants = $response->json();

        // $tenants = $response->json(['user_type'=>'tenant']);


        //property
        $responseProp = Http::get("https://api.smallsmall.com/api/property-api");
        $responseProp->body();
        $properties = $responseProp->json();
        
        //landlord
        $responseLandlord = Http::get("https://api.smallsmall.com/api/landlord-api");
        $responseLandlord->body();
        $landlords = $responseLandlord->json();

        //Verifications
        $responseVerifications = Http::get("https://api.smallsmall.com/api/verification-api");
        $responseVerifications->body();
        $verifications = $responseVerifications->json();


        //Transactions
        $responseTransactions = Http::get("https://api.smallsmall.com/api/transaction-api");
        $responseTransactions->body();
        $transactions = $responseTransactions->json();

        //Inspections
        $responseInspections = Http::get("https://api.smallsmall.com/api/inspection-api");
        $responseInspections->body();
        $inspections = $responseInspections->json();

        //bookings === real tenants
        $responseBookingsTenants = Http::get("https://api.smallsmall.com/api/booking-distinct-count-api");
        $responseBookingsTenants->body();
        $bookingsTenants = $responseBookingsTenants->json();

        // $properties = $responseProp->json(['user_type'=>'tenant']);

        // foreach($users as $user){
            
        // }
        // $user_count = $users->count();
        // $tenants = $users->where('user_type', 'tenant')->count();

        return view('home',['bookingsTenants'=>$bookingsTenants, 'tenants'=>$tenants, 'properties'=>$properties, 'landlords'=>$landlords, 'verifications'=>$verifications, 'transactions'=>$transactions, 'inspections'=>$inspections]);
    }
}
