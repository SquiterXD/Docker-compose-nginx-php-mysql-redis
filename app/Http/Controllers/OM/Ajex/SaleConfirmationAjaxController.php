<?php

namespace App\Http\Controllers\OM\Ajex;

use App\Http\Controllers\Controller;
use App\Models\OM\Api\OrderStatusHistory;
use App\Models\OM\AttachFiles;
use App\Models\OM\Customers;
use App\Models\OM\Customers\Domestics\Customer;
use App\Models\OM\Customers\Domestics\CustomerShipSites;
use App\Models\OM\Customers\Domestics\OrderCreditGroup;
use App\Models\OM\OverdueDebt\PaymentApplyCNDN;
use App\Models\OM\OverdueDebt\PaymentMatchInvoices;
use App\Models\OM\OrderHeaders;
use App\Models\OM\SaleConfirmation\OrderLines;
use App\Models\OM\SaleConfirmation\Currencies;
use App\Models\OM\SaleConfirmation\ItemWeights;
use App\Models\OM\SaleConfirmation\OrderHistory;
use App\Models\OM\SaleConfirmation\Period;
use App\Models\OM\SaleConfirmation\ProformaInvoiceHeaders;
use App\Models\OM\SaleConfirmation\ProformaInvoiceLines;
use App\Models\OM\SaleConfirmation\Terms;
use App\Models\OM\SaleConfirmation\ShipSites;
use App\Models\OM\SaleConfirmation\TaxCode;
use App\Models\OM\SaleConfirmation\TransactionTypes;
use App\Repositories\OM\AttachmentRepo;
use App\Repositories\OM\CreditAndQuotaRepo;
use App\Repositories\OM\GenerateNumberRepo;
use App\Repositories\OM\OrderRepo;
use App\Repositories\OM\DirectDebitRepo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleConfirmationAjaxController extends Controller
{
    public function updateSaleConfirmation(Request $request)
    {
        $rest = [];
        $attachmentFile = [];
        $resultWeight           = [];
        $resultTotalNet         = 0.00;
        $resultTotalGross       = 0.00;
        $resultSubTotal         = 0.00;
        $resultTax              = 0.00;
        $resultTotal            = 0.00;
        $resultAmount           = 0.00;
        $orderHeaderID          = '';

        // echo '<pre>';
        // print_r($request->all());
        // echo '<pre>';
        // exit();

        if(!empty($request->order_header_id)){

            $orderHeaderID = $request->order_header_id;

            // วันที่
            if(!empty($request->sa_date)){
                $dateArr    = explode('/', $request->sa_date);
                $day        = $dateArr[0];
                $month      = $dateArr[1];
                $year       = $dateArr[2];
                $newDate    = $month.'/'.$day.'/'.$year;

                $saTime = strtotime($newDate);
                $saDate = date('Y-m-d H:i:s',$saTime);
            }else{
                $saDate = '';
            }

            // วันที่สั่งซื้อ
            if(!empty($request->order_date)){
                $dateArr    = explode('/', $request->order_date);
                $day        = $dateArr[0];
                $month      = $dateArr[1];
                $year       = $dateArr[2];
                $newDate    = $month.'/'.$day.'/'.$year;

                $orderTime = strtotime($newDate);
                $orderDate = date('Y-m-d H:i:s',$orderTime);
            }else{
                $orderDate = '';
            }

            // วันที่ขออนุมัติ
            if(!empty($request->sale_confirm_date)){
                $dateArr    = explode('/', $request->sale_confirm_date);
                $day        = $dateArr[0];
                $month      = $dateArr[1];
                $year       = $dateArr[2];
                $newDate    = $month.'/'.$day.'/'.$year;

                $saleConfirmTime = strtotime($newDate);
                $saleConfirmDate = date('Y-m-d H:i:s',$saleConfirmTime);
            }else{
                $saleConfirmDate = '';
            }

            if (!empty($request->order_type_id)) {
                $productType        = TransactionTypes::where('order_type_id', $request->order_type_id)->pluck('product_type')->first();
                $product_type_code  = DB::table('oaom.ptom_product_type_export')->where('description', $productType)->pluck('lookup_code')->first();
            }

            if (empty($request->prepare_order_number)) {
                $newSaNumber = GenerateNumberRepo::generateSaleConfirmation('OMP0064_SA_NUM_EXP');
            }else{
                $newSaNumber = $request->prepare_order_number;
            }

            // echo '<pre>';
            // print_r($update);
            // echo '<pre>';
            // exit();

            if ($request->sa_status != 'Confirm') {
                $update = [
                    'prepare_order_number'      => $newSaNumber,
                    'sa_date'                   => $saDate,
                    'order_date'                => $orderDate,
                    'cust_po_number'            => $request->cust_po_number,
                    'order_type_id'             => !empty($request->order_type_id) ? $request->order_type_id : 0,
                    'product_type_code'         => !empty($product_type_code) ? $product_type_code : '',
                    'currency'                  => $request->currency,
                    'term_id'                   => !empty($request->term_id) ? $request->term_id : 0,
                    'payment_type_code'         => $request->payment_type_code,
                    'vat_code'                  => $request->vat_code,
                    'payment_method_code'       => $request->payment_method_code,
                    'remark'                    => $request->remark,
                    'bill_to_site_id'           => $request->bill_to_site_id,
                    'price_list_id'             => $request->price_list_id,
                    'ship_to_site_id'           => $request->ship_to_site_id,
                    'incoterms_code'            => $request->incoterms_code,
                    'port_of_loading'           => $request->port_of_loading,
                    'transport_type_code'       => $request->transport_type_code,
                    'transport_detail'          => $request->transport_detail,
                    'port_of_discharge'         => $request->port_of_discharge,
                    'shipping_marks'            => $request->shipping_marks,
                    'source_system'             => $request->source_system,
                    'shipment_condition'        => $request->shipment_condition,
                    'sale_confirm_by'           => $request->sale_confirm_by,
                    'sale_confirm_date'         => $saleConfirmDate,
                    'sale_confirm_document_no'  => $request->sale_confirm_document_no,
                    'sale_confirm_flag'         => $request->sale_confirm_flag,
                    'sa_status'                 => 'Draft',
                    'sub_total'                 => $request->order_sub_total,
                    'tax'                       => $request->order_tax,
                    'grand_total'               => $request->order_total,
                    'updated_by_id'             => optional(auth()->user())->user_id,
                    'updated_at'                => date('Y-m-d H:i:s'),
                    'last_updated_by'           => optional(auth()->user())->user_id,
                    'last_update_date'          => date('Y-m-d H:i:s')
                ];

                OrderHeaders::where('order_header_id', $request->order_header_id)->update($update);
            }

            if($request->hasFile('attachment')) {
                $fileAttachment = $request->file('attachment');
                AttachmentRepo::uploadAttachmentMultiple($fileAttachment,$request->order_header_id,'OMP0066');
            }

            $lineNumber = 1;

            $dataOrderLines = OrderLines::where('order_header_id', $request->order_header_id)->whereNull('deleted_at')->get();

            // echo '<pre>';
            // print_r($dataOrderLines);
            // echo '<pre>';
            // exit();

            if (!empty($request->sub_vat)) {
                foreach ($request->sub_vat as $key => $valueLine) {

                    foreach ($dataOrderLines as $keyLine => $lineDelete) {
                        if ($lineDelete->order_line_id == $key) {
                            unset($dataOrderLines[$keyLine]);
                        }
                    }

                    // ORDER QUANTITY
                    if (!empty($request->order_quantity[$key])) {
                        $orderQuantity = str_replace(',', '', $request->order_quantity[$key]);
                    }else{
                        $orderQuantity        = 0.00;
                    }

                    // UNIT PRICE
                    if (!empty($request->unit_price[$key])) {
                        $unitPrice = str_replace(',', '', $request->unit_price[$key]);
                    }else{
                        $unitPrice        = 0.00;
                    }

                    // AMOUNT
                    if (!empty($request->amount[$key])) {
                        $amount = str_replace(',', '', $request->amount[$key]);
                    }else{
                        $amount        = 0.00;
                    }

                    // TAX AMOUNT
                    if (!empty($request->tax_amount[$key])) {
                        $taxAmount = str_replace(',', '', $request->tax_amount[$key]);
                    }else{
                        $taxAmount        = 0.00;
                    }

                    // Total AMOUNT
                    if (!empty($request->total_amount[$key])) {
                        $totalAmount = str_replace(',', '', $request->total_amount[$key]);
                    }else{
                        $totalAmount        = 0.00;
                    }

                    // Net Weight
                    if (!empty($request->net[$key])) {
                        $net    = str_replace(',', '', $request->net[$key]);
                    }else{
                        $net    = 0.00;
                    }

                    // Gross Weight
                    if (!empty($request->gross[$key])) {
                        $gross  = str_replace(',', '', $request->gross[$key]);
                    }else{
                        $gross  = 0.00;
                    }

                    // Total NET WEIGHT
                    if (!empty($request->total_net_weight[$key])) {
                        $totalNetWeight = str_replace(',', '', $request->total_net_weight[$key]);
                    }else{
                        $totalNetWeight        = 0.00;
                    }

                    // Total NET GROSS
                    if (!empty($request->total_net_gross[$key])) {
                        $totalNetGross = str_replace(',', '', $request->total_net_gross[$key]);
                    }else{
                        $totalNetGross        = 0.00;
                    }

                    $checkDataLine = OrderLines::where('order_line_id', $key)->where('order_header_id', $request->order_header_id)->first();

                    if (!empty($checkDataLine)) {
                        $updateLine = [
                            'order_line_id'         => $key,
                            'line_number'           => $lineNumber,
                            'order_quantity'        => $orderQuantity,
                            'approve_quantity'      => $orderQuantity,
                            'item_description'      => $request->item_description[$key],
                            'unit_price'            => $unitPrice,
                            'amount'                => $amount,
                            'uom_code'              => $request->uom_code[$key],
                            'uom'                   => $request->uom[$key],
                            'vat_code'              => $valueLine,
                            'tax_amount'            => $taxAmount,
                            'total_amount'          => $totalAmount,
                            'weight_id'             => $request->weight_id[$key],
                            'weight_unit_net'       => $net,
                            'weight_unit_gross'     => $gross,
                            'total_net_weight'      => $totalNetWeight,
                            'total_net_gross'       => $totalNetGross,
                            'promo_flag'            => $unitPrice <= 0 ? 'Y' : null,
                            'updated_by_id'         => optional(auth()->user())->user_id,
                            'updated_at'            => date('Y-m-d H:i:s'),
                            'last_updated_by'       => optional(auth()->user())->user_id,
                            'last_update_date'      => date('Y-m-d H:i:s')
                        ];

                        OrderLines::where('order_line_id', $key)->update($updateLine);

                    }else{
                        $insertLine = [
                            'order_header_id'       => $request->order_header_id,
                            'line_number'           => $lineNumber,
                            'item_id'               => $request->item_id[$key],
                            'item_code'             => $request->item_code[$key],
                            'item_description'      => $request->item_description[$key],
                            'uom_code'              => $request->uom_code[$key],
                            'uom'                   => $request->uom[$key],
                            'order_quantity'        => $orderQuantity,
                            'approve_quantity'      => $orderQuantity,
                            'unit_price'            => $unitPrice,
                            'amount'                => $amount,
                            'vat_code'              => $valueLine,
                            'tax_amount'            => $taxAmount,
                            'total_amount'          => $totalAmount,
                            'weight_id'             => $request->weight_id[$key],
                            'weight_unit_net'       => $net,
                            'weight_unit_gross'     => $gross,
                            'total_net_weight'      => $totalNetWeight,
                            'total_net_gross'       => $totalNetGross,
                            'promo_flag'            => $unitPrice <= 0 ? 'Y' : null,
                            'program_code'          => 'OMP0066',
                            'created_by'            => optional(auth()->user())->user_id,
                            'created_at'            => date('Y-m-d'),
                            'creation_date'         => date('Y-m-d'),
                            'updated_by_id'         => optional(auth()->user())->user_id,
                            'updated_at'            => date('Y-m-d'),
                            'last_updated_by'       => optional(auth()->user())->user_id,
                            'last_update_date'      => date('Y-m-d')
                        ];

                        OrderLines::insert($insertLine);
                    }

                    $lineNumber++;

                    // echo '<pre>';
                    // print_r($updateLine);
                    // echo '<pre>';
                    // exit();
                }
            }

            if (!empty($dataOrderLines)) {
                foreach ($dataOrderLines as $key => $value) {
                    OrderLines::where('order_line_id', $value->order_line_id)->delete();
                }
            }

            // echo '<pre>';
            // print_r($dataOrderLines);
            // echo '<pre>';
            // exit();

            $attachmentFile = AttachFiles::where('attachment_program_code','OMP0066')->where('header_id', $request->order_header_id)->whereNull('deleted_at')->get();

            $getOrderHeader =  OrderHeaders::where('order_header_id', $request->order_header_id)->first();
            // OrderRepo::insertOrdersHistoryv2($getOrderHeader, 'Draft');

            // Reload Data

            $orderSelect = [
                'ptom_order_headers.prepare_order_number',
                'ptom_order_headers.order_number',
                'ptom_order_headers.order_date',
                'ptom_order_headers.sa_status',
                'ptom_order_headers.sa_date',
                'ptom_order_headers.order_status',
                'ptom_order_headers.customer_id',
                'ptom_order_headers.cust_po_number',
                'ptom_customers.customer_number',
                'ptom_customers.customer_name'
            ];

            $saList = OrderHeaders::join('ptom_customers', 'ptom_order_headers.customer_id', '=', 'ptom_customers.customer_id')
                                        ->select($orderSelect)
                                        ->where('ptom_customers.sales_classification_code', 'Export')
                                        // ->where('ptom_order_headers.order_status', 'Draft')
                                        // ->whereNotNull('ptom_order_headers.prepare_order_number')
                                        // ->whereNotNull('ptom_order_headers.order_number')
                                        ->orderBy('ptom_order_headers.prepare_order_number', 'desc')
                                        ->whereNull('ptom_order_headers.deleted_at')
                                        ->groupBy($orderSelect)
                                        ->get();

            foreach ($saList as $key => $value) {
                if ($value->sa_status == '') {
                    $saList[$key]->sa_status    = 'Draft';
                }

                $saList[$key]->sa_date      = !empty($value->sa_date) ? dateFormatDMYDefault(date('m/d/Y',strtotime($value->sa_date))) : $value->sa_date;
                $saList[$key]->order_date   = !empty($value->order_date) ? dateFormatDMYDefault(date('m/d/Y',strtotime($value->order_date))) : $value->order_date;
            }

            $getOrderLines = OrderLines::where('order_header_id', $request->order_header_id)->whereNull('deleted_at')->orderBy('item_code', 'asc')->get();

            // echo '<pre>';
            // print_r($getOrderLines);
            // echo '<pre>';
            // exit();

            $totalAmount = 0;

            if(!empty($getOrderLines)){

                foreach ($getOrderLines as $key => $value) {

                    $orderPiQuantity = ProformaInvoiceLines::where('ref_order_header_id', $request->order_header_id)->where('ref_order_line_id', $value->order_line_id)->whereNull('cancelled_flag')->sum('order_quantity');

                    // echo '<pre>';
                    // print_r($orderPiQuantity);
                    // echo '<pre>';
                    // exit();

                    $getItemWeight = ItemWeights::where('item_code', $value->item_code)
                                            ->where('active_flag', 'Y')
                                            // ->whereRaw("nvl(start_date,sysdate+1) < sysdate")
                                            ->whereRaw("nvl(end_date,sysdate+1) > sysdate")
                                            ->whereNull('deleted_at')->first();

                    $weight_id = !empty($getItemWeight->weight_id) ? $getItemWeight->weight_id : 0;
                    // $net_weight = !empty($getItemWeight->net_weight) ? $getItemWeight->net_weight : 0;
                    // $net_gross  = !empty($getItemWeight->net_gross) ? $getItemWeight->net_gross : 0;
                        $net_weight = !empty($value->weight_unit_net) ? $value->weight_unit_net : (!empty($getItemWeight->net_weight) ? $getItemWeight->net_weight : 0);
                        $net_gross  = !empty($value->weight_unit_gross) ? $value->weight_unit_gross : (!empty($getItemWeight->net_gross) ? $getItemWeight->net_gross : 0);

                    $approve_quantity   = !empty($value->order_quantity) ? number_format((float)$value->order_quantity, 2, '.', '') : 0.00;
                    $unit_price         = !empty($value->unit_price) ? number_format((float)$value->unit_price, 2, '.', '') : 0.00;
                    $totalNetWeight     = $value->order_quantity * $net_weight;
                    $totalNetGross      = $value->order_quantity * $net_gross;

                    $vatCode        = !empty($value->vat_code) ? $value->vat_code : $request->vat_code;
                    $getPercentage  = TaxCode::where('tax_rate_code', $vatCode)->pluck('percentage_rate')->first();
                    $taxAmount      = number_format((float)($approve_quantity * $unit_price) * $getPercentage / 100, 2, '.', '');

                    $total_amount       = !empty($value->total_amount) ? $value->total_amount : 0.00;
                    $lineAmount         = $total_amount + $taxAmount;

                    $orderLine[$key] = [
                        'order_line_id'         => $value->order_line_id,
                        'item_id'               => $value->item_id,
                        'item_code'             => $value->item_code,
                        'item_description'      => $value->item_description,
                        'uom_code'              => $value->uom_code,
                        'uom'                   => $value->uom,
                        'order_quantity'        => !empty($value->order_quantity) ? $value->order_quantity : 0,
                        'order_pi_quantity'     => $orderPiQuantity,
                        'unit_price'            => $value->unit_price,
                        'amount'                => !empty($value->amount) ? number_format((float)$value->amount, 2, '.', '') : 0.00,
                        'vat_code'              => $value->vat_code,
                        'tax_amount'            => $value->tax_amount,
                        'total_amount'          => $value->total_amount,
                        'weight_id'             => $weight_id,
                        'net_weight'            => $net_weight,
                        'net_gross'             => $net_gross,
                        'total_net_weight'      => number_format((float)$totalNetWeight, 2, '.', ''),
                        'total_net_gross'       => number_format((float)$totalNetGross, 2, '.', ''),
                    ];

                    $resultTotalNet     = $resultTotalNet + $totalNetWeight;
                    $resultTotalGross   = $resultTotalGross + $totalNetGross;
                    $resultSubTotal     = $resultSubTotal + $value->amount;
                    $resultTax          = $resultTax + $taxAmount;
                    $resultTotal        = $resultTotal + $value->total_amount + $taxAmount;
                    $totalAmount        = $totalAmount + $value->total_amount;
                }

                $resultWeight = [
                    'result_net_weight'     => number_format((float)$resultTotalNet, 2, '.', ''),
                    'result_gross_weight'   => number_format((float)$resultTotalGross, 2, '.', ''),
                    'result_sub_total'      => number_format((float)$resultSubTotal, 2, '.', ''),
                    'result_tax'            => number_format((float)$resultTax, 2, '.', ''),
                    'result_total'          => number_format((float)$resultTotal, 2, '.', ''),
                ];

                $matchInvoice = PaymentMatchInvoices::where('prepare_order_number', $newSaNumber)->where('match_flag', 'Y')->get();

                $paymentAmount = 0;

                if (!$matchInvoice->isEmpty()) {
                    foreach ($matchInvoice as $key => $invoice) {
                        $invoiceAmount = PaymentApplyCNDN::where('payment_match_id', $invoice->payment_match_id)->whereNull('deleted_at')->sum('invoice_amount');
                        $paymentAmount = ($paymentAmount + $invoice->payment_amount) + $invoiceAmount;
                    }
                }

                // ยอดคงค้าง
                $resultAmount = $totalAmount - $paymentAmount;
            }

            // END Relead Data

            $rest = [
                'orderLine'         => $orderLine,
                'newSaList'         => $saList,
                'saNumber'          => $newSaNumber,
                'orderHeaderID'     => $request->order_header_id,
                'status'            => 'success',
                'data'              => 'Success',
                'attachmentFile'    => $attachmentFile
            ];
        }else{

            // วันที่
            if(!empty($request->sa_date)){
                $dateArr    = explode('/', $request->sa_date);
                $day        = $dateArr[0];
                $month      = $dateArr[1];
                $year       = $dateArr[2];
                $newDate    = $month.'/'.$day.'/'.$year;

                $saTime = strtotime($newDate);
                $saDate = date('Y-m-d H:i:s',$saTime);
            }else{
                $saDate = '';
            }

            // วันที่สั่งซื้อ
            if(!empty($request->order_date)){
                $dateArr    = explode('/', $request->order_date);
                $day        = $dateArr[0];
                $month      = $dateArr[1];
                $year       = $dateArr[2];
                $newDate    = $month.'/'.$day.'/'.$year;

                $orderTime = strtotime($newDate);
                $orderDate = date('Y-m-d H:i:s',$orderTime);
            }else{
                $orderDate = '';
            }

            // วันที่เปลี่ยนแปลงสถานภาพ
            if(!empty($request->sale_confirm_date)){
                $dateArr    = explode('/', $request->sale_confirm_date);
                $day        = $dateArr[0];
                $month      = $dateArr[1];
                $year       = $dateArr[2];
                $newDate    = $month.'/'.$day.'/'.$year;

                $confirmTime  = strtotime($newDate);
                $confirmDate  = date('Y-m-d H:i:s',$confirmTime);
            }else{
                $confirmDate  = '';
            }

            if (!empty($request->order_type_id)) {
                $productType        = TransactionTypes::where('order_type_id', $request->order_type_id)->pluck('product_type')->first();
                $product_type_code  = DB::table('oaom.ptom_product_type_export')->where('description', $productType)->pluck('lookup_code')->first();
            }

            $periodLineID   = Period::whereRaw("nvl(start_period,sysdate+1) < sysdate")
                                    ->whereRaw("nvl(end_period,sysdate+1) > sysdate")
                                    ->pluck('period_line_id')->first();

            $periodLineID   = !empty($periodLineID) ? $periodLineID : 0;

            // GENERATE NUMBER
            $saNumber = GenerateNumberRepo::generateSaleConfirmation('OMP0064_SA_NUM_EXP');

            $orgId = DB::table('hr_organization_units_v')->select('organization_id')->where('name', 'การยาสูบแห่งประเทศไทย')->pluck('organization_id')->first();

            $insert = [
                'prepare_order_number'      => $saNumber,
                'sa_date'                   => $saDate,
                'order_number'              => $request->order_number,
                'order_date'                => $orderDate,
                'cust_po_number'            => $request->cust_po_number,
                'order_type_id'             => !empty($request->order_type_id) ? $request->order_type_id : 0,
                'product_type_code'         => !empty($product_type_code) ? $product_type_code : '',
                'currency'                  => $request->currency,
                'term_id'                   => !empty($request->term_id) ? $request->term_id : 0,
                'payment_type_code'         => $request->payment_type_code,
                'vat_code'                  => $request->vat_code,
                'payment_method_code'       => $request->payment_method_code,
                'remark'                    => $request->remark,
                'bill_to_site_id'           => $request->bill_to_site_id,
                'price_list_id'             => $request->price_list_id,
                'ship_to_site_id'           => $request->ship_to_site_id,
                'incoterms_code'            => $request->incoterms_code,
                'port_of_loading'           => $request->port_of_loading,
                'transport_type_code'       => $request->transport_type_code,
                'transport_detail'          => $request->transport_detail,
                'port_of_discharge'         => $request->port_of_discharge,
                'shipping_marks'            => $request->shipping_marks,
                'source_system'             => $request->source_system,
                'shipment_condition'        => $request->shipment_condition,
                'org_id'                    => !empty($orgId) ? $orgId : '',
                'order_source'              => 'WEB',
                'period_id'                 => $periodLineID,
                'order_status'              => 'Draft',
                'sa_status'                 => 'Draft',
                'sub_total'                 => $request->order_sub_total,
                'tax'                       => $request->order_tax,
                'grand_total'               => $request->order_total,
                'customer_id'               => $request->customer_id,
                'sale_confirm_date'         => $confirmDate,
                'sale_confirm_document_no'  => $request->sale_confirm_document_no,
                'sale_confirm_by'           => $request->sale_confirm_by,
                'sale_confirm_flag'         => $request->sale_confirm_flag,
                'program_code'              => 'OMP0066',
                'created_by'                => optional(auth()->user())->user_id,
                'created_at'                => date('Y-m-d'),
                'creation_date'             => date('Y-m-d'),
                'updated_by_id'             => optional(auth()->user())->user_id,
                'updated_at'                => date('Y-m-d'),
                'last_updated_by'           => optional(auth()->user())->user_id,
                'last_update_date'          => date('Y-m-d')
            ];

            // echo '<pre>';
            // print_r($insert);
            // echo '<pre>';
            // exit();

            OrderHeaders::insert($insert);

            $orderHeaderID  = OrderHeaders::select('order_header_id')->orderBy('order_header_id', 'DESC')->pluck('order_header_id')->first();

            $insert['order_header_id']  = $orderHeaderID;

            OrderHistory::insert($insert);

            if($request->hasFile('attachment')) {
                $fileAttachment = $request->file('attachment');
                AttachmentRepo::uploadAttachmentMultiple($fileAttachment,$orderHeaderID,'OMP0066');
            }

            if (!empty($request->sub_vat)) {
                foreach ($request->sub_vat as $key => $valueLine) {

                    // TAX AMOUNT
                    if (!empty($request->order_quantity[$key])) {
                        $orderQuantity = str_replace(',', '', $request->order_quantity[$key]);
                    }else{
                        $orderQuantity        = 0.00;
                    }

                    // UNIT PRICE
                    if (!empty($request->unit_price[$key])) {
                        $unitPrice = str_replace(',', '', $request->unit_price[$key]);
                    }else{
                        $unitPrice        = 0.00;
                    }

                    // Amount
                    if (!empty($request->amount[$key])) {
                        $amount = str_replace(',', '', $request->amount[$key]);
                    }else{
                        $amount        = 0.00;
                    }

                    // TAX AMOUNT
                    if (!empty($request->tax_amount[$key])) {
                        $taxAmount = str_replace(',', '', $request->tax_amount[$key]);
                    }else{
                        $taxAmount        = 0.00;
                    }

                    // Total AMOUNT
                    if (!empty($request->total_amount[$key])) {
                        $totalAmount = str_replace(',', '', $request->total_amount[$key]);
                    }else{
                        $totalAmount        = 0.00;
                    }

                    // Net Weight
                    if (!empty($request->net[$key])) {
                        $net    = str_replace(',', '', $request->net[$key]);
                    }else{
                        $net    = 0.00;
                    }

                    // Gross Weight
                    if (!empty($request->gross[$key])) {
                        $gross  = str_replace(',', '', $request->gross[$key]);
                    }else{
                        $gross  = 0.00;
                    }

                    // Total NET WEIGHT
                    if (!empty($request->total_net_weight[$key])) {
                        $totalNetWeight = str_replace(',', '', $request->total_net_weight[$key]);
                    }else{
                        $totalNetWeight        = 0.00;
                    }

                    // Total NET GROSS
                    if (!empty($request->total_net_gross[$key])) {
                        $totalNetGross = str_replace(',', '', $request->total_net_gross[$key]);
                    }else{
                        $totalNetGross        = 0.00;
                    }

                    $insertLine = [
                        'order_header_id'       => $orderHeaderID,
                        'line_number'           => $key+1,
                        'item_id'               => $request->item_id[$key],
                        'item_code'             => $request->item_code[$key],
                        'item_description'      => $request->item_description[$key],
                        'uom_code'              => $request->uom_code[$key],
                        'uom'                   => $request->uom[$key],
                        'order_quantity'        => $orderQuantity,
                        'approve_quantity'      => $orderQuantity,
                        'unit_price'            => $unitPrice,
                        'amount'                => $amount,
                        'vat_code'              => $valueLine,
                        'tax_amount'            => $taxAmount,
                        'total_amount'          => $totalAmount,
                        'weight_id'             => $request->weight_id[$key],
                        'weight_unit_net'       => $net,
                        'weight_unit_gross'     => $gross,
                        'total_net_weight'      => $totalNetWeight,
                        'total_net_gross'       => $totalNetGross,
                        'promo_flag'            => $unitPrice <= 0 ? 'Y' : null,
                        'program_code'          => 'OMP0066',
                        'created_by'            => optional(auth()->user())->user_id,
                        'created_at'            => date('Y-m-d'),
                        'creation_date'         => date('Y-m-d'),
                        'updated_by_id'         => optional(auth()->user())->user_id,
                        'updated_at'            => date('Y-m-d'),
                        'last_updated_by'       => optional(auth()->user())->user_id,
                        'last_update_date'      => date('Y-m-d')
                    ];

                    // echo '<pre>';
                    // print_r($insertLine);
                    // echo '<pre>';

                    OrderLines::insert($insertLine);
                }
            }

            $attachmentFile = AttachFiles::where('attachment_program_code','OMP0066')->where('header_id', $orderHeaderID)->whereNull('deleted_at')->get();

            $getOrderHeader =  OrderHeaders::where('order_header_id', $orderHeaderID)->first();
            OrderRepo::insertOrdersHistoryv2($getOrderHeader, 'Draft');

            // Reload Data

            $orderSelect = [
                'ptom_order_headers.prepare_order_number',
                'ptom_order_headers.order_number',
                'ptom_order_headers.order_date',
                'ptom_order_headers.sa_status',
                'ptom_order_headers.sa_date',
                'ptom_order_headers.order_status',
                'ptom_order_headers.customer_id',
                'ptom_order_headers.cust_po_number',
                'ptom_customers.customer_number',
                'ptom_customers.customer_name'
            ];
            $saList = OrderHeaders::join('ptom_customers', 'ptom_order_headers.customer_id', '=', 'ptom_customers.customer_id')
                                        ->select($orderSelect)
                                        ->where('ptom_customers.sales_classification_code', 'Export')
                                        // ->where('ptom_order_headers.order_status', 'Draft')
                                        // ->whereNotNull('ptom_order_headers.prepare_order_number')
                                        // ->whereNotNull('ptom_order_headers.order_number')
                                        ->orderBy('ptom_order_headers.prepare_order_number', 'desc')
                                        ->whereNull('ptom_order_headers.deleted_at')
                                        ->groupBy($orderSelect)
                                        ->get();

            foreach ($saList as $key => $value) {
                if ($value->sa_status == '') {
                    $saList[$key]->sa_status    = 'Draft';
                }

                $saList[$key]->sa_date      = !empty($value->sa_date) ? dateFormatDMYDefault(date('m/d/Y',strtotime($value->sa_date))) : $value->sa_date;
                $saList[$key]->order_date   = !empty($value->order_date) ? dateFormatDMYDefault(date('m/d/Y',strtotime($value->order_date))) : $value->order_date;
            }

            $getOrderHeadersQuery = OrderHeaders::where('prepare_order_number', $saNumber)->whereNull('deleted_at')->first();

            $getOrderLines = OrderLines::where('order_header_id', $getOrderHeadersQuery->order_header_id)->whereNull('deleted_at')->get();

            // echo '<pre>';
            // print_r($getOrderLines);
            // echo '<pre>';
            // exit();

            $totalAmount = 0;

            if(!empty($getOrderLines)){

                foreach ($getOrderLines as $key => $value) {

                    $orderPiQuantity = ProformaInvoiceLines::where('ref_order_header_id', $getOrderHeadersQuery->order_header_id)->where('ref_order_line_id', $value->order_line_id)->where('cancelled_flag', '!=', 'Y')->sum('order_quantity');

                    // echo '<pre>';
                    // print_r($orderPiQuantity);
                    // echo '<pre>';
                    // exit();

                    $getItemWeight = ItemWeights::where('item_code', $value->item_code)
                                            ->where('active_flag', 'Y')
                                            // ->whereRaw("nvl(start_date,sysdate+1) < sysdate")
                                            ->whereRaw("nvl(end_date,sysdate+1) > sysdate")
                                            ->whereNull('deleted_at')->first();

                    $weight_id = !empty($getItemWeight->weight_id) ? $getItemWeight->weight_id : 0;
                    // $net_weight = !empty($getItemWeight->net_weight) ? $getItemWeight->net_weight : 0;
                    // $net_gross  = !empty($getItemWeight->net_gross) ? $getItemWeight->net_gross : 0;
                        $net_weight = !empty($value->weight_unit_net) ? $value->weight_unit_net : (!empty($getItemWeight->net_weight) ? $getItemWeight->net_weight : 0);
                        $net_gross  = !empty($value->weight_unit_gross) ? $value->weight_unit_gross : (!empty($getItemWeight->net_gross) ? $getItemWeight->net_gross : 0);

                    $approve_quantity   = !empty($value->order_quantity) ? number_format((float)$value->order_quantity, 2, '.', '') : 0.00;
                    $unit_price         = !empty($value->unit_price) ? number_format((float)$value->unit_price, 2, '.', '') : 0.00;
                    $totalNetWeight     = $value->order_quantity * $net_weight;
                    $totalNetGross      = $value->order_quantity * $net_gross;

                    $vatCode        = !empty($value->vat_code) ? $value->vat_code : $getOrderHeadersQuery->vat_code;
                    $getPercentage  = TaxCode::where('tax_rate_code', $vatCode)->pluck('percentage_rate')->first();
                    $taxAmount      = number_format((float)($approve_quantity * $unit_price) * $getPercentage / 100, 2, '.', '');

                    $total_amount       = !empty($value->total_amount) ? $value->total_amount : 0.00;
                    $lineAmount         = $total_amount + $taxAmount;

                    $orderLine[$key] = [
                        'order_line_id'         => $value->order_line_id,
                        'item_id'               => $value->item_id,
                        'item_code'             => $value->item_code,
                        'item_description'      => $value->item_description,
                        'uom_code'              => $value->uom_code,
                        'uom'                   => $value->uom,
                        'order_quantity'        => !empty($value->order_quantity) ? $value->order_quantity : 0,
                        'order_pi_quantity'     => $orderPiQuantity,
                        'unit_price'            => $value->unit_price,
                        'amount'                => !empty($value->amount) ? number_format((float)$value->amount, 2, '.', '') : 0.00,
                        'vat_code'              => $value->vat_code,
                        'tax_amount'            => $value->tax_amount,
                        'total_amount'          => $value->total_amount,
                        'weight_id'             => $weight_id,
                        'net_weight'            => $net_weight,
                        'net_gross'             => $net_gross,
                        'total_net_weight'      => number_format((float)$totalNetWeight, 2, '.', ''),
                        'total_net_gross'       => number_format((float)$totalNetGross, 2, '.', ''),
                    ];

                    $resultTotalNet     = $resultTotalNet + $totalNetWeight;
                    $resultTotalGross   = $resultTotalGross + $totalNetGross;
                    $resultSubTotal     = $resultSubTotal + $value->amount;
                    $resultTax          = $resultTax + $taxAmount;
                    $resultTotal        = $resultTotal + $value->total_amount + $taxAmount;
                    $totalAmount        = $totalAmount + $value->total_amount;
                }

                $resultWeight = [
                    'result_net_weight'     => number_format((float)$resultTotalNet, 2, '.', ''),
                    'result_gross_weight'   => number_format((float)$resultTotalGross, 2, '.', ''),
                    'result_sub_total'      => number_format((float)$resultSubTotal, 2, '.', ''),
                    'result_tax'            => number_format((float)$resultTax, 2, '.', ''),
                    'result_total'          => number_format((float)$resultTotal, 2, '.', ''),
                ];

                $matchInvoice = PaymentMatchInvoices::where('prepare_order_number', $saNumber)->where('match_flag', 'Y')->get();

                $paymentAmount = 0;

                if (!$matchInvoice->isEmpty()) {
                    foreach ($matchInvoice as $key => $invoice) {
                        $invoiceAmount = PaymentApplyCNDN::where('payment_match_id', $invoice->payment_match_id)->whereNull('deleted_at')->sum('invoice_amount');
                        $paymentAmount = ($paymentAmount + $invoice->payment_amount) + $invoiceAmount;
                    }
                }

                // ยอดคงค้าง
                $resultAmount = $totalAmount - $paymentAmount;
            }

            // END Relead Data

            $rest = [
                'orderLine'         => $orderLine,
                'newSaList'         => $saList,
                'saNumber'          => $saNumber,
                'orderHeaderID'     => $orderHeaderID,
                'status'            => 'success',
                'data'              => 'Success',
                'attachmentFile'    => $attachmentFile
            ];
        }

        return response()->json(['data' => $rest]);
    }

    public function confirmSaleConfirmation(Request $request)
    {
        $rest = [];
        $attachmentFile = [];
        $resultWeight           = [];
        $resultTotalNet         = 0.00;
        $resultTotalGross       = 0.00;
        $resultSubTotal         = 0.00;
        $resultTax              = 0.00;
        $resultTotal            = 0.00;
        $resultAmount           = 0.00;
        $orderHeaderID          = '';

        // echo '<pre>';
        // print_r($request->all());
        // echo '<pre>';
        // exit();

        if(!empty($request->order_header_id)){

            $orderHeaderID = $request->order_header_id;

            // วันที่
            if(!empty($request->sa_date)){
                $dateArr    = explode('/', $request->sa_date);
                $day        = $dateArr[0];
                $month      = $dateArr[1];
                $year       = $dateArr[2];
                $newDate    = $month.'/'.$day.'/'.$year;

                $saTime = strtotime($newDate);
                $saDate = date('Y-m-d H:i:s',$saTime);
            }else{
                $saDate = '';
            }

            // วันที่สั่งซื้อ
            if(!empty($request->order_date)){
                $dateArr    = explode('/', $request->order_date);
                $day        = $dateArr[0];
                $month      = $dateArr[1];
                $year       = $dateArr[2];
                $newDate    = $month.'/'.$day.'/'.$year;

                $orderTime = strtotime($newDate);
                $orderDate = date('Y-m-d H:i:s',$orderTime);
            }else{
                $orderDate = '';
            }

            // วันที่ขออนุมัติ
            if(!empty($request->sale_confirm_date)){
                $dateArr    = explode('/', $request->sale_confirm_date);
                $day        = $dateArr[0];
                $month      = $dateArr[1];
                $year       = $dateArr[2];
                $newDate    = $month.'/'.$day.'/'.$year;

                $confirmTime  = strtotime($newDate);
                $confirmDate  = date('Y-m-d H:i:s',$confirmTime);
            }else{
                $confirmDate  = '';
            }

            if (!empty($request->order_type_id)) {
                $productType        = TransactionTypes::where('order_type_id', $request->order_type_id)->pluck('product_type')->first();
                $product_type_code  = DB::table('oaom.ptom_product_type_export')->where('description', $productType)->pluck('lookup_code')->first();
            }

            $checkOrderStatus = $request->payment_type_code == 10 ? 'Wait Pay' : 'Invoice';

            if (empty($request->prepare_order_number)) {
                // GENERATE NUMBER
                $saNumber = GenerateNumberRepo::generateSaleConfirmation('OMP0064_SA_NUM_EXP');
            }else{
                $saNumber = $request->prepare_order_number;
            }

            $update = [
                'prepare_order_number'      => $saNumber,
                'sa_date'                   => $saDate,
                'order_date'                => $orderDate,
                'cust_po_number'            => $request->cust_po_number,
                'order_type_id'             => !empty($request->order_type_id) ? $request->order_type_id : 0,
                'product_type_code'         => !empty($product_type_code) ? $product_type_code : '',
                'currency'                  => $request->currency,
                'term_id'                   => !empty($request->term_id) ? $request->term_id : 0,
                'payment_type_code'         => $request->payment_type_code,
                'vat_code'                  => $request->vat_code,
                'payment_method_code'       => $request->payment_method_code,
                'remark'                    => $request->remark,
                'bill_to_site_id'           => $request->bill_to_site_id,
                'price_list_id'             => $request->price_list_id,
                'ship_to_site_id'           => $request->ship_to_site_id,
                'incoterms_code'            => $request->incoterms_code,
                'port_of_loading'           => $request->port_of_loading,
                'transport_type_code'       => $request->transport_type_code,
                'transport_detail'          => $request->transport_detail,
                'port_of_discharge'         => $request->port_of_discharge,
                'shipping_marks'            => $request->shipping_marks,
                'source_system'             => $request->source_system,
                'shipment_condition'        => $request->shipment_condition,
                'sa_status'                 => 'Confirm',
                'sale_confirm_date'         => $confirmDate,
                'sale_confirm_document_no'  => $request->sale_confirm_document_no,
                'sale_confirm_by'           => $request->sale_confirm_by,
                'sale_confirm_flag'         => $request->sale_confirm_flag,
                'sub_total'                 => $request->order_sub_total,
                'tax'                       => $request->order_tax,
                'grand_total'               => $request->order_total,
                'updated_by_id'             => optional(auth()->user())->user_id,
                'updated_at'                => date('Y-m-d H:i:s'),
                'last_updated_by'           => optional(auth()->user())->user_id,
                'last_update_date'          => date('Y-m-d H:i:s'),
            ];

            // echo '<pre>';
            // print_r($update);
            // echo '<pre>';
            // exit();

            OrderHeaders::where('order_header_id', $request->order_header_id)->update($update);

            $checkCreditGroup   =  DB::table('ptom_order_credit_groups')->where('order_header_id',$request->order_header_id)->where('order_line_id',0)->where('credit_group_code',0)->first();

            $getOrderHeader = OrderHeaders::where('order_header_id', $request->order_header_id)->first();

            if (!empty($checkCreditGroup)) {
                DB::table('ptom_order_credit_groups')
                    ->where('order_header_id',$request->order_header_id)
                    ->where('order_line_id',0)
                    ->where('credit_group_code',0)
                    ->update(array(
                        'amount'=> $request->order_total
                    ));
            }else{

                $orderCredit    = OrderCreditGroup::where('order_header_id',$request->order_header_id)->where('order_line_id',0)->where('credit_group_code',0)->first();

                CreditAndQuotaRepo::setOrderCash($orderCredit,$getOrderHeader, $request->order_total, 'OMP0066');
            }

            // $update['order_status']  = $checkOrderStatus;

            OrderRepo::insertOrdersHistoryv2($getOrderHeader, $checkOrderStatus);

            // OrderHistory::where('order_header_id', $request->order_header_id)->update($update);

            if($request->hasFile('attachment')) {
                $fileAttachment = $request->file('attachment');
                AttachmentRepo::uploadAttachmentMultiple($fileAttachment,$request->order_header_id,'OMP0066');
            }


            $lineNumber = 1;

            $dataOrderLines = OrderLines::where('order_header_id', $request->order_header_id)->whereNull('deleted_at')->get();

            // echo '<pre>';
            // print_r($dataOrderLines);
            // echo '<pre>';
            // exit();

            if (!empty($request->sub_vat)) {
                foreach ($request->sub_vat as $key => $valueLine) {

                    foreach ($dataOrderLines as $keyLine => $lineDelete) {
                        if ($lineDelete->order_line_id == $key) {
                            unset($dataOrderLines[$keyLine]);
                        }
                    }

                    // ORDER QUANTITY
                    if (!empty($request->order_quantity[$key])) {
                        $orderQuantity = str_replace(',', '', $request->order_quantity[$key]);
                    }else{
                        $orderQuantity        = 0.00;
                    }

                    // UNIT PRICE
                    if (!empty($request->unit_price[$key])) {
                        $unitPrice = str_replace(',', '', $request->unit_price[$key]);
                    }else{
                        $unitPrice        = 0.00;
                    }

                    // AMOUNT
                    if (!empty($request->amount[$key])) {
                        $amount = str_replace(',', '', $request->amount[$key]);
                    }else{
                        $amount        = 0.00;
                    }

                    // TAX AMOUNT
                    if (!empty($request->tax_amount[$key])) {
                        $taxAmount = str_replace(',', '', $request->tax_amount[$key]);
                    }else{
                        $taxAmount        = 0.00;
                    }

                    // Total AMOUNT
                    if (!empty($request->total_amount[$key])) {
                        $totalAmount = str_replace(',', '', $request->total_amount[$key]);
                    }else{
                        $totalAmount        = 0.00;
                    }

                    // Net Weight
                    if (!empty($request->net[$key])) {
                        $net    = str_replace(',', '', $request->net[$key]);
                    }else{
                        $net    = 0.00;
                    }

                    // Gross Weight
                    if (!empty($request->gross[$key])) {
                        $gross  = str_replace(',', '', $request->gross[$key]);
                    }else{
                        $gross  = 0.00;
                    }

                    // Total NET WEIGHT
                    if (!empty($request->total_net_weight[$key])) {
                        $totalNetWeight = str_replace(',', '', $request->total_net_weight[$key]);
                    }else{
                        $totalNetWeight        = 0.00;
                    }

                    // Total NET GROSS
                    if (!empty($request->total_net_gross[$key])) {
                        $totalNetGross = str_replace(',', '', $request->total_net_gross[$key]);
                    }else{
                        $totalNetGross        = 0.00;
                    }

                    $checkDataLine = OrderLines::where('order_line_id', $key)->where('order_header_id', $request->order_header_id)->first();

                    if (!empty($checkDataLine)) {
                        $updateLine = [
                            'order_line_id'         => $key,
                            'line_number'           => $lineNumber,
                            'order_quantity'        => $orderQuantity,
                            'approve_quantity'      => $orderQuantity,
                            'item_description'      => $request->item_description[$key],
                            'unit_price'            => $unitPrice,
                            'amount'                => $amount,
                            'uom'                   => $request->uom[$key],
                            'vat_code'              => $valueLine,
                            'tax_amount'            => $taxAmount,
                            'total_amount'          => $totalAmount,
                            'weight_id'             => $request->weight_id[$key],
                            'weight_unit_net'       => $net,
                            'weight_unit_gross'     => $gross,
                            'total_net_weight'      => $totalNetWeight,
                            'total_net_gross'       => $totalNetGross,
                            'promo_flag'            => $unitPrice <= 0 ? 'Y' : null,
                            'updated_by_id'         => optional(auth()->user())->user_id,
                            'updated_at'            => date('Y-m-d H:i:s'),
                            'last_updated_by'       => optional(auth()->user())->user_id,
                            'last_update_date'      => date('Y-m-d H:i:s')
                        ];

                        OrderLines::where('order_line_id', $key)->update($updateLine);

                        $orderLineKey = $key;

                    }else{
                        $insertLine = [
                            'order_header_id'       => $request->order_header_id,
                            'line_number'           => $lineNumber,
                            'item_id'               => $request->item_id[$key],
                            'item_code'             => $request->item_code[$key],
                            'item_description'      => $request->item_description[$key],
                            'uom_code'              => $request->uom_code[$key],
                            'uom'                   => $request->uom[$key],
                            'order_quantity'        => $orderQuantity,
                            'approve_quantity'      => $orderQuantity,
                            'unit_price'            => $unitPrice,
                            'amount'                => $amount,
                            'vat_code'              => $valueLine,
                            'tax_amount'            => $taxAmount,
                            'total_amount'          => $totalAmount,
                            'weight_id'             => $request->weight_id[$key],
                            'weight_unit_net'       => $net,
                            'weight_unit_gross'     => $gross,
                            'total_net_weight'      => $totalNetWeight,
                            'total_net_gross'       => $totalNetGross,
                            'promo_flag'            => $unitPrice <= 0 ? 'Y' : null,
                            'program_code'          => 'OMP0066',
                            'created_by'            => optional(auth()->user())->user_id,
                            'created_at'            => date('Y-m-d'),
                            'creation_date'         => date('Y-m-d'),
                            'updated_by_id'         => optional(auth()->user())->user_id,
                            'updated_at'            => date('Y-m-d'),
                            'last_updated_by'       => optional(auth()->user())->user_id,
                            'last_update_date'      => date('Y-m-d')
                        ];

                        OrderLines::insert($insertLine);

                        $orderLineKey = OrderLines::orderBy('order_line_id', 'desc')->pluck('order_line_id')->first();
                    }

                    OrderRepo::amountCreditGroupCash(
                        $request->order_header_id,
                        $orderLineKey,
                        $totalAmount,
                        'OMP0066'
                    );

                    $lineNumber++;

                    // echo '<pre>';
                    // print_r($updateLine);
                    // echo '<pre>';
                    // exit();
                }
            }

            if (!empty($dataOrderLines)) {
                foreach ($dataOrderLines as $key => $value) {
                    OrderLines::where('order_line_id', $value->order_line_id)->delete();
                }
            }

            $attachmentFile = AttachFiles::where('attachment_program_code','OMP0066')->where('header_id', $request->order_header_id)->whereNull('deleted_at')->get();

            $saNumber = $saNumber;

            $getOrderHeader =  OrderHeaders::where('order_header_id', $orderHeaderID)->first();

            $orderSelect = [
                'ptom_order_headers.prepare_order_number',
                'ptom_order_headers.order_number',
                'ptom_order_headers.order_date',
                'ptom_order_headers.sa_status',
                'ptom_order_headers.sa_date',
                'ptom_order_headers.order_status',
                'ptom_order_headers.customer_id',
                'ptom_order_headers.cust_po_number',
                'ptom_customers.customer_number',
                'ptom_customers.customer_name'
            ];
            $saList = OrderHeaders::join('ptom_customers', 'ptom_order_headers.customer_id', '=', 'ptom_customers.customer_id')
                                        ->select($orderSelect)
                                        ->where('ptom_customers.sales_classification_code', 'Export')
                                        // ->where('ptom_order_headers.order_status', 'Draft')
                                        // ->whereNotNull('ptom_order_headers.prepare_order_number')
                                        // ->whereNotNull('ptom_order_headers.order_number')
                                        ->orderBy('ptom_order_headers.prepare_order_number')
                                        ->whereNull('ptom_order_headers.deleted_at')
                                        ->groupBy($orderSelect)
                                        ->get();

            foreach ($saList as $key => $value) {
                if ($value->sa_status == '') {
                    $saList[$key]->sa_status    = 'Draft';
                }

                $saList[$key]->sa_date      = !empty($value->sa_date) ? dateFormatDMYDefault(date('m/d/Y',strtotime($value->sa_date))) : $value->sa_date;
                $saList[$key]->order_date   = !empty($value->order_date) ? dateFormatDMYDefault(date('m/d/Y',strtotime($value->order_date))) : $value->order_date;
            }

            $getOrderLines = OrderLines::where('order_header_id', $request->order_header_id)->whereNull('deleted_at')->orderBy('item_code', 'asc')->get();

            // echo '<pre>';
            // print_r($getOrderLines);
            // echo '<pre>';
            // exit();

            $totalAmount = 0;

            if(!empty($getOrderLines)){

                foreach ($getOrderLines as $key => $value) {

                    $orderPiQuantity = ProformaInvoiceLines::where('ref_order_header_id', $request->order_header_id)->where('ref_order_line_id', $value->order_line_id)->whereNull('cancelled_flag')->sum('order_quantity');

                    // echo '<pre>';
                    // print_r($orderPiQuantity);
                    // echo '<pre>';
                    // exit();

                    $getItemWeight = ItemWeights::where('item_code', $value->item_code)
                                            ->where('active_flag', 'Y')
                                            // ->whereRaw("nvl(start_date,sysdate+1) < sysdate")
                                            ->whereRaw("nvl(end_date,sysdate+1) > sysdate")
                                            ->whereNull('deleted_at')->first();

                    $weight_id = !empty($getItemWeight->weight_id) ? $getItemWeight->weight_id : 0;
                    // $net_weight = !empty($getItemWeight->net_weight) ? $getItemWeight->net_weight : 0;
                    // $net_gross  = !empty($getItemWeight->net_gross) ? $getItemWeight->net_gross : 0;
                        $net_weight = !empty($value->weight_unit_net) ? $value->weight_unit_net : (!empty($getItemWeight->net_weight) ? $getItemWeight->net_weight : 0);
                        $net_gross  = !empty($value->weight_unit_gross) ? $value->weight_unit_gross : (!empty($getItemWeight->net_gross) ? $getItemWeight->net_gross : 0);

                    $approve_quantity   = !empty($value->order_quantity) ? number_format((float)$value->order_quantity, 2, '.', '') : 0.00;
                    $unit_price         = !empty($value->unit_price) ? number_format((float)$value->unit_price, 2, '.', '') : 0.00;
                    $totalNetWeight     = $value->order_quantity * $net_weight;
                    $totalNetGross      = $value->order_quantity * $net_gross;

                    $vatCode        = !empty($value->vat_code) ? $value->vat_code : $request->vat_code;
                    $getPercentage  = TaxCode::where('tax_rate_code', $vatCode)->pluck('percentage_rate')->first();
                    $taxAmount      = number_format((float)($approve_quantity * $unit_price) * $getPercentage / 100, 2, '.', '');

                    $total_amount       = !empty($value->total_amount) ? $value->total_amount : 0.00;
                    $lineAmount         = $total_amount + $taxAmount;

                    $orderLine[$key] = [
                        'order_line_id'         => $value->order_line_id,
                        'item_id'               => $value->item_id,
                        'item_code'             => $value->item_code,
                        'item_description'      => $value->item_description,
                        'uom_code'              => $value->uom_code,
                        'uom'                   => $value->uom,
                        'order_quantity'        => !empty($value->order_quantity) ? $value->order_quantity : 0,
                        'order_pi_quantity'     => $orderPiQuantity,
                        'unit_price'            => $value->unit_price,
                        'amount'                => !empty($value->amount) ? number_format((float)$value->amount, 2, '.', '') : 0.00,
                        'vat_code'              => $value->vat_code,
                        'tax_amount'            => $value->tax_amount,
                        'total_amount'          => $value->total_amount,
                        'weight_id'             => $weight_id,
                        'net_weight'            => $net_weight,
                        'net_gross'             => $net_gross,
                        'total_net_weight'      => number_format((float)$totalNetWeight, 2, '.', ''),
                        'total_net_gross'       => number_format((float)$totalNetGross, 2, '.', ''),
                    ];

                    $resultTotalNet     = $resultTotalNet + $totalNetWeight;
                    $resultTotalGross   = $resultTotalGross + $totalNetGross;
                    $resultSubTotal     = $resultSubTotal + $value->amount;
                    $resultTax          = $resultTax + $taxAmount;
                    $resultTotal        = $resultTotal + $value->total_amount + $taxAmount;
                    $totalAmount        = $totalAmount + $value->total_amount;
                }

                $resultWeight = [
                    'result_net_weight'     => number_format((float)$resultTotalNet, 2, '.', ''),
                    'result_gross_weight'   => number_format((float)$resultTotalGross, 2, '.', ''),
                    'result_sub_total'      => number_format((float)$resultSubTotal, 2, '.', ''),
                    'result_tax'            => number_format((float)$resultTax, 2, '.', ''),
                    'result_total'          => number_format((float)$resultTotal, 2, '.', ''),
                ];

                $matchInvoice = PaymentMatchInvoices::where('prepare_order_number', $request->prepare_order_number)->where('match_flag', 'Y')->get();

                $paymentAmount = 0;

                if (!$matchInvoice->isEmpty()) {
                    foreach ($matchInvoice as $key => $invoice) {
                        $invoiceAmount = PaymentApplyCNDN::where('payment_match_id', $invoice->payment_match_id)->whereNull('deleted_at')->sum('invoice_amount');
                        $paymentAmount = ($paymentAmount + $invoice->payment_amount) + $invoiceAmount;
                    }
                }

                // ยอดคงค้าง
                $resultAmount = $totalAmount - $paymentAmount;
            }

            try {
                $orderHeader = OrderHeaders::where('order_header_id', $request->order_header_id)->orderBy('order_header_id','DESC')->first();

                DirectDebitRepo::updateOrderDirectDebitExport($orderHeader);
            }catch (\Exception $e) {}


            $rest = [
                'orderHeaderID'     => $orderHeaderID,
                'orderLine'         => $orderLine,
                'newSaList'         => $saList,
                'saNumber'          => $saNumber,
                'status'            => 'success',
                'data'              => 'Success',
                'attachmentFile'    => $attachmentFile
            ];
        }else{

            // วันที่
            if(!empty($request->sa_date)){
                $dateArr    = explode('/', $request->sa_date);
                $day        = $dateArr[0];
                $month      = $dateArr[1];
                $year       = $dateArr[2];
                $newDate    = $month.'/'.$day.'/'.$year;

                $saTime = strtotime($newDate);
                $saDate = date('Y-m-d H:i:s',$saTime);
            }else{
                $saDate = '';
            }

            // วันที่สั่งซื้อ
            if(!empty($request->order_date)){
                $dateArr    = explode('/', $request->order_date);
                $day        = $dateArr[0];
                $month      = $dateArr[1];
                $year       = $dateArr[2];
                $newDate    = $month.'/'.$day.'/'.$year;

                $orderTime = strtotime($newDate);
                $orderDate = date('Y-m-d H:i:s',$orderTime);
            }else{
                $orderDate = '';
            }

            // วันที่เปลี่ยนแปลงสถานภาพ
            if(!empty($request->sale_confirm_date)){
                $dateArr    = explode('/', $request->sale_confirm_date);
                $day        = $dateArr[0];
                $month      = $dateArr[1];
                $year       = $dateArr[2];
                $newDate    = $month.'/'.$day.'/'.$year;

                $confirmTime  = strtotime($newDate);
                $confirmDate  = date('Y-m-d H:i:s',$confirmTime);
            }else{
                $confirmDate  = '';
            }

            if (!empty($request->order_type_id)) {
                $productType        = TransactionTypes::where('order_type_id', $request->order_type_id)->pluck('product_type')->first();
                $product_type_code  = DB::table('oaom.ptom_product_type_export')->where('description', $productType)->pluck('lookup_code')->first();
            }

            $periodLineID   = Period::whereRaw("nvl(start_period,sysdate+1) < sysdate")
                                    ->whereRaw("nvl(end_period,sysdate+1) > sysdate")
                                    ->pluck('period_line_id')->first();

            $periodLineID   = !empty($periodLineID) ? $periodLineID : 0;

            $checkOrderStatus = $request->payment_type_code == 10 ? 'Wait Pay' : 'Invoice';


            // GENERATE NUMBER
            $saNumber = GenerateNumberRepo::generateSaleConfirmation('OMP0064_SA_NUM_EXP');

            $orgId = DB::table('hr_organization_units_v')->select('organization_id')->where('name', 'การยาสูบแห่งประเทศไทย')->pluck('organization_id')->first();

            $insert = [
                'prepare_order_number'      => $saNumber,
                'sa_date'                   => $saDate,
                'order_number'              => $request->order_number,
                'order_date'                => $orderDate,
                'cust_po_number'            => $request->cust_po_number,
                'order_type_id'             => !empty($request->order_type_id) ? $request->order_type_id : 0,
                'product_type_code'         => !empty($product_type_code) ? $product_type_code : '',
                'currency'                  => $request->currency,
                'term_id'                   => !empty($request->term_id) ? $request->term_id : 0,
                'payment_type_code'         => $request->payment_type_code,
                'vat_code'                  => $request->vat_code,
                'payment_method_code'       => $request->payment_method_code,
                'remark'                    => $request->remark,
                'bill_to_site_id'           => $request->bill_to_site_id,
                'price_list_id'             => $request->price_list_id,
                'ship_to_site_id'           => $request->ship_to_site_id,
                'incoterms_code'            => $request->incoterms_code,
                'port_of_loading'           => $request->port_of_loading,
                'transport_type_code'       => $request->transport_type_code,
                'transport_detail'          => $request->transport_detail,
                'port_of_discharge'         => $request->port_of_discharge,
                'shipping_marks'            => $request->shipping_marks,
                'source_system'             => $request->source_system,
                'shipment_condition'        => $request->shipment_condition,
                'org_id'                    => !empty($orgId) ? $orgId : '',
                'order_source'              => 'WEB',
                'order_status'              => 'Draft',
                'period_id'                 => $periodLineID,
                'sa_status'                 => 'Confirm',
                'sub_total'                 => $request->order_sub_total,
                'tax'                       => $request->order_tax,
                'grand_total'               => $request->order_total,
                'customer_id'               => $request->customer_id,
                'sale_confirm_date'         => $confirmDate,
                'sale_confirm_document_no'  => $request->sale_confirm_document_no,
                'sale_confirm_by'           => $request->sale_confirm_by,
                'sale_confirm_flag'         => $request->sale_confirm_flag,
                'program_code'              => 'OMP0066',
                'created_by'                => optional(auth()->user())->user_id,
                'created_at'                => date('Y-m-d'),
                'creation_date'             => date('Y-m-d'),
                'updated_by_id'             => optional(auth()->user())->user_id,
                'updated_at'                => date('Y-m-d'),
                'last_updated_by'           => optional(auth()->user())->user_id,
                'last_update_date'          => date('Y-m-d')
            ];

            // echo '<pre>';
            // print_r($insert);
            // echo '<pre>';
            // exit();

            OrderHeaders::insert($insert);

            $orderHeaderID  = OrderHeaders::select('order_header_id')->orderBy('order_header_id', 'DESC')->pluck('order_header_id')->first();

            $insert['order_header_id']  = $orderHeaderID;

            OrderHistory::insert($insert);

            // $getOrderHeader =  OrderHeaders::where('order_header_id', $orderHeaderID)->first();
            // OrderRepo::insertOrdersHistoryv2($getOrderHeader, 'Draft');

            if($request->hasFile('attachment')) {
                $fileAttachment = $request->file('attachment');
                AttachmentRepo::uploadAttachmentMultiple($fileAttachment,$orderHeaderID,'OMP0066');
            }

            if (!empty($request->sub_vat)) {
                foreach ($request->sub_vat as $key => $valueLine) {

                    // ORDER QUANTITY
                    if (!empty($request->order_quantity[$key])) {
                        $orderQuantity = str_replace(',', '', $request->order_quantity[$key]);
                    }else{
                        $orderQuantity        = 0.00;
                    }

                    // UNIT PRICE
                    if (!empty($request->unit_price[$key])) {
                        $unitPrice = str_replace(',', '', $request->unit_price[$key]);
                    }else{
                        $unitPrice        = 0.00;
                    }

                    // Amount
                    if (!empty($request->amount[$key])) {
                        $amount = str_replace(',', '', $request->amount[$key]);
                    }else{
                        $amount        = 0.00;
                    }

                    // TAX AMOUNT
                    if (!empty($request->tax_amount[$key])) {
                        $taxAmount = str_replace(',', '', $request->tax_amount[$key]);
                    }else{
                        $taxAmount        = 0.00;
                    }

                    // Total AMOUNT
                    if (!empty($request->total_amount[$key])) {
                        $totalAmount = str_replace(',', '', $request->total_amount[$key]);
                    }else{
                        $totalAmount        = 0.00;
                    }

                    // Net Weight
                    if (!empty($request->net[$key])) {
                        $net    = str_replace(',', '', $request->net[$key]);
                    }else{
                        $net    = 0.00;
                    }

                    // Gross Weight
                    if (!empty($request->gross[$key])) {
                        $gross  = str_replace(',', '', $request->gross[$key]);
                    }else{
                        $gross  = 0.00;
                    }

                    // Total NET WEIGHT
                    if (!empty($request->total_net_weight[$key])) {
                        $totalNetWeight = str_replace(',', '', $request->total_net_weight[$key]);
                    }else{
                        $totalNetWeight        = 0.00;
                    }

                    // Total NET GROSS
                    if (!empty($request->total_net_gross[$key])) {
                        $totalNetGross = str_replace(',', '', $request->total_net_gross[$key]);
                    }else{
                        $totalNetGross        = 0.00;
                    }


                    $insertLine = [
                        'order_header_id'       => $orderHeaderID,
                        'line_number'           => $key+1,
                        'item_id'               => $request->item_id[$key],
                        'item_code'             => $request->item_code[$key],
                        'item_description'      => $request->item_description[$key],
                        'uom_code'              => $request->uom_code[$key],
                        'uom'                   => $request->uom[$key],
                        'order_quantity'        => $orderQuantity,
                        'approve_quantity'      => $orderQuantity,
                        'unit_price'            => $unitPrice,
                        'amount'                => $amount,
                        'vat_code'              => $valueLine,
                        'tax_amount'            => $taxAmount,
                        'total_amount'          => $totalAmount,
                        'weight_id'             => $request->weight_id[$key],
                        'weight_unit_net'       => $net,
                        'weight_unit_gross'     => $gross,
                        'total_net_weight'      => $totalNetWeight,
                        'total_net_gross'       => $totalNetGross,
                        'promo_flag'            => $unitPrice <= 0 ? 'Y' : null,
                        'program_code'          => 'OMP0066',
                        'created_by'            => optional(auth()->user())->user_id,
                        'created_at'            => date('Y-m-d'),
                        'creation_date'         => date('Y-m-d'),
                        'updated_by_id'         => optional(auth()->user())->user_id,
                        'updated_at'            => date('Y-m-d'),
                        'last_updated_by'       => optional(auth()->user())->user_id,
                        'last_update_date'      => date('Y-m-d')
                    ];

                    // echo '<pre>';
                    // print_r($insertLine);
                    // echo '<pre>';

                    OrderLines::insert($insertLine);
                }
            }

            $attachmentFile = AttachFiles::where('attachment_program_code','OMP0066')->where('header_id', $orderHeaderID)->whereNull('deleted_at')->get();

            // Reload Data

            $orderSelect = [
                'ptom_order_headers.prepare_order_number',
                'ptom_order_headers.order_number',
                'ptom_order_headers.order_date',
                'ptom_order_headers.sa_status',
                'ptom_order_headers.sa_date',
                'ptom_order_headers.order_status',
                'ptom_order_headers.customer_id',
                'ptom_order_headers.cust_po_number',
                'ptom_customers.customer_number',
                'ptom_customers.customer_name'
            ];
            $saList = OrderHeaders::join('ptom_customers', 'ptom_order_headers.customer_id', '=', 'ptom_customers.customer_id')
                                        ->select($orderSelect)
                                        ->where('ptom_customers.sales_classification_code', 'Export')
                                        // ->where('ptom_order_headers.order_status', 'Draft')
                                        // ->whereNotNull('ptom_order_headers.prepare_order_number')
                                        // ->whereNotNull('ptom_order_headers.order_number')
                                        ->orderBy('ptom_order_headers.prepare_order_number', 'desc')
                                        ->whereNull('ptom_order_headers.deleted_at')
                                        ->groupBy($orderSelect)
                                        ->get();

            foreach ($saList as $key => $value) {
                if ($value->sa_status == '') {
                    $saList[$key]->sa_status    = 'Draft';
                }

                $saList[$key]->sa_date      = !empty($value->sa_date) ? dateFormatDMYDefault(date('m/d/Y',strtotime($value->sa_date))) : $value->sa_date;
                $saList[$key]->order_date   = !empty($value->order_date) ? dateFormatDMYDefault(date('m/d/Y',strtotime($value->order_date))) : $value->order_date;
            }

            $getOrderHeadersQuery = OrderHeaders::where('prepare_order_number', $saNumber)->whereNull('deleted_at')->first();

            $getOrderLines = OrderLines::where('order_header_id', $getOrderHeadersQuery->order_header_id)->whereNull('deleted_at')->get();

            // echo '<pre>';
            // print_r($getOrderLines);
            // echo '<pre>';
            // exit();

            $totalAmount = 0;

            if(!empty($getOrderLines)){

                foreach ($getOrderLines as $key => $value) {

                    $orderPiQuantity = ProformaInvoiceLines::where('ref_order_header_id', $getOrderHeadersQuery->order_header_id)->where('ref_order_line_id', $value->order_line_id)->where('cancelled_flag', '!=', 'Y')->sum('order_quantity');

                    // echo '<pre>';
                    // print_r($orderPiQuantity);
                    // echo '<pre>';
                    // exit();

                    $getItemWeight = ItemWeights::where('item_code', $value->item_code)
                                            ->where('active_flag', 'Y')
                                            // ->whereRaw("nvl(start_date,sysdate+1) < sysdate")
                                            ->whereRaw("nvl(end_date,sysdate+1) > sysdate")
                                            ->whereNull('deleted_at')->first();

                    $weight_id = !empty($getItemWeight->weight_id) ? $getItemWeight->weight_id : 0;
                    // $net_weight = !empty($getItemWeight->net_weight) ? $getItemWeight->net_weight : 0;
                    // $net_gross  = !empty($getItemWeight->net_gross) ? $getItemWeight->net_gross : 0;
                        $net_weight = !empty($value->weight_unit_net) ? $value->weight_unit_net : (!empty($getItemWeight->net_weight) ? $getItemWeight->net_weight : 0);
                        $net_gross  = !empty($value->weight_unit_gross) ? $value->weight_unit_gross : (!empty($getItemWeight->net_gross) ? $getItemWeight->net_gross : 0);

                    $approve_quantity   = !empty($value->order_quantity) ? number_format((float)$value->order_quantity, 2, '.', '') : 0.00;
                    $unit_price         = !empty($value->unit_price) ? number_format((float)$value->unit_price, 2, '.', '') : 0.00;
                    $totalNetWeight     = $value->order_quantity * $net_weight;
                    $totalNetGross      = $value->order_quantity * $net_gross;

                    $vatCode        = !empty($value->vat_code) ? $value->vat_code : $getOrderHeadersQuery->vat_code;
                    $getPercentage  = TaxCode::where('tax_rate_code', $vatCode)->pluck('percentage_rate')->first();
                    $taxAmount      = number_format((float)($approve_quantity * $unit_price) * $getPercentage / 100, 2, '.', '');

                    $total_amount       = !empty($value->total_amount) ? $value->total_amount : 0.00;
                    $lineAmount         = $total_amount + $taxAmount;

                    $orderLine[$key] = [
                        'order_line_id'         => $value->order_line_id,
                        'item_id'               => $value->item_id,
                        'item_code'             => $value->item_code,
                        'item_description'      => $value->item_description,
                        'uom_code'              => $value->uom_code,
                        'uom'                   => $value->uom,
                        'order_quantity'        => !empty($value->order_quantity) ? $value->order_quantity : 0,
                        'order_pi_quantity'     => $orderPiQuantity,
                        'unit_price'            => $value->unit_price,
                        'amount'                => !empty($value->amount) ? number_format((float)$value->amount, 2, '.', '') : 0.00,
                        'vat_code'              => $value->vat_code,
                        'tax_amount'            => $value->tax_amount,
                        'total_amount'          => $value->total_amount,
                        'weight_id'             => $weight_id,
                        'net_weight'            => $net_weight,
                        'net_gross'             => $net_gross,
                        'total_net_weight'      => number_format((float)$totalNetWeight, 2, '.', ''),
                        'total_net_gross'       => number_format((float)$totalNetGross, 2, '.', ''),
                    ];

                    $resultTotalNet     = $resultTotalNet + $totalNetWeight;
                    $resultTotalGross   = $resultTotalGross + $totalNetGross;
                    $resultSubTotal     = $resultSubTotal + $value->amount;
                    $resultTax          = $resultTax + $taxAmount;
                    $resultTotal        = $resultTotal + $value->total_amount + $taxAmount;
                    $totalAmount        = $totalAmount + $value->total_amount;
                }

                $resultWeight = [
                    'result_net_weight'     => number_format((float)$resultTotalNet, 2, '.', ''),
                    'result_gross_weight'   => number_format((float)$resultTotalGross, 2, '.', ''),
                    'result_sub_total'      => number_format((float)$resultSubTotal, 2, '.', ''),
                    'result_tax'            => number_format((float)$resultTax, 2, '.', ''),
                    'result_total'          => number_format((float)$resultTotal, 2, '.', ''),
                ];

                $matchInvoice = PaymentMatchInvoices::where('prepare_order_number', $saNumber)->where('match_flag', 'Y')->get();

                $paymentAmount = 0;

                if (!$matchInvoice->isEmpty()) {
                    foreach ($matchInvoice as $key => $invoice) {
                        $invoiceAmount = PaymentApplyCNDN::where('payment_match_id', $invoice->payment_match_id)->whereNull('deleted_at')->sum('invoice_amount');
                        $paymentAmount = ($paymentAmount + $invoice->payment_amount) + $invoiceAmount;
                    }
                }

                // ยอดคงค้าง
                $resultAmount = $totalAmount - $paymentAmount;
            }

            try {
                $orderHeader = OrderHeaders::where('prepare_order_number', $saNumber)->whereNull('deleted_at')->orderBy('order_header_id','DESC')->first();

                DirectDebitRepo::updateOrderDirectDebitExport($orderHeader);
            }catch (\Exception $e) {}

            // END Relead Data

            $rest = [
                'orderLine'         => $orderLine,
                'newSaList'         => $saList,
                'saNumber'          => $saNumber,
                'orderHeaderID'     => $orderHeaderID,
                'status'            => 'success',
                'data'              => 'Success',
                'attachmentFile'    => $attachmentFile
            ];
        }

        return response()->json(['data' => $rest]);
    }

    public function search(Request $request)
    {
        $dataList               = [];
        $orderLine              = [];
        $shipSitesList          = [];
        $resultWeight           = [];
        $attachmentFile         = [];
        $resultTotalNet         = 0.00;
        $resultTotalGross       = 0.00;
        $resultSubTotal         = 0.00;
        $resultTax              = 0.00;
        $resultTotal            = 0.00;
        $resultAmount           = 0.00;

        // echo '<pre>';
        // print_r($request->all());
        // echo '<pre>';
        // exit();

        $getData = OrderHeaders::select('ptom_order_headers.*',
                                    'ptom_customers.currency as currency_customers',
                                    'ptom_customers.customer_number',
                                    'ptom_customers.customer_name',
                                    'ptom_customers.address_line1',
                                    'ptom_customers.address_line2',
                                    'ptom_customers.address_line3',
                                    'ptom_customers.state',
                                    'ptom_customers.alley',
                                    'ptom_customers.city',
                                    'ptom_customers.district',
                                    'ptom_customers.province_name',
                                    'ptom_customers.postal_code',
                                    'ptom_customers.country_name',
                                    'ptom_customers.shipment_condition as customer_shipment_condition',
                                    'ptom_customers.sales_channel_id as customer_sales_channel_id',
                                    'ptom_customers.incoterms_code as customer_incoterms_code',
                                    'ptom_customers.vat_code as customer_vat_code',
                                    'ptom_customers.order_type_id as customer_order_type_id',
                                    'ptom_customers.payment_term_id as customer_payment_term_id',
                                    'ptom_customers.payment_type_id as customer_payment_type_id',
                                    'ptom_customers.price_list_id as customer_price_list_id'
                                )->join('ptom_customers', 'ptom_order_headers.customer_id', '=', 'ptom_customers.customer_id')
                                ->whereNull('ptom_order_headers.deleted_at')
                                ->where('ptom_order_headers.order_status', '!=', 'Invoice')
                                ->where('ptom_order_headers.order_status', '!=', 'Wait Pay')
                                ->where('ptom_order_headers.order_status', '!=', 'Release')
                                ->where('ptom_order_headers.order_status', '!=', 'Inprocess')
                                ->where('ptom_order_headers.order_status', '!=', 'Cancel')
                                ->where('ptom_order_headers.order_status', '!=', 'Cancelled')
                                ->where(function($query) use($request) {
                                    if(!empty($request->prepare_order_number)) {
                                        $query->where('ptom_order_headers.prepare_order_number', $request->prepare_order_number);
                                    }
                                    if(!empty($request->order_number)) {
                                        $query->where('ptom_order_headers.order_number', $request->order_number);
                                    }
                                    if(!empty($request->customer_id)) {
                                        $query->where('ptom_order_headers.customer_id', $request->customer_id);
                                    }
                                })->where('ptom_customers.sales_classification_code', 'Export')->first();

        // echo '<pre>';
        // print_r($getData);
        // echo '<pre>';
        // exit();

        if (!empty($getData)) {

            if (!empty($getData->term_id)) {
                $getTerms = Terms::select('name', 'description')->where('term_id', $getData->term_id)->first();
            }else{
                $getTerms = Terms::select('name', 'description')->where('term_id', $getData->customer_payment_term_id)->first();
            }

            if (!empty($getData->customer_id)) {
                $shipSitesList  = ShipSites::where('customer_id', $getData->customer_id)->where('status', 'Active')->whereNull('deleted_at')->get();
            }else{
                $shipSitesList  = [];
            }

            $currency_name = '';
            $currency = '';

            if (!empty($getData->currency)) {
                if (ctype_upper($getData->currency)) {
                    $getCurrency = Currencies::select('name')->where('currency_code', $getData->currency)->first();
                    $currency_name  = !empty($getCurrency->name) ? $getCurrency->name : '';
                    $currency       = $getData->currency;
                }else{
                    if ($getData->currency == 'Bath' || $getData->currency == 'Baht') {
                        $currency_name  = 'Baht';
                        $currency       = 'THB';
                    }else{
                        $getCurrency = Currencies::select('currency_code')->where('name', $getData->currency)->first();
                        $currency_name  = $getData->currency;
                        $currency       = !empty($getCurrency->currency) ? $getCurrency->currency : '';
                    }
                }
            }

            $addressLine1        = !empty($getData->address_line1) ? $getData->address_line1.', ' : '';
            $addressLine2        = !empty($getData->address_line2) ? $getData->address_line2.', ' : '';
            $addressLine3        = !empty($getData->address_line3) ? $getData->address_line3.', ' : '';
            $alley               = !empty($getData->alley) ? $getData->alley.', ' : '';
            $state               = !empty($getData->state) ? $getData->state.', ' : '';
            $district            = !empty($getData->district) ? $getData->district.', ' : '';
            $city                = !empty($getData->city) ? $getData->city.', ' : '';
            $provinceName        = !empty($getData->province_name) ? $getData->province_name.', ' : '';
            $postalCode          = !empty($getData->postal_code) ? $getData->postal_code.', ' : '';
            $country_name        = !empty($getData->country_name) ? $getData->country_name.'.' : '';

            if (is_numeric($getData->port_of_discharge) || $getData->port_of_discharge == '') {
                $shipName            = CustomerShipSites::where('ship_to_site_id', $getData->ship_to_site_id)->pluck('ship_to_site_name')->first();
            }else{
                $shipName            = $getData->port_of_discharge;
            }

            $dataVatCode        = !empty($getData->vat_code) ? $getData->vat_code : $getData->customer_vat_code;

            if(empty($getData->remark) && $getData->sa_status == 'Draft'){
                $packingData    = DB::table('ptom_packing_details_v')
                    ->where('enabled_flag', 'Y')
                    ->where('tag', $getData->product_type_code)
                    ->whereRaw("nvl(start_date_active,sysdate+1) < sysdate")
                    ->whereRaw("nvl(end_date_active,sysdate+1) > sysdate")
                    ->orderBy('lookup_code', 'ASC')->get();
                    $getData->remark = '';
                    if (!empty($packingData)) {
                        foreach ($packingData as $key => $value) {
                            if (($key+1) < count($packingData)) {
                                $getData->remark .= $value->meaning. "\n";
                            }else{
                                $getData->remark .= $value->meaning;
                            }
                        }
                    }
            }

            $dataList = [
                'order_header_id'           => $getData->order_header_id,
                'sa_status'                 => !empty($getData->sa_status) ? $getData->sa_status : 'Draft',
                'prepare_order_number'      => $getData->prepare_order_number,
                'sa_date'                   => !empty($getData->sa_date) ? dateFormatDMYDefault(date('m/d/Y',strtotime($getData->sa_date))) : $getData->sa_date,
                'order_number'              => $getData->order_number,
                'order_date'                => !empty($getData->order_date) ? dateFormatDMYDefault(date('m/d/Y',strtotime($getData->order_date))) : $getData->order_date,
                'cust_po_number'            => $getData->cust_po_number,
                'customer_id'               => $getData->customer_id,
                'customer_number'           => $getData->customer_number,
                'customer_name'             => $getData->customer_name,
                'order_type_id'             => $getData->order_type_id > 0 ? $getData->order_type_id : $getData->customer_order_type_id,
                'currency_name'             => $currency_name,
                'currency'                  => $currency,
                'price_list_id'             => !empty($getData->price_list_id) ? $getData->price_list_id : $getData->customer_price_list_id,
                'customer_address'          => $addressLine1 . $addressLine2 . $addressLine3 . $alley . $state . $district . $city . $provinceName . $postalCode . $country_name,
                'term_id'                   => $getData->term_id > 0 ? $getData->term_id : $getData->customer_payment_term_id,
                'term_name'                 => !empty($getTerms->name) ? $getTerms->name : '',
                'term_description'          => !empty($getTerms->description) ? $getTerms->description : '',
                'payment_type_code'         => !empty($getData->payment_type_code) ? $getData->payment_type_code : $getData->customer_payment_type_id,
                'vat_code'                  => $dataVatCode,
                'payment_method_code'       => $getData->payment_method_code,
                'remark'                    => $getData->remark,
                'bill_to_site_id'           => !empty($getData->bill_to_site_id) ? $getData->bill_to_site_id : $getData->customer_id,
                'bill_to_site_name'         => !empty($getData->bill_to_site_name) ? $getData->bill_to_site_name : $getData->customer_name,
                'ship_to_site_id'           => $getData->ship_to_site_id,
                'incoterms_code'            => !empty($getData->incoterms_code) ? $getData->incoterms_code : $getData->customer_incoterms_code,
                'port_of_loading'           => !empty($getData->port_of_loading) ? $getData->port_of_loading : 'Tobacco Authority Of Thailand',
                'transport_type_code'       => $getData->transport_type_code,
                'transport_detail'          => $getData->transport_detail,
                'port_of_discharge'         => !empty($shipName) ? $shipName : '',
                'shipment_condition'        => !empty($getData->shipment_condition) ? $getData->shipment_condition : $getData->customer_shipment_condition,
                'shipping_marks'            => $getData->shipping_marks,
                'source_system'             => !empty($getData->source_system) ? $getData->source_system : $getData->customer_sales_channel_id,
                'sale_confirm_date'         => !empty($getData->sale_confirm_date) ? dateFormatDMYDefault(date('m/d/Y',strtotime($getData->sale_confirm_date))) : $getData->sale_confirm_date,
                'sale_confirm_document_no'  => $getData->sale_confirm_document_no,
                'sale_confirm_by'           => $getData->sale_confirm_by,
                'sale_confirm_flag'         => $getData->sale_confirm_flag,
            ];

            $getOrderLines = OrderLines::where('order_header_id', $getData->order_header_id)->whereNull('deleted_at')->orderBy('item_code', 'asc')->get();

            // echo '<pre>';
            // print_r($getOrderLines);
            // echo '<pre>';
            // exit();

            $totalAmount = 0;

            if(!$getOrderLines->isEmpty()){

                foreach ($getOrderLines as $key => $value) {

                    $orderPiQuantity = ProformaInvoiceLines::where('ref_order_header_id', $getData->order_header_id)->where('ref_order_line_id', $value->order_line_id)->whereNull('cancelled_flag')->sum('order_quantity');

                    // echo '<pre>';
                    // print_r($orderPiQuantity);
                    // echo '<pre>';
                    // exit();

                    $getItemWeight = ItemWeights::where('item_code', $value->item_code)
                                            ->where('active_flag', 'Y')
                                            // ->whereRaw("nvl(start_date,sysdate+1) < sysdate")
                                            ->whereRaw("nvl(end_date,sysdate+1) > sysdate")
                                            ->whereNull('deleted_at')->first();

                    $weight_id = !empty($getItemWeight->weight_id) ? $getItemWeight->weight_id : 0;
                    // $net_weight = !empty($getItemWeight->net_weight) ? $getItemWeight->net_weight : 0;
                    // $net_gross  = !empty($getItemWeight->net_gross) ? $getItemWeight->net_gross : 0;
                    $net_weight = !empty($value->weight_unit_net) ? $value->weight_unit_net : (!empty($getItemWeight->net_weight) ? $getItemWeight->net_weight : 0);
                    $net_gross  = !empty($value->weight_unit_gross) ? $value->weight_unit_gross : (!empty($getItemWeight->net_gross) ? $getItemWeight->net_gross : 0);

                    $totalNetWeight     = $value->order_quantity * $net_weight;
                    $totalNetGross      = $value->order_quantity * $net_gross;

                    $approveQuantity    = !empty($value->approve_quantity) ? $value->approve_quantity : 0.00;

                    $vatCodeLine        = !empty($value->vat_code) ? $value->vat_code : $dataVatCode;

                    $getPercentage  = TaxCode::where('tax_regime_code', 'SVAT')->where('rate_type_code', 'PERCENTAGE')->where('active_flag', 'Y')->where('tax_rate_code', $vatCodeLine)->pluck('percentage_rate')->first();
                    $percentage     = !empty($getPercentage) ? $getPercentage : 0;

                    $newTaxAmount      = ($value->amount * $percentage) / 100;
                    $newTotalAmount    = $value->amount + $newTaxAmount;

                    $orderLine[$key] = [
                        'order_line_id'         => $value->order_line_id,
                        'item_id'               => $value->item_id,
                        'item_code'             => $value->item_code,
                        'item_description'      => $value->item_description,
                        'uom_id'                => $value->uom_id,
                        'uom_code'              => $value->uom_code,
                        'uom'                   => $value->uom,
                        'order_quantity'        => !empty($value->order_quantity) ? $value->order_quantity : $approveQuantity,
                        'order_pi_quantity'     => $orderPiQuantity,
                        'unit_price'            => !empty($value->unit_price) ? $value->unit_price : 0.00,
                        'amount'                => !empty($value->amount) ? number_format((float)$value->amount, 2, '.', '') : 0.00,
                        'vat_code'              => $vatCodeLine,
                        'tax_amount'            => !empty($newTaxAmount) ? $newTaxAmount : 0.00,
                        'total_amount'          => !empty($newTotalAmount) ? $newTotalAmount : 0.00,
                        'weight_id'             => $weight_id,
                        'net_weight'            => $net_weight,
                        'net_gross'             => $net_gross,
                        'total_net_weight'      => $totalNetWeight,
                        'total_net_gross'       => $totalNetGross,
                    ];

                    $resultTotalNet     = $resultTotalNet + $totalNetWeight;
                    $resultTotalGross   = $resultTotalGross + $totalNetGross;
                    $resultSubTotal     = $resultSubTotal + $value->amount;
                    $resultTax          = $resultTax + $newTaxAmount;
                    $resultTotal        = $resultTotal + $value->total_amount + $newTaxAmount;
                    $totalAmount        = $totalAmount + $newTotalAmount;
                }
            }

            $resultWeight = [
                'result_net_weight'     => number_format((float)$resultTotalNet, 2, '.', ''),
                'result_gross_weight'   => number_format((float)$resultTotalGross, 2, '.', ''),
                'result_sub_total'      => number_format((float)$resultSubTotal, 2, '.', ''),
                'result_tax'            => number_format((float)$resultTax, 2, '.', ''),
                'result_total'          => number_format((float)$totalAmount, 2, '.', ''),
            ];

            $matchInvoice = PaymentMatchInvoices::where('prepare_order_number', $request->prepare_order_number)->where('match_flag', 'Y')->get();

            $paymentAmount = 0;

            if (!$matchInvoice->isEmpty()) {
                foreach ($matchInvoice as $key => $invoice) {
                    $invoiceAmount = PaymentApplyCNDN::where('payment_match_id', $invoice->payment_match_id)->whereNull('deleted_at')->sum('invoice_amount');
                    $paymentAmount = ($paymentAmount + $invoice->payment_amount) + $invoiceAmount;
                }
            }

            // ยอดคงค้าง
            $resultAmount = $totalAmount - $paymentAmount;

            // echo '<pre>';
            // print_r($dataList);
            // echo '<pre>';
            // exit();

            $attachmentFile = AttachFiles::where('attachment_program_code','OMP0066')->where('header_id', $getData->order_header_id)->whereNull('deleted_at')->get();

            $rest = [
                'resultTotalAmount'     => $resultAmount,
                'orderLine'             => $orderLine,
                'resultWeights'         => $resultWeight,
                'shipSitesList'         => $shipSitesList,
                'data'                  => $dataList,
                'status'                => 'success',
                'attachmentFile'        => $attachmentFile
            ];
        }else{
            $resultWeight = [
                'result_net_weight'     => $resultTotalNet,
                'result_gross_weight'   => $resultTotalGross,
                'result_sub_total'      => $resultSubTotal,
                'result_tax'            => $resultTax,
                'result_total'          => $resultTotal
            ];

            $rest = [
                'resultTotalAmount'     => $resultAmount,
                'orderLine'             => $orderLine,
                'resultWeights'         => $resultWeight,
                'shipSitesList'         => $shipSitesList,
                'data'                  => $dataList,
                'status'                => 'false',
                'attachmentFile'        => $attachmentFile
            ];
        }



        return response()->json(['data' => $rest]);
    }

    public function copyToProformaInvoice(Request $request)
    {
        $rest                   = [];
        $dataList               = [];
        $orderLine              = [];
        $shipSitesList          = [];
        $resultWeight           = [];
        $resultTotalNet         = 0.00;
        $resultTotalGross       = 0.00;
        $resultSubTotal         = 0.00;
        $resultTax              = 0.00;
        $resultTotal            = 0.00;
        $resultAmount           = 0.00;
        $piNumber               = '';

        // echo '<pre>';
        // print_r($request->all());
        // echo '<pre>';
        // exit();

        $validate = Validator::make($request->all(),[
            'prepare_order_number'          => 'required|string',
            'order_header_id'                  => 'required|string'
        ]);

        if($validate->fails()){
            $rest = [
                'status'    => false,
                'type'      => 'validate',
                'data'      => $validate->errors()
            ];
            return response()->json($rest);
        }else{

            $getOrderHeadersData = OrderHeaders::where('order_header_id', $request->order_header_id)->first();

            if(!empty($getOrderHeadersData)){

                // Genarate Number
                // $last = ProformaInvoiceHeaders::where('pi_number', 'LIKE', 'PI'.'%')->whereNotNull('pi_number')->orderBy('pi_number','desc')->first();

                // if(empty($last->pi_number)){
                //     $piNumber = 'PI2101001';
                // }else{
                //     $last_number = explode('PI',$last->pi_number);
                //     if(empty(is_numeric($last_number[1]))){
                //         $newnumber = sprintf('%07d', 1);
                //     }
                //     else if(is_numeric($last_number[1])){
                //         $newnumber = sprintf('%07d', $last_number[1]+1);
                //     }else{
                //         $newnumber = sprintf('%07d', 1);
                //     }
                //     $piNumber = 'PI'.$newnumber;
                // }


                // วันที่
                if(!empty($request->sa_date)){
                    $dateArr    = explode('/', $request->sa_date);
                    $day        = $dateArr[0];
                    $month      = $dateArr[1];
                    $year       = $dateArr[2];
                    $newDate    = $month.'/'.$day.'/'.$year;

                    $saTime = strtotime($newDate);
                    $saDate = date('Y-m-d H:i:s',$saTime);
                }else{
                    $saDate = '';
                }

                // GENERATE NUMBER
                $piNumber   = GenerateNumberRepo::generateCopyToPI('OMP0072_PI_NUM_EXP');
                $attrNumber = GenerateNumberRepo::generateCopyToIN('OMP0072_IN_NUM_EXP');

                $orgId = DB::table('hr_organization_units_v')->select('organization_id')->where('name', 'การยาสูบแห่งประเทศไทย')->pluck('organization_id')->first();


                $dataInsert = [
                    'pi_number'                 => $piNumber,
                    'attribute1'                => $attrNumber,
                    'pi_date'                   => date('Y-m-d H:i:s'),
                    'order_status'              => 'Draft',
                    'order_date'                => $getOrderHeadersData->order_date,
                    'customer_id'               => $getOrderHeadersData->customer_id,
                    'order_header_id'           => $getOrderHeadersData->order_header_id,
                    'sa_number'                 => $getOrderHeadersData->prepare_order_number,
                    'sa_date'                   => $saDate,
                    'org_id'                    => !empty($orgId) ? $orgId : '',
                    'cust_po_number'            => $getOrderHeadersData->cust_po_number,
                    'order_type_id'             => !empty($getOrderHeadersData->order_type_id) ? $getOrderHeadersData->order_type_id : 0,
                    'product_type_code'         => !empty($getOrderHeadersData->product_type_code) ? $getOrderHeadersData->product_type_code : '',
                    'order_source'              => 'WEB',
                    'currency'                  => $getOrderHeadersData->currency,
                    'term_id'                   => !empty($getOrderHeadersData->term_id) ? $getOrderHeadersData->term_id : 0,
                    'payment_type_code'         => $getOrderHeadersData->payment_type_code,
                    'payment_method_code'       => $getOrderHeadersData->payment_method_code,
                    'vat_code'                  => $getOrderHeadersData->vat_code,
                    'remark'                    => $getOrderHeadersData->remark,
                    'bill_to_site_id'           => $getOrderHeadersData->bill_to_site_id,
                    'ship_to_site_id'           => $getOrderHeadersData->ship_to_site_id,
                    'incoterms_code'            => $getOrderHeadersData->incoterms_code,
                    'port_of_loading'           => $getOrderHeadersData->port_of_loading,
                    'port_of_discharge'         => $getOrderHeadersData->port_of_discharge,
                    'shipping_marks'            => $getOrderHeadersData->shipping_marks,
                    'transport_type_code'       => $getOrderHeadersData->transport_type_code,
                    'transport_detail'          => $getOrderHeadersData->transport_detail,
                    'shipment_condition'        => $getOrderHeadersData->shipment_condition,
                    'period_id'                 => $getOrderHeadersData->period_id,
                    'sub_total'                 => $getOrderHeadersData->sub_total,
                    'tax'                       => $getOrderHeadersData->tax,
                    'cash_amount'               => $getOrderHeadersData->cash_amount,
                    'credit_amount'             => $getOrderHeadersData->credit_amount,
                    'grand_total'               => $getOrderHeadersData->grand_total,
                    'request_date'              => date('Y-m-d H:i:s'),
                    'remaining_amount'          => $getOrderHeadersData->remaining_amount,
                    'fines_amount'              => $getOrderHeadersData->fines_amount,
                    'source_system'             => $getOrderHeadersData->source_system,
                    'remark_source_system'      => $getOrderHeadersData->remark_source_system,
                    'skip_peroid_flag'          => $getOrderHeadersData->skip_peroid_flag,
                    'payment_duedate'           => $getOrderHeadersData->payment_duedate,
                    'ar_invoice_id'             => $getOrderHeadersData->ar_invoice_id,
                    'delivery_date'             => $getOrderHeadersData->delivery_date,
                    'contract_group_id'         => $getOrderHeadersData->contract_group_id,
                    'ref_order_header_id'       => $getOrderHeadersData->order_header_id,
                    'pricing_date'              => $getOrderHeadersData->pricing_date,
                    'price_list_id'             => $getOrderHeadersData->price_list_id,
                    'tax_exempt_flag'           => $getOrderHeadersData->tax_exempt_flag,
                    'tax_exempt_number'         => $getOrderHeadersData->tax_exempt_number,
                    'tax_exempt_reason_code'    => $getOrderHeadersData->tax_exempt_reason_code,
                    'salesrep_id'               => $getOrderHeadersData->salesrep_id,
                    'warehouse_id'              => $getOrderHeadersData->warehouse_id,
                    'payment_header_id'         => $getOrderHeadersData->payment_header_id,
                    'pick_release_id'           => $getOrderHeadersData->pick_release_id,
                    'pick_release_no'           => $getOrderHeadersData->pick_release_no,
                    'pick_release_status'       => $getOrderHeadersData->pick_release_status,
                    'pick_release_approve_flag' => $getOrderHeadersData->pick_release_approve_flag,
                    'pick_release_approve_date' => $getOrderHeadersData->pick_release_approve_date,
                    'pick_release_approve_by'   => $getOrderHeadersData->pick_release_approve_by,
                    'issue_flag'                => $getOrderHeadersData->issue_flag,
                    'ready_for_issue_flag'      => $getOrderHeadersData->ready_for_issue_flag,
                    'issue_number'              => $getOrderHeadersData->issue_number,
                    'issue_date'                => $getOrderHeadersData->issue_date,
                    'sale_confirm_document_no'  => $getOrderHeadersData->sale_confirm_document_no,
                    'sale_confirm_flag'         => $getOrderHeadersData->sale_confirm_flag,
                    'sale_confirm_date'         => $getOrderHeadersData->sale_confirm_date,
                    'sale_confirm_by'           => $getOrderHeadersData->sale_confirm_by,
                    'place_of_delivery'         => $getOrderHeadersData->port_of_discharge,
                    'exchange_rate'             => 1,
                    'program_code'              => 'OMP0066',
                    'created_by'                => optional(auth()->user())->user_id,
                    'created_at'                => date('Y-m-d'),
                    'creation_date'             => date('Y-m-d'),
                    'updated_by_id'             => optional(auth()->user())->user_id,
                    'updated_at'                => date('Y-m-d'),
                    'last_updated_by'           => optional(auth()->user())->user_id,
                    'last_update_date'          => date('Y-m-d')
                ];

                // echo '<pre>';
                // print_r($dataInsert);
                // echo '<pre>';
                // exit();

                ProformaInvoiceHeaders::insert($dataInsert);

                $getLastHeaderID = ProformaInvoiceHeaders::select('pi_header_id')->orderBy('pi_header_id', 'desc')->pluck('pi_header_id')->first();

                $allAmount      = 0;
                $alltaxAmount   = 0;
                $allLineAmount  = 0;

                foreach ($request->select_copy as $key => $valueLine) {

                    $getOrderLines = OrderLines::where('order_line_id', $valueLine)->first();

                    $orderQuantity  = !empty($request->pi_amount[$valueLine]) ? $request->pi_amount[$valueLine] : 0;
                    $piLineAmount   = (float)$orderQuantity * (float)$getOrderLines->unit_price;

                    $getPercentage  = TaxCode::where('tax_regime_code', 'SVAT')->where('rate_type_code', 'PERCENTAGE')->where('active_flag', 'Y')->where('tax_rate_code', $getOrderLines->vat_code)->pluck('percentage_rate')->first();
                    $percentage     = !empty($getPercentage) ? $getPercentage : 0;

                    $taxAmount      = ($piLineAmount * $percentage) / 100;
                    $totalAmount    = $piLineAmount + $taxAmount;

                    // $getItemWeight = ItemWeights::where('weight_id', $getOrderLines->weight_id)->where('active_flag', 'Y')->first();

                    // $net_weight     = 0;
                    // $net_gross      = 0;

                    // $totalNetWeight = 0;
                    // $totalNetGross  = 0;

                    // if (!empty($getItemWeight->net_weight)) {
                    //     $net_weight = !empty($getItemWeight->net_weight) ? $getItemWeight->net_weight : 0;
                    //     $net_gross  = !empty($getItemWeight->net_gross) ? $getItemWeight->net_gross : 0;

                    //     $totalNetWeight = $orderQuantity * $net_weight;
                    //     $totalNetGross  = $orderQuantity * $net_gross;
                    // }

                    $allAmount      = $allAmount + $piLineAmount;
                    $alltaxAmount   = $alltaxAmount + $taxAmount;
                    $allLineAmount  = $allLineAmount + $totalAmount;


                    $lineNumber     = $key+1;

                    if (empty($getOrderLines->weight_id)) {
                        $getItemWeight = ItemWeights::where('item_code', $getOrderLines->item_code)
                                            ->where('active_flag', 'Y')
                                            // ->whereRaw("nvl(start_date,sysdate+1) < sysdate")
                                            ->whereRaw("nvl(end_date,sysdate+1) > sysdate")
                                            ->whereNull('deleted_at')->first();

                        $getOrderLines->weight_id = !empty($getItemWeight->weight_id) ? $getItemWeight->weight_id : 0;
                        $getOrderLines->weight_unit_net = !empty($getItemWeight->net_weight) ? $getItemWeight->net_weight : 0;
                        $getOrderLines->weight_unit_gross = !empty($getItemWeight->net_gross) ? $getItemWeight->net_gross : 0;
                    }

                    $dataProformaLines = [
                        'pi_header_id'              => $getLastHeaderID,
                        'line_number'               => $lineNumber,
                        'item_id'                   => $getOrderLines->item_id,
                        'item_code'                 => $getOrderLines->item_code,
                        'item_description'          => $getOrderLines->item_description,
                        'ref_order_header_id'       => $getOrderLines->order_header_id,
                        'ref_order_line_id'         => $getOrderLines->order_line_id,
                        'unit_price'                => $getOrderLines->unit_price,
                        'order_quantity'            => $orderQuantity,
                        'approve_quantity'          => $orderQuantity,
                        'uom_code'                  => $getOrderLines->uom_code,
                        'uom'                       => $getOrderLines->uom,
                        'amount'                    => number_format((float)$piLineAmount, 2, '.', ''),
                        'tax_amount'                => number_format((float)$taxAmount, 2, '.', ''),
                        'total_amount'              => number_format((float)$totalAmount, 2, '.', ''),
                        'promotion_id'              => $getOrderLines->promotion_id,
                        'promotion_product_id'      => $getOrderLines->promotion_product_id,
                        'remark'                    => $getOrderLines->remark,
                        'vat_code'                  => $getOrderLines->vat_code,
                        'weight_id'                 => $getOrderLines->weight_id,
                        'weight_unit_net'           => $getOrderLines->weight_unit_net,
                        'weight_unit_gross'         => $getOrderLines->weight_unit_gross,
                        'total_net_weight'          => $getOrderLines->total_net_weight,
                        'total_net_gross'           => $getOrderLines->total_net_gross,
                        'program_code'              => 'OMP0066',
                        'created_by'                => optional(auth()->user())->user_id,
                        'created_at'                => date('Y-m-d'),
                        'creation_date'             => date('Y-m-d'),
                        'updated_by_id'             => optional(auth()->user())->user_id,
                        'updated_at'                => date('Y-m-d'),
                        'last_updated_by'           => optional(auth()->user())->user_id,
                        'last_update_date'          => date('Y-m-d')
                    ];

                    ProformaInvoiceLines::insert($dataProformaLines);
                }

                $dataUpdate = [
                    'sub_total'     => $allAmount,
                    'tax'           => $alltaxAmount,
                    'grand_total'   => $allLineAmount
                ];

                ProformaInvoiceHeaders::where('pi_header_id', $getLastHeaderID)->update($dataUpdate);

                // echo '<pre>';
                // print_r($dataProformaLines);
                // echo '<pre>';
                // exit();

                // Reload Data

                $orderSelect = [
                    'ptom_order_headers.prepare_order_number',
                    'ptom_order_headers.order_number',
                    'ptom_order_headers.order_date',
                    'ptom_order_headers.sa_status',
                    'ptom_order_headers.sa_date',
                    'ptom_order_headers.order_status',
                    'ptom_order_headers.customer_id',
                    'ptom_order_headers.cust_po_number',
                    'ptom_customers.customer_number',
                    'ptom_customers.customer_name'
                ];
                $saList = OrderHeaders::join('ptom_customers', 'ptom_order_headers.customer_id', '=', 'ptom_customers.customer_id')
                                            ->select($orderSelect)
                                            ->where('ptom_customers.sales_classification_code', 'Export')
                                            // ->where('ptom_order_headers.order_status', 'Draft')
                                            // ->whereNotNull('ptom_order_headers.prepare_order_number')
                                            // ->whereNotNull('ptom_order_headers.order_number')
                                            ->orderBy('ptom_order_headers.prepare_order_number', 'desc')
                                            ->whereNull('ptom_order_headers.deleted_at')
                                            ->groupBy($orderSelect)
                                            ->get();

                foreach ($saList as $key => $value) {
                    if ($value->sa_status == '') {
                        $saList[$key]->sa_status    = 'Draft';
                    }

                    $saList[$key]->sa_date      = !empty($value->sa_date) ? dateFormatDMYDefault(date('m/d/Y',strtotime($value->sa_date))) : $value->sa_date;
                    $saList[$key]->order_date   = !empty($value->order_date) ? dateFormatDMYDefault(date('m/d/Y',strtotime($value->order_date))) : $value->order_date;
                }

                $getOrderLines = OrderLines::where('order_header_id', $request->order_header_id)->whereNull('deleted_at')->orderBy('item_code', 'asc')->get();

                // echo '<pre>';
                // print_r($getOrderLines);
                // echo '<pre>';
                // exit();

                $totalAmount = 0;

                if(!empty($getOrderLines)){

                    foreach ($getOrderLines as $key => $value) {

                        $orderPiQuantity = ProformaInvoiceLines::where('ref_order_header_id', $request->order_header_id)->where('ref_order_line_id', $value->order_line_id)->whereNull('cancelled_flag')->sum('order_quantity');

                        // echo '<pre>';
                        // print_r($orderPiQuantity);
                        // echo '<pre>';
                        // exit();

                        $getItemWeight = ItemWeights::where('item_code', $value->item_code)
                                                ->where('active_flag', 'Y')
                                                // ->whereRaw("nvl(start_date,sysdate+1) < sysdate")
                                                ->whereRaw("nvl(end_date,sysdate+1) > sysdate")
                                                ->whereNull('deleted_at')->first();

                        $weight_id = !empty($getItemWeight->weight_id) ? $getItemWeight->weight_id : 0;
                        // $net_weight = !empty($getItemWeight->net_weight) ? $getItemWeight->net_weight : 0;
                        // $net_gross  = !empty($getItemWeight->net_gross) ? $getItemWeight->net_gross : 0;
                        $net_weight = !empty($value->weight_unit_net) ? $value->weight_unit_net : (!empty($getItemWeight->net_weight) ? $getItemWeight->net_weight : 0);
                        $net_gross  = !empty($value->weight_unit_gross) ? $value->weight_unit_gross : (!empty($getItemWeight->net_gross) ? $getItemWeight->net_gross : 0);

                        $approve_quantity   = !empty($value->order_quantity) ? number_format((float)$value->order_quantity, 2, '.', '') : 0.00;
                        $unit_price         = !empty($value->unit_price) ? number_format((float)$value->unit_price, 2, '.', '') : 0.00;
                        $totalNetWeight     = $value->order_quantity * $net_weight;
                        $totalNetGross      = $value->order_quantity * $net_gross;

                        $vatCode        = !empty($value->vat_code) ? $value->vat_code : $request->vat_code;
                        $getPercentage  = TaxCode::where('tax_rate_code', $vatCode)->pluck('percentage_rate')->first();
                        $taxAmount      = number_format((float)($approve_quantity * $unit_price) * $getPercentage / 100, 2, '.', '');

                        $total_amount       = !empty($value->total_amount) ? $value->total_amount : 0.00;
                        $lineAmount         = $total_amount + $taxAmount;

                        $orderLine[$key] = [
                            'order_line_id'         => $value->order_line_id,
                            'item_id'               => $value->item_id,
                            'item_code'             => $value->item_code,
                            'item_description'      => $value->item_description,
                            'uom_code'              => $value->uom_code,
                            'uom'                   => $value->uom,
                            'order_quantity'        => !empty($value->order_quantity) ? $value->order_quantity : 0,
                            'order_pi_quantity'     => $orderPiQuantity,
                            'unit_price'            => $value->unit_price,
                            'amount'                => !empty($value->amount) ? number_format((float)$value->amount, 2, '.', '') : 0.00,
                            'vat_code'              => $value->vat_code,
                            'tax_amount'            => $value->tax_amount,
                            'total_amount'          => $value->total_amount,
                            'weight_id'             => $weight_id,
                            'net_weight'            => $net_weight,
                            'net_gross'             => $net_gross,
                            'total_net_weight'      => number_format((float)$totalNetWeight, 2, '.', ''),
                            'total_net_gross'       => number_format((float)$totalNetGross, 2, '.', ''),
                        ];

                        $resultTotalNet     = $resultTotalNet + $totalNetWeight;
                        $resultTotalGross   = $resultTotalGross + $totalNetGross;
                        $resultSubTotal     = $resultSubTotal + $value->amount;
                        $resultTax          = $resultTax + $taxAmount;
                        $resultTotal        = $resultTotal + $value->total_amount + $taxAmount;
                        $totalAmount        = $totalAmount + $value->total_amount;
                    }

                    $resultWeight = [
                        'result_net_weight'     => number_format((float)$resultTotalNet, 2, '.', ''),
                        'result_gross_weight'   => number_format((float)$resultTotalGross, 2, '.', ''),
                        'result_sub_total'      => number_format((float)$resultSubTotal, 2, '.', ''),
                        'result_tax'            => number_format((float)$resultTax, 2, '.', ''),
                        'result_total'          => number_format((float)$resultTotal, 2, '.', ''),
                    ];

                    $matchInvoice = PaymentMatchInvoices::where('prepare_order_number', $request->prepare_order_number)->where('match_flag', 'Y')->get();

                    $paymentAmount = 0;

                    if (!$matchInvoice->isEmpty()) {
                        foreach ($matchInvoice as $key => $invoice) {
                            $invoiceAmount = PaymentApplyCNDN::where('payment_match_id', $invoice->payment_match_id)->whereNull('deleted_at')->sum('invoice_amount');
                            $paymentAmount = ($paymentAmount + $invoice->payment_amount) + $invoiceAmount;
                        }
                    }

                    // ยอดคงค้าง
                    $resultAmount = $totalAmount - $paymentAmount;
                }

                // END Relead Data

                // echo '<pre>';
                // print_r($dataList);
                // echo '<pre>';
                // exit();

                $rest = [
                    'piNumber'              => $piNumber,
                    'orderLine'             => $orderLine,
                    'newSaList'             => $saList,
                    'resultTotalAmount'     => $resultAmount,
                    'orderLine'             => $orderLine,
                    'resultWeights'         => $resultWeight,
                    'shipSitesList'         => $shipSitesList,
                    'data'                  => $dataList,
                    'status'                => 'success',
                ];

            }else
            {
                $resultWeight = [
                    'result_net_weight'     => $resultTotalNet,
                    'result_gross_weight'   => $resultTotalGross,
                    'result_sub_total'      => $resultSubTotal,
                    'result_tax'            => $resultTax,
                    'result_total'          => $resultTotal
                ];

                $rest = [
                    'piNumber'              => $piNumber,
                    'orderLine'             => $orderLine,
                    'newSaList'             => [],
                    'resultTotalAmount'     => $resultAmount,
                    'orderLine'             => $orderLine,
                    'resultWeights'         => $resultWeight,
                    'shipSitesList'         => $shipSitesList,
                    'data'                  => 'Something wrong!',
                    'status'                => 'false',
                ];
            }
        }

        return response()->json(['data' => $rest]);
    }

    public function checkCancel($saNumber)
    {
        $rest = [];

        if (!empty($saNumber)) {
            $matchInvoice = PaymentMatchInvoices::where('prepare_order_number', $saNumber)->where('match_flag', '!=', 'Y')->get();

            if (!empty($matchInvoice)) {
                $rest = [
                    'status'    => 'success'
                ];
            }else{
                $rest = [
                    'status'    => 'retry'
                ];
            }
        }else{
            $rest = [
                'status'    => 'fail'
            ];
        }

        return response()->json(['data' => $rest]);
    }

    public function cancel_bak(Request $request)
    {
        $rest = [];

        // echo '<pre>';
        // print_r($request->all());
        // echo '<pre>';
        // exit();

        $update = [
            'sale_confirm_document_no'  => '',
            'sale_confirm_date'         => '',
            'sale_confirm_by'           => '',
            'prepare_order_number'      => '',
            'sa_date'                   => '',
            'sale_confirm_flag'         => 'N',
            'sa_cancel_reason'          => $request->sa_cancel_reason,
            'order_status'              => 'Draft',
            'sa_status'                 => $request->sa_status,
            'program_code'              => 'OMP0066',
            'updated_by_id'             => optional(auth()->user())->user_id,
            'updated_at'                => date('Y-m-d H:i:s'),
            'last_updated_by'           => optional(auth()->user())->user_id,
            'last_update_date'          => date('Y-m-d H:i:s')
        ];

        // echo '<pre>';
        // print_r($update);
        // echo '<pre>';
        // exit();

        if(OrderHeaders::where('order_header_id', $request->order_header_id)->update($update))
        {
            $updateLine = [
                'cancelled_flag'    => 'Y',
                'cancelled_date'    => date('Y-m-d H:i:s'),
                'program_code'      => 'OMP0066',
                'updated_by_id'     => optional(auth()->user())->user_id,
                'updated_at'        => date('Y-m-d H:i:s'),
                'last_updated_by'   => optional(auth()->user())->user_id,
                'last_update_date'  => date('Y-m-d H:i:s')
            ];

            OrderLines::where('order_header_id', $request->order_header_id)->update($updateLine);

            $getOrderHeader =  OrderHeaders::where('order_header_id', $request->order_header_id)->first();
            OrderRepo::insertOrdersHistoryv2($getOrderHeader, 'Draft');

            $getOrderHistory = OrderHistory::where('order_header_id', $request->order_header_id)->whereNull('deleted_at')->orderBy('order_history_id', 'asc')->get();

            $clearDataHistory = [
                'deleted_by_id'     => optional(auth()->user())->user_id,
                'deleted_at'        => date('Y-m-d H:i:s')
            ];

            if (!empty($getOrderHistory)) {
                foreach ($getOrderHistory as $key => $value) {
                    if ($key > 0) {
                        OrderHistory::where('order_history_id', $value->order_history_id)->update($clearDataHistory);
                    }
                }
            }


            $rest = [
                'status'    => 'success',
                'data'      => ''
            ];
        }else{
            $rest = [
                'status'    => 'fail',
                'data'      => ''
            ];
        }

        return response()->json(['data' => $rest]);
    }

    public function cancel(Request $request)
    {
        DB::beginTransaction();
        try {
            $orderHeader = OrderHeaders::where('order_header_id',$request->order_header_id)->orderBy('order_header_id','DESC')->first();
            $OrderStatusHistory = OrderStatusHistory::where('order_header_id',$request->order_header_id)->where('order_status','Draft')->orderBy('order_header_id','DESC')->first();
            $orderHeaderCopy = new OrderHeaders();

            foreach ($OrderStatusHistory->toArray() as $key => $v) {

                if($key != 'order_header_id' && $key != 'order_history_id'){
                    if($key == 'prepare_order_number'){
                        $orderHeaderCopy[$key] = null;
                    }elseif($key == 'order_number'){
                        $orderHeaderCopy[$key] = $orderHeader->order_number;
                    }elseif($key == 'attribute3'){
                        $orderHeaderCopy[$key] = $request->order_header_id;
                    }elseif($key == 'creation_date')
                    {
                        $orderHeaderCopy[$key] = Carbon::parse($v)->format('Y-m-d H:i:s');
                    }
                    else{
                        $orderHeaderCopy[$key] = $v;
                    }
                }
            }

            $orderHeaderCopy->save();
            $headerKey = $orderHeaderCopy->getKey();

            $orderLine = OrderLines::where('order_header_id',$orderHeader->order_header_id)->get();

            foreach ($orderLine as $key_line => $v_line) {

                $orderLineMaster = OrderLines::where('order_line_id',$v_line->order_line_id)->first();
                $orderLineCopy = new OrderLines();
                foreach ($orderLineMaster->toArray() as $key => $v) {
                    if($key != 'order_line_id'){
                        if($key == 'order_header_id'){
                            $orderLineCopy[$key] = $headerKey;
                        }elseif($key == 'approve_quantity' || $key == 'approve_cardboardbox' || $key == 'approve_carton'){
                            $orderLineCopy[$key] = null;
                        }else{
                            $orderLineCopy[$key] = $v;
                        }
                    }
                }

                $orderLineCopy->save();
            }


            OrderRepo::insertOrdersHistoryv2($orderHeaderCopy,'Draft');

            $orderHeader->sa_cancel_reason = $request->sa_cancel_reason;
            $orderHeader->sa_status = 'Cancelled';
            $orderHeader->order_status = 'Draft';

            OrderRepo::insertOrdersHistoryv2($orderHeader,'Cancelled');

            $orderHeader->save();

            DB::commit();

            $rest = [
                'status'    => 'success',
                'data'      => ''
            ];

        }catch (\Exception $e) {
            DB::rollBack();
            $rest = [
                'status'    => 'fail',
                'data'      => $e->getMessage()
            ];
        }

        return response()->json(['data' => $rest]);
    }

    public function customerShipsite($customerID)
    {
        $rest = [];

        $shipSitesList  = ShipSites::where('customer_id', $customerID)->where('status', 'Active')->whereNull('deleted_at')->get();

        if (!empty($shipSitesList)) {
            $rest = [
                'data'      => $shipSitesList,
                'status'    => 'success'
            ];
        }else{
            $rest = [
                'data'      => [],
                'status'    => 'false'
            ];
        }

        return response()->json(['data' => $rest]);
    }

    // public function checkOutstandingDebt($orderHeaderID)
    // {
    //     $rest = [];

    //     $outStandingDebt  = DB::table('ptom_outstanding_debt_exp_v')->where('order_header_id', $orderHeaderID)->where('outstanding_debt', '>', 0)->first();

    //     if (empty($outStandingDebt)) {
    //         $rest = [
    //             'data'      => $outStandingDebt,
    //             'status'    => 'success'
    //         ];
    //     }else{
    //         $rest = [
    //             'data'      => $outStandingDebt,
    //             'status'    => 'false'
    //         ];
    //     }

    //     return response()->json(['data' => $rest]);
    // }

    // VERSION NEW
    public function checkOutstandingDebt($piNumber)
    {
        $rest = [];

        $orderHeaderID = ProformaInvoiceHeaders::where('pi_number', $piNumber)->pluck('order_header_id')->first();

        $outStandingDebt  = DB::table('ptom_outstanding_debt_exp_v')->where('order_header_id', $orderHeaderID)->where('outstanding_debt', '>', 0)->first();

        if (empty($outStandingDebt)) {
            $rest = [
                'data'      => $outStandingDebt,
                'status'    => 'success'
            ];
        }else{
            $rest = [
                'data'      => $outStandingDebt,
                'status'    => 'false'
            ];
        }

        return response()->json(['data' => $rest]);
    }
}
