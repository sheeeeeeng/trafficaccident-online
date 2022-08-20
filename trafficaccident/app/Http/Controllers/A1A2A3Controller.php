<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Http\Request;

class A1A2A3Controller extends Controller
{
    //
    public function Permissioncheck($bur,$sta,$usercheck){//權限確認
        $userbur = $usercheck->burean;
        $useremp = $usercheck->employer;
        $userPL = $usercheck->permission_level;
        if(($userPL[0]==1)||($userPL[0]==0)){ //第一位是1 總局all權限 0 管理員權限
            return true;
        }
        else if($userPL[0]==2){ //第一位是2 XX分局all權限
            $serchbur = mb_substr($bur,6,2);//取選項分局名
            $userbur = mb_substr($userbur,0,2);//取人員分局名
            if($serchbur==$userbur){
                return true;
            }
            else{
                return false;
            }
        }
        else if($userPL[0]==3){//第一位是3 XX派出所all權限
            $serchbur = mb_substr($bur,6,2);//取選項分局名
            $serchsta = mb_substr($sta,0,2);//取選項派出所名
            $userbur = mb_substr($userbur,0,2);//取人員分局名
            $useremp = mb_substr($useremp,4,2);//取人員派出所名
            if(($serchbur==$userbur)&&($serchsta==$useremp)){
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }
    public function getData(Request $request){
        $bur = $request->input('bur');
        $sta = $request->input('sta');
        $strat=strtotime($request->input('strat'));    
        $end=strtotime($request->input('end'));
        $users = DB::table('ta_log')->get();
        $A1count=array(0,0,0,0,0,0,0,0,0,0,0,0);//紀錄各級別事件此年度的數量
        $A2count=array(0,0,0,0,0,0,0,0,0,0,0,0);
        $A3count=array(0,0,0,0,0,0,0,0,0,0,0,0);

        //$this->authorize('isAdmin');
        $usercheck = Auth::user();

        //權限確認
        if($this->Permissioncheck($bur,$sta,$usercheck)==true){
            foreach ($users as $user)
            {
                $casedatemonth = explode("-",$user->case_date);
                $casedate= strtotime($user->case_date);
                if($casedate>=$strat&&$casedate<=$end){
                    if($user->case_handle_team==$bur.$sta || ($sta=="Total" && strpos($user->case_handle_team,$bur)!==false)||($bur=="臺東縣警察局全分局")){
                        if($user->accident_category=="A1"){
                            if($casedatemonth[1]=="01"){
                                $A1count[0]++;
                            }
                            else if($casedatemonth[1]=="02"){
                                $A1count[1]++;
                            }
                            else if($casedatemonth[1]=="03"){
                                $A1count[2]++;
                            }
                            else if($casedatemonth[1]=="04"){
                                $A1count[3]++;
                            }
                            else if($casedatemonth[1]=="05"){
                                $A1count[4]++;
                            }
                            else if($casedatemonth[1]=="06"){
                                $A1count[5]++;
                            }
                            else if($casedatemonth[1]=="07"){
                                $A1count[6]++;
                            }
                            else if($casedatemonth[1]=="08"){
                                $A1count[7]++;
                            }
                            else if($casedatemonth[1]=="09"){
                                $A1count[8]++;
                            }
                            else if($casedatemonth[1]=="10"){
                                $A1count[9]++;
                            }
                            else if($casedatemonth[1]=="11"){
                                $A1count[10]++;
                            }
                            else if($casedatemonth[1]=="12"){
                                $A1count[11]++;
                            }
                        }
                        else if($user->accident_category=="A2"){
                            if($casedatemonth[1]=="01"){
                                $A2count[0]++;
                            }
                            else if($casedatemonth[1]=="02"){
                                $A2count[1]++;
                            }
                            else if($casedatemonth[1]=="03"){
                                $A2count[2]++;
                            }
                            else if($casedatemonth[1]=="04"){
                                $A2count[3]++;
                            }
                            else if($casedatemonth[1]=="05"){
                                $A2count[4]++;
                            }
                            else if($casedatemonth[1]=="06"){
                                $A2count[5]++;
                            }
                            else if($casedatemonth[1]=="07"){
                                $A2count[6]++;
                            }
                            else if($casedatemonth[1]=="08"){
                                $A2count[7]++;
                            }
                            else if($casedatemonth[1]=="09"){
                                $A2count[8]++;
                            }
                            else if($casedatemonth[1]=="10"){
                                $A2count[9]++;
                            }
                            else if($casedatemonth[1]=="11"){
                                $A2count[10]++;
                            }
                            else if($casedatemonth[1]=="12"){
                                $A2count[11]++;
                            }
                        }
                        else if($user->accident_category=="A3"){
                            if($casedatemonth[1]=="01"){
                                $A3count[0]++;
                            }
                            else if($casedatemonth[1]=="02"){
                                $A3count[1]++;
                            }
                            else if($casedatemonth[1]=="03"){
                                $A3count[2]++;
                            }
                            else if($casedatemonth[1]=="04"){
                                $A3count[3]++;
                            }
                            else if($casedatemonth[1]=="05"){
                                $A3count[4]++;
                            }
                            else if($casedatemonth[1]=="06"){
                                $A3count[5]++;
                            }
                            else if($casedatemonth[1]=="07"){
                                $A3count[6]++;
                            }
                            else if($casedatemonth[1]=="08"){
                                $A3count[7]++;
                            }
                            else if($casedatemonth[1]=="09"){
                                $A3count[8]++;
                            }
                            else if($casedatemonth[1]=="10"){
                                $A3count[9]++;
                            }
                            else if($casedatemonth[1]=="11"){
                                $A3count[10]++;
                            }
                            else if($casedatemonth[1]=="12"){
                                $A3count[11]++;
                            }
                        }
                    }
                }
            }
        }
        return response()->json([
            "A1count" => $A1count,
            "A2count" => $A2count,
            "A3count" => $A3count
        ]);
    }
    
}



