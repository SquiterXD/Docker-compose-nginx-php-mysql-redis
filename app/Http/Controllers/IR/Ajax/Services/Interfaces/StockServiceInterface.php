<?php 

namespace App\Http\Controllers\IR\Ajax\Services\Interfaces;

class StockHeadersResponseStruct {
	public $header_id;
	public $document_number;
        public $status;
        public $year;
        public $period_name;
        public $period_from;
        public $policy_set_header_id;
        public $policy_set_description;
        public $department_code;
        public $department_desc;
        public $total_amount;
	public $insurance_start_date;
	public $insurance_end_date;
	public $include_tax_flag;
        public $inventory_amount;
        public $inventory_cover_amount;
        public $inventory_insu_amount;
        public $manual_amount;
        public $manual_cover_amount;
        public $manual_insu_amount;
        public $expense_flag;
        public $reference_document_number;
        public $total_rec;
        public $total_duty_amount;
        public $total_vat_amount;
        public $total_net_amount;
        public $manual_vat_amount;
        public $manual_duty_amount;
        public $manual_net_amount;
        public $inventory_vat_amount;
        public $inventory_duty_amount;
        public $inventory_net_amount;
        public $flag;
        public $program_code;
}

class StockLinesResponseStruct {
        public $line_id;
	public $header_id;
        public $line_number;
        public $status;
        public $year;
        public $period_name;
        public $period_from;
        public $period_to;
        public $policy_set_header_id;
        public $policy_set_number;
        public $policy_set_description;
        public $department_code;
        public $department_description;
        public $org_id;
        public $sub_inventory_code;
        public $sub_inventory_desc;
        public $location_code;
        public $location_desc;
        public $organization_id;
        public $organization_code;
        public $item_id;
        public $item_code;
        public $item_description;
        public $uom;
        public $uom_code;
        public $original_quantity;
        public $unit_price;
        public $line_amount;
        public $coverage_amount;
        public $calculate_start_date;
        public $calculate_end_date;
        public $calculate_days;
        public $line_type;
        public $invent_creation_date;
        public $invent_creation_by_id;
        public $invent_creation_by_name;
        public $item_exp_account_id;
        public $item_exp_account;
        public $expense_flag;
        public $premium_rate;
        public $revenue_stamp;
        public $prepaid_insurance;
        public $tax;
        public $asset_group_code;
        public $stock_list_description;
        public $program_code;
        public $created_at;
}

class StockHeadersRequestStruct {
	public $header_id;
	public $document_number;
        public $status;
        public $year;
        public $period_name;
        public $period_from;
        public $policy_set_header_id;
        public $policy_set_description;
        public $department_code;
        public $department_desc;
        public $total_amount;
        public $total_cover_amount;
        public $total_insu_amount;
        public $manual_amount;
        public $manual_cover_amount;
        public $manual_insu_amount;
        public $inventory_amount;
        public $inventory_cover_amount;
        public $inventory_insu_amount;
        public $expense_flag;
        public $item_exp_account_id;
        public $program_code;
}

class StockLinesRequestStruct {
        public $line_id;
	public $header_id;
        public $line_number;
        public $status;
        public $year;
        public $period_name;
        public $period_from;
        public $period_to;
        public $policy_set_header_id;
        public $policy_set_description;
        public $department_code;
        public $department_description;
        public $org_id;
        public $sub_inventory_code;
        public $sub_inventory_desc;
        public $location_code;
        public $location_desc;
        public $organization_id;
        public $organization_code;
        public $item_id;
        public $item_code;
        public $item_description;
        public $uom;
        public $uom_code;
        public $original_quantity;
        public $unit_price;
        public $line_amount;
        public $coverage_amount;
        public $calculate_start_date;
        public $calculate_end_date;
        public $calculate_days;
        public $line_type;
        public $invent_creation_date;
        public $invent_creation_by_id;
        public $invent_creation_by_name;
        public $item_exp_account_id;
        public $item_exp_account;
        public $expense_flag;
        public $premium_rate;
        public $revenue_stamp;
        public $prepaid_insurance;
        public $tax;
        public $asset_group_code;
        public $stock_list_description;
        public $program_code;
        public $flag;
}

class StockRequestStruct {
        public $header_id;
        public $document_number;
        public $expense_flag;
        public $status;
        public $program_code;
        public $rows;
}

interface StockServiceInterface {
	public function getAll(string $periodYear
		              ,string $periodName
		              ,string $startDate
		              ,string $endDate
		              ,int $policySetHeaderId
		              ,string $status
		              ,string $periodFrom
		              ,string $periodTo
		              ,string $departmentFrom
		              ,string $departmentTo
		              ,string $programCode);

	public function	getByID(int $id, string $program_code);
	public function	createOrUpdate(StockRequestStruct $detail);
	public function	update(int $id, StockLinesRequestStruct $detail, string $flag);
	public function	destroy(int $id);
}