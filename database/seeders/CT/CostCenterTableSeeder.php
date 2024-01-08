<?php

namespace Database\Seeders\CT;

use Illuminate\Database\Seeder;
use DB;

class CostCenterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::connection('oracle_oact')->table('ptct_cost_centers')->truncate();

        DB::connection('oracle_oact')->table('ptct_cost_centers')->insert([
            [
                'code' => 10,
                'name' => 'ยาเส้น',
                'cost_center_category_id' => 3,
                'is_active' => true,
                'fiscal_year' => '2020',
            ],
            [
                'code' => 20,
                'name' => 'ยาเส้นพอง',
                'cost_center_category_id' => 3,
                'is_active' => true,
                'fiscal_year' => '2020',
            ],
            [
                'code' => 30,
                'name' => 'มวน',
                'cost_center_category_id' => 3,
                'is_active' => true,
                'fiscal_year' => '2020',
            ],
            [
                'code' => 31,
                'name' => 'รับจ้างผลิตบุหรี่',
                'cost_center_category_id' => 3,
                'is_active' => true,
                'fiscal_year' => '2020',
            ],
            [
                'code' => 40,
                'name' => 'ก้นกรอง',
                'cost_center_category_id' => 3,
                'is_active' => true,
                'fiscal_year' => '2020',
            ],
            [
                'code' => 44,
                'name' => 'FOIL',
                'cost_center_category_id' => 3,
                'is_active' => true,
                'fiscal_year' => '2020',
            ],
            [
                'code' => 52,
                'name' => 'พิมพ์ Gravure',
                'cost_center_category_id' => 3,
                'is_active' => true,
                'fiscal_year' => '2020',
            ],
            [
                'code' => 53,
                'name' => 'รับจ้างผลิต',
                'cost_center_category_id' => 4,
                'is_active' => true,
                'fiscal_year' => '2020',
            ],
            [
                'code' => 60,
                'name' => 'ยาเส้นไม่ปรุง',
                'cost_center_category_id' => 3,
                'is_active' => true,
                'fiscal_year' => '2020',
            ],
            [
                'code' => 71,
                'name' => 'อบเอง-โรงอบเด่นชัย',
                'cost_center_category_id' => 2,
                'is_active' => true,
                'fiscal_year' => '2020',
            ],
            [
                'code' => 73,
                'name' => 'จ้างอบ-บ.ยาสูบสากล',
                'cost_center_category_id' => 2,
                'is_active' => true,
                'fiscal_year' => '2020',
            ],
            [
                'code' => 77,
                'name' => 'แปรสภาพใบยา',
                'cost_center_category_id' => 2,
                'is_active' => true,
                'fiscal_year' => '2020',
            ],
            [
                'code' => 78,
                'name' => 'ยาเส้นภูมิภาค',
                'cost_center_category_id' => 3,
                'is_active' => true,
                'fiscal_year' => '2020',
            ],
            [
                'code' => 79,
                'name' => 'บรรจุภูมิภาค',
                'cost_center_category_id' => 3,
                'is_active' => true,
                'fiscal_year' => '2020',
            ],
            [
                'code' => 81,
                'name' => ' ทำความสะอาดใบยา',
                'cost_center_category_id' => 2,
                'is_active' => true,
                'fiscal_year' => '2020',
            ],
            [
                'code' => 90,
                'name' => 'สารปรุงสารหอม ',
                'cost_center_category_id' => 3,
                'is_active' => true,
                'fiscal_year' => '2020',
            ],
            [
                'code' => 99,
                'name' => 'UAT',
                'cost_center_category_id' => 3,
                'is_active' => true,
                'fiscal_year' => '2020',
            ],
            [
                'code' => 51,
                'name' => 'พิมพ์Offset ',
                'cost_center_category_id' => 4,
                'is_active' => true,
                'fiscal_year' => '2020',
            ],
        ]);
    }
}
