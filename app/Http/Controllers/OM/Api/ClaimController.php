<?php

namespace App\Http\Controllers\OM\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use DB;
use PDO;

use App\Models\OM\ClaimHeaders;
use App\Models\OM\ClaimLines;
use App\Models\OM\Attachments;
use App\Models\OM\ClaimStatusV;
use App\Models\OM\ConsignmentHeaders;
use App\Models\OM\UomV;
use App\Models\OM\UomConversionsV;
use App\Models\MtlParameter;

class ClaimController extends Controller
{
        public function invoiceList()
        {
                try {
                        $data = collect(\DB::select("
                                                        select  orderHeader.order_header_id                     order_header_id,
                                                                pick_release_no                                 pick_release_no,
                                                                consignment_no                                  consignment_no,
                                                                pick_release_status                             pick_release_status,
                                                                consignment_status                              consignment_status,
                                                                cus.customer_id                                 customer_id,
                                                                cus.customer_number                             customer_number,
                                                                customer_type_id                                customer_type_id,                  
                                                                decode(consignment.consignment_status
                                                                        ,'Confirm',consignment.consignment_no
                                                                        ,NULL,orderHeader.pick_release_no
                                                                        ,NULL)                                  invoice_number 
                                                                
                                                        from    PTOM_ORDER_HEADERS                              orderHeader,
                                                                ptom_customers                                  cus,
                                                                PTOM_CONSIGNMENT_HEADERS                        consignment,                                                                
                                                                (       select  distinct ref_invoice_number,status_claim_code
                                                                        from    PTOM_CLAIM_HEADERS
                                                                        where   1=1
                                                                        and     status_claim_code is not null
                                                                        and     ref_invoice_number is not null
                                                                )                                               claimHeader                 
                                                        where   1 = 1
                                                        and     orderHeader.customer_id       = cus.customer_id (+)                   
                                                        and     orderHeader.order_header_id   = consignment.order_header_id(+)
                                                        and     decode(consignment.consignment_status
                                                                        ,'Confirm',consignment.consignment_no
                                                                        ,NULL,orderHeader.pick_release_no
                                                                        ,NULL)                  = claimHeader.ref_invoice_number(+)
                                                        and  nvl(claimHeader.status_claim_code,'9') = '9'
                                                        and     upper(orderHeader.pick_release_status) = upper('Confirm')
                                                        and     decode(consignment.consignment_status
                                                                        ,'Confirm',consignment.consignment_no
                                                                        ,NULL,orderHeader.pick_release_no
                                                                        ,NULL) is not null 
                                                        and     decode(customer_type_id,
                                                                        '40',consignment.consignment_no,
                                                                        'YES') is not null                                                       
                                                                                                                                        "));
                        $data = [
                                'status' => 'S',
                                'data' => $data,
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

        public function detailList()
        {
                $orgA01Id = MtlParameter::where('organization_code', 'A01')->value('organization_id');
                $claimHeaderId = request()->claim_header_id ? request()->claim_header_id : '';
                $invoiceId = ClaimHeaders::where('claim_header_id', $claimHeaderId)->value('invoice_id');
                $invoiceId = $claimHeaderId == '' ? request()->invoice : $invoiceId;
                $claimHeader = ClaimHeaders::where('claim_header_id', $claimHeaderId)->get();
                $uomClassList = [];
                $fromUnitOrder = 'CGK';
                $toUnitOrder = 'CG2';
                $claimLines = ClaimLines::where('claim_header_id', $claimHeaderId)->get();
                $dataDetails = collect(\DB::select("
                                                        select         
                                                                orderHeader.order_header_id                             order_header_id,
                                                                cus.customer_id                                         customer_id,
                                                                customer_type_id                                        customer_type_id,                  
                                                                decode(consignment.consignment_status
                                                                        ,'Confirm',consignment.consignment_no
                                                                        ,NULL,orderHeader.pick_release_no
                                                                        ,NULL)                                          invoice_number,
                                                                decode(consignment.consignment_status
                                                                        ,'Confirm',consignment.consignment_date
                                                                        ,NULL,orderHeader.pick_release_approve_date
                                                                        ,NULL)                                          invoice_date,
                                                                cus.customer_number                                     customer_number,
                                                                customer_name                                           customer_name,
                                                                cus.province_code                                       province_code,
                                                                cus.province_name                                       province_name,
                                                                source_system                                           source_system,
                                                                remark_source_system                                    remark_source_system,
                                                                orderHeader.ship_to_site_id                             ship_to_site_id,
                                                                sites.ship_to_site_name                                 ship_to_site_name,
                                                                product_type_code                                       product_type_code
                                                        from    PTOM_ORDER_HEADERS                                      orderHeader,
                                                                ptom_customers                                          cus,
                                                                PTOM_CONSIGNMENT_HEADERS                                consignment,
                                                                PTOM_CUSTOMER_SHIP_SITES                                sites
                                                        where          1 = 1
                                                        and            orderHeader.customer_id                         = cus.customer_id (+)                   
                                                        and            orderHeader.order_header_id                     = consignment.order_header_id(+)
                                                        and            upper(orderHeader.pick_release_status)          = upper('Confirm')
                                                        and            orderHeader.ship_to_site_id                     = sites.ship_to_site_id
                                                        and            orderHeader.customer_id                         = sites.customer_id  
                                                        and            orderHeader.order_header_id = '{$invoiceId}'                                            "));
                
                $dataDetails->map(function ($item, $key) {
                        $item->invoice_date_converThDate = parseToDateTh($item->invoice_date); 
                        $item->claim_date_converThDate = parseToDateTh(now());
                });

                $checkConsignmentValue = ConsignmentHeaders::where('order_header_id',$invoiceId)
                                                        ->where('consignment_status', 'Confirm')
                                                        ->value('consignment_header_id');
                                                        
                if($checkConsignmentValue){
                        $getLine = collect(\DB::select("
                                                                select  
                                                                        orderHeader.order_header_id                                             order_header_id,
                                                                        orderLine.order_line_id                                                 order_line_id,
                                                                        orderLine.line_number                                                   line_number,
                                                                        orderLine.item_id                                                       item_id,
                                                                        orderLine.item_code                                                     item_code,
                                                                        orderLine.item_description                                              item_description,
                                                                        orderLine.uom_code                                                      uom_code,
                                                                        orderLine.uom                                                           uom,
                                                                        (apps.inv_convert.inv_um_convert (
                                                                                item_id           => orderLine.item_id,
                                                                                organization_id   => {$orgA01Id},
                                                                                PRECISION         => NULL,
                                                                                from_quantity     => actual_quantity,
                                                                                from_unit         => 'CGK',
                                                                                to_unit           => 'CGC',
                                                                                from_name         => NULL,
                                                                                to_name           => NULL)
                                                                        )                                                                       convert_order_CBB,
                                                                        --orderLine.approve_carton                                                order_carton,
                                                                        --orderLine.approve_quantity                                              order_quantity,
                                                                        consignmentLines.actual_quantity                                        actual_quantity
                                                                from    PTOM_ORDER_HEADERS                                                      orderHeader,
                                                                        PTOM_ORDER_LINES                                                        orderLine,
                                                                        PTOM_consignment_headers                                                consignmentHeader,
                                                                        ptom_consignment_lines                                                  consignmentLines
                                                                where   orderHeader.order_header_id = orderLine.order_header_id 
                                                                and     orderHeader.order_header_id = consignmentHeader.order_header_id 
                                                                and     consignmentHeader.consignment_header_id = consignmentLines.consignment_header_id 
                                                                and     orderLine.order_line_id = consignmentLines.order_line_id
                                                                and     consignmentHeader.consignment_header_id = '{$checkConsignmentValue}'
                                                                                                                                                                        ")); 
                                                                                                                                                                                                                                                                                         

                        $getLine->map(function ($item, $key) use($orgA01Id, $fromUnitOrder, $toUnitOrder) {
                                if(is_numeric($item->convert_order_cbb) && floor($item->convert_order_cbb) != $item->convert_order_cbb){
                                        list($whole, $decimal) = explode('.',$item->convert_order_cbb ?? '0.0');
                                        $convertOrderCarton = $item->order_carton = self::convertUnit($item->item_id, $orgA01Id, $decimal, $fromUnitOrder, $toUnitOrder);;
                                        $item->order_carton = $convertOrderCarton->result;
                                        $item->order_cbb = ''; 
                                }else {
                                        $item->order_carton = '';
                                        $item->order_cbb = $item->convert_order_cbb == 0 ? '' : $item->convert_order_cbb;
                                }
                        });
                        data_set($getLine, '*.is_select', true);
                }else {
                        // $totalHaveClaim = 0;
                        // $balanceQuotaClaim = 0;
                        $getLine = collect(\DB::select("
                                                        select          
                                                                orderHeader.order_header_id                                             order_header_id,
                                                                orderLine.order_line_id                                                 order_line_id,
                                                                orderLine.line_number                                                   line_number,
                                                                orderLine.item_id                                                       item_id,
                                                                orderLine.item_code                                                     item_code,
                                                                orderLine.item_description                                              item_description,
                                                                orderLine.uom_code                                                      uom_code,
                                                                orderLine.uom                                                           uom,
                                                                orderLine.approve_cardboardbox                                          order_CBB,
                                                                orderLine.approve_carton                                                order_carton,
                                                                orderLine.approve_quantity                                              order_quantity        
                                                        from    PTOM_ORDER_HEADERS                                                      orderHeader,
                                                                PTOM_ORDER_LINES                                                        orderLine
                                                        where   orderHeader.order_header_id = orderLine.order_header_id 
                                                        and     orderHeader.order_header_id = '{$invoiceId}'
                                                                                                                                                        "));    
                        
                
                        data_set($getLine, '*.is_select', true);
                        // $getLine->map(function ($item, $key) use($getLine, $orgA01Id, $totalHaveClaim){
                        //         $item->is_select = true;
                        //         $isClaimHeaders = ClaimHeaders::where('invoice_id', $item->order_header_id)->get();
                        //         if($isClaimHeaders){
                        //                 foreach ($isClaimHeaders as $key => $claimHeader) {
                        //                         foreach ($getLine as $key => $item) {
                        //                                 $isClaimLines = ClaimLines::where('claim_header_id', $claimHeader['claim_header_id'])->get();
                        //                                 foreach ($isClaimLines as $key => $claimLine) {
                        //                                         if($claimLine['item_id'] == $item->item_id){                                                                
                        //                                                 $baseUnitCodeHaveClaim = UomConversionsV::where('uom_code', $claimLine['claim_uom_code'])
                        //                                                                                         ->where('domestic', 'Y')
                        //                                                                                         ->value('base_unit_code');
                        //                                                 $baseUnitCodeOrder = UomConversionsV::where('uom_code', $item->uom_code)
                        //                                                                                         ->where('domestic', 'Y')
                        //                                                                                         ->value('base_unit_code');
                        //                                                 if($baseUnitCodeHaveClaim == $baseUnitCodeOrder){
                        //                                                         $convertHaveClaim = self::convertUnit(  $claimLine['item_id'], 
                        //                                                                                                 $orgA01Id, 
                        //                                                                                                 $claimLine['claim_quantity'], 
                        //                                                                                                 $claimLine['claim_uom_code'], 
                        //                                                                                                 $baseUnitCodeHaveClaim          );
                        //                                                         $convertOrder = self::convertUnit(      $item->item_id, 
                        //                                                                                                 $orgA01Id, 
                        //                                                                                                 $item->order_quantity, 
                        //                                                                                                 $item->uom_code, 
                        //                                                                                                 $baseUnitCodeOrder              );
                        //                                                         $totalHaveClaim += $convertHaveClaim->result;                   //ผลรวมจำนวนของ ของที่เคยเคลม
                        //                                                 }
                        //                                         }   
                        //                                 }        

                        //                         }
                        //                 }
                        //                 // $balanceQuotaClaim = $convertOrder->result - $totalHaveClaim;
                        //                 // $convertBalanceQuotaClaim = self::convertUnit(          $item->item_id, 
                        //                 //                                                         $orgA01Id, 
                        //                 //                                                         $balanceQuotaClaim, 
                        //                 //                                                         $baseUnitCodeHaveClaim, 
                        //                 //                                                         $item->uom_code              );
                        //                 // dd($convertBalanceQuotaClaim);
                        //                 // $balanceHaveClaim = $totalHaveClaim;
                        //         }
                        // });
                }

                $claimStatus = ClaimStatusV::select('lookup_code', 'meaning', 'description', 'enabled_flag')
                                        ->where('lookup_code', '1')
                                        ->where('enabled_flag', 'Y')
                                        ->get();    
                                        
                if($dataDetails[0]->product_type_code != '10'){
                        foreach ($getLine as $key => $value) {
                                $uomClass =  \DB::select("
                                                                select  uom_class
                                                                from    PTOM_UOM_V
                                                                where   domestic = 'Y'
                                                                and     uom_code = '{$value->uom_code}'  
                                                                                                                ");        
                                $uomClassList = \DB::select("
                                                                select  *
                                                                from    PTOM_UOM_V
                                                                where   domestic = 'Y'
                                                                and     uom_class = '{$uomClass[0]->uom_class}'  
                                                                                                                ");
                        }
                }

                $claimLines->map(function ($item, $key) use($claimHeaderId) {
                        $attachmentDefault = Attachments::where('header_id', $claimHeaderId)->get();
                        foreach ($attachmentDefault as $index => $value) {
                                if($value['line_id'] == ($key+1)){
                                        if($value['attribute1'] == '1'){
                                                $item->picturePackage = array($value);
                                        }elseif ($value['attribute1'] == '2') {
                                                $item->pictureCase = array($value);
                                        }elseif ($value['attribute1'] == '3') {
                                                $item->pictureBroken = array($value);
                                        }else{
                                                $item->picturePackage = [];
                                                $item->pictureCase = [];
                                                $item->pictureBroken = [];
                                        }
                                }                                
                        }
                });

                return response()->json([       'dataDetails' => $dataDetails,
                                                'getLine' => $getLine ? $getLine : '',
                                                'uomClassList' => $uomClassList ? $uomClassList : '',
                                                'claimStatus' => $claimStatus,
                                                'claimHeaderDetails' => $claimHeader,
                                                'claimLines' => $claimLines                    ]);
        }

        public function store()
        {
                $program_code           = 'OMP0049';
                $totalHaveClaim         = 0;
                $totalClaim             = 0;
                $userId                 = optional(auth()->user())->user_id ?? -1;
                $orgA01Id               = MtlParameter::where('organization_code', 'A01')
                                                        ->value('organization_id');
                $claimStatus = ClaimStatusV::select('lookup_code', 'meaning', 'description', 'enabled_flag')
                                        ->where('lookup_code', '2')
                                        ->where('enabled_flag', 'Y')
                                        ->get();
                $CGKUom = UomV::where('domestic','Y')
                                ->where('uom_code', 'CGK')
                                ->value('uom_code');    //พันมวน
                $cbbUom = UomV::where('domestic','Y')
                                ->where('uom_code', 'CGC')
                                ->value('uom_code');    //หีบ
                $cartonUom = UomV::where('domestic','Y')
                                ->where('uom_code', 'CG2')
                                ->value('uom_code');    //ห่อ
                $packUom = UomV::where('domestic','Y')
                                ->where('uom_code', 'CGP')
                                ->value('uom_code');    //ซอง

                foreach (request()->dataGroup as $key => $data) {
                        if(isset($data['claim_quantity_cbb'])||
                           isset($data['claim_quantity_carton'])||
                           isset($data['claim_quantity_pack'])){
                                $baseUnitCodeOrder = UomConversionsV::where('uom_code', $data['uom_code'])
                                                                        ->where('domestic', 'Y')
                                                                        ->value('base_unit_code');

                                $convertOrder = self::convertUnit($data['item_id'], 
                                                                  $orgA01Id, 
                                                                  $data['order_quantity'], 
                                                                  $data['uom_code'], 
                                                                  $baseUnitCodeOrder);

                                if(isset($data['claim_quantity_cbb'])){
                                        $baseUnitCodeClaimCbb = UomConversionsV::where('uom_code', $cbbUom)
                                                                        ->where('domestic', 'Y')
                                                                        ->value('base_unit_code');
                
                                        $convertCbb = self::convertUnit($data['item_id'], 
                                                                        $orgA01Id, 
                                                                        $data['claim_quantity_cbb'], 
                                                                        $cbbUom, 
                                                                        $baseUnitCodeClaimCbb);
                                }
                                if(isset($data['claim_quantity_carton'])){
                                        $baseUnitCodeClaimCarton = UomConversionsV::where('uom_code', $cartonUom)
                                                                        ->where('domestic', 'Y')
                                                                        ->value('base_unit_code');
                                        
                                        $convertCarton = self::convertUnit($data['item_id'], 
                                                                           $orgA01Id, 
                                                                           $data['claim_quantity_carton'], 
                                                                           $cartonUom, 
                                                                           $baseUnitCodeClaimCarton);
                                }
                                if(isset($data['claim_quantity_pack'])){
                                        $baseUnitCodeClaimPack = UomConversionsV::where('uom_code', $packUom)
                                                                        ->where('domestic', 'Y')
                                                                        ->value('base_unit_code');
                                        
                                        $convertPack = self::convertUnit($data['item_id'], 
                                                                         $orgA01Id, 
                                                                         $data['claim_quantity_pack'], 
                                                                         $packUom, 
                                                                         $baseUnitCodeClaimPack);
                                }
                                $totalClaim =   (isset($convertCbb) ? $convertCbb->result : 0) + 
                                                (isset($convertCarton) ? $convertCarton->result : 0) +
                                                (isset($convertPack) ? $convertPack->result : 0); //ผลรวมของจำนวน หีบ ห่อ ซอง ที่แปลงมาเป็น มวน

                                if($convertOrder->result < $totalClaim){
                                        return response()->json([ 'statuSave' => $statuSave = 'quotaExceeded' ]);                                                  
                                }
                        }elseif (isset($data['enter_claim_quantity'])||isset($data['enter_claim_uom'])){
                                //การแปลงหน่วยสำหรับ การหาหน่วยของจำนวนของตั้งต้นว่า 'user มีการซื้อของไปจำนวนเท่าไร' based on to ซอง(PTN) == ชิ้น(E00)
                                $baseUnitCodeOrder = UomConversionsV::where('uom_code', $data['uom_code'])
                                                ->where('domestic', 'Y')
                                                ->value('base_unit_code');
 
                                $convertOrder = self::convertUnit($data['item_id'], 
                                                                  $orgA01Id, 
                                                                  $data['order_quantity'], 
                                                                  $data['uom_code'], 
                                                                  $baseUnitCodeOrder); 

                                //การแปลงหน่วยสำหรับ การหาหน่วยของจำนวนของเคลมว่า 'user มีการขอของเคลมไปจำนวนเท่าไร' based on to ซอง(PTN) == ชิ้น(E00)      
                                $baseUnitCodeClaim = UomConversionsV::where('uom_code', $data['enter_claim_uom'])
                                                                ->where('domestic', 'Y')
                                                                ->value('base_unit_code');                                                                                                                
                                
                                $convertClaim = self::convertUnit($data['item_id'], 
                                                                  $orgA01Id, 
                                                                  $data['enter_claim_quantity'], 
                                                                  $data['enter_claim_uom'], 
                                                                  $baseUnitCodeClaim); 
                                // **** เซ็คตรงนี้ เพื่อเค้าชัวอีกที
                                if($convertOrder->result < $convertClaim->result){
                                        return response()->json([ 'statuSave' => $statuSave = 'quotaExceeded' ]);                                                  
                                }
                                
                                $isClaimHeaders = ClaimHeaders::where('invoice_id', $data['order_header_id'])->get();
                                if($isClaimHeaders){
                                        foreach ($isClaimHeaders as $key => $claimHeader) {
                                                $getLine = collect(\DB::select("
                                                                                select          
                                                                                        orderHeader.order_header_id                                             order_header_id,
                                                                                        orderLine.order_line_id                                                 order_line_id,
                                                                                        orderLine.line_number                                                   line_number,
                                                                                        orderLine.item_id                                                       item_id,
                                                                                        orderLine.item_code                                                     item_code,
                                                                                        orderLine.item_description                                              item_description,
                                                                                        orderLine.uom_code                                                      uom_code,
                                                                                        orderLine.uom                                                           uom,
                                                                                        orderLine.approve_cardboardbox                                          order_CBB,
                                                                                        orderLine.approve_carton                                                order_carton,
                                                                                        orderLine.approve_quantity                                              order_quantity        
                                                                                from    PTOM_ORDER_HEADERS                                                      orderHeader,
                                                                                        PTOM_ORDER_LINES                                                        orderLine
                                                                                where   orderHeader.order_header_id = orderLine.order_header_id 
                                                                                and     orderHeader.order_header_id = '{$claimHeader['invoice_id']}'
                                                                                                                                                                                        "));
                                                foreach ($getLine as $key => $item) {
                                                        $isClaimLines = ClaimLines::where('claim_header_id', $claimHeader['claim_header_id'])->get();
                                                        foreach ($isClaimLines as $key => $claimLine) {
                                                                if($claimLine['item_id'] == $data['item_id'] && $item->item_id == $data['item_id']){
                                                                        $baseUnitCodeHaveClaim = UomConversionsV::where('uom_code', $claimLine['claim_uom_code'])
                                                                                                        ->where('domestic', 'Y')
                                                                                                        ->value('base_unit_code');
                                                                        if($baseUnitCodeHaveClaim == $baseUnitCodeClaim && $baseUnitCodeClaim == $baseUnitCodeOrder){
                                                                                $convertHaveClaim = self::convertUnit(  $claimLine['item_id'], 
                                                                                                                        $orgA01Id, 
                                                                                                                        $claimLine['claim_quantity'], 
                                                                                                                        $claimLine['claim_uom_code'], 
                                                                                                                        $baseUnitCodeHaveClaim          );
                                                                                $totalHaveClaim += $convertHaveClaim->result;                   //ผลรวมจำนวนของ ของที่เคยเคลม
                                                                                $totalClaim = $totalHaveClaim + $convertClaim->result;          //ผลรวมจำนวนของ ของที่เคยเคลม + ของที่พึ่งของเคลม
                                                                        }
                                                                }   
                                                        }        
        
                                                }                                                                
                                        }    
                                        if($convertOrder->result < $totalClaim){
                                                return response()->json([ 'statuSave' => $statuSave = 'quotaExceeded' ]);                                                  
                                        }  
                                }                                
                        } 
                }     
                                
                try {
                        $db = \DB::connection()->getPdo();
                        $sql = "        DECLARE
                                                LV_DOC_SEQUENCE_NUMBER      VARCHAR2(100)   :=  NULL;
                                                LV_RETURN_STATUS            VARCHAR2(100)   :=  NULL;
                                                LV_RETURN_MSG               VARCHAR2(4000)  :=  NULL;
                                        BEGIN
                                                PTOM_WEB_UTILITIES_PKG.GENERATE_DOC_SEQUENCE_NUMBER 
                                        (       I_DOCUMENT_CODE                 =>  'OMP0049_CLAIM_NUM_DOM', 
                                                O_DOC_SEQUENCE_NUMBER           =>  :LV_DOC_SEQUENCE_NUMBER, 
                                                O_RETURN_STATUS                 =>  :LV_RETURN_STATUS,
                                                O_RETURN_MSG                    =>  :LV_RETURN_MSG
                                                                                                                );
                                        END;    
                                ";
                        $sql = preg_replace("/[\r\n]*/","",$sql);
                        logger($sql);

                        $stmt = $db->prepare($sql);

                        $stmt->bindParam(':LV_DOC_SEQUENCE_NUMBER', $result['LV_DOC_SEQUENCE_NUMBER'], \PDO::PARAM_STR, 100);
                        $stmt->bindParam(':LV_RETURN_STATUS', $result['LV_RETURN_STATUS'], \PDO::PARAM_STR, 4000);
                        $stmt->bindParam(':LV_RETURN_MSG', $result['LV_RETURN_MSG'], \PDO::PARAM_STR, 100);

                        $stmt->execute();

                } catch (\Exception $e) {
                        throw new \Exception($e->getMessage(), 1);
                }    
                
                if($result['LV_RETURN_STATUS'] == 'S'){
                        //กรณีที่การเรียก PKG Success
                        \DB::beginTransaction();
                        try {                     

                                $claimHeaders = new ClaimHeaders();
                                $claimHeaders->claim_number             = $result['LV_DOC_SEQUENCE_NUMBER'];
                                $claimHeaders->claim_date               = now();
                                $claimHeaders->invoice_id               = request()['invoice_id'];
                                $claimHeaders->invoice_date             = request()['invoice_date'];
                                $claimHeaders->customer_id              = request()['customer_id'];
                                $claimHeaders->province_code            = request()['province_code'];
                                $claimHeaders->source_system            = isset(request()['source_system']) ? request()['source_system'] : '';
                                $claimHeaders->remark_source_system     = isset(request()['remark_source_system']) ? request()['remark_source_system'] : '';;
                                $claimHeaders->ship_to_site_id          = request()['ship_to_site_id'];
                                $claimHeaders->symptom_description      = request()['symptom_description'];
                                $claimHeaders->status_claim_code        = $claimStatus[0]->lookup_code;
                                $claimHeaders->status_claim             = $claimStatus[0]->meaning;
                                $claimHeaders->sales_type               = 'DOMESTIC';
                                $claimHeaders->ref_invoice_number       = request()['invoiceNumber'];
                                $claimHeaders->program_code             = $program_code;
                                $claimHeaders->created_by_id            = $userId;
                                $claimHeaders->created_by               = $userId;
                                $claimHeaders->creation_date            = now();
                                $claimHeaders->last_updated_by          = $userId;
                                $claimHeaders->last_update_date         = now();
                                $claimHeaders->save();

                                foreach (request()->dataGroup as $key => $data) {  
                                        if(isset($data['claim_quantity_cbb'])||isset($data['claim_quantity_carton'])||isset($data['claim_quantity_pack'])){
                                                //ในส่วนของระดับ Line ที่เป็นประเภทบุหรี่
                                                if(isset($data['claim_quantity_cbb'])){                                                        
                                                        $convertCbbInsert = self::convertUnit($data['item_id'], 
                                                                                        $orgA01Id, 
                                                                                        $data['claim_quantity_cbb'], 
                                                                                        $cbbUom, 
                                                                                        $CGKUom);
                                                }
                                                if(isset($data['claim_quantity_carton'])){
                                                        $convertCartonInsert = self::convertUnit($data['item_id'], 
                                                                                           $orgA01Id, 
                                                                                           $data['claim_quantity_carton'], 
                                                                                           $cartonUom, 
                                                                                           $CGKUom);
                                                }
                                                if(isset($data['claim_quantity_pack'])){
                                                        $convertPackInsert = self::convertUnit($data['item_id'], 
                                                                                         $orgA01Id, 
                                                                                         $data['claim_quantity_pack'], 
                                                                                         $packUom, 
                                                                                         $CGKUom);
                                                }
                                                
                                                $totalClaim =   (isset($convertCbbInsert->result)? $convertCbbInsert->result : 0) + 
                                                                (isset($convertCartonInsert->result) ? $convertCartonInsert->result : 0) +
                                                                (isset($convertPackInsert->result) ? $convertPackInsert->result : 0); //ผลรวมของจำนวน หีบ ห่อ ซอง ที่แปลงมาเป็น พันมวน

                                                $claimLines                             = new ClaimLines();
                                                $claimLines->claim_header_id            = $claimHeaders->claim_header_id;
                                                $claimLines->claim_no                   = $key+1;
                                                $claimLines->item_id                    = $data['item_id'];
                                                $claimLines->item_code                  = $data['item_code'];
                                                $claimLines->item_description           = $data['item_description'];
                                                $claimLines->claim_quantity_cbb         = isset($data['claim_quantity_cbb']) ? $data['claim_quantity_cbb'] : '';
                                                $claimLines->claim_quantity_carton      = isset($data['claim_quantity_carton']) ? $data['claim_quantity_carton'] : '';
                                                $claimLines->claim_quantity_pack        = isset($data['claim_quantity_pack']) ? $data['claim_quantity_pack'] : '';
                                                $claimLines->order_line_id              = $data['order_line_id'];
                                                $claimLines->claim_quantity             = $totalClaim;
                                                $claimLines->claim_uom_code             = $CGKUom;
                                                $claimLines->program_code               = $program_code;
                                                $claimLines->created_by_id              = $userId;
                                                $claimLines->created_by                 = $userId;
                                                $claimLines->creation_date              = now();
                                                $claimLines->last_updated_by            = $userId;
                                                $claimLines->last_update_date           = now();
                                                if(isset($data['picturePackage'])){
                                                        foreach ($data['picturePackage'] as $key => $picture) {
                                                                $claimLines->picture_package_name       = $picture->getClientOriginalName();
                                                                
                                                                $attachment = new Attachments;
                                                                $attachment->create($claimLines, $picture, 'picturePackage', $data['line_number']);
                                                        }
                                                }
                                                if(isset($data['pictureCase'])){
                                                        foreach ($data['pictureCase'] as $key => $picture) {
                                                                $claimLines->picture_case_name       = $picture->getClientOriginalName();

                                                                $attachment = new Attachments;
                                                                $attachment->create($claimLines, $picture, 'pictureCase', $data['line_number']);
                                                        }
                                                }
                                                if(isset($data['pictureBroken'])){
                                                        foreach ($data['pictureBroken'] as $key => $picture) {
                                                                $claimLines->picture_broken_name       = $picture->getClientOriginalName();

                                                                $attachment = new Attachments;
                                                                $attachment->create($claimLines, $picture, 'pictureBroken', $data['line_number']);
                                                        }
                                                }
                                                $claimLines->save();
                                                
                                        }elseif (isset($data['enter_claim_quantity'])||isset($data['enter_claim_uom'])) {                                                
                                                $convertClaimQuantity = self::convertUnit($data['item_id'], 
                                                                                          $orgA01Id, 
                                                                                          $data['enter_claim_quantity'], 
                                                                                          $data['enter_claim_uom'], 
                                                                                          $data['uom_code']);

                                                $claimLines                             = new ClaimLines();
                                                $claimLines->claim_header_id            = $claimHeaders->claim_header_id;
                                                $claimLines->claim_no                   = $key+1;
                                                $claimLines->item_id                    = $data['item_id'];
                                                $claimLines->item_code                  = $data['item_code'];
                                                $claimLines->item_description           = $data['item_description'];
                                                $claimLines->enter_claim_quantity       = isset($data['enter_claim_quantity']) ? $data['enter_claim_quantity'] : '';    //จำนวนขอเคลมที่ระบุจากหน้า OMP0049
                                                $claimLines->enter_claim_uom            = isset($data['enter_claim_uom']) ? $data['enter_claim_uom'] : '';      //UOM Code ที่ขอเคลม
                                                $claimLines->order_line_id              = $data['order_line_id'];
                                                $claimLines->claim_quantity             = $convertClaimQuantity->result;  //ใช้ DB แปลงหน่วยนับ โดยแปลงให้เป็นจำนวน ตามหน่วย CLAIM_UOM_CODE
                                                $claimLines->claim_uom_code             = $data['uom_code'];    //ขายในประเทศ ถ้าไม่ใช่บุหรี่ในประเทศ ดึงจาก PTOM_ORDER_LINES.UOM_CODE
                                                $claimLines->program_code               = $program_code;
                                                $claimLines->created_by_id              = $userId;
                                                $claimLines->created_by                 = $userId;
                                                $claimLines->creation_date              = now();
                                                $claimLines->last_updated_by            = $userId;
                                                $claimLines->last_update_date           = now();
                                                if(isset($data['picturePackage'])){
                                                        foreach ($data['picturePackage'] as $key => $picture) {
                                                                $claimLines->picture_package_name       = $picture->getClientOriginalName();
                                                                
                                                                $attachment = new Attachments;
                                                                $attachment->create($claimLines, $picture, 'picturePackage', $key);
                                                        }
                                                }
                                                if(isset($data['pictureCase'])){
                                                        foreach ($data['pictureCase'] as $key => $picture) {
                                                                $claimLines->picture_case_name       = $picture->getClientOriginalName();

                                                                $attachment = new Attachments;
                                                                $attachment->create($claimLines, $picture, 'pictureCase', $key);
                                                        }
                                                }
                                                if(isset($data['pictureBroken'])){
                                                        foreach ($data['pictureBroken'] as $key => $picture) {
                                                                $claimLines->picture_broken_name       = $picture->getClientOriginalName();

                                                                $attachment = new Attachments;
                                                                $attachment->create($claimLines, $picture, 'pictureBroken', $key);
                                                        }
                                                }
                                                $claimLines->save();
                                        } 
                                }

                                \DB::commit();

                        } catch (\Exception $e) {
                                \DB::rollBack();
                                if(request()->ajax()){
                                        $result['status'] = 'ERROR';
                                        $result['err_msg'] = $e->getMessage();
                                        return $result;
                                }else{
                                        \Log::error($e->getMessage());
                                        return abort('403');
                                }  
                        }

                        //เซ็คกรณี save 
                        $statuSave = 'success';
                        $claim_number = $result['LV_DOC_SEQUENCE_NUMBER'];
                        $statusClaimCode = $claimStatus[0]->lookup_code;
                        $statusClaim = $claimStatus[0]->meaning;
                }
                return response()->json([       'statuSave' => $statuSave,
                                                'claim_number' =>  $claim_number,
                                                'statusClaimCode' => $statusClaimCode,
                                                'statusClaim' => $statusClaim                   ]);
        }

        public function getClaimNumbers(){
                $customerId = request()->customer_id;
                $claimHeaderList = ClaimHeaders::where('customer_id', $customerId)
                                                ->whereNotNull('claim_number')
                                                ->get();
                return response()->json(['claimHeaderList' => $claimHeaderList]);
        }

        public function convertUnit($item, $org, $quantity, $fromUnit, $toUnit){
                return collect(\DB::select("
                                                select  (       apps.inv_convert.inv_um_convert (
                                                                item_id           => '{$item}',
                                                                organization_id   => {$org},
                                                                PRECISION         => NULL,
                                                                from_quantity     => '{$quantity}',
                                                                from_unit         => '{$fromUnit}',
                                                                to_unit           => '{$toUnit}',
                                                                from_name         => NULL,
                                                                to_name           => NULL)
                                                        )       result
                                                from dual
                                                                                                        "))->first();
        }
}
