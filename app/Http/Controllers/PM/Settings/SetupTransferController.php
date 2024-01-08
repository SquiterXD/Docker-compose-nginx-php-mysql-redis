<?php

namespace App\Http\Controllers\PM\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PM\Settings\SetupTransferLocV;
use App\Models\PM\Settings\OrganizationsInfo;
use App\Models\PM\Settings\Parameters;
use App\Models\PM\Settings\ItemCategorys;
use App\Models\PM\Settings\SetupTransferLocations;
use App\Models\PM\Settings\SubinventoryV;
use App\Models\PM\Settings\ItemLocationsKfv;
use App\Models\PM\Settings\RequestType;

use DB;

class SetupTransferController extends Controller
{
    public function index(Request $request)
    {
        $org = getDefaultData('/pm/settings/setup-transfer')->organization_id;
        $btnTrans = trans('btn');
        $tableParameters = (new Parameters)->getTable();
        $tableSetupTransferLocV = (new SetupTransferLocV)->getTable();
        $tableItemCategorys = (new ItemCategorys)->getTable();
        $tableOrganizationsInfo = (new OrganizationsInfo)->getTable();
        $ListSetupTransfer = DB::table("{$tableSetupTransferLocV}")
                    ->where('user_organization_id', $org)
                    ->when(!empty($request->tsm), function($q) use($tableSetupTransferLocV, $request) {
                        $q->where($tableSetupTransferLocV.'.request_type', $request->tsm);
                    })
                    ->when(!empty($request->ty), function($q) use($tableItemCategorys, $request) {
                        $desc = explode(':',$request->ty);
                        $q->where($tableItemCategorys.'.description', $desc[1]);
                    })
                    ->join("{$tableParameters}", "{$tableParameters}.organization_id", '=', "{$tableSetupTransferLocV}.user_organization_id")
                    ->join("{$tableItemCategorys}", "{$tableItemCategorys}.lookup_code", '=', "{$tableSetupTransferLocV}.item_cat_code")
                    ->leftJoin("{$tableOrganizationsInfo}", "{$tableSetupTransferLocV}.to_organization_id", '=',"{$tableOrganizationsInfo}.organization_id")
                    ->select("{$tableSetupTransferLocV}.*", "{$tableParameters}.organization_code", "{$tableItemCategorys}.description", "{$tableOrganizationsInfo}.organization_name")
                    ->skip($request->start)->take($request->length)->get();
        $ListSetupTransfer->map(function($item) use($btnTrans) {
            $item->_html_enable_flag = "<div class='tw-text-center'>".view('shared._status_active', ['isActive' => $item->enable_flag == 'Y' ? true : false])->render() . "</div>";
            $item->to_organization_code_organization_name = $item->to_organization_code. " : " .$item->organization_name;
            $item->action = '<div class="text-center">
            <a  type="button" href="'. route('pm.settings.setup-transfer.edit', $item->setup_trans_id) .'" 
                            class="'. $btnTrans['edit']['class'] .'">
                            <i class="'. $btnTrans['edit']['icon'] .'" aria-hidden="true"></i> '. $btnTrans['edit']['text'] .'
                        </a>
                        </div>';
            return $item;
        });
        $filterItemCat = DB::table($tableItemCategorys)
        ->select('description', 'lookup_code')
        ->whereNotNull('description')
        ->get();
        $filterItemCat = $filterItemCat->map(function($item) {
            $item->lookup_code = $item->lookup_code . ":" . $item->description;
            return $item;
        });
        $filterItemCat = $filterItemCat->pluck('lookup_code','description');
        $filterSetupTransferLocV = DB::table($tableSetupTransferLocV)->whereNotNull('request_type')->where('user_organization_id', $org)->get()
        ->pluck('request_type', 'request_type');
        if($request->ajax()) {
            $recordsFiltered = DB::table("{$tableSetupTransferLocV}")
                    ->where('user_organization_id', $org)
                    ->join("{$tableParameters}", "{$tableParameters}.organization_id", '=', "{$tableSetupTransferLocV}.user_organization_id")
                    ->join("{$tableItemCategorys}", "{$tableItemCategorys}.lookup_code", '=', "{$tableSetupTransferLocV}.item_cat_code")
                    ->leftJoin("{$tableOrganizationsInfo}", "{$tableSetupTransferLocV}.to_organization_id", '=',"{$tableOrganizationsInfo}.organization_id")
                    ->select("{$tableSetupTransferLocV}.*", "{$tableParameters}.organization_code", "{$tableItemCategorys}.description", "{$tableOrganizationsInfo}.organization_name")
                    ->count();
                    
            $recordsTotal =  DB::table("{$tableSetupTransferLocV}")
                            ->where('user_organization_id', $org)
                            ->join("{$tableParameters}", "{$tableParameters}.organization_id", '=', "{$tableSetupTransferLocV}.user_organization_id")
                            ->join("{$tableItemCategorys}", "{$tableItemCategorys}.lookup_code", '=', "{$tableSetupTransferLocV}.item_cat_code")
                            ->leftJoin("{$tableOrganizationsInfo}", "{$tableSetupTransferLocV}.to_organization_id", '=',"{$tableOrganizationsInfo}.organization_id")
                            ->select("{$tableSetupTransferLocV}.*", "{$tableParameters}.organization_code", "{$tableItemCategorys}.description", "{$tableOrganizationsInfo}.organization_name")
                            ->count();

            return response()->json([
                'draw' => $request->draw,
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $ListSetupTransfer,
            ]);
        }
        return  view('pm.settings.setup-transfer.index', 
                compact('ListSetupTransfer', 'btnTrans', 'filterItemCat', 'filterSetupTransferLocV'));
    }

