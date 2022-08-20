<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CauseController extends Controller
{
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
        $testtime=strtotime('2020-02-29');
        $causecount=array(0,0,0,0,0,0,0,0,0,0,0);//用來記錄各種肇因事件數
        $users = DB::table('ta_log')->get();

        $temp=0;

        $usercheck = Auth::user();

        if($this->Permissioncheck($bur,$sta,$usercheck)==true){
            foreach ($users as $user)
            {   
                $casedate= strtotime($user->case_date);
                if($casedate>=$strat&&$casedate<=$end){
                    if($user->case_jurisdiction==$bur.$sta || ($sta=="Total" && strpos($user->case_jurisdiction,$bur)!==false)||($bur=="臺東縣警察局全分局")){
                        if($user->case_cause=="未依規定讓車"){
                            $causecount[0]++;
                        }
                        elseif($user->case_cause=="變換車道或方向不當"){
                            $causecount[1]++;
                        }
                        elseif($user->case_cause=="左轉彎未依規定"){
                            $causecount[2]++;
                        }
                        elseif($user->case_cause=="右轉彎未依規定"){
                            $causecount[3]++;
                        }
                        elseif($user->case_cause=="未保持行車安全距離"){
                            $causecount[4]++;
                        }
                        elseif($user->case_cause=="起步未注意其他車(人)安全"){
                            $causecount[5]++;
                        }
                        elseif($user->case_cause=="酒醉(後)駕駛失控"){
                            $causecount[6]++;
                        }
                        elseif($user->case_cause=="未注意車前狀態"){
                            $causecount[7]++;
                        }
                        elseif($user->case_cause=="違反特定標誌(線)禁制"){
                            $causecount[8]++;
                        }
                        elseif($user->case_cause=="其他引起事故之違規或不當行為"){
                            $causecount[9]++;
                        }
                        else{
                            $causecount[10]++;
                        }
                    }
                }
            }
        }
        return response()->json([
            "causecount" => $causecount,
            "strat" => $strat,
            "end" => $end,
            "testtime" => $testtime,
        ]);

    }
}
