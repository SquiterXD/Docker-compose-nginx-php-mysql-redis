<?php

namespace App\Http\Controllers\OM\Ajex;

use App\Http\Controllers\Controller;
use App\Http\Controllers\OM\Api\OrderEcomController;
use App\Models\OM\Api\OrderHeader;
use App\Models\OM\ConsignmentClub\ConsignmentHeader;
use App\Models\OM\CustomerContractGroup;
use App\Models\OM\Customers\Domestics\OrderCreditGroup;
use App\Models\OM\SaleConfirmation\OrderHeaders;
use App\Models\OM\OverdueDebt\PaymentApplyCNDN;
use App\Models\OM\OverdueDebt\PaymentHeaders;
use App\Models\OM\OverdueDebt\PaymentMatchInvoices;
use App\Models\OM\PenaltyRateDomesticV;
use App\Models\OM\ReleaseCredit;
use App\Models\OM\SaleConfirmation\InvoiceLines;
use App\Models\OM\SaleConfirmation\OrderHistory;
use App\Models\OM\SaleConfirmation\OrderLines;
use App\Models\OM\SaleConfirmation\Terms;
use App\Repositories\OM\GenerateNumberRepo;
use App\Repositories\OM\OrderRepo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\OM\Customers;

class ApprovePrepareOrderAjaxController extends Controller
{

    public function searchApprovePrepareOrderBak(Request $request)
    {
        echo '<pre>';
        print_r($request->all());
        echo '</pre>';
        exit();
    }

