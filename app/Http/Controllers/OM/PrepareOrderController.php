<?php

namespace App\Http\Controllers\OM;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\OM\Api\OrderEcomController;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\OM\Order;
use App\Models\OM\OrderHeaders;
use App\Models\OM\Api\OrderLines;
use App\Models\OM\PeriodV;
use App\Models\OM\Customers;
use App\Models\OM\Customers\Domestics\CreditGroup;
use App\Models\OM\Payment\PaymentMethodDomestic;
use App\Models\OM\Payment\PaymentType;
use App\Models\OM\ShipmentBy;
use App\Models\OM\OutstandingDebtDomesticV;
use App\Models\OM\TransactionTypeV;
use App\Models\OM\SalesChannelV;
use App\Repositories\OM\OrderRepo;
use Illuminate\Support\Facades\Validator;
use App\Repositories\OM\AttachmentRepo;
use App\Repositories\OM\CreditAndQuotaRepo;
use App\Models\OM\AttachFiles;
use App\Models\OM\AdditionQuota;
use App\Models\OM\AdditionQuotaLines;
use App\Models\OM\Api\AdditionQuotaLine;
use App\Models\OM\Customers\Domestics\CustomerContractGroups;
use App\Models\OM\Api\OrderCreditGroup;
use App\Models\OM\Api\OrderHeader;
use App\Models\OM\Api\OrderQuotaHistory;
use App\Repositories\OM\GenerateNumberRepo;
use App\Models\OM\ReleaseCredit;
use App\Models\OM\SequenceEcoms;
use App\Models\OM\PenaltyRateDomesticV;
use App\Models\OM\Api\OrderStatusHistory;
use App\Models\OM\ImproveFines;
use Barryvdh\Snappy\Facades\SnappyPdf;
use App\Models\OM\Settings\QuotaCreditGroup;
use App\Models\OM\PostponeOrders;

use App\Repositories\OM\DirectDebitRepo;
use Illuminate\Support\Facades\Log;
use App\Models\OM\Customers\Domestics\CustomerContracts;

use App\Models\OM\Customers\Domestics\PrintHistory;

class PrepareOrderController extends Controller
{
    //
    public function additionQueta($oid) {
        $aqh = AdditionQuota::where('ORDER_HEADER_ID', $oid)->first();
        if($aqh == null) {
            return collect([]);
        }
        $aql = AdditionQuotaLine::where('quota_header_id', $aqh->quota_header_id)
        ->select('ptom_addition_quota_lines.*')
        ->get();
        $aql = $aql->groupBy('quota_group_id');
        return $aql;
    }

