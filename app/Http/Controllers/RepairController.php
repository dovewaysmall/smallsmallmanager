<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;

class RepairController extends Controller
{
    public function reportRepair(){
        return view('reportRepair');
    }

    public function reportRepairSuccess(){
        return view('reportRepairSuccess');
    }
}
