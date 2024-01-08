<?php

namespace App\Http\Controllers\OM\Ajex;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\OM\OrderHeaders;
use App\Models\OM\Api\OrderLines;
use App\Models\OM\Customers;
use App\Models\OM\PeriodV;
use App\Models\OM\OnHandV;
use App\Models\OM\SaleConfirmation\Terms;
use App\Models\OM\PaymentMatchInvoice;
use App\Models\OM\Customers\Domestics\CustomerContractGroups;
use App\Models\OM\Customers\Domestics\CreditGroup;
use App\Repositories\OM\OrderRepo;
use App\Models\OM\OutstandingDebtDomesticV;
use App\Models\OM\Api\OrderCreditGroup;
use App\Models\OM\PenaltyRateDomesticV;
use App\Models\OM\PnHolidayModel;
use App\Models\OM\ReleaseCredit;

class PrepareOrderAjaxController extends Controller
{
    //
    public function runPrepareNumber() {

        $now = Carbon::now();
        $periodV = PeriodV::where('start_period','>=', $now)->first();
        $budgetYear = ($periodV->budget_year + 543) - 2500;

        // $prepareNumber = runPrepareNumber(OrderHeaders::getLastPrepareNumber($budgetYear),$budgetYear);

        // $orderNumber = runOrderNumber(OrderHeaders::getLastOrderNumber());

        $prepareNumber = '';

        $orderNumber = '';

        $data['prepareNumber'] = $prepareNumber;
        $data['orderNumber'] = $orderNumber;
        $data['orderDate'] = dateFormatThai($now);


        return response()->json(['data'=>$data,'status'=>true]);

    }

