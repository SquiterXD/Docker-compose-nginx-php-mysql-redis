<?php
namespace App\Http\Controllers\PM\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Arr;
use App\Models\PM\PtpmWipRequestHeader;
use App\Models\PM\PtpmConvertTransaction;
use App\Repositories\PM\WipRequestRepository;
use App\Models\PM\PtmesProductLine;
use App\Models\PM\PtpmWipRequestLine;
use Illuminate\Support\Facades\DB;

class WipRequestController extends Controller
{

    public function getLines(Request $request)
    {
        $lines = (new WipRequestRepository)->getLines($request);

        $data = [
            'lines' => $lines,
        ];
        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        try {
            $header = (new WipRequestRepository)->store($request);

            $header->refresh();
            $resHeader = request()->header;
            $resHeader['wip_req_header_id'] =  data_get($header, 'wip_req_header_id',  -1);
            $resHeader['wip_request_no'] = data_get($header, 'wip_request_no', date('Ymd-His'));
            $resHeader['can'] = $header->can;

             $data = [
                'status' => 'S',
                'header' => $resHeader
            ];

        } catch (\Exception $e) {
            \Log::error($e);
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }

        return response()->json(['data' => $data]);
    }

    public function setStatus(PtpmWipRequestHeader $header)
    {
        try {
            $status = request()->status;
            $profile = getDefaultData('/pm/wip-requests');
            $sysdate = now();
           

            if ($status == 'infWipCompleted') {
                if ($header->interface_status != 'S' && $header->wip_request_status == 1) {
                    DB::beginTransaction();
                    $result = $header->infWipComplete();
                    $header->refresh();
                    if ($header->interface_status == 'S') {
                        $header->wip_request_status = 2;
                        $header->save();
                        $this->updateMESLine($header, 'INTERFACE');
                        (new PtpmConvertTransaction)->interface($profile, $header->web_batch_no);
                    } else {

                        $msg = $result['msg'];
                        $lines = new \App\Models\PM\PtpmWipRequestLine;
                        $lines = $lines->where('wip_req_header_id', $header->wip_req_header_id)
                                ->get();
                        foreach ($lines as $key => $line) {
                            if ($line->interface_msg && $line->interface_status != 'S') {
                                $msg .= "\n {$line->interface_msg}";
                            }
                        }

                        throw new \Exception($msg);
                    }
                }
            } elseif($status == 'infWipCompletedReturn') {


                if ($header->interface_status == 'S' && $header->wip_request_status = 2) {
                    $reqLines = collect(request()->lines ?? []);
                    $wipReqLineIdList = $reqLines->where('is_selected', true);
                    $wipReqLineIdList = optional(optional($wipReqLineIdList)->pluck('wip_req_line_id', 'wip_req_line_id'))->all();
                    $wipReqLineIdList = $wipReqLineIdList ?? [];

                    if (count($wipReqLineIdList) == 0) {
                        throw new \Exception('กรุณาเลือกรายการยกเลิก');
                    }



                    $batchNo = date("YmdHisu");
                    $header->interface_status = null;
                    $header->attribute1 = null;
                    $header->web_batch_no = "{$header->wip_req_header_id}-{$batchNo}";
                    $header->save();

                    $lines = new \App\Models\PM\PtpmWipRequestLine;
                    $lines = $lines->where('wip_req_header_id', $header->wip_req_header_id)
                                ->where('interface_status', 'S')
                                ->whereIn('wip_req_line_id', $wipReqLineIdList)
                                ->get();

                    // เช็คมีรายการบันทึกข้าม item ไหม
                    $convertTrans = $lines->where('convert_flag', 'Y');
                    if (count($convertTrans) > 0) {
                        $lineTrans = PtpmConvertTransaction::whereIn('wip_req_line_id', $convertTrans->pluck('wip_req_line_id', 'wip_req_line_id')->all())->get();
                        (new PtpmConvertTransaction)->insertCancelTrans($lineTrans, $header);
                        $result = (new PtpmConvertTransaction)->interface($profile, $header->web_batch_no);
                        if ($result['status'] != 'S') {
                            $msg = "ยกเลิกการข้าม item ไม่สำเร็จ: ".$result['msg'];
                            throw new \Exception($msg);
                        }
                    }

                    foreach ($lines as $key => $line) {
                        $line->interface_status = null;
                        $line->cancel_flag = 'Y';
                        $line->cancel_date = $sysdate;
                        $line->cancel_by_id = $profile->user_id;
                        $line->web_batch_no = $header->web_batch_no;
                        $line->save();
                    }


                    $result = $header->infWipComplete();
                    $header->refresh();
                    if ($header->interface_status == 'S') {
                        $resultLines = new \App\Models\PM\PtpmWipRequestLine;
                        $resultLines = $resultLines->where('wip_req_header_id', $header->wip_req_header_id)
                                    ->where('interface_status', 'S')
                                    ->get();

                        if (count($resultLines) == count($lines)) {
                            $header->wip_request_status = 3;
                            $header->save();
                            $this->updateMESLine($header, 'CANCEL_INTERFACE');

                        }
                    } else {

                        $msg = $result['msg'];
                        $lines = new \App\Models\PM\PtpmWipRequestLine;
                        $lines = $lines->where('wip_req_header_id', $header->wip_req_header_id)
                                ->whereIn('wip_req_line_id', $wipReqLineIdList)
                                ->get();
                        if (count($lines) <= 0) {
                            throw new \Exception('กรุณาทำการกด Checkbox และกดปุ่มบันทึกข้อมูลก่อน แล้วค่อยทำการกดปุ่มบันทึกยืนยันข้อมูล!!');
                        }
                        foreach ($lines as $key => $line) {
                            if ($line->interface_msg && $line->interface_status != 'S') {
                                $msg .= "\n {$line->interface_msg}";
                            }
                        }

                        throw new \Exception($msg);
                    }
                }
            } elseif($status == 'cancelTransfer') {
                $header->wip_request_status = 4;
                $header->save();
            }

            $header->updated_by_id      = $profile->user_id;
            $header->last_updated_by    = $profile->fnd_user_id;
            $header->updated_at         = $sysdate;
            $header->last_update_date   = $sysdate;
            $header->save();

            $header->refresh();
            $data = [
                'status' => 'S',
                'wip_request_status' => $header->wip_request_status,
                'can' => $header->can,
                'msg' => ''
            ];

        } catch (\Exception $e) {
            \Log::error($e);
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }
        return response()->json(['data' => $data]);
    }