    public function searchApprovePrepareOrder(Request $request)
    {
        // define variable
        $withData = new \stdClass;

        $match = PaymentMatchInvoices::selectRaw('prepare_order_number as invoice_prepare ,max(due_date) as maxdate,sum(payment_amount) as sumamount')->where('match_flag', '!=', 'N')
            ->groupBy('prepare_order_number');
        $order = OrderHeaders::where('period_id','!=',1)
            ->leftJoin('ptom_approver_orders', 'ptom_order_headers.pick_release_approve_by', '=', 'ptom_approver_orders.approver_order_id')
            ->leftJoin('ptom_customers', 'ptom_order_headers.customer_id', '=', 'ptom_customers.customer_id')
            ->leftJoinSub($match, 'match', 'match.invoice_prepare', 'ptom_order_headers.prepare_order_number')
            ->where('ptom_customers.sales_classification_code', 'Domestic')
            ->where('ptom_order_headers.payment_approve_flag', 'Y')
            ->where('ptom_order_headers.order_status','Confirm')
            ->where(function($query) use($request) {

                if(!empty($request->customer_id)) {
                    $query->where('ptom_order_headers.customer_id', $request->customer_id);
                }
                if(!empty($request->prepare_order_number)) {
                    $query->where('ptom_order_headers.prepare_order_number', $request->prepare_order_number);
                }
                if(!empty($request->pick_release_approve_flag)) {
                    if($request->pick_release_approve_flag == 'Y') {
                        $query->where('ptom_order_headers.pick_release_approve_flag', 'Y');
                    }
                    else{
                        // $query->where('ptom_order_headers.pick_release_approve_flag', '!=', 'Y');
                        $query->whereNull('ptom_order_headers.pick_release_approve_flag');
                    }
                }
                // else{
                //     $query->whereNull('ptom_order_headers.pick_release_approve_flag');
                // }
                if(!empty($request->pick_release_no)) {
                    $query->where('ptom_order_headers.pick_release_no', $request->pick_release_no);
                }
                if(!empty($request->pick_release_status)) {
                    $query->where('ptom_order_headers.pick_release_status', $request->pick_release_status);
                }
                if(!empty($request->unlock_print_flag)) {
                    if ($request->unlock_print_flag == 'Y') {
                        $query->where('ptom_order_headers.unlock_print_flag', '=', 'Y');
                    }else{
                        $query->where('ptom_order_headers.unlock_print_flag', '!=', 'Y');
                    }
                }

                if(!empty($request->delivery_start_date)){
                    $date_ex = explode('/',$request->delivery_start_date);
                    $year_1  = $date_ex[2] - 543;
                    $date    = $year_1.'-'.$date_ex[1].'-'.$date_ex[0];
                    $query->where('ptom_order_headers.delivery_date','>=',$date);
                }
                if(!empty($request->delivery_end_date)){
                    $dateto_ex = explode('/',$request->delivery_end_date);
                    $year_2  = $dateto_ex[2] - 543;
                    $date2    = $year_2.'-'.$dateto_ex[1].'-'.$dateto_ex[0];
                    $query->where('ptom_order_headers.delivery_date','<=',$date2);
                }
            })
            ->select([
                'ptom_order_headers.*',
                'ptom_approver_orders.approver_name as approver_name',
                'match.*',
                'ptom_customers.customer_name',
                'ptom_customers.customer_type_id'
            ])
            ->orderByRaw('ptom_order_headers.pick_release_status desc, ptom_order_headers.prepare_order_number asc')
            // ->orderBy('ptom_order_headers.prepare_order_number', 'desc')
            ->get();

            if (!empty($order)) {
                $orderArray = $order->toArray();
                usort($orderArray, array($this, 'cmpSortPrepareOrderNumber'));

                foreach ($orderArray as $key => $value) {
                    $order->$key = $value;
                }

                // $order = (object)$orderArray;
            }

        // แก้ไข color status & check inputbox
        // $item->set_color 1 = สีเขียว
        // $item->set_color 2 = สีส้ม
        $customerRemaining = DB::table('ptom_customer_contract_groups')->where('remaining_amount', '<=', '0')->whereIn('customer_id',$order->pluck('customer_id')->toArray())->get();
        $pluckOrder = $order->pluck('delivery_date', 'customer_id');


        if((boolean)request()->_faster != true) {
            $deptDomVData = DB::table('ptom_debt_dom_v')
                ->where('outstanding_debt', '>', '0');
            $deptDomVData = $deptDomVData->where(function($q) use($pluckOrder){
                foreach($pluckOrder as $k => $v) {
                    $deliveryDate = Carbon::createFromFormat('Y-m-d H:i:s', $v)->format('Y-m-d');
                    $q = $q->orWhere(function($query) use($k, $deliveryDate) {
                        $query = $query->whereRaw("customer_id = '{$k}'")
                        ->whereRaw("to_date(due_date) <= to_date('{$deliveryDate}')");
                    });
                }
            });
            $ptomReleaseCreditData =  DB::table('ptom_release_credit')
            ->select('invoice_num','credit_group_code', 'customer_id', 'attribute1')
            ->where('payment_flag', 'Y')
            ->where(function($q) use ($order){
                foreach($order->pluck('order_header_id', 'customer_id') as $k => $v) {
                    $q = $q->orWhere(function($query) use($k, $v) {
                        $query = $query->where('customer_id', $k)
                        ->where('attribute1', $v);
                    });
                }
            })
            ->get();
            $deptDomVData = $deptDomVData->get();

            $withData->deptDomV = DB::table('ptom_debt_dom_v')
                                    ->whereIn('pick_release_no', $ptomReleaseCreditData->pluck('invoice_num')->toArray())
                                    ->where('outstanding_debt', '>', '0')
                                    ->get();

            $withData->customer = Customers::whereIn('customer_id', $order->pluck('customer_id')->toArray())
                                ->get();

            $withData->line_item = DB::table('ptom_order_lines')->whereIn('order_header_id', $order->pluck('order_header_id')->toArray())->get();

            $withData->PeriodID = OrderHeaders::select('period_id', 'order_header_id')->whereIn('order_header_id', $order->pluck('order_header_id')->toArray())->get();
            $withData->PeriodData = DB::table('ptom_period_v')->whereIn('period_line_id', $order->pluck('period_id')->toArray())->get();
            $withData->quota = DB::table('ptom_customer_quota_headers as cqh')
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
                                    ->whereIn('cqh.customer_id', $order->pluck('customer_id')->toArray())
                                    ->get();

            $withData->paymentHeaderID    = PaymentMatchInvoices::whereIn('prepare_order_number', $order->pluck('prepare_order_number')->toArray())
                                        ->whereNull('deleted_at')
                                        // ->pluck('payment_header_id')
                                        ->get();
            
            $withData->additionQuotar = DB::table('ptom_addition_quota_headers')->whereIn('order_header_id', $order->pluck('order_header_id')->toArray())
                                ->where('approve_status', 'อนุมัติ')
                                ->whereNull('deleted_at')
                                ->get();
            

            $withData->getInvoiceNo       = PaymentHeaders::whereIn('payment_header_id', $withData->paymentHeaderID->pluck('payment_header_id')->toArray())->get();

            // $withData->dataCheckPayment = OrderHeaders::where('customer_id', $item->customer_id)
            //                                 ->where('order_header_id', '<=', $item->order_header_id)
            //                                 ->whereNull('deleted_at')
            //                                 ->orderBy('order_header_id', 'desc')
            //                                 ->limit(2)
            //                                 ->get();


            // $withData->debtDomData = DB::table('ptom_debt_dom_v')
            //                             ->where('outstanding_debt', '>', 0)
            //                             ->where(function($q) use ($order, $withData) {
            //                                 foreach($order as $item) {
            //                                     $q->orWhere(function($query) use($item, $withData) {
            //                                         $PeriodData = $withData->PeriodData->where('period_line_id', $item->period_id)->first();
            //                                         $query->where('customer_id', $item->customer_id);
            //                                         $query->whereBetween('due_date', [$PeriodData->start_period, $PeriodData->end_period]);
            //                                     });
            //                                 }
            //                             })
            //                             ->get();
            $quota_group = DB::table('ptom_quota_group as cg')->where('tag','Y')->get(['cg.lookup_code','cg.meaning']);
        }
        foreach($order as $item) {
            if((boolean)request()->_faster == true) {
                continue;
            }
            if($item->customer_type_id == '80') {
                $item->set_color = '1';
            } else {
                // case ที่หนึ่ง
                $deliveryDate = Carbon::createFromFormat('Y-m-d H:i:s', $item->delivery_date)->format('Y-m-d');
                $period = DB::table('ptom_period_v')->whereRaw("to_date('{$deliveryDate}') between to_date(start_period) AND to_date(end_period)")->first('end_period');
                
                $periodEndPeriod = Carbon::createFromFormat('Y-m-d H:i:s',$period->end_period)->format("Y-m-d");
                $deptDomV = $deptDomVData->where('customer_id', $item->customer_id)->where('product_type_code', $item->product_type_code);

                // สีส้ม
                if($deptDomV->count() > 0) {
                    $item->set_color = '2';
                }else {
                    // case ที่สอง PTOM_RELEASE_CREDIT
                    $ptomReleaseCredit = $ptomReleaseCreditData->where('customer_id',  $item->customer_id)->where('attribute1', $item->order_header_id)->first();
                    if($ptomReleaseCredit) {
                        $deptDomV = $withData->deptDomV->where('credit_group_code', $ptomReleaseCredit->credit_group_code)
                                    ->where('pick_release_no', $ptomReleaseCredit->invoice_num);
                        if($deptDomV->count() > 0) {
                            $item->set_color = '2';
                        } else {
                            $item->set_color = '1';
                        }
                    } else {
                        $item->set_color = '1';
                    }
                }
            }
            $item->is_over_quota = false;
            $customer_quota = [];

            $customer =$withData->customer->where('customer_id', $item->customer_id)->first();

            $item->customer_name = $customer ? $customer->customer_name_format : '';

           
            // $priceUnit = DB::raw("(SELECT operand FROM ptom_price_list_line_v
            //     WHERE ptom_price_list_line_v.list_header_id = plh.list_header_id
            //     AND ptom_price_list_line_v.item_id = cql.item_id
            // ) as price_unit");
            foreach($quota_group as $qitem){
                $quota = $withData->quota
                ->where('cqh.customer_id', $item->customer_id)
                ->where('qcg.quota_group_code',$qitem->lookup_code);


                if(count($quota) > 0){
                    // dd($quota);
                    foreach ($quota as $_q) {$customer_quota[] = $_q;}
                    // $customer_quota[] = $quota;
                }

            }
            $line_item = $withData->line_item->where('order_header_id', $item->order_header_id);
            foreach ($line_item as $line) {
                $quantity = $line->total_amount/1000;
                $sum = 0;
                foreach($customer_quota as $_q) {
                    if($_q->item_code==$line->item_code) $sum+=$_q->remaining_quota;
                }
                if($quantity>$sum) {
                    $item->is_over_quota = true;
                }
            }

            // $outStandingDue    = DB::table('ptom_outstanding_debt_dom_v')->where('customer_id', $item->customer_id)->get();

            if ($item->pick_release_status == 'Confirm') {
                // New Outstatnding
                // $PeriodID = OrderHeaders::select('period_id')->where('order_header_id', $item->order_header_id)->pluck('period_id')->first();
                // $PeriodData = DB::table('ptom_period_v')->where('period_line_id', $PeriodID)->first();
                $PeriodData = $withData->PeriodData->where('period_line_id', $item->period_id)->first();

                if(!empty($PeriodData)){
                    $debtDomData = DB::table('ptom_debt_dom_v')->where('customer_id', $item->customer_id)->where('outstanding_debt', '>', 0)->whereBetween('due_date', [$PeriodData->start_period, $PeriodData->end_period])->get();

                    $item->statusAmount = 2;

                    // if (count($debtDomData) <= 0) {
                    //     $item->statusAmount = 1;
                    // }else{
                    //     $item->statusAmount = 2;
                    // }
                }
            }else{
                // New Outstatnding
                // $PeriodID = OrderHeaders::select('period_id')->where('order_header_id', $item->order_header_id)->pluck('period_id')->first();
                // $PeriodData = DB::table('ptom_period_v')->where('period_line_id', $PeriodID)->first();
                $PeriodData = $withData->PeriodData->where('period_line_id', $item->period_id)->first();

                $item->statusAmount = 2;

                if(!empty($PeriodData)){
                    $debtDomData = DB::table('ptom_debt_dom_v')->where('customer_id', $item->customer_id)->where('outstanding_debt', '>', 0)->where('due_date', '<=' ,$PeriodData->end_period)->get();

                    if (count($debtDomData) > 0) {
                        foreach ($debtDomData as $key => $value) {

                            // dd($value);
                            if ($item->customer_type_id == 30 && $item->product_type_code == 10 ) {
                                $paymentDomData = DB::table('ptom_payment_dom_v')->where('invoice_number', $value->consignment_no)->where('customer_id', $item->customer_id)->where('credit_group_code', $value->credit_group_code)->get();
                            } else {
                                $paymentDomData = DB::table('ptom_payment_dom_v')->where('prepare_order_number', $value->prepare_order_number)->where('customer_id', $item->customer_id)->where('credit_group_code', $value->credit_group_code)->get();
                            }

                            if (count($paymentDomData) > 0) {
                                foreach ($paymentDomData as $keyDom => $itemDom) {
                                    $paymentDomData[$keyDom]->payment_date      = dateFormatThaiString($itemDom->payment_date);
                                    $paymentDomData[$keyDom]->payment_amount    = number_format($itemDom->payment_amount, 2, '.', ',');
                                }

                                if ($paymentDomData[$keyDom]->payment_amount < $value->debt_amount) {
                                    $item->statusAmount = 1;
                                }else{
                                    $item->statusAmount = 2;
                                }
                            }else{
                                $item->statusAmount = 1;
                            }

                        }
                    }
                }
            }

            if (empty($item->prepare_order_number)) {
                $item->prepare_order_number = '';
                $item->invoice_no           = '';
            }else{
                
                $paymentHeaderID    = $withData->paymentHeaderID->where('prepare_order_number', $item->prepare_order_number)->first();
                // $getInvoiceNo       = PaymentHeaders::where('payment_header_id', optional($paymentHeaderID)->payment_header_id)->pluck('payment_number')->first();
                $getInvoiceNo = $withData->getInvoiceNo->where('payment_header_id', optional($paymentHeaderID)->payment_header_id)->pluck('payment_number')->first();
                $item->invoice_no   = !empty($getInvoiceNo) ? $getInvoiceNo : '';
            }

            if (empty($item->pick_release_no)) {
                $item->pick_release_no = '';
            }

            if (empty($item->pick_release_status)) {
                $item->pick_release_status = '';
            }

            if (!empty($item->delivery_date)) {
                $item->delivery_date = dateFormatThaiString($item->delivery_date);
            }else{
                $item->delivery_date = '';
            }

            if (!empty($item->cash_amount)) {
                $item->cash_amount = number_format($item->cash_amount,2);
            }else{
                $item->cash_amount = '0.00';
            }

            if (!empty($item->credit_amount)) {
                $item->credit_amount = number_format($item->credit_amount,2);
            }else{
                $item->credit_amount = '0.00';
            }

            if (!empty($item->grand_total)) {
                $item->grand_total = number_format($item->grand_total,2);
            }else{
                $item->grand_total = '0.00';
            }

            $additionQuotar = $withData->additionQuotar->where('order_header_id', $item->order_header_id)->first();

            if (!empty($additionQuotar->approve_status)) {
                $item->addition_approve_status = 'Y';
            }else{
                $item->addition_approve_status = 'N';
            }

            // Check Payment before
            $dataCheckPayment = OrderHeaders::where('customer_id', $item->customer_id)->where('order_header_id', '<=', $item->order_header_id)->whereNull('deleted_at')->orderBy('order_header_id', 'desc')->limit(2)->get();

            $item->payment_before_status = 'Y';

            if (!empty($dataCheckPayment[1])) {

                $dataOrder = $dataCheckPayment[1];

                $paymentAmount = DB::table('ptom_payment_match_invoices')->where('prepare_order_number', $dataOrder->prepare_order_number)->where('match_flag', 'Y')->whereNull('deleted_at')->sum('payment_amount');

                $orderPaymentAmount = (float)$dataOrder->cash_amount + (float)$dataOrder->credit_amount;

                if ($paymentAmount <= $orderPaymentAmount) {

                    $checkDayAmount = 0;

                    // ดึงข้อมูลการค้างชำระ กรณี อื่นๆ
                    $selectColumnes = ['day_amount', 'credit_group_code'];
                    $dataCreditGroup = OrderLines::select($selectColumnes)->where('order_header_id', $dataOrder->order_header_id)->whereNull('deleted_at')->whereNull('promo_flag')->groupBy($selectColumnes)->get();

                    if (!$dataCreditGroup->isEmpty()) {
                        foreach ($dataCreditGroup as $crItem) {

                                // ดึงข้อมูล Day amount จาก TermV กรณี เป็นเงินสด
                            if (($item->customer_type_id == 30 || $item->customer_type_id == 40) && $item->product_type_code == 10) {
                                if (trim($crItem->credit_group_code) == 0) {
                                    $dueDaysConsignment = Terms::where('credit_group_code', 0)
                                                                ->where('sale_type', 'DOMESTIC')
                                                                ->whereRaw("nvl(start_date_active,sysdate+1) < sysdate")
                                                                ->whereRaw("nvl(end_date_active,sysdate+1) > sysdate")
                                                                ->pluck('due_days_consignment')->first();

                                    $crItem->day_amount = !empty($dueDaysConsignment) ? $dueDaysConsignment : trim($crItem->day_amount);
                                }
                            }

                            if ($item->customer_type_id == 30 && $item->product_type_code == 10)
                            {
                                // ดึงข้อมูลการค้างชำระ กรณี ลูกค้าสโมรกรุงเทพ
                                $consignmentData  = ConsignmentHeader::where('order_header_id', $dataOrder->order_header_id)->where('consignment_status', 'Confirm')->whereNull('deleted_at')->get();

                                $sumConsigment      = 0.00;
                                $sumPayment         = 0.00;
                                $sumInvoiceLine     = 0.00;
                                $totalPaymentCNDN   = 0.00;
                                if (!empty($consignmentData)) {
                                    foreach ($consignmentData as $consItem) {
                                        // SUM TOTAL AMOUNT FROM CONSIGNMENT
                                        $sumConsigment = $sumConsigment + (!empty($consItem->total_amount) ? $consItem->total_amount : 0);

                                        // SUM PAYMENT_AMOUNT FROM PAYMENT MATCH INVOICES
                                        $paymentMatchInvoice = PaymentMatchInvoices::where('invoice_number', $consItem->consignment_no)->where('match_flag', 'Y')->whereNull('deleted_at')->get();

                                        if (!$paymentMatchInvoice->isEmpty()) {
                                            foreach ($paymentMatchInvoice as $matchItem) {
                                                $sumPayment = $sumPayment + (!empty($matchItem->payment_amount) ? (float)$matchItem->payment_amount : 0);

                                                $paymentCNDN         = PaymentApplyCNDN::join('ptom_payment_match_invoices', 'ptom_payment_apply_cndn.payment_match_id', '=', 'ptom_payment_match_invoices.payment_match_id')
                                                                                ->where('ptom_payment_match_invoices.payment_match_id', $matchItem->payment_match_id)
                                                                                ->sum('ptom_payment_apply_cndn.invoice_amount');

                                                $totalPaymentCNDN   = $totalPaymentCNDN + (float)$paymentCNDN;
                                            }
                                        }

                                    }
                                }

                                $sumInvoiceLine         = InvoiceLines::join('ptom_invoice_headers', 'ptom_invoice_lines.invoice_headers_id', '=', 'ptom_invoice_headers.invoice_headers_id')
                                                                        ->where('ptom_invoice_lines.document_id', $dataOrder->order_header_id)
                                                                        ->where('ptom_invoice_headers.invoice_type', 'CN_OTHER')
                                                                        ->sum('payment_amount');

                                $resultPayment  = (float)$sumPayment + (float)$totalPaymentCNDN + (float)$sumInvoiceLine;

                                if ((float)$sumConsigment != $resultPayment) {
                                    $checkDayAmount = 1;
                                }
                            }
                            else if ($item->customer_type_id == 40 && $item->product_type_code == 10)
                            {
                                $grandTotal     = !empty($dataOrder->grand_total) ? (float)$dataOrder->grand_total : 0.00;

                                // ดึงข้อมูลการค้างชำระ กรณี ลูกค้าสโมรภูมิภาค
                                $consignmentData  = ConsignmentHeader::where('order_header_id', $dataOrder->order_header_id)->where('consignment_status', 'Confirm')->whereNull('deleted_at')->get();

                                $sumConsigment      = 0.00;
                                $sumPayment         = 0.00;
                                $sumInvoiceLine     = 0.00;
                                $totalPaymentCNDN   = 0.00;
                                if (!empty($consignmentData)) {
                                    foreach ($consignmentData as $consItem) {

                                        $sumInvoiceLine1    = InvoiceLines::join('ptom_invoice_headers', 'ptom_invoice_lines.invoice_headers_id', '=', 'ptom_invoice_headers.invoice_headers_id')
                                                                        ->where('ptom_invoice_lines.document_id', $consItem->consignment_header_id)
                                                                        ->where('ptom_invoice_headers.invoice_type', 'CN_TRANFER')
                                                                        ->sum('payment_amount');

                                        $sumInvoiceLine2    = InvoiceLines::join('ptom_invoice_headers', 'ptom_invoice_lines.invoice_headers_id', '=', 'ptom_invoice_headers.invoice_headers_id')
                                                                        ->where('ptom_invoice_lines.document_id', $consItem->consignment_header_id)
                                                                        ->where('ptom_invoice_headers.invoice_type', 'CN_OTHER')
                                                                        ->sum('payment_amount');

                                        $sumInvoiceLine     = $sumInvoiceLine + (float)$sumInvoiceLine1 + (float)$sumInvoiceLine2;

                                        // SUM TOTAL AMOUNT FROM CONSIGNMENT
                                        $sumConsigment = $sumConsigment + (!empty($consItem->total_amount) ? $consItem->total_amount : 0);

                                        // SUM PAYMENT_AMOUNT FROM PAYMENT MATCH INVOICES
                                        $paymentMatchInvoice = PaymentMatchInvoices::where('invoice_number', $consItem->consignment_no)->where('match_flag', 'Y')->whereNull('deleted_at')->get();

                                        if (!$paymentMatchInvoice->isEmpty()) {
                                            foreach ($paymentMatchInvoice as $matchItem) {
                                                $sumPayment = $sumPayment + (!empty($matchItem->payment_amount) ? (float)$matchItem->payment_amount : 0);

                                                $paymentCNDN         = PaymentApplyCNDN::join('ptom_payment_match_invoices', 'ptom_payment_apply_cndn.payment_match_id', '=', 'ptom_payment_match_invoices.payment_match_id')
                                                                                ->where('ptom_payment_match_invoices.payment_match_id', $matchItem->payment_match_id)
                                                                                ->sum('ptom_payment_apply_cndn.invoice_amount');

                                                $totalPaymentCNDN   = $totalPaymentCNDN + (float)$paymentCNDN;
                                            }
                                        }
                                    }
                                }

                                $resultPayment  = (float)$sumPayment + (float)$sumInvoiceLine + (float)$totalPaymentCNDN;

                                if ($grandTotal != $resultPayment) {
                                    $checkDayAmount = 1;
                                }


                            }
                            else{
                                // ตรวจสอบการค้างชำระ
                                $sumCreditGroupAmount   = OrderCreditGroup::where('order_header_id', $dataOrder->order_header_id)->where('order_line_id', 0)->where('credit_group_code', $crItem->credit_group_code)->whereNull('deleted_at')->sum('amount');

                                $PaymentMatchInvoice = PaymentMatchInvoices::where('prepare_order_number', $dataOrder->prepare_order_number)->where('match_flag', 'Y')->where('credit_group_code', $crItem->credit_group_code)->whereNull('deleted_at')->get();

                                $sumPaymentMatchInvoice = 0.00;
                                $totalPaymentCNDN       = 0.00;
                                if (!empty($PaymentMatchInvoice)) {
                                    foreach ($PaymentMatchInvoice as $matchItem) {
                                        $sumPaymentMatchInvoice = $sumPaymentMatchInvoice + (float)$matchItem->payment_amount;
                                        $sumPaymentCNDN         = PaymentApplyCNDN::join('ptom_payment_match_invoices', 'ptom_payment_apply_cndn.payment_match_id', '=', 'ptom_payment_match_invoices.payment_match_id')
                                                                                ->where('ptom_payment_match_invoices.payment_match_id', $matchItem->payment_match_id)
                                                                                ->sum('ptom_payment_apply_cndn.invoice_amount');

                                        $totalPaymentCNDN   = $totalPaymentCNDN + (float)$sumPaymentCNDN;
                                    }
                                }

                                $sumInvoiceLine         = InvoiceLines::join('ptom_invoice_headers', 'ptom_invoice_lines.invoice_headers_id', '=', 'ptom_invoice_headers.invoice_headers_id')
                                                                        ->where('ptom_invoice_lines.document_id', $dataOrder->order_header_id)
                                                                        ->where('ptom_invoice_headers.invoice_type', 'CN_OTHER')
                                                                        ->sum('payment_amount');

                                $resultPayment  = (float)$sumPaymentMatchInvoice + (float)$totalPaymentCNDN + (float)$sumInvoiceLine;

                                if ((float)$sumCreditGroupAmount != $resultPayment ) {
                                    $checkDayAmount = 1;
                                }
                            }

                            if ($checkDayAmount == 1) {
                                // ตรวจสอบวันครบกำหนดชำระ
                                $dueDate1 = !empty($dataOrder->pick_release_approve_date) ? $dataOrder->pick_release_approve_date : (!empty($dataOrder->delivery_date) ? $dataOrder->delivery_date : 0);

                                $dateFirst = removeTimeOnDate($dueDate1);

                                if ($crItem->day_amount <= 0) {
                                    $date1=date_create($dateFirst);     // วันครบกำหนดชำระ
                                }else{
                                    $dayAmount  = date('Y-m-d', strtotime("+".$crItem->day_amount." day", strtotime($dateFirst)));
                                    $date1      = date_create($dayAmount);      // วันครบกำหนดชำระ
                                }

                                // $date1=date_create(date('2021-11-28'));
                                $date2=date_create(date('Y-m-d'));     // วันปัจจุบัน
                                $diff=date_diff($date2,$date1);
                                $resultDay = $diff->format("%r%a");

                                if ($resultDay <= 0) {
                                    $item->payment_before_status = 'N';
                                }
                            }
                        }
                    }

                }
            }

            // S = ชำระเงินแล้ว
            // Y =

            // if ($item->pick_release_status == 'Confirm') {
            //     $outstandingQuery = DB::table('ptom_outstanding_debt_dom_v')->where('order_header_id', $item->order_header_id)->get();

            //     // echo '<pre>';
            //     // print_r($outstandingQuery);
            //     // echo '</pre>';
            //     // exit();

            //     if ($outstandingQuery->isEmpty()) {
            //         $item->standing_debt_status = 'S';
            //     }else{
            //         $outStanding    = DB::table('ptom_outstanding_debt_dom_v')->where('customer_id', $item->customer_id)->where('order_header_id', $item->order_header_id)->whereRaw("nvl(due_date,sysdate+1) <= sysdate")->first();

            //         if (!empty($outStanding)) {
            //             $item->standing_debt_status = 'Y';
            //         }else{
            //             $item->standing_debt_status = 'W';
            //         }
            //     }

            // }else{
            //     $outStanding    = DB::table('ptom_outstanding_debt_dom_v')->where('customer_id', $item->customer_id)->whereRaw("nvl(due_date,sysdate+1) <= sysdate")->first();

            //     // echo '<pre>';
            //     // print_r($outStanding);
            //     // echo '</pre>';
            //     // exit();

            //     if (!empty($outStanding)) {
            //         $item->standing_debt_status = 'Y';
            //     }else{
            //         $item->standing_debt_status = 'N';
            //     }
            // }
        }

        // echo '<pre>';
        // print_r($order);
        // echo '</pre>';
        // exit();

        // delivery_start_date
        // delivery_end_date
        // prepare_order_number
        // customer_number
        // customer_id
        // customer_name
        // pick_release_approve_flag
        // pick_release_no
        // pick_release_status
        // pick_release_print_flag
        // om/print-invoice/report
        $redirect_page = route('om.print-invoice.report-all').'?delivery_start_date='.$request->delivery_start_date.'&delivery_end_date='.$request->delivery_end_date
                        .'&prepare_order_number='.$request->prepare_order_number.'&customer_id='.$request->customer_id
                        .'&pick_release_approve_flag='.$request->pick_release_approve_flag.'&pick_release_no='.$request->pick_release_no
                        .'&pick_release_status='.$request->pick_release_status.'&pick_release_print_flag='.$request->pick_release_print_flag;
        

        $rest = [
            'status'        => 'success',
            'data'          => $order,
            'redirect_page' => $redirect_page
        ];

        return response()->json(['data'=>$rest]);
    }

