<?php

namespace App\Http\Controllers\PM\Api;

use App\Http\Controllers\Controller;
use App\Models\Lookup\PtpmItemConvUomVLookup;
use App\Models\Lookup\PtpmSummaryBatchVLookup;
use App\Models\PM\Lookup\PtpmJobType;
use App\Models\PM\MtlSystemItems;
use App\Models\PM\PtInvUomV;
use App\Models\PM\PtpmOnhandLog;
use Illuminate\Http\Request;
use App\Models\PM\PtpmOnhandNotice;
use App\Models\PM\PtpmProcessRequestsT;
use App\Models\PM\PtpmSummaryBatchV;
use App\Repositories\PM\AdditiveInventoryAlertRepository;
use Illuminate\Support\Facades\DB;
class AdditiveInventoryAlertController extends Controller
{
    protected $repo;

    public function __construct(AdditiveInventoryAlertRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        try {
            $params = [
                'subinventory_code' => $request->subinventory_code,
                'organization_code' => $request->organization_code,
                'locator_code' => $request->locator_code,
            ];
            $items = $this->repo->getList($params);
            $items = $items->map(function ($item) {
                $onHandLog = PtpmOnhandLog::where('inventory_item_id', $item->inventory_item_id)->where('item_type','11')->where('item_type', $item->item_type)->first();

                $item->report_num = !empty($onHandLog) ? $onHandLog->report_num : $item->report_num;
                $item->uom_master = PtpmItemConvUomVLookup::select(DB::raw(' from_unit_of_measure, inventory_item_id , from_uom_code , to_uom_code , conversion_rate'))->where('inventory_item_id', $item->inventory_item_id)
                    ->where('organization_id', $item->organization_id)
                    ->where('to_uom_code', $item->primary_uom_code)
                    ->get();

                // คำนวน Require QTY
                if (!empty($onHandLog->qty2)) {
                    $item->require_qty_calc = $onHandLog->qty2;
                } else {
                    $item->require_qty_calc = $item->max_qty - $item->transaction_quantity;
                }
                // var_dump('xx', $item);
                $item->url_pm_production_order = '#';
                if ($item->report_num) {
                    $item->url_pm_production_order = route('pm.production-order.show', ['batch_no' => $item->report_num]);
                }
                return $item;
            });


            $items = $items->toArray();
            
            $items= collect($items);
            if (!empty($request['segment1'])) :
               
                $items = $items->filter(function($item) use ($request){
                    return $item['segment1'] == $request['segment1'];
                });
            endif;
            $items= $items->take(100);
            return response()->json($items, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getProcessRequest()
    {
        $processRequestsT = PtpmProcessRequestsT::join('ptpm_summary_batch_v', function ($join) {
            $join->on("PTPM_PROCESS_REQUESTS_T.DEPARTMENT_CODE", "=", "PTPM_SUMMARY_BATCH_V.DEPARTMENT_CODE")
                ->on('PTPM_SUMMARY_BATCH_V.BATCH_NO', '=', 'PTPM_PROCESS_REQUESTS_T.REQUEST_NUMBER');
        })
            ->whereIn('PTPM_SUMMARY_BATCH_V.web_batch_status', ['กำลังผลิต', null])
            ->get()->toArray();

        return $processRequestsT;
    }

    public function productLists(Request $request)
    {

        try {
            $params = [
                'subinventory_code' => $request->filters['subinventory_code'],
                'organization_code' => $request->filters['organization_code'],
                'locator_code' => $request->filters['locator_code'],
                'selectBox' => true
            ];

            $items = $this->repo->getList($params);
           
            return response()->json($items, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

   
    public function store(Request $request)
    {
        try {
            $result = $this->repo->saveFunc($request);
            return response()->json(['result' => $result['report_number']], 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
    public function getTypeOrder() {
        return PtpmJobType::get();
    }
    
}
