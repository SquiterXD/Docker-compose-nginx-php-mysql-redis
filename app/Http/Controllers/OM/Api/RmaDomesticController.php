<?php

namespace App\Http\Controllers\OM\Api;

use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OM\Api\Customer;
use App\Models\OM\Api\DirectDebit;
use App\Models\OM\Rma\Export\PtomTransactionTypeAllV;
use App\Models\OM\Rma\PtomInvoiceHeaders;
use App\Models\OM\Rma\PtomInvoiceLines;
use App\Models\OM\Rma\PtomOrderTWms;
use App\Models\OM\Rma\PtomPaymentApplyCndn;
use App\Models\OM\Rma\PtomUomV;
use App\Models\OM\Rma\PtomOutstandingDebtDomV;
use App\Models\OM\Rma\PtomCustomerContractGroups;
use App\Models\OM\Customers;
use App\Models\OM\Rma\Domestic\PtomConsignmentHeaders;
use App\Models\OM\Rma\Domestic\PtomConsignmentLines;
use App\Models\OM\Rma\Domestic\PtomClaimHeaders;
use App\Models\OM\Rma\Domestic\PtomClaimLines;
use App\Models\OM\Rma\Domestic\PtomOrderHeaders;
use App\Models\OM\Rma\Domestic\PtomOrderLines;
use App\Models\OM\TransactionTypeV;
use App\Models\OM\PtomAllTaxRateV;
use mysql_xdevapi\Exception;

class RmaDomesticController extends Controller
{
    public function getNumberList(Request $request)
    {
        $query = $request->keyword ? '%'.$request->keyword.'%' : '%';
        $numbers = PtomClaimHeaders::from('ptom_claim_headers pch')
            ->join('PTOM_CUSTOMERS PC','POH.CUSTOMER_ID','PC.CUSTOMER_ID')
            // ->join('ptom_customer_ship_sites pcss','pch.ship_to_site_id','pcss.ship_to_site_id')
            ->where(function($q) use ($query){
                $q->where('rma_number', 'like', $query);
            })
            ->where('pch.sales_type','DOMESTIC')
            ->whereNotNull('pch.rma_number')
            ->orderBy('pch.rma_number','desc')
            ->limit(300)
            ->get([
                'pch.*'
                ,'pc.bill_to_site_name'
                ,'pc.province_name'
            ]);

        return response()->json($numbers);
    }

    public function getInvoiceList(Request $request)
    {
        $query = $request->keyword ? '%'.$request->keyword.'%' : '%';
        $invoices = PtomOrderHeaders::from('PTOM_ORDER_HEADERS POH')
            // ->join('PTOM_CUSTOMER_SHIP_SITES PCSS' , 'POH.SHIP_TO_SITE_ID' , 'PCSS.SHIP_TO_SITE_ID')
            ->join('PTOM_CUSTOMERS PC','POH.CUSTOMER_ID','PC.CUSTOMER_ID')
            ->where(function($q) use ($query){
                $q->where('PICK_RELEASE_NO', 'like', $query);
            })
            ->where('POH.PICK_RELEASE_STATUS','Confirm')
            ->whereNotNull('POH.PICK_RELEASE_NO')
            ->orderBy('POH.PICK_RELEASE_NO','desc')
            ->limit(300)
            ->get([
                'POH.ORDER_HEADER_ID'
                ,'POH.CUSTOMER_ID'
                ,'POH.ORG_ID'
                ,'POH.PRODUCT_TYPE_CODE'
                ,'POH.PICK_RELEASE_NO'
                ,'POH.PICK_RELEASE_APPROVE_DATE'
                ,'POH.PICK_RELEASE_STATUS'
                ,'POH.DELIVERY_DATE'
                ,'POH.TERM_ID'
                ,'POH.SOURCE_SYSTEM'
                ,'POH.REMARK_SOURCE_SYSTEM'
                ,'POH.SHIP_TO_SITE_ID'
                ,'PC.bill_to_site_name'
                ,'PC.province_name'
            ]);
        
        return response()->json($invoices);
    }

    public function getByNumber()
    {
        $customer = Customers::where('customer_id',request()->customer_id)->first();
        $pickReleaseNo = PtomClaimHeaders::select('invoice_id')->where('rma_number',request()->rma_number)->first();

        $invoice = PtomOrderHeaders::with('ptomCustomerShipSites')
            ->where('pick_release_no',$pickReleaseNo->invoice_id)->first();

        return response()->json(['invoice'=>$invoice,'customer'=>$customer]);
    }

    public function getByInvoice()
    {
        $invoice = PtomOrderHeaders::where('pick_release_no',request()->pick_release_no)->first();
        $customer = Customers::where('customer_id',$invoice->customer_id)->first();
        $numbers = PtomClaimHeaders::where('invoice_id',$invoice->order_header_id)
            ->get();

        return response()->json(['numbers'=>$numbers,'customer'=>$customer]);
    }

