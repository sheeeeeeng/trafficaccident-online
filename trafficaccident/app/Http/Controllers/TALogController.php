<?php

namespace App\Http\Controllers;

use App\Imports\TALogImport;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class TALogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('ta_log')
            ->select(
                'ta_log.id',
                'ta_log.serial_number',
                DB::raw('CONCAT(`ta_log`.`case_date`," ",`ta_log`.`case_time`) AS case_datetime'),
                'ta_log.case_township',
                'ta_log.accident_category',
                'ta_log.case_cause',
                'ta_log.longitude',
                'ta_log.latitude',
            )
            ->when(request()->filled('filter'), function ($query) {
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
    public function TAuploadpermissioncheck($handle_team,$usercheck){//上傳權限檢查
        $useremp = $usercheck->employer;
        $useremp = mb_substr($useremp,4,2);//取人員派出所名
        $userbur = $usercheck->burean;
        $userPL = $usercheck->permission_level;
        if((($userPL[0]==1)&&($userPL[1]==1))||(($userPL[0]==0)&&($userPL[1]==1))){//PL第一位 1表示總局all 0表示管理員等級瀏覽權限 第二位 1擁有上傳事故權限(對應瀏覽上限)
            return true;
        }
        else if(($userPL[0]==2)&&($userPL[1]==1)&& strpos($handle_team,$userbur) !== false){//PL第一位 2表示XX分局all瀏覽權限 第二位 1擁有上傳事故權限(對應瀏覽上限)
            return true;
        }
        else if(($userPL[0]==3)&&($userPL[1]==1)&& strpos($handle_team,$userbur.$useremp) !== false){//PL第一位 3表示XX派出所all瀏覽權限 第二位 1擁有上傳事故權限(對應瀏覽上限)
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
        ini_set('max_execution_time', 300);

        DB::table('ta_log_upload_cache')->truncate();

        Excel::import(new TALogImport, $request->file('csv'));

        $method = $request->get('method');

        $case_add_volume = 0;
        $rank_add_volume = 0;

        $case_pass_volume = 0;
        $case_pass_volume_noPL = 0;

        $case_replace_volume = 0;
        $rank_replace_volume = 0;

        $ta_log_cache = DB::table('ta_log_upload_cache')
            ->select(
                'ta_log_upload_cache.serial_number',
                'ta_log_upload_cache.case_date',
                'ta_log_upload_cache.case_time',
                'ta_log_upload_cache.longitude',
                'ta_log_upload_cache.latitude',
                'ta_log_upload_cache.accident_category',
                'ta_log_upload_cache.case_county',
                'ta_log_upload_cache.case_township',
                'ta_log_upload_cache.case_village',
                'ta_log_upload_cache.case_neighborhood',
                'ta_log_upload_cache.case_road',
                'ta_log_upload_cache.case_section',
                'ta_log_upload_cache.case_lane',
                'ta_log_upload_cache.case_number',
                'ta_log_upload_cache.case_intersection_road',
                'ta_log_upload_cache.case_intersection_lane',
                'ta_log_upload_cache.case_other',
                'ta_log_upload_cache.case_highway_category',
                'ta_log_upload_cache.case_highway_name',
                'ta_log_upload_cache.case_highway_kilometers',
                'ta_log_upload_cache.case_highway_meter',
                'ta_log_upload_cache.case_jurisdiction',
                'ta_log_upload_cache.case_handle_team',
                'ta_log_upload_cache.case_24h_death',
                'ta_log_upload_cache.case_30d_death',
                'ta_log_upload_cache.case_injuries',
                'ta_log_upload_cache.case_accident_type_parent',
                'ta_log_upload_cache.case_accident_type_child',
                'ta_log_upload_cache.case_cause'
            )
            ->groupby(
                'ta_log_upload_cache.serial_number',
                'ta_log_upload_cache.case_date',
                'ta_log_upload_cache.case_time',
                'ta_log_upload_cache.longitude',
                'ta_log_upload_cache.latitude',
                'ta_log_upload_cache.accident_category',
                'ta_log_upload_cache.case_county',
                'ta_log_upload_cache.case_township',
                'ta_log_upload_cache.case_village',
                'ta_log_upload_cache.case_neighborhood',
                'ta_log_upload_cache.case_road',
                'ta_log_upload_cache.case_section',
                'ta_log_upload_cache.case_lane',
                'ta_log_upload_cache.case_number',
                'ta_log_upload_cache.case_intersection_road',
                'ta_log_upload_cache.case_intersection_lane',
                'ta_log_upload_cache.case_other',
                'ta_log_upload_cache.case_highway_category',
                'ta_log_upload_cache.case_highway_name',
                'ta_log_upload_cache.case_highway_kilometers',
                'ta_log_upload_cache.case_highway_meter',
                'ta_log_upload_cache.case_jurisdiction',
                'ta_log_upload_cache.case_handle_team',
                'ta_log_upload_cache.case_24h_death',
                'ta_log_upload_cache.case_30d_death',
                'ta_log_upload_cache.case_injuries',
                'ta_log_upload_cache.case_accident_type_parent',
                'ta_log_upload_cache.case_accident_type_child',
                'ta_log_upload_cache.case_cause')
            ->get();

        foreach ($ta_log_cache as $item) {

            $check = DB::table('ta_log')
                ->where('ta_log.serial_number', '=', $item->serial_number)
                ->get();

            $usercheck = Auth::user();

            if($this->TAuploadpermissioncheck($item->case_handle_team,$usercheck)==false){
                $case_pass_volume_noPL++;
            }
            else if (count($check) > 0) {

                if ($method == "pass") {

                    $case_pass_volume++;

                } else if ($method == "replace") {

                    DB::table('ta_log')
                        ->where('ta_log.serial_number', '=', $item->serial_number)
                        ->update([
                            'ta_log.serial_number' => $item->serial_number,
                            'ta_log.case_date' => $item->case_date,
                            'ta_log.case_time' => $item->case_time,
                            'ta_log.longitude' => $item->longitude,
                            'ta_log.latitude' => $item->latitude,
                            'ta_log.accident_category' => $item->accident_category,
                            'ta_log.case_county' => $item->case_county,
                            'ta_log.case_township' => $item->case_township,
                            'ta_log.case_village' => $item->case_village,
                            'ta_log.case_neighborhood' => $item->case_neighborhood,
                            'ta_log.case_road' => $item->case_road,
                            'ta_log.case_section' => $item->case_section,
                            'ta_log.case_lane' => $item->case_lane,
                            'ta_log.case_number' => $item->case_number,
                            'ta_log.case_intersection_road' => $item->case_intersection_road,
                            'ta_log.case_intersection_lane' => $item->case_intersection_lane,
                            'ta_log.case_other' => $item->case_other,
                            'ta_log.case_highway_category' => $item->case_highway_category,
                            'ta_log.case_highway_name' => $item->case_highway_name,
                            'ta_log.case_highway_kilometers' => $item->case_highway_kilometers,
                            'ta_log.case_highway_meter' => $item->case_highway_meter,
                            'ta_log.case_jurisdiction' => $item->case_jurisdiction,
                            'ta_log.case_handle_team' => $item->case_handle_team,
                            'ta_log.case_24h_death' => $item->case_24h_death,
                            'ta_log.case_30d_death' => $item->case_30d_death,
                            'ta_log.case_injuries' => $item->case_injuries,
                            'ta_log.case_accident_type_parent' => $item->case_accident_type_parent,
                            'ta_log.case_accident_type_child' => $item->case_accident_type_child,
                            'ta_log.case_cause' => $item->case_cause,
                        ]);

                    $case_replace_volume++;

                    $rank_data = DB::table('ta_log_upload_cache')
                        ->select(
                            'ta_log_upload_cache.case_rank',
                            'ta_log_upload_cache.case_rank_age',
                            'ta_log_upload_cache.case_car_type',
                            'ta_log_upload_cache.case_is_drunk',
                        )
                        ->where('ta_log_upload_cache.serial_number', '=', $item->serial_number)
                        ->orderby('ta_log_upload_cache.case_rank')
                        ->get();

                    foreach ($rank_data as $rank_item) {

                        DB::table('ta_log_rank')
                            ->where('ta_log_rank.serial_number_id', '=', $check[0]->id)
                            ->where('ta_log_rank.case_rank', '=', $rank_item->case_rank)
                            ->updateOrInsert([
                                'ta_log_rank.serial_number_id' => $check[0]->id,
                                'ta_log_rank.case_rank' => $rank_item->case_rank,
                                'ta_log_rank.case_rank_age' => $rank_item->case_rank_age,
                                'ta_log_rank.case_car_type' => $rank_item->case_car_type,
                                'ta_log_rank.case_is_drunk' => $rank_item->case_is_drunk,
                            ]);

                        $rank_replace_volume++;

                    }

                }

            } else {

                $serial_number_id = DB::table('ta_log')
                    ->insertGetId([
                        'ta_log.serial_number' => $item->serial_number,
                        'ta_log.case_date' => $item->case_date,
                        'ta_log.case_time' => $item->case_time,
                        'ta_log.longitude' => $item->longitude,
                        'ta_log.latitude' => $item->latitude,
                        'ta_log.accident_category' => $item->accident_category,
                        'ta_log.case_county' => $item->case_county,
                        'ta_log.case_township' => $item->case_township,
                        'ta_log.case_village' => $item->case_village,
                        'ta_log.case_neighborhood' => $item->case_neighborhood,
                        'ta_log.case_road' => $item->case_road,
                        'ta_log.case_section' => $item->case_section,
                        'ta_log.case_lane' => $item->case_lane,
                        'ta_log.case_number' => $item->case_number,
                        'ta_log.case_intersection_road' => $item->case_intersection_road,
                        'ta_log.case_intersection_lane' => $item->case_intersection_lane,
                        'ta_log.case_other' => $item->case_other,
                        'ta_log.case_highway_category' => $item->case_highway_category,
                        'ta_log.case_highway_name' => $item->case_highway_name,
                        'ta_log.case_highway_kilometers' => $item->case_highway_kilometers,
                        'ta_log.case_highway_meter' => $item->case_highway_meter,
                        'ta_log.case_jurisdiction' => $item->case_jurisdiction,
                        'ta_log.case_handle_team' => $item->case_handle_team,
                        'ta_log.case_24h_death' => $item->case_24h_death,
                        'ta_log.case_30d_death' => $item->case_30d_death,
                        'ta_log.case_injuries' => $item->case_injuries,
                        'ta_log.case_accident_type_parent' => $item->case_accident_type_parent,
                        'ta_log.case_accident_type_child' => $item->case_accident_type_child,
                        'ta_log.case_cause' => $item->case_cause,
                    ]);

                $case_add_volume++;

                $rank_data = DB::table('ta_log_upload_cache')
                    ->select(
                        'ta_log_upload_cache.case_rank',
                        'ta_log_upload_cache.case_rank_age',
                        'ta_log_upload_cache.case_car_type',
                        'ta_log_upload_cache.case_is_drunk',
                    )
                    ->where('ta_log_upload_cache.serial_number', '=', $item->serial_number)
                    ->orderby('ta_log_upload_cache.case_rank')
                    ->get();

                foreach ($rank_data as $rank_item) {

                    DB::table('ta_log_rank')
                        ->insert([
                            'ta_log_rank.serial_number_id' => $serial_number_id,
                            'ta_log_rank.case_rank' => $rank_item->case_rank,
                            'ta_log_rank.case_rank_age' => $rank_item->case_rank_age,
                            'ta_log_rank.case_car_type' => $rank_item->case_car_type,
                            'ta_log_rank.case_is_drunk' => $rank_item->case_is_drunk,
                        ]);

                    $rank_add_volume++;

                }

            }

        }

        return response()->json([
            'handltram' => $item->case_handle_team,
            'status' => "Success",
            'method' => $method,
            'case_add_volume' => $case_add_volume,
            'rank_add_volume' => $rank_add_volume,
            'case_pass_volume' => $case_pass_volume,
            'case_pass_volume_noPL' => $case_pass_volume_noPL,
            'case_replace_volume' => $case_replace_volume,
            'rank_replace_volume' => $rank_replace_volume,
        ]);
    }

    public function show($id)
    {
        $data = DB::table('ta_log')
            ->select(
                'ta_log.id',
                'ta_log.serial_number',
                'ta_log.case_date',
                DB::raw('DATE_FORMAT(CONCAT(`ta_log`.`case_date`," ",`ta_log`.`case_time`),"%Y-%m-%d %H:%i") AS case_datetime'),
                'ta_log.longitude',
                'ta_log.latitude',
                'ta_log.accident_category',
                'ta_log.case_county',
                'ta_log.case_township',
                'ta_log.case_village',
                'ta_log.case_neighborhood',
                'ta_log.case_road',
                'ta_log.case_section',
                'ta_log.case_lane',
                'ta_log.case_number',
                'ta_log.case_intersection_road',
                'ta_log.case_intersection_lane',
                'ta_log.case_other',
                'ta_log.case_highway_category',
                'ta_log.case_highway_name',
                'ta_log.case_highway_kilometers',
                'ta_log.case_highway_meter',
                'ta_log.case_jurisdiction',
                'ta_log.case_handle_team',
                'ta_log.case_24h_death',
                'ta_log.case_30d_death',
                'ta_log.case_injuries',
                'ta_log.case_accident_type_parent',
                'ta_log.case_accident_type_child',
                'ta_log.case_cause',
                DB::raw('NULL AS case_rank_data')
            )
            ->where('ta_log.id', '=', $id)
            ->get();

        $rank_data = DB::table('ta_log_rank')
            ->select(
                'ta_log_rank.case_rank',
                'ta_log_rank.case_rank_age',
                'ta_log_rank.case_car_type',
                'ta_log_rank.case_is_drunk',
            )
            ->where('ta_log_rank.serial_number_id', '=', $data[0]->id)
            ->orderby('ta_log_rank.id')
            ->get();

        $data[0]->case_rank_data = $rank_data;

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
