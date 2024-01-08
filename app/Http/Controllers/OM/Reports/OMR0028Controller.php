<?php

namespace App\Http\Controllers\OM\Reports;

use App\Http\Controllers\Controller;
use App\Models\OM\TranspotReportModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OMR0028Controller extends Controller
{
    public function export($programCode, $request)
    {
        $customer_id_start = $request->get('customer_id_start');
        $customer_id_end = $request->get('customer_id_end');
        $start_dt = ($request->get('month_year') == "Invalid date" || $request->get('month_year') == "") ? "01/" . date("m") . "/" . (date("Y") + 543) . " 00:00:00" : $request->get('month_year');
        $end_dt = $request->get('month_year');
        $remark = ""; //$request->get('remark');
        $note_list = $request->get('note_list');
        $cloneDate = Carbon::createFromFormat('d/m/Y H:i:s', $start_dt);
        $getRMA = (new OMR0060Controller)->getRMA(['start'=> $cloneDate->clone()->startOfMonth()->format('Y-m-d'), 'end' => $cloneDate->clone()->endOfMonth()->format('Y-m-d')]);
        $raw_dt_arr = explode("/", $start_dt);
        $set_new_dt = $raw_dt_arr[1] . '/' . $raw_dt_arr[2];
        $spl_sp_dt = explode(" ", $set_new_dt);

        $start_date = $spl_sp_dt[0];
        $end_date = $spl_sp_dt[0];

        $carbon = Carbon::createFromFormat('d/m/Y', '01/'.$end_date);
        $carbonY = $carbon->format('Y');
        $carbonM = $carbon->format('m');
        // return $start_date;
        $sql = "SELECT
            ITEM_CODE,
            ITEM_DESCRIPTION
        FROM
            OAOM.PTOM_SEQUENCE_ECOMS
        WHERE
            SALE_TYPE_CODE = 'DOMESTIC'
            AND SCREEN_NUMBER <> '0'
            AND PRODUCT_TYPE_CODE ='10'
            AND TO_DATE('" . $start_date . "', 'MM/YYYY') >= TRUNC(START_DATE,'MM')
            AND (TO_DATE('" . $start_date . "', 'MM/YYYY') <= LAST_DAY(END_DATE) OR END_DATE IS NULL)
        ORDER BY
            PRODUCT_TYPE_CODE ,
            SCREEN_NUMBER";

        $items_obj = DB::select(DB::raw($sql));
        $taxAdjust = DB::table('ptom_ar_interfaces')
        ->selectRaw('oaom_tax_adjust tax, item_code, customer_number, invoice_number')
        ->where('interface_type', 'Invoice')
        ->where('interface_status', 'C')
        ->whereRaw("group_id not in (SELECT group_id FROM ptom_ar_interfaces WHERE interface_status = 'E' GROUP BY GROUP_ID)")
        ->whereRaw("trunc(invoice_date) between to_date('{$carbon->startOfMonth()->format('Y-m-d')}', 'yyyy-mm-dd') and to_date('{$carbon->endOfMonth()->format('Y-m-d')}', 'yyyy-mm-dd')")
        // ->groupBy(['item_code', 'customer_number'])
        ->get();
        // $adjust = collect(DB::select("
        //     select
        //         item_id,
        //         item_code,
        //         segment9,
        //         segment10,
        //         sum(entered_dr) as dr,
        //         sum(accounted_cr) as cr
        //     from
        //         ptom_gl_interfaces gl,
        //         ptom_sequence_ecoms item
        //     where
        //         segment9 = main_account_code
        //         and segment10 = sub_account_code
        //         and currency_code = 'THB'
        //         and trunc(accounting_date) between to_date('{$carbon->startOfMonth()->format('Y-m-d')}', 'yyyy-mm-dd') and to_date('{$carbon->endOfMonth()->format('Y-m-d')}', 'yyyy-mm-dd')
        //         and segment9 = '411100'
        //         and gl.program_code = 'OMP0043'
        //     group by
        //         item_id,
        //         item_code,
        //         segment9,
        //         segment10
        // "));

        // dd($adjust);

        $items_list = json_decode(json_encode($items_obj), true);
        $result_data = collect($this->sql($start_date, $end_date, $customer_id_start, $customer_id_end, $remark));
        $result_data_arr = collect($result_data)->groupBy('customer_id');
        $total_item_description = 'รวมทั้งสิ้น';
        $total_consignment_quantity = 0;
        $total_consignment_amount = 0;
        $total_exclued_vat = 0;
        $total_vat = 0;
        $total_base_vat = 0;
        $total_tax_amount = 0;
        $total_retail_amount = 0;
        $total_operand = 0;
        $result_arr = [];

        $max_line = 20;
        $page = 0;
        $page_plus = 1;

        $customer_ids = collect($result_data)->pluck('customer_id')->filter()->unique()->values();
        $customers = DB::table('ptom_customers')
        ->whereIn('customer_id', $customer_ids)
        ->get();

        // dd($result_data , $result_data_arr, $customers, $taxAdjust, $items_list);

        foreach($result_data_arr as $customer_id => $items){

            $customer = $customers
            ->where('customer_id', $customer_id)
            ->first();

            foreach ($items_list as $key => $value) {

                $tax = $taxAdjust
                ->where('customer_number', $customer->customer_number)
                ->where('item_code', $value['item_code'])
                ->sum('tax');

                $group = $items->where('item_code', $value['item_code']);

                $data = [];
                $data['item_code'] = $value['item_code'];
                $data['item_description'] = $value['item_description'];
                $data['customer_name'] = $customer->customer_name;
                if($group->count() > 0){
                    $data['consignment_quantity'] = $group->sum('consignment_quantity');
                    $data['consignment_amount'] = $group->sum('consignment_amount');
                    $data['exclued_vat'] = $group->sum('exclued_vat');
                    $data['vat'] = $group->sum('vat');
                    $data['retail_amount'] = $group->sum('retail_amount');
                    $tax_amount = count($taxAdjust->whereNull('tax')->where('customer_number', $customer->customer_number)) == 0 ? ($tax ?: $group->sum('tax_amount_round')) : $group->sum('tax_amount_round') ;
                    // $tax_amount = floor($tax_amount * 100) / 100; 
                    $data['tax_amount'] = $tax_amount;
                    $data['base_vat'] = $data['retail_amount'] - $data['tax_amount'];
                    $data['operand'] = $group->sum('operand');
                }

                $result_arr[$page][$key] = $data;
            }
            $total['customer_name'] = $customer->customer_name;
            $total['item_code'] = 'TOTAL';
            $total['item_description'] = 'รวม';
            $total['consignment_quantity'] = $items->sum('consignment_quantity');
            $total['consignment_amount'] = $items->sum('consignment_amount');
            $total['exclued_vat'] = $items->sum('exclued_vat');
            $total['vat'] = $items->sum('vat');
            $total['retail_amount'] = $items->sum('retail_amount');
            $tax_headers_sum = $items->groupBy('consignment_no')->sum(function($i) {
                return $i->first()->header_tax;
            });
            $tax_amount2 = count($taxAdjust->whereNull('tax')->where('customer_number', $customer->customer_number)) == 0 ? ($taxAdjust
                ->where('customer_number', $customer->customer_number)
                ->sum('tax') ?:$tax_headers_sum) :$tax_headers_sum;
            // $tax_amount2 = floor($tax_amount2 * 100) / 100;
            $total['tax_amount'] = $tax_amount2;
            $total['base_vat'] = $total['retail_amount'] - $total['tax_amount'];
            $total['operand'] = $items->sum('operand');

            $result_arr[$page][$key+1] = $total;
            $page++;
        }

        $j = 0;
        $len = count($result_data_arr);
        $count = count($items_list);
        $start_dt = date('Y-d-m', strtotime($start_dt));
        $_year = explode(" ", $raw_dt_arr[2]);
        $my = $_year[0] + 543;
        $dt_now = Carbon::parse()->addYear(543)->format('d/m/Y');
        $count_arr = count($result_arr);
        $fileName = date('Ymdhms');
        $pg_code = $request->input('program_code');

        // dd($result_arr);

        $contentHtml = view('om.reports.omr0028.main_page', compact('result_arr', 'count_arr', 'my', 'dt_now', 'pg_code', 'start_dt', 'note_list', 'getRMA'))->render();
        return \PDF::loadHtml($contentHtml)
            ->setPaper('a4', 'landscape')
            ->stream($programCode . '-' . $fileName . '.pdf');

        $_year = explode(" ", $raw_dt_arr[2]);
        $my = $_year[0] + 543;
        $dt_now = Carbon::parse()->addYear(543)->format('d/m/Y');
        $count_arr = count($result_arr);
        $fileName = date('Ymdhms');
        $pg_code = $request->input('program_code');
        if ($count_arr > 0) {
          $contentHtml = view('om.reports.omr0028.main_page', compact('result_arr', 'count_arr', 'my', 'dt_now', 'pg_code', 'start_dt'))->render();
          return \PDF::loadHtml($contentHtml)
            ->setPaper('a4', 'landscape')
            ->stream($fileName . '.pdf');
        }
        return 'ไม่พบข้อมูลที่ค้นหาในระบบ';
    }

    private function sql($start_date, $end_date, $customer_id_start, $customer_id_end, $remark)
    {
        $conditions = '';
        if (!empty($customer_id_start)) {
            if (!empty($customer_id_end)) {
                $conditions = "AND A.CUSTOMER_NUMBER BETWEEN '" . $customer_id_start . "' AND '" . $customer_id_end . "'";
            } else {
                $conditions = "AND A.CUSTOMER_NUMBER BETWEEN '" . $customer_id_start . "' AND '" . $customer_id_start . "'";
            }
        } elseif (!empty($customer_id_end)) {
            if (!empty($customer_id_start)) {
                $conditions = "AND A.CUSTOMER_NUMBER BETWEEN '" . $customer_id_start . "' AND '" . $customer_id_end . "'";
            } else {
                $conditions = "AND A.CUSTOMER_NUMBER BETWEEN '" . $customer_id_end . "' AND '" . $customer_id_end . "'";
            }
        }
        $sql_str = "
        SELECT
        A.PRODUCT_TYPE_CODE
        ,A.PRODUCT_TYPE_DESC
        ,A.CUSTOMER_ID
        ,A.CUSTOMER_NAME
        ,A.ITEM_ID
        ,A.ITEM_CODE 
        ,A.consignment_no
        ,A.ITEM_DESCRIPTION
        ,SUM(A.CONSIGNMENT_QUANTITY) CONSIGNMENT_QUANTITY
        ,ROUND(SUM(A.CONSIGNMENT_AMOUNT), 2) CONSIGNMENT_AMOUNT
        ,ROUND((NVL(A.RETAIL_PRICE, 0) * SUM(A.CONSIGNMENT_QUANTITY)) / 107 * 7, 2) VAT
        ,(NVL(A.RETAIL_PRICE, 0) * SUM(A.CONSIGNMENT_QUANTITY)) - ROUND((NVL(A.RETAIL_PRICE, 0) * SUM(A.CONSIGNMENT_QUANTITY)) / 107 * 7, 2) EXCLUED_VAT
        ,(NVL(A.RETAIL_PRICE, 0) * SUM(A.CONSIGNMENT_QUANTITY)) OPERAND
        ,sum(A.base_vat) base_vat
        ,sum(A.tax_amount) tax_amount
        ,sum(A.tax_amount_round) tax_amount_round
        ,A.header_tax
        ,sum(A.retail_amount) retail_amount
        FROM(
        SELECT
        A.PRODUCT_TYPE_CODE
        ,A.PRODUCT_TYPE_DESC
        ,A.CUSTOMER_ID
        ,A.CUSTOMER_NAME
        ,A.ITEM_ID
        ,A.ITEM_CODE
        ,B.ITEM_DESCRIPTION
        ,A.CONSIGNMENT_QUANTITY
        ,A.CONSIGNMENT_AMOUNT
        ,A.HEADER_TAX
        --,C.OPERAND
        ,A.retail_amount OPERAND
        ,A.consignment_no
        ,A.base_vat
        ,ROUND(A.tax_amount, 2) tax_amount_round
        ,A.tax_amount tax_amount
        ,A.retail_amount
        ,A.RETAIL_PRICE
        FROM  OAOM.PTOM_SO_OUTSTANDING_V A
            INNER JOIN OAOM.PTOM_SEQUENCE_ECOMS B ON A.ITEM_CODE = B.ITEM_CODE
            -- INNER JOIN OAOM.PTOM_PRICE_LIST_LINE_V C ON A.ITEM_ID = C.ITEM_ID
             -- INNER JOIN OAOM.PTOM_PRICE_LIST_HEAD_V D ON C.list_header_id = D.list_header_id
            WHERE  B.SCREEN_NUMBER <> 0
            AND B.SALE_TYPE_CODE ='DOMESTIC'
           --  AND D.NAME = 'ราคาขายปลีก'
            AND CASE WHEN A.CONSIGNMENT_DATE IS NULL THEN TO_CHAR(A.PICK_RELEASE_APPROVE_DATE,'MM/YYYY')  ELSE TO_CHAR(A.CONSIGNMENT_DATE,'MM/YYYY') END
            BETWEEN '" . $start_date . "' AND '" . $end_date . "'
            AND B.PRODUCT_TYPE_CODE IN (10)
            AND A.CUSTOMER_TYPE_ID IN('30','40')
            $conditions
            ORDER BY B.SCREEN_NUMBER ASC)A
        GROUP BY
        A.PRODUCT_TYPE_CODE
        ,A.PRODUCT_TYPE_DESC
        ,A.CUSTOMER_ID
        ,A.CUSTOMER_NAME
        ,A.ITEM_ID
        ,A.ITEM_CODE
        ,A.ITEM_DESCRIPTION
        ,A.consignment_no
        ,A.OPERAND
        ,A.base_vat
        ,A.tax_amount
        ,A.retail_amount
        ,A.header_tax
        ,A.RETAIL_PRICE
        ORDER BY A.PRODUCT_TYPE_CODE
            ,A.CUSTOMER_ID
        ";
        return DB::select(DB::raw($sql_str));
    }
}
