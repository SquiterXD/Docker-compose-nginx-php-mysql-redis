<?php

namespace App\Http\Controllers\IR\Ajax\Services\Interfaces;

use Illuminate\Foundation\Console\StorageLinkCommand;

class CarsResponseStruct
{
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
        public $insurance_expense;
        public $car_type_code;
        public $car_type;
        public $vat_percent;
        public $revenue_stamp_percent;
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
        public $location_code;
        public $location_description;
        public $tag;
        public $row_type;
        public $row_id;
}

class CarsRequestStruct
{
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
        public $insurance_expense;
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
        public $row_type;
        public $row_id;
}

interface CarsServiceInterface
{
        public function getAll(
                $year,
                $renewCode,
                $groupCode,
                $licensePlate,
                $departmentFrom,
                $departmentTo,
                $status
        );
        public function        getByID(int $id);
        public function        createOrUpdate(array $data);
        public function        update(int $id, CarsRequestStruct $detail);
        public function        destroy(int $id);
}
