<?php
namespace App\Repositories\PM;

use Illuminate\Database\Eloquent\Collection;

use DB;
use Arr;

use App\Models\PM\PtpmConvertTransaction;
use App\Models\PM\Settings\PtpmConvertItemsInfo;


class ConversTransactionRepository
{
    const url = '/pm/convers-transactions';

    function info($request)
    {
        $profile = $this->getProfile();

        // $header = PtpdAdjSalesForecastH::selectRaw("
        //                 h_adj_sale_for_id,
        //                 budget_year,
        //                 budget_year_version,
        //                 version_no,
        //                 adjust_percent,
        //                 created_at,
        //                 updated_at
        //             ")
        //             ->where('h_adj_sale_for_id', $hWebId)->first();
        $header     = (object) [];
        $data       = $this->getDataInfo($request, $header, $profile);
        $transDate  = trans('date');
        $transBtn   = trans('btn');
        $requestAll = $request->all();
        $url        = $this->url($request, $hWebId = '');

        return (object) [
            'profile'       => $profile,
            'data'          => $data,
            'header'        => $header,
            'url'           => $url,
            'transDate'     => $transDate,
            'transBtn'      => $transBtn,
            'requestAll'    => $requestAll,
        ];
    }

    function url($request, $hWebId = -999)
    {
        // $url                    = (object)[];
        // $preFixRoute            = 'pd.substitute-tobaccos';
        // $preFixAjaxRoute        = 'pd.ajax.substitute-tobaccos';
        // $url->index             = route("{$preFixRoute}.index", request()->all() ?? []);
        // $url->index             = route("{$preFixRoute}.index");
        // $url->ajax_store        = route("{$preFixAjaxRoute}.store");
        // // $url->ajax_update        = route("{$preFixAjaxRoute}.update", $hWebId);
        // // $url->ajax_modal_create_details = route("{$preFixAjaxRoute}.modal-create-details");
        // // $url->ajax_modal_search_details = route("{$preFixAjaxRoute}.modal-search-details");
        // // $url->ajax_get_lines    = route("{$preFixAjaxRoute}.get-lines");
        // // $url->ajax_get_data     = route("{$preFixAjaxRoute}.get-data");
        // // $url->ajax_compare_data = route("{$preFixAjaxRoute}.compare-data");
        // // $url->ajax_set_status   = route("{$preFixAjaxRoute}.set-status", $headerId);

        $url                    = (object)[];
        $preFixRoute            = 'pm.convers-transactions';
        $preFixAjaxRoute        = 'pm.ajax.convers-transactions';
        $url->index             = route("{$preFixRoute}.index");
        $url->ajax_store        = route("{$preFixAjaxRoute}.store");
        return $url;
    }

    // ไม่ใช้
    function search($request)
    {
        $budgetYear = $request->budget_year;
        $budgetYearVersion = $request->budget_year_version;
        $version = $request->version;

        $headers = PtpdAdjSalesForecastH::when($budgetYear, function($q) use($budgetYear) {
                        $q->where("budget_year", $budgetYear - 543);
                    })
                    ->when($budgetYearVersion, function($q) use($budgetYearVersion) {
                        $q->where("budget_year_version", $budgetYearVersion);
                    })
                    ->when($version, function($q) use($version) {
                        $q->where("version", $version);
                    })
                    ->orderBy('budget_year', 'desc')
                    ->orderBy('budget_year_version', 'desc')
                    ->orderBy('version_no', 'desc')
                    ->limit(20)
                    ->get();
        return $headers;
    }

