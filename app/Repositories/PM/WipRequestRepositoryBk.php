<?php
namespace App\Repositories\PM;

use Illuminate\Database\Eloquent\Collection;

use DB;
use Arr;
use App\Models\PM\PtpmWipRequestHeader;
use App\Models\PM\PtpmWipRequestLine;
use App\Models\PM\PtpmCompleteStatus;
use App\Models\PM\PtpmItemNumberV;

// use App\Models\PM\PtpmMesReviewIssueHeaders;
// use App\Models\PM\PtpmMesReviewIssueLines;
use App\Models\PM\PtpmMesReviewJobHeaders;
use App\Models\PM\PtpmMesReviewJobLines;

use App\Models\PM\PtpmSetupMfgDepartmentsV;
use App\Repositories\PM\CommonRepository;

class WipRequestRepositoryBk
{
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

        $jobHeaders = collect([]);
        $jobLines = PtpmWipRequestLine::where('wip_req_header_id', $headerId)->get();
        data_set($jobLines, '*.has_map', false);
        if ($header->can->edit) {
            // transaction_date_format
            $wipStep = 'WIP02';
            if ($profile->organization_id == 174) {
                $wipStep = 'WIP01';
            }
            $transactionDate = parseFromDateTh($header->transaction_date_format);
            $jobHeaders = PtpmMesReviewJobHeaders::whereHas('lines', function ($query) use ($transactionDate, $wipStep) {
                                $query->whereDate('transaction_date', $transactionDate)
                                        ->when($wipStep, function($q) use($wipStep) {
                                            $q->where('wip_step', $wipStep);
                                        })
                                        ->whereNotNUll('confirm_qty');
                            })
                            ->with(['lines' => function ($query) use ($transactionDate, $wipStep) {
                                $query->whereDate('transaction_date', $transactionDate)
                                        ->when($wipStep, function($q) use($wipStep) {
                                            $q->where('wip_step', $wipStep);
                                        })
                                        ->whereNotNUll('confirm_qty');
                            }])
                            // ->where('organization_id', $organizationId)
                            // ->where('batch_no', "64-4-0001")
                            ->get();
                            // ->toSql();
            // dd('xx', $jobHeaders);

            $jobHeaders = collect($jobHeaders)->map(function ($row) use ($jobLines) {
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

                $setup = $this->getSubinvDetail($item);

                $lines = $row->lines;
                $confirmQty = 0;
                if (count($lines)) {
                    $confirmQty = $lines->sum('confirm_qty');
                }


                $data = (object)[];
                $data->lines                    = $lines;
                $data->organization_id = $row->organization_id;
                // $data->department_code = '';
                $data->batch_id                 = $row->batch_id;
                $data->inventory_item_id        = $row->inventory_item_id;
                $data->lot_number               = '';
                // $data->transaction_quantity     = $confirmQty - $wipCompletedQty;
                $data->transaction_quantity     = $confirmQty ?? 0;
                $data->transaction_uom_code     = $row->opt_plan_uom;



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
                $data->primary_unit_of_measure  = $item->primary_unit_of_measure; //attribute9

                $data->confirm_qty              = $confirmQty; //attribute10
                $data->wip_completed_qty        = 0; //attribute11
                // $data->review_header_id         = $row->review_header_id; //attribute12
                $data->wip_step                 = $lines->first()->wip_step; //attribute13

                return $data;
            });

            // dd('xx', $jobHeaders);


            if (count($jobHeaders)) {
                $jobHeaders = $jobHeaders->groupBy('batch_no')->mapWithKeys(function ($item, $group) use ($jobLines) {

                    // if ($group == '64M0217-011') {
                    //     // dd('x', $item, $item->first()->lines);
                    // }

                    $wipCompletedQty = $this->getWipCompletedQty($item->first());
                    $item->wip_completed_qty        = $wipCompletedQty;
                    $item->transaction_quantity     = $wipCompletedQty - $wipCompletedQty;
                    data_set($item, "*.lines", []);
                    data_set($item, "*.wip_completed_qty", $wipCompletedQty);


                    // batch_id: "193020",
                    $newItem = $item->first();
                    if (count($item) > 1) {

                        if (!data_get($newItem, 'has_map')) {
                            $newItem->transaction_quantity  = $item->where('transaction_quantity', '!=', '')
                                                                ->sum('transaction_quantity');
                        }
                        $newItem->confirm_qty           = $item->sum('confirm_qty');
                    }
                    $newItem->transaction_quantity = ($newItem->transaction_quantity - $wipCompletedQty);
                    // $newItem->transaction_quantity = abs($newItem->transaction_quantity - $wipCompletedQty);

                    // เช็คมีข้อมูลที่บันทึกอยู่แล้วไหม
                    $checkData = $jobLines->where('batch_id', $newItem->batch_id)
                                    ->where('inventory_item_id', $newItem->inventory_item_id)
                                    ->where('organization_id', $newItem->organization_id)
                                    // ->where('attribute12', $data->review_header_id)
                                    ->first();

                    data_set($newItem, 'has_map', false);
                    if ($checkData) {
                        $newItem->transaction_quantity = $checkData->transaction_quantity;
                        $checkData->has_map =true;
                        $newItem->has_map = true;
                    }

                    return [$group => $newItem];
                });
            }
        } else {
            $jobLines = $jobLines->where('transaction_quantity', '>', 0);
        }

