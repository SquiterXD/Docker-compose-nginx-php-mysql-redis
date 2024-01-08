<?php

namespace App\Repositories\OM;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\OM\AdditionQuota;
use App\Models\OM\AdditionQuotaLines;
use App\Models\OM\Api\OrderStatusHistory;
use App\Models\OM\PnHolidayModel;
use App\Models\OM\Api\OrderLines;
use App\Models\OM\Api\OrderCreditGroup;
use App\Models\OM\ConsignmentClub\ConsignmentHeader;
use App\Models\OM\ConsignmentClub\ConsignmentLines;
use App\Models\OM\Customers;
use App\Models\OM\PaymentMatchInvoice;
use App\Models\OM\PenaltyRateDomesticV;
use App\Models\OM\OutstandingDebtDomesticV;
use App\Models\OM\ImproveFines;
use App\Models\OM\ReleaseCredit;
use App\Models\OM\Customers\Domestics\CustomerContractGroups;
use App\Models\OM\Customers\Domestics\PriceListLine;
use App\Models\OM\Customers\Domestics\SequenceEcom;
use App\Models\OM\SaleConfirmation\OrderHeaders;
use App\Models\OM\SaleConfirmation\TaxCode;
use App\Models\OM\Api\OrderQuotaHistory;
use Illuminate\Support\Facades\Log;

class OrderRepo
{

    public static function orgId()
    {
        $org = DB::table('PTOM_OPERATING_UNITS_V')
        ->where('short_code','TOAT')
        ->first();

        if(is_null($org)){
            return '81';
        }else{
            return $org->organization_id;
        }

    }

    public static function convertCGK($amount)
    {
        $response = [
            'cardboardbox'=>0,
            'carton'=>0
        ];

        $cardboardbox = floor($amount / 10);
        if($cardboardbox >= 1){
            if(($amount % 10) == 0){
                $response = [
                    'cardboardbox'=>(int)$cardboardbox,
                    'carton'=>0
                ];
            }else{
                $carton = ($amount % 10) * 5;
                $response = [
                    'cardboardbox'=>(int)$cardboardbox,
                    'carton'=>$carton
                ];
            }
        }else{
            $carton = floor($amount / 0.2);
            $response = [
                'cardboardbox'=>0,
                'carton'=>$carton
            ];
        }

        return $response;

    }

    public static function sumNotMatch($customer_id)
    {
        $paymentAmount = DB::table('PTOM_PAYMENT_DETAILS as ppd')
        ->join('PTOM_PAYMENT_HEADERS as pph', 'pph.payment_header_id', '=', 'ppd.payment_header_id')
        ->where('pph.payment_status','Confirm')
        ->where('pph.customer_id',$customer_id)
        ->whereNull('pph.deleted_at')
        ->sum('ppd.payment_amount');

        $paymentInvoice = DB::table('ptom_payment_match_invoices as pmi')
        ->join('ptom_payment_headers as pph', 'pph.payment_header_id', '=', 'pmi.payment_header_id')
        ->where('pmi.match_flag','Y')
        ->where('pph.customer_id',$customer_id)
        ->whereNull('pmi.deleted_at')
        ->whereNull('pph.deleted_at')
        ->sum('pmi.payment_amount');

        $paymentApply = DB::table('PTOM_PAYMENT_APPLY_CNDN as ppac')
        ->join('PTOM_PAYMENT_MATCH_INVOICES as pmi', 'pmi.payment_match_id', '=', 'ppac.payment_match_id')
        ->join('PTOM_PAYMENT_HEADERS as pph', 'pph.payment_header_id', '=', 'pmi.payment_header_id')
        ->where(function($query){
            $query->where('pph.payment_status','N');
            $query->orWhere('pph.payment_status','=',NULL);
        })
        ->where('pph.customer_id',$customer_id)
        ->whereNull('pph.deleted_at')
        ->sum('ppac.invoice_amount');

        return ($paymentAmount - $paymentInvoice) + $paymentApply;
    }

    public static function calTaxDomestic($quantity,$item_id,$order_type_id,$customer_id)
    {
        $orderType = DB::table('ptom_transaction_types_v')
        ->where('order_type_id',$order_type_id)
        ->first();

        $priceList = DB::table('ptom_price_list_head_v as plh')
        ->join('ptom_price_list_line_v as pll', 'pll.list_header_id', '=', 'plh.list_header_id')
        ->where('plh.name','ราคาขายปลีก')
        ->where('pll.item_id',$item_id)
        ->where(function($query){
            $query->whereNull('pll.start_date_active');
            $query->orWhere('pll.start_date_active','<=',date('Y-m-d'));
        })
        ->where(function($query){
            $query->whereNull('pll.end_date_active');
            $query->orWhere('pll.end_date_active','>=',date('Y-m-d'));
        })
        ->first();

        if(is_null($priceList)){
            return [
                'operand'=>0,
                'amount'=>0
            ];
        }

        return [
            'operand'=>$priceList->operand,
            'amount'=>($quantity * $priceList->operand) * ($orderType->tax_rate / 107)
        ];
    }


    public static function calTaxExport($quantity,$unit_price,$order_type_id,$customer_id)
    {
        $transactionTypes = DB::table('ptom_transaction_types_all_v')
        ->where('order_type_id',$order_type_id)
        ->first();

        $vat_code = 'SVAT-G7';
        $percentage = 0;
        if(!is_null($transactionTypes->vat_code)){
            $vat_code = $transactionTypes->vat_code;
        }else{
            $customer = DB::table('ptom_customers')
            ->where('customer_id',$customer_id)
            ->first();

            if(!is_null($customer->vat_code)){
                $customer = $transactionTypes->vat_code;
            }
        }

        $percentageTax = DB::table('ptom_tax_code_v')
        ->where('tax_rate_code',$vat_code)
        ->first();

        if(!is_null($percentageTax)){
            $percentage = $percentageTax->percentage_rate;
        }

        return [
            'vat_code'=>$vat_code,
            'amount'=>($quantity * $unit_price) * ($percentage / 100)
        ];
    }

    public static function getByTypeCustomer($type)
    {
        return DB::table('ptom_customers')
        ->whereRaw("lower(status) = 'active' ")
        ->whereRaw("lower(sales_classification_code) = '".$type."' ")
        ->where('deleted_at',NULL)
        ->orderBy('customer_number','asc')
        ->get();
    }

    public static function getAllCustomer()
    {
        return DB::table('ptom_customers')
        ->whereRaw("lower(status) = 'active' ")
        ->where('deleted_at',NULL)
        ->get();
    }

    public static function getPeriodFrom($from_date)
    {
        return  DB::table('ptom_period_v')
        ->select('period_line_id')
        ->whereDate('start_period','<=',$from_date)
        ->whereDate('end_period','>=',$from_date)
        ->where('budget_year','>=',date('Y'))
        ->orderBy('period_id','asc')
        ->first();
    }

    public static function getPeriodTo($to_date)
    {
        return  DB::table('ptom_period_v')
        ->select('period_line_id')
        ->whereDate('start_period','<=',$to_date)
        ->whereDate('end_period','>=',$to_date)
        ->orderBy('period_id','asc')
        ->first();
    }

