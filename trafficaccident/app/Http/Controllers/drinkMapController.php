<?php

namespace App\Http\Controllers;
use App\Imports\PatrolImport;
use DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Auth;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class drinkMapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData(){
        $data =DB::table('ta_log')
        ->leftJoin('ta_log_rank', 'ta_log.id', '=', 'ta_log_rank.id')
            ->select(
                'ta_log.case_time',
                'ta_log.id',
                'ta_log.serial_number',
                'ta_log.longitude',
                'ta_log.latitude',
                'ta_log.case_handle_team',
                'ta_log_rank.case_is_drunk',
            ) ->when(request()->filled('filter'), function ($query) {
                $filters = explode(',', request('filter'));

                foreach ($filters as $filter) {
                    [$field, $value] = explode(':', $filter);
                    [$start, $end] = explode('~', $value);
                    $query->whereBetween($field, array($start, $end));
                }
            })
            ->where('ta_log.case_handle_team','like',$this->Patrolserchpermissioncheck())
            ->get();
        return response()->json([
            'data' => $data,
        ]);
    }
    public function Patrolserchpermissioncheck(){//搜尋與瀏覽權限檢查
        $usercheck = Auth::user();
        $useremp = $usercheck->employer;
        $useremp = mb_substr($useremp,4,2);//取人員派出所名
        $userbur = $usercheck->burean;//取人員分局名
        $userPL = $usercheck->permission_level;
        if(($userPL[0]==1)||($userPL[0]==0)){
            return "%";
        }
        else if($userPL[0]==2){
            return "%".$userbur."%";
        }
        else if($userPL[0]==3){
            return "%".$userbur.$useremp."%";
        }

    }
}

