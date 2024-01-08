<?php

namespace App\Http\Controllers\OM;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\OM\Customers;
use App\Models\OM\Customers\Domestics\CustomerContractGroups;
use App\Models\OM\Customers\Domestics\CustomerShipSites;
use App\Models\OM\Customers\Domestics\OrderCreditGroup;
use App\Models\OM\Customers\Domestics\PriceList;
use App\Models\OM\Customers\Domestics\PriceListLine;
use App\Models\OM\Customers\Domestics\PrintHistory;
use App\Models\OM\Customers\Domestics\ShipmentBy;
use App\Models\OM\Customers\Domestics\TransactionType;
use App\Models\OM\Customers\Domestics\TransportOwner;
use App\Models\OM\OverdueDebt\PaymentMatchInvoices;
use App\Models\OM\SaleConfirmation\ApproveOrder;
use App\Models\OM\SaleConfirmation\OrderHeaders;
use App\Models\OM\Order;
use App\Models\OM\SaleConfirmation\OrderLines;
use App\Models\OM\SaleConfirmation\Period;
use App\Models\OM\SaleConfirmation\UomConversions;
use App\Repositories\OM\GenerateNumberRepo;
use App\Repositories\OM\OrderRepo;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class ApprovePrepareOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $menu = Menu::where('program_code', 'OMP0030')->first();
        // dd($menu);
        view()->share('menu', $menu);
    }

    public function index()
    {
        $prepareOrderList = [];
        $pickNoList = [];
        $customerList = [];
        if(request()->is_ajax == true && request()->get == 'prepare_order_number') {

            return $prepareOrderList = OrderHeaders::select('ptom_order_headers.prepare_order_number', 'ptom_order_headers.order_header_id')
                                            ->join('ptom_customers', 'ptom_customers.customer_id', '=', 'ptom_order_headers.customer_id')
                                            ->where('ptom_customers.sales_classification_code', 'Domestic')
                                            ->where('ptom_order_headers.order_status','Confirm')
                                            ->when(request()->val, function($q) {
                                                $val = request()->val;
                                                $q->where('prepare_order_number', 'LIKE', "%{$val}%");
                                            })
                                            ->whereNotNull('ptom_order_headers.prepare_order_number')
                                            ->whereNull('ptom_order_headers.deleted_at')
                                            ->groupBy('ptom_order_headers.prepare_order_number', 'ptom_order_headers.order_header_id')
                                            ->orderBy('ptom_order_headers.order_header_id', 'desc')
                                            ->take(500)
                                            ->get();

        }
       if(request()->is_ajax == true && request()->get == 'pick_release_no') {

        return $pickNoList = OrderHeaders::select('ptom_order_headers.pick_release_no', 'ptom_order_headers.order_header_id')
                                            ->join('ptom_customers', 'ptom_customers.customer_id', '=', 'ptom_order_headers.customer_id')
                                            ->where('ptom_customers.sales_classification_code', 'Domestic')
                                            ->where('ptom_order_headers.order_status','Confirm')
                                            ->whereNotNull('ptom_order_headers.pick_release_no')
                                            ->whereNull('ptom_order_headers.deleted_at')
                                            ->when(request()->val, function($q) {
                                                $val = request()->val;
                                                $q->where('pick_release_no', 'LIKE', "%{$val}%");
                                            })
                                            ->groupBy('ptom_order_headers.pick_release_no', 'ptom_order_headers.order_header_id')
                                            ->orderBy('ptom_order_headers.order_header_id', 'desc')
                                            ->take(500)
                                            ->get();
       }

       if(request()->is_ajax == true && request()->get == 'customerList') {
            return $customerList = Customers::where('sales_classification_code', 'Domestic')
                                        ->where('status', '!=', 'Inactive')
                                        ->whereNull('deleted_at')
                                        ->when(request()->val, function($q) {
                                            $val = request()->val;
                                            $q->where('customer_number', 'LIKE', "%{$val}%");
                                            $q->orwhere('customer_name', 'LIKE', "%{$val}%");
                                        })
                                        ->whereNotNull('customer_number')
                                        ->orderBy('customer_number')
                                        ->take(500)
                                        ->get();
        }

        $approverList = ApproveOrder::select('approver_order_id', 'approver_name', 'default_flag')->where('attribute1', 'DOMESTIC')->whereRaw("nvl(start_date,sysdate+1) < sysdate")->whereRaw("nvl(end_date,sysdate+1) > sysdate")->get();

        $getSpecailApprove  = DB::table('ptom_special_invoice_approve_v')
                                ->where('meaning', optional(auth()->user())->username)
                                ->where('enabled_flag', 'Y')
                                ->whereRaw("nvl(start_date_active,sysdate+1) < sysdate")
                                ->whereRaw("nvl(end_date_active,sysdate+1) > sysdate")->get();

        if (!$getSpecailApprove->isEmpty()) {
            $special_users = 1;
        }else{
            $special_users = 0;
        }

        $defaultDate = dateFormatThai(date('Y-m-d'));

        $dataCompact = [
            'prepareOrderList',
            'pickNoList',
            'customerList',
            'approverList',
            'special_users',
            'defaultDate'
        ];
        if((boolean)request()->_faster == true) {
            return view('om.urgent_invoice.index', compact($dataCompact));
        }
        return view('om.approve_prepare/index', compact($dataCompact));
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

    public function print($id)
    {
        $order = OrderHeaders::where('PERIOD_ID','!=',1)
            ->leftJoin('PTOM_APPROVER_ORDERS', 'PTOM_ORDER_HEADERS.PICK_RELEASE_APPROVE_BY', '=', 'PTOM_APPROVER_ORDERS.APPROVER_ORDER_ID')
            ->leftJoin('PTOM_CUSTOMERS', 'PTOM_ORDER_HEADERS.CUSTOMER_ID', '=', 'PTOM_CUSTOMERS.CUSTOMER_ID')
            ->where('PTOM_CUSTOMERS.SALES_CLASSIFICATION_CODE', 'Domestic')
            ->where('ptom_order_headers.payment_approve_flag', 'Y')
            // ->where('ptom_order_headers.order_status','Confirm')
            ->where('ptom_order_headers.order_header_id', $id)
        ->select([
            'PTOM_ORDER_HEADERS.*',
            'PTOM_APPROVER_ORDERS.APPROVER_NAME as approver_name',
            'ptom_customers.customer_name',
            'ptom_customers.customer_number',
            'ptom_customers.taxpayer_id',
            'ptom_customers.tax_register_number',
            'ptom_customers.branch',
            'ptom_customers.head_office_flag',
            'ptom_customers.address_line1',
            'ptom_customers.address_line2',
            'ptom_customers.address_line3',
            'ptom_customers.district',
            'ptom_customers.city',
            'ptom_customers.alley',
            'ptom_customers.province_name',
            'ptom_customers.postal_code',
            'ptom_customers.contact_phone',
            'ptom_customers.customer_type_id'
        ])
        ->first();

        // echo '<pre>';
        // print_r($order);
        // echo '</pre>';
        // exit();

        $totalOrderLines    = [];
        $creditGroupList    = [];
        $paoPercentINVList  = [];

        if (!empty($order)) {

            $order->is_over_quota = false;
            $customer_quota = [];

            $quota_group = DB::table('ptom_quota_group as cg')->where('tag','Y')->get(['cg.lookup_code','cg.meaning']);

            // $priceUnit = DB::raw("(SELECT operand FROM ptom_price_list_line_v
            //     WHERE ptom_price_list_line_v.list_header_id = plh.list_header_id
            //     AND ptom_price_list_line_v.item_id = cql.item_id
            // ) as price_unit");
            foreach($quota_group as $qitem){
                $quota = DB::table('ptom_customer_quota_headers as cqh')
                ->select(
                    'cqh.quota_header_id',
                    'cqh.quota_number',
                    'cqh.start_date',
                    'cqh.end_date',
                    'cqh.status',

                    'plh.list_header_id',
                    'plh.name as price_header_name',
                    'pll.operand',

                    'qcg.quota_credit_id',
                    'qcg.credit_group_code',

                    'cql.quota_line_id',
                    'cql.item_id',
                    'cql.item_code',
                    'cql.item_description',
                    'cql.received_quota',
                    'cql.minimum_quota',
                    'cql.remaining_quota',
                    // $priceUnit
                )
                ->join('ptom_customer_quota_lines as cql', 'cql.quota_header_id', '=', 'cqh.quota_header_id')
                ->leftJoin('ptom_quota_and_credit_group as qcg', 'qcg.item_id', '=', 'cql.item_id')

                ->join('ptom_customers as c', 'c.customer_id', '=', 'cqh.customer_id')
                ->join('ptom_price_list_head_v as plh', 'plh.list_header_id', '=', 'c.price_list_id')
                ->join('ptom_price_list_line_v as pll', 'pll.list_header_id', '=', 'plh.list_header_id')
                ->where('cqh.start_date','<=',date('Y-m-d'))
                ->where('cqh.end_date','>=',date('Y-m-d'))
                ->where('cqh.customer_id', $order->customer_id)
                ->where('qcg.quota_group_code',$qitem->lookup_code)
                ->get();
                if(count($quota) > 0){
                    foreach ($quota as $_q) {$customer_quota[] = $_q;}
                    // $customer_quota[] = $quota;
                }

            }
            $line_item = DB::table('PTOM_ORDER_LINES')->where('ORDER_HEADER_ID', $order->order_header_id)->get();
            foreach ($line_item as $line) {
                $quantity = $line->total_amount/1000;
                $sum = 0;
                foreach($customer_quota as $_q) {
                    if($_q->item_code==$line->item_code) $sum+=$_q->remaining_quota;
                }
                if($quantity>$sum) {
                    $order->is_over_quota = true;
                }
            }

            if ($order->credit_amount != 0) {
                if ($order->credit_amount == $order->sumamount) {
                    $order->statusAmount = 2;
                } else {
                    if($order->sumamount == null && $order->cash_amount > 0){
                        $order->statusAmount = 1;
                    }else if ($order->payment_duedate == null || Carbon::now() < $order->payment_duedate) {
                        $order->statusAmount = 0;
                    } else {
                        $order->statusAmount = 1;
                    }
                }
            } else {
                if ($order->cash_amount <= $order->sumamount && $order->cash_amount != 0) {
                    $order->statusAmount = 2;
                } else {
                    $order->statusAmount = 1;
                }
            }

            if (empty($order->prepare_order_number)) {
                $order->prepare_order_number = '';
            }

            if (empty($order->pick_release_no)) {
                $order->pick_release_no = '';
            }

            if (empty($order->pick_release_status)) {
                $order->pick_release_status = '';
            }

            if (!empty($order->delivery_date)) {
                $order->delivery_date = dateFormatThai($order->delivery_date);
            }else{
                $order->delivery_date = '';
            }

            if (!empty($order->cash_amount)) {
                $order->cash_amount = number_format($order->cash_amount,2);
            }else{
                $order->cash_amount = '0.00';
            }

            if (!empty($order->credit_amount)) {
                $order->credit_amount = number_format($order->credit_amount,2);
            }else{
                $order->credit_amount = '0.00';
            }

            if (!empty($order->grand_total)) {
                $order->grand_total = number_format($order->grand_total,2);
            }else{
                $order->grand_total = '0.00';
            }

            $getPeriodQuery = Period::select('budget_year', 'period_no')->where('period_line_id', $order->period_id)->first();

            if (!empty($getPeriodQuery)) {
                $order->period_detail   = ($getPeriodQuery->budget_year+543).'/'.$getPeriodQuery->period_no;
            }else{
                $order->period_detail   = '';
            }

            if (!empty($order->pick_release_approve_date)) {
                $order->pick_release_approve_date = dateFormatThai($order->pick_release_approve_date);
            }else{
                $order->pick_release_approve_date = '';
            }

            if (!empty($order->order_date)) {
                $order->order_date = dateFormatThai($order->order_date);
            }else{
                $order->order_date = '';
            }

            // if (!empty($order->max_payment_header_id)) {
            //     $paymentDate = DB::table('ptom_payment_headers')->select('payment_date')->where('payment_header_id', $order->max_payment_header_id)->pluck('payment_date')->first();
            //     $order->payment_date = !empty($paymentDate) ? dateFormatThai($paymentDate) : '';
            // }
            $order->payment_date = !empty($order->payment_duedate) ? dateFormatThai($order->payment_duedate) : '';

            // SHIPMENT BY
            $getShipmentQuery   = ShipmentBy::select('meaning')->where('lookup_code', $order->transport_type_code)->first();

            if (!empty($getShipmentQuery)) {

                if ($getShipmentQuery == '20') {
                    $transportOwnerName = TransportOwner::where('stop_flag', 'N')
                                                        ->whereRaw("nvl(start_date,sysdate+1) < sysdate")
                                                        ->whereRaw("nvl(end_date,sysdate+1) > sysdate")
                                                        ->pluck('transport_owner_name')->first();

                    $order->transport_type_description  = !empty($transportOwnerName) ? $transportOwnerName : '';
                }else{
                    $order->transport_type_description  = $getShipmentQuery->meaning;
                }

            }else{
                $order->transport_type_description   = '';
            }

            // TIME SHIPMENT BY
            $getPrintHistoryDate    = PrintHistory::where('document_id', $order->pick_release_id)->pluck('print_date')->first();

            // echo '<pre>';
            // print_r($getPrintHistoryDate);
            // echo '</pre>';
            // exit();

            $splitTimeStamp = explode(" ",$getPrintHistoryDate);
            $printDate = !empty($splitTimeStamp[0]) ? $splitTimeStamp[0] : '';
            $printTime = !empty($splitTimeStamp[1]) ? $splitTimeStamp[1] : '';
            $order->shipment_time = !empty($printTime) ? str_replace(':', '.', $printTime) : '';

            // SHIPMENT BY
            $getShipSiteQuery   = CustomerShipSites::where('ship_to_site_id', $order->ship_to_site_id)->orderBy('site_no')->first();

            if (!empty($getShipSiteQuery)) {
                $order->ship_to_site_name   = $getShipSiteQuery->ship_to_site_name;
                $order->ship_show_line      = $getShipSiteQuery->province_code == 10 ? 'ไม่ อบจ.' : 'อบจ.';
                $order->ship_province_name  = $getShipSiteQuery->province_name;
            }else{
                $order->ship_show_line      = '';
                $order->ship_province_name  = '';
            }

            // GET ORDER LINES

            if ($order->attribute5 == 'Y') {
                $orderLine      = OrderLines::where('order_header_id', $order->order_header_id)->whereNull('deleted_at')->get();
            }else{
                $orderLine      = OrderLines::where('order_header_id', $order->order_header_id)->whereNull("promo_flag")->whereNull('deleted_at')->get();
            }

            $totalApprove   = 0;
            $totalAmount    = 0;
            $totalOperand   = 0;

            if (!empty($orderLine)) {
                foreach ($orderLine as $key => $value) {

                    $listHeaderID   = PriceList::where('name', 'ราคาขายปลีก')->pluck('list_header_id')->first();
                    $operand        = PriceListLine::where('list_header_id', $listHeaderID)->where('item_id', $value->item_id)->pluck('operand')->first();

                    $total_operand  = $value->approve_quantity * $operand;

                    if ($value->promo_flag == 'Y') {
                        $orderLine[$key]->item_description = $value->item_description.' (Pro.)';
                    }

                    if ($order->customer_type_id == '20') {

                        $conversionCGC  = UomConversions::where('uom_code', 'CGC')->pluck('conversion_rate')->first();
                        $resultConversionCGC    = (float)$value->unit_price * ($conversionCGC / 1000);

                        $cardboardboxAmount     = (float)$value->approve_cardboardbox * (float)$resultConversionCGC;

                        // TOTAL
                        $totalApprove   = $totalApprove + $value->approve_quantity;
                        $totalAmount    = $totalAmount + $cardboardboxAmount;
                        $totalOperand   = $totalOperand + $total_operand;

                        $orderLine[$key]->line_number   = $key+1;
                        $orderLine[$key]->unit_price    = number_format($resultConversionCGC, 2, '.', ',');
                        $orderLine[$key]->amount        = number_format($cardboardboxAmount, 2, '.', ',');
                        $orderLine[$key]->total_amount  = number_format($value->total_amount, 2, '.', ',');
                        $orderLine[$key]->operand       = number_format($operand, 2, '.', ',');
                        $orderLine[$key]->total_operand = number_format($total_operand, 2, '.', ',');

                    }else{

                        // TOTAL
                        $totalApprove   = $totalApprove + $value->approve_quantity;
                        $totalAmount    = $totalAmount + $value->amount;
                        $totalOperand   = $totalOperand + $total_operand;

                        $orderLine[$key]->line_number   = $key+1;
                        $orderLine[$key]->unit_price    = number_format($value->unit_price, 2, '.', ',');
                        $orderLine[$key]->amount        = number_format($value->amount, 2, '.', ',');
                        $orderLine[$key]->total_amount  = number_format($value->total_amount, 2, '.', ',');
                        $orderLine[$key]->operand       = number_format($operand, 2, '.', ',');
                        $orderLine[$key]->total_operand = number_format($total_operand, 2, '.', ',');

                    }
                }

                $totalCalAmount     = $totalAmount - $order->tax;
                $totalCalOperand    = $totalOperand - $order->tax;

                $totalOrderLines = [
                    'total_approve_quantity'    => $totalApprove,
                    'total_cal_amount'          => number_format($totalCalAmount, 2, '.', ','),
                    'total_cal_operand'         => number_format($totalCalOperand, 2, '.', ','),
                    'total_amount'              => number_format($totalAmount, 2, '.', ','),
                    'total_operand'             => number_format($totalOperand, 2, '.', ','),
                ];
            }

            // TAX
            $order->tax_rate    = TransactionType::where('order_type_id', $order->order_type_id)->pluck('tax_rate')->first();
            $order->tax         = !empty($order->tax) ? number_format($order->tax, 2, '.', ',') : '0.00';

            $creditGroupQuery   = OrderCreditGroup::where('order_header_id', $order->order_header_id)->where('order_line_id', '!=', 0)->where('credit_group_code', '>', 0)->whereNull('deleted_at')->orderBy('credit_group_code', 'asc')->get();

            $checkCreditGroupCode   = 0;
            $sumAmount              = 0;

            if (!empty($creditGroupQuery)) {
                foreach ($creditGroupQuery as $key => $value) {
                    if ($checkCreditGroupCode != $value->credit_group_code) {
                        // SUM AMOUNT
                        $checkCreditGroupCode = $value->credit_group_code;
                        $creditGroupList[$value->credit_group_code]['sum_amount'] = number_format($value->amount, 2, '.', ',');
                        $sumAmount = $value->amount;

                        $getDayOfCredit = CustomerContractGroups::where('customer_id', $order->customer_id)->where('credit_group_code', $value->credit_group_code)->whereNull('deleted_at')->pluck('day_amount')->first();

                        if (!empty($order->delivery_date)) {
                            $arrCreditDate = explode('/', $order->delivery_date);
                            $cDay   = $arrCreditDate[0];
                            $cMonth = $arrCreditDate[1];
                            $cYear  = $arrCreditDate[2];
                            $creditDateChange = $cYear.'/'.$cMonth.'/'.$cDay;

                            $addDays = ' + '.$getDayOfCredit.' days';
                            $testDate = date('d/m/Y', strtotime($creditDateChange. $addDays));

                            $creditGroupList[$value->credit_group_code]['credit_group_date'] = $testDate;
                        }
                        else if (!empty($order->pick_release_approve_date)) {
                            $arrCreditDate = explode('/', $order->pick_release_approve_date);
                            $cDay   = $arrCreditDate[0];
                            $cMonth = $arrCreditDate[1];
                            $cYear  = $arrCreditDate[2];
                            $creditDateChange = $cYear.'/'.$cMonth.'/'.$cDay;

                            $addDays = ' + '.$getDayOfCredit.' days';
                            $testDate = date('d/m/Y', strtotime($creditDateChange. $addDays));

                            $creditGroupList[$value->credit_group_code]['credit_group_date'] = $testDate;
                        }else{
                            $creditGroupList[$value->credit_group_code]['credit_group_date'] = '';
                        }

                        $creditGroupList[$value->credit_group_code]['credit_group_code'] = $value->credit_group_code;

                    }else{
                        // SUM AMOUNT
                        $sumAmount = $sumAmount + $value->amount;
                        $creditGroupList[$value->credit_group_code]['sum_amount'] = number_format($sumAmount, 2, '.', ',');
                    }
                }
            }

            $paoPercentINVList = DB::table('ptom_pao_percent_inv')->where('order_header_id', $order->order_header_id)->whereNull('deleted_at')->get();

        }else{
            $orderLine  = [];
        }

        // echo '<pre>';
        // print_r($order);
        // echo '</pre>';

        // echo '<pre>';
        // print_r($orderLine);
        // echo '</pre>';

        // echo '<pre>';
        // print_r($creditGroupQuery);
        // echo '</pre>';
        // exit();

        $dataCompact = [
            'order',
            'orderLine',
            'totalOrderLines',
            'creditGroupList',
            'paoPercentINVList'
        ];

        // echo '<pre>';
        // print_r($order);
        // echo '</pre>';
        // exit();

        // return view('om.approve_prepare/print', compact($dataCompact)); // เงื่อนไข 1 ลูกค้าประเภทอื่นๆ
        $pdf = SnappyPdf::loadView('om.approve_prepare/print', compact($dataCompact));

        $pdf->setOption('page-width', '8.5in')
            ->setOption('page-height', '12in')
            ->setOption('margin-left','0')
            ->setOption('margin-right','0')
            ->setOption('margin-top','0')
            ->setOption('margin-bottom','0');

        return $pdf->stream('print.pdf');


    }

    public function calpao($id)
    {
        // order Header ID

        // EXAMPLE CONVERT TO ROUND
        // $value = 565.60;
        // $value = GenerateNumberRepo::convertTaxToRound($value);
        // dd($value);

        // EXAMPLE PAOPERCENT
        // OrderRepo::insertPaoPercentINV($id);

        // --------------- UPDATE PAO PERCENT -> TAX PER QTY
        $data = DB::table('ptom_pao_percent_inv')->orderBy('pao_percent_inv_id', 'ASC')->get();
        $keyProcess = 1;
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                // $newTaxPerQty = GenerateNumberRepo::convertTaxToRound($value->tax_per_qty);

                // echo '<pre>';
                // echo $value->tax_per_qty;
                // echo '</pre>';
                // dd($newTaxPerQty);

                // $dataUpdate = [
                //     'tax_per_qty'               => $newTaxPerQty,
                //     'last_updated_by'           => optional(auth()->user())->user_id,
                //     'last_update_date'          => date('Y-m-d H:i:s')
                // ];

                // DB::table('ptom_pao_percent_inv')->where('pao_percent_inv_id', $value->pao_percent_inv_id)->update($dataUpdate);

                if ($keyProcess == 1) {
                    $dataOrderPao = DB::table('ptom_order_pao_cal_v')->where('order_header_id', $value->order_header_id)->pluck('approve_quantity_head_office')->first();
                    $keyProcess = 2;
                } else {
                    $dataOrderPao = DB::table('ptom_order_pao_cal_v')->where('order_header_id', $value->order_header_id)->pluck('approve_quantity_branch')->first();
                    $keyProcess = 1;
                }

                $dataUpdate = [
                    'tax_per_qty'               => $dataOrderPao,
                    'last_updated_by'           => optional(auth()->user())->user_id,
                    'last_update_date'          => date('Y-m-d H:i:s')
                ];

                // dd($dataUpdate);
                DB::table('ptom_pao_percent_inv')->where('pao_percent_inv_id', $value->pao_percent_inv_id)->update($dataUpdate);


            }
        }
    }
}
