<?php

namespace App\Imports;

use DB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;

class TALogImport implements ToCollection, WithBatchInserts, WithChunkReading, WithStartRow
{
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            $this->createData($row);
        }
    }

    public function createData($rows)
    {
        $h = 0;
        $m = 0;
        $s = 0;

        if (strlen($rows[2]) == 5) {

            $h = substr($rows[2], 0, 1);
            $m = substr($rows[2], 1, 2);
            $s = substr($rows[2], 3, 2);

        } else if (strlen($rows[2]) == 6) {

            $h = substr($rows[2], 0, 2);
            $m = substr($rows[2], 2, 2);
            $s = substr($rows[2], 4, 2);

        }

        $case_time = $h . ':' . $m . ':' . $s;

        DB::table('ta_log_upload_cache')
            ->insert([
                'ta_log_upload_cache.serial_number' => $rows[0],
                'ta_log_upload_cache.case_date' => date('Y-m-d', strtotime($rows[1])),
                'ta_log_upload_cache.case_time' => date('H:i:s', strtotime($case_time)),
                'ta_log_upload_cache.longitude' => $rows[3],
                'ta_log_upload_cache.latitude' => $rows[4],
                'ta_log_upload_cache.accident_category' => $rows[5],
                'ta_log_upload_cache.case_county' => $rows[6],
                'ta_log_upload_cache.case_township' => $rows[7],
                'ta_log_upload_cache.case_village' => $rows[8],
                'ta_log_upload_cache.case_neighborhood' => $rows[9],
                'ta_log_upload_cache.case_road' => $rows[10],
                'ta_log_upload_cache.case_section' => $rows[11],
                'ta_log_upload_cache.case_lane' => $rows[12],
                'ta_log_upload_cache.case_number' => $rows[13],
                'ta_log_upload_cache.case_intersection_road' => $rows[14],
                'ta_log_upload_cache.case_intersection_lane' => $rows[15],
                'ta_log_upload_cache.case_other' => $rows[16],
                'ta_log_upload_cache.case_highway_category' => $rows[17],
                'ta_log_upload_cache.case_highway_name' => $rows[18],
                'ta_log_upload_cache.case_highway_kilometers' => $rows[19],
                'ta_log_upload_cache.case_highway_meter' => $rows[20],
                'ta_log_upload_cache.case_jurisdiction' => $rows[21],
                'ta_log_upload_cache.case_handle_team' => $rows[22],
                'ta_log_upload_cache.case_24h_death' => $rows[23],
                'ta_log_upload_cache.case_30d_death' => $rows[24],
                'ta_log_upload_cache.case_injuries' => $rows[25],
                'ta_log_upload_cache.case_accident_type_parent' => $rows[26],
                'ta_log_upload_cache.case_accident_type_child' => $rows[27],
                'ta_log_upload_cache.case_cause' => $rows[28],
                'ta_log_upload_cache.case_rank' => $rows[29],
                'ta_log_upload_cache.case_rank_age' => $rows[30],
                'ta_log_upload_cache.case_car_type' => $rows[31],
                'ta_log_upload_cache.case_is_drunk' => $rows[32],
            ]);
    }

    public function startRow(): int
    {
        return 7;
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

}
