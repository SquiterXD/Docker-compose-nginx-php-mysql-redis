<?php
namespace App\Repositories\PM;

use Illuminate\Database\Eloquent\Collection;

use DB;
use PDO;
use Arr;
use App\Models\PM\PtpmSendCigaretteHT;
use App\Models\PM\PtpmSendCigaretteLT;
use App\Models\PM\PtpmSendCigaretteStatus;
use App\Models\PM\PtpmItemNumberV;
use App\Models\PM\PtpmMfgFormulaV;
use App\Models\PM\PtmesBiWeeklyPlanJobV;

use App\Models\PM\PtBiweeklyV;

use App\Models\PM\PtmesPlanProcessDetail;
use App\Models\PM\PtpmSummaryBatchV;

use App\Models\PM\PtpmSetupMfgDepartmentsV;
use App\Repositories\PM\CommonRepository;

use App\Models\PM\PtpmItemProductTransfer;

class JamRepository
{
    function info($request)
    {
        $profile = getDefaultData('/pm/jams');
        $header = false;
        $organizationId = data_get($header, 'organization_id', $profile->organization_id);
        $orgM02 = $this->getOrgM02();

        // $onlyBlendList = PtmesBiWeeklyPlanJobV::selectRaw("distinct blend_no")
        //                     ->where('organization_id', $organizationId)
        //                     ->whereRaw("TRUNC(sysdate) = TRUNC(plan_date)")
        //                     ->get();
        // dd('xx', $request->all(), request()->transaction_date_format, 'transaction_date_format');
        $condition = "and     TRUNC(sysdate) = TRUNC(ppd.plan_start_date)";
        $transactionDateFormat = '';
        if (request()->transaction_date_format != '') {
            $transactionDateFormat = str_replace("'", "", request()->transaction_date_format);
            $transDate = parseFromDateTh($transactionDateFormat);
            $condition = "and     TRUNC(to_date('$transDate', 'YYYY-MM-DD')) = TRUNC(ppd.plan_start_date)";
        }

        $ppdTable = (new PtmesPlanProcessDetail)->getTable();
        $sbvTable = (new PtpmSummaryBatchV)->getTable();
        $onlyBlendList = collect(DB::select("
            SELECT  distinct ppd.blend_no
            FROM
                    $ppdTable ppd
                    , $sbvTable sbv
            where   1=1
            and     ppd.organization_id = sbv.organization_id
            and     ppd.batch_id = sbv.batch_id
            and     sbv.batch_status = 'WIP'
            and     ppd.blend_no is not null
            and     ppd.organization_id = $organizationId
            and     sbv.organization_id = $organizationId
            -- and     TRUNC(sysdate) = TRUNC(ppd.plan_start_date)
            $condition
        "));

        $blendNo = PtpmMfgFormulaV::selectRaw("
                        distinct
                        organization_code,
                        organization_id,
                        product_item_id     INVENTORY_ITEM_ID,
                        product_item_number ITEM_NUMBER,
                        product_item_desc   ITEM_DESC,
                        product_detail_uom  PRIMARY_UOM_CODE,
                        product_blend_no    BLEND_NO,
                        product_unit_of_measure,
                        product_item_number || ' : ' || product_item_desc as display
                    ")
                    ->where('organization_code', $profile->organization_code)
                    ->when($organizationId == $orgM02->organization_id, function($q) { // M02
                        $q->whereNotNull('product_blend_no');
                    })
                    ->when(count($onlyBlendList), function($q) use ($onlyBlendList) {
                        $q->whereIn('product_blend_no', $onlyBlendList->pluck('blend_no', 'blend_no'));
                    })
                    ->when(count($onlyBlendList) == 0, function($q) {
                        $q->whereRaw("1=2");
                    })
                    ->orderBy('product_item_number')
                    ->get();

        if (count($blendNo)) {
            $blendNo = collect($blendNo)->map(function ($row) use($request, $organizationId, $orgM02) {

                $workSteps = PtpmMfgFormulaV::selectRaw("distinct tobacco_type_code, tobacco_type")
                    ->where('organization_id', $row->organization_id)
                    ->where('product_item_id', $row->inventory_item_id)
                    ->orderBy('tobacco_type_code')
                    ->when($organizationId == $orgM02->organization_id, function($q) { // M02
                        $q->where('item_classification_code', '01');
                    })
                    ->get();

                $row->tobacco_type_list =  collect([]);
                if (count($workSteps)) {
                    $row->tobacco_type_list =  collect($workSteps->toArray());
                }

                return collect($row);
            });
        }
        $data = (object)[];
        $data->item_list                = $blendNo;
        $data->blend_no_list            = optional($blendNo)->pluck('blend_no', 'blend_no') ?? [];
        $data->tobacco_type_list        = [];
        // $data->chest_convert_rate       = $this->getConvertRate()->chest_convert_rate;
        // $data->box_convert_rate         = $this->getConvertRate()->box_convert_rate;

        $header = (object)[];
        $header->transaction_date_format    = ($transactionDateFormat != '') ? $transactionDateFormat : parseToDateTh(now());
        $header->blend_no                   = '';
        $header->inventory_item_id          = '';
        $header->product_qty                = '';
        $header->product_unit_of_measure    = '';
        $header->tobacco_type_code          = '';

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
        $preFixRoute            = 'pm.jams';
        $preFixAjaxRoute        = 'pm.ajax.jams';
        $url->index             = route("{$preFixRoute}.index", request()->all() ?? []);
        $url->index_ony         = route("{$preFixRoute}.index");
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
        $orgM02 = $this->getOrgM02();

        $commonRepo = new CommonRepository;
        $getConvertRate = $this->getConvertRate();
        $profile        = getDefaultData('/pm/jams');
        $organizationId = $profile->organization_id;

        $items = PtpmMfgFormulaV::with(['uom'])
                    ->selectRaw("
                        leaf_fomula,
                        inventory_item_id,
                        product_item_id,
                        product_item_number,
                        item_number,
                        item_desc,
                        detail_uom,
                        tobacco_group_code,
                        item_classification_code,
                        tobacco_type_code,
                        default_lot_no,
                        organization_id,
                        require_qty,
                        ratio_require_per_unit as ratio_require_per_unit
                    ")
                    ->where('organization_id', $organizationId)
                    ->when($headerReq->inventory_item_id, function($q) use($headerReq) {
                        $q->where('product_item_id', $headerReq->inventory_item_id);
                    })
                    ->when($headerReq->tobacco_type_code, function($q) use($headerReq) {
                        $q->where('tobacco_type_code', $headerReq->tobacco_type_code);
                    })
                    ->when($organizationId == $orgM02->organization_id, function($q) { // M02
                        $q->where('item_classification_code', '01');
                    })
                    ->get();

        $items = collect($items)->map(function ($row) use ($headerReq, $getConvertRate) {

            if ($headerReq->product_qty) {
                $row->require_qty = $row->ratio_require_per_unit * $headerReq->product_qty;
            }
            $row->is_selected       = false;


            $row->ca_qty            = '';
            $row->a3_qty            = '';
            $row->transaction_qty   = '';
            $row->transaction_uom   = $row->detail_uom;

            $row->ca_convert_rate   = $getConvertRate->ca_convert_rate;
            $row->a3_convert_rate   = $getConvertRate->a3_convert_rate;
            return collect($row);
        });

        return (object)[
            'lines' => $items,
        ];


        dd('xx', $headerReq, $items);

        // +"transaction_date_format": "04/06/2564"
        // +"blend_no": "99"
        // +"inventory_item_id": "10998"
        // +"product_qty": ""
        // +"product_unit_of_measure": ""
        // +"tobacco_type_code": ""



        if ($headerId = data_get($headerReq, 'storage_header_id', false)) {
        // if ($headerId = 22) {
            $header = PtpmSendCigaretteHT::find($headerId);
            $organizationId = data_get($header, 'organization_id', $profile->organization_id);

            if ($action == 'search' && $header->can->edit) {
                if ($header->transaction_date_format != $headerReq->transaction_date_format) {
                    $header->transaction_date = parseFromDateTh($headerReq->transaction_date_format, 'H:i:s');
                    $header->save();
                }

                if ($findBiweekly->biweekly_id != $findBiweekly->attribute1) {
                    $header->attribute1 = $findBiweekly->biweekly_id;
                    $header->attribute2 = $findBiweekly->biweekly;
                    $header->save();

                    $lines = PtpmSendCigaretteLT::where('storage_header_id', $headerId)->get();
                    foreach ($lines as $key => $line) {
                        $line->deleted_by_id = $profile->user_id;
                        $line->save();
                        $line->delete();
                    }
                }
            }
        } else {
            $header = $headerReq;
        }
        $header->attribute1 = $findBiweekly->biweekly_id;
        $header->attribute2 = $findBiweekly->biweekly;

        $oldLines = PtpmSendCigaretteLT::where('storage_header_id', $headerId)->get();
        // dd('xx', $oldLines, $headerId, $headerReq);
        $lines = collect([]);
        data_set($jobLines, '*.has_map', false);

        if ($header->can->edit) {

            $items = PtpmItemProductTransfer::with(['uom'])
                        ->where('organization_id', $organizationId)
                        ->where('biweekly', $header->attribute2)
                        ->get();

            $newLine = $this->getNewLine();
            $items = collect($items)->map(function ($row) use($newLine) {
                $data = array_merge((array) $newLine, $row->toArray());
                $data['segment1']        = $row->segment1;
                $data['description']     = $row->description;
                return $data;
            });

        } else {
        }

        $oldLines = $oldLines->where('has_map', false);
        // ข้อมูลเก่า
        foreach ($oldLines as $key => $row) {
            $data = (object)[];
            $data->is_selected        = true;
            $data->is_edit_item       = false;
            $data->storage_line_id    = $row->storage_line_id;
            $data->line_number        = $row->line_number;
            $data->organization_id    = $row->organization_id;
            $data->inventory_item_id  = $row->inventory_item_id;
            $data->cgc_quantity       = $row->cgc_quantity;
            $data->cgk_quantity       = $row->cgk_quantity;

            $data->segment1          = $row->attribute1;
            $data->description       = $row->attribute2;

            $lines->push($data);
        }

        return (object)[
            'biweekly' => $findBiweekly,
            'lines' => $lines,
        ];
    }

    function search($request)
    {
        $number = strtolower(request()->mfg_order_number);
        $headers = PtpmSendCigaretteHT::with([
                            'status:lookup_code,description'
                        ])
                        ->when($number, function($q) use($number) {
                            $q->whereRaw("LOWER(mfg_order_number) like '%{$number}%'");
                        })
                        ->orderBy('mfg_order_number', 'desc')
                        ->limit(20)
                        ->get();
        return $headers;
    }


    function store($request)
    {
        $inputHeader = (object) $request->header;
        $profile = getDefaultData('/pm/jams');
        $organizationId = $profile->organization_id;
        $sysdate = now();
        $headerId = Arr::get($request->header, 'storage_header_id', false);

        if ($headerId) {
            // $header = PtpmSendCigaretteHT::find($headerId);
            // $organizationId = data_get($header, 'organization_id', $profile->organization_id);

            // $lines = PtpmSendCigaretteLT::where('storage_header_id', $headerId)->get();
            // foreach ($lines as $key => $line) {
            //     $line->deleted_by_id = $profile->user_id;
            //     $line->save();
            //     $line->delete();
            // }
        } else {
            $header = new PtpmSendCigaretteHT;
            $header->created_by         = $profile->fnd_user_id;
            $header->created_by_id      = $profile->user_id;
            $header->created_at         = $sysdate;
            $header->creation_date      = $sysdate;
            $header->program_code       = $profile->program_code;
            $header->attribute15        = $organizationId;
        }

        $header->tobacco_type_code  = Arr::get(request()->header, 'tobacco_type_code');
        $header->transaction_date   = '';
        if (($sendDate = Arr::get(request()->header, 'transaction_date_format')) != '') {
            $header->transaction_date   = parseFromDateTh($sendDate, 'H:i:s');
        }

        $header->attribute1         = Arr::get(request()->header, 'inventory_item_id');
        $header->attribute2         = Arr::get(request()->header, 'blend_no');
        $header->attribute3         = Arr::get(request()->header, 'product_qty');
        $header->attribute4         = Arr::get(request()->header, 'product_unit_of_measure');
        $header->attribute5         = Arr::get(request()->header, 'request_quantity');

        $header->updated_by_id      = $profile->user_id;
        $header->last_updated_by    = $profile->fnd_user_id;
        $header->updated_at         = $sysdate;
        $header->last_update_date   = $sysdate;
        $header->save();

        foreach ($request->lines as $key => $reqLine) {
            $reqLine                  = (object) $reqLine;
            $line                     = new PtpmSendCigaretteLT;
            $line->created_by         = $profile->fnd_user_id;
            $line->created_by_id      = $profile->user_id;
            $line->created_at         = $sysdate;
            $line->creation_date      = $sysdate;
            $line->program_code       = $profile->program_code;

            $line->line_number          = $key += 1;
            $line->storage_header_id    = $header->storage_header_id ?? -1;
            $line->lot_number           = $reqLine->default_lot_no;
            $line->organization_id      = $reqLine->organization_id;
            $line->inventory_item_id    = $reqLine->inventory_item_id;

            $line->request_qty          = $reqLine->transaction_qty;
            $line->request_uom_code     = $reqLine->transaction_uom;
            $line->box_qty              = $reqLine->ca_qty; // หีบ
            $line->quarter_qty          = $reqLine->a3_qty; // ลูก




            $line->cgc_quantity         = 0;
            $line->cgk_quantity         = 0;

            $line->attribute1           = $reqLine->product_item_id; //attribute1
            $line->attribute2           = $reqLine->product_item_number; //attribute1
            $line->attribute3           = $reqLine->item_number; //attribute2
            $line->attribute4           = $reqLine->item_desc; //attribute2
            $line->attribute5           = $reqLine->item_classification_code; //attribute2
            $line->attribute6           = $reqLine->leaf_fomula; //attribute2

            $line->attribute7           = $reqLine->ratio_require_per_unit; //attribute2
            $line->attribute8           = $reqLine->tobacco_group_code; //attribute2
            $line->attribute9           = $reqLine->tobacco_type_code; //attribute2


            $line->updated_by_id        = $profile->user_id;
            $line->last_updated_by      = $profile->fnd_user_id;
            $line->updated_at           = $sysdate;
            $line->last_update_date     = $sysdate;
            $line->save();
        }

        return $header;
    }

    function asrsPkg($header)
    {
        $profile = getDefaultData('/pm/jams');

        $header->web_batch_no = $header->storage_header_id;
        $header->save();

        $lines = PtpmSendCigaretteLT::where('storage_header_id', $header->storage_header_id)->get();
        foreach ($lines as $key => $line) {
            $line->web_batch_no = $header->storage_header_id;
            $line->save();
        }

        $db     =   DB::connection('oracle')->getPdo();
        $sql    =   "
            declare
                v_status        varchar2(5);
                v_error_msg     varchar2(2000);
            begin
                ptpm_asrs_pkg.submit_to_asrs(p_program_code => 'PMP0002',
                                        p_web_batch_no => '$header->storage_header_id',
                                        p_user_name => '$profile->fnd_user_name',
                                        p_status => :v_status,
                                        p_err_msg => :v_error_msg);
                dbms_output.put_line('Status : ' || v_status);
                dbms_output.put_line('Error : ' || v_error_msg);
            end;
        ";

        $header->interfaced_msg = $sql;
        $header->save();
        \Log::info("{$header->web_batch_no} INF", [$sql]);
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':v_status', $result['status'], PDO::PARAM_STR, 10);
        $stmt->bindParam(':v_error_msg', $result['msg'], PDO::PARAM_STR, 4000);
        $stmt->execute();

        \Log::info("{$header->web_batch_no} INF", [$result]);
        return $result;
    }

    function getNewLine()
    {
        $line['is_selected']        = true;
        $line['is_edit_item']       = true;
        $line['storage_line_id']    = '';

        $line['line_number']        = '';
        $line['organization_id']    = '';
        $line['inventory_item_id']  = '';

        $line['cgc_quantity']       = '';
        $line['cgk_quantity']       = '';

        return (object) $line;
    }

    function findBiweekly($date)
    {
       $findBiweekly = PtBiweeklyV::whereRaw("TRUNC(TO_DATE('{$date}','YYYY-MM-DD')) BETWEEN START_DATE AND END_DATE")->first();
        return $findBiweekly;
    }

    function searchItem($request)
    {
        $inventoryItemId    = $request->inventory_item_id;
        $number             = strtolower($request->number) ?? false;
        $header             = json_decode($request->header ?? []);

        $profile            = getDefaultData('/pm/jams');
        $organizationId     = data_get($header, 'organization_id', $profile->organization_id);
        $transactionDate    = parseFromDateTh($header->transaction_date_format) ?? date('Y-m-d');
        $findBiweekly       = $this->findBiweekly($transactionDate);

        $items = [];
        if ($header->can->edit) {
            $tableName = (new PtpmItemProductTransfer)->getTable();
            $items = PtpmItemProductTransfer::with(['uom'])
                ->selectRaw("
                    distinct
                    {$tableName}.organization_id
                    , {$tableName}.inventory_item_id
                    , {$tableName}.segment1 segment1
                    , {$tableName}.description description
                    , {$tableName}.segment1 || ' : ' || {$tableName}.description  as display
                ")
                ->where("{$tableName}.organization_id", $organizationId)
                ->where('biweekly', $findBiweekly->biweekly)
                ->orderBy("{$tableName}.segment1")
                ->get();
        }

        return $items;
    }

    function getConvertRate()
    {
        $data = (object)[];
        $data->ca_convert_rate = 200; // หีบ
        $data->a3_convert_rate = 40; // ลูก
        return $data;
    }

    function getOrgM02()
    {
        $org = \DB::connection('oracle')->table('mtl_parameters')->where('organization_code', 'M02')->first();
        return $org;
    }
}
