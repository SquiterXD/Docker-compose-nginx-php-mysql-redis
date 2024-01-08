<?php

namespace App\Http\Controllers\IR\Ajax\Services;

use App\Http\Controllers\IR\Ajax\Repositories\Interfaces\CarsRepositoryInterface;
use App\Http\Controllers\IR\Ajax\Repositories\Interfaces\CarsStruct;
use App\Http\Controllers\IR\Ajax\Services\Interfaces\CarsRequestStruct;
use App\Http\Controllers\IR\Ajax\Services\Interfaces\CarsResponseStruct;
use App\Http\Controllers\IR\Ajax\Services\Interfaces\CarsServiceInterface;
use App\Models\IR\PtirCars;
use App\Models\IR\PtirWebUtilitiesPkg;
use App\Models\IR\Settings\PtirVehicles;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;
use stdClass;
use App\Models\IR\Views\PtirRenewCarInsurancesView;
use App\Models\IR\Views\PtirPolicySetHeadersView;

class CarsService implements CarsServiceInterface
{
	private $repository;
	private $userID;

	public function __construct(CarsRepositoryInterface $repository)
	{
		$this->repository   = $repository;
		$this->userID     = optional(auth()->user())->user_id ?? -1;
	}

	public function getAll($year, $renewCode, $groupCode, $licensePlate, $departmentFrom, $departmentTo, $status, $date_from = null, $date_to = null) {
		$cars = $this->repository->getAllFromView($year, $renewCode, $groupCode, $licensePlate, $departmentFrom, $departmentTo, $status, $date_from, $date_to);
		$response = array();
		foreach ($cars as $car) {
			$carResponse = new CarsResponseStruct;
			$carResponse->car_id 			 	= $car->car_id;
			$carResponse->document_number    	= $car->document_number;
			$carResponse->status 		     	= strtoupper($car->status);
			$carResponse->asset_status 	     	= $car->asset_status;
			$carResponse->year 		     		= (int)$car->year + 543;
			$carResponse->renew_type_code 	    = $car->renew_type_code;
			$carResponse->renew_type            = $car->renew_type;
			$carResponse->start_date            = parseToDateTh($car->start_date, 'd/m/Y');
			$carResponse->end_date 		     	= parseToDateTh($car->end_date, 'd/m/Y');
			$date1 								= date_create($car->end_date);
			$date2 								= date_create($car->start_date);
			$diff 								= date_diff($date1, $date2);
			$carResponse->total_days 	     	= $diff->days;
			$carResponse->department_code 	    = $car->department_code;
			$carResponse->department_name 	    = $car->department_name;
			$carResponse->license_plate 	    = $car->license_plate;
			$carResponse->group_code 	     	= $car->group_code;
			$carResponse->group_name 	     	= $car->group_name;
			$carResponse->insurance_amount 	    = $car->insurance_amount;
			$carResponse->discount 		     	= ($car->discount == null || $car->discount == '') ? 0 : $car->discount;
			$carResponse->duty_amount 	     	= (int)$car->duty_amount;
			$carResponse->vat_amount 	     	= (int)$car->vat_amount;
			$carResponse->net_amount 	     	= (int)$car->net_amount;
			$carResponse->vat_refund 	     	= $car->vat_refund;
			$carResponse->car_type_code			= $car->car_type_code;
			$carResponse->car_type				= $car->car_type;
			$carResponse->policy_number 	    = $car->policy_number;
			$carResponse->company_id 	     	= $car->company_id;
			$carResponse->company_name 	     	= $car->company_name;
			$carResponse->asset_number 	     	= $car->asset_number;
			$carResponse->expense_account_id    = ($car->expense_account_id == null || $car->expense_account_id == '') ? $car->vehicle->account_id : $car->expense_account_id;
			$carResponse->expense_account 	    = ($car->expense_account == null || $car->expense_account == '') ? $car->vehicle->account_number : $car->expense_account;
			$carResponse->expense_account_desc  = ($car->expense_account == null || $car->expense_account == '') ? $car->vehicle->account_description : $car->expense_account_desc;
			$carResponse->prepaid_account_id    = $car->prepaid_account_id;
			$carResponse->prepaid_account 	    = $car->prepaid_account;
			$carResponse->prepaid_account_desc  = $car->prepaid_account_desc;
			$carResponse->policy_set_header_id  = $car->policy_set_header_id;
			$carResponse->policy_set_description = isset($car->policy->policy_set_description) ? $car->policy->policy_set_description : '';
			$carResponse->car_brand_code         = $car->car_brand_code;
			$carResponse->car_brand 	     	= $car->car_brand;
			$carResponse->car_cc 		     	= $car->car_cc;
			$carResponse->engine_number         = $car->engine_number;
			$carResponse->tank_number 	     	= $car->tank_number;
			$carResponse->line_type 	     	= $car->line_type;
			$carResponse->receivable_code       = $car->receivable_code;
			$carResponse->receivable_name 	    = $car->receivable_name;
			$carResponse->expense_flag 	     	= $car->expense_flag;
			$carResponse->vat_percent 			= $car->vat_percent;
			$carResponse->revenue_stamp_percent = $car->revenue_stamp_percent;
			$carResponse->location_code 		= $car->location_code;
			$carResponse->location_description 	= $car->location_description;
			$carResponse->tag  					= $car->tag;

			array_push($response, $carResponse);
		}

		return getResponse($response);
	}

