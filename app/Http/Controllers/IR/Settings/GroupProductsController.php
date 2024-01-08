<?php

namespace App\Http\Controllers\IR\Settings;

use App\Models\IR\Settings\PtirPolicySetHeaders;
use App\Models\IR\Settings\PtirGroupProducts;
use App\Models\IR\Settings\PtirAccountsMapping;
use App\Models\IR\Settings\PtirAssetGroupV;
use App\Models\IR\Settings\PtirProductInvHeaders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;

class GroupProductsController extends Controller
{
    public function index()
    {
        $btnTrans = trans('btn');
        $search = request()->search;
        $policySetHeadersTable = (new PtirPolicySetHeaders)->getTable();
        $groupProductsTable = (new PtirGroupProducts)->getTable();
        // $policySetHeaders = PtirPolicySetHeaders::where('active_flag','Y')
        //                                         ->where('policy_type_code', 'DCT')
        //                                         ->orderBy('policy_set_number')
        //                                         ->get();
        $policySetHeaders = collect(DB::select("
                                                    SELECT  DISTINCT 
                                                            policy.policy_set_header_id, 
                                                            policy.policy_set_number, 
                                                            policy.policy_set_description
                                                    FROM    {$policySetHeadersTable}    policy,
                                                            {$groupProductsTable}       products
                                                    WHERE   1=1
                                                    AND     policy.policy_set_header_id = products.policy_set_header_id
                                                    AND     policy.active_flag = 'Y'
                                                    AND     policy.policy_type_code = 'DCT'
                                                "));
        $assetGroups = PtirAssetGroupV::orderBy('value')
                                        ->get();
        $accountsMappings = PtirAccountsMapping::orderBy('account_id')
                                                ->get();
        $descFieldSearches = PtirGroupProducts::orderBy('description', 'asc')
                                                ->whereHas('policySetHeaders')
                                                ->get()
                                                ->groupBy('description');
        $groupProducts = PtirGroupProducts::search($search)
                                        ->with('policySetHeaders', 'assetGroup', 'mappingAcc')
                                        ->whereHas('policySetHeaders')
                                        ->get();
        return  view('ir.settings.product-groups.index',
                compact('groupProducts', 'policySetHeaders', 'assetGroups', 'accountsMappings',
                        'search', 'descFieldSearches', 'btnTrans'));
    }

    public function create()
    {
        $btnTrans = trans('btn');
        $policySetHeaders = PtirPolicySetHeaders::where('active_flag','Y')
                                                ->where('policy_type_code', 'DCT')
                                                ->orderBy('policy_set_number')
                                                ->get();
        $accountsMappings = PtirAccountsMapping::where('active_flag','Y')
                                                ->orderBy('account_code')
                                                ->get();
        $assetGroups = PtirAssetGroupV::where('enabled_flag','Y')
                                    ->orderBy('value')
                                    ->get();

        return view('ir.settings.product-groups.create',compact('policySetHeaders', 'accountsMappings', 'assetGroups', 'btnTrans'));
    }

    public function store(Request $request)
    {
        $profile = getDefaultData('/ir/settings/product-groups');
        $isDuplicate = PtirGroupProducts::where('policy_set_header_id', $request['policy_set_header_id'])
                                        ->where('asset_group_code', $request['asset_group_code'])
                                        ->where('description', $request['description'])
                                        ->where('account_id', $request['account_id'])
                                        ->first();
        if($isDuplicate){
            return  redirect()
            ->back()
            ->withErrors(['กลุ่มสินค้านี้ได้มีการถูกสร้างเรียบร้อยแล้ว'])
            ->withInput($request->all());
        }
        $this->validate($request,[
            'policy_set_header_id' => 'required', 
            'asset_group_code' => 'required',
            'description' => 'required',
            'account_id' => 'required',
        ],[
            'policy_set_header_id.required' => 'กรุณาเลือกชุดกรมธรรม์', 
            'description.required' => 'กรุณากรอกรายละเอียดรายการ', 
            'asset_group_code.required' => 'กรุณาเลือกกลุ่มของทรัพย์สิน',
            'account_id.required' => 'กรุณาเลือกประเภทค่าใช้จ่าย',
        ]);
        try {
            \DB::beginTransaction();
                $groupProduct                               = new PtirGroupProducts();
                $groupProduct->policy_set_header_id         = $request->policy_set_header_id;
                $groupProduct->asset_group_code             = $request->asset_group_code;
                $groupProduct->description                  = $request->description;
                $groupProduct->account_id                   = $request->account_id;
                $groupProduct->active_flag                  = $request->active_flag ? 'Y' : 'N';
                $groupProduct->program_code                 = $profile->program_code;
                $groupProduct->created_at                   = now();
                $groupProduct->created_by_id                = $profile->user_id;
                $groupProduct->created_by                   = $profile->user_id;
                $groupProduct->last_updated_by              = $profile->user_id;
                $groupProduct->creation_date                = now();
                $groupProduct->last_update_date             = now();
                $groupProduct->save();
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();
            if($request->ajax()){
                $result['status'] = 'ERROR';
                $result['err_msg'] = $e->getMessage();
                return $result;
            }else{
                \Log::error($e->getMessage());
                return abort('403');
            }  
        }
        
        return redirect()->route('ir.settings.product-groups.index')->with('success','ทำการเพิ่มข้อมูลกลุ่มสินค้าเรียบร้อยแล้ว');
    }

    public function edit($id)
    {
        $groupProducts = PtirGroupProducts::where('group_product_id',$id)
                                            ->with('mappingAcc')
                                            ->first();
        $policySetHeaders = PtirPolicySetHeaders::where('active_flag','Y')
                                                ->where('policy_type_code', 'DCT')
                                                ->orderBy('policy_set_number')
                                                ->get();        
        $assetGroups = PtirAssetGroupV::where('enabled_flag','Y')
                                    ->orderBy('value')
                                    ->get();
        $accountsMappings = PtirAccountsMapping::where('active_flag','Y')
                                                ->orderBy('account_code')
                                                ->get();
        $btnTrans = trans('btn');
        return  view('ir.settings.product-groups.edit',
                compact('groupProducts', 'policySetHeaders', 'assetGroups', 'accountsMappings', 'btnTrans'));
    }

    public function update(Request $request)
    {
        $this->validate($request,[
            'policy_set_header_id' => 'required', 
            'asset_group_code' => 'required',
            'description' => 'required',
            'account_id' => 'required',
        ],[
            'policy_set_header_id.required' => 'กรุณาเลือกชุดกรมธรรม์', 
            'description.required' => 'กรุณากรอกรายละเอียดรายการ', 
            'asset_group_code.required' => 'กรุณาเลือกกลุ่มของทรัพย์สิน',
            'account_id.required' => 'กรุณาเลือกประเภทค่าใช้จ่าย',
        ]);
        $profile = getDefaultData('/ir/settings/product-groups');

        if( $request['old_checker_policy_set_header_id'] == $request['policy_set_header_id'] &&
            $request['old_checker_asset_group_code'] == $request['asset_group_code'] &&
            $request['old_checker_description'] == $request['description'] &&
            $request['old_checker_account_id'] == $request['account_id'] &&
            $request['old_checker_active_flag'] == $request['active_flag']                          ){

            return redirect()->route('ir.settings.product-groups.index')->with('success','ทำการเปลี่ยนข้อมูลกลุ่มสินค้าเรียบร้อยแล้ว');      
        }else{
            if ($request['old_checker_active_flag'] != $request['active_flag'] ) {
                if( $request['old_checker_policy_set_header_id'] == $request['policy_set_header_id'] &&
                    $request['old_checker_asset_group_code'] == $request['asset_group_code'] &&
                    $request['old_checker_description'] == $request['description'] &&
                    $request['old_checker_account_id'] == $request['account_id']                            ){
                    $productInvHeaders = PtirProductInvHeaders::where('group_product_id',$request->group_product_id)->first();
                    if($productInvHeaders != null){
                        $data = PtirGroupProducts::where('group_product_id', $productInvHeaders['group_product_id'])->first();
                        $request_flag = $request['active_flag'] == 'true' ? 'Y' : 'N';
         
                        if($productInvHeaders->active_flag == 'Y' && $request_flag == 'N'){
                            $data = ['status' => 'error'];
                            return  redirect()
                                    ->route('ir.settings.product-groups.index')
                                    ->with('error','ไม่สามารถปิดการใช้งานได้ เนื่องจากมีการใช้งานอยู่');
                        }else {
                            \DB::beginTransaction();
                            try {
                                $groupProduct                               = PtirGroupProducts::find($request->group_product_id);
                                $groupProduct->active_flag                  = $request->active_flag == "true" ? 'Y' : 'N';
                                $groupProduct->program_code                 = $profile->program_code;
                                $groupProduct->last_updated_by              = $profile->user_id;
                                $groupProduct->last_update_date             = now();
                                $groupProduct->save();
                                \DB::commit();
                            } catch (\Exception $e) {
                                \DB::rollBack();
                                if($request->ajax()){
                                    $result['status'] = 'ERROR';
                                    $result['err_msg'] = $e->getMessage();
                                    return $result;
                                }else{
                                    \Log::error($e->getMessage());
                                    return abort('403');
                                }  
                            }
                        }
                    }else{
                        \DB::beginTransaction();
                        try {
                            $groupProduct                               = PtirGroupProducts::find($request->group_product_id);
                            $groupProduct->active_flag                  = $request->active_flag == "true" ? 'Y' : 'N';
                            $groupProduct->program_code                 = $profile->program_code;
                            $groupProduct->last_updated_by              = $profile->user_id;
                            $groupProduct->last_update_date             = now();
                            $groupProduct->save();
                            \DB::commit();
                        } catch (\Exception $e) {
                            \DB::rollBack();
                            if($request->ajax()){
                                $result['status'] = 'ERROR';
                                $result['err_msg'] = $e->getMessage();
                                return $result;
                            }else{
                                \Log::error($e->getMessage());
                                return abort('403');
                            }
                        }
                    }
                    return redirect()->route('ir.settings.product-groups.index')->with('success','ทำการเปลี่ยนข้อมูลกลุ่มสินค้าเรียบร้อยแล้ว');        
                }else{
                    if( $request['old_checker_policy_set_header_id'] != $request['policy_set_header_id'] ||
                        $request['old_checker_asset_group_code'] != $request['asset_group_code'] ||
                        $request['old_checker_description'] != $request['description'] ||
                        $request['old_checker_account_id'] != $request['account_id']){

                        $isDuplicate = PtirGroupProducts::where('policy_set_header_id', $request['policy_set_header_id'])
                                                        ->where('asset_group_code', $request['asset_group_code'])
                                                        ->where('description', $request['description'])
                                                        ->where('account_id', $request['account_id'])
                                                        ->first();
                        if($isDuplicate){
                            return  redirect()
                                    ->back()
                                    ->withErrors(['ข้อมูลกลุ่มสินค้านี้มีในระบบแล้ว ไม่สามารถอัพเดตข้อมูลได้ กรุณาตรวจสอบ']);
                        }

                        $productInvHeaders  = PtirProductInvHeaders::where('group_product_id',$request->group_product_id)->first();
                        if($productInvHeaders != null){
                            $request_flag = $request['active_flag'] == 'true' ? 'Y' : 'N';
         
                            if($productInvHeaders->active_flag == 'Y' && $request_flag == 'N'){
                                $data = ['status' => 'error'];
                                return  redirect()
                                        ->route('ir.settings.product-groups.index')
                                        ->with('error','ไม่สามารถปิดการใช้งานได้ เนื่องจากมีการใช้งานอยู่');
                            }else {
                                \DB::beginTransaction();
                                try {
                                    $groupProduct                               = PtirGroupProducts::find($request->group_product_id);
                                    $groupProduct->group_product_id             = $request->group_product_id;
                                    $groupProduct->policy_set_header_id         = $request->policy_set_header_id;
                                    $groupProduct->asset_group_code             = $request->asset_group_code;
                                    $groupProduct->description                  = $request->description;
                                    $groupProduct->account_id                   = $request->account_id;
                                    $groupProduct->active_flag                  = $request->active_flag == "true" ? 'Y' : 'N';
                                    $groupProduct->program_code                 = $profile->program_code;
                                    $groupProduct->last_updated_by              = $profile->user_id;
                                    $groupProduct->last_update_date             = now();
                                    $groupProduct->save();
                                    \DB::commit();
                                } catch (\Exception $e) {
                                    \DB::rollBack();
                                    if($request->ajax()){
                                        $result['status'] = 'ERROR';
                                        $result['err_msg'] = $e->getMessage();
                                        return $result;
                                    }else{
                                        \Log::error($e->getMessage());
                                        return abort('403');
                                    }  
                                }
                            }
                        }else{
                            \DB::beginTransaction();
                            try {
                                $groupProduct                               = PtirGroupProducts::find($request->group_product_id);
                                $groupProduct->group_product_id             = $request->group_product_id;
                                $groupProduct->policy_set_header_id         = $request->policy_set_header_id;
                                $groupProduct->asset_group_code             = $request->asset_group_code;
                                $groupProduct->description                  = $request->description;
                                $groupProduct->account_id                   = $request->account_id;
                                $groupProduct->active_flag                  = $request->active_flag == "true" ? 'Y' : 'N';
                                $groupProduct->program_code                 = $profile->program_code;
                                $groupProduct->last_updated_by              = $profile->user_id;
                                $groupProduct->last_update_date             = now();
                                $groupProduct->save();
                                \DB::commit();
                            } catch (\Exception $e) {
                                \DB::rollBack();
                                if($request->ajax()){
                                    $result['status'] = 'ERROR';
                                    $result['err_msg'] = $e->getMessage();
                                    return $result;
                                }else{
                                    \Log::error($e->getMessage());
                                    return abort('403');
                                }
                            }
                        }
                        return redirect()->route('ir.settings.product-groups.index')->with('success','ทำการเปลี่ยนข้อมูลกลุ่มสินค้าเรียบร้อยแล้ว');
                    }
                }
            }

            if( $request['old_checker_policy_set_header_id'] != $request['policy_set_header_id'] ||
                $request['old_checker_asset_group_code'] != $request['asset_group_code'] ||
                $request['old_checker_description'] != $request['description'] ||
                $request['old_checker_account_id'] != $request['account_id']){

                $isDuplicate = PtirGroupProducts::where('policy_set_header_id', $request['policy_set_header_id'])
                                                ->where('asset_group_code', $request['asset_group_code'])
                                                ->where('description', $request['description'])
                                                ->where('account_id', $request['account_id'])
                                                ->first();
                if($isDuplicate){
                    return  redirect()
                            ->back()
                            ->withErrors(['ข้อมูลกลุ่มสินค้านี้มีในระบบแล้ว ไม่สามารถอัพเดตข้อมูลได้ กรุณาตรวจสอบ']);
                }

                $productInvHeaders = PtirProductInvHeaders::where('group_product_id',$request->group_product_id)->first();
                if($productInvHeaders != null){
                    $request_flag = $request['active_flag'] == 'true' ? 'Y' : 'N';
         
                    if($productInvHeaders->active_flag == 'Y' && $request_flag == 'N'){
                        $data = ['status' => 'error'];
                        return  redirect()
                                ->route('ir.settings.product-groups.index')
                                ->with('error','ไม่สามารถปิดการใช้งานได้ เนื่องจากมีการใช้งานอยู่');
                    }else {
                        \DB::beginTransaction();
                        try {
                            $groupProduct                               = PtirGroupProducts::find($request->group_product_id);
                            $groupProduct->group_product_id             = $request->group_product_id;
                            $groupProduct->policy_set_header_id         = $request->policy_set_header_id;
                            $groupProduct->asset_group_code             = $request->asset_group_code;
                            $groupProduct->description                  = $request->description;
                            $groupProduct->account_id                   = $request->account_id;
                            $groupProduct->active_flag                  = $request->active_flag == "true" ? 'Y' : 'N';
                            $groupProduct->program_code                 = $profile->program_code;
                            $groupProduct->last_updated_by              = $profile->user_id;
                            $groupProduct->last_update_date             = now();
                            $groupProduct->save();
                            \DB::commit();
                        } catch (\Exception $e) {
                            \DB::rollBack();
                            if($request->ajax()){
                                $result['status'] = 'ERROR';
                                $result['err_msg'] = $e->getMessage();
                                return $result;
                            }else{
                                \Log::error($e->getMessage());
                                return abort('403');
                            }  
                        }
                    }
                }else{
                    \DB::beginTransaction();
                    try {
                        $groupProduct                               = PtirGroupProducts::find($request->group_product_id);
                        $groupProduct->group_product_id             = $request->group_product_id;
                        $groupProduct->policy_set_header_id         = $request->policy_set_header_id;
                        $groupProduct->asset_group_code             = $request->asset_group_code;
                        $groupProduct->description                  = $request->description;
                        $groupProduct->account_id                   = $request->account_id;
                        $groupProduct->active_flag                  = $request->active_flag == "true" ? 'Y' : 'N';
                        $groupProduct->program_code                 = $profile->program_code;
                        $groupProduct->last_updated_by              = $profile->user_id;
                        $groupProduct->last_update_date             = now();
                        $groupProduct->save();
                        \DB::commit();
                    } catch (\Exception $e) {
                        \DB::rollBack();
                        if($request->ajax()){
                            $result['status'] = 'ERROR';
                            $result['err_msg'] = $e->getMessage();
                            return $result;
                        }else{
                            \Log::error($e->getMessage());
                            return abort('403');
                        }
                    }
                }
                return redirect()->route('ir.settings.product-groups.index')->with('success','ทำการเปลี่ยนข้อมูลกลุ่มสินค้าเรียบร้อยแล้ว');
            }
        }
    }
}