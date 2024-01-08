<?php
namespace App\Repositories\PM;

use Illuminate\Database\Eloquent\Collection;

use DB;
use Arr;
use App\Repositories\PM\CommonRepository;
use App\Models\PM\PtpmSummaryBatchV;
use App\Models\PM\PtInvUomV;
use App\Models\PM\MtlItemLocationsKfv;
use App\Models\PM\PtmesTobaccoTransR01V;
use App\Models\PM\Lookup\PtinvOnhandQuantitiesV;
use App\Models\PM\SprinkleTobaccos\PtpmSprinkleTobaccoHeader;
use App\Models\PM\SprinkleTobaccos\PtpmSprinkleTobaccoLine;
use App\Models\PM\PtpmItemNumberV;

use App\Models\PM\PtpmWipRequestHeader;
use App\Models\PM\PtpmWipRequestLine;
use App\Models\PM\PtpmCompleteStatus;

// use App\Models\PM\PtpmMesReviewIssueHeaders;
// use App\Models\PM\PtpmMesReviewIssueLines;
use App\Models\PM\PtpmMesReviewJobHeaders;
use App\Models\PM\PtpmMesReviewJobLines;
use App\Models\PM\PtpmPmp0044ListJobsV;

use App\Models\PM\PtpmSetupMfgDepartmentsV;

use App\Models\FndLookupValue;

class SprinkleTobaccoRepository
{
    const url = '/pm/sprinkle-tobaccos';

