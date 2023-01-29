<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;

class PropertyController extends Controller
{

    public function allProperties(){
                
        //landlord
        $responseProperty = Http::get("https://api.smallsmall.com/api/property-api");
        //$responseLandlord->body();
        $allProperties = $responseProperty->json();

        return view('allProperties',['allProperties'=>$allProperties]);
    }

    public function addProperty(){
        return view('addProperty');
    }

}
