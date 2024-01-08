<?php

namespace App\Http\Controllers\OM;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\OM\Customers\Domestics\Customer;
use App\Models\OM\Customers\Domestics\CustomerShipSites;
use App\Models\OM\Customers\Domestics\PaymentType;
use App\Models\OM\Customers\Domestics\PriceList;
use App\Models\OM\Customers\Domestics\PriceListLine;
use App\Models\OM\SaleConfirmation\Currencies;
use App\Models\OM\SaleConfirmation\Incoterms;
use App\Models\OM\SaleConfirmation\OrderHeaders;
use App\Models\OM\SaleConfirmation\PaymentMethodExport;
use App\Models\OM\SaleConfirmation\ProformaInvoiceHeaders;
use App\Models\OM\SaleConfirmation\ProformaInvoiceLines;
use App\Models\OM\SaleConfirmation\ProformaInvoiceLots;
use App\Models\OM\SaleConfirmation\SalesChannel;
use App\Models\OM\SaleConfirmation\ShipmentBy;
use App\Models\OM\SaleConfirmation\TaxCode;
use App\Models\OM\SaleConfirmation\Terms;
use App\Models\OM\SaleConfirmation\TransactionTypes;
use App\Models\OM\SaleConfirmation\Uom;
use App\Models\OM\SequenceEcoms;
use App\Repositories\OM\GenerateNumberRepo;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaxInvoiceExportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $menu = Menu::where('program_code', 'OMP0073')->first();
        // dd($menu);
        view()->share('menu', $menu);
    }

    public function index()
    {
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

        $orderTypes             = TransactionTypes::select('order_type_id', 'order_type_name', 'description')->where('sales_type', 'EXPORT')->get();
        $paymentType            = PaymentType::get();
        $paymentMethodExport    = PaymentMethodExport::get();
        $salesChannel           = SalesChannel::select('lookup_code', 'meaning', 'description')->where('enabled_flag', 'Y')->get();
        $incoterms              = Incoterms::get();
        $shipmentBy             = ShipmentBy::where('tag', 'E')
                                            ->where('enabled_flag', 'Y')
                                            ->whereRaw("nvl(start_date_active,sysdate+1) < sysdate")
                                            ->whereRaw("nvl(end_date_active,sysdate+1) > sysdate")->get();

        $taxCode                = TaxCode::where('tax_regime_code', 'SVAT')->where('rate_type_code', 'PERCENTAGE')->where('active_flag', 'Y')->orderBy('tax_rate_code', 'ASC')->get();
        $terms                  = Terms::where('sale_type', 'EXPORT')->whereRaw("nvl(start_date_active,sysdate+1) < sysdate")->whereRaw("nvl(end_date_active,sysdate+1) > sysdate")->get();
        $currency               = Currencies::get();


        $customerList           = Customer::where('sales_classification_code', 'Export')->where('status', 'Active')->whereNull('deleted_at')->orderBy('customer_number', 'ASC')->get();

        $priceList              = PriceList::select('price_list_id', 'list_header_id', 'name', 'currency_code')
                                        ->whereRaw("nvl(end_date_active,sysdate+1) > sysdate")
                                        ->where('active_flag', 'Y')
                                        ->where('attribute1', 'EXPORT')
                                        ->orderBy('name')->get();

        $priceListLine          = PriceListLine:: whereRaw("nvl(start_date_active,sysdate+1) < sysdate")->where('automatic_flag', 'Y')->get();

        $attachmentFile = [];

        $inCortermName = DB::table('ptom_incoterms')->select('attribute1')->where('lookup_code', 30)->pluck('attribute1')->first();

        $data_compact = array(
            'orderTypes',
            'paymentType',
            'paymentMethodExport',
            'salesChannel',
            'incoterms',
            'shipmentBy',
            'taxCode',
            'terms',
            'currency',
            'priceList',
            'priceListLine',
            'invoiceList',
            'proformaList',
            'customerList',
            'attachmentFile',
            'inCortermName'
        );

        return view('om.tax_invoice_export.index', compact($data_compact));
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
    public function update(Request $request)
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

    public function printinvoice(Request $request)
    {
        // echo '<pre>';
        // print_r($request->all());
        // echo '<pre>';
        // exit();

        $piHeaderID = !empty($request->pi_header_id) ? $request->pi_header_id : 0;

        if ($piHeaderID > 0) {

            $proformaData   = [];
            $orderLinesData = [];
            $totalCost      = 0.00;
            $totalFOB       = 0.00;
            $totalNet       = 0.00;
            $totalGross     = 0.00;
            $totalQuantity  = 0.00;
            $totalApprovePack           = 0.00;
            $totalApproveCartonBox      = 0.00;
            $totalApproveCarton         = 0.00;

            $toatAddress    = DB::table('ptom_toat_address_v')->first();

            $proformaData    = ProformaInvoiceHeaders::join('ptom_customers', 'ptom_proforma_invoice_headers.customer_id', '=', 'ptom_customers.customer_id')
                                                ->join('ptom_order_headers', 'ptom_proforma_invoice_headers.order_header_id', '=', 'ptom_order_headers.order_header_id')
                                                ->select(
                                                    'ptom_proforma_invoice_headers.*',
                                                    'ptom_customers.bill_to_site_name',
                                                    'ptom_customers.country_name',
                                                    'ptom_customers.customer_name',
                                                    'ptom_customers.address_line1',
                                                    'ptom_customers.address_line2',
                                                    'ptom_customers.address_line3',
                                                    'ptom_customers.state',
                                                    'ptom_customers.postal_code',
                                                    'ptom_customers.city_code',
                                                    'ptom_customers.city',
                                                    'ptom_customers.district_code',
                                                    'ptom_customers.district',
                                                    'ptom_customers.province_name',
                                                    'ptom_customers.tax_register_number',
                                                    'ptom_customers.branch',
                                                    'ptom_order_headers.order_number',
                                                    'ptom_customers.head_office_flag'
                                                )
                                                ->where('ptom_proforma_invoice_headers.pi_header_id', $piHeaderID)
                                                ->whereNull('ptom_proforma_invoice_headers.deleted_at')->first();


            if (!empty($proformaData)) {
                $customerID     = $proformaData->customer_id;
                $shipToSiteID   = $proformaData->ship_to_site_id;

                // GET DATA CUSTOMER SHIP SITES
                $customerShipSiteData = CustomerShipSites::where('ship_to_site_id', $shipToSiteID)->first();

                // SET DATA CUSTOMER SHIP SITE
                $proformaData->ship_to_site_name           = !empty($customerShipSiteData->ship_to_site_name) ? $customerShipSiteData->ship_to_site_name : '';
                $proformaData->ship_country_code           = !empty($customerShipSiteData->country_code) ? $customerShipSiteData->country_code : '';
                $proformaData->ship_country_name           = !empty($customerShipSiteData->country_name) ? $customerShipSiteData->country_name : '';
                $proformaData->ship_address_line_1         = !empty($customerShipSiteData->address_line1) ? $customerShipSiteData->address_line1 : '';
                $proformaData->ship_address_line_2         = !empty($customerShipSiteData->address_line2) ? $customerShipSiteData->address_line2 : '';
                $proformaData->ship_address_line_3         = !empty($customerShipSiteData->address_line3) ? $customerShipSiteData->address_line3 : '';
                $proformaData->ship_state                  = !empty($customerShipSiteData->state) ? $customerShipSiteData->state : '';
                $proformaData->ship_postal_code            = !empty($customerShipSiteData->postal_code) ? $customerShipSiteData->postal_code : '';
                $proformaData->ship_city                   = !empty($customerShipSiteData->city) ? $customerShipSiteData->city : '';
                $proformaData->ship_district               = !empty($customerShipSiteData->district) ? $customerShipSiteData->district : '';
                $proformaData->ship_province_name          = !empty($customerShipSiteData->province_name) ? $customerShipSiteData->province_name : '';
                $proformaData->ship_tax_register_number    = !empty($customerShipSiteData->tax_register_number) ? $customerShipSiteData->tax_register_number : '';
                
                $proformaData->ship_district    = DB::table('ptom_thailand_territory')
                                                    ->where('tambon_id', $proformaData->district_code)
                                                    ->pluck('tambon_eng_short')
                                                    ->first();
                $proformaData->ship_city        = DB::table('ptom_thailand_territory')
                                                    ->where('district_id', $proformaData->city_code)
                                                    ->pluck('district_eng_short')
                                                    ->first();
                $proformaData->district         = DB::table('ptom_thailand_territory')
                                                    ->where('tambon_id', $proformaData->district_code)
                                                    ->pluck('tambon_eng_short')
                                                    ->first();
                $proformaData->city             = DB::table('ptom_thailand_territory')
                                                    ->where('district_id', $proformaData->city_code)
                                                    ->pluck('district_eng_short')
                                                    ->first();

                // GET DATA SHIPMENT BY
                $shipmentMeaning                    = DB::table('ptom_shipment_by')
                                                        ->where('lookup_code', $proformaData->transport_type_code)
                                                        ->where('tag', 'E')
                                                        ->pluck('meaning')
                                                        ->first();
                $proformaData->shipment_meaning     = !empty($shipmentMeaning) ? $shipmentMeaning : $proformaData->transport_detail;

                // GET INCORTERM DESCRIPTION
                $incortermsDescription              = DB::table('ptom_incoterms')
                                                        ->select('meaning')
                                                        ->where('lookup_code', $proformaData->incoterms_code)
                                                        ->pluck('meaning')
                                                        ->first();
                $proformaData->incoterm_desription  = !empty($incortermsDescription) ? $incortermsDescription : '';


                // FORMAT PICK RELEASE APPROVE DATE
                $proformaData->pick_release_approve_date     = !empty($proformaData->pick_release_approve_date) ? date("F j, Y", strtotime($proformaData->pick_release_approve_date))  : '';
                $proformaData->delivery_date_text            = !empty($proformaData->delivery_date) ? date("F j, Y", strtotime($proformaData->delivery_date))  : '';
                $proformaData->pi_date_text                  = !empty($proformaData->pi_date) ? date("F j, Y", strtotime($proformaData->pi_date))  : '';

                // FORMAT PI DATE
                $proformaData->pi_date = !empty($proformaData->pi_date) ? date("F j, Y", strtotime($proformaData->pi_date))  : '';

                // FORMAT SALE CONFIRM DATE
                $proformaData->sale_confirm_date = !empty($proformaData->sale_confirm_date) ? date("F j, Y", strtotime($proformaData->sale_confirm_date))  : '';

                // FORMAT ORDER DATE
                $proformaData->order_date = !empty($proformaData->order_date) ? date("F j, Y", strtotime($proformaData->order_date))  : '';

                // GET TERM DESCRIPTION
                $termDescription                    = DB::table('ptom_terms_v')
                                                        ->where('term_id', $proformaData->term_id)
                                                        ->where('sale_type', 'EXPORT')
                                                        ->pluck('description')->first();
                $proformaData->term_description     = !empty($termDescription) ? $termDescription : '';

                // MONEY NUMBER TO TEXT
                $explodeGrandTotal              = explode('.', number_format($proformaData->grand_total, 2, '.', ''));
                $grandTotalFirst                = !empty($explodeGrandTotal[0]) ? ucwords(translateToWords((int)$explodeGrandTotal[0])) : '';
                $grandTotalStang                = !empty($explodeGrandTotal[1]) && $explodeGrandTotal[1] > 0 ? ' and '.ucwords(translateToWords((int)$explodeGrandTotal[1])) : '';
                $proformaData->grand_total_text = $grandTotalFirst.$grandTotalStang;

                $proformaData->sub_total   = !empty($proformaData->sub_total) ? number_format((float)$proformaData->sub_total, 2, '.', ',') : '';
                $proformaData->tax         = !empty($proformaData->tax) ? number_format((float)$proformaData->tax, 2, '.', ',') : '';
                $proformaData->grand_total = !empty($proformaData->grand_total) ? number_format((float)$proformaData->grand_total, 2, '.', ',') : '';

                // GET DETAIL PTOM_ORDER_LINES
                $orderLinesDataDefault     = ProformaInvoiceLines::where('pi_header_id', $piHeaderID)->whereNull('deleted_at')->orderBy('line_number')->get();

                if (!empty($orderLinesDataDefault)) {
                    $numLine    = 1;
                    $numCheck   = 1;
                    foreach ($orderLinesDataDefault as $key => $itemLines) {

                        $converApproveQuantity = GenerateNumberRepo::convertUnitItem($itemLines->item_id, $itemLines->approve_quantity, $itemLines->uom_code, 'CS1');

                        $orderLinesDataDefault[$key]->approve_quantity = !empty($itemLines->approve_quantity) ? ($proformaData->product_type_code != 10 ? number_format((float)$itemLines->approve_quantity, 2, '.', ',') : number_format((float)$itemLines->approve_quantity, 0, '.', ',')) : 0;
                        $orderLinesDataDefault[$key]->unit_price       = !empty($itemLines->unit_price) ? number_format((float)$itemLines->unit_price, 2, '.', ',') : number_format((float)0, 2, '.', ',');
                        $orderLinesDataDefault[$key]->amount           = !empty($itemLines->amount) ? number_format((float)$itemLines->amount, 2, '.', ',') : number_format((float)0, 2, '.', ',');

                        // GET DATA ITEM DESCRIPTION BY SEQUENCE ECOMS
                        $sequenceEcoms  = SequenceEcoms::where('item_id', $itemLines->item_id)->first();
                        $orderLinesDataDefault[$key]->report_item_display  = !empty($sequenceEcoms->report_item_display) ? $sequenceEcoms->report_item_display : '';

                        // GET UOM DATA
                        $uomReportEXP = Uom::where('uom_code', $itemLines->uom_code)->pluck('name_for_report_exp')->first();
                        $orderLinesDataDefault[$key]->name_for_report_exp = !empty($uomReportEXP) ? $uomReportEXP : '';

                        // GET LOTS DATA
                        $piLotsData = ProformaInvoiceLots::where('pi_line_id', $itemLines->pi_line_id)->whereNull('deleted_at')->orderBy('pi_lot_id')->get();
                        $lotTotalNetWeight = 0.00;
                        $lotTotalNetGross  = 0.00;

                        if (!empty($piLotsData)) {
                            foreach ($piLotsData as $keyLines => $itemLots) {
                                $lotTotalNetWeight = (float)$lotTotalNetWeight + (float)$itemLots->total_weight_unit_net;
                                $lotTotalNetGross  = (float)$lotTotalNetGross + (float)$itemLots->total_weight_unit_gross;
                                $totalQuantity = (float)$totalQuantity + (float)$itemLots->quantity_cbb;

                                $itemLots->total_weight_unit_net = number_format($itemLots->total_weight_unit_net, 2, '.', ',');
                                $itemLots->total_weight_unit_gross = number_format($itemLots->total_weight_unit_gross, 2, '.', ',');

                                $sequenceEcoms  = SequenceEcoms::where('item_id', $itemLines->item_id)->first();
                                $itemLots->report_item_display  = !empty($sequenceEcoms->report_item_display) ? $sequenceEcoms->report_item_display : '';

                                $dataPiLotData[$numLine][] = $itemLots;
                            }
                        }

                        $orderLinesDataDefault[$key]->total_net_weight = number_format((float)$lotTotalNetWeight, 2, '.', ',');
                        $orderLinesDataDefault[$key]->total_net_gross  = number_format((float)$lotTotalNetGross, 2, '.', ',');

                        $totalApprovePack       = (float)$totalApprovePack + (float)$converApproveQuantity;
                        $totalApproveCartonBox  = (float)$totalApproveCartonBox + (float)$itemLines->approve_cartonbox;
                        $totalApproveCarton     = (float)$totalApproveCarton + (float)$itemLines->approve_carton;

                        // $totalQuantity  = (float)$totalQuantity + (float)$orderLinesDataDefault[$key]->count_cardboad;
                        $totalCost      = (float)$totalCost + (float)$itemLines->amount;
                        $totalNet       = (float)$totalNet + (float)$lotTotalNetWeight;
                        $totalGross     = (float)$totalGross + (float)$lotTotalNetGross;
                        $totalUom       = $itemLines->uom;
                    }

                    foreach ($orderLinesDataDefault as $keySet => $setLine) {
                        $orderLinesData[$numLine][$keySet] = $setLine;

                        if ($numCheck == 3) {
                            $numLine++;
                            $numCheck = 1;
                        }else{
                            $numCheck++;
                        }
                    }
                }

                // GET PERCENTAGE RATE
                $proformaData->percentage_rate = TaxCode::where('tax_rate_code', $proformaData->vat_code)->pluck('percentage_rate')->first();

                $totalCost  = number_format((float)$totalCost, 2, '.', '');
                $totalFOB   = $totalCost * ($proformaData->percentage_rate / 100);

                $totalCost  = number_format((float)$totalCost, 2, '.', ',');
                $totalFOB   = number_format((float)$totalFOB, 2, '.', ',');

                // Net and Gross
                $totalNet       = number_format((float)$totalNet, 2, '.', ',');
                $totalGross     = number_format((float)$totalGross, 2, '.', ',');

                // Packing
                $totalApprovePack = number_format((float)$totalApprovePack, 2, '.', ',');

                // Incoterm 2010
                $incotermData = DB::table('ptom_incoterms')->select('attribute1', 'meaning', 'description')->where('tag', 'Y')->get();

                // Payment
                $paymentData    = DB::table('ptom_payment_details_v')
                                    ->where('enabled_flag', 'Y')
                                    ->whereRaw("nvl(start_date_active,sysdate+1) < sysdate")
                                    ->whereRaw("nvl(end_date_active,sysdate+1) > sysdate")->get();

                // Packing
                $packingData    = DB::table('ptom_packing_details_v')
                                    ->where('enabled_flag', 'Y')
                                    ->whereRaw("nvl(start_date_active,sysdate+1) < sysdate")
                                    ->whereRaw("nvl(end_date_active,sysdate+1) > sysdate")
                                    ->orderBy('lookup_code', 'ASC')->get();

                // Approve
                $approveData    = DB::table('ptom_approval_name_ex_v')
                                    ->where('enabled_flag', 'Y')
                                    ->where('tag', 'Y')
                                    ->whereRaw("nvl(start_date_active,sysdate+1) < sysdate")
                                    ->whereRaw("nvl(end_date_active,sysdate+1) > sysdate")->first();

                // Bank Acc
                $bankAccData    = DB::table('ptom_receipt_bank_acc_v')->where('om_report_flag', 'Y')->first();

                // Custome Name
                if ($proformaData->head_office_flag == 'Y') {
                    $proformaData->customer_name = $proformaData->customer_name . ' (HEAD OFFICE)';
                }else{
                    $proformaData->customer_name = $proformaData->customer_name . ' BRANCH NO. ' . (!empty($proformaData->branch) ? $proformaData->branch : '');
                }

            }

            $dataCompact = [
                'toatAddress',
                'proformaData',
                'orderLinesData',
                'totalCost',
                'totalFOB',
                'totalNet',
                'totalGross',
                'incotermData',
                'paymentData',
                'packingData',
                'totalApprovePack',
                'totalApproveCartonBox',
                'totalApproveCarton',
                'approveData',
                'bankAccData'
            ];

            $pdf = SnappyPdf::loadView('om.tax_invoice_export.print_invoice', compact($dataCompact));

            $pdf->setOption('page-width', '210mm')
                ->setOption('page-height', '297mm')
                ->setOption('margin-left','0')
                ->setOption('margin-right','0')
                ->setOption('margin-top','0')
                ->setOption('no-background', true)
                ->setOption('margin-bottom','0');

            return $pdf->stream('print.pdf');

        }else{
            return redirect()->action([ProformaInvoiceController::class, 'index']);
        }
    }

    public function printpackinglist(Request $request)
    {
        // echo '<pre>';
        // print_r($request->all());
        // echo '<pre>';
        // exit();

        $piHeaderID = !empty($request->pi_header_id) ? $request->pi_header_id : 0;

        if ($piHeaderID > 0) {

            $dataPiLotData  = [];
            $proformaData   = [];
            $totalCost      = 0.00;
            $totalFOB       = 0.00;
            $totalNet       = 0.00;
            $totalGross     = 0.00;
            $totalQuantity  = 0.00;
            $totalUom       = '';
            $packingData    = [];
            $totalApprovePack           = 0.00;
            $totalApproveCartonBox      = 0.00;
            $totalApproveCarton         = 0.00;

            $toatAddress        = DB::table('ptom_toat_address_v')->first();


            $proformaData    = ProformaInvoiceHeaders::join('ptom_customers', 'ptom_proforma_invoice_headers.customer_id', '=', 'ptom_customers.customer_id')
                                                ->join('ptom_order_headers', 'ptom_proforma_invoice_headers.order_header_id', '=', 'ptom_order_headers.order_header_id')
                                                ->select(
                                                    'ptom_proforma_invoice_headers.*',
                                                    'ptom_customers.country_name',
                                                    'ptom_customers.customer_name',
                                                    'ptom_customers.address_line1',
                                                    'ptom_customers.address_line2',
                                                    'ptom_customers.address_line3',
                                                    'ptom_customers.state',
                                                    'ptom_customers.postal_code',
                                                    'ptom_customers.city_code',
                                                    'ptom_customers.city',
                                                    'ptom_customers.district_code',
                                                    'ptom_customers.district',
                                                    'ptom_customers.province_name',
                                                    'ptom_customers.tax_register_number',
                                                    'ptom_customers.branch',
                                                    'ptom_order_headers.order_number',
                                                    'ptom_customers.head_office_flag'
                                                )
                                                ->where('ptom_proforma_invoice_headers.pi_header_id', $piHeaderID)
                                                ->whereNull('ptom_proforma_invoice_headers.deleted_at')->first();


            if (!empty($proformaData)) {
                $customerID     = $proformaData->customer_id;
                $shipToSiteID   = $proformaData->ship_to_site_id;

                // GET DATA CUSTOMER SHIP SITES
                $customerShipSiteData   = CustomerShipSites::where('ship_to_site_id', $shipToSiteID)->first();

                // SET DATA CUSTOMER SHIP SITE
                $proformaData->ship_to_site_name           = !empty($customerShipSiteData->ship_to_site_name) ? $customerShipSiteData->ship_to_site_name : '';
                $proformaData->ship_country_name           = !empty($customerShipSiteData->country_name) ? $customerShipSiteData->country_name : '';
                $proformaData->ship_address_line_1         = !empty($customerShipSiteData->address_line1) ? $customerShipSiteData->address_line1 : '';
                $proformaData->ship_address_line_2         = !empty($customerShipSiteData->address_line2) ? $customerShipSiteData->address_line2 : '';
                $proformaData->ship_address_line_3         = !empty($customerShipSiteData->address_line3) ? $customerShipSiteData->address_line3 : '';
                $proformaData->ship_state                  = !empty($customerShipSiteData->state) ? $customerShipSiteData->state : '';
                $proformaData->ship_postal_code            = !empty($customerShipSiteData->postal_code) ? $customerShipSiteData->postal_code : '';
                $proformaData->ship_city                   = !empty($customerShipSiteData->city) ? $customerShipSiteData->city : '';
                $proformaData->ship_district               = !empty($customerShipSiteData->district) ? $customerShipSiteData->district : '';
                $proformaData->ship_province_name          = !empty($customerShipSiteData->province_name) ? $customerShipSiteData->province_name : '';
                $proformaData->ship_tax_register_number    = !empty($customerShipSiteData->tax_register_number) ? $customerShipSiteData->tax_register_number : '';

                $proformaData->ship_district = DB::table('ptom_thailand_territory')->where('tambon_id', $proformaData->district_code)->pluck('tambon_eng_short')->first();
                $proformaData->ship_city = DB::table('ptom_thailand_territory')->where('district_id', $proformaData->city_code)->pluck('district_eng_short')->first();

                // GET DATA SHIPMENT BY
                $shipmentMeaning     = DB::table('ptom_shipment_by')->where('lookup_code', $proformaData->transport_type_code)->where('tag', 'E')->pluck('meaning')->first();
                $proformaData->shipment_meaning    = !empty($shipmentMeaning) ? $shipmentMeaning : $proformaData->transport_detail;

                // GET INCORTERM DESCRIPTION
                $incortermsDescription  = DB::table('ptom_incoterms')->select('meaning')->where('lookup_code', $proformaData->incoterms_code)->pluck('meaning')->first();
                $proformaData->incoterm_desription = !empty($incortermsDescription) ? $incortermsDescription : '';


                // FORMAT PICK RELEASE APPROVE DATE
                $proformaData->pick_release_approve_date     = !empty($proformaData->pick_release_approve_date) ? date("F j, Y", strtotime($proformaData->pick_release_approve_date))  : '';
                $proformaData->delivery_date_text            = !empty($proformaData->delivery_date) ? date("F j, Y", strtotime($proformaData->delivery_date))  : '';
                // $proformaData->pi_date_text                  = !empty($proformaData->pi_date) ? date("F j, Y", strtotime($proformaData->pi_date))  : '';

                if ($request->ref == 72) {
                    $proformaData->pi_date_text                  = !empty($proformaData->pi_date) ? date("F j, Y", strtotime($proformaData->pi_date))  : '';
                } else if($request->ref == 73) {
                    $proformaData->pi_date_text                  = !empty($proformaData->pick_release_approve_date) ? date("F j, Y", strtotime($proformaData->pick_release_approve_date))  : '';
                }


                // FORMAT PI DATE
                $proformaData->pi_date     = !empty($proformaData->pi_date) ? date("F j, Y", strtotime($proformaData->pi_date))  : '';

                // FORMAT SALE CONFIRM DATE
                $proformaData->sale_confirm_date     = !empty($proformaData->sale_confirm_date) ? date("F j, Y", strtotime($proformaData->sale_confirm_date))  : '';

                // FORMAT ORDER DATE
                $proformaData->order_date     = !empty($proformaData->order_date) ? date("F j, Y", strtotime($proformaData->order_date))  : '';

                // GET TERM DESCRIPTION
                $termDescription    = DB::table('ptom_terms_v')->where('term_id', $proformaData->term_id)->where('sale_type', 'EXPORT')->pluck('description')->first();
                $proformaData->term_description    = !empty($termDescription) ? $termDescription : '';

                // MONEY NUMBER TO TEXT
                $explodeGrandTotal = explode('.', number_format($proformaData->grand_total, 2, '.', ''));
                $grandTotalFirst = !empty($explodeGrandTotal[0]) ? ucwords(translateToWords((int)$explodeGrandTotal[0])) : '';
                $grandTotalStang = !empty($explodeGrandTotal[1]) && $explodeGrandTotal[1] > 0 ? ' and '.ucwords(translateToWords((int)$explodeGrandTotal[1])) : '';
                $proformaData->grand_total_text = $grandTotalFirst.$grandTotalStang;

                $proformaData->sub_total   = !empty($proformaData->sub_total) ? number_format((float)$proformaData->sub_total, 2, '.', ',') : '';
                $proformaData->tax         = !empty($proformaData->tax) ? number_format((float)$proformaData->tax, 2, '.', ',') : '';
                $proformaData->grand_total = !empty($proformaData->grand_total) ? number_format((float)$proformaData->grand_total, 2, '.', ',') : '';

                // GET DETAIL PTOM_ORDER_LINES
                $orderLinesDataDefault     = ProformaInvoiceLines::where('pi_header_id', $piHeaderID)->whereNull('deleted_at')->orderBy('line_number')->get();

                $dataPiLotDataDefault = null;

                if (!empty($orderLinesDataDefault)) {
                    $numLine = 1;
                    $numCheck = 1;

                    foreach ($orderLinesDataDefault as $key => $itemLines) {

                        $converApproveQuantity = GenerateNumberRepo::convertUnitItem($itemLines->item_id, $itemLines->approve_quantity, $itemLines->uom_code, 'CS1');

                        if ($proformaData->product_type_code == 10) {
                            $converQuantity = GenerateNumberRepo::convertUnitItem($itemLines->item_id, $itemLines->approve_quantity, $itemLines->uom_code, 'CGC');
                        }else{
                            $converQuantity = GenerateNumberRepo::convertUnitItem($itemLines->item_id, $itemLines->approve_quantity, $itemLines->uom_code, 'E18');
                        }

                        $orderLinesDataDefault[$key]->approve_quantity = !empty($itemLines->approve_quantity) ? number_format((float)$itemLines->approve_quantity, 0, '.', ',') : 0;
                        $orderLinesDataDefault[$key]->unit_price       = !empty($itemLines->unit_price) ? number_format((float)$itemLines->unit_price, 2, '.', ',') : number_format((float)0, 2, '.', ',');
                        $orderLinesDataDefault[$key]->amount           = !empty($itemLines->amount) ? number_format((float)$itemLines->amount, 2, '.', ',') : number_format((float)0, 2, '.', ',');
                        $orderLinesDataDefault[$key]->mms_per_box      = ProformaInvoiceLots::select('mms_per_box')->where('pi_line_id', $itemLines->pi_line_id)->whereNull('deleted_at')->pluck('mms_per_box')->first();
                        $orderLinesDataDefault[$key]->count_cardboad    = ProformaInvoiceLots::select('quantity_cbb')->where('pi_line_id', $itemLines->pi_line_id)->whereNull('deleted_at')->pluck('quantity_cbb')->first();

                        // GET DATA ITEM DESCRIPTION BY SEQUENCE ECOMS
                        $sequenceEcoms  = SequenceEcoms::where('item_id', $itemLines->item_id)->first();
                        $orderLinesDataDefault[$key]->report_item_display  = !empty($sequenceEcoms->report_item_display) ? $sequenceEcoms->report_item_display : '';

                        // GET UOM DATA
                        $uomReportEXP = Uom::where('uom_code', $itemLines->uom_code)->pluck('name_for_report_exp')->first();
                        $orderLinesDataDefault[$key]->name_for_report_exp = !empty($uomReportEXP) ? $uomReportEXP : '';

                        // GET LOTS DATA
                        $piLotsData = ProformaInvoiceLots::where('pi_line_id', $itemLines->pi_line_id)->whereNull('deleted_at')->orderBy('pi_lot_id')->get();
                        $lotTotalNetWeight = 0.00;
                        $lotTotalNetGross  = 0.00;

                        if (!empty($piLotsData)) {
                            foreach ($piLotsData as $keyLines => $itemLots) {
                                $lotTotalNetWeight = (float)$lotTotalNetWeight + (float)$itemLots->total_weight_unit_net;
                                $lotTotalNetGross  = (float)$lotTotalNetGross + (float)$itemLots->total_weight_unit_gross;
                                $totalQuantity = (float)$totalQuantity + (float)$itemLots->quantity_cbb;

                                $itemLots->total_weight_unit_net = number_format($itemLots->total_weight_unit_net, 2, '.', ',');
                                $itemLots->total_weight_unit_gross = number_format($itemLots->total_weight_unit_gross, 2, '.', ',');

                                $sequenceEcoms  = SequenceEcoms::where('item_id', $itemLines->item_id)->first();
                                $itemLots->report_item_display  = !empty($sequenceEcoms->report_item_display) ? $sequenceEcoms->report_item_display : '';

                                $dataPiLotDataDefault[] = $itemLots;
                            }
                        }

                        $orderLinesDataDefault[$key]->total_net_weight = number_format((float)$lotTotalNetWeight, 2, '.', ',');
                        $orderLinesDataDefault[$key]->total_net_gross  = number_format((float)$lotTotalNetGross, 2, '.', ',');

                        $totalApprovePack       = (float)$totalApprovePack + (float)$converApproveQuantity;
                        $totalApproveCartonBox  = (float)$totalApproveCartonBox + (float)$itemLines->approve_cartonbox;
                        $totalApproveCarton     = (float)$totalApproveCarton + (float)$itemLines->approve_carton;

                        // $totalQuantity  = (float)$totalQuantity + (float)$orderLinesDataDefault[$key]->count_cardboad;
                        $totalCost      = (float)$totalCost + (float)$itemLines->amount;
                        $totalNet       = (float)$totalNet + (float)$lotTotalNetWeight;
                        $totalGross     = (float)$totalGross + (float)$lotTotalNetGross;
                        $totalUom       = $itemLines->uom;
                    }



                    foreach ($orderLinesDataDefault as $keySet => $setLine) {
                        $orderLinesData[$numLine][$keySet] = $setLine;

                        if ($numCheck == 3) {
                            $numLine++;
                            $numCheck = 1;
                        }else{
                            $numCheck++;
                        }
                    }
                }

                if (!empty($dataPiLotDataDefault)) {
                    $numLine = 1;
                    $numCheck = 1;
                    foreach ($dataPiLotDataDefault as $keySet => $setLot) {
                        $dataPiLotData[$numLine][$keySet] = $setLot;

                        if ($numCheck == 8) {
                            $numLine++;
                            $numCheck = 1;
                        }else{
                            $numCheck++;
                        }
                    }
                }



                // GET PERCENTAGE RATE
                $proformaData->percentage_rate = TaxCode::where('tax_rate_code', $proformaData->vat_code)->pluck('percentage_rate')->first();

                $totalCost  = number_format((float)$totalCost, 2, '.', '');
                $totalFOB   = $totalCost * ($proformaData->percentage_rate / 100);

                $totalCost  = number_format((float)$totalCost, 2, '.', ',');
                $totalFOB   = number_format((float)$totalFOB, 2, '.', ',');

                // Net and Gross
                $totalNet       = number_format((float)$totalNet, 2, '.', ',');
                $totalGross     = number_format((float)$totalGross, 2, '.', ',');

                $totalQuantity  = number_format((float)$totalQuantity, 0, '.', ',');

                // Packing
                $totalApprovePack       = number_format((float)$totalApprovePack, 2, '.', ',');
                // $totalApproveCartonBox  = number_format((float)$totalApproveCartonBox, 2, '.', ',');
                // $totalApproveCarton     = number_format((float)$totalApproveCarton, 2, '.', ',');

                // GET APPROVE NAME
                $proformaData->approve_name     = DB::table('ptom_approval_name_ex_v')->select('meaning')->where('enabled_flag', 'Y')->where('tag', 'Y')->pluck('meaning')->first();
                $proformaData->approve_position = DB::table('ptom_approval_name_ex_v')->select('description')->where('enabled_flag', 'Y')->where('tag', 'Y')->pluck('description')->first();

                // GET PACKING
                $packingData    = DB::table('ptom_packing_details_v')
                                    ->where('enabled_flag', 'Y')
                                    ->whereRaw("nvl(start_date_active,sysdate+1) < sysdate")
                                    ->whereRaw("nvl(end_date_active,sysdate+1) > sysdate")
                                    ->orderBy('lookup_code', 'ASC')->get();

                // Approve
                $approveData    = DB::table('ptom_approval_name_ex_v')
                                    ->where('enabled_flag', 'Y')
                                    ->where('tag', 'Y')
                                    ->whereRaw("nvl(start_date_active,sysdate+1) < sysdate")
                                    ->whereRaw("nvl(end_date_active,sysdate+1) > sysdate")->first();

            }

            // dd($dataPiLotData);

            // echo '<pre>';
            // print_r($proformaData);
            // echo '</pre>';
            // exit();


            $dataCompact = [
                'toatAddress',
                'proformaData',
                'orderLinesData',
                'totalCost',
                'totalFOB',
                'totalNet',
                'totalGross',
                'totalQuantity',
                'totalUom',
                'packingData',
                'totalApprovePack',
                'approveData',
                'dataPiLotData'
            ];

            // return view('om.tax_invoice_export.print_packing_list', compact($dataCompact));

            $pdf = SnappyPdf::loadView('om.tax_invoice_export.print_packing_list', compact($dataCompact));

            $pdf->setOption('page-width', '210mm')
                // ->setOption('page-height', '297mm')
                ->setOption('margin-left','0')
                ->setOption('margin-right','0')
                ->setOption('margin-top','0')
                ->setOption('no-background', true)
                ->setOption('margin-bottom','0');

            return $pdf->stream('print.pdf');
            // return view('om.sale_confirmation.print', compact($dataCompact));

        }else{
            return redirect()->action([ProformaInvoiceController::class, 'index']);
        }
    }
}
