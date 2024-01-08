<?php
namespace App\Repositories\PM;

use Illuminate\Database\Eloquent\Collection;

use App\Models\PM\PtpmRequestHeader;
use App\Models\PM\PtpmRequestLine;
use App\Models\PM\PtpmMfgFormulaV;
use App\Models\PM\PtpmItemNumberV;
use App\Models\PM\PtpmSetupMfgDepartmentsV;
use App\Models\PM\Lookup\PtinvOnhandQuantitiesV;
use App\Models\PD\Lookup\MtlUnitsOfMeasureVl;
use App\Models\PM\Lookup\PtpmItemConvUomV;
use App\Models\PM\PtpmSetupTransferLocV;
use App\Models\PM\PtpmItemcatRequestSeg2;
use App\Models\PM\PtInvUomV;

use App\Models\PM\PtpmItemCatByOrgV;
use App\Models\PM\Settings\ItemCategorys;
use App\Models\PM\Settings\SetupTransferLocations;

use App\Models\PM\Lookup\PtpmObjectiveRequest;

use DB;

class MaterialRequestRepository
{

    const url = '/pm/material-requests';

    function search($request)
    {
        // $requestNumber = strtolower(request()->request_number);
        // $attribute2 = strtolower(request()->attribute2);
        // $requestDateFmFormat = request()->request_date_fm_format ?? false;
        // $requestDateToFormat = request()->request_date_to_format ?? false;
        // $requestStatus = request()->request_status ?? false;


        $fromTransactionDate = $request->from_transaction_date ?? false;
        $toTransactionDate = $request->to_transaction_date ?? false;
        $requestStatus = $request->request_status ?? false;
        $objectiveCode = $request->objective_code ?? false;
        $attribute2 = $request->attribute2 ?? 1;
        $wipReqHeaderId = $request->request_header_id ?? false;
        $inventoryItemId = $request->inventory_item_id ?? false;
        $profile = getDefaultData($this::url);

        $headers = PtpmRequestHeader::with([
                            'status:lookup_code,description'
                        ])
                        // ->when($requestNumber, function($q) use($requestNumber) {
                        //     $q->whereRaw("LOWER(request_number) like '%{$requestNumber}%'");
                        // })
                        // ->when($requestDateFmFormat, function($q) use($requestDateFmFormat) {
                        //     $q->whereDate("request_date", '>=', parseFromDateTh($requestDateFmFormat));
                        // })
                        // ->when($requestDateToFormat, function($q) use($requestDateToFormat) {
                        //     $q->whereDate("request_date", '<=', parseFromDateTh($requestDateToFormat));
                        // })
                        // ->when($attribute2, function($q) use($attribute2) {
                        //     $q->where("attribute2", $attribute2);
                        // })
                        // ->when($requestStatus, function($q) use($requestStatus) {
                        //     $q->where("request_status", $requestStatus);
                        // })
                        ->when($wipReqHeaderId, function($q) use($wipReqHeaderId) {
                            $q->where("request_header_id", $wipReqHeaderId);
                        })
                        ->when($fromTransactionDate, function($q) use($fromTransactionDate) {
                            $fromTransactionDate = parseFromDateTh($fromTransactionDate);
                            $q->whereRaw("TRUNC(request_date) >= '{$fromTransactionDate}'");
                        })
                        ->when($toTransactionDate, function($q) use($toTransactionDate) {
                            $toTransactionDate = parseFromDateTh($toTransactionDate);
                            $q->whereRaw("TRUNC(request_date) <= '{$toTransactionDate}'");
                        })
                        ->when($requestStatus, function($q) use($requestStatus) {
                            $q->where("request_status", $requestStatus);
                        })
                        ->when($objectiveCode, function($q) use($objectiveCode) {
                            $q->where("objective_code", $objectiveCode);
                        })
                        ->when($inventoryItemId, function($q) use($inventoryItemId) {
                            $q->where("inventory_item_id", $inventoryItemId);
                        })
                        ->where('organization_id', $profile->organization_id)
                        ->orderBy('request_number', 'desc')
                        ->limit(50)
                        ->get();

        $headers = $headers->map(function ($row) {
            $row->show_url = route('pm.material-requests.index', ['request_header_id' => $row->request_header_id]);
            return $row;
        });
        return $headers;
    }

