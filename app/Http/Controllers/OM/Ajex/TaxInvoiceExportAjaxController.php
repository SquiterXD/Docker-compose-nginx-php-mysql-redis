<?php

namespace App\Http\Controllers\OM\Ajex;

use App\Http\Controllers\Controller;
use App\Models\OM\AttachFiles;
use App\Models\OM\Customers;
use App\Models\OM\Customers\Domestics\CustomerContractGroups;
use App\Models\OM\Customers\Domestics\PriceList;
use App\Models\OM\OverdueDebt\PaymentApplyCNDN;
use App\Models\OM\OverdueDebt\PaymentMatchInvoices;
use App\Models\OM\SaleConfirmation\OrderHeaders;
use App\Models\OM\SaleConfirmation\OrderLines;
use App\Models\OM\SaleConfirmation\Currencies;
use App\Models\OM\SaleConfirmation\Incoterms;
use App\Models\OM\SaleConfirmation\Interfaces;
use App\Models\OM\SaleConfirmation\InvoiceHeaders;
use App\Models\OM\SaleConfirmation\InvoiceLines;
use App\Models\OM\SaleConfirmation\ItemWeights;
use App\Models\OM\SaleConfirmation\Onhand;
use App\Models\OM\SaleConfirmation\Organization;
use App\Models\OM\SaleConfirmation\PaymentHeaders;
use App\Models\OM\SaleConfirmation\PaymentMethodExport;
use App\Models\OM\SaleConfirmation\PaymentType;
use App\Models\OM\SaleConfirmation\ProformaInvoiceHeaders;
use App\Models\OM\SaleConfirmation\ProformaInvoiceLines;
use App\Models\OM\SaleConfirmation\ProformaInvoiceLots;
use App\Models\OM\SaleConfirmation\SalesChannel;
use App\Models\OM\SaleConfirmation\ShipmentBy;
use App\Models\OM\SaleConfirmation\Terms;
use App\Models\OM\SaleConfirmation\ShipSites;
use App\Models\OM\SaleConfirmation\TransactionTypes;
use App\Repositories\OM\AttachmentRepo;
use App\Repositories\OM\GenerateNumberRepo;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaxInvoiceExportAjaxController extends Controller
{

    public function create(Request $request)
    {
        // $performaData           = [];
        $dataList               = [];
        $orderLine              = [];
        $orderLots              = [];
        $resultWeight           = [];
        $orgList                = [];
        $lotList                = [];
        $attachmentFile         = [];
        $shipSitesList          = [];
        $resultTotalNet         = 0.00;
        $resultTotalGross       = 0.00;
        $resultSubTotal         = 0.00;
        $resultTax              = 0.00;
        $resultTotal            = 0.00;
        $resultAmount           = 0.00;

        $getData = ProformaInvoiceHeaders::select('ptom_proforma_invoice_headers.*',
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
                                )->join('ptom_customers', 'ptom_proforma_invoice_headers.customer_id', '=', 'ptom_customers.customer_id')
                                ->where('ptom_proforma_invoice_headers.pi_number', '=', $request->pi_number)
                                ->whereNull('ptom_proforma_invoice_headers.deleted_at')->first();

        // echo '<pre>';
        // print_r($getData);
        // echo '<pre>';
        // exit();

        if(!empty($getData->pick_release_no)){

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
                'orderLots'             => $orderLots,
                'resultWeights'         => $resultWeight,
                'orgList'               => $orgList,
                'lotList'               => $lotList,
                'data'                  => $dataList,
                'status'                => 'created',
                'attachmentFile'        => $attachmentFile
            ];

        }else if (!empty($getData)) {

            $getTerms = Terms::select('name', 'description')->where('term_id', $getData->term_id)->first();

            $shipSitesList  = ShipSites::where('customer_id', $getData->customer_id)->whereNull('deleted_at')->get();

            // $newPickReleaseNo = GenerateNumberRepo::generateApprovePrepare('OMP0073_IV_NUM_EXP');

            // $updateInvoiceNo = [
            //     'pick_release_no'           => $newPickReleaseNo,
            //     'program_code'              => 'OMP0073',
            //     'updated_by_id'             => optional(auth()->user())->user_id,
            //     'updated_at'                => date('Y-m-d H:i:s'),
            //     'last_updated_by'           => optional(auth()->user())->user_id,
            //     'last_update_date'          => date('Y-m-d H:i:s')
            // ];

            // echo '<pre>';
            // print_r($updateInvoiceNo);
            // echo '<pre>';
            // exit();

            // ProformaInvoiceHeaders::where('pi_number', $number)->update($updateInvoiceNo);

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

            $proShipSite = ShipSites::where('ship_to_site_id', '=', $getData->ship_to_site_id)->pluck('ship_to_site_name')->first();

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
                'order_header_id'           => $getData->order_header_id,
                'pick_release_status'       => !empty($getData->pick_release_status) ? $getData->pick_release_status : 'Draft',
                'pick_release_no'           => $getData->pick_release_no,
                'pick_release_approve_date' => !empty($getData->pick_release_approve_date) ? date('d/m/Y',strtotime($getData->pick_release_approve_date)) : $getData->pick_release_approve_date,
                'pi_header_id'              => $getData->pi_header_id,
                'pi_number'                 => $getData->pi_number,        // เลขที่ Pro
                'pi_date'                   => !empty($getData->pi_date) ? date('d/m/Y',strtotime($getData->pi_date)) : $getData->pi_date,
                'order_status'              => !empty($getData->order_status) ? $getData->order_status : 'Draft',       // Order Status
                'sa_number'                 => $getData->sa_number,                                                     // เลขที่ใบ SA
                'sa_date'                   => !empty($getData->sa_date) ? date('d/m/Y',strtotime($getData->sa_date)) : $getData->sa_date,
                'order_date'                => !empty($getData->order_date) ? date('d/m/Y',strtotime($getData->order_date)) : $getData->order_date,  // วันที่สั่งซื้อ
                'customer_id'               => $getData->customer_id,
                'cust_po_number'            => $getData->cust_po_number,
                'customer_number'           => $getData->customer_number,
                'customer_name'             => $getData->customer_name,
                'order_type_id'             => TransactionTypes::where('order_type_id', '=', $getData->order_type_id)->pluck('order_type_name')->first(),
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
                'bill_to_site_name'         => !empty($getData->bill_to_site_name) ? $getData->bill_to_site_name : $getData->customer_name,
                'ship_to_site_id'           => $getData->ship_to_site_id,
                'port_of_loading'           => $getData->port_of_loading,
                'port_of_discharge'         => !empty($getData->port_of_discharge) ? $getData->port_of_discharge : $proShipSite,
                'place_of_delivery'         => !empty($getData->place_of_delivery) ? $getData->place_of_delivery : $proShipSite,
                'incoterms_code'            => $getData->incoterms_code,
                'transport_type_code'       => $getData->transport_type_code,
                'transport_detail'          => $getData->transport_detail,
                'shipment_condition'        => $getData->shipment_condition,
                'shipping_marks'            => $getData->shipping_marks,
                'source_system'             => $getData->source_system,
                'delivery_date'             => !empty($getData->delivery_date) ? date('d/m/Y',strtotime($getData->delivery_date)) : $getData->delivery_date,
                'pick_exchange_rate'        => $getData->pick_exchange_rate,
                'exchange_rate'             => $getData->exchange_rate,
                'pick_exchange_date'        => !empty($getData->pick_exchange_date) ? date('d/m/Y',strtotime($getData->pick_exchange_date)) : $getData->pick_exchange_date,
                'forward_flag'              => $getData->forward_flag,
                'price_list_id'             => PriceList::where('list_header_id', $getData->price_list_id)->pluck('name')->first()
            ];

            // echo '<pre>';
            // print_r($dataList);
            // echo '<pre>';
            // exit();

            // to do continue เหลือเพิ่ม order line ไป proforma invoice line

            $getOrderLines = ProformaInvoiceLines::where('pi_header_id', $getData->pi_header_id)->whereNull('deleted_at')->orderBy('item_code')->get();

            $totalAmount = 0;

            if(!$getOrderLines->isEmpty()){

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
                        'pi_header_id'          => $value->pi_header_id,
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

            // PROFORMA INVOICE LOTS
            if (!empty($orderLine)) {
                $getOrderLots = ProformaInvoiceLots::where('pi_line_id', $orderLine[0]['pi_line_id'])->whereNull('deleted_at')->get();

                $totalAmount = 0;

                if(!$getOrderLots->isEmpty()){

                    foreach ($getOrderLots as $key => $valueLot) {

                        $orderLots[] = [
                            'pi_lot_id'             => $valueLot->pi_lot_id,
                            'pi_line_id'            => $valueLot->pi_line_id,
                            'lot_number'            => $valueLot->lot_number,
                            'item_id'               => $valueLot->item_id,
                            'item_code'             => $valueLot->item_code,
                            'item_description'      => $valueLot->item_description,
                            'inv_org_id'            => $valueLot->inv_org_id,
                            'inv_org_code'          => $valueLot->inv_org_code,
                            'inv_org_name'          => $valueLot->inv_org_name,
                            'onhand_quantity'       => $valueLot->onhand_quantity,
                            'order_quantity'        => $valueLot->order_quantity,
                            'subinventory_code'     => $valueLot->subinventory_code,
                            'serial_number'         => $valueLot->serial_number != 'null' ? $valueLot->serial_number : '',
                            'inventory_location_id' => $valueLot->inventory_location_id,
                            'inv_uom_code'          => $valueLot->inv_uom_code,
                            'onhand_conv_qty'       => $valueLot->onhand_conv_qty
                        ];


                        // GET ORG AND LOTS

                        $onhandQuery            = Onhand::where('item_code', $orderLine[0]['item_code'])->get();

                        // Data Org and Lot
                        if (!empty($onhandQuery)) {
                            $orgID          = 0;
                            $orgQuantity    = 0;
                            $orgKey         = 0;
                            foreach ($onhandQuery as $key => $value) {

                                if ($orgID == $value->organization_id) {
                                    $orgID = $value->organization_id;
                                    $orgQuantity = $orgQuantity + $value->onhand_quantity;
                                }else{
                                    $orgID = $value->organization_id;
                                    $orgQuantity = $value->onhand_quantity;

                                    if($key != 0)
                                    {
                                        $orgKey += 1;
                                    }
                                }

                                $orgList[$valueLot->pi_lot_id][$orgKey]   = [
                                    'organization_id'       => $value->organization_id,
                                    'organization_code'     => $value->organization_code,
                                    'organization_name'     => $value->organization_name,
                                    'total_onhand_quantity' => $orgQuantity,
                                    'lot_number'            => $value->lot_number,
                                    'subinventory_code'     => $value->subinventory_code,
                                    'serial_number'         => '',
                                    'locator_id'            => $value->locator_id,
                                    'transaction_uom_code'  => $value->transaction_uom_code,
                                    'onhand_quantity'       => $value->onhand_quantity
                                ];

                                $lotList[$valueLot->pi_lot_id][]  = [
                                    'inventory_item_id'     => $value->inventory_item_id,
                                    'organization_id'       => $value->organization_id,
                                    'organization_code'     => $value->organization_code,
                                    'lot_number'            => $value->lot_number,
                                    'onhand_quantity'       => $value->onhand_quantity,
                                    'transaction_uom_code'  => $value->transaction_uom_code,
                                    'serial_number'         => '',
                                    'locator_id'            => $value->locator_id,
                                ];
                            }
                        }
                    }
                }
            }

            $orderHeaderID  = ProformaInvoiceHeaders::where('pi_header_id', $getData->pi_header_id)->pluck('order_header_id')->first();
            $attachmentFile = AttachFiles::where('attachment_program_code','OMP0066')->where('header_id', $orderHeaderID)->whereNull('deleted_at')->get();

            // $performaData   = ProformaInvoiceHeaders::join('ptom_customers', 'ptom_proforma_invoice_headers.customer_id', '=', 'ptom_customers.customer_id')
            //                         ->select('ptom_proforma_invoice_headers.pi_number', 'ptom_proforma_invoice_headers.pick_release_no')
            //                         ->where('ptom_customers.sales_classification_code', 'Export')
            //                         ->where('ptom_proforma_invoice_headers.order_status', 'Confirm')
            //                         ->whereNull('ptom_proforma_invoice_headers.deleted_at')->get();

            $rest = [
                // 'performaData'          => $performaData,
                'resultTotalAmount'     => $resultAmount,
                'orderLine'             => $orderLine,
                'orderLots'             => $orderLots,
                'resultWeights'         => $resultWeight,
                'orgList'               => $orgList,
                'lotList'               => $lotList,
                'data'                  => $dataList,
                'status'                => 'success',
                'attachmentFile'        => $attachmentFile,
                'shipSitesList'         => $shipSitesList,
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
                'orderLots'             => $orderLots,
                'resultWeights'         => $resultWeight,
                'orgList'               => $orgList,
                'lotList'               => $lotList,
                'data'                  => $dataList,
                'status'                => 'false',
                'attachmentFile'        => $attachmentFile,
                'shipSitesList'         => $shipSitesList,
            ];
        }

        // echo '<pre>';
        // print_r($rest);
        // echo '<pre>';
        // exit();

        return response()->json(['data' => $rest]);
    }

    public function search(Request $request)
    {
        $dataList               = [];
        $orderLine              = [];
        $orderLots              = [];
        $resultWeight           = [];
        $orgList                = [];
        $lotList                = [];
        $attachmentFile         = [];
        $shipSitesList          = [];
        $resultTotalNet         = 0.00;
        $resultTotalGross       = 0.00;
        $resultSubTotal         = 0.00;
        $resultTax              = 0.00;
        $resultTotal            = 0.00;
        $resultAmount           = 0.00;

        $getData = ProformaInvoiceHeaders::select('ptom_proforma_invoice_headers.*',
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
                                )->join('ptom_customers', 'ptom_proforma_invoice_headers.customer_id', '=', 'ptom_customers.customer_id')
                                ->whereNull('ptom_proforma_invoice_headers.deleted_at')
                                ->where(function($query) use($request) {
                                    if(!empty($request->pick_release_no)) {
                                        $query->where('ptom_proforma_invoice_headers.pick_release_no', $request->pick_release_no);
                                    }
                                    if(!empty($request->pi_number)) {
                                        $query->where('ptom_proforma_invoice_headers.pi_number', $request->pi_number);
                                    }
                                })->first();

        // echo '<pre>';
        // print_r($getData);
        // echo '<pre>';
        // exit();

        if (!empty($getData)) {

            $getTerms = Terms::select('name', 'description')->where('term_id', $getData->term_id)->first();
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
                        $currency_name      = 'Baht';
                        $currency           = 'THB';
                    }else{
                        $getCurrency = Currencies::select('currency_code')->where('name', $getData->currency)->first();
                        $currency           = !empty($getCurrency->currency_code) ? $getCurrency->currency_code : '';
                        $currency_name      = $getData->currency;
                    }
                }
            }

            $proShipSite = ShipSites::where('ship_to_site_id', '=', $getData->ship_to_site_id)->pluck('ship_to_site_name')->first();

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
                'order_header_id'           => $getData->order_header_id,
                'pick_release_status'       => !empty($getData->pick_release_status) ? $getData->pick_release_status : 'Draft',
                'pick_release_no'           => $getData->pick_release_no,
                'pick_release_approve_date' => !empty($getData->pick_release_approve_date) ? date('d/m/Y',strtotime($getData->pick_release_approve_date)) : $getData->pick_release_approve_date,
                'pi_header_id'              => $getData->pi_header_id,
                'pi_number'                 => $getData->pi_number,        // เลขที่ Pro
                'pi_date'                   => !empty($getData->pi_date) ? date('d/m/Y',strtotime($getData->pi_date)) : $getData->pi_date,
                'order_status'              => !empty($getData->order_status) ? $getData->order_status : 'Draft',       // Order Status
                'sa_number'                 => $getData->sa_number,                                                     // เลขที่ใบ SA
                'sa_date'                   => !empty($getData->sa_date) ? date('d/m/Y',strtotime($getData->sa_date)) : $getData->sa_date,
                'order_date'                => !empty($getData->order_date) ? date('d/m/Y',strtotime($getData->order_date)) : $getData->order_date,  // วันที่สั่งซื้อ
                'customer_id'               => $getData->customer_id,
                'cust_po_number'            => $getData->cust_po_number,
                'customer_number'           => $getData->customer_number,
                'customer_name'             => $getData->customer_name,
                'order_type_id'             => TransactionTypes::where('order_type_id', '=', $getData->order_type_id)->pluck('order_type_name')->first(),
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
                'bill_to_site_name'         => !empty($getData->bill_to_site_name) ? $getData->bill_to_site_name : $getData->customer_name,
                'ship_to_site_id'           => $getData->ship_to_site_id,
                'port_of_loading'           => $getData->port_of_loading,
                'port_of_discharge'         => !empty($getData->port_of_discharge) ? $getData->port_of_discharge : $proShipSite,
                'place_of_delivery'         => !empty($getData->place_of_delivery) ? $getData->place_of_delivery : $proShipSite,
                'incoterms_code'            => $getData->incoterms_code,
                'transport_type_code'       => $getData->transport_type_code,
                'transport_detail'          => $getData->transport_detail,
                'shipment_condition'        => $getData->shipment_condition,
                'shipping_marks'            => $getData->shipping_marks,
                'source_system'             => $getData->source_system,
                'delivery_date'             => !empty($getData->delivery_date) ? date('d/m/Y',strtotime($getData->delivery_date)) : $getData->delivery_date,
                'pick_exchange_rate'        => $getData->pick_exchange_rate,
                'exchange_rate'             => $getData->exchange_rate,
                'pick_exchange_date'        => !empty($getData->pick_exchange_date) ? date('d/m/Y',strtotime($getData->pick_exchange_date)) : $getData->pick_exchange_date,
                'forward_flag'              => $getData->forward_flag,
                'price_list_id'             => PriceList::where('list_header_id', $getData->price_list_id)->pluck('name')->first()
            ];

            // echo '<pre>';
            // print_r($dataList);
            // echo '<pre>';
            // exit();

            // to do continue เหลือเพิ่ม order line ไป proforma invoice line

            $getOrderLines = ProformaInvoiceLines::where('pi_header_id', $getData->pi_header_id)->whereNull('deleted_at')->orderBy('item_code')->get();

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

                    $orderLine[] = [
                        'pi_line_id'            => $value->pi_line_id,
                        'pi_header_id'          => $value->pi_header_id,
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

            // PROFORMA INVOICE LOTS
            if (!empty($orderLine)) {
                $getOrderLots = ProformaInvoiceLots::where('pi_line_id', $orderLine[0]['pi_line_id'])->whereNull('deleted_at')->get();

                $totalAmount = 0;

                if(!$getOrderLots->isEmpty()){

                    foreach ($getOrderLots as $key => $valueLot) {

                        $orderLots[] = [
                            'pi_lot_id'             => $valueLot->pi_lot_id,
                            'pi_line_id'            => $valueLot->pi_line_id,
                            'lot_number'            => $valueLot->lot_number,
                            'item_id'               => $valueLot->item_id,
                            'item_code'             => $valueLot->item_code,
                            'item_description'      => $valueLot->item_description,
                            'inv_org_id'            => $valueLot->inv_org_id,
                            'inv_org_code'          => $valueLot->inv_org_code,
                            'inv_org_name'          => $valueLot->inv_org_name,
                            'onhand_quantity'       => $valueLot->onhand_quantity,
                            'order_quantity'        => $valueLot->order_quantity,
                            'subinventory_code'     => $valueLot->subinventory_code,
                            'serial_number'         => $valueLot->serial_number != 'null' ? $valueLot->serial_number : '',
                            'inventory_location_id' => $valueLot->inventory_location_id,
                            'inv_uom_code'          => $valueLot->inv_uom_code,
                            'onhand_conv_qty'       => $valueLot->onhand_conv_qty
                        ];


                        // GET ORG AND LOTS

                        $onhandQuery            = Onhand::where('item_code', $orderLine[0]['item_code'])->get();

                        // Data Org and Lot
                        if (!empty($onhandQuery)) {
                            $orgID          = 0;
                            $orgQuantity    = 0;
                            $orgKey         = 0;
                            foreach ($onhandQuery as $key => $value) {

                                if ($orgID == $value->organization_id) {
                                    $orgID = $value->organization_id;
                                    $orgQuantity = $orgQuantity + $value->onhand_quantity;
                                }else{
                                    $orgID = $value->organization_id;
                                    $orgQuantity = $value->onhand_quantity;

                                    if($key != 0)
                                    {
                                        $orgKey += 1;
                                    }
                                }

                                $orgList[$valueLot->pi_lot_id][$orgKey]   = [
                                    'organization_id'       => $value->organization_id,
                                    'organization_code'     => $value->organization_code,
                                    'organization_name'     => $value->organization_name,
                                    'total_onhand_quantity' => $orgQuantity,
                                    'lot_number'            => $value->lot_number,
                                    'subinventory_code'     => $value->subinventory_code,
                                    'serial_number'         => '',
                                    'locator_id'            => $value->locator_id,
                                    'transaction_uom_code'  => $value->transaction_uom_code,
                                    'onhand_quantity'       => $value->onhand_quantity
                                ];

                                $lotList[$valueLot->pi_lot_id][]  = [
                                    'inventory_item_id'     => $value->inventory_item_id,
                                    'organization_id'       => $value->organization_id,
                                    'organization_code'     => $value->organization_code,
                                    'lot_number'            => $value->lot_number,
                                    'onhand_quantity'       => $value->onhand_quantity,
                                    'transaction_uom_code'  => $value->transaction_uom_code,
                                    'serial_number'         => '',
                                    'locator_id'            => $value->locator_id,
                                ];
                            }
                        }
                    }
                }
            }

            $orderHeaderID  = ProformaInvoiceHeaders::where('pi_header_id', $getData->pi_header_id)->pluck('order_header_id')->first();
            $attachmentFile = AttachFiles::where('attachment_program_code','OMP0066')->where('header_id', $orderHeaderID)->whereNull('deleted_at')->get();

            $rest = [
                'resultTotalAmount'     => $resultAmount,
                'orderLine'             => $orderLine,
                'orderLots'             => $orderLots,
                'resultWeights'         => $resultWeight,
                'orgList'               => $orgList,
                'lotList'               => $lotList,
                'data'                  => $dataList,
                'status'                => 'success',
                'attachmentFile'        => $attachmentFile,
                'shipSitesList'         => $shipSitesList,
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
                'orderLots'             => $orderLots,
                'resultWeights'         => $resultWeight,
                'orgList'               => $orgList,
                'lotList'               => $lotList,
                'data'                  => $dataList,
                'status'                => 'false',
                'attachmentFile'        => $attachmentFile,
                'shipSitesList'         => $shipSitesList,
            ];
        }

        // echo '<pre>';
        // print_r($rest);
        // echo '<pre>';
        // exit();

        return response()->json(['data' => $rest]);
    }

    public function manage(Request $request)
    {
        $rest = [];
        $attachmentFile = [];

        // echo '<pre>';
        // print_r($request->all());
        // echo '<pre>';
        // exit();

        $validate = Validator::make($request->all(),[
            'pi_number'     => 'required|string',
        ]);

        if($validate->fails()){
            $rest = [
                'status'    => false,
                'type'      => 'validate',
                'data'      => $validate->errors()
            ];
            return response()->json($rest);
        }else{

            if(!empty($request->pi_number)){

                // วันที่
                // if(!empty($request->pick_release_approve_date)){
                //     $pickReleaseTime = strtotime($request->pick_release_approve_date);
                //     $pickReleaseData = date('Y-m-d H:i:s',$pickReleaseTime);
                // }else{
                //     $pickReleaseData = '';
                // }
                if(!empty($request->pick_release_approve_date)){
                    $dateArr    = explode('/', $request->pick_release_approve_date);
                    $day        = $dateArr[0];
                    $month      = $dateArr[1];
                    $year       = $dateArr[2];
                    $newDate    = $month.'/'.$day.'/'.$year;

                    $pickReleaseTime = strtotime($newDate);
                    $pickReleaseDate = date('Y-m-d H:i:s',$pickReleaseTime);
                }else{
                    $pickReleaseDate = date('Y-m-d H:i:s');
                }

                // วันที่ส่ง
                // if(!empty($request->delivery_date)){
                //     $deliveryTime = strtotime($request->delivery_date);
                //     $deliveryDate = date('Y-m-d H:i:s',$deliveryTime);
                // }else{
                //     $deliveryDate = '';
                // }
                if(!empty($request->delivery_date)){
                    $dateArr    = explode('/', $request->delivery_date);
                    $day        = $dateArr[0];
                    $month      = $dateArr[1];
                    $year       = $dateArr[2];
                    $newDate    = $month.'/'.$day.'/'.$year;

                    $deliveryTime = strtotime($newDate);
                    $deliveryDate = date('Y-m-d H:i:s',$deliveryTime);
                }else{
                    $deliveryDate = '';
                }

                // Check status
                // if ($request->pick_release_status == 'Confirm' && empty($request->pick_release_no)) {

                $getDayOfDueDate = Terms::where('term_id', $request->term_id)
                                        ->whereRaw("nvl(start_date_active,sysdate+1) < sysdate")
                                        ->whereRaw("nvl(end_date_active,sysdate+1) > sysdate")
                                        ->pluck('due_days')->first();

                if (!empty($request->delivery_date)) {
                    $arrCreditDate = explode('/', $request->delivery_date);
                    $cDay   = $arrCreditDate[0];
                    $cMonth = $arrCreditDate[1];
                    $cYear  = $arrCreditDate[2];
                    $creditDateChange = $cYear.'/'.$cMonth.'/'.$cDay;

                    $addDays = ' + '.$getDayOfDueDate.' days';
                    $calDate = date('Y-m-d H:i:s', strtotime($creditDateChange. $addDays));

                    $paymentDuedate = $calDate;
                }else{
                    $paymentDuedate = '';
                }

                $checkUpdate = '';
                if (!empty($request->pick_release_no) && $request->pick_release_status == 'Confirm') {
                    $checkUpdate = 'updateConfirm';
                }


                if (empty($request->pick_release_no)) {
                    $newPickReleaseNo = '';
                    $manageEvent      = 'Confirm';
                }else{
                    $newPickReleaseNo = $request->pick_release_no;
                    $manageEvent      = 'Update';
                }


                if ($checkUpdate == 'updateConfirm') {
                    $update = [
                        'pick_release_id'           => $request->order_header_id,
                        'pick_release_no'           => $newPickReleaseNo,
                        'pick_release_approve_date' => $pickReleaseDate,
                        'pick_release_status'       => $request->pick_release_status,
                        'exchange_rate'             => $request->exchange_rate,
                        'remark'                    => $request->remark,
                        'delivery_date'             => $deliveryDate,
                        'shipping_marks'            => $request->shipping_marks,
                        'payment_duedate'           => $paymentDuedate,
                        'forward_flag'              => $request->forward_flag == 'on' ? 'Y' : 'N',
                        'program_code'              => 'OMP0073',
                        'updated_by_id'             => optional(auth()->user())->user_id,
                        'updated_at'                => date('Y-m-d H:i:s'),
                        'last_updated_by'           => optional(auth()->user())->user_id,
                        'last_update_date'          => date('Y-m-d H:i:s')
                    ];
                } else {
                    $update = [
                        'pick_release_id'           => $request->order_header_id,
                        'pick_release_no'           => $newPickReleaseNo,
                        'pick_release_approve_date' => $pickReleaseDate,
                        'pick_release_status'       => $request->pick_release_status,
                        'exchange_rate'             => $request->exchange_rate,
                        'remark'                    => $request->remark,
                        'bill_to_site_id'           => $request->bill_to_site_id,
                        'payment_type_code'         => $request->payment_type_code,
                        // 'ship_to_site_name'         => $request->ship_to_site_id,
                        'incoterms_code'            => $request->incoterms_code,
                        'port_of_loading'           => $request->port_of_loading,
                        'transport_type_code'       => $request->transport_type_code,
                        'transport_detail'          => $request->transport_detail,
                        'port_of_discharge'         => $request->port_of_discharge,
                        'place_of_delivery'         => $request->place_of_delivery,
                        'shipping_marks'            => $request->shipping_marks,
                        'shipment_condition'        => $request->shipment_condition,
                        'source_system'             => $request->source_system,
                        'delivery_date'             => $deliveryDate,
                        'shipping_marks'            => $request->shipping_marks,
                        'payment_duedate'           => $paymentDuedate,
                        'forward_flag'              => $request->forward_flag == 'on' ? 'Y' : 'N',
                        'program_code'              => 'OMP0073',
                        'updated_by_id'             => optional(auth()->user())->user_id,
                        'updated_at'                => date('Y-m-d H:i:s'),
                        'last_updated_by'           => optional(auth()->user())->user_id,
                        'last_update_date'          => date('Y-m-d H:i:s')
                    ];
                }

                // echo '<pre>';
                // print_r($update);
                // echo '<pre>';
                // exit();

                $getDataQuery = ProformaInvoiceHeaders::where('pi_header_id', $request->pi_header_id)->first();

                $check = ProformaInvoiceHeaders::where('pi_header_id', $request->pi_header_id)->update($update);

                if(!!$check){

                    if($request->hasFile('attachment')) {
                        $fileAttachment = $request->file('attachment');
                        AttachmentRepo::uploadAttachmentMultiple($fileAttachment,$getDataQuery->order_header_id,'OMP0066');
                    }

                    $afterDeliveryDate = !empty($request->delivery_date) ? date('d/m/Y',strtotime($request->delivery_date)) : $request->delivery_date;
                    $beforeDeliveryDate = !empty($getDataQuery->delivery_date) ? date('d/m/Y',strtotime($getDataQuery->delivery_date)) : $getDataQuery->delivery_date;

                    if($afterDeliveryDate != $beforeDeliveryDate){
                        GenerateNumberRepo::callWMSPackageTaxInvoiceChangeDeliveryDate($request->pi_header_id, $getDataQuery->pi_number);
                    }

                    if (!empty($request->pi_line_id)) {
                        foreach ($request->pi_line_id as $key => $valueLine) {
                            $updateLine = [
                                'weight_unit_net'           => $request->net_weight[$key],
                                'weight_unit_gross'         => $request->net_gross[$key],
                                'total_net_weight'          => $request->total_net_weight[$key],
                                'total_net_gross'           => $request->total_net_gross[$key],
                                'program_code'              => 'OMP0073',
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


                    if (!empty($request->lot_pi_line_id) && $manageEvent == 'Confirm') {
                        foreach ($request->lot_pi_line_id as $key => $valueLot) {

                            // Lot onhand conv qty
                            if (!empty($request->lot_onhand_conv_qty[$key])) {
                                $convReplace = str_replace(',', '', $request->lot_onhand_conv_qty[$key]);
                                $convExplode = explode('.', $convReplace);
                                $conv        = !empty($convExplode[0]) ? $convExplode[0] : 0;
                            }else{
                                $conv        = '';
                            }

                            // lot onhand quantity
                            if (!empty($request->lot_onhand_quantity[$key])) {
                                $onhandQuantityReplace = str_replace(',', '', $request->lot_onhand_quantity[$key]);
                                $onhandQuantityExplode = explode('.', $onhandQuantityReplace);
                                $onhandQuantity        = !empty($onhandQuantityExplode[0]) ? $onhandQuantityExplode[0] : 0;
                            }else{
                                $onhandQuantity        = '';
                            }

                            // lot onhand quantity
                            if (!empty($request->lot_order_quantity[$key])) {
                                $orderQuantityReplace = str_replace(',', '', $request->lot_order_quantity[$key]);
                                $orderQuantityExplode = explode('.', $orderQuantityReplace);
                                $orderQuantity        = !empty($orderQuantityExplode[0]) ? $orderQuantityExplode[0] : 0;
                            }else{
                                $orderQuantity        = '';
                            }

                            // echo '<pre>';
                            // print_r($updateLine);
                            // echo '<pre>';
                            // exit();

                            $dataLot = [
                                'item_id'               => $request->lot_item_id[$key],
                                'item_code'             => $request->lot_item_code[$key],
                                'item_description'      => $request->lot_item_description[$key],
                                'inv_org_id'            => $request->lot_inv_org_id[$key],
                                'subinventory_code'     => $request->lot_subinventory_code[$key],
                                'serial_number'         => $request->lot_serial_number[$key],
                                'inventory_location_id' => $request->lot_inventory_location_id[$key],
                                'inv_uom_code'          => $request->lot_inv_uom_code[$key],
                                'onhand_conv_qty'       => $conv,
                                'inv_org_code'          => $request->lot_inv_org_code[$key],
                                'inv_org_name'          => $request->inv_org_name[$key],
                                'lot_number'            => $request->lot_lot_number[$key],
                                'onhand_quantity'       => $onhandQuantity,
                                'order_quantity'        => $orderQuantity,
                                'program_code'          => 'OMP0073',
                                'updated_by_id'         => optional(auth()->user())->user_id,
                                'updated_at'            => date('Y-m-d H:i:s'),
                                'last_updated_by'       => optional(auth()->user())->user_id,
                                'last_update_date'      => date('Y-m-d H:i:s')
                            ];
                            ProformaInvoiceLots::where('pi_lot_id', $request->lot_pi_lot_id[$key])->update($dataLot);

                        }
                    }

                    // Update Number

                    if (empty($request->pick_release_no)) {
                        $newPickReleaseNo = GenerateNumberRepo::generateApprovePrepare('OMP0073_IV_NUM_EXP');

                        $update = [
                            'pick_release_id'           => $request->order_header_id,
                            'pick_release_no'           => $newPickReleaseNo,
                            'pick_release_approve_date' => $pickReleaseDate,
                            'pick_release_status'       => $request->pick_release_status,
                            'exchange_rate'             => $request->exchange_rate,
                            'remark'                    => $request->remark,
                            'bill_to_site_id'           => $request->bill_to_site_id,
                            'payment_type_code'         => $request->payment_type_code,
                            // 'ship_to_site_name'         => $request->ship_to_site_id,
                            'incoterms_code'            => $request->incoterms_code,
                            'port_of_loading'           => $request->port_of_loading,
                            'transport_type_code'       => $request->transport_type_code,
                            'transport_detail'          => $request->transport_detail,
                            'port_of_discharge'         => $request->port_of_discharge,
                            'place_of_delivery'         => $request->place_of_delivery,
                            'shipping_marks'            => $request->shipping_marks,
                            'shipment_condition'        => $request->shipment_condition,
                            'source_system'             => $request->source_system,
                            'delivery_date'             => $deliveryDate,
                            'shipping_marks'            => $request->shipping_marks,
                            'payment_duedate'           => $paymentDuedate,
                            'forward_flag'              => $request->forward_flag == 'on' ? 'Y' : 'N',
                            'program_code'              => 'OMP0073',
                            'updated_by_id'             => optional(auth()->user())->user_id,
                            'updated_at'                => date('Y-m-d H:i:s'),
                            'last_updated_by'           => optional(auth()->user())->user_id,
                            'last_update_date'          => date('Y-m-d H:i:s')
                        ];

                        ProformaInvoiceHeaders::where('pi_header_id', $request->pi_header_id)->update($update);
                    }

                    $invoiceList   = ProformaInvoiceHeaders::join('ptom_customers', 'ptom_proforma_invoice_headers.customer_id', '=', 'ptom_customers.customer_id')
                                                ->select(
                                                    'ptom_proforma_invoice_headers.pi_number',
                                                    'ptom_proforma_invoice_headers.pi_date',
                                                    'ptom_proforma_invoice_headers.pick_release_no',
                                                    'ptom_proforma_invoice_headers.pick_release_approve_date',
                                                    'ptom_proforma_invoice_headers.pick_release_status',
                                                    'ptom_customers.customer_number',
                                                    'ptom_customers.customer_name',
                                                )
                                                ->where('ptom_customers.sales_classification_code', 'Export')
                                                ->where('ptom_proforma_invoice_headers.order_status', 'Confirm')
                                                ->whereNull('ptom_proforma_invoice_headers.deleted_at')
                                                ->orderBy('ptom_proforma_invoice_headers.pick_release_no', 'desc')->get();

                    if (!$invoiceList->isEmpty()) {
                        foreach ($invoiceList as $key => $value) {
                            $invoiceList[$key]->pi_date    = !empty($value->pi_date) ? dateFormatDMYDefault(date('m/d/Y',strtotime($value->pi_date))) : '';
                            $invoiceList[$key]->pick_release_approve_date = !empty($value->pick_release_approve_date) ? dateFormatDMYDefault(date('m/d/Y',strtotime($value->pick_release_approve_date))) : '';
                        }
                    }


                    $proformaList   = ProformaInvoiceHeaders::join('ptom_customers', 'ptom_proforma_invoice_headers.customer_id', '=', 'ptom_customers.customer_id')
                                                            ->select(
                                                                'ptom_proforma_invoice_headers.pi_number',
                                                                'ptom_proforma_invoice_headers.pi_date',
                                                                'ptom_proforma_invoice_headers.pick_release_no',
                                                                'ptom_proforma_invoice_headers.pick_release_approve_date',
                                                                'ptom_proforma_invoice_headers.pick_release_status',
                                                                'ptom_customers.customer_number',
                                                                'ptom_customers.customer_name',
                                                            )
                                                            ->where('ptom_customers.sales_classification_code', 'Export')
                                                            ->where('ptom_proforma_invoice_headers.order_status', 'Confirm')
                                                            ->whereNull('ptom_proforma_invoice_headers.deleted_at')
                                                            ->orderBy('ptom_proforma_invoice_headers.pi_number', 'desc')->get();

                    if (!$proformaList->isEmpty()) {
                        foreach ($proformaList as $key => $value) {
                            $proformaList[$key]->pi_date    = !empty($value->pi_date) ? dateFormatDMYDefault(date('m/d/Y',strtotime($value->pi_date))) : '';
                            $proformaList[$key]->pick_release_approve_date = !empty($value->pick_release_approve_date) ? dateFormatDMYDefault(date('m/d/Y',strtotime($value->pick_release_approve_date))) : '';
                        }
                    }



                    $orderHeaderData    = ProformaInvoiceHeaders::where('pi_header_id', $request->pi_header_id)->first();

                    if (!empty($orderHeaderData)) {
                            $orderHeaderData->pi_date    = !empty($orderHeaderData->pi_date) ? dateFormatDMYDefault(date('m/d/Y',strtotime($orderHeaderData->pi_date))) : '';
                            $orderHeaderData->pick_release_approve_date = !empty($orderHeaderData->pick_release_approve_date) ? dateFormatDMYDefault(date('m/d/Y',strtotime($orderHeaderData->pick_release_approve_date))) : '';
                    }

                    $attachmentFile     = AttachFiles::where('attachment_program_code','OMP0066')->where('header_id', $orderHeaderData->order_header_id)->whereNull('deleted_at')->get();

                    $rest = [
                        'invoiceList'       => $invoiceList,
                        'proformaList'       => $proformaList,
                        'status'            => 'success',
                        'data'              => $orderHeaderData,
                        'attachmentFile'    => $attachmentFile
                    ];
                }else{
                    $rest = [
                        'invoiceList'       => [],
                        'proformaList'      => [],
                        'status'            => 'false',
                        'data'              => [],
                        'attachmentFile'    => $attachmentFile
                    ];
                }

                if($request->pick_release_status == 'Confirm'){
                    GenerateNumberRepo::callWMSPackageTaxInvoice($request->pi_header_id, $getDataQuery->pi_number);
                }

            }else{
                $rest = [
                    'invoiceList'       => [],
                    'proformaList'      => [],
                    'status'            => 'false',
                    'data'              => [],
                    'attachmentFile'    => $attachmentFile
                ];
            }
        }

        return response()->json(['data' => $rest]);
    }

    public function checkCancel($invoiceID, $piNumber)
    {
        $checkPaymentCancel = 0;
        $rest               = [];

        if (!empty($invoiceID)) {
            $matchInvoice = PaymentMatchInvoices::where('invoice_id', $invoiceID)->where('match_flag', 'Y')->where('payment_amount', '>', 0)->get();

            if (!empty($matchInvoice)) {
                foreach ($matchInvoice as $key => $value) {
                    $paymentQuery = PaymentHeaders::where('payment_header_id', $value->payment_header_id)->where('payment_status', '!=', 'Cancel')->where('payment_status', '!=', 'Cancelled')->first();

                    if (!empty($paymentQuery)) {
                        $checkPaymentCancel += 1;
                    }
                }
            }

            $checkWMS   = DB::table('ptom_order_t_wms')->where('oaom_order_header_id', $invoiceID)->where('oaom_wms6_inven', 'Y')->first();

            $checkClose = ProformaInvoiceHeaders::where('order_header_id', $invoiceID)->where('pick_release_no', $piNumber)->where('close_sale_flag', 'Y')->first();

            if(!empty($checkClose->order_header_id)){
                $rest = [
                    'status'    => 'closed'
                ];
            }else if(!empty($checkWMS->oaom_order_header_id)){
                $rest = [
                    'status'    => 'wms_y'
                ];
            }else if ($checkPaymentCancel > 0) {
                $rest = [
                    'status'    => 'matching',
                ];
            }else{
                $rest = [
                    'status'    => 'notmatching'
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
            'invoice_cancel_reason' => $request->invoice_cancel_reason,
            'pick_release_status'   => $request->pick_release_status,
            'program_code'          => 'OMP0073',
            'updated_by_id'         => optional(auth()->user())->user_id,
            'updated_at'            => date('Y-m-d H:i:s'),
            'last_updated_by'       => optional(auth()->user())->user_id,
            'last_update_date'      => date('Y-m-d H:i:s')
        ];

        if(ProformaInvoiceHeaders::where('pi_header_id', $request->pi_header_id)->update($update))
        {

            $updateWMS  = [
                'record_status' => 'C'
            ];

            DB::table('ptom_order_t_wms')->where('oaom_order_header_id', $request->order_header_id)->update($updateWMS);

            // INVOICE

            // $year = strval((date('Y') + 543)-2500);
            // if(!date('Y')) $year = '64';
            // $symbol = 'AC';

            // $last = ProformaInvoiceHeaders::where('pick_release_no', 'LIKE', $year.$symbol.'%')->whereNotNull('pick_release_no')->orderBy('pick_release_no','desc')->first();

            // if (!empty($last->pick_release_no)) {
            //     $last_number = explode($symbol,$last->pick_release_no);
            //     if(empty(is_numeric($last_number[1]))){
            //         $newnumber = sprintf('%04d', 1);
            //     }
            //     else if(is_numeric($last_number[1])){
            //         $newnumber = sprintf('%04d', $last_number[1]+1);
            //     }else{
            //         $newnumber = sprintf('%04d', 1);
            //     }
            //     $newPickReleaseNo = $symbol.$newnumber;
            // }else{
            //     $newnumber = sprintf('%04d', 1);
            //     $newPickReleaseNo = $year . $symbol . $newnumber;
            // }


            // $sumTotalAmount      = ProformaInvoiceLines::where('pi_header_id', $request->pi_header_id)->whereNull('deleted_at')->sum('total_amount');

            // $insertInvoice = [
            //     'invoice_headers_number'    => $newPickReleaseNo,
            //     'customer_id'               => $request->customer_id,
            //     'province_name'             => !empty($request->customer_id) ? Customers::where('customer_id', $request->customer_id)->pluck('province_name')->first() : '',
            //     'invoice_type'              => 'CN_OTHER',
            //     'invoice_date'              => date('Y-m-d H:i:s'),
            //     'invoice_amount'            => $sumTotalAmount,
            //     'invoice_status'            => 'Confirm',
            //     'term_id'                   => $request->original_term_id,
            //     'channel_receiving_code'    => '40',
            //     'currency'                  => $request->currency,
            //     'program_code'              => 'OMP0073',
            //     'created_by'                => optional(auth()->user())->user_id,
            //     'created_by_id'             => optional(auth()->user())->user_id,
            //     'created_at'                => date('Y-m-d H:i:s'),
            //     'creation_date'             => date('Y-m-d H:i:s'),
            //     'updated_by_id'             => optional(auth()->user())->user_id,
            //     'updated_at'                => date('Y-m-d H:i:s'),
            //     'last_updated_by'           => optional(auth()->user())->user_id,
            //     'last_update_date'          => date('Y-m-d H:i:s')
            // ];

            // InvoiceHeaders::insert($insertInvoice);

            // foreach ($request->pi_line_id as $key => $value) {
            //     $piLineQuery    = ProformaInvoiceLines::where('pi_line_id', $value)->first();

            //     if (!empty($piLineQuery)) {

            //         $insertInvoiceLine  = [
            //             'invoice_headers_id'        => InvoiceHeaders::orderBy('invoice_headers_id')->pluck('invoice_headers_id')->first(),
            //             'item_id'                   => $piLineQuery->item_id,
            //             'item_code'                 => $piLineQuery->item_code,
            //             'item_description'          => $piLineQuery->item_description,
            //             'uom_code'                  => $piLineQuery->uom_code,
            //             'quantity'                  => $piLineQuery->approve_quantity,
            //             'document_id'               => $request->order_header_id,
            //             'document_line_id'          => $piLineQuery->pi_line_id,
            //             'payment_amount'            => $piLineQuery->total_amount,
            //             'invoice_flag'              => 'Y',
            //             'conversion_rate'           => $request->exchange_rate,
            //             'program_code'              => 'OMP0073',
            //             'created_by'                => optional(auth()->user())->user_id,
            //             'created_by_id'             => optional(auth()->user())->user_id,
            //             'created_at'                => date('Y-m-d H:i:s'),
            //             'creation_date'             => date('Y-m-d H:i:s'),
            //             'updated_by_id'             => optional(auth()->user())->user_id,
            //             'updated_at'                => date('Y-m-d H:i:s'),
            //             'last_updated_by'           => optional(auth()->user())->user_id,
            //             'last_update_date'          => date('Y-m-d H:i:s')
            //         ];

            //         InvoiceLines::insert($insertInvoiceLine);
            //     }
            // }

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

    public function closeWork($orderHeaderID)
    {
        $rest = [];

        if (!empty($orderHeaderID)) {

            $interfaceQuery = Interfaces::where('order_header_id', $orderHeaderID)->where('interface_status', 'S')->whereNull('deleted_at')->first();

            if (!empty($interfaceQuery->interface_id)) {

                $proformaInvoiceHeadersQuery = ProformaInvoiceHeaders::where('order_header_id', $orderHeaderID)->where('forward_flag', 'Y')->whereNull('deleted_at')->first();

                if (!empty($proformaInvoiceHeadersQuery)) {
                    $rest = [
                        'status'    => 'success',
                        'data'      => ''
                    ];
                }else{
                    $rest = [
                        'status'    => 'ceritfy',
                        'data'      => ''
                    ];
                }
            }else{
                $rest = [
                    'status'    => 'retry',
                    'data'      => ''
                ];
            }

        }else{
            $rest = [
                'status'    => 'fail',
                'data'      => ''
            ];
        }

        return response()->json(['data' => $rest]);
    }
}
