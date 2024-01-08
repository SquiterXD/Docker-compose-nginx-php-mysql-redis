<?php

namespace App\Http\Controllers\PM\Settings\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

use App\Models\PM\Settings\ItemLocationsKfv;
use App\Models\PM\Settings\ItemNumberV;
use App\Models\PM\Settings\TobaccoCatByOrgV;
use App\Models\PM\Settings\SetupMinMaxByItem;
use App\Models\PM\Settings\SetupMfgDepartmentsV;
use App\Models\PM\Settings\Parameters;

use Arr;
use DB;

class SetupMinMaxByItemController extends Controller
{
    public function getOrganization(Request $request)
    {
        if($request['itemcat'] == null){
            $organizationList = 'noInput';
            return response()->json([  'organizationList' => $organizationList ]);                      
        } else {
            $profile = getDefaultData('/pm/settings/setup-min-max-by-item');
            $orgMG6 = Parameters::where('organization_code', 'MG6')->first();
            $orgM05 = Parameters::where('organization_code', 'M05')->first();
            $orgM12 = Parameters::where('organization_code', 'M12')->first();

            $organization = collect(\DB::select("   select  t1.from_organization_id             organization_id,
                                                            t1.from_organization_code           organization_code,
                                                            orgUnit.name                        organization_name
                                                    from    ptpm_setup_mfg_departments_v        t1,
                                                            hr_all_organization_units           orgUnit
                                                    where   t1.organization_id = '{$profile->organization_id}'
                                                    and     tobacco_group_code  = '{$request['itemcat']}'
                                                    and     wip_transaction_type_id = '35'
                                                    and     t1.from_organization_id = orgUnit.organization_id
                                                    union
                                                    select  t2.to_organization_id               organization_id,
                                                            t2.to_organization_code             organization_code,
                                                            orgUnit.name                        organization_name
                                                    from    ptpm_setup_mfg_departments_v        t2,
                                                            hr_all_organization_units           orgUnit
                                                    where   t2.organization_id = '{$profile->organization_id}'
                                                    and     tobacco_group_code  = '{$request['itemcat']}'
                                                    and     wip_transaction_type_id = '44'
                                                    and     t2.to_organization_id = orgUnit.organization_id  "))->first();    
            
            if($profile->organization_id == $orgMG6['organization_id'] || $profile->organization_id == $orgM05['organization_id']){
                $itemLocations =    collect(\DB::select(" select * from (
                                                                select  t1.from_organization_id             organization_id,
                                                                        t1.from_organization_code           organization_code,
                                                                        orgUnit.name                        organization_name,
                                                                        t1.from_locator_id                  locator_id,
                                                                        t1.from_locator_code                locator_code,
                                                                        t1.location_desc                    location_desc,
                                                                        t1.from_subinventory                subinventory
                                                                from    ptpm_setup_mfg_departments_v        t1,
                                                                        hr_all_organization_units           orgUnit,
                                                                        mtl_item_locations_kfv              kfv
                                                                where   t1.organization_id = '{$profile->organization_id}'
                                                                and     tobacco_group_code  = '{$request['itemcat']}'
                                                                and     wip_transaction_type_id = '2'
                                                                and     t1.from_organization_id = orgUnit.organization_id
                                                                union
                                                                select  t2.to_organization_id               organization_id,
                                                                        t2.to_organization_code             organization_code,
                                                                        orgUnit.name                        organization_name,
                                                                        t2.to_locator_id                    locator_id,
                                                                        t2.to_locator_code                  locator_code,
                                                                        t2.location_desc                    location_desc,
                                                                        t2.to_subinventory                  subinventory
                                                                from    ptpm_setup_mfg_departments_v        t2,
                                                                        hr_all_organization_units           orgUnit,
                                                                        mtl_item_locations_kfv              kfv
                                                                where   t2.organization_id = '{$profile->organization_id}'
                                                                and     tobacco_group_code  = '{$request['itemcat']}'
                                                                and     wip_transaction_type_id = '44'
                                                                and     t2.to_organization_id = orgUnit.organization_id ) a where a.organization_id = '{$organization->organization_id}' "))
                                    ->first();

                $itemNumberList = ItemNumberV::where('item_cat_code', $request['itemcat'])
                                            ->where('organization_id', $organization->organization_id)
                                            ->where('enabled_flag', 'Y')
                                            ->orderBy('item_number', 'asc')
                                            ->get();
                return response()->json([
                    'itemLocation'      => $itemLocations,
                    'organization'      => $organization,
                    'itemNumberList'    => $itemNumberList
                ]);

            }else{
                $itemLocations =    collect(\DB::select(" select * from (
                                                                select  t1.from_organization_id             organization_id,
                                                                        t1.from_organization_code           organization_code,
                                                                        orgUnit.name                        organization_name,
                                                                        t1.from_locator_id                  locator_id,
                                                                        t1.from_locator_code                locator_code,
                                                                        t1.location_desc                    location_desc,
                                                                        t1.from_subinventory                subinventory
                                                                from    ptpm_setup_mfg_departments_v        t1,
                                                                        hr_all_organization_units           orgUnit,
                                                                        mtl_item_locations_kfv              kfv
                                                                where   t1.organization_id = '{$profile->organization_id}'
                                                                and     tobacco_group_code  = '{$request['itemcat']}'
                                                                and     wip_transaction_type_id = '35'
                                                                and     t1.from_organization_id = orgUnit.organization_id
                                                                union
                                                                select  t2.to_organization_id               organization_id,
                                                                        t2.to_organization_code             organization_code,
                                                                        orgUnit.name                        organization_name,
                                                                        t2.to_locator_id                    locator_id,
                                                                        t2.to_locator_code                  locator_code,
                                                                        t2.location_desc                    location_desc,
                                                                        t2.to_subinventory                  subinventory
                                                                from    ptpm_setup_mfg_departments_v        t2,
                                                                        hr_all_organization_units           orgUnit,
                                                                        mtl_item_locations_kfv              kfv
                                                                where   t2.organization_id = '{$profile->organization_id}'
                                                                and     tobacco_group_code  = '{$request['itemcat']}'
                                                                and     wip_transaction_type_id = '44'
                                                                and     t2.to_organization_id = orgUnit.organization_id ) a where a.organization_id = '{$organization->organization_id}' "))
                                    ->first();
                
                if($profile->organization_id == $orgM12['organization_id']){
                    $checkSegment = ItemLocationsKfv::where('inventory_location_id', $itemLocations->locator_id)
                                                    ->value('segment2');
                }else{
                    $checkSegment = null;
                }

                if ($checkSegment == 'ZONE01') {
                    $itemNumberList = ItemNumberV::where('item_cat_code', $request['itemcat'])
                                                ->where('organization_id', $organization->organization_id)
                                                ->where('item_type', 'RM')
                                                ->where('enabled_flag', 'Y')
                                                ->orderBy('item_number', 'asc')
                                                ->get();
                    return response()->json([
                        'itemLocation'      => $itemLocations,
                        'organization'      => $organization,
                        'itemNumberList'    => $itemNumberList
                    ]);
                }

                if ($checkSegment == 'ZONE02') {
                    $itemNumberList = ItemNumberV::where('item_cat_code', $request['itemcat'])
                                                ->where('organization_id', $organization->organization_id)
                                                ->where('item_type', 'SFG')
                                                ->where('enabled_flag', 'Y')
                                                ->orderBy('item_number', 'asc')
                                                ->get();
                    return response()->json([
                        'itemLocation'      => $itemLocations,
                        'organization'      => $organization,
                        'itemNumberList'    => $itemNumberList
                    ]);
                }
                
                $itemNumberList = ItemNumberV::where('item_cat_code', $request['itemcat'])
                                            ->where('organization_id', $organization->organization_id)
                                            ->where('enabled_flag', 'Y')
                                            ->orderBy('item_number', 'asc')
                                            ->get();

                return response()->json([
                    'itemLocation'      => $itemLocations,
                    'organization'      => $organization,
                    'itemNumberList'    => $itemNumberList
                ]);
            } 
        }
    }

    public function getUom(Request $request)
    {
        $profile = getDefaultData('/pm/settings/setup-min-max-by-item');
        $organization = $request->organization ? $request->organization : $profile->organization_id;
        $inventoryItemId = $request->inventoryItemId ? $request->inventoryItemId : '';
        $uom = ItemNumberV::where('inventory_item_id', $inventoryItemId)
                        ->where('enabled_flag', 'Y')
                        ->where('organization_id', $organization)
                        ->get();       
        return response()->json(['data' => [
                'dataUom'   => $uom
            ]
        ]);
    }

    public function destroy(Request $request)
    {
        $setupLayout = SetupMinMaxByItem::find($request['setupMinMaxId']);
        $setupLayout -> delete();
    }

    public function search(Request $request)
    {
        if($request->status === 'init_table') {
            $profile = getDefaultData('/pm/settings/setup-min-max-by-item');
          
            $listSetupMinMax = \DB::select("
                    select  mil.concatenated_segments               locator_code, 
                            psmmbi.*, 
                            pin.*,
                            pin.item_number,                        pin.item_desc 
                    from    PTPM_SETUP_MIN_MAX_BY_ITEM              psmmbi,
                            ptpm_item_number_v                      pin,
                            mtl_item_locations_kfv                  mil  
                    where   psmmbi.organization_id      = pin.organization_id
                    and     psmmbi.inventory_item_id    = pin.inventory_item_id
                    and     psmmbi.locator_id           = mil.inventory_location_id (+)
                    and     psmmbi.user_organization_id         = nvl('{$profile->organization_id}',psmmbi.user_organization_id)                         ");
        $listItemNumber = ItemNumberV::query()
                    ->where('organization_id', $profile->organization_id)
                    ->where('enabled_flag', 'Y')
                    ->orderBy('item_number', 'asc')
                    ->get();
        } else {
        $listSetupMinMax = \DB::select("
                                select  mil.concatenated_segments               locator_code, 
                                        psmmbi.*, 
                                        pin.*,
                                        pin.item_number,                        pin.item_desc 
                                from    PTPM_SETUP_MIN_MAX_BY_ITEM              psmmbi,
                                        ptpm_item_number_v                      pin,
                                        mtl_item_locations_kfv                  mil  
                                where   psmmbi.organization_id      = pin.organization_id
                                and     psmmbi.inventory_item_id    = pin.inventory_item_id
                                and     psmmbi.locator_id           = mil.inventory_location_id (+)
                                and     pin.organization_id         = nvl('{$request->organization}',pin.organization_id) 
                                and     psmmbi.locator_id           = nvl('{$request->location}' ,psmmbi.locator_id) 
                                and     pin.inventory_item_id       = nvl('{$request->itemNumber}' ,pin.inventory_item_id) 
                                and     pin.item_cat_code           = nvl('{$request->itemcat}' ,pin.item_cat_code)                        ");

        $listItemNumber = ItemNumberV::query()
                        ->where('organization_id', $request->organization)
                        ->where('item_cat_code', $request->itemcat)
                        ->where('enabled_flag', 'Y')
                        ->orderBy('item_number', 'asc')
                        ->get();
        }
        data_set($listSetupMinMax, '*.is_select', '');
        data_set($listSetupMinMax, '*.remarkImpossibleSmallValue', false);
        data_set($listSetupMinMax, '*.remarkImpossibleHighValue', false);
        
        if($listSetupMinMax == []){
            $listSetupMinMax = 'NoSearchData';
            return response()->json(['data' => [
                'listSetupMinMax'   => $listSetupMinMax,
                'listSearchItemNumber'    => $listItemNumber
            ]
            ]);
        }

        return response()->json(['data' => [
                'listSetupMinMax'   => $listSetupMinMax,
                'listSearchItemNumber'    => $listItemNumber
            ]
        ]);

    }

}