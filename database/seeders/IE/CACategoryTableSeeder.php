<?php

namespace Database\Seeders\IE;

use Illuminate\Database\Seeder;
use DB;

class CACategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('oracle_oaie')->table('ptw_ca_categories')->truncate();
        DB::connection('oracle_oaie')->table('ptw_ca_categories')->insert($this->CACategories());
    }
    
    public function CACategories()
    {
        $lists = [];

            array_push($lists, [
             'name' => 'ค่าธรรมเนียมขอวีซ่า และ Work permit (VISA and work permit fee)', 
             'description' => 'ค่าธรรมเนียมขอวีซ่า และ Work permit (VISA and work permit fee)', 
             'icon' => 'fa-cc-visa',
             'active' => true,
             'last_updated_by' => date('Y-m-d H:i:s'),
             'last_update_date' => date('Y-m-d H:i:s'),
             'last_updated_by' => -1,
             'created_by' => -1]);
            array_push($lists, [
             'name' => 'กิจกรรม Excursion (Excursion expense)',
             'description' => 'กิจกรรม Excursion (Excursion expense)', 
             'icon' => 'fa-suitcase',
             'active' => true,
             'last_updated_by' => date('Y-m-d H:i:s'),
             'last_update_date' => date('Y-m-d H:i:s'),
             'last_updated_by' => -1,
             'created_by' => -1]);
            array_push($lists, [
             'name' => 'กิจกรรม Staff party (Staff party expense)',
             'description' => 'กิจกรรม Staff party (Staff party expense)', 
             'icon' => 'fa-child',
             'active' => true,
             'last_updated_by' => date('Y-m-d H:i:s'),
             'last_update_date' => date('Y-m-d H:i:s'),
             'last_updated_by' => -1,
             'created_by' => -1]);
            array_push($lists, [
             'name' => 'ค่ารับรองลูกค้าและคู่ค้า (Entertain expense)',
             'description' => 'ค่ารับรองลูกค้าและคู่ค้า (Entertain expense)', 
             'icon' => 'fa-users',
             'active' => true,
             'last_updated_by' => date('Y-m-d H:i:s'),
             'last_update_date' => date('Y-m-d H:i:s'),
             'last_updated_by' => -1,
             'created_by' => -1]);
            array_push($lists, [
             'name' => 'เงินบริจาค (Donation expense)',
             'description' => 'เงินบริจาค (Donation expense)', 
             'icon' => 'fa-smile-o',
             'active' => true,
             'last_updated_by' => date('Y-m-d H:i:s'),
             'last_update_date' => date('Y-m-d H:i:s'),
             'last_updated_by' => -1,
             'created_by' => -1]);
            array_push($lists, [
             'name' => 'ค่าใช้จ่ายอบรมตัวแทน นายหน้า (Agent training expense)',
             'description' => 'ค่าใช้จ่ายอบรมตัวแทน นายหน้า (Agent training expense)', 
             'icon' => 'fa-certificate',
             'active' => true,
             'last_updated_by' => date('Y-m-d H:i:s'),
             'last_update_date' => date('Y-m-d H:i:s'),
             'last_updated_by' => -1,
             'created_by' => -1]);
            array_push($lists, [
             'name' => 'ค่าเดินทางไปตรวจสอบเคลม (Business trip - Claim)',
             'description' => 'ค่าเดินทางไปตรวจสอบเคลม (Business trip - Claim)', 
             'icon' => 'fa-car',
             'active' => true,
             'last_updated_by' => date('Y-m-d H:i:s'),
             'last_update_date' => date('Y-m-d H:i:s'),
             'last_updated_by' => -1,
             'created_by' => -1]);
            array_push($lists, [
             'name' => 'ค่าธรรมเนียมขออนุมัติ Product (Product approval fee from OIC)',
             'description' => 'ค่าธรรมเนียมขออนุมัติ Product (Product approval fee from OIC)', 
             'icon' => 'fa-money',
             'active' => true,
             'last_updated_by' => date('Y-m-d H:i:s'),
             'last_update_date' => date('Y-m-d H:i:s'),
             'last_updated_by' => -1,
             'created_by' => -1]); 
            array_push($lists, [
             'name' => 'ค่าธรรมเนียมคัดหนังสือรับรองบริษัท/ใบอนุญาตของบริษัทฯ (Copy fee for company document)',
             'description' => 'ค่าธรรมเนียมคัดหนังสือรับรองบริษัท/ใบอนุญาตของบริษัทฯ (Copy fee for company document)', 
             'icon' => 'fa-file-text-o',
             'active' => true,
             'last_updated_by' => date('Y-m-d H:i:s'),
             'last_update_date' => date('Y-m-d H:i:s'),
             'last_updated_by' => -1,
             'created_by' => -1]); 
            array_push($lists, [
             'name' => 'กิจกรรมชมรมฟุตบอล (TMFC expense)',
             'description' => 'กิจกรรมชมรมฟุตบอล (TMFC expense)', 
             'icon' => 'fa-soccer-ball-o',
             'active' => true,
             'last_updated_by' => date('Y-m-d H:i:s'),
             'last_update_date' => date('Y-m-d H:i:s'),
             'last_updated_by' => -1,
             'created_by' => -1]);
            array_push($lists, [
             'name' => 'ค่าซ่อมแซมบำรุง (Repair & Maintenance expense)',
             'description' => 'ค่าซ่อมแซมบำรุง (Repair & Maintenance expense)', 
             'icon' => 'fa-gear',
             'active' => true,
             'last_updated_by' => date('Y-m-d H:i:s'),
             'last_update_date' => date('Y-m-d H:i:s'),
             'last_updated_by' => -1,
             'created_by' => -1]);
            array_push($lists, [
             'name' => 'ค่าที่พักพนักงานไปปฏิบัติงานต่างสาขา (Accomodation fee)',
             'description' => 'ค่าที่พักพนักงานไปปฏิบัติงานต่างสาขา (Accomodation fee)', 
             'icon' => 'fa-sitemap',
             'active' => true,
             'last_updated_by' => date('Y-m-d H:i:s'),
             'last_update_date' => date('Y-m-d H:i:s'),
             'last_updated_by' => -1,
             'created_by' => -1]);
            array_push($lists, [
             'name' => 'ค่าเติมเงินบัตรทางด่วน (Express way expense)',
             'description' => 'ค่าเติมเงินบัตรทางด่วน (Express way expense)', 
             'icon' => 'fa-credit-card',
             'active' => true,
             'last_updated_by' => date('Y-m-d H:i:s'),
             'last_update_date' => date('Y-m-d H:i:s'),
             'last_updated_by' => -1,
             'created_by' => -1]);
            array_push($lists, [
             'name' => 'ค่าจัดกิจกรรม HR (HR activity expense)',
             'description' => 'ค่าจัดกิจกรรม HR (HR activity expense)', 
             'icon' => 'fa-male',
             'active' => true,
             'last_updated_by' => date('Y-m-d H:i:s'),
             'last_update_date' => date('Y-m-d H:i:s'),
             'last_updated_by' => -1,
             'created_by' => -1]);
            array_push($lists, [
             'name' => 'สนับสนุนกิจกรรมคู่ค้า (Support dealer and customer activity expense)',
             'description' => 'สนับสนุนกิจกรรมคู่ค้า (Support dealer and customer activity expense)', 
             'icon' => 'fa-wechat',
             'active' => true,
             'last_updated_by' => date('Y-m-d H:i:s'),
             'last_update_date' => date('Y-m-d H:i:s'),
             'last_updated_by' => -1,
             'created_by' => -1]);

        return $lists;
    }
    
}
