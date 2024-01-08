<?php

namespace App\Http\Controllers\OM\Api;

use App\Http\Controllers\Controller;
use App\Models\OM\Customers;
use App\Models\OM\Rma\Domestic\PtomClaimHeaders;
use App\Models\OM\Rma\Domestic\PtomClaimLines;
use App\Models\OM\Rma\Domestic\PtomOrderHeaders;
use App\Models\OM\Rma\Domestic\PtomOrderLines;
use App\Models\OM\Rma\Export\PtomProformaInvoiceHeadres;
use App\Models\OM\Rma\Export\PtomProformaInvoiceLines;
use App\Models\OM\Rma\Export\PtomTransactionTypeAllV;
use App\Models\OM\Rma\PtomInvoiceHeaders;
use App\Models\OM\Rma\PtomInvoiceLines;
use App\Models\OM\Rma\PtomOrderTWms;
use App\Models\OM\Rma\PtomOutstandingDebtExpV;
use App\Models\OM\Rma\PtomPaymentApplyCndn;
use App\Models\OM\Rma\PtomUomV;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class RmaExportController extends Controller
{
    public function getByNumber()
    {
        $customer = Customers::where('customer_id',request()->customer_id)->first();
        $pickReleaseNo = PtomProformaInvoiceHeadres::select('invoice_id')->where('rma_number',request()->rma_number)->first();

        $invoice = PtomProformaInvoiceHeadres::with('ptomCustomerShipSites')
            ->where('pick_release_no',$pickReleaseNo->invoice_id)->first();

        return response()->json(['invoice'=>$invoice,'customer'=>$customer]);
    }

    public function getByInvoice()
    {
        $invoice = PtomProformaInvoiceHeadres::where('pick_release_no',request()->pick_release_no)->first();
        $customer = Customers::where('customer_id',$invoice->customer_id)->first();
        $numbers = PtomProformaInvoiceLines::where('pi_header_id',$invoice->order_header_id)
            ->get();

        return response()->json(['numbers'=>$numbers,'customer'=>$customer]);
    }

    public function getByCustomer()
    {
        $customer = Customers::find(request()->customer_id);
//        dd($customer);
        if ($customer->customer_type_id != 30 || $customer->customer_type_id != 40){
//            $invoices = PtomProformaInvoiceHeadres::where('pick_release_status','Confirm')
//                ->where('customer_id',$customer->customer_id)
//                ->get();
            $invoices = PtomProformaInvoiceHeadres::from('PTOM_PROFORMA_INVOICE_HEADERS PPIH')
                ->join('PTOM_CUSTOMER_SHIP_SITES PCSS' , 'PPIH.SHIP_TO_SITE_ID' , 'PCSS.SHIP_TO_SITE_ID')
                ->where('PPIH.PICK_RELEASE_STATUS','Confirm')
                ->where('PPIH.CUSTOMER_ID',$customer->customer_id)
                ->whereNotNull('PPIH.PICK_RELEASE_NO')
                ->orderBy('PPIH.PICK_RELEASE_NO','desc')
                ->get([
                    'PPIH.PI_HEADER_ID'
                    ,'PPIH.CUSTOMER_ID'
                    ,'PPIH.ORG_ID'
                    ,'PPIH.PRODUCT_TYPE_CODE'
                    ,'PPIH.PICK_RELEASE_NO'
                    ,'PPIH.PICK_RELEASE_APPROVE_DATE'
                    ,'PPIH.PICK_RELEASE_STATUS'
                    ,'PPIH.DELIVERY_DATE'
                    ,'PPIH.CURRENCY'
                    ,'PPIH.TERM_ID'
                    ,'PPIH.SOURCE_SYSTEM'
                    ,'PPIH.REMARK_SOURCE_SYSTEM'
                    ,'PPIH.SHIP_TO_SITE_ID'
                    ,'PCSS.SHIP_TO_SITE_NAME'
                    ,'PCSS.PROVINCE_NAME'
                ]);
        } else {
//            $invoices = PtomConsignmentHeaders::whereHas('ptomProformaInvoiceHeadres',function ($q){
//                $q->where('customer_id',$customer->customer_id);
//            })
//                ->where('consignment_status','Confirm')
//                ->get();
        }

        $numbers = PtomProformaInvoiceHeadres::where('customer_id',request()->customer_id)
            ->get();


        return response()->json([
            'numbers'=>$numbers,
            'invoices'=>$invoices
        ]);
    }

    public function getNumberOnly()
    {
        $numbers = PtomProformaInvoiceHeadres::where('customer_id',request()->customer_id)
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
        $numbers = PtomProformaInvoiceLines::from('ptom_claim_headers pch')
            ->join('ptom_customer_ship_sites pcss','pch.ship_to_site_id','pcss.ship_to_site_id')
            ->where('pch.sales_type','EXPORT')
            ->whereNotNull('pch.rma_number')
            ->orderBy('pch.rma_number','desc')
            ->get();
//        dd($numbers);
        return response()->json(['newNumbers'=>$numbers]);
    }

    public function getPreviousRma() // Get Previous RMA quantity
    {
        $claimHeadersId = [];
        $rmaItemQty = [];
        $orderHeader = PtomProformaInvoiceHeadres::where('pick_release_no',\request()->invoiceNo)->first();
        $orgId = $orderHeader->org_id;
        $orderLines = PtomProformaInvoiceLines::where('pi_header_id',$orderHeader->pi_header_id)->get();
        $iOrderLines = $orderLines->count();
        $qty = 1;

        foreach ($orderLines as $line){
            array_push($rmaItemQty,[
                'item_code'=>$line->item_code
                ,'item_description'=>$line->item_description
                ,'order_quantity'=>$line->order_quantity
                ,'uom_code'=>$line->uom_code
                ,'org_id'=>$orgId
                ,'prvRmaQty'=>0
                ,'line_number'=>$line->line_number
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
        $orderHeader = PtomProformaInvoiceHeadres::where('pick_release_no',$claimHeader->ref_invoice_number)->first();
        $orgId = $orderHeader->org_id;
        $uomlist = PtomUomV::where('EXPORT','Y')->orderBy('UOM_CODE')->get();
        $factorArray =[];
        foreach ($uomlist as $item) {
            array_push($factorArray,[
                'uomDesc' => $item->uom_code
            ]);
        }

        // Get Line items
        if ($orderHeader->product_type_code == 10){
            $sql = "
            SELECT PCL.*
                 ,PUCV.UNIT_OF_MEASURE UOM
                 ,PPIL.UNIT_PRICE
                 ,PPIL.CREDIT_GROUP_CODE
                 ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PPIL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => 'CGC',
                        to_unit           => PPIL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) CGC
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PPIL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => 'CG2',
                        to_unit           => PPIL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) CG2
                 ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PPIL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => 'CGP',
                        to_unit           => PPIL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) CGP
            FROM PTOM_CLAIM_LINES PCL,
                 PTOM_UOM_CONVERSIONS_V PUCV,
                 PTOM_PROFORMA_INVOICE_LINES PPIL
            WHERE 1=1
                AND PCL.CLAIM_HEADER_ID = {$claim_header_id}
                AND PCL.UOM_CODE = PUCV.UOM_CODE
                AND PCL.ORDER_LINE_ID = PPIL.PI_LINE_ID
            ORDER BY PCL.RMA_LINE_NO
        ";
        } else {
            $sql = "
            SELECT PCL.*
                 ,PUCV.UNIT_OF_MEASURE UOM
                 ,PPIL.UNIT_PRICE
                 ,PPIL.CREDIT_GROUP_CODE
                 ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PPIL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[0]['uomDesc']}',
                        to_unit           => PPIL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[0]['uomDesc']}
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PPIL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[1]['uomDesc']}',
                        to_unit           => PPIL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[1]['uomDesc']}
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PPIL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[2]['uomDesc']}',
                        to_unit           => PPIL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[2]['uomDesc']}
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PPIL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[3]['uomDesc']}',
                        to_unit           => PPIL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[3]['uomDesc']}
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PPIL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[4]['uomDesc']}',
                        to_unit           => PPIL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[4]['uomDesc']}
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PPIL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[5]['uomDesc']}',
                        to_unit           => PPIL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[5]['uomDesc']}
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PPIL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[6]['uomDesc']}',
                        to_unit           => PPIL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[6]['uomDesc']}
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PPIL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[7]['uomDesc']}',
                        to_unit           => PPIL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[7]['uomDesc']}
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PPIL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[8]['uomDesc']}',
                        to_unit           => PPIL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[8]['uomDesc']}
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PPIL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[9]['uomDesc']}',
                        to_unit           => PPIL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[9]['uomDesc']}
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PPIL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[10]['uomDesc']}',
                        to_unit           => PPIL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[10]['uomDesc']}
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PPIL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[11]['uomDesc']}',
                        to_unit           => PPIL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[11]['uomDesc']}
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PPIL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[12]['uomDesc']}',
                        to_unit           => PPIL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[12]['uomDesc']}
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PPIL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[13]['uomDesc']}',
                        to_unit           => PPIL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[13]['uomDesc']}
            FROM PTOM_CLAIM_LINES PCL,
                 PTOM_UOM_CONVERSIONS_V PUCV,
                 PTOM_PROFORMA_INVOICE_LINES PPIL
            WHERE 1=1
                AND PCL.CLAIM_HEADER_ID = {$claim_header_id}
                AND PCL.UOM_CODE = PUCV.UOM_CODE
                AND PCL.ORDER_LINE_ID = PPIL.PI_LINE_ID
            ORDER BY PCL.RMA_LINE_NO
        ";
        }


        $lines = \DB::select($sql);
