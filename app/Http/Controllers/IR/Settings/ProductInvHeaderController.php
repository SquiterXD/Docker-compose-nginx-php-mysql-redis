<?php

namespace App\Http\Controllers\IR\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\IR\Settings\ProductInvHeader;
use App\Models\IR\Settings\ProductInvLine;
use App\Models\IR\Settings\GroupProduct;
use App\Models\IR\Settings\PolicySetHeader;
use App\Models\IR\Settings\SubGroups;
use App\Models\IR\Settings\SubInventory;
use App\Models\IR\Settings\ItemLocatorV;
use App\Models\IR\Settings\AssetGroupV;
use App\Models\IR\Settings\ItemCategory;

use App\Models\IR\Settings\PtglCoaDeptCodeView;

use Input;
use DB;

class ProductInvHeaderController extends Controller
{
    public function index()
    {
        // $tableProductInvHeader = (new ProductInvHeader)->getTable();
        $tableSubInventory = (new SubInventory)->getTable();
        $search = request()->search;
        $policySetHeadersTable = (new PolicySetHeader)->getTable();
        $groupProductsTable = (new GroupProduct)->getTable();

        // $headers = ProductInvHeader::SearchProductHeader($search)
        //                             ->orderBy('group_product_id')
        //                             ->get();
        $headers = ProductInvHeader::SearchProductHeader($search)
                                    ->orderBy('department_code')
                                    ->orderBy('subinventory_code')
                                    ->orderBy('sub_group_code')
                                    ->with( 'groupProduct', 'groupProduct.policySetHeader', 'department', 
                                            'subInventory', 'subGroups', 'groupProduct.assetGroup', 'groupProduct.accountsMapping')
                                    //->paginate('15')
                                    ->whereHas('groupProduct.policySetHeader')
                                    ->get()
                                    ->sortBy(function($query){
                                        return $query->groupProduct->account_id;
                                    })
                                    ->sortBy(function($query){
                                        return $query->groupProduct->description;
                                    })
                                    ->sortBy(function($query){
                                        return $query->groupProduct->asset_group_code;
                                    })
                                    ->sortBy(function($query){
                                        return $query->groupProduct->policy_set_number;
                                    })
                                    ->each(function ($item, $key) {
                                        $item->showFlag = $item->active_flag == 'Y';
                                    });

        // $policySetHeaders = PolicySetHeader::orderBy('policy_set_number')
        //                                     ->where('active_flag', 'Y')
        //                                     ->where('policy_type_code', 'DCT')
        //                                     ->get();
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
        $groupProducts = GroupProduct::where('active_flag', 'Y')
                                    ->whereHas('policySetHeader')
                                    ->orderBy('description')
                                    ->get();
        $departments = PtglCoaDeptCodeView::orderBy('department_code')->get(); 
        $assetGroups = AssetGroupV::orderBy('value')->get();
        $subGroups = SubGroups::selectRaw('distinct sub_group_code, sub_group_description, policy_set_header_id')
                            ->where('active_flag', 'Y')
                            ->get();
        // $subInventories = SubInventory::selectRaw('distinct subinventory_code, subinventory_desc')
        //                                 ->get();
        $subInventories = \DB::select("     select  DISTINCT
                                                                subinventory_code,
                                                                subinventory_desc
                                            from    {$tableSubInventory}
                                                    ORDER BY subinventory_code ASC              ");

        $itemCategories = ItemCategory::orderBy('lookup_code')->get();
                  
        return  view('ir.settings.product-inv.index', 
                compact('headers', 'policySetHeaders', 'assetGroups', 'departments',
                        'subInventories', 'subGroups', 'groupProducts', 'itemCategories', 'search'));
    }

    public function create()
    {
        $tableSubInventory = (new SubInventory)->getTable();
        $oldGroupCode = null;
        // $groupProducts = GroupProduct::where('active_flag', 'Y')
        //                             ->with('accountsMapping', 'assetGroup', 'policySetHeader')
        //                             // ->orderBy('PTIR_POLICY_SET_HEADERS.policy_set_number')                                
        //                             // ->orderBy('description')  
        //                             ->get();
        $groupProducts = \DB::select("      
                                        SELECT      b.policy_set_header_id      policy_set_header_id,
                                                    b.policy_set_number         policy_set_number,
                                                    a.group_product_id          group_product_id,
                                                    a.description               group_product_description,      
                                                    c.description               asset_group_description 
                                        FROM        ptir_group_products         a,
                                                    PTIR_POLICY_SET_HEADERS     b,
                                                    PTIR_ASSET_GROUP_V          c
                                        WHERE       a.policy_set_header_id = b.policy_set_header_id
                                        AND         a.asset_group_code = c.value
                                        AND         a.active_flag = 'Y'
                                        ORDER BY    policy_set_number ASC, asset_group_description ASC, group_product_description ASC
                                                                                                                        ");
        $policySets = PolicySetHeader::orderBy('policy_set_number')
                                    ->where('active_flag', 'Y')
                                    ->where('policy_type_code', 'DCT')
                                    ->get();
        $subInventories = \DB::select("     select  DISTINCT
                                                                subinventory_code,
                                                                subinventory_desc
                                            from    {$tableSubInventory}
                                                    ORDER BY subinventory_code ASC              ");
        $departments = PtglCoaDeptCodeView::all();
        $btnTrans = trans('btn');
        return  view('ir.settings.product-inv.create', 
                compact('groupProducts', 'policySets', 'subInventories', 
                        'departments', 'oldGroupCode','btnTrans'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'department_code'   => 'required', 
            'subinventory_code' => 'required',
            'sub_group_code'    => 'required',
            'cate_codes.*'      => 'required',
            
        ],[
            'department_code.required'      => 'กรุณาเลือกรหัสหน่วยงาน', 
            'subinventory_code.required'    => 'กรุณาเลือกรหัสคลังสินค้า',
            'sub_group_code.required'       => 'กรุณาเลือกกลุ่มสินค้าย่อย',
            'cate_codes.*.required'         => 'กรุณาเลือกรหัสประเภท',
        ]);

        $categoryCodeLineArr    = $request['cate_codes'];
        $zoneCodeLineArr        = $request['locators'];
        $groupCode              = $request['group_code'];
        $departmentArray        = explode(',', $request['department_code']);
        $departmentCode         = $departmentArray[0];
        $departmentDesc         = $departmentArray[1]; 
        $subinventoryArray      = explode(',', $request['subinventory_code']);
        $subinventoryCode       = $subinventoryArray[0];
        $subinventoryDesc       = $subinventoryArray[1]; 
        $subGroupArray          = explode(',', $request['sub_group_code']);
        $subGroupCode           = $subGroupArray[0];
        $subGroupDesc           = $subGroupArray[1];

        $userId             = getDefaultData('/ir/settings/product-header')->user_id;
        $program_code       = getDefaultData('/ir/settings/product-header')->program_code;
        $isDuplicateHeader  = ProductInvHeader::where('department_code', $departmentCode)
                                            ->where('department_desc', $departmentDesc)
                                            ->where('subinventory_code', $subinventoryCode)
                                            ->where('subinventory_desc', $subinventoryDesc)
                                            ->where('sub_group_code', $subGroupCode)
                                            ->where('sub_group_desc', $subGroupDesc)
                                            ->where('group_product_id', $groupCode)
                                            ->where('active_flag', 'Y')
                                            ->first();

        if($isDuplicateHeader){
            $data = 'DuplicateHeader';
            return  redirect()
                    ->route('ir.settings.product-header.create', compact('groupCode', 'data'))
                    ->withErrors(['มีข้อมูลซ้ำ ระดับ header'])
                    ->withInput($request->all());
        }else{
            $isDuplicateLine = ProductInvHeader::whereHas('productInvLines', function ($q) use ($categoryCodeLineArr, $zoneCodeLineArr){
                                                    $q  ->whereIn('category_code', $categoryCodeLineArr)
                                                        ->whereIn('zone_code', $zoneCodeLineArr);
                                                })
                                                ->where('subinventory_code', $subinventoryCode)
                                                ->where('subinventory_desc', $subinventoryDesc)
                                                ->where('group_product_id', $groupCode)
                                                ->first();
            if($isDuplicateLine){
                $data = 'DuplicateLine';
                return  redirect()
                        ->route('ir.settings.product-header.create', compact('groupCode', 'data'))
                        ->withErrors(['มีข้อมูลซ้ำ ระดับ Line'])
                        ->withInput($request->all());
            }  
            $data = 's';
        }

        \DB::beginTransaction();
        try {
                $productInvHeader                               = new ProductInvHeader();
                $productInvHeader->group_product_id             = $groupCode;
                $productInvHeader->department_code              = $departmentCode;
                $productInvHeader->department_desc              = $departmentDesc;
                $productInvHeader->subinventory_code            = $subinventoryCode;
                $productInvHeader->subinventory_desc            = $subinventoryDesc;
                $productInvHeader->sub_group_code               = $subGroupCode;
                $productInvHeader->sub_group_desc               = $subGroupDesc;
                $productInvHeader->active_flag                  = $request->activeFlag ? 'Y' : 'N';
                $productInvHeader->program_code                 = $program_code;
                $productInvHeader->created_at                   = now();
                $productInvHeader->created_by_id                = $userId;
                $productInvHeader->created_by                   = $userId;
                $productInvHeader->last_updated_by              = $userId;
                $productInvHeader->creation_date                = now();
                $productInvHeader->last_update_date             = now();

                $productInvHeader->save();
      
                foreach($request->cate_codes as $index => $cate_code){

                    $productInvLine                         = new ProductInvLine();
                    $productInvLine->header_id              = $productInvHeader->header_id;
                    $productInvLine->category_code          = $cate_code;
                    $productInvLine->zone_code              = $request->locators[$index];
                    $productInvLine->program_code           = $program_code;
                    $productInvLine->created_at             = now();
                    $productInvLine->created_by_id          = $userId;
                    $productInvLine->created_by             = $userId;
                    $productInvLine->last_updated_by        = $userId;
                    $productInvLine->creation_date          = now();
                    $productInvLine->last_update_date       = now();
                    // \Log::info($index);
                    $productInvLine->save();                
                }

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
        return redirect()->route('ir.settings.product-header.create', compact('groupCode', 'data'))->with('success','ทำการเพิ่มข้อมูลเรียบร้อยแล้ว');
    }

    public function edit($id)
    {
        $header = ProductInvHeader::with('productInvLines')
                                    ->find($id);
        $header->showFlag = $header->active_flag == 'Y';

        $subinventoryCodeArr = ProductInvHeader::where('header_id',$id)
                                            ->pluck('subinventory_code');
        $subinventoryCode = $subinventoryCodeArr[0];
        $itemLocators = ItemLocatorV::where('parent_flex_value', $subinventoryCode)
                                    ->limit(50)
                                    ->get();
        $itemCategories = ItemCategory::orderBy('lookup_code')->get();
        $btnTrans = trans('btn');

        return view('ir.settings.product-inv.edit', 
               compact('header', 'itemLocators', 'itemCategories', 'btnTrans'));
    }

    public function update(Request $request)
    {
        $userId = optional(auth()->user())->user_id ?? -1;
        $program_code = getDefaultData('/ir/settings/product-header')->program_code;
        $headerId = $request->productInvHeader;
        $groupCode = $request['groupProductId'];
        $activeFlag = $request->activeFlag == 'true' ? 'Y' : 'N';
        $confirmActiveFlag = $request->confirmActiveFlag;
        $openProgamFlag = $request->openProgamFlag;
        $headers = ProductInvHeader::find($headerId);
        $groupProducts = GroupProduct::find($headers['group_product_id']);
        $subGroups = SubGroups::where('sub_group_code', $headers['sub_group_code'])
                            ->where('policy_set_header_id', $groupProducts['policy_set_header_id'])
                            ->first();

        if($activeFlag == 'Y'){
            if($openProgamFlag == 'twoClose'){
                (new GroupProduct)->updateActiveFlag($groupProducts['group_product_id'], $activeFlag, $userId);
                (new SubGroups)->updateActiveFlag($subGroups['sub_group_id'], $activeFlag, $userId);
                (new ProductInvHeader)->updateActiveFlag($headerId, $activeFlag, $userId);
            }
            if($openProgamFlag == 'IRM0004Close'){
                (new GroupProduct)->updateActiveFlag($groupProducts['group_product_id'], $activeFlag, $userId);
                (new ProductInvHeader)->updateActiveFlag($headerId, $activeFlag, $userId);
            }
            if($openProgamFlag == 'IRM0009Close'){
                (new SubGroups)->updateActiveFlag($subGroups['sub_group_id'], $activeFlag, $userId);
                (new ProductInvHeader)->updateActiveFlag($headerId, $activeFlag, $userId);
            }
            if($groupProducts['active_flag'] == 'Y' && $subGroups['active_flag'] == 'Y'){
                (new ProductInvHeader)->updateActiveFlag($headerId, $activeFlag, $userId);
            }
        }else {
            (new ProductInvHeader)->updateActiveFlag($headerId, $activeFlag, $userId);
        }

        \DB::beginTransaction();
        try {
            $productInvLineArr  = ProductInvLine::where('header_id', $request->productInvHeader)->get()->pluck('line_id')->toArray();
            
            foreach ($request->dataGroup as $key => $line) {   
                if (in_array($line['line_id'], $productInvLineArr)) { 
                    // $isDuplicateLine = ProductInvHeader::where('subinventory_code', $request->subinventory_code)
                    //                                     ->where('subinventory_desc', $request->subinventory_desc)
                    //                                     ->where('group_product_id', $groupCode)
                    //                                     ->whereHas('productInvLines', function ($q) use ($line){
                    //                                         $q  ->where('line_id', '!=', $line['line_id'])
                    //                                             ->where('category_code', $line['cate_codes'])
                    //                                             ->where('zone_code', $line['locators']);
                    //                                     })
                    //                                     ->first();
                    // if($isDuplicateLine){
                    //     $data = 'DuplicateLine';

                    //     return redirect()->route('ir.settings.product-header.edit', [   'id' => $request->productInvHeader,
                    //                                                                     'data' => $data ])
                    //                     ->withErrors(['มีข้อมูลซ้ำ ระดับ Line']);
                    // }
                    $productInvLine                             = ProductInvLine::find($line['line_id']);
                    $productInvLine->header_id                  = $headerId;
                    $productInvLine->category_code              = $line['cate_codes']; 
                    $productInvLine->zone_code                  = $line['locators']; 
                    $productInvLine->program_code               = $program_code;
                    $productInvLine->updated_at                 = now();
                    $productInvLine->updated_by_id              = $userId;
                    $productInvLine->last_updated_by            = $userId;
                    $productInvLine->last_update_date           = now();
                    $productInvLine->save();

                    $data = 's';
                }else{      
                    if($line['line_id'] == null) {
                        $isDuplicateLine = ProductInvHeader::whereHas('productInvLines', function ($q) use ($line){
                                                                $q  ->where('category_code', $line['cate_codes'])
                                                                    ->where('zone_code', $line['locators']);
                                                            })
                                                            ->where('group_product_id', $groupCode)
                                                            ->where('subinventory_code', $request->subinventory_code)
                                                            ->where('subinventory_desc', $request->subinventory_desc)
                                                            ->first();
                        // if($isDuplicateLine){
                        //     $data = 'DuplicateLine';

                        //     return redirect()->route('ir.settings.product-header.edit', [   'id' => $request->productInvHeader,
                        //                                                                     'data' => $data])
                        //                     ->withErrors(['มีข้อมูลซ้ำ ระดับ Line']);
                        // }   
                        $data = 's';
                        $productInvLineNew              = ProductInvLine::updateOrCreate([
                            'line_id'                   => $line['line_id'],                        
                        ],[
                            'header_id'                 => $headerId,
                            'category_code'             => $line['cate_codes'],
                            'zone_code'                 => $line['locators'],
                            'program_code'              => $program_code,
                            'created_at'                => now(),
                            'created_by_id'             => $userId,
                            'created_by'                => $userId,
                            'last_updated_by'           => $userId,
                            'last_update_date'          => now()
                        ]);
                    }
                }
            }

            \DB::commit();

            if($request->ajax()){
                $result['status'] = 'SUCCESS';
                return $result;
            }

        } catch (\Exception $e) {
            // ERROR CREATE
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

        return redirect()->route('ir.settings.product-header.index')
                        ->with('success','ทำการเปลี่ยนแปลงข้อมูลเรียบร้อยแล้ว');
    }

}
