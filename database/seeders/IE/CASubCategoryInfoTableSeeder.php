<?php

namespace Database\Seeders\IE;

use Illuminate\Database\Seeder;
use DB;
use App\Models\IE\CACategory;
use App\Models\IE\CASubCategory;

class CASubCategoryInfoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        try {

            $subCategoryInfos = $this->subCategoryInfos();
            DB::connection('oracle_oaie')->table('ptw_ca_sub_category_infos')->truncate();
            DB::connection('oracle_oaie')->table('ptw_ca_sub_category_infos')->insert($subCategoryInfos);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error($e->getMessage());
            throw new \Exception($e->getMessage(), 1);
        }
        DB::commit();
    }

    public function subCategoryInfos()
    {
        $lists = [];

            $categories = CACategory::all();
            foreach ($categories as $key => $category) {

                $subCategories = CASubCategory::where('ca_category_id',$category->ca_category_id)
                                    ->get();

                foreach ($subCategories as $key => $subCategory) {

                    switch ($category->name) {

                        case 'ค่าธรรมเนียมขอวีซ่า และ Work permit (VISA and work permit fee)':

                            if($subCategory->name == 'ค่าธรรมเนียมขอวีซ่า และ Work permit (VISA and work permit fee)'){

                                array_push($lists, [
                                         'ca_category_id' => $category->ca_category_id, 
                                         'ca_sub_category_id' => $subCategory->ca_sub_category_id, 
                                         'attribute_name' => 'วันเดินทาง (Date)',
                                         'purpose' => 'วันเดินทาง (Date)',
                                         'form_type' => 'date',
                                         'form_value' => null,
                                         'required' => true,
                                         'active' => true,
                                         'last_updated_by' => date('Y-m-d H:i:s'),
                                         'last_update_date' => date('Y-m-d H:i:s'),
                                         'last_updated_by' => -1,
                                         'created_by' => -1]);

                                array_push($lists, [
                                         'ca_category_id' => $category->ca_category_id, 
                                         'ca_sub_category_id' => $subCategory->ca_sub_category_id, 
                                         'attribute_name' => 'วัตถุประสงค์การเดินทาง (Objective)',
                                         'purpose' => 'วัตถุประสงค์การเดินทาง (Objective)',
                                         'form_type' => 'text',
                                         'form_value' => null,
                                         'required' => true,
                                         'active' => true,
                                         'last_updated_by' => date('Y-m-d H:i:s'),
                                         'last_update_date' => date('Y-m-d H:i:s'),
                                         'last_updated_by' => -1,
                                         'created_by' => -1]);


                                array_push($lists, [
                                         'ca_category_id' => $category->ca_category_id, 
                                         'ca_sub_category_id' => $subCategory->ca_sub_category_id, 
                                         'attribute_name' => 'ประเทศ (Country)',
                                         'purpose' => 'ประเทศ (Country)',
                                         'form_type' => 'text',
                                         'form_value' => null,
                                         'required' => true,
                                         'active' => true,
                                         'last_updated_by' => date('Y-m-d H:i:s'),
                                         'last_update_date' => date('Y-m-d H:i:s'),
                                         'last_updated_by' => -1,
                                         'created_by' => -1]);
                            }

                        case 'กิจกรรม Excursion (Excursion expense)':

                            if($subCategory->name == 'กิจกรรม Excursion (Excursion expense)'){
                                array_push($lists, [
                                         'ca_category_id' => $category->ca_category_id, 
                                         'ca_sub_category_id' => $subCategory->ca_sub_category_id, 
                                         'attribute_name' => 'สถานที่จัดงาน (Place)',
                                         'purpose' => 'สถานที่จัดงาน (Place)',
                                         'form_type' => 'text',
                                         'form_value' => null,
                                         'required' => true,
                                         'active' => true,
                                         'last_updated_by' => date('Y-m-d H:i:s'),
                                         'last_update_date' => date('Y-m-d H:i:s'),
                                         'last_updated_by' => -1,
                                         'created_by' => -1]);

                                array_push($lists, [
                                         'ca_category_id' => $category->ca_category_id, 
                                         'ca_sub_category_id' => $subCategory->ca_sub_category_id, 
                                         'attribute_name' => 'วันที่จัดงาน (Date)',
                                         'purpose' => 'วันที่จัดงาน (Date)',
                                         'form_type' => 'date',
                                         'form_value' => null,
                                         'required' => true,
                                         'active' => true,
                                         'last_updated_by' => date('Y-m-d H:i:s'),
                                         'last_update_date' => date('Y-m-d H:i:s'),
                                         'last_updated_by' => -1,
                                         'created_by' => -1]);
                            }

                            break;

                        case 'กิจกรรม Staff party (Staff party expense)':

                            if($subCategory->name == 'กิจกรรม Staff party (Staff party expense)'){
                                array_push($lists, [
                                         'ca_category_id' => $category->ca_category_id, 
                                         'ca_sub_category_id' => $subCategory->ca_sub_category_id, 
                                         'attribute_name' => 'สถานที่จัดงาน (Place)',
                                         'purpose' => 'สถานที่จัดงาน (Place)',
                                         'form_type' => 'text',
                                         'form_value' => null,
                                         'required' => true,
                                         'active' => true,
                                         'last_updated_by' => date('Y-m-d H:i:s'),
                                         'last_update_date' => date('Y-m-d H:i:s'),
                                         'last_updated_by' => -1,
                                         'created_by' => -1]);

                                array_push($lists, [
                                         'ca_category_id' => $category->ca_category_id, 
                                         'ca_sub_category_id' => $subCategory->ca_sub_category_id, 
                                         'attribute_name' => 'วันที่จัดงาน (Date)',
                                         'purpose' => 'วันที่จัดงาน (Date)',
                                         'form_type' => 'date',
                                         'form_value' => null,
                                         'required' => true,
                                         'active' => true,
                                         'last_updated_by' => date('Y-m-d H:i:s'),
                                         'last_update_date' => date('Y-m-d H:i:s'),
                                         'last_updated_by' => -1,
                                         'created_by' => -1]);
                            }

                            break;

                        case 'ค่ารับรองลูกค้าและคู่ค้า (Entertain expense)':

                            if($subCategory->name == 'ค่ารับรองลูกค้าและคู่ค้า (Entertain expense)'){
                                array_push($lists, [
                                         'ca_category_id' => $category->ca_category_id, 
                                         'ca_sub_category_id' => $subCategory->ca_sub_category_id, 
                                         'attribute_name' => 'ชื่อลูกค้าและชื่อบริษัทที่รับรอง (Customer name & Company name)',
                                         'purpose' => 'ชื่อลูกค้าและชื่อบริษัทที่รับรอง (Customer name & Company name)',
                                         'form_type' => 'text',
                                         'form_value' => null,
                                         'required' => true,
                                         'active' => true,
                                         'last_updated_by' => date('Y-m-d H:i:s'),
                                         'last_update_date' => date('Y-m-d H:i:s'),
                                         'last_updated_by' => -1,
                                         'created_by' => -1]);

                                array_push($lists, [
                                         'ca_category_id' => $category->ca_category_id, 
                                         'ca_sub_category_id' => $subCategory->ca_sub_category_id, 
                                         'attribute_name' => 'วัตถุประสงค์การรับรอง (Objective)',
                                         'purpose' => 'วัตถุประสงค์การรับรอง (Objective)',
                                         'form_type' => 'text',
                                         'form_value' => null,
                                         'required' => false,
                                         'active' => true,
                                         'last_updated_by' => date('Y-m-d H:i:s'),
                                         'last_update_date' => date('Y-m-d H:i:s'),
                                         'last_updated_by' => -1,
                                         'created_by' => -1]);
                            }

                            break;

                        case 'เงินบริจาค (Donation expense)':

                            if($subCategory->name == 'เงินบริจาค (Donation expense)'){
                                array_push($lists, [
                                         'ca_category_id' => $category->ca_category_id, 
                                         'ca_sub_category_id' => $subCategory->ca_sub_category_id, 
                                         'attribute_name' => 'หน่วยงาน (Company name/Organizer name)',
                                         'purpose' => 'หน่วยงาน (Company name/Organizer name)',
                                         'form_type' => 'text',
                                         'form_value' => null,
                                         'required' => true,
                                         'active' => true,
                                         'last_updated_by' => date('Y-m-d H:i:s'),
                                         'last_update_date' => date('Y-m-d H:i:s'),
                                         'last_updated_by' => -1,
                                         'created_by' => -1]);

                            }

                            break;

                        case 'ค่าใช้จ่ายอบรมตัวแทน นายหน้า (Agent training expense)':

                            if($subCategory->name == 'ค่าใช้จ่ายอบรมตัวแทน นายหน้า (Agent training expense)'){
                                array_push($lists, [
                                         'ca_category_id' => $category->ca_category_id, 
                                         'ca_sub_category_id' => $subCategory->ca_sub_category_id, 
                                         'attribute_name' => 'ชื่อหลักสูตร (Course)',
                                         'purpose' => 'ชื่อหลักสูตร (Course)',
                                         'form_type' => 'text',
                                         'form_value' => null,
                                         'required' => true,
                                         'active' => true,
                                         'last_updated_by' => date('Y-m-d H:i:s'),
                                         'last_update_date' => date('Y-m-d H:i:s'),
                                         'last_updated_by' => -1,
                                         'created_by' => -1]);

                                array_push($lists, [
                                         'ca_category_id' => $category->ca_category_id, 
                                         'ca_sub_category_id' => $subCategory->ca_sub_category_id, 
                                         'attribute_name' => 'วันที่จัดหลักสูตร (Date)',
                                         'purpose' => 'วันที่จัดหลักสูตร (Date)',
                                         'form_type' => 'date',
                                         'form_value' => null,
                                         'required' => true,
                                         'active' => true,
                                         'last_updated_by' => date('Y-m-d H:i:s'),
                                         'last_update_date' => date('Y-m-d H:i:s'),
                                         'last_updated_by' => -1,
                                         'created_by' => -1]);

                                array_push($lists, [
                                         'ca_category_id' => $category->ca_category_id, 
                                         'ca_sub_category_id' => $subCategory->ca_sub_category_id, 
                                         'attribute_name' => 'สถานที่จัดอบรม (Place)',
                                         'purpose' => 'สถานที่จัดอบรม (Place)',
                                         'form_type' => 'text',
                                         'form_value' => null,
                                         'required' => true,
                                         'active' => true,
                                         'last_updated_by' => date('Y-m-d H:i:s'),
                                         'last_update_date' => date('Y-m-d H:i:s'),
                                         'last_updated_by' => -1,
                                         'created_by' => -1]);
                            }

                            break;

                        case 'ค่าเดินทางไปตรวจสอบเคลม (Business trip - Claim)':

                            if($subCategory->name == 'ค่าเดินทางไปตรวจสอบเคลม (Business trip - Claim)'){
                                array_push($lists, [
                                         'ca_category_id' => $category->ca_category_id, 
                                         'ca_sub_category_id' => $subCategory->ca_sub_category_id, 
                                         'attribute_name' => 'วันเดินทาง (Date)',
                                         'purpose' => 'วันเดินทาง (Date)',
                                         'form_type' => 'date',
                                         'form_value' => null,
                                         'required' => true,
                                         'active' => true,
                                         'last_updated_by' => date('Y-m-d H:i:s'),
                                         'last_update_date' => date('Y-m-d H:i:s'),
                                         'last_updated_by' => -1,
                                         'created_by' => -1]);

                                array_push($lists, [
                                         'ca_category_id' => $category->ca_category_id, 
                                         'ca_sub_category_id' => $subCategory->ca_sub_category_id, 
                                         'attribute_name' => 'Claim number',
                                         'purpose' => 'Claim number',
                                         'form_type' => 'text',
                                         'form_value' => null,
                                         'required' => true,
                                         'active' => true,
                                         'last_updated_by' => date('Y-m-d H:i:s'),
                                         'last_update_date' => date('Y-m-d H:i:s'),
                                         'last_updated_by' => -1,
                                         'created_by' => -1]);

                                array_push($lists, [
                                         'ca_category_id' => $category->ca_category_id, 
                                         'ca_sub_category_id' => $subCategory->ca_sub_category_id, 
                                         'attribute_name' => 'สถานที่ต้นทาง-สถานที่ปลายทาง (Place From-To)',
                                         'purpose' => 'สถานที่ต้นทาง-สถานที่ปลายทาง (Place From-To)',
                                         'form_type' => 'text',
                                         'form_value' => null,
                                         'required' => true,
                                         'active' => true,
                                         'last_updated_by' => date('Y-m-d H:i:s'),
                                         'last_update_date' => date('Y-m-d H:i:s'),
                                         'last_updated_by' => -1,
                                         'created_by' => -1]);
                            }

                            break;

                        case 'ค่าธรรมเนียมขออนุมัติ Product (Product approval fee from OIC)':

                            if($subCategory->name == 'ค่าธรรมเนียมขออนุมัติ Product (Product approval fee from OIC)'){
                                array_push($lists, [
                                         'ca_category_id' => $category->ca_category_id, 
                                         'ca_sub_category_id' => $subCategory->ca_sub_category_id, 
                                         'attribute_name' => 'วัตถุประสงค์ในการขอ (Objective)',
                                         'purpose' => 'วัตถุประสงค์ในการขอ (Objective)',
                                         'form_type' => 'text',
                                         'form_value' => null,
                                         'required' => true,
                                         'active' => true,
                                         'last_updated_by' => date('Y-m-d H:i:s'),
                                         'last_update_date' => date('Y-m-d H:i:s'),
                                         'last_updated_by' => -1,
                                         'created_by' => -1]);
                            }

                            break;

                        case 'ค่าธรรมเนียมคัดหนังสือรับรองบริษัท/ใบอนุญาตของบริษัทฯ (Copy fee for company document)':

                            if($subCategory->name == 'ค่าธรรมเนียมคัดหนังสือรับรองบริษัท/ใบอนุญาตของบริษัทฯ (Copy fee for company document)'){
                                array_push($lists, [
                                         'ca_category_id' => $category->ca_category_id, 
                                         'ca_sub_category_id' => $subCategory->ca_sub_category_id, 
                                         'attribute_name' => 'วัตถุประสงค์ในการขอ (Objective)',
                                         'purpose' => 'วัตถุประสงค์ในการขอ (Objective)',
                                         'form_type' => 'text',
                                         'form_value' => null,
                                         'required' => true,
                                         'active' => true,
                                         'last_updated_by' => date('Y-m-d H:i:s'),
                                         'last_update_date' => date('Y-m-d H:i:s'),
                                         'last_updated_by' => -1,
                                         'created_by' => -1]);
                            }

                            break;

                        case 'กิจกรรมชมรมฟุตบอล (TMFC expense)':

                            if($subCategory->name == 'กิจกรรมชมรมฟุตบอล (TMFC expense)'){
                                array_push($lists, [
                                         'ca_category_id' => $category->ca_category_id, 
                                         'ca_sub_category_id' => $subCategory->ca_sub_category_id, 
                                         'attribute_name' => 'วัตถุประสงค์ (Objective)',
                                         'purpose' => 'วัตถุประสงค์ (Objective)',
                                         'form_type' => 'text',
                                         'form_value' => null,
                                         'required' => true,
                                         'active' => true,
                                         'last_updated_by' => date('Y-m-d H:i:s'),
                                         'last_update_date' => date('Y-m-d H:i:s'),
                                         'last_updated_by' => -1,
                                         'created_by' => -1]);

                                array_push($lists, [
                                         'ca_category_id' => $category->ca_category_id, 
                                         'ca_sub_category_id' => $subCategory->ca_sub_category_id, 
                                         'attribute_name' => 'วันที่ (Date)',
                                         'purpose' => 'วันที่ (Date)',
                                         'form_type' => 'date',
                                         'form_value' => null,
                                         'required' => true,
                                         'active' => true,
                                         'last_updated_by' => date('Y-m-d H:i:s'),
                                         'last_update_date' => date('Y-m-d H:i:s'),
                                         'last_updated_by' => -1,
                                         'created_by' => -1]);

                                array_push($lists, [
                                         'ca_category_id' => $category->ca_category_id, 
                                         'ca_sub_category_id' => $subCategory->ca_sub_category_id, 
                                         'attribute_name' => 'สถานที่เช่า (Place)',
                                         'purpose' => 'สถานที่เช่า (Place)',
                                         'form_type' => 'text',
                                         'form_value' => null,
                                         'required' => true,
                                         'active' => true,
                                         'last_updated_by' => date('Y-m-d H:i:s'),
                                         'last_update_date' => date('Y-m-d H:i:s'),
                                         'last_updated_by' => -1,
                                         'created_by' => -1]);
                            }

                            break;

                        case 'ค่าซ่อมแซมบำรุง (Repair & Maintenance expense)':

                            if($subCategory->name == 'ค่าซ่อมแซมบำรุง (Repair & Maintenance expense)'){
                                array_push($lists, [
                                         'ca_category_id' => $category->ca_category_id, 
                                         'ca_sub_category_id' => $subCategory->ca_sub_category_id, 
                                         'attribute_name' => 'รายละเอียด (Detail)',
                                         'purpose' => 'รายละเอียด (Detail)',
                                         'form_type' => 'text',
                                         'form_value' => null,
                                         'required' => true,
                                         'active' => true,
                                         'last_updated_by' => date('Y-m-d H:i:s'),
                                         'last_update_date' => date('Y-m-d H:i:s'),
                                         'last_updated_by' => -1,
                                         'created_by' => -1]);
                            }

                            break;

                        case 'ค่าที่พักพนักงานไปปฏิบัติงานต่างสาขา (Accomodation fee)':

                            if($subCategory->name == 'ค่าที่พักพนักงานไปปฏิบัติงานต่างสาขา (Accomodation fee)'){
                                array_push($lists, [
                                         'ca_category_id' => $category->ca_category_id, 
                                         'ca_sub_category_id' => $subCategory->ca_sub_category_id, 
                                         'attribute_name' => 'สาขาที่ไปปฏิบัติงาน (Place)',
                                         'purpose' => 'สาขาที่ไปปฏิบัติงาน (Place)',
                                         'form_type' => 'text',
                                         'form_value' => null,
                                         'required' => true,
                                         'active' => true,
                                         'last_updated_by' => date('Y-m-d H:i:s'),
                                         'last_update_date' => date('Y-m-d H:i:s'),
                                         'last_updated_by' => -1,
                                         'created_by' => -1]);

                                array_push($lists, [
                                         'ca_category_id' => $category->ca_category_id, 
                                         'ca_sub_category_id' => $subCategory->ca_sub_category_id, 
                                         'attribute_name' => 'วัตถุประสงค์ (Objective)',
                                         'purpose' => 'วัตถุประสงค์ (Objective)',
                                         'form_type' => 'text',
                                         'form_value' => null,
                                         'required' => true,
                                         'active' => true,
                                         'last_updated_by' => date('Y-m-d H:i:s'),
                                         'last_update_date' => date('Y-m-d H:i:s'),
                                         'last_updated_by' => -1,
                                         'created_by' => -1]);
                            }

                            break;

                        case 'ค่าเติมเงินบัตรทางด่วน (Express way expense)':

                            if($subCategory->name == 'ค่าเติมเงินบัตรทางด่วน (Express way expense)'){
                                array_push($lists, [
                                         'ca_category_id' => $category->ca_category_id, 
                                         'ca_sub_category_id' => $subCategory->ca_sub_category_id, 
                                         'attribute_name' => 'หมายเลขบัตรที่เติม (Express way card no.)',
                                         'purpose' => 'หมายเลขบัตรที่เติม (Express way card no.)',
                                         'form_type' => 'text',
                                         'form_value' => null,
                                         'required' => true,
                                         'active' => true,
                                         'last_updated_by' => date('Y-m-d H:i:s'),
                                         'last_update_date' => date('Y-m-d H:i:s'),
                                         'last_updated_by' => -1,
                                         'created_by' => -1]);
                            }

                            break;

                        case 'ค่าจัดกิจกรรม HR (HR activity expense)':

                            if($subCategory->name == 'ค่าจัดกิจกรรม HR (HR activity expense)'){
                                array_push($lists, [
                                         'ca_category_id' => $category->ca_category_id, 
                                         'ca_sub_category_id' => $subCategory->ca_sub_category_id, 
                                         'attribute_name' => 'ชื่อกิจกรรม (Activity)',
                                         'purpose' => 'ชื่อกิจกรรม (Activity)',
                                         'form_type' => 'text',
                                         'form_value' => null,
                                         'required' => true,
                                         'active' => true,
                                         'last_updated_by' => date('Y-m-d H:i:s'),
                                         'last_update_date' => date('Y-m-d H:i:s'),
                                         'last_updated_by' => -1,
                                         'created_by' => -1]);

                                array_push($lists, [
                                         'ca_category_id' => $category->ca_category_id, 
                                         'ca_sub_category_id' => $subCategory->ca_sub_category_id, 
                                         'attribute_name' => 'วันที่จัดกิจกรรม (Date)',
                                         'purpose' => 'วันที่จัดกิจกรรม (Date)',
                                         'form_type' => 'date',
                                         'form_value' => null,
                                         'required' => true,
                                         'active' => true,
                                         'last_updated_by' => date('Y-m-d H:i:s'),
                                         'last_update_date' => date('Y-m-d H:i:s'),
                                         'last_updated_by' => -1,
                                         'created_by' => -1]);
                            }

                            break;

                        case 'สนับสนุนกิจกรรมคู่ค้า (Support dealer and customer activity expense)':

                            if($subCategory->name == 'สนับสนุนกิจกรรมคู่ค้า (Support dealer and customer activity expense)'){
                                array_push($lists, [
                                         'ca_category_id' => $category->ca_category_id, 
                                         'ca_sub_category_id' => $subCategory->ca_sub_category_id, 
                                         'attribute_name' => 'ชื่อลูกค้าหรือชื่อบริษัทที่จัดกิจกรรม (Dealer,Customer name)',
                                         'purpose' => 'ชื่อลูกค้าหรือชื่อบริษัทที่จัดกิจกรรม (Dealer,Customer name)',
                                         'form_type' => 'text',
                                         'form_value' => null,
                                         'required' => true,
                                         'active' => true,
                                         'last_updated_by' => date('Y-m-d H:i:s'),
                                         'last_update_date' => date('Y-m-d H:i:s'),
                                         'last_updated_by' => -1,
                                         'created_by' => -1]);

                                array_push($lists, [
                                         'ca_category_id' => $category->ca_category_id, 
                                         'ca_sub_category_id' => $subCategory->ca_sub_category_id, 
                                         'attribute_name' => 'วัตถุประสงค์การร่วมกิจกรรม (Objective)',
                                         'purpose' => 'วัตถุประสงค์การร่วมกิจกรรม (Objective)',
                                         'form_type' => 'text',
                                         'form_value' => null,
                                         'required' => true,
                                         'active' => true,
                                         'last_updated_by' => date('Y-m-d H:i:s'),
                                         'last_update_date' => date('Y-m-d H:i:s'),
                                         'last_updated_by' => -1,
                                         'created_by' => -1]);
                            }

                            break;

                        default:
                            # code...
                            break;
                    }
            }
        }
        return $lists;
    }
}
