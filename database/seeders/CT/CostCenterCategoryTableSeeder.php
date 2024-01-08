<?php

namespace Database\Seeders\CT;

use Illuminate\Database\Seeder;
use DB;

class CostCenterCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('oracle_oact')->table('ptct_cost_center_categories')->insert([
            [
                'code' => "O",
                'name' => 'ไม่ระบุ',
            ],
            [
                'code' => "B",
                'name' => 'กลุ่มศูนย์อบ',
            ],
            [
                'code' => "S",
                'name' => 'กลุ่มศูนย์ยาเส้น ยาเส้นพอง ก้นกรอง เมนทอลฟอยด์ มวน',
            ],
            [
                'code' => "P",
                'name' => 'กลุ่มสิ่งพิมพ์',
            ],
        ]);
    }
}