    public static function selectStatusHistory()
    {
        return '(
            SELECT ptom_order_history.order_status
            FROM ptom_order_history
            WHERE ptom_order_headers.order_header_id = ptom_order_history.order_header_id AND ptom_order_history.deleted_at IS NULL
            ORDER BY ptom_order_history.order_history_id DESC OFFSET 0 ROWS FETCH NEXT 1 ROWS ONLY
        )';
    }

    public static function checkHoliday($delivery_date,$skip,$dateSet='')
    {
        $status = 0;

        $compareDaysTH = compareDaysTH($delivery_date);
        $numberDayNow = date('w',strtotime(date('Y-m-d')));

        $dateDeli = nextDaysOfWeek(compareDaysTH($delivery_date));
        $dateDeliNow = nextDaysOfWeekNotPlus(compareDaysTH($delivery_date));
        $postPone = false;

        if($dateSet == ''){
            if ($skip == 1) {
                if($compareDaysTH < $numberDayNow && ($compareDaysTH != 0)){
                    $date = nextDaysOfWeek(compareDaysTH($delivery_date));
                }else{
                    $date = nextOfWeek(compareDaysTH($delivery_date));
                }
            }else{

                if ($dateDeliNow >= date('Y-m-d')) {
                    $date = $dateDeliNow;
                    if($compareDaysTH < $numberDayNow && ($compareDaysTH != 0)){
                        $postPone = true;
                    }
                }else{
                    $date = $dateDeli;
                    $postPone = true;
                }

            }
        }else{
            $date = $dateSet;
        }

        // if ($skip == 1) {
        //     $date = '2021-08-05';
        // }else{
        //     $date = '2021-08-12';
        // }

        $compareDays = date('w',strtotime($date));

        do {
            $holiday = PnHolidayModel::where('hol_date',$date)->first();
            if(!is_null($holiday) || ($compareDays == 6 || $compareDays == 0)){
                $date = date('Y-m-d',strtotime($date . "+1 days"));
                $compareDays = date('w',strtotime($date));
                $postPone = true;
            }else{
                $status = 1;
            }
        } while ($status == 0);

        return [
            'date'=>$date,
            'postpone'=>$postPone,
            'dateNow'=>$dateDeliNow,
            'numberDayNow'=>$numberDayNow,
            'compareDaysTH'=>$compareDaysTH
        ];
    }

    public static function getProcutTypeDomesticLookup($lookup_code)
    {
        return DB::table('ptom_product_type_domestic')->where('lookup_code',$lookup_code)->first(['lookup_code','meaning','description']);
    }

    public static function getPaymentType()
    {
        return DB::table('ptom_payment_type')->get(['lookup_code','meaning','description']);
    }

    public static function getPaymentTypeLookup($lookup_code)
    {
        return DB::table('ptom_payment_type')->where('lookup_code',$lookup_code)->first(['lookup_code','meaning','description']);
    }

    public static function getPaymentMethodLookup($lookup_code)
    {
        return DB::table('ptom_payment_method_domestic')->where('enabled_flag','Y')->where('lookup_code',$lookup_code)->first(['lookup_code','meaning','description']);
    }

    public static function uomConvert($uom)
    {
        $uom = DB::table('ptom_terms')
        ->where('uom_code','=', $uom)
        ->first();

        if (count($uom) > 0) {
            return DB::table('ptom_uom_conversions_v')->get(['uom_code','conversion_rate','unit_of_measure']);
        }else{
            return [
                'uom_code'=>$uom,
                'conversion_rate'=>1,
                'unit_of_measure'=>''
            ];
        }


    }

    public static function insertOrdersHistory($orderHeader)
    {
        $orderHistory = new OrderStatusHistory();
        foreach ($orderHeader->toArray() as $key => $v) {
            if ($key != 'requestor_code' && $key != 'payment_approve_flag') {
                if ($key == 'creation_date') {
                    $orderHistory[$key] = now();
                }else{
                    $orderHistory[$key] = $v;
                }
            }
        }
        $orderHistory->save();
    }


    public static function lastOrdersStatus($header_id)
    {
        $orderHistoryLast = OrderStatusHistory::where('order_header_id',$header_id)->whereNull('deleted_at')->orderBy('order_history_id','DESC')->first();
        return $orderHistoryLast;
    }

    public static function insertOrdersHistoryv2($orderHeader,$status)
    {

        $orderHistoryLast = OrderStatusHistory::where('order_header_id',$orderHeader->order_header_id)->whereNull('deleted_at')->orderBy('order_history_id','DESC')->first();
        if(!is_null($orderHistoryLast) && $orderHistoryLast->order_status == $status){
            $orderHistory = $orderHistoryLast;
        }else{
            $orderHistory = new OrderStatusHistory();
        }

        foreach ($orderHeader->toArray() as $key => $v) {
            try {
                if ($key != 'requestor_code' && $key != 'payment_approve_flag' && $key != 'close_sale_status' && $key != 'close_sale_msg') {
                    if ($key == 'creation_date') {
                        $orderHistory[$key] = now();
                    }elseif ($key == 'order_status') {
                        $orderHistory[$key] = $status;
                    }else{
                        $orderHistory[$key] = $v;
                    }
                }
            } catch (\Exception $e) {}
        }
        $orderHistory->save();
    }

    public static function amountCreditGroupCash(
        $header,
        $line,
        $total_amount,
        $program_code='')
    {
        $orderCreditGroup = OrderCreditGroup::where('order_header_id',$header)->where('order_line_id',$line)->where('credit_group_code',0)->first();

        $orderHeader = OrderHeaders::where('order_header_id', $header)->whereNull('deleted_at')->first();

        if(is_null($orderCreditGroup)){
            DB::table('ptom_order_credit_groups')->insert([
                'order_header_id'=>$header,
                'order_line_id'=> $line,
                'credit_group_code' => 0,
                'amount' => $total_amount,
                'period_id' => $orderHeader->period_id,
                'program_code' => $program_code,
                'created_by' => 1,
                'last_updated_by' => 1
            ]);
        }else{
            DB::table('ptom_order_credit_groups')
            ->where('order_header_id',$header)
            ->where('order_line_id',$line)
            ->where('credit_group_code',0)
            ->update([
                'amount' => $total_amount,
            ]);
        }

    }

    public static function amountCreditGroup(
        $header,
        $line,
        $creditGroupsRemaining,
        $quota,
        $total_amount,
        $program_code='')
    {
        $creditAmount = 0;
        $creditGroupCode = $quota->credit_group_code;
        $diffCredit = 0;

        if ($creditGroupsRemaining[$quota->credit_group_code] >= $total_amount) {
            $creditAmount = $total_amount;
            $creditGroupsRemaining[$quota->credit_group_code] -= $total_amount;
        }elseif($creditGroupsRemaining[$quota->credit_group_code] == 0){
            $creditAmount = $total_amount;
            $creditGroupCode = 0;
        }else{
            $diffCredit = $total_amount - $creditGroupsRemaining[$quota->credit_group_code];
            $creditAmount = $creditGroupsRemaining[$quota->credit_group_code];
            $creditGroupsRemaining[$quota->credit_group_code] = 0;
        }

        $orderCreditGroup = OrderCreditGroup::where('order_header_id',$header)->where('order_line_id',$line)->where('credit_group_code',$creditGroupCode)->first();

        $orderHeader = OrderHeaders::where('order_header_id', $header)->whereNull('deleted_at')->first();

        if(is_null($orderCreditGroup)){
            DB::table('ptom_order_credit_groups')->insert([
                'order_header_id'=>$header,
                'order_line_id'=> $line,
                'credit_group_code' => $creditGroupCode,
                'amount' => $creditAmount,
                'period_id' => $orderHeader->period_id,
                'program_code' => $program_code,
                'created_by' => 1,
                'last_updated_by' => 1
            ]);
        }else{
            DB::table('ptom_order_credit_groups')
            ->where('order_header_id',$header)
            ->where('order_line_id',$line)
            ->where('credit_group_code',$creditGroupCode)
            ->update([
                'amount' => $creditAmount,
            ]);
        }


        if($diffCredit > 0){
            $orderCreditGroupCash = OrderCreditGroup::where('order_header_id',$header)->where('order_line_id',$line)->where('credit_group_code',0)->first();

            if(is_null($orderCreditGroupCash)){
                DB::table('ptom_order_credit_groups')->insert([
                    'order_header_id'=>$header,
                    'order_line_id'=> $line,
                    'credit_group_code' => 0,
                    'amount' => $diffCredit,
                    'period_id' => $orderHeader->period_id,
                    'program_code' => $program_code,
                    'created_by' => 1,
                    'last_updated_by' => 1
                ]);
            }else{
                DB::table('ptom_order_credit_groups')
                ->where('order_header_id',$header)
                ->where('order_line_id',$line)
                ->where('credit_group_code',0)
                ->update([
                    'amount' => $diffCredit
                ]);
            }


        }
    }

    public static function amountCreditGroupv2(
        $header,
        $line,
        $creditGroupsRemaining,
        $quota,
        $creditGroups,
        $total_amount,
        $program_code='')
    {
        $creditAmount = 0;
        $creditGroupCode = $quota->credit_group_code;
        $diffCredit = 0;

        $resp = [];
        if ($creditGroupsRemaining[$quota->credit_group_code] >= $total_amount) {
            $creditAmount = $total_amount;
            $creditGroupsRemaining[$quota->credit_group_code] -= $total_amount;
        }elseif($creditGroupsRemaining[$quota->credit_group_code] == 0){
            $creditAmount = $total_amount;
            $creditGroupCode = 0;
        }else{
            $diffCredit = $total_amount - $creditGroupsRemaining[$quota->credit_group_code];
            $creditAmount = $creditGroupsRemaining[$quota->credit_group_code];
            $creditGroupsRemaining[$quota->credit_group_code] = 0;
        }

        $orderCreditGroup = OrderCreditGroup::where('order_header_id',$header)->where('order_line_id',$line)->where('credit_group_code',$creditGroupCode)->first();

        $orderHeader = OrderHeaders::where('order_header_id', $header)->whereNull('deleted_at')->first();

        // $creditGroups = OrderCreditGroup::where('order_header_id',$header)->where('order_line_id',$line)->where('credit_group_code',$creditGroupCode)->first();
        if(is_null($orderCreditGroup)){

            if($creditGroupCode == 0){
                $creditGroups[$quota->credit_group_code]->credit_amount = 0;
                $creditGroups[$quota->credit_group_code]->remaining_amount = 0;
            }

            DB::table('ptom_order_credit_groups')->insert([
                'order_header_id'=>$header,
                'order_line_id'=> $line,
                'credit_group_code' => $creditGroupCode,
                'amount' => $creditAmount,
                'period_id' => $orderHeader->period_id,
                'received_amount' => $creditGroups[$quota->credit_group_code]->credit_amount,
                'remaining_amount' => $creditGroups[$quota->credit_group_code]->remaining_amount,
                'program_code' => $program_code,
                'created_by' => 1,
                'last_updated_by' => 1
            ]);
        }else{
            $dataCreditGroup = OrderCreditGroup::where('order_header_id',$header)->where('order_line_id',0)->where('credit_group_code',$creditGroupCode)->first();

            DB::table('ptom_order_credit_groups')
            ->where('order_header_id',$header)
            ->where('order_line_id',$line)
            ->where('credit_group_code',$creditGroupCode)
            ->update([
                'amount' => $creditAmount
            ]);
        }

        if($diffCredit > 0){
            $orderCreditGroupCash = OrderCreditGroup::where('order_header_id',$header)->where('order_line_id',$line)->where('credit_group_code',0)->first();

            if(is_null($orderCreditGroupCash)){

                $dataCreditGroup = OrderCreditGroup::where('order_header_id',$header)->where('order_line_id',0)->where('credit_group_code',$creditGroupCode)->first();

                DB::table('ptom_order_credit_groups')->insert([
                    'order_header_id'=>$header,
                    'order_line_id'=> $line,
                    'credit_group_code' => 0,
                    'amount' => $diffCredit,
                    'period_id' => $orderHeader->period_id,
                    'received_amount' => 0,
                    'remaining_amount' => 0,
                    'program_code' => $program_code,
                    'created_by' => 1,
                    'last_updated_by' => 1
                ]);
            }else{
                $dataCreditGroup = OrderCreditGroup::where('order_header_id',$header)->where('order_line_id',0)->where('credit_group_code',$creditGroupCode)->first();
                DB::table('ptom_order_credit_groups')
                ->where('order_header_id',$header)
                ->where('order_line_id',$line)
                ->where('credit_group_code',0)
                ->update([
                    'amount' => $diffCredit
                ]);
            }
        }
        // return $resp;
    }

    public static function getPaymentMethodExportLookup($lookup_code)
    {
        return DB::table('ptom_payment_method_export')->where('enabled_flag','Y')->where('lookup_code',$lookup_code)->first(['lookup_code','meaning','description']);
    }

    public static function getShipmentLookup($lookup_code)
    {
        return DB::table('ptom_shipment_by')->where('lookup_code',$lookup_code)->first(['lookup_code','meaning','description']);
    }

    public static function shipSites($customer_id)
    {
        return DB::table('ptom_customer_ship_sites')->where('customer_id',$customer_id)->whereRaw("lower(status) = 'active' ")->where('deleted_at',NULL)->orderBy('site_no','ASC')->get(['ship_to_site_id','site_no','ship_to_site_name','attribute1']);
    }

    public static function getPeriodByLineId($period_line_id)
    {
        return DB::table('ptom_period_v as pvf')
        ->where('period_line_id','=', $period_line_id)
        ->first(['budget_year','period_line_id','period_no','start_period','end_period']);
    }

    public static function getPaymentTerm($id)
    {
        return DB::table('ptom_terms_v')
        ->where('term_id','=', $id)
        ->first(['term_id','name','description']);
    }

    public static function setTermDayAmount($orderHeader,$customer,$credit_group_code)
    {
        $data = [
            'day_amount' => 0,
            'credit_group_code' => 0
        ];

        // if($orderHeader->payment_type_code != 10){
            // day_amount
            if ($customer->customer_type_id != 30 && $customer->customer_type_id != 40) { // ไม่ใช่สโมสร
                if($credit_group_code != 0 && !is_null($credit_group_code)){ // เงินเชื่อ
                    $day_amount = CustomerContractGroups::where('customer_id',$orderHeader->customer_id)->where('credit_group_code',$credit_group_code)->whereNull('deleted_at')->first();

                    if (!is_null($day_amount)) {
                        $data = [
                            'day_amount' => $day_amount->day_amount,
                            'credit_group_code' => $credit_group_code
                        ];
                    }else{
                        $data = [
                            'day_amount' => 0,
                            'credit_group_code' => $credit_group_code
                        ];
                    }

                }else{ // เงินสด

                    $data = [
                        'day_amount' => 0,
                        'credit_group_code' => 0
                    ];

                }
            }else{
                if ($orderHeader->product_type_code == 10) { // บุหรี่ นปท
                    if ($customer->customer_type_id == 30){ // ลูกค้าประเภทสโมสรกรุงเทพ

                        $data = [
                            'day_amount' => 0,
                            'credit_group_code' => 0
                        ];

                    }else{ // ลูกค้าประเภทสโมสรภูมิภาค
                        $due_days = DB::table('ptom_terms_v')
                        ->where('credit_group_code','=', 0)
                        ->first(['due_days_consignment']);

                        if(!is_null($due_days)){

                            $data = [
                                'day_amount' => $due_days->due_days_consignment,
                                'credit_group_code' => 0
                            ];

                        }else{
                            $data = [
                                'day_amount' => 0,
                                'credit_group_code' => 0
                            ];
                        }
                    }


                }else{
                    $data = [
                        'day_amount' => 0,
                        'credit_group_code' => 0
                    ];
                }
            }
            // day_amount
        // }else{
        //     $data = [
        //         'day_amount' => 0,
        //         'credit_group_code' => 0
        //     ];
        // }

        return $data;
    }

    public static function getCustomerContractBooks($customer_id)
    {
        return DB::table('ptom_customer_contract_books')
        ->where('customer_id',$customer_id)
        ->whereNull('deleted_at')
        ->where(function($query){
            $query->whereNull('book_end_date');
            $query->orWhere('book_end_date','>=',date('Y-m-d'));
        })
        ->get(['contract_book_id','book_number','book_start_date','book_end_date','credit_limit']);
    }

    public static function getPromotionProduct($header_id)
    {
        $orderPromotion = DB::table('ptom_order_lines as ol')
        ->join('ptom_promotion_product as pp', 'pp.promotion_product_id', '=', 'ol.promotion_product_id')
        ->join('ptom_promotion_header as p', 'p.promotion_id', '=', 'pp.promotion_id')
        ->where('ol.order_header_id',$header_id)->where('ol.promo_flag','Y')
        ->get(['ol.*','p.promotion_code','pp.promotion_quantity','p.attribute1','pp.support_group','pp.promotion_product_id']);
        return $orderPromotion;
    }



    public static function getCustomerSumContractBooks($customer_id)
    {
        return DB::table('ptom_customer_contract_books')
        ->where('customer_id',$customer_id)
        ->where('book_start_date','<=',date('Y-m-d'))
        // ->orWhere('book_start_date','<=',dateFormatDMY(date('Y-m-d'),'-'))
        ->where('book_end_date','>=',date('Y-m-d'))
        // ->orWhere('book_end_date','>=',dateFormatDMY(date('Y-m-d'),'-'))
        ->orwhereNull('book_end_date')
        ->whereNull('deleted_at')
        ->sum('credit_limit');
    }

    public static function getCustomerContractGroups($customer_id)
    {
        $response = DB::table('ptom_customer_contract_groups as ccg')
        ->join('ptom_credit_group as cg', 'cg.lookup_code', '=', 'ccg.credit_group_code')
        ->where('ccg.customer_id',$customer_id)
        ->whereNull('ccg.deleted_at')
        ->whereNotNull('remaining_amount')
        ->get(['ccg.contract_group_id','cg.description','ccg.credit_group_code','ccg.credit_percentage','ccg.credit_amount','ccg.remaining_amount','ccg.day_amount']);

        foreach ($response as $key => $v) {
            $v->credit_amount = ($v->credit_amount * $v->credit_percentage) / 100;
            $v->remaining_amount = ($v->remaining_amount * $v->credit_percentage) / 100;
        }

        return $response;
    }

    public static function getCustomerContractGroupsByGroup($customer_id,$credit_group_code)
    {
        $response = DB::table('ptom_customer_contract_groups as ccg')
        ->join('ptom_credit_group as cg', 'cg.lookup_code', '=', 'ccg.credit_group_code')
        ->where('ccg.customer_id',$customer_id)
        ->where('ccg.credit_group_code',$credit_group_code)
        ->whereNull('ccg.deleted_at')
        ->whereNotNull('remaining_amount')
        ->get(['ccg.contract_group_id','cg.description','ccg.credit_group_code','ccg.credit_percentage','ccg.credit_amount','ccg.remaining_amount','ccg.day_amount']);

        foreach ($response as $key => $v) {
            $v->credit_amount = ($v->credit_amount * $v->credit_percentage) / 100;
            $v->remaining_amount = ($v->remaining_amount * $v->credit_percentage) / 100;
        }

        return $response;
    }

    public static function getCustomerSumContractGroups($customer_id,$field)
    {
        return DB::table('ptom_customer_contract_groups as ccg')
        ->join('ptom_credit_group as cg', 'cg.lookup_code', '=', 'ccg.credit_group_code')
        ->where('ccg.customer_id',$customer_id)
        ->whereNull('deleted_at')
        ->whereNotNull('remaining_amount')->sum($field);
        // return $data->sum(['ccg.credit_amount']);
        // ->get(['ccg.contract_group_id','cg.description','ccg.credit_group_code','ccg.credit_percentage','ccg.credit_amount','ccg.remaining_amount','ccg.day_amount']);
    }

    public static function getHeaderPrice($price_list_id)
    {
        return DB::table('ptom_price_list_head_v as h')
        ->join('ptom_currencies_v as c', 'c.currency_code', '=', 'h.currency_code')
        ->where('h.list_header_id',$price_list_id)
        ->first(['h.list_header_id','c.currency_code','c.name']);
    }

    public static function getVatCode($vat_code)
    {
        return DB::table('ptom_tax_code_v as t')
        ->where('t.tax_rate_code',$vat_code)
        ->first(['t.tax','t.rate_type_code','t.percentage_rate']);
    }

    public static function getProductListExportTypeCode($customer_id,$orderHeader)
    {
        $response = [];
        $productList = DB::table('ptom_customers as c')
        ->select(
            'plh.list_header_id',
            'plh.name as price_header_name',
            'se.item_id',
            'se.item_code',
            'se.report_item_display',
            'se.ecom_item_description as item_description',
            'pll.operand as price_unit',
            'pll.product_uom_code',
            'puv.unit_of_measure',
            'puv.description',
            'ucv.base_unit_code',
            'se.attribute1 as out_of_stock',
            'se.color_code',
            // $item
        )
        ->join('ptom_price_list_head_v as plh', 'plh.list_header_id', '=', 'c.price_list_id')
        ->join('ptom_price_list_line_v as pll', 'pll.list_header_id', '=', 'plh.list_header_id')
        ->join('ptom_sequence_ecoms as se', 'se.item_id', '=', 'pll.item_id')
        ->join('ptom_uom_v as puv', 'puv.uom_code', '=', 'pll.product_uom_code')
        ->join('ptom_uom_conversions_v as ucv', 'ucv.uom_code', '=', 'puv.uom_code')
        ->whereRaw("lower(c.sales_classification_code) = 'export' ")
        ->whereRaw("lower(c.status) = 'active' ")
        ->where('se.deleted_at',NULL)
        ->where('c.deleted_at',NULL)
        ->where('c.customer_id',$customer_id)
        ->whereRaw("lower(plh.attribute1) = 'export' ")
        ->whereRaw("lower(se.sale_type_code) = 'export' ")
        ->where('puv.export','Y')
        ->where('se.product_type_code',$orderHeader->product_type_code)
        ->where(function($query){
            $query->whereNull('pll.start_date_active');
            $query->orWhere('pll.start_date_active','<=',date('Y-m-d'));
        })
        ->where(function($query){
            $query->whereNull('pll.end_date_active');
            $query->orWhere('pll.end_date_active','>=',date('Y-m-d'));
        })
        ->where(function($query){
            $query->whereNull('se.start_date');
            $query->orWhere('se.start_date','<=',date('Y-m-d'));
        })
        ->where(function($query){
            $query->whereNull('se.end_date');
            $query->orWhere('se.end_date','>=',date('Y-m-d'));
        })
        ->orderBy('se.screen_number','asc')
        ->get();

        foreach ($productList as $key => $item) {
            // $data[$key][] = $item;
            // echo $item

            $orderLine = OrderLines::where('order_header_id',$orderHeader->order_header_id)->where('item_id',$item->item_id)->first();

            $uomData = DB::table('ptom_uom_conversions_v')
            ->where('uom_code','=', $item->product_uom_code)
            ->get();

            $price_unit = (!is_null($orderLine)) ? $orderLine->unit_price : $item->price_unit;
            $item->price_unit = $price_unit;

            $uomList = [];
            if (count($uomData) > 0) {
                $uomConvert = DB::table('ptom_uom_conversions_v')->where('base_unit_code','=', $item->base_unit_code)->get(['uom_code','conversion_rate','base_unit_code','unit_of_measure','description']);

                foreach ($uomConvert as $key_u => $uom) {
                    $uomList[] = [
                        'uom_code'=>$uom->uom_code,
                        'conversion_rate'=>$uom->conversion_rate,
                        // 'unit_of_measure'=>$uom->unit_of_measure,
                        'base_unit_code'=>$uom->base_unit_code,
                        'unit_of_measure'=>$uom->description,
                        'price_unit'=>($uom->conversion_rate / $uomData[0]->conversion_rate) * $price_unit
                    ];
                }

            }
            // else{
            //     $uomList = [
            //         'uom_code'=>$item->product_uom_code,
            //         'conversion_rate'=>1,
            //         'unit_of_measure'=>$item->unit_of_measure,
            //         'price_unit'=>$item->price_unit
            //     ];
            // }
            // $data[$key][] = $uom;
            $item->uom_list = $uomList;
            $response[$key] = $item;
            // array_merge($item,$uom);
            // $response[$key] = $uom;
        }

        return $response;

    }

    public static function getProductListTypeCode($customer_id,$type,$orderHeader='')
    {
        //  $item = DB::raw("(SELECT item_description FROM ptom_sequence_ecoms
        //     WHERE ptom_sequence_ecoms.item_id = pll.item_id
        // ) as item_description");

        $productList = DB::table('ptom_customers as c')
        ->select(
            'plh.list_header_id',
            'plh.name as price_header_name',
            'se.item_id',
            'se.item_code',
            'se.ecom_item_description as item_description',
            'pll.operand as price_unit',
            'pll.product_uom_code',
            'puv.unit_of_measure',
            'se.attribute1 as out_of_stock',
            'ucv.base_unit_code',
            'se.color_code',
            // $item
        )
        ->join('ptom_price_list_head_v as plh', 'plh.list_header_id', '=', 'c.price_list_id')
        ->join('ptom_price_list_line_v as pll', 'pll.list_header_id', '=', 'plh.list_header_id')
        ->join('ptom_sequence_ecoms as se', 'se.item_id', '=', 'pll.item_id')
        ->join('ptom_uom_v as puv', 'puv.uom_code', '=', 'pll.product_uom_code')
        ->join('ptom_uom_conversions_v as ucv', 'ucv.uom_code', '=', 'puv.uom_code')
        ->whereRaw("lower(c.sales_classification_code) = 'domestic' ")
        ->whereRaw("lower(c.status) = 'active' ")
        ->where('c.deleted_at',NULL)
        ->where('se.deleted_at',NULL)
        ->where('c.customer_id',$customer_id)
        ->whereRaw("lower(se.sale_type_code) = 'domestic' ")
        ->where('se.product_type_code',$type)
        ->where(function($query){
            $query->whereNull('se.start_date');
            $query->orWhere('se.start_date','<=',date('Y-m-d'));
        })
        ->where(function($query){
            $query->whereNull('se.end_date');
            $query->orWhere('se.end_date','>=',date('Y-m-d'));
        })
        ->where(function($query){
            $query->whereNull('pll.start_date_active');
            $query->orWhere('pll.start_date_active','<=',date('Y-m-d'));
        })
        ->where(function($query){
            $query->whereNull('pll.end_date_active');
            $query->orWhere('pll.end_date_active','>=',date('Y-m-d'));
        })
        ->orderBy('se.screen_number','asc')
        ->get();

        foreach ($productList as $key => $item) {
            // $data[$key][] = $item;
            // echo $item

            $uomData = DB::table('ptom_uom_conversions_v')
            ->where('uom_code','=', $item->product_uom_code)
            ->where('domestic','Y')
            ->get();

            $price_unit = $item->price_unit;

            if($orderHeader != ''){
                $orderLine = OrderLines::where('order_header_id',$orderHeader->order_header_id)->where('item_id',$item->item_id)->first();

                if(!is_null($orderLine)){

                    $uomData = DB::table('ptom_uom_conversions_v')
                    ->where('uom_code','=', $orderLine->uom_code)
                    ->where('domestic','Y')
                    ->get();

                    $item->product_uom_code = $orderLine->uom_code;
                }

                $price_unit = (!is_null($orderLine)) ? $orderLine->unit_price : $item->price_unit;
                $item->price_unit = $price_unit;
            }

            $uomList = [];
            if (count($uomData) > 0) {
                $uomConvert = DB::table('ptom_uom_conversions_v as ucv')
                ->join('ptom_uom_v as puv', 'puv.uom_code', '=', 'ucv.uom_code')
                ->where('base_unit_code','=', $item->base_unit_code)
                ->where('puv.uom_class','ทั่วไป')
                ->where('puv.domestic','Y')
                ->where('ucv.domestic','Y')
                ->get(['ucv.uom_code','ucv.conversion_rate','ucv.base_unit_code','ucv.unit_of_measure','ucv.description']);

                foreach ($uomConvert as $key_u => $uom) {
                    $uomList[] = [
                        'uom_code'=>$uom->uom_code,
                        'conversion_rate'=>$uom->conversion_rate,
                        // 'unit_of_measure'=>$uom->unit_of_measure,
                        'base_unit_code'=>$uom->base_unit_code,
                        'unit_of_measure'=>$uom->unit_of_measure,
                        'price_unit'=>($uom->conversion_rate / $uomData[0]->conversion_rate) * $price_unit
                    ];
                }

            }
            // else{
            //     $uomList = [
            //         'uom_code'=>$item->product_uom_code,
            //         'conversion_rate'=>1,
            //         'unit_of_measure'=>$item->unit_of_measure,
            //         'price_unit'=>$item->price_unit
            //     ];
            // }
            // $data[$key][] = $uom;
            $item->uom_list = $uomList;
            $response[$key] = $item;
            // array_merge($item,$uom);
            // $response[$key] = $uom;
        }

        return $response;

        // $priceUnit = DB::raw("(SELECT operand FROM ptom_price_list_line_v
        //     WHERE ptom_price_list_line_v.list_header_id = plh.list_header_id
        //     AND ptom_price_list_line_v.item_id = se.item_id
        // ) as price_unit");

        // return DB::table('ptom_sequence_ecoms as se')
        // ->select(
        //     'se.item_id',
        //     'se.item_code',
        //     'se.item_description',
        // )
        // ->join('ptom_price_list_head_v as plh', 'plh.list_header_id', '=', 'c.price_list_id')
        // // ->join('ptom_credit_group as cg', 'cg.lookup_code', '=', 'ccg.credit_group_code')
        // ->whereRaw("lower(se.sale_type_code) = 'domestic' ")
        // ->where('se.product_type_code',$type)
        // ->get();
    }

    public static function getProductListTypeCodePriceList($customer_id,$type,$price_list='')
    {

        $productList = DB::table('ptom_price_list_head_v as plh')
        ->select(
            'plh.list_header_id',
            'plh.name as price_header_name',
            'se.item_id',
            'se.item_code',
            'se.ecom_item_description as item_description',
            'pll.operand as price_unit',
            'pll.product_uom_code',
            'puv.unit_of_measure',
            'se.attribute1 as out_of_stock',
            'ucv.base_unit_code',
            'se.color_code',
            // $item
        )
        ->join('ptom_price_list_line_v as pll', 'pll.list_header_id', '=', 'plh.list_header_id')
        ->join('ptom_sequence_ecoms as se', 'se.item_id', '=', 'pll.item_id')
        ->join('ptom_uom_v as puv', 'puv.uom_code', '=', 'pll.product_uom_code')
        ->join('ptom_uom_conversions_v as ucv', 'ucv.uom_code', '=', 'puv.uom_code')
        ->where('se.deleted_at',NULL)
        ->whereRaw("lower(se.sale_type_code) = 'domestic' ")
        ->where('se.product_type_code',$type)
        ->where('pll.list_header_id',$price_list)
        ->where('pll.start_date_active','<=',date('Y-m-d'))
        ->where(function($query){
            $query->whereNull('pll.end_date_active');
            $query->orWhere('pll.end_date_active','>=',date('Y-m-d'));
        })
        ->where(function($query){
            $query->whereNull('se.start_date');
            $query->orWhere('se.start_date','<=',date('Y-m-d'));
        })
        ->where(function($query){
            $query->whereNull('se.end_date');
            $query->orWhere('se.end_date','>=',date('Y-m-d'));
        })
        ->orderBy('se.screen_number','asc')
        ->get();

        foreach ($productList as $key => $item) {

            $uomData = DB::table('ptom_uom_conversions_v')
            ->where('uom_code','=', $item->product_uom_code)
            ->where('domestic','Y')
            ->get();

            $price_unit = $item->price_unit;

            $uomList = [];
            if (count($uomData) > 0) {
                $uomConvert = DB::table('ptom_uom_conversions_v as ucv')
                ->join('ptom_uom_v as puv', 'puv.uom_code', '=', 'ucv.uom_code')
                ->where('base_unit_code','=', $item->base_unit_code)
                ->where('puv.uom_class','ทั่วไป')
                ->where('puv.domestic','Y')
                ->where('ucv.domestic','Y')
                ->get(['ucv.uom_code','ucv.conversion_rate','ucv.base_unit_code','ucv.unit_of_measure','ucv.description']);

                foreach ($uomConvert as $key_u => $uom) {
                    $uomList[] = [
                        'uom_code'=>$uom->uom_code,
                        'conversion_rate'=>$uom->conversion_rate,
                        // 'unit_of_measure'=>$uom->unit_of_measure,
                        'base_unit_code'=>$uom->base_unit_code,
                        'unit_of_measure'=>$uom->unit_of_measure,
                        'price_unit'=>($uom->conversion_rate / $uomData[0]->conversion_rate) * $price_unit
                    ];
                }

            }

            $item->uom_list = $uomList;
            $response[$key] = $item;
        }

        return $response;
    }

    public static function getProductListTypeCodeItemid($customer_id,$type,$item_id)
    {
        //  $item = DB::raw("(SELECT item_description FROM ptom_sequence_ecoms
        //     WHERE ptom_sequence_ecoms.item_id = pll.item_id
        // ) as item_description");

        return DB::table('ptom_customers as c')
        ->select(
            'plh.list_header_id',
            'plh.name as price_header_name',
            'se.item_id',
            'se.item_code',
            'se.ecom_item_description as item_description',
            'pll.operand as price_unit',
            'pll.product_uom_code',
            'puv.unit_of_measure',
            'se.attribute1 as out_of_stock',
            'se.color_code',
            // $item
        )
        ->join('ptom_price_list_head_v as plh', 'plh.list_header_id', '=', 'c.price_list_id')
        ->join('ptom_price_list_line_v as pll', 'pll.list_header_id', '=', 'plh.list_header_id')
        ->join('ptom_sequence_ecoms as se', 'se.item_id', '=', 'pll.item_id')
        ->join('ptom_uom_v as puv', 'puv.uom_code', '=', 'pll.product_uom_code')
        ->whereRaw("lower(c.sales_classification_code) = 'domestic' ")
        ->whereRaw("lower(c.status) = 'active' ")
        ->where('c.deleted_at',NULL)
        ->where('se.deleted_at',NULL)
        ->where('c.customer_id',$customer_id)
        ->whereRaw("lower(se.sale_type_code) = 'domestic' ")
        ->where('se.product_type_code',$type)
        ->where('se.item_code',$item_id)
        ->where(function($query){
            $query->whereNull('pll.start_date_active');
            $query->orWhere('pll.start_date_active','<=',date('Y-m-d'));
        })
        ->where(function($query){
            $query->whereNull('pll.end_date_active');
            $query->orWhere('pll.end_date_active','>=',date('Y-m-d'));
        })
        ->where(function($query){
            $query->whereNull('se.start_date');
            $query->orWhere('se.start_date','<=',date('Y-m-d'));
        })
        ->where(function($query){
            $query->whereNull('se.end_date');
            $query->orWhere('se.end_date','>=',date('Y-m-d'));
        })
        ->orderBy('se.screen_number','asc')
        ->first();

    }

    public static function getCustomerQuotaRemaining($customer_id,$date)
    {
        $remaining_quota = DB::table('ptom_customer_quota_headers as cqh')
        ->join('ptom_customer_quota_lines as cql', 'cql.quota_header_id', '=', 'cqh.quota_header_id')
        ->where('cqh.start_date','<=',$date)
        ->where(function($query) use ($date){
            $query->whereNull('cqh.end_date');
            $query->orWhere('cqh.end_date','>=',$date);
        })
        ->whereRaw("lower(cqh.status) = 'active' ")
        ->where('cqh.customer_id',$customer_id)->get();

        return $remaining_quota;
    }

    public static function getCustomerQuotaHeadersByPeriod($customer_id,$period)
    {
        $response = [];
        $date = date_format(date_create($period->from_period_date),"Y-m-d");
        $quota_group = DB::table('ptom_quota_group as cg')->where('enabled_flag','Y')->get(['cg.lookup_code','cg.meaning','cg.tag']);
        $priceUnit = DB::raw("( SELECT operand FROM ptom_price_list_line_v
                                WHERE ptom_price_list_line_v.list_header_id = plh.list_header_id
                                AND ptom_price_list_line_v.item_id = cql.item_id 
                                AND ((ptom_price_list_line_v.start_date_active <= '".$date."' 
                                AND ptom_price_list_line_v.end_date_active >= '".$date."') 
                                OR ptom_price_list_line_v.end_date_active IS NULL)
                            ) as price_unit");

        $onhandQuantity = DB::raw("(SELECT SUM(onhand_quantity) 
                                    FROM ptom_onhand_v
                                    WHERE ptom_onhand_v.item_code = cql.item_code
                                    ) as onhand_quantity");

        foreach($quota_group as $item){

            $received_quota = DB::table('ptom_customer_quota_headers as cqh')
            ->join('ptom_customer_quota_lines as cql', 'cql.quota_header_id', '=', 'cqh.quota_header_id')
            ->leftJoin('ptom_quota_and_credit_group as qcg', 'qcg.item_code', '=', 'cql.item_code')
            ->where('qcg.quota_group_code',$item->lookup_code)
            ->where('cqh.start_date','<=',$date)
            ->where('cqh.end_date','>=',$date)
            ->whereRaw("lower(cqh.status) = 'active' ")
            ->where('cqh.customer_id',$customer_id)->sum('cql.received_quota');

            $remaining_quota = DB::table('ptom_customer_quota_headers as cqh')
            ->join('ptom_customer_quota_lines as cql', 'cql.quota_header_id', '=', 'cqh.quota_header_id')
            ->leftJoin('ptom_quota_and_credit_group as qcg', 'qcg.item_code', '=', 'cql.item_code')
            ->where('qcg.quota_group_code',$item->lookup_code)
            ->where('cqh.start_date','<=',$date)
            ->where('cqh.end_date','>=',$date)
            ->whereRaw("lower(cqh.status) = 'active' ")
            ->where('cqh.customer_id',$customer_id)->sum('cql.remaining_quota');

            try{
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
                    'qcg.quota_group_code',

                    'cql.quota_line_id',
                    'cql.item_id',
                    'cql.item_code',
                    'se.ecom_item_description as item_description',
                    'cql.received_quota',
                    'cql.minimum_quota',
                    'cql.remaining_quota',

                    'se.attribute1 as out_of_stock',
                    'se.screen_number',
                    'se.color_code',
                    $priceUnit,
                    $onhandQuantity
                )
                ->join('ptom_customer_quota_lines as cql', 'cql.quota_header_id', '=', 'cqh.quota_header_id')
                ->join('ptom_sequence_ecoms as se', 'se.item_code', '=', 'cql.item_code')
                ->leftJoin('ptom_quota_and_credit_group as qcg', 'qcg.item_code', '=', 'cql.item_code')

                ->join('ptom_customers as c', 'c.customer_id', '=', 'cqh.customer_id')
                ->join('ptom_price_list_head_v as plh', 'plh.list_header_id', '=', 'c.price_list_id')
                ->where('cqh.start_date','<=',$date)
                ->where('cqh.end_date','>=',$date)
                ->where(function($query) use ($date){
                    $query->whereNull('qcg.end_date');
                    $query->orWhere('qcg.end_date','>=',$date);
                })
                ->where(function($query) use ($date){
                    $query->whereNull('se.start_date');
                    $query->orWhere('se.start_date','<=',$date);
                })
                ->where(function($query) use ($date){
                    $query->whereNull('se.end_date');
                    $query->orWhere('se.end_date','>=',$date);
                })
                ->where('cqh.customer_id',$customer_id)
                ->where('qcg.quota_group_code',$item->lookup_code)
                ->whereRaw("lower(cqh.status) = 'active' ")
                ->orderBy('se.screen_number')
                ->get();

                foreach ($quota as $q) {
                    $inv = DB::table('PTOM_ONHAND_V')->where('ITEM_CODE', $q->item_code)->get();
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
                    $q->onhand = $onhandsum;

                    $creditGroupCode = OrderRepo::getCustomerContractGroupsByGroup($customer_id,$q->credit_group_code);
                    if($q->credit_group_code != 0 && count($creditGroupCode) == 0){
                        $q->credit_group_code = 0;
                    }
                }

                if(count($quota) > 0){
                    $response[] = [
                        'group' => $item,
                        'quota' => $quota,
                        'received_quota' => $received_quota,
                        'remaining_quota' => $remaining_quota,
                        'quota_use' => 0
                    ];
                }
            } catch (\Exception $e) {

            }
        }

        return $response;
    }

    public static function getCustomerQuotaHeadersByPeriodMT($customer_id,$period)
    {
        $response = [];

        $date = date_format(date_create($period->from_period_date),"Y-m-d");

        // ->where('tag','Y')
        $quota_group = DB::table('ptom_quota_group as cg')->where('enabled_flag','Y')->get(['cg.lookup_code','cg.meaning','cg.tag']);
        // ->where('tag','Y')

        $priceUnit = DB::raw("(SELECT operand FROM ptom_price_list_line_v
            WHERE ptom_price_list_line_v.list_header_id = plh.list_header_id
            AND ptom_price_list_line_v.item_id = cql.item_id AND ((ptom_price_list_line_v.start_date_active <= '".$date."' AND ptom_price_list_line_v.end_date_active >= '".$date."') OR ptom_price_list_line_v.end_date_active IS NULL)
        ) as price_unit");

        $onhandQuantity = DB::raw("(SELECT SUM(onhand_quantity) FROM ptom_onhand_v
            WHERE ptom_onhand_v.item_code = cql.item_code
        ) as onhand_quantity");

        foreach($quota_group as $item){

            $received_quota = DB::table('ptom_customer_quota_headers as cqh')
            ->join('ptom_customer_quota_lines as cql', 'cql.quota_header_id', '=', 'cqh.quota_header_id')
            ->leftJoin('ptom_quota_and_credit_group as qcg', 'qcg.item_code', '=', 'cql.item_code')
            ->where('qcg.quota_group_code',$item->lookup_code)
            ->where('cqh.start_date','<=',$date)
            ->where('cqh.end_date','>=',$date)
            ->whereRaw("lower(cqh.status) = 'active' ")
            ->where('cqh.customer_id',$customer_id)->sum('cql.received_quota');

            $remaining_quota = DB::table('ptom_customer_quota_headers as cqh')
            ->join('ptom_customer_quota_lines as cql', 'cql.quota_header_id', '=', 'cqh.quota_header_id')
            ->leftJoin('ptom_quota_and_credit_group as qcg', 'qcg.item_code', '=', 'cql.item_code')
            ->where('qcg.quota_group_code',$item->lookup_code)
            ->where('cqh.start_date','<=',$date)
            ->where('cqh.end_date','>=',$date)
            ->whereRaw("lower(cqh.status) = 'active' ")
            ->where('cqh.customer_id',$customer_id)->sum('cql.remaining_quota');

            try{
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
                    'qcg.quota_group_code',

                    'cql.quota_line_id',
                    'cql.item_id',
                    'cql.item_code',
                    'se.ecom_item_description as item_description',
                    'cql.received_quota',
                    'cql.minimum_quota',
                    'cql.remaining_quota',

                    'se.attribute1 as out_of_stock',
                    'se.screen_number',
                    'se.color_code',
                    $priceUnit,
                    $onhandQuantity
                )
                ->join('ptom_customer_quota_lines as cql', 'cql.quota_header_id', '=', 'cqh.quota_header_id')
                ->join('ptom_sequence_ecoms as se', 'se.item_code', '=', 'cql.item_code')
                ->leftJoin('ptom_quota_and_credit_group as qcg', 'qcg.item_code', '=', 'cql.item_code')

                ->join('ptom_customers as c', 'c.customer_id', '=', 'cqh.customer_id')
                ->join('ptom_price_list_head_v as plh', 'plh.list_header_id', '=', 'c.price_list_id')
                // ->rightJoin('ptom_price_list_line_v as pll', 'pll.list_header_id', '=', 'plh.list_header_id')
                ->where('cqh.start_date','<=',$date)
                ->where('cqh.end_date','>=',$date)
                // ->whereRaw("( qcg.end_date >= ".$date.") ")
                ->where(function($query) use ($date){
                    $query->whereNull('qcg.end_date');
                    $query->orWhere('qcg.end_date','>=',$date);
                })
                ->where(function($query) use ($date){
                    $query->whereNull('se.start_date');
                    $query->orWhere('se.start_date','<=',$date);
                })
                ->where(function($query) use ($date){
                    $query->whereNull('se.end_date');
                    $query->orWhere('se.end_date','>=',$date);
                })
                // ->where(function($query) use ($date){
                //     $query->whereNull('pll.start_date_active');
                //     $query->orWhere('pll.start_date_active','<=',$date);
                // })
                // ->where(function($query) use ($date){
                //     $query->whereNull('pll.end_date_active');
                //     $query->orWhere('pll.end_date_active','>=',$date);
                // })
                // ->where('qcg.end_date','>=',$date)
                ->where('cqh.customer_id',$customer_id)
                ->where('qcg.quota_group_code',$item->lookup_code)
                ->whereRaw("lower(cqh.status) = 'active' ")
                ->orderBy('se.screen_number')
                ->get();

                foreach ($quota as $q) {
                    $inv = DB::table('PTOM_ONHAND_V')->where('ITEM_CODE', $q->item_code)->get();
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
                    $q->onhand = $onhandsum;

                    $q->credit_group_code = 3;
                }

                if(count($quota) > 0){
                    $response[] = [
                        'group' => $item,
                        'quota' => $quota,
                        'received_quota' => $received_quota,
                        'remaining_quota' => $remaining_quota,
                        'quota_use' => 0
                    ];
                }
            } catch (\Exception $e) {

            }

        }

        return $response;
    }

    public static function getCustomerQuotaHeaders($customer_id,$orderHeader,$delivery_date='')
    {
        $response = [];
    
        if(!is_null($orderHeader)){

            if (!is_null($orderHeader->delivery_date)) {
                $date = date("Y-m-d", strtotime(date("Y-m-d", strtotime($orderHeader->delivery_date))));
                $postpon = DB::table('ptom_postpone_orders')->where('from_period_id', $orderHeader->period_id)
                ->where('customer_id', $orderHeader->customer_id)
                ->where('approve_status','อนุมัติ')->first();
                if(!empty($postpon)) {
                    $date = $postpon->from_period_date;
                }
            } else if(!is_null($orderHeader->period_id)){
                $sdate = DB::table('ptom_period_v as pvf')
                ->where('period_line_id','=', $orderHeader->period_id)
                ->first(['start_period']);
                $delivery_date = DB::table('ptom_customers')
                ->where('customer_id','=', $customer_id)
                ->first();

                $day = DB::table('ptom_day')
                ->where('meaning','=', $delivery_date->delivery_date)
                ->first();

                if(!is_null($day->tag)){
                    $date = date('Y-m-d', strtotime(date_format(date_create($sdate->start_period),"Y-m-d").' +'.$day->tag.' day'));
                }else{
                    $date = date_format(date_create($sdate->start_period),"Y-m-d");
                }

            } else{
                $date = date("Y-m-d", strtotime(date("Y-m-d", strtotime($orderHeader->order_date))));
            }

            // $sdate = DB::table('ptom_period_v as pvf')
            // ->where('period_line_id','=', $orderHeader->period_id)
            // ->first(['start_period']);

            // $date = date_format(date_create($sdate->start_period),"Y-m-d");
        }else{
            if($delivery_date != ''){
                $date = $delivery_date;
            }else{
                $date = date('Y-m-d');
            }

        }

        // dd($date);

        // if(!is_null($orderHeader)){

        //     date("Y-m-d", strtotime("+1 week"));
        //     // $sdate = DB::table('ptom_period_v as pvf')
        //     // ->where('period_line_id','=', $orderHeader->period_id)
        //     // ->first(['start_period']);

        //     $date = date_format(date_create($sdate->start_period),"Y-m-d");
        // }else{
        //     $date = date('Y-m-d');
        // }


        // ->where('tag','Y')
        $quota_group = DB::table('ptom_quota_group as cg')->where('enabled_flag','Y')->get(['cg.lookup_code','cg.meaning','cg.tag']);
        // ->where('tag','Y')

        $priceUnit = DB::raw("(SELECT operand FROM ptom_price_list_line_v
            WHERE ptom_price_list_line_v.list_header_id = plh.list_header_id
            AND ptom_price_list_line_v.item_id = cql.item_id AND ((ptom_price_list_line_v.start_date_active <= '".$date."' AND ptom_price_list_line_v.end_date_active >= '".$date."') OR ptom_price_list_line_v.end_date_active IS NULL)
        ) as price_unit");

        $onhandQuantity = DB::raw("(SELECT SUM(onhand_quantity) FROM ptom_onhand_v
            WHERE ptom_onhand_v.item_code = cql.item_code
        ) as onhand_quantity");



        foreach($quota_group as $item){

            $received_quota = DB::table('ptom_customer_quota_headers as cqh')
            ->join('ptom_customer_quota_lines as cql', 'cql.quota_header_id', '=', 'cqh.quota_header_id')
            ->leftJoin('ptom_quota_and_credit_group as qcg', 'qcg.item_code', '=', 'cql.item_code')
            ->where('qcg.quota_group_code',$item->lookup_code)
            ->where('cqh.start_date','<=',$date)
            ->where('cqh.end_date','>=',$date)
            ->whereRaw("lower(cqh.status) = 'active' ")
            ->whereNull('cqh.deleted_at')
            ->where('cqh.customer_id',$customer_id)->sum('cql.received_quota');

            $remaining_quota = DB::table('ptom_customer_quota_headers as cqh')
            ->join('ptom_customer_quota_lines as cql', 'cql.quota_header_id', '=', 'cqh.quota_header_id')
            ->leftJoin('ptom_quota_and_credit_group as qcg', 'qcg.item_code', '=', 'cql.item_code')
            ->where('qcg.quota_group_code',$item->lookup_code)
            ->where('cqh.start_date','<=',$date)
            ->where('cqh.end_date','>=',$date)
            ->whereNull('cqh.deleted_at')
            ->where('cqh.customer_id',$customer_id)->sum('cql.remaining_quota');

            try {
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
                    'qcg.quota_group_code',

                    'cql.quota_line_id',
                    'cql.item_id',
                    'cql.item_code',
                    'se.ecom_item_description as item_description',
                    'cql.received_quota',
                    'cql.minimum_quota',
                    'cql.remaining_quota',

                    'se.attribute1 as out_of_stock',
                    'se.screen_number',
                    'se.color_code',
                    // 'pll.start_date_active',
                    // 'pll.end_date_active',
                    $priceUnit,
                    $onhandQuantity
                )
                ->join('ptom_customer_quota_lines as cql', 'cql.quota_header_id', '=', 'cqh.quota_header_id')
                ->join('ptom_sequence_ecoms as se', 'se.item_code', '=', 'cql.item_code')
                ->leftJoin('ptom_quota_and_credit_group as qcg', 'qcg.item_code', '=', 'cql.item_code')

                ->join('ptom_customers as c', 'c.customer_id', '=', 'cqh.customer_id')
                ->join('ptom_price_list_head_v as plh', 'plh.list_header_id', '=', 'c.price_list_id')
                // ->rightJoin('ptom_price_list_line_v as pll', 'pll.item_id', '=', 'cql.item_id')
                ->where('cqh.start_date','<=',$date)
                ->where('cqh.end_date','>=',$date)
                // ->whereRaw("( qcg.end_date >= ".$date.") ")
                ->where(function($query) use ($date){
                    $query->whereNull('qcg.end_date');
                    $query->orWhere('qcg.end_date','>=',$date);
                })
                ->where(function($query) use ($date){
                    $query->whereNull('se.start_date');
                    $query->orWhere('se.start_date','<=',$date);
                })
                ->where(function($query) use ($date){
                    $query->whereNull('se.end_date');
                    $query->orWhere('se.end_date','>=',$date);
                })
                // ->where(function($query) use ($date){
                //     $query->whereNull('pll.start_date_active');
                //     $query->orWhere('pll.start_date_active','<=',$date);
                // })
                // ->where(function($query) use ($date){
                //     $query->whereNull('pll.end_date_active');
                //     $query->orWhere('pll.end_date_active','>=',$date);
                // })
                // ->where('qcg.end_date','>=',$date)
                ->where('cqh.customer_id',$customer_id)
                ->where('qcg.quota_group_code',$item->lookup_code)
                ->whereRaw("lower(cqh.status) = 'active' ")
                ->orderBy('se.screen_number')
                ->get();


                foreach ($quota as $q) {
                    $inv = DB::table('PTOM_ONHAND_V')->where('ITEM_CODE', $q->item_code)->get();
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
                    $q->onhand = $onhandsum;

                    $creditGroupCode = OrderRepo::getCustomerContractGroupsByGroup($customer_id,$q->credit_group_code);
                    if($q->credit_group_code != 0 && count($creditGroupCode) == 0){
                        $q->credit_group_code = 0;
                    }

                }


                if(count($quota) > 0){
                    $response[] = [
                        'group' => $item,
                        'quota' => $quota,
                        'received_quota' => $received_quota,
                        'remaining_quota' => $remaining_quota,
                        'quota_use' => 0
                    ];
                }
            } catch (\Exception $e) {

            }

        }

        return $response;
    }

    public static function getCustomerQuotaHeadersMT($customer_id,$orderHeader,$delivery_date='')
    {
        $response = [];

        if(!is_null($orderHeader)){

            if (!is_null($orderHeader->delivery_date)) {
                $date = date("Y-m-d", strtotime(date("Y-m-d", strtotime($orderHeader->delivery_date))));
            } else if(!is_null($orderHeader->period_id)){
                $sdate = DB::table('ptom_period_v as pvf')
                ->where('period_line_id','=', $orderHeader->period_id)
                ->first(['start_period']);

                $delivery_date = DB::table('ptom_customers')
                ->where('customer_id','=', $customer_id)
                ->first();

                $day = DB::table('ptom_day')
                ->where('meaning','=', $delivery_date->delivery_date)
                ->first();

                if(!is_null($day->tag)){
                    $date = date('Y-m-d', strtotime(date_format(date_create($sdate->start_period),"Y-m-d").' +'.$day->tag.' day'));
                }else{
                    $date = date_format(date_create($sdate->start_period),"Y-m-d");
                }
            } else {
                $date = date("Y-m-d", strtotime(date("Y-m-d", strtotime($orderHeader->order_date))));
            }
            // $sdate = DB::table('ptom_period_v as pvf')
            // ->where('period_line_id','=', $orderHeader->period_id)
            // ->first(['start_period']);

            // $date = date_format(date_create($sdate->start_period),"Y-m-d");
        }else{
            if($delivery_date != ''){
                $date = $delivery_date;
            }else{
                $date = date('Y-m-d');
            }
        }


        // ->where('tag','Y')
        $quota_group = DB::table('ptom_quota_group as cg')->where('enabled_flag','Y')->get(['cg.lookup_code','cg.meaning','cg.tag']);
        // ->where('tag','Y')

        $priceUnit = DB::raw("(SELECT operand FROM ptom_price_list_line_v
            WHERE ptom_price_list_line_v.list_header_id = plh.list_header_id
            AND ptom_price_list_line_v.item_id = cql.item_id AND ((ptom_price_list_line_v.start_date_active <= '".$date."' AND ptom_price_list_line_v.end_date_active >= '".$date."') OR ptom_price_list_line_v.end_date_active IS NULL)
        ) as price_unit");

        $onhandQuantity = DB::raw("(SELECT SUM(onhand_quantity) FROM ptom_onhand_v
            WHERE ptom_onhand_v.item_code = cql.item_code
        ) as onhand_quantity");

        foreach($quota_group as $item){

            $received_quota = DB::table('ptom_customer_quota_headers as cqh')
            ->join('ptom_customer_quota_lines as cql', 'cql.quota_header_id', '=', 'cqh.quota_header_id')
            ->leftJoin('ptom_quota_and_credit_group as qcg', 'qcg.item_code', '=', 'cql.item_code')
            ->where('qcg.quota_group_code',$item->lookup_code)
            ->where('cqh.start_date','<=',$date)
            ->where('cqh.end_date','>=',$date)
            ->whereRaw("lower(cqh.status) = 'active' ")
            ->where('cqh.customer_id',$customer_id)->sum('cql.received_quota');

            $remaining_quota = DB::table('ptom_customer_quota_headers as cqh')
            ->join('ptom_customer_quota_lines as cql', 'cql.quota_header_id', '=', 'cqh.quota_header_id')
            ->leftJoin('ptom_quota_and_credit_group as qcg', 'qcg.item_code', '=', 'cql.item_code')
            ->where('qcg.quota_group_code',$item->lookup_code)
            ->where('cqh.start_date','<=',$date)
            ->where('cqh.end_date','>=',$date)
            ->whereRaw("lower(cqh.status) = 'active' ")
            ->where('cqh.customer_id',$customer_id)->sum('cql.remaining_quota');

            try{
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
                    'qcg.quota_group_code',

                    'cql.quota_line_id',
                    'cql.item_id',
                    'cql.item_code',
                    'se.ecom_item_description as item_description',
                    'cql.received_quota',
                    'cql.minimum_quota',
                    'cql.remaining_quota',

                    'se.attribute1 as out_of_stock',
                    'se.screen_number',
                    'se.color_code',
                    // 'pll.start_date_active',
                    // 'pll.end_date_active',
                    $priceUnit,
                    $onhandQuantity
                )
                ->join('ptom_customer_quota_lines as cql', 'cql.quota_header_id', '=', 'cqh.quota_header_id')
                ->join('ptom_sequence_ecoms as se', 'se.item_code', '=', 'cql.item_code')
                ->leftJoin('ptom_quota_and_credit_group as qcg', 'qcg.item_code', '=', 'cql.item_code')

                ->join('ptom_customers as c', 'c.customer_id', '=', 'cqh.customer_id')
                ->join('ptom_price_list_head_v as plh', 'plh.list_header_id', '=', 'c.price_list_id')
                // ->rightJoin('ptom_price_list_line_v as pll', 'pll.item_id', '=', 'cql.item_id')
                ->where('cqh.start_date','<=',$date)
                ->where('cqh.end_date','>=',$date)
                // ->whereRaw("( qcg.end_date >= ".$date.") ")
                ->where(function($query) use ($date){
                    $query->whereNull('qcg.end_date');
                    $query->orWhere('qcg.end_date','>=',date('Y-m-d'));
                })
                ->where(function($query) use ($date){
                    $query->whereNull('se.start_date');
                    $query->orWhere('se.start_date','<=',$date);
                })
                ->where(function($query) use ($date){
                    $query->whereNull('se.end_date');
                    $query->orWhere('se.end_date','>=',$date);
                })
                // ->where(function($query) use ($date){
                //     $query->whereNull('pll.start_date_active');
                //     $query->orWhere('pll.start_date_active','<=',$date);
                // })
                // ->where(function($query) use ($date){
                //     $query->whereNull('pll.end_date_active');
                //     $query->orWhere('pll.end_date_active','>=',$date);
                // })
                // ->where('qcg.end_date','>=',$date)
                ->where('cqh.customer_id',$customer_id)
                ->where('qcg.quota_group_code',$item->lookup_code)
                ->whereRaw("lower(cqh.status) = 'active' ")
                ->orderBy('se.screen_number')
                ->get();

                foreach ($quota as $q) {
                    $inv = DB::table('PTOM_ONHAND_V')->where('ITEM_CODE', $q->item_code)->get();
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
                    $q->onhand = $onhandsum;

                    $q->credit_group_code = 3;
                }


                if(count($quota) > 0){
                    $response[] = [
                        'group' => $item,
                        'quota' => $quota,
                        'received_quota' => $received_quota,
                        'remaining_quota' => $remaining_quota,
                        'quota_use' => 0
                    ];
                }
            } catch (\Exception $e) {

            }

        }

        return $response;
    }

    public static function getCustomerSpecialHeaders($customer_id,$orderHeader,$fromHeaderOrder)
    {
        $response = [];
        if (!is_null($orderHeader) && $orderHeader->installment_type_code == 20) {
            $date = date_format(date_create($orderHeader->delivery_date),"Y-m-d");
        }elseif(!is_null($orderHeader)){
            $date = date_format(date_create($orderHeader->order_date),"Y-m-d");
        }else{
            $date = date('Y-m-d');
        }

        $priceUnit = DB::raw("(SELECT operand FROM ptom_price_list_line_v
            WHERE ptom_price_list_line_v.list_header_id = plh.list_header_id
            AND ptom_price_list_line_v.item_id = fol.item_id
            AND ((ptom_price_list_line_v.start_date_active <= '".$date."' 
            AND ptom_price_list_line_v.end_date_active >= '".$date."') 
            OR ptom_price_list_line_v.end_date_active IS NULL)
        ) as price_unit");


        $quota = DB::table('ptom_form_order_lines as fol')
        ->select(
            'plh.list_header_id',
            'plh.name as price_header_name',
            'fol.item_id',
            'fol.item_code',
            'fol.approve_quantity',
            'fol.quantity',
            'fol.attribute1',
            'fol.attribute2',
            'se.ecom_item_description as item_description',
            'se.color_code',
            $priceUnit,
        )
        ->join('ptom_form_order_headers as foh', 'foh.form_header_id', '=', 'fol.form_header_id')
        ->join('ptom_sequence_ecoms as se', 'se.item_code', '=', 'fol.item_code')
        ->join('ptom_customers as c', 'c.customer_id', '=', 'foh.customer_id')
        ->join('ptom_price_list_head_v as plh', 'plh.list_header_id', '=', 'c.price_list_id')
        ->where('foh.customer_id',$customer_id)
        ->where('foh.form_header_id',$fromHeaderOrder->form_header_id)
        ->where('foh.approve_status','อนุมัติ')
        ->where('foh.to_period_date',$date)
        ->where('foh.form_type','SPECIAL')
        ->orderBy('se.screen_number')
        ->get();
        foreach ($quota as $q) {

            $q->convert_uom_cgc = collect(\DB::select("
                                                select  (       apps.inv_convert.inv_um_convert (
                                                                item_id           => '{$q->item_id}',
                                                                organization_id   => 64,
                                                                PRECISION         => NULL,
                                                                from_quantity     => '{$q->quantity}',
                                                                from_unit         => 'CGC',
                                                                to_unit           => 'CGK',
                                                                from_name         => NULL,
                                                                to_name           => NULL)
                                                        )       result
                                                from dual
                                                                                                        "))->first()->result;
                                                    \Log::info("Convert UOM : { $q->convert_uom_cgc} using select  (       apps.inv_convert.inv_um_convert (
                                                        item_id           => '{$q->item_id}',
                                                        organization_id   => 64,
                                                        PRECISION         => NULL,
                                                        from_quantity     => '{$q->quantity}',
                                                        from_unit         => 'CGC',
                                                        to_unit           => 'CGK',
                                                        from_name         => NULL,
                                                        to_name           => NULL)
                                                )       result
                                        from dual
                                                                                                ");
             $q->convert_uom_cgc_approve = collect(\DB::select("
                                                select  (       apps.inv_convert.inv_um_convert (
                                                                item_id           => '{$q->item_id}',
                                                                organization_id   => 64,
                                                                PRECISION         => NULL,
                                                                from_quantity     => '{$q->approve_quantity}',
                                                                from_unit         => 'CGC',
                                                                to_unit           => 'CGK',
                                                                from_name         => NULL,
                                                                to_name           => NULL)
                                                        )       result
                                                from dual
                                                                                                        "))->first()->result;
            $q->convert_uom_cg = collect(\DB::select("
                                                select  (       apps.inv_convert.inv_um_convert (
                                                                item_id           => '{$q->item_id}',
                                                                organization_id   => 64,
                                                                PRECISION         => NULL,
                                                                from_quantity     => '{$q->attribute1}',
                                                                from_unit         => 'CG2',
                                                                to_unit           => 'CGK',
                                                                from_name         => NULL,
                                                                to_name           => NULL)
                                                        )       result
                                                from dual
                                                                                                        "))->first()->result;
            $q->convert_uom_cg_approve = collect(\DB::select("
                                                select  (       apps.inv_convert.inv_um_convert (
                                                                item_id           => '{$q->item_id}',
                                                                organization_id   => 64,
                                                                PRECISION         => NULL,
                                                                from_quantity     => '{$q->attribute2}',
                                                                from_unit         => 'CG2',
                                                                to_unit           => 'CGK',
                                                                from_name         => NULL,
                                                                to_name           => NULL)
                                                        )       result
                                                from dual
                                                                                                        "))->first()->result;

            $q->total_cgk = $q->convert_uom_cgc + $q->convert_uom_cg;
            $q->total_cgk_approve = $q->convert_uom_cgc_approve + $q->convert_uom_cg_approve;
        }

        return $quota;
    }

    public static function getCustomerQuotaLines($header_id,$status='')
    {
        $response = [];

        $response = DB::table('ptom_order_lines as ol')
        ->select(
            'ol.*',
            'qcg.quota_group_code'
        )
        ->where('order_header_id',$header_id)
        // ->where('qcg.start_date','<=',date('Y-m-d'))
        ->where(function($query) use ($status){
            if(strtolower($status) != 'confirm'){
                $query->where('qcg.start_date','<=',date('Y-m-d'));
            }
        })
        ->where(function($query) use ($status){
            if(strtolower($status) != 'confirm'){
                $query->whereNull('qcg.end_date');
                $query->orWhere('qcg.end_date','>=',date('Y-m-d'));
            }
        })
        ->leftJoin('ptom_quota_and_credit_group as qcg', 'qcg.item_code', '=', 'ol.item_code')
        ->orderBy('line_number','asc')
        ->get();

        return $response;
    }

    public static function getQuotaOrderLines($customer_id,$line,$orderHeader)
    {
        $response = [];

        $sdate = DB::table('ptom_period_v as pvf')
        ->where('period_line_id','=', $orderHeader->period_id)
        ->first(['start_period']);

        $date = date_format(date_create($sdate->start_period),"Y-m-d");

        $onhandQuantity = DB::raw("(SELECT SUM(onhand_quantity) FROM ptom_onhand_v
            WHERE ptom_onhand_v.item_code = cql.item_code
        ) as onhand_quantity");

        $orderHistoryQuota = OrderQuotaHistory::where('order_header_id',$orderHeader->order_header_id)->where('quota_group_code',$line->quota_group_code)->first();
        if(is_null($orderHistoryQuota)){
            $received_quota = DB::table('ptom_customer_quota_headers as cqh')
            ->join('ptom_customer_quota_lines as cql', 'cql.quota_header_id', '=', 'cqh.quota_header_id')
            ->leftJoin('ptom_quota_and_credit_group as qcg', 'qcg.item_code', '=', 'cql.item_code')
            ->where('qcg.quota_group_code',$line->quota_group_code)
            ->where('cqh.start_date','<=',$date)
            ->where('cqh.end_date','>=',$date)
            ->whereRaw("lower(cqh.status) = 'active' ")
            ->where('cqh.customer_id',$customer_id)->sum('cql.received_quota');

            $remaining_quota = DB::table('ptom_customer_quota_headers as cqh')
            ->join('ptom_customer_quota_lines as cql', 'cql.quota_header_id', '=', 'cqh.quota_header_id')
            ->leftJoin('ptom_quota_and_credit_group as qcg', 'qcg.item_code', '=', 'cql.item_code')
            ->where('qcg.quota_group_code',$line->quota_group_code)
            ->where('cqh.start_date','<=',$date)
            ->where('cqh.end_date','>=',$date)
            ->whereRaw("lower(cqh.status) = 'active' ")
            ->where('cqh.customer_id',$customer_id)->sum('cql.remaining_quota');
        }else{
            $received_quota = $orderHistoryQuota->received_quota;
            $remaining_quota = $orderHistoryQuota->remaining_quota - $orderHistoryQuota->spending_quota;
        }

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
            'se.ecom_item_description as item_description',
            'cql.received_quota',
            'cql.minimum_quota',
            'cql.remaining_quota',
            $onhandQuantity
        )
        ->join('ptom_customer_quota_lines as cql', 'cql.quota_header_id', '=', 'cqh.quota_header_id')
        ->join('ptom_sequence_ecoms as se', 'se.item_code', '=', 'cql.item_code')
        ->leftJoin('ptom_quota_and_credit_group as qcg', 'qcg.item_code', '=', 'cql.item_code')

        ->join('ptom_customers as c', 'c.customer_id', '=', 'cqh.customer_id')
        ->join('ptom_price_list_head_v as plh', 'plh.list_header_id', '=', 'c.price_list_id')
        ->where('cqh.start_date','<=',$date)
        ->where('cqh.end_date','>=',$date)
        ->where(function($query){
            $query->whereNull('qcg.end_date');
            $query->orWhere('qcg.end_date','>=',date('Y-m-d'));
        })
        ->where(function($query) use ($date){
            $query->whereNull('se.start_date');
            $query->orWhere('se.start_date','<=',$date);
        })
        ->where(function($query) use ($date){
            $query->whereNull('se.end_date');
            $query->orWhere('se.end_date','>=',$date);
        })
        ->where('cqh.customer_id',$customer_id)
        ->where('qcg.item_id',$line->item_id)
        ->where('qcg.quota_credit_id',$line->quota_credit_id)
        ->where('qcg.quota_group_code',$line->quota_group_code)
        ->whereRaw("lower(cqh.status) = 'active' ")
        ->get();

        foreach ($quota as $q) {
            $inv = DB::table('PTOM_ONHAND_V')->where('ITEM_CODE', $q->item_code)->get();
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
            $q->onhand = $onhandsum;
        }

        return [
            'quota' => $quota,
            'received_quota' => $received_quota,
            'remaining_quota' => $remaining_quota,
            'quota_use' => 0
        ];
    }

    public static function getLatestOrderLine($item_id,$customer_id,$orderHeader=[])
    {
        $response = [];


        return DB::table('ptom_order_lines as ol')
        ->join('ptom_order_headers as oh', 'oh.order_header_id', '=', 'ol.order_header_id')
        ->where('oh.customer_id',$customer_id)
        ->where('ol.item_id',$item_id)
        ->where(function($query) use ($orderHeader){
            if(!empty($orderHeader->delivery_date)){
                $query->where('oh.delivery_date','<', $orderHeader->delivery_date);
            }
        })
        // ->whereNotNull('ol.delivery_date')
        ->where('oh.pick_release_status','Confirm')
        ->where('oh.order_status','Confirm')
        // ->whereRaw("lower(
        //     (
        //         SELECT ptom_order_history.order_status
        //         FROM ptom_order_history
        //         WHERE oh.order_header_id = ptom_order_history.order_header_id
        //         ORDER BY ptom_order_history.order_history_id DESC OFFSET 0 ROWS FETCH NEXT 1 ROWS ONLY
        //     )
        // ) = 'closed' ")
        ->orderBy('ol.order_line_id', 'DESC')->first();

        // return $response;
    }

    public static function additionQuota($order_header_id,$customer,$val,$overQuota)
    {
        // $dataUser = getDefaultData('/users');

        $additionQuota = AdditionQuota::where('order_header_id',$order_header_id)->first();

        if (!isset($additionQuota) || empty($additionQuota)) {
            $additionQuota = new AdditionQuota();
            $additionQuota->order_header_id = $order_header_id;
            $additionQuota->org_id = '81';
            $additionQuota->org_name = '';
            $additionQuota->customer_id = $customer->customer_id;
            $additionQuota->bill_to_site_id = $customer->customer_id;
            $additionQuota->customer_contact_id = $customer->contact_phone;
            $additionQuota->employee_approve1 = 1;
            $additionQuota->employee_approve2 = 2;
            $additionQuota->employee_approve3 = 3;
            $additionQuota->approve_status = 'ขออนุมัติ';
            $additionQuota->program_code = 'OMP0019';
            $additionQuota->created_by = 1;
            $additionQuota->creation_date = now();
            $additionQuota->last_updated_by = 1;
            $additionQuota->last_update_date = now();
            $additionQuota->save();

            $quota_header_id = $additionQuota->getKey();
        }else{
            $quota_header_id = $additionQuota->quota_header_id;
        }

        $additionQuotaLines = AdditionQuotaLines::where('quota_header_id',$quota_header_id)->where('quota_group_id',$val['group']->lookup_code)->first();

        if (!isset($additionQuotaLines) || empty($additionQuotaLines)) {
            $additionQuotaLines = new AdditionQuotaLines();
        }

        $additionQuotaLines->quota_header_id = $quota_header_id;
        $additionQuotaLines->quota_group_id = $val['group']->lookup_code;
        $additionQuotaLines->quota_quantity = $val['remaining_quota'];
        // $additionQuotaLines->last_approve_quantity = $val['remaining_quota'];
        $additionQuotaLines->request_quantity = $overQuota[$val['group']->lookup_code] - $val['remaining_quota'];
        $additionQuotaLines->total_quantity = $overQuota[$val['group']->lookup_code];
        $additionQuotaLines->approve_status = 'U';
        $additionQuotaLines->program_code = 'OMP0019';
        $additionQuotaLines->created_by = 1;
        $additionQuotaLines->creation_date = now();
        $additionQuotaLines->last_updated_by = 1;
        $additionQuotaLines->last_update_date = now();
        $additionQuotaLines->save();

    }

    public static function getPenalty($customer_id,$no,$credit_group_code)
    {
        $data['Outstanding'] = [];

        $penaltyRate = PenaltyRateDomesticV::where('enabled_flag','Y')->first();
        if(is_null($penaltyRate)){
            $amountPenaltyRate = 0;
        }else{
            $amountPenaltyRate = $penaltyRate->description;
        }

        $daysInYear = Carbon::parse(date('Y'))->daysInYear;

        $Outstanding = OutstandingDebtDomesticV::where('customer_id',$customer_id)->where('pick_release_no',$no)->where('pick_release_no',$no)->where('credit_group_code',$credit_group_code)->where('outstanding_debt','>',0)->where('pick_release_status','Confirm')->first();

        $releaseCredit = ReleaseCredit::where('invoice_id',$Outstanding->order_header_id)->where('customer_id',$customer_id)->where('credit_group_code',$Outstanding->credit_group_code)->first();

        $pick_release_no = ((!is_null($Outstanding->pick_release_no)) ? $Outstanding->pick_release_no : $Outstanding->consignment_no);

        if(!is_null($releaseCredit)){
            // ค่าปรับ
            return $releaseCredit->charge_amount;
        }else{

            $date = Carbon::parse($Outstanding->due_date);
            $now = Carbon::parse(now());

            if($date >= $now){
                $diff = 0;
            }else{
                $diff = $date->diffInDays($now);
            }

            $penalty_total = 0;
            $outstanding_debt = $Outstanding->outstanding_debt;
            $sum_payment_amount = 0;
            for ($i=0; $i < $diff; $i++) {

                if(!is_null($Outstanding->prepare_order_number)){
                    $payment_amount = DB::table('ptom_payment_match_invoices')
                    ->where('prepare_order_number',$Outstanding->prepare_order_number)
                    ->where('credit_group_code',$Outstanding->credit_group_code)
                    ->whereDate('creation_date',$date->addDays(1)->format('Y-m-d'))
                    ->where('match_flag','Y')
                    ->whereNull('deleted_at')->sum('payment_amount');
                }else{
                    $payment_amount = 0;
                }

                $outstanding_debt -= $payment_amount;
                $sum_payment_amount += $payment_amount;

                $penalty_total += (($outstanding_debt * $amountPenaltyRate) / 100) / $daysInYear;

            }



            return $penalty_total;
        }
    }

    public static function setOutstanding($customer_id,$period='',$order=[])
    {

        $data['Outstanding'] = [];

        $customer = Customers::byCustomerId($customer_id);

        $penaltyRate = PenaltyRateDomesticV::where('enabled_flag','Y')->first();
        if(is_null($penaltyRate)){
            $amountPenaltyRate = 0;
        }else{
            $amountPenaltyRate = $penaltyRate->description;
        }

        $daysInYear = Carbon::parse(date('Y'))->daysInYear;
        $Outstanding = [];

        if(@$order->order_status == 'Confirm'){
            // echo 'asdasd';
            $release = DB::table('ptom_release_credit')
            // ->select('ptom_debt_dom_v.*')
            // ->leftJoin('ptom_debt_dom_v', 'ptom_debt_dom_v.order_header_id', '=', 'ptom_release_credit.invoice_id')
            ->where('ptom_release_credit.customer_id',$customer_id)
            ->where('ptom_release_credit.attribute1',$order->order_header_id)
            // ->where('ptom_debt_dom_v.outstanding_debt','>',0)
            ->get();
            // $Outstanding = DB::table('OAOM.ptom_debt_dom_v')
            // // ->join('ptom_order_headers', 'ptom_order_headers.order_header_id', '=', 'ptom_order_direct_debit.order_header_id')
            // // ->where('order_header_id',$v->invoice_id)
            // ->where('order_header_id',$order->order_header_id)
            // ->where('customer_id',$customer_id)
            // ->where('outstanding_debt','>',0)
            // ->get();

            foreach ($release as $key => $v) {
                $Outstanding = DB::table('ptom_debt_dom_v')->select('ptom_debt_dom_v.*')
                // ->join('ptom_order_headers', 'ptom_order_headers.order_header_id', '=', 'ptom_order_direct_debit.order_header_id')
                ->where('order_header_id',$v->invoice_id)
                ->where('customer_id',$customer_id)
                // ->where('outstanding_debt','>',0)
                ->first();

                // ค่าปรับ
                $date = Carbon::parse($v->due_date);
                $now = Carbon::parse(now());

                if($date >= $now){
                    $diff = 0;
                }else{
                    $diff = $date->diffInDays($now);
                }

                $penalty_total = 0;
                $outstanding_debt = $Outstanding->debt_amount;
                $sum_payment_amount = 0;
                for ($i=0; $i < $diff; $i++) {

                    if(!is_null($Outstanding->prepare_order_number)){
                        $payment_amount = DB::table('ptom_payment_match_invoices')
                        ->where('prepare_order_number',$Outstanding->prepare_order_number)
                        ->where('credit_group_code',$Outstanding->credit_group_code)
                        ->whereDate('creation_date',$date->addDays(1)->format('Y-m-d'))
                        ->where('match_flag','Y')
                        ->whereNull('deleted_at')->sum('payment_amount');
                    }else{
                        $payment_amount = 0;
                    }

                    $outstanding_debt -= $payment_amount;

                    $sum_payment_amount += $payment_amount;

                    $penalty_total += (($outstanding_debt * $amountPenaltyRate) / 100) / $daysInYear;

                }
                $improve = ImproveFines::where('invoice_id',$Outstanding->order_header_id)->where('credit_group_code',$Outstanding->credit_group_code)->first();
                $improveFines = 'N';
                if(!is_null($improve)){
                    $improveFines = 'Y';
                }

                $data['Outstanding'][] = [
                    'no'=>$Outstanding->pick_release_no.'_'.$Outstanding->credit_group_code,
                    'pick_release_no'=>$Outstanding->pick_release_no,
                    'credit_group_code'=>$Outstanding->credit_group_code,
                    'description'=>(($Outstanding->credit_group_code == 0) ? 'เงินสด' : 'เงินเชื่อกลุ่ม '.$Outstanding->credit_group_code),
                    'amount'=>$Outstanding->debt_amount,
                    'auto_check'=>true,
                    'due_days'=>$Outstanding->due_days,
                    'date_th'=>dateFormatThai($Outstanding->due_date),
                    'due_date'=>dateFormatThai($Outstanding->due_date),
                    'penalty_percen'=>$amountPenaltyRate,
                    // 'penalty_day'=>$penalty_day,
                    'penalty_total'=>(!is_null($Outstanding->pick_release_no) || !is_null($Outstanding->consignment_no))  ? number_format((float)(($penalty_total < 0) ? 0 : $penalty_total), 2, '.', '') : 0,
                    'daysInYear'=>$daysInYear,
                    'improveFines'=>$improveFines,
                    'improveAmount'=> !is_null($improve) ? $improve->total_fine : 0,
                    'flag'=>'Y'
                ];
            }

        }else{

            if($period != ''){
                $period = OrderRepo::getPeriodByLineId($period);
                $Outstanding = OutstandingDebtDomesticV::where('customer_id',$customer_id)
                ->where('outstanding_debt','>',0)
                ->where('pick_release_status','Confirm')
                // ->where(function($query)  use ($period) {
                //     $query->where('due_date','<=',$period->end_period);
                // })
                ->get();
            }else{
                $Outstanding = OutstandingDebtDomesticV::where('customer_id',$customer_id)
                ->where('outstanding_debt','>',0)
                ->where('pick_release_status','Confirm')
                ->get();
            }
            foreach ($Outstanding as $key => $v) {

                try {
                    $delivery_date = OrderHeaders::where('order_header_id', @$order->order_header_id)->first()->delivery_date;
                    if(is_null($delivery_date)){
                        $delivery_date = date('Y-m-d');
                    }
                }catch (\Exception $e) {
                    $delivery_date = date('Y-m-d');
                }


                $improve = ImproveFines::where('invoice_id',$v->order_header_id)->where('credit_group_code',$v->credit_group_code)->first();
                $improveFines = 'N';
                if(!is_null($improve)){
                    $improveFines = 'Y';
                }

                $releaseCredit = ReleaseCredit::where('invoice_id',$v->order_header_id)->where('customer_id',$customer_id)->first();
                $pick_release_no = ((!is_null($v->pick_release_no)) ? $v->pick_release_no : $v->consignment_no);

                if(!is_null($releaseCredit)){

                    // ค่าปรับ
                    $date = Carbon::parse($v->due_date);
                    $now = Carbon::parse(now());

                    if($date >= $now){
                        $diff = 0;
                    }else{
                        $diff = $date->diffInDays($now);
                    }

                    $penalty_total = 0;
                    $outstanding_debt = $v->outstanding_debt;
                    $sum_payment_amount = 0;
                    for ($i=0; $i < $diff; $i++) {

                        if(!is_null($v->prepare_order_number)){
                            $payment_amount = DB::table('ptom_payment_match_invoices')
                            ->where('prepare_order_number',$v->prepare_order_number)
                            ->where('credit_group_code',$v->credit_group_code)
                            ->whereDate('creation_date',$date->addDays(1)->format('Y-m-d'))
                            ->where('match_flag','Y')
                            ->whereNull('deleted_at')->sum('payment_amount');
                        }else{
                            $payment_amount = 0;
                        }

                        $outstanding_debt -= $payment_amount;

                        $sum_payment_amount += $payment_amount;

                        $penalty_total += (($outstanding_debt * $amountPenaltyRate) / 100) / $daysInYear;

                    }
                    // if (!empty($checkReleaseCredit->where('credit_group_code', $v->credit_group_code)->where('amount', $v->outstanding_debt))) {

                    if ($releaseCredit->attribute1 == @$order->order_header_id) {

                        $no = ((($v->customer_type_id == 30 || $v->customer_type_id == 40) && $v->product_type_code == 10) ? $v->consignment_no : $v->pick_release_no);
                        $data['Outstanding'][] = [
                            'no'=>$no.'_'.$v->credit_group_code,
                            'pick_release_no'=>$no,
                            'credit_group_code'=>$v->credit_group_code,
                            'description'=>(($v->credit_group_code == 0) ? 'เงินสด' : 'เงินเชื่อกลุ่ม '.$v->credit_group_code),
                            'amount'=>$v->outstanding_debt,
                            'auto_check'=>($v->due_date <= $delivery_date) ? true : false,
                            'due_days'=>$v->due_days,
                            'date_th'=>dateFormatThai($v->due_date),
                            'due_date'=>dateFormatThai($v->due_date),
                            'penalty_percen'=>$amountPenaltyRate,
                            'penalty_total'=>(!is_null($v->pick_release_no) ||!is_null($v->consignment_no)) ? number_format((float)(($penalty_total < 0) ? 0 : $penalty_total), 2, '.', '') : 0,
                            'daysInYear'=>$daysInYear,
                            'improveFines'=>$improveFines,
                            'improveAmount'=> !is_null($improve) ? $improve->total_fine : 0,
                            'flag'=>'Y',
                            'payment_amount'=>$sum_payment_amount
                        ];
                    }else{

                        // if($releaseCredit->payment_flag != 'Y'){
                        //     $data['Outstanding'][] = [
                        //         'no'=>$v->pick_release_no.'_'.$v->credit_group_code,
                        //         'pick_release_no'=>$v->pick_release_no,
                        //         'credit_group_code'=>$v->credit_group_code,
                        //         'description'=>'เงินเชื่อกลุ่ม '.$v->credit_group_code,
                        //         'amount'=>$v->outstanding_debt,
                        //         'due_days'=>$v->due_days,
                        //         'date_th'=>dateFormatThai($v->pick_release_approve_date),
                        //         'due_date'=>dateFormatThai($v->due_date),
                        //         'penalty_percen'=>$amountPenaltyRate,
                        //         'penalty_total'=>number_format((float)$penalty_total, 2, '.', ''),
                        //         'daysInYear'=>$daysInYear,
                        //         'improveFines'=>$improveFines,
                        //         'flag'=> 'Y'
                        //     ];
                        // }else{
                            $no = ((($v->customer_type_id == 30 || $v->customer_type_id == 40) && $v->product_type_code == 10) ? $v->consignment_no : $v->pick_release_no);
                            $data['Outstanding'][] = [
                                'no'=>$no.'_'.$v->credit_group_code,
                                'pick_release_no'=>$no,
                                'credit_group_code'=>$v->credit_group_code,
                                'description'=>(($v->credit_group_code == 0) ? 'เงินสด' : 'เงินเชื่อกลุ่ม '.$v->credit_group_code),
                                'amount'=>$v->outstanding_debt,
                                'auto_check'=>false,
                                'due_days'=>$v->due_days,
                                'date_th'=>dateFormatThai($v->due_date),
                                'due_date'=>dateFormatThai($v->due_date),
                                'penalty_percen'=>$amountPenaltyRate,
                                'penalty_total'=>(!is_null($v->pick_release_no) || !is_null($v->consignment_no))  ? number_format((float)(($penalty_total < 0) ? 0 : $penalty_total), 2, '.', '') : 0,
                                'daysInYear'=>$daysInYear,
                                'improveFines'=>$improveFines,
                                'improveAmount'=> !is_null($improve) ? $improve->total_fine : 0,
                                'flag'=> 'M',
                                'payment_amount'=>$sum_payment_amount
                            ];
                        // }
                    }

                }else{

                    // // ค่าปรับ
                    $date = Carbon::parse($v->due_date);
                    $now = Carbon::parse(now());

                    if($date >= $now){
                        $diff = 0;
                    }else{
                        $diff = $date->diffInDays($now);
                    }

                    $penalty_total = 0;
                    $outstanding_debt = $v->outstanding_debt;
                    $sum_payment_amount = 0;

                    for ($i=0; $i < $diff; $i++) {

                        if(!is_null($v->prepare_order_number)){
                            $payment_amount = DB::table('ptom_payment_match_invoices')
                            ->where('prepare_order_number',$v->prepare_order_number)
                            ->where('credit_group_code',$v->credit_group_code)
                            ->whereDate('creation_date',$date->addDays(1)->format('Y-m-d'))
                            ->where('match_flag','Y')
                            ->whereNull('deleted_at')->sum('payment_amount');
                        }else{
                            $payment_amount = 0;
                        }

                        $outstanding_debt -= $payment_amount;
                        $sum_payment_amount += $payment_amount;

                        $penalty_total += (($outstanding_debt * $amountPenaltyRate) / 100) / $daysInYear;

                    }

                    $no = ((($v->customer_type_id == 30 || $v->customer_type_id == 40) && $v->product_type_code == 10) ? $v->consignment_no : $v->pick_release_no);
                    $data['Outstanding'][] = [
                        'no'=>$no.'_'.$v->credit_group_code,
                        'pick_release_no'=>$no,
                        'credit_group_code'=>$v->credit_group_code,
                        'description'=>(($v->credit_group_code == 0) ? 'เงินสด' : 'เงินเชื่อกลุ่ม '.$v->credit_group_code),
                        'amount'=>$v->outstanding_debt,
                        'auto_check'=>($v->due_date <= $delivery_date) ? true : false,
                        'due_days'=>$v->due_days,
                        'date_th'=>dateFormatThai($v->due_date),
                        'due_date'=>dateFormatThai($v->due_date),
                        'penalty_percen'=>$amountPenaltyRate,
                        // 'penalty_day'=>$penalty_day,
                        'penalty_total'=>(!is_null($v->pick_release_no) || !is_null($v->consignment_no))  ? number_format((float)(($penalty_total < 0) ? 0 : $penalty_total), 2, '.', '') : 0,
                        'daysInYear'=>$daysInYear,
                        'improveFines'=>$improveFines,
                        'improveAmount'=> !is_null($improve) ? $improve->total_fine : 0,
                        'flag'=>'N',
                        'payment_amount'=>$sum_payment_amount
                    ];
                }
            }

        }


        return $data['Outstanding'];
    }

    public static function insertConsiggment($orderHeaderID)
    {

        $orderHeaderQuery   = OrderHeaders::where('order_header_id', $orderHeaderID)->whereNull('deleted_at')->first();
        $orderLinesQuery    = OrderLines::where('order_header_id', $orderHeaderID)->whereNull('deleted_at')->get();

        $getTag             = Customers::join('ptom_delivery_period_v', 'ptom_customers.customer_number', '=', 'ptom_delivery_period_v.meaning')
                                        ->where('ptom_customers.customer_id', $orderHeaderQuery->customer_id)
                                        ->pluck('tag')
                                        ->first();

        $tag                = !empty($getTag) ? $getTag : 0;

        if ($tag > 0) {
            // $consignmentDate    = date("Y-m-d H:i:s", strtotime("+".$tag." Day", strtotime($orderHeaderQuery->delivery_date)));
            $consignmentDate = Carbon::createFromFormat('Y-m-d H:i:s', $orderHeaderQuery->delivery_date)->addDays($tag);
        }else{
            $consignmentDate = Carbon::createFromFormat('Y-m-d H:i:s', $orderHeaderQuery->delivery_date);
            // $consignmentDate    = $orderHeaderQuery->delivery_date;
        }
        // $consignmentDate = Carbon::createFromFormat('Y-m-d H:i:s', $orderHeaderQuery->delivery_date);
        $loopcheck = true;
        do {
            if($consignmentDate->format('D') == 'Sat' || $consignmentDate->format('D') == "Sun") {
                $consignmentDate->addDay(1);
                continue;
            }
            
            $checkDateHoliday = DB::table('PTPP_HOLIDAY_V')->whereRaw("TRUNC(hol_date) = TO_DATE('{$consignmentDate->format('m/d/Y')}', 'MM/DD/YYYY')")->first();
            if($checkDateHoliday)  {
                $consignmentDate->addDay(1);
                continue;
            }
            $loopcheck = false;
            $logs[] = "stop loop";
        }while($loopcheck);

        $consignmentDate = $consignmentDate->format('Y-m-d H:i:s');

        $dayOfWeek = date('w', strtotime($consignmentDate));
        if($dayOfWeek == 6){
            $consignmentDate    = date("Y-m-d H:i:s", strtotime("+2 Day", strtotime($consignmentDate)));
        }else if($dayOfWeek == 0){
            $consignmentDate    = date("Y-m-d H:i:s", strtotime("+1 Day", strtotime($consignmentDate)));
        }

        $customerID         = $orderHeaderQuery->customer_id;
        $customersQuery     = Customers::where('customer_id', $customerID)->first();
        $customersVat       = $customersQuery->vat_code;

        if ($customersVat != '') {
            $taxCodeQuery   = TaxCode::select('percentage_rate')->where('tax_rate_code', $customersVat)->first();
            $percentageRate = $taxCodeQuery->percentage_rate;
        }else{
            $percentageRate = 7;
        }

        // $vatAmount          = str_replace(',', '',$orderHeaderQuery->grand_total) * $percentageRate / 107;
        $totalIncludeVat    = str_replace(',', '',$orderHeaderQuery->grand_total);
        $commissionAmount   = 0;

        // $vatAmount          = number_format((float)$vatAmount, 2, '.', '');
        $totalIncludeVat    = number_format((float)$totalIncludeVat, 2, '.', '');

        $totalAmountForcalVat   = 0;
        $sumConsignmentAmount = 0;
        if (!empty($orderLinesQuery)) {
            foreach ($orderLinesQuery as $key => $value) {
                $sumConsignmentAmount = $sumConsignmentAmount + $value->order_quantity;
                $itemQuery      = SequenceEcom::where('item_code', $value->item_code)->first();
                $itemID         = $itemQuery->item_id;

                $priceListQuery = PriceListLine::join('ptom_price_list_head_v', 'ptom_price_list_line_v.list_header_id', '=', 'ptom_price_list_head_v.list_header_id')
                                            ->select('operand')
                                            ->where('item_id', $itemID)
                                            ->where(function($query){
                                                $query->where('name', 'ราคาขายส่ง')
                                                    ->orWhere('name', 'ราคาโรงงาน');
                                            })->orderBy('name', 'DESC')->get();

                $priceList1 = !empty($priceListQuery[0]->operand) ? $priceListQuery[0]->operand : 0;
                $priceList2 = !empty($priceListQuery[1]->operand) ? $priceListQuery[1]->operand : 0;

                $commissionAmount       = ($commissionAmount + (($value->order_quantity * ($priceList2 - $priceList1) * 95) * 0.01));

                $commissionAmount       = number_format((float)$commissionAmount, 2, '.', '');

                // Cal vat
                $getOperand = PriceListLine::join('ptom_price_list_head_v', 'ptom_price_list_line_v.list_header_id', '=', 'ptom_price_list_head_v.list_header_id')
                ->select('ptom_price_list_line_v.operand')
                ->where('ptom_price_list_line_v.item_id', $itemID)
                ->where('ptom_price_list_head_v.name', 'ราคาขายปลีก')
                ->whereRaw("nvl(ptom_price_list_line_v.start_date_active,sysdate+1) < sysdate")
                ->whereRaw("nvl(ptom_price_list_line_v.end_date_active,sysdate+1) > sysdate")
                ->first();

                $vatOperand             = !empty($getOperand->operand) ? $getOperand->operand : 0;
                $vatActual              = floatval(str_replace(',', '',$value->order_quantity)) * $vatOperand;
                $totalAmountForcalVat   = $totalAmountForcalVat + $vatActual;
            }

            $vatAmount  = $totalAmountForcalVat * $percentageRate / 107;
            $vatAmount  = number_format((float)$vatAmount, 2, '.', '');
        }

        $newConsingmentNo = GenerateNumberRepo::generateConsignmentNo('OMP0038_F_NUM_DOM');

        $insert = [
            'consignment_no'            => $newConsingmentNo,
            'consignment_date'          => $consignmentDate,
            'customer_id'               => $customerID,
            'customer_number'           => $customersQuery->customer_number,
            'order_type_id'             => $orderHeaderQuery->order_type_id,
            'pick_release_num'          => $orderHeaderQuery->pick_release_no,
            'pick_release_date'         => date("Y-m-d H:i:s"),
            'order_header_id'           => $orderHeaderQuery->order_header_id,
            'consignment_status'        => 'Draft',
            'total_unit_price_amount'   => $orderHeaderQuery->grand_total,
            'total_consignment_amount'  => $sumConsignmentAmount,
            'total_amount'              => $orderHeaderQuery->grand_total,
            'vat_amount'                => str_replace(',', '',$vatAmount),
            'total_include_vat'         => str_replace(',', '',$totalIncludeVat),
            'commission_amount'         => $commissionAmount > 0 ? str_replace(',', '',$commissionAmount) : 0,
            'program_code'              => 'OMP0038',
            'created_by'                => optional(auth()->user())->user_id,
            'created_by_id'             => optional(auth()->user())->user_id,
            'created_at'                => date('Y-m-d H:i:s'),
            'creation_date'             => date('Y-m-d H:i:s'),
            'last_updated_by'           => optional(auth()->user())->user_id,
            'last_update_date'          => date('Y-m-d H:i:s')
        ];

        // echo '<pre>';
        // print_r($insert);
        // echo '<pre>';
        // exit();

        ConsignmentHeader::insert($insert);


        //  INSERT CONSIGNMENT LINES

        if (!empty($orderLinesQuery)) {
            $consignmentLastQuery = ConsignmentHeader::select('consignment_header_id', 'order_type_id')->orderBy('consignment_header_id', 'desc')->first();

            foreach ($orderLinesQuery as $key => $valueLine) {

                $checkActual    = $valueLine->order_quantity;

                if ($checkActual > 0) {
                    $orderLinesQuerySub = OrderLines::where('order_line_id', $valueLine->order_line_id)->first();

                    // Previous Quantity
                    $previous = !empty($valueLine->order_quantity) ? $valueLine->order_quantity : 0;

                    // Remainign Quantity
                    $remaining  = 0;

                    // Actual Quantity
                    $actual           = !empty($valueLine->order_quantity) ? $valueLine->order_quantity : 0;

                    // if ($request->consignment_status == 'Confirm') {
                    //     $resultRemaining = (float)$remaining - (float)$actual;
                    // }else{
                    //     $resultRemaining = (float)$remaining;
                    // }

                    $lineCommisAmount = 0.00;

                    $itemQuery      = SequenceEcom::where('item_code', $valueLine->item_code)->first();
                    $itemID         = $itemQuery->item_id;

                    $priceListQuery = PriceListLine::join('ptom_price_list_head_v', 'ptom_price_list_line_v.list_header_id', '=', 'ptom_price_list_head_v.list_header_id')
                                                ->select('operand')
                                                ->where('item_id', $itemID)
                                                ->where(function($query){
                                                    $query->where('name', 'ราคาขายส่ง')
                                                        ->orWhere('name', 'ราคาโรงงาน');
                                                })->orderBy('name', 'DESC')->get();

                    $priceList1 = !empty($priceListQuery[0]->operand) ? $priceListQuery[0]->operand : 0;
                    $priceList2 = !empty($priceListQuery[1]->operand) ? $priceListQuery[1]->operand : 0;

                    $lineCommisAmount       = (($previous * ($priceList2 - $priceList1) * 95) * 0.01);

                    $lineCommisAmount       = number_format((float)$lineCommisAmount, 2, '.', '');

                    $transactionTaxRate = DB::table('ptom_transaction_types_v')->select('tax_rate')->where('order_type_id', $consignmentLastQuery->order_type_id)->pluck('tax_rate')->first();
                    $transactionTaxRate = !empty($transactionTaxRate) ? $transactionTaxRate : 0;
                    $lineTaxAmount      = (($actual * $orderLinesQuerySub->attribute1) * $transactionTaxRate / (100 + $transactionTaxRate));


                    $insertLine = [
                        'consignment_header_id'     => !empty($consignmentLastQuery->consignment_header_id) ? $consignmentLastQuery->consignment_header_id : 0,
                        'order_header_id'           => $orderHeaderQuery->order_header_id,
                        'order_line_id'             => $orderLinesQuerySub->order_line_id,
                        'item_id'                   => $orderLinesQuerySub->item_id,
                        'item_code'                 => $orderLinesQuerySub->item_code,
                        'item_description'          => $orderLinesQuerySub->item_description,
                        'quantity'                  => !empty($orderLinesQuerySub->approve_quantity) ? $orderLinesQuerySub->approve_quantity : 0,
                        'previous_quantity'         => $previous,
                        'remaining_quantity'        => $remaining,
                        'actual_quantity'           => $actual,
                        'line_commis_amount'        => $lineCommisAmount > 0 ? str_replace(',', '',$lineCommisAmount) : 0,
                        'attribute1'                => 'CGK',
                        'attribute2'                => $orderLinesQuerySub->promo_flag,
                        'attribute3'                => $orderLinesQuerySub->attribute1,
                        'line_tax_amount'           => $lineTaxAmount,
                        'program_code'              => 'OMP0038',
                        'created_by'                => optional(auth()->user())->user_id,
                        'created_by_id'             => optional(auth()->user())->user_id,
                        'created_at'                => date('Y-m-d H:i:s'),
                        'creation_date'             => date('Y-m-d H:i:s'),
                        'last_updated_by'           => optional(auth()->user())->user_id,
                        'last_update_date'          => date('Y-m-d H:i:s')
                    ];

                    // echo '<pre>';
                    // print_r($insertLine);
                    // echo '<pre>';

                    ConsignmentLines::insert($insertLine);
                }

            }
        }


    }

    public static function calculatePao($orderHeaderID)
    {
        $sumPaoLineAmount = 0;
        $paoLineAmount = 0;

        $orderHeaderData = OrderHeaders::leftJoin('ptom_customers', 'ptom_customers.customer_id', '=', 'ptom_order_headers.customer_id')
        ->where('ptom_order_headers.order_header_id', $orderHeaderID)
        ->where('ptom_order_headers.product_type_code', '10')
        ->select([
            'ptom_order_headers.*',
            'ptom_customers.province_code',
            'ptom_customers.customer_type_id'
        ])
        ->first();

        if (!empty($orderHeaderData)) {
            // $orderLinesData = OrderLines::where('order_header_id', $orderHeaderID)
            // ->where(function($query){
            //     $query->where('promo_flag', '!=', 'Y');
            //     $query->orWhere('promo_flag', '=', NULL);
            // })->get();
            $orderLinesData = OrderLines::where('order_header_id', $orderHeaderID)->get();

            if(!$orderLinesData->isEmpty()){
                foreach ($orderLinesData as $key => $value) {
                    $paoLineAmount = 0;
                    if($orderHeaderData->province_code == 10){
                        $paoLineAmount = 0;
                    }else if ($orderHeaderData->province_code != 10 && $orderHeaderData->customer_type_id == 20) {
                        $paoLineAmount = 0;
                    }else if($value->promo_flag == 'Y'){
                        $paoLineAmount = 0;
                    }else{
                        $tag = DB::table('ptom_all_tax_rate_v')->select('tag')->where('enabled_flag', 'Y')->whereRaw("nvl(start_date_active,sysdate+1) < sysdate")->whereRaw("nvl(end_date_active,sysdate+1) > sysdate")->pluck('tag')->first();
                        $paoLineAmount = $value->approve_quantity * $tag;
                    }

                    $sumPaoLineAmount = $sumPaoLineAmount + $paoLineAmount;

                    $lineUpdate = [
                        'pao_line_amount'   => $paoLineAmount,
                        'last_updated_by'   => optional(auth()->user())->user_id,
                        'last_update_date'  => date('Y-m-d H:i:s')
                    ];

                    OrderLines::where('order_line_id', $value->order_line_id)->update($lineUpdate);
                }
            }

            $orderUpdate = [
                'pao_amount'        => number_format($sumPaoLineAmount,2, '.', ''),
                'last_updated_by'   => optional(auth()->user())->user_id,
                'last_update_date'  => date('Y-m-d H:i:s')
            ];

            OrderHeaders::where('order_header_id', $orderHeaderID)->update($orderUpdate);
        }
    }

    public static function insertPaoPercentINV($orderHeaderID)
    {
        $orderHeaderData = OrderHeaders::where('order_header_id', $orderHeaderID)->whereNull('deleted_at')->first();
        $paoPercent = DB::table('ptom_pao_percent')->where('customer_id', $orderHeaderData->customer_id)->whereNull('deleted_at')->get();

        if (count($paoPercent) > 0) {
            foreach ($paoPercent as $key => $value) {

                $taxPaoPercent = $value->tax_pao_percent;
                $lineApproveQuantity = OrderLines::where('order_header_id', $orderHeaderID)->whereNull('deleted_at')->sum('approve_quantity');

                $taxPerQty = ( $taxPaoPercent / 100 ) * $lineApproveQuantity;

                $taxPerQty = GenerateNumberRepo::convertTaxToRound($taxPerQty);

                $dataInsert = [
                    'order_header_id'           => $orderHeaderID,
                    'pick_release_no'           => $orderHeaderData->pick_release_no,
                    'pick_release_approve_date' => $orderHeaderData->pick_release_approve_date,
                    'pao_percent_id'            => $value->pao_percent_id,
                    'province_code'             => $value->province_code,
                    'province_name'             => $value->province_name,
                    'tax_pao_percent'           => $value->tax_pao_percent,
                    'tax_per_qty'               => $taxPerQty,
                    'tax_per_amount'            => '',
                    'program_code'              => $orderHeaderData->program_code,
                    'created_by'                => optional(auth()->user())->user_id,
                    'created_by_id'             => optional(auth()->user())->user_id,
                    'created_at'                => date('Y-m-d H:i:s'),
                    'creation_date'             => date('Y-m-d H:i:s'),
                    'last_updated_by'           => optional(auth()->user())->user_id,
                    'last_update_date'          => date('Y-m-d H:i:s')
                ];

                DB::table('ptom_pao_percent_inv')->insert($dataInsert);
            }
        }
    }
}
