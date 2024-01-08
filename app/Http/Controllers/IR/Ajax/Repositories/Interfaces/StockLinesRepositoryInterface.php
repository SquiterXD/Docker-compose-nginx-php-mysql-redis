<?php 

namespace App\Http\Controllers\IR\Ajax\Repositories\Interfaces;

use Illuminate\Foundation\Console\StorageLinkCommand;

class StockLinesStruct {
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
        public $updated_at;
        public $created_by_id;
        public $created_by;
        public $last_updated_by;
        public $creation_date;
        public $last_update_date;
}

interface StockLinesRepositoryInterface {
	public function getAll(int $headerId);
	public function	getByID(int $id);
	public function getAllFromView(int $headerId, string $programCode);
	public function getByIDFromView(int $id);
	public function	store(StockLinesStruct $detail);
	public function	update(int $id, StockLinesStruct $detail);
	public function	destroy(int $id);
}