<?php

namespace App\Http\Controllers\IR\Ajax\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\IR\Settings\PolicyRequest;
use App\Models\IR\Settings\PtirGasStations;
use App\Models\IR\Settings\PtirGroupProducts;
use App\Models\IR\Settings\PtirPolicyGroupDists;
use App\Models\IR\Settings\PtirPolicyGroupSets;
use App\Models\IR\Settings\PtirPolicySetHeaders;
use App\Models\IR\Settings\PtirSubGroups;
use App\Models\IR\Settings\PtirVehicles;
use App\Models\IR\Views\PtirSubGroupView;
use Carbon\Carbon;
use Validator;
use Illuminate\Support\Facades\DB;

class PolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @param  App\Http\Requests\IR\Settings\CompaniesRequest 
     * @return \Illuminate\Http\Response
     */
    public function index(PolicyRequest $request)
    {
        $collection = (new PtirPolicySetHeaders())->getAllPolicySetHeaders($request->policy_set_header_id, $request->active_flag);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

     /**
     * Display the specified resource.
     *
     * @param  App\Http\Requests\IR\Settings\PolicyRequest 
     * @return \Illuminate\Http\Response
     */
    public function show(PolicyRequest $request)
    {
        $collection = (new PtirPolicySetHeaders())->getObjectPolicySetHeaders($request->policy_set_header_id);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\IR\Settings\PolicyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PolicyRequest $request)
    {
        $requestData = $request->all();
        $validator = Validator::make($requestData, [
            'policy_set_number'    => 'required',
            'policy_type_code'     => 'required',
            'account_id'           => 'required',
            'include_tax_flag'     => 'required',
            'active_flag'          => 'required',
        ]);

        $validator->validate();

        $userId = optional(auth()->user())->user_id ?? -1;
        $data['policy_set_number']      = $requestData['policy_set_number'];
        $data['policy_set_description'] = $requestData['policy_set_description'];
        $data['policy_type_code']       = $requestData['policy_type_code'];
        $data['policy_age']             = $requestData['policy_age'];
        $data['account_id']             = $requestData['account_id'];
        $data['include_tax_flag']       = $requestData['include_tax_flag'];
        $data['group_code']             = $requestData['group_code'];
        $data['policy_category_code']   = $requestData['policy_category_code'];
        $data['active_flag']            = $requestData['active_flag'];  
        $data['gl_expense_account_id']  = $requestData['gl_expense_account_id'];  
        $data['program_code']           = $requestData['program_code'];
        $data['created_by']             = $userId;
        $data['created_by_id']          = $userId;
        $data['last_updated_by']        = $userId;
        $data['created_at']             = Carbon::now();
        $data['creation_date']          = Carbon::now();
        $data['last_update_date']       = Carbon::now();

        $policy = PtirPolicySetHeaders::duplicateCheck($data['policy_set_number']);

        if ($policy) 
        {
            PtirPolicySetHeaders::create($data);

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
     * @param  App\Http\Requests\IR\Settings\PolicyRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(PolicyRequest $request)
    {
        $requestData = $request->all();
        $userId = optional(auth()->user())->user_id ?? -1;
        $data['policy_set_header_id']   = $requestData['policy_set_header_id'];
        $data['policy_set_number']      = $requestData['policy_set_number'];
        $data['policy_set_description'] = $requestData['policy_set_description'];
        $data['policy_type_code']       = $requestData['policy_type_code'];
        $data['policy_age']             = $requestData['policy_age'];
        $data['account_id']             = $requestData['account_id'];
        $data['include_tax_flag']       = $requestData['include_tax_flag'];
        $data['group_code']             = $requestData['group_code'];
        $data['policy_category_code']   = $requestData['policy_category_code'];
        $data['gl_expense_account_id']  = $requestData['gl_expense_account_id'];  
        $data['active_flag']            = $requestData['active_flag'];  
        $data['last_updated_by']        = $userId;
        $data['updated_at']             = Carbon::now();
        $data['last_update_date']       = Carbon::now();

        try {
            DB::beginTransaction();
            
            (new PtirPolicySetHeaders)->updatePolicySetHeader($data);
                
            DB::commit();

            $response = success(); 

            return response($response, $response['status']);
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withError($e->getMessage());
        }
    }

     /**
     * Update active flag
     * 
     * @param  App\Http\Requests\IR\Settings\PolicyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function updateActiveFlag(PolicyRequest $request)
    {
        $requestData = $request->all()['data'];
        $userId = optional(auth()->user())->user_id ?? -1;
        $data['policy_set_header_id']   = $requestData['policy_set_header_id'];
        $data['active_flag']            = $requestData['active_flag'];  
        $data['last_updated_by']        = $userId;
        $data['updated_at']             = Carbon::now();
        $data['last_update_date']       = Carbon::now();

        try {
            DB::beginTransaction();
            $policyId = $data['policy_set_header_id'];
            $policyGroup = \DB::table('ptir_policy_group_sets as a')->where('a.policy_set_header_id',  $policyId)
                                                                    ->join('ptir_policy_group_headers as b', 'a.group_header_id', '=', 'b.group_header_id')
                                                                    ->where('b.active_flag', 'Y')
                                                                    ->first();
            $groupProduct = PtirGroupProducts::where('policy_set_header_id', $policyId)
                                            ->where('active_flag', 'Y')
                                            ->first();
            $vehicle = PtirVehicles::where('policy_set_header_id', $policyId)
                                    ->where('active_flag', 'Y')
                                    ->first();
            $gasStation = PtirGasStations::where('policy_set_header_id', $policyId)
                                        ->where('active_flag', 'Y')
                                        ->first();
            $subGroup = PtirSubGroups::where('policy_set_header_id', $policyId)
                                    ->where('active_flag', 'Y')
                                    ->first();
            if ($policyGroup != null || $groupProduct != null || $vehicle != null || $gasStation != null || $subGroup != null) {
                $response = error('ไม่สามารถแก้ไขได้ ข้อมูลถูกใช้อยู่', 400);
            } else {
                (new PtirPolicySetHeaders)->updateActiveFlag($data);
                $response = success();
            }
                
            DB::commit();

            return response($response, $response['status']);        
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withError($e->getMessage());
        }
    }

    public function checkUsedData(PolicyRequest $request) {
        $policyId = $request->policy_set_header_id;
        $policyGroup = \DB::table('ptir_policy_group_sets as a')->where('a.policy_set_header_id',  $policyId)
                                                                ->join('ptir_policy_group_headers as b', 'a.group_header_id', '=', 'b.group_header_id')
                                                                ->where('b.active_flag', 'Y')
                                                                ->first();
        $groupProduct = PtirGroupProducts::where('policy_set_header_id', $policyId)
                                         ->where('active_flag', 'Y')
                                         ->first();
        $vehicle = PtirVehicles::where('policy_set_header_id', $policyId)
                                ->where('active_flag', 'Y')
                                ->first();
        $gasStation = PtirGasStations::where('policy_set_header_id', $policyId)
                                     ->where('active_flag', 'Y')
                                     ->first();
        $subGroup = PtirSubGroups::where('policy_set_header_id', $policyId)
                                    ->where('active_flag', 'Y')
                                    ->first();
        if ($policyGroup != null || $groupProduct != null || $vehicle != null || $gasStation != null || $subGroup != null) {
            $response = error('ไม่สามารถแก้ไขได้ ข้อมูลถูกใช้อยู่', 400);
        } else {
            $response = success();
        }

        return response($response, $response['status']);
    }

}
