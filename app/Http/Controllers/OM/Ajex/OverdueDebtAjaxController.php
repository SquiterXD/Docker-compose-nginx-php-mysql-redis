<?php

namespace App\Http\Controllers\OM\Ajex;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\OM\Customers\Domestics\CreditGroup;
use App\Models\OM\OverdueDebt\OrderHeaders;
use App\Models\OM\OverdueDebt\ProformaInvoiceHeaders;
use App\Models\OM\Customers\Domestics\Customer;
use App\Models\OM\OverdueDebt\PaymentApplyCNDN;
use App\Models\OM\OverdueDebt\PaymentHeaders;
use App\Models\OM\OverdueDebt\PaymentMatchInvoices;
use App\Models\OM\SaleConfirmation\OrderLines;
use Illuminate\Support\Facades\DB;

class OverdueDebtAjaxController extends Controller
{
    protected $perPage = 20;

    public function searchOverdueDebtBAK(Request $request)
    {
        // echo '<pre>';
        // print_r($request->all());
        // echo '</pre>';
        // exit();

        // วันที่ในใบขน
        if(!empty($request->payment_duedate)){
            $dateArr    = explode('/', $request->payment_duedate);
            $day        = $dateArr[0];
            $month      = $dateArr[1];
            $year       = $dateArr[2];
            $newDate    = $month.'/'.$day.'/'.$year.' 00:00:00';

            $duedateTime = strtotime($newDate);
            $duedateDate = date('Y-m-d H:i:s',$duedateTime);
        }else{
            $duedateDate = '';
        }

        $selectField = [
            'ptom_order_headers.*',
            'ptom_customers.customer_number',
            'ptom_customers.customer_name',
            'ptom_proforma_invoice_headers.pi_number',
            'ptom_proforma_invoice_headers.payment_duedate as proforma_payment_duedate',
            'ptom_proforma_invoice_headers.pick_release_no as proforma_pick_release_no',
            'ptom_proforma_invoice_headers.term_id as proforma_term_id',
            'ptom_proforma_invoice_headers.delivery_date as proforma_delivery_date',
        ];

        $orderHeaders = OrderHeaders::select($selectField)
                                    ->join('ptom_customers', 'ptom_order_headers.customer_id', '=', 'ptom_customers.customer_id')
                                    ->leftJoin('ptom_proforma_invoice_headers', 'ptom_proforma_invoice_headers.order_header_id', '=', 'ptom_order_headers.order_header_id')
                                    ->where('ptom_customers.sales_classification_code', 'Export')
                                    ->where('ptom_order_headers.order_status', 'Confirm')
                                    ->where(function($query) use($request, $duedateDate) {
                                        if(!empty($request->customer_number)) {
                                            $query->where('ptom_customers.customer_number', $request->customer_number);
                                        }
                                        if(!empty($request->payment_duedate)) {
                                            $query->where('ptom_order_headers.payment_duedate', $duedateDate);
                                            $query->orWhere('ptom_proforma_invoice_headers.delivery_date', $duedateDate);
                                        }
                                    })
                                    ->whereNull('ptom_order_headers.deleted_at')
                                    ->orderBy('order_number', 'desc')->get();

        // echo '<pre>';
        // print_r($orderHeaders);
        // echo '</pre>';
        // exit();

        $countCal = 0;


        if(!empty($orderHeaders)){
            $orderLists = [];
            foreach ($orderHeaders as $key => $value) {
                // $profomaInvoiceData = ProformaInvoiceHeaders::select('pi_number', 'pick_release_no', 'delivery_date', 'term_id')->where('order_header_id', $value->order_header_id)->where('customer_id', $value->customer_id)->first();

                $orderLine = OrderLines::select('credit_group_code')->where('order_header_id', '=', $value->order_header_id)
                                        // ->where('ptom_order_headers.order_status', '=', 'Confirm')
                                        ->get();

                $groupTag = 0;
                if (!$orderLine->isEmpty()) {
                    foreach ($orderLine as $key => $lines) {
                        $groupCode = CreditGroup::select('tag')->where('lookup_code', '=', $lines->credit_group_code)->first();

                        if (!empty($groupCode)) {
                            $groupTag = $groupCode->tag;
                        }
                    }
                }

                $totalAmount = OrderLines::where('order_header_id', '=', $value->order_header_id)
                                        // ->where('ptom_order_headers.order_status', '=', 'Confirm')
                                        ->sum('total_amount');

                $matchInvoice = PaymentMatchInvoices::where('prepare_order_number', $value->prepare_order_number)->where('match_flag', 'Y')->get();

                $paymentAmount = 0;

                if (!$matchInvoice->isEmpty()) {
                    foreach ($matchInvoice as $key => $invoice) {
                        $invoiceAmount = PaymentApplyCNDN::where('payment_match_id', $invoice->payment_match_id)->whereNull('deleted_at')->sum('invoice_amount');
                        $paymentAmount = ($paymentAmount + $invoice->payment_amount) - $invoiceAmount;
                    }
                }

                // CHECK PAYMENT TYPE CODE
                if ($value->payment_type_code == 10) {
                    $getDate = !empty($value->sa_date) ? $value->sa_date : '';
                    $dayOfDuedate = 15;

                }else if ($value->payment_type_code == 20){
                    $getDate = !empty($value->proforma_delivery_date) ? $value->proforma_delivery_date : '';

                    // echo '<pre>';
                    // print_r($profomaInvoiceData);
                    // echo '</pre>';
                    // exit();

                    if (!empty($value->proforma_term_id)) {
                        $dayOfDuedate   = DB::table('ptom_terms_v')->where('term_id', $value->proforma_term_id)->pluck('due_days')->first();
                        $dayOfDuedate   = !empty($dayOfDuedate) ? $dayOfDuedate : 0;
                    }else{
                        $dayOfDuedate   = 0;
                    }

                }else{
                    $dueDate        = '';
                    $dayOfDuedate   = 0;
                }

                if ($dayOfDuedate > 0 && $getDate != '') {
                    $dueDate = !empty($getDate) ? date("Y-m-d H:i:s", strtotime("+".$dayOfDuedate." day", strtotime($getDate))) : '';
                }else{
                    $dueDate = $getDate;
                }

                // echo 'Type :' . $value->payment_type_code;
                // echo '<br>';
                // echo 'Default date :' . $getDate;
                // echo '<br>';
                // echo 'New date :' . $dueDate;

                // ยอดคงค้าง
                $resultAmount = $totalAmount - $paymentAmount;

                // คำนวณค่าปรับ
                // $dueDate = $value->payment_duedate;

                if ($dueDate != '') {
                    $arrDueDate = explode('-', $dueDate);
                    $dueYear = $arrDueDate[0];

                    if ($dueYear%4 == 0) {
                        $dayOfYear = 366;
                    }else{
                        $dayOfYear = 365;
                    }
                }else{
                    $dayOfYear = 1;
                    $dueYear = 0;
                }

                // หาจำนวนวันที่เกิน
                if ($dueDate != '') {
                    $newDueDate = date('Y-m-d', strtotime($dueDate));
                    $dateNow = date("Y-m-d");

                    // วันเริ่มต้น
                    $arrStart = explode('-', $newDueDate);
                    $startYear = $arrStart[0];
                    $startMonth = $arrStart[1];
                    $startDay = $arrStart[2];

                    // วันปัจจุบัน
                    $arrNow = explode('-', $dateNow);
                    $nowYear = $arrNow[0];
                    $nowMonth = $arrNow[1];
                    $nowDay = $arrNow[2];

                    $makeNow = mktime(0,0,0,$nowMonth,$nowDay,$nowYear);
                    $makeStart = mktime(0,0,0,$startMonth ,$startDay ,$startYear);

                    $dayOverDue = ceil(($makeNow - $makeStart)/86400);


                }else{
                    $dayOverDue = 0;
                }

                // CONDITION CHECK IMPROVE FINE
                if (!empty($value->proforma_pick_release_no)) {

                    $improveFineData    = DB::table('ptom_improve_fines')->where('invoice_number', $value->proforma_pick_release_no)->where('cancel_flag', 'Y')->whereNull('deleted_at')->first();
                    $improveFineStatus  =  !empty($improveFineData) ? 'cancel' : 'calculate';
                }else{
                    $improveFineStatus  = 'calculate';
                    $countCal++;
                }

                // ค่าปรับ
                if ($improveFineStatus == 'calculate') {
                    $getPercent = DB::table('ptom_penalty_rate_export_v')
                                    ->where('start_date_active','<=',date('Y-m-d'))
                                    ->where(function ($query) {
                                        $query->where('end_date_active','>=',date('Y-m-d'));
                                        $query->orWhereNull('end_date_active');
                                    })
                                    ->where('enabled_flag', 'Y')
                                    ->pluck('description')
                                    ->first();

                    $percentCal = !empty($getPercent) ? (float)$getPercent / 100 : 0;


                    $fines = ((($resultAmount * $percentCal) * $dayOverDue) / $dayOfYear);
                }else{
                    $fines = 0;
                }

                if ($resultAmount > 0) {
                    $orderLists[] = [
                        'customer_id'           => $value->customer_id,
                        'customer_number'       => $value->customer_number,
                        'customer_name'         => $value->customer_name,
                        'order_number'          => !empty($value->order_number) ? $value->order_number : '',
                        'prepare_order_number'  => !empty($value->prepare_order_number) ? $value->prepare_order_number : '',
                        'pi_number'             => !empty($value->pi_number) ? $value->pi_number : '',
                        'pick_release_no'       => !empty($value->proforma_pick_release_no) ? $value->proforma_pick_release_no : '',
                        'group_tag'             => $groupTag,
                        'total_amount'          => $resultAmount >= 0 ? $resultAmount : 0,
                        'fines'                 => $fines >= 0 ? $fines : 0.00,
                        'payment_duedate'       => !empty($dueDate) ? dateFormatDMYDefault($dueDate) : ''
                        // 'payment_duedate'       => $value->payment_type_code. ' $$$$ ' .$dueDate. ' # '.$value->payment_duedate. ' ()() '. $value->proforma_delivery_date. ' ++++ '. $dayOfDuedate
                    ];
                }

            }
                $data = [
                    'data'      => $orderLists,
                    'status'    => 'success',
                    'countCal'      => $countCal
                ];
        }else{
            $data = [
                'data'      => 'empty',
                'status'    => 'false'
            ];
        }


        return response()->json(['data' => $data]);
    }

