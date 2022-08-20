<?php

namespace App\Http\Controllers;

use App\Imports\PatrolImport;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;


class analyzeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

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

    public function getallData(Request $request){ //根據各警局顯示事故件數
        $bur = $request->input('bur');//警局
        $sta = $request->input('sta');//分局
        $strat=strtotime($request->input('strat'));//事故時間    
        $end=strtotime($request->input('end'));//事故時間 
        $latitude=array();//事故緯度 
        $longitude=array();//事故經度
        $case_date=array();//事故時間
        $users = DB::table('ta_log')->get();
        //$this->authorize('isAdmin');
        //$usercheck = Auth::user();

        //權限確認
        //if($this->Permissioncheck($bur,$sta,$usercheck)==true){
            foreach ($users as $user){
                $casedate= strtotime($user->case_date);

                if($casedate>=$strat&&$casedate<=$end){
                    if($user->case_jurisdiction==$bur.$sta || ($sta=="Total" && strpos($user->case_jurisdiction,$bur)!==false)||($bur=="臺東縣警察局全分局")){
                        array_push($latitude, $user->latitude);
                        array_push($longitude, $user->longitude);
                        array_push($case_date, $user->case_date);
                    }
                }
            }
        //}

        $result = count($latitude);//計算事故總筆數
        if($result==0){//如果為0 反值0方便js判斷區間無資料
            array_push($latitude,0);
            array_push($longitude,0);
            array_push($case_date, 0);
            return response()->json([
                'latitude' => $latitude,
                'longitude' => $longitude,
                'colar' => $case_date,
           ]);
        }
        //把事故資料寫入csv
        $array = array();
        $array[] = $case_date;
        $array[] = $latitude;
        $array[] = $longitude;

        $fp = fopen('data/persons.csv', 'w');
        foreach ($array as $fields) {
            fputcsv($fp, $fields);
        }      
        fclose($fp);
       
        //員警資料查詢 
      $postrat=strtotime($request->input('postart'));//員警時間  
      $poend=strtotime($request->input('poend'));//員警時間 
      $pousers = DB::table('ta_patrol')->get();
      $posta = $request->input('postation');//分局
      $polatitude=array();//員警緯度 
      $polongitude=array();//員警經度
      $ponum=array();
      foreach ($pousers as $pousers){
          $set_date= strtotime($pousers->set_date);

          if($set_date>=$postrat&&$set_date<=$poend){
              
              if((strpos($pousers->team_name,$posta)!==false)||($bur=="臺東縣警察局全分局")){
                  array_push($polatitude, $pousers->latitude);
                  array_push($polongitude, $pousers->longitude);
                  array_push($ponum, $pousers->set_date);
              }
          }
      }

      $poresult = count($polatitude);//計算事故總筆數
        if($poresult==0){//如果為0 反值0方便js判斷區間無資料
            array_push($polatitude,1);
            array_push($polongitude,1);
            array_push($ponum, 1);
            return response()->json([
                'latitude' => $polatitude,
                'longitude' => $polongitude,
                'colar' => $ponum,
           ]);
        }
      $poarray = array();
      $poarray[] = $ponum;
      $poarray[] = $polatitude;
      $poarray[] = $polongitude;
      //把員警資料寫入csv
      $fp = fopen('data/police.csv', 'w');
      foreach ($poarray as $fields) {
          fputcsv($fp, $fields);
      }      
      fclose($fp);
      //啟動python
      $python="python";//python
      $ai="/opt/lampp/htdocs/trafficaccident/public/test.py";//啟動檔案放在public底下
      $cty=$strat.$end;//php字串合併a.b
      $lbl=$postrat.$poend;

      //啟動python
      $cmd=$python." ".$ai." ".$cty." ".$lbl." 2>&1";
      $out=null;
      $res=null;
      exec($cmd,$out,$res);
      //dd($out); dd可以看到python的terminal方便測試時使用
      

      //熱點點位
        $dotlatitude=array();//熱點緯度 
        $dotlongitude=array();//熱點經度
        $dotcolar=array();
        $start_row = 2; //define start row
        $i = 1; //define row count flag

        //開啟熱點csv 放入陣列 回傳json格式
        $f1='/opt/lampp/htdocs/trafficaccident/public/data/';
        $f2='dot.csv';
        $check=$f1.$cty.$lbl.$f2;
        $file = fopen($check, "r");
        while (($row = fgetcsv($file)) !== FALSE) {
            if($i >= $start_row) {

                array_push($dotlatitude,$row[0]);
                array_push($dotlongitude, $row[1]);
                array_push($dotcolar, $row[2]);
                //do your stuff
            }
            $i++;
        }
        // close file
        fclose($file);


      return response()->json([
            'latitude' => $dotlatitude,
            'longitude' => $dotlongitude,
            'colar' => $dotcolar,
       ]);
    }

}
