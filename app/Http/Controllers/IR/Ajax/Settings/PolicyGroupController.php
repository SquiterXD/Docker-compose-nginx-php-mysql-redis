<?php

namespace App\Http\Controllers\IR\Ajax\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\IR\Settings\PolicyGroupRequest;
use App\Models\IR\Settings\PtirPolicyGroupDists;
use App\Models\IR\Settings\PtirPolicyGroupHeaders;
use App\Models\IR\Settings\PtirPolicyGroupSets;
use App\Models\IR\Settings\PtirPolicyGroupLines;
use App\Models\IR\Settings\PtirPolicySetHeaders;
use App\Models\IR\Views\PtirPolicyTypeView;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Validator;

class PolicyGroupController extends Controller
{
    private $check;

    public function index(PolicyGroupRequest $request) 
    {
        $collection = (new PtirPolicyGroupHeaders())->getAllPolicyGroupHeaders($request->group_header_id, $request->active_flag);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    public function show(PolicyGroupRequest $request) 
    {
        $collection = (new PtirPolicyGroupSets())->getAllGroupSets($request->group_header_id);
        $rows = [];
        $data = (new PtirPolicyGroupLines())->getAllGroupLines($request->group_header_id);
        foreach($data as $index)
        {
            $index->group_dists_rows = [];
            $groupDists = (new PtirPolicyGroupDists())->getAllGroupDists($index->group_line_id, $request->group_header_id);
            array_push($index->group_dists_rows, $groupDists);
            array_push($rows, $index);
        }
    

        $response   = getResponse($collection);
        $response['rows'] = $rows;

        return response($response, $response['status']);
    }

    public function subDetail(PolicyGroupRequest $request) 
    {
        $collection = (new PtirPolicyGroupDists())->getAllGroupDists($request->group_line_id, $request->group_header_id);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

    public function store(PolicyGroupRequest $request)
    {
        $requestData = $request->all()['data'];
        $validator = Validator::make($requestData, [
            'active_flag'  => 'required|max:10',
        ]);

        $validator->validate();

        $userId = optional(auth()->user())->user_id ?? -1;
        $data['group_header_id']   = isset($requestData['group_header_id']) ? $requestData['group_header_id'] : '';
        $data['group_code']        = isset($requestData['group_code']) ? $requestData['group_code'] : '';
        $data['group_description'] = isset($requestData['group_description']) ? $requestData['group_description'] : '';
        $data['active_flag']       = isset($requestData['active_flag']) ? $requestData['active_flag'] : '';
        $data['program_code']      = isset($requestData['program_code']) ? $requestData['program_code'] : '';
        $data['created_by']        = $userId;
        $data['created_by_id']     = $userId;
        $data['last_updated_by']   = $userId;
        $data['created_at']        = Carbon::now();
        $data['updated_at']        = Carbon::now();
        $data['creation_date']     = Carbon::now();
        $data['last_update_date']  = Carbon::now();
        $lineRows                  = isset($requestData['policy_lines_rows']) ? $requestData['policy_lines_rows'] : [];
        $setRows                   = isset($requestData['policy_sets_rows']) ? $requestData['policy_sets_rows'] : [];
        
        try {
            DB::beginTransaction();
            if ($data['group_header_id'] != '')
            {
               PtirPolicyGroupHeaders::updateDesc($data); 
               $this->storePolicyGroupSets($data, $data['group_header_id'], $setRows);
               $this->storePolicyGroupLines($data, $data['group_header_id'], $lineRows);
            }
            else
            {
                $policyGroupHeaders = PtirPolicyGroupHeaders::create($data);
                $this->storePolicyGroupSets($data, $policyGroupHeaders->group_header_id, $setRows);
                $this->storePolicyGroupLines($data, $policyGroupHeaders->group_header_id, $lineRows);
            }
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withError($e->getMessage());
        }

        if ($this->check)
        {
            DB::rollback();
            $response = $this->check;
        }
        else
        {
            DB::commit();
            $response = success();
        }

        return response($response, $response['status']); 
    }

    private function storePolicyGroupSets($data, $groupId, $setRows)
    {
        foreach($setRows as $index) 
        {
            $data['group_header_id']       = $groupId;
            $data['group_set_id']          = isset($index['group_set_id']) ? $index['group_set_id'] : '';
            $data['policy_set_header_id']  = $index['policy_set_header_id'];
 
            if ($data['group_set_id'] != '')
            {
                PtirPolicyGroupSets::updateGroupSets($data);
            }
            else
            {
                $policy = PtirPolicyGroupSets::duplicateCheck($data['group_header_id'], $data['policy_set_header_id']);
                if ($policy)
                {
                    PtirPolicyGroupSets::create($data);
                }
                else
                {
                    $this->check = duplicate();
                    return;
                }
            }
        }
    }

    private function storePolicyGroupLines($data, $groupId, $lineRows)
    {
        foreach($lineRows as $index) {
            $data['group_line_id']     = isset($index['group_line_id']) ? $index['group_line_id'] : '';
            $data['year']              = isset($index['year']) ? convertYearToAD($index['year']) : '';
            $data['start_date']        = parseFromDateTh($index['start_date']);
            $data['end_date']          = parseFromDateTh($index['end_date']);
            $data['revenue_stamp']     = isset($index['revenue_stamp']) ? floatval(str_replace(',', '', $index['revenue_stamp'])) : '';
            $data['tax']               = isset($index['tax']) ? floatval(str_replace(',', '', $index['tax'])) : '';
            $data['premium_rate']      = isset($index['premium_rate']) ? floatval(str_replace(',', '', $index['premium_rate'])) : '';
            $data['prepaid_insurance'] = isset($index['prepaid_insurance']) ? floatval(str_replace(',', '', $index['prepaid_insurance'])): '';
            $data['policy_dists_rows'] = isset($index['group_dists_rows']) ? $index['group_dists_rows'][0] : [];

            $groupLine = PtirPolicyGroupLines::duplicateCheck($data['group_line_id'], $groupId);
            if ($groupLine)
            {
                $groupLine = PtirPolicyGroupLines::create($data);
                $this->storePolicyGroupDists($data, $groupLine->group_line_id, $groupId);
            }
            else
            {
                PtirPolicyGroupLines::updateGroupLine($data);
                $this->storePolicyGroupDists($data, $data['group_line_id'], $groupId);
            }
        }
    }

    private function storePolicyGroupDists($data, $groupLineId, $groupId) 
    {
        foreach($data['policy_dists_rows'] as $index) {
            $data['group_line_id']          = $groupLineId;
            $data['group_header_id']        = $groupId;
            $data['group_distribution_id']  = isset($index['group_distribution_id']) ? $index['group_distribution_id'] : '';
            $data['company_id']             = isset($index['company_id']) ? $index['company_id'] : '';
            $data['company_code']           = isset($index['company_code']) ? $index['company_code'] : '';
            $data['company_percent']        = isset($index['company_percent']) ? $index['company_percent'] : '';
            $data['user_policy_number']     = isset($index['user_policy_number']) ? $index['user_policy_number'] : '';
            $data['comments']               = isset($index['comments']) ? $index['comments'] : '';
            $data['default_diff_amount']    = $index['default_diff_amount'] == "true" || $index['default_diff_amount'] == "Y" ? 'Y' : 'N';

            if ($data['group_distribution_id'] != '')
            {
                PtirPolicyGroupDists::updateGroupDists($data);
            } 
            else
            {
                $groupDists = PtirPolicyGroupDists::duplicateCheck($data['company_id'], $data['group_line_id']);
                if ($groupDists)
                {
                    PtirPolicyGroupDists::create($data);
                }
                else
                {
                    $this->check = duplicate();
                    return;
                }
            }
        }
    }

    public function deletePolicyGroupSet(PolicyGroupRequest $request) 
    {
        $data['group_set_id']    = $request->group_set_id;
        $data['group_header_id'] = $request->group_header_id;
        try {
            DB::beginTransaction();
            
            (new PtirPolicyGroupSets())->deletePolicyGroupSet($data);
                
            DB::commit();


            $response   = success();

            return response($response, $response['status']); 

        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->withError($e->getMessage());
        }
    }

    public function updateActiveFlag(PolicyGroupRequest $request) 
    {
        $requestData = $request->all()['data'];    
        $userId = optional(auth()->user())->user_id ?? -1;
        $data['group_header_id']   = $requestData['group_header_id'];
        $data['active_flag']       = $requestData['active_flag'];
        $data['last_updated_by']   = $userId;
        (new PtirPolicyGroupHeaders())->updateActiveFlag($data);
        return response()->json('Success');
    }


    public function storeIndex(PolicyGroupRequest $request)
    {
        $requestData = $request->all()['data'];
        foreach($requestData['rows'] as $index)
        {
            $validator = Validator::make($index, [
                'active_flag'  => 'required',
            ]);
            $validator->validate();
            $userId = optional(auth()->user())->user_id ?? -1;
            $data['group_header_id']   = isset($index['group_header_id']) ? $index['group_header_id'] : '';
            $data['group_code']        = $index['group_code'];
            $data['group_description'] = $index['group_description'];
            $data['active_flag']       = $index['active_flag'];
            $data['program_code']      = $index['program_code'];
            $data['created_by']        = $userId;
            $data['created_by_id']     = $userId;
            $data['last_updated_by']   = $userId;
            $data['created_at']        = Carbon::now();
            $data['updated_at']        = Carbon::now();
            $data['creation_date']     = Carbon::now();
            $data['last_update_date']  = Carbon::now();

            if ($data['group_header_id'] == '') {
                $group = PtirPolicyGroupHeaders::duplicateCheck($data['group_code']);
                if ($group) {
                    $result = PtirPolicyGroupHeaders::create($data);
                }else{
                    $response = duplicate();
                    DB::rollback();
                    return response($response, $response['status']); 
                }
                DB::commit();
            }
        }

        $data = ['status' => 'S', 'redirect_page' => route('ir.settings.policy-group.edit', $result['group_header_id'])];
        return response()->json($data);
        // $response = success();
        // return response($response, $response['status']); 
    }

    public function policyDuplicateCheck(PolicyGroupRequest $request)
    {
        $check = PtirPolicyGroupSets::where('policy_set_header_id', $request->policy_set_header_id)
                                    ->where('group_header_id', '!=', $request->group_header_id)
                                    ->first();
        if ($check != null) {
            $response = duplicate('ข้อมูลกรมธรรม์นี้ถูกเพิ่มในกลุ่มอื่นแล้ว');
        }else{
            $response = duplicate('ข้อมูลไม่ซ้ำ', 200);
        }
        return response($response, $response['status']);
    }

    public function overlapCheck(PolicyGroupRequest $request)
    {
        $data     = $request->all()['data'];
        $year     = isset($data['year']) ? $data['year'] : '';
        $headerId = isset($data['group_header_id']) ? $data['group_header_id'] : '';

        $line = PtirPolicyGroupLines::where('group_header_id', $headerId)
                                    ->where('year', $year)
                                    ->first();

        if ($line != null) {
            $response = error('ข้อมูลปี '.($line->year + 543).' ซ้ำ');
            return response($response, $response['status']);
        }

        $response = error('', 200);
        return response($response, $response['status']);
    }

}