    public function create()
    {
        $oldInput = request()->old();
        $itemCats = ItemCategorys::where('enabled_flag','Y')
                                ->get();
        $requestTypes = RequestType::where('enabled_flag','Y')
                                ->get();
        $btnTrans = trans('btn');
        return  view('pm.settings.setup-transfer.create', 
                compact('itemCats', 'btnTrans', 'oldInput', 'requestTypes'));
    }

    public function store(Request $request)
    {
        $profile = getDefaultData('/pm/settings/setup-transfer');
        $this->validate($request,[
            'request_type' => 'required', 
            'toOrganization' => 'required', 
            'item_cat' => 'required',
            'subinventory_code' => 'required',
            'inventory_location_id' => 'required',
        ],[
            'request_type.required' => 'กรุณาเลือก ประเภทการเบิก', 
            'toOrganization.required' => 'กรุณาเลือก Organization รับวัตถุดิบ', 
            'item_cat.required' => 'กรุณาเลือก ประเภทวัตถุดิบ',
            'subinventory_code.required' => 'กรุณาเลือก คลังจัดเก็บ',
            'inventory_location_id.required' => 'กรุณาเลือก สถานที่จัดเก็บ',
        ]);
        $checkDuplicateData = SetupTransferLocations::where('to_subinventory_code', $request['subinventory_code'])
                                                    ->where('request_type', $request['request_type'])
                                                    ->where('to_locator_id', $request['inventory_location_id'])
                                                    ->where('item_cat_code', $request['item_cat'])
                                                    ->where('user_organization_id', $profile->organization_id)
                                                    ->first();
        if($checkDuplicateData){
            return  redirect()
                    ->back()
                    ->with('error','ไม่สามารถบันทึกข้อมูลได้ เนื่องจากมีข้อมูลการบันทึกคลังเบิกวัตถุดิบซ้ำ')
                    ->withInput($request->input());
        }
        $checkDuplicateDataItemCat = SetupTransferLocations::where('item_cat_code',  $request['item_cat'])
                                                            ->where('request_type', $request['request_type'])
                                                            ->where('user_organization_id', $profile->organization_id)
                                                            ->first();
        if($checkDuplicateDataItemCat){
            return  redirect()
                    ->back()
                    ->with('error','ไม่สามารถบันทึกข้อมูลได้ เนื่องจากมีข้อมูลประเภทวัตถุดิบซ้ำ')->withInput($request->input());
        }
        \DB::beginTransaction();
        try {
                $transfer                               = new SetupTransferLocations();
                $transfer->user_organization_id         = $profile->organization_id;
                $transfer->request_type                 = $request['request_type'];
                $transfer->to_organization_id           = $request['toOrganization'];
                $transfer->to_subinventory_code         = $request['subinventory_code'];
                $transfer->to_locator_id                = $request['inventory_location_id'];
                $transfer->item_cat_code                = $request['item_cat'];
                $transfer->program_code                 = $profile->program_code;
                $transfer->enable_flag                  = $request['enableFlag'] == 'true' ? 'Y' : 'N';
                $transfer->created_at                   = now();
                $transfer->created_by_id                = $profile->user_id;
                $transfer->updated_by_id                = $profile->user_id;   
                $transfer->last_updated_by              = $profile->user_id;
                $transfer->last_update_date             = now();

                $transfer->save();

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
        return  redirect()
                ->route('pm.settings.setup-transfer.index')
                ->with('success','ทำการเพิ่มข้อมูล การบันทึกคลังเบิกวัตถุดิบ');
    }

    public function edit($id)
    { 
        $tableParameters = (new Parameters)->getTable();
        $tableSetupTransferLocV = (new SetupTransferLocV)->getTable();
        $tableItemCategorys = (new ItemCategorys)->getTable();
        $tableOrganizationsInfo = (new OrganizationsInfo)->getTable();
        $tableSubinventoryV = (new SubinventoryV)->getTable();
        $tableItemLocationsKfv = (new ItemLocationsKfv)->getTable();
        $transfers = DB::table("{$tableSetupTransferLocV}")
                        ->where('setup_trans_id', $id)
                        ->join("{$tableParameters}", "{$tableParameters}.organization_id", '=',"{$tableSetupTransferLocV}.user_organization_id")
                        ->join("{$tableOrganizationsInfo}", "{$tableOrganizationsInfo}.organization_id", '=',"{$tableSetupTransferLocV}.to_organization_id")
                        ->join("{$tableSubinventoryV}", "{$tableSubinventoryV}.subinventory_code", '=',"{$tableSetupTransferLocV}.to_subinventory_code")
                        ->join("{$tableItemLocationsKfv}", "{$tableItemLocationsKfv}.inventory_location_id", '=',"{$tableSetupTransferLocV}.to_locator_id")
                        ->select("{$tableSetupTransferLocV}.*", "{$tableParameters}.organization_code", "{$tableOrganizationsInfo}.organization_name", "{$tableSubinventoryV}.subinventory_desc", "{$tableItemLocationsKfv}.description")
                        ->first();
        $itemCats = ItemCategorys::where('enabled_flag',"Y")
                                ->get();
        $btnTrans = trans('btn');
        $requestTypes = RequestType::where('enabled_flag','Y')
                                    ->get();
        return  view('pm.settings.setup-transfer.edit', 
                compact('transfers', 'itemCats', 'btnTrans', 'requestTypes'));
    }

    public function update(Request $request)
    {
        $this->validate($request,[
            'request_type' => 'required', 
            'toOrganization' => 'required', 
            'item_cat' => 'required',
            'subinventory_code' => 'required',
            'inventory_location_id' => 'required',
        ],[
            'request_type.required' => 'กรุณาเลือก ประเภทการเบิก', 
            'toOrganization.required' => 'กรุณาเลือก Organization รับวัตถุดิบ', 
            'item_cat.required' => 'กรุณาเลือก ประเภทวัตถุดิบ',
            'subinventory_code.required' => 'กรุณาเลือก คลังจัดเก็บ',
            'inventory_location_id.required' => 'กรุณาเลือก สถานที่จัดเก็บ',
        ]);

        $profile = getDefaultData('/pm/settings/setup-transfer');
        $program_code = getDefaultData('/pm/settings/setup-transfer')->program_code;
        $userId = optional(auth()->user())->user_id ?? -1;

        if( $request['old_item_cat'] != $request['item_cat'] 
            || $request['toOrganization'] != $request['oldToOrganization'] 
            || $request['oldSubinventoryCode'] != $request['subinventory_code'] 
            || $request['oldInventoryLocationId'] != $request['inventory_location_id']
            || $request['oldRequestType'] != $request['request_type']  ){
            $checkDuplicateData = SetupTransferLocations::where('to_subinventory_code',  $request['subinventory_code'])
                                                        ->where('request_type', $request['request_type'])
                                                        ->where('to_locator_id',  $request['inventory_location_id'])
                                                        ->where('item_cat_code',  $request['item_cat'])
                                                        ->where('user_organization_id', $profile->organization_id)
                                                        ->first();
            if($checkDuplicateData){
                return  redirect()
                        ->back()
                        ->with('error','ไม่สามารถแก้ไขข้อมูลได้ เนื่องจากมีข้อมูลการบันทึกคลังเบิกวัตถุดิบซ้ำ');
            }
        }

        \DB::beginTransaction();
        try {
                $transfer                               = SetupTransferLocations::find($request['setup_trans_id']);
                $transfer->request_type                 = $request['request_type'];
                $transfer->item_cat_code                = $request['item_cat'];
                $transfer->to_organization_id           = $request['toOrganization'];
                $transfer->to_subinventory_code         = $request['subinventory_code'];
                $transfer->to_locator_id                = $request['inventory_location_id'];
                $transfer->enable_flag                  = $request['newEnableFlag'] == 'true' ? 'Y' : 'N';
                $transfer->program_code                 = $profile->program_code;
                $transfer->updated_at                   = now();
                $transfer->updated_by_id                = $profile->user_id;
                $transfer->last_updated_by              = $profile->user_id;
                $transfer->last_update_date             = now();
                $transfer->save();

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
        return  redirect()
                ->route('pm.settings.setup-transfer.index')
                ->with('success','ทำการเปลี่ยนแปลงข้อมูล การบันทึกคลังเบิกวัตถุดิบ');
    }
}
