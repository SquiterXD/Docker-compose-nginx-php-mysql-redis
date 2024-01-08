<?php 

namespace App\Http\Controllers\IR\Ajax\Repositories;

use App\Http\Controllers\IR\Ajax\Repositories\Interfaces\ExtendGasStationsInterface;
use App\Models\IR\PtirExtendGasStations;
use App\Models\IR\Settings\PtirGasStations;
use Illuminate\Support\Facades\DB;

class ExtendGasStationRepository implements ExtendGasStationsInterface {
	public function getAll(string $year, string $typeCode, string $groupCode, string $status) {
		$gasStations = PtirExtendGasStations::whereRaw("year = nvl(to_number(?)-543, year)
								and type_code = nvl(?, type_code) 
								and group_code = nvl(?, group_code) 
								and status = nvl(?, status)",
								[$year, $typeCode, $groupCode, $status])
							->orderBy('document_number desc nulls last')
							->get();

		return $gasStations;
	}

	public function	getByID(int $id) {
		$gasStation = PtirExtendGasStations::find($id);	

		return $gasStation;
	}

	public function	store(array $detail) {
		DB::beginTransaction();
		try {
			$gasStation = new PtirGasStations();
			$gasStation->type_code             = $detail['type_code'];
			$gasStation->policy_set_header_id  = $detail['policy_set_header_id'];
			$gasStation->group_code            = $detail['group_code'];
			$gasStation->return_vat_flag 	   = $detail['return_vat_flag'];
			$gasStation->vat_percent           = $detail['vat_percent'];
			$gasStation->revenue_stamp_percent = $detail['revenue_stamp_percent'];
			$gasStation->active_flag       	   = $detail['active_flag'];
			$gasStation->account_id            = $detail['account_id'];
			$gasStation->insurance_expire_date = $detail['insurance_expire_date'];
			$gasStation->program_code          = $detail['program_code'];
			$gasStation->created_at            = $detail['created_at'];
			$gasStation->updated_at            = $detail['updated_at'];
			$gasStation->created_by_id         = $detail['created_by_id'];
			$gasStation->created_by            = $detail['created_by'];
			$gasStation->last_updated_by       = $detail['last_updated_by'];
			$gasStation->creation_date         = $detail['creation_date'];
			$gasStation->last_update_date      = $detail['last_update_date'];
			$gasStation->save();

			DB::commit();

		} catch (\Exception $e) {
			DB::rollBack();

			return 'E';
		}

		return $gasStation;
	}

	public function	update(int $id, array $detail, string $flag) {
		DB::beginTransaction();
		try {
			$gasStation = PtirGasStations::where('gas_station_id', $id);
			switch ($flag) {
				case 'all':
					$gasStation->update([
						'group_code'            => $detail['group_code'],
						'return_vat_flag'       => $detail['return_vat_flag'],
						'vat_percent'           => $detail['vat_percent'],
						'revenue_stamp_percent' => $detail['revenue_stamp_percent'],
						'active_flag'       	=> $detail['active_flag'],
						'account_id'            => $detail['account_id'],
						'insurance_expire_date' => $detail['insurance_expire_date'],
						'last_updated_by'       => $detail['last_updated_by'],
						'updated_at' 	     	=> $detail['updated_at'],
						'last_update_date'      => $detail['last_update_date'],
					]);
				break;

				case 'active_flag':
					$gasStation->update([
						'active_flag' 	    => $detail['active_flag'],
						'last_updated_by'   => $detail['last_updated_by'],
						'updated_at' 	    => $detail['updated_at'],
						'last_update_date'  => $detail['last_update_date'],
					]);
				break;

				case 'return_vat_flag':
					$gasStation->update([
						'return_vat_flag'   => $detail['return_vat_flag'],
						'last_updated_by'   => $detail['last_updated_by'],
						'updated_at' 	    => $detail['updated_at'],
						'last_update_date'  => $detail['last_update_date'],
					]);
				break;
			}

			$gasStation->save();

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
			PtirGasStations::where('gas_station_id', $id)->delete();

			DB::commit();
			
		} catch (\Exception $e) {
			DB::rollBack();
			
			return 'E';
		}

		return 'deleted';
	}
}