    public function searchOverdueDebt(Request $request)
    {
        // echo '<pre>';
        // print_r($request->all());
        // echo '</pre>';
        // exit();

        // วันที่ในใบขน
        if(!empty($request->payment_duedate)){
            $dateArr    = explode('/', $request->payment_duedate);
            $day        = $dateArr[0];
            $month      = $dateArr[1];
            $year       = $dateArr[2];
            $newDate    = $month.'/'.$day.'/'.$year.' 00:00:00';

            $duedateTime = strtotime($newDate);
            $duedateDate = date('Y-m-d H:i:s',$duedateTime);
        }else{
            $duedateDate = '';
        }

        $outstandingData    = DB::table('ptom_outstanding_debt_exp_v')
                                ->where(function($query) use($request, $duedateDate) {
                                    if(!empty($request->customer_number)) {
                                        $query->where('customer_number', $request->customer_number);
                                    }
                                    if(!empty($request->payment_duedate)) {
                                        $query->where('due_date', $duedateDate);
                                    }
                                })
                                ->orderBy('order_number', 'desc')
                                ->get();

        // echo '<pre>';
        // print_r($outstandingData);
        // echo '</pre>';
        // exit();

        $countCal = 0;


        if(!empty($outstandingData)){
            $orderLists = [];
            foreach ($outstandingData as $key => $value) {

                // คำนวณค่าปรับ
                $dueDate = $value->due_date;

                if ($dueDate != '') {
                    $arrDueDate = explode('-', $dueDate);
                    $dueYear = $arrDueDate[0];

                    if ($dueYear%4 == 0) {
                        $dayOfYear = 366;
                    }else{
                        $dayOfYear = 365;
                    }
                }else{
                    $dayOfYear = 1;
                    $dueYear = 0;
                }

                // หาจำนวนวันที่เกิน
                if ($dueDate != '') {
                    $newDueDate = date('Y-m-d', strtotime($dueDate));
                    $dateNow = date("Y-m-d");

                    // วันเริ่มต้น
                    $arrStart = explode('-', $newDueDate);
                    $startYear = $arrStart[0];
                    $startMonth = $arrStart[1];
                    $startDay = $arrStart[2];

                    // วันปัจจุบัน
                    $arrNow = explode('-', $dateNow);
                    $nowYear = $arrNow[0];
                    $nowMonth = $arrNow[1];
                    $nowDay = $arrNow[2];

                    $makeNow = mktime(0,0,0,$nowMonth,$nowDay,$nowYear);
                    $makeStart = mktime(0,0,0,$startMonth ,$startDay ,$startYear);

                    $dayOverDue = ceil(($makeNow - $makeStart)/86400);


                }else{
                    $dayOverDue = 0;
                }

                // CONDITION CHECK IMPROVE FINE
                if (!empty($value->pick_release_no)) {

                    $improveFineData    = DB::table('ptom_improve_fines')->where('invoice_number', $value->pick_release_no)->where('cancel_flag', 'Y')->whereNull('deleted_at')->first();
                    $improveFineStatus  =  !empty($improveFineData) ? 'cancel' : 'calculate';
                }else{
                    $improveFineStatus  = 'calculate';
                    $countCal++;
                }

                // ค่าปรับ
                if ($improveFineStatus == 'calculate' && $value->payment_type_code != 10) {
                    $getPercent = DB::table('ptom_penalty_rate_export_v')
                                    ->where('start_date_active','<=',date('Y-m-d'))
                                    ->where(function ($query) {
                                        $query->where('end_date_active','>=',date('Y-m-d'));
                                        $query->orWhereNull('end_date_active');
                                    })
                                    ->where('enabled_flag', 'Y')
                                    ->pluck('description')
                                    ->first();

                    $percentCal = !empty($getPercent) ? (float)$getPercent / 100 : 0;

                    $fines = ((($value->outstanding_debt * $percentCal) * $dayOverDue) / $dayOfYear);
                }else{
                    $fines = 0;
                }

                if ($value->outstanding_debt > 0) {
                    $orderLists[] = [
                        'customer_id'           => $value->customer_id,
                        'customer_number'       => $value->customer_number,
                        'customer_name'         => $value->customer_name,
                        'order_number'          => !empty($value->order_number) ? $value->order_number : '',
                        'prepare_order_number'  => !empty($value->sa_number) ? $value->sa_number : '',
                        'pi_number'             => !empty($value->pi_number) ? $value->pi_number : '',
                        'pick_release_no'       => !empty($value->pick_release_no) ? $value->pick_release_no : '',
                        'group_tag'             => $value->due_days,
                        'total_amount'          => $value->outstanding_debt >= 0 ? $value->outstanding_debt : 0,
                        'fines'                 => $fines >= 0 ? $fines : 0.00,
                        'payment_duedate'       => !empty($dueDate) ? dateFormatDMYDefault($dueDate) : ''
                    ];
                }

            }
                $data = [
                    'data'      => $orderLists,
                    'status'    => 'success',
                    'countCal'      => $countCal
                ];
        }else{
            $data = [
                'data'      => 'empty',
                'status'    => 'false'
            ];
        }


        return response()->json(['data' => $data]);
    }

    public function getCustomersName($id)
    {
        $getData = Customer::where('customer_number', $id)->first();
        $data = [];
        if(!empty($getData)){
            $data = [
                'customer_name' => $getData->customer_name,
                'status'        => 'success'
            ];
        }else{
            $data = [
                'customer_name' => '',
                'status'        => 'false'
            ];
        }

        return response()->json(['data' => $data]);

    }
}
