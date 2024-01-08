<?php

namespace App\Http\Controllers\PM\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Arr;

use App\Models\PM\Settings\OrganizationsInfo;
use App\Models\PM\Settings\SetupMinMaxByItem;
use App\Models\PM\Settings\ItemLocationsKfv;
use App\Models\PM\Settings\ItemNumberV;
use App\Models\PM\Settings\SetupMfgDepartmentsV;
use App\Models\PM\Settings\Parameters;

class SetupMinMaxByItemController extends Controller
{
    public function index(Request $request)
    { 
        $btnTrans = trans('btn');  
        $searchOld = $request->all() ? $request->search : '';
        $profile = getDefaultData('/pm/settings/setup-min-max-by-item');
        $orgMG6 = Parameters::where('organization_code', 'MG6')->first();
        $orgM05 = Parameters::where('organization_code', 'M05')->first();

        $tobaccoItemcatList = \DB::select("     select distinct
                                                                        t1.tobacco_group_code           tobacco_group_code,
                                                                        t1.tobacco_group                tobacco_group
                                                from    ptpm_setup_mfg_departments_v                        t1
                                                where   from_organization_id  = '{$profile->organization_id}'
                                                and     wip_transaction_type_id in ('35','44')
                                                union 
                                                select distinct
                                                                            t2.tobacco_group_code           tobacco_group_code,
                                                                            t2.tobacco_group                tobacco_group
                                                from    ptpm_setup_mfg_departments_v                        t2
                                                where   to_organization_id = '{$profile->organization_id}'
                                                and     wip_transaction_type_id in ('35','44')  
                                                                                                                                   ");
                                               
        return  view('pm.settings.setup-min-max-by-item.index', 
                compact('tobaccoItemcatList', 'searchOld', 'btnTrans'));
    }

    public function updateOrCreate(Request $request)
    {
        $search = $request->search;
        $profile = getDefaultData('/pm/settings/setup-min-max-by-item');
        $userOrganizationId = $profile->organization_id;
        $this->validate($request,[
            'organization' => 'required',
            'location' => 'required',
            'itemcat' => 'required',
        ],[
            'organization.required' => 'กรุณาเลือก Organization', 
            'location.required' => 'กรุณาเลือก คลังจัดเก็บ/สถานที่จัดเก็บ', 
            'itemcat.required' => 'กรุณาเลือก ประเภทวัตถุดิบ', 
        ]);
        
        $organization = Arr::get($request, 'organization');
        $location = Arr::get($request, 'location');
        try {
            \DB::beginTransaction();
                if($request->newDataGroup != null){
                    foreach ($request->newDataGroup as $key => $line) {
                        $itemNumber = Arr::get($line, 'item_number');
                        $min = Arr::get($line, 'min_qty');
                        $max = Arr::get($line, 'max_qty');
                        $remark = Arr::get($line, 'remark_msg');
                        $subinventory = ItemLocationsKfv::where('organization_id', $organization)
                                                        ->where('inventory_location_id', $location)
                                                        ->value('subinventory_code');
                        $item = ItemNumberV::where('organization_id', $organization)
                                            ->where('item_number', $itemNumber)
                                            ->value('inventory_item_id');
                        $isDuplicate = SetupMinMaxByItem::where('organization_id', $organization)
                                                        ->where('subinventory_code', $subinventory)
                                                        ->where('locator_id', $location)
                                                        ->where('inventory_item_id', $item)
                                                        ->first();             
                        if($isDuplicate){
                            return redirect()->route('pm.settings.setup-min-max-by-item.index')
                                             ->withErrors(['เกิดข้อผิดพลาด เนื่องจากมีข้อมูลกำหนดค่าเฝ้าระวังซ้ำ']);
                        }  
    
                        $setupMinMaxByItem                       = new SetupMinMaxByItem();
                        $setupMinMaxByItem->organization_id      = $organization;
                        $setupMinMaxByItem->subinventory_code    = $subinventory;
                        $setupMinMaxByItem->locator_id           = $location;
                        $setupMinMaxByItem->inventory_item_id    = $item;
                        $setupMinMaxByItem->min_qty              = $line['min_qty'];
                        $setupMinMaxByItem->max_qty              = $line['max_qty'];
                        $setupMinMaxByItem->remark_msg           = $line['remark_msg'];
                        $setupMinMaxByItem->program_code         = $profile->program_code;
                        $setupMinMaxByItem->created_by           = $profile->user_id;
                        $setupMinMaxByItem->creation_date        = now();
                        $setupMinMaxByItem->last_updated_by      = $profile->user_id;
                        $setupMinMaxByItem->last_update_date     = now();
                        $setupMinMaxByItem->user_organization_id = $userOrganizationId;
    
                        $setupMinMaxByItem->save();
                    }
                }

                if($request->updateDataGroup != null){
                    foreach($request->updateDataGroup as $key => $line){
                        $id = Arr::get($line, 'setup_min_max_id');
                        $min = Arr::get($line, 'min_qty');
                        $max = Arr::get($line, 'max_qty');
                        $remark = Arr::get($line, 'remark_msg');

                        $setup                              = SetupMinMaxByItem::find($id);
                        $setup->min_qty                     = $min;
                        $setup->max_qty                     = $max;
                        $setup->remark_msg                  = $remark;
                        $setup->program_code                = $profile->program_code;
                        $setup->updated_at                  = now();
                        $setup->last_updated_by             = $profile->user_id;
                        $setup->last_update_date            = now();
                        
                        $setup->save();
                    }
                } 
            \DB::commit();

            return redirect()->route('pm.settings.setup-min-max-by-item.index', compact('search'))
                             ->with('success','ทำการอัพเดทข้อมูลใหม่เรียบร้อยแล้ว');
        } catch (Exception $e) {
            \DB::rollback();
            return redirect()->back()->withError($e->getMessage());
        }                    
    }
}