	public function search($year, $renewCode, $groupCode, $licensePlate, $departmentFrom, $departmentTo, $status) {
		$cars = $this->repository->getSearch($year, $renewCode, $groupCode, $licensePlate, $departmentFrom, $departmentTo, $status);
		$response = array();
		foreach ($cars as $car) {
			// dd($car);
			$carResponse = new CarsResponseStruct;
			$carResponse->car_id 			 	= $car->car_id;
			$carResponse->document_number    	= $car->document_number;
			$carResponse->status 		     	= strtoupper($car->status);
			$carResponse->asset_status 	     	= $car->asset_status;
			$carResponse->year 		     		= (int)$car->year + 543;
			$carResponse->renew_type_code 	    = $car->renew_type_code;
			$carResponse->renew_type            = $car->renew_type;
			$carResponse->start_date            = parseToDateTh($car->start_date);
			$carResponse->end_date 		     	= parseToDateTh($car->end_date);
			$date1 								= date_create($car->end_date);
			$date2 								= date_create($car->start_date);
			$diff 								= date_diff($date1, $date2);
			$carResponse->total_days 	     	= $diff->days;
			$carResponse->department_code 	    = $car->department_code;
			$carResponse->department_name 	    = $car->department_name;
			$carResponse->license_plate 	    = $car->license_plate;
			$carResponse->group_code 	     	= $car->group_code;
			$carResponse->group_name 	     	= $car->group_name;
			$carResponse->insurance_amount 	    = $car->insurance_amount;
			$carResponse->discount 		     	= ($car->discount == null || $car->discount == '') ? 0 : $car->discount;
			$carResponse->duty_amount 	     	= $car->duty_amount;
			$carResponse->vat_amount 	     	= $car->vat_amount;
			$carResponse->net_amount 	     	= $car->net_amount;
			$carResponse->vat_refund 	     	= $car->vat_refund;
			$carResponse->car_type_code			= $car->car_type_code;
			$carResponse->car_type				= $car->car_type;
			$carResponse->policy_number 	    = $car->policy_number;
			$carResponse->company_id 	     	= $car->company_id;
			$carResponse->company_name 	     	= $car->company_name;
			$carResponse->asset_number 	     	= $car->asset_number;
			$carResponse->expense_account_id    = ($car->expense_account_id == null || $car->expense_account_id == '') ? $car->vehicle->account_id : $car->expense_account_id;
			$carResponse->expense_account 	    = ($car->expense_account == null || $car->expense_account == '') ? $car->vehicle->account_number : $car->expense_account;
			$carResponse->expense_account_desc  = ($car->expense_account == null || $car->expense_account == '') ? $car->vehicle->account_description : $car->expense_account_desc;
			$carResponse->prepaid_account_id    = $car->prepaid_account_id;
			$carResponse->prepaid_account 	    = $car->prepaid_account;
			$carResponse->prepaid_account_desc  = $car->prepaid_account_desc;
			$carResponse->policy_set_header_id  = $car->policy_set_header_id;
			$carResponse->policy_set_description = isset($car->policy->policy_set_description) ? $car->policy->policy_set_description : '';
			$carResponse->car_brand_code         = $car->car_brand_code;
			$carResponse->car_brand 	     	= $car->car_brand;
			$carResponse->car_cc 		     	= $car->car_cc;
			$carResponse->engine_number         = $car->engine_number;
			$carResponse->tank_number 	     	= $car->tank_number;
			$carResponse->line_type 	     	= $car->line_type;
			$carResponse->receivable_code       = $car->receivable_code;
			$carResponse->receivable_name 	    = $car->receivable_name;
			$carResponse->expense_flag 	     	= $car->expense_flag;
			$carResponse->vat_percent 			= $car->vat_percent;
			$carResponse->revenue_stamp_percent = $car->revenue_stamp_percent;
			$carResponse->location_code 		= $car->location_code;
			$carResponse->location_description  = $car->location_description;
			$carResponse->tag  				 	= $car->tag;

			array_push($response, $carResponse);
		}
		return getResponse($response);
	}

	public function	getByID(int $id)
	{
	}