    public function report_order() {

        $orderHeader = OrderHeaders::where('prepare_order_number',request()->prepare_order_number)
                                    ->orderBy('order_header_id','DESC')
                                    ->first();

        $orderLine = OrderLines::where('order_header_id',$orderHeader->order_header_id)
                        ->select('PTOM_ORDER_LINES.*', 'qcg.quota_group_code', 'seq.screen_number')
                        // ->where('unit_price','>',0)
                        ->leftJoin('ptom_quota_and_credit_group as qcg', 'qcg.item_code', '=', 'PTOM_ORDER_LINES.item_code')
                        ->leftJoin('PTOM_SEQUENCE_ECOMS as seq', 'seq.item_code', '=', 'PTOM_ORDER_LINES.item_code')
                        ->orderBy('seq.screen_number','ASC')
                        ->get();
        $customer_id    = $orderHeader->customer_id;
        $customer       = Customers::byCustomerId($customer_id);
        $additionQueta  = $this->additionQueta($orderHeader->order_header_id);
        $period         = PeriodV::where('period_line_id',$orderHeader->period_id)->first();

        $nowDate        = date('m-d-Y', strtotime(Carbon::now()));
        $defaultPeriod  = collect(\DB::select("
                            SELECT  *
                            FROM    PTOM_PERIOD_V
                            WHERE   1=1
                            AND start_period <= TO_DATE('{$nowDate}', 'MM/DD/YYYY')
                            AND end_period >= TO_DATE('{$nowDate}', 'MM/DD/YYYY')
                        "))->first();

        $checkPostpone  = PostponeOrders::where('from_period_id', optional($orderHeader)->period_id)
                                        ->where('approve_status', 'อนุมัติ')
                                        ->whereNull('deleted_at')
                                        ->where('customer_id', $customer_id)
                                        ->orderBy('postpone_order_id', 'DESC')
                                        ->get();
                                        
        $checkPostpone  = count($checkPostpone) != 0 ? true : false;
                        
        $releaseCredit  = ReleaseCredit::where('customer_id',$orderHeader->customer_id)
                                        ->where('attribute1',$orderHeader->order_header_id)
                                        ->get();
        $quota_code     = DB::table('ptom_quota_and_credit_group')->get();
        $quota_group    = DB::table('ptom_quota_group as cg')
                            ->where('enabled_flag','Y')
                            ->get(['cg.lookup_code','cg.meaning','cg.tag']);

        $received_quota     = 0;
        $spending_quota     = 0;
        $total_credit       = 0;
        $total_cash         = 0;
        $total_credit_cash  = 0;
        $remainingOrder = DB::table('oaom.ptom_order_remaining')
                            ->where('order_header_id',$orderHeader->order_header_id)->first();
        foreach($quota_group as $item){
            $item->received_quota = DB::table('ptom_order_quota_histories')
                                        ->where('order_header_id',$orderHeader->order_header_id)
                                        ->where('quota_group_code',$item->lookup_code)
                                        // ->where('quota_group_code',$item->lookup_code)
                                        ->sum('remaining_quota');

            $received_quota += $item->received_quota;
            if($orderHeader->installment_type_code == '20') {
                $item->spending_quota = DB::table('ptom_order_lines ol')
                ->leftJoin('ptom_quota_and_credit_group qg', 'qg.item_id', '=', 'ol.item_id')
                ->where('ol.order_header_id',$orderHeader->order_header_id)
                ->where('qg.quota_group_code',$item->lookup_code)->sum('approve_quantity');
            } else {
                // $item->spending_quota = DB::table('ptom_order_quota_histories')
                // ->where('order_header_id',$orderHeader->order_header_id)
                // ->where('quota_group_code',$item->lookup_code)->sum('spending_quota');
                $item->spending_quota = DB::table('ptom_order_lines ol')
                ->leftJoin('ptom_quota_and_credit_group qg', 'qg.item_id', '=', 'ol.item_id')
                ->where('ol.order_header_id',$orderHeader->order_header_id)
                ->where('qg.quota_group_code',$item->lookup_code)->sum('approve_quantity');
            }
            $spending_quota += $item->spending_quota;

            $item->quota_and_credit = DB::table('ptom_order_lines as ol')->select('qcg.quota_group_code')
            ->leftJoin('ptom_quota_and_credit_group as qcg', 'qcg.item_code', '=', 'ol.item_code')
            ->join('ptom_order_credit_groups as ocg', 'ocg.order_line_id', '=', 'ol.order_line_id')
            ->where('ol.order_header_id',$orderHeader->order_header_id)
            ->where('ocg.credit_group_code','!=',0)
            ->where('qcg.quota_group_code',$item->lookup_code)->sum('ocg.amount');
            if($item->lookup_code == '04') {
                
                $quota_and_credit = DB::table('ptom_order_credit_groups as ocg')
                ->where('ocg.order_header_id',$orderHeader->order_header_id)
                ->where('ocg.order_line_id', 0)
                ->where('ocg.credit_group_code', 2)
                ->first();
                $item->quota_and_credit = is_null($quota_and_credit) ? $item->quota_and_credit : $quota_and_credit->amount;
                
            }

            $item->cash = DB::table('ptom_order_lines as ol')->select('qcg.quota_group_code')
            ->leftJoin('ptom_quota_and_credit_group as qcg', 'qcg.item_code', '=', 'ol.item_code')
            ->join('ptom_order_credit_groups as ocg', 'ocg.order_line_id', '=', 'ol.order_line_id')
            ->where('ol.order_header_id',$orderHeader->order_header_id)
            ->where('ocg.credit_group_code',0)
            ->where('qcg.quota_group_code',$item->lookup_code)->sum('ocg.amount');
            if($item->lookup_code == '04') {
                $item->cash = $orderLine->where('quota_group_code', '04')->sum('amount') - $item->quota_and_credit;
            }

            $total_credit       += $item->quota_and_credit;
            $total_cash         += $item->cash;
            $item->total_amount = $item->quota_and_credit + $item->cash;
        }

        $total_credit_cash = $total_credit + $total_cash;
        $compact = compact( 'orderHeader', 'additionQueta', 
                            'orderLine', 'customer', 'period', 
                            'quota_group', 'releaseCredit', 'total_credit', 
                            'total_cash', 'total_credit_cash', 'received_quota', 
                            'spending_quota', 'checkPostpone');

        $pdf = SnappyPdf::loadView('om.preparation.order_report',$compact);
        $pdf->setOption('page-size', 'a4')
            ->setOption('margin-bottom', 5)
            ->setOption('margin-left', 0)
            ->setOption('margin-right', 0)
            ->setOption('margin-top', 0);
        return $pdf->stream('OMR0001.pdf');
    }

    public function report_preparation() {
        $orderHeader            = OrderHeaders::where('prepare_order_number',request()->prepare_order_number)
                                            ->orderBy('order_header_id','DESC')
                                            ->first();
        $requestor              = DB::table('ptom_requestor')->where('lookup_code', $orderHeader->requestor_code)->first();
        $customer_id            = $orderHeader->customer_id;
        $customer               = Customers::byCustomerId($customer_id);
        $customerTypeDomestic   = DB::table('ptom_customer_type_domestic')
                                    ->where('customer_type',$customer->customer_type_id)
                                    ->first();
        $credit_group           = DB::table('ptom_credit_group')->get();
        $quota_group            = DB::table('ptom_quota_group as cg')
                                    ->where('enabled_flag','Y')
                                    ->get();
        $dayAmount[2]           = (object)[];
        $dayAmount[3]           = (object)[];
        $release_credit[2]      = 0;
        $release_credit[3]      = 0;
        $nowDate                = Carbon::createFromFormat('Y-m-d H:i:s', now())->format('m/d/Y');
        $cusContracts           = CustomerContracts::where('customer_id', $customer_id)
                                                    ->whereRaw("TO_DATE('{$nowDate}', 'MM/DD/YYYY') 
                                                                BETWEEN start_date 
                                                                AND nvl(end_date,TO_DATE('{$nowDate}', 'MM/DD/YYYY'))")
                                                    ->get();
        $cusContracts           = $cusContracts->isEmpty();

        try {
            $delivery_date = OrderHeaders::where('order_header_id', $orderHeader->order_header_id)->first()->delivery_date;
            if(is_null($delivery_date)){
                $delivery_date = date('Y-m-d 00:00:00');
            }
        }catch (\Exception $e) {
            $delivery_date = date('Y-m-d 00:00:00');
        }

        $period = DB::table('ptom_period_v as pvf')
                    ->whereRaw("TO_DATE('". Carbon::createFromFormat('Y-m-d H:i:s', $delivery_date)->format('Y-m-d') . "', 'YYYY-MM-DD') BETWEEN START_PERIOD AND END_PERIOD")
                    // ->where('start_period','<=', $delivery_date)
                    // ->where('end_period','>=', $delivery_date)
                    ->first();

        $outstandingDue = OutstandingDebtDomesticV::where('customer_id',$orderHeader->customer_id)
                                                    ->where('due_date','>=', $period->start_period)
                                                    ->where('due_date','<=', $period->end_period)
                                                    ->where('pick_release_status','Confirm')
                                                    ->sum('outstanding_debt');
        $total_outstanding_in_period = 0;
        $period = PeriodV::where('period_line_id',$orderHeader->period_id)->first();
        $periodDerivery = PeriodV::whereRaw("   TO_DATE('{$delivery_date}', 'YYYY-MM-DD HH24:MI:SS') 
                                                BETWEEN start_period 
                                                AND end_period")
                                ->first();
        $debt_due_date_amount = [];
        // $orderIdInDeliveryDate = OrderHeader::where('delivery_date', $orderHeader->delivery_date)
        //                                     ->where('customer_id', $orderHeader->customer_id)
        //                                     ->select('order_header_id')
        //                                     ->get();

        foreach($credit_group as $item){
            $item->remaining_amount_cal = 0;
             $debt_due_date_amount[$item->lookup_code] = ReleaseCredit::where('attribute1', $orderHeader->order_header_id)
            // $debt_due_date_amount[$item->lookup_code] = ReleaseCredit::whereIn('attribute1', $orderIdInDeliveryDate->pluck('order_header_id')->toArray())
            ->where('credit_group_code', $item->lookup_code)
            ->sum('amount');

            try {
                $contractGroups = CustomerContractGroups::where('customer_id',$orderHeader->customer_id)->where('credit_group_code',$item->lookup_code)->whereNull('deleted_at')->first();
                $outstandingData = OutstandingDebtDomesticV::where('customer_id',$orderHeader->customer_id)->where('pick_release_status','Confirm')->sum('outstanding_debt');
                $remaining_amount_cal = $contractGroups->credit_amount - $outstandingData;
                $item->remaining_amount_cal = ($remaining_amount_cal < 0) ? 0 : $remaining_amount_cal;
            } catch (\Throwable $th) {
                //throw $th;
            }

            $total_outstanding_in_period += DB::table('ptom_order_credit_groups')
            ->join('ptom_order_headers', 'ptom_order_headers.order_header_id', '=', 'ptom_order_credit_groups.order_header_id')
            ->where('ptom_order_headers.period_id',$orderHeader->period_id)
            ->where('ptom_order_headers.customer_id',$orderHeader->customer_id)
            ->where('ptom_order_headers.order_status','Confirm')
            ->where('ptom_order_credit_groups.credit_group_code',$item->lookup_code)
            ->where('ptom_order_headers.creation_date','<=',$orderHeader->creation_date)
            ->where('ptom_order_credit_groups.order_line_id',0)
            ->sum('amount');

            $release_credit_amount = DB::table('ptom_release_credit')->where('attribute1',$orderHeader->order_header_id)->where('credit_group_code',$item->lookup_code)->sum('amount');
            if($release_credit_amount > 0){
                $release_credit[$item->lookup_code]= $release_credit_amount;
            }

            $item->remaining_quota = 0;

            $total_by_group = DB::table('ptom_order_credit_groups')->where('order_header_id',$orderHeader->order_header_id)->where('credit_group_code',$item->lookup_code)->where('order_line_id',0)->first('amount');
            $remai_by_group = DB::table('ptom_order_credit_groups')->where('order_header_id',$orderHeader->order_header_id)->where('credit_group_code',$item->lookup_code)->where('order_line_id',0)->first();
            $item->total_sum_group = (!is_null($total_by_group)) ? $total_by_group->amount : 0;
            if(!is_null($total_by_group)){
                $total_remai = $remai_by_group->remaining_amount - $total_by_group->amount;
                $item->remaining_by_group = $remai_by_group->remaining_amount;
                $item->totoal_by_group = ($total_remai > 0) ? $total_remai : 0;
            }else{
                $item->totoal_by_group = 0;
                $item->remaining_by_group = 0;
            }

            $orderLine              = OrderLines::where('order_header_id',$orderHeader->order_header_id)
                                                ->where('credit_group_code',$item->lookup_code)
                                                // ->orderBy('order_line_id','ASC')
                                                ->orderBy('line_number', 'ASC')
                                                ->get();

            $item->orderLine        = $orderLine;
            $item->total_order      = 0;
            $item->total_approve    = 0;
            $item->received_quota   = 0;
            foreach ($orderLine as $key => $line) {
                $quota_lines = DB::table('ptom_customer_quota_lines as cql')
                                ->leftJoin('ptom_quota_and_credit_group as qcg', 'qcg.item_code', '=', 'cql.item_code')
                                ->where('cql.quota_line_id',$line->quota_line_id)
                                ->first();
                $line->received_quota = $quota_lines->received_quota;
                $line->total_all_received_quota = DB::table('ptom_customer_quota_lines as cql')
                                                    ->leftJoin('ptom_quota_and_credit_group as qcg', 'qcg.item_code', '=', 'cql.item_code')
                                                    ->leftJoin('PTOM_SEQUENCE_ECOMS se', 'se.item_code', '=','cql.item_code')
                                                    ->where('cql.quota_header_id',$quota_lines->quota_header_id)
                                                    ->get();
                $latest = OrderRepo::getLatestOrderLine($line->item_id,$customer_id,$orderHeader);
                if ($latest) {
                    $line->latest_order_date        = dateFormatThai($latest->delivery_date ?? $latest->order_date);
                    $line->latest_order_quantity    = number_format($latest->order_quantity,2);
                    $line->latest_approve_quantity  = number_format($latest->approve_quantity,2);
                    $line->latest_order_uom         = $latest->uom_code . ' ' .$latest->uom;
                }else{
                    $line->latest_order_date        = '-';
                    $line->latest_order_quantity    = '0.00';
                    $line->latest_approve_quantity  = '0.00';
                    $line->latest_order_uom         = '';
                }

                $item->total_order      += $line->order_quantity;
                $item->total_approve    += $line->approve_quantity;
                $item->received_quota   += $line->received_quota;

                $day_amount = CustomerContractGroups::where('customer_id',$customer_id)
                                                    ->where('credit_group_code',$item->lookup_code)
                                                    ->whereNull('deleted_at')
                                                    ->first();
                if(!is_null($day_amount)){
                    if(!is_null($orderHeader->pick_release_approve_date)){
                        $date_amount = date('Y-m-d', strtotime($orderHeader->pick_release_approve_date."+".$day_amount->day_amount." days"));
                    }elseif(!is_null($orderHeader->delivery_date)){

                        $date_amount = date('Y-m-d', strtotime($orderHeader->delivery_date."+".$day_amount->day_amount." days"));
                    }else{
                        $date_amount = date('Y-m-d', strtotime("+".$day_amount->day_amount." days"));
                    }

                    $orderCredit = OrderCreditGroup::where('order_header_id',$orderHeader->order_header_id)->where('order_line_id',0)->where('credit_group_code',$item->lookup_code)->first();
                    $amount = 0;
                    if(!is_null($orderCredit) && $orderCredit->amount != 0){
                        $amount = $orderCredit->amount;
                    }

                    $dayAmount[$item->lookup_code] = (object)[
                        'description'       => $item->description,
                        'credit_group_code' => $item->lookup_code,
                        'amount'            => $amount,
                        'day_amount'        => $day_amount->day_amount,
                        'date_th'           => dateFormatThai($date_amount),
                        'date'              => $date_amount
                    ];

                }
            }
        }

        $cash_group = (object)[];
        $cash_group->totoal_by_group = 0;
        $cash_amount = DB::table('ptom_order_credit_groups')
                        ->where('order_header_id',$orderHeader->order_header_id)
                        ->whereRaw("nvl(credit_group_code, 0) = 0")
                        ->where('order_line_id',0)
                        ->first('amount');
        $cash_group->totoal_by_group = (!is_null($cash_amount)) ? $cash_amount->amount : 0;
        $cash_group->orderLine = OrderLines::with('header')
                                            ->where('order_header_id',$orderHeader->order_header_id)
                                            ->whereRaw("nvl(credit_group_code, 0) = 0")
                                            ->orderBy('line_number', 'ASC')
                                            ->get();

        $cash_group->orderLineTotal = OrderLines::with('header')
                                                ->where('order_header_id',$orderHeader->order_header_id)
                                                ->orderBy('line_number', 'ASC')
                                                ->get();
        $cash_group->total_order    = 0;
        $cash_group->total_approve  = 0;
        $cash_group->received_quota = 0;
        foreach ($cash_group->orderLineTotal->where('promo_flag', '!=', 'Y') as $key => $line) {
            if($line->header->product_type_code != '20') {
                
                $quota_lines = optional(DB::table('ptom_customer_quota_lines as cql')
                                ->leftJoin('ptom_quota_and_credit_group as qcg', 'qcg.item_code', '=', 'cql.item_code')
                                ->where('cql.quota_line_id',$line->quota_line_id)
                                ->first())
                                ->received_quota;
            } else {
                $quota_lines = 0;
            }
            
            $line->received_quota = $quota_lines;
            $cash_group->received_quota += $line->received_quota;
            $cash_group->total_order    += $line->order_quantity;
            $cash_group->total_approve  += $line->approve_quantity;
        }

        foreach ($cash_group->orderLine as $key => $line) {
            if($line->header->product_type_code != '20') {
                $quota_lines = optional(DB::table('ptom_customer_quota_lines as cql')
                                ->leftJoin('ptom_quota_and_credit_group as qcg', 'qcg.item_code', '=', 'cql.item_code')
                                ->where('cql.quota_line_id',$line->quota_line_id)
                                ->first())
                                ->received_quota ?? null;
            } else {
                $quota_lines = 0;
            }
            
            $line->received_quota = $quota_lines;

            $latest = OrderRepo::getLatestOrderLine($line->item_id,$customer_id,$orderHeader);
            if ($latest) {
                $line->latest_order_date        = dateFormatThai($latest->delivery_date ?? $latest->order_date);
                $line->latest_order_quantity    = number_format($latest->order_quantity,2);
                $line->latest_approve_quantity  = number_format($latest->approve_quantity,2);
                $line->latest_order_uom         = $latest->uom_code . ' ' .$latest->uom;
            }else{
                $line->latest_order_date        = '-';
                $line->latest_order_quantity    = '0.00';
                $line->latest_approve_quantity  = '0.00';
                $line->latest_order_uom         = '';
            }

            $day_amount = CustomerContractGroups::where('customer_id',$customer_id)
                                                ->where('credit_group_code',$item->lookup_code)
                                                ->whereNull('deleted_at')
                                                ->first();

            if(!is_null($day_amount)){
                if(!is_null($orderHeader->pick_release_approve_date)){
                    $date_amount = date('Y-m-d', strtotime($orderHeader->pick_release_approve_date."+".$day_amount->day_amount." days"));
                }elseif(!is_null($orderHeader->delivery_date)){

                    $date_amount = date('Y-m-d', strtotime($orderHeader->delivery_date."+".$day_amount->day_amount." days"));
                }else{
                    $date_amount = date('Y-m-d', strtotime("+".$day_amount->day_amount." days"));
                }

                $orderCredit = OrderCreditGroup::where('order_header_id',$orderHeader->order_header_id)->where('order_line_id',0)->where('credit_group_code',$item->lookup_code)->first();
                $amount = 0;
                if(!is_null($orderCredit) && $orderCredit->amount != 0){
                    $amount = $orderCredit->amount;
                }

                $dayAmount[0] = (object)[
                    'description'       =>$item->description,
                    'credit_group_code' =>$item->lookup_code,
                    'amount'            =>$amount,
                    'day_amount'        =>$day_amount->day_amount,
                    'date_th'           =>dateFormatThai($date_amount),
                    'date'              =>$date_amount
                ];

            }

            $line->old_credit_group_code = QuotaCreditGroup::where('item_id', $line->item_id)->value('credit_group_code');
        }

        $shipmentBy     = ShipmentBy::where('lookup_code',$orderHeader->transport_type_code)
                                    ->first();

        $shipSites      = DB::table('ptom_customer_ship_sites')
                            ->where('customer_id',$customer_id)
                            ->where('ship_to_site_id',$orderHeader->ship_to_site_id)
                            ->first();

        $period         = PeriodV::where('period_line_id',$orderHeader->period_id)
                                ->first();

        $userPrint      = DB::table('ptw_users')->where('user_id', optional(DB::table('ptom_order_history')
            ->where('order_status', 'Inprocess')
            ->where('order_header_id', $orderHeader->order_header_id)
            ->first())->created_by)->first();

        $debt_amount    = DB::table('ptom_debt_dom_v as ddv')
                            ->where('ddv.customer_id',$customer_id)
                            ->where('due_date','>=', $period->start_period)
                            ->where('due_date','<=', $period->end_period)
                            ->sum('debt_amount');

        $orderCreditGroup = DB::table('ptom_order_credit_groups')
                                ->where('order_header_id', $orderHeader->order_header_id)
                                ->where('order_line_id', 0)
                                ->where('credit_group_code','<>', 0)
                                ->get();
        
        $orderRemainging = DB::table('oaom.ptom_order_remaining')
                            ->where('order_header_id',$orderHeader->order_header_id)
                            ->first();

        // TIME SHIPMENT BY
        $getPrintHistoryDate    = PrintHistory::where('document_id', $orderHeader->pick_release_id)->pluck('print_date')->first();

        $splitTimeStamp = explode(" ",$getPrintHistoryDate);
        // $printDate      = !empty($splitTimeStamp[0]) ? $splitTimeStamp[0] : '';
        $shipmentTime   = !empty($splitTimeStamp[1]) ? $splitTimeStamp[1] : '';
        // $shipmentTime = !empty($printTime) ? str_replace(':', '.', $printTime) : '';
        $dateNow = Carbon::createFromFormat('Y-m-d H:i:s', $orderHeader->delivery_date)->format('Y-m-d');
        $transportOwner = DB::table('ptom_transport_owners')
        ->whereRaw("to_date('{$dateNow}', 'YYYY-MM-DD') BETWEEN start_date AND end_date")
        ->first();
        $compact = compact( 'orderHeader', 'transportOwner', 'orderRemainging', 'orderCreditGroup', 'requestor',
                            'customer', 'period','shipmentBy', 'shipSites',
                            'credit_group', 'cash_group', 'dayAmount',
                            'userPrint', 'release_credit', 'outstandingDue',
                            'total_outstanding_in_period', 'debt_amount', 'debt_due_date_amount',
                            'customerTypeDomestic', 'cusContracts', 'shipmentTime');
        // return view('om.preparation.preparation_report',$compact);
        $pdf = SnappyPdf::loadView('om.preparation.preparation_report',$compact);
        $pdf->setPaper('a4')
            ->setOrientation('landscape')
            ->setOption('margin-left','0')
            ->setOption('margin-right','0')
            ->setOption('margin-top','0')
            ->setOption('margin-bottom','0');
        return $pdf->stream('OMR0002.pdf');
    }

    public function direct_debit() {
        $orderHeader = OrderHeaders::where('order_number','POC000011')->orderBy('order_header_id','DESC')->first();
        DirectDebitRepo::updateOrderDirectDebot($orderHeader);
        dd($orderHeader);
    }

    public function index() {
        $dateNow = now()->format('Y-m-d');

        $data['customers'] = Customers::byCustomerDomestic();

        $data['paymenType'] = PaymentType::get();
        $data['paymentMethod'] = PaymentMethodDomestic::get();
        $data['shipmentBy'] = ShipmentBy::where('tag','D')->get();
        $data['creditGroup'] = CreditGroup::get();
        $data['transactionType'] = TransactionTypeV::whereRaw("lower(sales_type) = 'domestic'")->whereNotNull('receivables_transaction_type')->get();
        $data['salesChannel'] = SalesChannelV::get();
        $data['orderLine'] = [];
        $data['remainingLimit'] = 0;
        $data['transportOwner'] = DB::table('ptom_transport_owners')->where('stop_flag', 'N')
        ->whereRaw("to_date('{$dateNow}', 'YYYY-MM-DD') BETWEEN start_date AND end_date")
        ->first();
        $data['shipmentBy'] = $data['shipmentBy']->map(function($i) use($data) {
            if($i->lookup_code == 20 && $data['transportOwner'] != '') {
                $i->description = $data['transportOwner']->transport_owner_name;
            }
            return $i;
        });
        if(request()->ajax() && request()->type == 'prepare_order_number') {
            $data['orderPrepare'] = OrderHeaders::join('ptom_customers', 'ptom_customers.customer_id', '=', 'ptom_order_headers.customer_id')
            ->whereNotNull('ptom_order_headers.prepare_order_number')
            // ->whereNotNull("ptom_order_headers.order_status")
            // ->whereRaw("lower(ptom_order_headers.order_status) != 'draft'")
            // ->whereNull('ptom_order_headers.deleted_at')
            ->whereRaw("lower(ptom_customers.sales_classification_code) = 'domestic'")
            // ->whereRaw("lower(
            //     (
            //         SELECT ptom_order_history.order_status
            //         FROM ptom_order_history
            //         WHERE ptom_order_headers.order_header_id = ptom_order_history.order_header_id
            //         ORDER BY ptom_order_history.order_history_id DESC OFFSET 0 ROWS FETCH NEXT 1 ROWS ONLY
            //     )
            // ) != 'draft' ")
            ->limit(100)
            ->when(request()->search != '', function($q) {
                $search = request()->search;
                $q->where('prepare_order_number', 'LIKE', "%{$search}%");
            })
            ->when(request()->customer_id != 0 , function($q) {
                $cus = request()->customer_id;
                $q->where('ptom_customers.customer_id', $cus);
            })
            ->where('ptom_order_headers.program_code','!=','OMP0020')
            ->orderBy('ptom_order_headers.order_header_id','DESC')
            // ->whereRaw("TRUNC(order_date) between  TO_DATE('" . now()->addMonth('-3')->startOfWeek()->format('d/m/Y'). "', 'DD/MM/YYYY') AND  TO_DATE('" . now()->endoFweek()->format('d/m/Y'). "', 'DD/MM/YYYY')")
            ->get();
            return $data['orderPrepare'];
        }
        
        if(request()->ajax() && request()->type == 'order_number') {

                $data['orderNumber'] = OrderHeaders::join('ptom_customers', 'ptom_customers.customer_id', '=', 'ptom_order_headers.customer_id')
                ->whereRaw("lower(ptom_customers.sales_classification_code) = 'domestic'")
                ->whereNotNull("ptom_order_headers.order_status")
                // ->whereRaw("lower(ptom_order_headers.order_status) != 'draft'")
                ->whereNotNull('ptom_order_headers.order_number')
                // ->whereNotNull('ptom_order_headers.prepare_order_number')
                ->whereNull('ptom_order_headers.deleted_at')
                ->whereRaw("lower(
                    (
                        SELECT ptom_order_history.order_status
                        FROM ptom_order_history
                        WHERE ptom_order_headers.order_header_id = ptom_order_history.order_header_id
                        ORDER BY ptom_order_history.order_history_id DESC OFFSET 0 ROWS FETCH NEXT 1 ROWS ONLY
                    )
                ) != 'draft' ")
                ->when(request()->customer_id > 0 , function($q) {
                    $cus = request()->customer_id;
                    $q->where('ptom_customers.customer_id', $cus);
                })
                ->limit(100)
                ->when(request()->search != '', function($q) {
                    $search = request()->search;
                    $q->where('order_number', 'LIKE', "%{$search}%");
                })
                // ->whereRaw("TRUNC(order_date) between  TO_DATE('" . now()->addMonth('-2')->startOfWeek()->format('d/m/Y'). "', 'DD/MM/YYYY') AND  TO_DATE('" . now()->endoFweek()->format('d/m/Y'). "', 'DD/MM/YYYY')")
                ->where('ptom_order_headers.program_code','!=','OMP0020')
                ->orderBy('ptom_order_headers.order_header_id','DESC')
                ->get();
            return $data['orderNumber'];
        }
        $attachmentFile = [];
        $program_code = 'OMP0019';
        // var_dump($data['shipmentBy']);
        // print_r($getLastNum);
        // $data = Order::leftJoin('PTOM_ORDER_PERIOD_HEADERS', 'PTOM_ORDER_HEADERS.PERIOD_ID', '=', 'PTOM_ORDER_PERIOD_HEADERS.PERIOD_ID')
        //     ->leftJoin('PTOM_CUSTOMERS', 'PTOM_ORDER_HEADERS.CUSTOMER_ID', '=', 'PTOM_CUSTOMERS.CUSTOMER_ID')
        //     ->where('PREPARE_ORDER_NUMBER', '!=', NULL)
        //     ->orderBy('ORDER_HEADER_ID')->get();
        // // $data=[];
        return view('om.preparation.index',compact(['data'],'attachmentFile', 'program_code'));
    }

    public function search() {


        $data['customers'] = Customers::byCustomerDomestic();

        $data['paymenType'] = PaymentType::get();

        $program_code = 'OMP0019';

        $data['paymentMethod'] = PaymentMethodDomestic::get();
        $data['shipmentBy'] = ShipmentBy::where('tag','D')->get();
        $data['creditGroup'] = CreditGroup::get();
        $data['transactionType'] = TransactionTypeV::whereRaw("lower(sales_type) = 'domestic'")->whereNotNull('receivables_transaction_type')->get();
        $data['salesChannel'] = SalesChannelV::get();

        $data['order'] = OrderHeaders::where('prepare_order_number',request()->prepare_order_number)->orderBy('order_header_id','DESC')->first();
        $data['orderLastStatus'] = OrderRepo::lastOrdersStatus($data['order']->order_header_id);

        $dateNow = Carbon::createFromFormat('Y-m-d H:i:s', $data['order']->delivery_date)->format('Y-m-d');
        $data['transportOwner'] = DB::table('ptom_transport_owners')->where('stop_flag', 'N')
        ->whereRaw("to_date('{$dateNow}', 'YYYY-MM-DD') BETWEEN start_date AND end_date")
        ->first();
        $data['shipmentBy'] = $data['shipmentBy']->map(function($i) use($data) {
            if($i->lookup_code == 20 && $data['transportOwner'] != '') {
                $i->description = $data['transportOwner']->transport_owner_name;
            }
            return $i;
        });

        $attachmentFile = AttachFiles::where('attachment_program_code','OMP0019')->where('header_id',$data['order']->order_header_id)->whereNull('deleted_at')->get();

        $customer_id = $data['order']->customer_id;
        $data['customersOrder'] = Customers::byCustomerId($customer_id);
        $data['contractGroups'] = OrderRepo::getCustomerContractGroups($customer_id);
        $credit_amount = $data['order']->credit_amount;

        foreach ($data['contractGroups'] as $key => $item) {
            $item->use_amount = 0;

            $orderCredit = OrderCreditGroup::where('order_header_id',$data['order']->order_header_id)->where('credit_group_code',$item->credit_group_code)->first();
            if(!is_null($orderCredit)){
                $item->view_amount = $orderCredit->amount;
                $item->view_received_amount = $orderCredit->received_amount;
                $item->view_remaining_amount = $orderCredit->remaining_amount;
            }else{
                $item->view_amount = 0;
                $item->view_received_amount = 0;
                $item->view_remaining_amount = 0;
            }
        }

        foreach ($data['contractGroups'] as $key => $item) {

            $orderCredit = OrderCreditGroup::where('order_header_id',$data['order']->order_header_id)->where('credit_group_code',$item->credit_group_code)->first();
            if(!is_null($orderCredit) && $orderCredit->amount != 0){
                if ($credit_amount != null && $credit_amount != 0) {
                    $credit_amount -= $item->remaining_amount;
                    if($credit_amount > 0){
                        $item->use_amount = $item->remaining_amount;
                    }else{
                        $item->use_amount = $item->remaining_amount + $credit_amount;
                        break;
                    }
                }else{
                    $item->use_amount = 0;
                }
            }

        }

        $data['creditGroup'] = CreditGroup::get();
        $data['dayAmount'] = [];
        $data['dayAmountActive'] = '';
        $data['dayAmountUse'] = 0;
        foreach ($data['creditGroup'] as $key => $v) {
            $day_amount = CustomerContractGroups::where('customer_id',$customer_id)->where('credit_group_code',$v->lookup_code)->whereNull('deleted_at')->first();
            if(!is_null($day_amount)){
                if(!is_null($data['order']->pick_release_approve_date)){
                    $date_amount = date('Y-m-d', strtotime($data['order']->pick_release_approve_date."+".$day_amount->day_amount." days"));
                }elseif(!is_null($data['order']->delivery_date)){

                    $date_amount = date('Y-m-d', strtotime($data['order']->delivery_date."+".$day_amount->day_amount." days"));
                }else{
                    $date_amount = date('Y-m-d', strtotime("+".$day_amount->day_amount." days"));
                }

                $orderCredit = OrderCreditGroup::where('order_header_id',$data['order']->order_header_id)->where('order_line_id',0)->where('credit_group_code',$v->lookup_code)->first();
                $amount = 0;
                if(!is_null($orderCredit) && $orderCredit->amount != 0){
                    $use = true;
                    $data['dayAmountUse'] += 1;
                    $data['dayAmountActive'] = dateFormatThai($date_amount);
                    $amount = $orderCredit->amount;
                }else{
                    $use = false;
                }

                $data['dayAmount'][] = [
                    'description'=>$v->description,
                    'credit_group_code'=>$v->lookup_code,
                    'amount'=>$amount,
                    'day_amount'=>$day_amount->day_amount,
                    'date_th'=>dateFormatThai($date_amount),
                    'date'=>$date_amount,
                    'use'=>$use
                ];
            }
        }

        if(!is_null($data['order']->pick_release_approve_date)){
            $date_cash_amount = date('Y-m-d', strtotime($data['order']->pick_release_approve_date));
        }elseif(!is_null($data['order']->delivery_date)){
            $date_cash_amount = date('Y-m-d', strtotime($data['order']->delivery_date));
        }else{
            $date_cash_amount = date('Y-m-d');
        }

        if($data['order']->cash_amount > 0){
            $data['dayAmountUse'] += 1;
            $data['dayAmountActive'] = dateFormatThai($date_cash_amount);
            $use = true;
        }else{
            $use = false;
        }


        $data['dayAmount'][] = [
            'description'=>'เงินสด',
            'credit_group_code'=>0,
            'amount'=>$data['order']->cash_amount,
            'day_amount'=>0,
            'date_th'=>dateFormatThai($date_cash_amount),
            'date'=>date('Y-m-d'),
            'use'=>$use
        ];

        if($data['customersOrder']->customer_type_id == 20){
            $data['contractQuata'] = OrderRepo::getCustomerQuotaHeadersMT($customer_id,$data['order']);
        }else{
            $data['contractQuata'] = OrderRepo::getCustomerQuotaHeaders($customer_id,$data['order']);
        }

        if($data['order']->period_id == 0){
            $data['periodV'] = null;
            $data['budgetYear'] = null;
        }else{
            $data['periodV'] = PeriodV::where('period_line_id',$data['order']->period_id)->first();
            $data['budgetYear'] = ($data['periodV']->budget_year + 543) - 2500;
        }

        $data['shipSite'] = OrderRepo::shipSites($customer_id);

        $data['remainingLimit'] = OrderRepo::getCustomerSumContractGroups($customer_id,'ccg.remaining_amount');

        $data['runOrderLine'] = 0;
        $data['orderLine'] = [];
        $data['orderLineQuota'] = [];
        $data['latest'] = [];
        if ($data['order']->product_type_code == 20) {
            try {

                // $orderLine = OrderRepo::getCustomerQuotaLines($data['order']->order_header_id);
                $orderLine = OrderLines::where('order_header_id',$data['order']->order_header_id)->orderBy('order_line_id','ASC')->get();
                $quotaUse = 0;

                $data['uomList'] = OrderRepo::getProductListTypeCode($customer_id,20);

                // $data['useQuata'] = [];
                // foreach($data['contractQuata'] as $val){
                //     $data['useQuata'][$val['group']->lookup_code] = 0;
                // }
                foreach ($orderLine as $key => $v) {
                    $data['orderLine'][] = $v;
                        $inv = DB::table('PTOM_ONHAND_V')->where('ITEM_CODE', $v->item_code)->get();
                        $onhandsum = 0;
                        foreach ($inv as $_i) {
                            if($_i->transaction_uom_code == 'PTN'){
                                $onhandsum += ($_i->onhand_quantity / 120);
                            }else if($_i->transaction_uom_code != 'CGK'){
                                $onhandsum += ($_i->onhand_quantity / 1000);
                            }else{
                                $onhandsum += $_i->onhand_quantity;
                            }
                        }
                        $v->onhand = $onhandsum;
                    // $data['orderLineQuota'][$v->order_line_id] = OrderRepo::getQuotaOrderLines($customer_id,$v,$data['order']);

                    // $data['orderLine'][$v->item_id]
                    // $data['orderLine']['quata'] = DB::table('ptom_quota_group as cg')->where('enabled_flag','Y')->get(['cg.lookup_code','cg.meaning','cg.tag']);

                    // $data['orderLine'][$v->credit_group_code][$v->quota_line_id][$v->item_id] = $v;
                    // $data['useQuata'][$v->quota_group_code] += $v->order_quantity;

                    $latest = OrderRepo::getLatestOrderLine($v->item_id,$customer_id,$data['order']);
                    if ($latest) {
                        $data['latest'][$v->item_id]['order_date'] = dateFormatThai($latest->order_date);
                        $data['latest'][$v->item_id]['order_quantity'] = number_format($latest->order_quantity,2);
                        $data['latest'][$v->item_id]['order_uom'] = $latest->uom_code . ' ' .$latest->uom;
                    }else{
                        $data['latest'][$v->item_id]['order_date'] = '-';
                        $data['latest'][$v->item_id]['order_quantity'] = '0.00';
                        $data['latest'][$v->item_id]['order_uom'] = '';
                    }

                    $data['runOrderLine'] += 1;
                }

            } catch (\Exception $e) {
                $data['orderLine'] = [];
                foreach($data['contractQuata'] as $val){
                    $historyQuota = CreditAndQuotaRepo::getCustomerQuotaSpending($data['order'],$val['group']);
                    if(!is_null($historyQuota)){
                        $val['received_quota'] = $historyQuota->received_quota;
                        $val['remaining_quota'] = $historyQuota->remaining_quota;
                    }
                    foreach ($val['quota'] as $quota){
                        $quota->quota_use = 0;
                    }
                }
                $data['latest'] = [];
            }

        }else{
            try {

                $orderLine = OrderRepo::getCustomerQuotaLines($data['order']->order_header_id,$data['order']->order_status);
                $quotaUse = 0;
                // $data['useQuata'] = [];
                foreach($data['contractQuata'] as $key => $val){

                    $historyQuota = CreditAndQuotaRepo::getCustomerQuotaSpending($data['order'],$val['group']);
                    if(!is_null($historyQuota)){

                        $data['contractQuata'][$key]['received_quota'] = $historyQuota->received_quota;
                        $data['contractQuata'][$key]['remaining_quota'] = $historyQuota->remaining_quota;
                    }
                    $data['useQuata'][$val['group']->lookup_code] = 0;
                }
                foreach ($orderLine as $key => $v) {
                    $data['orderLine'][] = $v;
                    $data['orderLineQuota'][$v->quota_line_id] = OrderRepo::getQuotaOrderLines($customer_id,$v,$data['order']);

                    // $data['orderLine'][$v->item_id]
                    // $data['orderLine']['quata'] = DB::table('ptom_quota_group as cg')->where('enabled_flag','Y')->get(['cg.lookup_code','cg.meaning','cg.tag']);

                    // $data['orderLine'][$v->credit_group_code][$v->quota_line_id][$v->item_id] = $v;
                    // $data['useQuata'][$v->quota_group_code] += $v->order_quantity;

                    $latest = OrderRepo::getLatestOrderLine($v->item_id,$customer_id,$data['order']);
                    if ($latest) {
                        $data['latest'][$v->item_id]['order_date'] = dateFormatThai($latest->order_date);
                        $data['latest'][$v->item_id]['order_quantity'] = number_format($latest->order_quantity,2);
                    }else{
                        $data['latest'][$v->item_id]['order_date'] = '-';
                        $data['latest'][$v->item_id]['order_quantity'] = '0.00';
                    }

                    $data['runOrderLine'] += 1;
                }

            } catch (\Exception $e) {
                $data['orderLine'] = [];
                foreach($data['contractQuata'] as $val){
                    $historyQuota = CreditAndQuotaRepo::getCustomerQuotaSpending($data['order'],$val['group']);
                    // echo $val['received_quota'];
                    // echo '<br>';
                    if(!is_null($historyQuota)){
                        // echo $historyQuota->received_quota;
                        // echo '<br>';
                        $val['received_quota'] = $historyQuota->received_quota;
                        $val['remaining_quota'] = $historyQuota->remaining_quota;
                    }

                    foreach ($val['quota'] as $quota){
                        $quota->quota_use = 0;
                    }
                }
                $data['latest'] = [];

            }
        }

        $data['orderCreditUse']['credit_amount'] = DB::table('ptom_order_credit_groups as ocg')
        ->where('ocg.order_header_id',$data['order']->order_header_id)
        ->where('ocg.order_line_id',0)
        ->whereNull('deleted_at')->sum('amount');

        $data['orderCreditUse']['received_amount'] = DB::table('ptom_order_credit_groups as ocg')
        ->where('ocg.order_header_id',$data['order']->order_header_id)
        ->where('ocg.order_line_id',0)
        ->whereNull('deleted_at')->sum('received_amount');

        $data['orderCreditUse']['remaining_amount'] = DB::table('ptom_order_credit_groups as ocg')
        ->where('ocg.order_header_id',$data['order']->order_header_id)
        ->where('ocg.order_line_id',0)
        ->whereNull('deleted_at')->sum('remaining_amount');

        // $data['runOrderLine'] = 0;
        // try {
        //     $data['orderLine'] = [];
        //     $data['useQuata'] = [];
        //     foreach($data['contractQuata'] as $val){
        //         $data['useQuata'][$val['group']->lookup_code] = 0;
        //         foreach ($val['quota'] as $quota){
        //             $orderLine = OrderLines::where('order_header_id',$data['order']->order_header_id)
        //             ->where('item_id',$quota->item_id)->orderBy('order_line_id','ASC')->get();
        //             $quotaUse = 0;
        //             foreach ($orderLine as $key => $item) {
        //                 $data['orderLine'][$val['group']->lookup_code][$quota->quota_line_id][$item->item_id] = $item;
        //                 $data['useQuata'][$val['group']->lookup_code] += $item->order_quantity;
        //                 $quotaUse += $item->order_quantity;
        //                 $data['runOrderLine'] += 1;
        //             }

        //             if($quotaUse > $quota->remaining_quota){
        //                 $quota->quota_use = $quota->remaining_quota;
        //             }else{
        //                 $quota->quota_use = $quotaUse;
        //             }

        //             $latest = OrderRepo::getLatestOrderLine($quota->item_id,$customer_id);
        //             if ($latest) {
        //                 $data['latest'][$quota->item_id]['order_date'] = dateFormatThai($latest->order_date);
        //                 $data['latest'][$quota->item_id]['order_quantity'] = number_format($latest->order_quantity,2);
        //             }else{
        //                 $data['latest'][$quota->item_id]['order_date'] = '-';
        //                 $data['latest'][$quota->item_id]['order_quantity'] = '0.00';
        //             }
        //         }
        //     }
        // } catch (\Exception $e) {
        //     $data['orderLine'] = [];
        //     foreach($data['contractQuata'] as $val){
        //         foreach ($val['quota'] as $quota){
        //             $quota->quota_use = 0;
        //         }
        //     }
        // }

        $data['contractBooks'] = OrderRepo::getCustomerContractBooks($customer_id);
        $expireBook = false;
        foreach ($data['contractBooks'] as $key => $v) {
            $date = Carbon::parse($v->book_end_date);
            $now = Carbon::now();
            $diff = $date->diffInDays($now);

            if ($diff <= 30) {
                $data['contractExpireBooks'][] = $v;
            }
        }

        $data['Outstanding'] = collect(OrderRepo::setOutstanding($customer_id,$data['order']->period_id,$data['order']));
        // dd($data['Outstanding']);
        $data['cancel_over_fine_amount'] = 0;
        foreach ($data['Outstanding'] as $key => $v) {
            $data['cancel_over_fine_amount'] += $v['improveAmount'];
        }

        $releaseCredit = ReleaseCredit::where('attribute1',$data['order']->order_header_id)->get();
        $data['Outstanding'] = $data['Outstanding']->map(function($i) use($releaseCredit) {
            if($releaseCredit->where('invoice_num', $i['pick_release_no'])->where('credit_group_code', $i['credit_group_code'])->count() > 0){
                $i['auto_check'] = true;
                $i['flag'] = 'Y';
            } else {
                $i['auto_check'] = false;
                $i['flag'] = 'M';
            }
            return $i;
        });
        return view('om.preparation.search',compact(['data'],'attachmentFile','program_code'));
    }

    public function showcreate () {

        $customerList = DB::table('PTOM_CUSTOMERS')->get();
        $payment_type = DB::table('PTOM_PAYMENT_TYPE')->get();
        $ship_by = DB::table('PTOM_SHIPMENT_BY')->get();
        $payment_method = DB::table('PTOM_PAYMENT_METHOD_DOMESTIC')->get();
        $order_type = DB::table('PTOM_TRANSACTION_TYPES_V')->get();
        $line_items = DB::table('PTOM_SEQUENCE_ECOMS')->get();

        return view('om.preparation.create',compact(['payment_type', 'ship_by','payment_method', 'order_type', 'line_items', 'customerList']));
    }

    public function create (Request $request) {
        $validate = Validator::make($request->all(),[
            'customer_number'          => 'required|string',
        ]);

        if($validate->fails()){
            $rest = [
                'status'    => false,
                'message'      => 'validate',
                'data'      => $validate->errors()
            ];
            return response()->json($rest);
        }else{
            DB::beginTransaction();
            try {

                $dataUser = getDefaultData('/users');

                $now = Carbon::now();
                $periodV = PeriodV::where('start_period','>=', $now)->first();
                $budgetYear = ($periodV->budget_year + 543) - 2500;

                // $prepareNumber = runPrepareNumber(OrderHeaders::getLastPrepareNumber($budgetYear),$budgetYear);

                // $orderNumber = runOrderNumber(OrderHeaders::getLastOrderNumber());

                $orderHeader = new OrderHeaders;

                $customer = Customers::byCustomerNumber($request->customer_number);

                if ($request->order_type == '1065') {
                    $prepareNumber = GenerateNumberRepo::docSequenceNumber('OMP0019_SO_NUM_L_DOM','prepare_order_number');
                    // $orderNumber = GenerateNumberRepo::docSequenceNumber('OMP0003_PO_NUM_L_DOM','order_number');
                }else{
                    $prepareNumber = GenerateNumberRepo::docSequenceNumber('OMP0019_SO_NUM_CG_DOM','prepare_order_number');
                    // $orderNumber = GenerateNumberRepo::docSequenceNumber('OMP0003_PO_NUM_CG_DOM','order_number');
                }



                $overQuota = [];
                $orderHeader->org_id = OrderRepo::orgId();
                // $orderHeader->order_number = $request->order_number;
                // $orderHeader->prepare_order_number = $request->prepare_order_number;
                // $orderHeader->order_number = $orderNumber;
                $orderHeader->attribute6 = $request->attribute6 == 'on';
                $orderHeader->prepare_order_number = $prepareNumber;
                $orderHeader->order_type_id = $request->order_type;
                $orderHeader->customer_id = $customer->customer_id;
                $orderHeader->bill_to_site_id = $customer->customer_id;
                $orderHeader->ship_to_site_id = $request->ship_to_site_id;
                $orderHeader->currency = 'THB';
                $orderHeader->source_system = $request->sales_channel;

                if ($request->order_type == '1065') {
                    $orderHeader->product_type_code = 20;
                }else{
                    $orderHeader->product_type_code = 10;
                }

                $orderHeader->installment_type_code = 10;
                $orderHeader->period_id = $request->period_line;
                $orderHeader->unlock_print_flag = 'N';
                $orderHeader->order_source = 'WEB';
                // $orderHeader->payment_direct_debit_code = $request->payment_direct_debit_code;

                $orderHeader->cust_po_number = $request->cust_po_number;
                $orderHeader->credit_amount = covertNFToFloat($request->credit_amount);
                $orderHeader->grand_total = covertNFToFloat($request->grand_total);

                $cash = 0;
                if($orderHeader->payment_type_code == 10){
                    $orderHeader->cash_amount = covertNFToFloat($request->grand_total);
                    $cash = covertNFToFloat($request->grand_total);
                }else{
                    $orderHeader->cash_amount = covertNFToFloat($request->cash_amount);
                    $cash = covertNFToFloat($request->cash_amount);
                }

                $orderHeader->fines_amount = (covertNFToFloat($request->over_fine_amount));
                $orderHeader->remark = $request->remark;
                $orderHeader->remark_source_system = $request->remark_source_system;

                $orderHeader->payment_type_code = $request->payment_type;
                $orderHeader->payment_method_code = $request->payment_method;

                $orderHeader->transport_type_code = $request->shipment_by;

                // $orderHeader->payment_duedate = dateConvertThaiEng($request->payment_duedate);
                // $orderHeader->order_date = date('Y-m-d');
                $orderHeader->order_date = dateConvertThaiEng($request->order_date);
                $orderHeader->delivery_date = dateConvertThaiEng($request->delivery_date);

                if($request->form_type == 'confirm'){
                    $orderHeader->order_status = 'Confirm';
                }else{
                    $orderHeader->order_status = 'Draft';
                }

                $orderHeader->program_code = 'OMP0019';
                $orderHeader->created_by = $dataUser->user_id;
                $orderHeader->last_updated_by = $dataUser->user_id;

                $orderHeader->price_list_id = $customer->price_list_id;

                $orderHeader->remaining_amount = OrderRepo::sumNotMatch($customer->customer_id);

                $orderHeader->save();

                $customer_id = $customer->customer_id;

                $creditGroupsRemaining = [];
                $creditAmount = [];

                if ($request->order_type == '1065') {

                    $orderHeader = OrderHeaders::where('order_header_id',$orderHeader->getKey())->orderBy('order_header_id','DESC')->first();

                    $tax_amount = 0;
                    $orderCredit = OrderCreditGroup::where('order_header_id',$orderHeader->order_header_id)->where('order_line_id',0)->where('credit_group_code',0)->first();
                    CreditAndQuotaRepo::setOrderCash($orderCredit,$orderHeader,covertNFToFloat($request->cash_amount),'OMP0019');

                    foreach ($request->line_number as $keyline => $vline) {

                        if(isset($request->line_number[$keyline]) && $request->unit_price[$keyline] != 0){

                            $orderLine = OrderLines::where('order_header_id',$orderHeader->order_header_id)->where('line_number',$request->line_number[$keyline])->where('item_id',$request->item_id[$keyline])->whereNull('promo_flag')->first();
                            if (!isset($orderLine) || empty($orderLine)) {
                                $orderLine = new OrderLines();
                            }

                            $inData = true;

                            $line_program_code = $request->program_code[$keyline];
                            $line_number = $request->line_number[$keyline];

                            $unit_price = $request->unit_price[$keyline];


                            $order_quantity = ($request->order_quantity[$keyline] != '') ? $request->order_quantity[$keyline] : null;

                            $approve_quantity = ($request->approve_quantity[$keyline] != '') ? $request->approve_quantity[$keyline] : null;

                            // $max_amount = $request->items['max_amount'][$keyline];
                            $sum_amount = covertNFToFloat($request->sum_amount[$keyline]);
                            $total_amount = covertNFToFloat($request->sum_amount[$keyline]);

                            $orderLine->order_header_id = $orderHeader->order_header_id;
                            $orderLine->line_number = $line_number;

                            $prodItem = OrderRepo::getProductListTypeCodeItemid($customer_id,20,$request->item_id[$keyline]);

                            $orderLine->item_id = $prodItem->item_id;
                            $orderLine->item_code = $prodItem->item_code;
                            $orderLine->item_description = $prodItem->item_description;

                            $orderLine->attribute2 = $prodItem->price_unit;

                            $orderLine->uom_code = $prodItem->product_uom_code;
                            $orderLine->uom = $prodItem->unit_of_measure;
                            $orderLine->credit_group_code = 0;

                            $orderLine->order_quantity = !is_null($order_quantity) ? $order_quantity : null;
                            $orderLine->unit_price = $unit_price;

                            $orderLine->approve_quantity = !is_null($approve_quantity) ? $approve_quantity : null;
                            $orderLine->amount = $sum_amount;
                            $orderLine->program_code = $line_program_code;
                            $orderLine->created_by = auth()->user()->user_id; // 1;
                            $orderLine->last_updated_by = auth()->user()->user_id; // 1;
                            $orderLine->total_amount = number_format($total_amount, 2, ".", "");

                            $tax = 0;
                            if(!is_null($orderHeader->order_type_id)){
                                $calTax = OrderRepo::calTaxDomestic($orderLine->order_quantity,$orderLine->item_id,$orderHeader->order_type_id,$orderHeader->customer_id);
                                $orderLine->tax_amount = number_format((float)$calTax['amount'], 5, '.', '');
                                $orderLine->attribute1 = $calTax['operand'];
                                $tax_amount += $calTax['amount'];
                            }else{
                                if(!is_null($customer->order_type_id)){
                                    $calTax = OrderRepo::calTaxDomestic($orderLine->order_quantity,$orderLine->item_id,$customer->order_type_id,$orderHeader->customer_id);
                                    $orderLine->tax_amount = number_format((float)$calTax['amount'], 5, '.', '');
                                    $orderLine->attribute1 = $calTax['operand'];
                                    $tax_amount += $calTax['amount'];
                                }
                            }

                            // day amount
                            $dayAmountRepo = OrderRepo::setTermDayAmount($orderHeader,$customer,0);

                            $orderLine->day_amount = $dayAmountRepo['day_amount'];
                            if($orderHeader->payment_type_code == 10){
                                $orderLine->credit_group_code = 0;
                            }else{
                                $orderLine->credit_group_code = $dayAmountRepo['credit_group_code'];
                            }
                            // day amount

                            $orderLine->save();

                            OrderRepo::amountCreditGroupCash(
                                $orderHeader->order_header_id,
                                $orderLine->getKey(),
                                $total_amount,
                                'OMP0019'
                            );

                        }else{

                            $orderLine = OrderLines::where('order_header_id',$orderHeader->order_header_id)->where('line_number',$request->line_number[$keyline])->where('item_id',$request->item_id[$keyline])->whereNull('promo_flag')->first();
                            if (!isset($orderLine) || empty($orderLine)) {
                                $orderLine = new OrderLines();
                            }

                            $inData = true;

                            $line_program_code = $request->program_code[$keyline];
                            $line_number = $request->line_number[$keyline];

                            $unit_price = $request->unit_price[$keyline];


                            $order_quantity = ($request->order_quantity[$keyline] != '') ? $request->order_quantity[$keyline] : null;

                            $approve_quantity = ($request->approve_quantity[$keyline] != '') ? $request->approve_quantity[$keyline] : null;

                            // $max_amount = $request->items['max_amount'][$keyline];
                            $sum_amount = covertNFToFloat($request->sum_amount[$keyline]);
                            $total_amount = covertNFToFloat($request->sum_amount[$keyline]);

                            $orderLine->order_header_id = $orderHeader->order_header_id;
                            $orderLine->line_number = $line_number;

                            $prodItem = OrderRepo::getProductListTypeCodeItemid($customer_id,20,$request->item_id[$keyline]);

                            $orderLine->item_id = $prodItem->item_id;
                            $orderLine->item_code = $prodItem->item_code;
                            $orderLine->item_description = $prodItem->item_description;
                            $orderLine->attribute2 = $prodItem->price_unit;

                            $orderLine->uom_code = $prodItem->product_uom_code;
                            $orderLine->uom = $prodItem->unit_of_measure;
                            $orderLine->credit_group_code = 0;

                            $orderLine->order_quantity = !is_null($order_quantity) ? number_format($order_quantity, 2, ".", "") : null;
                            $orderLine->unit_price = $unit_price;
                            $orderLine->approve_quantity = !is_null($approve_quantity) ? number_format($approve_quantity, 2, ".", "") : null;
                            $orderLine->amount = $sum_amount;
                            $orderLine->total_amount = number_format($total_amount, 2, ".", "");

                            $dayAmountRepo = OrderRepo::setTermDayAmount($orderHeader,$customer,0);

                            $orderLine->day_amount = $dayAmountRepo['day_amount'];

                            $orderLine->program_code = 'OMP0019';
                            $orderLine->created_by = auth()->user()->user_id; // 1;
                            $orderLine->last_updated_by = auth()->user()->user_id; // 1;
                            $orderLine->tax_amount = 0;
                            $orderLine->promo_flag = 'Y';

                            $orderLine->save();
                        }

                    }

                    $orderHeader->tax = number_format((float)$tax_amount, 2, '.', '');
                    $orderHeader->sub_total = covertNFToFloat($request->grand_total) - number_format((float)$tax_amount, 2, '.', '');

                }else{
                    try {
                        foreach ($request->outstanding_id as $key => $val) {

                            if(!is_null($val)){
                                $exp = explode('_',$val);

                                $outstandingData = OutstandingDebtDomesticV::where(function($query) use ($exp){
                                    $query->where('pick_release_no',$exp[0]);
                                    $query->orWhere('consignment_no',$exp[0]);
                                })->where('credit_group_code',$exp[1])->where('pick_release_status','Confirm')->first();

                                $releaseCredit = new ReleaseCredit();
                                $releaseCredit->attribute1 = $orderHeader->order_header_id;
                                $releaseCredit->customer_id = $customer->customer_id;
                                $releaseCredit->invoice_id = $outstandingData->order_header_id;
                                $releaseCredit->invoice_num = $outstandingData->pick_release_no;
                                $releaseCredit->due_date = $outstandingData->due_date;
                                $releaseCredit->amount = $outstandingData->outstanding_debt;
                                $releaseCredit->credit_group_code = $outstandingData->credit_group_code;
                                $releaseCredit->charge_amount = 0.00;
                                $releaseCredit->payment_flag = 'Y';
                                $releaseCredit->created_by = auth()->user()->user_id; // 1;
                                $releaseCredit->last_updated_by = auth()->user()->user_id; // 1;
                                $releaseCredit->program_code = 'OMP0019';
                                $releaseCredit->save();

                                $customerContractGroups = CustomerContractGroups::where('credit_group_code',$outstandingData->credit_group_code)->where('customer_id',$customer->customer_id)->whereNull('deleted_at')->first();

                                $remaining_amount = $customerContractGroups->remaining_amount + $outstandingData->outstanding_debt;
                                if($remaining_amount > $customerContractGroups->credit_amount){
                                    $remaining_amount = $customerContractGroups->credit_amount;
                                }

                                if($customerContractGroups->remaining_amount < $customerContractGroups->credit_amount){
                                    DB::table('ptom_customer_contract_groups')
                                    ->where('credit_group_code',$outstandingData->credit_group_code)
                                    ->where('customer_id',$customer->customer_id)
                                    ->whereNull('deleted_at')
                                    ->update(array(
                                        'remaining_amount'=>(($remaining_amount < 0) ? 0 : $remaining_amount),
                                    ));
                                }

                            }
                        }
                    }catch (\Exception $e) {}

                    try {
                        foreach ($request->cancel_outstanding_id as $key => $val) {
                            if(!is_null($val)){
                                $exp = explode('_',$val);

                                $outstandingData = OutstandingDebtDomesticV::where(function($query) use ($exp){
                                    $query->where('pick_release_no',$exp[0]);
                                    $query->orWhere('consignment_no',$exp[0]);
                                })->where('credit_group_code',$exp[1])->where('pick_release_status','Confirm')->first();


                                $orderPeriod = OrderHeaders::where('order_header_id',$outstandingData->order_header_id)->orderBy('order_header_id','DESC')->first();

                                $penalty = OrderRepo::getPenalty($customer->customer_id,$outstandingData->pick_release_no,$outstandingData->credit_group_code);

                                if($outstandingData->customer_type_id == 30 && $outstandingData->product_type_code == 10){
                                    $improceFines = ImproveFines::where('invoice_id',$consignmentHeaders->consignment_header_id)->where('credit_group_code',$outstandingData->credit_group_code)->where('invoice_number',$outstandingData->consignment_no)->first();

                                    if(is_null($improve)){
                                        $improceFines = new ImproveFines();
                                    }
                                }else{
                                    $improceFines = ImproveFines::where('invoice_id',$orderPeriod->order_header_id)->where('credit_group_code',$outstandingData->credit_group_code)->where('invoice_number',$outstandingData->pick_release_no)->first();

                                    if(is_null($improve)){
                                        $improceFines = new ImproveFines();
                                    }
                                }

                                if($outstandingData->customer_type_id == 30 && $outstandingData->product_type_code == 10){
                                    $consignmentHeaders = DB::table('ptom_consignment_headers')
                                    ->where('consignment_no',$outstandingData->consignment_no)
                                    ->whereNull('deleted_at')->first();
                                    $improceFines->invoice_id = $consignmentHeaders->consignment_header_id;
                                    $improceFines->invoice_number = $outstandingData->consignment_no;
                                }else{
                                    $improceFines->period_id = $orderPeriod->period_id;
                                    $improceFines->invoice_id = $orderPeriod->order_header_id;
                                    $improceFines->invoice_number = $outstandingData->pick_release_no;
                                }

                                $improceFines->attribute1 = $orderHeader->order_header_id;
                                $improceFines->invoice_amount = $orderPeriod->grand_total;
                                $improceFines->remaining_amount = 0;
                                $improceFines->order_date = $orderHeader->order_date;
                                $improceFines->due_date = $outstandingData->due_date;
                                $improceFines->credit_group_code = $outstandingData->credit_group_code;
                                $improceFines->total_fine = $penalty;
                                $improceFines->total_fine_due = $penalty;
                                $improceFines->except_interest_days = 0;
                                $improceFines->cancel_flag = 'Y';
                                $improceFines->created_by = auth()->user()->user_id; // 1;
                                $improceFines->last_updated_by = auth()->user()->user_id; // 1;
                                $improceFines->program_code = 'OMP0019';
                                $improceFines->save();

                            }
                        }
                    }catch (\Exception $e) {}

                    $contractGroups = OrderRepo::getCustomerContractGroups($customer_id);
                    if(count($contractGroups) > 0 && $orderHeader->payment_type_code != 10){
                        $creditGroupsRemaining = [];
                        $creditGroups = [];
                        foreach($contractGroups as $val){
                            $creditGroupsRemaining[$val->credit_group_code] = $val->remaining_amount;
                            $creditGroups[$val->credit_group_code] = $val;
                            $orderCredit = OrderCreditGroup::where('order_header_id',$orderHeader->order_header_id)->where('order_line_id',0)->where('credit_group_code',$val->credit_group_code)->first();
                            CreditAndQuotaRepo::setOrderCredit($orderCredit,$orderHeader,$val,'OMP0019',0);
                            $creditAmount[$val->credit_group_code] = 0;
                        }

                        if(covertNFToFloat($request->cash_amount) > 0){
                            $orderCredit = OrderCreditGroup::where('order_header_id',$orderHeader->order_header_id)->where('order_line_id',0)->where('credit_group_code',0)->first();
                            CreditAndQuotaRepo::setOrderCash($orderCredit,$orderHeader,covertNFToFloat($request->cash_amount),'OMP0019');
                        }
                    }else{
                        $orderCredit = OrderCreditGroup::where('order_header_id',$orderHeader->order_header_id)->where('order_line_id',0)->where('credit_group_code',0)->first();
                        CreditAndQuotaRepo::setOrderCash($orderCredit,$orderHeader,0,'OMP0019');
                        $creditAmount[0] = 0;
                    }

                    if($customer->customer_type_id == 20){
                        $contractQuata = OrderRepo::getCustomerQuotaHeadersMT($customer->customer_id,null,dateConvertThaiEng($request->delivery_date));
                    }else{
                        $contractQuata = OrderRepo::getCustomerQuotaHeaders($customer->customer_id,null,dateConvertThaiEng($request->delivery_date));
                    }

                    $tax_amount = 0;

                    foreach($contractQuata as $val){
                        $overQuota[$val['group']->lookup_code] = 0;

                        CreditAndQuotaRepo::setCustomerQuota($orderHeader,$val);

                        $spending_approve_quota = 0;
                        $spending_order_quota = 0;

                        foreach ($val['quota'] as $quota){

                            try {


                                foreach ($request->line_number[$val['group']->lookup_code][$quota->quota_line_id][$quota->item_id] as $keyline => $vline) {

                                    if(isset($request->line_number[$val['group']->lookup_code][$quota->quota_line_id][$quota->item_id][$keyline]) && $request->unit_price[$val['group']->lookup_code][$quota->quota_line_id][$quota->item_id][$keyline] != 0){

                                        $orderLine = new OrderLines();

                                        $inData = true;
                                        $group_key = $val['group']->lookup_code;
                                        $quota_key = $quota->quota_line_id;
                                        $item_key = $quota->item_id;

                                        $line_number = $request->line_number[$group_key][$quota_key][$item_key][$keyline];

                                        $unit_price = $request->unit_price[$group_key][$quota_key][$item_key][$keyline];


                                        $order_quantity = ($request->order_quantity[$group_key][$quota_key][$item_key][$keyline] != '') ? $request->order_quantity[$group_key][$quota_key][$item_key][$keyline] : null;
                                        $order_cardboardbox = ($request->chest_amount[$group_key][$quota_key][$item_key][$keyline] != '') ? $request->chest_amount[$group_key][$quota_key][$item_key][$keyline] : null;
                                        $order_carton = ($request->wrap_amount[$group_key][$quota_key][$item_key][$keyline] != '') ? $request->wrap_amount[$group_key][$quota_key][$item_key][$keyline] : null;


                                        $approve_quantity = ($request->order_quantity_approve[$group_key][$quota_key][$item_key][$keyline] != '') ? $request->order_quantity_approve[$group_key][$quota_key][$item_key][$keyline] : null;
                                        $approve_cardboardbox = ($request->approve_chest_amount[$group_key][$quota_key][$item_key][$keyline] != '') ? $request->approve_chest_amount[$group_key][$quota_key][$item_key][$keyline] : null;
                                        $approve_carton = ($request->approve_wrap_amount[$group_key][$quota_key][$item_key][$keyline] != '') ? $request->approve_wrap_amount[$group_key][$quota_key][$item_key][$keyline] : null;

                                        // $max_amount = $request->items['max_amount'][$group_key][$quota_key][$item_key][$keyline];
                                        $sum_amount = covertNFToFloat($request->sum_amount[$group_key][$quota_key][$item_key][$keyline]);
                                        $total_amount = covertNFToFloat($request->sum_amount[$group_key][$quota_key][$item_key][$keyline]);


                                        $unit_price = $request->unit_price[$group_key][$quota_key][$item_key][$keyline];
                                        // $diff_quantity = 0;
                                        // $remaining_quota = $quota->remaining_quota - $order_quantity;
                                        // if ($order_quantity > $quota->remaining_quota) {
                                        //     $diff_quantity = $order_quantity - $quota->remaining_quota;
                                        //     $overQuota = [];
                                        //     // $remaining_quota = 0;
                                        // }

                                        $overQuota[$val['group']->lookup_code] += $order_quantity;

                                        $orderLine->order_header_id = $orderHeader->getKey();
                                        $orderLine->line_number = $line_number;
                                        $orderLine->quota_line_id = $quota->quota_line_id;

                                        $orderLine->item_id = $quota->item_id;
                                        $orderLine->item_code = $quota->item_code;
                                        $orderLine->item_description = $quota->item_description;
                                        $orderLine->attribute2 = $quota->price_unit;
                                        // $orderLine->unit_price = covertNFToFloat($request->unit_price[$val['group']->lookup_code][$quota->quota_line_id][$quota->item_id]);

                                        $orderLine->uom_code = 'CGK';
                                        $orderLine->uom = 'พันมวน';
                                        $orderLine->quota_credit_id = $quota->quota_credit_id;
                                        $orderLine->credit_group_code = $quota->credit_group_code;
                                        // $orderLine->order_quantity = $order_quantity;
                                        // $orderLine->order_cardboardbox = $order_cardboardbox;
                                        // $orderLine->order_carton = $order_carton;

                                        // $orderLine->approve_quantity = $approve_quantity;
                                        // $orderLine->approve_cardboardbox = $approve_cardboardbox;
                                        // $orderLine->approve_carton = $approve_carton;

                                        $orderLine->order_quantity = !is_null($order_quantity) ? number_format($order_quantity, 2, ".", "") : null;
                                        $orderLine->order_cardboardbox = !is_null($order_cardboardbox) ? $order_cardboardbox : null;
                                        $orderLine->order_carton = !is_null($order_carton) ? $order_carton : null;

                                        $approve_quantity = ($approve_cardboardbox  / 0.1) + ($approve_carton * 0.2);

                                        $orderLine->approve_quantity = number_format($approve_quantity, 2, ".", "");
                                        $orderLine->approve_cardboardbox = !is_null($approve_cardboardbox) ? $approve_cardboardbox : null;
                                        $orderLine->approve_carton = !is_null($approve_carton) ? $approve_carton : null;

                                        $orderLine->unit_price = $unit_price;
                                        if($request->unit_price[$val['group']->lookup_code][$quota->quota_line_id][$quota->item_id] == 0){
                                            $orderLine->promo_flag = 'Y';
                                        }

                                        $orderLine->amount = $sum_amount;


                                        $orderLine->program_code = 'OMP0019';
                                        $orderLine->created_by = $dataUser->user_id;
                                        $orderLine->last_updated_by = $dataUser->user_id;
                                        if($unit_price == 0){
                                            $orderLine->promo_flag = 'Y';
                                        }

                                        $tax = 0;
                                        if(!is_null($orderHeader->order_type_id)){
                                            $calTax = OrderRepo::calTaxDomestic($orderLine->order_quantity,$orderLine->item_id,$orderHeader->order_type_id,$orderHeader->customer_id);
                                            $orderLine->tax_amount = number_format((float)$calTax['amount'], 5, '.', '');
                                            $orderLine->attribute1 = $calTax['operand'];
                                            $tax_amount += $calTax['amount'];
                                        }else{
                                            if(!is_null($customer->order_type_id)){
                                                $calTax = OrderRepo::calTaxDomestic($orderLine->order_quantity,$orderLine->item_id,$customer->order_type_id,$orderHeader->customer_id);
                                                $orderLine->tax_amount = number_format((float)$calTax['amount'], 5, '.', '');
                                                $orderLine->attribute1 = $calTax['operand'];
                                                $tax_amount += $calTax['amount'];
                                            }
                                        }

                                        // $orderLine->total_amount = (float)$total_amount + (float)$tax;
                                        $orderLine->total_amount = number_format($total_amount, 2, ".", "");

                                        // day amount
                                        $dayAmountRepo = OrderRepo::setTermDayAmount($orderHeader,$customer,$quota->credit_group_code);

                                        $orderLine->day_amount = $dayAmountRepo['day_amount'];
                                        if($orderHeader->payment_type_code == 10){
                                            $orderLine->credit_group_code = 0;
                                        }else{
                                            $orderLine->credit_group_code = $dayAmountRepo['credit_group_code'];
                                        }
                                        // day amount

                                        $orderLine->save();

                                        if(count($contractGroups) > 0 && $orderHeader->payment_type_code != 10){
                                            $creditAmount[$quota->credit_group_code] += number_format($total_amount, 2, ".", "");
                                        }else{
                                            $creditAmount[0] += number_format($total_amount, 2, ".", "");
                                        }

                                        if($unit_price == 0){
                                            $orderLine->promo_flag = 'Y';
                                        }else{

                                            $orderLine->quota_credit_id = $quota->quota_credit_id;

                                            $spending_approve_quota += $approve_quantity;
                                            $spending_order_quota += $order_quantity;

                                            if((covertNFToFloat($request->credit_amount) == 0 && $cash != 0) || $quota->credit_group_code == 0){
                                                OrderRepo::amountCreditGroupCash(
                                                    $orderHeader->order_header_id,
                                                    $orderLine->getKey(),
                                                    $total_amount,
                                                    'OMP0019'
                                                );
                                            }else{

                                                $orderLine->credit_group_code = $quota->credit_group_code;

                                                $remaining_quota = ($quota->remaining_quota + $spending_order_quota) - $spending_approve_quota;

                                                CreditAndQuotaRepo::updateCustomerQuotaRefund($quota,$remaining_quota);

                                                OrderRepo::amountCreditGroupv2(
                                                    $orderHeader->order_header_id,
                                                    $orderLine->getKey(),
                                                    $creditGroupsRemaining,
                                                    $quota,
                                                    $creditGroups,
                                                    $total_amount,
                                                    'OMP0019'
                                                );

                                                $creditGroupsRemaining[$quota->credit_group_code] -= number_format($total_amount, 2, ".", "");
                                                if($creditGroupsRemaining[$quota->credit_group_code] < 0){
                                                    $creditGroupsRemaining[$quota->credit_group_code] = 0;
                                                }

                                            }

                                            if($request->form_type == 'confirm'){
                                                $remaining_quota_cal = $quota->remaining_quota - $order_quantity;

                                                DB::table('ptom_customer_quota_lines')
                                                ->where('quota_header_id',$quota->quota_header_id)
                                                ->where('quota_line_id',$quota->quota_line_id)
                                                ->where('item_id',$quota->item_id)
                                                ->whereNull('deleted_at')
                                                ->update(array(
                                                    'remaining_quota'=>$remaining_quota_cal,
                                                ));

                                            }
                                        }

                                        $orderLine->save();
                                    }
                                }

                            }catch (\Exception $e) {
                                // Log::error($e);
                            }

                        }
                        CreditAndQuotaRepo::updateCustomerQuotaSpending($orderHeader,$val['group'],$spending_approve_quota);

                    }

                    foreach ($request->line_number as $key1 => $v1) {
                        foreach ($v1 as $key2 => $v2) {
                            foreach ($v2 as $key3 => $v3) {
                                foreach ($v3 as $key4 => $v4) {

                                    if(isset($request->line_number[$key1][$key2][$key3][$key4]) && $request->unit_price[$key1][$key2][$key3][$key4] == 0){
                                        $response['line'][] = $request->line_number[$key1][$key2][$key3][$key4];
                                        $orderLine = OrderLines::where('order_header_id',$orderHeader->order_header_id)->where('item_id',$key3)->where('promo_flag','Y')->first();
                                        if (!isset($orderLine) || empty($orderLine)) {
                                            $orderLine = new OrderLines();
                                        }

                                        $sequenceEcom = SequenceEcoms::where('item_id',$key3)->where('deleted_at',NULL)->whereRaw("lower(sale_type_code) = 'domestic' ")->first();

                                        $line_number = $request->line_number[$key1][$key2][$key3][$key4];

                                        $unit_price = $request->unit_price[$key1][$key2][$key3][$key4];


                                        $order_quantity = ($request->order_quantity[$key1][$key2][$key3][$key4] != '') ? $request->order_quantity[$key1][$key2][$key3][$key4] : null;
                                        $order_cardboardbox = ($request->chest_amount[$key1][$key2][$key3][$key4] != '') ? $request->chest_amount[$key1][$key2][$key3][$key4] : null;
                                        $order_carton = ($request->wrap_amount[$key1][$key2][$key3][$key4] != '') ? $request->wrap_amount[$key1][$key2][$key3][$key4] : null;


                                        $approve_quantity = ($request->order_quantity_approve[$key1][$key2][$key3][$key4] != '') ? $request->order_quantity_approve[$key1][$key2][$key3][$key4] : null;
                                        $approve_cardboardbox = ($request->approve_chest_amount[$key1][$key2][$key3][$key4] != '') ? $request->approve_chest_amount[$key1][$key2][$key3][$key4] : null;
                                        $approve_carton = ($request->approve_wrap_amount[$key1][$key2][$key3][$key4] != '') ? $request->approve_wrap_amount[$key1][$key2][$key3][$key4] : null;

                                        $sum_amount = covertNFToFloat($request->sum_amount[$key1][$key2][$key3][$key4]);
                                        $total_amount = covertNFToFloat($request->sum_amount[$key1][$key2][$key3][$key4]);

                                        $orderLine->order_header_id = $orderHeader->order_header_id;
                                        $orderLine->line_number = $key4;
                                        $orderLine->quota_line_id = 0;
                                        $orderLine->item_id = $sequenceEcom->item_id;
                                        $orderLine->item_code = $sequenceEcom->item_code;
                                        $orderLine->item_description = $sequenceEcom->ecom_item_description;

                                        $orderLine->uom_code = 'CGK';
                                        $orderLine->uom = 'พันมวน';

                                        $orderLine->order_quantity = !is_null($order_quantity) ? number_format($order_quantity, 2, ".", "") : null;
                                        $orderLine->order_cardboardbox = !is_null($order_cardboardbox) ? $order_cardboardbox : null;
                                        $orderLine->order_carton = !is_null($order_carton) ? $order_carton : null;
                                        $orderLine->unit_price = $unit_price;

                                        $approve_quantity = ($approve_cardboardbox  / 0.1) + ($approve_carton * 0.2);
                                        $orderLine->approve_quantity = number_format($approve_quantity, 2, ".", "");
                                        $orderLine->approve_cardboardbox = !is_null($approve_cardboardbox) ? $approve_cardboardbox : null;
                                        $orderLine->approve_carton = !is_null($approve_carton) ? $approve_carton : null;

                                        $orderLine->amount = $sum_amount;
                                        $orderLine->total_amount = number_format($total_amount, 2, ".", "");
                                        $orderLine->program_code = 'OMP0019';
                                        $orderLine->created_by = auth()->user()->user_id; // 1;
                                        $orderLine->last_updated_by = auth()->user()->user_id; // 1;
                                        $orderLine->tax_amount = 0;
                                        $orderLine->promo_flag = 'Y';

                                        $orderLine->save();

                                    }
                                }
                            }
                        }
                    }

                    $orderHeader = OrderHeaders::where('order_header_id',$orderHeader->getKey())->orderBy('order_header_id','DESC')->first();

                    $orderLineTax = OrderLines::where('order_header_id',$orderHeader->order_header_id)->where('tax_amount','!=',0)->sum('tax_amount');

                    // $tax_amount_res = $tax_amount;
                    $orderHeader->tax = number_format((float)$orderLineTax, 2, '.', '');
                    $orderHeader->sub_total = covertNFToFloat($request->grand_total) - number_format((float)$tax_amount, 2, '.', '');

                    if(count($contractGroups) > 0 && $orderHeader->payment_type_code != 10){

                        
                        $countOrderRemaining = DB::table('oaom.ptom_order_remaining')->where('order_header_id', $orderHeader->order_header_id)->count();
                                if($countOrderRemaining === 0) {
                                    DB::table('oaom.ptom_order_remaining')->insert(
                                        [
                                            'order_header_id' => $orderHeader->order_header_id
                                            ,'org_id' => 81
                                            ,'program_code' => 'OMP0019'
                                            ,'group2_amount' => 0
                                            ,'group2_remaining' => 0
                                            ,'group3_amount' => 0
                                            ,'group3_remaining' => 0
                                            ,'created_by' => auth()->user()->user_id
                                            ,'last_updated_by' => auth()->user()->user_id
                                            
                                        ]
                                    );
                                }
                        foreach($contractGroups as $val){
                            $orderCredit = OrderCreditGroup::where('order_header_id',$orderHeader->order_header_id)->where('credit_group_code',$val->credit_group_code)->where('order_line_id',0)->first();

                            CreditAndQuotaRepo::updateCustomerContractRefund($val,$orderHeader,$orderCredit);  // คืนเงินเชื่อ

                            $set_amount[] = CreditAndQuotaRepo::updateCustomerContractDeduct($val,$orderHeader,$orderCredit,$creditAmount);  // หักเงินเชื่อ

                        }
                    }else{
                        DB::table('ptom_order_credit_groups')
                        ->where('order_header_id',$orderHeader->order_header_id)
                        ->where('order_line_id',0)
                        ->where('credit_group_code',0)
                        ->update(array(
                            'amount'=>$creditAmount[0]
                        ));
                    }
                }
                if(empty($creditAmount)) {
                    $creditAmount = [];
                }
                if(empty($set_amount)) {
                    $set_amount = [];
                }
                $replac_cash = (float)array_sum($creditAmount)- (float)array_sum($set_amount);

                DB::table('ptom_order_credit_groups')
                ->where('order_header_id',$orderHeader->order_header_id)
                ->where('credit_group_code',0)
                ->where('order_line_id',0)
                ->update(array(
                    'amount'=>(($replac_cash < 0) ? 0 : $replac_cash),
                ));


                $orderHeader->credit_amount = (float)array_sum($set_amount);

                // replace cash amount
                $orderHeader->cash_amount = (float)$orderHeader->grand_total - (float)array_sum($set_amount);

                // update header_id to attach file data W. 03/02/23
                if ($request->attachment_id) {

                    $attachmentIds = explode(',', $request->attachment_id);
    
                    foreach ($attachmentIds as $value) {
                        $attachmentData = AttachFiles::where('attachment_id', $value)->where('attachment_program_code', 'OMP0019')->first();
                        $attachmentData->header_id = $orderHeader->order_header_id;
                        $attachmentData->save();
                    }
                }

                if($request->hasFile('attachment')) {
                    $fileAttachment = $request->file('attachment');
                    AttachmentRepo::uploadAttachmentMultiple($fileAttachment,$orderHeader->getKey(),'OMP0019');
                }

                if($request->form_type == 'confirm'){
                    $orderHeader->pick_release_print_flag = NULL;
                    $orderHeader->unlock_print_flag = 'Y';
                    $orderHeader->save();
                    OrderRepo::insertOrdersHistoryv2($orderHeader,'Inprocess');
                    try {
                        DirectDebitRepo::updateOrderDirectDebot($orderHeader);
                    }catch (\Exception $e) {}
                }else{
                    $orderHeader->save();
                    OrderRepo::insertOrdersHistoryv2($orderHeader,'Draft');
                }

                DB::commit();

                if($request->form_type == 'confirm'){
                    $checkWMS = DB::table('PTOM_ORDER_T_WMS')->where('oaom_order_header_id',$orderHeader->order_header_id)->first();
                    if(is_null($checkWMS)){
                        GenerateNumberRepo::callWMSPackagePrepare($orderHeader->order_header_id,$orderHeader->prepare_order_number);
                    }
                }

                return response()->json(['data'=>$orderLineTax,'order_number'=>'','prepare_order_number'=>$prepareNumber,'status'=>true]);

            }catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['data'=>$request->all(),'message'=>$e->getMessage(),'status'=>false]);
                // return redirect()->back();
            }
        }
    }

    public function update (Request $request) {

        $validate = Validator::make($request->all(),[
            'prepare_order_number'          => 'required|string',
        ]);
        if($validate->fails()){
            $rest = [
                'status'    => false,
                'message'      => 'validate',
                'data'      => $validate->errors()
            ];
            return response()->json($rest);
        }else{
            DB::beginTransaction();
            $overQuota = [];
            $messageError = [];
            $outstanding = [];

            $response = [];


            // return response()->json(['data'=>[],'status'=>false,'message'=>$response]);

            try {

                // OAOM.PTOM_ORDER_REMAINING

                $orderHeader = OrderHeaders::where('prepare_order_number',$request->prepare_order_number)->orderBy('order_header_id','DESC')->first();
                


                // if($orderHeader->order_status == 'Confirm' && $request->form_type == "approve"){
                //         $orderHeader->pick_release_print_flag = NULL;
                //         $orderHeader->unlock_print_flag = 'Y';
                //         $orderHeader->save();
                //         OrderRepo::insertOrdersHistoryv2($orderHeader,'Inprocess');

                //         $checkWMS = DB::table('PTOM_ORDER_T_WMS')->where('oaom_order_header_id',$orderHeader->order_header_id)->first();
                //         if(is_null($checkWMS)){
                //             GenerateNumberRepo::callWMSPackagePrepare($orderHeader->order_header_id,$orderHeader->prepare_order_number);
                //         }

                //         try {
                //             DirectDebitRepo::updateOrderDirectDebot($orderHeader);
                //         }catch (\Exception $e) {}

                // }else{
                    $customer = Customers::byCustomerNumber($request->customer_number);

                    // $orderHeader->org_id = '81';
                    // $orderHeader->order_number = $request->order_number;
                    // $orderHeader->prepare_order_number = $request->prepare_order_number;
                    $orderHeader->order_type_id = $request->order_type;
                    // $orderHeader->customer_id = $customer->customer_id;
                    // $orderHeader->bill_to_site_id = $customer->customer_id;
                    $orderHeader->ship_to_site_id = $request->ship_to_site_id;
                    // $orderHeader->currency = 'THB';
                    $orderHeader->source_system = $request->sales_channel;
                    // $orderHeader->product_type_code = 0;
                    // $orderHeader->period_id = $request->period_no;
                    // $orderHeader->order_source = 'WEB';
                    // $orderHeader->payment_direct_debit_code = $request->payment_direct_debit_code;

                    $cash = 0;
                    if($orderHeader->payment_type_code == 10){
                        $orderHeader->cash_amount = covertNFToFloat($request->grand_total);
                        $cash = covertNFToFloat($request->grand_total);
                    }else{
                        $orderHeader->cash_amount = covertNFToFloat($request->cash_amount);
                        $cash = covertNFToFloat($request->cash_amount);
                    }

                    $orderHeader->cust_po_number = $request->cust_po_number;
                    $orderHeader->attribute6 = $request->attribute6 == 'on';

                    $orderHeader->credit_amount = covertNFToFloat($request->credit_amount);
                    $orderHeader->grand_total = covertNFToFloat($request->grand_total);
                    $orderHeader->fines_amount = (covertNFToFloat($request->over_fine_amount));
                    $orderHeader->remark = $request->remark;
                    $orderHeader->remark_source_system = $request->remark_source_system;

                    $orderHeader->payment_type_code = $request->payment_type;
                    $orderHeader->payment_method_code = $request->payment_method;

                    $orderHeader->transport_type_code = $request->shipment_by;

                    // $orderHeader->payment_duedate = dateConvertThaiEng($request->payment_duedate);
                    $orderHeader->order_date = dateConvertThaiEng($request->order_date);
                    $orderHeader->delivery_date = dateConvertThaiEng($request->delivery_date);

                    if($request->form_type == "confirm" || $request->form_type == "approve"){
                        $orderHeader->order_status = 'Confirm';
                    }else{
                        $orderHeader->order_status = 'Draft';
                    }

                    $orderHeader->program_code = 'OMP0019';
                    $orderHeader->created_by = auth()->user()->user_id; // 1;
                    $orderHeader->last_updated_by = auth()->user()->user_id; //1;


                    $customer_id = $customer->customer_id;

                    if ($orderHeader->product_type_code == 20) {

                        $orderCredit = OrderCreditGroup::where('order_header_id',$orderHeader->order_header_id)->where('order_line_id',0)->where('credit_group_code',0)->first();
                        CreditAndQuotaRepo::setOrderCash($orderCredit,$orderHeader,covertNFToFloat($request->cash_amount),'OMP0019');

                        $tax_amount = 0;

                        foreach ($request->line_number as $keyline => $vline) {

                            if(isset($request->line_number[$keyline]) && $request->unit_price[$keyline] != 0){

                                $orderLine = OrderLines::where('order_header_id',$orderHeader->order_header_id)->where('line_number',$request->line_number[$keyline])->where('item_code',$request->item_id[$keyline])->whereNull('promo_flag')->first();
                                if (is_null($orderLine)) {
                                    $orderLine = new OrderLines();
                                }

                                $inData = true;

                                $line_program_code = $request->program_code[$keyline];
                                $line_number = $request->line_number[$keyline];

                                $unit_price = $request->unit_price[$keyline];


                                $order_quantity = ($request->order_quantity[$keyline] != '') ? $request->order_quantity[$keyline] : null;

                                $approve_quantity = ($request->approve_quantity[$keyline] != '') ? $request->approve_quantity[$keyline] : null;

                                // $max_amount = $request->items['max_amount'][$keyline];
                                $sum_amount = covertNFToFloat($request->sum_amount[$keyline]);
                                $total_amount = covertNFToFloat($request->sum_amount[$keyline]);

                                $orderLine->order_header_id = $orderHeader->order_header_id;
                                $orderLine->line_number = $line_number;

                                $prodItem = OrderRepo::getProductListTypeCodeItemid($customer_id,20,$request->item_id[$keyline]);

                                $orderLine->item_id = $prodItem->item_id;
                                $orderLine->item_code = $prodItem->item_code;
                                $orderLine->item_description = $prodItem->item_description;

                                $orderLine->attribute2 = $prodItem->price_unit;
                                // $orderLine->uom_code = $prodItem->product_uom_code;
                                // $orderLine->uom = $prodItem->unit_of_measure;

                                $orderLine->order_quantity = !is_null($order_quantity) ? $order_quantity : null;
                                $orderLine->unit_price = $unit_price;
                                $orderLine->approve_quantity = !is_null($approve_quantity) ? $approve_quantity : null;
                                $orderLine->amount = $sum_amount;
                                $orderLine->program_code = $line_program_code;
                                $orderLine->created_by = auth()->user()->user_id; // 1;
                                $orderLine->last_updated_by = auth()->user()->user_id; // 1;
                                $orderLine->total_amount = number_format($total_amount, 2, ".", "");

                                $orderLine->credit_group_code = 0;
                                $tax = 0;
                                if(!is_null($orderHeader->order_type_id)){
                                    $calTax = OrderRepo::calTaxDomestic($orderLine->approve_quantity,$orderLine->item_id,$orderHeader->order_type_id,$orderHeader->customer_id);
                                    $orderLine->tax_amount = number_format((float)$calTax['amount'], 5, '.', '');
                                    $orderLine->attribute1 = $calTax['operand'];
                                    $tax_amount += $calTax['amount'];
                                }else{
                                    if(!is_null($customer->order_type_id)){
                                        $calTax = OrderRepo::calTaxDomestic($orderLine->approve_quantity,$orderLine->item_id,$customer->order_type_id,$orderHeader->customer_id);
                                        $orderLine->tax_amount = number_format((float)$calTax['amount'], 5, '.', '');
                                        $orderLine->attribute1 = $calTax['operand'];
                                        $tax_amount += $calTax['amount'];
                                    }
                                }

                                $orderLine->save();

                                OrderRepo::amountCreditGroupCash(
                                    $orderHeader->order_header_id,
                                    $orderLine->getKey(),
                                    $total_amount,
                                    'OMP0019'
                                );

                            }

                            $response[] = $request->line_number[$keyline];
                        }

                        $orderHeader->tax = number_format((float)$tax_amount, 2, '.', '');
                        $orderHeader->sub_total = covertNFToFloat($request->grand_total) - number_format((float)$tax_amount, 2, '.', '');

                        $orderHeader->save();

                    }else{
                        $orderHeader->remaining_amount = OrderRepo::sumNotMatch($customer->customer_id);

                        $tax_amount = 0;

                        if($orderHeader->installment_type_code == 10){
                            // คืนวงเงินก่อน ค่อยตัดใหม่
                            $orderCreditGroup = OrderCreditGroup::where('order_header_id',$orderHeader->order_header_id)->where('order_line_id',0)->where('credit_group_code','!=',0)->get();
                            foreach ($orderCreditGroup as $key => $v) {
                                $customerContractGroups = CustomerContractGroups::where('credit_group_code',$v->credit_group_code)->where('customer_id',$orderHeader->customer_id)->whereNull('deleted_at')->first();
                                $remaining_amount = $customerContractGroups->remaining_amount + $v->amount;

                                if($v->amount >= $customerContractGroups->credit_amount){
                                    $remaining_amount = $customerContractGroups->credit_amount;
                                }

                                DB::table('ptom_customer_contract_groups')
                                ->where('credit_group_code',$v->credit_group_code)
                                ->where('customer_id',$orderHeader->customer_id)
                                ->whereNull('deleted_at')
                                ->update(array(
                                    'remaining_amount'=>(($remaining_amount < 0) ? 0 : $remaining_amount),
                                ));
                            }
                            // คืนวงเงินก่อน ค่อยตัดใหม่


                            try {
                                // ลบหนี้ค้างที่เปลี่ยน
                                foreach ($request->outstanding_rm as $key => $val) {
                                    if(!is_null($val)){
                                        $exp = explode('_',$val);

                                        $outstandingData = OutstandingDebtDomesticV::where('pick_release_no',$exp[0])->where('credit_group_code',$exp[1])->where('pick_release_status','Confirm')->first();

                                        $release = ReleaseCredit::where('attribute1',$orderHeader->order_header_id)->where('customer_id',$customer->customer_id)->where('invoice_id',$outstandingData->order_header_id)->where('credit_group_code',$exp[1])->first();

                                        if(!is_null($release)){
                                            $customerContractGroups = CustomerContractGroups::where('credit_group_code',$release->credit_group_code)->where('customer_id',$customer->customer_id)->whereNull('deleted_at')->first();
                                            $remaining_amount = $customerContractGroups->remaining_amount - $release->amount;
                                            //

                                            DB::table('ptom_customer_contract_groups')
                                            ->where('credit_group_code',$outstandingData->credit_group_code)
                                            ->where('customer_id',$customer->customer_id)
                                            ->whereNull('deleted_at')
                                            ->update(array(
                                                'remaining_amount'=>(($remaining_amount < 0) ? 0 : $remaining_amount),
                                            ));

                                            $release->delete();
                                        }

                                    }
                                }
                                // ลบหนี้ค้างที่เปลี่ยน

                                // หนี้ค้างที่เลือก
                                foreach ($request->outstanding_id as $key => $val) {

                                    if(!is_null($val)){

                                        $exp = explode('_',$val);

                                        $outstandingData = OutstandingDebtDomesticV::where(function($query) use ($exp){
                                            $query->where('pick_release_no',$exp[0]);
                                            $query->orWhere('consignment_no',$exp[0]);
                                        })->where('credit_group_code',$exp[1])->where('pick_release_status','Confirm')->first();

                                        if($outstandingData->credit_group_code != 0){

                                            $releaseCredit = ReleaseCredit::where('attribute1',$orderHeader->order_header_id)->where('customer_id',$customer->customer_id)->where('invoice_id',$outstandingData->order_header_id)->where('credit_group_code',$exp[1])->first();
                                            if(is_null($releaseCredit)){
                                                $releaseCredit = new ReleaseCredit();
                                            }

                                            $releaseCredit->customer_id = $customer->customer_id;
                                            $releaseCredit->attribute1 = $orderHeader->order_header_id;
                                            $releaseCredit->invoice_id = $outstandingData->order_header_id;
                                            $releaseCredit->invoice_num = $outstandingData->pick_release_no;
                                            $releaseCredit->due_date = $outstandingData->due_date;
                                            $releaseCredit->amount = $outstandingData->outstanding_debt;
                                            $releaseCredit->credit_group_code = $outstandingData->credit_group_code;
                                            $releaseCredit->charge_amount = 0.00;
                                            $releaseCredit->payment_flag = 'Y';
                                            $releaseCredit->created_by = auth()->user()->user_id; // 1;
                                            $releaseCredit->last_updated_by = auth()->user()->user_id; // 1;
                                            $releaseCredit->program_code = 'OMP0019';
                                            $releaseCredit->save();

                                            $customerContractGroups = CustomerContractGroups::where('credit_group_code',$outstandingData->credit_group_code)->whereNull('deleted_at')->where('customer_id',$customer->customer_id)->first();

                                            $remaining_amount = $customerContractGroups->remaining_amount + $outstandingData->outstanding_debt;
                                            if($remaining_amount > $customerContractGroups->credit_amount){
                                                $remaining_amount = $customerContractGroups->credit_amount;
                                            }

                                        // if($customerContractGroups->remaining_amount < $customerContractGroups->credit_amount){
                                            DB::table('ptom_customer_contract_groups')
                                            ->where('credit_group_code',$outstandingData->credit_group_code)
                                            ->where('customer_id',$customer->customer_id)
                                            ->whereNull('deleted_at')
                                            ->update(array(
                                                'remaining_amount'=>(($remaining_amount < 0) ? 0 : $remaining_amount),
                                            ));
                                        // }
                                        }

                                    }
                                }
                                // หนี้ค้างที่เลือก
                            }catch (\Exception $e) {}

                            try {
                                foreach ($request->cancel_outstanding_id as $key => $val) {
                                    if(!is_null($val)){
                                        $exp = explode('_',$val);

                                        $outstandingData = OutstandingDebtDomesticV::where(function($query) use ($exp){
                                            $query->where('pick_release_no',$exp[0]);
                                            $query->orWhere('consignment_no',$exp[0]);
                                        })->where('credit_group_code',$exp[1])->where('pick_release_status','Confirm')->first();


                                        $orderPeriod = OrderHeaders::where('order_header_id',$outstandingData->order_header_id)->orderBy('order_header_id','DESC')->first();

                                        $penalty = OrderRepo::getPenalty($customer->customer_id,$outstandingData->pick_release_no,$outstandingData->credit_group_code);

                                        $improceFines = new ImproveFines();

                                        if($outstandingData->customer_type_id == 30 && $outstandingData->product_type_code == 10){
                                            $consignmentHeaders = DB::table('ptom_consignment_headers')
                                            ->where('consignment_no',$outstandingData->consignment_no)
                                            ->whereNull('deleted_at')->first();
                                            $improceFines->invoice_id = $consignmentHeaders->consignment_header_id;
                                            $improceFines->invoice_number = $outstandingData->consignment_no;
                                        }else{
                                            $improceFines->period_id = $orderPeriod->period_id;
                                            $improceFines->invoice_id = $orderPeriod->order_header_id;
                                            $improceFines->invoice_number = $outstandingData->pick_release_no;
                                        }

                                        $improceFines->attribute1 = $orderHeader->order_header_id;
                                        $improceFines->invoice_amount = $orderPeriod->grand_total;
                                        $improceFines->remaining_amount = 0;
                                        $improceFines->order_date = $orderHeader->order_date;
                                        $improceFines->due_date = $outstandingData->due_date;
                                        $improceFines->credit_group_code = $outstandingData->credit_group_code;
                                        $improceFines->total_fine = $penalty;
                                        $improceFines->total_fine_due = $penalty;
                                        $improceFines->except_interest_days = 0;
                                        $improceFines->cancel_flag = 'Y';
                                        $improceFines->created_by = auth()->user()->user_id; // 1;
                                        $improceFines->last_updated_by = auth()->user()->user_id; // 1;
                                        $improceFines->program_code = 'OMP0019';
                                        $improceFines->save();

                                    }
                                }
                            }catch (\Exception $e) {}

                            $creditGroups = [];
                            $creditAmount = [];

                            // $contractGroups = OrderRepo::getCustomerContractGroups($customer->customer_id);
                            $creditGroupsRemaining = [];

                            $contractGroups = OrderRepo::getCustomerContractGroups($customer_id);


                            if(count($contractGroups) > 0 && $orderHeader->payment_type_code != 10){
                                $creditGroupsRemaining = [];
                                $creditGroups = [];
                                foreach($contractGroups as $val){
                                    // $creditGroupsRemaining[$val->credit_group_code] = $val->remaining_amount;

                                    if(strlen($orderHeader->delivery_date) == '19') {
                                        $odelivery_date = Carbon::createFromFormat('Y-m-d H:i:s',$orderHeader->delivery_date)->format('d/m/Y');
                                    } else {
                                        $odelivery_date = Carbon::createFromFormat('Y-m-d',$orderHeader->delivery_date)->format('d/m/Y');
                                    }
                                    $invDue = [];
                                    if(!empty(request()->outstanding_id)) {
                                        foreach(request()->outstanding_id as $key => $item) {
                                                $invDue[] = explode('_',$key)[0];
                                        }
                                    }
                                    $releaseCreditPluck = ReleaseCredit::where('customer_id',$customerContractGroups->customer_id)
                                                    ->whereIn('invoice_num',$invDue)
                                                    ->where('credit_group_code',$val->credit_group_code)
                                                    ->get();
                                    $c = (new OrderEcomController)->reCalculateRemainingAmountV2($customerContractGroups->customer_id,
                                                                $odelivery_date,
                                                                $orderHeader->period_id,
                                                                $releaseCreditPluck->pluck('invoice_num')->toArray());
                                    $remaining_base = $c['cusContractGroup']->where('credit_group_code', $val->credit_group_code)->first();
                                    $remaining_base =  $remaining_base->credit_amount * ($remaining_base->credit_percentage / 100);
                                    $ptOmDebtDomV = $c['ptOmDebtDomV']->where('credit_group_code', $val->credit_group_code)->sum('outstanding_debt');
                                    $debtDomV = $c['debtDomV']->where('credit_group_code', $val->credit_group_code)->sum('outstanding_debt');
                                    $orderHeaders = $c['orderHeaders']->where('credit_group_code', $val->credit_group_code)->where('prepare_order_number', '!=', $orderHeader->prepare_order_number)->sum('amount');
                                    $new_remaining_amount = $remaining_base - $ptOmDebtDomV - $orderHeaders + $debtDomV;
                                    $creditGroupsRemaining[$val->credit_group_code] = $new_remaining_amount;


                                    $creditGroups[$val->credit_group_code] = $val;
                                    $orderCredit = OrderCreditGroup::where('order_header_id',$orderHeader->order_header_id)->where('order_line_id',0)->where('credit_group_code',$val->credit_group_code)->first();
                                    CreditAndQuotaRepo::setOrderCredit($orderCredit,$orderHeader,$val,'OMP0019',0);
                                    $creditAmount[$val->credit_group_code] = 0;
                                }

                                if(covertNFToFloat($request->cash_amount) > 0){
                                    $orderCredit = OrderCreditGroup::where('order_header_id',$orderHeader->order_header_id)->where('order_line_id',0)->where('credit_group_code',0)->first();
                                    CreditAndQuotaRepo::setOrderCash($orderCredit,$orderHeader,covertNFToFloat($request->cash_amount),'OMP0019');
                                }
                            }else{
                                $orderCredit = OrderCreditGroup::where('order_header_id',$orderHeader->order_header_id)->where('order_line_id',0)->where('credit_group_code',0)->first();
                                CreditAndQuotaRepo::setOrderCash($orderCredit,$orderHeader,0,'OMP0019');
                                $creditAmount[0] = 0;
                            }

                            $contractGroups = OrderRepo::getCustomerContractGroups($customer_id);
                            $response['contractGroups'] = $contractGroups;

                            // foreach($contractGroups as $val){
                            //     $creditGroupsRemaining[$val->credit_group_code] = $val->remaining_amount;
                            //     $creditAmount[$val->credit_group_code] = 0;
                            //     $creditGroups[$val->credit_group_code] = $val;
                            // }


                            if($customer->customer_type_id == 20){
                                $contractQuata = OrderRepo::getCustomerQuotaHeadersMT($customer->customer_id,$orderHeader);
                            }else{
                                $contractQuata = OrderRepo::getCustomerQuotaHeaders($customer->customer_id,$orderHeader);
                            }

                            try {
                                if(isset($request->line_remove[0])){
                                    print_r($request->line_remove[0]);
                                    $line_remove = explode(',',$request->line_remove[0]);
                                    foreach($line_remove as $val){
                                        $orderLine = OrderLines::where('order_line_id',$val)->first();
                                        if(!is_null($orderLine)){
                                            $orderLine->delete();
                                        }

                                    }
                                }
                            }catch (\Exception $e) {}
                            $promo = [];
                            foreach($contractQuata as $val){
                                $inData = false;
                                $overQuota[$val['group']->lookup_code] = 0;

                                CreditAndQuotaRepo::setCustomerQuota($orderHeader,$val);

                                $spending_approve_quota = 0;
                                $spending_order_quota = 0;

                                foreach ($val['quota'] as $quota){

                                    try {
                                        foreach ((array)@$request->line_number[$val['group']->lookup_code][$quota->quota_line_id][$quota->item_id] as $keyline => $vline) {

                                            if(isset($request->line_number[$val['group']->lookup_code][$quota->quota_line_id][$quota->item_id][$keyline]) && $request->unit_price[$val['group']->lookup_code][$quota->quota_line_id][$quota->item_id][$keyline] != 0){

                                                $orderLine = OrderLines::where('order_header_id',$orderHeader->order_header_id)->where('item_id',$quota->item_id)->whereNull('promo_flag')->first();
                                                if (!isset($orderLine) || empty($orderLine)) {
                                                    $orderLine = new OrderLines();
                                                }

                                                $inData = true;
                                                $group_key = $val['group']->lookup_code;
                                                $quota_key = $quota->quota_line_id;
                                                $item_key = $quota->item_id;

                                                $line_program_code = $request->program_code[$group_key][$quota_key][$item_key][$keyline];
                                                $line_number = $request->line_number[$group_key][$quota_key][$item_key][$keyline];

                                                $unit_price = $request->unit_price[$group_key][$quota_key][$item_key][$keyline];


                                                $order_quantity = ($request->order_quantity[$group_key][$quota_key][$item_key][$keyline] != '') ? $request->order_quantity[$group_key][$quota_key][$item_key][$keyline] : null;
                                                $order_cardboardbox = ($request->chest_amount[$group_key][$quota_key][$item_key][$keyline] != '') ? $request->chest_amount[$group_key][$quota_key][$item_key][$keyline] : null;
                                                $order_carton = ($request->wrap_amount[$group_key][$quota_key][$item_key][$keyline] != '') ? $request->wrap_amount[$group_key][$quota_key][$item_key][$keyline] : null;


                                                $approve_quantity = ($request->order_quantity_approve[$group_key][$quota_key][$item_key][$keyline] != '') ? $request->order_quantity_approve[$group_key][$quota_key][$item_key][$keyline] : null;
                                                $approve_cardboardbox = ($request->approve_chest_amount[$group_key][$quota_key][$item_key][$keyline] != '') ? $request->approve_chest_amount[$group_key][$quota_key][$item_key][$keyline] : null;
                                                $approve_carton = ($request->approve_wrap_amount[$group_key][$quota_key][$item_key][$keyline] != '') ? $request->approve_wrap_amount[$group_key][$quota_key][$item_key][$keyline] : null;

                                                // $max_amount = $request->items['max_amount'][$group_key][$quota_key][$item_key][$keyline];
                                                $sum_amount = covertNFToFloat($request->sum_amount[$group_key][$quota_key][$item_key][$keyline]);
                                                $total_amount = covertNFToFloat($request->sum_amount[$group_key][$quota_key][$item_key][$keyline]);


                                                // $diff_quantity = 0;
                                                // $remaining_quota = $quota->remaining_quota - $order_quantity;
                                                // if ($order_quantity > $quota->remaining_quota) {
                                                //     $diff_quantity = $order_quantity - $quota->remaining_quota;
                                                //     // $remaining_quota = 0;
                                                //     $response['diff'] = true;
                                                // }

                                                $orderLine->order_header_id = $orderHeader->order_header_id;
                                                // $orderLine->line_number = $quota->quota_line_id;
                                                $orderLine->line_number = $line_number;
                                                $orderLine->quota_line_id = $quota->quota_line_id;
                                                $orderLine->item_id = $quota->item_id;
                                                $orderLine->item_code = $quota->item_code;
                                                $orderLine->item_description = $quota->item_description;

                                                $orderLine->attribute2 = $quota->price_unit;
                                                // $orderLine->unit_price = covertNFToFloat($request->unit_price[$val['group']->lookup_code][$quota->quota_line_id][$quota->item_id]);
                                                $orderLine->uom_code = 'CGK';
                                                $orderLine->uom = 'พันมวน';
                                                $orderLine->order_quantity = !is_null($order_quantity) ? number_format($order_quantity, 2, ".", "") : null;
                                                $orderLine->order_cardboardbox = !is_null($order_cardboardbox) ? $order_cardboardbox : null;
                                                $orderLine->order_carton = !is_null($order_carton) ? $order_carton : null;
                                                $orderLine->unit_price = $unit_price;

                                                $approve_quantity = ($approve_cardboardbox  / 0.1) + ($approve_carton * 0.2);
                                                $overQuota[$val['group']->lookup_code] += !is_null($approve_quantity) ? $approve_quantity : 0;

                                                $orderLine->approve_quantity = number_format($approve_quantity, 2, ".", "");
                                                $orderLine->approve_cardboardbox = !is_null($approve_cardboardbox) ? $approve_cardboardbox : null;
                                                $orderLine->approve_carton = !is_null($approve_carton) ? $approve_carton : null;

                                                // $orderLine->diff_quantity = $diff_quantity;
                                                $orderLine->amount = $sum_amount;

                                                $orderLine->program_code = $line_program_code;
                                                $orderLine->created_by = auth()->user()->user_id; // 1;
                                                $orderLine->last_updated_by = auth()->user()->user_id; // 1;

                                                $tax = 0;
                                                if(!is_null($orderHeader->order_type_id)){
                                                    $calTax = OrderRepo::calTaxDomestic($orderLine->approve_quantity,$orderLine->item_id,$orderHeader->order_type_id,$orderHeader->customer_id);
                                                    $orderLine->tax_amount = number_format((float)$calTax['amount'], 5, '.', '');
                                                    $orderLine->attribute1 = $calTax['operand'];
                                                    $tax_amount += $calTax['amount'];
                                                }else{
                                                    if(!is_null($customer->order_type_id)){
                                                        $calTax = OrderRepo::calTaxDomestic($orderLine->approve_quantity,$orderLine->item_id,$customer->order_type_id,$orderHeader->customer_id);
                                                        $orderLine->tax_amount = number_format((float)$calTax['amount'], 5, '.', '');
                                                        $orderLine->attribute1 = $calTax['operand'];
                                                        $tax_amount += $calTax['amount'];
                                                    }
                                                }
                                               ################################################################### debug ค่า
                                                // dump([$orderLine->approve_quantity,  $calTax['amount']]);

                                                // $orderLine->total_amount = $total_amount + $tax;
                                                $orderLine->total_amount = number_format($total_amount, 2, ".", "");

                                                if($unit_price == 0){
                                                    $orderLine->promo_flag = 'Y';
                                                }

                                                  // day amount
                                                $dayAmountRepo = OrderRepo::setTermDayAmount($orderHeader,$customer,$quota->credit_group_code);

                                                $orderLine->day_amount = $dayAmountRepo['day_amount'];
                                                if($orderHeader->payment_type_code == 10){
                                                    $orderLine->credit_group_code = 0;
                                                }else{
                                                    $orderLine->credit_group_code = $dayAmountRepo['credit_group_code'];
                                                }
                                                // day amount

                                                $orderLine->save();

                                                if(count($contractGroups) > 0 && $orderHeader->payment_type_code != 10){
                                                    $creditAmount[$quota->credit_group_code] += number_format($total_amount, 2, ".", "");
                                                }else{
                                                    $creditAmount[0] += number_format($total_amount, 2, ".", "");
                                                }

                                                if($unit_price == 0){
                                                    $orderLine->promo_flag = 'Y';
                                                }else{

                                                    $orderLine->quota_credit_id = $quota->quota_credit_id;

                                                    $spending_approve_quota += !is_null($approve_quantity) ? $approve_quantity : 0;
                                                    $spending_order_quota += !is_null($order_quantity) ? $order_quantity : 0;

                                                    if((covertNFToFloat($request->credit_amount) == 0 && $cash != 0) || $quota->credit_group_code == 0){
                                                        OrderRepo::amountCreditGroupCash(
                                                            $orderHeader->order_header_id,
                                                            $orderLine->getKey(),
                                                            $total_amount,
                                                            'OMP0019'
                                                        );
                                                    }else{

                                                        $orderLine->credit_group_code = $quota->credit_group_code;

                                                        $remaining_quota = ($quota->remaining_quota + $spending_order_quota) - $spending_approve_quota;

                                                        if(is_null($orderHeader->order_number)){
                                                            CreditAndQuotaRepo::updateCustomerQuotaRefund($quota,$remaining_quota);
                                                        }

                                                        OrderRepo::amountCreditGroupv2(
                                                            $orderHeader->order_header_id,
                                                            $orderLine->getKey(),
                                                            $creditGroupsRemaining,
                                                            $quota,
                                                            $creditGroups,
                                                            $total_amount,
                                                            'OMP0019'
                                                        );

                                                        $creditGroupsRemaining[$quota->credit_group_code] -= number_format($total_amount, 2, ".", "");
                                                        if($creditGroupsRemaining[$quota->credit_group_code] < 0){
                                                            $creditGroupsRemaining[$quota->credit_group_code] = 0;
                                                        }
                                                    }

                                                    if($request->form_type == 'confirm' && is_null($orderHeader->order_number)){
                                                        $remaining_quota_cal = $quota->remaining_quota - $approve_quantity;

                                                        DB::table('ptom_customer_quota_lines')
                                                        ->where('quota_header_id',$quota->quota_header_id)
                                                        ->where('quota_line_id',$quota->quota_line_id)
                                                        ->where('item_id',$quota->item_id)
                                                        ->whereNull('deleted_at')
                                                        ->update(array(
                                                            'remaining_quota'=>$remaining_quota_cal,
                                                        ));

                                                    }
                                                }

                                                $orderLine->save();

                                                // DB::commit();

                                            }

                                            $response[] = $request->line_number[$group_key][$quota_key][$item_key][$keyline];
                                        }

                                    }catch (\Exception $e) {
                                        $messageError[] = $e->getMessage();
                                    }
                                }

                                CreditAndQuotaRepo::updateCustomerQuotaSpending($orderHeader,$val['group'],$spending_approve_quota);

                                // if($overQuota[$val['group']->lookup_code] > $val['remaining_quota'] && $inData){

                                //     $orderHeader = OrderHeaders::where('order_header_id',$orderHeader->order_header_id)->orderBy('order_header_id','DESC')->first();
                                //     $orderHeader->order_status = 'Draft';
                                //     $orderHeader->save();

                                //     OrderRepo::additionQuota($orderHeader->order_header_id,$customer,$val,$overQuota);
                                // }

                            }

                            foreach ($request->line_number as $key1 => $v1) {
                                foreach ($v1 as $key2 => $v2) {
                                    foreach ($v2 as $key3 => $v3) {
                                        foreach ($v3 as $key4 => $v4) {

                                            if(isset($request->line_number[$key1][$key2][$key3][$key4]) && $request->unit_price[$key1][$key2][$key3][$key4] == 0){
                                                $response['line'][] = $request->line_number[$key1][$key2][$key3][$key4];
                                                $orderLine = OrderLines::where('order_header_id',$orderHeader->order_header_id)->where('item_id',$key3)->where('promo_flag','Y')->first();
                                                if (!isset($orderLine) || empty($orderLine)) {
                                                    $orderLine = new OrderLines();
                                                }

                                                $sequenceEcom = SequenceEcoms::where('item_id',$key3)->where('deleted_at',NULL)->whereRaw("lower(sale_type_code) = 'domestic' ")->first();

                                                $line_program_code = $request->program_code[$key1][$key2][$key3][$key4];
                                                $line_number = $request->line_number[$key1][$key2][$key3][$key4];

                                                $unit_price = $request->unit_price[$key1][$key2][$key3][$key4];


                                                $order_quantity = ($request->order_quantity[$key1][$key2][$key3][$key4] != '') ? $request->order_quantity[$key1][$key2][$key3][$key4] : null;
                                                $order_cardboardbox = ($request->chest_amount[$key1][$key2][$key3][$key4] != '') ? $request->chest_amount[$key1][$key2][$key3][$key4] : null;
                                                $order_carton = ($request->wrap_amount[$key1][$key2][$key3][$key4] != '') ? $request->wrap_amount[$key1][$key2][$key3][$key4] : null;


                                                $approve_quantity = ($request->order_quantity_approve[$key1][$key2][$key3][$key4] != '') ? $request->order_quantity_approve[$key1][$key2][$key3][$key4] : null;
                                                $approve_cardboardbox = ($request->approve_chest_amount[$key1][$key2][$key3][$key4] != '') ? $request->approve_chest_amount[$key1][$key2][$key3][$key4] : null;
                                                $approve_carton = ($request->approve_wrap_amount[$key1][$key2][$key3][$key4] != '') ? $request->approve_wrap_amount[$key1][$key2][$key3][$key4] : null;

                                                $sum_amount = covertNFToFloat($request->sum_amount[$key1][$key2][$key3][$key4]);
                                                $total_amount = covertNFToFloat($request->sum_amount[$key1][$key2][$key3][$key4]);

                                                $orderLine->order_header_id = $orderHeader->order_header_id;
                                                $orderLine->line_number = $key4;
                                                $orderLine->quota_line_id = 0;
                                                $orderLine->item_id = $sequenceEcom->item_id;
                                                $orderLine->item_code = $sequenceEcom->item_code;
                                                $orderLine->item_description = $sequenceEcom->ecom_item_description;
                                                if($orderLine->uom_code == ''){
                                                    $orderLine->uom_code = 'CGK';
                                                    $orderLine->uom = 'พันมวน';
                                                }

                                                $orderLine->order_quantity = !is_null($order_quantity) ? $order_quantity : null;
                                                $orderLine->order_cardboardbox = !is_null($order_cardboardbox) ? $order_cardboardbox : null;
                                                $orderLine->order_carton = !is_null($order_carton) ? $order_carton : null;
                                                $orderLine->unit_price = $unit_price;

                                                // new version approve_quantity

                                                $approve_quantity = ($approve_cardboardbox  / 0.1) + ($approve_carton * 0.2);
                                                // $orderLine->approve_quantity = !is_null($approve_quantity) ? $approve_quantity : null;
                                                $orderLine->approve_quantity = number_format($approve_quantity, 2, ".", "");
                                                $orderLine->approve_cardboardbox = !is_null($approve_cardboardbox) ? $approve_cardboardbox : null;
                                                $orderLine->approve_carton = !is_null($approve_carton) ? $approve_carton : null;

                                                $orderLine->amount = $sum_amount;
                                                $orderLine->total_amount = number_format($total_amount, 2, ".", "");
                                                $orderLine->program_code = $line_program_code;
                                                $orderLine->created_by = auth()->user()->user_id; // 1;
                                                $orderLine->last_updated_by = auth()->user()->user_id; // 1;
                                                $orderLine->tax_amount = 0;
                                                $orderLine->promo_flag = 'Y';

                                                $orderLine->save();

                                            }
                                        }
                                    }
                                }
                            }

                            // foreach($contractQuata as $val){
                            //     $inData = false;
                            //     $overQuota[$val['group']->lookup_code] = 0;

                            //     CreditAndQuotaRepo::setCustomerQuota($orderHeader,$val);

                            //     $spending_approve_quota = 0;
                            //     $spending_order_quota = 0;

                            //     foreach ($val['quota'] as $quota){

                            //         try {
                            //             foreach ($request->line_number[$val['group']->lookup_code][$quota->quota_line_id][$quota->item_id] as $keyline => $vline) {

                            //                 $response[] = $request->line_number[$group_key][$quota_key][$item_key][$keyline];
                            //             }

                            //         }catch (\Exception $e) {
                            //             $messageError[] = $e->getMessage();
                            //         }
                            //     }
                            // }
                        }else{
                            foreach ($request->line_number as $key1 => $v1) {
                                foreach ($v1 as $key2 => $v2) {
                                    foreach ($v2 as $key3 => $v3) {
                                        foreach ($v3 as $key4 => $v4) {
                                            if(isset($request->line_number[$key1][$key2][$key3][$key4])){
                                                $response['line'][] = $request->line_number[$key1][$key2][$key3][$key4];
                                                $orderLine = OrderLines::where('order_header_id',$orderHeader->order_header_id)->where('item_id',$key3)->whereNull('promo_flag')->first();
                                                if (!isset($orderLine) || empty($orderLine)) {
                                                    $orderLine = new OrderLines();
                                                }

                                                $sequenceEcom = SequenceEcoms::where('item_id',$key3)->where('deleted_at',NULL)->whereRaw("lower(sale_type_code) = 'domestic' ")->first();

                                                $line_program_code = $request->program_code[$key1][$key2][$key3][$key4];
                                                $line_number = $request->line_number[$key1][$key2][$key3][$key4];

                                                $unit_price = $request->unit_price[$key1][$key2][$key3][$key4];


                                                $order_quantity = ($request->order_quantity[$key1][$key2][$key3][$key4] != '') ? $request->order_quantity[$key1][$key2][$key3][$key4] : null;
                                                $order_cardboardbox = ($request->chest_amount[$key1][$key2][$key3][$key4] != '') ? $request->chest_amount[$key1][$key2][$key3][$key4] : null;
                                                $order_carton = ($request->wrap_amount[$key1][$key2][$key3][$key4] != '') ? $request->wrap_amount[$key1][$key2][$key3][$key4] : null;


                                                $approve_quantity = ($request->order_quantity_approve[$key1][$key2][$key3][$key4] != '') ? $request->order_quantity_approve[$key1][$key2][$key3][$key4] : null;
                                                $approve_cardboardbox = ($request->approve_chest_amount[$key1][$key2][$key3][$key4] != '') ? $request->approve_chest_amount[$key1][$key2][$key3][$key4] : null;
                                                $approve_carton = ($request->approve_wrap_amount[$key1][$key2][$key3][$key4] != '') ? $request->approve_wrap_amount[$key1][$key2][$key3][$key4] : null;

                                                $sum_amount = covertNFToFloat($request->sum_amount[$key1][$key2][$key3][$key4]);
                                                $total_amount = covertNFToFloat($request->sum_amount[$key1][$key2][$key3][$key4]);

                                                $orderLine->order_header_id = $orderHeader->order_header_id;
                                                $orderLine->line_number = $key4;
                                                $orderLine->quota_line_id = 0;
                                                $orderLine->item_id = $sequenceEcom->item_id;
                                                $orderLine->item_code = $sequenceEcom->item_code;
                                                $orderLine->item_description = $sequenceEcom->ecom_item_description;
                                                $orderLine->uom_code = 'CGK';
                                                $orderLine->uom = 'พันมวน';
                                                $orderLine->order_quantity = !is_null($order_quantity) ? number_format($order_quantity, 2, ".", "") : null;
                                                $orderLine->order_cardboardbox = !is_null($order_cardboardbox) ? $order_cardboardbox : null;
                                                $orderLine->order_carton = !is_null($order_carton) ? $order_carton : null;
                                                $orderLine->unit_price = $unit_price;

                                                $approve_quantity = ($approve_cardboardbox  / 0.1) + ($approve_carton * 0.2);
                                                $orderLine->approve_quantity = number_format($approve_quantity, 2, ".", "");
                                                $orderLine->approve_cardboardbox = !is_null($approve_cardboardbox) ? $approve_cardboardbox : null;
                                                $orderLine->approve_carton = !is_null($approve_carton) ? $approve_carton : null;

                                                $orderLine->amount = $sum_amount;
                                                $orderLine->total_amount = number_format($total_amount, 2, ".", "");
                                                $orderLine->program_code = $line_program_code;
                                                $orderLine->created_by = auth()->user()->user_id; // 1;
                                                $orderLine->last_updated_by = auth()->user()->user_id; // 1;

                                                if(!is_null($orderHeader->order_type_id)){
                                                    $calTax = OrderRepo::calTaxDomestic($orderLine->approve_quantity,$orderLine->item_id,$orderHeader->order_type_id,$orderHeader->customer_id);
                                                    $orderLine->tax_amount = number_format((float)$calTax['amount'], 5, '.', '');
                                                    $orderLine->attribute1 = $calTax['operand'];
                                                    $tax_amount += $calTax['amount'];
                                                }else{
                                                    if(!is_null($customer->order_type_id)){
                                                        $calTax = OrderRepo::calTaxDomestic($orderLine->approve_quantity,$orderLine->item_id,$customer->order_type_id,$orderHeader->customer_id);
                                                        $orderLine->tax_amount = number_format((float)$calTax['amount'], 5, '.', '');
                                                        $orderLine->attribute1 = $calTax['operand'];
                                                        $tax_amount += $calTax['amount'];
                                                    }
                                                }

                                                $orderLine->save();

                                            }
                                        }
                                    }
                                }
                            }
                        }

                        $orderLineTax = OrderLines::where('order_header_id',$orderHeader->order_header_id)->where('tax_amount','!=',0)->sum('tax_amount');

                        $orderHeader->tax = number_format((float)$orderLineTax, 2, '.', '');
                        $orderHeader->sub_total = covertNFToFloat($request->grand_total) - number_format((float)$tax_amount, 2, '.', '');

                        if($request->hasFile('attachment')) {
                            $fileAttachment = $request->file('attachment');
                            AttachmentRepo::uploadAttachmentMultiple($fileAttachment,$orderHeader->order_header_id,'OMP0019');
                        }

                        $orderHeader->save();
                        $set_amount = [];
                        if($orderHeader->installment_type_code == 10){
                            if(count($contractGroups) > 0 && $orderHeader->payment_type_code != 10){
                                $countOrderRemaining = DB::table('oaom.ptom_order_remaining')->where('order_header_id', $orderHeader->order_header_id)->count();
                                if($countOrderRemaining === 0) {
                                    DB::table('oaom.ptom_order_remaining')->insert(
                                        [
                                            'order_header_id' => $orderHeader->order_header_id
                                            ,'org_id' => 81
                                            ,'program_code' => 'OMP0019'
                                            ,'group2_amount' => 0
                                            ,'group2_remaining' => 0
                                            ,'group3_amount' => 0
                                            ,'group3_remaining' => 0
                                            ,'created_by' => auth()->user()->user_id
                                            ,'last_updated_by' => auth()->user()->user_id
                                            
                                        ]
                                    );
                                }
                                foreach($contractGroups as $val){
                                    $orderCredit = OrderCreditGroup::where('order_header_id',$orderHeader->order_header_id)->where('credit_group_code',$val->credit_group_code)->where('order_line_id',0)->first();
                                    CreditAndQuotaRepo::updateCustomerContractRefund($val,$orderHeader,$orderCredit);  // คืนเงินเชื่อ
                                    
                                    $set_amount[] = CreditAndQuotaRepo::updateCustomerContractDeduct($val,$orderHeader,$orderCredit,$creditAmount);  // หักเงินเชื่อ

                                }
                            }else{
                                DB::table('ptom_order_credit_groups')
                                ->where('order_header_id',$orderHeader->order_header_id)
                                ->where('order_line_id',0)
                                ->where('credit_group_code',0)
                                ->update(array(
                                    'amount'=>$creditAmount[0]
                                ));
                            }
                        }

                        if(empty($creditAmount)) {
                            $creditAmount = [];
                        }
                        if(empty($set_amount)) {
                            $set_amount = [];
                        }
                        $replac_cash = (float)array_sum($creditAmount)- (float)array_sum($set_amount);

                        DB::table('ptom_order_credit_groups')
                        ->where('order_header_id',$orderHeader->order_header_id)
                        ->where('credit_group_code',0)
                        ->where('order_line_id',0)
                        ->update(array(
                            'amount'=>(($replac_cash < 0) ? 0 : $replac_cash),
                        ));
                        $orderHeader->credit_amount = (float)array_sum($set_amount);

                        // replace cash amount
                        $orderHeader->cash_amount = (float)$orderHeader->grand_total - (float)array_sum($set_amount);

                        $orderHeader->cash_amount = round($orderHeader->cash_amount, 2);
                        DB::table('ptom_order_credit_groups')
                        ->where('order_header_id',$orderHeader->order_header_id)
                        ->where('credit_group_code',0)
                        ->where('order_line_id',0)
                        ->update(array(
                            'amount'=> $orderHeader->cash_amount,
                        ));
                    }

                    // คำนวนใหม่
                    // $calRemainingAmount = (new OrderEcomController)->remainingAmountCallback($orderHeader->customer_id, Carbon::createFromFormat('Y-m-d',$orderHeader->delivery_date)->format('d/m/Y'));
                    
                    // foreach($calRemainingAmount['cusContractGroup'] as $groupBase) {
                    //     $remaining_base = $calRemainingAmount['cusContractGroup']->where('credit_group_code', $groupBase->credit_group_code)->first();
                    //     $remaining_base =  $remaining_base->credit_amount * ($remaining_base->credit_percentage / 100);
                    //     $ptOmDebtDomV = $calRemainingAmount['ptOmDebtDomV']->where('credit_group_code', $groupBase->credit_group_code)->sum('outstanding_debt');
                    //     $debtDomV = $calRemainingAmount['debtDomV']->where('credit_group_code', $groupBase->credit_group_code)->sum('outstanding_debt');
                        
                    //     $total_by_group = DB::table('ptom_order_credit_groups')->where('order_header_id',$orderHeader->order_header_id)->where('credit_group_code',$groupBase->credit_group_code)->where('order_line_id',0)->first('amount');
                        
                    //     $total_sum_group = (!is_null($total_by_group)) ? $total_by_group->amount : 0;
                        
                    //     $group_remaining = $remaining_base - $ptOmDebtDomV + $debtDomV;
                    //     $group_amount = $group_remaining - $total_sum_group;
    
                    //     dump([$group_remaining, $group_amount,$total_sum_group, $remaining_base, $ptOmDebtDomV, $debtDomV, $groupBase->credit_group_code]);
                    // }

                    if($request->form_type == "confirm" || $request->form_type == "approve"){
                        $orderHeader->pick_release_print_flag = NULL;
                        $orderHeader->unlock_print_flag = 'Y';
                        $orderHeader->save();
                        OrderRepo::insertOrdersHistoryv2($orderHeader,'Inprocess');
                    }else{
                        // OrderRepo::insertOrdersHistoryv2($orderHeader,'Draft');
                    }

                    try {
                        DirectDebitRepo::updateOrderDirectDebot($orderHeader);
                    }catch (\Exception $e) {}
                // }

                DB::commit();
                if($request->form_type == "confirm" || $request->form_type == "approve"){
                    $checkWMS = DB::table('PTOM_ORDER_T_WMS')->where('oaom_order_header_id',$orderHeader->order_header_id)->first();
                        if(is_null($checkWMS)){
                            GenerateNumberRepo::callWMSPackagePrepare($orderHeader->order_header_id,$orderHeader->prepare_order_number);
                      }
                }
                return response()->json(['data'=>$orderHeader,'prepare_order_number'=>$request->prepare_order_number,'message'=>$messageError,'status'=>true]);

            }catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['data'=>[],'status'=>false,'message'=>$e->getMessage()]);
                // return redirect()->back();
            }
        }
    }

