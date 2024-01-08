<?php

namespace Database\Seeders\CT;

use Illuminate\Database\Seeder;
use DB;

class CriterionAllocateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('oracle_oact')->table('ptct_criterion_allocates')->insert([
            [ 'code' => '00', 'name' => 'เท่ากัน', 'is_active' => 1],	
            [ 'code' => '01', 'name' => 'สัดส่วนการให้บริการ', 'is_active' => 1],	
            [ 'code' => '02', 'name' => 'ปริมาณผลผลิต', 'is_active' => 1],	
            [ 'code' => '03', 'name' => 'จำนวนพนักงาน', 'is_active' => 1],	
            [ 'code' => '04', 'name' => 'ขนาดของพื้นที่', 'is_active' => 1],	
            [ 'code' => '05', 'name' => 'ตามมูลค่าของครุภัณฑ์', 'is_active' => 1],	
            [ 'code' => '06', 'name' => 'ตามมูลค่าของคอมพิวเตอร์', 'is_active' => 1],	
            [ 'code' => '07', 'name' => 'ตามมูลค่าของเครื่องจักร', 'is_active' => 1],	
            [ 'code' => '09', 'name' => 'ตามปริมาณการใช้', 'is_active' => 1],	
            [ 'code' => '10', 'name' => 'ตามเครื่องจักรที่ใช้งาน', 'is_active' => 1],	
            [ 'code' => '11', 'name' =>	'ตามมูลค่าสินทรัพย์', 'is_active' => 1],
            [ 'code' => '12', 'name' =>	'ตามกำลังวัตต์', 'is_active' => 1],
            [ 'code' => '13', 'name' =>	'ค่าใช้จ่ายตามจริง', 'is_active' => 1],
            [ 'code' => '99', 'name' =>	'ทั้งหมด', 'is_active' => 1],
        ]);
    }
}

