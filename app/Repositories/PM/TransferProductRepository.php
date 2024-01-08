<?php
namespace App\Repositories\PM;

use Illuminate\Database\Eloquent\Collection;

use DB;
use Arr;
use App\Models\PM\PtpmRequestHeader;
use App\Models\PM\PtpmProductTransferH;
use App\Models\PM\PtpmProductTransferL;

use App\Models\PM\PtpmTransferObjective;
use App\Models\PM\PtpmTransferStatus;
use App\Models\PM\PtpmItemNumberV;
use App\Models\PM\PtpmItemProductTransfer;
use App\Models\PM\PtBiweeklyV;

use App\Repositories\PM\CommonRepository;

use App\Models\Lookup\PtpmItemConvUomVLookup;

class TransferProductRepository
{
    function info($request)
    {
        $profile = getDefaultData('/pm/transfer-products');
        //วัตถุประสงค์ในการเบิก
        $objectiveCodeList = PtpmTransferObjective::query()
                                ->select(['LOOKUP_CODE', 'MEANING', 'DESCRIPTION'])
                                ->where('attribute1', optional(auth()->user()->organization)->organization_code)
                                ->active()
                                ->get();

        //สถานะขอเบิก
        $requestStatusList = PtpmTransferStatus::select(['LOOKUP_CODE', 'MEANING', 'DESCRIPTION'])
                                ->active()
                                ->get();


        $data = (object)[];
        $data->objective_code_list = collect(optional($objectiveCodeList)->toArray() ?? []);
        $data->request_status_list = collect(optional($requestStatusList)->toArray() ?? []);
        $data->new_line = $this->getNewLine();

        $model = new PtpmProductTransferH();
        $can = $model->can;
        $header                         = (object)[];
        $header->can                    = $can;
        $header->transfer_objective     = optional($objectiveCodeList->first())->lookup_code ?? '';
        $header->transfer_status        = optional($requestStatusList->first())->lookup_code ?? "1";
        $header->product_date_format    = parseToDateTh(now());
        $header->transfer_date_format   = parseToDateTh(now());

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
        $preFixRoute            = 'pm.transfer-products';
        $preFixAjaxRoute        = 'pm.ajax.transfer-products';
        $url->index             = route("{$preFixRoute}.index", request()->all() ?? []);
        $url->ajax_store        = route("{$preFixAjaxRoute}.store");
        $url->ajax_get_lines    = route("{$preFixAjaxRoute}.get-lines");
        $url->ajax_get_item     = route("{$preFixAjaxRoute}.get-item");
        $url->ajax_set_status   = route("{$preFixAjaxRoute}.set-status", $headerId);
        $url->ajax_get_uom      = route("{$preFixAjaxRoute}.transfer-products.get-uom");
        return $url;
    }

    function getNewLine()
    {
        $line['is_selected']                = true;
        $line['is_edit_item']               = true;
        $line['transfer_line_id']           = '';

        $line['transaction_type_id_from']   = '';
        $line['organization_id_from']       = '';
        $line['subinventory_from']          = '';
        $line['locator_id_from']            = '';

        $line['inventory_item_id']          = '';
        $line['lot_number']                 = '';

        $line['transaction_type_id_to']     = '';
        $line['organization_id_to']         = '';
        $line['subinventory_to']            = '';
        $line['locator_id_to']              = '';

        $line['transaction_qty']            = '';
        $line['transaction_uom']            = '';
        //$line['secondary_uom_list']       = '';

        $line['biweekly']                   = '';
        $line['batch_id']                   = '';

        $line['locator_code_from']          = '';   // attribute1
        $line['locator_code_to']            = '';   // attribute2
        $line['item_number']                = '';   // attribute3
        $line['item_desc']                  = '';   // attribute4
        $line['transaction_uom_desc']       = '';   // attribute5
        
        $line['uom_list']                   = [];
        $line['uom']                        = '';

        return (object) $line;
    }

