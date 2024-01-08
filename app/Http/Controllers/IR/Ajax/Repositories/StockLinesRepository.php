<?php 

namespace App\Http\Controllers\IR\Ajax\Repositories;

use App\Http\Controllers\IR\Ajax\Repositories\Interfaces\StockLinesRepositoryInterface;
use App\Http\Controllers\IR\Ajax\Repositories\Interfaces\StockLinesStruct;
use App\Models\IR\PtirStockLines;
use App\Models\IR\Views\PtirStockLinesView;
use Illuminate\Support\Facades\DB;

class StockLinesRepository implements StockLinesRepositoryInterface {
	public function getAll(int $headerId) {
		$stocks = PtirStockLines::all();
		
		return $stocks;
	}

	public function	getByID(int $id) {
		$stock = PtirStockLines::find($id);

		return $stock;
	}

	public function	getAllFromView(int $headerId, string $programCode) 
	{

		$stocks = new PtirStockLinesView();

		if ($programCode != '') {
			$stocks->where('program_code', $programCode);
		}

		$stocks = $stocks->orderBy('line_type', 'ASC')
				 ->orderBy('line_id', 'ASC')				 
				 ->get();

		return $stocks;
	}

	public function	getByIDFromView(int $id) {
		$stock = PtirStockLinesView::find($id);	

		return $stock;
	}

	public function	store(StockLinesStruct $detail) {
		DB::beginTransaction();
		try {
			$stock = new PtirStockLines();
			$stock->header_id 	        = $detail->header_id;
			$stock->line_number 	        = $detail->line_number;
			$stock->status 		        = $detail->status;
			$stock->year 		       	= $detail->year;
			$stock->period_name 	        = $detail->period_name; 
			$stock->period_from 	        = $detail->period_from;
			$stock->period_to 	        = $detail->period_to;
			$stock->policy_set_header_id    = $detail->policy_set_header_id;
			$stock->policy_set_description  = $detail->policy_set_description;
			$stock->department_code         = $detail->department_code;
			$stock->department_description  = $detail->department_description;
			$stock->org_id  	        = $detail->org_id;
			$stock->sub_inventory_code      = $detail->sub_inventory_code;
			$stock->sub_inventory_desc      = $detail->sub_inventory_desc;
			$stock->location_code 	        = $detail->location_code;
			$stock->location_desc           = $detail->location_desc;
			$stock->organization_id         = $detail->organization_id;
			$stock->organization_code       = $detail->organization_code;
			$stock->item_id 	        = $detail->item_id;
			$stock->item_code 	        = $detail->item_code;
			$stock->item_description        = $detail->item_description;
			$stock->uom_code 	        = $detail->uom_code;
			$stock->original_quantity       = $detail->original_quantity;
			$stock->unit_price 	        = $detail->unit_price;
			$stock->line_amount 	        = $detail->line_amount;
			$stock->coverage_amount         = $detail->coverage_amount;
			$stock->calculate_start_date    = $detail->calculate_start_date;
			$stock->calculate_end_date      = $detail->calculate_end_date;
			$stock->calculate_days          = $detail->calculate_days;
			$stock->line_type 	        = $detail->line_type;
			$stock->invent_creation_by_id  	= $detail->invent_creation_by_id;
			$stock->invent_creation_by_name = $detail->invent_creation_by_name;
			$stock->item_exp_account_id     = $detail->item_exp_account_id;
			$stock->item_exp_account        = $detail->item_exp_account;
			$stock->expense_flag 		= $detail->expense_flag;
			$stock->premium_rate 		= $detail->premium_rate;
			$stock->revenue_stamp 	  	= $detail->revenue_stamp;
			$stock->prepaid_insurance 	= $detail->prepaid_insurance;
			$stock->tax 			= $detail->tax;
			$stock->asset_group_code 	= $detail->asset_group_code;
			$stock->stock_list_description	= $detail->stock_list_description;
			$stock->program_code 		= $detail->program_code;
			$stock->created_at 		= $detail->created_at;
			$stock->updated_at 		= $detail->updated_at;
			$stock->created_by_id 		= $detail->created_by_id;
			$stock->created_by 		= $detail->created_by;
			$stock->last_updated_by 	= $detail->last_updated_by;
			$stock->creation_date 		= $detail->creation_date;
			$stock->last_update_date 	= $detail->last_update_date;
			$stock->save();

			DB::commit();

		} catch (\Exception $e) {
			dd($e);
			DB::rollBack();

			return 'E';
		}

		return $stock;
	}

	public function	update(int $id, StockLinesStruct $detail) {
		DB::beginTransaction();
		try {
			$stock = PtirStockLines::where('line_id', $id);
			$stock->update([
				'status' 		  => $detail->status,
				'year' 		       	  => $detail->year,
				'period_name' 	          => $detail->period_name, 
				'period_from' 	          => $detail->period_from,
				'period_to' 	          => $detail->period_to,
				'policy_set_header_id'    => $detail->policy_set_header_id,
				'policy_set_description'  => $detail->policy_set_description,
				'department_code'         => $detail->department_code,
				'department_description'  => $detail->department_description,
				'org_id'  	          => $detail->org_id,
				'sub_inventory_code'      => $detail->sub_inventory_code,
				'sub_inventory_desc'      => $detail->sub_inventory_desc,
				'location_code'           => $detail->location_code,
				'location_desc'           => $detail->location_desc,
				'organization_id'         => $detail->organization_id,
				'organization_code'       => $detail->organization_code,
				'item_id' 	          => $detail->item_id,
				'item_code' 	          => $detail->item_code,
				'item_description'        => $detail->item_description,
				'uom_code' 	          => $detail->uom_code,
				'original_quantity'       => $detail->original_quantity,
				'unit_price' 	          => $detail->unit_price,
				'line_amount' 	          => $detail->line_amount,
				'coverage_amount'         => $detail->coverage_amount,
				'calculate_start_date'    => $detail->calculate_start_date,
				'calculate_end_date'      => $detail->calculate_end_date,
				'calculate_days'          => $detail->calculate_days,
				'line_type' 	          => $detail->line_type,
				'invent_creation_by_id'   => $detail->invent_creation_by_id,
				'invent_creation_by_name' => $detail->invent_creation_by_name,
				'item_exp_account_id'     => $detail->item_exp_account_id,
				'item_exp_account'        => $detail->item_exp_account,
				'expense_flag' 		  => $detail->expense_flag,
				'premium_rate' 	    	  => $detail->premium_rate,
				'revenue_stamp' 	  => $detail->revenue_stamp,
				'prepaid_insurance' 	  => $detail->prepaid_insurance,
				'tax' 			  => $detail->tax,
				'asset_group_code' 	  => $detail->asset_group_code,
				'stock_list_description'  => $detail->stock_list_description,
				'updated_at' 		  => $detail->updated_at,
				'last_updated_by' 	  => $detail->last_updated_by,
				'last_update_date' 	  => $detail->last_update_date,
			]);

			DB::commit();

		} catch (\Exception $e) {
			DB::rollBack();
			dd($e);
			return 'E';
		}

		return 'updated';
	}

	public function	destroy(int $id) {
		DB::beginTransaction();
		try {
			PtirStockLines::where('line_id', $id)->delete();

			DB::commit();
			
		} catch (\Exception $e) {
			DB::rollBack();
			
			return 'E';
		}

		return 'deleted';
	}
}