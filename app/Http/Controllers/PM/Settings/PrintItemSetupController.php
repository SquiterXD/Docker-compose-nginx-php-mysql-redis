<?php

namespace App\Http\Controllers\PM\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PM\Settings\ItemNumberV;
use App\Models\PM\Settings\PrintItemSetup;
use App\Models\MtlParameter;
use App\Models\QM\FndLookupValue;
use App\Models\PM\PtpmPrintItemCatV;

class PrintItemSetupController extends Controller
{
    public function index()
    {
        $tableLookupValues = (new FndLookupValue)->getTable();
        $btnTrans = trans('btn');
        $arrDataInventoryItemIdSetup = [];
        
        if(array_key_exists('search', request()->all())){
            $search = request()->all()['search'];
            $inventoryItemId = $search['inventory_item_id'];
            $size = $search['size'];
            $brand = $search['brand'];
            $product = $search['product'];
            $printType = $search['printType'];
        }else{
            $search = [];
            $inventoryItemId = '';
            $size = '';
            $brand = '';
            $product = '';
            $printType = '';
        }

        $printItemSetupList = PrintItemSetup::when($inventoryItemId, function($q) use ($inventoryItemId) {
                                                    $q->where('inventory_item_id', $inventoryItemId);
                                                })
                                            ->when($size, function($q) use ($size) {
                                                $q->where('tobacco_size', $size);
                                            })
                                            ->when($brand, function($q) use ($brand) {
                                                $q->where('brand', $brand);
                                            })
                                            ->when($product, function($q) use ($product) {
                                                $q->where('product', $product);
                                            })
                                            ->when($printType, function($q) use ($printType) {
                                                $q->where('print_type', $printType);
                                            })
                                            ->get();
        $printItemSetupListAll = PrintItemSetup::all();
        $sizeList = \DB::select("                                
                                    SELECT *
                                    FROM    {$tableLookupValues}
                                    WHERE   lookup_type = 'PTPP_PRODUCT_TYPES'
                                    AND     attribute1 = 'MG6'
                                                                                        ");
        $brandList =  PrintItemSetup::selectRaw(" DISTINCT brand ")
                                    ->orderBy('brand', 'asc')
                                    ->get();

        $productList =  PrintItemSetup::selectRaw(" DISTINCT product ")
                                    ->orderBy('product', 'asc')
                                    ->get();

        // $printTypeList = \DB::select("                                
        //                                 SELECT  * 
        //                                 FROM    {$tableLookupValues}
        //                                 WHERE   lookup_type = 'PTPM_PRINT_TYPE'
        //                                 AND     enabled_flag = 'Y'
        //                                                                             ");
        $printTypeList = $this->getPrintTypeList();

        foreach ($printItemSetupListAll as $key => $value) {
            array_push($arrDataInventoryItemIdSetup,$value['inventory_item_id']);
        }

        $itemNumberList = ItemNumberV::select('inventory_item_id', 'item_number', 'item_desc')
                                    ->whereIn('item_type', ['SFG','FG'])
                                    ->where('enabled_flag', 'Y')
                                    ->where('inventory_item_status_code', 'Active')
                                    ->where('organization_code', 'M06')
                                    ->whereIn('inventory_item_id', $arrDataInventoryItemIdSetup)
                                    ->orderBy('item_number', 'asc')
                                    ->get();

        $printItemSetupList->map(function ($item, $key) use($tableLookupValues, $printTypeList) {
            $item->itemNumberV = ItemNumberV::select('inventory_item_id', 'item_number', 'item_desc')
                                    ->where('inventory_item_id', $item['inventory_item_id'])
                                    ->where('organization_code', 'M06')
                                    ->first();
            $item->lookupValues = \DB::select("                                
                                                select *
                                                from    {$tableLookupValues}
                                                where   lookup_type = 'PTPP_PRODUCT_TYPES'
                                                and     attribute1 = 'MG6'
                                                and     lookup_code = '{$item['tobacco_size']}'
                                                                                                    ");
            // $item->printType = \DB::select("                                
            //                                     select * 
            //                                     from    {$tableLookupValues}
            //                                     where   lookup_type = 'PTPM_PRINT_TYPE'
            //                                     and     enabled_flag = 'Y'
            //                                     and     lookup_code = '{$item['print_type']}'
            //                                                                                         ");
            $item->printType = array_values($printTypeList->where('lookup_code', $item['print_type'])->toArray());
            
        });
                                    
        return  view('pm.print-item-setup.index', 
                compact('printItemSetupList', 
                        'btnTrans', 
                        'itemNumberList',
                        'search',
                        'sizeList',
                        'brandList',
                        'productList',
                        'printTypeList'));
    }

    public function create()
    {
        $tableLookupValues = "fnd_lookup_values";
        $itemNumberList = ItemNumberV::select('inventory_item_id', 'item_number', 'item_desc')
                                    ->whereIn('item_type', ['SFG','FG'])
                                    ->where('enabled_flag', 'Y')
                                    ->where('inventory_item_status_code', 'Active')
                                    ->where('organization_code', 'M06')
                                    ->orderBy('item_number', 'asc')
                                    ->get();
        $btnTrans = trans('btn');
        $sizeList = \DB::select("                                
                                        SELECT *
                                        FROM    {$tableLookupValues}
                                        WHERE   lookup_type = 'PTPP_PRODUCT_TYPES'
                                        AND     attribute1 = 'MG6'
                                                                                    ");
        // $printTypeList = \DB::select("                                
        //                                 SELECT * 
        //                                 FROM    {$tableLookupValues}
        //                                 WHERE   lookup_type = 'PTPM_PRINT_TYPE'
        //                                 AND     enabled_flag = 'Y'
        //                                                                             ");
        $printTypeList = $this->getPrintTypeList();
        return view('pm.print-item-setup.create', compact('itemNumberList', 'sizeList', 'printTypeList', 'btnTrans'));
    }

    public function store(Request $request)
    {
        $programCode = getDefaultData('/pm/settings/print-item-setup')->program_code;
        $userId = getDefaultData('/pm/settings/print-item-setup')->organization_id;
        $organizationM06 = MtlParameter::where('organization_code', 'M06')->value('organization_id');

        $this->validate(request(),[
            'inventory_item_id'         => 'required',
            // 'tobacco_size'              => 'required',
            'brand'                     => 'required',
            'brand_colors'              => 'required',
            'product'                   => 'required',
            'product_colors'            => 'required',
        ], [
            'inventory_item_id.required'    => 'โปรดเลือก รหัสบุหรี่',
            // 'tobacco_size.required'         => 'โปรดเลือก ขนาดบุหรี่',
            'brand.required'                => 'โปรดกรอก Brand',
            'brand_colors.required'         => 'โปรดกรอก Color Brand',
            'product.required'              => 'โปรดกรอก Product',
            'product_colors.required'       => 'โปรดกรอก Color Product', 
        ]);

        $isDuplicate = PrintItemSetup::where('organization_id', $organizationM06)
                                    ->where('inventory_item_id', $request['inventory_item_id'])
                                    ->first();   
        if($isDuplicate){
            return redirect()->route('pm.settings.print-item-setup.create')->withErrors(['มีข้อมูลการบันทึกซ้ำ']);
        }  

        \DB::beginTransaction();
        try {
            $printItemSetup                             = new PrintItemSetup();
            $printItemSetup->organization_id            = $organizationM06;
            $printItemSetup->inventory_item_id          = $request['inventory_item_id'];
            $printItemSetup->tobacco_size               = data_get($request, 'tobacco_size');
            $printItemSetup->brand                      = $request['brand'];
            $printItemSetup->brand_colors               = $request['brand_colors'];
            $printItemSetup->product                    = $request['product'];
            $printItemSetup->product_colors             = $request['product_colors'];
            $printItemSetup->enable_flag                = $request['enabled_flag'] == "true" ? 'Y' : 'N';
            $printItemSetup->print_type                 = $request['print_type'];
            $printItemSetup->program_id                 = $programCode ? $programCode : 'PMS0051';
            $printItemSetup->created_by                 = $userId;
            $printItemSetup->creation_date              = now(); 
            $printItemSetup->last_updated_by            = $userId;
            $printItemSetup->last_update_date           = now();

            $printItemSetup->save();
          
            // SUCCESS CREATE
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

        return redirect()->route('pm.settings.print-item-setup.index')->with('success','ทำการบันทึกข้อมูลเรียบร้อยแล้ว');
    }

    public function edit($id)
    {
        $printItemSetup = PrintItemSetup::where('pm_print_set_id', $id)->first();
        $tableLookupValues = "fnd_lookup_values";
        $itemNumberList = ItemNumberV::select('inventory_item_id', 'item_number', 'item_desc')
                                    ->where('organization_code', 'M06')
                                    // ->where('enabled_flag', 'Y')
                                    // ->where('inventory_item_status_code', 'Active')
                                    ->where('inventory_item_id', $printItemSetup['inventory_item_id'])
                                    ->get();
        $btnTrans = trans('btn');
        $sizeList = \DB::select("                                
                                        SELECT *
                                        FROM    {$tableLookupValues}
                                        WHERE   lookup_type = 'PTPP_PRODUCT_TYPES'
                                        AND     attribute1 = 'MG6'
                                                                                    ");

        // $printTypeList = \DB::select("                                
        //                                 SELECT * 
        //                                 FROM    {$tableLookupValues}
        //                                 WHERE   lookup_type = 'PTPM_PRINT_TYPE'
        //                                 AND     enabled_flag = 'Y'
        //                                                                             ");
        $printTypeList = $this->getPrintTypeList();

        return view('pm.print-item-setup.edit', compact('printItemSetup', 'itemNumberList', 'sizeList', 'printTypeList', 'btnTrans'));
    }

    public function update(Request $request)
    {
        $programCode = getDefaultData('/pm/settings/print-item-setup')->program_code;
        $userId = getDefaultData('/pm/settings/print-item-setup')->organization_id;
        // $organizationM06 = MtlParameter::where('organization_code', 'M06')->value('organization_id');

        $this->validate(request(),[
            'inventory_item_id'         => 'required',
            // 'tobacco_size'              => 'required',
            'brand'                     => 'required',
            'brand_colors'              => 'required',
            'product'                   => 'required',
            'product_colors'            => 'required',
        ], [
            'inventory_item_id.required'    => 'โปรดเลือก รหัสบุหรี่',
            // 'tobacco_size.required'         => 'โปรดเลือก ขนาดบุหรี่',
            'brand.required'                => 'โปรดกรอก Brand',
            'brand_colors.required'         => 'โปรดกรอก Color Brand',
            'product.required'              => 'โปรดกรอก Product',
            'product_colors.required'       => 'โปรดกรอก Color Product', 
        ]);

        \DB::beginTransaction();
        try {
            $printItemSetup                             = PrintItemSetup::find($request['pm_print_set_id']);
            // $printItemSetup->organization_id            = $organizationM06;
            // $printItemSetup->inventory_item_id          = $request['inventory_item_id'];
            $printItemSetup->tobacco_size               = data_get($request, 'tobacco_size');
            $printItemSetup->brand                      = $request['brand'];
            $printItemSetup->brand_colors               = $request['brand_colors'];
            $printItemSetup->product                    = $request['product'];
            $printItemSetup->product_colors             = $request['product_colors'];
            $printItemSetup->print_type                 = $request['print_type'];
            $printItemSetup->enable_flag                = $request['enabled_flag'] == "true" ? 'Y' : 'N';
            $printItemSetup->program_id                 = $programCode ? $programCode : 'PMS0051';
            $printItemSetup->created_by                 = $userId;
            $printItemSetup->creation_date              = now(); 
            $printItemSetup->last_updated_by            = $userId;
            $printItemSetup->last_update_date           = now();

            $printItemSetup->save();
          
            // SUCCESS CREATE
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


        return redirect()->route('pm.settings.print-item-setup.index')->with('success','เปลี่ยนแปลงข้อมูลสำเร็จ');
    }

    public function getPrintTypeList()
    {
        $data = PtpmPrintItemCatV::selectRaw("
                    cost_segment1 as lookup_code
                    , cost_description as description
                ")
                ->groupByRaw("cost_segment1, cost_description")
                ->get();
        return $data;
    }
}