    /**
     * updateRemainingAmount
     *
     * @param  mixed $customer_id
     * @return void
     */
    public function updateRemainingAmount($customer_id) {
        $customerContracts = CustomerContractGroup::where('customer_id', $customer_id)->get();
        $remaining= (new OrderEcomController)->reCalculateRemainingAmountVal($customer_id);
        foreach($customerContracts as $ccg) {
            DB::table('ptom_customer_contract_groups')
            ->where('customer_id', $customer_id)
            ->where('credit_group_code', $ccg->credit_group_code)
            ->update(['remaining_amount' => !empty(@$remaining[$ccg->credit_group_code]) ? $remaining[$ccg->credit_group_code] :0 ]);
        }
    }
    public function managePrepareOrder(Request $request)
    {
        // echo '<pre>';
        // print_r($request->all());
        // echo '</pre>';
        // exit();

        foreach ($request->select_order as $key => $value) {
            $order_data = OrderHeaders::where('order_header_id', $value)
                ->leftJoin('ptom_period_v', 'ptom_order_headers.period_id', '=', 'ptom_period_v.period_line_id')
                ->leftJoin('ptom_transaction_types_v', 'ptom_order_headers.order_type_id' ,'=', 'ptom_transaction_types_v.order_type_id')
                ->select([
                    'ptom_order_headers.*',
                    'ptom_period_v.budget_year as year',
                    'ptom_transaction_types_v.product_type as product_type'
                ])
                ->get()[0];
            // return $order_data;

            // echo '<pre>';
            // print_r($order_data->delivery_date);
            // echo '</pre>';
            // exit();

            if(!isset($order_data->pick_release_approve_flag) || $order_data->pick_release_approve_flag!='Y')
            {
                // $year = strval(($order_data->year + 543)-2500);
                // // $symbol =
                // if(!$order_data->year) $year = '64';
                // $symbol = '';
                // if(empty($order_data->product_type)){
                //     $symbol = 'C';
                // }
                // else if(str_contains($order_data->product_type, 'บุหรี่')) {
                //     $symbol = 'IL';
                // }
                // else if(str_contains($order_data->product_type, 'ยาเส้น')) {
                //     $symbol = 'IO';
                // }
                // else {
                //     $symbol = 'C';
                // }
                // $running_number = sprintf("%06d", $order_data->order_header_id);
                // $invoice_no = $year . $symbol . $running_number;

                $documentCode = '';

                if($request->product_type_code[$value] == '10' && ($request->customer_type_id[$value] == '30' || $request->customer_type_id[$value] == '40')){
                    $documentCode = 'OMP0030_C_NUM_DOM';
                }else if($request->product_type_code[$value] == '10'){
                    $documentCode = 'OMP0030_INV_NUM_CG_DOM';
                }else if ($request->product_type_code[$value] == '20') {
                    $documentCode = 'OMP0030_INV_NUM_L_DOM';
                }else{
                    $documentCode = 'OMP0030_INV_NUM_O_DOM';
                }

                $checkPremium = DB::table('ptom_invoice_with_premium_v')->where('enabled_flag', 'Y')
                                                                        ->whereRaw("nvl(start_date_active,sysdate+1) < sysdate")
                                                                        ->whereRaw("nvl(end_date_active,sysdate+1) > sysdate")->get();

                $invoice_no = GenerateNumberRepo::generateApprovePrepare($documentCode);

                if($request->event == 'Confirm'){
                    $update = [
                        'pick_release_approve_flag'     => 'Y',
                        'pick_release_approve_date'     => Carbon::createFromFormat('Y-m-d H:i:s',$order_data->delivery_date)->format('Y-m-d'). " ". Carbon::now()->format('H:i:s'),
                        'pick_release_approve_by'       => $request->approver_id[$value],
                        'attribute1'                    => $request->remark[$value],
                        // 'attribute5'                    => !$checkPremium->isEmpty() ? 'Y' : 'N',
                        'pick_release_status'           => 'Confirm',
                        'pick_release_id'               => $order_data->order_header_id,
                        'pick_release_no'               => $invoice_no,
                        'last_updated_by'               => optional(auth()->user())->user_id,
                        // 'last_update_date'              => date('Y-m-d H:i:s')
                    ];

                    $updateHistory = [
                        'pick_release_approve_flag'     => 'Y',
                        'pick_release_approve_date'     => Carbon::createFromFormat('Y-m-d H:i:s',$order_data->delivery_date)->format('Y-m-d'). " ". Carbon::now()->format('H:i:s'),
                        'pick_release_approve_by'       => $request->approver_id[$value],
                        'attribute1'                    => $request->remark[$value],
                        // 'attribute5'                    => !$checkPremium->isEmpty() ? 'Y' : 'N',
                        'pick_release_status'           => 'Invoice',
                        'pick_release_id'               => $order_data->order_header_id,
                        'pick_release_no'               => $invoice_no,
                        'last_updated_by'               => optional(auth()->user())->user_id,
                        // 'last_update_date'              => date('Y-m-d H:i:s')
                    ];
                    OrderHistory::where('order_header_id', $value)->where('order_status', 'Invoice')->whereNull('deleted_at')->update($updateHistory);

                    $getOrderLinesQuery = OrderLines::where('order_header_id', $value)->whereNull('deleted_at')->get();

                    if (!empty($getOrderLinesQuery)) {
                        foreach ($getOrderLinesQuery as $key => $lineValue) {
                            // $approveLine    = [
                            //     'approve_quantity'  => $lineValue->approve_quantity,
                            //     'last_updated_by'   => optional(auth()->user())->user_id,
                            //     'last_update_date'  => date('Y-m-d H:i:s')
                            // ];

                            // OrderLines::where('order_line_id', $lineValue->order_line_id)->update($approveLine);
                        }
                    }

                }else{
                    $update = [
                        'pick_release_approve_flag'     => 'N',
                        'pick_release_approve_date'     => NULL,
                        'pick_release_approve_by'       => NULL,
                        'attribute1'                    => NULL,
                        // 'attribute5'                    => NULL,
                        'pick_release_status'           => 'Cancelled',
                        'pick_release_id'               => NULL,
                        'pick_release_no'               => NULL,
                        'last_updated_by'               => optional(auth()->user())->user_id,
                        // 'last_update_date'              => date('Y-m-d H:i:s')
                    ];

                    $updateHistory = [
                        'pick_release_approve_flag'     => 'N',
                        'pick_release_approve_date'     => NULL,
                        'pick_release_approve_by'       => NULL,
                        'attribute1'                    => NULL,
                        // 'attribute5'                    => NULL,
                        'pick_release_status'           => 'Cancelled',
                        'pick_release_id'               => NULL,
                        'pick_release_no'               => NULL,
                        'last_updated_by'               => optional(auth()->user())->user_id,
                        // 'last_update_date'              => date('Y-m-d H:i:s')
                    ];
                    OrderHistory::where('order_header_id', $value)->where('order_status', 'Invoice')->whereNull('deleted_at')->update($updateHistory);
                }

                // echo '<pre>';
                // print_r($update);
                // echo '</pre>';
                // exit();

                OrderHeaders::where('order_header_id', $value)->update($update);

                if($request->product_type_code[$value] == '10' && $request->customer_type_id[$value] == '40'){
                    OrderRepo::insertConsiggment($value);
                }

                if ($request->event == 'Confirm') {
                    GenerateNumberRepo::callWMSPackageApprovePrepare($order_data->order_header_id, $order_data->prepare_order_number);

                    $getHeadersData = OrderHeaders::where('order_header_id', $order_data->order_header_id)->first();
                    OrderRepo::insertOrdersHistoryv2($getHeadersData, 'Invoice');

                    OrderRepo::calculatePao($order_data->order_header_id);

                    OrderRepo::insertPaoPercentINV($order_data->order_header_id);

                }
            }
        }

        $match = PaymentMatchInvoices::selectRaw('prepare_order_number as invoice_prepare ,max(due_date) as maxdate,sum(payment_amount) as sumamount')
            ->groupBy('prepare_order_number');
        $order = OrderHeaders::where('period_id','!=',1)
            ->leftJoin('ptom_approver_orders', 'ptom_order_headers.pick_release_approve_by', '=', 'ptom_approver_orders.approver_order_id')
            ->leftJoin('ptom_customers', 'ptom_order_headers.customer_id', '=', 'ptom_customers.customer_id')
            ->leftJoinSub($match, 'match', 'match.invoice_prepare', 'ptom_order_headers.prepare_order_number')
            ->where('ptom_customers.sales_classification_code', 'Domestic')
            ->where('ptom_order_headers.payment_approve_flag', 'Y')
            ->where('ptom_order_headers.order_status','Confirm')
            ->where(function($query) use($request) {

                if(!empty($request->customer_id)) {
                    $query->where('ptom_order_headers.customer_id', $request->customer_id);
                }
                if(!empty($request->prepare_order_number)) {
                    $query->where('ptom_order_headers.prepare_order_number', $request->prepare_order_number);
                }
                if(!empty($request->pick_release_approve_flag)) {
                    if($request->pick_release_approve_flag == 'Y') {
                        $query->where('ptom_order_headers.pick_release_approve_flag', 'Y');
                    }
                    else{
                        // $query->where('ptom_order_headers.pick_release_approve_flag', '!=', 'Y');
                        $query->whereNull('ptom_order_headers.pick_release_approve_flag');
                    }
                }
                // else{
                //     $query->whereNull('ptom_order_headers.pick_release_approve_flag');
                // }
                if(!empty($request->pick_release_no)) {
                    $query->where('ptom_order_headers.pick_release_no', $request->pick_release_no);
                }
                if(!empty($request->pick_release_status)) {
                    $query->where('ptom_order_headers.pick_release_status', $request->pick_release_status);
                }
                if(!empty($request->unlock_print_flag)) {
                    if ($request->unlock_print_flag == 'Y') {
                        $query->where('ptom_order_headers.unlock_print_flag', '=', 'Y');
                    }else{
                        $query->where('ptom_order_headers.unlock_print_flag', '!=', 'Y');
                    }
                }

                if(!empty($request->delivery_start_date)){
                    $date_ex = explode('/',$request->delivery_start_date);
                    $year_1  = $date_ex[2] - 543;
                    $date    = $year_1.'-'.$date_ex[1].'-'.$date_ex[0];
                    $query->where('ptom_order_headers.delivery_date','>=',$date);
                }
                if(!empty($request->delivery_end_date)){
                    $dateto_ex = explode('/',$request->delivery_end_date);
                    $year_2  = $dateto_ex[2] - 543;
                    $date2    = $year_2.'-'.$dateto_ex[1].'-'.$dateto_ex[0];
                    $query->where('ptom_order_headers.delivery_date','<=',$date2);
                }
            })
            ->select([
                'ptom_order_headers.*',
                'ptom_approver_orders.approver_name as approver_name',
                'match.*',
                'ptom_customers.customer_name',
                'ptom_customers.customer_type_id'
            ])
            ->get();

            // echo '<pre>';
            // print_r($order);
            // echo '</pre>';
            // exit();

        foreach($order as $item) {
            $item->is_over_quota = false;
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
                ->where('cqh.customer_id', $item->customer_id)
                ->where('qcg.quota_group_code',$qitem->lookup_code)
                ->get();
                if(count($quota) > 0){
                    foreach ($quota as $_q) {$customer_quota[] = $_q;}
                    // $customer_quota[] = $quota;
                }

            }
            $line_item = DB::table('ptom_order_lines')->where('order_header_id', $item->order_header_id)->get();
            foreach ($line_item as $line) {
                $quantity = $line->total_amount/1000;
                $sum = 0;
                foreach($customer_quota as $_q) {
                    if($_q->item_code==$line->item_code) $sum+=$_q->remaining_quota;
                }
                if($quantity>$sum) {
                    $item->is_over_quota = true;
                }
            }

            if ($item->pick_release_status == 'Confirm') {
                // New Outstatnding
                $PeriodID = OrderHeaders::select('period_id')->where('order_header_id', $item->order_header_id)->pluck('period_id')->first();
                $PeriodData = DB::table('ptom_period_v')->where('period_line_id', $PeriodID)->first();

                if(!empty($PeriodData)){
                    $debtDomData = DB::table('ptom_debt_dom_v')->where('customer_id', $item->customer_id)->where('outstanding_debt', '>', 0)->whereBetween('due_date', [$PeriodData->start_period, $PeriodData->end_period])->get();



                    if (count($debtDomData) <= 0) {
                        $item->statusAmount = 1;
                    }else{
                        $item->statusAmount = 2;
                    }
                }
            }else{
                // New Outstatnding
                $PeriodID = OrderHeaders::select('period_id')->where('order_header_id', $item->order_header_id)->pluck('period_id')->first();
                $PeriodData = DB::table('ptom_period_v')->where('period_line_id', $PeriodID)->first();

                $item->statusAmount = 2;

                if(!empty($PeriodData)){
                    $debtDomData = DB::table('ptom_debt_dom_v')->where('customer_id', $item->customer_id)->where('outstanding_debt', '>', 0)->where('due_date', '<=' ,$PeriodData->end_period)->get();

                    if (count($debtDomData) > 0) {
                        foreach ($debtDomData as $key => $value) {

                            // dd($value);
                            if ($item->customer_type_id == 30 && $item->product_type_code == 10 ) {
                                $paymentDomData = DB::table('ptom_payment_dom_v')->where('invoice_number', $value->consignment_no)->where('customer_id', $item->customer_id)->where('credit_group_code', $value->credit_group_code)->get();
                            } else {
                                $paymentDomData = DB::table('ptom_payment_dom_v')->where('prepare_order_number', $value->prepare_order_number)->where('customer_id', $item->customer_id)->where('credit_group_code', $value->credit_group_code)->get();
                            }

                            if (count($paymentDomData) > 0) {
                                foreach ($paymentDomData as $keyDom => $itemDom) {
                                    $paymentDomData[$keyDom]->payment_date      = dateFormatThaiString($itemDom->payment_date);
                                    $paymentDomData[$keyDom]->payment_amount    = number_format($itemDom->payment_amount, 2, '.', ',');
                                }

                                if ($paymentDomData[$keyDom]->payment_amount < $value->debt_amount) {
                                    $item->statusAmount = 1;
                                }else{
                                    $item->statusAmount = 2;
                                }

                            }else{
                                $item->statusAmount = 1;
                            }
                        }
                    }
                }
            }

            // if ($item->credit_amount != 0) {
            //     if ($item->credit_amount == $item->sumamount) {
            //         $item->statusAmount = 2;
            //     } else {
            //         if($item->sumamount == null && $item->cash_amount > 0){
            //             $item->statusAmount = 1;
            //         }
            //         // else if ($item->delivery_date < $outstandingDueDate) {
            //         //     $item->statusAmount = 0;
            //         // }
            //         else {
            //             $item->statusAmount = 1;
            //         }
            //     }
            // } else {
            //     if (($item->cash_amount <= $item->sumamount) && $item->sumamount != 0 || ($item->pick_release_status == 'Confirm' && $item->statusAmount == 2)) {
            //         $item->statusAmount = 2;
            //     } else {
            //         $item->statusAmount = 1;
            //     }
            // }

            // เช็คขอคืนวงเงินเชื่อ
            // $releaseData = ReleaseCredit::where('payment_flag', 'Y')->where('customer_id', $item->customer_id)->get();
            // if (!$releaseData->isEmpty()) {
            //     foreach ($releaseData as $reItem) {
            //         $outstandingCheck = DB::table('ptom_outstanding_debt_dom_v')
            //             ->where('credit_group_code', $reItem->credit_group_code)
            //             ->where(function($query) use($reItem) {
            //                     $query->where('consignment_no', $reItem->invoice_num);
            //                     $query->orWhere('pick_release_no', $reItem->invoice_num);
            //             })->get();

            //         if (!$outstandingCheck->isEmpty()) {
            //             $item->statusAmount = 1;
            //         }
            //     }
            // }

            // if (!empty($item->pick_release_no)) {
            //     $osdDueDate    = DB::table('ptom_outstanding_debt_dom_v')->where('customer_id', $item->customer_id)->where('pick_release_no', $item->pick_release_no)->first();

            //     if (!empty($osdDueDate->due_date)) {
            //         if ($item->credit_amount == $item->sumamount) {
            //             $item->statusAmount = 2;
            //         }else {
            //             $item->statusAmount = 1;
            //         }
            //     }

            // }

            if (empty($item->prepare_order_number)) {
                $item->prepare_order_number = '';
                $item->invoice_no           = '';
            }else{
                $paymentHeaderID    = PaymentMatchInvoices::where('prepare_order_number', $item->prepare_order_number)->whereNull('deleted_at')->pluck('payment_header_id')->first();
                $getInvoiceNo       = PaymentHeaders::where('payment_header_id', $paymentHeaderID)->pluck('payment_number')->first();
                $item->invoice_no   = !empty($getInvoiceNo) ? $getInvoiceNo : '';
            }

            if (empty($item->pick_release_no)) {
                $item->pick_release_no = '';
            }

            if (empty($item->pick_release_status)) {
                $item->pick_release_status = '';
            }

            if (!empty($item->delivery_date)) {
                $item->delivery_date = dateFormatThaiString($item->delivery_date);
            }else{
                $item->delivery_date = '';
            }

            if (!empty($item->cash_amount)) {
                $item->cash_amount = number_format($item->cash_amount,2);
            }else{
                $item->cash_amount = '0.00';
            }

            if (!empty($item->credit_amount)) {
                $item->credit_amount = number_format($item->credit_amount,2);
            }else{
                $item->credit_amount = '0.00';
            }

            if (!empty($item->grand_total)) {
                $item->grand_total = number_format($item->grand_total,2);
            }else{
                $item->grand_total = '0.00';
            }

            $additionQuotar = DB::table('ptom_addition_quota_headers')->where('order_header_id', $item->order_header_id)->where('approve_status', 'อนุมัติ')->whereNull('deleted_at')->first();

            if (!empty($additionQuotar->approve_status)) {
                $item->addition_approve_status = 'Y';
            }else{
                $item->addition_approve_status = 'N';
            }

            // Check Payment before
            $dataCheckPayment = OrderHeaders::where('customer_id', $item->customer_id)->where('order_header_id', '<=', $item->order_header_id)->whereNull('deleted_at')->orderBy('order_header_id', 'desc')->limit(2)->get();

            $item->payment_before_status = 'Y';

            if (!empty($dataCheckPayment[1])) {

                $dataOrder = $dataCheckPayment[1];

                $paymentAmount = DB::table('ptom_payment_match_invoices')->where('prepare_order_number', $dataOrder->prepare_order_number)->where('match_flag', 'Y')->whereNull('deleted_at')->sum('payment_amount');

                $orderPaymentAmount = (float)$dataOrder->cash_amount + (float)$dataOrder->credit_amount;

                if ($paymentAmount <= $orderPaymentAmount) {

                    $checkDayAmount = 0;

                    // ดึงข้อมูลการค้างชำระ กรณี อื่นๆ
                    $selectColumnes = ['day_amount', 'credit_group_code'];
                    $dataCreditGroup = OrderLines::select($selectColumnes)->where('order_header_id', $dataOrder->order_header_id)->whereNull('deleted_at')->whereNull('promo_flag')->groupBy($selectColumnes)->get();

                    if (!$dataCreditGroup->isEmpty()) {
                        foreach ($dataCreditGroup as $crItem) {

                                // ดึงข้อมูล Day amount จาก TermV กรณี เป็นเงินสด
                            if (($item->customer_type_id == 30 || $item->customer_type_id == 40) && $item->product_type_code == 10) {
                                if (trim($crItem->credit_group_code) == 0) {
                                    $dueDaysConsignment = Terms::where('credit_group_code', 0)
                                                                ->where('sale_type', 'DOMESTIC')
                                                                ->whereRaw("nvl(start_date_active,sysdate+1) < sysdate")
                                                                ->whereRaw("nvl(end_date_active,sysdate+1) > sysdate")
                                                                ->pluck('due_days_consignment')->first();

                                    $crItem->day_amount = !empty($dueDaysConsignment) ? $dueDaysConsignment : trim($crItem->day_amount);
                                }
                            }

                            if ($item->customer_type_id == 30 && $item->product_type_code == 10)
                            {
                                // ดึงข้อมูลการค้างชำระ กรณี ลูกค้าสโมรกรุงเทพ
                                $consignmentData  = ConsignmentHeader::where('order_header_id', $dataOrder->order_header_id)->where('consignment_status', 'Confirm')->whereNull('deleted_at')->get();

                                $sumConsigment      = 0.00;
                                $sumPayment         = 0.00;
                                $sumInvoiceLine     = 0.00;
                                $totalPaymentCNDN   = 0.00;
                                if (!empty($consignmentData)) {
                                    foreach ($consignmentData as $consItem) {
                                        // SUM TOTAL AMOUNT FROM CONSIGNMENT
                                        $sumConsigment = $sumConsigment + (!empty($consItem->total_amount) ? $consItem->total_amount : 0);

                                        // SUM PAYMENT_AMOUNT FROM PAYMENT MATCH INVOICES
                                        $paymentMatchInvoice = PaymentMatchInvoices::where('invoice_number', $consItem->consignment_no)->where('match_flag', 'Y')->whereNull('deleted_at')->get();

                                        if (!$paymentMatchInvoice->isEmpty()) {
                                            foreach ($paymentMatchInvoice as $matchItem) {
                                                $sumPayment = $sumPayment + (!empty($matchItem->payment_amount) ? (float)$matchItem->payment_amount : 0);

                                                $paymentCNDN         = PaymentApplyCNDN::join('ptom_payment_match_invoices', 'ptom_payment_apply_cndn.payment_match_id', '=', 'ptom_payment_match_invoices.payment_match_id')
                                                                                ->where('ptom_payment_match_invoices.payment_match_id', $matchItem->payment_match_id)
                                                                                ->sum('ptom_payment_apply_cndn.invoice_amount');

                                                $totalPaymentCNDN   = $totalPaymentCNDN + (float)$paymentCNDN;
                                            }
                                        }

                                    }
                                }

                                $sumInvoiceLine         = InvoiceLines::join('ptom_invoice_headers', 'ptom_invoice_lines.invoice_headers_id', '=', 'ptom_invoice_headers.invoice_headers_id')
                                                                        ->where('ptom_invoice_lines.document_id', $dataOrder->order_header_id)
                                                                        ->where('ptom_invoice_headers.invoice_type', 'CN_OTHER')
                                                                        ->sum('payment_amount');

                                $resultPayment  = (float)$sumPayment + (float)$totalPaymentCNDN + (float)$sumInvoiceLine;

                                if ((float)$sumConsigment != $resultPayment) {
                                    $checkDayAmount = 1;
                                }
                            }
                            else if ($item->customer_type_id == 40 && $item->product_type_code == 10)
                            {
                                $grandTotal     = !empty($dataOrder->grand_total) ? (float)$dataOrder->grand_total : 0.00;

                                // ดึงข้อมูลการค้างชำระ กรณี ลูกค้าสโมรภูมิภาค
                                $consignmentData  = ConsignmentHeader::where('order_header_id', $dataOrder->order_header_id)->where('consignment_status', 'Confirm')->whereNull('deleted_at')->get();

                                $sumConsigment      = 0.00;
                                $sumPayment         = 0.00;
                                $sumInvoiceLine     = 0.00;
                                $totalPaymentCNDN   = 0.00;
                                if (!empty($consignmentData)) {
                                    foreach ($consignmentData as $consItem) {

                                        $sumInvoiceLine1    = InvoiceLines::join('ptom_invoice_headers', 'ptom_invoice_lines.invoice_headers_id', '=', 'ptom_invoice_headers.invoice_headers_id')
                                                                        ->where('ptom_invoice_lines.document_id', $consItem->consignment_header_id)
                                                                        ->where('ptom_invoice_headers.invoice_type', 'CN_TRANFER')
                                                                        ->sum('payment_amount');

                                        $sumInvoiceLine2    = InvoiceLines::join('ptom_invoice_headers', 'ptom_invoice_lines.invoice_headers_id', '=', 'ptom_invoice_headers.invoice_headers_id')
                                                                        ->where('ptom_invoice_lines.document_id', $consItem->consignment_header_id)
                                                                        ->where('ptom_invoice_headers.invoice_type', 'CN_OTHER')
                                                                        ->sum('payment_amount');

                                        $sumInvoiceLine     = $sumInvoiceLine + (float)$sumInvoiceLine1 + (float)$sumInvoiceLine2;

                                        // SUM TOTAL AMOUNT FROM CONSIGNMENT
                                        $sumConsigment = $sumConsigment + (!empty($consItem->total_amount) ? $consItem->total_amount : 0);

                                        // SUM PAYMENT_AMOUNT FROM PAYMENT MATCH INVOICES
                                        $paymentMatchInvoice = PaymentMatchInvoices::where('invoice_number', $consItem->consignment_no)->where('match_flag', 'Y')->whereNull('deleted_at')->get();

                                        if (!$paymentMatchInvoice->isEmpty()) {
                                            foreach ($paymentMatchInvoice as $matchItem) {
                                                $sumPayment = $sumPayment + (!empty($matchItem->payment_amount) ? (float)$matchItem->payment_amount : 0);

                                                $paymentCNDN         = PaymentApplyCNDN::join('ptom_payment_match_invoices', 'ptom_payment_apply_cndn.payment_match_id', '=', 'ptom_payment_match_invoices.payment_match_id')
                                                                                ->where('ptom_payment_match_invoices.payment_match_id', $matchItem->payment_match_id)
                                                                                ->sum('ptom_payment_apply_cndn.invoice_amount');

                                                $totalPaymentCNDN   = $totalPaymentCNDN + (float)$paymentCNDN;
                                            }
                                        }
                                    }
                                }

                                $resultPayment  = (float)$sumPayment + (float)$sumInvoiceLine + (float)$totalPaymentCNDN;

                                if ($grandTotal != $resultPayment) {
                                    $checkDayAmount = 1;
                                }


                            }
                            else{
                                // ตรวจสอบการค้างชำระ
                                $sumCreditGroupAmount   = OrderCreditGroup::where('order_header_id', $dataOrder->order_header_id)->where('order_line_id', 0)->where('credit_group_code', $crItem->credit_group_code)->whereNull('deleted_at')->sum('amount');

                                $PaymentMatchInvoice = PaymentMatchInvoices::where('prepare_order_number', $dataOrder->prepare_order_number)->where('match_flag', 'Y')->where('credit_group_code', $crItem->credit_group_code)->whereNull('deleted_at')->get();

                                $sumPaymentMatchInvoice = 0.00;
                                $totalPaymentCNDN       = 0.00;
                                if (!empty($PaymentMatchInvoice)) {
                                    foreach ($PaymentMatchInvoice as $matchItem) {
                                        $sumPaymentMatchInvoice = $sumPaymentMatchInvoice + (float)$matchItem->payment_amount;
                                        $sumPaymentCNDN         = PaymentApplyCNDN::join('ptom_payment_match_invoices', 'ptom_payment_apply_cndn.payment_match_id', '=', 'ptom_payment_match_invoices.payment_match_id')
                                                                                ->where('ptom_payment_match_invoices.payment_match_id', $matchItem->payment_match_id)
                                                                                ->sum('ptom_payment_apply_cndn.invoice_amount');

                                        $totalPaymentCNDN   = $totalPaymentCNDN + (float)$sumPaymentCNDN;
                                    }
                                }

                                $sumInvoiceLine         = InvoiceLines::join('ptom_invoice_headers', 'ptom_invoice_lines.invoice_headers_id', '=', 'ptom_invoice_headers.invoice_headers_id')
                                                                        ->where('ptom_invoice_lines.document_id', $dataOrder->order_header_id)
                                                                        ->where('ptom_invoice_headers.invoice_type', 'CN_OTHER')
                                                                        ->sum('payment_amount');

                                $resultPayment  = (float)$sumPaymentMatchInvoice + (float)$totalPaymentCNDN + (float)$sumInvoiceLine;

                                if ((float)$sumCreditGroupAmount != $resultPayment ) {
                                    $checkDayAmount = 1;
                                }
                            }

                            if ($checkDayAmount == 1) {
                                // ตรวจสอบวันครบกำหนดชำระ
                                $dueDate1 = !empty($dataOrder->pick_release_approve_date) ? $dataOrder->pick_release_approve_date : (!empty($dataOrder->delivery_date) ? $dataOrder->delivery_date : 0);

                                $dateFirst = removeTimeOnDate($dueDate1);

                                if ($crItem->day_amount <= 0) {
                                    $date1=date_create($dateFirst);     // วันครบกำหนดชำระ
                                }else{
                                    $dayAmount  = date('Y-m-d', strtotime("+".$crItem->day_amount." day", strtotime($dateFirst)));
                                    $date1      = date_create($dayAmount);      // วันครบกำหนดชำระ
                                }

                                // $date1=date_create(date('2021-11-28'));
                                $date2=date_create(date('Y-m-d'));     // วันปัจจุบัน
                                $diff=date_diff($date2,$date1);
                                $resultDay = $diff->format("%r%a");

                                if ($resultDay <= 0) {
                                    $item->payment_before_status = 'N';
                                }
                            }
                        }
                    }

                }
            }

            $this->updateRemainingAmount($item->customer_id);

            // S = ชำระเงินแล้ว
            // Y =

            // if ($item->pick_release_status == 'Confirm') {
            //     $outstandingQuery = DB::table('ptom_outstanding_debt_dom_v')->where('order_header_id', $item->order_header_id)->get();

            //     if ($outstandingQuery->isEmpty()) {
            //         $item->standing_debt_status = 'S';
            //     }else{
            //         $outStanding    = DB::table('ptom_outstanding_debt_dom_v')->where('customer_id', $item->customer_id)->where('order_header_id', $item->order_header_id)->whereRaw("nvl(due_date,sysdate+1) <= sysdate")->first();

            //         if (!empty($outStanding)) {
            //             $item->standing_debt_status = 'Y';
            //         }else{
            //             $item->standing_debt_status = 'W';
            //         }
            //     }

            // }else{
            //     $outStanding    = DB::table('ptom_outstanding_debt_dom_v')->where('customer_id', $item->customer_id)->whereRaw("nvl(due_date,sysdate+1) <= sysdate")->first();

            //     if (!empty($outStanding)) {
            //         $item->standing_debt_status = 'Y';
            //     }else{
            //         $item->standing_debt_status = 'N';
            //     }
            // }
        }

