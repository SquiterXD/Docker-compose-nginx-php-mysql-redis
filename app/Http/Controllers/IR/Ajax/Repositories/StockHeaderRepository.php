<?php 

namespace App\Http\Controllers\IR\Ajax\Repositories;

use App\Http\Controllers\IR\Ajax\Repositories\Interfaces\StockHeadersRepositoryInterface;
use App\Http\Controllers\IR\Ajax\Repositories\Interfaces\StockHeadersStruct;
use App\Models\IR\PtirStockHeaders;
use App\Models\IR\Views\PtirStockHeadersView;
use Illuminate\Support\Facades\DB;

class StockHeaderRepository implements StockHeadersRepositoryInterface {
	public function getAll() {
		$stocks = PtirStockHeaders::all();
		
		return $stocks;
	}

	public function	getByID(int $id) {
		$stock = PtirStockHeaders::find($id);

		return $stock;
	}

	public function	getAllFromView($periodYear
				       ,$periodName
				       ,$startDate
				       ,$endDate
				       ,$policySetHeaderId
				       ,$status
				       ,$periodFrom
				       ,$periodTo
				       ,$departmentFrom
				       ,$departmentTo
				       ,$programCode) 
	{
		$stocks = PtirStockHeadersView::where('program_code', $programCode)
		->when($periodYear, function ($q, $periodYear){
			return $q->where('period_year', $periodYear);
		})
		->when($periodName, function ($q, $periodName){
			return $q->whereRaw("to_char(to_date(period_name, 'MON-yy'), 'mm/yyyy') = ? ", [$periodName]);
		})
		->when($startDate && $endDate, function ($q) use($startDate, $endDate) {
			return $q->whereRaw("insurance_start_date >= to_date(?, 'dd/mm/yyyy')
			and insurance_end_date <= to_date(?, 'dd/mm/yyyy')", [$startDate, $endDate]);
		})
		->when($policySetHeaderId, function ($q, $policySetHeaderId){
			return $q->where('policy_set_header_id', $policySetHeaderId);
		})
		->when($status, function($q, $status){
			return $q->where('status', $status);
		})
		->when($periodFrom && $periodTo, function ($q) use($periodFrom , $periodTo) {
			return $q->whereRaw("period_from >= to_date(?, 'mm/yyyy')
			and trunc(period_to) <= nvl(last_day(to_date(?, 'mm/yyyy')), trunc(period_to))", [$periodFrom, $periodTo]);
		})
		->when($departmentFrom, function($q) use($departmentFrom, $departmentTo) {
			return $q->whereRaw("department_code between ? and nvl(?, department_code)", [$departmentFrom, $departmentTo]);
		})
		->when($programCode === 'IRP0001', function($q) {
			return $q->orderByRaw("document_number ASC nulls last, policy_set_header_id ASC, department_code ASC");
		})
		->when($programCode === 'IRP0002', function($q) {
			return $q->orderByRaw("document_number ASC nulls last, policy_set_header_id ASC, department_code ASC, to_date(period_name, 'MON-yy') ASC");
		})
		->with('policy', 'effectiveDate')
		->get();

		return $stocks;
	}

	public function	getByIDFromView(int $id, string $programCode) {
		$stock = PtirStockHeadersView::where('header_id', $id)
					     ->where('program_code', $programCode)	
					     ->first();

		return $stock;
	}

	public function	store(StockHeadersStruct $detail) {
		DB::beginTransaction();
		try {
			$stock = new PtirStockHeaders();
			$stock->header_id              = $detail->header_id;
			$stock->document_number        = $detail->document_number;
			$stock->status                 = $detail->status;
			$stock->year                   = $detail->year;
			$stock->period_name            = $detail->period_name;
			$stock->period_from            = $detail->period_from;
			$stock->period_to              = $detail->period_to;
			$stock->policy_set_header_id   = $detail->policy_set_header_id;
			$stock->policy_set_description = $detail->policy_set_description;
			$stock->department_code        = $detail->department_code;
			$stock->department_desc        = $detail->department_desc;
			$stock->total_amount           = $detail->total_amount;
			$stock->total_cover_amount     = $detail->total_cover_amount;
			$stock->total_insu_amount      = $detail->total_insu_amount;
			$stock->manual_amount          = $detail->manual_amount;
			$stock->manual_cover_amount    = $detail->manual_cover_amount;
			$stock->manual_insu_amount     = $detail->manual_insu_amount;
			$stock->inventory_amount       = $detail->inventory_amount;
			$stock->inventory_cover_amount = $detail->inventory_cover_amount;
			$stock->inventory_insu_amount  = $detail->inventory_insu_amount;
			$stock->expense_flag           = $detail->expense_flag;
			$stock->rows                   = $detail->rows;
			$stock->program_code           = $detail->program_code;
			$stock->created_at             = $detail->created_at;
			$stock->created_by_id          = $detail->created_by_id;
			$stock->created_by             = $detail->created_by;
			$stock->last_updated_by        = $detail->last_updated_by;
			$stock->update_at              = $detail->update_at;
			$stock->creation_date          = $detail->creation_at;
			$stock->last_update_date       = $detail->last_update_date;
			$stock->save();

			DB::commit();

		} catch (\Exception $e) {
			DB::rollBack();

			return 'E';
		}

		return $stock;
	}

	public function	update(int $id, StockHeadersStruct $detail) {
		DB::beginTransaction();
		try {
			$stock = PtirStockHeaders::where('header_id', $id)
				 		->update([
							'status'                 => $detail->status,
							'document_number'        => $detail->document_number,
							'expense_flag'           => $detail->expense_flag,
							'total_amount'           => $detail->total_amount,
							'total_cover_amount'     => $detail->total_cover_amount,
							'total_insu_amount'      => $detail->total_insu_amount,
							'manual_amount'          => $detail->manual_amount,
							'manual_cover_amount'    => $detail->manual_cover_amount,
							'manual_insu_amount'     => $detail->manual_insu_amount,
							'inventory_amount'       => $detail->inventory_amount,
							'inventory_cover_amount' => $detail->inventory_cover_amount,
							'inventory_insu_amount'  => $detail->inventory_insu_amount,
							'manual_vat_amount'      => $detail->manual_vat_amount,
							'manual_duty_amount'     => $detail->manual_duty_amount,
							'manual_net_amount'      => $detail->manual_net_amount,
							'inventory_vat_amount'   => $detail->inventory_vat_amount,
							'inventory_duty_amount'  => $detail->inventory_duty_amount,
							'inventory_net_amount'   => $detail->inventory_net_amount,
							'total_duty_amount'      => $detail->total_duty_amount,
							'total_vat_amount'       => $detail->total_vat_amount,
							'total_net_amount'       => $detail->total_net_amount,
							'updated_at'             => $detail->updated_at,
							'last_updated_by'        => $detail->last_updated_by,
							'last_update_date'       => $detail->last_update_date,
						]);


			DB::commit();

		} catch (\Exception $e) {
			DB::rollBack();
			return 'E';
		}

		return 'updated';
	}

	public function	destroy(int $id) {
		DB::beginTransaction();
		try {
			PtirStockHeaders::where('header_id', $id)->delete();

			DB::commit();
			
		} catch (\Exception $e) {
			DB::rollBack();
			
			return 'E';
		}

		return 'deleted';
	}
}