    // ไม่ใช้
    public function getParam($request)
    {
        $profile                = getDefaultData(self::url);
        // tobacco_type_desc_list
        // category_code_1_list
        // category_code_2_list
        // item_id_list
        // instead_item_id_list
        // instead_lot_number_list
        $tobaccoTypeDescList[]  = ['value' => '', 'label' => 'ท้ังหมด'];
        $categoryCode1List[]    = ['value' => '', 'label' => 'ท้ังหมด'];
        $categoryCode2List[]    = ['value' => '', 'label' => 'ท้ังหมด'];
        $itemIdList[]           = ['value' => '', 'label' => 'ท้ังหมด'];
        $insteadItemIdList[]    = ['value' => '', 'label' => 'ท้ังหมด'];
        $insteadLotNumberList[] = ['value' => '', 'label' => 'ท้ังหมด'];
        $lotNumberList[]        = ['value' => '', 'label' => 'ท้ังหมด'];
        $lineList               = [];

        $tobaccoTypeDesc        = request()->get('tobacco_type_desc', false);
        $categoryCode1          = request()->get('category_code_1', false);
        $categoryCode2          = request()->get('category_code_2', false);
        $itemId                 = request()->get('item_id', false);
        $lotNumber              = request()->get('lot_number', false);
        $insteadItemId          = request()->get('instead_item_id', false);
        $insteadLotNumber       = request()->get('instead_lot_number', false);

        $data = PtpdMedicinalLeafLV::where('organization_id', $profile->organization_id);
        if ($tobaccoTypeDesc || $categoryCode1 || $categoryCode2 || $itemId || $lotNumber) {
            $data = $data->when($tobaccoTypeDesc, function($q) use ($tobaccoTypeDesc) {
                        $q->where('tobacco_type_desc', $tobaccoTypeDesc);
                    })->when($categoryCode1, function($q) use ($categoryCode1) {
                        $q->where('category_code_1', $categoryCode1);
                    })->when($categoryCode2, function($q) use ($categoryCode2) {
                        $q->where('category_code_2', $categoryCode2);
                    })->when($itemId, function($q) use ($itemId) {
                        $q->where('item_id', $itemId);
                    })->when($lotNumber, function($q) use ($lotNumber) {
                        $q->where('lot_number', $lotNumber);
                    });
        }

        $tobaccoTypeDescData        = clone $data;
        $categoryCode1Data          = clone $data;
        $categoryCode2Data          = clone $data;
        $itemIdData                 = clone $data;
        $insteadItemIdData          = clone $data;
        $insteadLotNumberData       = clone $data;
        $lotNumberData              = clone $data;
        if ($data) {

            $tobaccoTypeDescData = $tobaccoTypeDescData->selectRaw("
                                            distinct
                                            tobacco_type_desc as value,
                                            tobacco_type_desc as label
                                    ")
                                    // ->whereNotNull('tobacco_type_desc')
                                    ->orderBy("label")
                                    ->get();
            if (count($tobaccoTypeDescData)) {
                $tobaccoTypeDescList = array_merge($tobaccoTypeDescList, $tobaccoTypeDescData->toArray());
            }

            $categoryCode1Data = $categoryCode1Data->selectRaw("
                                            distinct
                                            CATEGORY_CODE_1 as value,
                                            CATEGORY_DESC_1 as label
                                    ")
                                    // ->whereNotNull('tobacco_type_desc')
                                    ->orderBy("label")
                                    ->get();
            if (count($categoryCode1Data)) {
                $categoryCode1List = array_merge($categoryCode1List, $categoryCode1Data->toArray());
            }

            $categoryCode2Data = $categoryCode2Data->selectRaw("
                                            distinct
                                            CATEGORY_CODE_2 as value,
                                            CATEGORY_DESC_2 as label
                                    ")
                                    // ->whereNotNull('tobacco_type_desc')
                                    ->orderBy("label")
                                    ->get();
            if (count($categoryCode2Data)) {
                $categoryCode2List = array_merge($categoryCode2List, $categoryCode2Data->toArray());
            }

            $itemIdData = $itemIdData->selectRaw("
                                            distinct
                                            item_id,
                                            item_code,
                                            item_desc,
                                            item_id as value,
                                            item_code ||' : '|| item_desc  as label
                                    ")
                                    // ->whereNotNull('tobacco_type_desc')
                                    ->orderBy("label")
                                    ->get();
            if (count($itemIdData)) {
                $itemIdList = array_merge($itemIdList, $itemIdData->toArray());
            }

            // lot_number
            $lotNumberData = $lotNumberData->selectRaw("
                                            distinct
                                            lot_number as value,
                                            lot_number as label
                                    ")
                                    ->orderBy("label")
                                    ->get();
            if (count($lotNumberData)) {
                $lotNumberList = array_merge($lotNumberList, $lotNumberData->toArray());
            }

            $lineList = $data->selectRaw("
                                blend_no
                                , formula_id
                                , formula_no
                                , leaf_formula          as instead_leaf_formula
                                , leaf_formula_desc     as instead_leaf_formula_desc
                                , ingredients_group     as instead_ingredients_group
                                , leaf_proportion       as instead_leaf_proportion
                                , leaf_proportion
                                , formulaline_id
                                , line_type
                                , line_no
                                , organization_id
                                , organization_code
                                , item_id
                                , item_code
                                , item_desc
                                , qty
                                , detail_uom
                                , ingredient_proportions
                                , lot_number
                                , '' old_ingredient_proportions
                                , '' instead_item_id
                                , '' instead_item_code
                                , '' instead_item_desc
                                , '' instead_ingredient_proportions
                                , '' instead_lot_number
                        ")
                        ->orderByRaw("
                            blend_no, item_code, item_desc
                        ")
                        ->get();
            data_set($lineList, '*.is_select', false);
            data_set($lineList, '*.instead_lot_number_list', false);
        }

        $data = [
            'tobacco_type_desc_list'    => $tobaccoTypeDescList,
            'category_code_1_list'      => $categoryCode1List,
            'category_code_2_list'      => $categoryCode2List,
            'item_id_list'              => $itemIdList,
            'lot_number_list'           => $lotNumberList,
            'instead_item_id_list'      => $insteadItemIdData,
            'instead_lot_number_list'   => $insteadLotNumberData,
            'lines_list'                => $lineList,
        ];

        return $data;
    }

    // ไม่ใช้
    public function searchInsteadItem($request)
    {
        $profile = $this->getProfile();
        $itemList = (new ExpFmlRepository)->getItemList($request, $profile, $inventoryItemId = false);

        foreach ($itemList as $key => $item) {
            $item->lot_list = (new ExpFmlRepository)->getLotList($request, $profile, $inventory_item_id = $item->value);
        }

        $data = [
            'instead_item_id_list'      => $itemList,
            'instead_lot_number_list'   => [],
        ];
        return $data;
    }

    function store($request)
    {
        $profile = $this->getProfile();
        $sysdate = now();

        $batchNo = \Str::uuid();
        foreach ($request->lines as $key => $line) {
            $line = (object) $line;
            $convertItemId = data_get($line->to_item, 'convert_item_id');
            $conversion = PtpmConvertItemsInfo::where('convert_item_id', $convertItemId)->first();

            $data  = new PtpmConvertTransaction;
            $data->convert_item_id          = $conversion->convert_item_id;
            $data->transaction_date         = $sysdate;
            $data->transaction_quantity     = $line->transaction_quantity;
            $data->transaction_uom          = data_get($line->to_item, 'to_uom_code');

            $data->transaction_rate         = $conversion->conversion_rate;
            $data->from_inventory_item_id   = $conversion->from_inventory_item_id;
            $data->to_inventory_item_id     = $conversion->to_inventory_item_id;

            $data->created_by               = $profile->fnd_user_id;
            $data->created_by_id            = $profile->user_id;
            $data->created_at               = $sysdate;
            $data->creation_date            = $sysdate;
            $data->program_code             = $profile->program_code;
            $data->updated_by_id            = $profile->user_id;
            $data->last_updated_by          = $profile->fnd_user_id;
            $data->updated_at               = $sysdate;
            $data->last_update_date         = $sysdate;
            $data->web_batch_no             = $batchNo;
            $data->save();
        }

        $result = $this->interface($profile, $batchNo);
        if ($result['status'] != 'S') {
            throw new \Exception($result['msg']);
        }

        return;
    }

    // ไม่ใช้
    function update(PtpdAdjSalesForecastH $adjSalForecastHT, $request)
    {
        $adjustPercent = Arr::get($request->all(), 'header.adjust_percent', null);
        $lines = Arr::get($request->all(), 'header.lines', []) ?? [];

        $profile = $this->getProfile();
        $sysdate = now();

        // $adjSalForecastHT->adjust_percent     = $adjustPercent;
        // $adjSalForecastHT->updated_by_id      = $profile->user_id;
        // $adjSalForecastHT->last_updated_by    = $profile->fnd_user_id;
        // $adjSalForecastHT->updated_at         = $sysdate;
        // $adjSalForecastHT->last_update_date   = $sysdate;
        // $adjSalForecastHT->save();

        $header                     = new PtpdAdjSalForecastHT;
        $header->h_adj_sale_for_id  = $adjSalForecastHT->h_adj_sale_for_id;
        $header->adjust_percent     = $adjustPercent;
        $header->org_id             = $adjSalForecastHT->org_id;
        $header->budget_year        = $adjSalForecastHT->budget_year;
        $header->budget_year_version = $adjSalForecastHT->budget_year_version;
        $header->version_no         = $adjSalForecastHT->version_no;

        $header->web_status         = 'UPDATE';
        $header->created_by         = $profile->fnd_user_id;
        $header->created_by_id      = $profile->user_id;
        $header->created_at         = $sysdate;
        $header->creation_date      = $sysdate;
        $header->program_code       = $profile->program_code;

        $header->updated_by_id      = $profile->user_id;
        $header->last_updated_by    = $profile->fnd_user_id;
        $header->updated_at         = $sysdate;
        $header->last_update_date   = $sysdate;
        $header->web_batch_no       = '-';
        $header->save();
        $header->web_batch_no       = $header->h_web_id;
        $header->save();


        foreach ($lines as $key => $line) {
            $line = (object) $line;
            $updateLine                     = PtpdAdjSalesForecastL::find($line->l_adj_sale_for_id);
            // $updateLine->adjust_quantity    = $line->adjust_quantity;
            // $updateLine->updated_by_id      = $adjSalForecastHT->updated_by_id;
            // $updateLine->last_updated_by    = $adjSalForecastHT->last_updated_by;
            // $updateLine->updated_at         = $adjSalForecastHT->updated_at;
            // $updateLine->last_update_date   = $adjSalForecastHT->last_update_date;
            // $updateLine->save();


            $newLine                    = new PtpdAdjSalForecastLT;
            // $newLine->l_web_id          = PtpdAdjSalForecastLT::max('l_web_id') + 1;
            $newLine->l_adj_sale_for_id = $updateLine->l_adj_sale_for_id;
            $newLine->h_adj_sale_for_id = $adjSalForecastHT->h_adj_sale_for_id;
            $newLine->h_web_id          = $header->h_web_id;
            $newLine->org_id            = $updateLine->org_id;
            $newLine->budget_year_version = $updateLine->budget_year_version;
            $newLine->version_no        = $updateLine->version_no;
            $newLine->yearly_id         = $updateLine->yearly_id;
            $newLine->item_id           = $updateLine->item_id;
            $newLine->item_code         = $updateLine->item_code;
            $newLine->item_description  = $updateLine->item_description;
            $newLine->quantity          = $updateLine->quantity;
            $newLine->adjust_quantity   = $line->adjust_quantity;
            $newLine->created_by        = $header->created_by;
            $newLine->created_by_id     = $header->created_by_id;
            $newLine->created_at        = $header->created_at;
            $newLine->creation_date     = $header->creation_date;
            $newLine->program_code      = $header->program_code;

            $newLine->web_status        = $header->web_status;
            $newLine->updated_by_id     = $header->updated_by_id;
            $newLine->last_updated_by   = $header->last_updated_by;
            $newLine->updated_at        = $header->updated_at;
            $newLine->last_update_date  = $header->last_update_date;
            $newLine->web_batch_no      = $header->web_batch_no;
            $newLine->save();
        }

        $result = $this->interfaceImort($header);
        if ($result['status'] != 'C') {
            throw new \Exception($result['msg']);
        }

        return $adjSalForecastHT;
    }


    function interface($profile, $batchNo)
    {
        $db     =   \DB::connection('oracle')->getPdo();
        $sql    =   "
            declare
                v_status            varchar2(10);
                v_err_msg            varchar2(2000);
            begin
                ptpm_pmp0060_pkg.main_process(  p_program_code => '{$profile->program_code}',
                                                p_user_name => '{$profile->fnd_user_name}',
                                                p_web_batch_no => '{$batchNo}',
                                                p_status => :v_status,
                                                p_err_msg => :v_err_msg);
                dbms_output.put_line('Status : ' || v_status);
                dbms_output.put_line('Error : ' || v_err_msg);
            end;
        ";

        \Log::info("{$batchNo} INF", [$sql]);
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':v_status', $result['status'], \PDO::PARAM_STR, 10);
        $stmt->bindParam(':v_err_msg', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        \Log::info("{$batchNo} INF", [$result]);

        return $result;
    }

    function getDataInfo($request, $header, $profile)
    {
        $conversRateCondition = "and TRUNC(sysdate) BETWEEN TRUNC(a.start_date) and TRUNC(nvl(a.end_date, sysdate)) and nvl(a.enable_flag, 'N') = 'Y'";

        $items = DB::select("
            SELECT
                DISTINCT
                a.from_inventory_item_id,
                b.item_number,
                b.item_desc,
                b.primary_unit_of_measure,
                a.from_inventory_item_id value,
                b.item_number || ' : ' || b.item_desc label
            from    ptpm_convert_items_info a
                    , ptpm_item_number_v b
            where   1=1
            and     a.from_organization_id = b.organization_id
            and     a.from_inventory_item_id = b.inventory_item_id
                    $conversRateCondition
            order by b.item_number
        ");

        // $fmOrg = DB::select("
        //     SELECT  distinct
        //             a.convert_item_id
        //             , a.conversion_rate
        //             , fm_item.item_number                  from_item_number
        //             , fm_item.item_desc                    from_item_desc
        //             , fm_uom.unit_of_measure                from_item_uom

        //             , a.from_inventory_item_id
        //             , a.from_organization_id
        //             , a.from_subinv
        //             , a.from_locator_id
        //             , c.concatenated_segments from_locator
        //             , b.organization_code
        //             , b.organization_name
        //             , b.organization_id value
        //             , b.organization_code || ' : ' || b.organization_name label

        //             , a.to_inventory_item_id
        //             --, toOrg.organization_code to_organization_code
        //             --, toOrg.organization_name to_organization_name
        //             , toOrg.organization_id to_org_value
        //             , toOrg.organization_code || ' : ' || toOrg.organization_name to_org_label
        //             , a.to_organization_id
        //             , a.to_subinv
        //             , a.to_locator_id
        //             , toLocator.concatenated_segments to_locator
        //             , a.to_locator_id to_locator_value
        //             , toLocator.concatenated_segments to_locator_label

        //             , item.item_number                  to_item_number
        //             , item.item_desc                    to_item_desc
        //             , to_uom.unit_of_measure            to_item_uom
        //             , a.to_inventory_item_id            to_item_value
        //             , a.to_uom                          to_uom_code
        //             , item.item_number || ' : ' || item.item_desc to_item_label

        //     from    ptpm_convert_items_info a
        //             , ORG_ORGANIZATION_DEFINITIONS b
        //             , mtl_item_locations_kfv c
        //             , ptpm_item_number_v    fm_item
        //             , ptinv_uom_v           fm_uom
        //             , ptinv_uom_v           to_uom


        //             -- to Org
        //             , ORG_ORGANIZATION_DEFINITIONS toOrg
        //             , mtl_item_locations_kfv toLocator

        //             -- to_item
        //             , ptpm_item_number_v item

        //     where   1=1
        //     and     a.from_organization_id = b.organization_id
        //     -- and     a.from_organization_id = c.organization_id
        //     and     a.from_locator_id =  c.inventory_location_id
        //     and     a.from_organization_id = fm_item.organization_id
        //     and     a.from_inventory_item_id = fm_item.inventory_item_id

        //     -- FM UOM
        //     and     a.from_uom              = fm_uom.uom_code

        //     and     a.to_organization_id = toOrg.organization_id
        //     and     a.to_organization_id = toLocator.organization_id
        //     and     a.to_locator_id =  toLocator.inventory_location_id

        //     -- TO UOM
        //     and     a.to_uom                = to_uom.uom_code

        //     and     a.to_organization_id = item.organization_id
        //     and     a.to_inventory_item_id = item.inventory_item_id
        //             $conversRateCondition
        // ");

         $fmOrgSql = ("
            SELECT
                    distinct
                    a.convert_item_id
                    , a.conversion_rate
                    , fm_item.item_number                  from_item_number
                    , fm_item.item_desc                    from_item_desc
                    , fm_uom.unit_of_measure                from_item_uom

                    , a.from_inventory_item_id
                    , set_mfg.from_organization_id                              --, a.from_organization_id
                    , set_mfg.from_subinventory         as from_subinv          --, a.from_subinv
                    , set_mfg.from_locator_id           as from_locator_id      --, a.from_locator_id
                    , set_mfg.from_locator_code         as from_locator         --, c.concatenated_segments from_locator
                    , fm_org.organization_code
                    , fm_org.organization_name
                    , fm_org.organization_id value
                    , fm_org.organization_code || ' : ' || fm_org.organization_name label

                    , a.to_inventory_item_id
                    , to_org.organization_id to_org_value
                    , to_org.organization_code || ' : ' || to_org.organization_name to_org_label
                    , set_mfg.to_organization_id
                    , set_mfg.to_subinventory           as to_subinv
                    , set_mfg.to_locator_id
                    , set_mfg.from_locator_code         as to_locator
                    , set_mfg.to_locator_id             as to_locator_value
                    , set_mfg.from_locator_code         as to_locator_label

                    , to_item.item_number               as to_item_number
                    , to_item.item_desc                 as to_item_desc
                    , to_uom.unit_of_measure            as to_item_uom
                    , a.to_inventory_item_id            as to_item_value
                    , a.to_uom                          as to_uom_code
                    , to_item.item_number || ' : ' || to_item.item_desc to_item_label
            from    ptpm_convert_items_info a

                    -- FM ITEM
                    , ptpm_item_number_v    fm_item
                    , ptinv_uom_v           fm_uom
                    -- TO ITEM
                    , ptpm_item_number_v    to_item
                    , ptinv_uom_v           to_uom

                    -- Setup PMS0022
                    , ptpm_setup_mfg_departments_v set_mfg
                    , ORG_ORGANIZATION_DEFINITIONS fm_org
                    , ORG_ORGANIZATION_DEFINITIONS to_org
            where   1=1
            -- FM ITEM
            and     a.from_organization_id = fm_item.organization_id
            and     a.from_inventory_item_id = fm_item.inventory_item_id
            -- FM UOM
            and     a.from_uom              = fm_uom.uom_code

            -- TO ITEM
            and     a.to_organization_id = to_item.organization_id
            and     a.to_inventory_item_id = to_item.inventory_item_id
            -- TO UOM
            and     a.to_uom                = to_uom.uom_code

            -- Setup PMS0022
            and     fm_item.tobacco_group_code = set_mfg.tobacco_group_code
            and     set_mfg.transaction_type_name = 'T16:จ่าย-Letterข้ามItem'
            and     set_mfg.from_organization_id = fm_org.organization_id
            and     set_mfg.to_organization_id = to_org.organization_id
                    $conversRateCondition
        ");

        $fmOrg =  DB::select($fmOrgSql);

         // dd('xx', $fmOrgSql, $fmOrg);
        foreach ($fmOrg as $key => $org) {
            $org->fm_onhand = $this->getOnhand($org->from_organization_id, $org->from_inventory_item_id, $org->from_subinv, $org->from_locator_id);
            $org->to_onhand = $this->getOnhand($org->to_organization_id, $org->to_inventory_item_id, $org->to_subinv, $org->to_locator_id);
        }


        $newLine = (object) [];
        $newLine->is_select = true;
        $newLine->from_organization_id = '';
        $newLine->from_inventory_item_id = '';
        $newLine->from_subinv = '';
        $newLine->from_locator_id = '';
        $newLine->from_uom = '';
        $newLine->to_organization_id = '';
        $newLine->to_subinv = '';
        $newLine->to_locator_id = '';
        $newLine->to_inventory_item_id = '';
        $newLine->to_uom = '';

        $newLine->transaction_uom = '';
        $newLine->fm_transaction_quantity = '';
        $newLine->transaction_quantity = '';


        $newLine->fm_item = (object) [];
        $newLine->to_item = (object) [];
        $newLine->fm_org_selected = (object) [];

        $newLine->fm_org_list = [];
        $newLine->fm_subinv_list = [];
        $newLine->fm_locator_list = [];
        $newLine->to_org_list = [];
        $newLine->to_subinv_list = [];
        $newLine->to_locator_list = [];
        $newLine->to_item_list = [];


        $data = (object)[];
        $data->items = $items;
        $data->fm_org = $fmOrg;
        $data->new_line = $newLine;

        $data->menu = getMenu($this::url);

        $header->lines = [];
        if (false) {
            $lines = [];
            if (count($lines)) {
                data_set($lines, '*.is_select', false);
                data_set($lines, '*.instead_lot_number_list', false);
            }
            $header->lines = $lines;

            $can = (object) [];
            $can->edit = $header->created_at == $header->updated_at;
            $header->can = $can;
        } else {
            $can = (object) [];
            $can->edit = true;
            $header->can = $can;
        }

        return $data;
    }

    function getJsonNullable()
    {
        return json_encode(false);
    }

    function getCan($status, $lookupCode)
    {
        $can = (object)[
            'edit' => true,
            // Tab: cigarettes
            'cigarettes' => (object) [
                'multi_cigarettes' => true,
            ],
            // Tab: leaf_formulas
            'leaf_formulas' => (object) [
                'ingredient' => (object) [
                    'add_lot_number' => false
                ]
            ],
        ];
        if (strtoupper($status) == 'ACTIVE' || true) {
            if ($lookupCode == 1) {
                $can->leaf_formulas->ingredient->add_lot_number = true;
                $can->cigarettes->multi_cigarettes = true;
            }
        }

        return $can;
    }


    function getProfile($lookupCode = false)
    {
        $data = getDefaultData($this::url);
        return $data;
    }

    function getOnhand($orgId, $itemId, $subinv, $locatorId)
    {
        $data = DB::select("
            SELECT sum(onhand_quantity) TRANSACTION_QUANTITY
            from    PTINV_ONHAND_QUANTITIES_V
            where   organization_id = $orgId
            and     inventory_item_id = $itemId
            and     subinventory_code = '$subinv'
            and     locator_id = $locatorId
            and     TRUNC(nvl(expiration_date, sysdate) ) >= TRUNC(sysdate)
        ");


        $onhand = 0;
        if (count($data)) {
            $onhand = $data[0]->transaction_quantity;
        }

        return $onhand;
    }


}
