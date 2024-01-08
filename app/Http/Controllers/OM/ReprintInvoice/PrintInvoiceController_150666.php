<?php

namespace App\Http\Controllers\OM\ReprintInvoice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

use App\Models\OM\ReprintInvoice\OrderHeaderModel;
use App\Models\OM\ReprintInvoice\InvoiceHeaderModel;
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
use App\Repositories\OM\OrderRepo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

use App\Models\OM\Customers;
use App\Models\OM\CustomerTypeDomestic;

class PrintInvoiceController extends Controller
{
    public function index()
    {
        try {
            $order_prepare      = [];
            $order_release      = [];

            $date       = date('Y-m-d');
            $d_xp       = explode('-',$date);
            $year       = $d_xp[0] +543;
            $dateThai   = $d_xp[2].'/'.$d_xp[1].'/'.$year;
            return view('om.reprintinvoice.printinvoice',compact('order_prepare','order_release','dateThai'));
        } catch (\Throwable $th) {
            Log::error($th);
        }
       
    }

    public function print_invoice(Request $request)
    {
        $id_ex = explode(',',$request->invoice);

        foreach($id_ex as $ex_item)
        {
            if(!empty($ex_item)){
                $id[] = $ex_item;
            }
        }

        $match = PaymentMatchInvoices::selectRaw('PREPARE_ORDER_NUMBER as invoice_prepare ,max(DUE_DATE) as maxdate,sum(PAYMENT_AMOUNT) as sumamount, max(PAYMENT_HEADER_ID) as max_payment_header_id')
                                        ->groupBy('PREPARE_ORDER_NUMBER');
        $order = OrderHeaders::where('PERIOD_ID','!=',1)
                                ->leftJoin('PTOM_APPROVER_ORDERS', 'PTOM_ORDER_HEADERS.PICK_RELEASE_APPROVE_BY', '=', 'PTOM_APPROVER_ORDERS.APPROVER_ORDER_ID')
                                ->leftJoin('PTOM_CUSTOMERS', 'PTOM_ORDER_HEADERS.CUSTOMER_ID', '=', 'PTOM_CUSTOMERS.CUSTOMER_ID')
                                ->leftJoin('PTOM_CUSTOMER_SHIP_SITES', 'PTOM_CUSTOMER_SHIP_SITES.ship_to_site_id', '=', 'ptom_order_headers.ship_to_site_id')
                                ->leftJoinSub($match, 'match', 'match.invoice_prepare', 'PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER')
                                ->where('PTOM_CUSTOMERS.SALES_CLASSIFICATION_CODE', 'Domestic')
                                ->where('ptom_order_headers.payment_approve_flag', 'Y')
                                // ->where('ptom_order_headers.order_status','Confirm')
                                ->whereIn('ptom_order_headers.order_header_id', $id)
                                ->select([
                                    'PTOM_ORDER_HEADERS.*',
                                    'PTOM_APPROVER_ORDERS.APPROVER_NAME as approver_name',
                                    'match.*',
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
                                    'ptom_customers.customer_type_id',
                                    'ptom_customers.market'
                                    ,'ptom_customer_ship_sites.address_line1 as s_address_line1'
                                    ,'ptom_customer_ship_sites.address_line2 as s_address_line2'
                                    ,'ptom_customer_ship_sites.address_line3 as s_address_line3'
                                    ,'ptom_customer_ship_sites.alley as s_alley'
                                    ,'ptom_customer_ship_sites.district as s_district'
                                    ,'ptom_customer_ship_sites.city as s_city'
                                    ,'ptom_customer_ship_sites.province_name as s_province_name'
                                    ,'ptom_customer_ship_sites.postal_code as s_postal_code'
                                ])
                                ->orderBy('PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER', 'asc')
                                ->get();
        // echo '<pre>';
        // print_r($order);
        // echo '</pre>';
        // exit();

        $dataAll  = [];
        if ($order->count() > 0) {

            foreach($order as $order_item){
                // UPDATE PRINT INVOICE 20230130 Piyawut A.
                OrderHeaders::where('order_header_id', $order_item->order_header_id)->update(['print_invoice_flag' => 'Y', 'print_by_id' => auth()->user()->user_id]);

                $datad[] = $order_item->pick_release_no;

                $totalOrderLines    = [];
                $order_item->is_over_quota = false;
                $customer_quota = [];

                $quota_group = DB::table('ptom_quota_group as cg')->where('tag','Y')->get(['cg.lookup_code','cg.meaning']);

                $priceUnit = DB::raw("(SELECT operand FROM ptom_price_list_line_v
                    WHERE ptom_price_list_line_v.list_header_id = plh.list_header_id
                    AND ptom_price_list_line_v.item_id = cql.item_id
                ) as price_unit");
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
                        // 'pll.operand',

                        'qcg.quota_credit_id',
                        'qcg.credit_group_code',

                        'cql.quota_line_id',
                        'cql.item_id',
                        'cql.item_code',
                        'cql.item_description',
                        'cql.received_quota',
                        'cql.minimum_quota',
                        'cql.remaining_quota',
                        $priceUnit
                    )
                    ->join('ptom_customer_quota_lines as cql', 'cql.quota_header_id', '=', 'cqh.quota_header_id')
                    ->leftJoin('ptom_quota_and_credit_group as qcg', 'qcg.item_id', '=', 'cql.item_id')

                    ->join('ptom_customers as c', 'c.customer_id', '=', 'cqh.customer_id')
                    ->join('ptom_price_list_head_v as plh', 'plh.list_header_id', '=', 'c.price_list_id')
                    // ->join('ptom_price_list_line_v as pll', 'pll.list_header_id', '=', 'plh.list_header_id')
                    ->where('cqh.start_date','<=',date('Y-m-d'))
                    ->where('cqh.end_date','>=',date('Y-m-d'))
                    ->where('cqh.customer_id', $order_item->customer_id)
                    ->where('qcg.quota_group_code',$qitem->lookup_code)
                    ->get();
                    if(count($quota) > 0){
                        foreach ($quota as $_q) {$customer_quota[] = $_q;}
                        // $customer_quota[] = $quota;
                    }

                }
                $line_item = DB::table('PTOM_ORDER_LINES')->where('ORDER_HEADER_ID', $order_item->order_header_id)->get();
                foreach ($line_item as $line) {
                    $quantity = $line->total_amount/1000;
                    $sum = 0;
                    foreach($customer_quota as $_q) {
                        if($_q->item_code==$line->item_code) $sum+=$_q->remaining_quota;
                    }
                    if($quantity>$sum) {
                        $order_item->is_over_quota = true;
                    }
                }

                if ($order_item->credit_amount != 0) {
                    if ($order_item->credit_amount == $order_item->sumamount) {
                        $order_item->statusAmount = 2;
                    } else {
                        if($order_item->sumamount == null && $order_item->cash_amount > 0){
                            $order_item->statusAmount = 1;
                        }else if ($order_item->payment_duedate == null || Carbon::now() < $order_item->payment_duedate) {
                            $order_item->statusAmount = 0;
                        } else {
                            $order_item->statusAmount = 1;
                        }
                    }
                } else {
                    if ($order_item->cash_amount <= $order_item->sumamount && $order_item->cash_amount != 0) {
                        $order_item->statusAmount = 2;
                    } else {
                        $order_item->statusAmount = 1;
                    }
                }

                if (empty($order_item->prepare_order_number)) {
                    $order_item->prepare_order_number = '';
                }

                if (empty($order_item->pick_release_no)) {
                    $order_item->pick_release_no = '';
                }

                if (empty($order_item->pick_release_status)) {
                    $order_item->pick_release_status = '';
                }

                if (!empty($order_item->delivery_date)) {
                    $order_item->delivery_date = dateFormatThai($order_item->delivery_date);
                }else{
                    $order_item->delivery_date = '';
                }

                if (!empty($order_item->cash_amount)) {
                    $order_item->cash_amount = number_format($order_item->cash_amount,2);
                }else{
                    $order_item->cash_amount = '0.00';
                }

                if (!empty($order_item->credit_amount)) {
                    $order_item->credit_amount = number_format($order_item->credit_amount,2);
                }else{
                    $order_item->credit_amount = '0.00';
                }

                if (!empty($order_item->grand_total)) {
                    $order_item->grand_total = number_format($order_item->grand_total,2, '.', ',');
                }else{
                    $order_item->grand_total = '0.00';
                }

                $getPeriodQuery = Period::select('budget_year', 'period_no')->where('period_line_id', $order_item->period_id)->first();

                if (!empty($getPeriodQuery)) {
                    $order_item->period_detail   = ($getPeriodQuery->budget_year+543).'/'.$getPeriodQuery->period_no;
                }else{
                    $order_item->period_detail   = '';
                }

                if (!empty($order_item->pick_release_approve_date)) {
                    $order_item->pick_release_approve_date = dateFormatThai($order_item->pick_release_approve_date);
                }else{
                    $order_item->pick_release_approve_date = '';
                }

                if (!empty($order_item->order_date)) {
                    $order_item->order_date = dateFormatThai($order_item->order_date);
                }else{
                    $order_item->order_date = '';
                }

                if (!empty($order_item->requestor_code)) {
                    $order_item->requestor_description = DB::table('ptom_requestor')->select('description')->where('lookup_code', $order_item->requestor_code)->pluck('description')->first();
                }

                // if (!empty($order_item->max_payment_header_id)) {
                //     $paymentDate = DB::table('ptom_payment_headers')->select('payment_date')->where('payment_header_id', $order_item->max_payment_header_id)->pluck('payment_date')->first();
                //     $order_item->payment_date = !empty($paymentDate) ? dateFormatThai($paymentDate) : '';
                // }

                // if ($order_item->customer_type_id == 80 && $order_item->order_type_id != 1109) {
                //     $order_item->payment_date = $order_item->pick_release_approve_date;
                // }else{
                //     $paymentDate = DB::table('ptom_debt_dom_v')->select('due_date')->where('credit_group_code', 0)->where('pick_release_no', $order_item->pick_release_no)->pluck('due_date')->first();
                //     $order_item->payment_date = !empty($paymentDate) ? dateFormatThai($paymentDate) : '';
                // }

                $order_item->payment_date = !empty($order_item->payment_duedate) ? dateFormatThai($order_item->payment_duedate) : '';

                // if (!empty($order_item->delivery_date)) {

                //     $deliveryDate = $order_item->delivery_date;
                // }else{
                //     $order_item->payment_date = '';
                // }


                // SHIPMENT BY
                $getShipmentQuery   = ShipmentBy::select('meaning')->where('lookup_code', $order_item->transport_type_code)->first();

                if (!empty($getShipmentQuery)) {

                    if ($getShipmentQuery == '20') {
                        $transportOwnerName = TransportOwner::where('stop_flag', 'N')
                                                            ->whereRaw("nvl(start_date,sysdate+1) < sysdate")
                                                            ->whereRaw("nvl(end_date,sysdate+1) > sysdate")
                                                            ->pluck('transport_owner_name')->first();

                        $order_item->transport_type_description  = !empty($transportOwnerName) ? $transportOwnerName : '';
                    }else{
                        $order_item->transport_type_description  = $getShipmentQuery->meaning;
                    }

                }else{
                    $order_item->transport_type_description   = '';
                }

                // TIME SHIPMENT BY
                $getPrintHistoryDate    = PrintHistory::where('document_id', $order_item->pick_release_id)->pluck('print_date')->first();

                $splitTimeStamp = explode(" ",$getPrintHistoryDate);
                $printDate = !empty($splitTimeStamp[0]) ? $splitTimeStamp[0] : '';
                $order_item->shipment_time = !empty($splitTimeStamp[1]) ? $splitTimeStamp[1] : '';
                // $order_item->shipment_time = !empty($printTime) ? str_replace(':', '.', $printTime) : '';

                // SHIPMENT BY
                $getShipSiteQuery   = CustomerShipSites::where('ship_to_site_id', $order_item->ship_to_site_id)->orderBy('site_no')->first();

                if (!empty($getShipSiteQuery)) {

                    $customer = Customers::where('customer_id', $order_item->customer_id)->first();
                    

                    $order_item->ship_to_site_name   = $getShipSiteQuery->ship_to_site_name;
                    $order_item->ship_show_line      = $customer->customer_type_id == 20 || $getShipSiteQuery->province_code == 10 ? 'ไม่ อบจ.' : 'อบจ.';
                    $order_item->ship_province_name  = $getShipSiteQuery->province_name;
                }else{
                    $order_item->ship_show_line      = '';
                    $order_item->ship_province_name  = '';
                }

                // GET ORDER LINES

                if ($order_item->attribute5 == 'Y') {
                    $orderLine      = OrderLines::where('order_header_id', $order_item->order_header_id)->whereNull('deleted_at')->orderBy('line_number', 'asc')->get();
                }else{
                    $orderLine      = OrderLines::where('order_header_id', $order_item->order_header_id)->whereNull("promo_flag")->whereNull('deleted_at')->orderBy('line_number', 'asc')->get();
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

                        // if ($order_item->product_type_code == '20') {

                        //     $conversionCGC  = UomConversions::where('uom_code', 'CGC')->pluck('conversion_rate')->first();
                        //     $resultConversionCGC    = (float)$value->unit_price * ($conversionCGC / 1000);

                        //     $cardboardboxAmount     = (float)$value->approve_cardboardbox * (float)$resultConversionCGC;

                        //     $conversionCS1 = convertToCS1RemoveCell($value->uom_code, $value->approve_quantity);
                        //     $orderLine[$key]->approve_quantity = $conversionCS1;

                        //     $total_operand  = $conversionCS1 * $operand;



                        //     // TOTAL
                        //     $totalApprove   = $totalApprove + $conversionCS1;
                        //     $totalAmount    = $totalAmount + $cardboardboxAmount;
                        //     $totalOperand   = $totalOperand + $total_operand;

                        //     $orderLine[$key]->line_number   = $key+1;


                        //     $orderLine[$key]->unit_price    = number_format($resultConversionCGC, 2, '.', ',');
                        //     $orderLine[$key]->amount        = number_format($cardboardboxAmount, 2, '.', ',');
                        //     $orderLine[$key]->total_amount  = number_format($value->total_amount, 2, '.', ',');
                        //     $orderLine[$key]->operand       = number_format($operand, 2, '.', ',');
                        //     $orderLine[$key]->total_operand = number_format($total_operand, 2, '.', ',');

                        // }else{

                            $conversionCGC  = UomConversions::where('uom_code', 'CGC')->pluck('conversion_rate')->first();
                            $resultConversionCGC    = (float)$value->unit_price * ($conversionCGC / 1000);

                            // $conversionCS1 = convertToCS1RemoveCell($value->uom_code, $value->approve_quantity);
                            // $orderLine[$key]->approve_quantity = $conversionCS1;

                            // TOTAL
                            $totalApprove   = $totalApprove + $value->approve_quantity;
                            $totalAmount    = $totalAmount + $value->amount;
                            $totalOperand   = $totalOperand + $total_operand;

                            $orderLine[$key]->line_number   = $key+1;

                            $orderLine[$key]->unit_price    = number_format($value->unit_price, 2, '.', ',');
                            $orderLine[$key]->attribute2    = number_format($value->attribute2, 2, '.', ',');
                            $orderLine[$key]->amount        = number_format($value->amount, 2, '.', ',');
                            $orderLine[$key]->total_amount  = number_format($value->total_amount, 2, '.', ',');
                            $orderLine[$key]->operand       = number_format($operand, 2, '.', ',');
                            $orderLine[$key]->total_operand = number_format($total_operand, 2, '.', ',');

                        // }
                    }

                    $totalCalAmount     = $totalAmount - $order_item->tax;
                    $totalCalOperand    = $totalOperand - $order_item->tax;

                    $totalOrderLines = [
                        'total_approve_quantity'    => $totalApprove,
                        'total_cal_amount'          => number_format($totalCalAmount, 2, '.', ','),
                        'total_cal_operand'         => number_format($totalCalOperand, 2, '.', ','),
                        'total_amount'              => number_format($totalAmount, 2, '.', ','),
                        'total_operand'             => number_format($totalOperand, 2, '.', ','),
                    ];
                }

