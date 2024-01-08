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

use App\Models\PM\PtBiweeklyV;

use App\Models\PM\PtpmSetupMfgDepartmentsV;
use App\Repositories\PM\CommonRepository;

use App\Models\PM\PtpmItemProductTransfer;

class SendCigaretteRepository
{
    function info($request)
    {
        $profile = getDefaultData('/pm/send-cigarettes');
        //สถานะขอเบิก
        $status = PtpmSendCigaretteStatus::select(['LOOKUP_CODE', 'MEANING', 'DESCRIPTION'])
                    ->active()
                    ->get();

        $data = (object)[];
        $data->mfg_status_list = collect(optional($status)->toArray() ?? []);
        $data->new_line = $this->getNewLine();
        $data->convert_rate = 10;

        $model = new PtpmSendCigaretteHT();
        $can = $model->can;
        $header                         = (object)[];
        $header->can                    = $can;
        $header->mfg_order_number       = '';
        $header->lot_number             = '';
        $header->mfg_status             = optional($status->first())->lookup_code ?? "1";
        $header->transaction_date_format = parseToDateTh(now());
        $header->remark_msg             = '';

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
        $preFixRoute            = 'pm.send-cigarettes';
        $preFixAjaxRoute        = 'pm.ajax.send-cigarettes';
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
        $profile        = getDefaultData('/pm/send-cigarettes');
        $organizationId = $profile->organization_id;
        $transactionDate = parseFromDateTh($headerReq->transaction_date_format) ?? date('Y-m-d');
        $findBiweekly    = $this->findBiweekly($transactionDate);



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
        
        if (isset($lines)) {
            $lines = $this->getLineDetail($header->transaction_date_format);
        }

        // dd($lines);
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
        $profile = getDefaultData('/pm/send-cigarettes');
        $organizationId = $profile->organization_id;
        $sysdate = now();
        $headerId = Arr::get($request->header, 'storage_header_id', false);

        if ($headerId) {
            $header = PtpmSendCigaretteHT::find($headerId);
            $organizationId = data_get($header, 'organization_id', $profile->organization_id);

            $lines = PtpmSendCigaretteLT::where('storage_header_id', $headerId)->get();
            foreach ($lines as $key => $line) {
                $line->deleted_by_id = $profile->user_id;
                $line->save();
                $line->delete();
            }
        } else {
            $header = new PtpmSendCigaretteHT;
            $header->created_by         = $profile->fnd_user_id;
            $header->created_by_id      = $profile->user_id;
            $header->created_at         = $sysdate;
            $header->creation_date      = $sysdate;
            $header->program_code       = $profile->program_code;
        }

        $header->mfg_status         = Arr::get(request()->header, 'mfg_status');
        $header->remark_msg         = Arr::get(request()->header, 'remark_msg');
        $header->transaction_date   = '';
        if (($sendDate = Arr::get(request()->header, 'transaction_date_format')) != '') {
            $header->transaction_date   = parseFromDateTh($sendDate, 'H:i:s');
        }

        $header->updated_by_id      = $profile->user_id;
        $header->last_updated_by    = $profile->fnd_user_id;
        $header->updated_at         = $sysdate;
        $header->last_update_date   = $sysdate;
        $header->attribute15        = $organizationId;
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
            $line->lot_number           = $header->lot_number;
            $line->storage_header_id    = $header->storage_header_id ?? -1;
            $line->organization_id      = $reqLine->organization_id;
            $line->inventory_item_id    = $reqLine->inventory_item_id;
            $line->cgc_quantity         = $reqLine->cgc_quantity;
            $line->cgk_quantity         = $reqLine->cgk_quantity;

            $line->attribute1           = $reqLine->segment1; //attribute1
            $line->attribute2           = $reqLine->description; //attribute2

            $line->updated_by_id        = $profile->user_id;
            $line->last_updated_by      = $profile->fnd_user_id;
            $line->updated_at           = $sysdate;
            $line->last_update_date     = $sysdate;
            $line->save();
        }

        return $header;
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

        $profile            = getDefaultData('/pm/send-cigarettes');
        $organizationId     = data_get($header, 'organization_id', $profile->organization_id);
        $transactionDate    = parseFromDateTh($header->transaction_date_format) ?? date('Y-m-d');
        $findBiweekly       = $this->findBiweekly($transactionDate);

        $lines              = $request->lines;
        $arrayInventoryItem = [];

        foreach ($lines as $value) {
            $line = json_decode($value ?? []);

            if ($line->inventory_item_id != $inventoryItemId) {
                array_push($arrayInventoryItem, $line->inventory_item_id);
            }
        }

