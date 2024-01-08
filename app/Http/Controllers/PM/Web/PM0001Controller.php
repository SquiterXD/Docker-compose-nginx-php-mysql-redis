<?php

namespace App\Http\Controllers\PM\Web;

use App\Models\Lookup\PtpmItemConvUomVLookup;
use App\Models\Lookup\PtpmMfgFormulaV;
use App\Models\PM\Lookup\PtpmBatchStatus;
use App\Models\PM\Lookup\PtpmItemConvUomV;
use App\Models\PM\Lookup\PtpmJobType;
use App\Models\PtglCoaDeptCodeAllV;
use App\Models\PM\PtpmSummaryBatchV;
use App\Models\Lookup\PtBiweeklyLookup;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;

class PM0001Controller extends BaseController
{
    const PROGRAM_CODE = 'PM0001';

    public function index($batchNo = null)
    {
        // $periods = collect(\DB::select("
        //     SELECT  period_name
        //     FROM    GL_PERIODS_V
        //     WHERE   trunc(sysdate) between trunc(start_date) and trunc(end_date)
        // "));

        // $periods = optional(optional($periods)->pluck('period_name', 'period_name'))->all() ?? [];
        // $biweekly = PtBiweeklyLookup::whereIn('period_name', $periods)->orderBy('biweekly')->get();

        // dd('xx', $periods, $biweekly);
        // $currentBiweekly = PtBiweeklyLookup::whereRaw("TRUNC(sysdate) BETWEEN START_DATE AND END_DATE")->first();
        // $biweekly = PtBiweeklyLookup::where('period_year', $currentBiweekly->period_year)
        //                 ->where('biweekly', '>=', $currentBiweekly->biweekly)
        //                 ->get();
        $defaultData = getDefaultData(self::PROGRAM_CODE);
        $userDept = PtglCoaDeptCodeAllV::query()
            ->where('department_code', $defaultData->department_code)
            ->first();

        $summaryBatchQuery = PtpmSummaryBatchV::query();
        $summaryBatchName = $summaryBatchQuery->getModel()->getTable();
        $itemConvUomLookupName = PtpmItemConvUomV::query()->getModel()->getTable();

//            ->where('organization_id', $organizationId)
//            ->where('inventory_item_id', $inventoryItemId)
//            ->get();

        $findBatch = PtpmSummaryBatchV::where('batch_no', $batchNo)->where('organization_id', session('organization_id'))->first();
        if ($findBatch && $batchNo) {
            $summaryBatch = $summaryBatchQuery
                ->where('batch_no', $batchNo)
                ->whereRaw("$summaryBatchName.inventory_item_id = $findBatch->inventory_item_id")
                ->whereRaw("$summaryBatchName.organization_id = $findBatch->organization_id")
                ->join($itemConvUomLookupName, function ($join) use ($summaryBatchName, $itemConvUomLookupName) {
                    $join->on("$summaryBatchName.organization_id", '=', "$itemConvUomLookupName.organization_id");
                    $join->on("$summaryBatchName.inventory_item_id", '=', "$itemConvUomLookupName.inventory_item_id");
                    $join->on("$summaryBatchName.dtl_um", '=', "$itemConvUomLookupName.from_uom_code");
                })
                ->select([
                    "$summaryBatchName.*",
                    "$itemConvUomLookupName.from_uom_code",
                    "$itemConvUomLookupName.from_unit_of_measure",
                ])
                ->first();

            if (!$summaryBatch) return redirect()->route('pm.production-order.index');
//            if ($summaryBatch->actual_start_date) {
//                $summaryBatch->actual_start_date = date('Y-m-d', strtotime($summaryBatch->actual_start_date));
//            }
            if ($summaryBatch->plan_start_date) {
                $summaryBatch->plan_start_date = date('Y-m-d', strtotime($summaryBatch->plan_start_date));
            }

            $summaryBatch->uom_list = PtpmItemConvUomVLookup::query()
                ->where('organization_id', $summaryBatch->organization_id)
                ->where('inventory_item_id', $summaryBatch->inventory_item_id)
                ->get();

        } else {
            $summaryBatch = null;
        }

        $jobTypeList = PtpmJobType::all()->toArray();
        $batchStatusList = PtpmBatchStatus::all();
        //$itemConvUomList = PtpmItemConvUomVLookup::all();

        usort($jobTypeList, function ($obj1, $obj2) {
            return intval($obj1['lookup_code']) - intval($obj2['lookup_code']);
        });

        $productItems = PtpmMfgFormulaV::query()
            ->select([
                'product_item_id',
                'product_item_number',
                'product_item_desc',
                'product_uom_code',
                'product_blend_no',
                'organization_id',
            ])
            ->where('organization_id', $defaultData->organization_id)
            ->distinct()
            ->when($defaultData->organization_code == 'M06', function ($q) use($defaultData) {
                return $q->where('receipe_type_code', 1);
            })
            ->when($defaultData->organization_code == 'M02', function ($q) use($defaultData) {
                // return $q->where('receipe_type_code', 1)->whereNotNull('product_blend_no');
                return $q->whereNotNull('product_blend_no');
            })
            ->isProductFlag()
            ->orderBy('product_item_number')
            ->get();

        $blendNos = PtpmMfgFormulaV::query()
            ->select([
                'product_item_id',
                'product_item_number',
                'product_item_desc',
                'product_uom_code',
                'product_blend_no',
                'organization_id',
            ])
            ->whereNotNull('product_blend_no')
            ->where('organization_id', $defaultData->organization_id)
            ->distinct()
            ->when($defaultData->organization_code == 'M06', function ($q) use($defaultData) {
                return $q->where('receipe_type_code', 1);
            })
            ->when($defaultData->organization_code == 'M02', function ($q) use($defaultData) {
                return $q->whereNotNull('product_blend_no');
            })
            ->isProductFlag()
            ->orderBy('product_item_number')
            ->get();

        if ($summaryBatch) {
            $item = $productItems->filter(function ($item) use ($summaryBatch) {
                return $item->product_item_id === $summaryBatch->inventory_item_id;
            })->first();

            // if ($item) {
            //     $summaryBatch->product_item_number = $item->product_item_number;
            //     $summaryBatch->product_item_desc = $item->product_item_desc;
            // }
            // dd('xx', $summaryBatch);

            $summaryBatch->product_item_number = $summaryBatch->item_no;
            $summaryBatch->product_item_desc = $summaryBatch->item_desc;
            $summaryBatch->start_date = $summaryBatch->plan_start_date ? Carbon::parse($summaryBatch->plan_start_date)->format('Y-m-d') : null;
            $summaryBatch->end_date = $summaryBatch->plan_cmplt_date ? Carbon::parse($summaryBatch->plan_cmplt_date)->format('Y-m-d') : null;
        }

        $defaultBiweekly = '';
        $datePeriods = (object) [];
        $periods = collect(\DB::select("
                        SELECT  OAP.PERIOD_NAME
                        FROM    ORG_ACCT_PERIODS OAP ,
                                ORG_ORGANIZATION_DEFINITIONS OOD
                        WHERE   OAP.ORGANIZATION_ID = OOD.ORGANIZATION_ID
                        AND     OAP.OPEN_FLAG = 'Y'
                        --AND (TRUNC(SYSDATE) BETWEEN TRUNC(OAP.PERIOD_START_DATE) AND TRUNC (OAP.SCHEDULE_CLOSE_DATE))
                        AND     OAP.ORGANIZATION_ID = {$defaultData->organization_id}
                        ORDER BY OOD.ORGANIZATION_ID
                    "));


        if ($summaryBatch) {
            $defBiweekly = PtBiweeklyLookup::selectRaw("
                            pt_biweekly.*
                            , to_char(start_date, 'YYYY-MM-DD') start_date_us
                            , to_char(end_date, 'YYYY-MM-DD') end_date_us
                        ")
                        ->orderBy('biweekly')
                        ->where('biweekly', $summaryBatch->biweekly)
                        ->whereRaw("
                            to_date('{$summaryBatch->plan_start_date}', 'YYYY-MM-DD') between start_date and end_date
                        ")
                        ->get();
            $defaultBiweekly = optional($defBiweekly->first())->biweekly_id ?? '';
            $organizationCode = $summaryBatch->organization_code;

            $periods = optional(optional($periods)->pluck('period_name', 'period_name'))->all() ?? [];
            $biweekly = PtBiweeklyLookup::selectRaw("
                            pt_biweekly.*
                            , to_char(start_date, 'YYYY-MM-DD') start_date_us
                            , to_char(end_date, 'YYYY-MM-DD') end_date_us
                        ")
                        ->whereIn('period_name', $periods)
                        ->when($defaultBiweekly, function ($query, $defaultBiweekly) {
                            return $query->orWhere('biweekly_id', $defaultBiweekly);
                        })
                        ->orderBy('biweekly')
                        ->get();

        } else {

            $periods = optional(optional($periods)->pluck('period_name', 'period_name'))->all() ?? [];
            $query =  PtBiweeklyLookup::selectRaw("
                            pt_biweekly.*
                            , to_char(start_date, 'YYYY-MM-DD') start_date_us
                            , to_char(end_date, 'YYYY-MM-DD') end_date_us
                        ")
                        ->whereIn('period_name', $periods)->orderBy('biweekly');
            $biweekly = clone $query;
            $biweekly = $biweekly->get();
            $defaultBiweekly = clone $query;
            $defaultBiweekly = $defaultBiweekly
                                ->whereRaw("TRUNC(SYSDATE) BETWEEN TRUNC(start_date) AND TRUNC(end_date)")
                                ->first();
            // dd('xx', $biweekly);
            $defaultBiweekly = optional($defaultBiweekly)->biweekly_id;


            $organizationCode = $defaultData->organization_code;
        }

        $datePeriods = collect(\DB::select("
            SELECT  (to_char(min(period_start_date), 'YYYY-MM-DD')) minDate, (to_char(max(schedule_close_date), 'YYYY-MM-DD')) maxDate
            FROM    ORG_ACCT_PERIODS OAP ,
                    ORG_ORGANIZATION_DEFINITIONS OOD
            WHERE   OAP.ORGANIZATION_ID = OOD.ORGANIZATION_ID
            AND     OAP.OPEN_FLAG = 'Y'
            --AND (TRUNC(SYSDATE) BETWEEN TRUNC(OAP.PERIOD_START_DATE) AND TRUNC (OAP.SCHEDULE_CLOSE_DATE))
            AND     OAP.ORGANIZATION_ID = {$defaultData->organization_id}
            ORDER BY OOD.ORGANIZATION_ID
        "));

        if ($datePeriods) {
            $datePeriods = $datePeriods->first();
        }

        return $this->vue('pm0001', [
            'organization_code' => $organizationCode,
            'default_biweekly' => $defaultBiweekly,
            'min_max_date_period' => $datePeriods,
            'default_data' => $defaultData,
            'batch_no' => $batchNo,
            'summary_batch' => $summaryBatch,
            'user_dept' => $userDept,
            'job_type_list' => $jobTypeList,
            'batch_status_list' => $batchStatusList,
            'product_item_list' => $productItems,
            'blend_no_list' => $blendNos,
            'biweekly' => $biweekly
//            'item_conv_uom_list' => $itemConvUomList,
        ]);
    }
}
