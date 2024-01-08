<?php
namespace App\Repositories\PD;

use Illuminate\Database\Eloquent\Collection;

use DB;
use Arr;
use App\Models\PD\AdjSalForecasts\PtpdAdjSalesForecastH;
use App\Models\PD\AdjSalForecasts\PtpdAdjSalesForecastL;

use App\Models\PD\AdjSalForecasts\PtpdAdjSalForecastHT;
use App\Models\PD\AdjSalForecasts\PtpdAdjSalForecastLT;

use App\Models\PD\AdjSalForecasts\PtpdBudgetYearV;
use App\Models\PD\AdjSalForecasts\PtpdBudgetYearItemV;


use App\Models\PD\ExpFmls\PtpdFormulaHV;
use App\Models\PD\SubstituteTobacco\PtpdMedicinalLeafLV;
use App\Models\PD\SubstituteTobacco\PtpdMedicinalLeafHT;
use App\Models\PD\SubstituteTobacco\PtpdMedicinalLeafLT;
use App\Models\PM\Lookup\PtinvOnhandQuantitiesV;

use App\Repositories\PD\ExpFmlRepository;

class SubstituteTobaccoRepository
{
    const url = '/pd/substitute-tobaccos';

    function info($request)
    {
        $profile = $this->getProfile();
        $hWebId = $request->h_adj_sale_for_id ?? -1;

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
        $header = false;

        if (!$header) {
            $header = new PtpdAdjSalesForecastH;
        }

        $data       = $this->getDataInfo($request, $header, $profile);
        $transDate  = trans('date');
        $transBtn   = trans('btn');
        $requestAll = $request->all();
        $url        = $this->url($request, $hWebId);

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
        $preFixRoute            = 'pd.substitute-tobaccos';
        $preFixAjaxRoute        = 'pd.ajax.substitute-tobaccos';
        $url->index             = route("{$preFixRoute}.index", request()->all() ?? []);
        $url->ajax_store        = route("{$preFixAjaxRoute}.store");
        $url->ajax_get_lines    = route("{$preFixAjaxRoute}.get-lines");
        $url->ajax_get_data     = route("{$preFixAjaxRoute}.get-data");
        $url->ajax_compare_data = route("{$preFixAjaxRoute}.compare-data");
        // $url->ajax_set_status   = route("{$preFixAjaxRoute}.set-status", $headerId);
        return $url;
    }

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

        // $data = PtpdMedicinalLeafLV::where('organization_id', $profile->organization_id);
        // if ($tobaccoTypeDesc || $categoryCode1 || $categoryCode2 || $itemId || $lotNumber) {
        //     $data = $data->when($tobaccoTypeDesc, function($q) use ($tobaccoTypeDesc) {
        //                 $q->where('tobacco_type_desc', $tobaccoTypeDesc);
        //             })->when($categoryCode1, function($q) use ($categoryCode1) {
        //                 $q->where('category_code_1', $categoryCode1);
        //             })->when($categoryCode2, function($q) use ($categoryCode2) {
        //                 $q->where('category_code_2', $categoryCode2);
        //             })->when($itemId, function($q) use ($itemId) {
        //                 $q->where('item_id', $itemId);
        //             })->when($lotNumber, function($q) use ($lotNumber) {
        //                 $q->where('lot_number', $lotNumber);
        //             });
        // }