    function searchItem($request)
    {
        $inventoryItemId    = $request->inventory_item_id;
        $numberSearch       = '';
        $charSearch         = '';
        // $number             = strtoupper($request->number) ?? false;

        $header             = json_decode($request->header ?? []);

        $requestLineId      = $request->request_line_id;
        $productDateFormat    = parseFromDateTh($header->product_date_format) ?? date('Y-m-d');
        $findBiweekly       = $this->findBiweekly($productDateFormat);

        $profile            = getDefaultData('/pm/transfer-products');
        $organizationId     = data_get($header, 'organization_id', $profile->organization_id);
        $commonRepo         = new CommonRepository;

        $transferObjective = data_get($header, 'transfer_objective');
        $objective = PtpmTransferObjective::where('lookup_code', $transferObjective)->active()->first();

        $tableName = (new PtpmItemProductTransfer)->getTable();
        $mttName = (new \App\Models\PM\MtlTransactionType)->getTable();

        $joinTableName = (new \App\Models\PM\PtpmSetupMfgDepartmentsV)->getTable();

        //ที่ต้องแยกระหว่าง ตัวอักษรและตัวเลขเพราะว่า ถ้านำตัวอักษรไปหาพร้อมกับตัวเลขจะเกิดการซ้ำข้อมูลภายใน 
        //LOV และขึ้นข้อมูลที่ได้จะผิดเพราะจะเอาข้อมูลที่ไม่เกี่ยวข้องขึ้นมาด้วย
        if(is_numeric($request->number)){
            $numberSearch = strtoupper($request->number) ?? false;
        }else{
            $charSearch = strtoupper($request->number) ?? false;
        }
        // dd($request->all(), $productDateFormat, $findBiweekly);
        $items = PtpmItemProductTransfer::query()
                    ->with(['uom'])
                    ->selectRaw("
                        distinct
                        {$tableName}.organization_id
                        , {$tableName}.inventory_item_id
                        , {$tableName}.primary_uom_code
                        --, {$tableName}.primary_uom_code                                     transaction_uom
                        , {$tableName}.primary_unit_of_measure                              transaction_uom_desc
                        , '' secondary_uom_list
                        , {$tableName}.segment1                                             item_number
                        , {$tableName}.description                                          item_desc
                        , {$tableName}.item_category
                        , {$tableName}.segment1 || ' : ' || {$tableName}.description        as display
                        , {$tableName}.biweekly
                        , {$tableName}.batch_id
                        , {$joinTableName}.transaction_type_id                              transaction_type_id_from
                        , {$joinTableName}.from_organization_id                             organization_id_from
                        , {$joinTableName}.from_organization_code                           organization_code_from
                        , {$joinTableName}.from_subinventory                                subinventory_from
                        , {$joinTableName}.from_locator_id                                  locator_id_from
                        , {$joinTableName}.from_locator_code                                locator_code_from

                        --, {$joinTableName}.transaction_type_id                            transaction_type_id_to
                        , {$mttName}.attribute1                                             transaction_type_id_to
                        , {$joinTableName}.to_organization_id                               organization_id_to
                        , {$joinTableName}.to_organization_code                             organization_code_to
                        , {$joinTableName}.to_subinventory                                  subinventory_to
                        , {$joinTableName}.to_locator_id                                    locator_id_to
                        , {$joinTableName}.to_locator_code                                  locator_code_to
                    ")
                    ->when($charSearch, function ($query, $charSearch) use($tableName) {
                        return $query->where("{$tableName}.description", 'like', '%' . "{$charSearch}" . '%');
                    })
                    ->leftJoin($joinTableName, function($join) use ($tableName, $joinTableName) {
                        $join->on("{$joinTableName}.tobacco_group_code", "{$tableName}.item_category")
                            ->whereRaw("to_char({$joinTableName}.organization_id) = to_char({$tableName}.organization_id)")
                            ->where("{$joinTableName}.enable_flag", "Y")
                            ->where("{$joinTableName}.wip_transaction_type_name", "WIP Completion");
                            // ->where("{$joinTableName}.wip_transaction_type_id", 44);
                    })
                    ->leftJoin($mttName, function($join) use ($mttName, $joinTableName) {
                        $join->on("{$mttName}.transaction_type_id", "{$joinTableName}.transaction_type_id");
                    })
                    ->whereNotNull("{$joinTableName}.from_subinventory")
                    ->where("{$tableName}.organization_id", $organizationId)
                    ->when(!is_null($objective), function($q) use($objective, $tableName) {
                        if ($objective->tag) {
                            $q->where("{$tableName}.item_category", $objective->tag);
                        }
                    })
                    ->where("{$tableName}.biweekly", optional($findBiweekly)->biweekly ?? -1)
                    ->when($numberSearch, function ($query, $numberSearch) use($tableName) {
                        return $query->where("{$tableName}.segment1", 'like', '%' . "{$numberSearch}" . '%');                                     
                    })
                    ->orderBy("{$tableName}.segment1")
                    ->get();
                $items = collect($items)->map(function ($row) use($commonRepo) {
                    // $secUomList = $commonRepo->getSecUomList((object)[
                    //                     'inventory_item_id' => $row->inventory_item_id,
                    //                     'organization_id' => $row->organization_id,
                    //                     'to_uom_code' => $row->primary_uom_code,
                    //                 ]);
                    $line                           = $row->toArray();
                    // $line['secondary_uom_list']     = $secUomList ?? [];
                    return $line;
                });
        return $items;
    }
    function getDefaultUomLine($objectiveId) {
       return $ptpmTransferObjective = \DB::table('PTPM_TRANSFER_OBJECTIVE')->where('LOOKUP_CODE', $objectiveId)->selectRaw('attribute3 as default_uom')->get()->first();
    }
    function getLines($request)
    {
        $headerReq = json_decode($request->header ?? []);
        $getDefaultUomLine = $this->getDefaultUomLine($headerReq->transfer_objective);
        $action = $request->action;

        $commonRepo = new CommonRepository;
        $profile        = getDefaultData('/pm/ajax/transfer-products');
        $organizationId = $profile->organization_id;

        if ($headerId = data_get($headerReq, 'transfer_header_id', false)) {
        // if ($headerId = 437) {
            $header = PtpmProductTransferH::find($headerId);
            $organizationId = data_get($header, 'organization_id', $profile->organization_id);

            if ($action == 'search') {
                $hasChange = false;
                if ($header->transfer_objective != $headerReq->transfer_objective) {
                    $header->transfer_objective = $headerReq->transfer_objective;
                    $hasChange = true;
                }

                if ($hasChange) {
                    $header->save();
                    $lines = PtpmProductTransferL::where('transfer_header_id', $headerId)->get();
                    foreach ($lines as $key => $line) {
                        $line->deleted_by_id = $profile->user_id;
                        $line->save();
                    }

                    PtpmProductTransferL::where('transfer_header_id', $headerId)->delete();
                }
            }
        } else {
            $header = $headerReq;
        }
        $items = [];
        $newLine = $this->getNewLine();
        $items = PtpmProductTransferL::where('transfer_header_id', $headerId)->get();
        $transactionDate = parseFromDateTh($header->product_date_format);
        $period = PtBiweeklyV::whereRaw("TRUNC(to_date('$transactionDate', 'YYYY-MM-DD')) between start_date and end_date")->first();
        $items = collect($items)->map(function ($row) use($commonRepo, $newLine, $getDefaultUomLine, $period, $header) {

            $row['uom_list'] = PtpmItemConvUomVLookup::where('inventory_item_id', $row['inventory_item_id'])
                                            ->where('organization_id', $row['organization_id_from'])
                                            ->get();
            $row['transaction_qty'] = $row['transaction_qty'] ? $row['web_qty'] : '';   
            $row['transaction_uom'] = $row['transaction_uom'] ? $row['web_uom'] : '';                       

            // $secUomList = $commonRepo->getSecUomList((object)[
            //                     'inventory_item_id' => $row->inventory_item_id,
            //                     'organization_id' => $row->organization_id,
            //                     'to_uom_code' => $row->primary_uom_code,
            //                 ]);

            $data = array_merge((array) $newLine, $row->toArray());
            $data['is_edit_item']           = false;
            $data['locator_code_from']      = $row->attribute1;
            $data['locator_code_to']        = $row->attribute2;
            $data['item_number']            = $row->attribute3;
            $data['item_desc']              = $row->attribute4;
            $data['transaction_uom_desc']   = $row->attribute5;
            $data['get_default_uom_line']   = $getDefaultUomLine->default_uom;
            //$data['secondary_uom_list'] = $secUomList ?? [];

            // dd('xx', $period, $row->inventory_item_id,  $row, $row->organization_id_from);
            $data['is_disable'] = false;
            $data['cost_valid'] = true;
            $data['cost_validate_msg'] = '';

            // $data['cost_valid'] = false;
            // $data['cost_validate_msg'] = 'xxxxx';
            if ($header->transfer_status == 1) { // 1   ยังไม่ส่งข้อมูล
                $costValidate = (new CommonRepository)->costValidate(
                    $row->inventory_item_id,
                    $row->organization_id_to,
                    $period->period_year );
                if ($costValidate['status'] != 'S') {
                    $data['is_disable'] = true;
                    $data['cost_valid']  = false;
                    $data['cost_validate_msg'] = $costValidate['msg'];
                }
            }

            if (!$data['cost_valid']) {
                $data['is_disable'] = true;
                $data['is_selected'] = false;
            }
            return $data;
        });


        return $items;
    }

    function search($request, $programCode = 'PMP0052')
    {
        $transferNumber = trim(strtolower(request()->transfer_number));
        $productDateFormat = request()->product_date_format ?? false;
        $transferDateFormat = request()->transfer_date_format ?? false;

        $headers = PtpmProductTransferH::with([
                            'objective:lookup_code,description',
                            'status:lookup_code,description'
                        ])
                        ->when($transferNumber, function($q) use($transferNumber) {
                            $q->whereRaw("LOWER(transfer_number) like '%{$transferNumber}%'");
                        })
                        ->when($productDateFormat, function($q) use($productDateFormat) {
                            $q->whereDate("product_date", parseFromDateTh($productDateFormat));
                        })
                        ->when($transferDateFormat, function($q) use($transferDateFormat) {
                            $q->whereDate("transfer_date", parseFromDateTh($transferDateFormat));
                        })
                        ->where('organization_id', session('organization_id'))
                        ->where('program_code', $programCode)
                        ->orderBy('transfer_number')
                        ->limit(50)
                        ->get();
        return $headers;
    }

    function findBiweekly($date)
    {
       $findBiweekly = PtBiweeklyV::whereRaw("TRUNC(TO_DATE('{$date}','YYYY-MM-DD')) BETWEEN START_DATE AND END_DATE")->first();
        return $findBiweekly;
    }

}
