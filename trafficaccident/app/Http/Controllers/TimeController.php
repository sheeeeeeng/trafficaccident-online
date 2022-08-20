<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TimeController extends Controller
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
        else if($userPL[0]==3){//第一位是2 XX派出所all權限
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
        $timearray=array(0,0,0,0,0,0,0,0,0,0,0,0);//用來記錄派出所各時段案件數
        $users = DB::table('ta_log')->get();

        $usercheck = Auth::user();
        if($this->Permissioncheck($bur,$sta,$usercheck)==true){
            foreach($users as $user){
                $casedate= strtotime($user->case_date);
                if($casedate>=$strat&&$casedate<=$end){
                    if($user->case_jurisdiction==$bur.$sta|| ($sta=="Total" && strpos($user->case_jurisdiction,$bur)!==false)||($bur=="臺東縣警察局全分局")){
                        $casetime= strtotime($user->case_time);
                        if(strtotime("00:00:00")<=$casetime && strtotime("01:59:59")>=$casetime){
                            $timearray[0]++;
                        }
                        else if(strtotime("02:00:00")<=$casetime && strtotime("03:59:59")>=$casetime){
                            $timearray[1]++;
                        }
                        else if(strtotime("04:00:00")<=$casetime && strtotime("05:59:59")>=$casetime){
                            $timearray[2]++;
                        }
                        else if(strtotime("06:00:00")<=$casetime && strtotime("07:59:59")>=$casetime){
                            $timearray[3]++;
                        }
                        else if(strtotime("08:00:00")<=$casetime && strtotime("09:59:59")>=$casetime){
                            $timearray[4]++;
                        }
                        else if(strtotime("10:00:00")<=$casetime && strtotime("11:59:59")>=$casetime){
                            $timearray[5]++;
                        }
                        else if(strtotime("12:00:00")<=$casetime && strtotime("13:59:59")>=$casetime){
                            $timearray[6]++;
                        }
                        else if(strtotime("14:00:00")<=$casetime && strtotime("15:59:59")>=$casetime){
                            $timearray[7]++;
                        }
                        else if(strtotime("16:00:00")<=$casetime && strtotime("17:59:59")>=$casetime){
                            $timearray[8]++;
                        }
                        else if(strtotime("18:00:00")<=$casetime && strtotime("19:59:59")>=$casetime){
                            $timearray[9]++;
                        }
                        else if(strtotime("20:00:00")<=$casetime && strtotime("21:59:59")>=$casetime){
                            $timearray[10]++;
                        }
                        else if(strtotime("22:00:00")<=$casetime && strtotime("23:59:59")>=$casetime){
                            $timearray[11]++;
                        }
                    }
                }
            }
        }
        return response()->json([
            "timearray" => $timearray,
        ]);
    }
}
