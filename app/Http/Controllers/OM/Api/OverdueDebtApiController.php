<?php

namespace App\Http\Controllers\OM\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\Api\Currency;
use Illuminate\Support\Facades\DB;

class OverdueDebtApiController extends Controller
{
    public function search(Request $request)
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
}
