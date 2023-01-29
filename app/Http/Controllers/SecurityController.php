<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AllInspectionsExport;
use Illuminate\Support\Facades\Auth;

class SecurityController extends Controller
{
    public function changePassword(){

        return view('changePassword');
    }

    public function saveNewPassword(Request $request){
        $data = array();
        $rawPassword = $request->password;
        if($rawPassword == ''){
            return view('changePassword');
        }else{
            $data['password'] = bcrypt($rawPassword);
            $changePassword = DB::table('users')->where('id', Auth::user()->id)->update($data);
            // return view('changePassword')->with('message', 'Password successfully changed!');
            return redirect()->back(); //view('changePassword')->with('message', 'Password successfully changed!');
        }
        
    }

 
}
