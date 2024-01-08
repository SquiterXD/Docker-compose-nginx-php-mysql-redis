<?php

namespace App\Imports\OM;

use App\Models\OM\Settings\ThailandTerritory;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\Importable;

class ThailandTerritoryImport implements ToCollection, WithStartRow
{
    use Importable;

    /**
    * @return int
    */
    public function startRow(): int
    {
        return 2;
    }

    public function collection(Collection $rows)
    {
        $data = [];

        foreach ($rows as $row) 
        {
            $maxThambonId   = ThailandTerritory::max('tambon_id');
            $maxDistrictId  = ThailandTerritory::max('district_id');
            $maxProvinceId  = ThailandTerritory::max('province_id');
            $maxRegionId    = ThailandTerritory::max('region_id');

            $thambonById    = ThailandTerritory::whereTambonId($row[1])->first();
            $thambonExcel   = $row[2].$row[3].$row[10].$row[11].$row[15].$row[16].$row[18].$row[19];
            $thambon        = ThailandTerritory::where(\DB::raw("CONCAT(
                                                                    CONCAT(
                                                                        CONCAT(tambon_thai,tambon_eng),
                                                                        CONCAT(district_thai,district_eng)
                                                                    ),
                                                                    CONCAT(
                                                                        CONCAT(province_thai,province_eng),
                                                                        CONCAT(region_thai,region_eng)
                                                                    )
                                                                )"), "LIKE", "%".$thambonExcel."%")
                                                ->first();

            $districtById   = ThailandTerritory::whereDistrictId($row[9])->first();
            $districtExcel  = $row[10].$row[11].$row[15].$row[16].$row[18].$row[19];
            $district       = ThailandTerritory::where(\DB::raw("CONCAT(
                                                                    CONCAT(district_thai,district_eng),
                                                                    CONCAT(
                                                                        CONCAT(province_thai,province_eng),
                                                                        CONCAT(region_thai,region_eng)
                                                                    )
                                                                )"), "LIKE", "%".$districtExcel."%")
                                                ->first();

            $provinceById   = ThailandTerritory::whereProvinceId($row[14])->first();
            $provinceExcel  = $row[15].$row[16].$row[18].$row[19];
            $province       = ThailandTerritory::where(\DB::raw("CONCAT(
                                                                    CONCAT(province_thai,province_eng),
                                                                    CONCAT(region_thai,region_eng)
                                                                )"), "LIKE", "%".$provinceExcel."%")
                                                ->first();

            $regionById     = ThailandTerritory::whereRegionId($row[17])->first();
            $regionExcel    = $row[18].$row[19];
            $region         = ThailandTerritory::where(\DB::raw("CONCAT(region_thai,region_eng)"), "LIKE", "%".$regionExcel."%")->first();

            // CHECK DISTRICT
            if ($district) {
                // ข้อมูลเก่า
                $districtId     = $district->district_id;
                $districtThai   = $district->district_thai;
                $districtEng    = $district->district_eng;
            } elseif (!$district && $districtById) {
                // ข้อมูลเใหม่ยังไม่มีในDB, idเก่า
                $districtId     = $districtById->district_id;
                $districtThai   = $districtById->district_thai;
                $districtEng    = $districtById->district_eng;
            } elseif (!$district && (!$districtById || !$row[9])) {
                // ข้อมูลเใหม่ยังไม่มีในDB, idใหม่ หรือ idว่าง
                $districtId     = $maxDistrictId+1;
                $districtThai   = $row[10];
                $districtEng    = $row[11];
            }

            // CHECK PROVINCE
            if ($province) {
                // ข้อมูลเก่า
                $provinceId     = $province->province_id;
                $provinceThai   = $province->province_thai;
                $provinceEng    = $province->province_eng;
            } elseif (!$province && $provinceById) {
                // ข้อมูลเใหม่ยังไม่มีในDB, idเก่า
                $provinceId     = $provinceById->province_id;
                $provinceThai   = $provinceById->province_thai;
                $provinceEng    = $provinceById->province_eng;
            } elseif (!$province && (!$provinceById || !$row[14])) {
                // ข้อมูลเใหม่ยังไม่มีในDB, idใหม่ หรือ idว่าง
                $provinceId     = $maxProvinceId+1;
                $provinceThai   = $row[15];
                $provinceEng    = $row[16];
            }

            if ($provinceThai == 'กรุงเทพมหานคร') {
                $attribute1 = 1;
            } else {
                $attribute1 = 2;
            }

            // CHECK REGION
            if ($region) {
                // ข้อมูลเก่า
                $regionId   = $region->region_id;
                $regionThai = $region->region_thai;
                $regionEng  = $region->region_eng;
            } elseif (!$region && $regionById) {
                // ข้อมูลเใหม่ยังไม่มีในDB, idเก่า
                $regionId   = $regionById->region_id;
                $regionThai = $regionById->region_thai;
                $regionEng  = $regionById->region_eng;
            } elseif (!$region && (!$regionById || !$row[17])) {
                // ข้อมูลเใหม่ยังไม่มีในDB, idใหม่ หรือ idว่าง
                $regionId   = $maxRegionId+1;
                $regionThai = $row[18];
                $regionEng  = $row[19];
            }
            
            if (!$thambon && $thambonById) {
                // ข้อมูลเใหม่ยังไม่มีในDB, idเก่า => update record
                $thaiTerritory = ThailandTerritory::whereTambonId($row[1])->first();
                $thaiTerritory->territory_file_name = $row[0];
                $thaiTerritory->tambon_id           = $row[1];
                $thaiTerritory->tambon_thai         = $row[2];
                $thaiTerritory->tambon_eng          = $row[3];
                $thaiTerritory->tambon_thai_short   = $row[4];
                $thaiTerritory->tambon_eng_short    = $row[5];
                $thaiTerritory->postcode_main       = $row[6];
                $thaiTerritory->postcode_all        = $row[7];
                $thaiTerritory->postal_code_remark  = $row[8];
                $thaiTerritory->district_id         = $districtId;
                $thaiTerritory->district_thai       = $districtThai;
                $thaiTerritory->district_eng        = $districtEng;
                $thaiTerritory->district_thai_short = $row[12];
                $thaiTerritory->district_eng_short  = $row[13];
                $thaiTerritory->province_id         = $provinceId;
                $thaiTerritory->province_thai       = $provinceThai;
                $thaiTerritory->province_eng        = $provinceEng;
                $thaiTerritory->region_id           = $regionId;
                $thaiTerritory->region_thai         = $regionThai;
                $thaiTerritory->region_eng          = $regionEng;
                $thaiTerritory->attribute1          = $attribute1;
                $thaiTerritory->interface_status    = 'U';
                $thaiTerritory->interfaced_msg      = 'UPDATE RECORD';
                $thaiTerritory->save();

            } elseif (!$thambon && (!$thambonById || !$row[1])) {
                // ข้อมูลเใหม่ยังไม่มีในDB, idใหม่ หรือ idว่าง => create new record
                ThailandTerritory::create([
                    'territory_file_name'   => $row[0],
                    'tambon_id'             => $maxThambonId+1,
                    'tambon_thai'           => $row[2],
                    'tambon_eng'            => $row[3],
                    'tambon_thai_short'     => $row[4],
                    'tambon_eng_short'      => $row[5],
                    'postcode_main'         => $row[6],
                    'postcode_all'          => $row[7],
                    'postal_code_remark'    => $row[8],
                    'district_id'           => $districtId,
                    'district_thai'         => $districtThai,
                    'district_eng'          => $districtEng,
                    'district_thai_short'   => $row[12],
                    'district_eng_short'    => $row[13],
                    'province_id'           => $provinceId,
                    'province_thai'         => $provinceThai,
                    'province_eng'          => $provinceEng,
                    'region_id'             => $regionId,
                    'region_thai'           => $regionThai,
                    'region_eng'            => $regionEng,
                    'attribute1'            => $attribute1,
                    'interface_status'      => 'I',
                    'interfaced_msg'        => 'INSERT NEW RECORD',
                ]);
            }

        }
    }
}
