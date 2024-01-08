<?php

namespace App\Http\Controllers\OM;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\OM\Customers\Domestics\Customer;
use App\Models\OM\Customers\Domestics\CustomerShipSites;
use App\Models\OM\Customers\Domestics\PaymentType;
use App\Models\OM\Customers\Domestics\PriceList;
use App\Models\OM\Customers\Domestics\SequenceEcom;
use App\Models\OM\SaleConfirmation\ApproveOrder;
use App\Models\OM\SaleConfirmation\Currencies;
use App\Models\OM\SaleConfirmation\Incoterms;
use App\Models\OM\SaleConfirmation\ItemWeights;
use App\Models\OM\SaleConfirmation\OrderHeaders;
use App\Models\OM\SaleConfirmation\OrderLines;
use App\Models\OM\SaleConfirmation\PaymentMethodExport;
use App\Models\OM\SaleConfirmation\PriceListLine;
use App\Models\OM\SaleConfirmation\SalesChannel;
use App\Models\OM\SaleConfirmation\ShipmentBy;
use App\Models\OM\SaleConfirmation\TaxCode;
use App\Models\OM\SaleConfirmation\Terms;
use App\Models\OM\SaleConfirmation\TransactionTypes;
use App\Models\OM\SaleConfirmation\Uom;
use App\Models\OM\SaleConfirmation\UomConversions;
use App\Models\OM\SequenceEcoms;
use App\Repositories\OM\GenerateNumberRepo;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleConfirmationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $menu = Menu::where('program_code', 'OMP0066')->first();
        // dd($menu);
        view()->share('menu', $menu);
    }
    public function index()
    {
        $orderSelect = [
            'ptom_order_headers.order_header_id',
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
                                    ->where('ptom_order_headers.order_status', '!=', 'Invoice')
                                    ->where('ptom_order_headers.order_status', '!=', 'Wait Pay')
                                    ->where('ptom_order_headers.order_status', '!=', 'Release')
                                    ->where('ptom_order_headers.order_status', '!=', 'Inprocess')
                                    // ->where('ptom_order_headers.order_status', '!=', 'Cancel')
                                    // ->where('ptom_order_headers.order_status', '!=', 'Cancelled')
                                    // ->where('ptom_order_headers.order_status', 'Draft')
                                    // ->whereNotNull('ptom_order_headers.prepare_order_number')
                                    // ->whereNotNull('ptom_order_headers.order_number')
                                    ->whereNull('ptom_order_headers.deleted_at')
                                    ->orderBy('ptom_order_headers.prepare_order_number', 'desc')
                                    ->groupBy($orderSelect)
                                    ->get();

        foreach ($saList as $key => $value) {
            $saList[$key]->order_status = !empty($value->order_status) ? $value->order_status : 'Draft';
            $saList[$key]->sa_status    = !empty($value->sa_status) ? $value->sa_status : 'Draft';
            $saList[$key]->sa_date      = !empty($value->sa_date) ? dateFormatDMYDefault(date('m/d/Y',strtotime($value->sa_date))) : $value->sa_date;
            $saList[$key]->order_date   = !empty($value->order_date) ? dateFormatDMYDefault(date('m/d/Y',strtotime($value->order_date))) : $value->order_date;
        }

        $orderList = OrderHeaders::join('ptom_customers', 'ptom_order_headers.customer_id', '=', 'ptom_customers.customer_id')
                                    ->select($orderSelect)
                                    ->where('ptom_customers.sales_classification_code', 'Export')
                                    ->where('ptom_order_headers.order_status', '!=', 'Invoice')
                                    ->where('ptom_order_headers.order_status', '!=', 'Wait Pay')
                                    ->where('ptom_order_headers.order_status', '!=', 'Release')
                                    ->where('ptom_order_headers.order_status', '!=', 'Inprocess')
                                    // ->where('ptom_order_headers.order_status', '!=', 'Cancel')
                                    // ->where('ptom_order_headers.order_status', '!=', 'Cancelled')
                                    // ->where('ptom_order_headers.order_status', 'Draft')
                                    // ->whereNotNull('ptom_order_headers.prepare_order_number')
                                    // ->whereNotNull('ptom_order_headers.order_number')
                                    ->whereNull('ptom_order_headers.deleted_at')
                                    ->orderBy('ptom_order_headers.order_number', 'desc')
                                    ->groupBy($orderSelect)
                                    ->get();

        foreach ($orderList as $key => $value) {
            $orderList[$key]->order_status  = !empty($value->order_status) ? $value->order_status : 'Draft';
            $orderList[$key]->sa_status     = !empty($value->sa_status) ? $value->sa_status : 'Draft';
            $orderList[$key]->sa_date       = !empty($value->sa_date) ? dateFormatDMYDefault(date('m/d/Y',strtotime($value->sa_date))) : $value->sa_date;
            $orderList[$key]->order_date    = !empty($value->order_date) ? dateFormatDMYDefault(date('m/d/Y',strtotime($value->order_date))) : $value->order_date;
        }

        $customerOrderList = [];
        foreach ($saList as $key => $value) {
            $customerOrderList[$value->customer_number] = $value;
        }

        $customerList           = Customer::join('ptom_currencies_v', 'ptom_customers.currency', '=', 'ptom_currencies_v.currency_code')
                                            ->join('ptom_terms_v', 'ptom_customers.payment_term_id', '=', 'ptom_terms_v.term_id')
                                            ->select(
                                                'ptom_customers.*',
                                                'ptom_currencies_v.name as currency_name',
                                                'ptom_currencies_v.description as currency_description',
                                                'ptom_terms_v.name as term_name',
                                                'ptom_terms_v.description as term_description')
                                            ->where('ptom_customers.sales_classification_code', 'Export')
                                            ->where('ptom_customers.status', 'Active')
                                            ->whereNotNull('ptom_customers.customer_number')
                                            ->whereNull('ptom_customers.deleted_at')
                                            ->orderBy('ptom_customers.customer_number', 'ASC')
                                            ->get();

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
        $approverList           = ApproveOrder::select('approver_order_id', 'approver_name', 'default_flag')->where('attribute1', 'EXPORT')->whereRaw("nvl(start_date,sysdate+1) < sysdate")->whereRaw("nvl(end_date,sysdate+1) > sysdate")->get();
        $uomList                = Uom::where('export', 'Y')->get();
        $uomConversionsList     = UomConversions::get();
        $priceList              = PriceList::select('price_list_id', 'list_header_id', 'name', 'currency_code')
                                        ->whereRaw("nvl(end_date_active,sysdate+1) > sysdate")
                                        ->where('active_flag', 'Y')
                                        ->where('attribute1', 'EXPORT')
                                        ->orderBy('name')->get();

        $priceListLine          = PriceListLine:: whereRaw("nvl(start_date_active,sysdate+1) < sysdate")->where('automatic_flag', 'Y')->get();

        // CREATE
        $sequenceEcoms = SequenceEcom::join('ptom_price_list_line_v', 'ptom_sequence_ecoms.item_id', '=', 'ptom_price_list_line_v.item_id')
                                    ->select(
                                        'ptom_sequence_ecoms.*',
                                        'ptom_price_list_line_v.list_header_id',
                                        'ptom_price_list_line_v.operand',
                                        'ptom_price_list_line_v.product_uom_code',
                                        'ptom_price_list_line_v.list_header_id'
                                    )
                                    ->where('ptom_sequence_ecoms.sale_type_code', 'EXPORT')
                                    ->whereRaw("nvl(ptom_sequence_ecoms.start_date,sysdate+1) < sysdate")
                                    ->whereRaw("nvl(ptom_sequence_ecoms.end_date,sysdate+1) > sysdate")
                                    // ->whereRaw("nvl(ptom_price_list_line_v.start_date_active,sysdate+1) < sysdate")
                                    // ->whereRaw("nvl(ptom_price_list_line_v.end_date_active,sysdate+1) > sysdate")
                                    ->whereNull('ptom_sequence_ecoms.deleted_at')
                                    ->orderBy('ptom_sequence_ecoms.sequence_ecom_id','asc')
                                    ->get();


        $itemWeight = ItemWeights::where('active_flag', 'Y')
                                // ->whereRaw("nvl(start_date,sysdate+1) < sysdate")
                                // ->whereRaw("nvl(end_date,sysdate+1) > sysdate")
                                ->whereNull('deleted_at')->get();

        $attachmentFile = [];

        $inCortermName = DB::table('ptom_incoterms')->select('attribute1')->where('lookup_code', 30)->pluck('attribute1')->first();

        // GET PACKING
        $packingData    = DB::table('ptom_packing_details_v')
        ->where('enabled_flag', 'Y')
        ->whereRaw("nvl(start_date_active,sysdate+1) < sysdate")
        ->whereRaw("nvl(end_date_active,sysdate+1) > sysdate")
        ->orderBy('lookup_code', 'ASC')->get();

        $stringPackingData = '';
        if (!empty($packingData)) {
            foreach ($packingData as $key => $value) {
                if (($key+1) < count($packingData)) {
                    $stringPackingData .= $value->meaning. "\n";
                }else{
                    $stringPackingData .= $value->meaning;
                }
            }
        }

        // echo '<pre>';
        // print_r($sequenceEcoms);
        // echo '</pre>';
        // exit();

        $data_compact = array(
            'saList',
            'orderList',
            'orderTypes',
            'customerOrderList',
            'paymentType',
            'paymentMethodExport',
            'salesChannel',
            'incoterms',
            'shipmentBy',
            'taxCode',
            'terms',
            'currency',
            'customerList',
            'approverList',
            'sequenceEcoms',
            'uomList',
            'uomConversionsList',
            'priceList',
            'priceListLine',
            'itemWeight',
            'attachmentFile',
            'inCortermName',
            'packingData',
            'stringPackingData'
        );

        return view('om.sale_confirmation.index', compact($data_compact));
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

    public function print(Request $request)
    {
        // echo '<pre>';
        // print_r($request->all());
        // echo '<pre>';
        // exit();

        $orderHeaderID = !empty($request->order_header_id) ? $request->order_header_id : 0;

        if ($orderHeaderID > 0) {

            $orderData      = [];
            $orderLinesData = [];
            $incotermData   = [];
            $totalCost      = 0.00;
            $totalFOB       = 0.00;
            $totalNet       = 0.00;
            $totalGross     = 0.00;
            $totalApprovePack           = 0.00;
            $totalApproveCartonBox      = 0.00;
            $totalApproveCarton         = 0.00;

            $toatAddress    = DB::table('ptom_toat_address_v')->first();

            $orderData    = OrderHeaders::join('ptom_customers', 'ptom_order_headers.customer_id', '=', 'ptom_customers.customer_id')
                                                ->select(
                                                    'ptom_order_headers.*',
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
                                                    'ptom_customers.head_office_flag'
                                                )
                                                ->where('ptom_order_headers.order_header_id', $orderHeaderID)
                                                ->whereNull('ptom_order_headers.deleted_at')->first();


            if (!empty($orderData)) {

                // echo '<pre>';
                // print_r($orderData);
                // echo '<pre>';
                // exit();

                $customerID     = $orderData->customer_id;
                $shipToSiteID   = $orderData->ship_to_site_id;

                // GET DATA CUSTOMER SHIP SITES
                $customerShipSiteData   = CustomerShipSites::where('ship_to_site_id', $shipToSiteID)->first();

                // SET DATA CUSTOMER SHIP SITE
                $orderData->ship_to_site_name           = !empty($customerShipSiteData->ship_to_site_name) ? $customerShipSiteData->ship_to_site_name : '';
                $orderData->ship_country_code           = !empty($customerShipSiteData->country_code) ? $customerShipSiteData->country_code : '';
                $orderData->ship_country_name           = !empty($customerShipSiteData->country_name) ? $customerShipSiteData->country_name : '';
                $orderData->ship_address_line_1         = !empty($customerShipSiteData->address_line1) ? $customerShipSiteData->address_line1 : '';
                $orderData->ship_address_line_2         = !empty($customerShipSiteData->address_line2) ? $customerShipSiteData->address_line2 : '';
                $orderData->ship_address_line_3         = !empty($customerShipSiteData->address_line3) ? $customerShipSiteData->address_line3 : '';
                $orderData->ship_state                  = !empty($customerShipSiteData->state) ? $customerShipSiteData->state : '';
                $orderData->ship_postal_code            = !empty($customerShipSiteData->postal_code) ? $customerShipSiteData->postal_code : '';
                $orderData->ship_city                   = !empty($customerShipSiteData->city) ? $customerShipSiteData->city : '';
                $orderData->ship_district               = !empty($customerShipSiteData->district) ? $customerShipSiteData->district : '';
                $orderData->ship_province_name          = !empty($customerShipSiteData->province_name) ? $customerShipSiteData->province_name : '';
                $orderData->ship_tax_register_number    = !empty($customerShipSiteData->tax_register_number) ? $customerShipSiteData->tax_register_number : '';

                $orderData->ship_district = DB::table('ptom_thailand_territory')->where('tambon_id', $orderData->district_code)->pluck('tambon_eng_short')->first();
                $orderData->ship_city = DB::table('ptom_thailand_territory')->where('district_id', $orderData->city_code)->pluck('district_eng_short')->first();

                $orderData->district = DB::table('ptom_thailand_territory')->where('tambon_id', $orderData->district_code)->pluck('tambon_eng_short')->first();
                $orderData->city = DB::table('ptom_thailand_territory')->where('district_id', $orderData->city_code)->pluck('district_eng_short')->first();

                // GET DATA SHIPMENT BY
                $shipmentMeaning     = DB::table('ptom_shipment_by')->where('lookup_code', $orderData->transport_type_code)->where('tag', 'E')->pluck('meaning')->first();
                $orderData->shipment_meaning    = !empty($shipmentMeaning) ? $shipmentMeaning : $orderData->transport_detail;

                // GET INCORTERM DESCRIPTION
                $incortermsDescription  = DB::table('ptom_incoterms')->select('meaning')->where('lookup_code', $orderData->incoterms_code)->pluck('meaning')->first();
                $orderData->incoterm_desription = !empty($incortermsDescription) ? $incortermsDescription : '';

                // FORMAT SA DATE
                $orderData->sa_date     = !empty($orderData->sa_date) ? date("F j, Y", strtotime($orderData->sa_date))  : '';

                // FORMAT SALE CONFIRM DATE
                $orderData->sale_confirm_date     = !empty($orderData->sale_confirm_date) ? date("F j, Y", strtotime($orderData->sale_confirm_date))  : '';

                // FORMAT ORDER DATE
                $orderData->order_date     = !empty($orderData->order_date) ? date("F j, Y", strtotime($orderData->order_date))  : '';

                // GET TERM DESCRIPTION
                $termDescription    = DB::table('ptom_terms_v')->where('term_id', $orderData->term_id)->where('sale_type', 'EXPORT')->pluck('description')->first();
                $orderData->term_description    = !empty($termDescription) ? $termDescription : '';

                // MONEY NUMBER TO TEXT
                $explodeGrandTotal = explode('.', number_format($orderData->grand_total, 2, '.', ''));
                $grandTotalFirst = !empty($explodeGrandTotal[0]) ? ucwords(translateToWords((int)$explodeGrandTotal[0])) : '';
                $grandTotalStang = !empty($explodeGrandTotal[1]) && $explodeGrandTotal[1] > 0 ? ' and '.ucwords(translateToWords((int)$explodeGrandTotal[1])) : '';
                $orderData->grand_total_text = $grandTotalFirst.$grandTotalStang;

                $orderData->sub_total   = !empty($orderData->sub_total) ? number_format((float)$orderData->sub_total, 2, '.', ',') : '';
                $orderData->tax         = !empty($orderData->tax) ? number_format((float)$orderData->tax, 2, '.', ',') : '';
                $orderData->grand_total = !empty($orderData->grand_total) ? number_format((float)$orderData->grand_total, 2, '.', ',') : '';

                // GET DETAIL PTOM_ORDER_LINES
                $orderLinesDataDefault     = OrderLines::where('order_header_id', $orderHeaderID)->whereNull('deleted_at')->orderBy('line_number')->get();

                if (!empty($orderLinesDataDefault)) {
                    foreach ($orderLinesDataDefault as $key => $itemLines) {

                        $converApproveQuantity = GenerateNumberRepo::convertUnitItem($itemLines->item_id, $itemLines->approve_quantity, $itemLines->uom_code, 'CS1');

                        if (!empty($itemLines->approve_quantity)) {
                            if ($orderData->product_type_code == 10) {
                                $orderLinesDataDefault[$key]->approve_quantity = number_format((float)$itemLines->approve_quantity, 0, '.', ',');
                            } else {
                                $orderLinesDataDefault[$key]->approve_quantity = number_format((float)$itemLines->approve_quantity, 2, '.', ',');
                            }
                        }

                        $orderLinesDataDefault[$key]->unit_price       = !empty($itemLines->unit_price) ? number_format((float)$itemLines->unit_price, 2, '.', ',') : number_format((float)0, 2, '.', ',');
                        $orderLinesDataDefault[$key]->amount           = !empty($itemLines->amount) ? number_format((float)$itemLines->amount, 2, '.', ',') : number_format((float)0, 2, '.', ',');

                        // GET DATA ITEM DESCRIPTION BY SEQUENCE ECOMS
                        $sequenceEcoms  = SequenceEcoms::where('item_id', $itemLines->item_id)->first();
                        $orderLinesDataDefault[$key]->report_item_display  = !empty($sequenceEcoms->report_item_display) ? $sequenceEcoms->report_item_display : '';

                        // GET UOM DATA
                        $uomReportEXP = Uom::where('uom_code', $itemLines->uom_code)->pluck('name_for_report_exp')->first();
                        $orderLinesDataDefault[$key]->name_for_report_exp = !empty($uomReportEXP) ? $uomReportEXP : '';

                        $totalCost      = (float)$totalCost + (float)$itemLines->amount;
                        $totalNet       = (float)$totalNet + (float)$itemLines->total_net_weight;
                        $totalGross     = (float)$totalGross + (float)$itemLines->total_net_gross;


                        // exit();

                        $totalApprovePack       = (float)$totalApprovePack + (float)$converApproveQuantity;
                        $totalApproveCartonBox  = (float)$totalApproveCartonBox + (float)$itemLines->approve_cartonbox;
                        $totalApproveCarton     = (float)$totalApproveCarton + (float)$itemLines->approve_carton;
                    }

                    $numLine = 1;
                    $numCheck = 1;

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
                $orderData->percentage_rate = TaxCode::where('tax_rate_code', $orderData->vat_code)->pluck('percentage_rate')->first();

                $totalCost  = number_format((float)$totalCost, 2, '.', '');
                $totalFOB   = $totalCost * ($orderData->percentage_rate / 100);

                $totalCost  = number_format((float)$totalCost, 2, '.', ',');
                $totalFOB   = number_format((float)$totalFOB, 2, '.', ',');

                // Net and Gross
                $totalNet       = number_format((float)$totalNet, 2, '.', ',');
                $totalGross     = number_format((float)$totalGross, 2, '.', ',');

                // Packing
                $totalApprovePack       = number_format((float)$totalApprovePack, 2, '.', ',');
                // $totalApproveCartonBox  = number_format((float)$totalApproveCartonBox, 2, '.', ',');
                // $totalApproveCarton     = number_format((float)$totalApproveCarton, 2, '.', ',');


                // Footer



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
                if ($orderData->head_office_flag == 'Y') {
                    $orderData->bill_to_site_name = $orderData->bill_to_site_name . ' (HEAD OFFICE)';
                }else{
                    $orderData->bill_to_site_name = $orderData->bill_to_site_name . ' BRANCH NO. ' . (!empty($orderData->branch) ? $orderData->branch : '');
                }


            }

            // echo '<pre>';
            // print_r($toatAddress);
            // echo '</pre>';
            // echo '<pre>';
            // print_r($orderData);
            // echo '</pre>';
            // echo '<pre>';
            // print_r($orderLinesData);
            // echo '</pre>';
            // exit();


            $dataCompact = [
                'toatAddress',
                'orderData',
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

            // return view('om.sale_confirmation.print', compact($dataCompact));

            $pdf = SnappyPdf::loadView('om.sale_confirmation.print', compact($dataCompact))
                ->setOption('page-width', '210mm')
                ->setOption('page-height', '297mm')
                ->setOption('margin-left','0')
                ->setOption('margin-right','0')
                ->setOption('margin-top','0')
                ->setOption('no-background', true)
                ->setOption('margin-bottom','0');

            return $pdf->stream('print.pdf');

        }else{
            return redirect()->action([SaleConfirmationController::class, 'index']);
        }
    }
}