    public function getByCustomer()
    {
        $customer = Customers::find(request()->customer_id);

        if ($customer->customer_type_id != 30 || $customer->customer_type_id != 40){
//            $invoices = PtomOrderHeaders::where('pick_release_status','Confirm')
//                ->where('customer_id',$customer->customer_id)
//                ->get();
            $invoices = PtomOrderHeaders::from('PTOM_ORDER_HEADERS POH')
                ->join('PTOM_CUSTOMERS PC','POH.CUSTOMER_ID','PC.CUSTOMER_ID')
                ->where('POH.PICK_RELEASE_STATUS','Confirm')
                ->where('POH.CUSTOMER_ID',$customer->customer_id)
                ->whereNotNull('POH.PICK_RELEASE_NO')
                ->orderBy('POH.PICK_RELEASE_NO','desc')
                ->get([
                    'POH.ORDER_HEADER_ID'
                    ,'POH.CUSTOMER_ID'
                    ,'POH.ORG_ID'
                    ,'POH.PRODUCT_TYPE_CODE'
                    ,'POH.PICK_RELEASE_NO'
                    ,'POH.PICK_RELEASE_APPROVE_DATE'
                    ,'POH.PICK_RELEASE_STATUS'
                    ,'POH.DELIVERY_DATE'
                    ,'POH.TERM_ID'
                    ,'POH.SOURCE_SYSTEM'
                    ,'POH.REMARK_SOURCE_SYSTEM'
                    ,'POH.SHIP_TO_SITE_ID'
                    ,'pc.bill_to_site_name'
                    ,'pc.province_name'
                ]);

        } else {
//            $invoices = PtomConsignmentHeaders::whereHas('ptomOrderHeader',function ($q){
//                $q->where('customer_id',$customer->customer_id);
//            })
//                ->where('consignment_status','Confirm')
//                ->get();
            $invoices = PtomConsignmentHeaders::from('PTOM_CONSIGNMENT_HEADERS POH')
                ->join('PTOM_CUSTOMER_SHIP_SITES PCSS' , 'POH.SHIP_TO_SITE_ID' , 'PCSS.SHIP_TO_SITE_ID')
                ->join('PTOM_CUSTOMERS PC','POH.CUSTOMER_ID','PC.CUSTOMER_ID')
                ->where('POH.PICK_RELEASE_STATUS','Confirm')
                ->where('POH.CUSTOMER_ID',$customer->customer_id)
                ->whereNotNull('POH.PICK_RELEASE_NO')
                ->orderBy('POH.PICK_RELEASE_NO','desc')
                ->get([
                    'POH.ORDER_HEADER_ID'
                    ,'POH.CUSTOMER_ID'
                    ,'POH.ORG_ID'
                    ,'POH.PRODUCT_TYPE_CODE'
                    ,'POH.PICK_RELEASE_NO'
                    ,'POH.PICK_RELEASE_APPROVE_DATE'
                    ,'POH.PICK_RELEASE_STATUS'
                    ,'POH.DELIVERY_DATE'
                    ,'POH.TERM_ID'
                    ,'POH.SOURCE_SYSTEM'
                    ,'POH.REMARK_SOURCE_SYSTEM'
                    ,'POH.SHIP_TO_SITE_ID'
                    ,'pc.bill_to_site_name'
                    ,'pc.province_name'
                ]);
        }

        $numbers = PtomClaimHeaders::where('sales_type','DOMESTIC')
            ->where('customer_id',request()->customer_id)
            ->get();


        return response()->json([
            'numbers'=>$numbers,
            'invoices'=>$invoices
        ]);
    }

    public function getNumberOnly()
    {
        $numbers = PtomClaimHeaders::where('customer_id',request()->customer_id)
            ->where('invoice_id',request()->pick_release_no)
            ->get();

        return response()->json(['numbers'=> $numbers]);
    }

    public function getInvoiceOnly()
    {
        return response()->json(['data'=>"Ok.."]);
    }

    public function getCustomerOnly()
    {
        return response()->json(['data'=>"Ok.."]);
    }

    public function getNewNumber()
    {
        $numbers = PtomClaimHeaders::from('ptom_claim_headers pch')
                ->join('PTOM_CUSTOMERS PC','pch.CUSTOMER_ID','PC.CUSTOMER_ID')
            ->where('pch.sales_type','DOMESTIC')
            ->whereNotNull('pch.rma_number')
            ->orderBy('pch.rma_number','desc')
            ->get([
                'pch.claim_header_id'
                ,'pch.invoice_id'
                ,'pch.invoice_date'
                ,'pch.customer_id'
                ,'pch.source_system'
                ,'pch.remark_source_system'
                    ,'pc.bill_to_site_name'
                    ,'pc.province_name'
                ,'pch.rma_number'
                ,'pch.rma_date'
                ,'pch.status_rma'
                ,'pch.SYMPTOM_DESCRIPTION'
                ,'pch.credit_note_number'
            ]);

        return response()->json(['newNumbers'=> $numbers]);
    }

    public function getPreviousRma() // Get Previous RMA quantity
    {
        $claimHeadersId = [];
        $rmaItemQty = [];
        $orderHeader = PtomOrderHeaders::where('pick_release_no',\request()->invoiceNo)->first();
        $orgId = $orderHeader->org_id;
        $orderLines = PtomOrderLines::where('order_header_id',$orderHeader->order_header_id)->get();
        $iOrderLines = $orderLines->count();
        $qty = 1;

        foreach ($orderLines as $line){
            array_push($rmaItemQty,[
                'item_code'=>$line->item_code
                ,'item_description'=>$line->item_description
                ,'order_quantity'=>$line->order_quantity
                ,'uom_code'=>$line->uom_code
                , 'line_id' => $line->order_line_id
                ,'org_id'=>$orgId
                ,'prvRmaQty'=>0
            ]);
        }
        $claimHeaders = PtomClaimHeaders::where('ref_invoice_number',\request()->invoiceNo)
            ->where('status_rma','Confirm')
            ->get();
        foreach ($claimHeaders as $header){
            array_push($claimHeadersId,$header->claim_header_id);
        }
        $claimLines = PtomClaimLines::whereIn('claim_header_id',$claimHeadersId)->get();
        foreach ($claimLines as $line) {
            for ($i=0;$i < $iOrderLines;$i++ ){
                if ($line->item_code == $rmaItemQty[$i]['item_code']){
                    $rmaItemQty[$i]['prvRmaQty'] += $line->rma_quantity;
                }
            }
        }
        for ($i=0;$i<count($rmaItemQty);$i++){
            $rmaItemQty[$i]['canReturn'] = $rmaItemQty[$i]['order_quantity'] - $rmaItemQty[$i]['prvRmaQty'];
        }
        return response()->json(['previousRma'=>$rmaItemQty]);
    }