    public function updateMESLine(PtpmWipRequestHeader $header, $source)
    {
        $organizationCode = $header->organization->organization_code;
        if ($organizationCode == 'MG6' || $organizationCode == 'M05') {

            $lines = new \App\Models\PM\PtpmWipRequestLine;
            $lines = $lines->where('wip_req_header_id', $header->wip_req_header_id)
                        ->where('interface_status', 'S')
                        ->get();

            foreach ($lines as $key => $line) {
                $mesLines = PtmesProductLine::query()
                            ->where('organization_id', $header->organization_id)
                            ->whereRaw("TRUNC(PRODUCT_DATE) = TO_DATE('{$header->transaction_date->format('Y-m-d')}', 'YYYY-mm-dd')")
                            ->where('batch_id', $line->batch_id)
                            ->where('inventory_item_id', $line->inventory_item_id)
                            ->orderBy('wip_step', 'desc')
                            ->first();

                // $mesLines = PtmesProductLine::whereDate('product_date', $header->transaction_date)
                //             ->where('batch_id', $line->batch_id)
                //             ->where('inventory_item_id', $line->inventory_item_id)
                //             ->where('organization_id', $line->organization_id)
                //             ->where('uom', $line->transaction_uom_code)
                //             ->first();

                if ($source == 'INTERFACE') {
                    $attribute3 = 'Y';
                }

                if ($source == 'CANCEL_INTERFACE') {
                    $attribute3 = null;
                }


                $db = DB::statement("UPDATE ptmes_product_line SET attribute3='{$attribute3}'  
                WHERE batch_id = '{$line->batch_id}' 
                AND wip_step='{$mesLines->wip_step}' 
                AND organization_id = '{$header->organization_id}' 
                AND inventory_item_id='{$line->inventory_item_id}'
                AND TRUNC(PRODUCT_DATE) = TO_DATE('{$header->transaction_date->format('Y-m-d')}', 'YYYY-MM-DD')");

               
                // foreach ($mesLines ?? [] as $key => $mesline) {
                //     $mesline->attribute3 = $attribute3;
                //     $mesline->save();
                // }
            }
        }
    }
}
