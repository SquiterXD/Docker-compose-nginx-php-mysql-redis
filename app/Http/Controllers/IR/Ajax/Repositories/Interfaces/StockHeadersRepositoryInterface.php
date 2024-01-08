<?php 

namespace App\Http\Controllers\IR\Ajax\Repositories\Interfaces;

use DateTime;
use phpDocumentor\Reflection\Types\Float_;
use Ramsey\Uuid\Type\Decimal;

class StockHeadersStruct {
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
        public $created_at;
        public $updated_at;
        public $created_by_id;
        public $created_by;
        public $last_updated_by;
        public $creation_date;
        public $last_update_date;
}

interface StockHeadersRepositoryInterface {
	public function getAll();
	public function	getByID(int $id);
	public function getAllFromView(string $periodYear
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
	public function getByIDFromView(int $id, string $programCode);
	public function	store(StockHeadersStruct $detail);
	public function	update(int $id, StockHeadersStruct $detail);
	public function	destroy(int $id);
}