    public function getLines() //get lines from ptom_claim_lines
    {
        // Get Order Header
        $claim_header_id = \request()->claim_header_id;
        $claimHeader = PtomClaimHeaders::where('claim_header_id',$claim_header_id)->first();
        $orderHeader = PtomOrderHeaders::where('pick_release_no',$claimHeader->ref_invoice_number)->first();
        $orgId = $orderHeader->org_id;
        $uomlist = PtomUomV::where('DOMESTIC','Y')->orderBy('UOM_CODE')->get();
        $add_sql = '';
        foreach ($uomlist as $item) {
            $add_sql .= "
                ,(SELECT
                    apps.inv_convert.inv_um_convert (
                    item_id           => PCL.ITEM_ID,
                    organization_id   => {$orgId},
                    PRECISION         => NULL,
                    from_quantity     => 1,
                    from_unit         => '{$item->uom_code}',
                    to_unit           => PCL.UOM_CODE,
                    from_name         => NULL,
                    to_name           => NULL) convert_qty
                FROM dual) {$item->uom_code}
            ";
        }
        // Get Line items

        if ($orderHeader->product_type_code == 10){
            $sql = "
            SELECT PCL.*
                 ,PUCV.UNIT_OF_MEASURE UOM
                 ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PCL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => 'CGC',
                        to_unit           => 'CGK',
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) CGC
                 ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PCL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => 'CG2',
                        to_unit           => 'CGK',
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) CG2
                 ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PCL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => 'CGP',
                        to_unit           => 'CGK',
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) CGP
                 ,POL.APPROVE_CARDBOARDBOX
                 ,POL.APPROVE_CARTON
                 ,POL.CREDIT_GROUP_CODE
                 ,POL.UNIT_PRICE
                 ,POL.APPROVE_QUANTITY
                 ,POL.UOM_CODE
            FROM PTOM_CLAIM_LINES PCL
                ,PTOM_UOM_CONVERSIONS_V PUCV
                ,PTOM_ORDER_LINES POL
            WHERE 1=1
                AND PCL.CLAIM_HEADER_ID     = {$claim_header_id}
                AND PCL.ORDER_LINE_ID       = POL.ORDER_LINE_ID
                AND PCL.UOM_CODE = PUCV.UOM_CODE
                            AND POL.PROMO_FLAG is null
                            ORDER BY PCL.RMA_LINE_NO
        ";

        } else {
            $sql = "
            SELECT PCL.*
                ,PUCV.UNIT_OF_MEASURE UOM
                $add_sql
                ,POL.APPROVE_CARDBOARDBOX
                ,POL.APPROVE_CARTON
                ,POL.CREDIT_GROUP_CODE
                ,POL.UNIT_PRICE
                ,POL.APPROVE_QUANTITY
                ,POL.UOM_CODE
            FROM PTOM_CLAIM_LINES PCL
                ,PTOM_UOM_CONVERSIONS_V PUCV
                ,PTOM_ORDER_LINES POL
            WHERE 1=1
                AND PCL.CLAIM_HEADER_ID     = {$claim_header_id}
                AND PCL.ORDER_LINE_ID       = POL.ORDER_LINE_ID
                AND PCL.UOM_CODE = PUCV.UOM_CODE
                            AND POL.PROMO_FLAG is null
                            ORDER BY PCL.RMA_LINE_NO
        ";

        }

        $lines = \DB::select($sql);

        return response()->json(['lines'=>$lines]);
    }

    public function getInvoiceLines() // get lines from ptom_order_lines
    {
        // Get invoice line items
        $orderHeader = PtomOrderHeaders::where('order_header_id',\request()->order_header_id)->first();
        $uomlist = PtomUomV::where('DOMESTIC','Y')->orderBy('UOM_CODE')->get();
        $orgId = $orderHeader->org_id;
        $add_sql = '';
        foreach ($uomlist as $item) {
            $add_sql .= "
                ,(SELECT
                    apps.inv_convert.inv_um_convert (
                    item_id           => POL.ITEM_ID,
                    organization_id   => {$orgId},
                    PRECISION         => NULL,
                    from_quantity     => 1,
                    from_unit         => '{$item->uom_code}',
                    to_unit           => POL.UOM_CODE,
                    from_name         => NULL,
                    to_name           => NULL) convert_qty
                FROM dual) {$item->uom_code}
            ";
        }
        if ($orderHeader->product_type_code == 10){
            $sql = "
            SELECT POL.*
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => POL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => 'CGC',
                        to_unit           => 'CGK',
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) CGC
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => POL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => 'CG2',
                        to_unit           => 'CGK',
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) CG2
                 ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => POL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => 'CGP',
                        to_unit           => 'CGK',
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) CGP
            FROM PTOM_ORDER_LINES POL
            WHERE POL.ORDER_HEADER_ID = {$orderHeader->order_header_id}
                            AND POL.PROMO_FLAG is null
            ORDER BY POL.LINE_NUMBER
        ";
        }else{
            $sql = "
                SELECT POL.*
                $add_sql
            FROM PTOM_ORDER_LINES POL
            WHERE POL.ORDER_HEADER_ID = {$orderHeader->order_header_id}
                            AND POL.PROMO_FLAG is null

            ORDER BY POL.LINE_NUMBER
            ";
        }
        $lines = \DB::select($sql);
        return response()->json(['lines'=>$lines]);
    }

    public function createRma()
    {
        // Create RMA NUMBER
        $db = \DB::connection('oracle')->getPdo();
        $sql = "
                DECLARE
                  LV_DOC_SEQUENCE_NUMBER     VARCHAR2(100)   :=  NULL;
                  LV_RETURN_STATUS                      VARCHAR2(100)   :=  NULL;
                  LV_RETURN_MSG                            VARCHAR2(4000)  :=  NULL;
                BEGIN
                  PTOM_WEB_UTILITIES_PKG.GENERATE_DOC_SEQUENCE_NUMBER
                  (   I_DOCUMENT_CODE                       =>  'OMP0052_RMA_NUM_DOM'
                    , O_DOC_SEQUENCE_NUMBER                 =>  :LV_DOC_SEQUENCE_NUMBER
                    , O_RETURN_STATUS                       =>  :LV_RETURN_STATUS
                    , O_RETURN_MSG                          =>  :LV_RETURN_MSG
                  );

                END;
        ";
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);
        $result = [];
        $stmt->bindParam(':LV_DOC_SEQUENCE_NUMBER', $result['doc_sequence_number'], \PDO::PARAM_STR, 2000);
        $stmt->bindParam(':LV_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 20);
        $stmt->bindParam(':LV_RETURN_MSG', $result['message'], \PDO::PARAM_STR, 2000);
        $stmt->execute();

        if ($result['status'] == "S"){
            // Create Header

            // Convert date for rma_date
            \request()->merge(['rma_date' => Carbon::now()->format('Y-m-d h:i:s')]);
            // Get user id
            $user = getDefaultData('/om/rma-domestic');
            $user_id = $user->user_id;
            // Get customer type
            $orderHeader = PtomOrderHeaders::where('pick_release_no',\request()->invoice['pick_release_no'])->first();
            $customer = Customers::find($orderHeader->customer_id);

            // Get order type id
            if (($customer->customer_type_id == 30 || $customer->customer_type_id == 40)&& $orderHeader->product_type_code == 10){
                $orderType = PtomTransactionTypeAllV::from('PTOM_TRANSACTION_TYPES_ALL_V AS PTTAV')
                    ->join('PTOM_CONSIGNMENT_HEADERS AS PCH','PTTAV.ORDER_TYPE_ID', 'PCH.ORDER_TYPE_ID')
                    ->where('PCH.PICK_RELEASE_NUM' , \request()->invoice['pick_release_no'])
                    ->first();
            } else {
                $orderType = PtomTransactionTypeAllV::from('PTOM_TRANSACTION_TYPES_ALL_V AS PTTAV')
                    ->join('PTOM_ORDER_HEADERS AS POH','PTTAV.ORDER_TYPE_ID', 'POH.ORDER_TYPE_ID')
                    ->where('POH.PICK_RELEASE_NO' , \request()->invoice['pick_release_no'])
                    ->first();
            }

            $data = [
                'invoice_id' => \request()->invoice['order_header_id']
                ,'invoice_date' => \request()->invoice['pick_release_approve_date'] == null ? null:parseFromDateTh(\request()->invoice['pick_release_approve_date'])
                ,'customer_id' => \request()->invoice['customer_id']
                ,'source_system' => \request()->invoice['source_system']
                ,'remark_source_system' => \request()->invoice['remark_source_system']
                ,'ship_to_site_id' => \request()->invoice['ship_to_site_id']
                ,'symptom_description' => \request()->symptom_description == null ? null:\request()->symptom_description
                ,'program_code' => 'OMP0052'
                ,'created_by' => $user_id
                ,'CREATED_BY_ID' => $user_id
                ,'UPDATED_BY_ID' => $user_id
                ,'creation_date' => \request()->rma_date
                ,'last_updated_by' => $user_id
                ,'last_update_date' => \request()->rma_date
                ,'rma_number' => $result['doc_sequence_number']
                ,'rma_date' => \request()->rma_date
                ,'status_rma' => \request()->status_rma
                ,'sales_type' => 'DOMESTIC'
                ,'INTERFACED_MSG' => $result['message']
                ,'INTERFACE_STATUS' => $result['status']
                ,'REF_INVOICE_NUMBER' => \request()->invoice['pick_release_no']
                ,'RMA_ORDER_TYPE_ID' => $orderType == null ? null:$orderType->rma_transaction_type_id
            ];

            PtomClaimHeaders::insert($data);

            // Get latest header_id
            $lastHeader = PtomClaimHeaders::latest('claim_header_id')->first();

            // Create Lines
            foreach (\request()->lines as $line) {
                $storeLine = array(
                    'claim_header_id' => $lastHeader->claim_header_id,
                    'order_line_id' => $line['order_line_id'],
                    'claim_no' => $line['rma_line_no'],
                    'item_id' => $line['item_id'],
                    'item_code' => $line['item_code'],
                    'item_description' => $line['item_description'],
                    'order_quantity' => $line['order_quantity'],
                    'uom_code' => $line['uom_code'],
                    'program_code' => 'OMP0052',
                    'created_by'=> $user_id,
                    'creation_date' => \request()->rma_date,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'last_updated_by'=> $user_id,
                    'last_update_date' => \request()->rma_date,
                    'rma_line_no' => $line['rma_line_no'],
                    'rma_quantity' => $line['rma_quantity'],
                    'rma_uom_code' => $line['uom_code'],
                    'rma_quantity_cbb' => $line['rma_quantity_cbb'],
                    'rma_quantity_carton' => $line['rma_quantity_carton'],
                    'rma_quantity_pack' => $line['rma_quantity_pack'],
                    'enter_rma_quantity' => $line['enter_rma_quantity'],
                    'enter_rma_uom' => $line['enter_rma_uom'],
                );
                PtomClaimLines::insert($storeLine);
            }

            // Return with success
            return response()->json(['result' => $result, 'latestHeader' => $lastHeader]);
        } else {
            // Return with error
            return response()->json(['result' => $result, 'latestHeader' => $lastHeader]);
        }
    }

    public function updateRma()
    {
        $result = [];
        $updateResult = PtomClaimHeaders::where('claim_header_id', \request()->claim_header_id)->update([
            'symptom_description' => \request()->symptom_description == null ? null:\request()->symptom_description
        ]);

        if($updateResult) {
            foreach (\request()->claim_lines as $line) {
                $updateLine = array(
                    'rma_quantity_cbb' => $line['rma_quantity_cbb'],
                    'rma_quantity_carton' => $line['rma_quantity_carton'],
                    'rma_quantity_pack' => $line['rma_quantity_pack'],
                    'enter_rma_quantity' => $line['enter_rma_quantity'],
                    'enter_rma_uom' => $line['enter_rma_uom'],
                    'rma_quantity' => $line['rma_quantity']
                );

                PtomClaimLines::where('claim_line_id',$line['claim_line_id'])->update($updateLine);
            }
            $result['status'] = 'S';
            $result['message'] = 'All process done !';

            return response()->json(['result' => $result]);
        } else  {
            $result['status'] = 'E';
            $result['message'] = 'Update PtomClaimHeaders Fail..';

            return response()->json(['result' => $result]);
        }
    }

    public function confirmRma()
    {
        // Params
        $claim_header_id = \request()->claimHeader['claim_header_id'];
        $rma_number = \request()->claimHeader['rma_number'];
        $result = [];

        // Get user id
        $user = getDefaultData('/om/rma-domestic');
        $user_id = $user->user_id;

        // Update claim header status
        $update = PtomClaimHeaders::where('claim_header_id',$claim_header_id)->update(['status_rma' => "Confirm"]);

        if ($update){
            // Update claim header status complete..
            //Create CN
            $dbCn = \DB::connection('oracle')->getPdo();
            $sqlCn = "
                DECLARE
                  LV_DOC_SEQUENCE_NUMBER     VARCHAR2(100)   :=  NULL;
                  LV_RETURN_STATUS                      VARCHAR2(100)   :=  NULL;
                  LV_RETURN_MSG                            VARCHAR2(4000)  :=  NULL;
                BEGIN
                  PTOM_WEB_UTILITIES_PKG.GENERATE_DOC_SEQUENCE_NUMBER
                  (   I_DOCUMENT_CODE                       =>  'OMP0033_CN_NUM_DOM'
                    , O_DOC_SEQUENCE_NUMBER                 =>  :LV_DOC_SEQUENCE_NUMBER
                    , O_RETURN_STATUS                       =>  :LV_RETURN_STATUS
                    , O_RETURN_MSG                          =>  :LV_RETURN_MSG
                  );
                END;
            ";
            $sqlCn = preg_replace("/[\r\n]*/","",$sqlCn);
            $stmtCn = $dbCn->prepare($sqlCn);
            $resultCn = [];
            $stmtCn->bindParam(':LV_DOC_SEQUENCE_NUMBER', $resultCn['doc_sequence_number'], \PDO::PARAM_STR, 2000);
            $stmtCn->bindParam(':LV_RETURN_STATUS', $resultCn['status'], \PDO::PARAM_STR, 20);
            $stmtCn->bindParam(':LV_RETURN_MSG', $resultCn['message'], \PDO::PARAM_STR, 2000);
            $stmtCn->execute();

            if ($resultCn['status']  == "S"){
                // Call package create CN success

                // Parameter
                $pickReleaseNo = \request()->orderHeader['pick_release_no'];
                $orderHeader = PtomOrderHeaders::where('pick_release_no', $pickReleaseNo)->first();

                $transType = TransactionTypeV::where('order_type_id', $orderHeader->order_type_id)->first();
                $taxRate = PtomAllTaxRateV::where('meaning', 'อัตราภาษีอบจ.')->first();
                
                // Update cn_number to ptom_claim_headers
                $updateCn = PtomClaimHeaders::where('rma_number',$rma_number)->update(['CREDIT_NOTE_NUMBER' => $resultCn['doc_sequence_number']]);
                // Create CN Invoice header
                $header = new PtomInvoiceHeaders();
//                    $header->invoice_headers_number = $cn_number;
                $header->invoice_headers_number = $resultCn['doc_sequence_number'];
                $header->customer_id = \request()->claimHeader['customer_id'];
                $header->province_name = \request()->claimHeader['province_name'];
                $header->program_code = 'OMP0052';
                $header->invoice_type = 'CN_OTHER';
                $header->invoice_date = parseFromDateTh(\request()->claimHeader['rma_date']);
                $header->invoice_amount = 0;
                $header->delivery_date = \request()->orderHeader['delivery_date'];
                $header->invoice_status = 'Confirm';
                $header->term_id = \request()->orderHeader['term_id'];
                $header->document_number = \request()->claimHeader['rma_number'];
                $header->currency = 'THB';
                $header->creation_date = Carbon::today();
                $header->created_at = Carbon::now();
                $header->updated_at = Carbon::now();
                $header->created_by_id = $user_id;
                $header->created_by = $user_id;
                $header->last_updated_by = $user_id;
                $header->ref_invoice_number = $pickReleaseNo;

                $header->save();
                // Get latest header_id
                $lastHeader = PtomInvoiceHeaders::select('invoice_headers_id')->latest('invoice_headers_id')->first();
                $invoice_amount = 0;
                $total_tax_amount = 0;
                $total_pao_amount = 0;
                $documentId = 0;
                // Create CN Invoice Lines
                foreach (\request()->claimLines as $line) {
                    
                    $orderLine = PtomOrderLines::where('order_header_id', $orderHeader->order_header_id)->where('item_code', $line['item_code'])->first();
                    $tax_amount = $orderLine->promo_flag == 'Y' ? 0 : ($line['rma_quantity'] * (optional($orderLine)->attribute1 ?? 1)) * ((optional($transType)->tax_rate ?? 0)/(100+(optional($transType)->tax_rate ?? 0)));
                    $pao_tax = $line['rma_quantity'] * (optional($taxRate)->tag ?? 0);

                    $invoiceLine = array(
                        'invoice_headers_id' => $lastHeader->invoice_headers_id,
                        'item_id' => $line['item_id'],
                        'item_code' => $line['item_code'],
                        'item_description' => $line['item_description'],
                        'uom_code' => $line['rma_uom_code'],
                        'quantity' => $line['rma_quantity'],
                        'document_id' => $line['claim_header_id'],
                        'document_line_id' => $line['claim_line_id'],
                        'payment_amount' => (float)$line['rma_quantity'] * (float)$line['unit_price'],
                        'invoice_flag' => 'Y',
                        'conversion_rate' => 1,
                        'credit_group_code' => $line['credit_group_code'],
                        'line_tax_amount' => $tax_amount,
                        'pao_line_amount' => $pao_tax,
                        'program_code' => 'OMP0052',
                        'created_by' => $user_id,
                        'created_by_id' => $user_id,
                        'last_updated_by' => $user_id,
                        'creation_date' => Carbon::today(),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                        'ref_invoice_number' => $pickReleaseNo,
                    );
                    $customer = Customer::where('customer_id',  $header->customer_id)->first();
                    if($customer->customer_type_id == 20 && $customer->province_code ==10) {
                        unset($invoiceLine['pao_line_amount']);
                    } 
                    $total_tax_amount += $tax_amount;
                    $total_pao_amount += $pao_tax;
                    $invoice_amount = $invoice_amount + ((float)$line['rma_quantity'] * (float)$line['unit_price']);
                    $documentId = (int)$line['claim_header_id'];
                    PtomInvoiceLines::insert($invoiceLine);
                }

                // Update invoice amount
                $objUpdateAmount =[
                    'INVOICE_AMOUNT' => $invoice_amount,
                    'TOTAL_VAT_AMOUNT' => $total_tax_amount,
                    'PAO_AMOUNT' => $total_pao_amount
                ];
                if($customer->customer_type_id == 20 && $customer->province_code ==10) {
                    unset($objUpdateAmount['PAO_AMOUNT']);
                } 
                $updateAmount = PtomInvoiceHeaders::where('INVOICE_HEADERS_ID',$lastHeader->invoice_headers_id)
                    ->update($objUpdateAmount);

                // Check CNDN cenario
                $customer = Customers::find($orderHeader->customer_id);
                // Check data in PTOM_OUTSTANDING_DEBT_DOM_V
                if (($customer->customer_type_id == 30 || $customer->customer_type_id == 40)&& $orderHeader->product_type_code == 10){
                    $invoiceHeader = PtomConsignmentHeaders::where('pick_release_num',\request()->orderHeader['pick_release_no'])->first();
                    $invoiceLines = PtomConsignmentLines::where('CONSIGNMENT_HEADER_ID',$invoiceHeader->consignment_header_id)->get();
//                    foreach ($invoiceLines as $line) {
                    $result = PtomOutstandingDebtDomV::where('CONSIGNMENT_NO',$invoiceHeader->consignment_no)->get();
                    if ($result->first()){
                        $sumPayment = PtomConsignmentLines::where('CONSIGNMENT_HEADER_ID', $invoiceHeader->consignment_header_id)
                            ->sum('LINE_COMMIS_AMOUNT');
                        $outStanding = PtomOutstandingDebtDomV::where('PICK_RELEASE_NO', \request()->orderHeader['pick_release_no'])
                            ->sum('outstanding_debt');
                        if ($outStanding >= $sumPayment){
                            // Create PTOM_PAYMENT_APPLY_CNDN Case 2
                            $data = [
                                [
                                    'order_header_id' => \request()->orderHeader['order_header_id']
                                    ,'pick_release_no' => \request()->orderHeader['pick_release_no']
                                    ,'credit_group_code' => null
                                    ,'invoice_number' => $resultCn['doc_sequence_number']
                                    ,'invoice_header_id' => $lastHeader->invoice_headers_id
                                    ,'invoice_amount' => $invoice_amount
                                    ,'attribute1' => 'Y'
                                    ,'attribute2' => 'CN_OTHER'
                                    ,'program_code' => 'OMP0052'
                                    ,'creation_date' => Carbon::today()
                                    ,'created_at' => Carbon::now()
                                    ,'updated_at' => Carbon::now()
                                    ,'created_by_id' => $user_id
                                    ,'updated_by_id' => $user_id
                                    ,'created_by' => $user_id
                                    ,'last_updated_by' => $user_id
                                ]
                            ];
                            PtomPaymentApplyCndn::insert($data);
                        } else {
                            // Create PTOM_PAYMENT_APPLY_CNDN Case 3
                            $data = [
                                [
                                    'order_header_id' => \request()->orderHeader['order_header_id']
                                    ,'pick_release_no' => \request()->orderHeader['pick_release_no']
                                    ,'credit_group_code' => null
                                    ,'invoice_number' => $resultCn['doc_sequence_number']
                                    ,'invoice_header_id' => $lastHeader->invoice_headers_id
                                    ,'invoice_amount' => $invoice_amount
                                    ,'attribute1' => 'Y'
                                    ,'attribute2' => 'CN_OTHER'
                                    ,'program_code' => 'OMP0052'
                                    ,'creation_date' => Carbon::today()
                                    ,'created_at' => Carbon::now()
                                    ,'updated_at' => Carbon::now()
                                    ,'created_by_id' => $user_id
                                    ,'updated_by_id' => $user_id
                                    ,'created_by' => $user_id
                                    ,'last_updated_by' => $user_id
                                ],
                                [
                                    'order_header_id' => null
                                    ,'pick_release_no' => null
                                    ,'credit_group_code' => null
                                    ,'invoice_number' => $resultCn['doc_sequence_number']
                                    ,'invoice_header_id' => $lastHeader->invoice_headers_id
                                    ,'invoice_amount' => $sumPayment - $invoice_amount
                                    ,'attribute1' => null
                                    ,'attribute2' => 'CN_OTHER'
                                    ,'program_code' => 'OMP0052'
                                    ,'creation_date' => Carbon::today()
                                    ,'created_at' => Carbon::now()
                                    ,'updated_at' => Carbon::now()
                                    ,'created_by_id' => $user_id
                                    ,'updated_by_id' => $user_id
                                    ,'created_by' => $user_id
                                    ,'last_updated_by' => $user_id
                                ]
                            ];
                            PtomPaymentApplyCndn::insert($data);
                        }
                    } else {
                        // Create PTOM_PAYMENT_APPLY_CNDN Case 1
                        $data = [
                            [
                                'order_header_id' => null
                                ,'pick_release_no' => null
                                ,'credit_group_code' => null
                                ,'invoice_number' => $resultCn['doc_sequence_number']
                                ,'invoice_header_id' => $lastHeader->invoice_headers_id
                                ,'invoice_amount' => $invoice_amount
                                ,'attribute1' => null
                                ,'attribute2' => 'CN_OTHER'
                                ,'program_code' => 'OMP0052'
                                ,'creation_date' => Carbon::today()
                                ,'created_at' => Carbon::now()
                                ,'updated_at' => Carbon::now()
                                ,'created_by_id' => $user_id
                                ,'updated_by_id' => $user_id
                                ,'created_by' => $user_id
                                ,'last_updated_by' => $user_id
                            ]
                        ];
                        PtomPaymentApplyCndn::insert($data);
                    }
//                    }
                } else {
                    $invoiceHeader = PtomInvoiceHeaders::where('REF_INVOICE_NUMBER', \request()->orderHeader['pick_release_no'])->first();
                    $invoiceLines = PtomInvoiceLines::distinct()
                        ->where('INVOICE_HEADERS_ID', $invoiceHeader->invoice_headers_id)
                        ->get(['credit_group_code']);
                    foreach ($invoiceLines as $line) {
                        $result = PtomOutstandingDebtDomV::where('PICK_RELEASE_NO', \request()->orderHeader['pick_release_no'])
                            ->where('CREDIT_GROUP_CODE', $line->credit_group_code)
                            ->get();
                        if ($result->first()) {
                            $sumPayment = PtomInvoiceLines::where('INVOICE_HEADERS_ID', $invoiceHeader->invoice_headers_id)
                                ->where('credit_group_code', $line->credit_group_code)
                                ->sum('payment_amount');
                            $outStanding = PtomOutstandingDebtDomV::where('PICK_RELEASE_NO', \request()->orderHeader['pick_release_no'])
                                ->where('credit_group_code', $line->credit_group_code)
                                ->sum('outstanding_debt');
                            if ($outStanding >= $sumPayment) {
                                // Create PTOM_PAYMENT_APPLY_CNDN Case 2
                                $data = [
                                    [
                                        'order_header_id' => \request()->orderHeader['order_header_id']
                                        ,'pick_release_no' => \request()->orderHeader['pick_release_no']
                                        ,'credit_group_code' => $line->credit_group_code
                                        ,'invoice_number' => $resultCn['doc_sequence_number']
                                        ,'invoice_header_id' => $lastHeader->invoice_headers_id
                                        ,'invoice_amount' => $invoice_amount
                                        ,'attribute1' => 'Y'
                                        ,'attribute2' => 'CN_OTHER'
                                        ,'program_code' => 'OMP0052'
                                        ,'creation_date' => Carbon::today()
                                        ,'created_at' => Carbon::now()
                                        ,'updated_at' => Carbon::now()
                                        ,'created_by_id' => $user_id
                                        ,'updated_by_id' => $user_id
                                        ,'created_by' => $user_id
                                        ,'last_updated_by' => $user_id
                                    ]
                                ];
                                PtomPaymentApplyCndn::insert($data);
                            } else {
                                // Create PTOM_PAYMENT_APPLY_CNDN Case 3
                                $data = [
                                    [
                                        'order_header_id' => \request()->orderHeader['order_header_id']
                                        ,'pick_release_no' => \request()->orderHeader['pick_release_no']
                                        ,'credit_group_code' => $line->credit_group_code
                                        ,'invoice_number' => $resultCn['doc_sequence_number']
                                        ,'invoice_header_id' => $lastHeader->invoice_headers_id
                                        ,'invoice_amount' => $invoice_amount
                                        ,'attribute1' => 'Y'
                                        ,'attribute2' => 'CN_OTHER'
                                        ,'program_code' => 'OMP0052'
                                        ,'creation_date' => Carbon::today()
                                        ,'created_at' => Carbon::now()
                                        ,'updated_at' => Carbon::now()
                                        ,'created_by_id' => $user_id
                                        ,'updated_by_id' => $user_id
                                        ,'created_by' => $user_id
                                        ,'last_updated_by' => $user_id
                                    ],
                                    [
                                        'order_header_id' => null
                                        ,'pick_release_no' => null
                                        ,'credit_group_code' => null
                                        ,'invoice_number' => $resultCn['doc_sequence_number']
                                        ,'invoice_header_id' => $lastHeader->invoice_headers_id
                                        ,'invoice_amount' => $sumPayment - $invoice_amount
                                        ,'attribute1' => null
                                        ,'attribute2' => 'CN_OTHER'
                                        ,'program_code' => 'OMP0052'
                                        ,'creation_date' => Carbon::today()
                                        ,'created_at' => Carbon::now()
                                        ,'updated_at' => Carbon::now()
                                        ,'created_by_id' => $user_id
                                        ,'updated_by_id' => $user_id
                                        ,'created_by' => $user_id
                                        ,'last_updated_by' => $user_id
                                    ]
                                ];
                                PtomPaymentApplyCndn::insert($data);
                            }
                        } else {
                            // Create PTOM_PAYMENT_APPLY_CNDN Case 1
                            $data = [
                                [
                                    'order_header_id' => null
                                    ,'pick_release_no' => null
                                    ,'credit_group_code' => null
                                    ,'invoice_number' => $resultCn['doc_sequence_number']
                                    ,'invoice_header_id' => $lastHeader->invoice_headers_id
                                    ,'invoice_amount' => $invoice_amount
                                    ,'attribute1' => null
                                    ,'attribute2' => 'CN_OTHER'
                                    ,'program_code' => 'OMP0052'
                                    ,'creation_date' => Carbon::today()
                                    ,'created_at' => Carbon::now()
                                    ,'updated_at' => Carbon::now()
                                    ,'created_by_id' => $user_id
                                    ,'updated_by_id' => $user_id
                                    ,'created_by' => $user_id
                                    ,'last_updated_by' => $user_id
                                ]
                            ];
                            PtomPaymentApplyCndn::insert($data);
                        }
                    }
                }

                // Update PTOM_CUSTOMER_CONTRACT_GROUPS

                $invoiceHeader = PtomInvoiceHeaders::where('invoice_headers_id',$lastHeader->invoice_headers_id)->first();
                $result = PtomInvoiceLines::distinct()
                    ->where('REF_INVOICE_NUMBER',\request()->orderHeader['pick_release_no'])
                    ->where('invoice_headers_id',$invoiceHeader->invoice_headers_id)
                    ->get(['credit_group_code']);
                foreach ($result as $value) {
                    if ($value->credit_group_code != 0 && $value->credit_group_code != null){
//                        echo 'CREDIT_GROUP_CODE => '.$value->credit_group_code . '<br>';
                        $sumPayment = PtomInvoiceLines::where('REF_INVOICE_NUMBER',\request()->orderHeader['pick_release_no'])
                            ->where('credit_group_code',$value->credit_group_code)
                            ->where('invoice_headers_id',$invoiceHeader->invoice_headers_id)
                            ->sum('payment_amount');
//                        echo '$sumPayment => ' . number_format($sumPayment,2). '<br>';
                        $remainingAmount = PtomCustomerContractGroups::where('customer_id',$invoiceHeader->customer_id)
                            ->where('credit_group_code',$value->credit_group_code)
                            ->first();
//                        echo '$remainingAmount => ' . number_format($remainingAmount->remaining_amount,2) . '<br>';
                        $remainingAmount->remaining_amount += $sumPayment;
//                        echo 'new $remainingAmount => ' . number_format($remainingAmount->remaining_amount,2) . '<br>';
                        PtomCustomerContractGroups::where('customer_id',$invoiceHeader->customer_id)
                            ->where('credit_group_code',$value->credit_group_code)
                            ->update(['REMAINING_AMOUNT'=>$remainingAmount->remaining_amount]);
                    }
                }

                // Call WMS
                $dbWms = \DB::connection('oracle')->getPdo();
                $sqlWms = "
                        DECLARE
                            o_result    VARCHAR2(4000);
                        BEGIN
                            PTOM_WEB_SALE_INF_WMS_PKG.main_process_1_14(i_claim_header_id   => {$claim_header_id}
                                ,i_rma_number     => '{$rma_number}'
                                ,o_result                   => :o_result);
                            dbms_output.put_line(o_result);
                        END;
                    ";

                $sqlWms = preg_replace("/[\r\n]*/","",$sqlWms);
                $stmtWms = $dbWms->prepare($sqlWms);
                $resultWms = [];
                $stmtWms->bindParam(':o_result', $resultWms['o_result'], \PDO::PARAM_STR, 4000);
                $stmtWms->execute();

                if ($resultWms['o_result'] == "Completed"){
                    // Call package wms success
                    $result['status'] = 'S';
                    $result['message'] = 'All process done !';
                    $result['cnNumber'] = $resultCn['doc_sequence_number'];

                    return response()->json(['result' => $result]);
                } else {
                    // Call package wms not success
                    $result['status'] = 'E';
                    $result['message'] = 'o_result : ' . $resultWms['o_result'];
                    $result['cnNumber'] = $resultCn['doc_sequence_number'];

                    return response()->json(['result' => $result]);
                }
            } else {
                // Call package create CN not success
                $result['status'] = 'E';
                $result['message'] = 'resultCn : ' . $resultCn['message'];

                return response()->json(['result' => $result]);
            }
        } else {
            // Update claim header status not complete..
            $result['status'] = 'E';
            $result['message'] = 'Error update rma_status..';

            return response()->json(['result' => $result]);
        }
    }

    public function cancelRma()
    {
        // Get user id
        $user = getDefaultData('/om/rma-domestic');
        $user_id = $user->user_id;
        $result = [];

        if (\request()->rma_status == 'Draft'){

            // Update PTOM_CLAIM_HEADERS
            PtomClaimHeaders::where('RMA_NUMBER',\request()->rma_number)
                ->update([
                    'STATUS_RMA' => "Cancelled",
                    'RMA_CANCEL_REASON' => \request()->rma_cancel_reason,
                    'last_updated_by' => $user_id,
                    'last_update_date' => Carbon::now()
                ]);

            $result['status'] = 'S';
            $result['message'] = '-- ดำเนินการสำเร็จ --';

            return response()->json(['result' => $result]);

        } else {
            // Get invoice header
            $Header = PtomInvoiceHeaders::where('INVOICE_HEADERS_NUMBER',\request()->cn_number)->first();
            $claimHeader = PtomClaimHeaders::where('rma_number',\request()->rma_number)->first();
            $orderTwms = PtomOrderTWms::where('OAOM_ORDER_NO',\request()->rma_number)->first();


            if ($claimHeader->close_sale_flag != "Y"){
                if ($orderTwms->oaom_wms6_inven != "Y") {

                    // Update PTOM_ORDER_T_WMS.
                    PtomOrderTWms::where('oaom_order_no',\request()->rma_number)
                        ->update([
                            'RECORD_STATUS' => "C"
                        ]);

                    // Update PTOM_CLAIM_HEADERS.
                    PtomClaimHeaders::where('RMA_NUMBER',\request()->rma_number)
                        ->update([
                            'STATUS_RMA' => "Cancelled",
                            'RMA_CANCEL_REASON' => \request()->rma_cancel_reason,
                            'last_updated_by' => $user_id,
                            'last_update_date' => Carbon::now()
                        ]);

                    // Update PTOM_INVOICE_HEADERS.
                    PtomInvoiceHeaders::where('INVOICE_HEADERS_NUMBER',$orderTwms->oaom_invoice_no)
                        ->update([
                            'INVOICE_STATUS' => "Cancelled",
                            'LAST_UPDATED_BY' => $user_id,
                            'LAST_UPDATE_DATE' => Carbon::now()
                        ]);

                    // Update PTOM_PAYMENT_APPLY_CNDN.
                    PtomPaymentApplyCndn::where('INVOICE_HEADER_ID',$Header->invoice_headers_id)
                        ->update([
                            'ATTRIBUTE1' => 'C',
                            'LAST_UPDATED_BY' => $user_id,
                            'LAST_UPDATE_DATE' => Carbon::now()
                        ]);

                    // Update PTOM_CUSTOMER_CONTRACT_GROUPS
                    $invoiceHeader = PtomInvoiceHeaders::where('DOCUMENT_NUMBER',\request()->rma_number)->first();
                    $result = PtomInvoiceLines::distinct()
                        ->where('REF_INVOICE_NUMBER',$invoiceHeader->ref_invoice_number)
                        ->where('invoice_headers_id',$invoiceHeader->invoice_headers_id)
                        ->get(['credit_group_code']);
                    foreach ($result as $value) {
                        if ($value->credit_group_code != 0 && $value->credit_group_code != null){
//                        echo 'CREDIT_GROUP_CODE => '.$value->credit_group_code . '<br>';
                            $sumPayment = PtomInvoiceLines::where('REF_INVOICE_NUMBER',$invoiceHeader->ref_invoice_number)
                                ->where('credit_group_code',$value->credit_group_code)
                                ->where('invoice_headers_id',$invoiceHeader->invoice_headers_id)
                                ->sum('payment_amount');
//                        echo '$sumPayment => ' . number_format($sumPayment,2). '<br>';
                            $remainingAmount = PtomCustomerContractGroups::where('customer_id',$invoiceHeader->customer_id)
                                ->where('credit_group_code',$value->credit_group_code)
                                ->first();
//                        echo '$remainingAmount => ' . number_format($remainingAmount->remaining_amount,2) . '<br>';
                            $remainingAmount->remaining_amount -= $sumPayment;
//                        echo 'new $remainingAmount => ' . number_format($remainingAmount->remaining_amount,2) . '<br>';
                            PtomCustomerContractGroups::where('customer_id',$invoiceHeader->customer_id)
                                ->where('credit_group_code',$value->credit_group_code)
                                ->update(['REMAINING_AMOUNT'=>$remainingAmount->remaining_amount]);
                        }
                    }

                    $result['status'] = 'S';
                    $result['message'] = '-- ดำเนินการสำเร็จ --';

                    return response()->json(['result' => $result]);
                } else {
                    $result['status'] = 'E';
                    $result['message'] = 'PTOM_ORDER_T_WMS.OAOM_WMS6_INVEN = Y';

                    return response()->json(['result' => $result]);
                }
            } else {
                $result['status'] = 'E';
                $result['message'] = 'ไม่สามารถยกเลิกได้เนื่องจากปิดการขายประจำวันไปแล้ว';

                return response()->json(['result' => $result]);

            }
        }

    }

    public function convertUnit()
    {
        $itemId = \request()->itemId;
        $orgId = \request()->orgId;
        $qty = \request()->qty;
        $fromUnit = \request()->fromUnit;
        $toUnit = \request()->toUnit;


        $sql = "
            SELECT
                apps.inv_convert.inv_um_convert (
                    item_id           => {$itemId},
                    organization_id   => {$orgId},
                    PRECISION         => NULL,
                    from_quantity     => {$qty},
                    from_unit         => '{$fromUnit}',
                    to_unit           => '{$toUnit}',
                    from_name         => NULL,
                    to_name           => NULL) convert_qty
            from dual
        ";

        $data = \DB::select($sql);
        foreach ($data as $datum) {
            $result = $datum->convert_qty;
        }

        return response()->json(['convertResult'=>$result]);
    }

    public function testUpdate()
    {
        $result = PtomClaimHeaders::where('claim_header_id',$id)->update(['status_rma' => "Confirm"]);
        if ($result){
            return response()->json([
                'message' => "Update Completed...",
                'code' => 200
            ]);
        } else {
            return response()->json([
                'message' => "Update Error...",
                'code' => 500
            ]);
        }
    }
}
