<?php

namespace App\Http\Controllers\IR\Ajax\Repositories;

use App\Http\Controllers\IR\Ajax\Repositories\Interfaces\CarsRepositoryInterface;
use App\Http\Controllers\IR\Ajax\Repositories\Interfaces\CarsStruct;
use App\Models\IR\PtirCars;
use App\Models\IR\PtirStockHeaders;
use App\Models\IR\Views\PtirCarsView;
use Illuminate\Support\Facades\DB;

class CarsRepository implements CarsRepositoryInterface
{
	public function getAll()
	{
		$cars = PtirCars::all();
		return $cars;
	}

	public function	getByID(int $id)
	{
		$cars = PtirCars::find($id);
		return $cars;
	}

	public function	getAllFromView(
		$year,
		$renewCode,
		$groupCode,
		$licensePlate,
		$departmentFrom,
		$departmentTo,
		$status,
		$date_from = null,
		$date_to = null
	) {

		$sql = 'select license_plate from ptir_vehicles where 1 = 1';
		if ($licensePlate) {
			$sql .= " and license_plate = '$licensePlate' ";
		}

		if ($date_from && $date_to) {
			$sql .= " and insurance_expire_date between to_date('$date_from','YYYY-MM-DD' ) and to_date('$date_to','YYYY-MM-DD' ) ";
		}

		$sql .= ' and vehicle_type_code in ( select distinct value from ptir_toat_fa_category_seg5_v group by value )';

		$cars = PtirCarsView::select(DB::raw("
			ptir_cars_v.*,
            (case when ptir_renew_car_insurances.lookup_type = 'PTIR_RENEW_CAR_INSURANCES' then
                'IRS0002'
            when ptir_renew_car_insurances.lookup_type = 'PTIR_RENEW_CAR_ACT' then 
                'IRS0003'
            when ptir_renew_car_insurances.lookup_type = 'PTIR_RENEW_CAR_LICENSE_PLATE' then 
                'IRS0004'
            when ptir_renew_car_insurances.lookup_type = 'PTIR_RENEW_CAR_INSPECTION' then 
                'IRS0005'
            else 
                ptir_renew_car_insurances.lookup_type
            end) renew_program_code
        "))
        ->join('ptir_renew_car_insurances', 'ptir_cars_v.renew_type', '=', 'ptir_renew_car_insurances.meaning')
        ->whereRaw("
			ptir_cars_v.renew_type = ptir_renew_car_insurances.meaning
			and ptir_cars_v.renew_type_code = ptir_renew_car_insurances.lookup_code
            and ptir_cars_v.license_plate in (
				$sql
			)
        ")
        ->when($year, function ($q) use ($year){
            return $q->where('year', $year);
        })
        ->when($renewCode, function ($q) use ($renewCode){
            return $q->where('renew_type', $renewCode);
        })
		->when($groupCode, function ($q) use ($groupCode){
            return $q->where('group_code', $groupCode);
        })
        ->when($departmentFrom, function ($q) use ($departmentFrom, $departmentTo){
            return $q->whereRaw("ptir_cars_v.department_code between ? and nvl(?, ptir_cars_v.department_code)"
			, [$departmentFrom, $departmentTo]);
        })
        ->when($status, function ($q, $status){
            return $q->where('status', $status);
        })
		->where('status', 'NEW')
		->whereNull('document_number')
        ->orderByRaw("renew_program_code asc, renew_type_code asc")
        ->get();


		return $cars;
	}

	// Get search -- Piyawut A. 20220331
	public function	getSearch($year, $renewType, $groupCode, $licensePlate, $departmentFrom, $departmentTo, $status) {
		// dd('----test--view----', $year, $licensePlate);
		DB::enableQueryLog();
		$query = PtirCarsView::query();
		if ($year != '') {
			$query = $query->where('year', $year);
		}

		if ($renewType != '') {
			$query = $query->where('renew_type', $renewType);
		}

		if ($groupCode != '') {
			$query = $query->whereRaw('group_code = ?', $groupCode);
		}

		if ($licensePlate != '') {
			$query = $query->where('license_plate', 'like', '%'.$licensePlate.'%');
		}

		if ($departmentFrom != '') {
			if ($departmentFrom != '' && $departmentTo != '') {
	            $query = $query->whereRaw("department_code between '{$departmentFrom}' and '{$departmentTo}'");
	        }elseif ($departmentFrom != '') {
	            $query = $query->where('department_code', $departmentFrom);
	        }
		}

		if ($status != '') {
			$query = $query->where('status', $status);
		}

		$cars = $query->orderBy('document_number', 'desc')
		->get();
		$sql = DB::getQueryLog();
		// dd($cars, $sql);
		return $cars;
	}

	public function	getByIDFromView(int $id)
	{
	}

	public function	store(CarsStruct $detail)
	{
		DB::beginTransaction();
		try {
			// $car = new PtirStockHeaders();
			$car = new PtirCars();
			$car->document_number	     = $detail->document_number;
			$car->status		     = $detail->status;
			$car->asset_status	     = $detail->asset_status;
			$car->year		     = $detail->year;
			$car->renew_type_code	     = $detail->renew_type_code;
			$car->renew_type	     = $detail->renew_type;
			$car->start_date	     = $detail->start_date;
			$car->end_date		     = $detail->end_date;
			$car->total_days	     = $detail->total_days;
			$car->department_code	     = $detail->department_code;
			$car->department_name	     = $detail->department_name;
			$car->license_plate	     = $detail->license_plate;
			$car->group_code	     = $detail->group_code;
			$car->group_name	     = $detail->group_name;
			$car->insurance_amount	     = $detail->insurance_amount;
			$car->discount		     = $detail->discount;
			$car->duty_amount	     = $detail->duty_amount;
			$car->vat_amount	     = $detail->vat_amount;
			$car->net_amount	     = $detail->net_amount;
			$car->vat_refund	     = $detail->vat_refund;
			$car->insurance_expense  = $detail->insurance_expense;
			// $car->end_month_28_365	 = $detail->end_month_28_365;
			// $car->end_month_29_366	 = $detail->end_month_29_366;
			// $car->end_month_30_365	 = $detail->end_month_30_365;
			// $car->end_month_30_366	 =	$detail->end_month_30_366;
			// $car->end_month_31_365	 = $detail->end_month_31_365;
			// $car->end_month_31_366	 = $detail->end_month_31_366;
			$car->car_type_code	     = $detail->car_type_code;
			$car->car_type		     = $detail->car_type;
			$car->policy_number	     = $detail->policy_number;
			$car->company_id	     = $detail->company_id;
			$car->company_name	     = $detail->company_name;
			$car->asset_number	     = $detail->asset_number;
			$car->asset_description	     = $detail->asset_description;
			$car->date_placed_in_service = $detail->date_placed_in_service;
			$car->expense_account_id     = $detail->expense_account_id;
			$car->expense_account	     = $detail->expense_account;
			$car->expense_account_desc   = $detail->expense_account_desc;
			$car->prepaid_account_id     = $detail->prepaid_account_id;
			$car->prepaid_account 	     = $detail->prepaid_account;
			$car->prepaid_account_desc   = $detail->prepaid_account_desc;
			$car->policy_set_header_id   = $detail->policy_set_header_id;
			$car->policy_set_description = $detail->policy_set_description;
			$car->car_brand_code	     = $detail->car_brand_code;
			$car->car_brand		     = $detail->car_brand;
			$car->car_cc		     = $detail->car_cc;
			$car->engine_number	     = $detail->engine_number;
			$car->tank_number	     = $detail->tank_number;
			$car->line_type		     = $detail->line_type;
			$car->receivable_code	     = $detail->receivable_code;
			$car->receivable_name	     = $detail->receivable_name;
			$car->expense_flag	     = $detail->expense_flag;
			$car->program_code	     = $detail->program_code;
			$car->created_at	     = $detail->created_at;
			$car->updated_at	     = $detail->updated_at;
			$car->created_by_id	     = $detail->created_by_id;
			$car->created_by	     = $detail->created_by;
			$car->last_updated_by	     = $detail->last_updated_by;
			$car->creation_date	     = $detail->creation_date;
			$car->last_update_date       = $detail->last_update_date;
			
			$car->end_month_28           = $detail->end_month_28;
			$car->end_month_29           = $detail->end_month_29;
			$car->end_month_30           = $detail->end_month_30;
			$car->end_month_31           = $detail->end_month_31;
			$car->save();

			DB::commit();
			return $car;
		} catch (\Exception $e) {
			DB::rollBack();
			return 'E';
		}

		// return $car;
	}

	// public function	update(int $id, CarsStruct $detail)
	public function	update(int $id, $detail)
	{
		DB::beginTransaction();
		try {
			$car = PtirCars::where('car_id', $id)
				->update([
					'document_number'        => $detail->document_number,
					'status'                 => $detail->status,
					'asset_status'           => $detail->asset_status,
					'license_plate'          => $detail->license_plate,
					'group_code'             => $detail->group_code,
					'group_name'             => $detail->group_name,
					'year'                   => $detail->year,
					'renew_type_code'        => $detail->renew_type_code,
					'renew_type'             => $detail->renew_type,
					'start_date'             => $detail->start_date,
					'end_date'               => $detail->end_date,
					'total_days'             => $detail->total_days,
					'department_code'        => $detail->department_code,
					'department_name'        => $detail->department_name,
					'insurance_amount'       => $detail->insurance_amount,
					'discount'               => $detail->discount,
					'duty_amount'            => $detail->duty_amount,
					'vat_amount'             => $detail->vat_amount,
					'vat_refund'             => $detail->vat_refund,
					'insurance_expense'		 => $detail->insurance_expense,
					// 'end_month_28_365'		 => $detail->end_month_28_365,
					// 'end_month_29_366'		 => $detail->end_month_29_366,
					// 'end_month_30_365'		 => $detail->end_month_30_365,
					// 'end_month_30_366'		 =>	$detail->end_month_30_366,
					// 'end_month_31_365'		 => $detail->end_month_31_365,
					// 'end_month_31_366'		 => $detail->end_month_31_366,
					'net_amount'             => $detail->net_amount,
					'company_id'             => $detail->company_id,
					'company_name'           => $detail->company_name,
					'asset_number'           => $detail->asset_number,
					'asset_description'      => $detail->asset_description,
					'date_placed_in_service' => $detail->date_placed_in_service,
					'policy_number'          => $detail->policy_number,
					'expense_account_id'     => $detail->expense_account_id,
					'expense_account'        => $detail->expense_account,
					'expense_account_desc'   => $detail->expense_account_desc,
					'prepaid_account_id'     => $detail->prepaid_account_id,
					'prepaid_account'        => $detail->prepaid_account,
					'prepaid_account_desc'   => $detail->prepaid_account_desc,
					'policy_set_header_id'   => $detail->policy_set_header_id,
					'policy_set_description' => $detail->policy_set_description,
					'car_brand_code'         => $detail->car_brand_code,
					'car_brand'              => $detail->car_brand,
					'car_cc'                 => $detail->car_cc,
					'engine_number'          => $detail->engine_number,
					'tank_number'            => $detail->tank_number,
					'line_type'              => $detail->line_type,
					'receivable_code'        => $detail->receivable_code,
					'receivable_name'        => $detail->receivable_name,
					'expense_flag'           => $detail->expense_flag,
					'row_type'				 => $detail->row_type,
					'lookup_type'			 => $detail->row_type,
					'updated_at'             => $detail->updated_at,
					'last_updated_by'        => $detail->last_updated_by,
					'last_update_date'       => $detail->last_update_date,
					'end_month_28'           => $detail->end_month_28,
					'end_month_29'           => $detail->end_month_29,
					'end_month_30'           => $detail->end_month_30,
					'end_month_31'           => $detail->end_month_31,
					'car_type_code'	         => $detail->car_type_code,
				]);
			DB::commit();
			$car = PtirCars::where('car_id', $id)->first();
			// dd($car, $id);
			return $car;
		} catch (\Exception $e) {
			// dd($e);
			DB::rollBack();
			return 'E';
		}

		// return 'updated';
	}

	public function	destroy(int $id)
	{
		DB::beginTransaction();
		try {
			PtirCars::where('car_id', $id)->delete();

			DB::commit();
		} catch (\Exception $e) {
			DB::rollBack();

			return 'E';
		}

		return 'deleted';
	}
}
