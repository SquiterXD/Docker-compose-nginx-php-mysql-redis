<?php

namespace App\Http\Controllers\PM\Settings;

use App\Models\PM\Settings\TobaccoItemcatSeg2V;
use App\Models\PM\Settings\SetupLayouts;
use App\Models\PM\Settings\SetupLayoutsV;
use App\Models\PM\Settings\ItemNumberV;
use App\Models\PM\Settings\Parameters;
use App\Models\PM\Settings\PtpmConvertItemsInfo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\CollectionHelper;

class SavePublicationLayoutController extends Controller
{
    protected $perPage = 25;
    public function index()
    {
        if (request()->ajax() || request()->test) {
            if (request()->action == 'get-items') {
                $data = $this->getItems(request());
                return response()->json($data);
            }
        }

        $resultSearch = request()->all() ? request()->all() : '';
        if($resultSearch){
            if(isset($resultSearch['itemcat'])){
                $itemcatArray = explode('.', $resultSearch['itemcat']);
                $tobaccoGroupCode = $itemcatArray[0];
                $tobaccoTypeCode = $itemcatArray[1];
            }else {
                $tobaccoTypeCode = '';
            }

            if(isset($resultSearch['itemNumber'])){
                $itemNumber = $resultSearch['itemNumber'];
            }else{
                $itemNumber = '';
            }
        }else {
            $tobaccoTypeCode = '';
            $itemNumber = '';
        }
        $organizationIdLogin = getDefaultData('/pm/settings/save-publication-layout')->organization_id;
        $tableItemNumberV = (new ItemNumberV)->getTable();
        $tableParameters = (new Parameters)->getTable();
        $tableTobaccoItemcatSeg2V = (new TobaccoItemcatSeg2V)->getTable();
        // $itemNumberSelectList = collect(\DB::select(" select
        //                                                     {$tableItemNumberV}.item_number,
        //                                                     {$tableItemNumberV}.item_desc,
        //                                                     {$tableItemNumberV}.inventory_item_id,
        //                                                     {$tableItemNumberV}.primary_uom_code,
        //                                                     {$tableItemNumberV}.primary_unit_of_measure,
        //                                                     {$tableItemNumberV}.enabled_flag,
        //                                                     {$tableItemNumberV}.item_type,
        //                                                     {$tableItemNumberV}.user_item_type,
        //                                                     {$tableItemNumberV}.tobacco_group_code,
        //                                                     {$tableItemNumberV}.tobacco_group,
        //                                                     {$tableItemNumberV}.tobacco_type_code,
        //                                                     {$tableItemNumberV}.tobacco_type
        //                                             from    {$tableItemNumberV}
        //                                             where   {$tableItemNumberV}.organization_id = '{$organizationIdLogin}'
        //                                             and     {$tableItemNumberV}.tobacco_group_code = '1103'                   "));
        // $itemNumberSelectList = ItemNumberV::search($resultSearch)
        //                                     ->where('organization_id', $organizationIdLogin)
        //                                     ->whereIn('tobacco_group_code', ['1103', '1105'])
        //                                     // ->where('item_number', '11030AGD102')
        //                                     ->orderBy('item_number', 'asc')
        //                                     ->get();

        $columns = "tobacco_group_code, tobacco_type_code, inventory_item_id, item_number, item_desc, primary_unit_of_measure, primary_uom_code";
        $oldItemSql = $this->oldItemSql();
        $itemNumberSelectList = ItemNumberV::selectRaw($columns)->groupByRaw($columns)
                                    ->when($oldItemSql, function($q) use($oldItemSql) {
                                        $q->whereRaw("inventory_item_id  in ($oldItemSql)");
                                    })
                                    ->orderBy('item_number', 'asc')
                                    ->get();
        // $itemNumberList = ItemNumberV::search($resultSearch)
        //                                 ->where('organization_id', $organizationIdLogin)
        //                                 // ->where('tobacco_group_code', '1103')
        //                                 // ->where('item_number', '11030AGD102')
        //                                 ->whereIn('tobacco_group_code', ['1103', '1105'])
        //                                 // ->when(request('filter_by') == 'likes', function ($q) {
        //                                 //     return $q->where('likes', '>', request('likes_amount', 0));
        //                                 // })
        //                                 ->whereRaw("inventory_item_id = nvl('{$itemNumber}', inventory_item_id)")
        //                                 ->whereRaw("tobacco_type_code = nvl('{$tobaccoTypeCode}', tobacco_type_code)")
        //                                 ->orderBy('item_number', 'asc')
        //                                 ->paginate($this->perPage)
        //                                 ->appends([ 'itemNumber' => $itemNumber,
        //                                             'tobaccoTypeCode' => $tobaccoTypeCode   ]);

        $itemNumberList = ItemNumberV::selectRaw($columns)
                            ->when($itemNumber != '', function ($q) use ($itemNumber) {
                                $q->where('inventory_item_id', $itemNumber);
                            })
                            // ->where('organization_id', $organizationIdLogin)
                            ->when($tobaccoTypeCode != '', function ($q) use ($tobaccoTypeCode) {
                                $q->where('tobacco_type_code', $tobaccoTypeCode);
                            })
                            ->when($oldItemSql, function($q) use($oldItemSql) {
                                $q->whereRaw("inventory_item_id  in ($oldItemSql)");
                            })
                            ->groupByRaw($columns)
                            ->orderBy('item_number', 'asc')
                            ->paginate($this->perPage)
                            ->appends([ 'itemNumber' => $itemNumber,
                                        'tobaccoTypeCode' => $tobaccoTypeCode   ]);

        $itemCatList =  \DB::select("   select      {$tableTobaccoItemcatSeg2V}.group_code
                                                    || '.' || {$tableTobaccoItemcatSeg2V}.type_code    tobacco_code,
                                                    {$tableTobaccoItemcatSeg2V}.group_desc
                                                    || '.' || {$tableTobaccoItemcatSeg2V}.type_desc    description,
                                                    {$tableTobaccoItemcatSeg2V}.group_code tobacco_group_code,
                                                    {$tableTobaccoItemcatSeg2V}.type_code tobacco_type_code
                                        from        {$tableTobaccoItemcatSeg2V}
                                        where       group_code in ('1103', '1105', '1125')                                           ");
        $itemNumberList->map(function ($item, $key) {
            $item->is_new_row = false;
            $item->is_edit_item = false;
            $item->is_deleted = false;

            $item->loading = false;
            $item->specification_showed = false;
            $item->conversion_rate_showed = false;
        });

        $newItem = (object) [
            'is_new_row' => true,
            'is_edit_item' => false,
            'loading' => false,
            'is_deleted' => false,
            'inventory_item_id' => '',
            'item_number' => '',
            'item_desc' => '',
            'tobacco_group_code' => '',
            'tobacco_type_code' => '',
            'conversion_rate_showed' => false,
            'specification_showed' => false,
        ];


        $url = $this->url();
        return view('pm.settings.save-publication-layout.index',compact('itemNumberList', 'itemCatList', 'resultSearch', 'itemNumberSelectList', 'url', 'newItem'));
    }

    public function edit(Request $request, $id)
    {
        $setupLayout = SetupLayoutsV::where('layout_id', $id)
                                    ->first();
        $customUomList = \App::make(\App\Http\Controllers\PM\Settings\Ajax\SavePublicationLayoutController::class)->getCustomUomList();
        $listDateLayout = [];

        array_push($listDateLayout, [
            'start_date'    => isset($setupLayout['start_date']) ? parseToDateTh($setupLayout['start_date']) : '',
            'end_date'      => isset($setupLayout['end_date']) ? parseToDateTh($setupLayout['end_date']) : '',
        ]);

        return view('pm.settings.save-publication-layout.edit',compact('setupLayout', 'listDateLayout', 'customUomList'));
    }

    public function update(Request $request)
    {
        $userId = optional(auth()->user())->user_id ?? -1;
        \DB::beginTransaction();
        try {
                $setupLayout                            = SetupLayouts::find($request->layout_id);
                $setupLayout->start_date                = parseFromDateTh($request->start_date_active);
                $setupLayout->end_date                  = parseFromDateTh($request->end_date_active);
                $setupLayout->layout_qty                = $request->numberLayout;
                $setupLayout->custom_uom_code           = $request->custom_uom_code;
                $setupLayout->program_code              = 'PMS0023';
                $setupLayout->updated_at                = now();
                $setupLayout->updated_by_id             = $userId;
                $setupLayout->last_updated_by           = $userId;
                $setupLayout->last_update_date          = now();
                $setupLayout->save();

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

        return redirect()->route('pm.settings.save-publication-layout.index')->with('success','ทำการเปลี่ยนบันทึก Layout สิ่งพิมพ์เรียบร้อยแล้ว');
    }

    private function url()
    {
        $url                    = (object)[];
        $preFixAjaxRoute        = 'pm.ajax.settings.save-publication-layout.conversion-rates';
        $url->save_publication_layout_idx = route("pm.settings.save-publication-layout.index");
        $url->ajax_conversion_idx = route("{$preFixAjaxRoute}.index");
        $url->ajax_conversion_store = route("{$preFixAjaxRoute}.store");
        return $url;
    }

    private function getItems(Request $request)
    {
        $organizationIdLogin = getDefaultData('/pm/settings/save-publication-layout')->organization_id;
        $columns = "inventory_item_id";
        // $oldItems = SetupLayoutsV::selectRaw($columns)->groupByRaw($columns)->get();
        $oldItemSql = $this->oldItemSql();
        $except = $request->except ?? [];

        $selectCols = "inventory_item_id, item_number, item_desc, tobacco_group_code, tobacco_type_code";
        $itemNumberList = ItemNumberV::selectRaw(
                                $selectCols . "
                                    , inventory_item_id       as value
                                    , item_number || ' : ' || item_desc  as label
                                "
                            )
                            ->where('organization_id', $organizationIdLogin)
                            ->whereIn('tobacco_group_code', ['1103', '1105', '1125'])
                            // ->when(count($oldItems), function ($q) use ($oldItems) {
                            //     $oldItems = $oldItems->pluck('inventory_item_id', 'inventory_item_id')->all();
                            //     $q->whereNotIn('inventory_item_id', $oldItems);
                            // })
                            ->when($oldItemSql, function($q) use($oldItemSql) {
                                $q->whereRaw("inventory_item_id not in ($oldItemSql)");
                            })
                            ->when(count($except), function($q) use($except) {
                                $except = array_filter($except);
                                if (count($except)) {
                                    $q->whereNotIn("inventory_item_id", $except);
                                }
                            })
                            ->orderBy('item_number', 'asc')
                            ->groupByRaw($selectCols)
                            // ->limit(20)
                            ->get();

        if (count($itemNumberList)) {
            return array_values($itemNumberList->toArray());
        }
        return [];
    }

    private function oldItemSql()
    {

        $layout = (new SetupLayoutsV)->getTable();
        $conversion = (new PtpmConvertItemsInfo)->getTable();

        $sql ="
            select inventory_item_id from $layout group by inventory_item_id
            UNION ALL
            select from_inventory_item_id $conversion  from ptpm_convert_items_info where deleted_at is null group by from_inventory_item_id
        ";
        return $sql;
    }



}