        $rest = [
            'status'    => 'success',
            'data'      => $order
        ];

        return response()->json(['data'=>$rest]);
    }

    public function getPaymentState($customerID, $orderHeadersId)
    {

            $rest = [];
            $outstandingData = [];

            $penaltyRate = PenaltyRateDomesticV::where('enabled_flag','Y')->first();
            if(is_null($penaltyRate)){
                $amountPenaltyRate = 0;
            }else{
                $amountPenaltyRate = $penaltyRate->description;
            }

            $daysInYear = Carbon::parse(date('Y'))->daysInYear;

            // Duplicate STEP 1 AND 2
            $orderData = OrderHeaders::where('order_header_id', $orderHeadersId)->first();
            $PeriodID = OrderHeaders::select('period_id')->where('order_header_id', $orderHeadersId)->pluck('period_id')->first();
            $productTypeCode = OrderHeaders::select('product_type_code')->where('order_header_id', $orderHeadersId)->pluck('product_type_code')->first();
           
            $customerTypeID = DB::table('ptom_customers')->select('customer_type_id')->where('customer_id', $customerID)->pluck('customer_type_id')->first();
            $PeriodData = DB::table('ptom_period_v')->where('period_line_id', $PeriodID)->first();
            if(!empty($PeriodData)){
                $pickReleaseStatus = OrderHeader::select('pick_release_status')->where('order_header_id', $orderHeadersId)->pluck('pick_release_status')->first();
                
                if($pickReleaseStatus == 'Confirm'){
                    $debtDomData = DB::table('ptom_debt_dom_v')
                                    ->where('product_type_code', $orderData->product_type_code)
                                    ->where('customer_id', $customerID)
                                    // ->where('outstanding_debt', '>', 0)
                                    ->whereBetween('due_date', [$PeriodData->start_period, $PeriodData->end_period])
                                    ->orderBy('due_date', 'ASC')
                                    ->orderBy('pick_release_no', 'ASC')
                                    ->orderBy('consignment_no', 'ASC')
                                    ->get();
                    if (count($debtDomData) > 0) {
                        foreach ($debtDomData as $key => $value) {

                            if (($customerTypeID == 30 || $customerTypeID == 40) && $productTypeCode == 10 ) {
                                $paymentDomData = DB::table('ptom_payment_dom_v')->where('invoice_number', $value->consignment_no)->where('customer_id', $customerID)->where('credit_group_code', $value->credit_group_code)->get();
                            } else {
                                $paymentDomData = DB::table('ptom_payment_dom_v')->where('prepare_order_number', $value->prepare_order_number)->where('customer_id', $customerID)->where('credit_group_code', $value->credit_group_code)->get();
                            }
                            $paymentStatus = true;

                            if (count($paymentDomData) > 0) {
                                foreach ($paymentDomData as $keyDom => $itemDom) {
                                    $paymentDomData[$keyDom]->payment_date      = dateFormatThaiString($itemDom->payment_date);
                                    $paymentDomData[$keyDom]->payment_amount    = number_format($itemDom->payment_amount, 2, '.', ',');
                                    $paymentDomData[$keyDom]->payment_amount_num    = $itemDom->payment_amount? str_replace(',', '', $itemDom->payment_amount): 0;
                                }

                                $osDueDate = date('Y-m-d', strtotime($value->due_date));
                                $osStartPeriod = date('Y-m-d', strtotime($PeriodData->start_period));
                                $osEndPeriod = date('Y-m-d', strtotime($PeriodData->end_period));

                                if (($osDueDate >= $osStartPeriod) && ($osDueDate <= $osEndPeriod)){
                                    $paymentStatus = true;
                                }else{
                                    $paymentStatus = false;
                                }
                            }

                            if ($paymentStatus == true) {
                                $outstandingData[] = [
                                    'payment_prepare_num'   => $value->prepare_order_number,
                                    'payment_release_no'    => (($customerTypeID == 30 || $customerTypeID == 40) && $productTypeCode == 10 ) ? $value->consignment_no : $value->pick_release_no,
                                    'payment_credit_group'  => $value->credit_group_code == 0 ? 'เงินสด' : $value->credit_group_code,
                                    'payment_amount'        => !empty($value->debt_amount) ? number_format((float)$value->debt_amount, 2, '.', ',') : 0.00,
                                    'payment_fine'          => 0.00,
                                    'payment_due_date'      => dateFormatThaiString($value->due_date),
                                    'payment_invoice_no'    => '',
                                    'payment_date'          => '',
                                    'payment_pay_amount'    => '',
                                    'payment_dom_data'      => $paymentDomData,
                                    'count_payment_dom'     => count($paymentDomData),
                                    'cn_amount'             => !empty($value->cn_amount) ? number_format((float)$value->cn_amount, 2, '.', ',') : 0.00,
                                ];
                            }
                        }

                    }
                }else{
                    $debtDomData = DB::table('ptom_debt_dom_v')
                                    ->where('customer_id', $customerID)
                                    ->where('product_type_code', $orderData->product_type_code)
                                    // ->where('outstanding_debt', '>', 0)
                                    // ->where('due_date', '<=' , $PeriodData->end_period)
                                    ->where(function($q) use ($PeriodData) {
                                        $q->where(function($subQ) use ($PeriodData){
                                             $subQ->where('outstanding_debt', '>', 0)
                                             ->where('due_date', '<=' , $PeriodData->end_period);
                                        });
                                        $q->orWhere(function($subQ) use($PeriodData) {
                                            $subQ->whereBetween('due_date', [$PeriodData->start_period, $PeriodData->end_period]);
                                        });
                                    })
                                    // ->whereBetween('due_date', [$PeriodData->start_period, $PeriodData->end_period])
                                    ->orderBy('due_date', 'ASC')
                                    ->orderBy('pick_release_no', 'ASC')
                                    ->orderBy('consignment_no', 'ASC')
                                    ->get();
                    if (count($debtDomData) > 0) {
                        foreach ($debtDomData as $key => $value) {
                            if ($customerTypeID == 30 && $productTypeCode == 10 ) {
                                $paymentDomData = DB::table('ptom_payment_dom_v')->where('invoice_number', $value->consignment_no)->where('customer_id', $customerID)->where('credit_group_code', $value->credit_group_code)->get();
                            } else {
                                $paymentDomData = DB::table('ptom_payment_dom_v')->where('prepare_order_number', $value->prepare_order_number)->where('customer_id', $customerID)->where('credit_group_code', $value->credit_group_code)->get();
                            }
                            $paymentStatus = true;

                            if (count($paymentDomData) > 0 ) {
                                foreach ($paymentDomData as $keyDom => $itemDom) {
                                    $paymentDomData[$keyDom]->payment_date      = dateFormatThaiString($itemDom->payment_date);

                                    if ($paymentDomData[$keyDom]->payment_amount < $value->debt_amount) {
                                        $paymentStatus = true;
                                    }else{
                                        $paymentStatus = true;
                                        // $paymentStatus = false;
                                    }
                                    $paymentDomData[$keyDom]->payment_amount    = number_format($itemDom->payment_amount, 2, '.', ',');
                                }

                            }
                            if ($paymentStatus == true) {
                                $outstandingData[] = [
                                    'payment_prepare_num'   => $value->prepare_order_number,
                                    'payment_release_no'    => in_array($customerTypeID, [30, 40]) ? $value->consignment_no : $value->pick_release_no,
                                    'payment_credit_group'  => $value->credit_group_code == 0 ? 'เงินสด' : 'เงินเชื่อกลุ่ม '.$value->credit_group_code,
                                    'payment_amount'        => !empty($value->debt_amount) ? number_format((float)$value->debt_amount, 2, '.', ',') : 0.00,
                                    'payment_fine'          => 0.00,
                                    'payment_due_date'      => dateFormatThaiString($value->due_date),
                                    'payment_invoice_no'    => '',
                                    'payment_date'          => '',
                                    'payment_pay_amount'    => '',
                                    'payment_dom_data'      => $paymentDomData,
                                    'count_payment_dom'     => count($paymentDomData),
                                    'cn_amount'             => !empty($value->cn_amount) ? number_format((float)$value->cn_amount, 2, '.', ',') : 0.00,
                                ];
                            }
                        }
                    }
                }
            }
            // END DUPLICATE STEP 1 AND 2

            // STEP 3
            $releaseCreditQuery = ReleaseCredit::where('payment_flag', 'Y')->where('customer_id', $customerID)->where('attribute1', $orderHeadersId)->get();
            $releaseCreditQuery = ReleaseCredit::whereNotIn('invoice_id', $debtDomData->pluck('order_header_id')->toArray())->where('payment_flag', 'Y')->where('customer_id', $customerID)->where('attribute1', $orderHeadersId)->get();
            // echo '<pre>';
            // print_r($releaseCreditQuery);
            // echo '</pre>';
            // exit();

            if (!empty($releaseCreditQuery)) {
                foreach ($releaseCreditQuery as $key => $value) {
                    $outstandingDebt = DB::table('ptom_debt_dom_v')->where('pick_release_no', $value->invoice_num)->first();
                    if (!empty($outstandingDebt)) {
                        
                        // ค่าปรับ
                        $date = Carbon::parse($value->due_date);
                        $now = Carbon::parse(now());

                        if($date >= $now){
                            $diff = 0;
                        }else{
                            $diff = $date->diffInDays($now);
                        }

                        $penalty_total = 0;
                        $outstanding_debt = $outstandingDebt->debt_amount;
                        $sum_payment_amount = 0;

                        $improveStatus = DB::table('ptom_improve_fines')->where('invoice_number', $value->invoice_num)->first();

                        if (!empty($improveStatus)) {
                            if (empty($improveStatus->cancel_flag) || $improveStatus->cancel_flag != 'Y') {
                                for ($i=0; $i < $diff; $i++) {

                                    if (!empty($outstandingDebt->prepare_order_number)) {
                                        $payment_amount = DB::table('ptom_payment_match_invoices')
                                        ->where('prepare_order_number',$outstandingDebt->prepare_order_number)
                                        ->where('credit_group_code',$outstandingDebt->credit_group_code)
                                        ->whereDate('creation_date',$date->addDays(1)->format('Y-m-d'))
                                        ->where('match_flag','Y')
                                        ->whereNull('deleted_at')->sum('payment_amount');
                                    }else {
                                        $payment_amount = 0;
                                    }
                                    $outstanding_debt -= $payment_amount;
                                    $sum_payment_amount += $payment_amount;

                                    $penalty_total += (($outstanding_debt * $amountPenaltyRate) / 100) / $daysInYear;

                                }
                            }

                        }

                        if ($outstandingDebt->product_type_code == 10 && ( $outstandingDebt->customer_type_id == 30 || $outstandingDebt->customer_type_id == 40 )) {
                            $paymentReleaseNo = $outstandingDebt->consignment_no;
                        }else{
                            $paymentReleaseNo = $outstandingDebt->pick_release_no;
                        }

                        $prePareNumber = DB::table('ptom_debt_dom_v')->where('pick_release_no', $value->invoice_num)->where('credit_group_code', $value->credit_group_code)->pluck('prepare_order_number')->first();

                        // $prePareNumber = OrderHeaders::where('order_header_id', $orderHeadersId)->pluck('prepare_order_number')->first();

                        // เลขที่ใบเสร็จรับเงิน && วันที่รับชำระเงิน
                        $paymentHeaderID = DB::table('ptom_payment_match_invoices')->select('payment_header_id')->where('prepare_order_number', $prePareNumber)->where('match_flag', 'Y')->where('payment_amount', '>', 0)->pluck('payment_header_id')->first();
                        $invoiceNo = '';
                        $paymentDate = '';
                        $paymentPayAmount = 0;
                        if (!empty($paymentHeaderID)) {
                            $paymentHeaderQuery = DB::table('ptom_payment_headers')->where('payment_header_id', $paymentHeaderID)->first();

                            if (!empty($paymentHeaderQuery)) {
                                $invoiceNo = $paymentHeaderQuery->payment_number;
                                $paymentDate = !empty($paymentHeaderQuery->payment_date) ? dateFormatThai($paymentHeaderQuery->payment_date) : '';
                                $paymentPayAmount = !empty($paymentHeaderQuery->payment_amount) ? number_format((float)$paymentHeaderQuery->payment_amount, 2, '.', '') : 0;
                            }
                        }

                        // echo 'Pyament Date : '.$paymentDate;
                        // echo '<pre>';

                        if ($invoiceNo == '') {
                            $cndnQuery = DB::table('ptom_payment_apply_cndn')->where('order_header_id', $orderHeadersId)->where('attribute1', 'Y')->where('credit_group_code', $value->credit_group_code)->first();
                            if (!empty($cndnQuery)) {
                                $invoiceNo = $cndnQuery->invoice_number;
                                $paymentDate = !empty($cndnQuery->last_update_date) ? dateFormatThai($cndnQuery->last_update_date) : '';
                                $paymentPayAmount = !empty($cndnQuery->invoice_amount) ? number_format((float)$cndnQuery->invoice_amount, 2, '.', '') : 0;
                            }
                        }

                        $sumAmountData = $value->amount;
                        if ($sumAmountData != $paymentPayAmount) {
                            $paymentFineData = !empty($penalty_total) ? number_format((float)$penalty_total, 2, '.', ',') : 0;
                        } else {
                            $paymentFineData = number_format(0, 2, '.', ',');
                        }

                        // echo 'Invoice Date : '.$paymentDate;
                        // exit();

                        $customerTypeID = DB::table('ptom_customers')->select('customer_type_id')->where('customer_id', $customerID)->pluck('customer_type_id')->first();
                        $productTypeCode = OrderHeaders::select('product_type_code')->where('order_header_id', $orderHeadersId)->pluck('product_type_code')->first();

                        if ($customerTypeID == 30 && $productTypeCode == 10) {
                            $paymentDomData = DB::table('ptom_payment_dom_v')->where('invoice_number', $value->invoice_num)->where('customer_id', $customerID)->where('credit_group_code', $value->credit_group_code)->get();
                        } else {
                            $paymentDomData = DB::table('ptom_payment_dom_v')->where('prepare_order_number', $prePareNumber)->where('customer_id', $customerID)->where('credit_group_code', $value->credit_group_code)->get();
                        }

                        if (!empty($paymentDomData)) {
                            foreach ($paymentDomData as $keyDom => $itemDom) {
                                $paymentDomData[$keyDom]->payment_date      = dateFormatThaiString($itemDom->payment_date);
                                $paymentDomData[$keyDom]->payment_amount    = number_format($itemDom->payment_amount, 2, '.', ',');
                            }
                        }

                        // if ($itemDom->debt_amount > 0) {
                            $outstandingData[] = [
                                'payment_prepare_num'   => !empty($prePareNumber) ? $prePareNumber : '',
                                'payment_release_no'    => $value->invoice_num ,
                                'payment_credit_group'  => $value->credit_group_code == 0 ? 'เงินสด' : 'เงินเชื่อกลุ่ม '.$value->credit_group_code,
                                'payment_amount'        => number_format($outstanding_debt, 2, '.', ','),
                                'payment_fine'          => $value->invoice_num != '' ? $paymentFineData : 0.00,
                                'payment_due_date'      => dateFormatThaiString($value->due_date),
                                'payment_invoice_no'    => '',
                                'payment_date'          => '',
                                'payment_pay_amount'    => '',
                                'payment_dom_data'      => $paymentDomData,
                                'count_payment_dom'     => count($paymentDomData),
                                'cn_amount'             => 0.00,

                            ];
                        // }
                    }
                }
            }
            // check duplicate data 
            $outstandingData = collect($outstandingData)->unique(function($item) {
                return $item['payment_prepare_num'].$item['payment_release_no'].$item['payment_credit_group'];
            });
            // dd(collect($outstandingData));

            $rest = [
                'status'    => 'success',
                'data'      => $outstandingData
            ];

            return response()->json(['data'=>$rest]);
    }

    public function getPaymentState_bak($customerID, $orderHeadersId)
    {
        // $dataOverDue =OrderRepo::setOutstanding($customerID);

            // echo '<pre>';
            // print_r($dataOverDue);
            // echo '</pre>';
            // exit();

            // หนี้ค้างชำระ
            // if (!empty($dataOverDue)) {
            //     foreach ($dataOverDue as $key => $itemDept) {
            //         $dataPay[] = [
            //             'status_due_date'       => $itemDept['flag'] == 'Y' ? 'check' : '',
            //             'payment_prepare_num'   => '',
            //             'payment_release_no'    => $itemDept['pick_release_no'],
            //             'payment_credit_group'  => $itemDept['credit_group_code'] == 0 ? 'เงินสด' : $itemDept['description'],
            //             'payment_amount'        => $itemDept['amount'],
            //             'payment_fine'          => $itemDept['penalty_total'],
            //             'payment_due_date'      => $itemDept['due_date'],
            //             'payment_invoice_no'    => '',
            //             'payment_date'          => '',
            //             'payment_pay_amount'    => $itemDept['payment_amount'],
            //         ];
            //     }
            // }else{
            //     $dataPay = [];
            // }

            // $rest = [
            //     'status'    => 'success',
            //     'data'      => $dataPay
            // ];

            $rest = [];
            $outstandingData = [];

            $penaltyRate = PenaltyRateDomesticV::where('enabled_flag','Y')->first();
            if(is_null($penaltyRate)){
                $amountPenaltyRate = 0;
            }else{
                $amountPenaltyRate = $penaltyRate->description;
            }

            $daysInYear = Carbon::parse(date('Y'))->daysInYear;


            // STEP 1

            $outstandingQuery = DB::table('ptom_outstanding_debt_dom_v')
                                ->where('customer_id', $customerID)
                                ->where('outstanding_debt','>',0)
                                ->where(function ($query) use($orderHeadersId) {
                                    $query->where('order_header_id','!=', $orderHeadersId);
                                    $query->orWhereNull('order_header_id');
                                })
                                ->whereRaw("nvl(due_date,sysdate+1) <= sysdate")->get();

             if (!empty($outstandingQuery)) {
                foreach ($outstandingQuery as $key => $item) {

                    $releaseCredit = ReleaseCredit::where('invoice_id',$item->order_header_id)->where('customer_id',$customerID)->where('credit_group_code',$item->credit_group_code)->first();

                    // // ค่าปรับ
                    $date = Carbon::parse($item->due_date);
                    $now = Carbon::parse(now());

                    if($date >= $now){
                        $diff = 0;
                    }else{
                        $diff = $date->diffInDays($now);
                    }

                    if ($item->product_type_code == 10 && ( $item->customer_type_id == 30 || $item->customer_type_id == 40 )) {
                        $paymentReleaseNo = $item->consignment_no;
                    }else{
                        $paymentReleaseNo = $item->pick_release_no;
                    }


                    $penalty_total = 0;
                    $outstanding_debt = $item->outstanding_debt;
                    $sum_payment_amount = 0;

                    $improveStatus = DB::table('ptom_improve_fines')->where('invoice_number', $paymentReleaseNo)->pluck('cancel_flag')->first();

                    $calculateImprove = true;
                    if (!empty($improveStatus)) {
                        if ($improveStatus != 'Y') {
                            $calculateImprove = false;
                        }
                    }

                    if($calculateImprove == true){
                        for ($i=0; $i < $diff; $i++) {
                            if (!empty($item->prepare_order_number)) {
                                $payment_amount = DB::table('ptom_payment_match_invoices')
                                ->where('prepare_order_number',$item->prepare_order_number)
                                ->where('credit_group_code',$item->credit_group_code)
                                ->whereDate('creation_date',$date->addDays(1)->format('Y-m-d'))
                                ->where('match_flag','Y')
                                ->whereNull('deleted_at')->sum('payment_amount');
                            }else {
                                $payment_amount = 0;
                            }

                            $outstanding_debt -= $payment_amount;
                            $sum_payment_amount += $payment_amount;

                            $penalty_total += (($outstanding_debt * $amountPenaltyRate) / 100) / $daysInYear;

                        }

                        $penalty_total = $penalty_total >= 0 ? $penalty_total : 0;
                    }

                    $outstandingData[] = [
                        'payment_prepare_num'   => $item->prepare_order_number,
                        'payment_release_no'    => $paymentReleaseNo,
                        'payment_credit_group'  => $item->credit_group_code == 0 ? 'เงินสด' : 'เงินเชื่อกลุ่ม '.$item->credit_group_code,
                        'payment_amount'        => $item->outstanding_debt,
                        'payment_fine'          => $paymentReleaseNo != '' ? (!empty($releaseCredit) ? number_format((float)$releaseCredit->charge_amount, 2, '.', '') : (!empty($penalty_total) ? number_format((float)$penalty_total, 2, '.', '') : 0)) : 0.00,
                        'payment_due_date'      => dateFormatThai($item->due_date),
                        'payment_invoice_no'    => '',
                        'payment_date'          => '',
                        'payment_pay_amount'    => '',
                    ];
                }
            }

            // STEP 2

            $orderHeadersQuery = OrderHeaders::join('ptom_customers', 'ptom_customers.customer_id', '=', 'ptom_order_headers.customer_id')
                                            ->select('ptom_order_headers.*', 'ptom_customers.customer_type_id')
                                            ->where('ptom_order_headers.order_header_id', $orderHeadersId)
                                            ->whereNull('ptom_order_headers.deleted_at')
                                            ->first();

            if (!empty($orderHeadersQuery)) {

                // $getOrderLinesQuery = OrderLines::select('credit_group_code')->where('order_header_id', $orderHeadersId)->whereNull('deleted_at')->whereNotNull('credit_group_code')->groupBy('credit_group_code')->get();
                $getOrderLinesQuery = DB::table('ptom_order_credit_groups')->select('credit_group_code', 'amount')->where('order_header_id', $orderHeadersId)->where('order_line_id', 0)->where('amount', '>', 0)->whereNull('deleted_at')->whereNotNull('credit_group_code')->get();

                // echo '<pre>';
                // print_r($getOrderLinesQuery);
                // echo '</pre>';
                // exit();

                if (!empty($getOrderLinesQuery)) {
                    foreach ($getOrderLinesQuery as $key => $value) {

                        $sumAmount = $value->amount;

                        $releaseCredit = ReleaseCredit::where('invoice_id',$orderHeadersId)->where('customer_id',$customerID)->where('credit_group_code',$value->credit_group_code)->first();

                        // ค่าปรับ
                        $dueDate = $orderHeadersQuery->delivery_date;

                        if ($orderHeadersQuery->customer_type_id == 30 || $orderHeadersQuery->customer_type_id == 40 ) {
                            if ($orderHeadersQuery->product_type_code == 10) {
                                if ($orderHeadersQuery->customer_type_id == 30) {
                                    $dueDate = '';
                                }else {
                                    $dayAmount = DB::table('ptom_terms_v')->select('due_days_consignment')->where('credit_group_code', $value->credit_group_code)->pluck('due_days_consignment')->first();
                                    $dayAmount = !empty($dayAmount) ? $dayAmount : 0;

                                    // if($value->credit_group_code != 0){
                                        $dueDate = Date('Y-m-d H:i:s', strtotime("+".$dayAmount." day", strtotime($dueDate)));
                                    // }
                                }

                            }else{
                                $dayAmount = DB::table('ptom_customer_contract_groups')->select('day_amount')->where('customer_id', $customerID)->where('credit_group_code', $value->credit_group_code)->pluck('day_amount')->first();

                                if($value->credit_group_code != 0){
                                    $dueDate = Date('Y-m-d H:i:s', strtotime("+".$dayAmount." day", strtotime($dueDate)));
                                }
                            }
                        }else{
                            $dayAmount = DB::table('ptom_customer_contract_groups')->select('day_amount')->where('customer_id', $customerID)->where('credit_group_code', $value->credit_group_code)->pluck('day_amount')->first();

                            if($value->credit_group_code != 0){
                                $dueDate = Date('Y-m-d H:i:s', strtotime("+".$dayAmount." day", strtotime($dueDate)));
                            }
                        }

                        $penalty_total = 0;
                        $outstanding_debt = $sumAmount;
                        $sum_payment_amount = 0;
                        if ($dueDate != '') {
                            $date = Carbon::parse($dueDate);
                            $now = Carbon::parse(now());

                            if($date >= $now){
                                $diff = 0;
                            }else{
                                $diff = $date->diffInDays($now);
                            }

                            for ($i=0; $i < $diff; $i++) {

                                if (!empty($item->prepare_order_number)) {
                                    $payment_amount = DB::table('ptom_payment_match_invoices')
                                    ->where('prepare_order_number',$item->prepare_order_number)
                                    ->where('credit_group_code',$item->credit_group_code)
                                    ->whereDate('creation_date',$date->addDays(1)->format('Y-m-d'))
                                    ->where('match_flag','Y')
                                    ->whereNull('deleted_at')->sum('payment_amount');
                                }else {
                                    $payment_amount = 0;
                                }

                                // echo '<pre> outStanding debt : ';
                                // print_r($outstanding_debt);
                                // echo '<pre> Payment Amount : ';
                                // print_r($payment_amount);
                                // echo '<pre> Payment Amount : ';
                                // print_r($amountPenaltyRate);
                                // echo '<pre> Payment Amount : ';
                                // print_r($daysInYear);
                                // echo '</pre>';
                                // exit();


                                $outstanding_debt -= $payment_amount;
                                $sum_payment_amount += $payment_amount;

                                $penalty_total += (($outstanding_debt * $amountPenaltyRate) / 100) / $daysInYear;

                            }
                        }

                        // เลขที่ใบเสร็จรับเงิน && วันที่รับชำระเงิน
                        $paymentHeaderID = DB::table('ptom_payment_match_invoices')->select('payment_header_id')->where('prepare_order_number', $orderHeadersQuery->prepare_order_number)->where('match_flag', 'Y')->where('payment_amount', '>', 0)->where('credit_group_code', $value->credit_group_code)->pluck('payment_header_id')->first();
                        $invoiceNo = '';
                        $paymentDate = '';
                        $paymentPayAmount = 0;
                        if (!empty($paymentHeaderID)) {
                            $paymentHeaderQuery = DB::table('ptom_payment_headers')->where('payment_header_id', $paymentHeaderID)->first();

                            if (!empty($paymentHeaderQuery)) {
                                $invoiceNo = $paymentHeaderQuery->payment_number;
                                $paymentDate = !empty($paymentHeaderQuery->payment_date) ? dateFormatThai($paymentHeaderQuery->payment_date) : '';
                                $paymentPayAmount = !empty($paymentHeaderQuery->payment_amount) ? number_format((float)$paymentHeaderQuery->payment_amount, 2, '.', '') : 0;
                            }
                        }

                        // echo 'Pyament Date : '.$paymentDate;
                        // echo '<pre>';

                        if ($invoiceNo == '') {
                            $cndnQuery = DB::table('ptom_payment_apply_cndn')->where('order_header_id', $orderHeadersId)->where('attribute1', 'Y')->where('credit_group_code', $value->credit_group_code)->first();
                            if (!empty($cndnQuery)) {
                                $invoiceNo = $cndnQuery->invoice_number;
                                $paymentDate = !empty($cndnQuery->last_update_date) ? dateFormatThai($cndnQuery->last_update_date) : '';
                                $paymentPayAmount = !empty($cndnQuery->invoice_amount) ? number_format((float)$cndnQuery->invoice_amount, 2, '.', '') : 0;
                            }
                        }

                        // echo 'Invoice NO : '.$invoiceNo;
                        // exit();

                        $total_payment_amount = DB::table('ptom_payment_match_invoices')
                                ->where('prepare_order_number',$orderHeadersQuery->prepare_order_number)
                                ->where('credit_group_code',$value->credit_group_code)
                                ->where('match_flag','Y')
                                ->whereNull('deleted_at')->sum('payment_amount');

                        $total_payment_amount += $paymentPayAmount;

                        $consignmentDataNo = ConsignmentHeader::where('order_header_id', $orderHeadersId)->where('consignment_status', 'Confirm')->pluck('consignment_no')->first();
                        if (!empty($consignmentDataNo)){
                            $releaseNo = $consignmentDataNo;
                        }else{
                            $releaseNo = $orderHeadersQuery->pick_release_no;
                        }

                        $sumAmountData = number_format((float)$sumAmount, 2, '.', '');
                        if ($sumAmountData != $total_payment_amount) {
                            $paymentFineData = !empty($releaseCredit) ? number_format((float)$releaseCredit->charge_amount, 2, '.', '') : (!empty($penalty_total) ? number_format((float)$penalty_total, 2, '.', '') : 0);
                        } else {
                            $paymentFineData = number_format(0, 2, '.', '');
                        }


                        // if ($invoiceNo != '') {
                            $outstandingData[] = [
                                    'payment_prepare_num'   => $orderHeadersQuery->prepare_order_number,
                                    'payment_release_no'    => $releaseNo,
                                    'payment_credit_group'  => $value->credit_group_code == 0 ? 'เงินสด' : 'เงินเชื่อกลุ่ม '.$value->credit_group_code,
                                    'payment_amount'        => $sumAmountData,
                                    'payment_fine'          => $releaseNo != '' ? $paymentFineData : 0.00,
                                    'payment_due_date'      => !empty($dueDate) ? dateFormatThai($dueDate) : '',
                                    'payment_invoice_no'    => $invoiceNo,
                                    'payment_date'          => !empty($paymentDate) ? $paymentDate : '',
                                    'payment_pay_amount'    => $total_payment_amount,
                                ];
                        // }
                    }
                }
            }

            // STEP 3
            $releaseCreditQuery = ReleaseCredit::where('payment_flag', 'Y')->where('customer_id', $customerID)->where('attribute1', $orderHeadersId)->whereRaw("nvl(due_date,sysdate+1) > sysdate")->get();

            // echo '<pre>';
            // print_r($releaseCreditQuery);
            // echo '</pre>';
            // exit();
            if (!empty($releaseCreditQuery)) {
                foreach ($releaseCreditQuery as $key => $value) {
                    $outstandingDebt = DB::table('ptom_outstanding_debt_dom_v')->where('pick_release_no', $value->invoice_num)->first();

                    if (!empty($outstandingDebt)) {

                        // ค่าปรับ
                        $date = Carbon::parse($value->due_date);
                        $now = Carbon::parse(now());

                        if($date >= $now){
                            $diff = 0;
                        }else{
                            $diff = $date->diffInDays($now);
                        }

                        $penalty_total = 0;
                        $outstanding_debt = $outstandingDebt->outstanding_debt;
                        $sum_payment_amount = 0;

                        $improveStatus = DB::table('ptom_improve_fines')->where('invoice_number', $value->invoice_num)->first();

                        if (!empty($improveStatus)) {
                            if (empty($improveStatus->cancel_flag) || $improveStatus->cancel_flag != 'Y') {
                                for ($i=0; $i < $diff; $i++) {

                                    if (!empty($outstandingDebt->prepare_order_number)) {
                                        $payment_amount = DB::table('ptom_payment_match_invoices')
                                        ->where('prepare_order_number',$outstandingDebt->prepare_order_number)
                                        ->where('credit_group_code',$outstandingDebt->credit_group_code)
                                        ->whereDate('creation_date',$date->addDays(1)->format('Y-m-d'))
                                        ->where('match_flag','Y')
                                        ->whereNull('deleted_at')->sum('payment_amount');
                                    }else {
                                        $payment_amount = 0;
                                    }
                                    $outstanding_debt -= $payment_amount;
                                    $sum_payment_amount += $payment_amount;

                                    $penalty_total += (($outstanding_debt * $amountPenaltyRate) / 100) / $daysInYear;

                                }
                            }

                        }

                        if ($outstandingDebt->product_type_code == 10 && ( $outstandingDebt->customer_type_id == 30 || $outstandingDebt->customer_type_id == 40 )) {
                            $paymentReleaseNo = $outstandingDebt->consignment_no;
                        }else{
                            $paymentReleaseNo = $outstandingDebt->pick_release_no;
                        }

                        $prePareNumber = OrderHeaders::where('order_header_id', $orderHeadersId)->pluck('prepare_order_number')->first();

                        // เลขที่ใบเสร็จรับเงิน && วันที่รับชำระเงิน
                        $paymentHeaderID = DB::table('ptom_payment_match_invoices')->select('payment_header_id')->where('prepare_order_number', $prePareNumber)->where('match_flag', 'Y')->where('payment_amount', '>', 0)->pluck('payment_header_id')->first();
                        $invoiceNo = '';
                        $paymentDate = '';
                        $paymentPayAmount = 0;
                        if (!empty($paymentHeaderID)) {
                            $paymentHeaderQuery = DB::table('ptom_payment_headers')->where('payment_header_id', $paymentHeaderID)->first();

                            if (!empty($paymentHeaderQuery)) {
                                $invoiceNo = $paymentHeaderQuery->payment_number;
                                $paymentDate = !empty($paymentHeaderQuery->payment_date) ? dateFormatThai($paymentHeaderQuery->payment_date) : '';
                                $paymentPayAmount = !empty($paymentHeaderQuery->payment_amount) ? number_format((float)$paymentHeaderQuery->payment_amount, 2, '.', '') : 0;
                            }
                        }

                        // echo 'Pyament Date : '.$paymentDate;
                        // echo '<pre>';

                        if ($invoiceNo == '') {
                            $cndnQuery = DB::table('ptom_payment_apply_cndn')->where('order_header_id', $orderHeadersId)->where('attribute1', 'Y')->where('credit_group_code', $value->credit_group_code)->first();
                            if (!empty($cndnQuery)) {
                                $invoiceNo = $cndnQuery->invoice_number;
                                $paymentDate = !empty($cndnQuery->last_update_date) ? dateFormatThai($cndnQuery->last_update_date) : '';
                                $paymentPayAmount = !empty($cndnQuery->invoice_amount) ? number_format((float)$cndnQuery->invoice_amount, 2, '.', '') : 0;
                            }
                        }

                        $sumAmountData = $value->amount;
                        if ($sumAmountData != $paymentPayAmount) {
                            $paymentFineData = !empty($penalty_total) ? number_format((float)$penalty_total, 2, '.', '') : 0;
                        } else {
                            $paymentFineData = number_format(0, 2, '.', '');
                        }

                        // echo 'Invoice Date : '.$paymentDate;
                        // exit();

                        $outstandingData[] = [
                            'payment_prepare_num'   => !empty($prePareNumber) ? $prePareNumber : '',
                            'payment_release_no'    => $value->invoice_num,
                            'payment_credit_group'  => $value->credit_group_code == 0 ? 'เงินสด' : 'เงินเชื่อกลุ่ม '.$value->credit_group_code,
                            'payment_amount'        => $value->amount,
                            'payment_fine'          => $value->invoice_num != '' ? $paymentFineData : 0.00,
                            'payment_due_date'      => dateFormatThai($value->due_date),
                            'payment_invoice_no'    => $invoiceNo,
                            'payment_date'          => !empty($paymentDate) ? $paymentDate : '',
                            'payment_pay_amount'    => $paymentPayAmount,
                        ];
                    }
                }
            }


            $rest = [
                'status'    => 'success',
                'data'      => $outstandingData
            ];

            return response()->json(['data'=>$rest]);
    }

    public function cancelPrepareOrder(Request $request)
    {
        $resultStatus = 'success';

        if($request->cancel_header_id > 0){
            $update = [
                'pick_release_approve_flag'     => 'N',
                // 'pick_release_approve_date'     => NULL,
                // 'pick_release_approve_by'       => NULL,
                // 'attribute1'                    => NULL,
                // // 'attribute5'                    => NULL,
                // 'pick_release_status'           => 'Cancelled',
                // 'pick_release_id'               => NULL,
                // 'pick_release_no'               => NULL,
                'last_updated_by'               => optional(auth()->user())->user_id,
                // 'last_update_date'              => date('Y-m-d H:i:s')
            ];

            $updateHistory = [
                'pick_release_approve_flag'     => 'N',
                // 'pick_release_approve_date'     => NULL,
                // 'pick_release_approve_by'       => NULL,
                // 'attribute1'                    => NULL,
                // // 'attribute5'                    => NULL,
                // 'pick_release_status'           => 'Cancelled',
                // 'pick_release_id'               => NULL,
                // 'pick_release_no'               => NULL,
                'last_updated_by'               => optional(auth()->user())->user_id,
                // 'last_update_date'              => date('Y-m-d H:i:s')
            ];
            if(OrderHeaders::where('order_header_id', $request->cancel_header_id)->update($update)){
                OrderHistory::where('order_header_id', $request->cancel_header_id)->where('order_status', 'Invoice')->whereNull('deleted_at')->update($updateHistory);
            }else{
                $resultStatus = 'false';
            }
        }

        $match = PaymentMatchInvoices::selectRaw('prepare_order_number as invoice_prepare ,max(due_date) as maxdate,sum(payment_amount) as sumamount')
            ->groupBy('prepare_order_number');
        $order = OrderHeaders::where('period_id','!=',1)
            ->leftJoin('ptom_approver_orders', 'ptom_order_headers.pick_release_approve_by', '=', 'ptom_approver_orders.approver_order_id')
            ->leftJoin('ptom_customers', 'ptom_order_headers.customer_id', '=', 'ptom_customers.customer_id')
            ->leftJoinSub($match, 'match', 'match.invoice_prepare', 'ptom_order_headers.prepare_order_number')
            ->where('ptom_customers.sales_classification_code', 'Domestic')
            ->where('ptom_order_headers.payment_approve_flag', 'Y')
            ->where('ptom_order_headers.order_status','Confirm')
            ->where(function($query) use($request) {

                if(!empty($request->customer_id)) {
                    $query->where('ptom_order_headers.customer_id', $request->customer_id);
                }
                if(!empty($request->prepare_order_number)) {
                    $query->where('ptom_order_headers.prepare_order_number', $request->prepare_order_number);
                }
                if(!empty($request->pick_release_approve_flag)) {
                    if($request->pick_release_approve_flag == 'Y') {
                        $query->where('ptom_order_headers.pick_release_approve_flag', 'Y');
                    }
                    else{
                        // $query->where('ptom_order_headers.pick_release_approve_flag', '!=', 'Y');
                        $query->whereNull('ptom_order_headers.pick_release_approve_flag');
                    }
                }
                // else{
                //     $query->whereNull('ptom_order_headers.pick_release_approve_flag');
                // }
                if(!empty($request->pick_release_no)) {
                    $query->where('ptom_order_headers.pick_release_no', $request->pick_release_no);
                }
                if(!empty($request->pick_release_status)) {
                    $query->where('ptom_order_headers.pick_release_status', $request->pick_release_status);
                }
                if(!empty($request->unlock_print_flag)) {
                    if ($request->unlock_print_flag == 'Y') {
                        $query->where('ptom_order_headers.unlock_print_flag', '=', 'Y');
                    }else{
                        $query->where('ptom_order_headers.unlock_print_flag', '!=', 'Y');
                    }
                }

                if(!empty($request->delivery_start_date)){
                    $date_ex = explode('/',$request->delivery_start_date);
                    $year_1  = $date_ex[2] - 543;
                    $date    = $year_1.'-'.$date_ex[1].'-'.$date_ex[0];
                    $query->where('ptom_order_headers.delivery_date','>=',$date);
                }
                if(!empty($request->delivery_end_date)){
                    $dateto_ex = explode('/',$request->delivery_end_date);
                    $year_2  = $dateto_ex[2] - 543;
                    $date2    = $year_2.'-'.$dateto_ex[1].'-'.$dateto_ex[0];
                    $query->where('ptom_order_headers.delivery_date','<=',$date2);
                }
            })
            ->select([
                'ptom_order_headers.*',
                'ptom_approver_orders.approver_name as approver_name',
                'match.*',
                'ptom_customers.customer_name',
                'ptom_customers.customer_type_id'
            ])
            ->get();

            // echo '<pre>';
            // print_r($order);
            // echo '</pre>';
            // exit();

        foreach($order as $item) {
            $item->is_over_quota = false;
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
                ->where('cqh.customer_id', $item->customer_id)
                ->where('qcg.quota_group_code',$qitem->lookup_code)
                ->get();
                if(count($quota) > 0){
                    foreach ($quota as $_q) {$customer_quota[] = $_q;}
                    // $customer_quota[] = $quota;
                }

            }
            $line_item = DB::table('ptom_order_lines')->where('order_header_id', $item->order_header_id)->get();
            foreach ($line_item as $line) {
                $quantity = $line->total_amount/1000;
                $sum = 0;
                foreach($customer_quota as $_q) {
                    if($_q->item_code==$line->item_code) $sum+=$_q->remaining_quota;
                }
                if($quantity>$sum) {
                    $item->is_over_quota = true;
                }
            }

            if ($item->pick_release_status == 'Confirm') {
                // New Outstatnding
                $PeriodID = OrderHeaders::select('period_id')->where('order_header_id', $item->order_header_id)->pluck('period_id')->first();
                $PeriodData = DB::table('ptom_period_v')->where('period_line_id', $PeriodID)->first();

                if(!empty($PeriodData)){
                    $debtDomData = DB::table('ptom_debt_dom_v')->where('customer_id', $item->customer_id)->where('outstanding_debt', '>', 0)->whereBetween('due_date', [$PeriodData->start_period, $PeriodData->end_period])->get();



                    if (count($debtDomData) <= 0) {
                        $item->statusAmount = 1;
                    }else{
                        $item->statusAmount = 2;
                    }
                }
            }else{
                // New Outstatnding
                $PeriodID = OrderHeaders::select('period_id')->where('order_header_id', $item->order_header_id)->pluck('period_id')->first();
                $PeriodData = DB::table('ptom_period_v')->where('period_line_id', $PeriodID)->first();

                $item->statusAmount = 2;

                if(!empty($PeriodData)){
                    $debtDomData = DB::table('ptom_debt_dom_v')->where('customer_id', $item->customer_id)->where('outstanding_debt', '>', 0)->where('due_date', '<=' ,$PeriodData->end_period)->get();

                    if (count($debtDomData) > 0) {
                        foreach ($debtDomData as $key => $value) {

                            // dd($value);
                            if ($item->customer_type_id == 30 && $item->product_type_code == 10 ) {
                                $paymentDomData = DB::table('ptom_payment_dom_v')->where('invoice_number', $value->consignment_no)->where('customer_id', $item->customer_id)->where('credit_group_code', $value->credit_group_code)->get();
                            } else {
                                $paymentDomData = DB::table('ptom_payment_dom_v')->where('prepare_order_number', $value->prepare_order_number)->where('customer_id', $item->customer_id)->where('credit_group_code', $value->credit_group_code)->get();
                            }

                            if (count($paymentDomData) > 0) {
                                foreach ($paymentDomData as $keyDom => $itemDom) {
                                    $paymentDomData[$keyDom]->payment_date      = dateFormatThaiString($itemDom->payment_date);
                                    $paymentDomData[$keyDom]->payment_amount    = number_format($itemDom->payment_amount, 2, '.', ',');
                                }

                                if ($paymentDomData[$keyDom]->payment_amount < $value->debt_amount) {
                                    $item->statusAmount = 1;
                                }else{
                                    $item->statusAmount = 2;
                                }

                            }else{
                                $item->statusAmount = 1;
                            }
                        }
                    }
                }
            }

            // if ($item->credit_amount != 0) {
            //     if ($item->credit_amount == $item->sumamount) {
            //         $item->statusAmount = 2;
            //     } else {
            //         if($item->sumamount == null && $item->cash_amount > 0){
            //             $item->statusAmount = 1;
            //         }
            //         // else if ($item->delivery_date < $outstandingDueDate) {
            //         //     $item->statusAmount = 0;
            //         // }
            //         else {
            //             $item->statusAmount = 1;
            //         }
            //     }
            // } else {
            //     if (($item->cash_amount <= $item->sumamount) && $item->sumamount != 0 || ($item->pick_release_status == 'Confirm' && $item->statusAmount == 2)) {
            //         $item->statusAmount = 2;
            //     } else {
            //         $item->statusAmount = 1;
            //     }
            // }

            // เช็คขอคืนวงเงินเชื่อ
            // $releaseData = ReleaseCredit::where('payment_flag', 'Y')->where('customer_id', $item->customer_id)->get();
            // if (!$releaseData->isEmpty()) {
            //     foreach ($releaseData as $reItem) {
            //         $outstandingCheck = DB::table('ptom_outstanding_debt_dom_v')
            //             ->where('credit_group_code', $reItem->credit_group_code)
            //             ->where(function($query) use($reItem) {
            //                     $query->where('consignment_no', $reItem->invoice_num);
            //                     $query->orWhere('pick_release_no', $reItem->invoice_num);
            //             })->get();

            //         if (!$outstandingCheck->isEmpty()) {
            //             $item->statusAmount = 1;
            //         }
            //     }
            // }

            // if (!empty($item->pick_release_no)) {
            //     $osdDueDate    = DB::table('ptom_outstanding_debt_dom_v')->where('customer_id', $item->customer_id)->where('pick_release_no', $item->pick_release_no)->first();

            //     if (!empty($osdDueDate->due_date)) {
            //         if ($item->credit_amount == $item->sumamount) {
            //             $item->statusAmount = 2;
            //         }else {
            //             $item->statusAmount = 1;
            //         }
            //     }

            // }

            if (empty($item->prepare_order_number)) {
                $item->prepare_order_number = '';
                $item->invoice_no           = '';
            }else{
                $paymentHeaderID    = PaymentMatchInvoices::where('prepare_order_number', $item->prepare_order_number)->whereNull('deleted_at')->pluck('payment_header_id')->first();
                $getInvoiceNo       = PaymentHeaders::where('payment_header_id', $paymentHeaderID)->pluck('payment_number')->first();
                $item->invoice_no   = !empty($getInvoiceNo) ? $getInvoiceNo : '';
            }

            if (empty($item->pick_release_no)) {
                $item->pick_release_no = '';
            }

            if (empty($item->pick_release_status)) {
                $item->pick_release_status = '';
            }

            if (!empty($item->delivery_date)) {
                $item->delivery_date = dateFormatThaiString($item->delivery_date);
            }else{
                $item->delivery_date = '';
            }

            if (!empty($item->cash_amount)) {
                $item->cash_amount = number_format($item->cash_amount,2);
            }else{
                $item->cash_amount = '0.00';
            }

            if (!empty($item->credit_amount)) {
                $item->credit_amount = number_format($item->credit_amount,2);
            }else{
                $item->credit_amount = '0.00';
            }

            if (!empty($item->grand_total)) {
                $item->grand_total = number_format($item->grand_total,2);
            }else{
                $item->grand_total = '0.00';
            }

            $additionQuotar = DB::table('ptom_addition_quota_headers')->where('order_header_id', $item->order_header_id)->where('approve_status', 'อนุมัติ')->whereNull('deleted_at')->first();

            if (!empty($additionQuotar->approve_status)) {
                $item->addition_approve_status = 'Y';
            }else{
                $item->addition_approve_status = 'N';
            }

            // Check Payment before
            $dataCheckPayment = OrderHeaders::where('customer_id', $item->customer_id)->where('order_header_id', '<=', $item->order_header_id)->whereNull('deleted_at')->orderBy('order_header_id', 'desc')->limit(2)->get();

            $item->payment_before_status = 'Y';

            if (!empty($dataCheckPayment[1])) {

                $dataOrder = $dataCheckPayment[1];

                $paymentAmount = DB::table('ptom_payment_match_invoices')->where('prepare_order_number', $dataOrder->prepare_order_number)->where('match_flag', 'Y')->whereNull('deleted_at')->sum('payment_amount');

                $orderPaymentAmount = (float)$dataOrder->cash_amount + (float)$dataOrder->credit_amount;

                if ($paymentAmount <= $orderPaymentAmount) {

                    $checkDayAmount = 0;

                    // ดึงข้อมูลการค้างชำระ กรณี อื่นๆ
                    $selectColumnes = ['day_amount', 'credit_group_code'];
                    $dataCreditGroup = OrderLines::select($selectColumnes)->where('order_header_id', $dataOrder->order_header_id)->whereNull('deleted_at')->whereNull('promo_flag')->groupBy($selectColumnes)->get();

                    if (!$dataCreditGroup->isEmpty()) {
                        foreach ($dataCreditGroup as $crItem) {

                                // ดึงข้อมูล Day amount จาก TermV กรณี เป็นเงินสด
                            if (($item->customer_type_id == 30 || $item->customer_type_id == 40) && $item->product_type_code == 10) {
                                if (trim($crItem->credit_group_code) == 0) {
                                    $dueDaysConsignment = Terms::where('credit_group_code', 0)
                                                                ->where('sale_type', 'DOMESTIC')
                                                                ->whereRaw("nvl(start_date_active,sysdate+1) < sysdate")
                                                                ->whereRaw("nvl(end_date_active,sysdate+1) > sysdate")
                                                                ->pluck('due_days_consignment')->first();

                                    $crItem->day_amount = !empty($dueDaysConsignment) ? $dueDaysConsignment : trim($crItem->day_amount);
                                }
                            }

                            if ($item->customer_type_id == 30 && $item->product_type_code == 10)
                            {
                                // ดึงข้อมูลการค้างชำระ กรณี ลูกค้าสโมรกรุงเทพ
                                $consignmentData  = ConsignmentHeader::where('order_header_id', $dataOrder->order_header_id)->where('consignment_status', 'Confirm')->whereNull('deleted_at')->get();

                                $sumConsigment      = 0.00;
                                $sumPayment         = 0.00;
                                $sumInvoiceLine     = 0.00;
                                $totalPaymentCNDN   = 0.00;
                                if (!empty($consignmentData)) {
                                    foreach ($consignmentData as $consItem) {
                                        // SUM TOTAL AMOUNT FROM CONSIGNMENT
                                        $sumConsigment = $sumConsigment + (!empty($consItem->total_amount) ? $consItem->total_amount : 0);

                                        // SUM PAYMENT_AMOUNT FROM PAYMENT MATCH INVOICES
                                        $paymentMatchInvoice = PaymentMatchInvoices::where('invoice_number', $consItem->consignment_no)->where('match_flag', 'Y')->whereNull('deleted_at')->get();

                                        if (!$paymentMatchInvoice->isEmpty()) {
                                            foreach ($paymentMatchInvoice as $matchItem) {
                                                $sumPayment = $sumPayment + (!empty($matchItem->payment_amount) ? (float)$matchItem->payment_amount : 0);

                                                $paymentCNDN         = PaymentApplyCNDN::join('ptom_payment_match_invoices', 'ptom_payment_apply_cndn.payment_match_id', '=', 'ptom_payment_match_invoices.payment_match_id')
                                                                                ->where('ptom_payment_match_invoices.payment_match_id', $matchItem->payment_match_id)
                                                                                ->sum('ptom_payment_apply_cndn.invoice_amount');

                                                $totalPaymentCNDN   = $totalPaymentCNDN + (float)$paymentCNDN;
                                            }
                                        }

                                    }
                                }

                                $sumInvoiceLine         = InvoiceLines::join('ptom_invoice_headers', 'ptom_invoice_lines.invoice_headers_id', '=', 'ptom_invoice_headers.invoice_headers_id')
                                                                        ->where('ptom_invoice_lines.document_id', $dataOrder->order_header_id)
                                                                        ->where('ptom_invoice_headers.invoice_type', 'CN_OTHER')
                                                                        ->sum('payment_amount');

                                $resultPayment  = (float)$sumPayment + (float)$totalPaymentCNDN + (float)$sumInvoiceLine;

                                if ((float)$sumConsigment != $resultPayment) {
                                    $checkDayAmount = 1;
                                }
                            }
                            else if ($item->customer_type_id == 40 && $item->product_type_code == 10)
                            {
                                $grandTotal     = !empty($dataOrder->grand_total) ? (float)$dataOrder->grand_total : 0.00;

                                // ดึงข้อมูลการค้างชำระ กรณี ลูกค้าสโมรภูมิภาค
                                $consignmentData  = ConsignmentHeader::where('order_header_id', $dataOrder->order_header_id)->where('consignment_status', 'Confirm')->whereNull('deleted_at')->get();

                                $sumConsigment      = 0.00;
                                $sumPayment         = 0.00;
                                $sumInvoiceLine     = 0.00;
                                $totalPaymentCNDN   = 0.00;
                                if (!empty($consignmentData)) {
                                    foreach ($consignmentData as $consItem) {

                                        $sumInvoiceLine1    = InvoiceLines::join('ptom_invoice_headers', 'ptom_invoice_lines.invoice_headers_id', '=', 'ptom_invoice_headers.invoice_headers_id')
                                                                        ->where('ptom_invoice_lines.document_id', $consItem->consignment_header_id)
                                                                        ->where('ptom_invoice_headers.invoice_type', 'CN_TRANFER')
                                                                        ->sum('payment_amount');

                                        $sumInvoiceLine2    = InvoiceLines::join('ptom_invoice_headers', 'ptom_invoice_lines.invoice_headers_id', '=', 'ptom_invoice_headers.invoice_headers_id')
                                                                        ->where('ptom_invoice_lines.document_id', $consItem->consignment_header_id)
                                                                        ->where('ptom_invoice_headers.invoice_type', 'CN_OTHER')
                                                                        ->sum('payment_amount');

                                        $sumInvoiceLine     = $sumInvoiceLine + (float)$sumInvoiceLine1 + (float)$sumInvoiceLine2;

                                        // SUM TOTAL AMOUNT FROM CONSIGNMENT
                                        $sumConsigment = $sumConsigment + (!empty($consItem->total_amount) ? $consItem->total_amount : 0);

                                        // SUM PAYMENT_AMOUNT FROM PAYMENT MATCH INVOICES
                                        $paymentMatchInvoice = PaymentMatchInvoices::where('invoice_number', $consItem->consignment_no)->where('match_flag', 'Y')->whereNull('deleted_at')->get();

                                        if (!$paymentMatchInvoice->isEmpty()) {
                                            foreach ($paymentMatchInvoice as $matchItem) {
                                                $sumPayment = $sumPayment + (!empty($matchItem->payment_amount) ? (float)$matchItem->payment_amount : 0);

                                                $paymentCNDN         = PaymentApplyCNDN::join('ptom_payment_match_invoices', 'ptom_payment_apply_cndn.payment_match_id', '=', 'ptom_payment_match_invoices.payment_match_id')
                                                                                ->where('ptom_payment_match_invoices.payment_match_id', $matchItem->payment_match_id)
                                                                                ->sum('ptom_payment_apply_cndn.invoice_amount');

                                                $totalPaymentCNDN   = $totalPaymentCNDN + (float)$paymentCNDN;
                                            }
                                        }
                                    }
                                }

                                $resultPayment  = (float)$sumPayment + (float)$sumInvoiceLine + (float)$totalPaymentCNDN;

                                if ($grandTotal != $resultPayment) {
                                    $checkDayAmount = 1;
                                }


                            }
                            else{
                                // ตรวจสอบการค้างชำระ
                                $sumCreditGroupAmount   = OrderCreditGroup::where('order_header_id', $dataOrder->order_header_id)->where('order_line_id', 0)->where('credit_group_code', $crItem->credit_group_code)->whereNull('deleted_at')->sum('amount');

                                $PaymentMatchInvoice = PaymentMatchInvoices::where('prepare_order_number', $dataOrder->prepare_order_number)->where('match_flag', 'Y')->where('credit_group_code', $crItem->credit_group_code)->whereNull('deleted_at')->get();

                                $sumPaymentMatchInvoice = 0.00;
                                $totalPaymentCNDN       = 0.00;
                                if (!empty($PaymentMatchInvoice)) {
                                    foreach ($PaymentMatchInvoice as $matchItem) {
                                        $sumPaymentMatchInvoice = $sumPaymentMatchInvoice + (float)$matchItem->payment_amount;
                                        $sumPaymentCNDN         = PaymentApplyCNDN::join('ptom_payment_match_invoices', 'ptom_payment_apply_cndn.payment_match_id', '=', 'ptom_payment_match_invoices.payment_match_id')
                                                                                ->where('ptom_payment_match_invoices.payment_match_id', $matchItem->payment_match_id)
                                                                                ->sum('ptom_payment_apply_cndn.invoice_amount');

                                        $totalPaymentCNDN   = $totalPaymentCNDN + (float)$sumPaymentCNDN;
                                    }
                                }

                                $sumInvoiceLine         = InvoiceLines::join('ptom_invoice_headers', 'ptom_invoice_lines.invoice_headers_id', '=', 'ptom_invoice_headers.invoice_headers_id')
                                                                        ->where('ptom_invoice_lines.document_id', $dataOrder->order_header_id)
                                                                        ->where('ptom_invoice_headers.invoice_type', 'CN_OTHER')
                                                                        ->sum('payment_amount');

                                $resultPayment  = (float)$sumPaymentMatchInvoice + (float)$totalPaymentCNDN + (float)$sumInvoiceLine;

                                if ((float)$sumCreditGroupAmount != $resultPayment ) {
                                    $checkDayAmount = 1;
                                }
                            }

                            if ($checkDayAmount == 1) {
                                // ตรวจสอบวันครบกำหนดชำระ
                                $dueDate1 = !empty($dataOrder->pick_release_approve_date) ? $dataOrder->pick_release_approve_date : (!empty($dataOrder->delivery_date) ? $dataOrder->delivery_date : 0);

                                $dateFirst = removeTimeOnDate($dueDate1);

                                if ($crItem->day_amount <= 0) {
                                    $date1=date_create($dateFirst);     // วันครบกำหนดชำระ
                                }else{
                                    $dayAmount  = date('Y-m-d', strtotime("+".$crItem->day_amount." day", strtotime($dateFirst)));
                                    $date1      = date_create($dayAmount);      // วันครบกำหนดชำระ
                                }

                                // $date1=date_create(date('2021-11-28'));
                                $date2=date_create(date('Y-m-d'));     // วันปัจจุบัน
                                $diff=date_diff($date2,$date1);
                                $resultDay = $diff->format("%r%a");

                                if ($resultDay <= 0) {
                                    $item->payment_before_status = 'N';
                                }
                            }
                        }
                    }

                }
            }



            // S = ชำระเงินแล้ว
            // Y =

            // if ($item->pick_release_status == 'Confirm') {
            //     $outstandingQuery = DB::table('ptom_outstanding_debt_dom_v')->where('order_header_id', $item->order_header_id)->get();

            //     if ($outstandingQuery->isEmpty()) {
            //         $item->standing_debt_status = 'S';
            //     }else{
            //         $outStanding    = DB::table('ptom_outstanding_debt_dom_v')->where('customer_id', $item->customer_id)->where('order_header_id', $item->order_header_id)->whereRaw("nvl(due_date,sysdate+1) <= sysdate")->first();

            //         if (!empty($outStanding)) {
            //             $item->standing_debt_status = 'Y';
            //         }else{
            //             $item->standing_debt_status = 'W';
            //         }
            //     }

            // }else{
            //     $outStanding    = DB::table('ptom_outstanding_debt_dom_v')->where('customer_id', $item->customer_id)->whereRaw("nvl(due_date,sysdate+1) <= sysdate")->first();

            //     if (!empty($outStanding)) {
            //         $item->standing_debt_status = 'Y';
            //     }else{
            //         $item->standing_debt_status = 'N';
            //     }
            // }
        }

        $rest = [
            'status'    => $resultStatus,
            'data'      => $order
        ];

        return response()->json(['data' => $rest]);
    }

    function cmpSortPrepareOrderNumber($a, $b)
    {
        return strcmp($a['prepare_order_number'], $b['prepare_order_number']);
    }

}
