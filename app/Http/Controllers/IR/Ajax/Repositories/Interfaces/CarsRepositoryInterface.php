<?php 

namespace App\Http\Controllers\IR\Ajax\Repositories\Interfaces;

use Illuminate\Foundation\Console\StorageLinkCommand;

class CarsStruct {
        public $car_id;
        public $document_number;
        public $status;
        public $asset_status;
        public $year;
        public $renew_type_code;
        public $renew_type;
        public $start_date;
        public $end_date;
        public $total_days;
        public $department_code;
        public $department_name;
        public $license_plate;
        public $group_code;
        public $group_name;
        public $insurance_amount;
        public $discount;
        public $duty_amount;
        public $vat_amount;
        public $net_amount;
        public $vat_refund;
        public $car_type_code;
        public $car_type;
        public $policy_number;
        public $company_id;
        public $company_name;
        public $asset_number;
        public $asset_description;
        public $date_placed_in_service;
        public $expense_account_id;
        public $expense_account;
        public $expense_account_desc;
        public $prepaid_account_id;
        public $prepaid_account;
        public $prepaid_account_desc;
        public $policy_set_header_id;
        public $policy_set_description;
        public $car_brand_code;
        public $car_brand;
        public $car_cc;
        public $engine_number;
        public $tank_number;
        public $line_type;
        public $receivable_code;
        public $receivable_name;
        public $expense_flag;
        public $program_code;
        public $created_at;
        public $updated_at;
        public $created_by_id;
        public $created_by;
        public $last_updated_by;
        public $creation_date;
        public $last_update_date;
}

interface CarsRepositoryInterface {
	public function getAll();
	public function	getByID(int $id);
	public function getAllFromView($year, 
                                       $renewCode, 
                                       $groupCode, 
                                       $licensePlate, 
                                       $departmentFrom,
                                       $departmentTo, 
                                       $status);
	public function getByIDFromView(int $id);
	public function	store(CarsStruct $detail);
	public function	update(int $id, CarsStruct $detail);
	public function	destroy(int $id);
}