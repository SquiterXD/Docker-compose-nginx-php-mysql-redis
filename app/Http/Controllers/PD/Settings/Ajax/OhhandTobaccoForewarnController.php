<?php

namespace App\Http\Controllers\PD\Settings\Ajax;

use App\Models\Example\User;
use App\Models\PD\Settings\TobaccoItemcatSeg2V;
use App\Models\PD\Settings\TobaccoForewarnV;
use App\Models\PD\Settings\OhhandTobaccoForewarn;
use App\Models\PD\Settings\TobaccoCatByOrgV;
use App\Models\PD\Settings\OrganizationsInfo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OhhandTobaccoForewarnController extends Controller
{
    public function getTobaccoItemcatSeg2(Request $request)
    {
        $orgA00 = OrganizationsInfo::where('organization_code', 'A00')->value('organization_id');
        $orgA04 = OrganizationsInfo::where('organization_code', 'A04')->value('organization_id');
        $first = TobaccoCatByOrgV::selectRaw('distinct flex_value_meaning2, description2')
                                ->where('organization_id', $orgA04)
                                ->where('segment1', $request->itemCatSeg1)
                                ->whereRaw("segment2 like'0%00'");

        $itemCatSeg2List = TobaccoCatByOrgV::selectRaw('distinct flex_value_meaning2, description2')
                                            ->union($first)
                                            ->where('organization_id', $orgA00)
                                            ->where('segment1', $request->itemCatSeg1)
                                            ->whereRaw("segment2 like'0%00'")
                                            ->orderBy('flex_value_meaning2')
                                            ->get();

        return response()->json(['itemCatSeg2List' => $itemCatSeg2List]);
    }

    public function getItemNumber(Request $request)
    {
        // $itemNumberList = TobaccoForewarnV::selectRaw('distinct organization_code, organization_id, 
        //                                                         inventory_item_id, item_number, item_desc, 
        //                                                         tobacco_group_code, tobacco_type, tobacco_type_code')
        //                                 ->where('tobacco_group_code', $request->itemCatSeg1)
        //                                 ->where('tobacco_type_code', $request->itemCatSeg2)
        //                                 ->orderBy('item_number')
        //                                 ->limit(150)
        //                                 ->get();

        $itemNumberList = collect(\DB::select("
                                                    SELECT DISTINCT    ptf.organization_code
                                                                    ,  ptf.organization_id
                                                                    ,  ptf.inventory_item_id
                                                                    ,  ptf.item_number
                                                                    ,  ptf.item_desc
                                                                    ,  ptf.tobacco_group_code
                                                                    ,  ptf.tobacco_type
                                                                    ,  ptf.tobacco_type_code
                                                    FROM    ptpd_tobacco_forewarn_v     ptf,
                                                            mtl_system_items_b          msi
                                                    WHERE   ptf.organization_id     =   msi.organization_id
                                                    AND     ptf.inventory_item_id   =   msi.inventory_item_id
                                                    AND     tobacco_group_code      =   '{$request->itemCatSeg1}'
                                                    AND     tobacco_type_code       =   '{$request->itemCatSeg2}'
                                                    AND     msi.attribute_category  =   'LEAF_DRYING'
                                                    AND     msi.attribute13 IS NULL
                                                    ORDER BY item_number
                                            "));

        // $itemNumbersUpdateList = TobaccoForewarnV::selectRaw('distinct  organization_code, organization_id, 
        //                                                                 inventory_item_id, item_number, item_desc, 
        //                                                                 tobacco_group_code, tobacco_type, tobacco_type_code')
        //                                         ->where('tobacco_group_code', $request->itemCatSeg1)
        //                                         ->where('tobacco_type_code', $request->itemCatSeg2)
        //                                         ->whereNotExists(function($query){
        //                                             $query->select(\DB::raw(1))
        //                                                     ->from('ptpd_ohhand_tobacco_forewarn')
        //                                                     ->whereColumn([
        //                                                         ['ptpd_tobacco_forewarn_v.inventory_item_id', '=', 'ptpd_ohhand_tobacco_forewarn.inventory_item_id'],
        //                                                     ]);
        //                                         })
        //                                         ->orderBy('item_number')
        //                                         ->limit(150)
        //                                         ->get();
                                
        // $itemNumberShowAllList = TobaccoForewarnV::selectRaw('distinct  organization_code, organization_id, 
        //                                                                 inventory_item_id, item_number, item_desc, 
        //                                                                 tobacco_group_code, tobacco_type, tobacco_type_code')
        //                                         ->where('tobacco_group_code', $request->itemCatSeg1)
        //                                         ->where('tobacco_type_code', $request->itemCatSeg2)
        //                                         ->orderBy('item_number')
        //                                         ->get();
                                                                        
        // return response()->json([   'itemNumberList' => $itemNumberList,
        //                             'itemNumbersUpdateList' => $itemNumbersUpdateList,
        //                             'itemNumberShowAllList' => $itemNumberShowAllList]);
        return response()->json([   'itemNumberList' => $itemNumberList ]);
    }

    public function search(Request $request)
    {
        $tobaccoForewarnList = OhhandTobaccoForewarn::selectRaw('distinct ptpd_tobacco_forewarn_v.item_desc, ptpd_tobacco_forewarn_v.item_number, ptpd_ohhand_tobacco_forewarn.*')
                                                    ->join('ptpd_tobacco_forewarn_v', 'ptpd_tobacco_forewarn_v.inventory_item_id', '=', 'ptpd_ohhand_tobacco_forewarn.inventory_item_id')
                                                    ->whereRaw('ptpd_ohhand_tobacco_forewarn.category_tobacco = ?',[$request->itemCatSeg1])
                                                    ->whereRaw('ptpd_ohhand_tobacco_forewarn.type_tobacco = ?', [$request->itemCatSeg2])
                                                    ->whereRaw('ptpd_ohhand_tobacco_forewarn.inventory_item_id = nvl(?, ptpd_ohhand_tobacco_forewarn.inventory_item_id)', [$request->itemNumber])
                                                    ->paginate(20);

        $itemNumbersParent = TobaccoForewarnV::selectRaw('distinct item_desc, item_number')
                                                ->where('inventory_item_id', $request->itemNumber)
                                                ->value('item_number');
                                                
        $itemNumbersUpdateList = collect(\DB::select("
                                                        SELECT DISTINCT ptpd_tobacco_forewarn_v.organization_code
                                                                ,  ptpd_tobacco_forewarn_v.organization_id
                                                                ,  ptpd_tobacco_forewarn_v.inventory_item_id
                                                                ,  ptpd_tobacco_forewarn_v.item_number
                                                                ,  ptpd_tobacco_forewarn_v.item_desc
                                                                ,  ptpd_tobacco_forewarn_v.tobacco_group_code
                                                                ,  ptpd_tobacco_forewarn_v.tobacco_type
                                                                ,  ptpd_tobacco_forewarn_v.tobacco_type_code
                                                        FROM        ptpd_tobacco_forewarn_v
                                                        INNER JOIN  mtl_system_items_b ON ptpd_tobacco_forewarn_v.organization_id = mtl_system_items_b.organization_id
                                                        AND         ptpd_tobacco_forewarn_v.inventory_item_id = mtl_system_items_b.inventory_item_id
                                                        WHERE       1=1
                                                        AND         mtl_system_items_b.attribute_category = 'LEAF_DRYING'
                                                        AND         mtl_system_items_b.attribute13 IS NOT NULL
                                                        AND         ptpd_tobacco_forewarn_v.item_number LIKE '{$itemNumbersParent}%'
                                                        AND  NOT EXISTS (   SELECT *
                                                                            FROM   ptpd_ohhand_tobacco_forewarn
                                                                            WHERE  ptpd_tobacco_forewarn_v.inventory_item_id = ptpd_ohhand_tobacco_forewarn.inventory_item_id   ) 
                                                        ORDER BY    item_number
                                                    "));

        $itemNumberShowAllList = collect(\DB::select("
                                                            SELECT DISTINCT ptpd_tobacco_forewarn_v.organization_code
                                                                    ,  ptpd_tobacco_forewarn_v.organization_id
                                                                    ,  ptpd_tobacco_forewarn_v.inventory_item_id
                                                                    ,  ptpd_tobacco_forewarn_v.item_number
                                                                    ,  ptpd_tobacco_forewarn_v.item_desc
                                                                    ,  ptpd_tobacco_forewarn_v.tobacco_group_code
                                                                    ,  ptpd_tobacco_forewarn_v.tobacco_type
                                                                    ,  ptpd_tobacco_forewarn_v.tobacco_type_code
                                                            FROM        ptpd_tobacco_forewarn_v
                                                            INNER JOIN  mtl_system_items_b ON ptpd_tobacco_forewarn_v.organization_id = mtl_system_items_b.organization_id
                                                            AND         ptpd_tobacco_forewarn_v.inventory_item_id = mtl_system_items_b.inventory_item_id
                                                            WHERE       1=1
                                                            AND         mtl_system_items_b.attribute_category = 'LEAF_DRYING'
                                                            AND         mtl_system_items_b.attribute13 IS NOT NULL
                                                            AND         ptpd_tobacco_forewarn_v.item_number LIKE '{$itemNumbersParent}%'                                                        
                                                            ORDER BY    item_number
                                                "));

        return response()->json(['tobaccoForewarnList' => $tobaccoForewarnList,
                                 'itemNumbersUpdateList' => $itemNumbersUpdateList,
                                 'itemNumberShowAllList' => $itemNumberShowAllList]);
    }

    public function getSearchItemNumber(Request $request)
    {
        $querySearch = $request ['query'];
        $itemCatSeg1 = $request ['itemCatSeg1'];
        $itemCatSeg2 = $request ['itemCatSeg2'];
        $inventoryItemId = $request ['inventoryItemId'];
        $updateList = isset($request ['UpdateList']) ? $request ['UpdateList'] : '';
        if($updateList == 'UpdateList'){         
            $itemNumbersParent = TobaccoForewarnV::selectRaw('distinct item_desc, item_number')
                                                ->where('inventory_item_id', $inventoryItemId)
                                                ->value('item_number');

            $itemNumberList = collect(\DB::select("
                                                    SELECT * FROM (
                                                        SELECT DISTINCT ptpd_tobacco_forewarn_v.organization_code
                                                                    ,  ptpd_tobacco_forewarn_v.organization_id
                                                                    ,  ptpd_tobacco_forewarn_v.inventory_item_id
                                                                    ,  ptpd_tobacco_forewarn_v.item_number
                                                                    ,  ptpd_tobacco_forewarn_v.item_desc
                                                                    ,  ptpd_tobacco_forewarn_v.tobacco_group_code
                                                                    ,  ptpd_tobacco_forewarn_v.tobacco_type
                                                                    ,  ptpd_tobacco_forewarn_v.tobacco_type_code
                                                        FROM        ptpd_tobacco_forewarn_v
                                                        INNER JOIN  mtl_system_items_b ON ptpd_tobacco_forewarn_v.organization_id =  mtl_system_items_b.organization_id
                                                        AND         ptpd_tobacco_forewarn_v.inventory_item_id =  mtl_system_items_b.inventory_item_id
                                                        WHERE       1=1
                                                        AND         mtl_system_items_b.attribute_category           =       'LEAF_DRYING'
                                                        AND         ptpd_tobacco_forewarn_v.tobacco_group_code      =       '{$request->itemCatSeg1}'
                                                        AND         ptpd_tobacco_forewarn_v.tobacco_type_code       =       '{$request->itemCatSeg2}'
                                                        AND         ptpd_tobacco_forewarn_v.item_number             LIKE    '{$itemNumbersParent}%'
                                                        AND         mtl_system_items_b.attribute13 IS NOT  NULL
                                                        AND         NOT EXISTS (    SELECT *
                                                                                    FROM   ptpd_ohhand_tobacco_forewarn
                                                                                    WHERE  ptpd_tobacco_forewarn_v.inventory_item_id = ptpd_ohhand_tobacco_forewarn.inventory_item_id   ) 
                                                        ORDER BY    item_number                   
                                                    )                                                           
                                                        WHERE item_number || item_desc LIKE '%{$querySearch}%'                                                                                             
                                                "));
        }else{
            $itemNumberList = collect(\DB::select("
                                                    SELECT * FROM (
                                                        SELECT DISTINCT ptpd_tobacco_forewarn_v.organization_code
                                                                    ,  ptpd_tobacco_forewarn_v.organization_id
                                                                    ,  ptpd_tobacco_forewarn_v.inventory_item_id
                                                                    ,  ptpd_tobacco_forewarn_v.item_number
                                                                    ,  ptpd_tobacco_forewarn_v.item_desc
                                                                    ,  ptpd_tobacco_forewarn_v.tobacco_group_code
                                                                    ,  ptpd_tobacco_forewarn_v.tobacco_type
                                                                    ,  ptpd_tobacco_forewarn_v.tobacco_type_code
                                                        FROM        ptpd_tobacco_forewarn_v
                                                        INNER JOIN  mtl_system_items_b ON ptpd_tobacco_forewarn_v.organization_id =  mtl_system_items_b.organization_id
                                                        AND         ptpd_tobacco_forewarn_v.inventory_item_id =  mtl_system_items_b.inventory_item_id
                                                        WHERE       1=1
                                                        AND         mtl_system_items_b.attribute_category           =       'LEAF_DRYING'
                                                        AND         ptpd_tobacco_forewarn_v.tobacco_group_code      =       '{$request->itemCatSeg1}'
                                                        AND         ptpd_tobacco_forewarn_v.tobacco_type_code       =       '{$request->itemCatSeg2}'
                                                        AND         ptpd_tobacco_forewarn_v.item_number             LIKE    '{$itemNumbersParent}%'
                                                        AND         mtl_system_items_b.attribute13 IS NOT  NULL
                                                        AND         NOT EXISTS (    SELECT *
                                                                                    FROM   ptpd_ohhand_tobacco_forewarn
                                                                                    WHERE  ptpd_tobacco_forewarn_v.inventory_item_id = ptpd_ohhand_tobacco_forewarn.inventory_item_id   ) 
                                                        ORDER BY    item_number                   
                                                    )                                                           
                                                        WHERE item_number || item_desc LIKE '%{$querySearch}%'              
                                                "));
        }
          
        return response()->json(['itemNumberList' => $itemNumberList]);
    }

    public function updateOrCreate(Request $request)
    {
        $profile = getDefaultData('/pd/settings/ohhand-tobacco-forewarn');
        if($request->params){
            foreach ($request->params as $key => $value) {
                    $tobacco_group_code = TobaccoForewarnV::where('inventory_item_id', $value['inventoryItemId'])->value('tobacco_group_code');
                    $tobacco_type_code = TobaccoForewarnV::where('inventory_item_id', $value['inventoryItemId'])->value('tobacco_type_code');
                    $OhhandTobaccoForewarn                          = new OhhandTobaccoForewarn();
                    $OhhandTobaccoForewarn->category_tobacco        = $tobacco_group_code;
                    $OhhandTobaccoForewarn->type_tobacco            = $tobacco_type_code;
                    $OhhandTobaccoForewarn->inventory_item_id       = $value['inventoryItemId'];
                    $OhhandTobaccoForewarn->warning_num             = $value['warningNum'];
                    $OhhandTobaccoForewarn->created_by              = $profile->user_id;
                    $OhhandTobaccoForewarn->creation_date           = now();
                    $OhhandTobaccoForewarn->last_updated_by         = $profile->user_id;
                    $OhhandTobaccoForewarn->last_update_date        = now();
                    
                    $OhhandTobaccoForewarn->save();
            }
        }

        if($request->params1['data']){
            foreach ($request->params1['data'] as $key => $value) {
                $OhhandTobaccoForewarn                          = OhhandTobaccoForewarn::find($value['forewarn_id']);
                $OhhandTobaccoForewarn->category_tobacco        = $value['category_tobacco'];
                $OhhandTobaccoForewarn->type_tobacco            = $value['type_tobacco'];
                $OhhandTobaccoForewarn->inventory_item_id       = $value['inventory_item_id'];
                $OhhandTobaccoForewarn->warning_num             = $value['warning_num'];
                $OhhandTobaccoForewarn->created_by              = $profile->user_id;
                $OhhandTobaccoForewarn->creation_date           = now();
                $OhhandTobaccoForewarn->last_updated_by         = $profile->user_id;
                $OhhandTobaccoForewarn->last_update_date        = now();
                
                $OhhandTobaccoForewarn->save();
            }    
        }

        $data = 'succeed';
        return response()->json(['data' => $data]);
    }
}