        $items = [];
        if ($header->can->edit) {
            if (isset($arrayInventoryItem)) {
                $items = $this->getItem($arrayInventoryItem);
            } 

            // $tableName = (new PtpmItemProductTransfer)->getTable();
            // $items = PtpmItemProductTransfer::with(['uom'])
            //     ->selectRaw("
            //         distinct
            //         {$tableName}.organization_id
            //         , {$tableName}.inventory_item_id
            //         , {$tableName}.segment1 segment1
            //         , {$tableName}.description description
            //         , {$tableName}.segment1 || ' : ' || {$tableName}.description  as display
            //     ")
            //     ->when($number, function($q) use($number, $tableName) {
            //         $q->whereRaw("LOWER({$tableName}.segment1 || ' : ' || {$tableName}.description) like '%{$number}%'");
            //     })
            //     ->where("{$tableName}.organization_id", $organizationId)
            //     ->where('biweekly', $findBiweekly->biweekly)
            //     ->orderBy("{$tableName}.segment1")
            //     ->get();       
        }

        return $items;
    }

    function asrsPkg($header)
    {
        $profile = getDefaultData('/pm/send-cigarettes');

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
                ptpm_asrs_pkg.submit_to_asrs(p_program_code => '$profile->program_code',
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

    public function getLineDetail($date)
    {
        $lines = [];

        if ($date) {
            $lines = $this->getDataLine($date);
            foreach ($lines as $line) {
                $line->is_selected        = true;
                $line->is_edit_item       = true;
                $line->storage_line_id    = '';

                $line->line_number        = '';
                $line->inventory_item_id  = $line->inventory_item_id;

                $line->cgc_quantity       = $line->cardboard_box;
                $line->cgk_quantity       = $line->thousand_cigarettes;
            }
        }

        return $lines;
    }

    public function getDataLine($date)
    {
        $planDate = parseFromDateth($date);
        $user     = auth()->user();
        $orgCode  = $user->organization ? $user->organization->organization_code : ''; 

        $data = collect(\DB::select("
            SELECT PBP.ORGANIZATION_ID  
                , PBP.PLAN_DATE 
                , PBP.ITEM_NUMBER   
                , MSI.DESCRIPTION   
                , MSI.SEGMENT1
                , SUM(PBP.PLAN_QUANTITY) PLAN_QUANTITY  
                , CEIL(SUM(PBP.PLAN_QUANTITY) / 10000) CARDBOARD_BOX  
                , CEIL(SUM(PBP.PLAN_QUANTITY) / 10000) * 10 THOUSAND_CIGARETTES 
                , PBP.INVENTORY_ITEM_ID
            FROM PTMES_BIWEEKLY_PLAN_JOBS_V PBP 
                , MTL_SYSTEM_ITEMS MSI  
            WHERE 1=1   
            AND PBP.ORGANIZATION_ID = MSI.ORGANIZATION_ID   
            AND PBP.INVENTORY_ITEM_ID = MSI.INVENTORY_ITEM_ID  
            AND PBP.PLAN_DATE = to_date('{$planDate}','yyyy-mm-dd')  
            AND (SELECT MP.ORGANIZATION_CODE    
            FROM MTL_PARAMETERS MP  
            WHERE MP.ORGANIZATION_ID = PBP.ORGANIZATION_ID) = '{$orgCode}' 
            GROUP BY PBP.ORGANIZATION_ID,PBP.PLAN_DATE,PBP.INVENTORY_ITEM_ID,PBP.ITEM_NUMBER,MSI.DESCRIPTION,MSI.SEGMENT1    
            ORDER BY PBP.ORGANIZATION_ID,PBP.PLAN_DATE,PBP.ITEM_NUMBER  
        "));

        // \Log::info('-------- PMP0042 getDataLine Start --------');
        // \Log::info($data);
        // \Log::info('-------- PMP0042 getDataLine End --------');
        
        return $data;
    }

    public function getItem($arrayInventoryItem)
    { 
        $user     = auth()->user();
        $orgCode  = $user->organization ? $user->organization->organization_code : '';

        $array = '';
        foreach ($arrayInventoryItem as $key => $item) {
            if ($key == 0) {
                $array = $array . $item;
            } else {
                $array = $array . ' , '. $item;
            }
        }
        $data = collect(\DB::select("
            SELECT MSI.SEGMENT1 ITEM_NUMBER 
                , MSI.DESCRIPTION   
                , MSI.ORGANIZATION_ID
                , MSI.INVENTORY_ITEM_ID
                , MSI.SEGMENT1 || ' : '|| MSI.DESCRIPTION display
                , MSI.SEGMENT1
            FROM MTL_SYSTEM_ITEMS MSI   
                , MTL_ITEM_CATEGORIES_V MIC 
            WHERE 1=1   
            AND (SELECT MP.ORGANIZATION_CODE    
            FROM MTL_PARAMETERS MP  
            WHERE MP.ORGANIZATION_ID = MSI.ORGANIZATION_ID) = '{$orgCode}' 
            AND MSI.ORGANIZATION_ID = MIC.ORGANIZATION_ID   
            AND MSI.INVENTORY_ITEM_ID = MIC.INVENTORY_ITEM_ID   
            AND MIC.SEGMENT1 = '1501'   
            AND MIC.SEGMENT2 NOT IN '9999'  
            AND MSI.INVENTORY_ITEM_ID NOT IN ({$array})
            ORDER BY MSI.SEGMENT1    
        "));

        // \Log::info('-------- PMP0042 getItem Start --------');
        // \Log::info($data);
        // \Log::info('-------- PMP0042 getItem End --------');

        return $data;
    }
}
