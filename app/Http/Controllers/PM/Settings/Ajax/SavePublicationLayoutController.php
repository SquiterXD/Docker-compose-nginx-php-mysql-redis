<?php

namespace App\Http\Controllers\PM\Settings\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PM\Settings\SetupLayoutsV;
use App\Models\PM\Settings\SetupLayouts;
use App\Models\PM\Settings\ItemNumberV;
use App\Models\PM\Settings\Parameters;
use Carbon\Carbon;

class SavePublicationLayoutController extends Controller
{
    public function getTableResults(Request $request)
    {
        $organizationIdLogin = getDefaultData('/pm/settings/save-publication-layout')->organization_id;
        $dataItemNumber = ItemNumberV::where('item_number', $request->itemNumber)
                                    ->where('organization_id', $organizationIdLogin)
                                    ->first();
        $primaryUomCode = $dataItemNumber['primary_uom_code'];
        $primaryUnitOfMeasure = $dataItemNumber['primary_unit_of_measure'];
        $dataSetupLayoutList = SetupLayoutsV::selectRaw("
                                    layout_id
                                    , layout_id as id
                                    , start_date as def_start_date
                                    , start_date as start_date
                                    , end_date as end_date
                                    , layout_qty
                                    , primary_uom_code as unit
                                    , primary_unit_of_measure
                                    , custom_uom_code as custom_uom_code
                                    , custom_uom_name as custom_uom_name
                                ")
                                ->where('tobacco_group_code', $dataItemNumber['tobacco_group_code'])
                                ->where('tobacco_type_code', $dataItemNumber['tobacco_type_code'])
                                ->where('inventory_item_id', $dataItemNumber['inventory_item_id'])
                                ->where('item_number', $dataItemNumber['item_number'])
                                ->orderBy('start_date', 'asc')
                                ->paginate(10);



        $dataSetupLayoutList->map(function($item, $key) use($organizationIdLogin){
            $newItem = (object) $item;
            $newItem->def_start_date    = $item->start_date ? \Carbon\Carbon::parse($item->start_date)->format('Y-m-d') :  null;
            $newItem->start_date        = $item->start_date ? \Carbon\Carbon::parse($item->start_date)->format('Y-m-d') :  null;
            $newItem->end_date          = $item->end_date ? \Carbon\Carbon::parse($item->end_date)->format('Y-m-d') : null;
            $newItem->numberLayout      = $newItem->layout_qty * 1;
            $newItem->unitMeasure       = $newItem->primary_unit_of_measure;
            $newItem->validateRemark    = false;
            $newItem->is_new_row        = false;
            $newItem->is_del_row        = false;
            $newItem->start_date_valid  = true;
            $newItem->end_date_valid    = true;




            // $newItem->parseToDateThStartDate    = parseToDateTh($item->start_date ? $item->start_date : '');
            // $newItem->parseToDateThEndDate      = parseToDateTh($item->end_date ? $item->end_date : '');
            $newItem->parseToDatePKGStartDate   = $item->start_date ? Carbon::parse($item->start_date)->format("Y-m-d") : '';
            $newItem->parseToDatePKGEndDate     = $item->end_date ? Carbon::parse($item->end_date)->format("Y-m-d") : '';
            $newItem->statusBtn                 = \DB::select("    select  'Y'
                                                    from    mtl_material_transactions mmt
                                                    where   mmt.organization_id = '{$organizationIdLogin}'
                                                    and     mmt.inventory_item_id = '{$item['inventory_item_id']}'
                                                    and     mmt.transaction_date
                                                    between to_date('{$item->parseToDatePKGStartDate}', 'YYYY-MM-DD')
                                                    and     to_date('{$item->parseToDatePKGEndDate}', 'YYYY-MM-DD') ");
            return (object) $newItem;
        });

        $customUomList = $this->getCustomUomList();
        return response()->json([   'setupLayout' => $dataSetupLayoutList,
                                    'primaryUomCode' => $primaryUomCode,
                                    'primaryUnitOfMeasure' => $primaryUnitOfMeasure,
                                    'itemNumber' => $request->itemNumber,
                                    'customUomList' => $customUomList,
                                ]);
    }

    public function store(Request $request)
    {
        $profile = getDefaultData('/pm/settings/save-publication-layout');
        $requestItemNumber = $request->params1;
        $dataItemNumber = ItemNumberV::where('item_number', $requestItemNumber)
                                ->where('organization_id', $profile->organization_id)
                                ->first();
        \DB::beginTransaction();
        try {
                foreach($request->params as $index => $data){
                    if (!($data['is_new_row'] && $data['is_del_row'])) {
                        if ($data['is_new_row']) {
                            $setupLayout                        = new SetupLayouts();
                        } else {
                            $setupLayout                        = SetupLayouts::where('layout_id', $data['layout_id'])->first();
                        }
                        $setupLayout->tobacco_group_code    = $dataItemNumber->tobacco_group_code;
                        $setupLayout->tobacco_type_code     = $dataItemNumber->tobacco_type_code;
                        $setupLayout->inventory_item_id     = $dataItemNumber->inventory_item_id;
                        // $setupLayout->start_date            = parseFromDateth(date('Y-m-d', strtotime($data['start_date'])));
                        // $setupLayout->end_date              = parseFromDateTh($data['end_date']);

                        $setupLayout->start_date            = $data['start_date'];
                        $setupLayout->end_date              = $data['end_date'];
                        $setupLayout->layout_qty            = $data['numberLayout'];
                        $setupLayout->uom_code              = $data['unit'];
                        $setupLayout->custom_uom_code       = $data['custom_uom_code'];
                        $setupLayout->program_code          = $profile->program_code;
                        $setupLayout->created_by_id         = $profile->user_id;
                        $setupLayout->last_updated_by       = $profile->user_id;
                        $setupLayout->last_update_date      = now();
                        $setupLayout->save();
                        if ($data['is_del_row']) {
                            $setupLayout->delete();
                            // code...
                        }
                    }
                }

            \DB::commit();

        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::info($e);
            if($request->ajax()){
                $result['status'] = 'ERROR';
                $result['err_msg'] = $e->getMessage();
                return $result;
            }else{
                \Log::error($e->getMessage());
                return abort('403');
            }
        }

        $data = 'succeed';
        return response()->json(['data' => $data]);
    }

    public function getCustomUomList()
    {
        $data = collect(\DB::select("
            SELECT lv.lookup_code ,lv.description
                    , lv.lookup_code value
                    , lv.description label
            FROM apps.fnd_lookup_types_TL        lt
                , apps.fnd_lookup_values         lv
            WHERE 1=1
                AND lt.LOOKUP_TYPE      = lv.LOOKUP_TYPE
                AND lt.LOOKUP_TYPE      = 'PMS0023_LAYOUT_UOM'
                AND lv.enabled_flag     = 'Y'
                AND  sysdate            >=   nvl(lv.end_date_active ,sysdate)
            UNION ALL
            SELECT
                lv2.uom_code as lookup_code
                ,lv2.unit_of_measure as description
               , lv2.uom_code value
               , lv2.unit_of_measure label
            from ptinv_uom_v lv2
            where 1=1
        "));

        return $data;
    }
}
