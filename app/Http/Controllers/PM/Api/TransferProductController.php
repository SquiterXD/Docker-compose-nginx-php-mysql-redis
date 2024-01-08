<?php

namespace App\Http\Controllers\PM\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Arr;

use App\Models\PM\PtpmMfgFormulaV;
use App\Models\PM\PtpmSetupMfgDepartmentsV;
use App\Models\PM\Lookup\PtinvOnhandQuantitiesV;
use App\Models\PD\Lookup\MtlUnitsOfMeasureVl;
use App\Models\PM\Lookup\PtpmItemConvUomV;

use App\Models\PM\PtpmProductTransferH;
use App\Models\PM\PtpmProductTransferL;
use App\Models\PM\PtpmItemNumberV;

use App\Repositories\PM\CommonRepository;
use App\Repositories\PM\MaterialRequestRepository;
use App\Repositories\PM\TransferProductRepository;

use App\Models\Lookup\PtpmItemConvUomVLookup;
use App\Models\PM\PtmesProductLine;
use App\Models\PM\PtpmProductPlanL;
use Illuminate\Support\Facades\DB;

class TransferProductController extends Controller
{

    public function getLines(Request $request)
    {
        $lines = (new TransferProductRepository)->getLines($request);
        $data = [
            'lines' => $lines,
        ];
        
        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        try {
            $inputHeader    = (object) $request->header;
            $profile        = getDefaultData('/pm/transfer-products');
            $organizationId = $profile->organization_id;
            $sysdate = now();
            $attribute1 = $inputHeader->attribute1;
            $attribute2 = $inputHeader->attribute2;
            $headerId = Arr::get(request()->header, 'transfer_header_id', false);

            if ($headerId) {
                $header = PtpmProductTransferH::find($headerId);
                $organizationId = data_get($header, 'organization_id', $profile->organization_id);

            } else {
                $header = new PtpmProductTransferH;
                $header->created_by         = $profile->fnd_user_id;
                $header->created_by_id      = $profile->user_id;
                $header->created_at         = $sysdate;
                $header->creation_date      = $sysdate;
                $header->program_code       = $profile->program_code;
            }

            $header->attribute1         = $attribute1;
            $header->attribute2         = $attribute2;
            $header->organization_id    = $organizationId;
            $header->transfer_objective = Arr::get(request()->header, 'transfer_objective');
            $header->transfer_status    = Arr::get(request()->header, 'transfer_status');

            $header->product_date       = '';
            $header->transfer_date      = '';
            if (($sendDate = Arr::get(request()->header, 'product_date_format')) != '') {
                $header->product_date   = parseFromDateTh($sendDate, 'H:i:s');
            }
            if (($requestDate = Arr::get(request()->header, 'transfer_date_format')) != '') {
                $header->transfer_date  = parseFromDateTh($requestDate, 'H:i:s');
            }

            $header->updated_by_id      = $profile->user_id;
            $header->last_updated_by    = $profile->fnd_user_id;
            $header->updated_at         = $sysdate;
            $header->last_update_date   = $sysdate;
            $header->save();

            $selectLineIdList = [];
            foreach (request()->lines as $key => $reqLine) {
                $reqLine = (object) $reqLine;

                // if( $reqLine->item_number != '15104407' &&
                //     $reqLine->item_number != '15104408' &&
                //     $reqLine->item_number != '15104406'     ){
                //     $toUomConvert = PtpmItemConvUomVLookup::where('organization_id', $organizationId)
                //                                             ->where('inventory_item_id', $reqLine->inventory_item_id)
                //                                             ->where('from_uom_code', $reqLine->web_uom)
                //                                             ->value('to_uom_code'); 
                //     $convertTransaction_qty = collect(\DB::select("
                //                                 select  (apps.inv_convert.inv_um_convert (
                //                                                 item_id           => '{$reqLine->inventory_item_id}',
                //                                                 organization_id   => {$organizationId},
                //                                                 PRECISION         => NULL,
                //                                                 from_quantity     => '{$reqLine->web_qty}',
                //                                                 from_unit         => '{$reqLine->web_uom}',
                //                                                 to_unit           => '{$toUomConvert}',
                //                                                 from_name         => NULL,
                //                                                 to_name           => NULL)
                //                                         )   convert_transaction_qty
                //                                 from dual
                //                                                                                 "))->first();  
                // }

                $toUomConvert = PtpmItemConvUomVLookup::where('organization_id', $organizationId)
                                                            ->where('inventory_item_id', $reqLine->inventory_item_id)
                                                            ->where('from_uom_code', $reqLine->web_uom)
                                                            ->value('to_uom_code'); 
                $convertTransaction_qty = collect(\DB::select("
                                            select  (apps.inv_convert.inv_um_convert (
                                                            item_id           => '{$reqLine->inventory_item_id}',
                                                            organization_id   => {$organizationId},
                                                            PRECISION         => NULL,
                                                            from_quantity     => '{$reqLine->web_qty}',
                                                            from_unit         => '{$reqLine->web_uom}',
                                                            to_unit           => '{$toUomConvert}',
                                                            from_name         => NULL,
                                                            to_name           => NULL)
                                                    )   convert_transaction_qty
                                            from dual
                                                                                            "))->first();
                                                                                  
                if ($reqLine->transfer_line_id) {
                    $line = PtpmProductTransferL::find($reqLine->transfer_line_id);
                } else {
                    $line = new PtpmProductTransferL;
                    $line->created_by         = $profile->fnd_user_id;
                    $line->created_by_id      = $profile->user_id;
                    $line->created_at         = $sysdate;
                    $line->creation_date      = $sysdate;
                    $line->program_code       = $profile->program_code;
                }

                $line->transfer_header_id       = $header->transfer_header_id ?? -1;
                $line->transaction_type_id_from = $reqLine->transaction_type_id_from;
                $line->organization_id_from     = $reqLine->organization_id_from;
                $line->subinventory_from        = $reqLine->subinventory_from;
                $line->locator_id_from          = $reqLine->locator_id_from;

                $line->inventory_item_id        = $reqLine->inventory_item_id;

                $line->transaction_type_id_to   = $reqLine->transaction_type_id_to;
                $line->organization_id_to       = $reqLine->organization_id_to;
                $line->subinventory_to          = $reqLine->subinventory_to;
                $line->locator_id_to            = $reqLine->locator_id_to;
                
                //ส่วนการหยอดข้อมูลการแปลงหน่วย,จำนวนของการจ่ายออก และข้อมูลจำนวนการจ่ายออกที่เลือกตั้งแต่หน้าเว็บ
                // if( $reqLine->item_number != '15104407' &&
                //     $reqLine->item_number != '15104408' &&
                //     $reqLine->item_number != '15104406'     ){   
                //     $line->transaction_qty          = $convertTransaction_qty->convert_transaction_qty;
                //     $line->transaction_uom          = $toUomConvert;
                //     $line->web_qty                  = $reqLine->web_qty;
                //     $line->web_uom                  = $reqLine->web_uom;
                // }else {
                //     $line->transaction_qty          = $reqLine->web_qty*120;
                //     $line->transaction_uom          = 'PTN';
                //     $line->web_qty                  = $reqLine->web_qty;
                //     $line->web_uom                  = $reqLine->web_uom;
                // }

                $line->transaction_qty          = $convertTransaction_qty->convert_transaction_qty;
                $line->transaction_uom          = $toUomConvert;
                $line->web_qty                  = $reqLine->web_qty;
                $line->web_uom                  = $reqLine->web_uom;

                $line->biweekly                 = sprintf("%'02d", $reqLine->biweekly);
                $line->batch_id                 = $reqLine->batch_id;

                $line->attribute1               = $reqLine->locator_code_from;
                $line->attribute2               = $reqLine->locator_code_to;
                $line->attribute3               = $reqLine->item_number;
                $line->attribute4               = $reqLine->item_desc;
                $line->attribute5               = $reqLine->transaction_uom_desc;

                $line->updated_by_id        = $profile->user_id;
                $line->last_updated_by      = $profile->fnd_user_id;
                $line->updated_at           = $sysdate;
                $line->last_update_date     = $sysdate;
                $line->save();

                $selectLineIdList[]         = $line->transfer_header_id;
            }

            // clear รายการที่ไม่เลือก
            $lines = PtpmProductTransferL::where('transfer_header_id', $header->transfer_header_id)
                        ->whereNotIn('transfer_header_id', $selectLineIdList)
                        ->get();
            foreach ($lines as $key => $line) {
                $line->deleted_by_id = $profile->user_id;
                $line->save();
                $line->delete();
            }

            $header->refresh();
            $resHeader = request()->header;
            $resHeader['transfer_header_id'] = data_get($header, 'transfer_header_id',  -1);
            $resHeader['transfer_number'] = data_get($header, 'transfer_number', date('Ymd-His'));
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
    public function updatePtpmesProductLine($header, $line) {
        $ptmesProductLine = PtmesProductLine::query()
        ->where('organization_id', $header->organization_id)
        ->whereRaw("TRUNC(PRODUCT_DATE) = TO_DATE('{$header->transfer_date->format('Y-m-d')}', 'YYYY-mm-dd')")
        ->where('batch_id', $line->batch_id)
        ->where('inventory_item_id', $line->inventory_item_id)
        ->orderBy('wip_step', 'desc')
        ->first();
        $transfer_qty =  ( $line->transaction_qty * 1000) + optional($ptmesProductLine)->transfer_qty ?? 0;
        if($header->transfer_objective === '1') {
            $db = DB::statement("UPDATE ptmes_product_line SET  attribute3='Y'  WHERE batch_id = '{$line->batch_id}' AND wip_step='{$ptmesProductLine->wip_step}' AND organization_id = '{$header->organization_id}' AND inventory_item_id='{$line->inventory_item_id}' AND TRUNC(PRODUCT_DATE) = TO_DATE('{$header->transfer_date->format('Y-m-d')}', 'YYYY-MM-DD')");
        }
        return false;
        
    }
    public function setStatus(PtpmProductTransferH $header)
    {
        try {
            $status = request()->status;
            if ($status == 'confirmTransfer') {

                if ($header->transfer_status == 1 && $header->export_to_wms_flag != 'I') {

                    $result = $header->interface();

                    $header->refresh();
                    if ($header->export_to_wms_flag == 'I') {
                        $header->transfer_status = 2;
                        if($header->save()) {
                            $lines = PtpmProductTransferL::where('transfer_header_id', $header->transfer_header_id)
                                    ->get();
                            foreach($lines as $line) {
                                $this->updatePtpmesProductLine($header, $line);
                            }
                        }

                    } else {
                        throw new \Exception($result['status']);
                    }
                }

                $header->transfer_status = 2;
                $header->save();
            } elseif($status == 'cancelTransfer') {

                if ($header->transfer_status == 2) { // ส่งข้อมูลเรียบร้อย
                    $result = $header->cancelInterface();
                    $header->refresh();

                    if ($result['status'] == 'E' || $result['status'] == '') {
                        $msg = $result['status'];
                        $msg .= "\n $header->interface_msg ";
                        $lines = new PtpmProductTransferL;
                        $lines = $lines->where('transfer_header_id', $header->transfer_header_id)
                                ->get();
                        foreach ($lines as $key => $line) {
                            if ($line->interface_msg) {
                                $msg .= "\n {$line->interface_msg}";
                            }
                        }

                        throw new \Exception($msg);
                    }
                }
                $header->transfer_status = 4;
                $header->transaction_flag = 'Y';
                
                // update ptmes
                $lines = new PtpmProductTransferL;
                $lines = $lines->where('transfer_header_id', $header->transfer_header_id)
                        ->get();
                foreach($lines as $line) {
                    $ptmesProductLine = PtmesProductLine::query()
                                        ->where('organization_id', $header->organization_id)
                                        ->whereRaw("TRUNC(PRODUCT_DATE) = TO_DATE('{$header->transfer_date->format('Y-m-d')}', 'YYYY-mm-dd')")
                                        ->where('batch_id', $line->batch_id)
                                        ->where('inventory_item_id', $line->inventory_item_id)
                                        ->orderBy('wip_step', 'desc')
                                        ->first();
                    $transfer_qty =  optional($ptmesProductLine)->transfer_qty - ( $line->transaction_qty * 1000) ?? 0;

                    if($transfer_qty > 0) {
                        $set_attribute3 = "'Y'";
                    } else {
                        $set_attribute3 = 'null';
                    }
                    if($header->transfer_objective === '1') {
                        $db = DB::statement("UPDATE ptmes_product_line SET transfer_qty='{$transfer_qty}', attribute3={$set_attribute3}  WHERE batch_id = '{$line->batch_id}' AND wip_step='{$ptmesProductLine->wip_step}' AND organization_id = '{$header->organization_id}' AND inventory_item_id='{$line->inventory_item_id}' AND TRUNC(PRODUCT_DATE) = TO_DATE('{$header->transfer_date->format('Y-m-d')}', 'YYYY-MM-DD')");
                    }
                }
                $header->save();
            }

            $profile = getDefaultData('/pm/transfer-products');
            $sysdate = now();
            $header->updated_by_id      = $profile->user_id;
            $header->last_updated_by    = $profile->fnd_user_id;
            $header->updated_at         = $sysdate;
            $header->last_update_date   = $sysdate;
            $header->save();

            $data = [
                'status' => 'S',
                'transfer_status' => $header->transfer_status,
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

    public function getItem(Request $request)
    {
        try {

            $items = (new TransferProductRepository)->searchItem($request);
            $header= json_decode($request->header ?? []);
            $getDefaultUomLine = (new TransferProductRepository)->getDefaultUomLine($header->transfer_objective);

            $data = [
                'status' => 'S',
                'items' => $items,
                'uom_master' => optional($getDefaultUomLine)->default_uom
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

    public function getUOM(Request $request)
    {        
        $profile = getDefaultData('/pm/transfer-products');
        $UomList = PtpmItemConvUomVLookup::where('inventory_item_id', $request['inventoryItemId'])
                                        ->where('organization_id', $profile->organization_id)
                                        ->get();
        
        return response()->json(['UomList' => $UomList]);
    }

}
