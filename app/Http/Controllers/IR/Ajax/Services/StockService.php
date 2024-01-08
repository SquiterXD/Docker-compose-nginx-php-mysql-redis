<?php 

namespace App\Http\Controllers\IR\Ajax\Services;

use App\Http\Controllers\IR\Ajax\Repositories\Interfaces\StockHeadersRepositoryInterface;
use App\Http\Controllers\IR\Ajax\Repositories\Interfaces\StockHeadersStruct;
use App\Http\Controllers\IR\Ajax\Repositories\Interfaces\StockLinesRepositoryInterface;
use App\Http\Controllers\IR\Ajax\Repositories\Interfaces\StockLinesStruct;
use App\Http\Controllers\IR\Ajax\Services\Interfaces\StockHeadersResponseStruct;
use App\Http\Controllers\IR\Ajax\Services\Interfaces\StockLinesRequestStruct;
use App\Http\Controllers\IR\Ajax\Services\Interfaces\StockLinesResponseStruct;
use App\Http\Controllers\IR\Ajax\Services\Interfaces\StockRequestStruct;
use App\Http\Controllers\IR\Ajax\Services\Interfaces\StockServiceInterface;
use App\Models\IR\PtirWebUtilitiesPkg;
use App\Models\IR\Settings\PtirAccountsMapping;
use App\Models\IR\Settings\PtirGroupProducts;
use App\Models\IR\Settings\PtirPolicyGroupSets;
use App\Models\IR\Views\GlPeriodYearView;
use App\Models\IR\Views\PtBiweeklyView;
use App\Models\IR\PtirStockLines;
use Carbon\Carbon;
use DateTime;
use stdClass;

use App\Models\IR\Views\PtirItemView;

class StockService implements StockServiceInterface {
	private $headerRepo;
	private $lineRepo;
	private $userID;

