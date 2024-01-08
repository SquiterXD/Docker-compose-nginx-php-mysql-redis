<?php

namespace App\Http\Controllers\OM\Ajex;

use App\Http\Controllers\Controller;
use App\Models\OM\AttachFiles;
use App\Models\OM\Customers;
use App\Models\OM\OverdueDebt\PaymentApplyCNDN;
use App\Models\OM\OverdueDebt\PaymentMatchInvoices;
use App\Models\OM\SaleConfirmation\OrderHeaders;
use App\Models\OM\SaleConfirmation\OrderLines;
use App\Models\OM\SaleConfirmation\Currencies;
use App\Models\OM\SaleConfirmation\ItemWeights;
use App\Models\OM\SaleConfirmation\Onhand;
use App\Models\OM\SaleConfirmation\Organization;
use App\Models\OM\SaleConfirmation\ProformaInvoiceHeaders;
use App\Models\OM\SaleConfirmation\ProformaInvoiceLines;
use App\Models\OM\SaleConfirmation\ProformaInvoiceLots;
use App\Models\OM\SaleConfirmation\Terms;
use App\Models\OM\SaleConfirmation\ShipSites;
use App\Repositories\OM\AttachmentRepo;
use App\Repositories\OM\DirectDebitRepo;
use App\Repositories\OM\GenerateNumberRepo;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProformaInvoiceAjaxController extends Controller
{
    public function createProformaInvoice($number)
    {
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

        $getData = OrderHeaders::select('ptom_order_headers.*',
                                    'ptom_customers.currency as currency_customers',
                                    'ptom_customers.customer_number',
                                    'ptom_customers.customer_name',
                                    'ptom_customers.address_line1',
                                    'ptom_customers.address_line2',
                                    'ptom_customers.address_line3',
                                    'ptom_customers.alley',
                                    'ptom_customers.state',
                                    'ptom_customers.district',
                                    'ptom_customers.city',
                                    'ptom_customers.province_name',
                                    'ptom_customers.postal_code',
                                    'ptom_customers.country_name',
                                )->join('ptom_customers', 'ptom_order_headers.customer_id', '=', 'ptom_customers.customer_id')
                                ->where('ptom_order_headers.prepare_order_number', '=', $number)
                                ->whereNull('ptom_order_headers.deleted_at')->first();

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

            $shipSitesList  = ShipSites::where('customer_id', $getData->customer_id)->whereNull('deleted_at')->get();

            $newPINumber = GenerateNumberRepo::generateApprovePrepare('OMP0072_PI_NUM_EXP');

            $getData->pi_number = $newPINumber;

            $currency = '';
            $currency_name = '';

            if (!empty($getData->currency)) {
                if (ctype_upper($getData->currency)) {
                    $currency           = $getData->currency;
                }else{
                    if ($getData->currency == 'Bath') {
                        $currency       = 'THB';
                    }else{
                        $getCurrency = Currencies::select('currency_code')->where('name', $getData->currency)->first();
                        $currency           = $getCurrency->currency_code;
                    }
                }
            }

            $place_of_delivery = '';

            if (!empty($shipSitesList)) {
                foreach ($shipSitesList as $key => $valShip) {

                    // Place of delivery
                    if (!empty($getData->ship_to_site_id)) {
                        if ($valShip->ship_to_site_id == $getData->ship_to_site_id) {
                            $place_of_delivery = $valShip->ship_to_site_name;
                        }
                    }
                }
            }

            $insertPI = [
                'pi_number'                 => $newPINumber,
                'order_header_id'           => $getData->order_header_id,
                'sa_number'                 => $getData->prepare_order_number,
                'sa_date'                   => $getData->sa_date,
                'order_date'                => $getData->order_date,
                'org_id'                    => '81',
                'order_type_id'             => $getData->order_type_id,
                'product_type_code'         => $getData->product_type_code,
                'order_source'              => 'WEB',
                'cust_po_number'            => $getData->cust_po_number,
                'payment_type_code'         => $getData->payment_type_code,
                'payment_method_code'       => $getData->payment_method_code,
                'transport_type_code'       => $getData->transport_type_code,
                'transport_detail'          => $getData->transport_detail,
                'pi_date'                   => date('Y-m-d H:i:s'),
                'term_id'                   => $getData->term_id,
                'term_name'                 => !empty($getTerms->name) ? $getTerms->name : '',
                'order_status'              => 'Draft',
                'remark'                    => $getData->remark,
                'customer_id'               => $getData->customer_id,
                'bill_to_site_id'           => $getData->bill_to_site_id,
                'ship_to_site_id'           => $getData->ship_to_site_id,
                'currency'                  => $getData->currency,
                'sub_total'                 => $getData->sub_total,
                'tax'                       => $getData->tax,
                'grand_total'               => $getData->grand_total,
                'source_system'             => $getData->source_system,
                'delivery_date'             => date('Y-m-d H:i:s'),
                'sale_confirm_document_no'  => $getData->sale_confirm_document_no,
                'sale_confirm_flag'         => $getData->sale_confirm_flag,
                'sale_confirm_date'         => $getData->sale_confirm_date,
                'sale_confirm_by'           => $getData->sale_confirm_by,
                'vat_code'                  => $getData->vat_code,
                'incoterms_code'            => $getData->incoterms_code,
                'port_of_loading'           => $getData->port_of_loading,
                'port_of_discharge'         => $getData->port_of_discharge,
                'shipping_marks'            => $getData->shipping_marks,
                'place_of_delivery'         => $place_of_delivery,
                'program_code'              => 'OMP0072',
                'created_by'                => optional(auth()->user())->user_id,
                'created_by_id'             => optional(auth()->user())->user_id,
                'created_at'                => date('Y-m-d H:i:s'),
                'creation_date'             => date('Y-m-d H:i:s'),
                'updated_by_id'             => optional(auth()->user())->user_id,
                'updated_at'                => date('Y-m-d H:i:s'),
                'last_updated_by'           => optional(auth()->user())->user_id,
                'last_update_date'          => date('Y-m-d H:i:s')
            ];

            // echo '<pre>';
            // print_r($insertPI);
            // echo '<pre>';
            // exit();

            // ProformaInvoiceHeaders::insert($insertPI);

            $currency = '';
            $currency_name = '';

            if (!empty($getData->currency)) {
                if (ctype_upper($getData->currency)) {
                    $getCurrency = Currencies::select('name')->where('currency_code', $getData->currency)->first();
                    $currency_name      = !empty($getCurrency->name) ? $getCurrency->name : '';
                    $currency           = $getData->currency;
                }else{
                    if ($getData->currency == 'Bath') {
                        $currency_name      = 'Baht';
                        $currency           = 'THB';
                    }else{
                        $getCurrency = Currencies::select('currency_code')->where('name', $getData->currency)->first();
                        $currency           = !empty($getCurrency->currency_code) ? $getCurrency->currency_code : '';
                        $currency_name      = $getData->currency;
                    }
                }
            }

            $addressLine1        = $getData->address_line1 != null ? $getData->address_line1.', ' : '';
            $addressLine2        = $getData->address_line2 != null ? $getData->address_line2.', ' : '';
            $addressLine3        = $getData->address_line3 != null ? $getData->address_line3.', ' : '';
            $alley               = $getData->alley != null ? $getData->alley.', ' : '';
            $state               = $getData->state != null ? $getData->state.', ' : '';
            $district            = $getData->district != null ? $getData->district.', ' : '';
            $city                = $getData->city != null ? $getData->city.', ' : '';
            $provinceName        = $getData->province_name != null ? $getData->province_name.', ' : '';
            $postalCode          = $getData->postal_code != null ? $getData->postal_code.', ' : '';
            $country_name        = $getData->country_name != null ? $getData->country_name.'.' : '';

            $dataList = [
                'pi_header_id'              => $getData->pi_header_id,
                'pi_number'                 => $newPINumber,        // เลขที่ Pro
                'order_status'              => !empty($getData->order_status) ? $getData->order_status : 'Draft',       // Order Status
                'sa_number'                 => $getData->sa_number,                                                     // เลขที่ใบ SA
                'sa_date'                   => !empty($getData->sa_date) ? date('m/d/Y',strtotime($getData->sa_date)) : $getData->sa_date,
                'order_date'                => !empty($getData->order_date) ? date('m/d/Y',strtotime($getData->order_date)) : $getData->order_date,  // วันที่สั่งซื้อ
                'order_number'              => $getData->order_number,  // เลขที่ใบสั่งซื้อ
                'customer_id'               => $getData->customer_id,
                'customer_number'           => $getData->customer_number,
                'customer_name'             => $getData->customer_name,
                'order_type_id'             => $getData->order_type_id,
                'currency'                  => $currency,
                'currency_name'             => $currency_name,
                'customer_address'          => $addressLine1.$addressLine2.$addressLine3.$alley.$state.$district.$city.$provinceName.$postalCode.$country_name,
                'term_id'                   => $getData->term_id,
                'term_name'                 => !empty($getTerms->name) ? $getTerms->name : '',
                'term_description'          => !empty($getTerms->description) ? $getTerms->description : '',
                'payment_type_code'         => $getData->payment_type_code,
                'vat_code'                  => $getData->vat_code,
                'payment_method_code'       => $getData->payment_method_code,
                'remark'                    => $getData->remark,
                'bill_to_site_id'           => !empty($getData->bill_to_site_id) ? $getData->bill_to_site_id : $getData->customer_id,
                'bill_to_site_name'         => !empty($getData->bill_to_site_name) ? $getData->bill_to_site_name : $getData->customer_name,
                'ship_to_site_id'           => $getData->ship_to_site_id,
                'port_of_loading'           => !empty($getData->port_of_loading) ? $getData->port_of_loading : 'Tobacco Authority Of Thailand',
                'port_of_discharge'         => !empty($getData->port_of_discharge) ? $getData->port_of_discharge : $getData->ship_to_site_id,
                'place_of_delivery'         => $place_of_delivery,
                'incoterms_code'            => $getData->incoterms_code,
                'transport_type_code'       => $getData->transport_type_code,
                'transport_detail'          => $getData->transport_detail,
                'shipment_condition'        => $getData->shipment_condition,
                'shipping_marks'            => $getData->shipping_marks,
                'source_system'             => $getData->source_system,
                'delivery_date'             => date('m/d/Y'),
            ];

            // to do continue เหลือเพิ่ม order line ไป proforma invoice line

            $getOrderLines = OrderLines::where('order_header_id', $getData->order_header_id)->whereNull('deleted_at')->get();

            $totalAmount = 0;

            if($getOrderLines->isEmpty()){

                foreach ($getOrderLines as $key => $value) {

                    $getItemWeight = ItemWeights::where('weight_id', $value->weight_id)->whereNull('deleted_at')->first();

                    // $net_weight = !empty($getItemWeight->net_weight) ? $getItemWeight->net_weight : 0;
                    // $net_gross  = !empty($getItemWeight->net_gross) ? $getItemWeight->net_gross : 0;
                    $net_weight = !empty($value->weight_unit_net) ? $value->weight_unit_net : (!empty($getItemWeight->net_weight) ? $getItemWeight->net_weight : 0);
                    $net_gross  = !empty($value->weight_unit_gross) ? $value->weight_unit_gross : (!empty($getItemWeight->net_gross) ? $getItemWeight->net_gross : 0);

                    $totalNetWeight   = $value->order_quantity * $net_weight;
                    $totalNetGross    = $value->order_quantity * $net_gross;

                    $orderLine[] = [
                        'pi_line_id'            => $value->pi_line_id,
                        'item_code'             => $value->item_code,
                        'item_description'      => $value->item_description,
                        'uom_code'              => $value->uom_code,
                        'uom'                   => $value->uom,
                        'order_quantity'        => !empty($value->order_quantity) ? $value->order_quantity : 0,
                        'unit_price'            => !empty($value->unit_price) ? $value->unit_price : 0,
                        'amount'                => !empty($value->amount) ? $value->amount : 0,
                        'vat_code'              => $value->vat_code,
                        'tax_amount'            => !empty($value->tax_amount) ? $value->tax_amount : 0,
                        'total_amount'          => $value->total_amount,
                        'net_weight'            => $net_weight,
                        'net_gross'             => $net_gross,
                        'total_net_weight'      => number_format((float)$totalNetWeight, 2, '.', ''),
                        'total_net_gross'       => number_format((float)$totalNetGross, 2, '.', ''),
                    ];

                    $resultTotalNet     = $resultTotalNet + $totalNetWeight;
                    $resultTotalGross   = $resultTotalGross + $totalNetGross;
                    $resultSubTotal     = $resultSubTotal + $value->amount;
                    $resultTax          = $resultTax + $value->tax_amount;
                    $resultTotal        = $resultTotal + $value->total_amount + $value->tax_amount;
                    $totalAmount        = $totalAmount + $value->total_amount;
                }
            }

            $resultWeight = [
                'result_net_weight'     => number_format((float)$resultTotalNet, 2, '.', ''),
                'result_gross_weight'   => number_format((float)$resultTotalGross, 2, '.', ''),
                'result_sub_total'      => number_format((float)$resultSubTotal, 2, '.', ''),
                'result_tax'            => number_format((float)$resultTax, 2, '.', ''),
                'result_total'          => number_format((float)$resultTotal, 2, '.', ''),
            ];

            $paymentAmount = 0;

            if (!empty($getData->prepare_order_number)) {
                $matchInvoice = PaymentMatchInvoices::where('prepare_order_number', $getData->prepare_order_number)->get();

                if (!$matchInvoice->isEmpty()) {
                    foreach ($matchInvoice as $key => $invoice) {
                        $invoiceAmount = PaymentApplyCNDN::where('payment_match_id', $invoice->payment_match_id)->whereNull('deleted_at')->sum('invoice_amount');
                        $paymentAmount = ($paymentAmount + $invoice->payment_amount) + $invoiceAmount;
                    }
                }

                // ยอดคงค้าง
                $resultAmount = $totalAmount - $paymentAmount;
            }

            // echo '<pre>';
            // print_r($dataList);
            // echo '<pre>';
            // exit();

            $rest = [
                'resultTotalAmount'     => $resultAmount,
                'orderLine'             => $orderLine,
                'resultWeights'         => $resultWeight,
                'shipSitesList'         => $shipSitesList,
                'data'                  => $dataList,
                'status'                => 'success',
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

        $getData = ProformaInvoiceHeaders::select('ptom_proforma_invoice_headers.*',
                                    'ptom_order_headers.order_number',
                                    'ptom_customers.currency as currency_customers',
                                    'ptom_customers.customer_number',
                                    'ptom_customers.customer_name',
                                    'ptom_customers.address_line1',
                                    'ptom_customers.address_line2',
                                    'ptom_customers.address_line3',
                                    'ptom_customers.alley',
                                    'ptom_customers.state',
                                    'ptom_customers.district',
                                    'ptom_customers.city',
                                    'ptom_customers.province_name',
                                    'ptom_customers.postal_code',
                                    'ptom_customers.country_name',
                                    'ptom_customers.price_list_id as customer_price_list_id'
                                )->join('ptom_customers', 'ptom_proforma_invoice_headers.customer_id', '=', 'ptom_customers.customer_id')
                                ->join('ptom_order_headers', 'ptom_proforma_invoice_headers.order_header_id', '=', 'ptom_order_headers.order_header_id')
                                ->where(function($query) use($request) {
                                    if(!empty($request->pi_number)) {
                                        $query->where('ptom_proforma_invoice_headers.pi_number', $request->pi_number);
                                    }
                                    if(!empty($request->order_number)) {
                                        $query->where('ptom_order_headers.order_number', $request->order_number);
                                    }
                                    if(!empty($request->sa_number)) {
                                        $query->where('ptom_proforma_invoice_headers.sa_number', $request->sa_number);
                                    }
                                    if(!empty($request->customer_id)) {
                                        $query->where('ptom_proforma_invoice_headers.customer_id', $request->customer_id);
                                    }
                                })
                                ->whereNull('ptom_proforma_invoice_headers.deleted_at')->first();

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

            $shipSitesList  = ShipSites::where('customer_id', $getData->customer_id)->whereNull('deleted_at')->get();

            $currency = '';
            $currency_name = '';

            if (!empty($getData->currency)) {
                if (ctype_upper($getData->currency)) {
                    $getCurrency = Currencies::select('name')->where('currency_code', $getData->currency)->first();
                    $currency_name      = !empty($getCurrency->name) ? $getCurrency->name : '';
                    $currency           = $getData->currency;
                }else{
                    if ($getData->currency == 'Bath') {
                        $currency_name  = 'Baht';
                        $currency       = 'THB';
                    }else{
                        $getCurrency = Currencies::select('currency_code', 'name')->where('name', $getData->currency)->first();
                        $currency           = $getCurrency->currency_code;
                        $currency_name      = !empty($getCurrency->name) ? $getCurrency->name : '';
                    }
                }
            }

            $getDataOrderHeader = OrderHeaders::where('order_header_id', $getData->order_header_id)->first();

            $addressLine1        = $getData->address_line1 != null ? $getData->address_line1.', ' : '';
            $addressLine2        = $getData->address_line2 != null ? $getData->address_line2.', ' : '';
            $addressLine3        = $getData->address_line3 != null ? $getData->address_line3.', ' : '';
            $alley               = $getData->alley != null ? $getData->alley.', ' : '';
            $state               = $getData->state != null ? $getData->state.', ' : '';
            $district            = $getData->district != null ? $getData->district.', ' : '';
            $city                = $getData->city != null ? $getData->city.', ' : '';
            $provinceName        = $getData->province_name != null ? $getData->province_name.', ' : '';
            $postalCode          = $getData->postal_code != null ? $getData->postal_code.', ' : '';
            $country_name        = $getData->country_name != null ? $getData->country_name.'.' : '';

            $dataList = [
                'pi_header_id'              => $getData->pi_header_id,
                'order_header_id'              => $getData->order_header_id,
                'order_status'              => !empty($getData->order_status) ? $getData->order_status : 'Draft',
                'sa_number'                 => $getData->sa_number,
                'pi_date'                   => !empty($getData->pi_date) ? dateFormatDMYDefault(date('m/d/Y',strtotime($getData->pi_date))) : $getData->pi_date,
                'sa_date'                   => !empty($getData->sa_date) ? dateFormatDMYDefault(date('m/d/Y',strtotime($getData->sa_date))) : $getData->sa_date,
                'order_number'              => !empty($getDataOrderHeader->order_number) ? $getDataOrderHeader->order_number : '',
                'order_date'                => !empty($getData->order_date) ? dateFormatDMYDefault(date('m/d/Y',strtotime($getData->order_date))) : $getData->order_date,
                'cust_po_number'            => $getData->cust_po_number,
                'customer_id'               => $getData->customer_id,
                'customer_number'           => $getData->customer_number,
                'customer_name'             => $getData->customer_name,
                'order_type_id'             => $getData->order_type_id,
                'currency'                  => $currency,
                'currency_name'             => $currency_name,
                'customer_address'          => $addressLine1.$addressLine2.$addressLine3.$alley.$state.$district.$city.$provinceName.$postalCode.$country_name,
                'term_id'                   => $getData->term_id,
                'term_name'                 => !empty($getTerms->name) ? $getTerms->name : '',
                'term_description'          => !empty($getTerms->description) ? $getTerms->description : '',
                'payment_type_code'         => $getData->payment_type_code,
                'vat_code'                  => $getData->vat_code,
                'payment_method_code'       => $getData->payment_method_code,
                'product_type_code'         => $getData->product_type_code,
                'remark'                    => $getData->remark,
                'bill_to_site_id'           => !empty($getData->bill_to_site_id) ? $getData->bill_to_site_id : $getData->customer_id,
                'price_list_id'             => !empty($getData->price_list_id) ? $getData->price_list_id : $getData->customer_price_list_id,
                'bill_to_site_name'         => !empty($getData->bill_to_site_name) ? $getData->bill_to_site_name : $getData->customer_name,
                'ship_to_site_id'           => $getData->ship_to_site_id,
                'incoterms_code'            => $getData->incoterms_code,
                'port_of_loading'           => !empty($getData->port_of_loading) ? $getData->port_of_loading : 'Tobacco Authority Of Thailand',
                'transport_type_code'       => $getData->transport_type_code,
                'transport_detail'          => $getData->transport_detail,
                'port_of_discharge'         => !empty($getData->port_of_discharge) ? $getData->port_of_discharge : "",
                'place_of_delivery'         => !empty($getData->place_of_delivery) ? $getData->place_of_delivery : "",
                'shipment_condition'        => $getData->shipment_condition,
                'shipping_marks'            => $getData->shipping_marks,
                'source_system'             => $getData->source_system,
                'delivery_date'             => !empty($getData->delivery_date) ? dateFormatDMYDefault(date('m/d/Y',strtotime($getData->delivery_date))) : $getData->delivery_date,
                'sale_confirm_date'         => !empty($getData->sale_confirm_date) ? dateFormatDMYDefault(date('m/d/Y',strtotime($getData->sale_confirm_date))) : $getData->sale_confirm_date,
                'sale_confirm_document_no'  => $getData->sale_confirm_document_no,
            ];

            $getOrderLines = ProformaInvoiceLines::where('pi_header_id', $getData->pi_header_id)->orderBy('item_code')->get();

            // echo '<pre>';
            // print_r($dataList);
            // echo '<pre>';
            // exit();

            $totalAmount = 0;

            if(!$getOrderLines->isEmpty()){

                foreach ($getOrderLines as $key => $value) {

                    if (empty($value->weight_id)) {
                        $getItemWeight = ItemWeights::where('item_code', $value->item_code)
                                            ->where('active_flag', 'Y')
                                            // ->whereRaw("nvl(start_date,sysdate+1) < sysdate")
                                            ->whereRaw("nvl(end_date,sysdate+1) > sysdate")
                                            ->whereNull('deleted_at')->first();

                        $value->weight_id = !empty($getItemWeight->weight_id) ? $getItemWeight->weight_id : 0;
                    }

                    $getItemWeight = ItemWeights::where('weight_id', $value->weight_id)->whereNull('deleted_at')->first();

                    // $net_weight = !empty($getItemWeight->net_weight) ? $getItemWeight->net_weight : 0;
                    // $net_gross  = !empty($getItemWeight->net_gross) ? $getItemWeight->net_gross : 0;
                    $net_weight = !empty($value->weight_unit_net) ? $value->weight_unit_net : (!empty($getItemWeight->net_weight) ? $getItemWeight->net_weight : 0);
                    $net_gross  = !empty($value->weight_unit_gross) ? $value->weight_unit_gross : (!empty($getItemWeight->net_gross) ? $getItemWeight->net_gross : 0);

                    $totalNetWeight   = $value->order_quantity * $net_weight;
                    $totalNetGross    = $value->order_quantity * $net_gross;


                    $orderLine[$key] = [
                        'pi_line_id'            => $value->pi_line_id,
                        'item_code'             => $value->item_code,
                        'item_description'      => $value->item_description,
                        'uom_code'              => $value->uom_code,
                        'uom'                   => $value->uom,
                        'order_quantity'        => !empty($value->order_quantity) ? $value->order_quantity : 0,
                        'unit_price'            => !empty($value->unit_price) ? $value->unit_price : 0,
                        'amount'                => !empty($value->amount) ? $value->amount : 0,
                        'vat_code'              => $value->vat_code,
                        'tax_amount'            => !empty($value->tax_amount) ? $value->tax_amount : 0,
                        'total_amount'          => $value->total_amount,
                        'net_weight'            => $net_weight,
                        'net_gross'             => $net_gross,
                        'total_net_weight'      => number_format((float)$totalNetWeight, 2, '.', ''),
                        'total_net_gross'       => number_format((float)$totalNetGross, 2, '.', ''),
                    ];

                    $resultTotalNet     = $resultTotalNet + $totalNetWeight;
                    $resultTotalGross   = $resultTotalGross + $totalNetGross;
                    $resultSubTotal     = $resultSubTotal + $value->amount;
                    $resultTax          = $resultTax + $value->tax_amount;
                    $resultTotal        = $resultSubTotal + $resultTax;
                    $totalAmount        = $totalAmount + $value->total_amount;
                }
            }

            $resultWeight = [
                'result_net_weight'     => number_format((float)$resultTotalNet, 2, '.', ''),
                'result_gross_weight'   => number_format((float)$resultTotalGross, 2, '.', ''),
                'result_sub_total'      => number_format((float)$resultSubTotal, 2, '.', ''),
                'result_tax'            => number_format((float)$resultTax, 2, '.', ''),
                'result_total'          => number_format((float)$resultTotal, 2, '.', ''),
            ];

            $matchInvoice = PaymentMatchInvoices::where('prepare_order_number', $getData->sa_number)->where('match_flag', 'Y')->get();

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

            $orderHeaderID  = ProformaInvoiceHeaders::where('pi_header_id', $getData->pi_header_id)->pluck('order_header_id')->first();

            $attachmentFile = AttachFiles::where('attachment_program_code','OMP0066')->where('header_id', $orderHeaderID)->whereNull('deleted_at')->get();

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

    public function manageProformaInvoice(Request $request)
    {
        $rest = [];
        $attachmentFile         = [];

        // echo '<pre>';
        // print_r($request->all());
        // echo '<pre>';
        // exit();

        $validate = Validator::make($request->all(),[
            'pi_header_id'     => 'required|string',
        ]);

        if($validate->fails()){
            $rest = [
                'status'    => false,
                'type'      => 'validate',
                'data'      => $validate->errors()
            ];
            return response()->json($rest);
        }else{

            if(!empty($request->pi_header_id)){

                // วันที่
                if(!empty($request->pi_date)){
                    $dateArr    = explode('/', $request->pi_date);
                    $day        = $dateArr[0];
                    $month      = $dateArr[1];
                    $year       = $dateArr[2];
                    $newDate    = $month.'/'.$day.'/'.$year;

                    $piTime = strtotime($newDate);
                    $piDate = date('Y-m-d H:i:s',$piTime);
                }else{
                    $piDate = '';
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

                // วันที่ส่ง
                if(!empty($request->delivery_date)){
                    $dateArr    = explode('/', $request->delivery_date);
                    $day        = $dateArr[0];
                    $month      = $dateArr[1];
                    $year       = $dateArr[2] > 2300 ? $dateArr[2] - 543 : $dateArr[2];
                    $newDate    = $month.'/'.$day.'/'.$year;

                    $deliveryTime = strtotime($newDate);
                    $deliveryDate = date('Y-m-d H:i:s',$deliveryTime);
                }else{
                    $deliveryDate = '';
                }


                $update = [
                    'order_status'              => $request->order_status,
                    'pi_date'                   => $piDate,
                    'order_date'                => $orderDate,
                    'sa_number'                 => $request->sa_number,
                    'customer_id'               => $request->customer_id,
                    'order_type_id'             => !empty($request->order_type_id) ? $request->order_type_id : 0,
                    'currency'                  => $request->currency,
                    'term_id'                   => !empty($request->term_id) ? $request->term_id : 0,
                    'payment_type_code'         => $request->payment_type_code,
                    'vat_code'                  => $request->vat_code,
                    'payment_method_code'       => $request->payment_method_code,
                    'remark'                    => $request->remark,
                    'bill_to_site_id'           => $request->bill_to_site_id,
                    'ship_to_site_id'           => $request->ship_to_site_id,
                    'incoterms_code'            => $request->incoterms_code,
                    'port_of_loading'           => $request->port_of_loading,
                    'transport_type_code'       => $request->transport_type_code,
                    'transport_detail'          => $request->transport_detail,
                    'port_of_discharge'         => $request->port_of_discharge,
                    'place_of_delivery'         => $request->place_of_delivery,
                    'shipping_marks'            => $request->shipping_marks,
                    'shipment_condition'        => $request->shipment_condition,
                    'source_system'             => $request->source_system,
                    'sub_total'                 => $request->sub_total,
                    'tax'                       => $request->tax,
                    'grand_total'               => $request->grand_total,
                    'delivery_date'             => $deliveryDate,
                    'pick_release_status'       => $request->order_status == 'Confirm' ? 'Draft' : '',
                    'program_code'              => 'OMP0072',
                    'updated_by_id'             => optional(auth()->user())->user_id,
                    'updated_at'                => date('Y-m-d H:i:s'),
                    'last_updated_by'           => optional(auth()->user())->user_id,
                    'last_update_date'          => date('Y-m-d H:i:s')
                ];

                // echo '<pre>';
                // print_r($update);
                // echo '<pre>';
                // exit();

                ProformaInvoiceHeaders::where('pi_header_id', $request->pi_header_id)->update($update);
                // OrderHeaders::where('prepare_order_number', $request->prepare_order_number)->update($update);

                $getDataQuery = ProformaInvoiceHeaders::where('pi_header_id', $request->pi_header_id)->first();

                if($request->hasFile('attachment')) {
                    $fileAttachment = $request->file('attachment');
                    AttachmentRepo::uploadAttachmentMultiple($fileAttachment,$getDataQuery->order_header_id, 'OMP0066');
                }

                if($request->order_status == 'Confirm'){
                    GenerateNumberRepo::callWMSPackageProformaInvoice($request->pi_header_id, $getDataQuery->pi_number);
                }

                try {
                    $orderHeaderQuery = OrderHeaders::where('order_header_id', $getDataQuery->order_header_id)->first();
                    DirectDebitRepo::updateOrderDirectDebitExport($orderHeaderQuery);
                   }catch (\Exception $e) {}

                if (!empty($request->sub_vat)) {
                    foreach ($request->sub_vat as $key => $valueLine) {
                        $updateLine = [
                            'vat_code'                  => $valueLine,
                            'tax_amount'                => $request->tax_amount[$key],
                            'total_amount'              => $request->total_amount[$key],
                            'weight_unit_net'           => $request->net_weight[$key],
                            'weight_unit_gross'         => $request->net_gross[$key],
                            'total_net_weight'          => $request->total_net_weight[$key],
                            'total_net_gross'           => $request->total_net_gross[$key],
                            'program_code'              => 'OMP0072',
                            'updated_by_id'             => optional(auth()->user())->user_id,
                            'updated_at'                => date('Y-m-d H:i:s'),
                            'last_updated_by'           => optional(auth()->user())->user_id,
                            'last_update_date'          => date('Y-m-d H:i:s')
                        ];

                        // echo '<pre>';
                        // print_r($updateLine);
                        // echo '<pre>';

                        ProformaInvoiceLines::where('pi_line_id', $key)->update($updateLine);
                        // OrderLines::where('pi_line_id', $key)->update($updateLine);
                    }
                }

                // if (!empty($request->lot_pi_line_id)) {
                //     foreach ($request->lot_pi_line_id as $key => $valueLot) {

                //         // Capital
                //         if (!empty($request->lot_onhand_conv_qty[$key])) {
                //             $convReplace = str_replace(',', '', $request->lot_onhand_conv_qty[$key]);
                //             $convExplode = explode('.', $convReplace);
                //             $conv        = !empty($convExplode[0]) ? $convExplode[0] : 0;
                //         }else{
                //             $conv        = '';
                //         }

                //         // Capital
                //         if (!empty($request->lot_onhand_quantity[$key])) {
                //             $onhandQuantityReplace = str_replace(',', '', $request->lot_onhand_quantity[$key]);
                //             $onhandQuantityExplode = explode('.', $onhandQuantityReplace);
                //             $onhandQuantity        = !empty($onhandQuantityExplode[0]) ? $onhandQuantityExplode[0] : 0;
                //         }else{
                //             $onhandQuantity        = '';
                //         }

                //         $getPILineQuery = ProformaInvoiceLots::where('pi_line_id', $request->lot_pi_line_id[$key])->whereNull('deleted_at')->first();

                //         // echo '<pre>';
                //         // print_r($updateLine);
                //         // echo '<pre>';
                //         // exit();

                //         if (empty($getPILineQuery)) {

                //             $dataLot = [
                //                 'pi_line_id'            => $request->lot_pi_line_id[$key],
                //                 'item_id'               => $request->lot_item_id[$key],
                //                 'item_code'             => $request->lot_item_code[$key],
                //                 'item_description'      => $request->lot_item_description[$key],
                //                 'inv_org_id'            => $request->lot_inv_org_id[$key],
                //                 'subinventory_code'     => $request->lot_subinventory_code[$key],
                //                 'serial_number'         => $request->lot_serial_number[$key],
                //                 'inventory_location_id' => $request->lot_inventory_location_id[$key],
                //                 'inv_uom_code'          => $request->lot_inv_uom_code[$key],
                //                 'onhand_conv_qty'       => $conv,
                //                 'inv_org_code'          => $request->lot_inv_org_code[$key],
                //                 'inv_org_name'          => $request->inv_org_name[$key],
                //                 'lot_number'            => $request->lot_lot_number[$key],
                //                 'onhand_quantity'       => $onhandQuantity,
                //                 'order_quantity'        => $request->lot_order_quantity[$key],
                //                 'program_code'          => 'OMP0072',
                //                 'created_by'        => optional(auth()->user())->user_id,
                //                 'creation_date'     => date('Y-m-d H:i:s'),
                //                 'last_updated_by'       => optional(auth()->user())->user_id,
                //                 'last_update_date'      => date('Y-m-d H:i:s')
                //             ];

                //             ProformaInvoiceLots::insert($dataLot);
                //         }else{
                //             $dataLot = [
                //                 'item_id'               => $request->lot_item_id[$key],
                //                 'item_code'             => $request->lot_item_code[$key],
                //                 'item_description'      => $request->lot_item_description[$key],
                //                 'inv_org_id'            => $request->lot_inv_org_id[$key],
                //                 'subinventory_code'     => $request->lot_subinventory_code[$key],
                //                 'serial_number'         => $request->lot_serial_number[$key],
                //                 'inventory_location_id' => $request->lot_inventory_location_id[$key],
                //                 'inv_uom_code'          => $request->lot_inv_uom_code[$key],
                //                 'onhand_conv_qty'       => $conv,
                //                 'inv_org_code'          => $request->lot_inv_org_code[$key],
                //                 'inv_org_name'          => $request->inv_org_name[$key],
                //                 'lot_number'            => $request->lot_lot_number[$key],
                //                 'onhand_quantity'       => $onhandQuantity,
                //                 'order_quantity'        => $request->lot_order_quantity[$key],
                //                 'program_code'          => 'OMP0072',
                //                 'updated_by_id'         => optional(auth()->user())->user_id,
                //                 'updated_at'            => date('Y-m-d H:i:s'),
                //                 'last_updated_by'       => optional(auth()->user())->user_id,
                //                 'last_update_date'      => date('Y-m-d H:i:s')
                //             ];
                //             ProformaInvoiceLots::where('pi_lot_id', $getPILineQuery->pi_lot_id)->update($dataLot);
                //         }
                //     }
                // }

                $orderHeaderID  = ProformaInvoiceHeaders::where('pi_header_id', $request->pi_header_id)->pluck('order_header_id')->first();

                $attachmentFile = AttachFiles::where('attachment_program_code','OMP0066')->where('header_id', $orderHeaderID)->whereNull('deleted_at')->get();

                $rest = [
                    'status'            => 'success',
                    'data'              => 'Success',
                    'attachmentFile'    => $attachmentFile
                ];
            }else{
                $rest = [
                    'status'            => 'false',
                    'data'              => 'Someting Wrong',
                    'attachmentFile'    => $attachmentFile
                ];
            }
        }

        return response()->json(['data' => $rest]);
    }

    public function checkCancel($piNumber)
    {
        $rest = [];
        $proformaInvoiceQuery = ProformaInvoiceHeaders::where('pi_number', $piNumber)->first();

        if (!empty($proformaInvoiceQuery->pi_number)) {

            $checkWMS   = DB::table('ptom_order_t_wms')->where('oaom_order_header_id', $proformaInvoiceQuery->order_header_id)->where('oaom_wms6_inven', 'Y')->first();
            if(!empty($checkWMS->oaom_order_header_id)){
                $rest = [
                    'status'    => 'wms_y'
                ];
            }else if($proformaInvoiceQuery->close_sale_flag == 'Y'){
                $rest = [
                    'status'    => 'closed'
                ];

            }else if ($proformaInvoiceQuery->pick_release_status == 'Cancelled' || $proformaInvoiceQuery->pick_release_status == 'Draft' || empty($proformaInvoiceQuery->pick_release_status)) {
                $rest = [
                    'status'    => 'success'
                ];
            }else {
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

    public function cancel(Request $request)
    {
        $rest = [];

        // echo '<pre>';
        // print_r($request->all());
        // echo '<pre>';
        // exit();

        $update = [
            'pi_cancel_reason'  => $request->pi_cancel_reason,
            'order_status'      => $request->order_status,
            'program_code'      => 'OMP0072',
            'updated_by_id'     => optional(auth()->user())->user_id,
            'updated_at'        => date('Y-m-d H:i:s'),
            'last_updated_by'   => optional(auth()->user())->user_id,
            'last_update_date'  => date('Y-m-d H:i:s')
        ];

        // echo '<pre>';
        // print_r($update);
        // echo '<pre>';
        // exit();

        if(ProformaInvoiceHeaders::where('pi_header_id', $request->pi_header_id)->update($update))
        {
            $updateLine = [
                'cancelled_flag'    => 'Y',
                'cancelled_date'    => date('Y-m-d H:i:s'),
                'program_code'      => 'OMP0072',
                'updated_by_id'     => optional(auth()->user())->user_id,
                'updated_at'        => date('Y-m-d H:i:s'),
                'last_updated_by'   => optional(auth()->user())->user_id,
                'last_update_date'  => date('Y-m-d H:i:s')
            ];

            ProformaInvoiceLines::where('pi_header_id', $request->pi_header_id)->update($updateLine);

            $updateWMS = [
                'record_status' => 'C'
            ];

            DB::table('ptom_order_t_wms')->where('oaom_order_no', $request->pi_number)->update($updateWMS);

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

    public function createProformaLot($lineID)
    {
        $rest               = [];
        $data               = [];
        $orgList            = [];
        $lotList            = [];
        $mmsPerBox          = '';
        $proformaLinesQuery     = ProformaInvoiceLines::where('pi_line_id', $lineID)->whereNull('deleted_at')->first();

        if(!empty($proformaLinesQuery->order_quantity))
        {
            if (empty($proformaLinesQuery->weight_id)) {
                $getItemWeight = ItemWeights::where('item_code', $proformaLinesQuery->item_code)
                                    ->where('active_flag', 'Y')
                                    // ->whereRaw("nvl(start_date,sysdate+1) < sysdate")
                                    ->whereRaw("nvl(end_date,sysdate+1) > sysdate")
                                    ->whereNull('deleted_at')->first();

                $proformaLinesQuery->weight_id = !empty($getItemWeight->weight_id) ? $getItemWeight->weight_id : 0;
            }

            $getItemWeight = ItemWeights::where('weight_id', $proformaLinesQuery->weight_id)->whereNull('deleted_at')->first();

            // $net_weight = !empty($getItemWeight->net_weight) ? $getItemWeight->net_weight : 0;
            // $net_gross  = !empty($getItemWeight->net_gross) ? $getItemWeight->net_gross : 0;
            $net_weight = !empty($proformaLinesQuery->weight_unit_net) ? $proformaLinesQuery->weight_unit_net : (!empty($getItemWeight->net_weight) ? $getItemWeight->net_weight : 0);
            $net_gross  = !empty($proformaLinesQuery->weight_unit_gross) ? $proformaLinesQuery->weight_unit_gross : (!empty($getItemWeight->net_gross) ? $getItemWeight->net_gross : 0);

            $pi_line_id                 = $proformaLinesQuery->pi_line_id;
            $item_id                    = $proformaLinesQuery->item_id;
            $item_code                  = $proformaLinesQuery->item_code;
            $item_description           = $proformaLinesQuery->item_description;
            $weight_unit_net            = $net_weight;
            $weight_unit_gross          = $net_gross;
            $total_weight_unit_net      = $proformaLinesQuery->total_net_weight;
            $total_weight_unit_gross    = $proformaLinesQuery->total_net_gross;

            $limitOrderQuantity     = $proformaLinesQuery->order_quantity;

            // $organizationQuery      = Organization::orderBy('organization_id', 'asc')->get();

            if ($limitOrderQuantity > 0) {
                $onhandQuery            = Onhand::where('item_code', $item_code)->orderBy('organization_code')->orderBy('lot_number')->get();

                // echo '<pre>';
                // print_r($onhandQuery);
                // echo '<pre>';
                // exit();

                $sumOnhand              = Onhand::where('item_code', $item_code)->sum('onhand_quantity');

                // Data Org and Lot
                if (!empty($onhandQuery)) {
                    $orgID          = 0;
                    $orgQuantity    = 0;
                    $orgKey         = 0;
                    $beforOrgCode   = '';
                    $beforkeyOrg    = 0;
                    $beforkeyLot    = 0;
                    $beforLotNumber = '';
                    foreach ($onhandQuery as $key => $value) {

                        $lineUOM        = ProformaInvoiceLines::where('pi_line_id', $lineID)->whereNull('deleted_at')->pluck('uom_code')->first();
                        $lotUOM         = $value->transaction_uom_code;
                        $onhandQuantity = $value->onhand_quantity;
                        $lineOnhand     = 0;
                        $lotOnhand      = 0;
                        $onConversion   = 0;

                        if (!empty($lineUOM)) {
                            $lineOnhand = DB::table('ptom_uom_conversions_v')->where('uom_code', $lineUOM)->pluck('conversion_rate')->first();
                            $lotOnhand  = DB::table('ptom_uom_conversions_v')->where('uom_code', $lotUOM)->pluck('conversion_rate')->first();
                            $onConversion   = ((float)$onhandQuantity * (float)$lotOnhand) / (float)$lineOnhand;
                        }

                        if ($orgID == $value->organization_id) {
                            $orgID = $value->organization_id;
                            $orgQuantity = $orgQuantity + $onConversion;
                        }else{
                            $orgID = $value->organization_id;
                            $orgQuantity = $onConversion;

                            if($key != 0)
                            {
                                $orgKey += 1;
                            }
                        }

                        if($beforOrgCode != $value->organization_code){
                            $beforkeyOrg = $orgKey;
                        }

                        $orgList[$beforkeyOrg]   = [
                            'organization_id'           => $value->organization_id,
                            'organization_code'         => $value->organization_code,
                            'organization_name'         => $value->organization_name,
                            'total_onhand_quantity'     => $orgQuantity,
                            'lot_number'                => $value->lot_number,
                            'subinventory_code'         => $value->subinventory_code,
                            'serial_number'             => '',
                            'locator_id'                => $value->locator_id,
                            'transaction_uom_code'      => $value->transaction_uom_code,
                            'onhand_quantity'           => $onConversion,
                            'weight_unit_net'           => $weight_unit_net,
                            'weight_unit_gross'         => $weight_unit_gross,
                            'total_weight_unit_net'     => $total_weight_unit_net,
                            'total_weight_unit_gross'   => $total_weight_unit_gross,
                        ];
                        $beforOrgCode = $value->organization_code;
                        if ($beforLotNumber != $value->lot_number) {
                            $beforkeyLot = $key;
                            $lotList[$beforkeyLot]  = [
                                'inventory_item_id'     => $value->inventory_item_id,
                                'organization_id'       => $value->organization_id,
                                'organization_code'     => $value->organization_code,
                                'lot_number'            => $value->lot_number,
                                'onhand_quantity'       => $onConversion,
                                'transaction_uom_code'  => $value->transaction_uom_code,
                                'serial_number'         => '',
                                'locator_id'            => $value->locator_id,
                                'subinventory_code'     => $value->subinventory_code,
                                'locator'               => $value->locator,
                            ];
                        }else{
                            $lotList[$beforkeyLot]  = [
                                'inventory_item_id'     => $value->inventory_item_id,
                                'organization_id'       => $value->organization_id,
                                'organization_code'     => $value->organization_code,
                                'lot_number'            => $value->lot_number,
                                'onhand_quantity'       => (float)$onConversion + (float)$lotList[$beforkeyLot]['onhand_quantity'],
                                'transaction_uom_code'  => $value->transaction_uom_code,
                                'serial_number'         => '',
                                'locator_id'            => $value->locator_id,
                                'subinventory_code'     => $value->subinventory_code,
                                'locator'               => $value->locator,
                            ];
                        }
                        $beforLotNumber = $value->lot_number;
                    }
                }

                $data   = [
                    'pi_lot_id'         => '',
                    'pi_line_id'        => $pi_line_id,
                    'item_id'           => $item_id,
                    'item_code'         => $item_code,
                    'item_description'  => $item_description,
                    'weight_net'        => $net_weight,
                    'weight_gross'      => $net_gross
                ];
            }

            // foreach ($organizationQuery as $key => $value) {
            //     $organizationData[] = [
            //         'organization_id'       => $value->organization_id,
            //         'organization_code'     => $value->organization_code,
            //         'organization_name'     => $value->organization_name
            //     ];
            // }

            $weightID           = ProformaInvoiceLines::where('pi_line_id', $lineID)->whereNull('deleted_at')->pluck('weight_id')->first();

            $itemWeightData     = ItemWeights::select('length', 'width', 'height')
                                            ->where('weight_id', $weightID)
                                            ->where('active_flag', 'Y')
                                            // ->whereRaw("nvl(start_date,sysdate+1) < sysdate")
                                            // ->whereRaw("nvl(end_date,sysdate+1) > sysdate")
                                            ->whereNull('deleted_at')->first();

            if (!empty($itemWeightData->length) && !empty($itemWeightData->width) && !empty($itemWeightData->height)) {
                $mmsPerBox = $itemWeightData->length.'x'.$itemWeightData->width.'x'.$itemWeightData->height;
            }else{
                $mmsPerBox = '';
            }

            $sumLots    = ProformaInvoiceLots::where('pi_line_id', $lineID)->whereNull('deleted_at')->sum('order_quantity');

            // Check Unit quantity
            if ($sumOnhand >= $limitOrderQuantity) {
                // $limitOrderQuantity = $limitOrderQuantity;
                // $limitOrderQuantity = $limitOrderQuantity - $sumLots;

                $rest = [
                    'data'                  => $data,
                    'orgList'               => $orgList,
                    'lotList'               => $lotList,
                    'limitOrderQuantity'    => $limitOrderQuantity,
                    'sumOnhand'             => $sumOnhand,
                    'mmsPerBox'             => $mmsPerBox,
                    'status'                => 'success'
                ];

            }else{
                // $limitOrderQuantity = $sumOnhand;
                // $limitOrderQuantity = $limitOrderQuantity - $sumLots;

                $rest = [
                    'data'                  => $data,
                    'orgList'               => $orgList,
                    'lotList'               => $lotList,
                    'limitOrderQuantity'    => $limitOrderQuantity,
                    'sumOnhand'             => $sumOnhand,
                    'mmsPerBox'             => $mmsPerBox,
                    'status'                => 'over'
                ];
            }
        }else{
            $rest = [
                'data'                  => $data,
                'orgList'               => $orgList,
                'lotList'               => $lotList,
                'limitOrderQuantity'    => 0,
                'sumOnhand'             => 0,
                'mmsPerBox'             => $mmsPerBox,
                'status'                => 'false',
            ];
        }

        return response()->json(['data' => $rest]);
    }

    public function getProformaLot($lineID)
    {
        $rest       = [];
        $orgList    = [];
        $lotList    = [];
        $dataList = ProformaInvoiceLots::where('pi_line_id', $lineID)->whereNull('deleted_at')->orderBy('pi_lot_id', 'ASC')->get();

        if(!empty($dataList))
        {

            foreach ($dataList as $keyLot => $valueLot) {
                $item_code              = $valueLot->item_code;

                // $organizationQuery      = Organization::orderBy('organization_id', 'asc')->get();

                $onhandQuery            = Onhand::where('item_code', $item_code)->get();

                // Data Org and Lot
                if (!empty($onhandQuery)) {
                    $orgID          = 0;
                    $orgQuantity    = 0;
                    $orgKey         = 0;
                    foreach ($onhandQuery as $key => $value) {

                        $lineUOM        = ProformaInvoiceLines::where('pi_line_id', $lineID)->whereNull('deleted_at')->pluck('uom_code')->first();
                        $lotUOM         = $value->transaction_uom_code;
                        $onhandQuantity = $value->onhand_quantity;
                        $lineOnhand     = 0;
                        $lotOnhand      = 0;
                        $onConversion   = 0;

                        if (!empty($lineUOM)) {
                            $lineOnhand = DB::table('ptom_uom_conversions_v')->where('uom_code', $lineUOM)->pluck('conversion_rate')->first();
                            $lotOnhand  = DB::table('ptom_uom_conversions_v')->where('uom_code', $lotUOM)->pluck('conversion_rate')->first();
                            $onConversion   = ((float)$onhandQuantity * (float)$lotOnhand) / (float)$lineOnhand;
                        }

                        if ($orgID == $value->organization_id) {
                            $orgID = $value->organization_id;
                            $orgQuantity = $orgQuantity + $onConversion;
                        }else{
                            $orgID = $value->organization_id;
                            $orgQuantity = $onConversion;

                            if($key != 0)
                            {
                                $orgKey += 1;
                            }
                        }

                        $onhandQuery            = Onhand::where('item_code', $item_code)->orderBy('organization_code')->orderBy('lot_number')->get();

                        // echo '<pre>';
                        // print_r($onhandQuery);
                        // echo '<pre>';
                        // exit();

                        $sumOnhand              = Onhand::where('item_code', $item_code)->sum('onhand_quantity');

                        // Data Org and Lot
                        if (!empty($onhandQuery)) {
                            $orgID          = 0;
                            $orgQuantity    = 0;
                            $orgKey         = 0;
                            $beforOrgCode   = '';
                            $beforkeyOrg    = 0;
                            $beforkeyLot    = 0;
                            $beforLotNumber = '';
                            foreach ($onhandQuery as $key => $value) {

                                $lineUOM        = ProformaInvoiceLines::where('pi_line_id', $lineID)->whereNull('deleted_at')->pluck('uom_code')->first();
                                $lotUOM         = $value->transaction_uom_code;
                                $onhandQuantity = $value->onhand_quantity;
                                $lineOnhand     = 0;
                                $lotOnhand      = 0;
                                $onConversion   = 0;

                                if (!empty($lineUOM)) {
                                    $lineOnhand = DB::table('ptom_uom_conversions_v')->where('uom_code', $lineUOM)->pluck('conversion_rate')->first();
                                    $lotOnhand  = DB::table('ptom_uom_conversions_v')->where('uom_code', $lotUOM)->pluck('conversion_rate')->first();
                                    $onConversion   = ((float)$onhandQuantity * (float)$lotOnhand) / (float)$lineOnhand;
                                }

                                if ($orgID == $value->organization_id) {
                                    $orgID = $value->organization_id;
                                    $orgQuantity = $orgQuantity + $onConversion;
                                }else{
                                    $orgID = $value->organization_id;
                                    $orgQuantity = $onConversion;

                                    if($key != 0)
                                    {
                                        $orgKey += 1;
                                    }
                                }

                                $orgList[$valueLot->pi_lot_id][$orgKey]   = [
                                    'organization_id'           => $value->organization_id,
                                    'organization_code'         => $value->organization_code,
                                    'organization_name'         => $value->organization_name,
                                    'total_onhand_quantity'     => $orgQuantity,
                                    'lot_number'                => $value->lot_number,
                                    'subinventory_code'         => $value->subinventory_code,
                                    'serial_number'             => '',
                                    'locator_id'                => $value->locator_id,
                                    'transaction_uom_code'      => $value->transaction_uom_code,
                                    'onhand_quantity'           => $onConversion,
                                ];
                                $beforOrgCode = $value->organization_code;
                                if ($beforLotNumber != $value->lot_number) {
                                    $beforkeyLot = $key;
                                    $lotList[$valueLot->pi_lot_id][$beforkeyLot]  = [
                                        'inventory_item_id'     => $value->inventory_item_id,
                                        'organization_id'       => $value->organization_id,
                                        'organization_code'     => $value->organization_code,
                                        'lot_number'            => $value->lot_number,
                                        'onhand_quantity'       => $onConversion,
                                        'transaction_uom_code'  => $value->transaction_uom_code,
                                        'serial_number'         => '',
                                        'locator_id'            => $value->locator_id,
                                        'subinventory_code'     => $value->subinventory_code,
                                        'locator'               => $value->locator,
                                    ];
                                }else{
                                    $lotList[$valueLot->pi_lot_id][$beforkeyLot]  = [
                                        'inventory_item_id'     => $value->inventory_item_id,
                                        'organization_id'       => $value->organization_id,
                                        'organization_code'     => $value->organization_code,
                                        'lot_number'            => $value->lot_number,
                                        'onhand_quantity'       => (float)$onConversion + (float)(!empty($lotList[$beforkeyLot]) ? $lotList[$beforkeyLot]['onhand_quantity'] : 0),
                                        'transaction_uom_code'  => $value->transaction_uom_code,
                                        'serial_number'         => '',
                                        'locator_id'            => $value->locator_id,
                                        'subinventory_code'     => $value->subinventory_code,
                                        'locator'               => $value->locator,
                                    ];
                                }
                                $beforLotNumber = $value->lot_number;
                            }
                        }
                    }
                }
            }

        }

        $rest = [
            'data'      => $dataList,
            'orgList'   => $orgList,
            'lotList'   => $lotList,
            'status'    => 'success'
        ];

        return response()->json(['data' => $rest]);
    }

    public function updateLot(Request $request)
    {
        $rest = [];

        // echo '<pre>';
        // print_r($request->all());
        // echo '<pre>';
        // exit();

        if (!empty($request->lot_pi_lot_id)) {
            foreach ($request->lot_pi_lot_id as $key => $valueLot) {

                // Capital
                if (!empty($request->lot_onhand_conv_qty[$key])) {
                    $convReplace = str_replace(',', '', $request->lot_onhand_conv_qty[$key]);
                    $convExplode = explode('.', $convReplace);
                    $conv        = !empty($convExplode[0]) ? $convExplode[0] : 0;
                }else{
                    $conv        = '';
                }

                // Onhand quantity
                $onhandQuantityReplace = '';
                if (!empty($request->lot_onhand_quantity[$key])) {
                    $onhandQuantityReplace = str_replace(',', '', $request->lot_onhand_quantity[$key]);
                    $onhandQuantityExplode = explode('.', $onhandQuantityReplace);
                    $onhandQuantity        = !empty($onhandQuantityExplode[0]) ? $onhandQuantityExplode[0] : 0;
                }else{
                    $onhandQuantity        = '';
                }

                // Order Quantity
                $orderQuantityReplace = '';
                if (!empty($request->lot_order_quantity[$key])) {
                    $orderQuantityReplace = str_replace(',', '', $request->lot_order_quantity[$key]);
                    $orderQuantityExplode = explode('.', $orderQuantityReplace);
                    $orderQuantity        = !empty($orderQuantityExplode[0]) ? $orderQuantityExplode[0] : 0;
                }else{
                    $orderQuantity        = '';
                }

                $getPILineQuery = ProformaInvoiceLots::where('pi_lot_id', $request->lot_pi_lot_id[$key])->whereNull('deleted_at')->first();

                // echo '<pre>';
                // print_r($updateLine);
                // echo '<pre>';
                // exit();

                if (empty($getPILineQuery)) {

                    $dataLot = [
                        'pi_line_id'                => $request->lot_pi_line_id[$key],
                        'item_id'                   => $request->lot_item_id[$key],
                        'item_code'                 => $request->lot_item_code[$key],
                        'item_description'          => $request->lot_item_description[$key],
                        'inv_org_id'                => $request->lot_inv_org_id[$key],
                        'subinventory_code'         => $request->lot_subinventory_code[$key],
                        'serial_number'             => $request->lot_serial_number[$key],
                        'inventory_location_id'     => $request->lot_inventory_location_id[$key],
                        'inv_uom_code'              => $request->lot_inv_uom_code[$key],
                        'onhand_conv_qty'           => $conv,
                        'inv_org_code'              => $request->lot_inv_org_code[$key],
                        'inv_org_name'              => $request->inv_org_name[$key],
                        'locator'                   => $request->lot_locator[$key],
                        'lot_number'                => $request->lot_lot_number[$key],
                        'onhand_quantity'           => $onhandQuantityReplace,
                        'order_quantity'            => $orderQuantityReplace,
                        'case_no_from'              => (int)$request->case_no_from[$key],
                        'case_no_to'                => (int)$request->case_no_to[$key],
                        'mms_per_box'               => $request->mms_per_box[$key],
                        'quantity_cbb'              => (int)$request->quantity_cbb[$key],
                        'weight_unit_net'           => $request->weight_unit_net[$key],
                        'weight_unit_gross'         => $request->weight_unit_gross[$key],
                        'total_weight_unit_net'     => $request->total_weight_unit_net[$key],
                        'total_weight_unit_gross'   => $request->total_weight_unit_gross[$key],
                        'program_code'              => 'OMP0072',
                        'created_by'                => optional(auth()->user())->user_id,
                        'creation_date'             => date('Y-m-d H:i:s'),
                        'last_updated_by'           => optional(auth()->user())->user_id,
                        'last_update_date'          => date('Y-m-d H:i:s')
                    ];

                    ProformaInvoiceLots::insert($dataLot);
                }else{
                    $dataLot = [
                        'item_id'                   => $request->lot_item_id[$key],
                        'item_code'                 => $request->lot_item_code[$key],
                        'item_description'          => $request->lot_item_description[$key],
                        'inv_org_id'                => $request->lot_inv_org_id[$key],
                        'subinventory_code'         => $request->lot_subinventory_code[$key],
                        'serial_number'             => $request->lot_serial_number[$key],
                        'inventory_location_id'     => $request->lot_inventory_location_id[$key],
                        'inv_uom_code'              => $request->lot_inv_uom_code[$key],
                        'onhand_conv_qty'           => $conv,
                        'inv_org_code'              => $request->lot_inv_org_code[$key],
                        'inv_org_name'              => $request->inv_org_name[$key],
                        'locator'                   => $request->lot_locator[$key],
                        'lot_number'                => $request->lot_lot_number[$key],
                        'onhand_quantity'           => $onhandQuantityReplace,
                        'order_quantity'            => $orderQuantityReplace,
                        'case_no_from'              => (int)$request->case_no_from[$key],
                        'case_no_to'                => (int)$request->case_no_to[$key],
                        'mms_per_box'               => $request->mms_per_box[$key],
                        'quantity_cbb'              => (int)$request->quantity_cbb[$key],
                        'weight_unit_net'           => $request->weight_unit_net[$key],
                        'weight_unit_gross'         => $request->weight_unit_gross[$key],
                        'total_weight_unit_net'     => $request->total_weight_unit_net[$key],
                        'total_weight_unit_gross'   => $request->total_weight_unit_gross[$key],
                        'program_code'              => 'OMP0072',
                        'updated_by_id'             => optional(auth()->user())->user_id,
                        'updated_at'                => date('Y-m-d H:i:s'),
                        'last_updated_by'           => optional(auth()->user())->user_id,
                        'last_update_date'          => date('Y-m-d H:i:s')
                    ];
                    ProformaInvoiceLots::where('pi_lot_id', $getPILineQuery->pi_lot_id)->update($dataLot);
                }
            }

            $rest = [
                'data'      => 'Success',
                'status'    => 'success',
            ];

        }else{
            $rest = [
                'data'      => 'Success',
                'status'    => 'fail',
            ];
        }

        return response()->json(['data' => $rest]);
    }

    public function deleteAllLot(Request $request)
    {
        $rest = [];

        // echo '<pre>';
        // print_r($request->all());
        // echo '<pre>';
        // exit();

        if (!empty($request->main_lot_pi_line_id)) {
            ProformaInvoiceLots::where('pi_line_id', $request->main_lot_pi_line_id)->delete();

            $rest = [
                'data'      => 'Success',
                'status'    => 'success'
            ];
        }else{
            $rest = [
                'data'      => 'Fail',
                'status'    => 'fail'
            ];
        }

        return response()->json(['data' => $rest]);
    }

    public function deleteSingleLot(Request $request)
    {
        $rest = [];

        // echo '<pre>';
        // print_r($request->all());
        // echo '<pre>';
        // exit();

        ProformaInvoiceLots::where('pi_line_id', $request->main_lot_pi_line_id)->where('pi_lot_id', $request->delete_lot_id)->delete();

        $rest = [
            'data'      => 'Success',
            'status'    => 'success'
        ];

        return response()->json(['data' => $rest]);
    }
}
