<?php
namespace App\Repositories\PM;

use App\Models\Lookup\PtpmItemConvUomVLookup;
use Illuminate\Database\Eloquent\Collection;

use DB;
use Arr;
use Carbon\Carbon;
use App\Models\PM\PtBiweeklyV;
use App\Models\PM\PtpmWipRequestHeader;
use App\Models\PM\PtpmWipRequestLine;
use App\Models\PM\PtpmCompleteStatus;
use App\Models\PM\PtpmItemNumberV;

// use App\Models\PM\PtpmMesReviewIssueHeaders;
// use App\Models\PM\PtpmMesReviewIssueLines;
use App\Models\PM\PtpmMesReviewJobHeaders;
use App\Models\PM\PtpmMesReviewJobLines;
use App\Models\PM\PtpmPmp0044ListJobsV;

use App\Models\PM\PtpmSetupMfgDepartmentsV;
use App\Repositories\PM\CommonRepository;
use App\Models\PM\PtInvUomV;

use App\Models\PM\Settings\PtpmConvertItemsInfo;
use App\Models\PM\PtpmConvertTransaction;

class WipRequestRepository
{
    const url = '/pm/wip-requests';
    function getProfile()
    {
        $data = getDefaultData($this::url);
        return $data;
    }

    function info($request)
    {
        $profile = getDefaultData('/pm/wip-requests');
        //สถานะขอเบิก
        $requestStatusList = PtpmCompleteStatus::select(['LOOKUP_CODE', 'MEANING', 'DESCRIPTION'])
                                ->active()
                                ->get();

        $data = (object)[];
        $data->request_status_list = collect(optional($requestStatusList)->toArray() ?? []);

        $model = new PtpmWipRequestHeader();
        $can = $model->can;
        $header                         = (object)[];
        $header->can                    = $can;
        $header->wip_request_no         = '';
        $header->wip_request_status     = optional($requestStatusList->first())->lookup_code ?? "1";
        $header->transaction_date_format= parseToDateTh(now());
        // $header->transaction_date_format= parseToDateTh('2021-07-09');

        $transDate  = trans('date');
        $transBtn   = trans('btn');
        $requestAll = $request->all();
        $url        = $this->url($request, $headerId = -999);

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

    function url($request, $headerId = -999)
    {
        $url                    = (object)[];
        $preFixRoute            = 'pm.wip-requests';
        $preFixAjaxRoute        = 'pm.ajax.wip-requests';
        $url->index             = route("{$preFixRoute}.index", request()->all() ?? []);
        $url->ajax_store        = route("{$preFixAjaxRoute}.store");
        $url->ajax_get_lines    = route("{$preFixAjaxRoute}.get-lines");
        $url->ajax_get_item     = route("{$preFixAjaxRoute}.get-item");
        $url->ajax_set_status   = route("{$preFixAjaxRoute}.set-status", $headerId);
        return $url;
    }

    function getLines($request)
    {
        $headerReq = json_decode($request->header ?? []);
        $action = $request->action;

        $commonRepo = new CommonRepository;
        $profile        = getDefaultData('/pm/wip-requests');
        $organizationId = $profile->organization_id;

        if ($headerId = data_get($headerReq, 'wip_req_header_id', false)) {
        // if ($headerId = 22) {
            $header = PtpmWipRequestHeader::find($headerId);
            $organizationId = data_get($header, 'organization_id', $profile->organization_id);

            if ($action == 'search') {
                $hasChange = false;
                if ($header->transfer_objective != $headerReq->transfer_objective) {
                    $header->transfer_objective = $headerReq->transfer_objective;
                    $hasChange = true;
                }

                if ($hasChange) {
                    $header->save();
                }
                $lines = PtpmWipRequestLine::where('wip_req_header_id', $headerId)->get();
                foreach ($lines as $key => $line) {
                    $line->deleted_by_id = $profile->user_id;
                    $line->save();
                    $line->delete();
                }
            }
        } else {
            $header = $headerReq;
        }
        $transactionDate = parseFromDateTh($header->transaction_date_format);

        $jobHeaders = collect([]);
        $jobLines = PtpmWipRequestLine::where('wip_req_header_id', $headerId)->get();
        data_set($jobLines, '*.has_map', false);
        if ($header->can->edit) {
            // transaction_date_format
            // $wipStep = 'WIP02';
            // if ($profile->organization_id == 174) {
            //     $wipStep = 'WIP01';
            // }

            $transactionDate = parseFromDateTh($header->transaction_date_format);
            $jobHeaders = PtpmPmp0044ListJobsV::selectRaw("
                                organization_id
                                , inventory_item_id
                                , opt
                                , opt_plan_uom
                                , batch_id
                                , batch_no
                                , transaction_date
                                , wip_step
                                , convert_flag
                                , sum(confirm_qty) confirm_qty
                            ")
                            ->whereDate('transaction_date', $transactionDate)
                            ->where('organization_id', $profile->organization_id)
                            // ->where('wip_step', $wipStep)
                            ->whereNotNUll('confirm_qty')
                            ->groupBy(['organization_id', 'inventory_item_id', 'opt', 'opt_plan_uom', 'batch_id', 'batch_no', 'transaction_date', 'wip_step', 'convert_flag'])
                            ->orderBy('batch_no')
                            ->orderBy('opt')
                            ->get();

            $jobHeaders = collect($jobHeaders)->map(function ($row) use ($jobLines, $header, $transactionDate) {
                $item = PtpmItemNumberV::select([
                                'organization_id',
                                'blend_no',
                                'item_number',
                                'item_desc',
                                'primary_unit_of_measure',
                                'tobacco_group_code'
                            ])
                            ->where('inventory_item_id', $row->inventory_item_id)
                            ->where('organization_id', $row->organization_id)
                            ->first();

                $uom = PtInvUomV::where('uom_code', $row->opt_plan_uom)->first();

                $setup = $this->getSubinvDetail($item);
                $wipCompletedQty = $this->getWipCompletedQty($row);

                $confirmQty = $row->confirm_qty ?? 0;

                $data = (object)[];
                $data->organization_id = $row->organization_id;
                // $data->department_code = '';
                $data->batch_id                 = $row->batch_id;
                $data->inventory_item_id        = $row->inventory_item_id;
                $data->opt                      = $row->opt;
                $data->lot_number               = '';
                $data->transaction_quantity     = $confirmQty - $wipCompletedQty;
                // $data->transaction_quantity     = $confirmQty ?? 0;
                $data->transaction_uom_code     = $row->opt_plan_uom;
                $data->transaction_date         = $row->transaction_date;



                $data->transfer_organization_id = optional($setup)->organization_id_to ?? '';
                $data->transfer_subinv          = optional($setup)->subinventory_to ?? '';
                $data->transfer_locator_id      = optional($setup)->locator_id_to ?? '';

                $data->location_code_from       = optional($setup)->location_code_from ?? ''; //แสดงบนหน้าเฉยๆ

                $data->transaction_type_id_from = optional($setup)->transaction_type_id_from ?? ''; //attribute1
                $data->organization_id_from     = optional($setup)->organization_code_from ?? ''; //attribute2
                $data->subinventory_from        = optional($setup)->subinventory_from ?? ''; //attribute3
                $data->locator_id_from          = optional($setup)->locator_id_from ?? ''; //attribute4
                $data->locator_code_from        = optional($setup)->locator_code_from ?? ''; //attribute5

                $data->batch_no                 = $row->batch_no; //attribute6
                $data->item_number              = $item->item_number; //attribute7
                $data->item_desc                = $item->item_desc; //attribute8
                // $data->primary_unit_of_measure  = $item->primary_unit_of_measure; //attribute9
                $data->primary_unit_of_measure  = optional($uom)->unit_of_measure; //attribute9

                $data->confirm_qty              = $confirmQty; //attribute10
                $data->wip_completed_qty        = 0; //attribute11
                $data->wip_step                 = $row->wip_step; //attribute13

                // เช็คมีข้อมูลที่บันทึกอยู่แล้วไหม
                $checkData = $jobLines->where('batch_id', $data->batch_id)
                                ->where('inventory_item_id', $data->inventory_item_id)
                                ->where('organization_id', $data->organization_id)
                                ->where('opt', $data->opt)
                                ->first();

                $data->is_selected = false;
                $data->wip_req_line_id = '';
                $data->can_cancel_line = false;
                if ($checkData) {
                    // $data->transaction_quantity = $checkData->transaction_quantity;
                    $checkData->has_map = true;
                    $data->has_map = true;
                    $data->is_selected = true;
                    $data->wip_req_line_id = $checkData->wip_req_line_id;
                }
                $period = PtBiweeklyV::whereRaw("TRUNC(to_date('$transactionDate', 'YYYY-MM-DD')) between start_date and end_date")->first();
                $costValidate = (new CommonRepository)->costValidate(
                    $data->inventory_item_id,
                    $data->transfer_organization_id,
                    $period->period_year );
                $data->cost_valid = true;
                $data->cost_validate_msg = '';
                if ($costValidate['status'] != 'S') {
                    $data->is_disable = true;
                    $data->cost_valid  = false;
                    $data->cost_validate_msg = $costValidate['msg'];
                }

                $data->is_disable = $this->lineIsDisable($header, $data);
                $data->is_convert_flag = $row->convert_flag == 'Y';
                $data->transaction_date = $transactionDate;
                if ($data->is_convert_flag) {
                    $this->setConvertDetail($data, $row, $wipReqLineId = false, $checkCost = true, $checkCostPeriodYear = $period->period_year);
                }

                return $data;
            });

        } else {
            $jobLines = $jobLines->where('transaction_quantity', '>', 0);
        }

        if ($jobLines) {
            $jobLines = $jobLines->where('has_map', false);
        }
        // ข้อมูลเก่า
        foreach ($jobLines ?? [] as $key => $row) {
            $data = (object)[];
            $data->wip_req_line_id          = $row->wip_req_line_id;
            $data->organization_id          = $row->organization_id;
            $data->batch_id                 = $row->batch_id;
            $data->inventory_item_id        = $row->inventory_item_id;
            $data->opt                      = $row->opt;
            $data->lot_number               = $row->lot_number;
            // $data->transaction_quantity     = $row->transaction_quantity;
            $data->transaction_quantity     = $row->web_qty;
            $data->transaction_uom_code     = $row->transaction_uom_code;

            $data->transfer_organization_id = $row->transfer_organization_id;
            $data->transfer_subinv          = $row->transfer_subinv;
            $data->transfer_locator_id      = $row->transfer_locator_id;

            $data->transaction_type_id_from =  $row->attribute1; //attribute1
            $data->organization_id_from     =  $row->attribute2; //attribute2
            $data->subinventory_from        =  $row->attribute3; //attribute3
            $data->locator_id_from          =  $row->attribute4; //attribute4
            $data->locator_code_from        =  $row->attribute5; //attribute5

            $data->batch_no                 = $row->attribute6; //attribute6
            $data->item_number              = $row->attribute7; //attribute7
            $data->item_desc                = $row->attribute8; //attribute8
            $data->primary_unit_of_measure  = $row->attribute9; //attribute9

            $data->confirm_qty              = $row->attribute10; //attribute10
            $data->wip_completed_qty        = $row->attribute11; //attribute11
            // $data->review_header_id         = $row->attribute12; //attribute12
            $data->location_code_from       = $row->attribute12; //attribute12
            $data->wip_step                 = $row->attribute13; //attribute13
            $data->is_selected              = false;
            $data->can_cancel_line          = $row->can_cancel_line;
            $data->is_disable               = $this->lineIsDisable($header, $data);
            $data->is_convert_flag          = $row->convert_flag == 'Y';
            $data->is_convert_flag = $row->convert_flag == 'Y';
            if ($data->is_convert_flag) {
                $this->setConvertDetail($data, $row, $row->wip_req_line_id);
            }
            $data->cost_valid = true;
            $jobHeaders->push($data);
        }

        if (count($jobHeaders)) {
            $jobHeaders = $jobHeaders->where('transaction_quantity', '>', 0);
        }

        return $jobHeaders;
    }

    function search($request)
    {
        $wipRequestNo = strtolower(request()->wip_request_no);
        $wipReqHeaderId = strtolower(request()->wip_req_header_id);
        // $transactionDate = request()->transaction_date ?? false;
        $fromTransactionDate = $request->from_transaction_date ?? '';
        $toTransactionDate = $request->to_transaction_date ?? '';
        $wipRequestStatus = $request->wip_request_status ?? '';
        $profile = getDefaultData('/pm/wip-requests');

        $headers = PtpmWipRequestHeader::with([
                            'status:lookup_code,description'
                        ])
                        ->when($wipRequestNo, function($q) use($wipRequestNo) {
                            $q->whereRaw("LOWER(wip_request_no) like '%{$wipRequestNo}%'");
                        })
                        ->when($wipReqHeaderId, function($q) use($wipReqHeaderId) {
                            $q->where("wip_req_header_id", $wipReqHeaderId);
                        })
                        ->when($fromTransactionDate, function($q) use($fromTransactionDate) {
                            $fromTransactionDate = parseFromDateTh($fromTransactionDate);
                            $q->whereRaw("TRUNC(transaction_date) >= '{$fromTransactionDate}'");
                        })
                        ->when($toTransactionDate, function($q) use($toTransactionDate) {
                            $toTransactionDate = parseFromDateTh($toTransactionDate);
                            $q->whereRaw("TRUNC(transaction_date) <= '{$toTransactionDate}'");
                        })
                        ->when($wipRequestStatus, function($q) use($wipRequestStatus) {
                            $q->where("wip_request_status", $wipRequestStatus);
                        })
                        ->where('organization_id', $profile->organization_id)
                        ->orderBy('wip_request_no', 'desc')
                        // ->limit(20)
                        ->get();
        return $headers;
    }

    function searchGetParam($request)
    {
        $fromTransactionDate = $request->from_transaction_date ?? '';
        $toTransactionDate = $request->to_transaction_date ?? '';
        $wipRequestStatus = $request->wip_request_status ?? '';

        $wipRequestStatusData = [];


        $profile = getDefaultData('/pm/wip-requests');
        $headers = PtpmWipRequestHeader::selectRaw("
                        wip_request_status,
                        wip_req_header_id as value,
                        wip_request_no as label
                    ")
                    ->where('organization_id', $profile->organization_id)
                    ->orderBy('transaction_date', 'desc');


        if ($fromTransactionDate || $toTransactionDate || $wipRequestStatus) {

            if ($fromTransactionDate) {
                $fromTransactionDate = parseFromDateTh($fromTransactionDate);
            }

            if ($toTransactionDate) {
                $toTransactionDate = parseFromDateTh($toTransactionDate);
            }
            $headers = $headers->when($fromTransactionDate, function($q) use($fromTransactionDate) {
                        $q->whereRaw("TRUNC(transaction_date) >= '{$fromTransactionDate}'");
                    })
                    ->when($toTransactionDate, function($q) use($toTransactionDate) {
                        $q->whereRaw("TRUNC(transaction_date) <= '{$toTransactionDate}'");
                    })
                    ->when($wipRequestStatus, function($q) use($wipRequestStatus) {
                        $q->where("wip_request_status", $wipRequestStatus);
                    })
                    ->get();

            if (count($headers)) {
                $wipRequestStatusData = $headers->pluck('wip_request_status', 'wip_request_status')->all();
            }
        } else {
            $headers = $headers
                        // ->limit(50)
                        ->get();
        }

        $statusData = PtpmCompleteStatus::select([
                        'LOOKUP_CODE as value',
                        'DESCRIPTION as label'
                        ])
                        ->when(count($wipRequestStatusData), function($q) use($wipRequestStatusData) {
                            $q->whereIn("LOOKUP_CODE", $wipRequestStatusData);
                        })
                        ->active()
                        ->get();

        $statusList[] = [ 'value' => '', 'label' => 'ท้ังหมด' ];
        if (count($statusData)) {
            $statusList = array_merge($statusList, $statusData->toArray());
        }
        $wipReqHeaderIdList = [];
        if (count($headers)) {
            $wipReqHeaderIdList = $headers->toArray();
        }
        return [
            'wip_request_status_list' => $statusList,
            'wip_req_header_id_list' => $wipReqHeaderIdList,
        ];
    }

    function store($request)
    {
        $inputHeader = (object) $request->header;
        $profile = getDefaultData('/pm/wip-requests');
        $organizationId = $profile->organization_id;
        $sysdate = now();
        $headerId = Arr::get($request->header, 'wip_req_header_id', false);
        if ($headerId) {
            $header = PtpmWipRequestHeader::find($headerId);
            $organizationId = data_get($header, 'organization_id', $profile->organization_id);

            $lines = PtpmWipRequestLine::where('wip_req_header_id', $headerId)->get();
            if (count($lines) > 0) {
                $lineIdList = $lines->pluck('wip_req_line_id', 'wip_req_line_id')->all();
                foreach ($lines as $key => $line) {
                    $line->deleted_by_id = $profile->user_id;
                    $line->save();
                    $line->delete();
                }

                $convertTrans = PtpmConvertTransaction::whereIn('wip_req_line_id', $lineIdList)->get();
                foreach ($convertTrans as $key => $line) {
                    $line->deleted_by_id = $profile->user_id;
                    $line->web_batch_no = "DELETE-$line->web_batch_no";
                    $line->save();
                    $line->delete();
                }
            }


        } else {
            $header = new PtpmWipRequestHeader;
            $header->created_by         = $profile->fnd_user_id;
            $header->created_by_id      = $profile->user_id;
            $header->created_at         = $sysdate;
            $header->creation_date      = $sysdate;
            $header->program_code       = $profile->program_code;
        }

        $header->organization_id    = $organizationId;
        $header->department_code    = $profile->department_code;
        $header->wip_request_status = Arr::get(request()->header, 'wip_request_status');

        $header->transaction_date   = '';
        $header->wip_request_date   = '';
        if (($sendDate = Arr::get(request()->header, 'transaction_date_format')) != '') {
            $header->transaction_date   = parseFromDateTh($sendDate, 'H:i:s');
            $header->wip_request_date   = parseFromDateTh($sendDate, 'H:i:s');
        }

        $header->updated_by_id      = $profile->user_id;
        $header->last_updated_by    = $profile->fnd_user_id;
        $header->updated_at         = $sysdate;
        $header->last_update_date   = $sysdate;
        $header->save();

        $selectLineIdList = [];


        foreach ($request->lines as $key => $reqLine) {
            $reqLine                  = (object) $reqLine;

            if ($reqLine->transaction_quantity && $reqLine->is_selected) {
                $toUomConvert = PtpmItemConvUomVLookup::where('organization_id', $organizationId)
                                                ->where('inventory_item_id', $reqLine->inventory_item_id)
                                                ->where('from_uom_code', $reqLine->transaction_uom_code)
                                                ->value('to_uom_code');           
                $convertTransaction_qty = collect(\DB::select("
                                                        select  (apps.inv_convert.inv_um_convert (
                                                                        item_id           => '{$reqLine->inventory_item_id}',
                                                                        organization_id   => {$organizationId},
                                                                        PRECISION         => NULL,
                                                                        from_quantity     => '{$reqLine->transaction_quantity}',
                                                                        from_unit         => '{$reqLine->transaction_uom_code}',
                                                                        to_unit           => '{$toUomConvert}',
                                                                        from_name         => NULL,
                                                                        to_name           => NULL)
                                                                )   convert_transaction_qty
                                                        from dual
                                                                                                        "))->first();      
                          
                $line                     = new PtpmWipRequestLine;
                $line->created_by         = $profile->fnd_user_id;
                $line->created_by_id      = $profile->user_id;
                $line->created_at         = $sysdate;
                $line->creation_date      = $sysdate;
                $line->program_code       = $profile->program_code;

                $line->wip_req_header_id        = $header->wip_req_header_id ?? -1;
                $line->web_batch_no             = $header->wip_req_header_id;
                $line->organization_id          = $profile->organization_id;
                $line->department_code          = $profile->department_code;
                $line->batch_id                 = $reqLine->batch_id;
                $line->inventory_item_id        = $reqLine->inventory_item_id;
                $line->opt                      = $reqLine->opt;
                $line->lot_number               = $reqLine->lot_number;
                // $line->transaction_quantity     = $reqLine->transaction_quantity;
                // $line->transaction_uom_code     = $reqLine->transaction_uom_code;
                $line->transaction_quantity     = $convertTransaction_qty->convert_transaction_qty;
                $line->transaction_uom_code     = $toUomConvert;
                
                $line->WEB_QTY                  = $reqLine->transaction_quantity;
                $line->WEB_UOM                  = $reqLine->transaction_uom_code;

                $line->subinventory_code        = $reqLine->subinventory_from;
                $line->locator_id               = $reqLine->locator_id_from;

                $line->transfer_organization_id = $reqLine->transfer_organization_id;
                $line->transfer_subinv          = $reqLine->transfer_subinv;
                $line->transfer_locator_id      = $reqLine->transfer_locator_id;

                $line->attribute1               = $reqLine->transaction_type_id_from; //attribute1
                $line->attribute2               = $reqLine->organization_id_from; //attribute2
                $line->attribute3               = $reqLine->subinventory_from; //attribute3
                $line->attribute4               = $reqLine->locator_id_from; //attribute4
                $line->attribute5               = $reqLine->locator_code_from; //attribute5
                $line->attribute6               = $reqLine->batch_no; //attribute6
                $line->attribute7               = $reqLine->item_number; //attribute7
                $line->attribute8               = $reqLine->item_desc; //attribute8
                $line->attribute9               = $reqLine->primary_unit_of_measure; //attribute9
                $line->attribute10              = $reqLine->confirm_qty; //attribute10
                $line->attribute11              = $reqLine->wip_completed_qty; //attribute11
                // $line->attribute12              = $reqLine->review_header_id; //attribute12
                $line->attribute12              = $reqLine->location_code_from; //attribute12
                $line->attribute13              = $reqLine->wip_step; //attribute13

                $line->convert_flag             = $reqLine->is_convert_flag ? 'Y' : '';

                $line->updated_by_id        = $profile->user_id;
                $line->last_updated_by      = $profile->fnd_user_id;
                $line->updated_at           = $sysdate;
                $line->last_update_date     = $sysdate;

                $line->save();

                if ($reqLine->is_convert_flag) {
                    $this->insertConvertTrans($reqLine, $line, $header->transaction_date);
                }
            }
        }

        $header->web_batch_no = $header->wip_req_header_id;
        $header->save();

        return $header;
    }


    function getSubinvDetail($item)
    {
            $columns = "
                transaction_type_id      transaction_type_id_from
                , from_organization_id     organization_id_from
                , from_organization_code   organization_code_from
                , from_subinventory        subinventory_from
                , from_locator_id          locator_id_from
                , from_locator_code        locator_code_from
                , from_location_code       location_code_from

                , transaction_type_id     transaction_type_id_to
                , to_organization_id      organization_id_to
                , to_organization_code    organization_code_to
                , to_subinventory         subinventory_to
                , to_locator_id           locator_id_to
            ";

        $setup = PtpmSetupMfgDepartmentsV::selectRaw($columns)
                    ->wipCompleteType()
                    ->where('organization_id', $item->organization_id)
                    ->where('tobacco_group_code', $item->tobacco_group_code)
                    ->where('enable_flag', 'Y')
                    ->first();

        return $setup;
    }

    function getWipCompletedQty($data)
    {
        $wipStep = $data->wip_step;
        $lineTransDate = $data->transaction_date;

        $completedQty = PtpmWipRequestLine::isInfSuccess()
                            ->whereHas('header', function ($query) use ($lineTransDate) {
                                $query->isInfWipCompleted()
                                    ->whereDate('transaction_date', $lineTransDate);
                            })
                            ->where('batch_id', $data->batch_id)
                            ->where('attribute13', $wipStep)
                            ->where('opt', $data->opt)
                            ->sum('web_qty');
                            // ->get();

        $completedReturnQty = PtpmWipRequestLine::isInfSuccess()
                            ->whereHas('header', function ($query) use ($lineTransDate) {
                                $query->isInfWipCompleted()
                                    ->whereDate('transaction_date', $lineTransDate);
                            })
                            ->where('cancel_flag', 'Y')
                            ->where('batch_id', $data->batch_id)
                            ->where('attribute13', $wipStep)
                            ->where('opt', $data->opt)
                            ->sum('web_qty');
                            // ->get();
        // if ($data->review_header_id == 120) {
        //     // code...
        //     dd('xx', $data, $completedQty);
        //     dd('xx', $data, $completedQty->toArray(), $wipStep);
        // }

        // $completedReturnQty = 0;

        return $completedQty - $completedReturnQty;
    }

    function lineIsDisable($header, $line)
    {
        return (!$header->can->cancel_transfer && !$header->can->edit) || (!$line->can_cancel_line && !$header->can->edit);
    }

    function setConvertDetail($data, $row, $wipReqLineId = false, $checkCost = false, $checkCostPeriodYear = false)
    {
        $convertInfo = (object) [];
        $convertInfo->lines = [];
        $convertInfo->valid = true;
        $convertInfo->msg = '';
        $digit = 5;

        try {
            if ($wipReqLineId) { // ให้อ่านจากข้อมูลเดิม
                $convertTrans = PtpmConvertTransaction::where('wip_req_line_id', $wipReqLineId)->get();
                $convertInfo->lines = collect($convertTrans)->map(function ($o) use ($digit) {
                    $uom = PtInvUomV::where('uom_code', $o->transaction_uom)->first();
                    $convsInfo = PtpmConvertItemsInfo::where('convert_item_id', $o->convert_item_id)->first();
                    $toItem = PtpmItemNumberV::select([
                                    'item_number',
                                    'item_desc',
                                ])
                                ->where('inventory_item_id', $convsInfo->to_inventory_item_id)
                                ->where('organization_id', $convsInfo->to_organization_id)
                                ->first();

                    $line = (object)[];
                    $transactionQuantity            = $o->transaction_quantity ? $o->transaction_quantity / $o->transaction_rate : 0;
                    $line->convert_tran_id          = $o->convert_tran_id;
                    $line->convert_item_id          = $o->convert_item_id;
                    $line->to_inventory_item_display = $toItem ? "$toItem->item_number: $toItem->item_desc" : '-';
                    $line->conversion_rate          = $o->transaction_rate;
                    $line->transaction_quantity     = number_format($o->transaction_quantity, $digit, '.', '');
                    $line->transaction_quantity_format = number_format($transactionQuantity, $digit);
                    $line->to_uom_display           = optional($uom)->unit_of_measure;
                    return $line;
                });

            } else {
                $convsInfo = PtpmConvertItemsInfo::active()->where('from_inventory_item_id', $row->inventory_item_id)->get();
                if (count($convsInfo) == 0) {
                    $convertInfo->msg = 'ไม่พบข้อมูลการแปลงหน่วยข้าม Item : PMS0023: บันทึก Layout สิ่งพิมพ์';
                    throw new \Exception($convertInfo->msg);
                }

                $convertInfo->lines = collect($convsInfo)->map(function ($o) use($data, $digit, $checkCostPeriodYear) {
                    $uom = PtInvUomV::where('uom_code', $o->to_uom)->first();
                    $toItem = PtpmItemNumberV::select([
                                    'item_number',
                                    'item_desc',
                                ])
                                ->where('inventory_item_id', $o->to_inventory_item_id)
                                ->where('organization_id', $o->to_organization_id)
                                ->first();

                    $line = (object)[];
                    $transactionQuantity            = $o->conversion_rate ? $data->confirm_qty / $o->conversion_rate : 0;
                    $line->convert_tran_id          = null;
                    $line->convert_item_id          = $o->convert_item_id;
                    $line->to_inventory_item_display = $toItem ? "$toItem->item_number: $toItem->item_desc" : '-';
                    $line->conversion_rate          = $o->conversion_rate;
                    $line->transaction_quantity     = $data->confirm_qty;
                    $line->transaction_quantity_format = number_format($transactionQuantity, $digit);

                    $line->to_uom_display           = optional($uom)->unit_of_measure;

                    $costValidate = (new CommonRepository)->costValidate(
                        $o->to_inventory_item_id,
                        $o->to_organization_id,
                        $checkCostPeriodYear
                    );
                    $line->cost_valid = true;
                    $line->cost_validate_msg = '';
                    if ($costValidate['status'] != 'S') {
                        $line->cost_valid  = false;
                        $line->cost_validate_msg = $costValidate['msg'];
                    }
                    return $line;
                });
            }

            $data->convert_info = $convertInfo;
            return $data;
        } catch (\Exception $e) {
            \Log::error($e);
            $convertInfo->valid = false;
            $data->convert_info = $convertInfo;
            return $data;
        }
    }

    function insertConvertTrans($reqLine, $line, $transDate)
    {
        // "convert_info" => array:3 [
        //   "lines" => array:1 [
        //     0 => array:7 [
        //       "convert_tran_id" => null
        //       "convert_item_id" => 34
        //       "to_inventory_item_display" => "1701P0018: สมุดฉีก ผอก."
        //       "conversion_rate" => "76"
        //       "transaction_quantity" => 6924
        //       "transaction_quantity_format" => "6,924"
        //       "to_uom_display" => "เล่ม"
        //     ]
        //   ]
        //   "valid" => true
        //   "msg" => null
        // ]

        $profile = $this->getProfile();
        $sysdate = now();

        $convertInfo = (object) $reqLine->convert_info;
        foreach ($convertInfo->lines ?? [] as $key => $convertLine) {
            $convertLine = (object) $convertLine;
            $convsInfo = PtpmConvertItemsInfo::active()->where('convert_item_id', $convertLine->convert_item_id)->first();

            $data                           = new PtpmConvertTransaction;
            $data->convert_item_id          = $convsInfo->convert_item_id;
            $data->transaction_date         = $transDate;
            $data->transaction_quantity     = $convertLine->transaction_quantity;
            $data->transaction_uom          = $convsInfo->to_uom;

            $data->transaction_rate         = $convsInfo->conversion_rate;
            $data->from_inventory_item_id   = $convsInfo->from_inventory_item_id;
            $data->to_inventory_item_id     = $convsInfo->to_inventory_item_id;

            $data->created_by               = $profile->fnd_user_id;
            $data->created_by_id            = $profile->user_id;
            $data->created_at               = $sysdate;
            $data->creation_date            = $sysdate;
            $data->program_code             = 'PMP0060';
            $data->updated_by_id            = $profile->user_id;
            $data->last_updated_by          = $profile->fnd_user_id;
            $data->updated_at               = $sysdate;
            $data->last_update_date         = $sysdate;
            $data->web_batch_no             = $line->web_batch_no;
            $data->wip_req_line_id          = $line->wip_req_line_id;
            $data->save();
        }
    }
}
