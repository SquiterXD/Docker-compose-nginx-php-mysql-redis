<?php

namespace Database\Seeders\IE;

use Illuminate\Database\Seeder;
use DB;
use App\Models\IE\CACategory;
// use App\Models\IE\FNDListOfValues;

class CASubCategoryTableSeeder extends Seeder
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

    		$subCategories = $this->subCategories();
        	DB::connection('oracle_oaie')->table('ptw_ca_sub_categories')->truncate();
        	DB::connection('oracle_oaie')->table('ptw_ca_sub_categories')->insert($subCategories);

            $dbSubCategories = DB::connection('oracle_oaie')->table('ptw_ca_sub_categories')->get();
            foreach ($dbSubCategories as $key => $dbSubCategory) {
                # code...
                DB::connection('oracle_oaie')->table('ptw_accessible_orgs')->insert(
                    [
                        'accessible_orgable_id' => $dbSubCategory->ca_sub_category_id,
                        'accessible_orgable_type' => 'App\Models\IE\CASubCategory',
						'creation_date' => date('Y-m-d H:i:s'),
                        'last_update_date' => date('Y-m-d H:i:s'),
                        'last_updated_by' => -1,
                        'created_by' => -1,
                        'org_id' => '81'
                    ]
                );
            }

    	} catch (\Exception $e) {
    		DB::rollBack();
			\Log::error($e->getMessage());
			throw new \Exception($e->getMessage(), 1);
    	}
    	DB::commit();
    }

	public function subCategories()
    {
        $lists = [];
        
        $defaultSubAccountCode = '000';
        $defaultBranchCode = null;
        $defaultDepartmentCode = '000';

        	$categories = CACategory::all();
        	foreach ($categories as $key => $category) {

        		switch ($category->name) {

        			case 'ค่าธรรมเนียมขอวีซ่า และ Work permit (VISA and work permit fee)':

        				$subCategoryName = 'ค่าธรรมเนียมขอวีซ่า และ Work permit (VISA and work permit fee)';
        				$accountCode = '19505';
        				// self::validateAccountCode('81',$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
        				array_push($lists, [
						             'ca_category_id' => $category->ca_category_id, 
						             'name' => $subCategoryName, 
						             'description' => $subCategoryName,
						             'start_date' => date('Y-m-d'),
						             'end_date' => null,
						             'account_code' => $accountCode,
						             'sub_account_code' => $defaultSubAccountCode,
						             'branch_code' => $defaultBranchCode,
						             'department_code' => $defaultDepartmentCode,
						             'vat_id' => null,
						             'required_attachment' => false,
						            //  'interface_doc_flag' => 'N',
						             'check_ca_min' => true,
						             'ca_min_amount' => 2000,
						             'check_ca_max' => false,
						             'ca_max_amount' => null,
						             'active' => true,
						             'last_updated_by' => date('Y-m-d H:i:s'),
									 'last_update_date' => date('Y-m-d H:i:s'),
									 'last_updated_by' => -1,
									 'created_by' => -1]);

        			case 'กิจกรรม Excursion (Excursion expense)':

						$subCategoryName = 'กิจกรรม Excursion (Excursion expense)';
        				$accountCode = '19505';
        				// self::validateAccountCode('81',$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
        				array_push($lists, [
						             'ca_category_id' => $category->ca_category_id, 
						             'name' => $subCategoryName, 
						             'description' => $subCategoryName,
						             'start_date' => date('Y-m-d'),
						             'end_date' => null,
						             'account_code' => $accountCode,
						             'sub_account_code' => $defaultSubAccountCode,
						             'branch_code' => $defaultBranchCode,
						             'department_code' => $defaultDepartmentCode,
						             'vat_id' => null,
						             'required_attachment' => false,
						            //  'interface_doc_flag' => 'N',
						             'check_ca_min' => true,
						             'ca_min_amount' => 2000,
						             'check_ca_max' => false,
						             'ca_max_amount' => null,
						             'active' => true,
						             'last_updated_by' => date('Y-m-d H:i:s'),
									 'last_update_date' => date('Y-m-d H:i:s'),
									 'last_updated_by' => -1,
									 'created_by' => -1]);

        				break;

        			case 'กิจกรรม Staff party (Staff party expense)':

						$subCategoryName = 'กิจกรรม Staff party (Staff party expense)';
        				$accountCode = '19505';
        				// self::validateAccountCode('81',$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
        				array_push($lists, [
						             'ca_category_id' => $category->ca_category_id, 
						             'name' => $subCategoryName, 
						             'description' => $subCategoryName,
						             'start_date' => date('Y-m-d'),
						             'end_date' => null,
						             'account_code' => $accountCode,
						             'sub_account_code' => $defaultSubAccountCode,
						             'branch_code' => $defaultBranchCode,
						             'department_code' => $defaultDepartmentCode,
						             'vat_id' => null,
						             'required_attachment' => false,
						            //  'interface_doc_flag' => 'N',
						             'check_ca_min' => true,
						             'ca_min_amount' => 2000,
						             'check_ca_max' => false,
						             'ca_max_amount' => null,
						             'active' => true,
						             'last_updated_by' => date('Y-m-d H:i:s'),
									 'last_update_date' => date('Y-m-d H:i:s'),
									 'last_updated_by' => -1,
									 'created_by' => -1]);

        				break;

        			case 'ค่ารับรองลูกค้าและคู่ค้า (Entertain expense)':

        				$subCategoryName = 'ค่ารับรองลูกค้าและคู่ค้า (Entertain expense)';
        				$accountCode = '19505';
        				// self::validateAccountCode('81',$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
        				array_push($lists, [
						             'ca_category_id' => $category->ca_category_id, 
						             'name' => $subCategoryName, 
						             'description' => $subCategoryName,
						             'start_date' => date('Y-m-d'),
						             'end_date' => null,
						             'account_code' => $accountCode,
						             'sub_account_code' => $defaultSubAccountCode,
						             'branch_code' => $defaultBranchCode,
						             'department_code' => $defaultDepartmentCode,
						             'vat_id' => null,
						             'required_attachment' => false,
						            //  'interface_doc_flag' => 'N',
						             'check_ca_min' => true,
						             'ca_min_amount' => 2000,
						             'check_ca_max' => false,
						             'ca_max_amount' => null,
						             'active' => true,
						             'last_updated_by' => date('Y-m-d H:i:s'),
									 'last_update_date' => date('Y-m-d H:i:s'),
									 'last_updated_by' => -1,
									 'created_by' => -1]);

        				break;

        			case 'เงินบริจาค (Donation expense)':

        				$subCategoryName = 'เงินบริจาค (Donation expense)';
        				$accountCode = '19505';
        				// self::validateAccountCode('81',$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
        				array_push($lists, [
						             'ca_category_id' => $category->ca_category_id, 
						             'name' => $subCategoryName, 
						             'description' => $subCategoryName,
						             'start_date' => date('Y-m-d'),
						             'end_date' => null,
						             'account_code' => $accountCode,
						             'sub_account_code' => $defaultSubAccountCode,
						             'branch_code' => $defaultBranchCode,
						             'department_code' => $defaultDepartmentCode,
						             'vat_id' => null,
						             'required_attachment' => false,
						            //  'interface_doc_flag' => 'N',
						             'check_ca_min' => true,
						             'ca_min_amount' => 2000,
						             'check_ca_max' => false,
						             'ca_max_amount' => null,
						             'active' => true,
						             'last_updated_by' => date('Y-m-d H:i:s'),
									 'last_update_date' => date('Y-m-d H:i:s'),
									 'last_updated_by' => -1,
									 'created_by' => -1]);

        				break;

        			case 'ค่าใช้จ่ายอบรมตัวแทน นายหน้า (Agent training expense)':

						$subCategoryName = 'ค่าใช้จ่ายอบรมตัวแทน นายหน้า (Agent training expense)';
        				$accountCode = '19505';
        				// self::validateAccountCode('81',$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
        				array_push($lists, [
						             'ca_category_id' => $category->ca_category_id, 
						             'name' => $subCategoryName, 
						             'description' => $subCategoryName,
						             'start_date' => date('Y-m-d'),
						             'end_date' => null,
						             'account_code' => $accountCode,
						             'sub_account_code' => $defaultSubAccountCode,
						             'branch_code' => $defaultBranchCode,
						             'department_code' => $defaultDepartmentCode,
						             'vat_id' => null,
						             'required_attachment' => false,
						            //  'interface_doc_flag' => 'N',
						             'check_ca_min' => true,
						             'ca_min_amount' => 2000,
						             'check_ca_max' => false,
						             'ca_max_amount' => null,
						             'active' => true,
						             'last_updated_by' => date('Y-m-d H:i:s'),
									 'last_update_date' => date('Y-m-d H:i:s'),
									 'last_updated_by' => -1,
									 'created_by' => -1]);

        				break;

        			case 'ค่าเดินทางไปตรวจสอบเคลม (Business trip - Claim)':

        				$subCategoryName = 'ค่าเดินทางไปตรวจสอบเคลม (Business trip - Claim)';
        				$accountCode = '19505';
        				// self::validateAccountCode('81',$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
        				array_push($lists, [
						             'ca_category_id' => $category->ca_category_id, 
						             'name' => $subCategoryName, 
						             'description' => $subCategoryName,
						             'start_date' => date('Y-m-d'),
						             'end_date' => null,
						             'account_code' => $accountCode,
						             'sub_account_code' => $defaultSubAccountCode,
						             'branch_code' => $defaultBranchCode,
						             'department_code' => $defaultDepartmentCode,
						             'vat_id' => null,
						             'required_attachment' => false,
						            //  'interface_doc_flag' => 'N',
						             'check_ca_min' => true,
						             'ca_min_amount' => 2000,
						             'check_ca_max' => false,
						             'ca_max_amount' => null,
						             'active' => true,
						             'last_updated_by' => date('Y-m-d H:i:s'),
									 'last_update_date' => date('Y-m-d H:i:s'),
									 'last_updated_by' => -1,
									 'created_by' => -1]);

        				break;

        			case 'ค่าธรรมเนียมขออนุมัติ Product (Product approval fee from OIC)':

        				$subCategoryName = 'ค่าธรรมเนียมขออนุมัติ Product (Product approval fee from OIC)';
        				$accountCode = '19505';
        				// self::validateAccountCode('81',$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
        				array_push($lists, [
						             'ca_category_id' => $category->ca_category_id, 
						             'name' => $subCategoryName, 
						             'description' => $subCategoryName,
						             'start_date' => date('Y-m-d'),
						             'end_date' => null,
						             'account_code' => $accountCode,
						             'sub_account_code' => $defaultSubAccountCode,
						             'branch_code' => $defaultBranchCode,
						             'department_code' => $defaultDepartmentCode,
						             'vat_id' => null,
						             'required_attachment' => false,
						            //  'interface_doc_flag' => 'N',
						             'check_ca_min' => true,
						             'ca_min_amount' => 2000,
						             'check_ca_max' => false,
						             'ca_max_amount' => null,
						             'active' => true,
						             'last_updated_by' => date('Y-m-d H:i:s'),
									 'last_update_date' => date('Y-m-d H:i:s'),
									 'last_updated_by' => -1,
									 'created_by' => -1]);

        				break;

        			case 'ค่าธรรมเนียมคัดหนังสือรับรองบริษัท/ใบอนุญาตของบริษัทฯ (Copy fee for company document)':

						$subCategoryName = 'ค่าธรรมเนียมคัดหนังสือรับรองบริษัท/ใบอนุญาตของบริษัทฯ (Copy fee for company document)';
        				$accountCode = '19505';
        				// self::validateAccountCode('81',$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
        				array_push($lists, [
						             'ca_category_id' => $category->ca_category_id, 
						             'name' => $subCategoryName, 
						             'description' => $subCategoryName,
						             'start_date' => date('Y-m-d'),
						             'end_date' => null,
						             'account_code' => $accountCode,
						             'sub_account_code' => $defaultSubAccountCode,
						             'branch_code' => $defaultBranchCode,
						             'department_code' => $defaultDepartmentCode,
						             'vat_id' => null,
						             'required_attachment' => false,
						            //  'interface_doc_flag' => 'N',
						             'check_ca_min' => true,
						             'ca_min_amount' => 2000,
						             'check_ca_max' => false,
						             'ca_max_amount' => null,
						             'active' => true,
						             'last_updated_by' => date('Y-m-d H:i:s'),
									 'last_update_date' => date('Y-m-d H:i:s'),
									 'last_updated_by' => -1,
									 'created_by' => -1]);

        				break;

        			case 'กิจกรรมชมรมฟุตบอล (TMFC expense)':

        				$subCategoryName = 'กิจกรรมชมรมฟุตบอล (TMFC expense)';
        				$accountCode = '19505';
        				// self::validateAccountCode('81',$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
        				array_push($lists, [
						             'ca_category_id' => $category->ca_category_id, 
						             'name' => $subCategoryName, 
						             'description' => $subCategoryName,
						             'start_date' => date('Y-m-d'),
						             'end_date' => null,
						             'account_code' => $accountCode,
						             'sub_account_code' => $defaultSubAccountCode,
						             'branch_code' => $defaultBranchCode,
						             'department_code' => $defaultDepartmentCode,
						             'vat_id' => null,
						             'required_attachment' => false,
						            //  'interface_doc_flag' => 'N',
						             'check_ca_min' => true,
						             'ca_min_amount' => 2000,
						             'check_ca_max' => false,
						             'ca_max_amount' => null,
						             'active' => true,
						             'last_updated_by' => date('Y-m-d H:i:s'),
									 'last_update_date' => date('Y-m-d H:i:s'),
									 'last_updated_by' => -1,
									 'created_by' => -1]);

        				break;

        			case 'ค่าซ่อมแซมบำรุง (Repair & Maintenance expense)':

        				$subCategoryName = 'ค่าซ่อมแซมบำรุง (Repair & Maintenance expense)';
        				$accountCode = '19505';
        				// self::validateAccountCode('81',$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
        				array_push($lists, [
						             'ca_category_id' => $category->ca_category_id, 
						             'name' => $subCategoryName, 
						             'description' => $subCategoryName,
						             'start_date' => date('Y-m-d'),
						             'end_date' => null,
						             'account_code' => $accountCode,
						             'sub_account_code' => $defaultSubAccountCode,
						             'branch_code' => $defaultBranchCode,
						             'department_code' => $defaultDepartmentCode,
						             'vat_id' => null,
						             'required_attachment' => false,
						            //  'interface_doc_flag' => 'N',
						             'check_ca_min' => true,
						             'ca_min_amount' => 2000,
						             'check_ca_max' => false,
						             'ca_max_amount' => null,
						             'active' => true,
						             'last_updated_by' => date('Y-m-d H:i:s'),
									 'last_update_date' => date('Y-m-d H:i:s'),
									 'last_updated_by' => -1,
									 'created_by' => -1]);

        				break;

        			case 'ค่าที่พักพนักงานไปปฏิบัติงานต่างสาขา (Accomodation fee)':

        				$subCategoryName = 'ค่าที่พักพนักงานไปปฏิบัติงานต่างสาขา (Accomodation fee)';
        				$accountCode = '19505';
        				// self::validateAccountCode('81',$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
        				array_push($lists, [
						             'ca_category_id' => $category->ca_category_id, 
						             'name' => $subCategoryName, 
						             'description' => $subCategoryName,
						             'start_date' => date('Y-m-d'),
						             'end_date' => null,
						             'account_code' => $accountCode,
						             'sub_account_code' => $defaultSubAccountCode,
						             'branch_code' => $defaultBranchCode,
						             'department_code' => $defaultDepartmentCode,
						             'vat_id' => null,
						             'required_attachment' => false,
						            //  'interface_doc_flag' => 'N',
						             'check_ca_min' => true,
						             'ca_min_amount' => 2000,
						             'check_ca_max' => false,
						             'ca_max_amount' => null,
						             'active' => true,
						             'last_updated_by' => date('Y-m-d H:i:s'),
									 'last_update_date' => date('Y-m-d H:i:s'),
									 'last_updated_by' => -1,
									 'created_by' => -1]);

        				break;

        			case 'ค่าเติมเงินบัตรทางด่วน (Express way expense)':

        				$subCategoryName = 'ค่าเติมเงินบัตรทางด่วน (Express way expense)';
        				$accountCode = '19505';
        				// self::validateAccountCode('81',$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
        				array_push($lists, [
						             'ca_category_id' => $category->ca_category_id, 
						             'name' => $subCategoryName, 
						             'description' => $subCategoryName,
						             'start_date' => date('Y-m-d'),
						             'end_date' => null,
						             'account_code' => $accountCode,
						             'sub_account_code' => $defaultSubAccountCode,
						             'branch_code' => $defaultBranchCode,
						             'department_code' => $defaultDepartmentCode,
						             'vat_id' => null,
						             'required_attachment' => false,
						            //  'interface_doc_flag' => 'N',
						             'check_ca_min' => true,
						             'ca_min_amount' => 2000,
						             'check_ca_max' => false,
						             'ca_max_amount' => null,
						             'active' => true,
						             'last_updated_by' => date('Y-m-d H:i:s'),
									 'last_update_date' => date('Y-m-d H:i:s'),
									 'last_updated_by' => -1,
									 'created_by' => -1]);

        				break;

                    case 'ค่าจัดกิจกรรม HR (HR activity expense)':

                        $subCategoryName = 'ค่าจัดกิจกรรม HR (HR activity expense)';
                        $accountCode = '19505';
                        // self::validateAccountCode('81',$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'ca_category_id' => $category->ca_category_id, 
                                     'name' => $subCategoryName, 
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => null,
                                     'required_attachment' => false,
                                    //  'interface_doc_flag' => 'N',
                                     'check_ca_min' => true,
                                     'ca_min_amount' => 2000,
                                     'check_ca_max' => false,
                                     'ca_max_amount' => null,
                                     'active' => true,
                                     'last_updated_by' => date('Y-m-d H:i:s'),
									 'last_update_date' => date('Y-m-d H:i:s'),
									 'last_updated_by' => -1,
									 'created_by' => -1]);

                        break;

                    case 'สนับสนุนกิจกรรมคู่ค้า (Support dealer and customer activity expense)':

                        $subCategoryName = 'สนับสนุนกิจกรรมคู่ค้า (Support dealer and customer activity expense)';
                        $accountCode = '19505';
                        // self::validateAccountCode('81',$accountCode,$defaultSubAccountCode,$category->name,$subCategoryName);
                        array_push($lists, [
                                     'ca_category_id' => $category->ca_category_id, 
                                     'name' => $subCategoryName, 
                                     'description' => $subCategoryName,
                                     'start_date' => date('Y-m-d'),
                                     'end_date' => null,
                                     'account_code' => $accountCode,
                                     'sub_account_code' => $defaultSubAccountCode,
                                     'branch_code' => $defaultBranchCode,
                                     'department_code' => $defaultDepartmentCode,
                                     'vat_id' => null,
                                     'required_attachment' => false,
                                    //  'interface_doc_flag' => 'N',
                                     'check_ca_min' => true,
                                     'ca_min_amount' => 2000,
                                     'check_ca_max' => false,
                                     'ca_max_amount' => null,
                                     'active' => true,
                                     'last_updated_by' => date('Y-m-d H:i:s'),
									 'last_update_date' => date('Y-m-d H:i:s'),
									 'last_updated_by' => -1,
									 'created_by' => -1]);

                        break;

        			default:
        				# code...
        				break;
    			}
    	}
    	return $lists;
    }

    private static function validateAccountCode($orgId,$accountCode,$subAccountCode,$categoryName,$subCategoryName)
    {
    	$valid = true; $errMsg = '';

    	// $fndAccountCode = FNDListOfValues::account($orgId)
    	// 						->whereFlexValue($accountCode)
    	// 						->first();
    	// $fndSubAccountCode = FNDListOfValues::subAccount($orgId)
    	// 						->byParentValue('TMITH_GL_ACCOUNT',$accountCode)
    	// 						->whereFlexValue($subAccountCode)
    	// 						->first();

    	// if(!$fndAccountCode){
    	// 	$valid = false; 
    	// 	$errMsg = 'Not found TMITH_GL_ACCOUNT = '.$accountCode;
    	// }else{
    	// 	if(!$fndSubAccountCode){
	    // 		$valid = false; 
	    // 		$errMsg = 'Not found TMITH_GL_SUB_ACCOUNT = '.$subAccountCode.' (TMITH_GL_ACCOUNT='.$accountCode.') ';
	    // 	}
    	// }

    	// if(!$valid){
    	// 	throw new \Exception('INTERFACE ERROR : Category = '.$categoryName.' | Sub-Category = '.$subCategoryName.' | '.$errMsg, 1);
    	// }
    }
}