	public function	createOrUpdate(array $data)
	{
		// dd('cccccc', $data);
		$cars = [];
		foreach ($data as $car) {
			// $car = new CarsStruct();
			// $car->car_id	     	     = $line->car_id;
			// $car->document_number	     = $line->document_number;
			// $car->status		     = $line->status;
			// $car->asset_status	     = $line->asset_status;
			// $car->year		     = $line->year;
			// $car->renew_type_code	     = $line->renew_type_code;
			// $car->renew_type	     = $line->renew_type;
			// $car->start_date	     = $car->start_date;
			// $car->end_date		     = $car->end_date;
			// $car->total_days	     = $line->total_days;
			$car->department_code	     = $car->department_code;
			$car->department_name	     = $car->department_name;
			// $car->license_plate	     = $line->license_plate;
			// $car->group_code	     = $line->group_code;
			// $car->group_name	     = $line->group_name;
			// $car->insurance_amount	     = $line->insurance_amount;
			// $car->discount		     = $line->discount;
			// $car->duty_amount	     = $line->duty_amount;
			// $car->vat_amount	     = $line->vat_amount;
			// $car->net_amount	     = $line->net_amount;
			// $car->vat_refund	     = $line->vat_refund;
			$car->insurance_expense		= (float)$car->insurance_expense;
			// $car->end_month_28_365		= round($car->insurance_expense * 28 / 365, 2);
			// $car->end_month_29_366		= round($car->insurance_expense * 29 / 366, 2);
			// $car->end_month_30_365		= round($car->insurance_expense * 30 / 365, 2);
			// $car->end_month_30_366		= round($car->insurance_expense * 30 / 366, 2);
			// $car->end_month_31_365		= round($car->insurance_expense * 31 / 365, 2);
			// $car->end_month_31_366		= round($car->insurance_expense * 31 / 366, 2);

			$car->end_month_28		    = round($car->insurance_expense * 28 / $car->total_days, 2);
			$car->end_month_29		    = round($car->insurance_expense * 29 / $car->total_days, 2);
			$car->end_month_30		    = round($car->insurance_expense * 30 / $car->total_days, 2);
			$car->end_month_31		    = round($car->insurance_expense * 31 / $car->total_days, 2);

			// $car->car_type_code	     = $line->car_type_code;
			// $car->car_type		     = $line->car_type;
			// $car->policy_number	     = $line->policy_number;
			// $car->company_id	     = $line->company_id;
			// $car->company_name	     = $line->company_name;
			// $car->asset_number	     = $line->asset_number;
			// $car->asset_description	     = $line->asset_description;
			// $car->date_placed_in_service = $line->date_placed_in_service;
			// $car->expense_account_id     = $line->expense_account_id;
			// $car->expense_account	     = $line->expense_account;
			// $car->expense_account_desc   = $line->expense_account_desc;
			// $car->prepaid_account_id     = $line->prepaid_account_id;
			// $car->prepaid_account 	     = $line->prepaid_account;
			// $car->prepaid_account_desc   = $line->prepaid_account_desc;
			// $car->policy_set_header_id   = $line->policy_set_header_id;
			// $car->policy_set_description = $line->policy_set_description;
			// $car->car_brand_code	     = $line->car_brand_code;
			// $car->car_brand		     = $line->car_brand;
			// $car->car_cc		     = $line->car_cc;
			// $car->engine_number	     = $line->engine_number;
			// $car->tank_number	     = $line->tank_number;
			// $car->line_type		     = $car->line_type;
			// $car->receivable_code	     = $line->receivable_code;
			// $car->receivable_name	     = $line->receivable_name;
			// $car->expense_flag	     = $line->expense_flag;
			// $car->program_code	     = $line->program_code;
			$car->created_at	     = Carbon::now();
			$car->updated_at	     = Carbon::now();
			$car->created_by_id	     = $this->userID;
			$car->created_by	     = $this->userID;
			$car->last_updated_by	     = $this->userID;
			$car->creation_date	     = Carbon::now();
			$car->last_update_date       = Carbon::now();
			// dd('$car->line_type->', $car->line_type);
			// if ($car->line_type == 'Fix Asset' && $car->status == 'NEW') {
			// 	//dump('---1----');
			// 	PtirCars::where('car_id', $car->car_id)->delete();
			// 	continue;
			// }
			//dump('---2----');

			$vehicle = (new PtirVehicles())->getVehicleForCars($car->asset_number);
			// $car->prepaid_account_id     = isset($vehicle->gl_expense_account_id) ? $vehicle->gl_expense_account_id : '';
			// $car->prepaid_account        = isset($vehicle->account_combine) ? $vehicle->account_combine : '';
			// $car->prepaid_account_desc   = isset($vehicle->account_combine_desc) ? $vehicle->account_combine_desc : '';
			$car->policy_set_header_id   = isset($vehicle->policy_set_header_id) ? $vehicle->policy_set_header_id : $car->policy_set_header_id;
			$car->policy_set_description = isset($vehicle->policy_set_description) ? $vehicle->policy_set_description : $car->policy_set_description;

			// $policy = PtirPolicySetHeadersView::where('policy_set_header_id', $car->policy_set_header_id)->first();
			// $car->prepaid_account_id     = optional($policy)->gl_expense_account_id;
			// $car->prepaid_account        = optional($policy)->gl_expense_account_combine;
			// $car->prepaid_account_desc   = optional($policy)->gl_expense_account_desc;

			if ($car->expense_account_id == '') {
				//dump('---3----');
				DB::rollback();
				return error('ไม่มีรหัสบัญชีนี้ โปรดเลือกบัญชีใหม่');
			}
			
			$renewType = $this->checkListValue($car->renew_type);
			$car->row_type = $renewType->lookup_type;
			$car->lookup_type = $renewType->lookup_type;

			if ($car->car_id == '') {
				//dump('---5----');
				$carDB = $this->repository->store($car);
				// //dump('--store---', $carDB);
			} else {
				//dump('---6----');
				$carDB = $this->repository->update($car->car_id, $car);
				// //dump('---update---', $carDB);
			}

			if ($carDB == 'E') {
				//dump('---7----');
				return error('cannot update or create car', 500);
			}

			$car->car_id = $carDB->car_id;

			// if ($car->status == 'CONFIRMED') {
				//dump('---8----');

				$carx = PtirCars::select(DB::raw('max(end_date) end_date'))
					->where('license_plate', $car->license_plate)
					->whereRaw("status in ('CONFIRMED', 'INTERFACE')")
					->where('row_type', $renewType->lookup_type)
					->first();

				$vehicle = PtirVehicles::where('license_plate', $car->license_plate);
				// list lov for check condition -- Piyawut MCR 20220329
				if ($renewType->lookup_type == 'PTIR_RENEW_CAR_INSURANCES') {
					$vehicle->update(['insurance_expire_date' => $carx->end_date]);
				} elseif ($renewType->lookup_type == 'PTIR_RENEW_CAR_ACT') {
					$vehicle->update(['acts_expire_date' => $carx->end_date]);
				} elseif ($renewType->lookup_type == 'PTIR_RENEW_CAR_LICENSE_PLATE') {
					$vehicle->update(['license_plate_expire_date' => $carx->end_date]);
				} elseif ($renewType->lookup_type == 'RENEW_CAR_INSPECTION') {
					$vehicle->update(['car_inspection_expire_date' => $carx->end_date]);
				}

				$vehicle->update([
					'updated_at' => $car->updated_at,
					'last_updated_by' => $car->last_updated_by,
					'last_update_date' => $car->last_update_date,
				]);
			// } else if ($car->status == 'CANCELLED') {
			// 	//dump('---9----');
			// 	$vehicle = PtirVehicles::where('license_plate', $car->license_plate);
			// 	if ($car->renew_type_code == '01' || $car->renew_type_code == '02' || $car->renew_type_code == '03' || $car->renew_type_code == '04') {
			// 		$vehicle->update(['insurance_expire_date' => null]);
			// 	} elseif ($car->renew_type_code == '05') {
			// 		$vehicle->update(['acts_expire_date' => null]);
			// 	} elseif ($car->renew_type_code == '06') {
			// 		$vehicle->update(['license_plate_expire_date' => null]);
			// 	} elseif ($car->renew_type_code == '07') {
			// 		$vehicle->update(['car_inspection_expire_date' => null]);
			// 	}

			// 	$vehicle->update([
			// 		'updated_at' => $car->updated_at,
			// 		'last_updated_by' => $car->last_updated_by,
			// 		'last_update_date' => $car->last_update_date,
			// 	]);
			// }
			// dd($car->status, $car->document_number);
			if ($car->document_number == '') {
				//dump('---10----');
				// logger((new PtirWebUtilitiesPkg())->genDocumentNumber($car->program_code, $car->car_id)['document_number']);
				$car->document_number = (new PtirWebUtilitiesPkg())->genDocumentNumber($car->program_code, $car->car_id)['document_number'];
			}
			//dump('---11----');
			// //dump($car->document_number, $car);
			// dd($carDB);
			$carDB = $this->repository->update($carDB->car_id, $car);
			//dump('---12----');

			if ($carDB == 'E') {
				//dump('---13----');
				return error('cannot update document_number', 500);
			}

			//dump('---14----');
			DB::commit();
			$cars[] = $car;
		}
		return success($cars);
	}

	public function	update(int $id, CarsRequestStruct $detail)
	{
	}

	public function	destroy(int $id)
	{
	}

	public function checkListValue($meaning)
	{
		$data = PtirRenewCarInsurancesView::where('meaning', $meaning)->first();
		return $data;
	}
}