//        dd($lines);
        return response()->json(['lines'=>$lines]);
    }

    public function getInvoiceLines() // get lines from ptom_order_lines
    {
        // Get invoice line items
        $pi_header_id = \request()->pi_header_id;
        $orderHeader = PtomProformaInvoiceHeadres::where('pi_header_id',$pi_header_id)->first();
        $uomlist = PtomUomV::where('EXPORT','Y')->orderBy('UOM_CODE')->get();
        $orgId = $orderHeader->org_id;
        $factorArray =[];
        foreach ($uomlist as $item) {
            array_push($factorArray,[
                'uomDesc' => $item->uom_code
            ]);
        }
        if ($orderHeader->product_type_code == 10){
            $sql = "
            SELECT PPIL.*
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PPIL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => 'CGC',
                        to_unit           => PPIL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) CGC
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PPIL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => 'CG2',
                        to_unit           => PPIL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) CG2
                 ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PPIL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => 'CGP',
                        to_unit           => PPIL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) CGP
            FROM PTOM_PROFORMA_INVOICE_LINES PPIL
            WHERE PPIL.PI_HEADER_ID = {$pi_header_id}
            ORDER BY PPIL.LINE_NUMBER
        ";
        } else {
            $sql = "
            SELECT PPIL.*
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PPIL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[0]['uomDesc']}',
                        to_unit           => PPIL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[0]['uomDesc']}
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PPIL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[1]['uomDesc']}',
                        to_unit           => PPIL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[1]['uomDesc']}
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PPIL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[2]['uomDesc']}',
                        to_unit           => PPIL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[2]['uomDesc']}
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PPIL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[3]['uomDesc']}',
                        to_unit           => PPIL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[3]['uomDesc']}
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PPIL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[4]['uomDesc']}',
                        to_unit           => PPIL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[4]['uomDesc']}
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PPIL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[5]['uomDesc']}',
                        to_unit           => PPIL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[5]['uomDesc']}
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PPIL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[6]['uomDesc']}',
                        to_unit           => PPIL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[6]['uomDesc']}
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PPIL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[7]['uomDesc']}',
                        to_unit           => PPIL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[7]['uomDesc']}
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PPIL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[8]['uomDesc']}',
                        to_unit           => PPIL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[8]['uomDesc']}
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PPIL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[9]['uomDesc']}',
                        to_unit           => PPIL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[9]['uomDesc']}
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PPIL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[10]['uomDesc']}',
                        to_unit           => PPIL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[10]['uomDesc']}
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PPIL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[11]['uomDesc']}',
                        to_unit           => PPIL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[11]['uomDesc']}
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PPIL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[12]['uomDesc']}',
                        to_unit           => PPIL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[12]['uomDesc']}
                ,(SELECT
                        apps.inv_convert.inv_um_convert (
                        item_id           => PPIL.ITEM_ID,
                        organization_id   => {$orgId},
                        PRECISION         => NULL,
                        from_quantity     => 1,
                        from_unit         => '{$factorArray[13]['uomDesc']}',
                        to_unit           => PPIL.UOM_CODE,
                        from_name         => NULL,
                        to_name           => NULL) convert_qty
                    FROM dual) {$factorArray[13]['uomDesc']}
            FROM PTOM_PROFORMA_INVOICE_LINES PPIL
            WHERE PPIL.PI_HEADER_ID = {$pi_header_id}
            ORDER BY PPIL.LINE_NUMBER
        ";
        }

        $lines = \DB::select($sql);

        return response()->json(['lines'=>$lines]);
    }

    public function createRma()
    {
//        dd('test');
        // Create RMA NUMBER
        $db = \DB::connection('oracle')->getPdo();
        $sql = "
                DECLARE
                  LV_DOC_SEQUENCE_NUMBER     VARCHAR2(100)   :=  NULL;
                  LV_RETURN_STATUS                      VARCHAR2(100)   :=  NULL;
                  LV_RETURN_MSG                            VARCHAR2(4000)  :=  NULL;
                BEGIN
                  PTOM_WEB_UTILITIES_PKG.GENERATE_DOC_SEQUENCE_NUMBER
                  (   I_DOCUMENT_CODE                       =>  'OMP0084_RMA_NUM_EXP'
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
            $user = getDefaultData('/om/rma-export');
            $user_id = $user->user_id;
            // Get order_type_id
            $orderType = PtomTransactionTypeAllV::from('PTOM_TRANSACTION_TYPES_ALL_V AS PTTAV')
                ->join('PTOM_PROFORMA_INVOICE_HEADERS AS PPIH','PTTAV.ORDER_TYPE_ID', 'PPIH.ORDER_TYPE_ID')
                ->where('PPIH.PICK_RELEASE_NO' , \request()->invoice['pick_release_no'])
                ->first();

            $header = new PtomClaimHeaders();

            $header->invoice_id = \request()->invoice['pi_header_id'];
            $header->invoice_date = \request()->invoice['pick_release_approve_date'] == null ? null: Carbon::createFromFormat('d/m/Y',\request()->invoice['pick_release_approve_date'])->format('Y-m-d');
            $header->customer_id = \request()->invoice['customer_id'];
            $header->source_system = \request()->invoice['source_system'];
            $header->remark_source_system = \request()->invoice['remark_source_system'];
            $header->ship_to_site_id = \request()->invoice['ship_to_site_id'];
            $header->symptom_description = \request()->symptom_description == null ? null:\request()->symptom_description;
            $header->program_code = 'OMP0084';
            $header->created_by = $user_id;
            $header->CREATED_BY_ID = $user_id;
            $header->UPDATED_BY_ID = $user_id;
            $header->creation_date = \request()->rma_date;
            $header->last_updated_by = $user_id;
            $header->last_update_date = \request()->rma_date;
            $header->rma_number = $result['doc_sequence_number'];
            $header->rma_date = \request()->rma_date;
            $header->status_rma = \request()->status_rma;
            $header->sales_type = 'EXPORT';
            $header->INTERFACED_MSG = $result['message'];
            $header->INTERFACE_STATUS = $result['status'];
            $header->REF_INVOICE_NUMBER = \request()->invoice['pick_release_no'];
            $header->RMA_ORDER_TYPE_ID = $orderType->rma_transaction_type_id;

            $header->save();

            // Get latest header_id
//            $lastHeader = PtomProformaInvoiceHeadres::select('claim_header_id','rma_number')->latest('claim_header_id')->first();
            $lastHeader = PtomClaimHeaders::latest('claim_header_id')->first();
//            dd(\request()->lines);

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
                    'program_code' => 'OMP0084',
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
            $result['status'] = "S";
            $result['message'] = "All process done !";

            return response()->json(['result' => $result]);
        } else  {
            $result['status'] = "E";
            $result['message'] = "Update PtomProformaInvoiceHeadres Fail..";

            return response()->json(['result' => $result]);
        }
    }

    public function confirmRma()
    {
//        $invoiceHeader = PtomProformaInvoiceHeadres::where('PICK_RELEASE_NO',\request()->orderHeader['pick_release_no'])->first();
//        $result = PtomOutstandingDebtExpV::where('PICK_RELEASE_NO', \request()->orderHeader['pick_release_no'])->get();
//        if ($result->first()) {
//            $sumPayment = PtomInvoiceLines::where('INVOICE_HEADERS_ID', $invoiceHeader->invoice_headers_id)
//                ->sum('payment_amount');
//            $outStanding = PtomOutstandingDebtExpV::where('PICK_RELEASE_NO', \request()->orderHeader['pick_release_no'])
//                ->sum('outstanding_debt');
//            if ($outStanding >= $sumPayment) {
//                // Create PTOM_PAYMENT_APPLY_CNDN Case 2
//                $cenario = 'Case 2';
//            } else {
//                // Create PTOM_PAYMENT_APPLY_CNDN Case 3
//                $cenario = 'Case 3';
//            }
//        } else {
//            // Create PTOM_PAYMENT_APPLY_CNDN Case 1
//            $sumPayment = 0;
//            $outStanding = 0;
//            $cenario = 'Case 1';
//        }
//        dd($sumPayment, $outStanding, $result,$cenario);
        //Params
        $claim_header_id = \request()->claimHeader['claim_header_id'];
        $rma_number = \request()->claimHeader['rma_number'];
        $result = [];

        // Get user id
        $user = getDefaultData('/om/rma-export');
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
                  (   I_DOCUMENT_CODE                       =>  'OMP0077_CN_NUM_EXP'
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
                // Parameter
                $pickReleaseNo = \request()->orderHeader['pick_release_no'];
                // Call package create CN success
                // Update cn_number to ptom_claim_headers
                $updateCn = PtomClaimHeaders::where('rma_number',$rma_number)->update(['CREDIT_NOTE_NUMBER' => $resultCn['doc_sequence_number']]);
                // Create CN Invoice header
                $header = new PtomInvoiceHeaders();
//                    $header->invoice_headers_number = $cn_number;
                $header->invoice_headers_number = $resultCn['doc_sequence_number'];
                $header->customer_id = \request()->claimHeader['customer_id'];
                $header->province_name = \request()->claimHeader['province_name'];
                $header->program_code = 'OMP0084';
                $header->invoice_type = 'CN_OTHER';
                $header->invoice_date = \request()->claimHeader['rma_date'] == null ? null: Carbon::createFromFormat('d/m/Y',\request()->claimHeader['rma_date'])->format('Y-m-d');
                // $header->invoice_date = parseFromDateTh(\request()->claimHeader['rma_date']);
                
                $header->invoice_amount = 0;
                $header->delivery_date = \request()->orderHeader['delivery_date'];
                $header->invoice_status = 'Confirm';
                $header->term_id = \request()->orderHeader['term_id'];
                $header->document_number = \request()->claimHeader['rma_number'];
                $header->currency = \request()->orderHeader['currency'];
                $header->creation_date = Carbon::today();
                $header->created_at = Carbon::now();
                $header->updated_at = Carbon::now();
                $header->created_by_id = $user_id;
                $header->created_by = $user_id;
                $header->LAST_UPDATED_BY = $user_id;
                $header->ref_invoice_number = \request()->orderHeader['pick_release_no'];

                $header->save();

                // Get latest header_id
                $lastHeader = PtomInvoiceHeaders::select('INVOICE_HEADERS_ID')->latest('INVOICE_HEADERS_ID')->first();
                $invoice_amount = 0;
                $documentId = 0;

                // Create CN Invoice Lines
                foreach (\request()->claimLines as $line) {
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
                        'program_code' => 'OMP0084',
                        'created_by' => $user_id,
                        'created_by_id' => $user_id,
                        'last_updated_by' => $user_id,
                        'creation_date' => Carbon::today()->format('Y-m-d'),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                        'ref_invoice_number' => \request()->orderHeader['pick_release_no'],
                    );
                    $invoice_amount = $invoice_amount + ((int)$line['rma_quantity'] * (int)$line['unit_price']);
                    $documentId = (int)$line['claim_header_id'];
                    PtomInvoiceLines::insert($invoiceLine);
                }

                // Update invoice amount
                $updateAmount = PtomInvoiceHeaders::where('INVOICE_HEADERS_ID',$lastHeader->invoice_headers_id)
                    ->update(['INVOICE_AMOUNT' => $invoice_amount]);

                // Create PTOM_PAYMENT_APPLY_CNDN
                $invoiceHeader = PtomProformaInvoiceHeadres::where('PICK_RELEASE_NO',\request()->orderHeader['pick_release_no'])->first();
                $result = PtomOutstandingDebtExpV::where('PICK_RELEASE_NO', \request()->orderHeader['pick_release_no'])->get();
                if ($result->first()) {
                    $sumPayment = PtomInvoiceLines::where('INVOICE_HEADERS_ID', $invoiceHeader->invoice_headers_id)
                        ->sum('payment_amount');
                    $outStanding = PtomOutstandingDebtExpV::where('PICK_RELEASE_NO', \request()->orderHeader['pick_release_no'])
                        ->sum('outstanding_debt');
                    if ($outStanding >= $sumPayment) {
                        // Create PTOM_PAYMENT_APPLY_CNDN Case 2
                        $data = [
                            'order_header_id' => \request()->orderHeader['pi_header_id']
                            , 'pick_release_no' => \request()->orderHeader['pick_release_no']
                            , 'invoice_number' => $resultCn['doc_sequence_number']
                            , 'invoice_header_id' => $lastHeader->invoice_headers_id
                            , 'invoice_amount' => $invoice_amount
                            , 'attribute1' => 'Y'
                            , 'attribute2' => 'CN_OTHER'
                            , 'program_code' => 'OMP0084'
                            , 'creation_date' => Carbon::today()
                            , 'created_at' => Carbon::now()
                            , 'updated_at' => Carbon::now()
                            , 'created_by_id' => $user_id
                            , 'updated_by_id' => $user_id
                            , 'created_by' => $user_id
                            , 'LAST_UPDATED_BY' => $user_id
                        ];

                        PtomPaymentApplyCndn::insert($data);
                    } else {
                        // Create PTOM_PAYMENT_APPLY_CNDN Case 3
                        $data = [
                            [
                                'order_header_id' => \request()->orderHeader['pi_header_id']
                                , 'pick_release_no' => \request()->orderHeader['pick_release_no']
                                , 'invoice_number' => $resultCn['doc_sequence_number']
                                , 'invoice_header_id' => $lastHeader->invoice_headers_id
                                , 'invoice_amount' => $invoice_amount
                                , 'attribute1' => 'Y'
                                , 'attribute2' => 'CN_OTHER'
                                , 'program_code' => 'OMP0084'
                                , 'creation_date' => Carbon::today()
                                , 'created_at' => Carbon::now()
                                , 'updated_at' => Carbon::now()
                                , 'created_by_id' => $user_id
                                , 'updated_by_id' => $user_id
                                , 'created_by' => $user_id
                                , 'LAST_UPDATED_BY' => $user_id
                            ],
                            [
                                'order_header_id' => null
                                , 'pick_release_no' => null
                                , 'invoice_number' => $resultCn['doc_sequence_number']
                                , 'invoice_header_id' => $lastHeader->invoice_headers_id
                                , 'invoice_amount' => $invoice_amount
                                , 'attribute1' => null
                                , 'attribute2' => 'CN_OTHER'
                                , 'program_code' => 'OMP0084'
                                , 'creation_date' => Carbon::today()
                                , 'created_at' => Carbon::now()
                                , 'updated_at' => Carbon::now()
                                , 'created_by_id' => $user_id
                                , 'updated_by_id' => $user_id
                                , 'created_by' => $user_id
                                , 'LAST_UPDATED_BY' => $user_id
                            ]
                        ];

                        PtomPaymentApplyCndn::insert($data);
                    }
                } else {
                    // Create PTOM_PAYMENT_APPLY_CNDN Case 1
                    $data = [
                        'order_header_id' => null
                        , 'pick_release_no' => null
                        , 'invoice_number' => $resultCn['doc_sequence_number']
                        , 'invoice_header_id' => $lastHeader->invoice_headers_id
                        , 'invoice_amount' => $invoice_amount
                        , 'attribute1' => null
                        , 'attribute2' => 'CN_OTHER'
                        , 'program_code' => 'OMP0084'
                        , 'creation_date' => Carbon::today()
                        , 'created_at' => Carbon::now()
                        , 'updated_at' => Carbon::now()
                        , 'created_by_id' => $user_id
                        , 'updated_by_id' => $user_id
                        , 'created_by' => $user_id
                        , 'LAST_UPDATED_BY' => $user_id
                    ];

                    PtomPaymentApplyCndn::insert($data);
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
        $user = getDefaultData('/om/rma-export');
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
                if ($orderTwms->oaom_wms6_inven == null || $orderTwms->oaom_wms6_inven != "Y") {

                    // Update PTOM_ORDER_T_WMS
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





    /////////////////////////////////////////////////
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