        if ($jobLines) {
            $jobLines = $jobLines->where('has_map', false);
        }
        // ข้อมูลเก่า
        foreach ($jobLines ?? [] as $key => $row) {
            $data = (object)[];
            $data->organization_id          = $row->organization_id;
            $data->batch_id                 = $row->batch_id;
            $data->inventory_item_id        = $row->inventory_item_id;
            $data->lot_number               = $row->lot_number;
            $data->transaction_quantity     = $row->transaction_quantity;
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
        $transactionDate = request()->transaction_date ?? false;
        $headers = PtpmWipRequestHeader::with([
                            'status:lookup_code,description'
                        ])
                        ->when($wipRequestNo, function($q) use($wipRequestNo) {
                            $q->whereRaw("LOWER(wip_request_no) like '%{$wipRequestNo}%'");
                        })
                        ->when($transactionDate, function($q) use($transactionDate) {
                            $q->whereDate("transaction_date", parseFromDateTh($transactionDate));
                        })
                        ->orderBy('wip_request_no', 'desc')
                        ->limit(20)
                        ->get();
        return $headers;
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
            foreach ($lines as $key => $line) {
                $line->deleted_by_id = $profile->user_id;
                $line->save();
                $line->delete();
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

            if ($reqLine->transaction_quantity) {
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
                $line->lot_number               = $reqLine->lot_number;
                $line->transaction_quantity     = $reqLine->transaction_quantity;
                $line->transaction_uom_code     = $reqLine->transaction_uom_code;


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

                $line->updated_by_id        = $profile->user_id;
                $line->last_updated_by      = $profile->fnd_user_id;
                $line->updated_at           = $sysdate;
                $line->last_update_date     = $sysdate;
                $line->save();
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

        $setup = PtpmSetupMfgDepartmentsV::selectRaw($columns)->wipCompleteType()
                    ->where('organization_id', $item->organization_id)
                    ->where('tobacco_group_code', $item->tobacco_group_code)
                    ->where('enable_flag', 'Y')
                    ->first();
        return $setup;
    }

    function getWipCompletedQty($data)
    {
        $lines = $data->lines;
        if (count($lines)) {
            $wipStep = $lines->first()->wip_step;
            $lineTransDate = $lines->first()->transaction_date;
        } else {
            $wipStep = $lines->wip_step;
            $lineTransDate = $lines->transaction_date;
        }

        $completedQty = PtpmWipRequestLine::isInfSuccess()
                            ->whereHas('header', function ($query) use ($lineTransDate) {
                                $query->isInfWipCompleted()
                                    ->whereDate('transaction_date', $lineTransDate);
                            })
                            ->where('batch_id', $data->batch_id)
                            ->where('attribute13', $wipStep)
                            ->sum('transaction_quantity');
                            // ->get();

        // if ($data->review_header_id == 120) {
        //     // code...
        //     dd('xx', $data, $completedQty);
        //     dd('xx', $data, $completedQty->toArray(), $wipStep);
        // }

        $completedReturnQty = 0;

        return $completedQty - $completedReturnQty;
    }
}
