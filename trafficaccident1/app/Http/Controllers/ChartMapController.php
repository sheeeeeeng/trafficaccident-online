<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Illuminate\Http\Request;

class ChartMapController extends Controller
{
    public function getdistance($lng1, $lat1, $lng2, $lat2)
    {
        $radLat1 = deg2rad(floatval($lat1));
        $radLat2 = deg2rad(floatval($lat2));
        $radLng1 = deg2rad(floatval($lng1));
        $radLng2 = deg2rad(floatval($lng2));
        $a = $radLat1 - $radLat2;
        $b = $radLng1 - $radLng2;
        $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2))) * 6378.137 * 1000;
        return round($s, 2);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
    public function index()
    {

        $this->date_start = null;
        $this->date_end = null;
        $this->time_start = null;
        $this->time_end = null;
        $this->lat = null;
        $this->lng = null;

        if (request()->filled('filter')) {

            $filters = explode(',', request('filter'));

            foreach ($filters as $filter) {

                [$field, $value] = explode(':', $filter);

                switch ($field) {
                    case 'lat':
                        $this->lat = $value;
                        break;
                    case 'lng':
                        $this->lng = $value;
                        break;
                    case 'date_start':
                        $this->date_start = $value;
                        break;
                    case 'date_end':
                        $this->date_end = $value;
                        break;
                    case 'time_start':
                        $this->time_start = str_replace('-', ':', $value);
                        break;
                    case 'time_end':
                        $this->time_end = str_replace('-', ':', $value);
                        break;
                }

            }
        }

        $ta_id = DB::table('ta_log')
            ->select(
                'ta_log.id',
                'ta_log.serial_number',
                'ta_log.latitude',
                'ta_log.longitude'
            )
            ->whereBetween('ta_log.case_date', array($this->date_start, $this->date_end))
            ->whereBetween('ta_log.case_time', array($this->time_start, $this->time_end))
            ->orderby('ta_log.serial_number')
            ->get();

        $volume = 0;

        $data_id[] = null;

        foreach ($ta_id as $item) {

            if ($item->longitude != null && $item->latitude != null) {

                $distance = $this->getdistance($item->longitude, $item->latitude, $this->lng, $this->lat);

                $item->distance = $distance;

                if ($distance <= 50) {
                    $data_id[] = $item->id;
                    $volume++;
                }

            }

        }

        $hour = [];
        $ta_total = [];
        $patrol_total = [];

        for ($i = 0; $i < 24; $i++) {

            $hour[] = $i;

            $ta_data = DB::table('ta_log')
                ->select(
                    DB::raw('DATE_FORMAT(`ta_log`.`case_time`,"%H") as hour'),
                    DB::raw('count(ta_log.serial_number) AS total')
                )
                ->whereIn('ta_log.id', $data_id)
                ->where(DB::raw('DATE_FORMAT(`ta_log`.`case_time`,"%H")'), '=', $i)
                ->groupby('hour')
                ->orderby('hour')
                 /*where事故權限確認*/
                 ->where('ta_log.case_handle_team','like',$this->Patrolserchpermissioncheck())
                ->get();

            if (count($ta_data) > 0) {
                $ta_total[] = $ta_data[0]->total;
            } else {
                $ta_total[] = 0;
            }

            $patrol_case = 0;

            if (strlen($i) == 1) {
                $insert0 = '0' . $i;
            } else {
                $insert0 = $i;
            }

            $patrol_data = DB::table('ta_patrol')
                ->select(
                    'ta_patrol.id',
                    DB::raw('SUBSTRING_INDEX(ta_patrol.work_time, "-", 1) as start_hour'),
                    DB::raw('SUBSTRING_INDEX(ta_patrol.work_time, "-", -1) as end_hour'),
                    'ta_patrol.longitude',
                    'ta_patrol.team_name',
                    'ta_patrol.latitude'
                )
                ->whereBetween(DB::raw('DATE_FORMAT(ta_patrol.set_date,"%Y-%m-%d")'), array($this->date_start, $this->date_end))
                ->whereBetween(DB::raw($insert0), array(DB::raw('SUBSTRING_INDEX(ta_patrol.work_time, "-", 1)'), DB::raw('SUBSTRING_INDEX(ta_patrol.work_time, "-", -1)')))
                /*where員警權限確認*/
                ->where('ta_patrol.team_name','like',$this->Patrolserchpermissioncheck())
                ->get();

            if (count($patrol_data) > 0) {

                foreach ($patrol_data as $item) {

                    $distance = $this->getdistance($item->longitude, $item->latitude, $this->lng, $this->lat);

                    if ($distance <= 50) {
                        $patrol_case++;
                    }
                }

                $patrol_total[] = $patrol_case;

            } else {
                $patrol_total[] = 0;
            }

        }
        
        return response()->json([
            'volume_50m' => $volume,
            'hour' => $hour,
            'ta_total' => $ta_total,
            'patrol_total' => $patrol_total,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
