<?php

namespace App\Http\Controllers\IR\Ajax\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\IR\Settings\GasStationsRequest;
use App\Models\IR\Settings\PtirGasStations;
use stdClass;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PHPUnit\Util\Xml\SuccessfulSchemaDetectionResult;

use App\Models\IR\Settings\PtirPolicyGroupSets;

class GasStationsController extends Controller
{
     /**
     * Display a listing of the resource.
     * 
     * @param  App\Http\Requests\IR\Settings\GasStationsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function index(GasStationsRequest $request) 
    {
        $collection  = (new PtirGasStations())->getAllGasStations($request->type_code, $request->return_vat_flag, $request->active_flag);


        foreach ($collection as $list) {
            $vat = (new PtirPolicyGroupSets())->getPremiumRate($list->policy_set_header_id, null, null, null);

            if ($vat) {
                $list->vat_percent = $vat->tax;
            }
        }
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
     * Display specified gas station
     * 
     * @param  App\Http\Requests\IR\Settings\GasStationsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function show(GasStationsRequest $request) 
    {
        $collection  = (new PtirGasStations())->objectGasStation($request->gas_station_id);

        $vat = (new PtirPolicyGroupSets())->getPremiumRate($collection->policy_set_header_id, null, null, null);
        if ($vat) {
            $collection->vat_percent = $vat->tax;
        }

        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\IR\Settings\GasStationsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GasStationsRequest $request)
    {
        $requestData = $request->all()['data'];
        $validator = Validator::make($requestData, [
            'type_code'             => 'required',
            'group_code'            => 'required',
            'return_vat_flag'       => 'required',
            'vat_percent'           => 'required',
            'revenue_stamp_percent' => 'required',
            'account_id'            => 'required',
            'active_flag'           => 'required',
        ]);

        $validator->validate();
        $userId = optional(auth()->user())->user_id ?? -1;
        $data['type_code']             = isset($requestData['type_code']) ? $requestData['type_code'] : '';
        $data['group_code']            = isset($requestData['group_code']) ? $requestData['group_code'] : '';
        $data['return_vat_flag']       = isset($requestData['return_vat_flag']) ? $requestData['return_vat_flag'] : '';
        $data['vat_percent']           = isset($requestData['vat_percent']) ? $requestData['vat_percent'] : '';
        $data['revenue_stamp_percent'] = isset($requestData['revenue_stamp_percent']) ? $requestData['revenue_stamp_percent'] : '';
        $data['active_flag']           = isset($requestData['active_flag']) ? $requestData['active_flag'] : '';
        $data['policy_set_header_id']  = isset($requestData['policy_set_header_id']) ? $requestData['policy_set_header_id'] : '';
        $data['account_id']            = isset($requestData['account_id']) ? $requestData['account_id'] : '';
        $data['insurance_expire_date']  = isset($requestData['insurance_expire_date']) ? parseFromDateTh($requestData['insurance_expire_date']) : '';
        $data['program_code']          = isset($requestData['program_code']) ? $requestData['program_code'] : '';
        $data['created_at']            = Carbon::now();
        $data['created_by_id']         = $userId;
        $data['created_by']            = $userId;
        $data['last_updated_by']       = $userId;
        $data['creation_date']         = Carbon::now();
        $data['last_update_date']      = Carbon::now();
        $data['insurance_date']        = isset($requestData['insurance_date']) ? parseFromDateTh($requestData['insurance_date']) : '';
        $data['coverage_amount']       = isset($requestData['coverage_amount']) ? $requestData['coverage_amount'] : '';
 
        $gasStation = PtirGasStations::duplicateCheck($data['type_code']);

        if ($gasStation) 
        {
            PtirGasStations::create($data);

            $response = success();
        }
        else 
        {
            $response = duplicate();
        }
      
        return response($response, $response['status']);

    }

     /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\IR\Settings\GasStationsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(GasStationsRequest $request) 
    {
        $requestData = $request->all()['data'];
        $userId = optional(auth()->user())->user_id ?? -1;
        $data['gas_station_id']        = isset($requestData['gas_station_id']) ? $requestData['gas_station_id'] : '';
        $data['group_code']            = isset($requestData['group_code']) ? $requestData['group_code'] : '';
        $data['return_vat_flag']       = isset($requestData['return_vat_flag']) ? $requestData['return_vat_flag'] : '';
        $data['vat_percent']           = isset($requestData['vat_percent']) ? $requestData['vat_percent'] : '';
        $data['revenue_stamp_percent'] = isset($requestData['revenue_stamp_percent']) ? $requestData['revenue_stamp_percent'] : '';
        $data['account_id']            = isset($requestData['account_id']) ? $requestData['account_id'] : '';
        $data['insurance_expire_date']  = isset($requestData['insurance_expire_date']) ? parseFromDateTh($requestData['insurance_expire_date']) : '';
        $data['active_flag']           = isset($requestData['active_flag']) ? $requestData['active_flag'] : '';
        $data['policy_set_header_id']  = isset($requestData['policy_set_header_id']) ? $requestData['policy_set_header_id'] : '';
        $data['group_code']            = isset($requestData['group_code']) ? $requestData['group_code'] : '';
        $data['last_updated_by']       = $userId;
        $data['updated_at']            = Carbon::now();
        $data['last_update_date']      = Carbon::now();
        $data['insurance_date']        = isset($requestData['insurance_date']) ? parseFromDateTh($requestData['insurance_date']) : '';
        $data['coverage_amount']       = isset($requestData['coverage_amount']) ? $requestData['coverage_amount'] : '';

        try {
            DB::beginTransaction();
            
            (new PtirGasStations)->updateGasStations($data);
                
            DB::commit();

            $response   = success();

            return response($response, $response['status']);

        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withError($e->getMessage());
        }
    }

     /**
     * Update the specified return vat flag resource in storage.
     *
     * @param  App\Http\Requests\IR\Settings\GasStationsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function updateReturnVatFlag(GasStationsRequest $request) 
    {
        $requestData = $request->all()['data'];
        $userId = optional(auth()->user())->user_id ?? -1;
        $data['gas_station_id']    = isset($requestData['gas_station_id']) ? $requestData['gas_station_id'] : '';
        $data['return_vat_flag']   = isset($requestData['return_vat_flag']) ? $requestData['return_vat_flag'] : '';;
        $data['last_updated_by']   = $userId;
        $data['updated_at']        = Carbon::now();
        $data['last_update_date']  = Carbon::now();

        try {
            DB::beginTransaction();
            
            (new PtirGasStations)->updateReturnVatFlag($data);
                
            DB::commit();

           $response   = success();

            return response($response, $response['status']);


        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withError($e->getMessage());
        }
    }

     /**
     * Update the specified active flag resource in storage.
     *
     * @param  App\Http\Requests\IR\Settings\GasStationsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function updateActiveFlag(GasStationsRequest $request) 
    {
        $requestData = $request->all()['data'];
        $userId = optional(auth()->user())->user_id ?? -1;
        $data['gas_station_id']    = isset($requestData['gas_station_id']) ? $requestData['gas_station_id'] : '';
        $data['active_flag']       = isset($requestData['active_flag']) ? $requestData['active_flag'] : '';
        $data['last_updated_by']   = $userId;
        $data['updated_at']        = Carbon::now();
        $data['last_update_date']  = Carbon::now();

        try {
            DB::beginTransaction();
            
            (new PtirGasStations)->updateActiveFlag($data);
                
            DB::commit();

            $response   = success();

            return response($response, $response['status']);


        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withError($e->getMessage());
        }
    }

        


    
}
