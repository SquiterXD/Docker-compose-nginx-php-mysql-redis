<?php

namespace App\Http\Controllers\PM\Web;

use App\Models\PM\PtpmRequestSummaryV;
use App\Models\PM\Lookup\PtpmBatchStatus;
use App\Models\Lookup\PtBiweeklyVLookup;
use App\Models\PM\Lookup\PtpmJobType;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PM0038Controller extends BaseController
{
    public function index()
    {
        $profile = getDefaultData("/pm/production-order-list");

        // สถานะคำสั่งผลิต
        $lovManufactureStatus = DB::SELECT(
            "SELECT LOOKUP_CODE, DESCRIPTION
                                FROM OAPM.PTPM_BATCH_STATUS
                                WHERE LOOKUP_CODE != 4");


        if (request()->ajax() || request()->action == 'search') {

            $startCreateData = request()->start_creation_date;
            $endCreateData = request()->end_creation_date;
            $requestNumber = request()->request_number;
            $itemCode = request()->item_code;


            $whereStartCreateData = '';
            if ($startCreateData) {
                $whereStartCreateData ="and TRUNC(ptpm_request_summary_v.creation_date) >= to_date('$startCreateData', 'YYYY-MM-DD')";
                // $whereStartCreateData ="and batch_id in (143730, 141723, 140715, 140714, 140713, 140712, 140711, 140705, 128681, 128678, 154741, 153741, 131678, 128674)";
            }
            $whereEndCreateData = '';
            if ($endCreateData) {
                $whereEndCreateData ="and TRUNC(ptpm_request_summary_v.creation_date) <= to_date('$endCreateData', 'YYYY-MM-DD')";
            }

            $whereRequestNumber = '';
            if ($requestNumber) {
                $whereRequestNumber ="and ptpm_request_summary_v.request_number =  '$requestNumber";
            }
            $whereItemCode = '';
            if ($itemCode) {
                $whereItemCode ="and ptpm_request_summary_v.item_code =  '$itemCode'";
            }

            $query = "SELECT
                    PTPM_REQUEST_SUMMARY_V.*,
                    I.BLEND_NO,
                    U.UNIT_OF_MEASURE AS TH_UOM
                    FROM APPS.PTPM_REQUEST_SUMMARY_V PTPM_REQUEST_SUMMARY_V
                    LEFT JOIN OAPM.PTPM_ITEM_NUMBER_V I
                    ON PTPM_REQUEST_SUMMARY_V.ITEM_CODE = I.ITEM_NUMBER
                    AND PTPM_REQUEST_SUMMARY_V.ORGANIZATION_ID = I.ORGANIZATION_ID
                    LEFT JOIN  APPS.MTL_UNITS_OF_MEASURE_VL U
                    ON U.UOM_CODE = PTPM_REQUEST_SUMMARY_V.REQUEST_UOM
                    WHERE 1 = 1
                    AND PTPM_REQUEST_SUMMARY_V.ORGANIZATION_ID = '{$profile->organization_id}'
                    $whereStartCreateData $whereEndCreateData $whereRequestNumber $whereItemCode
                    ORDER BY PTPM_REQUEST_SUMMARY_V.REQUEST_NUMBER DESC
            ";
            $reqs = DB::select($query);

            $lovRequestNumber = collect([]);
            $lovItem = collect([]);

            foreach ($reqs as $key => $req) {
                $checkLovRequestNumber = $lovRequestNumber->where('item_code', $req->item_code)
                    ->where('request_number', $req->request_number)
                    ->where('creation_date', $req->creation_date)
                    ->where('item_description', $req->item_description);
                if (count($checkLovRequestNumber) == 0) {
                    $lovRequestNumber->push((object)[
                        'request_number' => $req->request_number,
                        'creation_date' => $req->creation_date,
                        'item_code' => $req->item_code,
                        'item_description' => $req->item_description,
                    ]);
                }

                $checkLovItem = $lovItem->where('item_code', $req->item_code)
                    ->where('item_description', $req->item_description)
                    ->where('blend_no', $req->blend_no);
                if (count($checkLovItem) == 0) {
                    $lovItem->push((object)[
                        'item_code' => $req->item_code,
                        'item_description' => $req->item_description,
                        'blend_no' => $req->blend_no,
                    ]);
                }
            }

            return response()->json([
                'data_reqs' => $reqs,
                'lov_manufacture_status' => optional($lovManufactureStatus)->toArray() ?? [],
                'lov_request_number' => optional($lovRequestNumber)->toArray() ?? [],
                'lov_item' => optional($lovItem)->toArray() ?? [],
            ]);


            // เลขที่คำสั่งผลิต
            // $lovRequestNumber = DB::SELECT(
            //     "SELECT DISTINCT REQUEST_NUMBER,
            //                         CREATION_DATE,
            //                         ITEM_CODE,
            //                         ITEM_DESCRIPTION
            //                         FROM APPS.PTPM_REQUEST_SUMMARY_V PTPM_REQUEST_SUMMARY_V
            //                         WHERE 1 = 1
            //                         AND PTPM_REQUEST_SUMMARY_V.ORGANIZATION_ID = '{$profile->organization_id}'
            //                         $whereStartCreateData $whereEndCreateData $whereRequestNumber $whereItemCode
            //                         ORDER BY REQUEST_NUMBER DESC");

            // $lovItem = DB::SELECT(
            //     "SELECT DISTINCT ITEM_CODE, ITEM_DESCRIPTION, I.BLEND_NO
            //                         FROM APPS.PTPM_REQUEST_SUMMARY_V PTPM_REQUEST_SUMMARY_V
            //                         LEFT JOIN OAPM.PTPM_ITEM_NUMBER_V I
            //                         ON ITEM_CODE = I.ITEM_NUMBER
            //                         AND PTPM_REQUEST_SUMMARY_V.ORGANIZATION_ID = I.ORGANIZATION_ID
            //                         WHERE 1 = 1
            //                         AND PTPM_REQUEST_SUMMARY_V.ORGANIZATION_ID = '{$profile->organization_id}'
            //                         $whereStartCreateData $whereEndCreateData $whereRequestNumber $whereItemCode
            //                         ORDER BY ITEM_CODE ASC");

            return response()->json([
                'data_reqs' => $reqs,
                'lov_manufacture_status' => $lovManufactureStatus,
                'lov_request_number' => $lovRequestNumber,
                'lov_item' => $lovItem,
            ]);
        } else {
            $reqs = collect([]);
            $lovRequestNumber = collect([]);
            $lovItem = collect([]);
        }

        $batchStatusList = PtpmBatchStatus::all();
        $currentDate = date("Y-m-d");
        $initBiweeklySelected = PtBiweeklyVLookup::query()
            ->whereDate('start_date', '<=', Carbon::parse($currentDate)->format('Y-m-d'))
            ->whereDate('end_date', '>=', Carbon::parse($currentDate)->format('Y-m-d'))
            ->select('*')
            ->get();

        return $this->vue('pm0038', [
            'btn_trans' => trans('btn'),
            'default_data' => getDefaultData(),
            // 'data_reqs' => $reqs,
            'batch_status_list' => $batchStatusList,
            'lov_manufacture_status' => $lovManufactureStatus,
            'lov_request_number' => $lovRequestNumber,
            'lov_item' => $lovItem,
            'index_url' => route('pm.production-order-list.index'),
            'init_filter' => [
                'year' => Carbon::parse($currentDate)->format('Y'),
                'month' => Carbon::parse($currentDate)->format('m'),
                'biweekly' => $initBiweeklySelected,
            ],
        ]);
    }
}