    public function setDayAmount(Request $request){
        $data['creditGroup'] = CreditGroup::get();
        $data['dayAmount'] = [];
        $data['dayAmountActive'] = '';
        $data['dayAmountUse'] = 0;

        $delivery_date = dateConvertThaiEng($request->date);

        if(is_null($request->order_number)){

            $customer = Customers::byCustomerNumber($request->customer_number);

            $data['dayAmountActive'] = dateFormatThai($delivery_date);
            foreach ($data['creditGroup'] as $key => $v) {
                $day_amount = CustomerContractGroups::where('customer_id',$customer->customer_id)->where('credit_group_code',$v->lookup_code)->first();
                if(!is_null($day_amount)){
                    if(!is_null($delivery_date)){
                        $date_amount = date('Y-m-d', strtotime($delivery_date."+".$day_amount->day_amount." days"));
                    }else{
                        $date_amount = date('Y-m-d', strtotime("+".$day_amount->day_amount." days"));
                    }

                    $amount = 0;
                    $use = false;

                    $data['dayAmount'][] = [
                        'description'=>$v->description,
                        'credit_group_code'=>$v->lookup_code,
                        'amount'=>$amount,
                        'day_amount'=>$day_amount->day_amount,
                        'date_th'=>dateFormatThai($date_amount),
                        'date'=>$date_amount,
                        'use'=>false
                    ];
                }
            }

            if(!is_null($delivery_date)){
                $date_cash_amount = date('Y-m-d', strtotime($delivery_date));
            }else{
                $date_cash_amount = date('Y-m-d');
            }


            $data['dayAmount'][] = [
                'description'=>'เงินสด',
                'credit_group_code'=>0,
                'amount'=>0,
                'day_amount'=>0,
                'date_th'=>dateFormatThai($date_cash_amount),
                'date'=>date('Y-m-d'),
                'use'=>false
            ];
        }else{
            $data['order'] = OrderHeaders::where('order_number',$request->order_number)->orderBy('order_header_id','DESC')->first();
            $customer_id = $data['order']->customer_id;
            foreach ($data['creditGroup'] as $key => $v) {
                $day_amount = CustomerContractGroups::where('customer_id',$customer_id)->where('credit_group_code',$v->lookup_code)->first();
                if(!is_null($day_amount)){
                    if(!is_null($data['order']->pick_release_approve_date)){
                        $date_amount = date('Y-m-d', strtotime($data['order']->pick_release_approve_date."+".$day_amount->day_amount." days"));
                    }elseif(!is_null($delivery_date)){
                        $date_amount = date('Y-m-d', strtotime($delivery_date."+".$day_amount->day_amount." days"));
                    }else{
                        $date_amount = date('Y-m-d', strtotime("+".$day_amount->day_amount." days"));
                    }

                    $orderCredit = OrderCreditGroup::where('order_header_id',$data['order']->order_header_id)->where('credit_group_code',$v->lookup_code)->first();
                    $amount = 0;

                    if(!is_null($orderCredit) && $orderCredit->amount != 0){
                        $use = true;
                        $data['dayAmountUse'] += 1;
                        $amount = $orderCredit->amount;
                        $data['dayAmountActive'] = dateFormatThai($date_amount);
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
            }elseif(!is_null($delivery_date)){
                $date_cash_amount = date('Y-m-d', strtotime($delivery_date));
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
        }





        return response()->json(['data'=>$data,'status'=>true]);
    }

    public function dataByCustomer() {

        $now = Carbon::now();

        $customer_id = request()->id;

        $customer = Customers::byCustomerId($customer_id);

        // $datePeriod = nextDaysOfWeek(compareDaysTH($customer->delivery_date));

        // if(isset(request()->delivery_date) && request()->delivery_date != ''){
        //     $newDate = explode('-',request()->delivery_date);
        //     $datePeriod = ($newDate[2] - 543).'-'.$newDate[1].'-'.$newDate[0];
        // }


        // $data['datePeriod'] = $datePeriod;
        // $data['order_date'] = $now;

        $compareDays = compareDaysTH($customer->delivery_date);
        $allDays = false;
        // echo $compareDays;
        // if($compareDays != 0){
            $status = 0;

            $date = nextDaysOfWeekNotPlus(compareDaysTH($customer->delivery_date));

            do {
                if($compareDays == 0){
                    $compareDays = date('w',strtotime($date));
                    if($compareDays == 0 ||  $compareDays == 6){
                        $date = date('Y-m-d',strtotime($date . "+1 days"));
                        $compareDays = date('w',strtotime($date));
                    }
                }else{
                    if(($compareDays == 6 || $compareDays == 7)){
                        $date = date('Y-m-d',strtotime($date . "+1 days"));
                        $compareDays = date('w',strtotime($date));
                    }else{
                        $status = 1;
                    }
                }

            } while ($status == 0);
        // }else{
        //     $allDays = true;
        // }


        $datePeriod = nextDaysOfWeekNotPlus($compareDays);

        if(isset(request()->date_delivery) && request()->date_delivery != ''){
            $newDate = explode('-',request()->date_delivery);
            $datePeriod = ($newDate[0] - 543).'-'.$newDate[1].'-'.$newDate[2];
        }

        $data['datePeriod'] = $datePeriod;
        $statusPostpone = 0;
        do {
            $holiday = PnHolidayModel::where('hol_date',$datePeriod)->first();
            if(!is_null($holiday)){
                $datePeriod = date('Y-m-d',strtotime($datePeriod . "+1 days"));
            }else{
                if(date('w',strtotime($datePeriod)) == 6 || date('w',strtotime($datePeriod)) == 0){
                    $datePeriod = date('Y-m-d',strtotime($datePeriod . "+1 days"));
                }else{
                    $statusPostpone = 1;
                }
            }
        } while ($statusPostpone == 0);
        // do {
        //     $holiday = PnHolidayModel::where('hol_date',$datePeriod)->first();
        //     if(!is_null($holiday)){
        //         $datePeriod = date('Y-m-d',strtotime($datePeriod . "+1 days"));
        //     }else{
        //         $statusPostpone = 1;
        //     }
        // } while ($statusPostpone == 0);

        // echo $datePeriod;
        $data['period'] = DB::table('ptom_period_v as pvf')
        ->where('start_period','<=', $datePeriod)
        ->where('end_period','>=', $datePeriod)
        ->first();

        // $data['period'] = PeriodV::where('start_period','>=', $datePeriod)->first();

        $data['budgetYear'] = ($data['period']->budget_year + 543);
        $data['periodNo'] = $data['period']->period_no;
        $data['periodLine'] = $data['period']->period_line_id;
        $data['billTo'] = $customer->customer_name;
        $data['paymentId'] = $customer->payment_type_id;

        $data['remainingAmount'] = OrderRepo::sumNotMatch($customer->customer_id);

        $data['terms'] = [];

        if ($customer->payment_type_id == 10) {
            // $data['terms'] = Terms::where('term_id', $payment_term_id)->first();
        }else{
            $customerContractG = CustomerContractGroups::where('customer_id', $customer->customer_id)->orderBy('day_amount', 'asc')->first();
            $data['customerContractG'] = $customerContractG;

            try {
                $data['terms'] = Terms::where('due_days', $customerContractG->day_amount)
                ->where('credit_group_code',$customerContractG->credit_group_code)
                ->whereRaw("lower(sale_type) = '".strtolower($customer->sales_classification_code)."' ")->first();
                if (!isset($data['terms'])) {
                    $data['terms'] = Terms::where('due_days', $customerContractG->day_amount)
                    ->whereRaw("lower(sale_type) = '".strtolower($customer->sales_classification_code)."' ")->first();
                }
            }catch (\Exception $e) {}
        }

        // $data['orderPrepare'] = OrderHeaders::where('customer_id',$customer_id)->whereNotNull('prepare_order_number')->whereNull('deleted_at')->whereNull('deleted_at')->orderBy('order_header_id','DESC')->get();
        // $data['orderNumber'] = OrderHeaders::where('customer_id',$customer_id)->whereNotNull('prepare_order_number')->whereNotNull('order_number')->whereNull('deleted_at')->orderBy('order_header_id','DESC')->get();

        try {
            $data['payment_duedate'] = dateFormatThai(Carbon::now()->addDays($data['terms']->due_days));
        }catch (\Exception $e) {
            $data['payment_duedate'] = dateFormatThai(Carbon::now());
        }


        $data['shipSite'] = OrderRepo::shipSites($customer_id);
        $data['creditLimit'] = OrderRepo::getCustomerSumContractGroups($customer->customer_id,'ccg.credit_amount');
        $data['remainingLimit'] = OrderRepo::getCustomerSumContractGroups($customer->customer_id,'ccg.remaining_amount');
        // $data['contractQuata'] = OrderRepo::getCustomerQuotaHeaders($customer->customer_id,null);
        if($customer->customer_type_id == 20){
            $data['contractQuata'] = OrderRepo::getCustomerQuotaHeadersMT($customer_id,null,$datePeriod);
        }else{
            $data['contractQuata'] = OrderRepo::getCustomerQuotaHeaders($customer_id,null,$datePeriod);
        }

        $data['contractGroups'] = OrderRepo::getCustomerContractGroups($customer_id);


        foreach ($data['contractQuata'] as $key => $cont) {
            foreach ($cont['quota'] as $key_quota => $quota) {
                $latest = OrderRepo::getLatestOrderLine($quota->item_id,$customer->customer_id);
                if ($latest) {
                    $data['latest'][$quota->item_id]['order_date'] = dateFormatThai($latest->order_date);
                    $data['latest'][$quota->item_id]['order_quantity'] = number_format($latest->order_quantity,2);
                }else{
                    $data['latest'][$quota->item_id]['order_date'] = '-';
                    $data['latest'][$quota->item_id]['order_quantity'] = '0.00';
                }
            }
        }

        $data['delivery_date'] = dateFormatThai($datePeriod);
        $data['delivery_date_en'] = $datePeriod;
        // $data['delivery_date'] = dateFormatThai(nextDaysOfWeekNotPlus(compareDaysTH($customer->delivery_date)));

        // $data['delivery_date_en'] = nextDaysOfWeekNotPlus(compareDaysTH($customer->delivery_date));

        // if(isset(request()->date_delivery) && request()->date_delivery != ''){
        //     $data['delivery_date'] = dateFormatThai($datePeriod);
        // }

        // start หนี้ค้าง
        $data['creditGroup'] = CreditGroup::get();


        $data['dayAmount'] = [];
        // day amount
        foreach ($data['creditGroup'] as $key => $v) {
            $day_amount = CustomerContractGroups::where('customer_id',$customer_id)->where('credit_group_code',$v->lookup_code)->first();
            if(!is_null($day_amount)){
                $date_amount = date('Y-m-d', strtotime($datePeriod."+".$day_amount->day_amount." days"));
                $data['dayAmount'][] = [
                    'description'=>$v->description,
                    'credit_group_code'=>$v->lookup_code,
                    'day_amount'=>$day_amount->day_amount,
                    'amount'=>0,
                    'date_th'=>dateFormatThai($date_amount),
                    'date'=>$date_amount,
                    'use'=>false
                ];
            }

        }

        $data['dayAmount'][] = [
            'description'=>'เงินสด',
            'credit_group_code'=>0,
            'amount'=>0,
            'day_amount'=>0,
            'date_th'=>$data['delivery_date'],
            'date'=>nextDaysOfWeek(compareDaysTH($customer->delivery_date)),
            'use'=>false
        ];

        // day amount

        $data['Outstanding'] = [];

        $penaltyRate = PenaltyRateDomesticV::where('enabled_flag','Y')->first();
        if(is_null($penaltyRate)){
            $amountPenaltyRate = 0;
        }else{
            $amountPenaltyRate = $penaltyRate->description;
        }

        $daysInYear = Carbon::parse(date('Y'))->daysInYear;

        $Outstanding = OutstandingDebtDomesticV::where('customer_id',$customer->customer_id)
        ->where('outstanding_debt','>',0)
        // ->where('due_date','<=',$data['period']->end_period)
        ->where('pick_release_status','Confirm')
        ->get();

        foreach ($Outstanding as $key => $v) {
            if(is_null($v->pick_release_approve_date)){
                $date = date('Y-m-d');
            }else{
                $date = $v->pick_release_approve_date;
            }

            // ค่าปรับ
            // $date = Carbon::parse($v->pick_release_approve_date);
            // $now = Carbon::parse(now());

            // if($date >= $now){
            //     $diff = 0;
            // }else{
            //     $diff = $date->diffInDays($now);
            // }

            // $penalty_day = (($v->outstanding_debt * $amountPenaltyRate) / 100) / $daysInYear;
            // $penalty_total = $penalty_day * $diff;

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
            // ค่าปรับ

            $no = ((($v->customer_type_id == 30 || $v->customer_type_id == 40) && $v->product_type_code == 10) ? $v->consignment_no : $v->pick_release_no);

            $releaseCredit = ReleaseCredit::where('invoice_id',$v->order_header_id)->where('customer_id',$customer->customer_id)->where('credit_group_code',$v->credit_group_code)->first();

            if (!is_null($releaseCredit)) {
                $flag = 'M';
            }else{
                $flag = 'N';
            }

            $data['Outstanding'][] = [
                'no'=>$no.'_'.$v->credit_group_code,
                'pick_release_no'=>$no,
                'credit_group_code'=>$v->credit_group_code,
                'description'=>(($v->credit_group_code == 0) ? 'เงินสด' : 'เงินเชื่อกลุ่ม '.$v->credit_group_code),
                'amount'=>$v->outstanding_debt,
                'delivery_date_en'=>$data['delivery_date_en'],
                'auto_check'=>(date("Y-m-d", strtotime($v->due_date)) <= $data['delivery_date_en']) ? true : false,
                'due_days'=>$v->due_days,
                'sum_payment_amount'=>$penalty_total,
                'date_th'=>dateFormatThai($v->due_date),
                'penalty_percen'=>$amountPenaltyRate,
                // 'penalty_day'=>$penalty_day,
                // 'payment_amount'=>$payment_amount,
                'penalty_total'=>(!is_null($v->pick_release_no) || !is_null($v->consignment_no)) ? number_format((float)(($penalty_total < 0) ? 0 : $penalty_total), 2, '.', '') : 0,
                'daysInYear'=>$daysInYear,
                'flag'=>$flag
            ];
        }


        $data['overDue'] = [];
        $paymentMatchInvoice = [];
        foreach ($data['creditGroup'] as $key => $cg) {
            $totalPayment = PaymentMatchInvoice::sumHeaderByCustomer($customer->customer_id,$cg->lookup_code);
            $totalOrder = PaymentMatchInvoice::sumOrderHeaderByCustomer($customer->customer_id,$cg->lookup_code);
            $totalFine = PaymentMatchInvoice::sumOrderFinesByCustomer($customer->customer_id,$cg->lookup_code);
            $amount = $totalOrder - ($totalPayment);
            if ($amount > 0) {
                $data['overDue'][$cg->lookup_code]['description'] = $cg->description;
                $data['overDue'][$cg->lookup_code]['amount'] = $amount + $totalFine;
                $data['overDue'][$cg->lookup_code]['over_due'] = number_format(($totalOrder - $totalPayment),2);
                $data['overDue'][$cg->lookup_code]['fine'] = number_format($totalFine,2);
            }
        }


        // end หนี้ค้าง

        return response()->json(['data'=>$data,'status'=>true]);

    }

    public function dataByItem() {

        $now = Carbon::now();

        $customer_number = request()->customer_number;

        $customer = Customers::byCustomerNumber($customer_number);

        if($customer->customer_type_id == 20){
            $response['contractQuata'] = OrderRepo::getCustomerQuotaHeadersMT($customer->customer_id,null);
        }else{
            $response['contractQuata'] = OrderRepo::getCustomerQuotaHeaders($customer->customer_id,null);
        }

        return response()->json(['data'=>$response,'status'=>true]);

    }

    public function productByOrderType() {

        $now = Carbon::now();

        $customer_number = request()->customer_number;
        $customer = Customers::byCustomerNumber($customer_number);

        $dateDelivery = '';
        if(request()->date_delivery && request()->date_delivery != ''){
            $date_delivery = request()->date_delivery;
            $newDate = explode('-',$date_delivery);
            try {
                $dateDelivery = ($newDate[0] - 543).'-'.$newDate[1].'-'.$newDate[2];
            } catch (\Exception $th) {
                $date_delivery = Carbon::createFromFormat('d/m/Y',request()->date_delivery)->addYears('-543');
                $dateDelivery = $date_delivery->format('Y-m-d');
            }
        }else{

            $compareDays = compareDaysTH($customer->delivery_date);
            $allDays = false;
            // if($compareDays != 0){
                $status = 0;

                $date = nextDaysOfWeekNotPlus(compareDaysTH($customer->delivery_date));

                do {
                    if($compareDays == 0){
                        $compareDays = date('w',strtotime($date));
                        if($compareDays == 0 ||  $compareDays == 6){
                            $date = date('Y-m-d',strtotime($date . "+1 days"));
                            $compareDays = date('w',strtotime($date));
                        }
                    }else{
                        if(($compareDays == 6 || $compareDays == 7)){
                            $date = date('Y-m-d',strtotime($date . "+1 days"));
                            $compareDays = date('w',strtotime($date));
                        }else{
                            $status = 1;
                        }
                    }

                } while ($status == 0);
            // }else{
            //     $allDays = true;
            // }

            $dateDelivery = nextDaysOfWeekNotPlus($compareDays);

            if(isset(request()->date_delivery) && request()->date_delivery != ''){
                $newDate = explode('-',request()->date_delivery);
                $dateDelivery = ($newDate[0] - 543).'-'.$newDate[1].'-'.$newDate[2];
            }

            $statusPostpone = 0;
            do {
                $holiday = PnHolidayModel::where('hol_date',$dateDelivery)->first();
                if(!is_null($holiday)){
                    $dateDelivery = date('Y-m-d',strtotime($dateDelivery . "+1 days"));
                }else{
                    $statusPostpone = 1;
                }
            } while ($statusPostpone == 0);
        }


        if (request()->type == '1065') {
            $response['contractQuata'] = OrderRepo::getProductListTypeCode($customer->customer_id,20);

            foreach ($response['contractQuata'] as $key => $item) {
                $latest = OrderRepo::getLatestOrderLine($item->item_id,$customer->customer_id);
                if ($latest) {
                    $response['latest'][$item->item_id]['order_date'] = dateFormatThai($latest->order_date);
                    $response['latest'][$item->item_id]['order_quantity'] = number_format($latest->order_quantity,2);
                    $response['latest'][$item->item_id]['order_uom'] = $latest->uom_code . ' ' .$latest->uom;
                }else{
                    $response['latest'][$item->item_id]['order_date'] = '-';
                    $response['latest'][$item->item_id]['order_quantity'] = '0.00';
                    $response['latest'][$item->item_id]['order_uom'] = '';
                }

                $inv = DB::table('PTOM_ONHAND_V')->where('ITEM_CODE', $item->item_code)->get();
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
                $item->onhand = $onhandsum;
            }

        }else{

            if($customer->customer_type_id == 20){
                $response['contractQuata'] = OrderRepo::getCustomerQuotaHeadersMT($customer->customer_id,null,$dateDelivery);
            }else{
                $response['contractQuata'] = OrderRepo::getCustomerQuotaHeaders($customer->customer_id,null,$dateDelivery);
            }



            foreach ($response['contractQuata'] as $key => $cont) {
                foreach ($cont['quota'] as $key_quota => $quota) {
                    $latest = OrderRepo::getLatestOrderLine($quota->item_id,$customer->customer_id);
                    if ($latest) {
                        $response['latest'][$quota->item_id]['order_date'] = dateFormatThai($latest->order_date);
                        $response['latest'][$quota->item_id]['order_quantity'] = number_format($latest->order_quantity,2);
                    }else{
                        $response['latest'][$quota->item_id]['order_date'] = '-';
                        $response['latest'][$quota->item_id]['order_quantity'] = '0.00';
                    }
                }
            }
        }

        return response()->json(['data'=>$response,'status'=>true]);

    }
}
