<?php

namespace App\Http\Controllers\PM\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;
use App\Helpers\Utils;
// use Exception;
use Illuminate\Http\JsonResponse;
use App\Models\PM\PtmesProductLine;
use App\Models\PM\PtpmRequestSummaryV;
use App\Models\PM\PtmesTobaccoTransR01V;
use App\Models\PM\PtmpMesReviewIssueV;

use App\Models\PM\PtpmProductLine;
use App\Models\PM\PtpmWipRequestLine;
use App\Models\PM\PtpmWipRequestHeader;
use App\Models\PM\PtpmWipStepByBatchV;
use App\Models\PM\PtpmPmp0044ListJobsV;
use Carbon\Carbon;

class PM0038ApiController extends Controller
{
    public function close_job(Request $request)
    {
        $profile = getDefaultData("/pm/production-order-list");
        $res = [];
        DB::beginTransaction();
        try {
            foreach ($request->input('checked_requests') as $checked_Request) {

                $batch = PtpmRequestSummaryV::where('batch_id', $checked_Request)
                        ->where('organization_id', $profile->organization_id)
                        ->first();
                // $sql = "
                //      declare
                //         v_status         varchar2(200);
                //         v_err_msg        varchar2(5000);
                //      begin
                //         APPS.PTPM_MICS_PKG.CLOSE_BATCH(p_batch_id => $checked_Request,
                //         x_status       => :v_status,
                //         x_message      => :v_err_msg);
                //         dbms_output.put_line(:v_status);
                //         dbms_output.put_line(:v_err_msg);
                //      end;
                // ";

                $sql = "
                    declare
                        v_status            varchar2(20);
                        v_err_msg           varchar2(2000);
                    begin
                        ptpm_main.change_batch_status ( p_org_code => '$profile->organization_code',
                                                    p_batch_no  => '$batch->request_number',
                                                    p_new_batch_status => 'Closed',
                                                    p_new_request_status  => '5',
                                                    p_user_name => '$profile->fnd_user_name',
                                                    p_response => 'OPM ALL',
                                                    p_app_short_name => 'GMD',
                                                    p_status => :v_status,
                                                    p_exception => :v_err_msg);

                        dbms_output.put_line('Status : ' || v_status);
                        dbms_output.put_line('Error msg : ' || v_err_msg);
                    end;
                ";

                \Log::info('App\Http\Controllers\PM\Api\PM0038ApiController@close_job');
                \Log::info($sql);

                //echo $sql;
                $response = [];
                $stmt = DB::connection('oracle')->getPdo()->prepare($sql);
                $stmt->bindParam(":v_status", $response['v_status'], PDO::PARAM_STR, 200);
                $stmt->bindParam(":v_err_msg", $response['v_err_msg'], PDO::PARAM_STR, 5000);
                $stmt->execute();
                $res[] = $response;
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            print_r('print r $e : ');
            print_r($e);

            return response()->json([
                'err' => $e,
            ], 500);
        }

//        print_r("/n");
//        print_r('print r not catch : ');
//        print_r($res);

        return response()->json([
            'res' => $res,
        ]);
    }

    public function cancelCloseJob(Request $request)
    {
        $profile = getDefaultData("/pm/production-order-list");
        $res = [];
        try {
            if (count($request->input('checked_requests') ?? []) == 0) {
                $res[] = [
                    'v_status' => 'E',
                    'v_err_msg' => 'กรุณาเลือกเลขที่คำสั่งผลิต',
                ];
                return response()->json([
                    'res' => $res,
                ]);
            }

            $batchs = PtpmRequestSummaryV::whereIn('batch_id', $request->input('checked_requests') ?? [])
                        ->where('organization_id', $profile->organization_id)
                        ->get();

            if (count($batchs) != count($batchs->where('batch_status', 'Closed'))) {

                foreach ($batchs->where('batch_status', '!=', 'Closed') as $key => $batch) {
                    $res[] = [
                        'v_status' => 'E',
                        'v_err_msg' => "เลขที่คำสั่งการผลิต $batch->request_number : สถานะคำสั่งผลิตต้องเป็น ปิดคำสั่งการผลิตแล้วเท่านั้น",
                    ];
                }
                return response()->json([
                    'res' => $res,
                ]);
            }

            foreach ($batchs as $batch) {
                // $sql = "
                //     declare
                //         v_status            varchar2(20);
                //         v_err_msg           varchar2(4000);
                //     begin
                //         ptopm_utilities.change_batch_status ( p_org_code  => '$profile->organization_code',
                //                                     p_batch_no => '$batch->request_number',
                //                                     p_new_batch_status => 'WIP',
                //                                     p_user_name => '$profile->fnd_user_name',
                //                                     p_response => 'OPM ALL',
                //                                     p_app_short_name => 'GMD',
                //                                     p_status => :v_status,
                //                                     p_exception => :v_err_msg);
                //         dbms_output.put_line('Status : ' || v_status);
                //         dbms_output.put_line('Error msg : ' || v_err_msg);
                //     end;
                // ";

                // p_new_batch_status => 'WIP'     --batch status
                // p_new_request_status  => '2' --new web job status
                $sql = "
                    declare
                        v_status            varchar2(20);
                        v_err_msg           varchar2(2000);
                    BEGIN
                        ptpm_main.change_batch_status ( p_org_code     => '$profile->organization_code',
                                                    p_batch_no         => '$batch->request_number',
                                                    p_new_batch_status => 'WIP',
                                                    p_new_request_status  => '2',
                                                    p_user_name => '$profile->fnd_user_name',
                                                    p_response => 'OPM ALL',
                                                    p_app_short_name => 'GMD',
                                                    p_status => :v_status,
                                                    p_exception => :v_err_msg);

                        dbms_output.put_line('Status : ' || v_status);
                        dbms_output.put_line('Error msg : ' || v_err_msg);
                    end;
                ";

                \Log::info('App\Http\Controllers\PM\Api\PM0038ApiController@cancelCloseJob');
                \Log::info($sql);

                //echo $sql;
                $response = [];
                $stmt = DB::connection('oracle')->getPdo()->prepare($sql);
                $stmt->bindParam(":v_status", $response['v_status'], PDO::PARAM_STR, 200);
                $stmt->bindParam(":v_err_msg", $response['v_err_msg'], PDO::PARAM_STR, 5000);
                $stmt->execute();
                $response = [
                    'v_status' => $response['v_status'],
                    'v_err_msg' => "เลขที่คำสั่งการผลิต $batch->request_number : ". $response['v_err_msg'],
                ];

                $res[] = $response;
            }
        } catch (\Exception $e) {
            \Log::error($e);

            return response()->json([
                'err' => $e,
            ]);
        }

        return response()->json([
            'res' => $res,
        ]);
    }

    public function productDetail(Request $request)
    {
        $requestSummary = json_decode($request->request_summary);
        $flagType       = $request->flag_type;
        $organizationId = $requestSummary->organization_id;
        $batchId        = $requestSummary->batch_id;
        $uom            = $requestSummary->request_uom;
        $maxWipstep = collect(\DB::SELECT("
            SELECT    max(substr(oprn.oprn_no,1,instr(oprn.oprn_no,'-')-1)) wip_step
            FROM    apps.fm_rout_hdr frh,
                    apps.fm_rout_dtl frd,
                    apps.gmd_operations_vl oprn
            WHERE   frh.routing_id = (
                        select routing_id from gme_batch_header
                        where 1=1
                        and gme_batch_header.batch_id = $batchId
                        and gme_batch_header.organization_id = $organizationId
                    )
            AND     frh.routing_id = frd.routing_id
            AND     frd.oprn_id = oprn.oprn_id
        "));
        $maxWipstep = optional($maxWipstep->first())->wip_step ?? '';


        $org = \App\Models\MtlParameter::where('organization_id', $organizationId)->first();

        if ($org->organization_code == 'M02' || $org->organization_code == 'M03') {
            $mesLines = [];
            if ($flagType == 'wip_flag') {
                $trans = PtmesTobaccoTransR01V::selectRaw("
                                    distinct organization_id, TRUNC(wip_date) wip_date
                                    , to_char(wip_date, 'YYYYMMDD') transaction_date_number
                                ")
                                ->where('organization_id', $organizationId)
                                ->whereNotNull('wip_date')
                                ->where('batch_no', $requestSummary->request_number)
                                ->where('wip_step', $maxWipstep)
                                ->orderBy('wip_date')
                                ->get();

                $mesLines = PtpmWipStepByBatchV::selectRaw("
                                    distinct organization_id, TRUNC(transaction_date) transaction_date
                                    , to_char(transaction_date, 'YYYYMMDD') transaction_date_number
                                ")
                                ->where('organization_id', $organizationId)
                                ->whereNotNull('transaction_date')
                                ->whereNotNull('confirm_qty')
                                ->where('batch_no', $requestSummary->request_number)
                                ->where('wip_step', $maxWipstep)
                                ->orderBy('transaction_date')
                                ->get();


                $mesLines = $mesLines->map(function ($row) use($request, $flagType, $requestSummary, $trans) {
                    $newRow = (object) [];
                    $newRow->organization_id    = $row->organization_id;
                    $newRow->batch_id           = $requestSummary->batch_id;
                    $newRow->product_date_format = $row->transaction_date ? parseToDateTh($row->transaction_date) : '';
                    // $newRow->is_checked         = $trans->where('transaction_date_number', $row->transaction_date_number)->isNotEmpty();
                    $newRow->is_checked         = !!$row->transaction_date_number;
                    return $newRow;
                });
            }

            if ($flagType == 'issue_flag') {
                // $mesLines = PtmpMesReviewIssueV::selectRaw("
                //                     distinct organization_id, TRUNC(transaction_date) transaction_date
                //                     , (
                //                         SELECT  distinct nvl(issue_item_class_01_flag, issue_item_class_02_flag) issue_flag
                //                         from    PTPM_MES_REVIEW_ISSUE_V msi2
                //                         where   msi2.organization_id = PTPM_MES_REVIEW_ISSUE_V.organization_id
                //                         and     msi2.batch_no = PTPM_MES_REVIEW_ISSUE_V.batch_no
                //                         and     TRUNC(msi2.transaction_date) = TRUNC(PTPM_MES_REVIEW_ISSUE_V.transaction_date)
                //                         and     (msi2.issue_item_class_01_flag is not null or msi2.issue_item_class_01_flag is not null)
                //                     ) issue_flag
                //                 ")
                //                 ->where('organization_id', $organizationId)
                //                 ->where('batch_no', $requestSummary->request_number)
                //                 ->whereNotNull('transaction_date')
                //                 ->orderBy('transaction_date')
                //                 ->get();

                // New Query By P'P 20230809 -- Piyawut A.
                $mesLines = collect(\DB::SELECT("
                    select  pwsb.transaction_date,  pwsb.organization_id,
                            nvl((select   distinct 'Y'
                            from    ptpm_mes_review_issue_headers pmrih
                            where   pmrih.organization_id = pwsb.organization_id
                            and     pmrih.batch_id = pwsb.batch_id
                            and     substr(pmrih.wip_step,1,5) = pwsb.wip_step
                            and     pmrih.issue_date = pwsb.transaction_date
                            and     pmrih.interface_status = 'S'
                            and     nvl(pmrih.cancel_flag,'N') = 'N'),'N') issue_flag
                    from    PTPM_WIP_STEP_BY_BATCH_V pwsb,
                            mtl_parameters mp,
                            ptpm_wip_step_v pws
                    where   pwsb.wip_step <> (select  max(pwp.wip_step)
                                            from    PTCT_WIP_PROCESS_V pwp
                                            where   pwp.opm_org_code = pwsb.organization_code)    
                    and    batch_no = '{$requestSummary->request_number}'
                    and    pws.organization_code = mp.organization_code
                    and    pwsb.organization_id = mp.organization_id
                    and    pws.attribute4 = 'Y'
                    and    pwsb.wip_step = pws.wip_step
                    and    pws.rout_id = (select    gbh.routing_id
                                            from    GME_BATCH_HEADER gbh
                                            where   gbh.batch_id = pwsb.batch_id
                                            and     gbh.organization_id = pwsb.organization_id)                       
                    group by pwsb.organization_id,pwsb.batch_id,pwsb.wip_step,pwsb.transaction_date
                    having sum(pwsb.confirm_issue_qty) > 0
                    order by transaction_date
                "));

                $mesLines = $mesLines->map(function ($row) use($request, $flagType, $requestSummary) {
                    $newRow = (object) [];
                    $newRow->organization_id    = $row->organization_id;
                    $newRow->batch_id           = $requestSummary->batch_id;
                    $newRow->product_date_format = $row->transaction_date ? parseToDateTh($row->transaction_date) : '';
                    $newRow->is_checked = $row->issue_flag == 'Y';
                    return $newRow;
                });
            }

            if ($flagType == 'complete_flag') {

                // $maxWipstep = collect(\DB::SELECT("
                //     SELECT    max(substr(oprn.oprn_no,1,instr(oprn.oprn_no,'-')-1)) wip_step
                //     FROM    apps.fm_rout_hdr frh,
                //             apps.fm_rout_dtl frd,
                //             apps.gmd_operations_vl oprn
                //     WHERE   frh.routing_id = (
                //                 select routing_id from gme_batch_header
                //                 where 1=1
                //                 and gme_batch_header.batch_id = $batchId
                //                 and gme_batch_header.organization_id = $organizationId
                //             )
                //     AND     frh.routing_id = frd.routing_id
                //     AND     frd.oprn_id = oprn.oprn_id
                // "));
                // $maxWipstep = optional($maxWipstep->first())->wip_step ?? '';
                // // batch_id
                // $lines = PtpmProductLine::where('organization_id', $organizationId)
                //             ->where('batch_id', $requestSummary->batch_id)
                //             ->where('wip_step', $maxWipstep)
                //             ->orderBy('product_date')
                //             ->get();

                $lines = PtpmPmp0044ListJobsV::selectRaw("
                                organization_id
                                , batch_id
                                , batch_no
                                , transaction_date as product_date
                                , sum(confirm_qty) as product_qty
                            ")
                            ->where('organization_id', $organizationId)
                            ->where('batch_id', $requestSummary->batch_id)
                            ->whereNotNUll('confirm_qty')
                            ->groupBy(['organization_id', 'batch_id', 'batch_no', 'transaction_date'])
                            ->orderBy('transaction_date')
                            ->get();

                $wipLines = PtpmWipRequestLine::where('organization_id', $organizationId)
                            ->where('batch_id', $requestSummary->batch_id)
                            ->where('interface_status', 'S')
                            ->whereNull('cancel_flag')
                            ->whereNull('deleted_at')
                            ->get();
                // dd('xx', $lines, $wipLines);
                $wipHeaders = [];
                $wipReqHeaderIdList = [];
                if (count($wipLines)) {
                    $wipReqHeaderIdList = $wipLines->pluck('wip_req_header_id', 'wip_req_header_id')->all();

                    $headerTable = (new PtpmWipRequestHeader)->getTable();
                    $wipHeaders = PtpmWipRequestHeader::selectRaw("
                                        {$headerTable}.*
                                        , to_char({$headerTable}.transaction_date, 'YYYYMMDD') transaction_date_number
                                    ")
                                    ->whereIn('wip_req_header_id', $wipReqHeaderIdList)
                                    ->get();
                }

                $mesLines = $lines->map(function ($row) use($request, $flagType, $requestSummary, $wipHeaders, $lines, $wipLines) {
                    $newRow = (object) [];
                    $newRow->organization_id    = $row->organization_id;
                    $newRow->batch_id           = $requestSummary->batch_id;
                    $newRow->product_date_format = $row->product_date ? parseToDateTh($row->product_date) : '';
                    $newRow->is_checked = false;

                    $sumTransactionQuantity = -999;
                    if (count($wipHeaders)) {
                        $transtions = $wipHeaders->where('transaction_date_number', Carbon::parse($row->product_date)->format('Ymd'));
                        if (count($transtions)) {
                            $sumTransactionQuantity = $wipLines->whereIn('wip_req_header_id', $transtions->pluck('wip_req_header_id', 'wip_req_header_id')->all())
                                                        ->sum('transaction_quantity');
                        }

                        $newRow->is_checked = number_format($sumTransactionQuantity, 5) == number_format($row->product_qty, 5);
                    }
                    return $newRow;
                });
            }
        } elseif ($org->organization_code == 'M12' || ($org->organization_code == 'M06')) {
            $mesLines = [];
            if ($flagType == 'wip_flag') {

                $trans = PtpmWipStepByBatchV::selectRaw("
                            batch_id, organization_id, TRUNC(transaction_date) transaction_date
                        ")
                        ->where('organization_id', $organizationId)
                        ->where('batch_no', $requestSummary->request_number)
                        ->whereRaw('nvl(confirm_qty, 0)  > 0')
                        ->whereNotNull('transaction_date')
                        ->groupByRaw("batch_id, organization_id, TRUNC(transaction_date)")
                        ->orderBy('transaction_date')
                        ->get();

                $mesLines = $trans->map(function ($row) {
                    $newRow = (object) [];
                    $newRow->organization_id    = $row->organization_id;
                    $newRow->batch_id           = $row->batch_id;
                    $newRow->product_date_format = $row->transaction_date ? parseToDateTh($row->transaction_date) : '';
                    $newRow->is_checked         = true;
                    return $newRow;
                });
            }

            if ($flagType == 'issue_flag') {
                $mesLines = PtmpMesReviewIssueV::selectRaw("
                                batch_id, wip_step, organization_id, TRUNC(transaction_date) transaction_date,
                                (
                                    SELECT  DISTINCT 1
                                    FROM    ptpm_mes_review_issue_headers pmrih
                                    WHERE   pmrih.organization_id = ptpm_mes_review_issue_v.organization_id
                                    AND pmrih.batch_id = ptpm_mes_review_issue_v.batch_id
                                    AND pmrih.wip_step like  ''|| ptpm_mes_review_issue_v.wip_step || '%'
                                    AND pmrih.interface_status = 'S'
                                    AND TRUNC(complete_date) = TRUNC(ptpm_mes_review_issue_v.transaction_date)
                                    AND pmrih.issue_status = 2
                                    AND NVL (pmrih.cancel_flag, 'N') = 'N'
                                ) is_checked
                            ")
                            ->where('organization_id', $organizationId)
                            ->where('batch_no', $requestSummary->request_number)
                            ->whereNotNull('transaction_date')
                            ->orderBy('transaction_date')
                            ->groupByRaw("batch_id, wip_step, organization_id, TRUNC(transaction_date)")
                            ->get();
                $mesLines = $mesLines->map(function ($row) {
                    $newRow = (object) [];
                    $newRow->organization_id    = $row->organization_id;
                    $newRow->batch_id           = $row->batch_id;
                    $newRow->product_date_format = $row->transaction_date ? parseToDateTh($row->transaction_date) : '';
                    $newRow->is_checked         = $row->is_checked == 1;
                    return $newRow;
                });
            }

            if ($flagType == 'complete_flag') {
                $lines = PtpmPmp0044ListJobsV::selectRaw("
                                organization_id
                                , batch_id
                                , batch_no
                                , transaction_date as product_date
                                , sum(confirm_qty) as product_qty
                            ")
                            ->where('organization_id', $organizationId)
                            ->where('batch_id', $requestSummary->batch_id)
                            ->whereNotNUll('confirm_qty')
                            ->groupBy(['organization_id', 'batch_id', 'batch_no', 'transaction_date'])
                            ->orderBy('transaction_date')
                            ->get();

                $wipLines = PtpmWipRequestLine::where('organization_id', $organizationId)
                            ->where('batch_id', $requestSummary->batch_id)
                            ->where('interface_status', 'S')
                            ->whereNull('cancel_flag')
                            ->whereNull('deleted_at')
                            ->get();
                // dd('xx', $lines, $wipLines);
                $wipHeaders = [];
                $wipReqHeaderIdList = [];
                if (count($wipLines)) {
                    $wipReqHeaderIdList = $wipLines->pluck('wip_req_header_id', 'wip_req_header_id')->all();

                    $headerTable = (new PtpmWipRequestHeader)->getTable();
                    $wipHeaders = PtpmWipRequestHeader::selectRaw("
                                        {$headerTable}.*
                                        , to_char({$headerTable}.transaction_date, 'YYYYMMDD') transaction_date_number
                                    ")
                                    ->whereIn('wip_req_header_id', $wipReqHeaderIdList)
                                    ->get();
                }

                $mesLines = $lines->map(function ($row) use($request, $flagType, $requestSummary, $wipHeaders, $lines, $wipLines) {
                    $newRow = (object) [];
                    $newRow->organization_id    = $row->organization_id;
                    $newRow->batch_id           = $requestSummary->batch_id;
                    $newRow->product_date_format = $row->product_date ? parseToDateTh($row->product_date) : '';
                    $newRow->is_checked = false;

                    $sumTransactionQuantity = -999;
                    if (count($wipHeaders)) {
                        $transtions = $wipHeaders->where('transaction_date_number', Carbon::parse($row->product_date)->format('Ymd'));
                        if (count($transtions)) {
                            $sumTransactionQuantity = $wipLines->whereIn('wip_req_header_id', $transtions->pluck('wip_req_header_id', 'wip_req_header_id')->all())
                                                        ->sum('transaction_quantity');
                        }

                        $newRow->is_checked = number_format($sumTransactionQuantity, 5) == number_format($row->product_qty, 5);
                    }
                    return $newRow;
                });
            }

        }else {
            $mesLines = $this->getproductDetail($request, $requestSummary, $flagType, $organizationId, $batchId, $uom);
        }

        if (count($mesLines)) {
            $mesLines = $mesLines->toArray();
        }

        $data = [
            'mes_lines' => $mesLines
        ];

        return response()->json(['data' => $data]);
    }


    private function getproductDetail($request, $requestSummary, $flagType, $organizationId, $batchId, $uom)
    {
        $maxWipstep = collect(\DB::SELECT("
            SELECT    max(substr(oprn.oprn_no,1,instr(oprn.oprn_no,'-')-1)) wip_step
            FROM    apps.fm_rout_hdr frh,
                    apps.fm_rout_dtl frd,
                    apps.gmd_operations_vl oprn
            WHERE   frh.routing_id = (
                        select routing_id from gme_batch_header
                        where 1=1
                        and gme_batch_header.batch_id = $batchId
                        and gme_batch_header.organization_id = $organizationId
                    )
            AND     frh.routing_id = frd.routing_id
            AND     frd.oprn_id = oprn.oprn_id
        "));
        $maxWipstep = optional($maxWipstep->first())->wip_step ?? '';

        $cols = [
            'organization_id',
            'batch_id',
            'uom',
            'product_date',
            'wip_step',
            'attribute2',
            'transaction_flag',
            'attribute3',
        ];

        $mesLineTable = (new PtmesProductLine)->getTable();
        $mesLines = PtmesProductLine::where('organization_id', $organizationId)
                        ->where('batch_id', $batchId)
                        // ->where('uom', $uom)
                        ->where('wip_step', $maxWipstep)
                        ->select($cols)
                        ->orderBy('wip_step')
                        ->orderBy('product_date')
                        // ->groupBy($cols)
                        ->get();
        // dd('zz', $organizationId, $batchId, $maxWipstep, $uom, $mesLines->toArray());

        $mesLines = $mesLines->map(function ($row) use($request, $flagType) {
            // wip_flag
            // check_flag
            // issue_flag
            // complete_flag
            $row->is_checked = false;
            if ($flagType == 'wip_flag') {
                $row->is_checked = ($row->attribute2 == 'Y');
            }
            if ($flagType == 'issue_flag') {
                $row->is_checked = ($row->transaction_flag == 'Y');
            }
            if ($flagType == 'complete_flag') {
                $row->is_checked = ($row->attribute3 == 'Y');
            }
            return $row;
        });

        return $mesLines;
    }

}