        $tobaccoTypeDescData        = false;
        $categoryCode1Data          = false;
        $categoryCode2Data          = false;
        $itemIdData                 = false;
        $insteadItemIdData          = false;
        $insteadLotNumberData       = false;
        $lotNumberData              = false;
        if (true) {

            // $tobaccoTypeDescData = $tobaccoTypeDescData->selectRaw("
            //                                 distinct
            //                                 tobacco_type_desc as value,
            //                                 tobacco_type_desc as label
            //                         ")
            //                         // ->whereNotNull('tobacco_type_desc')
            //                         ->orderBy("label")
            //                         ->get();
            $condition = "";
            if ($tobaccoTypeDesc) {
                $condition = "and   tobacco_type_desc = '$tobaccoTypeDesc'";
            }
            $tobaccoTypeDescData = collect(DB::select("
                                        SELECT  tobacco_type_desc as value,
                                                tobacco_type_desc as label
                                        FROM    PTPD_MEDI_LEAF_TOBACCO_TYPE_V
                                        WHERE   1=1
                                        AND    TOBACCO_ORGANIZATION_CODE = '{$profile->organization_code}'
                                        $condition
                                        GROUP BY tobacco_type_desc, tobacco_type_code
                                        ORDER BY tobacco_type_desc
                                    "));
            if (count($tobaccoTypeDescData)) {
                $tobaccoTypeDescList = array_merge($tobaccoTypeDescList, $tobaccoTypeDescData->toArray());
            }


            if ($tobaccoTypeDesc) {
                $condition = "and   tobacco_type_desc = '$tobaccoTypeDesc'";
                $condition2 = "";
                if ($categoryCode1) {
                    $condition2 = "and   category_code_1 = '$categoryCode1'";
                }
                $categoryCode1Data = collect(DB::select("
                                            SELECT  CATEGORY_CODE_1 as value,
                                                    CATEGORY_DESC_1 as label
                                            FROM    PTPD_MEDICINAL_LEAF_TYPE_V
                                            WHERE   1=1
                                            $condition
                                            $condition2
                                            GROUP BY CATEGORY_CODE_1, CATEGORY_DESC_1
                                            ORDER BY CATEGORY_CODE_1
                                        "));
                if (count($categoryCode1Data)) {
                    $categoryCode1List = array_merge($categoryCode1List, $categoryCode1Data->toArray());
                }
            }

            if ($tobaccoTypeDesc && $categoryCode1) {
                $condition = "and   tobacco_type_desc = '$tobaccoTypeDesc'";
                $condition .= "and   category_code_1 = '$categoryCode1'";
                $condition2 = "";
                if ($categoryCode2) {
                    $condition2 = "and   category_code_2 = '$categoryCode2'";
                }

                $categoryCode2Data = collect(DB::select("
                                            SELECT  CATEGORY_CODE_2 as value,
                                                    CATEGORY_DESC_2 as label
                                            FROM    PTPD_MEDICINAL_LEAF_TYPE_V
                                            WHERE   1=1
                                            $condition
                                            $condition2
                                            GROUP BY CATEGORY_CODE_2, CATEGORY_DESC_2
                                            ORDER BY CATEGORY_CODE_2
                                        "));
                if (count($categoryCode2Data)) {
                    $categoryCode2List = array_merge($categoryCode2List, $categoryCode2Data->toArray());
                }
            }

            if ($tobaccoTypeDesc && $categoryCode1 && $categoryCode2) {
                $condition = "and   organization_code = '{$profile->organization_code}'";
                $condition .= "and   category_code_1 = '$categoryCode1'";
                $condition .= "and   category_code_2 = '$categoryCode2'";
                $condition2 = "";
                if ($itemId) {
                    $condition2 = "and   item_id = $itemId";
                }

                $itemIdData = collect(DB::select("
                                            SELECT  distinct
                                                    item_id,
                                                    item_code,
                                                    item_desc,
                                                    item_id as value,
                                                    item_code ||' : '|| item_desc  as label
                                            FROM    PTPD_MEDICINAL_LEAF_ITEM_FM_V
                                            WHERE   1=1
                                            $condition
                                            $condition2
                                            GROUP BY item_id, item_code, item_desc
                                            ORDER BY item_code, item_desc
                                        "));
                if (count($itemIdData)) {
                    $itemIdList = array_merge($itemIdList, $itemIdData->toArray());
                }
            }

            if ($tobaccoTypeDesc && $categoryCode1 && $categoryCode2 && $itemId) {
                $condition = "and   organization_code = '{$profile->organization_code}'";
                $condition .= "and   category_code_1 = '$categoryCode1'";
                $condition .= "and   category_code_2 = '$categoryCode2'";
                $condition .= "and   item_id = '$itemId'";
                $condition2 = "";
                if ($lotNumber) {
                    $condition2 = "and   lot_number = $lotNumber";
                }
                $lotNumberData = collect(DB::select("
                                            SELECT  distinct
                                                    lot_number as value,
                                                    lot_number as label
                                            FROM    PTPD_MEDICINAL_LEAF_ITEM_FM_V
                                            WHERE   1=1
                                            $condition
                                            $condition2
                                            AND     lot_number is not null
                                            GROUP BY lot_number
                                            ORDER BY lot_number
                                        "));
                if (count($lotNumberData)) {
                    $lotNumberList = array_merge($lotNumberList, $lotNumberData->toArray());
                }
            }

            if ($tobaccoTypeDesc && $categoryCode1 && $categoryCode2 && request()->click_search_btn == 'true') {
                $lineList = PtpdMedicinalLeafLV::where('organization_id', $profile->organization_id)
                                ->selectRaw("
                                    blend_no
                                    , formula_id
                                    , formula_status
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
                                    , formula_vers
                                    , leaf_formula
                                    , leaf_formula_desc
                                    , ingredients_group
                                    , ingredient_proportions old_ingredient_proportions
                                    , '' instead_item_id
                                    , '' instead_item_code
                                    , '' instead_item_desc
                                    , '' instead_ingredient_proportions
                                    , '' instead_lot_number
                                    , onhand_quantity
                                ")
                                ->when($tobaccoTypeDesc, function($q) use ($tobaccoTypeDesc) {
                                    $q->where('tobacco_type_desc', $tobaccoTypeDesc);
                                })->when($categoryCode1, function($q) use ($categoryCode1) {
                                    $q->where('category_code_1', $categoryCode1);
                                })->when($categoryCode2, function($q) use ($categoryCode2) {
                                    $q->where('category_code_2', $categoryCode2);
                                })->when($itemId, function($q) use ($itemId) {
                                    $q->where('item_id', $itemId);
                                })->when($lotNumber, function($q) use ($lotNumber) {
                                    $q->where('lot_number', $lotNumber);
                                })
                                ->orderByRaw("
                                    blend_no, item_code, item_desc
                                ")
                                // ->limit(10)
                                ->get();
                data_set($lineList, '*.is_select', false);
                data_set($lineList, '*.for_delete', false);
                data_set($lineList, '*.is_disabled', false);
                data_set($lineList, '*.instead_lot_number_list', false);
                // data_set($lineList, '*.onhand_quantity', 0);
                data_set($lineList, '*.onhand_quantity_format', number_format(0, 2));

                foreach ($lineList ?? [] as $key => $line) {
                    $line->is_inactive = ($line->formula_status == 'Inactive');
                    if (!$line->is_inactive) {
                        $line->is_disabled = true;
                    }
                    // if ($line->lot_number) {
                    //     $table = (new PtinvOnhandQuantitiesV)->getTable();
                    //     $data = collect(DB::select("
                    //         SELECT sum(onhand_quantity) TRANSACTION_QUANTITY
                    //         from    $table
                    //         where   organization_id = $line->organization_id
                    //         and     inventory_item_id = $line->item_id
                    //         and     lot_number = '$line->lot_number'
                    //         and     TRUNC(nvl(expiration_date, sysdate) ) >= TRUNC(sysdate)
                    //     "));
                    //     if ($data) {
                    //         $line->onhand_quantity = $data->first()->transaction_quantity ?? 0;
                    //     }
                    // }
                    $line->for_delete = $line->onhand_quantity == 0 && $line->ingredient_proportions == 0;
                    $line->onhand_quantity_format = number_format($line->onhand_quantity, 2);
                }
            }

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

    public function searchInsteadItem($request)
    {
        $profile = $this->getProfile();
        $number = strtolower($request->number) ?? false;
        $itemList = collect([]);

        $tobaccoTypeDescList[]  = ['value' => '', 'label' => 'ท้ังหมด'];
        $categoryCode1List[]    = ['value' => '', 'label' => 'ท้ังหมด'];
        $categoryCode2List[]    = ['value' => '', 'label' => 'ท้ังหมด'];

        $tobaccoTypeDescData        = false;
        $categoryCode1Data          = false;
        $categoryCode2Data          = false;

        $tobaccoTypeDesc        = request()->get('instead_tobacco_type_desc', false);
        $categoryCode1          = request()->get('instead_category_code_1', false);
        $categoryCode2          = request()->get('instead_category_code_2', false);


        $condition = "";
        if ($tobaccoTypeDesc) {
            $condition = "and   tobacco_type_desc = '$tobaccoTypeDesc'";
        }
        $tobaccoTypeDescData = collect(DB::select("
                                    SELECT  tobacco_type_desc as value,
                                            tobacco_type_desc as label
                                    FROM    PTPD_MEDI_LEAF_TOBACCO_TYPE_V
                                    WHERE   1=1
                                    AND    TOBACCO_ORGANIZATION_CODE = '{$profile->organization_code}'
                                    $condition
                                    GROUP BY tobacco_type_desc, tobacco_type_code
                                    ORDER BY tobacco_type_desc
                                "));
        if (count($tobaccoTypeDescData)) {
            $tobaccoTypeDescList = array_merge($tobaccoTypeDescList, $tobaccoTypeDescData->toArray());
        }



        if ($tobaccoTypeDesc) {
            $condition = "and   tobacco_type_desc = '$tobaccoTypeDesc'";
            $condition2 = "";
            if ($categoryCode1) {
                $condition2 = "and   category_code_1 = '$categoryCode1'";
            }
            $categoryCode1Data = collect(DB::select("
                                        SELECT  CATEGORY_CODE_1 as value,
                                                CATEGORY_DESC_1 as label
                                        FROM    PTPD_MEDICINAL_LEAF_TYPE_TO_V
                                        WHERE   1=1
                                        $condition
                                        $condition2
                                        GROUP BY CATEGORY_CODE_1, CATEGORY_DESC_1
                                        ORDER BY CATEGORY_CODE_1
                                    "));
            if (count($categoryCode1Data)) {
                $categoryCode1List = array_merge($categoryCode1List, $categoryCode1Data->toArray());
            }
        }

        if ($tobaccoTypeDesc && $categoryCode1) {
            $condition = "and   tobacco_type_desc = '$tobaccoTypeDesc'";
            $condition .= "and   category_code_1 = '$categoryCode1'";
            $condition2 = "";
            if ($categoryCode2) {
                $condition2 = "and   category_code_2 = '$categoryCode2'";
            }

            $categoryCode2Data = collect(DB::select("
                                        SELECT  CATEGORY_CODE_2 as value,
                                                CATEGORY_DESC_2 as label
                                        FROM    PTPD_MEDICINAL_LEAF_TYPE_TO_V
                                        WHERE   1=1
                                        $condition
                                        $condition2
                                        GROUP BY CATEGORY_CODE_2, CATEGORY_DESC_2
                                        ORDER BY CATEGORY_CODE_2
                                    "));
            if (count($categoryCode2Data)) {
                $categoryCode2List = array_merge($categoryCode2List, $categoryCode2Data->toArray());
            }
        }


        if ($categoryCode1 && $categoryCode2) {
            $condition = "and   organization_code = '{$profile->organization_code}'";
            $condition .= "and   category_code_1 = '$categoryCode1'";
            $condition .= "and   category_code_2 = '$categoryCode2'";

            $cdtItemNum = "";
            if ($number) {
                $cdtItemNum = "and LOWER(item_code || ' : ' || item_desc) like '%{$number}%'";
            }

            $itemIdData = collect(DB::select("
                SELECT  organization_code,
                        organization_id,
                        item_group,
                        item_code               as item_number,
                        item_desc               as item_desc,
                        uom,
                        uom_name,
                        inventory_item_id       as value,
                        item_code || ' : ' || item_desc  as label,
                        CASE
                            WHEN item_group = '1002' THEN 'Y'
                            ELSE 'N'
                        END                     as validate_lot,
                        lot_number,
                        onhand_quantity
                FROM    PTPD_MEDICINAL_LEAF_ITEM_TO_V
                WHERE   1=1
                $condition
                $cdtItemNum
                ORDER BY item_code, item_desc, lot_number
            "));

            if (count($itemIdData)) {
                foreach ($itemIdData->groupBy('item_number') as $key => $lines) {
                    $firstLine = $lines->first();
                    $lotList = [];
                    $onhandList = [];
                    foreach ($lines->groupBy('lot_number') as $key => $lot) {
                        $lotNumber = $lot->first()->lot_number;
                        $lotList[] = [
                            'value' => $lotNumber,
                            'label' => $lotNumber,
                        ];
                        $onhandList["lot-$lotNumber"] = (object)[
                            'onhand_quantity' => $lot->sum('onhand_quantity') ?? 0,
                            'primary_unit_of_measure' => optional($firstLine)->uom_name ?? '',
                        ];
                    }

                    $firstLine->lot_list = $lotList;
                    $firstLine->onhand_list = (object)$onhandList;
                    $itemList->push($firstLine);
                }
            }

            if (count($itemList)) {
                $itemList = array_values($itemList->toArray());
            }
        }


        $data = [
            'instead_tobacco_type_desc_list'    => $tobaccoTypeDescList,
            'instead_category_code_1_list'      => $categoryCode1List,
            'instead_category_code_2_list'      => $categoryCode2List,
            'instead_item_id_list'      => $itemList,
            'instead_lot_number_list'   => [],
        ];
        return $data;

        foreach ($itemList as $key => $item) {
            $item->lot_list = (new ExpFmlRepository)->getLotList($request, $profile, $inventory_item_id = $item->value);
            $onhandList = [];
            if ($item->lot_list) {
                foreach ($item->lot_list as $key => $lotNumber) {

                    $table = (new PtinvOnhandQuantitiesV)->getTable();
                    $onhand = collect(DB::select("
                        SELECT sum(onhand_quantity) TRANSACTION_QUANTITY, primary_unit_of_measure
                        from    $table
                        where   organization_id = $item->organization_id
                        and     item_number = '$item->item_number'
                        and     lot_number = '$lotNumber->value'
                        and     TRUNC(nvl(expiration_date, sysdate) ) >= TRUNC(sysdate)
                        group by organization_id, item_number, lot_number, primary_unit_of_measure
                    "));

                    $onhandList["lot-$lotNumber->value"] = (object)[
                        'onhand_quantity' => optional($onhand->first())->transaction_quantity ?? 0,
                        'primary_unit_of_measure' => optional($onhand->first())->primary_unit_of_measure ?? '',
                    ];
                }
            }
            $item->onhand_list = (object)$onhandList;
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

        $lines = data_get($request->header, 'lines');
        if (count($lines) == 0) {
            throw new \Exception('ไม่พบข้อมูล');
        }
        $lines = collect($lines);
        $lines = $lines->where('is_select', true);
        if (count($lines) == 0) {
            throw new \Exception('โปรดเลือกรายการอย่างน้อย 1 รายการ');
        }

        $firstLine = (object) $lines->first();
        if ( (data_get($firstLine, 'instead_item_id', '') == '' || is_null(data_get($firstLine, 'instead_item_id', null))) && $firstLine->for_delete == false ) {
            throw new \Exception('โปรดเลือก แทนด้วยรหัสใบยา');
        }

        foreach ($lines as $key => $line) {
            $line = (object) $line;
            if ($line->for_delete == false) {
                if ($line->old_ingredient_proportions === '') {
                    throw new \Exception("โปรดระบุ สัดส่่วนเดิม(%) (Blend: {$line->blend_no}, รหัสใบยา: {$line->item_code})");
                }
                if ($line->instead_ingredient_proportions === '') {
                    throw new \Exception("โปรดระบุ สัดส่วนใหม่(%) (Blend: {$line->blend_no}, รหัสใบยา: {$line->item_code})");
                }

                if ($line->old_ingredient_proportions < 0) {
                    throw new \Exception("โปรดระบุ สัดส่่วนเดิม(%) มากกว่า 0 (Blend: {$line->blend_no}, รหัสใบยา: {$line->item_code})");
                }
                if ($line->instead_ingredient_proportions < 0) {
                    throw new \Exception("โปรดระบุ สัดส่วนใหม่(%) มากกว่า 0 (Blend: {$line->blend_no}, รหัสใบยา: {$line->item_code})");
                }

                $sumIngredientProportion = $line->old_ingredient_proportions + $line->instead_ingredient_proportions;
                if (number_format($sumIngredientProportion, 5)  != number_format($line->ingredient_proportions, 5)) {
                    throw new \Exception("โปรดระบุ ยอดรวมสัดส่วนเดิม(%) และ สัดส่วนเดิม(%) ไม่เท่ากับสัดส่วนในสูตร(%)  (Blend: {$line->blend_no}, รหัสใบยา: {$line->item_code})");
                }
            }
        }

        $tobaccoTypeDesc = false;
        $tobaccoTypeDescReq = data_get($request->form, 'tobacco_type_desc');
        if ($tobaccoTypeDescReq) {
            $tobaccoTypeDesc = collect(DB::select("
                SELECT  tobacco_type_desc -- ประเภทยาเส้น
                        , tobacco_organization_id
                        , tobacco_organization_code
                FROM    PTPD_TOBACCO_TYPE_V
                WHERE  1=1
                AND     tobacco_organization_id = '{$profile->organization_id}'
                AND     tobacco_type_desc = '$tobaccoTypeDescReq'
            "))->first();
        }

        $categoryCode1 = false;
        $categoryCode1Req = data_get($request->form, 'category_code_1');
        if ($categoryCode1Req) {
            $categoryCode1 = collect(DB::select("
                SELECT  category_code_1 -- ประเภทใบยา
                        , category_desc_1
                FROM    PTPD_MEDICINAL_LEAF_TYPE_H_V
                WHERE  1=1
                AND     category_code_1 = '$categoryCode1Req'
            "))->first();
        }

        $categoryCode2 = false;
        $categoryCode2Req = data_get($request->form, 'category_code_2');
        if ($categoryCode2Req) {
            $categoryCode2 = collect(DB::select("
                SELECT  category_code_2 -- ชนิดใบยา
                        , category_desc_2
                FROM    PTPD_MEDICINAL_LEAF_TYPE_L_V
                WHERE  1=1
                AND     category_code_2 = '$categoryCode2Req'
            "))->first();
        }


        $header = new PtpdMedicinalLeafHT;
        $isDelete = false;
        if ($tobaccoTypeDesc) {
            $header->tobacco_type_desc          = $tobaccoTypeDesc->tobacco_type_desc;
            $header->tobacco_organization_id    = $tobaccoTypeDesc->tobacco_organization_id;
            $header->tobacco_organization_code  = $tobaccoTypeDesc->tobacco_organization_code;
        }
        if ($categoryCode1) {
            $header->category_code_1            = $categoryCode1->category_code_1;
            $header->category_desc_1            = $categoryCode1->category_desc_1;
        }
        if ($categoryCode2) {
            $header->category_code_2            = $categoryCode2->category_code_2;
            $header->category_desc_2            = $categoryCode2->category_desc_2;
        }
        $header->organization_id            = $profile->organization_id;
        $header->item_code                  = $firstLine->item_code;
        $header->item_desc                  = $firstLine->item_desc;
        $header->instead_item_id            = data_get($firstLine, 'instead_item_id', ''); //$firstLine->instead_item_id;
        $header->instead_item_code          = data_get($firstLine, 'instead_item_code', ''); //$firstLine->instead_item_code;
        $header->instead_item_desc          = data_get($firstLine, 'instead_item_desc', ''); //$firstLine->instead_item_desc;

        $header->instead_approval_date  = data_get($request->form, 'approved_date');
        $header->web_status         = 'CREATE';
        $header->created_by         = $profile->fnd_user_id;
        $header->created_by_id      = $profile->user_id;
        $header->created_at         = $sysdate;
        $header->creation_date      = $sysdate;
        $header->program_code       = $profile->program_code;

        $header->updated_by_id      = $profile->user_id;
        $header->last_updated_by    = $profile->fnd_user_id;
        $header->updated_at         = $sysdate;
        $header->last_update_date   = $sysdate;
        $header->web_batch_no       = now()->format("YmdHisu");
        $header->save();

        $header->refresh();
        foreach ($lines as $key => $line) {
            $line = (object) $line;
            $newLine = new PtpdMedicinalLeafLT;
            $newLine->web_h_id          = $header->web_h_id;

            $newLine->instead_of_flag   = 'Y';
            $newLine->formula_status    = data_get($line, 'formula_status', ''); // $line->formula_status;
            $newLine->blend_no          = data_get($line, 'blend_no', ''); // $line->blend_no;
            $newLine->formula_id        = data_get($line, 'formula_id', ''); // $line->formula_id;
            $newLine->formula_no        = data_get($line, 'formula_no', ''); // $line->formula_no;
            $newLine->formulaline_id    = data_get($line, 'formulaline_id', ''); // $line->formulaline_id;
            $newLine->line_type         = data_get($line, 'line_type', ''); // $line->line_type;
            $newLine->line_no           = data_get($line, 'line_no', ''); // $line->line_no;
            $newLine->organization_id   = data_get($line, 'organization_id', ''); // $line->organization_id;
            $newLine->organization_code = data_get($line, 'organization_code', ''); // $line->organization_code;
            $newLine->item_id           = data_get($line, 'item_id', ''); // $line->item_id;
            $newLine->item_code         = data_get($line, 'item_code', ''); // $line->item_code;
            $newLine->item_desc         = data_get($line, 'item_desc', ''); // $line->item_desc;
            $newLine->qty               = data_get($line, 'qty', ''); // $line->qty;
            $newLine->detail_uom        = data_get($line, 'detail_uom', ''); // $line->detail_uom;
            $newLine->leaf_proportion   = data_get($line, 'leaf_proportion', ''); // $line->leaf_proportion;
            $newLine->ingredient_proportions = data_get($line, 'ingredient_proportions', ''); // $line->ingredient_proportions;
            $newLine->lot_number        = data_get($line, 'lot_number', ''); // $line->lot_number;
            $newLine->old_ingredient_proportions = data_get($line, 'old_ingredient_proportions', ''); // $line->old_ingredient_proportions;
            $newLine->leaf_formula      = data_get($line, 'leaf_formula', ''); // $line->leaf_formula;
            $newLine->leaf_formula_desc = data_get($line, 'leaf_formula_desc', ''); // $line->leaf_formula_desc;
            $newLine->ingredients_group = data_get($line, 'ingredients_group', ''); // $line->ingredients_group;
            $newLine->instead_item_id   = data_get($line, 'instead_item_id', ''); // $line->instead_item_id;
            $newLine->instead_item_code = data_get($line, 'instead_item_code', ''); // $line->instead_item_code;
            $newLine->instead_item_desc = data_get($line, 'instead_item_desc', ''); // $line->instead_item_desc;
            $newLine->instead_ingredient_proportions = data_get($line, 'instead_ingredient_proportions', ''); // $line->instead_ingredient_proportions;
            $newLine->instead_lot_number = data_get($line, 'instead_lot_number', ''); // $line->instead_lot_number;
            $newLine->formula_vers      = data_get($line, 'formula_vers', ''); // $line->formula_vers;

            $newLine->instead_leaf_formula      = data_get($line, 'instead_leaf_formula', ''); // $line->instead_leaf_formula;
            $newLine->instead_leaf_formula_desc = data_get($line, 'instead_leaf_formula_desc', ''); // $line->instead_leaf_formula_desc;
            $newLine->instead_ingredients_group = data_get($line, 'instead_ingredients_group', ''); // $line->instead_ingredients_group;
            $newLine->instead_leaf_proportion   = data_get($line, 'instead_leaf_proportion', ''); // $line->instead_leaf_proportion;

            $newLine->web_status         = 'CREATE';
            $newLine->web_status         = $line->for_delete ? 'DELETE' : $newLine->web_status;
            $newLine->created_by         = $header->created_by;
            $newLine->created_by_id      = $header->created_by_id;
            $newLine->created_at         = $header->created_at;
            $newLine->creation_date      = $header->creation_date;
            $newLine->program_code       = $header->program_code;

            $newLine->updated_by_id      = $header->updated_by_id;
            $newLine->last_updated_by    = $header->last_updated_by;
            $newLine->updated_at         = $header->updated_at;
            $newLine->last_update_date   = $header->last_update_date;
            $newLine->web_batch_no       = $header->web_batch_no;
            $newLine->save();

            if ($newLine->web_status == 'DELETE') {
                $isDelete = true;
            }
        }

        if ($isDelete) {
            $result = $this->interfaceDel($header);
            if ($result['status'] != 'S' && $result['status'] != 'C') {
                throw new \Exception($result['msg']);
            }
        } else {
            $result = $this->interface($header);
            if ($result['status'] != 'S' && $result['status'] != 'C') {
                throw new \Exception($result['msg']);
            }
        }
        return $header;
    }

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

    function interface(PtpdMedicinalLeafHT $header)
    {
        $db     =   \DB::connection('oracle')->getPdo();
        $sql    =   "
            declare
                v_status   varchar2(1);
                v_msg      varchar2(4000);
            begin
                PTPD_MEDICINAL_LEAF_PKG.MAIN_IMORT(P_WEB_BATCH_NO  => '{$header->web_batch_no}'
                          ,P_INTERFACE_STATUS  => :v_status
                          ,P_INTERFACE_MSG     => :v_msg) ;

            end ;
        ";

        $header->interface_name = $sql;
        $header->save();
        \Log::info("{$header->web_batch_no} INF", [$sql]);
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':v_status', $result['status'], \PDO::PARAM_STR, 10);
        $stmt->bindParam(':v_msg', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        \Log::info("{$header->web_batch_no} INF", [$result]);

        return $result;
    }

    function interfaceDel(PtpdMedicinalLeafHT $header)
    {
        $db     =   \DB::connection('oracle')->getPdo();
        $sql    =   "
            declare
                v_status   varchar2(1);
                v_msg      varchar2(4000);
            begin
                PTPD_MEDICINAL_LEAF_PKG.DELETE_FORMULA_DETAIL(P_WEB_BATCH_NO  => '{$header->web_batch_no}'
                          ,P_INTERFACE_STATUS  => :v_status
                          ,P_INTERFACE_MSG     => :v_msg) ;

            end ;
        ";

        $header->interface_name = $sql;
        $header->save();
        \Log::info("{$header->web_batch_no} interfaceDel", [$sql]);
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':v_status', $result['status'], \PDO::PARAM_STR, 10);
        $stmt->bindParam(':v_msg', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        \Log::info("{$header->web_batch_no} interfaceDel", [$result]);

        return $result;
    }

    function getDataInfo($request, $header, $profile)
    {
        $budgetYearList = [];
        $table = (new PtpdBudgetYearV)->getTable();
        $budgetYearList = PtpdBudgetYearV::selectRaw("budget_year + 543 budget_year_th, {$table}.*")
                            ->orderBy('budget_year')
                            ->orderBy('budget_year_version')
                            ->get();

        $createInput = (object) [
            'def_budget_year'   => '',
            'def_version'       => '',
            'budget_year_list'  => $budgetYearList->groupBy('budget_year_th'),
        ];

        $searchInput = (object) [
            'def_budget_year'   => '',
            'def_version'       => '',
            'budget_year_list'  => $budgetYearList->groupBy('budget_year_th'),
        ];

        $data = (object)[];
        $data->create_input = $createInput;
        $data->search_input = $searchInput;
        $data->menu = getMenu($this::url);

        $header->lines = [];
        if ($header || true) {
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
        // data_set($can, 'leaf_formulas.leaf_formulas.ingredient.add_lot_number', true);
        // dd('zz', $can);

        // $lookupCode
        // 1   สูตรใช้จริง
        // 2   สูตรมาตรฐาน
        // 3   สูตรทดลอง

        if (strtoupper($status) == 'ACTIVE' || true) {
            if ($lookupCode == 1) {
                $can->leaf_formulas->ingredient->add_lot_number = true;
                $can->cigarettes->multi_cigarettes = true;
            }
        }

        // if ($this->wip_request_status) {

        //     switch ($this->wip_request_status) {
        //         case '1': // ยังไม่ส่งข้อมูล
        //             $can->edit = true;
        //             $can->transfer = true;
        //             $can->cancel_transfer = true;
        //             break;
        //         case '2': // บันทึกผลผลิตเข้าคลังเรียบร้อย
        //             if ($this->interface_status) {
        //                 $can->edit = false;
        //                 $can->transfer = false;
        //                 $can->cancel_transfer = false;
        //                 break;
        //             }
        //         case '3': // ยกเลิกการบันทึกผลผลิตเข้าคลัง
        //             $can->edit = false;
        //             $can->transfer = false;
        //             $can->cancel_transfer = false;
        //             break;
        //         case '4': // ยกเลิกใบส่งผลผลิตเข้าคลัง
        //             $can->edit = false;
        //             $can->transfer = false;
        //             $can->cancel_transfer = false;
        //             break;
        //     }
        // }


        return $can;
    }


    function getProfile($lookupCode = false)
    {
        $data = getDefaultData("/pd/substitute-tobaccos");
        return $data;
    }


    function interfaceImort($tmp)
    {
        $db     =   \DB::connection('oracle')->getPdo();
        $sql    =   "
            DECLARE
                V_STATUS    VARCHAR2(10);
                V_MSG       VARCHAR2(4000);
            BEGIN
                    PTPD_ADJ_SAL_FORECAST_PKG.MAIN_IMPORT(P_WEB_BATCH_NO        => '$tmp->web_batch_no'
                                                        , P_INTERFACE_STATUS    => :V_STATUS
                                                        , P_INTERFACE_MSG       => :V_MSG);

            END;
        ";

        $tmp->interface_name = $sql;
        $tmp->save();
        \Log::info("{$tmp->web_batch_no} INF", [$sql]);
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':V_STATUS', $result['status'], \PDO::PARAM_STR, 10);
        $stmt->bindParam(':V_MSG', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        \Log::info("{$tmp->web_batch_no} INF", [$result]);

        return $result;
    }

    function getData($request)
    {
        $type       = $request->type;
        $jsonNullable   = $this->getJsonNullable();
        $header         = json_decode($request->header ?? $jsonNullable);
        $profile        = $this->getProfile();

        $lines = PtpdMedicinalLeafLV::where('blend_no', 'MCR081-PD0011-001')
                    ->get();

        return [
            'lines' => $lines,
        ];
    }

    function searchBlendGetParam($request)
    {
        $blendNoReq = $request->blend_no;
        if ($blendNoReq) {
            $data = collect(DB::select("
                SELECT  distinct blend_no as value, blend_desc as label
                FROM    PTPD_BLEND_AND_CIGAR_V
                WHERE  1=1
                AND     blend_no like '%$blendNoReq%'
                order by blend_no
            "));
        } else {
            $data = collect(DB::select("
                SELECT  distinct blend_no as value, blend_desc as label
                FROM    PTPD_BLEND_AND_CIGAR_V
                WHERE  1=1
                order by blend_no
            "));
        }

        return [
            'blend_no_list' => $data,
        ];
    }

    function searchBlend($request)
    {
        $blendNoReq = $request->blend_no;
        if ($blendNoReq) {
            $data = collect(DB::select("
                SELECT  distinct cigar_item_code , cigar_item_desc
                FROM    PTPD_BLEND_AND_CIGAR_V
                WHERE  1=1
                AND     blend_no like '%$blendNoReq%'
                order by cigar_item_code
            "));
        } else {
            $data = collect(DB::select("
                SELECT  distinct cigar_item_code , cigar_item_desc
                FROM    PTPD_BLEND_AND_CIGAR_V
                WHERE  1=1
                order by cigar_item_code
            "));
        }


        return [
            'blend_no_list' => $data,
        ];
    }

    function searchBrandGetParam($request)
    {
        $blendNoReq = $request->blend_no;
        if ($blendNoReq) {
            $data = collect(DB::select("
                SELECT  distinct cigar_item_code as value, cigar_item_desc as label
                FROM    PTPD_BLEND_AND_CIGAR_V
                WHERE  1=1
                AND     cigar_item_code like '%$blendNoReq%'
                order by cigar_item_code
            "));
        } else {
            $data = collect(DB::select("
                SELECT  distinct cigar_item_code as value, cigar_item_desc as label
                FROM    PTPD_BLEND_AND_CIGAR_V
                WHERE  1=1
                order by cigar_item_code
            "));
        }

        return [
            'brand_no_list' => $data,
        ];
    }

    function searchBrand($request)
    {
        $brandNoReq = $request->brand_no;
        if ($brandNoReq) {
            $data = collect(DB::select("
                SELECT  distinct blend_no , blend_desc
                FROM    PTPD_BLEND_AND_CIGAR_V
                WHERE  1=1
                AND     cigar_item_code like '%$brandNoReq%'
                order by blend_no
            "));
        } else {
            $data = collect(DB::select("
                SELECT  distinct blend_no , blend_desc
                FROM    PTPD_BLEND_AND_CIGAR_V
                WHERE  1=1
                order by blend_no
            "));
        }

        return [
            'brand_no_list' => $data,
        ];
    }
}