                // TAX
                $order_item->tax_rate    = TransactionType::where('order_type_id', $order_item->order_type_id)->pluck('tax_rate')->first();
                $order_item->tax         = !empty($order_item->tax) ? number_format($order_item->tax, 2, '.', ',') : '0.00';

                $creditGroupQuery   = OrderCreditGroup::where('order_header_id', $order_item->order_header_id)->where('order_line_id', 0)->where('credit_group_code', '>', 0)->whereNull('deleted_at')->orderBy('credit_group_code', 'asc')->get();

                $creditGroupList        = [];
                $checkCreditGroupCode   = 0;
                $sumAmount              = 0;

                if (!empty($creditGroupQuery)) {
                    foreach ($creditGroupQuery as $key => $value) {
                        if ($checkCreditGroupCode != $value->credit_group_code) {
                            // SUM AMOUNT
                            $checkCreditGroupCode = $value->credit_group_code;
                            $creditGroupList[$value->credit_group_code]['sum_amount'] = number_format($value->amount, 2, '.', ',');
                            $sumAmount = $value->amount;

                            $getDayOfCredit = CustomerContractGroups::where('customer_id', $order_item->customer_id)->where('credit_group_code', $value->credit_group_code)->whereNull('deleted_at')->pluck('day_amount')->first();

                            if (!empty($order_item->pick_release_approve_date)) {
                                $arrCreditDate = explode('/', $order_item->pick_release_approve_date);
                                $cDay   = $arrCreditDate[0];
                                $cMonth = $arrCreditDate[1];
                                $cYear  = $arrCreditDate[2];
                                $creditDateChange = $cYear.'/'.$cMonth.'/'.$cDay;

                                $addDays = ' + '.$getDayOfCredit.' days';
                                $testDate = date('d/m/Y', strtotime($creditDateChange. $addDays));

                                $creditGroupList[$value->credit_group_code]['credit_group_date'] = $testDate;
                            }else if (!empty($order_item->delivery_date)) {
                                $arrCreditDate = explode('/', $order_item->delivery_date);
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

                // $paoPercentINVList = DB::table('ptom_pao_percent_inv')->where('order_header_id', $order_item->order_header_id)->whereNull('deleted_at')->get();

                // if (count($paoPercentINVList) <= 0) {
                //     OrderRepo::insertPaoPercentINV($order_item->order_header_id);

                //     $paoPercentINVList = DB::table('ptom_pao_percent_inv')->where('order_header_id', $order_item->order_header_id)->whereNull('deleted_at')->get();
                // }

                $paoPercentINVList = DB::table('ptom_pao_percent_inv')->where('order_header_id', $order_item->order_header_id)->orderBy('pao_percent_inv_id')->get();

                // dd($paoPercentINVList);

                $dataAll[] = [
                    'order'             => $order_item,
                    'orderLine'         => $orderLine,
                    'totalOrderLines'   => $totalOrderLines,
                    'creditGroupList'   => $creditGroupList,
                    'paoPercentINVList' => $paoPercentINVList
                ];
            }
        }else{
            $dataAll  = [];
        }

        // dd($order);
        // dd($orderLine);

        // return view('om.reprintinvoice/print', compact('dataAll')); // เงื่อนไข 1 ลูกค้าประเภทอื่นๆ
        $pdf = PDF::loadView('om.reprintinvoice/print', compact('dataAll'));

        $pdf->setOption('page-width', '8.5in')
            ->setOption('page-height', '12in')
            ->setOption('margin-left','0')
            ->setOption('margin-right','0')
            ->setOption('margin-top','0')
            ->setOption('margin-bottom','0');

        return $pdf->stream('print.pdf');
    }

    public function print_invoice_all(Request $request)
    {
        // dd('print_invoice_all', request()->all());
        // delivery_start_date
        // delivery_end_date
        // prepare_order_number ---
        // customer_id ---
        // pick_release_approve_flag
        // pick_release_no ---
        // pick_release_status  ---
        // pick_release_print_flag
        $delivery_start_date       = $request->delivery_start_date;
        $delivery_end_date         = $request->delivery_end_date;

        $match = PaymentMatchInvoices::selectRaw('PREPARE_ORDER_NUMBER as invoice_prepare ,max(DUE_DATE) as maxdate,sum(PAYMENT_AMOUNT) as sumamount, max(PAYMENT_HEADER_ID) as max_payment_header_id')
                                        ->groupBy('PREPARE_ORDER_NUMBER');
        $order = OrderHeaders::where('PERIOD_ID','!=',1)
                                ->leftJoin('PTOM_APPROVER_ORDERS', 'PTOM_ORDER_HEADERS.PICK_RELEASE_APPROVE_BY', '=', 'PTOM_APPROVER_ORDERS.APPROVER_ORDER_ID')
                                ->leftJoin('PTOM_CUSTOMERS', 'PTOM_ORDER_HEADERS.CUSTOMER_ID', '=', 'PTOM_CUSTOMERS.CUSTOMER_ID')
                                ->leftJoin('PTOM_CUSTOMER_SHIP_SITES', 'PTOM_CUSTOMER_SHIP_SITES.ship_to_site_id', '=', 'ptom_order_headers.ship_to_site_id')
                                ->leftJoinSub($match, 'match', 'match.invoice_prepare', 'PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER')
                                ->where('PTOM_CUSTOMERS.SALES_CLASSIFICATION_CODE', 'Domestic')
                                ->where('ptom_order_headers.payment_approve_flag', 'Y')
                                ->where('ptom_order_headers.order_status', '!=', 'Cancelled')
                                // ->when($delivery_start_date, function($q) use($delivery_start_date) {
                                //     $q->where('delivery_date', date("Y-m-d", strtotime($delivery_start_date)));
                                // })
                                // ->whereIn('ptom_order_headers.order_header_id', $id)
                                // ->where('ptom_order_headers.prepare_order_number', request()->prepare_order_number)
                                // ->where('ptom_order_headers.pick_release_no', request()->pick_release_no)
                                // ->where('ptom_order_headers.pick_release_status', request()->pick_release_status)
                                // ->where('ptom_order_headers.customer_id', request()->customer_id)
                                ->select([
                                    'PTOM_ORDER_HEADERS.*',
                                    'PTOM_APPROVER_ORDERS.APPROVER_NAME as approver_name',
                                    'match.*',
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
                                    'ptom_customers.customer_type_id',
                                    'ptom_customers.market'
                                    ,'ptom_customer_ship_sites.address_line1 as s_address_line1'
                                    ,'ptom_customer_ship_sites.address_line2 as s_address_line2'
                                    ,'ptom_customer_ship_sites.address_line3 as s_address_line3'
                                    ,'ptom_customer_ship_sites.alley as s_alley'
                                    ,'ptom_customer_ship_sites.district as s_district'
                                    ,'ptom_customer_ship_sites.city as s_city'
                                    ,'ptom_customer_ship_sites.province_name as s_province_name'
                                    ,'ptom_customer_ship_sites.postal_code as s_postal_code'
                                ])
                                ->searchReport($request)
                                ->orderBy('PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER', 'asc')
                                // ->orderBy('ptom_order_headers.cust_po_number', 'asc')
                                // ->orderBy('ptom_order_headers.pick_release_no', 'asc')
                                ->get();


        $dataAll  = [];
        if ($order->count() > 0) {

            foreach($order as $order_item){
                // UPDATE PRINT INVOICE 20230130 Piyawut A.
                $OrderHeader = OrderHeaders::where('order_header_id', $order_item->order_header_id)->update(['print_invoice_flag' => 'Y', 'print_by_id' => auth()->user()->user_id]);

                $datad[] = $order_item->pick_release_no;

                $totalOrderLines    = [];
                $order_item->is_over_quota = false;
                $customer_quota = [];

                $quota_group = DB::table('ptom_quota_group as cg')->where('tag','Y')->get(['cg.lookup_code','cg.meaning']);

                $priceUnit = DB::raw("(SELECT operand FROM ptom_price_list_line_v
                    WHERE ptom_price_list_line_v.list_header_id = plh.list_header_id
                    AND ptom_price_list_line_v.item_id = cql.item_id
                ) as price_unit");
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

                        'qcg.quota_credit_id',
                        'qcg.credit_group_code',

                        'cql.quota_line_id',
                        'cql.item_id',
                        'cql.item_code',
                        'cql.item_description',
                        'cql.received_quota',
                        'cql.minimum_quota',
                        'cql.remaining_quota',
                        $priceUnit
                    )
                    ->join('ptom_customer_quota_lines as cql', 'cql.quota_header_id', '=', 'cqh.quota_header_id')
                    ->leftJoin('ptom_quota_and_credit_group as qcg', 'qcg.item_id', '=', 'cql.item_id')

                    ->join('ptom_customers as c', 'c.customer_id', '=', 'cqh.customer_id')
                    ->join('ptom_price_list_head_v as plh', 'plh.list_header_id', '=', 'c.price_list_id')
                    ->where('cqh.start_date','<=',date('Y-m-d'))
                    ->where('cqh.end_date','>=',date('Y-m-d'))
                    ->where('cqh.customer_id', $order_item->customer_id)
                    ->where('qcg.quota_group_code',$qitem->lookup_code)
                    ->get();
                    if(count($quota) > 0){
                        foreach ($quota as $_q) {$customer_quota[] = $_q;}
                    }

                }
                $line_item = DB::table('PTOM_ORDER_LINES')->where('ORDER_HEADER_ID', $order_item->order_header_id)->get();
                foreach ($line_item as $line) {
                    $quantity = $line->total_amount/1000;
                    $sum = 0;
                    foreach($customer_quota as $_q) {
                        if($_q->item_code==$line->item_code) $sum+=$_q->remaining_quota;
                    }
                    if($quantity>$sum) {
                        $order_item->is_over_quota = true;
                    }
                }

                if ($order_item->credit_amount != 0) {
                    if ($order_item->credit_amount == $order_item->sumamount) {
                        $order_item->statusAmount = 2;
                    } else {
                        if($order_item->sumamount == null && $order_item->cash_amount > 0){
                            $order_item->statusAmount = 1;
                        }else if ($order_item->payment_duedate == null || Carbon::now() < $order_item->payment_duedate) {
                            $order_item->statusAmount = 0;
                        } else {
                            $order_item->statusAmount = 1;
                        }
                    }
                } else {
                    if ($order_item->cash_amount <= $order_item->sumamount && $order_item->cash_amount != 0) {
                        $order_item->statusAmount = 2;
                    } else {
                        $order_item->statusAmount = 1;
                    }
                }

                if (empty($order_item->prepare_order_number)) {
                    $order_item->prepare_order_number = '';
                }

                if (empty($order_item->pick_release_no)) {
                    $order_item->pick_release_no = '';
                }

                if (empty($order_item->pick_release_status)) {
                    $order_item->pick_release_status = '';
                }

                if (!empty($order_item->delivery_date)) {
                    $order_item->delivery_date = dateFormatThai($order_item->delivery_date);
                }else{
                    $order_item->delivery_date = '';
                }

                if (!empty($order_item->cash_amount)) {
                    $order_item->cash_amount = number_format($order_item->cash_amount,2);
                }else{
                    $order_item->cash_amount = '0.00';
                }

                if (!empty($order_item->credit_amount)) {
                    $order_item->credit_amount = number_format($order_item->credit_amount,2);
                }else{
                    $order_item->credit_amount = '0.00';
                }

                if (!empty($order_item->grand_total)) {
                    $order_item->grand_total = number_format($order_item->grand_total,2, '.', ',');
                }else{
                    $order_item->grand_total = '0.00';
                }

                $getPeriodQuery = Period::select('budget_year', 'period_no')->where('period_line_id', $order_item->period_id)->first();

                if (!empty($getPeriodQuery)) {
                    $order_item->period_detail   = ($getPeriodQuery->budget_year+543).'/'.$getPeriodQuery->period_no;
                }else{
                    $order_item->period_detail   = '';
                }

                if (!empty($order_item->pick_release_approve_date)) {
                    $order_item->pick_release_approve_date = dateFormatThai($order_item->pick_release_approve_date);
                }else{
                    $order_item->pick_release_approve_date = '';
                }

                if (!empty($order_item->order_date)) {
                    $order_item->order_date = dateFormatThai($order_item->order_date);
                }else{
                    $order_item->order_date = '';
                }

                if (!empty($order_item->requestor_code)) {
                    $order_item->requestor_description = DB::table('ptom_requestor')->select('description')->where('lookup_code', $order_item->requestor_code)->pluck('description')->first();
                }

                $order_item->payment_date = !empty($order_item->payment_duedate) ? dateFormatThai($order_item->payment_duedate) : '';


                // SHIPMENT BY
                $getShipmentQuery   = ShipmentBy::select('meaning')->where('lookup_code', $order_item->transport_type_code)->first();

                if (!empty($getShipmentQuery)) {

                    if ($getShipmentQuery == '20') {
                        $transportOwnerName = TransportOwner::where('stop_flag', 'N')
                                                            ->whereRaw("nvl(start_date,sysdate+1) < sysdate")
                                                            ->whereRaw("nvl(end_date,sysdate+1) > sysdate")
                                                            ->pluck('transport_owner_name')->first();

                        $order_item->transport_type_description  = !empty($transportOwnerName) ? $transportOwnerName : '';
                    }else{
                        $order_item->transport_type_description  = $getShipmentQuery->meaning;
                    }

                }else{
                    $order_item->transport_type_description   = '';
                }

                // TIME SHIPMENT BY
                $getPrintHistoryDate    = PrintHistory::where('document_id', $order_item->pick_release_id)->pluck('print_date')->first();

                $splitTimeStamp = explode(" ",$getPrintHistoryDate);
                $printDate = !empty($splitTimeStamp[0]) ? $splitTimeStamp[0] : '';
                $order_item->shipment_time = !empty($splitTimeStamp[1]) ? $splitTimeStamp[1] : '';
                // $order_item->shipment_time = !empty($printTime) ? str_replace(':', '.', $printTime) : '';

                // SHIPMENT BY
                $getShipSiteQuery   = CustomerShipSites::where('ship_to_site_id', $order_item->ship_to_site_id)->orderBy('site_no')->first();

                if (!empty($getShipSiteQuery)) {
                    
                    $customer = Customers::where('customer_id', $order_item->customer_id)->first();

                    $order_item->ship_to_site_name   = $getShipSiteQuery->ship_to_site_name;
                    $order_item->ship_show_line      = $customer->customer_type_id == 20 || $getShipSiteQuery->province_code == 10 ? 'ไม่ อบจ.' : 'อบจ.';
                    $order_item->ship_province_name  = $getShipSiteQuery->province_name;
                }else{
                    $order_item->ship_show_line      = '';
                    $order_item->ship_province_name  = '';
                }

                // GET ORDER LINES

                if ($order_item->attribute5 == 'Y') {
                    $orderLine      = OrderLines::where('order_header_id', $order_item->order_header_id)->orderBy('line_number', 'asc')->whereNull('deleted_at')->get();
                }else{
                    $orderLine      = OrderLines::where('order_header_id', $order_item->order_header_id)->orderBy('line_number', 'asc')->whereNull("promo_flag")->whereNull('deleted_at')->get();
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

                        $conversionCGC  = UomConversions::where('uom_code', 'CGC')->pluck('conversion_rate')->first();
                        $resultConversionCGC    = (float)$value->unit_price * ($conversionCGC / 1000);

                        // TOTAL
                        $totalApprove   = $totalApprove + $value->approve_quantity;
                        $totalAmount    = $totalAmount + $value->amount;
                        $totalOperand   = $totalOperand + $total_operand;

                        $orderLine[$key]->line_number   = $key+1;

                        $orderLine[$key]->unit_price    = number_format($value->unit_price, 2, '.', ',');
                        $orderLine[$key]->attribute2    = number_format($value->attribute2, 2, '.', ',');
                        $orderLine[$key]->amount        = number_format($value->amount, 2, '.', ',');
                        $orderLine[$key]->total_amount  = number_format($value->total_amount, 2, '.', ',');
                        $orderLine[$key]->operand       = number_format($operand, 2, '.', ',');
                        $orderLine[$key]->total_operand = number_format($total_operand, 2, '.', ',');

                    }

                    $totalCalAmount     = $totalAmount - $order_item->tax;
                    $totalCalOperand    = $totalOperand - $order_item->tax;

                    $totalOrderLines = [
                        'total_approve_quantity'    => $totalApprove,
                        'total_cal_amount'          => number_format($totalCalAmount, 2, '.', ','),
                        'total_cal_operand'         => number_format($totalCalOperand, 2, '.', ','),
                        'total_amount'              => number_format($totalAmount, 2, '.', ','),
                        'total_operand'             => number_format($totalOperand, 2, '.', ','),
                    ];
                }

                // TAX
                $order_item->tax_rate    = TransactionType::where('order_type_id', $order_item->order_type_id)->pluck('tax_rate')->first();
                $order_item->tax         = !empty($order_item->tax) ? number_format($order_item->tax, 2, '.', ',') : '0.00';

                $creditGroupQuery   = OrderCreditGroup::where('order_header_id', $order_item->order_header_id)->where('order_line_id', 0)->where('credit_group_code', '>', 0)->whereNull('deleted_at')->orderBy('credit_group_code', 'asc')->get();

                $creditGroupList        = [];
                $checkCreditGroupCode   = 0;
                $sumAmount              = 0;

                if (!empty($creditGroupQuery)) {
                    foreach ($creditGroupQuery as $key => $value) {
                        if ($checkCreditGroupCode != $value->credit_group_code) {
                            // SUM AMOUNT
                            $checkCreditGroupCode = $value->credit_group_code;
                            $creditGroupList[$value->credit_group_code]['sum_amount'] = number_format($value->amount, 2, '.', ',');
                            $sumAmount = $value->amount;

                            $getDayOfCredit = CustomerContractGroups::where('customer_id', $order_item->customer_id)->where('credit_group_code', $value->credit_group_code)->whereNull('deleted_at')->pluck('day_amount')->first();

                            if (!empty($order_item->pick_release_approve_date)) {
                                $arrCreditDate = explode('/', $order_item->pick_release_approve_date);
                                $cDay   = $arrCreditDate[0];
                                $cMonth = $arrCreditDate[1];
                                $cYear  = $arrCreditDate[2];
                                $creditDateChange = $cYear.'/'.$cMonth.'/'.$cDay;

                                $addDays = ' + '.$getDayOfCredit.' days';
                                $testDate = date('d/m/Y', strtotime($creditDateChange. $addDays));

                                $creditGroupList[$value->credit_group_code]['credit_group_date'] = $testDate;
                            }else if (!empty($order_item->delivery_date)) {
                                $arrCreditDate = explode('/', $order_item->delivery_date);
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

                $paoPercentINVList = DB::table('ptom_pao_percent_inv')->where('order_header_id', $order_item->order_header_id)->orderBy('pao_percent_inv_id')->get();

                // dd($paoPercentINVList);

                $dataAll[] = [
                    'order'             => $order_item,
                    'orderLine'         => $orderLine,
                    'totalOrderLines'   => $totalOrderLines,
                    'creditGroupList'   => $creditGroupList,
                    'paoPercentINVList' => $paoPercentINVList
                ];
            }
        }else{
            $dataAll  = [];
        }

        // dd('print_invoice_all dataAll', $dataAll->first(), $dataAll);

        $pdf = PDF::loadView('om.reprintinvoice/reportAll', compact('dataAll'));

        $pdf->setOption('page-width', '8.5in')
            ->setOption('page-height', '12in')
            ->setOption('margin-left','0')
            ->setOption('margin-right','0')
            ->setOption('margin-top','0')
            ->setOption('margin-bottom','0');

        return $pdf->stream('reportAll.pdf');
    }
}
