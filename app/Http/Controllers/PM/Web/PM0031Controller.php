<?php

namespace App\Http\Controllers\PM\Web;

use App\Http\Controllers\PM\Api\PM0031ApiController;
use App\Models\Lookup\PtmesProductHeaderLookup;
// use App\Models\Lookup\PtpmSummaryBatchVLookup;
// use App\Models\PM\PtmesProductDistribution;
// use App\Models\PM\PtmesProductLine;
// use App\Models\PM\PtpmManufactureStep;

use App\Models\PM\PtpmOpmRoutingV;
use App\Models\PM\PtpmProductBatchV;
use App\Models\PM\PtpmProductHeader;
use App\Models\PM\PtpmProductLine;

use App\Models\PM\PtBiweeklyV;
use App\Models\PM\PtInvUomV;

use Illuminate\Http\Request;

use DB;

class PM0031Controller extends BaseController
{
    /**
     * @var PM0031ApiController
     */
    private $api;

    /**
     * PM0031Controller constructor.
     * @param PM0031ApiController $api
     */
    public function __construct(PM0031ApiController $api)
    {
        $this->api = $api;
    }

    public function index(Request $request)
    {
        
        // $db     =   \DB::connection('oracle')->getPdo();

        // $sql    =   "
        //                 declare
        //                     v_status         varchar2(5);
        //                     v_err_msg        varchar2(2000);
        //                 begin

        //                                PTPM_MICS_PKG.batch_load( V_MESSAGE     =>  :v_err_msg
        //                                                     ,V_STATUS   => :v_status);
        //                                 dbms_output.put_line('Status : ' || v_status);
        //                                 dbms_output.put_line('Error : ' || v_err_msg);
        //                 end;
        //             ";

        // $result = null;
        
        // # $sql = preg_replace("/[\r\n]*/","",$sql);

        // \Log::info('PM0031Controller', [$sql]);

        // $stmt = $db->prepare($sql);
        // $stmt->bindParam(':v_status', $result['status'], \PDO::PARAM_STR, 10);
        // $stmt->bindParam(':v_err_msg', $result['message'], \PDO::PARAM_STR, 4000);
        // $stmt->execute();

        // \Log::info('PM0031Controller', [$result]);

        $user = auth()->user();
        $defaultData = getDefaultData();
        $departmentCode = $user->department_code;
        $organizationId = $user->organization_id;

        $resGetBatches = $this->api->getBatches($request)->getData();
        $resGetListBatchHeaders = $this->api->getListBatchHeaders($request)->getData();
        $resGetJobWipSteps = $this->api->getWipSteps($request)->getData();
        $resGetProductInfo = $this->api->index($request)->getData();

        $biweekly = self::findBiweekly(date('Y-m-d'));

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
            $datePeriods->mindate = parse_to_date_th($datePeriods->mindate);
            $datePeriods->maxdate = parse_to_date_th($datePeriods->maxdate);
        }

        // $invItemList = PtpmProductBatchV::select(DB::raw("inventory_item_id, item_no, item_desc, item_no || ' : ' || item_desc as item_full_desc"))
        //     ->where('organization_id', $organizationId)
        //     ->groupBy('inventory_item_id', 'item_no','item_desc')
        //     ->orderBy('item_no')
        //     ->forUserProcess()
        //     ->where('batch_id', 187752)
        //     ->get();

        //  $wipList = PtpmProductBatchV::selectRaw("wip_step as value, wip_step as label")
        //     ->where('organization_id', $organizationId)
        //     ->whereNotNull('wip_step')
        //     ->groupBy('wip_step')
        //     ->forUserProcess()
        //     ->where('batch_id', 187752)
        //     ->orderBy('label')
        //     ->get();
        $batchHeaders = [];
        $invItemList = [];
        $wipList = [];
        if (count($resGetListBatchHeaders->batch_header_list)) {
            $headers = collect($resGetListBatchHeaders->batch_header_list);
            $batchHeaders = $headers->groupBy('batch_id')->map(function ($group) {
                            $line = $group->first();
                            $data = [];
                            $data['batch_full_desc']        = "$line->batch_no : $line->item_desc";
                            $data['organization_id']        = "$line->organization_id";
                            $data['batch_no']               = "$line->batch_no";
                            $data['batch_id']               = "$line->batch_id";
                            $data['inventory_item_id']      = "$line->inventory_item_id";
                            $data['item_no']                = "$line->item_no";
                            $data['item_desc']              = "$line->item_desc";
                            $data['actual_start_date']      = "$line->actual_start_date";
                            return $data;
                        })
                        ->sortBy('batch_no')
                        ->toArray();
            $invItemList = $headers->groupBy('inventory_item_id')->map(function ($group) {
                            $line = $group->first();
                            $data = [];
                            $data['inventory_item_id']      = "$line->inventory_item_id";
                            $data['item_no']                = "$line->item_no";
                            $data['item_desc']              = "$line->item_desc";
                            $data['item_full_desc']         = "$line->item_no : $line->item_desc";
                            return $data;
                        })
                        ->sortBy('item_no')
                        ->toArray();
            $wipList    = $headers->groupBy('wip_step')->map(function ($group) {
                            $line = $group->first();
                            $data = [];
                            $data['value']  = "$line->wip_step";
                            $data['label']  = "$line->wip_step";
                            return $data;
                        })
                        ->sortBy('label')
                        ->toArray();

            $batchHeaders = array_values($batchHeaders);
            $invItemList = array_values($invItemList);
        }

        $uomCodes = PtInvUomV::getListUomCodes()->get();

        return $this->vue('pm-0031', [
            'user'                  => $user,
            'defaultdata'           => $defaultData,
            'biweekly_start_date'   => parse_to_date_th($biweekly->start_date),
            'product_date'          => $request->product_date,
            'batch_no'              => $request->batch_no,
            'batch_id'              => $request->batch_id,
            'wip_step'              => $request->wip_step,
            'job_wip_steps'         => $resGetJobWipSteps->job_wip_steps,
            'batch_header'          => $resGetBatches->batch_header,
            'batch_lines'           => $resGetBatches->batch_lines,
            // 'batch_header_list'     => $resGetListBatchHeaders->batch_header_list,
            'batch_header_list'     => $batchHeaders,
            'wip_list'              => $wipList,
            'inv_item_list'         => $invItemList,
            'uom_codes'             => $uomCodes,
            'header'                => $resGetProductInfo->header,
            'receive_wip_header'    => $resGetProductInfo->receive_wip_header,
            'previous_wip_header'   => $resGetProductInfo->previous_wip_header,
            'lines'                 => $resGetProductInfo->lines,
            'receive_wip_lines'     => $resGetProductInfo->receive_wip_lines,
            'previous_wip_lines'    => $resGetProductInfo->previous_wip_lines,
            'min_max_date_period'   => $datePeriods,
        ]);
    }

    public static function findBiweekly($date)
    {
       $findBiweekly = PtBiweeklyV::whereRaw("TRUNC(TO_DATE('{$date}','YYYY-MM-DD')) BETWEEN START_DATE AND END_DATE")->first();
        return $findBiweekly;
    }

}