    function searchGetParam($request)
    {
        $fromTransactionDate = $request->from_transaction_date ?? '';
        $toTransactionDate = $request->to_transaction_date ?? '';
        $requestStatus = $request->request_status ?? '';
        $objectiveCode = $request->objective_code ?? '';
        $attribute2 = $request->attribute2 ?? 1;
        $inventoryItemId = $request->inventory_item_id ?? false;
        $requestHeaderId = $request->request_header_id ?? '';
        $attribute3OrIngredientGroup = $request->attribute3_or_ingredient_group ?? ''; // ประเภทวัตถุดิบ

        $requestStatusData = [];
        $objectData = [];
        $itemData = [];
        $itemData = [];

        $attribute3 = [];
        $ingredientGroup = [];

        $profile = getDefaultData($this::url);

        $headers = PtpmRequestHeader::selectRaw("
                        request_status,
                        objective_code,
                        inventory_item_id,
                        attribute3,
                        send_date,
                        ingredient_group,
                        request_header_id as value,
                        request_number as label
                    ")
                    ->where('organization_id', $profile->organization_id)
                    ->where('attribute2', $attribute2)
                    ->orderBy('request_date', 'desc');


        if ($fromTransactionDate || $toTransactionDate || $requestStatus || $objectiveCode || $inventoryItemId) {

            if ($fromTransactionDate) {
                $fromTransactionDate = parseFromDateTh($fromTransactionDate);
            }

            if ($toTransactionDate) {
                $toTransactionDate = parseFromDateTh($toTransactionDate);
            }
            $headers = $headers->when($fromTransactionDate, function($q) use($fromTransactionDate) {
                        $q->whereRaw("TRUNC(request_date) >= '{$fromTransactionDate}'");
                    })
                    ->when($toTransactionDate, function($q) use($toTransactionDate) {
                        $q->whereRaw("TRUNC(request_date) <= '{$toTransactionDate}'");
                    })
                    ->when($requestStatus, function($q) use($requestStatus) {
                        $q->where("request_status", $requestStatus);
                    })
                    ->when($objectiveCode, function($q) use($objectiveCode) {
                        $q->where("objective_code", $objectiveCode);
                    })
                    ->when($inventoryItemId, function($q) use($inventoryItemId) {
                        $q->where("inventory_item_id", $inventoryItemId);
                    })
                    ->when($requestHeaderId, function($q) use($requestHeaderId) {
                        $q->where("request_header_id", $requestHeaderId);
                    })
                    ->when($attribute3OrIngredientGroup != '', function($q) use($attribute3OrIngredientGroup) {
                        $q->whereRaw("
                            (attribute3 = '$attribute3OrIngredientGroup' or ingredient_group = '$attribute3OrIngredientGroup')
                        ");
                    })
                    ->get();

            if (count($headers)) {
                $requestStatusData = $headers->pluck('request_status', 'request_status')->all();
                $objectData = $headers->pluck('objective_code', 'objective_code')->all();
                $itemData = $headers->pluck('inventory_item_id', 'inventory_item_id')->all();

                $attribute3 = $headers->pluck('attribute3', 'attribute3')->all();
                $ingredientGroup = $headers->pluck('ingredient_group', 'ingredient_group')->all();
            }
        } else {
            $headers = $headers->limit(50)->get();
        }

        $attribute3Data = collect([]);
        if (count($attribute3)) {
            $getItemCatCodeList = $this->getItemCatCodeList($profile, collect([]), $case = 1, false, $allList = true); // list ประเภทวัตถุดิบ: เบิกวัสดุสินเปลือง
            $getItemCatForProdList = $this->getItemCatForProdList($profile, collect([]), $case = 1, false, $allList = true);//list ประเภทวัตถุดิบ: เบิกเพื่อทดลอง

            if (count($getItemCatCodeList)) {
                $getItemCatCodeList = $getItemCatCodeList->whereIn('item_cat_code', $attribute3);
            }
            if (count($getItemCatForProdList)) {
                $getItemCatForProdList = $getItemCatForProdList->whereIn('item_cat_code', $attribute3);
            }

            $attribute3Data = $attribute3Data->merge($getItemCatCodeList);
            $attribute3Data = $attribute3Data->merge($getItemCatForProdList);
        }

        if (count($ingredientGroup)) {
            $ingredientGroupList = DB::connection('oracle')
                                        ->table("OAPM.PTPM_ITEM_CLASSIFICATIONS_V")
                                        ->selectRaw("
                                            ITEM_CLASSIFICATION_CODE        item_cat_code,
                                            ITEM_CLASSIFICATION             item_cat_desc
                                        ")
                                        ->whereIn('ITEM_CLASSIFICATION_CODE', $ingredientGroup)
                                        ->groupByRaw("ITEM_CLASSIFICATION_CODE, ITEM_CLASSIFICATION")
                                        ->get();
            if (count($ingredientGroupList)) {
                $attribute3Data = $attribute3Data->merge($ingredientGroupList);
            }
        }

        $statusData = \App\Models\PM\Lookup\PtpmRequestTransferStatus::select([
                        'LOOKUP_CODE as value',
                        'DESCRIPTION as label'
                        ])
                        ->when(count($requestStatusData), function($q) use($requestStatusData) {
                            $q->whereIn("LOOKUP_CODE", $requestStatusData);
                        })
                        // ->active()
                        ->get();

        $objData = PtpmObjectiveRequest::select([
                        'LOOKUP_CODE as value',
                        'DESCRIPTION as label'
                        ])
                        ->when(count($objectData), function($q) use($objectData) {
                            $q->whereIn("LOOKUP_CODE", $objectData);
                        })
                        // ->active()
                        ->get();

        $items = [];
        if (count($itemData)) {
            $items = PtpmItemNumberV::selectRaw("
                        distinct inventory_item_id as value
                        , item_number || ' : ' || item_desc as label
                    ")
                    ->when(count($itemData), function($q) use($itemData) {
                        $q->whereIn("inventory_item_id", $itemData);
                    })
                    ->orderBy("label")
                    ->get();
        }


        $statusList[] = [ 'value' => '', 'label' => 'ท้ังหมด' ];
        if (count($statusData)) {
            $statusList = array_merge($statusList, $statusData->toArray());
        }
        $objList[] = [ 'value' => '', 'label' => 'ท้ังหมด' ];
        if (count($objData)) {
            $objList = array_merge($objList, $objData->toArray());
        }
        $headerIdList[] = [ 'value' => '', 'label' => 'ท้ังหมด' ];
        if (count($headers)) {
            $headerIdList = array_merge($headerIdList, $headers->toArray());
        }
        $itemList[] = [ 'value' => '', 'label' => 'ท้ังหมด' ];
        if (count($items)) {
            $itemList = array_merge($itemList, $items->toArray());
        }

        $attribute3OrIngredientGroupList[] = [ 'value' => '', 'label' => 'ท้ังหมด' ];
        if (count($attribute3Data)) {
            foreach ($attribute3Data as $key => $line) {
                $line->value = $line->item_cat_code;
                $line->label = $line->item_cat_desc;
            }
            $attribute3Data = $attribute3Data->sortBy('label');
            $attribute3OrIngredientGroupList = array_merge($attribute3OrIngredientGroupList, $attribute3Data->toArray());
        }
        return [
            'request_status_list' => $statusList,
            'objective_code_list' => $objList,
            'request_header_id_list' => $headerIdList,
            'inventory_item_id_list' => $itemList,
            'attribute3_or_ingredient_group_list' => $attribute3OrIngredientGroupList,
        ];
    }

    function lines($request)
    {
        // array:5 [▼
        //   "blend_no" => "EX2"
        //   "inventory_item_id" => "11076"
        //   "ingredient_group" => "01"
        //   "type_code" => "0100"
        //   "objective_code" => "1"
        // ]

        $materialRequestRepo = new self;
        $profile        = getDefaultData($this::url);
        $organizationId = $profile->organization_id;
        $headerId       = $request->request_header_id ?? false;
        $header         = new PtpmRequestHeader;
        $header->objective_code = $request->objective_code;
        $header->work_step = $request->work_step;
        $header->attribute3 = $request->item_cat_code;
        $header->attribute2 = $request->case ?? 1;
        $header->attribute1 = $request->product_uom_code;

        if ($headerId) {
            $header = PtpmRequestHeader::find($headerId);
            $organizationId = $header->organization_id;
            if ($request->action == 'search') {
                $hasChange = false;
                if ($header->inventory_item_id != $request->inventory_item_id) {
                    $header->inventory_item_id = $request->inventory_item_id;
                    $hasChange = true;
                }

                if ($header->ingredient_group != $request->ingredient_group) {
                    $header->ingredient_group = $request->ingredient_group;
                    $hasChange = true;
                }

                if ($header->work_step != $request->work_step) {
                    $header->work_step = $request->work_step;
                    $hasChange = true;
                }

                if ($header->objective_code != $request->objective_code) {
                    $header->objective_code = $request->objective_code;
                    $hasChange = true;
                }
                if ($header->attribute3 != $request->item_cat_code) {
                    $header->attribute3 = $request->item_cat_code;
                    $hasChange = true;
                }
                if ($header->attribute1 != $request->product_uom_code) {
                    $header->attribute1 = $request->product_uom_code;
                    $hasChange = true;
                }

                if ($hasChange) {
                    $header->save();
                    PtpmRequestLine::where('request_header_id', $headerId)->delete();
                }
            }
        }

        // $headerId   = 79;
        // $setupMfgDept = PtpmSetupMfgDepartmentsV::where('department_code', $profile->department_code)
        //                     ->get();

        $items = [];
        if ($request->inventory_item_id && $header->can->edit) {
            $items = PtpmMfgFormulaV::with(['uom'])
                        ->where('organization_id', $organizationId)
                        ->when($request->inventory_item_id, function($q) use($request) {
                            $q->where('product_item_id', $request->inventory_item_id);
                        })
                        ->when($request->ingredient_group, function($q) use($request) {
                            $q->where('item_classification_code', $request->ingredient_group);
                        })
                        ->when($header->work_step, function($q) use($header) {
                            $q->where('oprn_no', $header->work_step);
                        })
                        ->when($header->is_other_objective, function($q) use($header) {
                            $q->where('item_cat_code', $header->attribute3);
                        })
                        ->when($header->attribute1, function($q) use($header) {
                            $q->where('product_detail_uom', $header->attribute1);
                        })
                        ->when($header->attribute2 == 1, function($q) use ($organizationId) {
                            $itemCate = $this->getFilterItemCat($organizationId);
                            $q->where('product_flag', 'Y');
                            if (count($itemCate)) {
                                $q->whereIn('item_cat_code', $itemCate);
                            }
                        })
                        ->when($header->attribute2 == 2, function($q) {
                            $exceptItemCate = $this->getExceptItemCate();
                            if (count($exceptItemCate)) {
                                $q->whereNotIn('item_cat_code', $exceptItemCate);
                            }
                            $q->where('receipe_type_code', 1); //สูตรใช้จริง
                        })
                        ->joinSetupMfgDept($profile->department_code, $header->attribute2)
                        // ->where('inventory_item_id', 19700)
                        // ->whereIn('item_number', ['1080RCT/KOREA', '100730EL'])
                        // ->where('item_number', '100300001')
                        // ->where('item_number', '100700001')
                        // item_number: "100300001",
                        ->get();
                        // ->toSql();
        // dd('x222x', $organizationId, $request->inventory_item_id, $header->attribute1, $items);
        // dd('x222x', $items->first()->toArray());
        }

        $requestLines   = PtpmRequestLine::where('request_header_id', $headerId)->get();
        if ($header->attribute2 == 1) {
            if (count($items) > 0) {
                $items = $items->where('recipe_version', $items->max('recipe_version'));
            }
            if ($items) {
                $items = $items->groupBy('group_key')->mapWithKeys(function ($item, $group) {
                    $sumRequireQty = $item->whereNotNull('require_qty')->sum('require_qty');
                    $sumRatioRequirePerUnit = number_format($item->whereNotNull('require_qty')->sum('ratio_require_per_unit'), 9);

                    $firstList = clone $item->first();
                    $firstList->require_qty = $sumRequireQty;
                    $firstList->ratio_require_per_unit = $sumRatioRequirePerUnit;


                    $itemMaster = PtpmItemNumberV::select(['primary_uom_code'])
                                    ->where('organization_id', $firstList->organization_id)
                                    ->where('inventory_item_id', $firstList->inventory_item_id)
                                    ->first();
                    $converUom = optional($itemMaster)->primary_uom_code ?? '';
                    if ($firstList->detail_uom != $converUom) {
                        $rateList = $this->getSecUomList((object)[
                                        'inventory_item_id' => $firstList->inventory_item_id,
                                        'organization_id' => $firstList->organization_id,
                                        'to_uom_code' => $converUom,
                                    ]);
                        $rateList = optional($rateList)->where('from_uom_code', $firstList->detail_uom) ?? [];


                        if (count($rateList)) {
                            $rateList = $rateList->first();
                            $conversionRate = $rateList->conversion_rate;
                            $firstList->require_qty = $firstList->require_qty * $rateList->conversion_rate;
                            $firstList->ratio_require_per_unit = $firstList->ratio_require_per_unit * $rateList->conversion_rate;
                            $firstList->detail_uom = $converUom;
                        }
                    }

                    return [$group => $firstList];
                });
                $items = $items->sortBy('item_desc')->values();
            }
        }

        if ($header->attribute2 == 2) {
            if ($items) {
                $items = $items->groupBy('group_key')->mapWithKeys(function ($item, $group) {
                    $sumRequireQty = $item->whereNotNull('require_qty')->max('require_qty');
                    $sumRatioRequirePerUnit = $item->whereNotNull('require_qty')->max('ratio_require_per_unit');

                    $firstList = clone $item->first();
                    $firstList->require_qty = $sumRequireQty;
                    $firstList->ratio_require_per_unit = $sumRatioRequirePerUnit;

                    $converUom = $firstList->product_uom_code;
                    $itemMaster = PtpmItemNumberV::select(['primary_uom_code'])
                                    ->where('organization_id', $firstList->organization_id)
                                    ->where('inventory_item_id', $firstList->inventory_item_id)
                                    ->first();
                    $converUom = optional($itemMaster)->primary_uom_code ?? '';
                    if ($firstList->detail_uom != $converUom) {
                        $rateList = $this->getSecUomList((object)[
                                        'inventory_item_id' => $firstList->inventory_item_id,
                                        'organization_id' => $firstList->organization_id,
                                        'to_uom_code' => $converUom,
                                    ]);
                        $rateList = optional($rateList)->where('from_uom_code', $firstList->detail_uom) ?? [];

                        // dd('x', $firstList->detail_uom, $converUom, $rateList);


                        if (count($rateList)) {
                            $rateList = $rateList->first();
                            $conversionRate = $rateList->conversion_rate;
                            $firstList->require_qty = $firstList->require_qty * $rateList->conversion_rate;
                            $firstList->ratio_require_per_unit = $firstList->ratio_require_per_unit * $rateList->conversion_rate;
                            $firstList->detail_uom = $converUom;
                        }
                    }

                    return [$group => $firstList];
                });
                $items = $items->sortBy('item_desc')->values();
            }
        }


        $lines = collect($items)->map(function ($row) use($requestLines, $materialRequestRepo) {
            $line = $materialRequestRepo->createLineData($row, 'NEW_ITEM_FORMULA');

            $requestLine = $requestLines->where('organization_id', $row->organization_id)
                            ->where('inventory_item_id', $row->inventory_item_id)
                            ->where('attribute9', $row->ratio_require_per_unit)
                            ->first();

            $line['work_step'] = $row->work_step;
            if (!is_null($requestLine)) {
                $line = $materialRequestRepo->createLineData($line, 'REFRESH', $requestLine);
            }

            return $line;
        });

        foreach ($requestLines as $key => $requestLine) {
            $checkLine = $lines->where('organization_id', $requestLine->organization_id)
                            ->where('inventory_item_id', $requestLine->inventory_item_id)
                            ->first();
            if (is_null($checkLine)) {
                $line = $materialRequestRepo->createLineData($requestLine, 'RequestLine');
                $lines->push($line);
            }
        }

        return $lines;
    }

    function setData($profile, $request)
    {
        $case = $request->case ?? 1;
        $headerId   = $request->request_header_id ?? '-1';
        $header = PtpmRequestHeader::find($headerId);
        if ($header) {
            $case = $header->attribute2;
        }
        //Blend No. สินค้าที่จะผลิต
        $blendNo = collect(DB::select("
            SELECT  BLEND_NO,    -- ลิสให้เลือก Blend No
                    ITEM_NUMBER,  -- ลิสให้เลือก สินค้าที่จะผลิต
                    ITEM_DESC,    -- รายละเอียดสินค้าที่จะผลิต ที่แสดงในหน้าจอ
                    INVENTORY_ITEM_ID,  -- save ลง table PTPM_REQUEST_HEADERS
                    PRIMARY_UOM_CODE,
                    ORGANIZATION_ID,
                    ITEM_CLASSIFICATION_CODE
                    --, PTPM_ITEM_NUMBER_V.*
            FROM    OAPM.PTPM_ITEM_NUMBER_V
            WHERE  BLEND_NO IS NOT NULL
            AND    ORGANIZATION_CODE = '{$profile->organization_code}'
            AND    TOBACCO_GROUP_CODE IS NOT NULL
            --and     INVENTORY_ITEM_ID = 10998
        "));


        $table = (new PtpmMfgFormulaV)->getTable();
        $blendNo = PtpmMfgFormulaV::selectRaw("
                        distinct
                        organization_code,
                        organization_id,
                        product_item_id     INVENTORY_ITEM_ID,
                        product_item_number ITEM_NUMBER,
                        product_item_desc   ITEM_DESC,
                        product_detail_uom  PRIMARY_UOM_CODE,
                        product_blend_no    BLEND_NO,
                        -- product_unit_of_measure,
                        (
                            select unit_of_measure
                            from ptinv_uom_v
                            where ptinv_uom_v.uom_code = ptpm_mfg_formula_v.product_detail_uom
                        ) as product_unit_of_measure,
                        product_item_number || ' : ' || product_item_desc as display
                    ")
                    ->where('organization_code', $profile->organization_code)
                    ->when($case == 1, function($q) {
                        $q->whereNotNull('product_blend_no')
                        ->where('product_flag', 'Y');
                    })
                    ->orderBy('display')
                    // ->where('product_item_id', 50174)
                    // ->where('product_item_id', 162017)
                    // ->where('product_detail_uom', 'CG')
                    // ->where('product_detail_uom', 'CGK')
                    ->get();
                    // ->toSql();

        // if ($case == 2) {
        //     //Blend No. สินค้าที่จะผลิต
        //     $blendNo = collect(DB::select("
        //         SELECT  BLEND_NO,    -- ลิสให้เลือก Blend No
        //                 ITEM_NUMBER,  -- ลิสให้เลือก สินค้าที่จะผลิต
        //                 ITEM_DESC,    -- รายละเอียดสินค้าที่จะผลิต ที่แสดงในหน้าจอ
        //                 INVENTORY_ITEM_ID,  -- save ลง table PTPM_REQUEST_HEADERS
        //                 PRIMARY_UOM_CODE,
        //                 ORGANIZATION_ID,
        //                 ITEM_CLASSIFICATION_CODE
        //                 --, PTPM_ITEM_NUMBER_V.*
        //         FROM    OAPM.PTPM_ITEM_NUMBER_V
        //         WHERE  1=1
        //         AND    ORGANIZATION_CODE = '{$profile->organization_code}'
        //         AND    TOBACCO_GROUP_CODE IS NOT NULL
        //     "));
        // }

        if (count($blendNo)) {
            $blendNo = collect($blendNo)->map(function ($row) use($request, $case) {
                $secUomList = $this->getSecUomList((object)[
                                'inventory_item_id' => $row->inventory_item_id,
                                'organization_id' => $row->organization_id,
                                'to_uom_code' => $row->primary_uom_code,
                            ]);
                $row->secondary_uom_list = $secUomList;
                $row->work_step_list = [];
                if ($case == 2) {

                    $workSteps = PtpmMfgFormulaV::selectRaw("distinct oprn_no, oprn_desc")
                        ->where('organization_id', $row->organization_id)
                        ->where('product_item_id', $row->inventory_item_id)
                        ->when($row->item_classification_code, function($q) use($row) {
                            $q->where('item_classification_code', $row->item_classification_code);
                        })
                        ->orderBy('oprn_no')
                        ->get();
                    $row->work_step_list = $workSteps;
                }

                return $row;
            });
        }
        //ประเภทวัตถุดิบ
        $ingredientGroupList = collect(DB::select("
            SELECT  ITEM_CLASSIFICATION_CODE,    -- save
                    ITEM_CLASSIFICATION          -- display
            FROM    OAPM.PTPM_ITEM_CLASSIFICATIONS_V
        "));

        // objective_code: 3 การเบิกวัสดุสินเปลือย หรือ อื่น ประเภทวัตถุดิบ เก็บที่ header.attribute2
        $itemCatCodeList = $this->getItemCatCodeList($profile, $request, $case, $header);

        $columns = ['organization_id', 'item_cat_code', 'item_cat_desc'];
        $tableItemCate = (new PtpmItemCatByOrgV)->getTable();
        $tableFormula = (new PtpmMfgFormulaV)->getTable();
        $itemCatForProdList = PtpmItemCatByOrgV::select($columns)->groupBy($columns)
                                ->where('organization_id', $profile->organization_id)
                                ->whereNotExists(function($query) use ($tableItemCate, $tableFormula) {
                                    $query->select(\DB::raw(1))
                                        ->from($tableFormula)
                                        ->whereRaw("
                                            {$tableFormula}.organization_id = {$tableItemCate}.organization_id
                                            and {$tableFormula}.product_item_cat_code = {$tableItemCate}.item_cat_code
                                        ");
                                })
                                ->when($case == 2, function($q) {
                                    $exceptItemCate = $this->getExceptItemCate();
                                    if (count($exceptItemCate)) {
                                        $q->whereNotIn('item_cat_code', $exceptItemCate);
                                    }
                                })
                                ->orderBy('item_cat_desc')
                                ->get();
                                // ->toSql();
        // dd('xx', $this->getExceptItemCate(), $itemCatForProdList);
        //วัตถุประสงค์ในการเบิก
        $objectiveCodeList = collect(DB::select("
            SELECT  LOOKUP_CODE,          -- save
                    MEANING,              -- display ยกเลิกแล้ว เปลี่ยนไปใช้ DESCRIPTION แทน
                    DESCRIPTION           -- display
            FROM    OAPM.PTPM_OBJECTIVE_REQUEST
            WHERE   ENABLED_FLAG   =  'Y'
        "));

        //สถานะขอเบิก
        $requestStatusList = collect(DB::select("
            SELECT  LOOKUP_CODE,    -- save
                    DESCRIPTION    -- display
            FROM    OAPM.PTPM_REQUEST_TRANSFER_STATUS
            WHERE   ENABLED_FLAG    =  'Y'
            order by LOOKUP_CODE
        "));

        //tag
        $typeCodeList = collect(DB::select("
            SELECT      PTIS2.TYPE_CODE,            -- save
                        PTIS2.TYPE_DESC,            -- display
                        PTIS2.REQUEST_MAT_FLAG,
                        PTIS1.ITEM_CLASSIFICATION
            FROM        TOAT.PTPM_TOBACCO_ITEMCAT_SEG1_V PTIS1,
                        TOAT.PTPM_TOBACCO_ITEMCAT_SEG2_V PTIS2
            WHERE       PTIS1.GROUP_CODE            = PTIS2.GROUP_CODE
            AND         PTIS1.ITEM_CLASSIFICATION   = '01'
            AND         PTIS2.REQUEST_MAT_FLAG      = 'Y'
            AND         PTIS1.REQUEST_MAT_FLAG      = 'Y'
            GROUP BY    PTIS1.ITEM_CLASSIFICATION,
                        PTIS2.TYPE_CODE,
                        PTIS2.TYPE_DESC,
                        PTIS2.REQUEST_MAT_FLAG
            -- ORDER BY    PTIS2.TYPE_CODE;
        "));

        $typeCodeList2 = collect(DB::select("
            SELECT DISTINCT
                    TOBACCO_INGRIDENT_TYPE TYPE_CODE,
                    TOBACCO_INGRIDENT_TYPE TYPE_DESC,
                    ITEM_CLASSIFICATION_CODE ITEM_CLASSIFICATION
            FROM PTPM_MFG_FORMULA_V
            WHERE   1=1
            AND     ORGANIZATION_CODE = 'M02'
            AND     ITEM_CLASSIFICATION_CODE = '02'
            AND     TOBACCO_INGRIDENT_TYPE IS NOT NULL
        "));

        $typeCodeList2 = $typeCodeList2->map(function ($row) {
            if (strtoupper($row->type_desc) == 'FLAVOR') {
                $row->type_desc = 'สารหอม';
            } else if (strtoupper($row->type_desc) == 'CASING') {
                $row->type_desc = 'สารปรุง';
            }

            return $row;
        });

        $typeCodeList = $typeCodeList->merge($typeCodeList2);

        $dataInfo = (object)[];
        $dataInfo->blend_no_list = optional($blendNo)->pluck('blend_no', 'blend_no') ?? [];
        // $dataInfo->item_list = optional($blendNo)->groupBy('blend_no') ?? [];
        $dataInfo->item_list = $blendNo ?? [];
        $dataInfo->objective_code_list = $objectiveCodeList ?? [];
        $dataInfo->request_status_list = $requestStatusList ?? [];
        $dataInfo->type_code_list = $typeCodeList ? $typeCodeList->groupBy('item_classification') : [];
        $dataInfo->new_line = (new self)->createLineData([], 'NEW_LINE');

        // เบิกเพื่อผลิต
        $dataInfo->ingredient_group_list = $ingredientGroupList ?? [];
        // เบิกวัสดุสินเปลือง
        $dataInfo->item_cat_code_list = $itemCatCodeList ?? [];
        // เบิกเพื่อทดลอง
        // $dataInfo->item_cat_for_prod_list = $itemCatForProdList ?? [];
        $dataInfo->item_cat_for_prod_list = $this->getItemCatForProdList($profile, $request, $case, $header);

        if ($header) {
            if (!$header->created_by_id) {
                $profile = getDefaultData();
                $sysdate = now();
                $header->created_by         = $profile->fnd_user_id;
                $header->created_by_id      = $profile->user_id;
                $header->created_at         = $sysdate;
                $header->creation_date      = $sysdate;
                $header->request_type       = 1;
                $header->updated_by_id      = $profile->user_id;
                $header->last_updated_by    = $profile->fnd_user_id;

                $header->updated_at         = $sysdate;
                $header->last_update_date   = $sysdate;
                $header->save();
            }
        } else {
            $header = new PtpmRequestHeader();
            $can = $header->can;
            $organization = $header->organization;

            $requestStatusList = $dataInfo->request_status_list;
            $ingredientGroupList = $dataInfo->ingredient_group_list;
            $objectiveCodeList = $dataInfo->objective_code_list;

            $header = array_flip($header->getFillable());
            $header = (object) data_set($header, '*', '');
            $header->can                = $can;
            $header->organization       = $organization;
            $header->attribute2         = $request->case ?? 1;
            $header->request_status     = "1";
            $header->department_code    = $profile->department_code;
            $header->request_date_format= parseToDateTh(now());
            $header->send_date_format   = parseToDateTh(now());
            $header->blend_no           = '';
            $header->ingredient_group   = optional($ingredientGroupList->first())->item_classification_code ?? '';
            $header->objective_code     = optional($objectiveCodeList->first())->lookup_code ?? '';
            $header->case               = $case;
        }
        $header->blend_no           = '';
        $header->sysdate            = parseToDateTh(now());
        $header->type_code          = 'selectAll';
        $programCode = $profile->program_code ?? 'PMP0005';
        if (!$header->program_code) {
            $header->program_code = $programCode;
        }


        if ($header->case == 2) {
            $header->ingredient_group = '';
        }

        return (object) [
            'data' => $dataInfo,
            'header' => $header,
        ];
    }

    function getItem($request)
    {
        $inventoryItemId = request()->inventory_item_id;
        $number = trim(strtolower(request()->number)) ?? false;
        $header = json_decode($request->header ?? []);
        $typeCode = $header->type_code;
        $requestLineId = $request->request_line_id;
        $ingredienGroup = $header->ingredient_group;
        $materialRequestRepo = new self;


        $profile = getDefaultData($this::url);
        $organizationId =  $profile->organization_id;
        if ($header->organization_id) {
            $organizationId =  $header->organization_id;
        }
        $orgIdLogin = $organizationId;


        $organizationCode = optional(optional($header)->organization)->organization_code ?? $profile->organization_code;
        if ($header->objective_code == 3 || $header->objective_code == 2) {
            $data = SetupTransferLocations::select(['to_organization_id'])
                    ->where('user_organization_id', $organizationId)
                    ->where('item_cat_code', $header->attribute3)
                    ->where('enable_flag', 'Y')
                    ->where('request_type', '1')
                    ->first();
            $organizationId = optional($data)->to_organization_id ?? 0;
        }

        $ptpmItemNumberVTable = (new PtpmItemNumberV)->getTable();
        $ptpmMfgFormulaVTable = (new PtpmMfgFormulaV)->getTable();
        $items = PtpmItemNumberV::with(['uom'])
                    ->selectRaw("
                        organization_id
                        , inventory_item_id
                        , primary_uom_code
                        , primary_uom_code transaction_uom
                        , primary_uom_code detail_uom
                        , primary_unit_of_measure transaction_uom_desc
                        , '' secondary_uom
                        , '' secondary_uom_list
                        , item_number
                        , item_desc
                        , tobacco_group_code
                        , item_classification_code
                        , tobacco_type_code
                        , item_number || ' : ' || item_desc as display
                        , item_cat_code
                    ")
                    ->where('organization_id', $organizationId)
                    ->when($ingredienGroup, function($q) use($ingredienGroup) {
                        $q->where("item_classification_code", $ingredienGroup);
                    })
                    ->when($inventoryItemId, function($q) use($inventoryItemId) {
                        // $q->where("inventory_item_id", $inventoryItemId);
                        $q->where(function($r) use($inventoryItemId) {
                            $r->where("inventory_item_id", $inventoryItemId)
                                // ->orWhereRaw("item_number || ' ' like '% %'");
                                ->orWhereRaw("inventory_item_id || ' ' like '%SUBSTR(inventory_item_id, 1, 4)%'");


                        });
                    })
                    ->when($typeCode, function($q) use($typeCode) {
                        $mapKeys = [ 'selectAll', 'selectItemList' ];
                        if (!in_array($typeCode, $mapKeys)) {
                            $q->where("tobacco_type_code", $typeCode);
                        }
                    })
                    ->when($number, function($q) use($number) {
                        $q->whereRaw("LOWER(item_number || ': ' || item_desc) like '%{$number}%'");
                        // $q->whereRaw("LOWER(item_number) like ?", ["%{$number}%"]);
                    })
                    ->when( $header->attribute2 == 2, function($q) use (
                        $header, $ptpmItemNumberVTable, $ptpmMfgFormulaVTable, $orgIdLogin
                        ) {
                        $exceptItemCate = $this->getExceptItemCate();
                        if (count($exceptItemCate)) {
                            $q->whereNotIn('item_cat_code', $exceptItemCate);
                        }

                        // เบิกวัสดุสินเปลือง
                        if ($header->objective_code == 3) {

                            $q->whereNotExists(function($query) use (
                                $ptpmItemNumberVTable, $ptpmMfgFormulaVTable, $orgIdLogin
                                ) {
                                $query->select(\DB::raw(1))
                                    ->from($ptpmMfgFormulaVTable)
                                    ->whereRaw("
                                        {$ptpmMfgFormulaVTable}.inventory_item_id = {$ptpmItemNumberVTable}.inventory_item_id
                                        and     {$ptpmMfgFormulaVTable}.organization_id = {$orgIdLogin}
                                    ");
                            });
                        }
                    })
                    ->when( $header->attribute3, function($q) use($header) {
                        $q->where('item_cat_code', $header->attribute3);
                    })
                    ->orderBy("item_number")
                    // ->limit(20)
                    ->get();
                    // ->toSql();
        // dd('xx', $this->getExceptItemCate(), $organizationId, $header->attribute3, $items);

        $items = collect($items)->map(function ($row) use($materialRequestRepo, $requestLineId) {
            $line = $materialRequestRepo->createLineData($row, 'NEW_ITEM_FORMULA', false, false);
            $line['is_selected'] = true;
            $line['request_line_id'] = $requestLineId;
            $line['display'] = $row->display;
            return $line;
        });
        return $items;
    }


    function createLineData($data, $case, $oldData = false, $showOnhand = true)
    {
        $transactionUom = '';
        $onhandQty = (object) [
            'sourcing_onhand' => 0,
            'production_onhand' => 0,
        ];
        $secUomList = [];
        $formatNumber = 4;

        if ($case == 'REFRESH') {
            $line = $data;
            $line['is_selected'] = true;
            $line['request_line_id'] = $oldData->request_line_id;
            $line['transaction_quantity'] = $oldData->transaction_quantity;
            $line['transaction_uom'] = $oldData->transaction_uom;
            $line['remark_msg'] = $oldData->remark_msg;
            $line['secondary_qty'] = $oldData->secondary_qty;
            $line['secondary_uom'] = $oldData->secondary_uom;
            $line['use_lose_qty'] = $oldData->attribute8;
            $line['ratio_require_per_unit'] = $oldData->attribute9;
        }

        if ($case == 'NEW_ITEM_FORMULA') {
            // dd('xx', $data);
            $transactionUom = $data->detail_uom;
            if ($showOnhand) {
                $onhandQty = $this->getOnhand((object)[
                                    'inventory_item_id' => $data->inventory_item_id,
                                    'organization_id' => $data->organization_id,
                                    'primary_uom_code' => $transactionUom,
                                    'tobacco_group_code' => $data->tobacco_group_code,
                                    'subinventory_code' => $data->from_subinventory,
                                    'locator_id' => $data->from_locator_id,
                                    'lot_number' => $data->default_lot_no,
                                ]);
            }


            $secUomList = $this->getSecUomList((object)[
                                'inventory_item_id' => $data->inventory_item_id,
                                'organization_id' => $data->organization_id,
                                'to_uom_code' => $transactionUom,
                            ]);


            $uom = PtInvUomV::where('uom_code', $transactionUom)->first();
            $unitOfMeasure = '';
            if ($uom) {
                $unitOfMeasure  = $uom->unit_of_measure;
            }

            $line = [
                'is_selected' => false,
                'request_line_id' => null,
                'is_edit_item' => false,

                'organization_id' => $data->organization_id,
                'subinventory_code' => $data->from_subinventory,
                'locator_id' => $data->from_locator_id,

                'inventory_item_id' => $data->inventory_item_id,
                'lot_number' =>  $data->default_lot_no,
                'transaction_quantity' => '',
                'transaction_uom' => $transactionUom,
                'remark_msg' => '',

                'secondary_qty' => '',
                // 'secondary_uom' => optional($secUomList->first())->from_uom_code,
                'secondary_uom' => $transactionUom,
                'secondary_uom_list' => $secUomList ?? [],

                // 'onhand' => number_format($onhandQty, $formatNumber) ,
                'sourcing_onhand' => number_format($onhandQty->sourcing_onhand, $formatNumber) ,
                'production_onhand' => number_format($onhandQty->production_onhand, $formatNumber) ,



                'require_qty' => $data->require_qty ?? 0,

                // Attribute
                'item_number' => $data->item_number,
                'item_desc' => $data->item_desc,
                'transaction_uom_desc' => $unitOfMeasure,
                'tobacco_group_code' => $data->tobacco_group_code,
                'item_classification_code' => $data->item_classification_code,
                'tobacco_type_code' => $data->tobacco_type_code,
                'use_lose_qty' => $data->require_qty ?? 0,
                'ratio_require_per_unit' => $data->ratio_require_per_unit,
                'tobacco_ingrident_type' => $data->tobacco_ingrident_type,
            ];
        }

        if ($case == 'RequestLine') {
            if ($showOnhand) {
                $onhandQty = $this->getOnhand((object)[
                                'inventory_item_id' => $data->inventory_item_id,
                                'organization_id' => $data->organization_id,
                                'primary_uom_code' => $data->transaction_uom,
                                'tobacco_group_code' => $data->tobacco_group_code,
                                'subinventory_code' => $data->from_subinventory,
                                'locator_id' => $data->from_locator_id,
                                'lot_number' => $data->lot_number,
                            ]);
            }

            $secUomList = $this->getSecUomList((object)[
                                'inventory_item_id' => $data->inventory_item_id,
                                'organization_id' => $data->organization_id,
                                'to_uom_code' => $data->transaction_uom,
                            ]);

            $item = PtpmItemNumberV::select([
                            'item_number',
                            'item_desc'
                        ])
                        ->where('organization_id', $data->organization_id)
                        ->where('inventory_item_id', $data->inventory_item_id)
                        ->first();
            $uom = PtInvUomV::where('uom_code', $data->transaction_uom)->first();

            $line['is_selected']            =  true;
            $line['is_edit_item']           = false;
            $line['is_edit_item']           = true;
            $line['request_line_id']        =  $data->request_line_id;
            $line['organization_id']        =  $data->organization_id;
            $line['subinventory_code']      = $data->subinventory_code;
            $line['locator_id']             = $data->locator_id;
            $line['inventory_item_id']      = $data->inventory_item_id;
            $line['lot_number']             = $data->lot_number;
            $line['transaction_quantity']   = $data->transaction_quantity;
            $line['transaction_uom']        = $data->transaction_uom;
            $line['remark_msg']             = $data->remark_msg;
            $line['secondary_qty']          = $data->secondary_qty;
            $line['secondary_uom']          = $data->secondary_uom;
            $line['secondary_uom_list']     = $secUomList;

            // $line['onhand']                 = number_format($onhandQty, $formatNumber);
            $line['sourcing_onhand']        = number_format($onhandQty->sourcing_onhand, $formatNumber);
            $line['production_onhand']      = number_format($onhandQty->production_onhand, $formatNumber);

            // $line['item_number']            = $data->attribute2;
            // $line['item_desc']              = $data->attribute3;

            $line['item_number']            = optional($item)->item_number;
            $line['item_desc']              = optional($item)->item_desc;
            // $line['transaction_uom_desc']   = $data->attribute4;
            $line['transaction_uom_desc']   = optional($uom)->unit_of_measure;
            $line['tobacco_group_code']     = $data->attribute5;
            $line['item_classification_code'] = $data->attribute6;
            $line['tobacco_type_code']      = $data->attribute7;
            $line['use_lose_qty']           = $data->attribute8;
            $line['ratio_require_per_unit'] = $data->attribute9;
            $line['require_qty']            = $data->attribute10;
        }

        if ($case == 'NEW_LINE') {
            $line['is_selected']            = true;
            $line['is_edit_item']           = true;
            $line['request_line_id']        = '';
            $line['organization_id']        = '';
            $line['subinventory_code']      = '';
            $line['locator_id']             = '';
            $line['inventory_item_id']      = '';
            $line['lot_number']             = '';
            $line['transaction_quantity']   = '';
            $line['transaction_uom']        = '';
            $line['remark_msg']             = '';
            $line['secondary_qty']          = '';
            $line['secondary_uom']          = '';
            $line['secondary_uom_list']     = '';

            // $line['onhand']                 = number_format($onhandQty, $formatNumber);
            $line['sourcing_onhand']        = number_format($onhandQty->sourcing_onhand, $formatNumber);
            $line['production_onhand']      = number_format($onhandQty->production_onhand, $formatNumber);


            $line['require_qty']            = 0;

            $line['item_number']            = '';
            $line['item_desc']              = '';
            $line['transaction_uom_desc']   = '';
            $line['tobacco_group_code']     = '';
            $line['item_classification_code'] = '';
            $line['tobacco_type_code']      = '';
            $line['use_lose_qty']           = 0;
            $line['ratio_require_per_unit'] = 0;
        }
        return $line;
    }


    function getOnhand($params)
    {
        $onhands = PtpmSetupTransferLocV::sourcingOnhand($params)
                    ->where('user_organization_id',  $params->organization_id)
                    ->get();

        $onhandQty = 0;
        if (count($onhands) === 1) {
            $onhandQty = $onhands->first()->onhand_quantity;
        } elseif (count($onhands) > 0) {
            $onhandQty = $onhands->sum('onhand_quantity');
        }
        $sourcingOnhand = $onhandQty;

        $onhands = PtpmSetupTransferLocV::productOnhand($params)
                    ->where('user_organization_id',  $params->organization_id)
                    ->get();

        $onhandQty = 0;
        if (count($onhands) === 1) {
            $onhandQty = $onhands->first()->onhand_quantity;
        } elseif (count($onhands) > 0) {
            $onhandQty = $onhands->sum('onhand_quantity');
        }
        $productOnhand = $onhandQty;

        return (object) [
            'sourcing_onhand' => $sourcingOnhand,
            'production_onhand' => $productOnhand
        ];

        // ProductOnhand
        dd('C', $onhandQty);
        return $onhandQty;



        $onhands = PtinvOnhandQuantitiesV::where('inventory_item_id', $params->inventory_item_id)
                        ->where('organization_id',  $params->organization_id)
                        ->where('primary_uom_code', $params->primary_uom_code)
                        ->where('tobacco_group_code', $params->tobacco_group_code)
                         ->when($params->tobacco_group_code, function($q) use($params) {
                            $q->where('tobacco_group_code', $params->tobacco_group_code);
                        })
                        ->when($params->subinventory_code, function($q) use($params) {
                            $q->where('subinventory_code', $params->subinventory_code);
                        })
                        ->when($params->locator_id, function($q) use($params) {
                            $q->where('locator_id', $params->locator_id);
                        })
                        // ->when($row->default_lot_no, function($q) use($row) {
                        //     $q->where('lot_number', $row->default_lot_no);
                        // })
                        ->get();

        $onhandQty = 0;
        if (count($onhands) === 1) {
            $onhand = $onhands->first();
            $onhandQty = $onhand->first()->onhand_quantity;
        } elseif (count($onhands) > 0) {
            $onhandQty = $onhands->sum('onhand_quantity');
        }
        return $onhandQty;
    }


    function getSecUomList($params)
    {
        $secUomList = PtpmItemConvUomV::with(['fromUom'])->where('inventory_item_id', $params->inventory_item_id)
                        ->where('organization_id',  $params->organization_id)
                        ->where('to_uom_code', $params->to_uom_code)
                        ->get();

        return $secUomList;
    }


    function getExceptItemCate()
    {
        $data = PtpmItemcatRequestSeg2::select(['item_cat_code'])->where('request_mat_flag', 'N')->get();
        return $data;
    }

    function getFilterItemCat($organizationId)
    {
        $data = SetupTransferLocations::selectRaw("distinct item_cat_code")
                ->where('user_organization_id', $organizationId)
                ->where('enable_flag', 'Y')
                ->where('request_type', '1')
                ->get();
        if (count($data)) {
            return $data->pluck('item_cat_code', 'item_cat_code')->all();
        } else {
            return [];
        }
    }

    function getItemCatCodeList($profile, $request, $case, $header, $allList = false)
    {
        $columns = ['organization_id', 'item_cat_code', 'item_cat_desc'];
        $tableItemCate = (new PtpmItemCatByOrgV)->getTable();
        $tableFormula = (new PtpmMfgFormulaV)->getTable();
        $data = PtpmItemCatByOrgV::select($columns)->groupBy($columns)
                ->where('organization_id', $profile->organization_id)
                ->whereNotExists(function($query) use ($tableItemCate, $tableFormula) {
                    $query->select(\DB::raw(1))
                        ->from($tableFormula)
                        ->whereRaw("
                            {$tableFormula}.organization_id = {$tableItemCate}.organization_id
                            and {$tableFormula}.item_cat_code = {$tableItemCate}.item_cat_code
                        ");
                })
                ->whereNotExists(function($query) use ($tableItemCate, $tableFormula) {
                    $query->select(\DB::raw(1))
                        ->from($tableFormula)
                        ->whereRaw("
                            {$tableFormula}.organization_id = {$tableItemCate}.organization_id
                            and {$tableFormula}.product_item_cat_code = {$tableItemCate}.item_cat_code
                        ");
                })
                ->orderBy('item_cat_desc')
                ->get();

        // Organization
        $organizationId = $profile->organization_id;
        $organizationCode = $profile->organization_code;
        if ($header) {
            $organizationId = optional(optional($header)->organization)->organization_id ?? $profile->organization_id;
            $organizationCode = optional(optional($header)->organization)->organization_code ?? $profile->organization_code;
        }
        if ($case == 1) {
            if ($organizationCode == 'M02' || $organizationCode == 'M03') {
                $tableItemCate = (new ItemCategorys)->getTable();
                $table = (new SetupTransferLocations)->getTable();

                $columns = [
                    "{$table}.to_organization_id as organization_id",
                    "{$table}.item_cat_code",
                    "{$tableItemCate}.description as item_cat_desc"
                ];
                $formulaItemCate = PtpmMfgFormulaV::selectRaw("distinct item_cat_code")
                                    ->where('organization_id', $organizationId)
                                    ->get();

                $data = SetupTransferLocations::select($columns)
                        ->where('user_organization_id', $organizationId)
                        ->join($tableItemCate, "{$tableItemCate}.lookup_code", '=', "{$table}.item_cat_code")
                        ->when(count($formulaItemCate), function($q) use($formulaItemCate) {
                            $q->whereNotIn("item_cat_code", $formulaItemCate->pluck('item_cat_code', 'item_cat_code')->all());
                        })
                        // ->whereRaw("{$table}.enable_flag = 'Y' ")
                        ->whereRaw("{$table}.request_type = '1' ");
                        // ->get();
                if (!$allList) {
                    $data = $data->whereRaw("{$table}.enable_flag = 'Y' ");
                }
                $data = $data->get();
            }
        } else if ($case == 2) {

            if ($organizationCode == 'M12' && false) {
                $tableItemCate = (new ItemCategorys)->getTable();
                $table = (new SetupTransferLocations)->getTable();

                $columns = [
                    "{$table}.to_organization_id as organization_id",
                    "{$table}.item_cat_code",
                    "{$tableItemCate}.description as item_cat_desc"
                ];
                $formulaItemCate = PtpmMfgFormulaV::selectRaw("distinct item_cat_code")
                                    ->where('organization_id', $organizationId)
                                    ->get();

                $data = SetupTransferLocations::select($columns)
                        ->where('user_organization_id', $organizationId)
                        ->join($tableItemCate, "{$tableItemCate}.lookup_code", '=', "{$table}.item_cat_code")
                        ->when(count($formulaItemCate), function($q) use($formulaItemCate) {
                            $q->whereNotIn("item_cat_code", $formulaItemCate->pluck('item_cat_code', 'item_cat_code')->all());
                        })
                        ->whereRaw("{$table}.enable_flag = 'Y' ")
                        ->whereRaw("{$table}.request_type = '1' ")
                        ->get();

            }  else {
                $tableItemCate = (new ItemCategorys)->getTable();
                $table = (new SetupTransferLocations)->getTable();

                $columns = [
                    "{$table}.to_organization_id as organization_id",
                    "{$table}.item_cat_code",
                    "{$tableItemCate}.description as item_cat_desc"
                ];

                // $table2 = (new PtpmMfgFormulaV)->getTable();
                // $columns2 = [
                //     "{$table2}.item_cat_code",
                //     "{$tableItemCate}.description as item_cat_desc"
                // ];
                // $formulaItemCate = PtpmMfgFormulaV::select($columns2)->distinct()
                //                         ->where('organization_id', $organizationId)
                //                         ->join($tableItemCate, "{$tableItemCate}.lookup_code", '=', "{$table2}.item_cat_code")
                //                         ->get();

                $data = SetupTransferLocations::select($columns)
                        ->distinct()
                        ->where('user_organization_id', $organizationId)
                        ->join($tableItemCate, "{$tableItemCate}.lookup_code", '=', "{$table}.item_cat_code")
                        ->whereRaw("{$table}.request_type = '1' ");

                if (!$allList) {
                    $data = $data->whereRaw("{$table}.enable_flag = 'Y' ");
                }
                $data = $data->get();
                // dd('x', $data->toArray());
                // $data = $formulaItemCate->union($data);
            }
        }

        return $data;
    }

    function getItemCatForProdList($profile, $request, $case, $header)
    {
        // Organization
        $organizationId = optional(optional($header)->organization)->organization_id ?? $profile->organization_id;
        $organizationCode = optional(optional($header)->organization)->organization_code ?? $profile->organization_code;

        $tableItemCate = (new ItemCategorys)->getTable();
        $table = (new SetupTransferLocations)->getTable();

        $columns = [
            "{$table}.to_organization_id as organization_id",
            "{$table}.item_cat_code",
            "{$tableItemCate}.description as item_cat_desc"
        ];
        $formulaItemCate = PtpmMfgFormulaV::selectRaw("distinct item_cat_code")
                            ->where('organization_id', $organizationId)
                            ->get();

        $data = SetupTransferLocations::select($columns)
                ->distinct()
                ->where('user_organization_id', $organizationId)
                ->join($tableItemCate, "{$tableItemCate}.lookup_code", '=', "{$table}.item_cat_code")
                ->when(count($formulaItemCate), function($q) use($formulaItemCate) {
                    $q->whereIn("item_cat_code", $formulaItemCate->pluck('item_cat_code', 'item_cat_code')->all());
                })
                ->whereRaw("{$table}.enable_flag = 'Y' ")
                ->whereRaw("{$table}.request_type = '1' ")
                ->get();
                // ->toSql();
        return $data;
    }
}
