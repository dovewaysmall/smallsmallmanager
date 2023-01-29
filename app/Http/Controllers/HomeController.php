<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){
        $role = Auth::user()->role;

        // return "API data";
        // $response = Http::get("https://api.smallsmall.com/api/tenant-api");
        // $response->body();
        // $tenants = $response->json();

        // $tenants = $response->json(['user_type'=>'tenant']);


        //Verifications
        $responseUsersCount = Http::get("https://api.smallsmall.com/staging/api/user-count-api");
        $responseUsersCount->body();
        $usersCount = $responseUsersCount->json();

        //property
        $responseProp = Http::get("https://api.smallsmall.com/staging/api/property-api");
        $responseProp->body();
        $properties = $responseProp->json();
        
        //landlord
        $responseLandlord = Http::get("https://api.smallsmall.com/staging/api/landlord-api");
        $responseLandlord->body();
        $landlords = $responseLandlord->json();

        //Verifications
        $responseVerificationsCount = Http::get("https://api.smallsmall.com/staging/api/verification-count-api");
        $responseVerificationsCount->body();
        $verificationsCount = $responseVerificationsCount->json();


        //Transactions
        $responseTransactionsCount = Http::get("https://api.smallsmall.com/staging/api/transaction-count-api");
        $responseTransactionsCount->body();
        $transactionsCount = $responseTransactionsCount->json();

        //Inspections
        $responseInspectionsCount = Http::get("https://api.smallsmall.com/staging/api/inspection-count-api");
        $responseInspectionsCount->body();
        $inspectionsCount = $responseInspectionsCount->json();

        //bookings === real tenants
        $responseBookingsTenantsCount = Http::get("https://api.smallsmall.com/staging/api/booking-distinct-count-api");
        $responseBookingsTenantsCount->body();
        $bookingsTenantsCount = $responseBookingsTenantsCount->json();

        if($role == '100'){
            return view('admin');
        }else if($role == '1'){
            return view('cx',['usersCount'=>$usersCount,'bookingsTenantsCount'=>$bookingsTenantsCount, 'properties'=>$properties, 'landlords'=>$landlords, 'verificationsCount'=>$verificationsCount, 'transactionsCount'=>$transactionsCount, 'inspectionsCount'=>$inspectionsCount]);
        }else if($role == '2'){
            return view('cxSupervisor',['usersCount'=>$usersCount,'bookingsTenantsCount'=>$bookingsTenantsCount, 'properties'=>$properties, 'landlords'=>$landlords, 'verificationsCount'=>$verificationsCount, 'transactionsCount'=>$transactionsCount, 'inspectionsCount'=>$inspectionsCount]);
        }else if($role == '3'){
            return view('cxAll',['usersCount'=>$usersCount,'bookingsTenantsCount'=>$bookingsTenantsCount, 'properties'=>$properties, 'landlords'=>$landlords, 'verificationsCount'=>$verificationsCount, 'transactionsCount'=>$transactionsCount, 'inspectionsCount'=>$inspectionsCount]);
        }else if($role == '4'){
            return view('fm', ['usersCount'=>$usersCount,'bookingsTenantsCount'=>$bookingsTenantsCount, 'properties'=>$properties, 'landlords'=>$landlords, 'verificationsCount'=>$verificationsCount, 'transactionsCount'=>$transactionsCount, 'inspectionsCount'=>$inspectionsCount]);
        }else if($role == '5'){
            return view('tsr', ['usersCount'=>$usersCount,'bookingsTenantsCount'=>$bookingsTenantsCount, 'properties'=>$properties, 'landlords'=>$landlords, 'verificationsCount'=>$verificationsCount, 'transactionsCount'=>$transactionsCount, 'inspectionsCount'=>$inspectionsCount]);
        }else if($role == '6'){
            return view('cto', ['usersCount'=>$usersCount,'bookingsTenantsCount'=>$bookingsTenantsCount, 'properties'=>$properties, 'landlords'=>$landlords, 'verificationsCount'=>$verificationsCount, 'transactionsCount'=>$transactionsCount, 'inspectionsCount'=>$inspectionsCount]);
        }else if($role == '7'){
            return view('finance', ['usersCount'=>$usersCount,'bookingsTenantsCount'=>$bookingsTenantsCount, 'properties'=>$properties, 'landlords'=>$landlords, 'verificationsCount'=>$verificationsCount, 'transactionsCount'=>$transactionsCount, 'inspectionsCount'=>$inspectionsCount]);
        }else if($role == '11'){
            return view('ceo', ['usersCount'=>$usersCount,'bookingsTenantsCount'=>$bookingsTenantsCount, 'properties'=>$properties, 'landlords'=>$landlords, 'verificationsCount'=>$verificationsCount, 'transactionsCount'=>$transactionsCount, 'inspectionsCount'=>$inspectionsCount]);
        }
    }

    
}
