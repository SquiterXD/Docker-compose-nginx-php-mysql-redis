<?php

namespace App\Http\Controllers\IR\Ajax\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\IR\Settings\CompanyRequest;

use App\Models\IR\Settings\PtirCompanies;
use App\Models\IR\Settings\PtirPolicyGroupDists;
use Validator;
use Carbon\Carbon;
class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @param  App\Http\Requests\IR\Settings\CompanyRequest 
     * @return \Illuminate\Http\Response
     */
    public function index(CompanyRequest $request) 
    {
        $collection = (new PtirCompanies)->allCompany($request->company_id, $request->active_flag);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }

  
     /**
     * Display the specified resource.
     *
     * @param  App\Http\Requests\IR\Settings\CompanyRequest 
     * @return \Illuminate\Http\Response
     */
    public function show(CompanyRequest $request)
    {
        $collection = (new PtirCompanies)->getObjectCompany($request->company_id);
        $response   = getResponse($collection);

        return response($response, $response['status']);
    }
  

    /**
     * Update active flag
     * @param  App\Http\Requests\IR\Settings\CompanyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function updateActiveFlag(CompanyRequest $request)
    {
        $requestData = $request->all()['data'];
        $userId = optional(auth()->user())->user_id ?? -1;
        $data['company_id']        = $requestData['company_id'];
        $data['active_flag']       = $requestData['active_flag'];
        $data['last_updated_by']   = $userId;
        $data['updated_at']        = Carbon::now();
        $data['last_update_date']  = Carbon::now();

        // $policyGroupDist = \DB::table('ptir_policy_group_dists as a')->where('a.company_id',  $data['company_id'])
        //                                                                     ->join('ptir_policy_group_headers as b', 'a.group_header_id', '=', 'b.group_header_id')
        //                                                                     ->where('b.active_flag', 'Y')
        //                                                                     ->first();
        // if ($policyGroupDist == null) {
        //     (new PtirCompanies)->updateActiveFlag($data);
        //     $response = success();
        // } else {
        //     $response = error('ไม่สามารถแก้ไขได้ ข้อมูลถูกใช้อยู่', 400);
        // }


        //เช็คกับหน้า IRM0003 ถ้ามีการใช้แล้วต้อง inactive ไม่ได้ W.27/06/22 --- start ---
        if ($data['active_flag'] == 'N') {
            $policyGroupDist = PtirPolicyGroupDists::where('company_id', $data['company_id'])->first();

            if ($policyGroupDist == null) {
                (new PtirCompanies)->updateActiveFlag($data);
                $response = success();
            } else {
                $response = error('ไม่สามารถแก้ไขได้ ข้อมูลถูกใช้อยู่', 400);
            }
        } else {
            (new PtirCompanies)->updateActiveFlag($data);
            $response = success();
        }
        // --- end ---

        return response($response, $response['status']);
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\IR\Settings\CompanyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {
        $requestData = $request->all()['data'];
        $validator = Validator::make($requestData, [
            'company_number'    => 'required',
            'company_name'      => 'required',
            'company_address'   => 'required',
            'program_code'      => 'required',
        ]);

        $validator->validate();

        $userId = optional(auth()->user())->user_id ?? -1;
        $data['company_number']    = (new PtirCompanies())->genCompanyNumber()->company_number;
        $data['company_name']      = isset($requestData['company_name']) ? $requestData['company_name'] : '';
        $data['company_address']   = isset($requestData['company_address']) ? $requestData['company_address'] : '';
        $data['company_telephone'] = isset($requestData['company_telephone']) ? $requestData['company_telephone'] : '';
        $data['vendor_id']         = isset($requestData['vendor_id']) ? $requestData['vendor_id'] : '';
        $data['vendor_site_id']    = isset($requestData['vendor_site_id']) ? $requestData['vendor_site_id'] : '';
        $data['customer_id']       = isset($requestData['customer_id']) ? $requestData['customer_id'] : '';
        $data['active_flag']       = isset($requestData['active_flag']) ? $requestData['active_flag'] : '';
        $data['program_code']      = isset($requestData['program_code']) ? $requestData['program_code'] : '';
        $data['created_by']        = $userId;
        $data['created_by_id']     = $userId;
        $data['last_updated_by']   = $userId;
        $data['created_at']        = Carbon::now();
        $data['updated_at']        = Carbon::now();
        $data['creation_date']     = Carbon::now();
        $data['last_update_date']  = Carbon::now();

        $companies = PtirCompanies::duplicateCheck($data['company_number']);
        
        if ($companies) 
        {
            PtirCompanies::create($data);

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
     * @param  App\Http\Requests\IR\Settings\CompanyRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyRequest $request)
    {
        $requestData = $request->all()['data'];
        $userId = optional(auth()->user())->user_id ?? -1;
        $validator = Validator::make($requestData, [
            'company_number'    => 'required',
            'company_name'      => 'required',
            'company_address'   => 'required',
            'program_code'      => 'required',
        ]);

        $validator->validate();
        $data['company_id']        = $requestData['company_id'];
        $data['company_number']    = $requestData['company_number'];
        $data['company_name']      = $requestData['company_name'];
        $data['company_address']   = $requestData['company_address'];
        $data['company_telephone'] = $requestData['company_telephone'];
        $data['vendor_id']         = $requestData['vendor_id'];
        $data['vendor_site_id']    = $requestData['vendor_site_id'];
        $data['customer_id']       = $requestData['customer_id'];
        $data['active_flag']       = $requestData['active_flag'] == true? 'Y': 'N';
        $data['last_updated_by']   = $userId;
        $data['updated_at']        = Carbon::now();
        $data['last_update_date']  = Carbon::now(); 

        //เช็คกับหน้า IRM0003 ถ้ามีการใช้แล้วต้อง inactive ไม่ได้ W.28/06/22 --- start ---
        if ($data['active_flag'] == 'N') {
            $policyGroupDist = PtirPolicyGroupDists::where('company_id', $data['company_id'])->first();

            if ($policyGroupDist) {
                $response = error('ไม่สามารถแก้ไขได้ ข้อมูลถูกใช้อยู่', 400);

                return response($response, $response['status']);
            }
        }
        // --- end ---

        try {
            \DB::beginTransaction();
            
            (new PtirCompanies)->updateCompany($data);
                
            \DB::commit();

            $response = success();
        
            return response($response, $response['status']);     
        } catch (Exception $e) {
            \DB::rollback();
            return redirect()->back()->withError($e->getMessage());
        }
        
    } 

    public function checkUsedData(CompanyRequest $request) {
        $companyId = $request->company_id;
        $policyGroupDist = \DB::table('ptir_policy_group_dists as a')->where('a.company_id',  $request->company_id)
                                                                    ->join('ptir_policy_group_headers as b', 'a.group_header_id', '=', 'b.group_header_id')
                                                                    ->where('b.active_flag', 'Y')
                                                                    ->first();
        if ($policyGroupDist == null) {
            $response = success();
        } else {
            $response = error('ไม่สามารถแก้ไขได้ ข้อมูลถูกใช้อยู่', 400);
        }

        return response($response, $response['status']);
    }

    public function checkDuplicateData(CompanyRequest $request) {
        // dd($request->all());
        // $requestData = $request->all()['data'];
        $data = PtirCompanies::where("vendor_id", $request->vendor_id)
                            ->where("customer_id", $request->customer_id)
                            // ->where("company_id", '!=', $request->company_id)
                            ->first();
        if ($data == null) {
            $response = success();
        } else {
            $response = error("ข้อมูลซ้ำ", 400);
        }

        return response($response, $response['status']);
    }
}