	public function __construct(StockHeadersRepositoryInterface $headerRepo, StockLinesRepositoryInterface $lineRepo)
	{
		$this->headerRepo = $headerRepo;	
		$this->lineRepo   = $lineRepo;
		$this->userID     = optional(auth()->user())->user_id ?? -1;
	}

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
			       ,string $programCode)
	{
		$stocks = $this->headerRepo->getAllFromView($periodYear
							    ,$periodName
							    ,$startDate
							    ,$endDate
							    ,$policySetHeaderId
							    ,$status
							    ,$periodFrom
							    ,$periodTo
							    ,$departmentFrom
							    ,$departmentTo
							    ,$programCode);

		$response = array();
		foreach($stocks as $stock) {
			$stockResponse = new StockHeadersResponseStruct();
			$stockResponse->header_id 		  = $stock->header_id;
			$stockResponse->document_number 	  = $stock->document_number;
        	   	$stockResponse->status 			  = strtoupper($stock->status);
        	        $stockResponse->period_year 		  = $stock->period_year;
        	        $stockResponse->period_name 		  = $stock->period_name;
        	   	$stockResponse->period_from 		  = (new DateTime($stock->period_from))->format('m/Y');
        	   	$stockResponse->period_to 		  = (new DateTime($stock->period_to))->format('m/Y');
        	   	$stockResponse->policy_set_header_id 	  = $stock->policy_set_header_id;
        	   	$stockResponse->policy_set_number 	  = optional($stock->policy)->policy_set_number;
        	   	$stockResponse->policy_set_description 	  = $stock->policy_set_description;
        	   	$stockResponse->department_code 	  = $stock->department_code;
        	   	$stockResponse->department_desc 	  = $stock->department_desc;
        	   	$stockResponse->total_amount 		  = $stock->total_amount;
		   	$stockResponse->insurance_start_date 	  = (new DateTime(optional($stock->effectiveDate)->start_date_active))->format('d/m/Y'); 
		   	$stockResponse->insurance_end_date   	  = (new DateTime(optional($stock->effectiveDate)->start_date_active))->add(new \DateInterval('P12M'))->format('d/m/Y'); 
		   	$stockResponse->include_tax_flag 	  = $stock->include_tax_flag;
        	   	$stockResponse->inventory_amount 	  = $stock->inventory_amount;
        	   	$stockResponse->inventory_cover_amount    = $stock->inventory_cover_amount;
        	   	$stockResponse->inventory_insu_amount     = $stock->inventory_insu_amount;
        	   	$stockResponse->manual_amount 		  = $stock->manual_amount;
        	   	$stockResponse->manual_cover_amount       = $stock->manual_cover_amount;
        	   	$stockResponse->manual_insu_amount 	  = $stock->manual_insu_amount;
        	   	$stockResponse->expense_flag 	          = isset($stock->expense_flag) ? $stock->expense_flag : 'N';
        	   	$stockResponse->reference_document_number = $stock->reference_document_number;
        	   	$stockResponse->total_rec   		  = $stock->line_count;
        	   	$stockResponse->total_duty_amount 	  = $stock->total_duty_amount;
        	   	$stockResponse->total_cover_amount 	  = $stock->total_cover_amount;
        	   	$stockResponse->total_insu_amount 	  = $stock->total_insu_amount;
        	   	$stockResponse->total_vat_amount 	  = $stock->total_vat_amount;
        	   	$stockResponse->total_net_amount 	  = $stock->total_net_amount;
        	   	$stockResponse->manual_vat_amount  	  = $stock->manual_vat_amount;
        	   	$stockResponse->manual_duty_amount  	  = $stock->manual_duty_amount;
        	   	$stockResponse->manual_net_amount 	  = $stock->manual_net_amount;
        	   	$stockResponse->inventory_vat_amount 	  = $stock->inventory_vat_amount;
        	   	$stockResponse->inventory_duty_amount  	  = $stock->inventory_duty_amount;
        	   	$stockResponse->inventory_net_amount 	  = $stock->inventory_net_amount;
			array_push($response, $stockResponse);
		}

		return getResponse($response);
	}

	public function	getByID(int $id, string $programCode) {
		$stock    = $this->headerRepo->getByIDFromView($id, $programCode);
		
		if ($stock == null) {
			return error('data not found', 500);
		}
		$date = (new GlPeriodYearView())->getByYear($stock->period_year);
		if ($date == null) {
			$date->start_date = '';
			$date->end_date = '';
		}
		$arrLine  = array();
		foreach($stock->stockLine as $index => $line) {
			$lineResponse = new StockLinesResponseStruct();
			$lineResponse->header_id 	      = $line->header_id;
			$lineResponse->line_id 		      = $line->line_id;
			$lineResponse->line_number 	      = $line->line_number;
			$lineResponse->period_year 	      = $stock->period_year;
			$lineResponse->status 		      = strtoupper($line->status);
			$lineResponse->period_from            = (new DateTime($line->period_from))->format('m/Y');
			$lineResponse->period_to 	      = (new DateTime($line->period_to))->format('m/Y');
			$lineResponse->policy_set_header_id   = $stock->policy_set_header_id;
			$lineResponse->policy_set_number      = $stock->policy->policy_set_number;
			$lineResponse->policy_set_description = $stock->policy_set_description;
			$lineResponse->department_code 	      = $stock->department_code;
			$lineResponse->department_description = $stock->department_description;
			$lineResponse->organization_id        = $line->organization_id;
			$lineResponse->organization_code      = $line->organization_code;
			$lineResponse->organization_name      = $line->organization_name;
			$lineResponse->subinventory_code      = $line->subinventory_code;
			$lineResponse->subinventory_desc      = $line->subinventory_desc;
			$lineResponse->sub_group_code 	      = $line->sub_group_code;
			$lineResponse->sub_group_desc 	      = $line->sub_group_desc;
			$lineResponse->item_id 	              = $line->item_id;
			$lineResponse->item_code 	      = $line->item_code;
			$lineResponse->item_description       = $line->item_description;
			$lineResponse->uom 		      = isset(optional($line->uomData)->description) ? optional($line->uomData)->description : '';
			$lineResponse->uom_code 	      = isset(optional($line->uomData)->uom_code) ? optional($line->uomData)->uom_code : '';
			$lineResponse->original_qty 	      = $line->original_qty;
			$lineResponse->unit_price 	      = $line->unit_price;
			$lineResponse->amount                 = $line->amount;
			$lineResponse->coverage_amount        = $line->coverage_amount;
			$lineResponse->calculate_start_date   = isset($line->calculate_start_date) ?  (new DateTime($line->calculate_start_date))->format('d/m/Y') :  (new DateTime($date->start_date))->format('d/m/Y');
			$lineResponse->calculate_end_date     = isset($line->calculate_end_date) ? (new DateTime($line->calculate_end_date))->format('d/m/Y') : (new DateTime($date->end_date))->format('d/m/Y') ;
			$lineResponse->line_type 	      = $line->line_type;
			$lineResponse->creation_date          = $line->creation_date;
			$lineResponse->created_by 	      = $line->created_by;
			$lineResponse->line_amount 	      = $line->line_amount;
			$lineResponse->period_name 	      = $line->period_name;
			$lineResponse->calculate_days 	      = $line->calculate_days;
			$lineResponse->premium_rate 	      = $line->premium_rate;
			$lineResponse->revenue_stamp 	      = $line->revenue_stamp;
			$lineResponse->tax 	              = $line->tax;
			$lineResponse->prepaid_insurance      = $line->prepaid_insurance;
			$lineResponse->asset_group_code       = $line->asset_group_code;
			$lineResponse->asset_group_name       = optional($line->assetGroup)->description;
			$lineResponse->include_tax_flag       = $stock->include_tax_flag;
			$lineResponse->stock_list_description = $line->stock_list_description; 
			$lineResponse->expense_flag           = isset($line->expense_flag) ? $line->expense_flag : 'N';
			$lineResponse->flag 		      = 'update';
			$lineResponse->created_at	      = parseToDateTh($line->created_at);

			array_push($arrLine, $lineResponse);
		}

		$obj = new stdClass();
		$obj->header_id       = isset($stock->header_id) ? $stock->header_id : '';
		$obj->document_number = isset($stock->document_number) ? $stock->document_number : '';
		$obj->expense_flag    = isset($stock->expense_flag) ? $stock->expense_flag : '';
		$obj->status          = isset($stock->status) ? $stock->status : '';
		$obj->rows            = $arrLine;

		return getResponse($obj);
	}

	public function	createOrUpdate(StockRequestStruct $detail) {

		$amountInventory   = 0;
		$amountManual      = 0;
		$amountTotal       = 0;
		$coverageInventory = 0;
		$coverageManual    = 0;
		$coverageTotal     = 0;
		$premiumInventory  = 0;
		$premiumManual     = 0;
		$premiumTotal      = 0;
		$dutyInventory     = 0;
		$dutyManual        = 0;
		$dutyTotal         = 0;
		$vatInventory      = 0;
		$vatManual         = 0;
		$vatTotal          = 0;
		$netInventory      = 0;
		$netManual         = 0;
		$netTotal          = 0;
		$lineData          = [];
		$headerId          = '';
		$documentNumber    = '';

		$now = Carbon::now();

		foreach($detail->rows as $index => $line) {
			$item = PtirItemView::where('item_code', $line->item_code)->first();

			if($line->line_type === 'INVENTORY'){
				$stock = PtirStockLines::find($line->line_id);
				$stock->header_id 	        	= $detail->header_id;
				$stock->line_id                 = $line->line_id;
				$stock->line_number             = $line->line_number;
				$stock->status                  = $line->status;
				$stock->line_amount             = $line->line_amount;
				$stock->coverage_amount         = $line->coverage_amount;
				$stock->expense_flag            = $line->expense_flag;
				$stock->last_updated_by			= $this->userID;
				$stock->updated_at				= $now;
				$stock->last_update_date		= $now;
				$stock->save();
			}else {
				$stock = new StockLinesStruct();
				$stock->header_id				= $detail->header_id;
				$stock->line_id					= $line->line_id; 
				$stock->line_number				= $line->line_number; 
				$stock->line_type               = $line->line_type;
				$stock->document_number         = $line->document_number; 
				$stock->status                  = $line->status; 
				$stock->year                    = $line->year; 
				$stock->period_name             = $line->period_name; 
				$stock->period_from             = $line->period_from; 
				$stock->period_to               = $line->period_to; 
				$stock->policy_set_header_id    = $line->policy_set_header_id; 
				$stock->policy_set_description  = $line->policy_set_description; 
				$stock->department_code    		= $detail->department_code; 
				$stock->department_description  = $detail->department_desc; 
				$stock->org_id                  = $line->org_id; 
				$stock->sub_inventory_code      = $line->sub_inventory_code; 
				$stock->sub_inventory_desc      = $line->sub_inventory_desc; 
				$stock->location_code           = $line->location_code; 
				$stock->location_desc           = $line->location_desc; 
				$stock->item_id                 = $line->item_id; 
				$stock->item_code               = $line->item_code; 
				$stock->item_description        = $line->item_description; 
				$stock->uom_code                = $item ? $item->uom_code : ''; 
				$stock->original_quantity       = $line->original_quantity; 
				$stock->unit_price              = $line->unit_price; 
				$stock->line_amount             = $line->line_amount; 
				$stock->coverage_amount         = $line->coverage_amount; 
				$stock->calculate_start_date    = $line->calculate_start_date; 
				$stock->calculate_end_date      = $line->calculate_end_date; 
				$stock->calculate_days          = $line->calculate_days; 
				$stock->invent_creation_date    = $line->invent_creation_date; 
				$stock->invent_creation_by_id   = $line->invent_creation_by_id; 
				$stock->invent_creation_by_name = $line->invent_creation_by_name; 
				$stock->organization_id         = $line->organization_id; 
				$stock->organization_code       = $line->organization_code; 
				$stock->expense_flag            = $line->expense_flag; 
				$stock->asset_group_code        = $line->asset_group_code; 
				$stock->stock_list_description  = $line->stock_list_description; 
				$stock->premium_rate            = $line->premium_rate; 
				$stock->revenue_stamp           = $line->revenue_stamp; 
				$stock->tax                     = $line->tax; 
				$stock->prepaid_insurance       = $line->prepaid_insurance; 
				$stock->program_code            = $detail->program_code; 
				$stock->created_at				= $now;
				$stock->created_by_id			= $this->userID;
				$stock->created_by				= $this->userID;
				$stock->last_updated_by			= $this->userID;
				$stock->updated_at				= $now;
				$stock->creation_date			= $now;
				$stock->last_update_date		= $now;
			}

			if ($stock->item_exp_account_id == '') {
				$groupProduct = (new PtirGroupProducts())->getAccountId($stock->policy_set_header_id, $stock->asset_group_code, $stock->stock_list_description);
				$stock->item_exp_account_id     = isset($groupProduct->account_id) ? $groupProduct->account_id : '';
			}

			if ($stock->item_exp_account == '') {
				$accountMapping = (new PtirAccountsMapping())->getAccount($stock->item_exp_account_id);
				$stock->item_exp_account     = isset($accountMapping->account_combine) ? $accountMapping->account_combine : '';
			}

			$stock->invent_creation_date    = $now;
			$stock->invent_creation_by_id   = $this->userID;
			$stock->invent_creation_by_name = $this->userID;
			
			if ($stock->premium_rate == '') {
				$rate = (new PtirPolicyGroupSets())->getPremiumRate($stock->policy_set_header_id, '', '', $stock->year);
				if ($rate != null) {
					$stock->premium_rate 	  = $rate->premium_rate;
					$stock->revenue_stamp 	  = $rate->revenue_stamp;
					$stock->tax 		  = $rate->tax;
					$stock->prepaid_insurance = $rate->prepaid_insurance;
				}
			}

			if ($line->flag == 'update') {
				if($line->line_type === 'INVENTORY'){
					$stockLine = 'updated';
					$stock->save();
				}else {
					$stockLine = $this->lineRepo->update((int)$stock->line_id, $stock);
				}
				$stock->flag                    = $line->flag;
				$stock->row_id                  = $line->row_id;

				$lineData[$index]['line_id'] = $stock->line_id;
				$lineData[$index]['row_id']  = $stock->row_id;
				
			} else if ($line->flag == 'add') {
				$stockLine = $this->lineRepo->store($stock);
				$stock->flag                    = $line->flag;
				$stock->row_id                  = $line->row_id;

				$lineData[$index]['line_id'] = $stockLine->line_id;
				$lineData[$index]['row_id']  = $stock->row_id;
			}

			if ($stockLine == 'E') {
				return error();
			}

			$periodName = date("Y-m-t", strtotime($stock->period_name));
			$explode = explode('-', $periodName);
			if ($stock->line_type == 'INVENTORY' and $stock->status == 'CONFIRMED' || $stock->status == 'INTERFACE')
			{
			    $amountInventory   = $amountInventory + $stock->line_amount;
			    $coverageInventory = $coverageInventory + $stock->coverage_amount; 
			    if ($stock->program_code == 'IRP0001') {
				$premiumCal        = (($stock->coverage_amount * $stock->premium_rate)/100);
			    } else {
					// $premiumCal        = 0;
					$premiumCal        = ((($stock->coverage_amount * $stock->premium_rate)/100) * $explode[2] / (date("z", mktime(0,0,0,12,31,$stock->year))+1));
			    }
			    $premiumInventory  = $premiumInventory + $premiumCal;
			    $dutyCal           = ($premiumCal * $stock->revenue_stamp) / 100;
			    $dutyInventory     = $dutyInventory + $dutyCal; 
			    $vatCal            = (($premiumCal + $dutyCal) *  $stock->tax) / 100;
			    $vatInventory      = $vatInventory + $vatCal; 
			    // $netInventory      = $netInventory + $premiumCal + $dutyCal + $vatCal;
				$netInventory      = round($premiumInventory, 2) + round($dutyInventory, 2) + round($vatInventory, 2);
			}
			else if ($stock->line_type == 'MANUAL' and $stock->status == 'CONFIRMED' || $stock->status == 'INTERFACE')
			{
			    $amountManual   = $amountManual + $stock->line_amount;
			    $coverageManual = $coverageManual + $stock->coverage_amount; 
			    $premiumCal     = (((($stock->coverage_amount * $stock->premium_rate)/100) * $stock->calculate_days) / (date("z", mktime(0,0,0,12,31,$stock->year))+1));                
				$premiumManual  = $premiumManual + $premiumCal;
			    $dutyCal        = ($premiumCal * $stock->revenue_stamp) / 100;
			    $dutyManual     = $dutyManual + $dutyCal;
			    $vatCal         = (($premiumCal + $dutyCal) *  $stock->tax) / 100;
			    $vatManual      = $vatManual + $vatCal; 
			    $netManual      += $premiumCal + $dutyCal + $vatCal;
			}
		}

		$amountTotal     = $amountTotal + round($amountInventory, 2) + round($amountManual, 2);
		$coverageTotal   = $coverageTotal + round($coverageInventory, 2) + round($coverageManual, 2);
		$premiumTotal    = $premiumTotal + round($premiumManual, 2) + round($premiumInventory, 2);
		$dutyTotal      += round($dutyInventory, 2) + round($dutyManual, 2);
		$vatTotal       += round($vatInventory, 2) + round($vatManual, 2);
		$netTotal       += round($netInventory, 2) + round($netManual, 2);

		if ($detail->document_number == '') {
			$detail->document_number = (new PtirWebUtilitiesPkg())->genDocumentNumber($detail->program_code, $detail->header_id)['document_number'];
		}

		$header = new StockHeadersStruct();
		$header->status                 = $detail->status;
		$header->document_number        = $detail->document_number;
		$header->expense_flag           = $detail->expense_flag;
		$header->total_amount           = $amountTotal;
		$header->total_cover_amount     = $coverageTotal;
		$header->total_insu_amount      = $premiumTotal;
		$header->manual_amount          = $amountManual;
		$header->manual_cover_amount    = $coverageManual;
		$header->manual_insu_amount     = $premiumManual;
		$header->inventory_amount       = $amountInventory;
		$header->inventory_cover_amount = $coverageInventory;
		$header->inventory_insu_amount  = $premiumInventory;
		$header->manual_vat_amount      = $vatManual;
		$header->manual_duty_amount     = $dutyManual;
		$header->manual_net_amount      = $netManual;
		$header->inventory_vat_amount   = $vatInventory;
		$header->inventory_duty_amount  = $dutyInventory;
		$header->inventory_net_amount   = $netInventory;
		$header->total_duty_amount      = $dutyTotal;
		$header->total_vat_amount       = $vatTotal;
		$header->total_net_amount       = $netTotal;
		$header->updated_at             = Carbon::now();
		$header->last_updated_by        = $this->userID;
		$header->last_update_date       = Carbon::now();

		$header = $this->headerRepo->update($detail->header_id, $header);

		if ($header == 'E') {
			return error();
		}

		$obj = new \stdClass();
		$obj->header_id = $detail->header_id;
		$obj->document_number = $detail->document_number;
		$obj->rows = $lineData;

		return success($obj);
	}

	public function	update(int $id, StockLinesRequestStruct $detail, string $flag) {

	}

	public function	destroy(int $id) {

	}
}