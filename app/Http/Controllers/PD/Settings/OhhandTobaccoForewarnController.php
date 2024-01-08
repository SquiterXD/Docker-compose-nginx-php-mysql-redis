<?php

namespace App\Http\Controllers\PD\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Example\User;
use App\Models\PD\Settings\OrganizationsInfo;
use App\Models\PD\Settings\TobaccoCatByOrgV;

class OhhandTobaccoForewarnController extends Controller
{
    public function index()
    {
        $org = OrganizationsInfo::where('organization_code', 'A00')->first();
        $organizations = OrganizationsInfo::orderBy('organization_code')
                                            ->where('organization_code', 'A00')
                                            ->get();
        $domesticLookUpCode = '1001';
        $exportLookUpCode = '1002';
        $tobaccoCatByOrgVTable = (new TobaccoCatByOrgV)->getTable();
        $itemCatSeg1List = collect(\DB::select("
                                                    select  distinct flex_value_meaning1, description1
                                                    from    {$tobaccoCatByOrgVTable}                        
                                                    where   organization_id  = '{$org['organization_id']}'
                                                    and     flex_value_meaning1 = {$domesticLookUpCode}
                                                    union 
                                                    select  distinct flex_value_meaning1, description1
                                                    from    {$tobaccoCatByOrgVTable}                         
                                                    where   organization_id  = '{$org['organization_id']}'
                                                    and     flex_value_meaning1 = {$exportLookUpCode}   
                                                "));
        return view('pd.settings.ohhand-tobacco-forewarn.index', compact('organizations', 'org', 'itemCatSeg1List'));
    }

    // public function store(Request $request)
    // {
    //     $userId = optional(auth()->user())->user_id ?? -1;
    //     $valueSets = TobaccoForewarnV::where('tobacco_group_code', $request->itemCatSeg1)
    //                                 ->where('tobacco_type_code', $request->itemCatSeg2)
    //                                 ->get();
    //     // foreach ($valueSets as $valueSet){
    //         // $setDefaultData = OhhandTobaccoForewarn::updateOrCreate([
    //         //     'inventory_item_id' => $valueSet->inventory_item_id,
    //         //     'category_tobacco' => $valueSet->tobacco_group_code,
    //         //     'type_tobacco' => $valueSet->tobacco_type_code,
    //         // ],
    //         // [
    //         //     'category_tobacco' => $valueSet->tobacco_group_code,
    //         //     'type_tobacco' => $valueSet->tobacco_type_code,
    //         //     'inventory_item_id' => $valueSet->inventory_item_id,
    //         //     'warning_num' => $request->setDefault,
    //         //     'created_by' => $userId,
    //         //     'last_updated_by' => $userId,
                
    //         // ]);        
    //     // }           
    //     return redirect()->route('pd.settings.ohhand-tobacco-forewarn.index')->with('success','ทำการบันทึกข้อมูลเรียบร้อยแล้ว');
    // }

    // public function update(Request $request, $forewarnId, $inventoryItemId)
    // {
    //     // dd($request->all(), $forewarnId, $inventoryItemId);
    //     $userId = optional(auth()->user())->user_id ?? -1;
    //     $data['last_updated_by']                    = $userId;
    //     $data['inventory_item_id']                  = $inventoryItemId;
    //     $data['warning_num']                        = $request->warning_num == null ? 0 : $request->warning_num;
    //     try {
    //         \DB::beginTransaction();
    //             (new OhhandTobaccoForewarn)->updateOhhandTobaccoForewarn($data);    
    //         \DB::commit();
    //         return redirect()->route('pd.settings.ohhand-tobacco-forewarn.index')->with('success','ทำการเปลี่ยนแปลงข้อมูลเรียบร้อยแล้ว');
    //     } catch (Exception $e) {
    //         \DB::rollback();
    //         return redirect()->back()->withError($e->getMessage());
    //     }
        
    // }
}
