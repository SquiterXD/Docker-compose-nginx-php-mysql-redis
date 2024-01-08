<?php

namespace App\Http\Controllers\OM\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OM\ClaimHeaders;
use App\Models\OM\ClaimLines;
use App\Models\OM\InvoiceHeaders;
use App\Models\OM\InvoiceLines;
use App\Models\OM\Customers;
use App\Models\OM\OrderHeaders;
use App\Models\OM\ProformaInvoiceLines;
use App\Models\OM\ClaimStatusV;
use App\Models\OM\UomV;
use App\Models\OM\OutstandingDebtDomV;
use App\Models\OM\OrderLines;
use App\Models\OM\PaymentApplyCNDN;
use App\Models\OM\RMATransactionTypeId;
use App\Models\OM\ConsignmentHeaders;
use App\Models\OM\Attachments;
use App\Models\OM\TransactionTypeV;
use App\Models\OM\PtomAllTaxRateV;

class ApprovalClaimController extends Controller
{
        public function getSearch()
        {
                $tableClaimHeaders = new ClaimHeaders();
                $headerList = $tableClaimHeaders->search(request()->all());
                $headerList->map(function ($item, $key) {
                        $item->uom_claim_quantity_cbb = UomV::where('domestic', 'Y')
                                                                ->where('uom_code', 'CGC')
                                                                ->first();
                        $item->uom_claim_quantity_carton = UomV::where('domestic', 'Y')
                                                                ->where('uom_code', 'CG2')
                                                                ->first();
                        $item->uom_claim_quantity_pack = UomV::where('domestic', 'Y')
                                                                ->where('uom_code', 'CGP')
                                                                ->first();
                        $item->approve                  = $item->status_approve_claim ? $item->status_approve_claim : ''; 
                        $item->validateRemarkApprove    = false;
                        $item->replacement              = $item->replacement_flag == 'Y' ? $item->replacement_flag : '';
                        $item->creditNote               =  $item->replacement_flag == 'N' ? $item->replacement_flag : '';
                        $item->cashBack                 = $item->replacement_flag == 'C' ? 'cashBack' : '';
                        $item->note                     = $item->cancel_deliver_remark ?  $item->cancel_deliver_remark : '';
                        $item->notSendBack              = $item->cancel_deliver_flag ? $item->cancel_deliver_flag == 'Y' ? true : '' : false;
                        $item->cardboard_box_quantity   = $item->cardboard_box_quantity != 0 ? $item->cardboard_box_quantity : 0 ;
                        $item->cartons_quantity         = $item->cartons_quantity != 0 ? $item->cartons_quantity : 0 ;
                        $item->pack_quantity            = $item->pack_quantity != 0 ? $item->pack_quantity : 0 ;
                });
                return response()->json(['headerList' => $headerList]);
        }

