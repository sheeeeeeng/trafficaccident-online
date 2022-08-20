<?php

namespace App\Http\Controllers;

use App\Imports\PatrolImport;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class PatrolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('ta_patrol')
            ->select(
                'ta_patrol.id',
                'ta_patrol.set_date',
                'ta_patrol.work_time',
                'ta_patrol.communication',
                'ta_patrol.police_total',
                'ta_patrol.patrol_content',
                'ta_patrol.method',
                'ta_patrol.longitude',
                'ta_patrol.latitude',
                'ta_patrol.team_name',
                'ta_patrol.police_name',
                'ta_patrol.work_memo',
                'ta_patrol.unit_uploader',
                'ta_patrol.center_uploader',
            )
            ->when(request()->filled('filter'), function ($query) {
                $filters = explode(',', request('filter'));

                foreach ($filters as $filter) {
                    [$field, $value] = explode(':', $filter);

                    switch ($field) {
                        case "set_date":
                            [$start, $end] = explode('~', $value);
                            $query->whereBetween($field, array($start, $end));
                            break;
                        case "id":
                            $column = "ta_team." . $field;
                            $query->where($column, $value);
                            break;
                    }
                }
            })
            ->where( 'ta_patrol.team_name','like',$this->Patrolserchpermissioncheck())
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
    public function Patroluploadpermissioncheck($team_name,$usercheck){//上傳權限檢查
        $useremp = $usercheck->employer;
        $useremp = mb_substr($useremp,4,2);//取人員派出所名
        $userbur = $usercheck->burean;//取人員分局名
        $userPL = $usercheck->permission_level;
        if((($userPL[0]==1)&&($userPL[2]==1))||(($userPL[0]==0)&&($userPL[2]==1))){//PL第一位 1表示總局all 0表示管理員等級瀏覽權限 第三位 1擁有上傳勤務權限(對應瀏覽上限)
            return true;
        }
        else if(($userPL[0]==2)&&($userPL[2]==1)&&strpos($team_name,$userbur) !== false){//PL第一位 2表示XX分局all瀏覽權限 第三位 1擁有上傳勤務權限(對應瀏覽上限)
            return true;
        }
        else if(($userPL[0]==3)&&($userPL[2]==1)&&strpos($team_name,$userbur.$useremp) !== false){//PL第一位 3表示XX派出所all瀏覽權限 第三位 1擁有上傳勤務權限(對應瀏覽上限)
            return true;
        }
        else{
            return false;
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $importData = Excel::toArray(new PatrolImport, $request->file('csv'));

        $method = $request->get('method');

        $csvData = $importData[0];

        $add_volume = 0;
        $pass_volume = 0;
        $pass_volume_noPL = 0;
        $replace_volume = 0;

        $time = null;

        for ($i = 2; $i < count($csvData) - 1; $i++) {

            if ($csvData[$i][8] != null) {

                if (strpos($csvData[$i][2], '~') == true) {
                    $time = str_replace("~", "-", $csvData[$i][2]);
                } elseif (strpos($csvData[$i][2], '～') == true) {
                    $time = str_replace("～", "-", $csvData[$i][2]);
                } else {
                    $time = $csvData[$i][2];
                }

                $check = DB::table('ta_patrol')
                    ->where('ta_patrol.set_date', '=', $csvData[$i][8])
                    ->where('ta_patrol.police_name', '=', $csvData[$i][3])
                    ->where('ta_patrol.work_time', '=', $csvData[$i][2])
                    ->get();

                $usercheck = Auth::user();
                $team=$csvData[$i][1];
                if($this->Patroluploadpermissioncheck($csvData[$i][1],$usercheck)==false){
                        $pass_volume_noPL++;
                }
                else if (count($check) > 0) {

                    if ($method == "pass") {

                        $pass_volume++;

                    } else if ($method == "replace") {

                        DB::table('ta_patrol')
                            ->where('ta_patrol.set_date', '=', $csvData[$i][8])
                            ->where('ta_patrol.police_name', '=', $csvData[$i][3])
                            ->where('ta_patrol.work_time', '=', $csvData[$i][2])
                            ->update([
                                'ta_patrol.set_date' => $csvData[$i][8],
                                'ta_patrol.work_time' => $time,
                                'ta_patrol.communication' => $csvData[$i][0],
                                'ta_patrol.police_total' => $csvData[$i][5],
                                'ta_patrol.patrol_content' => $csvData[$i][6],
                                'ta_patrol.method' => $csvData[$i][4],
                                'ta_patrol.longitude' => $csvData[$i][9],
                                'ta_patrol.latitude' => $csvData[$i][10],
                                'ta_patrol.team_name' => $csvData[$i][1],
                                'ta_patrol.police_name' => $csvData[$i][3],
                                'ta_patrol.work_memo' => $csvData[$i][7],
                                'ta_patrol.unit_uploader' => $csvData[$i][11],
                                'ta_patrol.center_uploader' => $csvData[$i][12],
                            ]
                            );

                        $replace_volume++;

                    }

                } else {

                    DB::table('ta_patrol')->insert([
                        'ta_patrol.set_date' => $csvData[$i][8],
                        'ta_patrol.work_time' => $time,
                        'ta_patrol.communication' => $csvData[$i][0],
                        'ta_patrol.police_total' => $csvData[$i][5],
                        'ta_patrol.patrol_content' => $csvData[$i][6],
                        'ta_patrol.method' => $csvData[$i][4],
                        'ta_patrol.longitude' => $csvData[$i][9],
                        'ta_patrol.latitude' => $csvData[$i][10],
                        'ta_patrol.team_name' => $csvData[$i][1],
                        'ta_patrol.police_name' => $csvData[$i][3],
                        'ta_patrol.work_memo' => $csvData[$i][7],
                        'ta_patrol.unit_uploader' => $csvData[$i][11],
                        'ta_patrol.center_uploader' => $csvData[$i][12],
                    ]
                    );

                    $add_volume++;

                }

            }

        }

        return response()->json([
            'status' => "Success",
            'team'=>$team,
            'method' => $method,
            'add_volume' => $add_volume,
            'pass_volume' => $pass_volume,
            'pass_volume_noPL' => $pass_volume_noPL,
            'replace_volume' => $replace_volume,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = DB::table('ta_patrol')
            ->select(
                'ta_patrol.id',
                'ta_patrol.set_date',
                'ta_patrol.work_time',
                'ta_patrol.communication',
                'ta_patrol.police_total',
                'ta_patrol.patrol_content',
                'ta_patrol.method',
                'ta_patrol.longitude',
                'ta_patrol.latitude',
                'ta_patrol.team_name',
                'ta_patrol.police_name',
                'ta_patrol.work_memo',
                'ta_patrol.unit_uploader',
                'ta_patrol.center_uploader',
            )
            ->where('ta_patrol.id', '=', $id)
            ->get();

        return response()->json([
            'data' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
