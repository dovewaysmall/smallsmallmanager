<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InspectionController extends Controller
{
    public function allInspections(){
                
        //landlord
        $responseInspection = Http::get("https://api.smallsmall.com/api/inspection-api");
        //$responseLandlord->body();
        $allInspections = $responseInspection->json();

        return view('allInspections',['allInspections'=>$allInspections]);
    }
    
    public function completedInspections(){
                
        //landlord
        $responseCompletedInspection = Http::get("https://api.smallsmall.com/api/inspection-api");
        //$responseLandlord->body();
        $completedInspections = $responseCompletedInspection->json();

        return view('completedInspections',['completedInspections'=>$completedInspections]);
    }

    public function canceledInspections(){
                
        //landlord
        $responseCanceledInspection = Http::get("https://api.smallsmall.com/api/inspection-api");
        //$responseLandlord->body();
        $canceledInspections = $responseCanceledInspection->json();

        return view('canceledInspections',['canceledInspections'=>$canceledInspections]);
    }

    // public function allInspectionsTSR(){
                
    //     //landlord
    //     $responseInspectionTSR = Http::get("https://api.smallsmall.com/api/inspectiontsr-api");
    //     //$responseLandlord->body();
    //     $allInspectionsTSR = $responseInspectionTSR->json();

    //     return view('allInspectionsTSR',['allInspectionsTSR'=>$allInspectionsTSR]);
    // }

    public function allInspectionsTSR(){
                
        //landlord
        $responseInspectionTSR = Http::get("https://api.smallsmall.com/api/inspection-api");
        //$responseLandlord->body();
        $allInspectionsTSR = $responseInspectionTSR->json();

        return view('allInspectionsTSR',['allInspectionsTSR'=>$allInspectionsTSR]);
    }
    
    public function singleInspection($id){
        // $fullname = DB::table('user_tbl')->where('userID',$id)->select('firstName')->get();
        $responseSingleInspection = Http::get("https://api.smallsmall.com/api/inspection-api/".$id);
        //$responseLandlord->body();
        $singleInspection = $responseSingleInspection->json();

        $responseStaffTSR = Http::get("https://api.smallsmall.com/api/stafftsr-api");
        //$responseLandlord->body();
        $allStaffTSR = $responseStaffTSR->json();
        
        return view('singleInspection', ['singleInspection' => $singleInspection, 'allStaffTSR'=>$allStaffTSR]);

    }

    public function allPendingInspectionsTSR(){
                
        //landlord
        $responsePendingInspectionTSR = Http::get("https://api.smallsmall.com/api/inspection-api");
        //$responseLandlord->body();
        $allPendingInspectionsTSR = $responsePendingInspectionTSR->json();

        return view('allPendingInspectionsTSR',['allPendingInspectionsTSR'=>$allPendingInspectionsTSR]);
    }

    public function allCompletedInspectionsTSR(){
                
        //landlord
        $responseCompletedInspectionTSR = Http::get("https://api.smallsmall.com/api/inspection-api");
        //$responseLandlord->body();
        $allCompletedInspectionsTSR = $responseCompletedInspectionTSR->json();

        return view('allCompletedInspectionsTSR',['allCompletedInspectionsTSR'=>$allCompletedInspectionsTSR]);
    }

    public function allCanceledInspectionsTSR(){
                
        //landlord
        $responseCanceledInspectionTSR = Http::get("https://api.smallsmall.com/api/inspection-api");
        //$responseLandlord->body();
        $allCanceledInspectionsTSR = $responseCanceledInspectionTSR->json();

        return view('allCanceledInspectionsTSR',['allCanceledInspectionsTSR'=>$allCanceledInspectionsTSR]);
    }

    public function inspection($id){
        // $fullname = DB::table('user_tbl')->where('userID',$id)->select('firstName')->get();
        $responseSingleInspection = Http::get("https://api.smallsmall.com/api/inspection-api/".$id);
        //$responseLandlord->body();
        $singleInspection = $responseSingleInspection->json();

        $responseStaffTSR = Http::get("https://api.smallsmall.com/api/stafftsr-api");
        //$responseLandlord->body();
        $allStaffTSR = $responseStaffTSR->json();
        
        return view('inspection', ['singleInspection' => $singleInspection, 'allStaffTSR'=>$allStaffTSR]);

    }

    public function pendingInspection($id){
        // $fullname = DB::table('user_tbl')->where('userID',$id)->select('firstName')->get();
        $responseSinglePendingInspection = Http::get("https://api.smallsmall.com/api/inspection-api/".$id);
        //$responseLandlord->body();
        $singlePendingInspection = $responseSinglePendingInspection->json();
        
        return view('pending-inspection', ['singlePendingInspection' => $singlePendingInspection]);

    }

    public function inspectionsThisMonth(){
                
        //$currentMonth = date('m');
        //landlord
        $responseInspectionsThisMonth = Http::get("https://api.smallsmall.com/api/inspections-this-month-api");
        //$responseLandlord->body();
        $inspectionsThisMonth = $responseInspectionsThisMonth->json();

        return view('inspectionsThisMonth',['inspectionsThisMonth'=>$inspectionsThisMonth]);
    }
    

    public function inspectionsLastMonth(){
                
        //$currentMonth = date('m');
        //landlord
        $responseInspectionsLastMonth = Http::get("https://api.smallsmall.com/api/inspections-last-month-api");
        //$responseLandlord->body();
        $inspectionsLastMonth = $responseInspectionsLastMonth->json();

        return view('inspectionsLastMonth',['inspectionsLastMonth'=>$inspectionsLastMonth]);
    }
    
    public function completedInspectionsThisMonth(){
                
        //$currentMonth = date('m');
        //landlord
        $responseCompletedInspectionsThisMonth = Http::get("https://api.smallsmall.com/api/inspections-this-month-api");
        //$responseLandlord->body();
        $completedInspectionsThisMonth = $responseCompletedInspectionsThisMonth->json();

        return view('completedInspectionsThisMonth',['completedInspectionsThisMonth'=>$completedInspectionsThisMonth]);
    }
    
    public function completedInspectionsLastMonth(){
                
        //$currentMonth = date('m');
        //landlord
        $responseCompletedInspectionsLastMonth = Http::get("https://api.smallsmall.com/api/inspections-last-month-api");
        //$responseLandlord->body();
        $completedInspectionsLastMonth = $responseCompletedInspectionsLastMonth->json();

        return view('completedInspectionsLastMonth',['completedInspectionsLastMonth'=>$completedInspectionsLastMonth]);
    }
    
    public function canceledInspectionsThisMonth(){
                
        //$currentMonth = date('m');
        //landlord
        $responseCanceledInspectionsThisMonth = Http::get("https://api.smallsmall.com/api/inspections-this-month-api");
        //$responseLandlord->body();
        $canceledInspectionsThisMonth = $responseCanceledInspectionsThisMonth->json();

        return view('canceledInspectionsThisMonth',['canceledInspectionsThisMonth'=>$canceledInspectionsThisMonth]);
    }

    public function canceledInspectionsLastMonth(){
                
        //$currentMonth = date('m');
        //landlord
        $responseCanceledInspectionsLastMonth = Http::get("https://api.smallsmall.com/api/inspections-last-month-api");
        //$responseLandlord->body();
        $canceledInspectionsLastMonth = $responseCanceledInspectionsLastMonth->json();

        return view('canceledInspectionsLastMonth',['canceledInspectionsLastMonth'=>$canceledInspectionsLastMonth]);
    }
    
    public function assignedInspections(){
                
        //$currentMonth = date('m');
        //landlord
        $responseAssignedInspections = Http::get("https://api.smallsmall.com/api/inspection-api");
        //$responseLandlord->body();
        $assignedInspections = $responseAssignedInspections->json();

        return view('assignedInspections',['assignedInspections'=>$assignedInspections]);
    }
    

    public function inspectionUpdateSuccess(){
        return view('inspectionUpdateSuccess');
    }

    public function inspectionStatusUpdateSuccess(){
        return view('inspectionStatusUpdateSuccess');
    }

    public function inspectionStatusUpdateFailed(){
        return view('inspectionStatusUpdateFailed');
    }

    public function inspectionUpdateFailed(){
        return view('inspectionUpdateFailed');
    }

    // public function inspectionFeedbackCX(){
    //     return view('inspectionFeedbackCX ');
    // }
    
    public function inspectionPostInspecFeedbackSuccess(){
        return view('inspectionPostInspecFeedbackSuccess');
    }
    
    public function inspectionPostInspecFeedbackFailed(){
        return view('inspectionPostInspecFeedbackFailed');
    }
    
    public function inspectionFeedbackCX($id){
        // $fullname = DB::table('user_tbl')->where('userID',$id)->select('firstName')->get();
        $responseSinglePendingInspection = Http::get("https://api.smallsmall.com/api/inspection-api/".$id);
        //$responseLandlord->body();
        $singleInspectionFeedback = $responseSinglePendingInspection->json();
        
        return view('singleInspectionFeedback', ['singleInspectionFeedback' => $singleInspectionFeedback]);

    }
    
    public function allBuyInspections(){
        //landlord
        $responseBuyInspection = Http::get("https://api.smallsmall.com/api/buy-inspection-api/");
        //$responseLandlord->body();
        $allBuyInspections = $responseBuyInspection->json();

        return view('allBuyInspections',['allBuyInspections'=>$allBuyInspections]);
    }
    
    public function singleBuyInspection($id){
        // $fullname = DB::table('user_tbl')->where('userID',$id)->select('firstName')->get();
        $responseSingleInspection = Http::get("https://api.smallsmall.com/api/buy-inspection-api/".$id);
        //$responseLandlord->body();
        $singleBuyInspection = $responseSingleInspection->json();

        // $responseStaffTSR = Http::get("https://api.smallsmall.com/api/stafftsr-api");
        // $allStaffTSR = $responseStaffTSR->json();
        
        return view('singleBuyInspection', ['singleBuyInspection' => $singleBuyInspection]);

    }

    
    
}