    function info($request)
    {
        $profile    = $this->getProfile();
        $header     = $this->getHeaderInfo($request, $profile);
        $data       = $this->getDataInfo($request, $header, $profile);

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

    function getDataInfo($request, $header, $profile)
    {
        $preiodMinMax = collect(\DB::select("
            SELECT
                (to_char(min(period_start_date), 'YYYY-MM-DD')) min_date
                , (to_char(max(schedule_close_date), 'YYYY-MM-DD')) max_date
                ,  (to_char(min(period_start_date), 'DD/MM/YYYY', 'NLS_CALENDAR=''THAI BUDDHA'' NLS_DATE_LANGUAGE=THAI')) min_date_th
                ,  (to_char(max(schedule_close_date), 'DD/MM/YYYY', 'NLS_CALENDAR=''THAI BUDDHA'' NLS_DATE_LANGUAGE=THAI')) max_date_th
            FROM    ORG_ACCT_PERIODS OAP ,
                    ORG_ORGANIZATION_DEFINITIONS OOD
            WHERE   OAP.ORGANIZATION_ID = OOD.ORGANIZATION_ID
            AND     OAP.OPEN_FLAG = 'Y'
            AND     OAP.ORGANIZATION_ID = {$profile->organization_id}
            ORDER BY OOD.ORGANIZATION_ID
        "));

        if ($preiodMinMax) {
            $preiodMinMax = $preiodMinMax->first();
        }

        $data = (object)[];
        $data->preiod_min_max = $preiodMinMax;


        return $data;
    }

    function getHeaderInfo($request, $profile)
    {
        if ($request->sprinkle_header_id) {
            $header =   PtpmSprinkleTobaccoHeader::selectRaw("
                            sprinkle_header_id
                            , interface_status
                            , cancel_by_id
                            , cancel_flag
                            , batch_id
                            , product_item_id
                            , opt
                            , receipt_quantity
                            , receipt_uom_code
                            , sprinkle_no
                            , transaction_date
                            , organization_id to_organization_id
                            , organization_id
                            , subinventory_code to_subinventory
                            , locator_id
                            , locator_id to_locator_id
                            , transfer_status
                        ")
                        ->find($request->sprinkle_header_id);
            $header = (object) $header->toArray();
            $uom    = PtInvUomV::where('uom_code', $header->receipt_uom_code)->first();
            $blend  = PtpmItemNumberV::where('organization_id', $header->organization_id)
                        ->where('inventory_item_id', $header->product_item_id)
                        ->first();
            $locator= MtlItemLocationsKfv::where('inventory_location_id', $header->locator_id)->first();

            $header->transaction_date_format = parseToDateTh($header->transaction_date);
            $header->blend_no   = optional($blend)->blend_no;
            $header->item_no    = optional($blend)->item_number;
            $header->item_desc  = optional($blend)->item_desc;
            $header->uom_desc   = optional($uom)->unit_of_measure;
            $header->to_locator_code = optional($locator)->concatenated_segments;

            $lines = PtpmSprinkleTobaccoLine::where('sprinkle_header_id', $header->sprinkle_header_id)->get();
            $lines = $lines->groupBy('inventory_item_id')->mapWithKeys(function ($item, $group) {
                $firstLine = $item->first();
                $uom    = PtInvUomV::where('uom_code', $firstLine->issue_uom_code)->first();
                $blend  = PtpmItemNumberV::where('inventory_item_id', $firstLine->inventory_item_id)
                            ->where('organization_id', $firstLine->organization_id)
                            ->first();
                $locator= MtlItemLocationsKfv::where('inventory_location_id', $firstLine->locator_id)->first();

                $newDate = (object) [];
                $newDate->is_disable            = false;
                $newDate->is_selected           = true;
                $newDate->can_misc_receipt      = false;
                $newDate->blend_no              = optional($blend)->blend_no;
                $newDate->total_onhand_quantity = '';
                $newDate->subinventory_code     = $firstLine->subinventory;

                $newDate->locator_id            = $firstLine->locator_id;
                $newDate->locator_code          = optional($locator)->concatenated_segments;
                $newDate->inventory_item_id     = $firstLine->inventory_item_id;
                $newDate->item_number           = optional($blend)->item_number;
                $newDate->item_desc             = optional($blend)->item_desc;

                $newDate->lot_number            = '';
                $newDate->origination_date      = '';
                $newDate->issue_uom_code        = $firstLine->issue_uom_code;
                $newDate->issue_unit_of_measure = optional($uom)->unit_of_measure;

                $lotList = $item;
                data_set($lotList, '*.issue_unit_of_measure', $newDate->issue_unit_of_measure);
                $newDate->lot_list              = $lotList;
                return [$group => $newDate];
            });
            $header->lines = $lines;
        } else {
            $model = new PtpmSprinkleTobaccoHeader();
            $can = $model->can;
            $header                             = (object)[];
            $header->can                        = $can;
            $header->sprinkle_header_id         = '';
            $header->blend_no                   = '';
            $header->batch_id                   = '';
            $header->product_item_id            = '';
            $header->opt                        = '';
            $header->receipt_quantity           = '';
            $header->receipt_uom_code           = '';
            $header->sprinkle_no                = '';

            $header->to_organization_id         = '';
            $header->to_subinventory            = '';
            $header->to_locator_id              = '';
            $header->to_locator_code            = '';
            $header->transaction_date_format    = parseToDateTh(now());
            $header->transfer_status            = '';                       //คอลัมเก็บสถานะ
        }

        $header->request_status_list            = FndLookupValue::where('lookup_type', 'PTPM_TOBACCO_SPRINKLE')
                                                                ->where('enabled_flag', 'Y')
                                                                ->get();

        return $header;
    }

    function url($request, $headerId = -999)
    {
        $url                    = (object)[];
        $preFixRoute            = 'pm.sprinkle-tobaccos';
        $preFixAjaxRoute        = 'pm.ajax.sprinkle-tobaccos';
        $url->index             = route("{$preFixRoute}.index", request()->all() ?? []);
        $url->ajax_store        = route("{$preFixAjaxRoute}.store");
        $url->ajax_cancel       = route("{$preFixAjaxRoute}.cancel");
        $url->ajax_get_lines    = route("{$preFixAjaxRoute}.get-lines");
        $url->ajax_get_item     = route("{$preFixAjaxRoute}.get-item");
        $url->ajax_set_status   = route("{$preFixAjaxRoute}.set-status", $headerId);
        return $url;
    }

    function getBlendDetail($request)
    {
        $date                   = parseFromDateTh($request->transaction_date_format ?? now());
        $profile                = $this->getProfile();
        $summaryBatchTable      = (new PtpmSummaryBatchV)->getTable();
        $ro1Table               = (new PtmesTobaccoTransR01V)->getTable();

        $blendNo = collect(DB::select("
            SELECT
                    distinct
                    psb.blend_no, psb.batch_id, psb.inventory_item_id as product_item_id
                    , psb.inventory_item_id, psb.item_no, psb.item_desc, psb.organization_id
                    , psb.dtl_um as uom_code
                    , tbv.opt
                    --, psb.*
            FROM    {$summaryBatchTable} psb
                    , {$ro1Table} tbv
            WHERE   1=1
            and     psb.batch_status_code = 2
            and     psb.organization_id = {$profile->organization_id}
            and     TRUNC(to_date('{$date}', 'YYYY-MM-DD')) between TRUNC(psb.plan_start_date) and TRUNC(psb.plan_cmplt_date)
            --and     psb.blend_no = 98
            and     psb.organization_id = tbv.organization_id
            and     psb.batch_no = tbv.batch_no
            and     psb.item_no = tbv.item_number
            and     psb.biweekly = psb.biweekly
            and     tbv.opt is not null
            order by psb.blend_no, tbv.opt
        "));

        $blendNoList    = $blendNo->groupBy('blend_no');
        $commonRepo     = new CommonRepository;
        $itemList       = $blendNo->groupBy('blend_no')->mapWithKeys(function ($item, $group) use ($commonRepo) {
            $firstLine = $item->first();
            $secUomList = $commonRepo->getSecUomList((object)[
                'inventory_item_id' => $firstLine->inventory_item_id,
                'organization_id' => $firstLine->organization_id,
                'to_uom_code' => $firstLine->uom_code,
            ]);


            $secUomList = $secUomList->groupBy('from_uom_code')->mapWithKeys(function ($item, $group) {
                return [$group => $item->first()->toArray()];
            });

            $firstLine->secondary_uom_list          = $secUomList;
            $invDestination                         = $this->getInvDestination($firstLine->organization_id, $firstLine->inventory_item_id);
            $firstLine->to_organization_id          = optional($invDestination)->to_organization_id;
            $firstLine->to_subinventory             = optional($invDestination)->to_subinventory;
            $firstLine->to_locator_id               = optional($invDestination)->to_locator_id;
            $firstLine->to_locator_code             = optional($invDestination)->to_locator_code;
            return [$group => $firstLine];
        });

        return [
            'blend_no_list' => $blendNoList,
            'item_list' => $itemList
        ];
    }

    function getLines($request)
    {
        $headerReq = json_decode($request->header ?? []);
        $action = $request->action;

        // +"can": {#2110 ▶}
        // +"blend_no": "98"
        // +"opt": "98V10/233"
        // +"receipt_quantity": 1
        // +"receipt_uom_code": "KG"
        // +"sprinkle_no": "2"
        // +"to_organization_id": "166"
        // +"to_subinventory": "FC6ROJ01"
        // +"to_locator_id": "486"
        // +"to_locator_code": "FC6ROJ01.ZONE001"
        // +"transaction_date_format": "28/08/2564"

        $onhand = (new PtinvOnhandQuantitiesV);
        $onhand = $onhand->selectRaw("
                        onhand_quantity
                        , blend_no
                        , subinventory_code
                        , locator_id
                        , locator_code
                        , inventory_item_id
                        , item_number
                        , item_desc
                        , lot_number
                        , origination_date
                        , primary_uom_code as issue_uom_code
                        , primary_unit_of_measure as issue_unit_of_measure
                        , '' as issue_quantity
                    ")
                    // ->where('blend_no', $headerReq->blend_no)
                    ->where('organization_id', $headerReq->to_organization_id)
                    // ->where('organization_id', 166)
                    ->where('locator_code', 'like', '%ZONE C48%')
                    ->whereRaw("TRUNC(nvl(expiration_date, sysdate)) >= TRUNC(sysdate)")
                    ->orderBy('origination_date')
                    ->get();

        $lotList = $onhand->groupBy('inventory_item_id');
        $onhandList = $onhand->groupBy('inventory_item_id')->mapWithKeys(function ($item, $group) use($lotList) {
            $firstLine = $item->first();

            $newDate = (object) [];

            $newDate->is_disable            = false;
            $newDate->is_selected           = false;
            $newDate->can_misc_receipt      = false;
            $newDate->total_onhand_quantity = $item->sum('onhand_quantity');
            $newDate->blend_no              = $firstLine->blend_no;
            $newDate->subinventory_code     = $firstLine->subinventory_code;

            $newDate->locator_id = $firstLine->locator_id;
            $newDate->locator_code = $firstLine->locator_code;
            $newDate->inventory_item_id = $firstLine->inventory_item_id;
            $newDate->item_number = $firstLine->item_number;
            $newDate->item_desc = $firstLine->item_desc;
            $newDate->lot_number = $firstLine->lot_number;
            $newDate->origination_date = $firstLine->origination_date;
            $newDate->issue_uom_code = $firstLine->issue_uom_code;
            $newDate->issue_unit_of_measure = $firstLine->issue_unit_of_measure;
            $newDate->lot_list = data_get($lotList, $firstLine->inventory_item_id);

            return [$group => $newDate];
        });

        return [
            'onhand_list' => $onhandList
        ];
    }

    function search($request)
    {
        $sprinkleNo = strtolower(request()->sprinkle_no);
        $transactionDate = request()->transaction_date ?? false;
        $sprinkleHeaderId = strtolower(request()->sprinkle_header_id);
        // $transactionDate = request()->transaction_date ?? false;
        $fromTransactionDate = $request->from_transaction_date ?? '';
        $toTransactionDate = $request->to_transaction_date ?? '';

        $profile = getDefaultData($this::url);

        $headers = PtpmSprinkleTobaccoHeader::when($sprinkleNo, function($q) use($sprinkleNo) {
                            $q->whereRaw("LOWER(sprinkle_no) like '%{$sprinkleNo}%'");
                        })
                        // ->when($transactionDate, function($q) use($transactionDate) {
                        //     if ($transactionDate != 'Invalid date') {
                        //         $q->whereDate("transaction_date", parseFromDateTh($transactionDate));
                        //     }
                        // })
                        ->when($sprinkleHeaderId, function($q) use($sprinkleHeaderId) {
                            $q->where("sprinkle_header_id", $sprinkleHeaderId);
                        })
                        ->when($fromTransactionDate, function($q) use($fromTransactionDate) {
                            $fromTransactionDate = parseFromDateTh($fromTransactionDate);
                            $q->whereRaw("TRUNC(transaction_date) >= '{$fromTransactionDate}'");
                        })
                        ->when($toTransactionDate, function($q) use($toTransactionDate) {
                            $toTransactionDate = parseFromDateTh($toTransactionDate);
                            $q->whereRaw("TRUNC(transaction_date) <= '{$toTransactionDate}'");
                        })
                        // ->where('organization_id', $profile->organization_id)
                        // ->where('interface_status', 'S')
                        ->whereRaw("nvl(interface_status,'Z') <> 'E'")
                        ->orderBy('sprinkle_no', 'desc')
                        ->limit(20)
                        ->get();
        return $headers;
    }

    function searchGetParam($request)
    {
        $fromTransactionDate = $request->from_transaction_date ?? '';
        $toTransactionDate = $request->to_transaction_date ?? '';

        $profile = getDefaultData($this::url);
        $headers = PtpmSprinkleTobaccoHeader::selectRaw("
                        sprinkle_header_id as value,
                        sprinkle_no as label
                    ")
                    // ->where('organization_id', $profile->organization_id)
                    ->where('interface_status', 'S')
                    ->orderBy('transaction_date', 'desc');


        if ($fromTransactionDate || $toTransactionDate ) {

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
                    ->get();

        } else {
            $headers = $headers->limit(50)->get();
        }

        $sprinkleHeaderIdList = [];
        if (count($headers)) {
            $sprinkleHeaderIdList = $headers->toArray();
        }
        return [
            'sprinkle_header_id_list' => $sprinkleHeaderIdList,
        ];
    }


    function store($request)
    {
        $profile = getDefaultData('/pm/sprinkle-tobaccos');
        $sysdate = now();
        $inputHeader = (object) $request->header;
        $inputLines = (object) $request->select_onhand;
        if (count($request->select_onhand) == 0) {
            throw new \Exception('ไม่พบปริมาณคงคลัง');
        }

        if (count($inputLines->lot_list) == 0) {
            throw new \Exception('ไม่รายการ Lot');
        }

        $lotList = collect($inputLines->lot_list);
        $totalIssue = $lotList->sum(function ($lot) {
            return $lot['issue_quantity'];
        });

        if ($inputHeader->receipt_quantity != $totalIssue) {
            throw new \Exception('จำนวนที่ต้องการและปริมาณที่นำไปโรยไม่ตรงกัน');
        }

        $oldTrans = PtpmSprinkleTobaccoHeader::where('sprinkle_no', $inputHeader->sprinkle_no)->get();
        if (count($oldTrans->where('status', 'S'))) {
            throw new \Exception("เลขที่เอกสาร: {$inputHeader->sprinkle_no} มีในระบบแล้ว");
        }
        // ลบ sprinkle_no ที่ซ้ำ
        foreach ($oldTrans as $key => $old) {
            if ($old->status != 'S') {
                $old->sprinkle_no   = $inputHeader->sprinkle_no .'-'. date('YmdHis');
                $old->updated_at    = $sysdate;
                $old->updated_by_id = $profile->user_id;
                $old->deleted_by_id = $profile->user_id;
                $old->save();
                $old->delete();
            }
        }

        $header                     = new PtpmSprinkleTobaccoHeader;
        $header->sprinkle_no        = $inputHeader->sprinkle_no;
        $header->organization_id    = $inputHeader->to_organization_id;
        $header->subinventory_code  = $inputHeader->to_subinventory;
        $header->locator_id         = $inputHeader->to_locator_id;
        $header->batch_id           = $inputHeader->batch_id;
        $header->opt                = $inputHeader->opt;
        $header->product_item_id    = $inputHeader->product_item_id;
        $header->transaction_date   = parseFromDateTh($inputHeader->transaction_date_format, 'H:i:s');
        $header->receipt_quantity   = $inputHeader->receipt_quantity;
        $header->receipt_uom_code   = $inputHeader->receipt_uom_code;

        $header->program_code       = $profile->program_code;
        $header->created_at         = $sysdate;
        $header->updated_at         = $sysdate;
        $header->created_by_id      = $profile->user_id;
        $header->updated_by_id      = $profile->user_id;

        $header->web_batch_no       = null;
        $header->created_by         = $profile->fnd_user_id;
        $header->last_updated_by    = $profile->fnd_user_id;
        $header->creation_date      = $sysdate;
        $header->last_update_date   = $sysdate;
        $header->transfer_status    = $inputHeader->transfer_status;
        $header->save();
        $header->web_batch_no       = $header->sprinkle_header_id;
        $header->save();

        foreach ($lotList as $key => $lot) {
            $lot = (object) $lot;
            if ($inputLines->is_selected && $inputLines->can_misc_receipt && !$inputLines->is_disable) {
                $line = new PtpmSprinkleTobaccoLine;

                $line->sprinkle_header_id   = $header->sprinkle_header_id;
                $line->line_number          = $key += 1;
                $line->inventory_item_id    = $lot->inventory_item_id;
                $line->organization_id      = $header->organization_id;
                $line->subinventory         = $lot->subinventory_code;
                $line->locator_id           = $lot->locator_id;
                $line->lot_number           = $lot->lot_number;
                $line->issue_quantity       = $lot->issue_quantity;
                $line->issue_uom_code       = $lot->issue_uom_code;

                $line->program_code         = $header->program_code;
                $line->created_at           = $header->created_at;
                $line->updated_at           = $header->updated_at;
                $line->created_by_id        = $header->created_by_id;
                $line->updated_by_id        = $header->updated_by_id;

                $line->web_batch_no         = $header->web_batch_no;
                $line->created_by           = $header->created_by;
                $line->last_updated_by      = $header->last_updated_by;
                $line->creation_date        = $header->creation_date;
                $line->last_update_date     = $header->last_update_date;
                $line->save();
            }
        }

        return $header;
        throw new \Exception("xxx");
    }


    function cancel($request)
    {
        $profile = $this->getProfile();
        $sysdate = now();
        $inputHeader = (object) $request->header;
        $inputLines = (object) $request->select_onhand;
        $lookUpCancel = FndLookupValue::where('lookup_type', 'PTPM_TOBACCO_SPRINKLE')
                                        ->where('enabled_flag', 'Y')
                                        ->where('lookup_code', '3')
                                        ->first();

        $header = PtpmSprinkleTobaccoHeader::where('sprinkle_header_id', $inputHeader->sprinkle_header_id)->first();

        if (!$header) {
            throw new \Exception('ไม่พบรายการที่ต้องการยกเลิก');
        }

        if (!is_null($header->cancel_by_id) && $header->cancel_flag == 'Y') {
            throw new \Exception("รายการ {$header->sprinkle_no} ถูกยกเลิกแล้ว");
        }

        $header->interface_status   = null;
        $header->transfer_status    = $lookUpCancel['lookup_code'];
        $header->cancel_date        = $sysdate;
        $header->cancel_flag        = 'Y';
        $header->updated_at         = $sysdate;
        $header->updated_by_id      = $profile->user_id;
        $header->save();

        $lines = PtpmSprinkleTobaccoLine::where('sprinkle_header_id', $header->sprinkle_header_id)->get();
        foreach ($lines as $key => $line) {
            $line->interface_status     = null;
            $line->updated_at           = $header->updated_at;
            $line->updated_by_id        = $header->updated_by_id;
            $line->save();
        }

        $result = (new PtpmSprinkleTobaccoHeader)->interface($header, $profile);
        if ($result['status'] != 'S') {

            $msg = $result['msg'];
            $lines = new PtpmSprinkleTobaccoLine;
            $lines = $lines->where('sprinkle_header_id', $header->sprinkle_header_id)->get();
            $msg .= "\n {$header->interfaced_msg}";
            foreach ($lines as $key => $line) {
                if ($line->interfaced_msg && $line->interface_status != 'S') {
                    $msg .= "\n {$line->interfaced_msg}";
                }
            }
            throw new \Exception($msg);
        }

        $header->cancel_by_id = $profile->user_id;
        $header->save();

        return $header;
        throw new \Exception("xxx");
    }

    function getProfile()
    {
        $data = getDefaultData($this::url);
        return $data;
    }

    function getInvDestination($organizationId, $inventoryItemId)
    {
        $data = collect(DB::select("
            SELECT  psmd.to_organization_id,psmd.to_subinventory,psmd.to_locator_id,psmd.to_locator_code
            FROM    ptpm_setup_mfg_departments_v psmd,
                    ptpm_item_number_v pin
            WHERE   psmd.wip_transaction_type_id = 44
            and     psmd.to_organization_id = pin.organization_id
            and     psmd.tobacco_group_code = pin.tobacco_group_code
            and     psmd.enable_flag = 'Y'
            and     psmd.organization_id = {$organizationId}
            and     pin.inventory_item_id = {$inventoryItemId}
        "));

        return optional($data)->first() ?? null;
    }

    function confirm($request)
    {
        $profile = $this->getProfile();
        $sysdate = now();
        $lookUpConfirm = FndLookupValue::where('lookup_type', 'PTPM_TOBACCO_SPRINKLE')
                                        ->where('enabled_flag', 'Y')
                                        ->where('lookup_code', '2')
                                        ->first();
        $header = PtpmSprinkleTobaccoHeader::where('sprinkle_header_id', $request['sprinkle_header_id'])->first();

        if (!$header) {
            throw new \Exception('ไม่พบรายการที่ต้องการยืนยันการโรยยาเส้น');
        }

        if (!is_null($header->cancel_by_id) && $header->cancel_flag == 'Y') {
            throw new \Exception("รายการ {$header->sprinkle_no} ถูกยืนยันเรียบร้อยแล้ว");
        }

        $lines = PtpmSprinkleTobaccoLine::where('sprinkle_header_id', $header->sprinkle_header_id)->get();
        foreach ($lines as $key => $line) {
            $line->interface_status     = null;
            $line->updated_at           = $header->updated_at;
            $line->updated_by_id        = $header->updated_by_id;
            $line->save();
        }

        $result = (new PtpmSprinkleTobaccoHeader)->interface($header, $profile);
        if ($result['status'] != 'S') {

            $msg = $result['msg'];
            $lines = new PtpmSprinkleTobaccoLine;
            $lines = $lines->where('sprinkle_header_id', $header->sprinkle_header_id)->get();
            $msg .= "\n {$header->interfaced_msg}";
            foreach ($lines as $key => $line) {
                if ($line->interfaced_msg && $line->interface_status != 'S') {
                    $msg .= "\n {$line->interfaced_msg}";
                }
            }
            throw new \Exception($msg);
        }

        $header->interface_status   = null;
        $header->transfer_status    = $lookUpConfirm['lookup_code'];
        $header->updated_at         = $sysdate;
        $header->updated_by_id      = $profile->user_id;
        $header->save();

        return $header;
        throw new \Exception("xxx");
    }
}