    public function approve($order_header_id)
    {
        DB::beginTransaction();
        try {
            $orderHeader = OrderHeaders::where('order_header_id',$order_header_id)->orderBy('order_header_id','DESC')->first();
            OrderRepo::insertOrdersHistoryv2($orderHeader,'Inprocess');
            $orderHeader->payment_approve_flag = 'N';
            $orderHeader->save();

            $resp = GenerateNumberRepo::callWMSPackagePrepare($orderHeader->order_header_id,$orderHeader->prepare_order_number);
            DB::commit();
            return response()->json(['data'=>[],'status'=>true,'message'=>$resp]);
        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['data'=>[],'status'=>false]);
            // return redirect()->back();
        }
    }

    public function cancel(Request $request,$order_header_id)
    {
        DB::beginTransaction();
        try {
            $orderHeader = OrderHeaders::where('order_header_id',$order_header_id)->orderBy('order_header_id','DESC')->first();
            $OrderStatusHistory = OrderStatusHistory::where('order_header_id',$order_header_id)->where('order_status','Draft')->orderBy('order_header_id','DESC')->first();

            if(!is_null($orderHeader->order_number)){
                $orderHeaderCopy = new OrderHeaders();
                foreach ($OrderStatusHistory->toArray() as $key => $v) {
                    if($key != 'order_header_id' && $key != 'order_history_id'){
                        if($key == 'prepare_order_number'){
                            $orderHeaderCopy[$key] = null;
                        }elseif($key == 'order_number'){
                            $orderHeaderCopy[$key] = $orderHeader->order_number;
                        }elseif($key == 'attribute3'){
                            $orderHeaderCopy[$key] = $order_header_id;
                        }elseif($key == 'cash_amount'){
                            $orderHeaderCopy[$key] = $orderHeader->cash_amount;
                        }elseif($key == 'credit_amount'){
                            $orderHeaderCopy[$key] = $orderHeader->credit_amount;
                        }elseif($key == 'fines_amount'){
                            $orderHeaderCopy[$key] = $orderHeader->fines_amount;
                        }elseif($key == 'grand_total'){
                            $orderHeaderCopy[$key] = $orderHeader->grand_total;
                        }elseif($key == 'pick_release_no'){
                            $orderHeaderCopy[$key] = '';
                        }else{
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
            }

            // foreach ($orderHeader->toArray() as $key => $v) {
            //     if($key != 'order_header_id'){
            //         if($key == 'prepare_order_number'){
            //             $orderHeaderCopy[$key] = null;
            //         }elseif($key == 'order_status'){
            //             $orderHeaderCopy[$key] = 'Draft';
            //         }elseif($key == 'payment_approve_flag'){
            //             $orderHeaderCopy[$key] = '';
            //         }else{
            //             $orderHeaderCopy[$key] = $v;
            //         }
            //     }
            // }


            // DB::commit();

            $response = [];
            $orderCreditGroup = OrderCreditGroup::where('order_header_id',$orderHeader->order_header_id)->where('order_line_id',0)->where('credit_group_code','!=',0)->get();


            $lastOrder = OrderRepo::lastOrdersStatus($orderHeader->order_header_id);
            $resp = [];
            if($orderHeader->installment_type_code == 10){

                $orderQuota = OrderRepo::getCustomerQuotaRemaining($orderHeader->customer_id,$orderHeader->delivery_date);

                $response['orderQuota'][] = $orderQuota;

                foreach ($orderQuota as $key => $v) {
                    $orderLine = OrderLines::where('order_header_id',$orderHeader->order_header_id)->whereNull('promo_flag')->where('item_code',$v->item_code)->first();
                    if(!is_null($orderLine)){


                        $remaining_quota = $v->remaining_quota + $orderLine->order_quantity;

                        if($remaining_quota >= $v->received_quota){
                            $remaining_quota = $v->received_quota;
                        }

                        DB::table('ptom_customer_quota_lines')
                        ->where('quota_line_id',$v->quota_line_id)
                        // ->where('item_code',$v->item_code)
                        // ->where('quota_header_id',$v->quota_header_id)
                        ->update(array(
                            'remaining_quota'=>$remaining_quota,
                        ));

                        // $resp[] = $remaining_quota;
                        // $resp['v'][] = $v;
                    }
                }

                OrderQuotaHistory::where('order_header_id',$orderHeader->order_header_id)->delete();

                foreach ($orderCreditGroup as $key => $v) {
                    $customerContractGroups = CustomerContractGroups::where('credit_group_code',$v->credit_group_code)->where('customer_id',$orderHeader->customer_id)->whereNull('deleted_at')->first();

                    $releaseCredit = ReleaseCredit::where('attribute1',$orderHeader->order_header_id)->where('customer_id',$orderHeader->customer_id)->where('credit_group_code',$v->credit_group_code)->where('payment_flag','Y')->sum('amount');
                    $remaining_amount = $customerContractGroups->remaining_amount + $v->amount - $releaseCredit;

                    if($remaining_amount >= $customerContractGroups->credit_amount){
                        $remaining_amount = $customerContractGroups->credit_amount;
                    }

                    $c = (new OrderEcomController)->remainingAmountCallback($orderHeader->customer_id, '', $orderHeader->period_id);
                    $remaining_base = $c['cusContractGroup']->where('credit_group_code', $v->credit_group_code)->first();
                    $remaining_base =  $remaining_base->credit_amount * ($remaining_base->credit_percentage / 100);
                    $ptOmDebtDomV = $c['ptOmDebtDomV']->where('credit_group_code', $v->credit_group_code)->sum('outstanding_debt');
                    $debtDomV = $c['debtDomV']->where('credit_group_code', $v->credit_group_code)->sum('outstanding_debt');
                    $orderHeaders = $c['orderHeaders']->where('credit_group_code', $v->credit_group_code)->where('prepare_order_number', '!=', $orderHeader->prepare_order_number)->sum('amount');
                    $new_remaining_amount = $remaining_base - $ptOmDebtDomV - $orderHeaders + $debtDomV;
                    $remaining_amount = $new_remaining_amount;

                    DB::table('ptom_customer_contract_groups')
                    ->where('credit_group_code',$v->credit_group_code)
                    ->where('customer_id',$orderHeader->customer_id)
                    ->whereNull('deleted_at')
                    ->update(array(
                        'remaining_amount'=>(($remaining_amount < 0) ? 0 : $remaining_amount),
                    ));

                }

                OrderCreditGroup::where('order_header_id',$orderHeader->order_header_id)->delete();

                $releaseCredit = ReleaseCredit::where('attribute1',$orderHeader->order_header_id)->where('customer_id',$orderHeader->customer_id)->delete();
                ImproveFines::where('attribute1',$orderHeader->order_header_id)->delete();

                // foreach ($releaseCredit as $key => $v) {
                //     $v->payment_flag = null;
                //     $v->save();
                // }
            }

            $orderHeader->po_cancel_reason = $request->po_cancel_reason;
            $orderHeader->order_status = 'Cancelled';
            $orderHeader->deleted_at = Carbon::now();

            $order_history = OrderStatusHistory::where('order_header_id',$orderHeader->order_header_id)->where('order_status','!=','Draft')->whereNull('deleted_at')->orderBy('order_history_id','DESC')->get();

            foreach ($order_history as $key => $v) {
                $v->deleted_at = Carbon::now();
                $v->save();
            }

            OrderRepo::insertOrdersHistoryv2($orderHeader,'Cancelled');
            $orderHeader->save();

            $checkWMS = DB::table('PTOM_ORDER_T_WMS')->where('oaom_order_header_id',$orderHeader->order_header_id)->first();

            if($checkWMS){
                if($checkWMS->oaom_wms6_inven == 'Y'){

                    DB::rollBack();
                    return response()->json(['data'=>[],'status'=>false,'message'=>'ไม่สามารถยกเลิกได้เนื่องจาก WMS ทำการตัด Stock แล้ว']);

                }else if($orderHeader->pick_release_status == 'Confirm'){

                    DB::rollBack();
                    return response()->json(['data'=>[],'status'=>false,'message'=>'ไม่สามารถยกเลิกได้เนื่องจากออก Invoice เรียบร้อยแล้ว']);

                }else{

                    $wms_update = [
                        'record_status' => 'C'
                    ];

                    DB::table('PTOM_ORDER_T_WMS')->where('oaom_order_header_id',$orderHeader->order_header_id)->update($wms_update);

                }

                // if($checkWMS->oaom_wms6_inven != 'Y' && $orderHeader->pick_release_status != 'Confirm'){

                //     $wms_update = [
                //         'record_status' => 'C'
                //     ];

                //     DB::table('PTOM_ORDER_T_WMS')->where('oaom_order_header_id',$orderHeader->order_header_id)->update($wms_update);

                //     // return response()->json(['data'=>[],'status'=>true,'message'=>'']);

                // }else{
                //     return response()->json(['data'=>[],'status'=>false,'message'=>'ไม่สามารถยกเลิกได้ เนื่องจาก WMS ทำการตัด Stock แล้ว']);
                // }
            }


            DB::commit();

            return response()->json(['data'=>[],'status'=>true,'message'=>$response]);
        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['data'=>[],'status'=>false,'message'=>'ไม่สามารถยกเลิกสินค้าได้ กรุณาตรวจสอบข้อมูลอีกครั้ง']);
        }
    }

    public function copy($order_number)
    {
        DB::beginTransaction();
        try {
            $orderHeader = OrderHeaders::where('order_number',$order_number)->orderBy('order_header_id','DESC')->first()->toArray();

            $orderHeaderCopy = new OrderHeaders();
            foreach ($orderHeader as $key => $v) {
                if($key != 'order_header_id'){
                    if($key == 'order_number'){
                        $orderHeaderCopy[$key] = runOrderNumber(OrderHeaders::getLastOrderNumber());
                    }elseif($key == 'prepare_order_number'){
                        $now = Carbon::now();
                        $periodV = PeriodV::where('start_period','>=', $now)->first();
                        $budgetYear = ($periodV->budget_year + 543) - 2500;
                        $orderHeaderCopy[$key] = runPrepareNumber(OrderHeaders::getLastPrepareNumber($budgetYear),$budgetYear);
                    }if($key == 'order_status'){
                        $orderHeaderCopy[$key] = 'Draft';
                    }else{
                        $orderHeaderCopy[$key] = $v;
                    }
                }
            }
            $orderHeaderCopy->save();
            $headerKey = $orderHeaderCopy->getKey();

            $orderLine = OrderLines::where('order_header_id',$orderHeader['order_header_id'])->get()->toArray();

            for ($i=0; $i < count($orderLine); $i++) {
                $OrderLinesCopy = new OrderLines();
                foreach ($orderLine[$i] as $key => $v) {
                    if($key != 'order_line_id'){
                        $OrderLinesCopy[$key] = $v;
                        if($key == 'order_header_id'){
                            $OrderLinesCopy[$key] = $headerKey;
                        }else{
                            $OrderLinesCopy[$key] = $v;
                        }
                    }
                }
                $OrderLinesCopy->save();
            }

            DB::commit();
            return response()->json(['data'=>[],'order_number'=>$orderHeaderCopy['order_number'],'status'=>true]);
        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['data'=>[],'order_number'=>$e->getMessage(),'status'=>false]);
            // return redirect()->back();
        }
    }

    public function showedit (Request $request, $id) {


        $customerList = DB::table('PTOM_CUSTOMERS')->get();
        $payment_type = DB::table('PTOM_PAYMENT_TYPE')->get();
        $ship_by = DB::table('PTOM_SHIPMENT_BY')->get();
        $payment_method = DB::table('PTOM_PAYMENT_METHOD_DOMESTIC')->get();
        $order_type = DB::table('PTOM_TRANSACTION_TYPES_V')->get();
        $data = DB::table('PTOM_ORDER_HEADERS')->where('ORDER_HEADER_ID', $id)
            ->leftJoin('PTOM_CUSTOMERS', 'PTOM_ORDER_HEADERS.CUSTOMER_ID', '=', 'PTOM_CUSTOMERS.CUSTOMER_ID')
            ->select([
                'PTOM_ORDER_HEADERS.*',
                'PTOM_CUSTOMERS.*',
                'PTOM_CUSTOMERS.DELIVERY_DATE as delivery_date_period'
            ])
            ->get()->first();
        $line_item = DB::table('PTOM_ORDER_LINES')->where('ORDER_HEADER_ID', $id)->get();

        $datePeriod = nextDaysOfWeek(compareDaysTH($data->delivery_date_period));
        $period = DB::table('ptom_period_v as pvf')
        ->where('start_period','>=', $datePeriod)
        ->first();

        $ship_to = DB::table('PTOM_CUSTOMER_SHIP_SITES')->where('CUSTOMER_ID', $data->customer_id)->get();


        $contract_group = DB::table('ptom_customer_contract_groups as ccg')
            ->join('ptom_credit_group as cg', 'cg.lookup_code', '=', 'ccg.credit_group_code')
            ->where('ccg.customer_id',$data->customer_id)
            ->whereNull('deleted_at')
            ->whereNotNull('remaining_amount')
            ->get(['ccg.contract_group_id','cg.description','ccg.credit_group_code','ccg.credit_percentage','ccg.credit_amount','ccg.remaining_amount','ccg.day_amount']);

        $customer_quota = [];

        $quota_group = DB::table('ptom_quota_group as cg')->where('tag','Y')->get(['cg.lookup_code','cg.meaning']);

        $priceUnit = DB::raw("(SELECT operand FROM ptom_price_list_line_v
            WHERE ptom_price_list_line_v.list_header_id = plh.list_header_id
            AND ptom_price_list_line_v.item_id = cql.item_id
        ) as price_unit");
        foreach($quota_group as $item){
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
            ->where('cqh.customer_id', $data->customer_id)
            ->where('qcg.quota_group_code',$item->lookup_code)
            ->get();
            foreach ($quota as $q) {
                $inv = DB::table('PTOM_ONHAND_V')->where('ITEM_CODE', $q->item_code)->get();
                $sum = 0;
                foreach ($inv as $_i) {
                    if($_i->transaction_uom_code == 'PTN'){
                        $onhandsum += ($_i->onhand_quantity / 120);
                    }else if($_i->transaction_uom_code != 'CGK'){
                        $onhandsum += ($_i->onhand_quantity / 1000);
                    }else{
                        $sum += $_i->onhand_quantity;
                    }
                }
                $q->onhand = $sum;
            }
            if(count($quota) > 0){
                $customer_quota[] = [
                    'group' => $item,
                    'quota' => $quota
                ];
            }

        }
        return view('om.preparation.edit',compact(['payment_type', 'ship_by','payment_method', 'data', 'order_type', 'customerList', 'period', 'ship_to', 'customer_quota', 'contract_group', 'line_item']));
    }

    // public function search (Request $request) {
    //     // $data = DB::table('PTOM_ORDER_HEADERS')->get();
    //     if(!is_numeric($request->key))return [];
    //     $data = Order::where('ORDER_HEADER_ID','like', '%'.$request->key.'%')->leftJoin('PTOM_ORDER_PERIOD_HEADERS', 'PTOM_ORDER_HEADERS.PERIOD_ID', '=', 'PTOM_ORDER_PERIOD_HEADERS.PERIOD_ID')->get();
    //     return $data;
    // }

    public function searchcustomer (Request $request) {
        $data = DB::table('PTOM_CUSTOMERS')->where('CUSTOMER_NUMBER', $request->key)->get()->first();
        if($data){
            return [
                'status' => 'success',
                'result' => $data->customer_name,
                'id' => $data->customer_id,
            ];
            // return $data->CUSTOMER_NAME;
        }
        return [
            'status' => 'failed',
            'result' => ''
        ];
    }

    public function editsubmit (Request $request, $id) {
        if($request->order_status=='Cancel') {
            //Check if match invoice
            $info = DB::table('PTOM_PAYMENT_MATCH_INVOICES')->leftJoin('PTOM_ORDER_HEADERS','PTOM_PAYMENT_MATCH_INVOICES.PREPARE_ORDER_NUMBER','=','PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER')->where('PTOM_ORDER_HEADERS.ORDER_HEADER_ID', $id)->get();
            // return redirect('/om/order/prepare');
            if($info)
                return redirect('/om/order/prepare');

        }
        DB::beginTransaction();
        try {
            $order = [];
            if($request->order_no) $order['order_number'] = $request->order_no;
            if($request->customer_po) $order['cust_po_number'] = $request->customer_po;
            if($request->order_status) $order['order_status'] = $request->order_status;
            if($request->customer_id) $order['customer_id'] = $request->customer_id;
            if($request->payment_method) $order['payment_method_code'] = $request->payment_method;
            if($request->source_system)$order['source_system'] = $request->source_system;
            if($request->note_system)$order['remark_source_system'] = $request->note_system;
            if($request->order_date) $order['order_date'] = $request->order_date;
            if($request->ship_by) $order['transport_type_code'] = $request->ship_by;
            if($request->payment_type) $order['payment_type_code'] = $request->payment_type;
            if($request->note) $order['remark'] = $request->note;
            if($request->order_type) $order['order_type_id'] = $request->order_type;
            if($request->bill_to) $order['bill_to_site_id'] = $request->bill_to;
            if($request->ship_to) $order['ship_to_site_id'] = $request->ship_to;
            $order['last_updated_by'] = \Auth::user()->user_id;
            $order['program_code'] = 'OMP0019';
            $order['currency'] = 'Bath';
            $order['period_id'] = '7';
            $order['order_source'] = 'WEB';
            $order['org_id'] = 81;

            if($request->year) {
                $year = strval($request->year-2500);
                if(!$request->year) $year = '64';
                $symbol = 'O';
                $id = sprintf("%06d", $id);
                $prepare_order_number = $year . $symbol . $id;
                $order['prepare_order_number'] = $prepare_order_number;
            }

            DB::table('PTOM_ORDER_HEADERS')->where('ORDER_HEADER_ID', $id)->update($order);
            if($request->item) foreach ($request->item as $key=>$line_item) {
                if($line_item['type']=='0')
                {
                    DB::table('PTOM_ORDER_LINES')->insert([
                        'ORDER_HEADER_ID' => $id,
                        'LINE_NUMBER' => $key,
                        'ITEM_ID' => $line_item['item_id'],
                        'ITEM_CODE' => $line_item['code'],
                        'ITEM_DESCRIPTION' => $line_item['item_description'],
                        'CREDIT_GROUP_CODE' => $line_item['credit_group'],
                        'UNIT_PRICE' => $line_item['unit_price'],
                        'ORDER_QUANTITY' => $line_item['line_order_amount'],
                        'APPROVE_QUANTITY' => $line_item['line_approve_amount'],
                        'UOM_CODE' => 'CGK',
                        'TOTAL_AMOUNT' => $line_item['line_item_total_price'],
                        'PROGRAM_CODE' => 'OMP0019',
                        'CREATED_BY' => \Auth::user()->user_id,
                        'LAST_UPDATED_BY' => \Auth::user()->user_id,

                    ]);
                }
                else {
                    DB::table('PTOM_ORDER_LINES')->where('ORDER_LINE_ID', $line_item['type'])->update([
                        'LINE_NUMBER' => $key,
                        'ITEM_ID' => $line_item['item_id'],
                        'ITEM_CODE' => $line_item['code'],
                        'ITEM_DESCRIPTION' => $line_item['item_description'],
                        'CREDIT_GROUP_CODE' => $line_item['credit_group'],
                        'UNIT_PRICE' => $line_item['unit_price'],
                        'ORDER_QUANTITY' => $line_item['line_order_amount'],
                        'APPROVE_QUANTITY' => $line_item['line_approve_amount'],
                        'UOM_CODE' => 'CGK',
                        'TOTAL_AMOUNT' => $line_item['line_item_total_price'],
                        'PROGRAM_CODE' => 'OMP0019',
                        'CREATED_BY' => \Auth::user()->user_id,
                        'LAST_UPDATED_BY' => \Auth::user()->user_id,
                    ]);
                }

            }
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back();
        }
        return redirect('/om/order/prepare');
    }

    public function fetchcustomer (Request $request) {

        $customer = DB::table('PTOM_CUSTOMERS')->where('CUSTOMER_NUMBER', $request->key)->get()->first();
        $sites = DB::table('PTOM_CUSTOMER_SHIP_SITES')->where('CUSTOMER_ID', $customer->customer_id)->get();
        $trust = DB::table('PTOM_CUSTOMER_CONTRACT_GROUPS')->where('CUSTOMER_ID', $customer->customer_id)->where('REMAINING_AMOUNT', '!=', NULL)->get();

        $datePeriod = nextDaysOfWeek(compareDaysTH($customer->delivery_date));
        $period = DB::table('ptom_period_v as pvf')
        ->where('start_period','>=', $datePeriod)
        ->first();


        $contract_group = DB::table('ptom_customer_contract_groups as ccg')
            ->join('ptom_credit_group as cg', 'cg.lookup_code', '=', 'ccg.credit_group_code')
            ->where('ccg.customer_id',$customer->customer_id)
            ->whereNull('deleted_at')
            ->whereNotNull('remaining_amount')
            ->get(['ccg.contract_group_id','cg.description','ccg.credit_group_code','ccg.credit_percentage','ccg.credit_amount','ccg.remaining_amount','ccg.day_amount']);

        $customer_quota = [];

        $quota_group = DB::table('ptom_quota_group as cg')->where('tag','Y')->get(['cg.lookup_code','cg.meaning']);

        $priceUnit = DB::raw("(SELECT operand FROM ptom_price_list_line_v
            WHERE ptom_price_list_line_v.list_header_id = plh.list_header_id
            AND ptom_price_list_line_v.item_id = cql.item_id
        ) as price_unit");
        foreach($quota_group as $item){
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
            ->where('cqh.customer_id', $customer->customer_id)
            ->where('qcg.quota_group_code',$item->lookup_code)
            ->get();

            foreach ($quota as $q) {
                $inv = DB::table('PTOM_ONHAND_V')->where('ITEM_CODE', $q->item_code)->get();
                $sum = 0;
                foreach ($inv as $_i) {
                    if($_i->transaction_uom_code == 'PTN'){
                        $onhandsum += ($_i->onhand_quantity / 120);
                    }else if($_i->transaction_uom_code != 'CGK'){
                        $onhandsum += ($_i->onhand_quantity / 1000);
                    }else{
                        $sum += $_i->onhand_quantity;
                    }
                }
                $q->onhand = $sum;
            }
            if(count($quota) > 0){
                $customer_quota[] = [
                    'group' => $item,
                    'quota' => $quota
                ];
            }

        }

        return [
            'status' => 'success',
            'customer' => $customer,
            'sites' => $sites,
            'trust' => $trust,
            'period' => $period,
            'contract_group' => $contract_group,
            'quota' => $customer_quota
        ];
    }
}
