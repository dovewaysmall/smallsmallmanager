<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class LandlordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function allLandlord(){
                
        //landlord
        $responseLandlord = Http::get("https://api.smallsmall.com/api/landlord-api");
        //$responseLandlord->body();
        $allLandlord = $responseLandlord->json();

        return view('allLandlord',['allLandlord'=>$allLandlord]);
    }

    public function addLandlord(){
        return view('addLandlord');
    }

    public function addLandlordSuccess(){
        return view('addLandlordSuccess');

    }
}