        public function closedClaim()
        {  
                $program_code = 'OMP0049';
                $profile = getDefaultData();

                $claimStatus = ClaimStatusV::where('lookup_code', '8')->first();        
                \DB::beginTransaction();
                try {   
                        foreach (request()->all() as $key => $value) {
                                $claimHeaders = ClaimHeaders::find($value['claim_header_id']);
                                $claimHeaders->status_claim             = $claimStatus['meaning'];
                                $claimHeaders->status_claim_code        = $claimStatus['lookup_code'];   
                                $claimHeaders->cancel_deliver_remark    = isset($value['note']) ? $value['note'] ? $value['note'] : '' : '';
                                $claimHeaders->program_code             = $program_code;
                                $claimHeaders->created_by               = $profile->user_id;
                                $claimHeaders->creation_date            = now();
                                $claimHeaders->last_updated_by          = $profile->user_id;
                                $claimHeaders->last_update_date         = now();
                                $claimHeaders->save();
                        }
                        // SUCCESS CREATE
                        \DB::commit();

                } catch (\Exception $e) {
                        // ERROR CREATE
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
                $result = 'success';
                return response()->json(['result' => $result]);
        }

        public function updateApprovalClaim()
        {   
                $program_code = 'OMP0049';
                $profile = getDefaultData();
                
                \DB::beginTransaction();
                try {   
                        foreach (request()->all() as $key => $lineList) {
                                foreach ($lineList as $key => $data) {
                                        if($data['approve'] == 'N'){
                                                $statusClaimCode = ClaimStatusV::where('lookup_code', '5')->value('lookup_code');
                                                $statusClaim = ClaimStatusV::where('lookup_code', '5')->value('meaning');
                                        }else{
                                                $statusClaimCode = ClaimStatusV::where('lookup_code', '2')->value('lookup_code');
                                                $statusClaim = ClaimStatusV::where('lookup_code', '2')->value('meaning');
                                        }
                                        $claimHeaders = ClaimHeaders ::find($data['claim_header_id']);
                                        $claimHeaders->status_approve_claim     = $data['approve'];
                                        $claimHeaders->remark_approve           = $data['remark_approve'];
                                        $claimHeaders->cardboard_box_quantity   = isset($data['cardboard_box_quantity']) ? $data['cardboard_box_quantity'] ? $data['cardboard_box_quantity'] : 0 : 0;
                                        $claimHeaders->cartons_quantity         = isset($data['cartons_quantity']) ? $data['cartons_quantity'] ? $data['cartons_quantity'] : 0 : 0;
                                        $claimHeaders->pack_quantity            = isset($data['pack_quantity']) ? $data['pack_quantity'] ? $data['pack_quantity'] : 0 : 0;
                                        $claimHeaders->cancel_deliver_remark    = isset($data['note']) ? $data['note'] ? $data['note'] : '' : '';
                                        $claimHeaders->program_code             = $program_code;
                                        $claimHeaders->status_claim_code        = $statusClaimCode;
                                        $claimHeaders->status_claim             = $statusClaim;
                                        $claimHeaders->created_by               = $profile->user_id;
                                        $claimHeaders->creation_date            = now();
                                        $claimHeaders->last_updated_by          = $profile->user_id;
                                        $claimHeaders->last_update_date         = now();
                                        $claimHeaders->save();
                                }
                        }
                        // SUCCESS CREATE
                        \DB::commit();

                } catch (\Exception $e) {
                        // ERROR CREATE
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
                $result = 'success';
                return response()->json(['result' => $result]);
        }

        public function updateReplacement()
        {
                $program_code   = 'OMP0049';
                $profile        = getDefaultData();
                foreach (request()->lineList as $key => $data) {
                        $checkStatusApprove = ClaimHeaders::find($data['claim_header_id']);
                        if($data['status_approve_claim'] == 'N'){
                                $result = 'disapproved'; 
                                return response()->json(['result' => $result]);
                        }
                }
                \DB::beginTransaction();
                try {   
                        foreach (request()->lineList as $key => $data) {
                                $claimHeaders = ClaimHeaders::find($data['claim_header_id']);

                                if($data['replacement'] == "replacement"){
                                        $claimHeaders->replacement_flag = 'Y';
                                }elseif ($data['creditNote'] == "creditNote") {
                                        $claimHeaders->replacement_flag = 'N';
                                }elseif ($data['cashBack'] == "cashBack") {
                                        $claimHeaders->replacement_flag = 'C';
                                }    
                                
                                $claimHeaders->cancel_deliver_flag      = $data['notSendBack'] ? 'N' : 'Y';
                                $claimHeaders->cancel_deliver_remark    = $data['note'] ? $data['note'] : '';
                                $claimHeaders->program_code             = $program_code;
                                $claimHeaders->created_by               = $profile->user_id;
                                $claimHeaders->creation_date            = now();
                                $claimHeaders->last_updated_by          = $profile->user_id;
                                $claimHeaders->last_update_date         = now();
                                $claimHeaders->save(); 
 
                                if($claimHeaders['replacement_flag'] == 'Y'){
                                        $claimStatus = ClaimStatusV::where('lookup_code', '3')->first();

                                        $claimHeaders = ClaimHeaders::find($data['claim_header_id']);
                                        $claimHeaders->status_claim_code        = $claimStatus['lookup_code'];
                                        $claimHeaders->status_claim             = $claimStatus['meaning'];
                                        $claimHeaders->program_code             = $program_code;
                                        $claimHeaders->created_by               = $profile->user_id;
                                        $claimHeaders->creation_date            = now();
                                        $claimHeaders->last_updated_by          = $profile->user_id;
                                        $claimHeaders->last_update_date         = now();
                                        $claimHeaders->save();  

                                        $result = $this->callPackageWMS($claimHeaders);
                                }

                                if($claimHeaders['replacement_flag'] == 'N'){
                                        $customers      = Customers::find($data['customer_id']);
                                        $orderHeaders   = OrderHeaders::find($claimHeaders['invoice_id']);
                                        $claimStatus    = ClaimStatusV::where('lookup_code', '4')->first();
                                        $claimLines     = ClaimLines::where('claim_header_id', $data['claim_header_id'])->get();
                                      
                                        if($claimHeaders['cancel_deliver_flag'] == 'N'){
                                                $claimStatus = ClaimStatusV::where('lookup_code', '3')->first();

                                                $claimHeaders = ClaimHeaders::find($data['claim_header_id']);
                                                $claimHeaders->status_claim_code        = $claimStatus['lookup_code'];
                                                $claimHeaders->status_claim             = $claimStatus['meaning'];
                                                $claimHeaders->program_code             = $program_code;
                                                $claimHeaders->created_by               = $profile->user_id;
                                                $claimHeaders->creation_date            = now();
                                                $claimHeaders->last_updated_by          = $profile->user_id;
                                                $claimHeaders->last_update_date         = now();
                                                $claimHeaders->save();  

                                                $seqNumberRMA   = $this->callCreateRMA($orderHeaders, $claimHeaders);
                                                $result         = $this->callPackageWMS($claimHeaders);
                                        }else{
                                                $claimHeaders->status_claim_code        = $claimStatus['lookup_code'];
                                                $claimHeaders->status_claim             = $claimStatus['meaning'];
                                                $claimHeaders->save();
                                        }
                                        
                                        $seqNumberCreditNote = $this->callCreateCreditNote($customers, $orderHeaders, $claimHeaders, $profile, $claimLines);
                                        
                                        $claimHeaders                           = ClaimHeaders::find($data['claim_header_id']);
                                        $claimHeaders->credit_note_number       = $seqNumberCreditNote;
                                        $claimHeaders->rma_number               = isset($seqNumberRMA) ? $seqNumberRMA : '';
                                        $claimHeaders->rma_date                 = isset($seqNumberRMA) ? now() : '';
                                        $claimHeaders->status_rma               = isset($seqNumberRMA) ? 'Confirm' : '';                                      
                                        $claimHeaders->program_code             = $program_code;
                                        $claimHeaders->created_by               = $profile->user_id;
                                        $claimHeaders->creation_date            = now();
                                        $claimHeaders->last_updated_by          = $profile->user_id;
                                        $claimHeaders->last_update_date         = now();
                                        $claimHeaders->save();
                                }

                                if($claimHeaders['replacement_flag'] == 'C'){
                                        $customers      = Customers::find($data['customer_id']);
                                        $orderHeaders   = OrderHeaders::find($claimHeaders['invoice_id']);
                                        $claimStatus    = ClaimStatusV::where('lookup_code', '10')->first();
                                        $claimLines     = ClaimLines::where('claim_header_id', $data['claim_header_id'])->get();

                                        if($claimHeaders['cancel_deliver_flag'] == 'N'){
                                                $claimStatus = ClaimStatusV::where('lookup_code', '3')->first();

                                                $claimHeaders = ClaimHeaders::find($data['claim_header_id']);
                                                $claimHeaders->status_claim_code        = $claimStatus['lookup_code'];
                                                $claimHeaders->status_claim             = $claimStatus['meaning'];
                                                $claimHeaders->program_code             = $program_code;
                                                $claimHeaders->created_by               = $profile->user_id;
                                                $claimHeaders->creation_date            = now();
                                                $claimHeaders->last_updated_by          = $profile->user_id;
                                                $claimHeaders->last_update_date         = now();
                                                $claimHeaders->save();  

                                                $seqNumberRMA   = $this->callCreateRMA($orderHeaders, $claimHeaders);
                                                $result         = $this->callPackageWMS($claimHeaders);                                                
                                        }
                                        
                                        $seqNumberCreditNote = $this->callCreateCreditNote($customers, $orderHeaders, $claimHeaders, $profile, $claimLines);
                                        
                                        $claimHeaders                           = ClaimHeaders::find($data['claim_header_id']);
                                        $claimHeaders->credit_note_number       = $seqNumberCreditNote;
                                        $claimHeaders->rma_number               = isset($seqNumberRMA) ? $seqNumberRMA : '';
                                        $claimHeaders->rma_date                 = isset($seqNumberRMA) ? now() : '';
                                        $claimHeaders->status_rma               = isset($seqNumberRMA) ? 'Confirm' : '';  
                                        $claimHeaders->program_code             = $program_code;
                                        $claimHeaders->created_by               = $profile->user_id;
                                        $claimHeaders->creation_date            = now();
                                        $claimHeaders->last_updated_by          = $profile->user_id;
                                        $claimHeaders->last_update_date         = now();
                                        $claimHeaders->save();
                                }
                        }
                        // SUCCESS CREATE
                        \DB::commit();

                } catch (\Exception $e) {
                        // ERROR CREATE
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
                $result = 'success';
                return response()->json(['result' => $result]);
        }

        public function callPackageWMS($claimHeaders){
                $claimHeaderId  = $claimHeaders['claim_header_id'];
                $claimNumber    = $claimHeaders['claim_number'];

                try {
                        $db = \DB::connection()->getPdo();
                        $sql = "        DECLARE
                                                o_result    VARCHAR2(4000) := NULL;    
                                        BEGIN
                                                PTOM_WEB_SALE_INF_WMS_PKG.main_process_1_13(
                                                i_claim_header_id       => {$claimHeaderId}   
                                                ,i_claim_number         => '{$claimNumber}'     
                                                ,o_result               => :o_result);
                                        END;    
                                ";
                        $sql = preg_replace("/[\r\n]*/","",$sql);
                        logger($sql);
        
                        $stmt = $db->prepare($sql);
                        $result = [];
                        $stmt->bindParam(':o_result', $result['result'], \PDO::PARAM_STR, 40000);
        
                        $stmt->execute();                                
                } catch (\Exception $e) {
                        throw new \Exception($e->getMessage(), 1);
                }     
        }

        public function callCreateCreditNote($customers, $orderHeaders, $claimHeaders, $profile, $claimLines){
                $totalInvoiceAmount     = 0;
                $totalInvoiceVatAmount  = 0;
                $totalInvoicePaoAmount  = 0;
                $dataInvoiceLines       = [];
                try {
                        $db = \DB::connection()->getPdo();
                        $sql = "        DECLARE
                                                LV_DOC_SEQUENCE_NUMBER                  VARCHAR2(100)   :=  NULL;
                                                LV_RETURN_STATUS                        VARCHAR2(100)   :=  NULL;
                                                LV_RETURN_MSG                           VARCHAR2(4000)  :=  NULL;
                                        BEGIN
                                                PTOM_WEB_UTILITIES_PKG.GENERATE_DOC_SEQUENCE_NUMBER 
                                                (   I_DOCUMENT_CODE                     =>  'OMP0033_CN_NUM_DOM'
                                                , O_DOC_SEQUENCE_NUMBER                 =>  :LV_DOC_SEQUENCE_NUMBER
                                                , O_RETURN_STATUS                       =>  :LV_RETURN_STATUS
                                                , O_RETURN_MSG                          =>  :LV_RETURN_MSG
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
                
                $invoiceHeaders                                 = new InvoiceHeaders();
                $invoiceHeaders->invoice_headers_number         = $result['LV_DOC_SEQUENCE_NUMBER'];
                $invoiceHeaders->customer_id                    = $claimHeaders['customer_id'];
                $invoiceHeaders->province_name                  = isset($customers['province_name']) ? $customers['province_name'] : '';
                $invoiceHeaders->invoice_type                   = 'CN_OTHER';
                $invoiceHeaders->invoice_date                   = now();                                //ให้ Default จาก RMA_DATE
                $invoiceHeaders->document_id                    = $claimHeaders['claim_header_id'];
                $invoiceHeaders->delivery_date                  = $orderHeaders['delivery_date'];
                $invoiceHeaders->term_id                        = $orderHeaders['term_id'];
                $invoiceHeaders->document_number                = $claimHeaders['claim_number'];
                $invoiceHeaders->channel_receiving_code         = '40';
                $invoiceHeaders->program_code                   = 'OMP0052';
                $invoiceHeaders->created_by                     = $profile->user_id;
                $invoiceHeaders->creation_date                  = now();
                $invoiceHeaders->last_updated_by                = $profile->user_id;
                $invoiceHeaders->last_update_date               = now();

                if($claimHeaders['replacement_flag'] == 'C'){
                        $invoiceHeaders->refund_flag            = 'Y';
                }

                $invoiceHeaders->save(); 

                foreach ($claimLines as $key => $dataLine) {
                        $unitPriceOrderLines            = OrderLines::where('order_header_id',$orderHeaders['order_header_id'])
                                                                        ->where('item_id', $dataLine['item_id'])
                                                                        ->value('unit_price');
                        $creditGroupCodeOrderLines      = OrderLines::where('order_header_id',$orderHeaders['order_header_id'])
                                                                        ->where('item_id', $dataLine['item_id'])
                                                                        ->value('credit_group_code');
                        $totalPaymentAmount             = $dataLine['claim_quantity']*$unitPriceOrderLines;         //ตัวคูณ PTOM_CLAIM_LINES.CLAIM_QUANTITY*PTOM_ORDER_LINES.UNIT_PRICE
                        $att1OrderLines                 = OrderLines::where('order_header_id',$orderHeaders['order_header_id'])
                                                                        ->where('item_id', $dataLine['item_id'])
                                                                        ->value('attribute1');
                        $att1OrderLines                 = $att1OrderLines ? $att1OrderLines : 0;
                        $taxRate                        = TransactionTypeV::where('order_type_id',$orderHeaders['order_type_id'])
                                                                         ->value('tax_rate');
                                                        
                        $lineTaxAmount                  = ($dataLine['claim_quantity']*$att1OrderLines)*$taxRate/(100+$taxRate);
                        // $lineTaxAmount                  = number_format(floatval($lineTaxAmount));

                        $tag                            = PtomAllTaxRateV::where('enabled_flag', 'Y')
                                                                        ->where('lookup_code', '10')
                                                                        ->value('tag');
                        $paoLineAmount                  = $dataLine['claim_quantity']*$tag;  
                        
                        $invoiceLines = new InvoiceLines();
                        $invoiceLines->invoice_headers_id       = $invoiceHeaders['invoice_headers_id'];
                        $invoiceLines->item_id                  = $dataLine['item_id'];
                        $invoiceLines->item_code                = $dataLine['item_code'];
                        $invoiceLines->item_description         = $dataLine['item_description'];
                        $invoiceLines->uom_code                 = $dataLine['claim_uom_code'];
                        $invoiceLines->quantity                 = $dataLine['claim_quantity'];
                        $invoiceLines->document_id              = $dataLine['claim_header_id'];
                        $invoiceLines->document_line_id         = $dataLine['claim_line_id'];   
                        $invoiceLines->line_tax_amount          = round($lineTaxAmount, 2);  
                        $invoiceLines->pao_line_amount          = $paoLineAmount; 
                        $invoiceLines->payment_amount           = $totalPaymentAmount;          //ติดนำ table มาแล้วแต่ไม่มีตัวคูณ PTOM_CLAIM_LINES.CLAIM_QUANTITY*PTOM_ORDER_LINES.UNIT_PRICE
                        $invoiceLines->invoice_flag             = 'Y';
                        $invoiceLines->conversion_rate          = '1';
                        $invoiceLines->program_code             = 'OMP0052';
                        $invoiceLines->ref_invoice_number       = $claimHeaders['ref_invoice_number'];
                        $invoiceLines->credit_group_code        = $creditGroupCodeOrderLines;
                        $invoiceLines->currency                 = 'THB';
                        $invoiceLines->created_by               = $profile->user_id;                        
                        $invoiceLines->creation_date            = now();
                        $invoiceLines->last_updated_by          = $profile->user_id;
                        $invoiceLines->last_update_date         = now();
                        $invoiceLines->save();  

                        $totalInvoiceAmount     += $totalPaymentAmount;
                        $totalInvoiceVatAmount  += $lineTaxAmount;
                        $totalInvoicePaoAmount  += $paoLineAmount;
                        $dataInvoiceLines[] = $invoiceLines;
                }

                $invoiceHeaders->invoice_amount         = $totalInvoiceAmount;
                $invoiceHeaders->total_vat_amount       = $totalInvoiceVatAmount;
                $invoiceHeaders->pao_amount             = $totalInvoicePaoAmount;
                $invoiceHeaders->save();

                $groupByInvoiceLines = collect($dataInvoiceLines)->groupBy('credit_group_code');

                foreach ($groupByInvoiceLines as $key => $values) {
                        foreach ($values as $index => $data) {
                                $customer = Customers::where('customer_id', $orderHeaders['customer_id'])->first();                                
                                if((    $customer['customer_type_id'] == '30' || $customer['customer_type_id'] == '40') &&
                                        $orderHeaders['product_type_code'] == '10' ){
                                        $isOutstandingDom = OutstandingDebtDomV::where('consignment_no',$data['ref_invoice_number'])
                                                                                ->where('credit_group_code', $key)
                                                                                ->first();
                                        if($isOutstandingDom){
                                                // $totalInvoiceAmountGroupBy +=  $data['payment_amount'];
                                                $totalOutstandingDebt = OutstandingDebtDomV::selectRaw('consignment_no
                                                                                                ,  credit_group_code
                                                                                                ,  outstanding_debt
                                                                                                ,  sum(outstanding_debt) as total_outstanding_debt')
                                                                                        ->where('consignment_no',$data['ref_invoice_number'])
                                                                                        ->where('credit_group_code', $key)
                                                                                        ->groupBy('pick_release_no', 'credit_group_code', 'outstanding_debt')
                                                                                        ->value('total_outstanding_debt');
                                                if((int)$totalOutstandingDebt >=  $invoiceHeaders['invoice_amount']){
                                                        $statusOutstanding = 'greaterThanEqualTo';
                                                }

                                                if((int)$totalOutstandingDebt < $invoiceHeaders['invoice_amount']){
                                                        $statusOutstanding = 'LessThan';
                                                }
                                        }else{

                                                // $totalInvoiceAmountGroupBy +=  $data['payment_amount'];
                                                $statusOutstanding = 'noDataFound';
                                                
                                        }
                                }else{
                                        $isOutstandingDom = OutstandingDebtDomV::where('pick_release_no',$data['ref_invoice_number'])
                                                                                ->where('credit_group_code', $key)
                                                                                ->first();
                                        if($isOutstandingDom){
                                                // $totalInvoiceAmountGroupBy +=  $data['payment_amount'];
                                                $totalOutstandingDebt = OutstandingDebtDomV::selectRaw('pick_release_no
                                                                                                ,  credit_group_code
                                                                                                ,  outstanding_debt
                                                                                                ,  sum(outstanding_debt) as total_outstanding_debt')
                                                                                        ->where('pick_release_no',$data['ref_invoice_number'])
                                                                                        ->where('credit_group_code', $key)
                                                                                        ->groupBy('pick_release_no', 'credit_group_code', 'outstanding_debt')
                                                                                        ->value('total_outstanding_debt');
                                                if((int)$totalOutstandingDebt >=  $invoiceHeaders['invoice_amount']){
                                                        $statusOutstanding = 'greaterThanEqualTo';
                                                }

                                                if((int)$totalOutstandingDebt < $invoiceHeaders['invoice_amount']){
                                                        $statusOutstanding = 'LessThan';
                                                }
                                        }else{
                                                // $totalInvoiceAmountGroupBy +=  $data['payment_amount'];
                                                $statusOutstanding = 'noDataFound';
                                                
                                        }
                                }
                        }                        
                }

                if($statusOutstanding == 'noDataFound'){
                        $paymentApplyCNDN                               = new PaymentApplyCNDN;
                        $paymentApplyCNDN->invoice_number               = $invoiceHeaders['invoice_headers_number'];
                        $paymentApplyCNDN->invoice_header_id            = $invoiceHeaders['invoice_headers_id'];
                        $paymentApplyCNDN->invoice_amount               = $invoiceHeaders['invoice_amount'];
                        $paymentApplyCNDN->attribute2                   = 'CN_OTHER';
                        $paymentApplyCNDN->program_code                 = 'OMP0052';
                        $paymentApplyCNDN->created_by                   = $profile->user_id;                        
                        $paymentApplyCNDN->creation_date                = now();
                        $paymentApplyCNDN->last_updated_by              = $profile->user_id;
                        $paymentApplyCNDN->last_update_date             = now();
                        $paymentApplyCNDN->created_at                   = now();
                        $paymentApplyCNDN->updated_at                   = now();
                        $paymentApplyCNDN->created_by_id                = $profile->user_id;
                        $paymentApplyCNDN->updated_by_id                = $profile->user_id;
                        $paymentApplyCNDN->save();
                }elseif ($statusOutstanding == 'greaterThanEqualTo') {
                        $paymentApplyCNDN                               = new PaymentApplyCNDN;
                        $paymentApplyCNDN->order_header_id              = $orderHeaders['order_header_id'];
                        $paymentApplyCNDN->pick_release_no              = $claimHeaders['ref_invoice_number'];
                        $paymentApplyCNDN->credit_group_code            = $invoiceLines['credit_group_code'];   
                        $paymentApplyCNDN->attribute1                   = 'Y';                               
                        $paymentApplyCNDN->invoice_number               = $invoiceHeaders['invoice_headers_number'];
                        $paymentApplyCNDN->invoice_header_id            = $invoiceHeaders['invoice_headers_id'];
                        $paymentApplyCNDN->invoice_amount               = $invoiceHeaders['invoice_amount'];
                        $paymentApplyCNDN->attribute2                   = 'CN_OTHER';
                        $paymentApplyCNDN->program_code                 = 'OMP0052';
                        $paymentApplyCNDN->created_by                   = $profile->user_id;                        
                        $paymentApplyCNDN->creation_date                = now();
                        $paymentApplyCNDN->last_updated_by              = $profile->user_id;
                        $paymentApplyCNDN->last_update_date             = now();
                        $paymentApplyCNDN->created_at                   = now();
                        $paymentApplyCNDN->updated_at                   = now();
                        $paymentApplyCNDN->created_by_id                = $profile->user_id;
                        $paymentApplyCNDN->updated_by_id                = $profile->user_id;
                        $paymentApplyCNDN->save();
                }elseif ($statusOutstanding == 'LessThan') {
                        $paymentApplyCNDN                               = new PaymentApplyCNDN;
                        $paymentApplyCNDN->order_header_id              = $orderHeaders['order_header_id'];
                        $paymentApplyCNDN->pick_release_no              = $claimHeaders['ref_invoice_number'];
                        $paymentApplyCNDN->credit_group_code            = $invoiceLines['credit_group_code'];   
                        $paymentApplyCNDN->attribute1                   = 'Y';                               
                        $paymentApplyCNDN->invoice_number               = $invoiceHeaders['invoice_headers_number'];
                        $paymentApplyCNDN->invoice_header_id            = $invoiceHeaders['invoice_headers_id'];
                        $paymentApplyCNDN->invoice_amount               = $totalOutstandingDebt;
                        $paymentApplyCNDN->attribute2                   = 'CN_OTHER';
                        $paymentApplyCNDN->program_code                 = 'OMP0052';
                        $paymentApplyCNDN->created_by                   = $profile->user_id;                        
                        $paymentApplyCNDN->creation_date                = now();
                        $paymentApplyCNDN->last_updated_by              = $profile->user_id;
                        $paymentApplyCNDN->last_update_date             = now();
                        $paymentApplyCNDN->created_at                   = now();
                        $paymentApplyCNDN->updated_at                   = now();
                        $paymentApplyCNDN->created_by_id                = $profile->user_id;
                        $paymentApplyCNDN->updated_by_id                = $profile->user_id;
                        $paymentApplyCNDN->save();

                        $balanceInvoice = $totalOutstandingDebt - $invoiceHeaders['invoice_amount'];

                        $paymentApplyCNDN = new PaymentApplyCNDN;
                        $paymentApplyCNDN->invoice_number               = $invoiceHeaders['invoice_headers_number'];
                        $paymentApplyCNDN->invoice_header_id            = $invoiceHeaders['invoice_headers_id'];
                        $paymentApplyCNDN->invoice_amount               = $balanceInvoice;
                        $paymentApplyCNDN->attribute2                   = 'CN_OTHER';
                        $paymentApplyCNDN->program_code                 = 'OMP0052';
                        $paymentApplyCNDN->created_by                   = $profile->user_id;                        
                        $paymentApplyCNDN->creation_date                = now();
                        $paymentApplyCNDN->last_updated_by              = $profile->user_id;
                        $paymentApplyCNDN->last_update_date             = now();
                        $paymentApplyCNDN->created_at                   = now();
                        $paymentApplyCNDN->updated_at                   = now();
                        $paymentApplyCNDN->created_by_id                = $profile->user_id;
                        $paymentApplyCNDN->updated_by_id                = $profile->user_id;
                        $paymentApplyCNDN->save();                        
                }
                
                return $result['LV_DOC_SEQUENCE_NUMBER'];
        }

        public function callCreateRMA($orderHeaders, $claimHeaders){
                try {
                        $db = \DB::connection()->getPdo();
                        $sql = "        DECLARE
                                                LV_DOC_SEQUENCE_NUMBER                  VARCHAR2(100)   :=  NULL;
                                                LV_RETURN_STATUS                        VARCHAR2(100)   :=  NULL;
                                                LV_RETURN_MSG                           VARCHAR2(4000)  :=  NULL;
                                        BEGIN
                                                PTOM_WEB_UTILITIES_PKG.GENERATE_DOC_SEQUENCE_NUMBER 
                                                (   I_DOCUMENT_CODE                     =>  'OMP0052_RMA_NUM_DOM'
                                                , O_DOC_SEQUENCE_NUMBER                 =>  :LV_DOC_SEQUENCE_NUMBER
                                                , O_RETURN_STATUS                       =>  :LV_RETURN_STATUS
                                                , O_RETURN_MSG                          =>  :LV_RETURN_MSG
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

                $customer = Customers::where('customer_id', $orderHeaders['customer_id'])->first();
                
                if(     ($customer['customer_type_id'] == 30 || $customer['customer_type_id'] == 40) &&
                        $orderHeaders['product_type_code'] == 10){
                        $orderTypeId = ConsignmentHeaders::where('consignment_no', $claimHeaders['ref_invoice_number'])
                                                        ->value('order_type_id');
                        $RMAOrderTypeId  = RMATransactionTypeId::where('order_type_id',$orderTypeId)
                                                                ->value('rma_transaction_type_id');

                        $claimHeaders->rma_order_type_id = $RMAOrderTypeId ? $RMAOrderTypeId : '';
                        $claimHeaders->save();
                }else{
                        $RMAOrderTypeId  = RMATransactionTypeId::where('order_type_id',$orderHeaders['order_type_id'])
                                                                ->value('rma_transaction_type_id');

                        $claimHeaders->rma_order_type_id = $RMAOrderTypeId ? $RMAOrderTypeId : '';
                        $claimHeaders->save();
                }

                $claimLinesList = ClaimLines::where('claim_header_id', $claimHeaders['claim_header_id'])->get();
                
                foreach ($claimLinesList as $key => $value) {
                        $claimLines                             = ClaimLines::find($value['claim_line_id']);
                        $claimLines->rma_line_no                = $key+1;
                        $claimLines->rma_quantity               = $value->claim_quantity;
                        $claimLines->rma_uom_code               = $value->claim_uom_code;
                        $claimLines->rma_quantity_cbb           = $value->claim_quantity_cbb;
                        $claimLines->rma_quantity_carton        = $value->claim_quantity_carton;
                        $claimLines->rma_quantity_pack          = $value->claim_quantity_pack;
                        $claimLines->order_quantity             = $value->claim_quantity_pack;
                        

                        $orderLine = OrderLines::where('order_header_id', $orderHeaders['order_header_id']) 
                                                ->where('order_line_id', $value->order_line_id)
                                                ->first();

                        $claimLines->order_quantity             = $orderLine->approve_quantity;
                        $claimLines->uom_code                   = $orderLine->uom_code;

                        $claimLines->save();
                }

                return $result['LV_DOC_SEQUENCE_NUMBER'];
        }

        public function reportClaim(Request $request)
        {
                $claimInfo      = ClaimHeaders::where('claim_header_id', $request['claim_header_id'])
                                                ->first();
                $claimLineInfo  = ClaimLines::where('claim_header_id', $request->claim_header_id)
                                                ->get();
                $attachments    = Attachments::where('header_id', $request['claim_header_id'])
                                                ->orderBy('ATTACHMENT_ID', 'asc')
                                                ->get();
                $customeInfo    = Customers::where('customer_id', $claimInfo['customer_id'])
                                                ->first();
                $claimInfo['date_thai_claim_date'] = $this->DateThaiTime($claimInfo['claim_date']);
                if (empty($claimInfo)) abort(404);

                $pdf = \PDF::loadView('om.approval-claim.report.index', 
                                compact('customeInfo', 'attachments', 'claimInfo', 'claimLineInfo'))
                                ->setPaper('a4')
                                ->setOption('margin-top', '1cm')
                                ->setOption('margin-bottom', '1cm')
                                ->setOption('margin-left', '2cm')
                                ->setOption('margin-right', '1cm');
                return $pdf->inline();
        }

        public function DateThaiTime($strDate)
        {
                $strYear = date("Y", strtotime($strDate)) + 543;
                $strMonth = date("n", strtotime($strDate));
                $strDay = date("j", strtotime($strDate));
                $strHour = date("H", strtotime($strDate));
                $strMinute = date("i", strtotime($strDate));
                $strSeconds = date("s", strtotime($strDate));
                $strMonthCut = array("", "มกราคม.", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
                $strMonthThai = $strMonthCut[$strMonth];
                return "$strDay $strMonthThai $strYear $strHour:$strMinute";
        }
}
