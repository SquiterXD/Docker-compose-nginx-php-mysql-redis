<?php

namespace App\Http\Controllers\OM\Reports;

use App\Http\Controllers\Controller;
use App\Models\OM\reports\PtomSoOutstandingV;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

ini_set('max_execution_time', '300');
ini_set("pcre.backtrack_limit", "5000000");

class OMR0024Controller extends Controller
{

    public function export($programCode, $request)
    {
        $customer_type_id   = $request['customer_type_id'];
        $approveDate        = $request['approve_date'];
        $program_code       = $request['program_code'];
        $function_name      = $request['function_name'];

        $reportlayout = [
            0       =>  [1, 2, 3, 4, 5],
            10      =>  [1],
            20      =>  [3],
            30      =>  [1, 2],
            40      =>  [1, 2],
            '30,40' =>  [1, 2],
            50      =>  [1],
            60      =>  [5],
            70      =>  [1],
            80      =>  [4],
        ];

        $layouts = $reportlayout[$customer_type_id];
        $openwindow = '<script>';
        foreach ($layouts as $i => $layout) {
            if ($i > 0) {
                $openwindow .= " window.open('/ir/reports/get-param?approve_date=" . urlencode($approveDate) . "&customer_type_id={$customer_type_id}&program_code={$programCode}&function_name={$programCode}&layout={$layout}'); ";
            } else {
                $openwindow .= " window.location.href='/ir/reports/get-param?approve_date=" . urlencode($approveDate) . "&customer_type_id={$customer_type_id}&program_code={$programCode}&function_name={$programCode}&layout={$layout}';";
            }
        }
        $openwindow .= '</script>';
        echo $openwindow;
        exit();
    }

    public function initialQty(){
        $qtyMain = [];
        $qtyMain[0]['submitqty10']      = 0;
        $qtyMain[0]['orderqty10']       = 0;

        $qtyMain[1]['submitamount10']   = 0;
        $qtyMain[1]['orderamount10']    = 0;

        $qtyMain[2]['submitqty20']      = 0;
        $qtyMain[2]['orderqty20']       = 0;

        $qtyMain[3]['submitamount20']   = 0;
        $qtyMain[3]['orderamount20']    = 0;

        $qtyMain[4]['submitamount10submitamount20'] = 0;
        $qtyMain[4]['orderamount10orderamount20']   = 0;
        return $qtyMain;
    }

    public function getColHeaderSpan($column_cnt_pagebreak, $cigarette, $rework){
        $column_header_span = [];

        $cnt_temp = 0;

        $prev_col_cnt = 0;
        $col_header_name = 'บุหรี่';
        $current_sec_cnt = 0;
        for($i = 0; $i < ceil(count($cigarette) + $prev_col_cnt) / $column_cnt_pagebreak ; $i++){
            $column_header_span[$cnt_temp][$col_header_name]['rowspan'] = 1;
            $column_header_span[$cnt_temp][$col_header_name]['colspan'] =  count($cigarette) - $current_sec_cnt >= $column_cnt_pagebreak ? $column_cnt_pagebreak :count($cigarette) - $current_sec_cnt;
            $current_sec_cnt += $column_header_span[$cnt_temp][$col_header_name]['colspan'];
            $cnt_temp = array_reduce($column_header_span[$cnt_temp], function($accum, $items) { $accum += $items['colspan']; return $accum;}, 0) < $column_cnt_pagebreak ? $cnt_temp : $cnt_temp +1;
        }

        $prev_col_cnt = isset($column_header_span[$cnt_temp]) ? array_reduce($column_header_span[$cnt_temp], function($accum, $items) { $accum += $items['colspan']; return $accum;}, 0)  : 0;
        $col_header_name = 'ยาเส้น';
        $current_sec_cnt = 0;

        for($i = 0; $i < (count($rework) + $prev_col_cnt) / $column_cnt_pagebreak ; $i++){

            $column_header_span[$cnt_temp][$col_header_name]['rowspan'] = 1;
            if ($prev_col_cnt > 0 && $i <= 0){
                $column_header_span[$cnt_temp][$col_header_name]['colspan'] =  count($rework) - $current_sec_cnt >= ($column_cnt_pagebreak - $prev_col_cnt) ? ($column_cnt_pagebreak - $prev_col_cnt) :  count($rework);
            }else{
                $column_header_span[$cnt_temp][$col_header_name]['colspan'] =  count($rework) - $current_sec_cnt >= $column_cnt_pagebreak ? $column_cnt_pagebreak :count($rework) - $current_sec_cnt;
            }

            $current_sec_cnt += $column_header_span[$cnt_temp][$col_header_name]['colspan'];
            $cnt_temp = array_reduce($column_header_span[$cnt_temp], function($accum, $items) { $accum += $items['colspan']; return $accum;}, 0) < $column_cnt_pagebreak ? $cnt_temp : $cnt_temp +1;
        }


        $column_header_span[$cnt_temp]['ยอดรวมบุหรี่']['rowspan'] = 2;
        $column_header_span[$cnt_temp]['ยอดรวมบุหรี่']['colspan'] = 1;

        $cnt_temp = array_reduce($column_header_span[$cnt_temp], function($accum, $items) { $accum += $items['colspan']; return $accum;}, 0)  < $column_cnt_pagebreak ? $cnt_temp : $cnt_temp +1;
        $column_header_span[$cnt_temp]['จำนวนเงินบุหรี่']['rowspan'] = 2;
        $column_header_span[$cnt_temp]['จำนวนเงินบุหรี่']['colspan'] = 1;

        $cnt_temp = array_reduce($column_header_span[$cnt_temp], function($accum, $items) { $accum += $items['colspan']; return $accum;}, 0)  < $column_cnt_pagebreak ? $cnt_temp : $cnt_temp +1;
        $column_header_span[$cnt_temp]['ยอดรวมยาเส้น']['rowspan'] = 2;
        $column_header_span[$cnt_temp]['ยอดรวมยาเส้น']['colspan'] = 1;

        $cnt_temp = array_reduce($column_header_span[$cnt_temp], function($accum, $items) { $accum += $items['colspan']; return $accum;}, 0)  < $column_cnt_pagebreak ? $cnt_temp : $cnt_temp +1;
        $column_header_span[$cnt_temp]['จำนวนเงินยาเส้น']['rowspan'] = 2;
        $column_header_span[$cnt_temp]['จำนวนเงินยาเส้น']['colspan'] = 1;

        $cnt_temp = array_reduce($column_header_span[$cnt_temp], function($accum, $items) { $accum += $items['colspan']; return $accum;}, 0)  < $column_cnt_pagebreak ? $cnt_temp : $cnt_temp +1;
        $column_header_span[$cnt_temp]['รวมจำนวนเงินทั้งสิ้น']['rowspan'] = 2;
        $column_header_span[$cnt_temp]['รวมจำนวนเงินทั้งสิ้น']['colspan'] = 1;

        return $column_header_span;
    }

    public function getDetail(&$layout_data, $colsTmp, $cigarette, $rework, $custypeid, $cust_type_name, $approve_date, $layout, $is_bkk, $CS1_rate)
    {
        $sec = [];
        if($layout != 2) {
            $qrytmp = PtomSoOutstandingV::select($colsTmp);
            $qrytmp = $qrytmp->leftJoin('ptom_uom_conversions_v as ucv', 'ucv.uom_code', '=', DB::raw("PTOM_SO_OUTSTANDING_V.UOM_CODE AND ucv.DOMESTIC = 'Y' AND ucv.UOM_CLASS = 'ทั่วไป'"));
        } else {
            $qrytmp = DB::table('ptom_transport_v')->select($colsTmp);
            $qrytmp = $qrytmp->leftJoin('ptom_uom_conversions_v as ucv', 'ucv.uom_code', '=', DB::raw("ptom_transport_v.UOM_CODE AND ucv.DOMESTIC = 'Y' AND ucv.UOM_CLASS = 'ทั่วไป'"));
        }
        $qrytmp = $is_bkk ? $qrytmp->where('province_code', 10) : $qrytmp->where('province_code', '<>', 10);

        if ($layout == 1) {
            if ($custypeid != "30,40" && $custypeid != 10) {
                $qrytmp = $qrytmp->where('customer_type_id', $custypeid);
                $qrytmp = $qrytmp->whereRaw("TO_CHAR(pick_release_approve_date, 'dd-mm-yyyy') = ?", [$approve_date]);
                $qrytmp = $qrytmp->groupBy(['consignment_no', 'pick_release_no', 'customer_id', 'customer_name', 'province_code', 'consignment_header_id', 'customer_type_id']);
                $qrytmp = $qrytmp->orderBy('pick_release_no', 'asc');
            } 
            elseif($custypeid == 10){
                // $qrytmp = $qrytmp->where(function($q) use($custypeid){
                //     $q->where('pick_release_no', "LIKE", '%IL%');
                //     $q->orWhere('customer_type_id', $custypeid);
                // });
                $qrytmp = $qrytmp->whereIn('customer_type_id', [$custypeid, 40]);
                $qrytmp = $qrytmp->where('pick_release_no', "NOT LIKE", '%C%');
                $qrytmp = $qrytmp->whereRaw("TO_CHAR(pick_release_approve_date, 'dd-mm-yyyy') = ?", [$approve_date]);
                $qrytmp = $qrytmp->groupBy(['consignment_no', 'pick_release_no', 'customer_id', 'customer_name', 'province_code', 'consignment_header_id', 'customer_type_id']);
                $qrytmp = $qrytmp->orderBy('pick_release_no', 'asc');
            }
            else {
                $qrytmp = $qrytmp->whereIn('customer_type_id', [30, 40]);
                $qrytmp = $qrytmp->whereNotNull('consignment_header_id');
                $qrytmp = $qrytmp->whereRaw("TO_CHAR(consignment_date, 'dd-mm-yyyy') = ?", [$approve_date]);
                $qrytmp = $qrytmp->groupBy(['consignment_no', 'customer_id', 'customer_name', 'province_code', 'consignment_header_id', 'customer_type_id']);
                $qrytmp = $qrytmp->orderBy('consignment_no', 'asc');
            }
        }
        else if ($layout == 2) {
            $qrytmp = $qrytmp->whereIn('customer_type_id', [30, 40]);
            $qrytmp = $qrytmp->where('pick_release_no', "NOT LIKE", '%IL%');
            $qrytmp = $qrytmp->whereRaw("TO_CHAR(pick_release_approve_date,'dd-mm-yyyy') = ?", [$approve_date]);
            $qrytmp = $qrytmp->groupBy(['pick_release_no', 'customer_id', 'customer_name', 'province_code', 'order_header_id', 'customer_type_id']);
            $qrytmp = $qrytmp->orderBy('pick_release_no', 'asc');
        }
        else if ($layout == 3) {
            $qrytmp = $is_bkk ? $qrytmp->where('province_code', 10) : $qrytmp->where('province_code', '<>', 10);
            $qrytmp = $qrytmp->where('customer_type_id', 20);
            $qrytmp = $qrytmp->whereRaw("TO_CHAR(pick_release_approve_date,'dd-mm-yyyy') = ?", [$approve_date]);
            $qrytmp = $qrytmp->groupBy(['pick_release_no', 'consignment_no', 'customer_id', 'customer_name', 'province_code', 'consignment_header_id', 'customer_type_id']);
            $qrytmp = $qrytmp->orderBy('consignment_no', 'asc');
        }elseif ($layout == 4) {
            $qrytmp = $qrytmp->where('customer_type_id', $custypeid);
            $qrytmp = $qrytmp->whereRaw("TO_CHAR(pick_release_approve_date, 'dd-mm-yyyy') = ?", [$approve_date]);
            $qrytmp = $qrytmp->groupBy(['consignment_no', 
                                        'customer_id', 
                                        'customer_name', 
                                        'province_code', 
                                        'consignment_header_id', 
                                        'customer_type_id',
                                        'pick_release_no']);
            $qrytmp = $qrytmp->orderBy('consignment_no', 'asc');
        }elseif ($layout == 5) {
            $qrytmp = $qrytmp->where('customer_type_id', $custypeid);
            $qrytmp = $qrytmp->whereRaw("TO_CHAR(pick_release_approve_date, 'dd-mm-yyyy') = ?", [$approve_date]);
            $qrytmp = $qrytmp->groupBy(['consignment_no', 
                                        'customer_id', 
                                        'customer_name', 
                                        'province_code', 
                                        'consignment_header_id', 
                                        'customer_type_id',
                                        'pick_release_no']);
            $qrytmp = $qrytmp->orderBy('consignment_no', 'asc');
        }

        $sec                = $qrytmp->get();
        $sum_sec            = [];
        $cigaretteSum       = [];
        $reworkSum          = [];
        $qty                = $this->initialQty();
        $arr                = [];
        $custypeidType60    = '';

        if (count($sec) > 0) {
            foreach ($sec as $row) {
                foreach ($cigarette as $item) {
                    if (array_key_exists($item->item_id, $cigaretteSum)) {
                        $cigaretteSum[$item->item_id]['a'] += $row->{'a' . $item->item_id};
                        $cigaretteSum[$item->item_id]['o'] += $row->{'o' . $item->item_id};
                    } else {
                        $cigaretteSum[$item->item_id]['a'] = $row->{'a' . $item->item_id};
                        $cigaretteSum[$item->item_id]['o'] = $row->{'o' . $item->item_id};
                    }
                }

                foreach ($rework as $item) {
                    if (array_key_exists($item->item_id, $reworkSum)) {
                        $reworkSum[$item->item_id]['a'] += $row->{'a' . $item->item_id};
                        $reworkSum[$item->item_id]['o'] += $row->{'o' . $item->item_id};
                    } else {
                        $reworkSum[$item->item_id]['a'] = $row->{'a' . $item->item_id};
                        $reworkSum[$item->item_id]['o'] = $row->{'o' . $item->item_id};
                    }

                }
                $qty[0]['submitqty10']                  += $row->submitqty10;
                $qty[0]['orderqty10']                   += $row->orderqty10;

                $qty[1]['orderamount10']                += $row->orderamount10;
                $qty[1]['submitamount10']               += $row->submitamount10;

                $qty[2]['submitqty20']                  += $row->submitqty20;
                $qty[2]['orderqty20']                   += $row->orderqty20;

                $qty[3]['orderamount20']                += $row->orderamount20;
                $qty[3]['submitamount20']               += $row->submitamount20;

                $qty[4]['submitamount10submitamount20'] += $row->submitamount10 + $row->submitamount20;
                $qty[4]['orderamount10orderamount20']   += $row->orderamount10 + $row->orderamount20;
            }
            $sum_sec = [
                'cigarette' => $cigaretteSum,
                'rework'    => $reworkSum,
                'qty'       => $qty
            ];
        }

        $layout_data[$custypeid]['type']          = $is_bkk ? 'ไม่อบจ.' : 'อบจ.';
        $layout_data[$custypeid]['name']          = $cust_type_name[0];
        $layout_data[$custypeid]['sum_name']      = $cust_type_name[1];
        $layout_data[$custypeid]['sec']           = $sec;
        $layout_data[$custypeid]['sum_sec']       = $sum_sec;
        $layout_data[$custypeid]['convert_rate']  = [];
    }

    public function pushDataPerPage(&$layout_data_all, &$line_cnt, &$page_no, $detail_all)
    {
        $limit_line_per_page = 19;
        $line_cnt++;

        if ($line_cnt > $limit_line_per_page ) {
            $page_no++;
            $line_cnt = 0;
        }

        if (!array_key_exists($page_no,$layout_data_all)){
            $layout_data_all[$page_no] = [];
        }
        array_push($layout_data_all[$page_no], $detail_all);
    }

    public function loopDataPerPage(&$layout_data_all, &$page_no, &$line_cnt, $ldata, $lsum, $s_type){
        $default_detail_all = [
            'section'       => '',
            'section_type'  => '',
            'cust_type_id'  => '',
            'type'          => '',
            'name'          => '',
            'sum_name'      => '',
            'sec'           => [],
            'sum_sec'       => [],
            'convert_rate'  => []
        ];

        if ($s_type != 'ab'){
            foreach($ldata as $k1 => $cust_types)
            {
                $detail_all                     = $default_detail_all;
                $detail_all['section']          = "sec_$s_type";
                $detail_all['section_type']     = 'detail';
                $detail_all['cust_type_id']     = $k1;
                $detail_all['type']             = $cust_types['type'];
                $detail_all['name']             = $cust_types['name'];
                $detail_all['sum_name']         = $cust_types['sum_name'];
                $detail_all['convert_rate']     = $cust_types['convert_rate'];
                if (count($cust_types['sec']) > 0){
                    $detail_all['section_type'] = 'header';
                    $this->pushDataPerPage($layout_data_all, $line_cnt, $page_no, $detail_all);
                }

                foreach($cust_types['sec'] as $k2 => $section){
                    $detail_all['section_type'] = 'detail';
                    $detail_all['sec'] = json_decode(json_encode($section));
                    $this->pushDataPerPage($layout_data_all, $line_cnt, $page_no, $detail_all);
                }

                if (count($cust_types['sum_sec']) > 0){
                    $detail_all['section_type'] = "sum";
                    $detail_all['sec'] = [];
                    $detail_all['sum_sec'] = $cust_types['sum_sec'];
                    $this->pushDataPerPage($layout_data_all, $line_cnt, $page_no, $detail_all);
                }

            }
        }

        if (count($lsum) > 0){
            $detail_all = $default_detail_all;
            $detail_all['section'] = "sec_$s_type";
            $detail_all['section_type'] = "sum_all_$s_type";
            $detail_all['sum_sec_all'] = $lsum;
            $this->pushDataPerPage($layout_data_all, $line_cnt, $page_no, $detail_all);
        }
    }

    public function rearrange_layout_data($layout_data, $layout_data_not_bkk, $layout_sum_groupa, $layout_sum_groupb, $layout_sum_groupab){

        $layout_data_all =[];
        $page_no = 0;
        $line_cnt = 0;

        $this->loopDataPerPage($layout_data_all, $page_no, $line_cnt, $layout_data, $layout_sum_groupa, 'a');
        $this->loopDataPerPage($layout_data_all, $page_no, $line_cnt, $layout_data_not_bkk, $layout_sum_groupb, 'b');
        $this->loopDataPerPage($layout_data_all, $page_no, $line_cnt, [], $layout_sum_groupab, 'ab');

        return $layout_data_all;
    }

    public function layout1($programCode, $request)
    {
        $layout         = 1;
        $custypeid      = $request['customer_type_id'];
        $approve_date   = $request['approve_date'];  //"03/01/2022"

        list($day, $month, $year)   = explode("/", $approve_date);
        $approve_date               = $day . "-" . $month . "-" . $year;
        $approve_date_th            = $day . "/" . $month . "/" . ($year + 543);
        $dateymd                    = $year . "-" . $month . "-" . $day;

        //สำหรับ บุหรี และ ยาเส้น
        $sql        = "SELECT DISTINCT  ITEM_ID, ITEM_DESCRIPTION, START_DATE, END_DATE, 
                                        PRODUCT_TYPE_CODE,SCREEN_NUMBER 
                              FROM PTOM_SEQUENCE_ECOMS 
                              WHERE to_char(start_date,'yyyy-mm-dd')<= ? 
                              AND (to_char(end_date,'yyyy-mm-dd')>= ? OR END_DATE IS NULL) 
                              AND SCREEN_NUMBER <> '0' 
                              AND sale_type_code='DOMESTIC'
                              AND product_type_code = ? 
                              ORDER BY PRODUCT_TYPE_CODE ASC,SCREEN_NUMBER ASC";
        $cigarette  = DB::select($sql, [$dateymd, $dateymd, 10]); // บุหรี่
        $rework     = DB::select($sql, [$dateymd, $dateymd, 20]); // ยาเส้น
        $user       = Auth::user()->user_id;  // user id
        $repname    = "รายการจำหน่ายยาสูบ/ยาเส้น (รต/1)";
        $nowDateTH  = parseToDateTh(date('Y-m-d H:i:s'));

        $CS1_rate = DB::table('ptom_uom_conversions_v')->where('uom_code', 'CS1')->pluck('conversion_rate')->first();
        $CS1_rate = $CS1_rate == null ? 1 : $CS1_rate;

        //-----------------------SEC A exclude 30,40 -----------------------------------------------------
        $colAs = [
            'consignment_no',
            'customer_id',
            'customer_name',
            'province_code',
            'consignment_header_id',
            'customer_type_id',
            'pick_release_no as invoice_no',

            DB::raw('sum(CASE WHEN product_type_code = 10 THEN approve_quantity ELSE 0 END) AS submitqty10'),
            DB::raw('sum(CASE WHEN product_type_code = 10 THEN order_quantity ELSE 0 END) AS orderqty10'),
            DB::raw('sum(CASE WHEN pick_release_no IS NOT NULL and product_type_code = 10 THEN consignment_quantity ELSE 0 END) AS actualqty10'),

            DB::raw('sum(CASE WHEN product_type_code = 10 THEN amount ELSE 0 END) AS submitamount10'),
            DB::raw('sum(CASE WHEN product_type_code = 10 THEN unit_price * order_quantity ELSE 0 END) AS orderamount10'),

            DB::raw('sum(CASE WHEN product_type_code = 20 THEN approve_quantity * (ucv.conversion_rate/ '. $CS1_rate .') ELSE 0 END) AS submitqty20'),
            DB::raw('sum(CASE WHEN product_type_code = 20 THEN order_quantity * (ucv.conversion_rate/ '. $CS1_rate .') ELSE 0 END) AS orderqty20'),
            DB::raw('sum(CASE WHEN pick_release_no IS NOT NULL and product_type_code = 20  THEN consignment_quantity * (ucv.conversion_rate/ '. $CS1_rate .') ELSE 0 END) AS actualqty20'),

            DB::raw('sum(CASE WHEN product_type_code = 20 THEN amount ELSE 0 END) AS submitamount20'),
            DB::raw('sum(CASE WHEN product_type_code = 20 THEN unit_price * (ucv.conversion_rate/ '. $CS1_rate .') * order_quantity ELSE 0 END) AS orderamount20'),
        ];

        foreach ($cigarette as $key => $value) {
            $colAs[] = DB::raw('sum(case when item_id = ' . $value->item_id . ' then approve_quantity else 0 end ) as a' . $value->item_id);
            $colAs[] = DB::raw('sum(case when item_id = ' . $value->item_id . ' then order_quantity else 0 end ) as o' . $value->item_id);
        }
        foreach ($rework as $key => $value) {
            $colAs[] = DB::raw('sum(case when item_id = ' . $value->item_id . ' then approve_quantity * (ucv.conversion_rate/ '. $CS1_rate .') else 0 end ) as a' . $value->item_id);
            $colAs[] = DB::raw('sum(case when item_id = ' . $value->item_id . ' then order_quantity * (ucv.conversion_rate/ '. $CS1_rate .') else 0 end ) as o' . $value->item_id);
        }

        //-----------------------SEC B only 30,40 -----------------------------------------------------
        $colBs = [
            'consignment_no as invoice_no',
            'customer_id',
            'customer_name',
            'province_code',
            'consignment_header_id',
            'customer_type_id',

            DB::raw('sum(CASE WHEN product_type_code = 10 THEN consignment_quantity ELSE 0 END) AS submitqty10'),
            DB::raw('sum(CASE WHEN product_type_code = 10 THEN approve_quantity ELSE 0 END) AS orderqty10'),
            DB::raw('sum(CASE WHEN consignment_no IS NOT NULL and product_type_code = 10 THEN consignment_quantity ELSE 0 END) AS actualqty10'),

            DB::raw('sum(CASE WHEN product_type_code = 10 THEN consignment_amount ELSE 0 END) AS submitamount10'),
            DB::raw('sum(CASE WHEN product_type_code = 10 THEN amount ELSE 0 END) AS orderamount10'),

            DB::raw('sum(CASE WHEN product_type_code = 20 THEN approve_quantity * (ucv.conversion_rate/ '. $CS1_rate .') ELSE 0 END) AS submitqty20'),
            DB::raw('sum(CASE WHEN product_type_code = 20 THEN order_quantity * (ucv.conversion_rate/ '. $CS1_rate .') ELSE 0 END) AS orderqty20'),
            DB::raw('sum(CASE WHEN consignment_no IS NOT NULL and product_type_code = 20  THEN consignment_quantity * (ucv.conversion_rate/ '. $CS1_rate .') ELSE 0 END) AS actualqty20'),

            DB::raw('sum(CASE WHEN product_type_code = 20 THEN amount ELSE 0 END) AS submitamount20'),
            DB::raw('sum(CASE WHEN product_type_code = 20 THEN unit_price  * (ucv.conversion_rate/ '. $CS1_rate .') * order_quantity ELSE 0 END) AS orderamount20'),

        ];
        foreach ($cigarette as $key => $value) {
            $colBs[] = DB::raw('sum(case when item_id = ' . $value->item_id . ' then approve_quantity else 0 end ) as o' . $value->item_id);
            $colBs[] = DB::raw('sum(case when item_id = ' . $value->item_id . ' then consignment_quantity else 0 end ) as a' . $value->item_id);
        }
        foreach ($rework as $key => $value) {
            $colBs[] = DB::raw('sum(case when item_id = ' . $value->item_id . ' then approve_quantity * (ucv.conversion_rate/ '. $CS1_rate .') else 0 end ) as o' . $value->item_id);
            $colBs[] = DB::raw('sum(case when item_id = ' . $value->item_id . ' then consignment_quantity * (ucv.conversion_rate/ '. $CS1_rate .') else 0 end ) as a' . $value->item_id);
        }


        $qryB = PtomSoOutstandingV::select([
            DB::raw(
                'DISTINCT item_id'
            ),
            'uom_code',
            DB::raw('(SELECT CONVERSION_RATE FROM ptom_uom_conversions_v pucv WHERE pucv.UOM_CODE = PTOM_SO_OUTSTANDING_V.UOM_CODE) AS conversions_rate')
        ])->where('product_type_code', 20);

        $layout1_convert_rate   = $qryB->get()->toArray();
        $product20_convert_rate = [];
        foreach($layout1_convert_rate as $rate){
            $product20_convert_rate[$rate['item_id']] = $rate['conversions_rate'] / $CS1_rate;
        }

        //-----------------------CUST_TYPE_ARR LAYOUT 1 BKK-----------------------------------------------------
        // $cust_type_id => [{section_name}, {sum_section_name}]
        $cust_type_arr = [
            10 => ['ร้านค้าป.1', 'กทม'],
            '30,40' => ['ฝากสโมสรยาสูบขาย', 'ฝากขาย'],
            50 => ['ร้านขายส่งยาสูบประเภท 2', 'ร้านขายส่งยาสูบประเภท 2'],
            // 60 => ['ขายพนักงาน', 'ขายพนักงาน'],
            70 => ['ลูกค้าขายปลีก', 'ลูกค้าขายปลีก'],
            // 80 => ['ส่งเสริม ไม่คิดมูลค่า', 'ส่งเสริม ไม่คิดมูลค่า']
        ];

        //-----------------------ONLY BKK-----------------------------------------------------
        $is_bkk         = true;
        $layout_data    = [];
        if ($custypeid == 0) {
            foreach ($cust_type_arr as $cust_type => $cust_type_name) {
                if ($cust_type == "30,40") {
                    $this->getDetail($layout_data, $colBs, $cigarette, $rework, $cust_type, $cust_type_name, $approve_date, $layout, $is_bkk, $CS1_rate);
                } else {
                    $this->getDetail($layout_data, $colAs, $cigarette, $rework, $cust_type, $cust_type_name, $approve_date, $layout, $is_bkk, $CS1_rate);
                }
            }
        } else if ($custypeid == "30,40") {
            $this->getDetail($layout_data, $colBs, $cigarette, $rework, $custypeid, $cust_type_arr[$custypeid], $approve_date, $layout, $is_bkk, $CS1_rate);
        } else {
            $this->getDetail($layout_data, $colAs, $cigarette, $rework, $custypeid, $cust_type_arr[$custypeid], $approve_date, $layout, $is_bkk, $CS1_rate);
        }
        //-----------------------CUST_TYPE_ARR LAYOUT 1 NOT BKK-----------------------------------------------------
        // $cust_type_id => [{section_name}, {sum_section_name}]
        $cust_type_arr = [
            10 => ['ร้านค้าป.1', 'ต่างจังหวัด'],
            '30,40' => ['ฝากสโมสรยาสูบขาย', 'ฝากขาย'],
            50 => ['ร้านขายส่งยาสูบประเภท 2', 'ร้านขายส่งยาสูบประเภท 2'],
            // 60 => ['ขายพนักงาน', 'ขายพนักงาน'],
            70 => ['ลูกค้าขายปลีก', 'ลูกค้าขายปลีก'],
            // 80 => ['ส่งเสริม ไม่คิดมูลค่า', 'ส่งเสริม ไม่คิดมูลค่า']
        ];
        //-----------------------NOT BKK-----------------------------------------------------
        $is_bkk = false;
        $layout_data_not_bkk = [];
        if ($custypeid == 0) {
            foreach ($cust_type_arr as $cust_type => $cust_type_name) {
                if ($cust_type == "30,40") {
                    $this->getDetail($layout_data_not_bkk, $colBs, $cigarette, $rework, $cust_type, $cust_type_name, $approve_date, $layout, $is_bkk, $CS1_rate);
                } else {
                    $this->getDetail($layout_data_not_bkk, $colAs, $cigarette, $rework, $cust_type, $cust_type_name, $approve_date,  $layout,$is_bkk, $CS1_rate);
                }
            }
        } else if ($custypeid == "30,40") {
            $this->getDetail($layout_data_not_bkk, $colBs, $cigarette, $rework, $custypeid, $cust_type_arr[$custypeid], $approve_date, $layout,$is_bkk, $CS1_rate);
        } else {
            $this->getDetail($layout_data_not_bkk, $colAs, $cigarette, $rework, $custypeid, $cust_type_arr[$custypeid], $approve_date,  $layout,$is_bkk, $CS1_rate);
        }

        //-----------------------sum_groupA.-----------------------------------------------
        $layout_sum_groupa = [];
        foreach ($layout_data as $key1 => $layout_data_detail) {
            foreach ($layout_data_detail['sum_sec'] as $key2 => $layout_data_sum_sec) {
                foreach ($layout_data_sum_sec as $key3 => $layout_data_sum_sec_arr) {
                    foreach ($layout_data_sum_sec_arr as $key4 => $layout_data_sum_sec_value) {
                        if ($key2 != 'qty') {
                            if (!array_key_exists($key4 . $key3, $layout_sum_groupa)) {
                                $layout_sum_groupa[$key4 . $key3] = $layout_data_sum_sec_value;
                            } else {
                                $layout_sum_groupa[$key4 . $key3] += $layout_data_sum_sec_value;
                            }
                        } else {
                            if (!array_key_exists($key4, $layout_sum_groupa)) {
                                $layout_sum_groupa[$key4] = $layout_data_sum_sec_value;
                            } else {
                                $layout_sum_groupa[$key4] += $layout_data_sum_sec_value;
                            }
                        }
                    }
                }
            }
        }

        //-----------------------sum_groupB-------------------------------------------------
        $layout_sum_groupb = [];
        foreach ($layout_data_not_bkk as $key1 => $layout_data_detail) {
            foreach ($layout_data_detail['sum_sec'] as $key2 => $layout_data_sum_sec) {
                foreach ($layout_data_sum_sec as $key3 => $layout_data_sum_sec_arr) {
                    foreach ($layout_data_sum_sec_arr as $key4 => $layout_data_sum_sec_value) {
                        if ($key2 != 'qty') {
                            if (!array_key_exists($key4 . $key3, $layout_sum_groupb)) {
                                $layout_sum_groupb[$key4 . $key3] = $layout_data_sum_sec_value;
                            } else {
                                $layout_sum_groupb[$key4 . $key3] += $layout_data_sum_sec_value;
                            }
                        } else {
                            if (!array_key_exists($key4, $layout_sum_groupb)) {
                                $layout_sum_groupb[$key4] = $layout_data_sum_sec_value;
                            } else {
                                $layout_sum_groupb[$key4] += $layout_data_sum_sec_value;
                            }
                        }
                    }
                }
            }
        }
        //-----------------------sum_groupAB.-----------------------------------------------

        $layout_sum_groupab = [];
        if (count($layout_sum_groupa) > 0){
            foreach ($layout_sum_groupa as $key1 => $layout_sum_groupa_value) {
                $layout_sum_groupab[$key1] = $layout_sum_groupa_value + (isset($layout_sum_groupb[$key1]) ? $layout_sum_groupb[$key1] : 0);
            }
        }else{
            foreach ($layout_sum_groupb as $key1 => $layout_sum_groupb_value) {
                $layout_sum_groupab[$key1] = $layout_sum_groupb_value + (isset($layout_sum_groupa[$key1]) ? $layout_sum_groupa[$key1] : 0);
            }
        }

        $column_cnt_pagebreak = 10;
        $column_header_span = $this->getColHeaderSpan($column_cnt_pagebreak, $cigarette, $rework);

        $layout_data_all = $this->rearrange_layout_data($layout_data, $layout_data_not_bkk, $layout_sum_groupa,$layout_sum_groupb,$layout_sum_groupab);

        //-----------------------END--------------------------------------------------------
        $data = compact(
            'programCode',
            'user',
            'nowDateTH',
            'approve_date',
            'approve_date_th',
            'cigarette',
            'rework',
            'cust_type_arr',
            'column_cnt_pagebreak',
            'column_header_span',
            'layout_data_all'
        );

        // $sql = DB::getQueryLog();
        $html = view('om.reports.omr0024.layout1', $data)->render();
        $mpdf = new \Mpdf\Mpdf([
            'tempDir'           => __DIR__ . '/tmp',
            'margin_left'       => 5,
            'margin_right'      => 5,
            'margin_top'        => 35,
            'margin_bottom'     => 25,
            'margin_header'     => 10,
            'format'            => 'A3-L',
            'mode'              => 'utf-8',
            'default_font'      => 'angsana',
            'margin_footer'     => 10
        ]);

        $mpdf->SetTitle("{$programCode}_1 - $repname");
        $mpdf->SetProtection(array('print'));
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($html);
        $mpdf->Output($programCode . '_1.pdf', \Mpdf\Output\Destination::INLINE);
        exit();
    }

    public function layout2($programCode, $request)
    {
        $layout             = 2;
        $custypeid          = '30,40';
        $approve_date       = $request['approve_date'];  //"03/01/2022"
        list($day, $month, $year) = explode("/", $approve_date);
        $approve_date       = $day . "-" . $month . "-" . $year;
        $approve_date_th    = $day . "/" . $month . "/" . ($year + 543);
        $dateymd            = $year . "-" . $month . "-" . $day;
        // DB::enableQueryLog();
        //สำหรับ บุหรี และ ยาเส้น
        $sql                = " SELECT DISTINCT ITEM_ID, ITEM_DESCRIPTION, START_DATE, END_DATE, PRODUCT_TYPE_CODE, SCREEN_NUMBER 
                                FROM PTOM_SEQUENCE_ECOMS 
                                WHERE to_char(START_DATE,'yyyy-mm-dd')<= ? 
                                AND (to_char(end_date,'yyyy-mm-dd')>= ? OR END_DATE IS NULL) 
                                AND SCREEN_NUMBER<> '0' 
                                AND sale_type_code='DOMESTIC'
                                AND product_type_code = ? 
                                ORDER BY PRODUCT_TYPE_CODE ASC,SCREEN_NUMBER ASC";
        $cigarette          = DB::select($sql, [$dateymd, $dateymd, 10]); // บุหรี่
        $rework             = DB::select($sql, [$dateymd, $dateymd, 20]); // ยาเส้น

        $user       = Auth::user()->user_id;  // user id
        $repname    = "รายการจำหน่ายยาสูบ/ยาเส้น (รต/1) ใบขน (สโมสร)";
        $nowDateTH  = parseToDateTh(date('Y-m-d H:i:s'));

        $CS1_rate = DB::table('ptom_uom_conversions_v')->where('uom_code', 'CS1')->pluck('conversion_rate')->first();
        $CS1_rate = $CS1_rate == null ? 1 : $CS1_rate;

        //---------------- SEC A ----------------------------------------------
        $colAs = [
            'pick_release_no as invoice_no',
            'customer_id',
            'customer_name',
            'province_code',
            'order_header_id',
            'customer_type_id',

            DB::raw('sum(CASE WHEN product_type_code = 10 THEN approve_quantity ELSE 0 END) AS submitqty10'), //6 ส่ง
            DB::raw('sum(CASE WHEN product_type_code = 10 THEN order_quantity ELSE 0 END) AS orderqty10'), //6 สั่ง
            DB::raw('sum(0) AS actualqty10'), //6
            // DB::raw('sum(CASE WHEN consignment_no IS NOT NULL and product_type_code = 10 THEN consignment_quantity ELSE 0 END) AS actualqty10'), //6

            DB::raw('sum(CASE WHEN product_type_code = 10 THEN amount ELSE 0 END) AS submitamount10'), //7 ส่ง
            DB::raw('sum(CASE WHEN product_type_code = 10 THEN unit_price * order_quantity ELSE 0 END) AS orderamount10'), //7 สั่ง

            DB::raw('sum(CASE WHEN product_type_code = 20 THEN approve_quantity * (ucv.conversion_rate/ '. $CS1_rate .') ELSE 0 END) AS submitqty20'), //8 ส่ง
            DB::raw('sum(CASE WHEN product_type_code = 20 THEN order_quantity * (ucv.conversion_rate/ '. $CS1_rate .') ELSE 0 END) AS orderqty20'), //8 สั่ง
            DB::raw('sum(0) AS actualqty20'), //8
            // DB::raw('sum(CASE WHEN consignment_no IS NOT NULL and product_type_code = 20  THEN consignment_quantity * (ucv.conversion_rate/ '. $CS1_rate .') ELSE 0 END) AS actualqty20'), //8

            DB::raw('sum(CASE WHEN product_type_code = 20 THEN amount ELSE 0 END) AS submitamount20'), //9 ส่ง
            DB::raw('sum(CASE WHEN product_type_code = 20 THEN unit_price * (ucv.conversion_rate/ '. $CS1_rate .') * order_quantity ELSE 0 END) AS orderamount20'), //9 สั่ง
        ];

        foreach ($cigarette as $key => $value) {
            $colAs[] = DB::raw('sum(case when item_id = ' . $value->item_id . ' then approve_quantity else 0 end ) as a' . $value->item_id);
            $colAs[] = DB::raw('sum(case when item_id = ' . $value->item_id . ' then order_quantity else 0 end ) as o' . $value->item_id);
        }

        foreach ($rework as $key => $value) {
            $colAs[] = DB::raw('sum(case when item_id = ' . $value->item_id . ' then approve_quantity * (ucv.conversion_rate/ '. $CS1_rate .') else 0 end ) as a' . $value->item_id);
            $colAs[] = DB::raw('sum(case when item_id = ' . $value->item_id . ' then order_quantity * (ucv.conversion_rate/ '. $CS1_rate .') else 0 end ) as o' . $value->item_id);
        }
        //-----------------------CUST_TYPE_ARR LAYOUT 2-----------------------------------------------------
        // $cust_type_id => [{section_name}, {sum_section_name}]
        $cust_type_arr = [
            '30,40' => ['ใบขนสโมสรยาสูบ', 'ขาย ไม่อบจ.'],
        ];
        //-----------------------ONLY BKK-----------------------------------------------------
        $is_bkk = true;
        $layout_data = [];
        $this->getDetail($layout_data, $colAs, $cigarette, $rework, $custypeid, $cust_type_arr[$custypeid], $approve_date, $layout, $is_bkk, $CS1_rate);

        //-----------------------CUST_TYPE_ARR LAYOUT 2-----------------------------------------------------
        // $cust_type_id => [{section_name}, {sum_section_name}]
        $cust_type_arr = [
            '30,40' => ['ใบขนสโมสรยาสูบ', 'ขาย อบจ.'],
        ];
        //-----------------------NOT BKK-----------------------------------------------------
        $is_bkk = false;
        $layout_data_not_bkk = [];
        $this->getDetail($layout_data_not_bkk, $colAs, $cigarette, $rework, $custypeid, $cust_type_arr[$custypeid], $approve_date, $layout, $is_bkk, $CS1_rate);

        //-----------------------sum_groupA.-----------------------------------------------
        $layout_sum_groupa = [];
        foreach ($layout_data as $key1 => $layout_data_detail) {
            foreach ($layout_data_detail['sum_sec'] as $key2 => $layout_data_sum_sec) {
                foreach ($layout_data_sum_sec as $key3 => $layout_data_sum_sec_arr) {
                    foreach ($layout_data_sum_sec_arr as $key4 => $layout_data_sum_sec_value) {
                        if ($key2 != 'qty') {
                            if (!array_key_exists($key4 . $key3, $layout_sum_groupa)) {
                                $layout_sum_groupa[$key4 . $key3] = $layout_data_sum_sec_value;
                            } else {
                                $layout_sum_groupa[$key4 . $key3] += $layout_data_sum_sec_value;
                            }
                        } else {
                            if (!array_key_exists($key4, $layout_sum_groupa)) {
                                $layout_sum_groupa[$key4] = $layout_data_sum_sec_value;
                            } else {
                                $layout_sum_groupa[$key4] += $layout_data_sum_sec_value;
                            }
                        }
                    }
                }
            }
        }

        //-----------------------sum_groupB-------------------------------------------------
        $layout_sum_groupb = [];
        foreach ($layout_data_not_bkk as $key1 => $layout_data_detail) {
            foreach ($layout_data_detail['sum_sec'] as $key2 => $layout_data_sum_sec) {
                foreach ($layout_data_sum_sec as $key3 => $layout_data_sum_sec_arr) {
                    foreach ($layout_data_sum_sec_arr as $key4 => $layout_data_sum_sec_value) {
                        if ($key2 != 'qty') {
                            if (!array_key_exists($key4 . $key3, $layout_sum_groupb)) {
                                $layout_sum_groupb[$key4 . $key3] = $layout_data_sum_sec_value;
                            } else {
                                $layout_sum_groupb[$key4 . $key3] += $layout_data_sum_sec_value;
                            }
                        } else {
                            if (!array_key_exists($key4, $layout_sum_groupb)) {
                                $layout_sum_groupb[$key4] = $layout_data_sum_sec_value;
                            } else {
                                $layout_sum_groupb[$key4] += $layout_data_sum_sec_value;
                            }
                        }
                    }
                }
            }
        }
        //-----------------------sum_groupAB.-----------------------------------------------

        $layout_sum_groupab = [];
        if (count($layout_sum_groupa) > 0){
            foreach ($layout_sum_groupa as $key1 => $layout_sum_groupa_value) {
                $layout_sum_groupab[$key1] = $layout_sum_groupa_value + (isset($layout_sum_groupb[$key1]) ? $layout_sum_groupb[$key1] : 0);
            }
        }else{
            foreach ($layout_sum_groupb as $key1 => $layout_sum_groupb_value) {
                $layout_sum_groupab[$key1] = $layout_sum_groupb_value + (isset($layout_sum_groupa[$key1]) ? $layout_sum_groupa[$key1] : 0);
            }
        }

        $column_cnt_pagebreak = 10;
        $column_header_span = $this->getColHeaderSpan($column_cnt_pagebreak, $cigarette, $rework);

        $layout_data_all = $this->rearrange_layout_data($layout_data, $layout_data_not_bkk, $layout_sum_groupa,$layout_sum_groupb,$layout_sum_groupab);

        $data = compact(
            'programCode',
            'user',
            'repname',
            'nowDateTH',
            'approve_date',
            'approve_date_th',
            'cigarette',
            'rework',
            'cust_type_arr',
            'column_cnt_pagebreak',
            'column_header_span',
            'layout_data_all'
        );
        $html = view('om.reports.omr0024.layout2', $data)->render();
        $mpdf = new \Mpdf\Mpdf([
            'tempDir'           => __DIR__ . '/tmp',
            'margin_left'       => 5,
            'margin_right'      => 5,
            'margin_top'        => 35,
            'margin_bottom'     => 25,
            'margin_header'     => 10,
            'format'            => 'A3-L',
            'mode'              => 'utf-8',
            'default_font'      => 'angsana',
            'margin_footer'     => 10
        ]);

        $mpdf->SetTitle("{$programCode}_2 - $repname");
        $mpdf->SetProtection(array('print'));
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($html);
        $mpdf->Output($programCode . '_2.pdf', \Mpdf\Output\Destination::INLINE);
        exit();
    }

    public function layout3($programCode, $request)
    {
        $layout             = 3;
        $custypeid          = '20';
        $approve_date       = $request['approve_date'];  //"03/01/2022"
        list($day, $month, $year) = explode("/", $approve_date);
        $approve_date       = $day . "-" . $month . "-" . $year;
        $approve_date_th    = $day . "/" . $month . "/" . ($year + 543);
        $dateymd            = $year . "-" . $month . "-" . $day;
        //สำหรับ บุหรี และ ย้าเส้น
        $sql                = " SELECT DISTINCT ITEM_ID, ITEM_DESCRIPTION, START_DATE, END_DATE, PRODUCT_TYPE_CODE, SCREEN_NUMBER 
                                FROM        PTOM_SEQUENCE_ECOMS 
                                WHERE       to_char(START_DATE,'yyyy-mm-dd')<= ? 
                                AND         (to_char(end_date,'yyyy-mm-dd')>= ? OR END_DATE IS NULL) 
                                AND         SCREEN_NUMBER<> '0' 
                                AND         sale_type_code='DOMESTIC'
                                AND         product_type_code = ? 
                                ORDER BY    PRODUCT_TYPE_CODE ASC,SCREEN_NUMBER ASC";
        $cigarette          = DB::select($sql, [$dateymd, $dateymd, 10]); // บุหรี่
        $rework             = DB::select($sql, [$dateymd, $dateymd, 20]); // ยาเส้น

        $user               = Auth::user()->user_id;  // user id
        $repname            = "รายการจำหน่ายยาสูบ/ยาเส้น (รต/1)";
        $nowDateTH          = parseToDateTh(date('Y-m-d H:i:s'));

        $CS1_rate = DB::table('ptom_uom_conversions_v')->where('uom_code', 'CS1')->pluck('conversion_rate')->first();
        $CS1_rate = $CS1_rate == null ? 1 : $CS1_rate;

        //---------------- SEC A----------------------------------------------
        $colAs = [
            'consignment_no',
            'customer_id',
            'customer_name',
            'province_code',
            'consignment_header_id',
            'customer_type_id',
            'pick_release_no as invoice_no',

            DB::raw('sum(CASE WHEN product_type_code = 10 THEN order_quantity ELSE 0 END) AS orderqty10'), //6
            DB::raw('sum(CASE WHEN product_type_code = 10 THEN approve_quantity ELSE 0 END) AS submitqty10'), //6
            DB::raw('sum(CASE WHEN consignment_no IS NOT NULL and product_type_code = 10 THEN consignment_quantity ELSE 0 END) AS actualqty10'), //6

            DB::raw('sum(CASE WHEN product_type_code = 10 THEN amount ELSE 0 END) AS submitamount10'), //7 ส่ง
            DB::raw('sum(CASE WHEN product_type_code = 10 THEN unit_price * order_quantity ELSE 0 END) AS orderamount10'), //7 สั่ง

            DB::raw('sum(CASE WHEN product_type_code = 20 THEN order_quantity * (ucv.conversion_rate/ '. $CS1_rate .') ELSE 0 END) AS orderqty20'), //8
            DB::raw('sum(CASE WHEN product_type_code = 20 THEN approve_quantity * (ucv.conversion_rate/ '. $CS1_rate .') ELSE 0 END) AS submitqty20'), //8
            DB::raw('sum(CASE WHEN consignment_no IS NOT NULL and product_type_code = 20  THEN consignment_quantity * (ucv.conversion_rate/ '. $CS1_rate .') ELSE 0 END) AS actualqty20'), //8

            DB::raw('sum(CASE WHEN product_type_code = 20 THEN amount ELSE 0 END) AS submitamount20'), //9 ส่ง
            DB::raw('sum(CASE WHEN product_type_code = 20 THEN unit_price * (ucv.conversion_rate/ '. $CS1_rate .') * order_quantity ELSE 0 END) AS orderamount20'), //9 สั่ง
        ];
        foreach ($cigarette as $key => $value) {
            $colAs[] = DB::raw('sum(case when item_id = ' . $value->item_id . ' then approve_quantity else 0 end ) as a' . $value->item_id);
            $colAs[] = DB::raw('sum(case when item_id = ' . $value->item_id . ' then order_quantity else 0 end ) as o' . $value->item_id);
        }
        foreach ($rework as $key => $value) {
            $colAs[] = DB::raw('sum(case when item_id = ' . $value->item_id . ' then approve_quantity * (ucv.conversion_rate/ '. $CS1_rate .') else 0 end ) as a' . $value->item_id);
            $colAs[] = DB::raw('sum(case when item_id = ' . $value->item_id . ' then order_quantity * (ucv.conversion_rate/ '. $CS1_rate .') else 0 end ) as o' . $value->item_id);
        }

        $layout3_convert_rate = PtomSoOutstandingV::select([
            DB::raw(
                'DISTINCT item_id'
            ),
            'uom_code',
            DB::raw('(SELECT CONVERSION_RATE FROM ptom_uom_conversions_v pucv WHERE pucv.UOM_CODE = PTOM_SO_OUTSTANDING_V.UOM_CODE) AS conversions_rate')
        ])
            ->where('customer_type_id', 20)->get()->toArray();

        //-----------------------CUST_TYPE_ARR LAYOUT 3-----------------------------------------------------
        // $cust_type_id => [{section_name}, {sum_section_name}]
        $cust_type_arr = [
            20 => ['กทม. (MT)', 'ไม่อบจ.'],
        ];
        //-----------------------ONLY BKK-----------------------------------------------------
        $is_bkk = true;
        $layout_data = [];
        $this->getDetail($layout_data, $colAs, $cigarette, $rework, $custypeid, $cust_type_arr[$custypeid], $approve_date, $layout, $is_bkk, $CS1_rate);

        //-----------------------CUST_TYPE_ARR LAYOUT 3-----------------------------------------------------
        // $cust_type_id => [{section_name}, {sum_section_name}]
        $cust_type_arr = [
            20 => ['ต่างจังหวัด (MT)', 'อบจ.'],
        ];
        //-----------------------NOT BKK-----------------------------------------------------
        $is_bkk = false;
        $layout_data_not_bkk = [];
        $this->getDetail($layout_data_not_bkk, $colAs, $cigarette, $rework, $custypeid, $cust_type_arr[$custypeid], $approve_date, $layout, $is_bkk, $CS1_rate);

        //-----------------------sum_groupA.-----------------------------------------------
        $layout_sum_groupa = [];
        foreach ($layout_data as $key1 => $layout_data_detail) {
            foreach ($layout_data_detail['sum_sec'] as $key2 => $layout_data_sum_sec) {
                foreach ($layout_data_sum_sec as $key3 => $layout_data_sum_sec_arr) {
                    foreach ($layout_data_sum_sec_arr as $key4 => $layout_data_sum_sec_value) {
                        if ($key2 != 'qty') {
                            if (!array_key_exists($key4 . $key3, $layout_sum_groupa)) {
                                $layout_sum_groupa[$key4 . $key3] = $layout_data_sum_sec_value;
                            } else {
                                $layout_sum_groupa[$key4 . $key3] += $layout_data_sum_sec_value;
                            }
                        } else {
                            if (!array_key_exists($key4, $layout_sum_groupa)) {
                                $layout_sum_groupa[$key4] = $layout_data_sum_sec_value;
                            } else {
                                $layout_sum_groupa[$key4] += $layout_data_sum_sec_value;
                            }
                        }
                    }
                }
            }
        }

        //-----------------------sum_groupB-------------------------------------------------
        $layout_sum_groupb = [];
        foreach ($layout_data_not_bkk as $key1 => $layout_data_detail) {
            foreach ($layout_data_detail['sum_sec'] as $key2 => $layout_data_sum_sec) {
                foreach ($layout_data_sum_sec as $key3 => $layout_data_sum_sec_arr) {
                    foreach ($layout_data_sum_sec_arr as $key4 => $layout_data_sum_sec_value) {
                        if ($key2 != 'qty') {
                            if (!array_key_exists($key4 . $key3, $layout_sum_groupb)) {
                                $layout_sum_groupb[$key4 . $key3] = $layout_data_sum_sec_value;
                            } else {
                                $layout_sum_groupb[$key4 . $key3] += $layout_data_sum_sec_value;
                            }
                        } else {
                            if (!array_key_exists($key4, $layout_sum_groupb)) {
                                $layout_sum_groupb[$key4] = $layout_data_sum_sec_value;
                            } else {
                                $layout_sum_groupb[$key4] += $layout_data_sum_sec_value;
                            }
                        }
                    }
                }
            }
        }
        //-----------------------sum_groupAB.-----------------------------------------------

        $layout_sum_groupab = [];
        if (count($layout_sum_groupa) > 0){
            foreach ($layout_sum_groupa as $key1 => $layout_sum_groupa_value) {
                $layout_sum_groupab[$key1] = $layout_sum_groupa_value + (isset($layout_sum_groupb[$key1]) ? $layout_sum_groupb[$key1] : 0);
            }
        }else{
            foreach ($layout_sum_groupb as $key1 => $layout_sum_groupb_value) {
                $layout_sum_groupab[$key1] = $layout_sum_groupb_value + (isset($layout_sum_groupa[$key1]) ? $layout_sum_groupa[$key1] : 0);
            }
        }
        $column_cnt_pagebreak = 10;
        $column_header_span = $this->getColHeaderSpan($column_cnt_pagebreak, $cigarette, $rework);

        $layout_data_all = $this->rearrange_layout_data($layout_data, $layout_data_not_bkk, $layout_sum_groupa,$layout_sum_groupb,$layout_sum_groupab);


        // $sql = DB::getQueryLog();
        $data = compact(
            'programCode',
            'user',
            'repname',
            'nowDateTH',
            'approve_date',
            'approve_date_th',
            'cigarette',
            'rework',
            'cust_type_arr',
            'column_cnt_pagebreak',
            'column_header_span',
            'layout_data_all'
        );
        $html = view('om.reports.omr0024.layout3', $data)->render();
        $mpdf = new \Mpdf\Mpdf([
            'tempDir'           => __DIR__ . '/tmp',
            'margin_left'       => 5,
            'margin_right'      => 5,
            'margin_top'        => 35,
            'margin_bottom'     => 25,
            'margin_header'     => 10,
            'format'            => 'A3-L',
            'mode'              => 'utf-8',
            'default_font'      => 'angsana',
            'margin_footer'     => 10
        ]);

        $mpdf->SetTitle("{$programCode}_3 - $repname");
        $mpdf->SetProtection(array('print'));
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($html);
        $mpdf->Output($programCode . '_3.pdf', \Mpdf\Output\Destination::INLINE);
        exit();
    }

    public function layout4($programCode, $request)
    {
        $repname                    = "รายการจำหน่ายยาสูบ/ยาเส้น (รต/1) บุหรี่ไม่คิดมูลค่า";
        $user                       = Auth::user()->user_id;
        $approve_date               = $request['approve_date'];
        list($day, $month, $year)   = explode("/", $approve_date);
        $approve_date               = $day . "-" . $month . "-" . $year;
        $approve_date_th            = $day . "/" . $month . "/" . ($year + 543);
        $nowDateTH                  = parseToDateTh(date('Y-m-d H:i:s'));
        $dateymd                    = $year . "-" . $month . "-" . $day;
        $custypeid                  = $request['customer_type_id'];
        $column_cnt_pagebreak       = 10;

        $layout                     = 4;
        $layout_data                = [];
        $layout_data_not_bkk        = [];
        $layout_sum_groupa          = [];
        $layout_sum_groupb          = [];
        $layout_sum_groupab         = [];

        $sql = "SELECT  DISTINCT    ITEM_ID, 
                                    ITEM_DESCRIPTION, 
                                    START_DATE,
                                    END_DATE,
                                    PRODUCT_TYPE_CODE,
                                    SCREEN_NUMBER 
                        FROM    PTOM_SEQUENCE_ECOMS 
                        WHERE   to_char(start_date,'yyyy-mm-dd')<= ? 
                        AND     (to_char(end_date,'yyyy-mm-dd')>= ? OR END_DATE IS NULL) 
                        AND     SCREEN_NUMBER<> '0' 
                        AND     sale_type_code='DOMESTIC'
                        AND     product_type_code = ? 
                        ORDER BY PRODUCT_TYPE_CODE ASC, SCREEN_NUMBER ASC";

        $cigarette          = DB::select($sql, [$dateymd, $dateymd, 10]); // บุหรี่
        $rework             = DB::select($sql, [$dateymd, $dateymd, 20]); // ยาเส้น
        $column_header_span = $this->getColHeaderSpan($column_cnt_pagebreak, $cigarette, $rework);

        $CS1_rate = DB::table('ptom_uom_conversions_v')->where('uom_code', 'CS1')->pluck('conversion_rate')->first();
        $CS1_rate = $CS1_rate == null ? 1 : $CS1_rate;

        $colAs = [
            'consignment_no',
            'customer_id',
            'customer_name',
            'province_code',
            'consignment_header_id',
            'customer_type_id',
            'pick_release_no as invoice_no',

            DB::raw('sum(CASE WHEN product_type_code = 10 THEN approve_quantity ELSE 0 END) AS submitqty10'), 
            DB::raw('sum(CASE WHEN product_type_code = 10 THEN order_quantity ELSE 0 END) AS orderqty10'), 
            DB::raw('sum(CASE WHEN pick_release_no IS NOT NULL and product_type_code = 10 THEN consignment_quantity ELSE 0 END) AS actualqty10'),

            DB::raw('sum(CASE WHEN product_type_code = 10 THEN amount ELSE 0 END) AS submitamount10'),
            DB::raw('sum(CASE WHEN product_type_code = 10 THEN unit_price * order_quantity ELSE 0 END) AS orderamount10'),

            DB::raw('sum(CASE WHEN product_type_code = 20 THEN approve_quantity * (ucv.conversion_rate/ '. $CS1_rate .') ELSE 0 END) AS submitqty20'),
            DB::raw('sum(CASE WHEN product_type_code = 20 THEN order_quantity * (ucv.conversion_rate/ '. $CS1_rate .') ELSE 0 END) AS orderqty20'),
            DB::raw('sum(CASE WHEN pick_release_no IS NOT NULL and product_type_code = 20  THEN consignment_quantity * (ucv.conversion_rate/ '. $CS1_rate .') ELSE 0 END) AS actualqty20'), //8

            DB::raw('sum(CASE WHEN product_type_code = 20 THEN amount ELSE 0 END) AS submitamount20'),
            DB::raw('sum(CASE WHEN product_type_code = 20 THEN unit_price * (ucv.conversion_rate/ '. $CS1_rate .') * order_quantity ELSE 0 END) AS orderamount20'),
        ];

        foreach ($cigarette as $key => $value) {
            $colAs[] = DB::raw('sum(case when item_id = ' . $value->item_id . ' then approve_quantity else 0 end ) as a' . $value->item_id);
            $colAs[] = DB::raw('sum(case when item_id = ' . $value->item_id . ' then order_quantity else 0 end ) as o' . $value->item_id);
        }
        foreach ($rework as $key => $value) {
            $colAs[] = DB::raw('sum(case when item_id = ' . $value->item_id . ' then approve_quantity * (ucv.conversion_rate/ '. $CS1_rate .') else 0 end ) as a' . $value->item_id);
            $colAs[] = DB::raw('sum(case when item_id = ' . $value->item_id . ' then order_quantity * (ucv.conversion_rate/ '. $CS1_rate .') else 0 end ) as o' . $value->item_id);
        }

        $is_bkk         = true;
        $cust_type_arr  = [
            10 => ['ร้านค้าป.1', 'ต่างจังหวัด'],
            '30,40' => ['ฝากสโมสรยาสูบขาย', 'ฝากขาย'],
            50 => ['ร้านขายส่งยาสูบประเภท 2', 'ร้านขายส่งยาสูบประเภท 2'],
            60 => ['ขายพนักงาน', 'ขายพนักงาน'],
            70 => ['ลูกค้าขายปลีก', 'ลูกค้าขายปลีก'],
            80 => ['บุหรี่ไม่คิดมูลค่า', 'บุหรี่ไม่คิดมูลค่า']
        ];

        foreach ($cust_type_arr as $cust_type => $cust_type_name) {
            if($cust_type === 80){
                $this->getDetail($layout_data, $colAs, $cigarette, $rework, $cust_type, $cust_type_name, $approve_date, $layout, $is_bkk, $CS1_rate);
            }
        }
        
        $layout_sum_groupa = [];
        foreach ($layout_data as $key1 => $layout_data_detail) {
            foreach ($layout_data_detail['sum_sec'] as $key2 => $layout_data_sum_sec) {
                foreach ($layout_data_sum_sec as $key3 => $layout_data_sum_sec_arr) {
                    foreach ($layout_data_sum_sec_arr as $key4 => $layout_data_sum_sec_value) {
                        if ($key2 != 'qty') {
                            if (!array_key_exists($key4 . $key3, $layout_sum_groupa)) {
                                $layout_sum_groupa[$key4 . $key3] = $layout_data_sum_sec_value;
                            } else {
                                $layout_sum_groupa[$key4 . $key3] += $layout_data_sum_sec_value;
                            }
                        } else {
                            if (!array_key_exists($key4, $layout_sum_groupa)) {
                                $layout_sum_groupa[$key4] = $layout_data_sum_sec_value;
                            } else {
                                $layout_sum_groupa[$key4] += $layout_data_sum_sec_value;
                            }
                        }
                    }
                }
            }
        }

        $layout_data_all = $this->rearrange_layout_data($layout_data, 
                                                        $layout_data_not_bkk, 
                                                        $layout_sum_groupa,
                                                        $layout_sum_groupb,
                                                        $layout_sum_groupab);
        $data = compact(
            'programCode',
            'user',
            'repname',
            'nowDateTH',
            'approve_date',
            'approve_date_th',
            'cigarette',
            'rework',
            'cust_type_arr',
            'column_cnt_pagebreak',
            'column_header_span',
            'layout_data_all'
        );

        $html = view('om.reports.omr0024.layout4', $data)->render();
        $mpdf = new \Mpdf\Mpdf([
            'tempDir'           => __DIR__ . '/tmp',
            'margin_left'       => 5,
            'margin_right'      => 5,
            'margin_top'        => 35,
            'margin_bottom'     => 25,
            'margin_header'     => 10,
            'format'            => 'A3-L',
            'mode'              => 'utf-8',
            'default_font'      => 'angsana',
            'margin_footer'     => 10
        ]);

        $mpdf->SetTitle("{$programCode}_4 - $repname");
        $mpdf->SetProtection(array('print'));
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($html);
        $mpdf->Output($programCode . '_4.pdf', \Mpdf\Output\Destination::INLINE);
        exit();
    }

    public function layout5($programCode, $request)
    {
        $repname                    = "รายการจำหน่ายยาสูบ/ยาเส้น (รต/1) กลุ่มขายพนักงาน";
        $user                       = Auth::user()->user_id;
        $approve_date               = $request['approve_date'];
        list($day, $month, $year)   = explode("/", $approve_date);
        $approve_date               = $day . "-" . $month . "-" . $year;
        $approve_date_th            = $day . "/" . $month . "/" . ($year + 543);
        $nowDateTH                  = parseToDateTh(date('Y-m-d H:i:s'));
        $dateymd                    = $year . "-" . $month . "-" . $day;
        $custypeid                  = $request['customer_type_id'];
        $column_cnt_pagebreak       = 10;

        $layout                     = 5;
        $layout_data                = [];
        $layout_data_not_bkk        = [];
        $layout_sum_groupa          = [];
        $layout_sum_groupb          = [];
        $layout_sum_groupab         = [];

        $sql = "SELECT  DISTINCT    ITEM_ID, 
                                    ITEM_DESCRIPTION, 
                                    START_DATE,
                                    END_DATE,
                                    PRODUCT_TYPE_CODE,
                                    SCREEN_NUMBER 
                        FROM    PTOM_SEQUENCE_ECOMS 
                        WHERE   to_char(start_date,'yyyy-mm-dd')<= ? 
                        AND     (to_char(end_date,'yyyy-mm-dd')>= ? OR END_DATE IS NULL) 
                        AND     SCREEN_NUMBER<> '0' 
                        AND     sale_type_code='DOMESTIC'
                        AND     product_type_code = ? 
                        ORDER BY PRODUCT_TYPE_CODE ASC, SCREEN_NUMBER ASC";

        $cigarette          = DB::select($sql, [$dateymd, $dateymd, 10]); // บุหรี่
        $rework             = DB::select($sql, [$dateymd, $dateymd, 20]); // ยาเส้น
        $column_header_span = $this->getColHeaderSpan($column_cnt_pagebreak, $cigarette, $rework);

        $CS1_rate = DB::table('ptom_uom_conversions_v')->where('uom_code', 'CS1')->pluck('conversion_rate')->first();
        $CS1_rate = $CS1_rate == null ? 1 : $CS1_rate;

        $colAs = [
            'consignment_no',
            'customer_id',
            'customer_name',
            'province_code',
            'consignment_header_id',
            'customer_type_id',
            'pick_release_no as invoice_no',

            DB::raw('sum(CASE WHEN product_type_code = 10 THEN approve_quantity ELSE 0 END) AS submitqty10'), 
            DB::raw('sum(CASE WHEN product_type_code = 10 THEN order_quantity ELSE 0 END) AS orderqty10'), 
            DB::raw('sum(CASE WHEN pick_release_no IS NOT NULL and product_type_code = 10 THEN consignment_quantity ELSE 0 END) AS actualqty10'),

            DB::raw('sum(CASE WHEN product_type_code = 10 THEN amount ELSE 0 END) AS submitamount10'),
            DB::raw('sum(CASE WHEN product_type_code = 10 THEN unit_price * order_quantity ELSE 0 END) AS orderamount10'),

            DB::raw('sum(CASE WHEN product_type_code = 20 THEN approve_quantity * (ucv.conversion_rate/ '. $CS1_rate .') ELSE 0 END) AS submitqty20'),
            DB::raw('sum(CASE WHEN product_type_code = 20 THEN order_quantity * (ucv.conversion_rate/ '. $CS1_rate .') ELSE 0 END) AS orderqty20'),
            DB::raw('sum(CASE WHEN pick_release_no IS NOT NULL and product_type_code = 20  THEN consignment_quantity * (ucv.conversion_rate/ '. $CS1_rate .') ELSE 0 END) AS actualqty20'), //8

            DB::raw('sum(CASE WHEN product_type_code = 20 THEN amount ELSE 0 END) AS submitamount20'),
            DB::raw('sum(CASE WHEN product_type_code = 20 THEN unit_price * (ucv.conversion_rate/ '. $CS1_rate .') * order_quantity ELSE 0 END) AS orderamount20'),
        ];

        foreach ($cigarette as $key => $value) {
            $colAs[] = DB::raw('sum(case when item_id = ' . $value->item_id . ' then approve_quantity else 0 end ) as a' . $value->item_id);
            $colAs[] = DB::raw('sum(case when item_id = ' . $value->item_id . ' then order_quantity else 0 end ) as o' . $value->item_id);
        }
        foreach ($rework as $key => $value) {
            $colAs[] = DB::raw('sum(case when item_id = ' . $value->item_id . ' then approve_quantity * (ucv.conversion_rate/ '. $CS1_rate .') else 0 end ) as a' . $value->item_id);
            $colAs[] = DB::raw('sum(case when item_id = ' . $value->item_id . ' then order_quantity * (ucv.conversion_rate/ '. $CS1_rate .') else 0 end ) as o' . $value->item_id);
        }

        $is_bkk         = true;
        $cust_type_arr  = [
            10 => ['ร้านค้าป.1', 'ต่างจังหวัด'],
            '30,40' => ['ฝากสโมสรยาสูบขาย', 'ฝากขาย'],
            50 => ['ร้านขายส่งยาสูบประเภท 2', 'ร้านขายส่งยาสูบประเภท 2'],
            60 => ['กทม.', 'ขายพนักงาน'],
            70 => ['ลูกค้าขายปลีก', 'ลูกค้าขายปลีก'],
            80 => ['บุหรี่ไม่คิดมูลค่า', 'บุหรี่ไม่คิดมูลค่า']
        ];

        foreach ($cust_type_arr as $cust_type => $cust_type_name) {
            if($cust_type === 60){
                $this->getDetail($layout_data, $colAs, $cigarette, $rework, $cust_type, $cust_type_name, $approve_date, $layout, $is_bkk, $CS1_rate);
            }
        }
        
        $layout_sum_groupa = [];
        foreach ($layout_data as $key1 => $layout_data_detail) {
            foreach ($layout_data_detail['sum_sec'] as $key2 => $layout_data_sum_sec) {
                foreach ($layout_data_sum_sec as $key3 => $layout_data_sum_sec_arr) {
                    foreach ($layout_data_sum_sec_arr as $key4 => $layout_data_sum_sec_value) {
                        if ($key2 != 'qty') {
                            if (!array_key_exists($key4 . $key3, $layout_sum_groupa)) {
                                $layout_sum_groupa[$key4 . $key3] = $layout_data_sum_sec_value;
                            } else {
                                $layout_sum_groupa[$key4 . $key3] += $layout_data_sum_sec_value;
                            }
                        } else {
                            if (!array_key_exists($key4, $layout_sum_groupa)) {
                                $layout_sum_groupa[$key4] = $layout_data_sum_sec_value;
                            } else {
                                $layout_sum_groupa[$key4] += $layout_data_sum_sec_value;
                            }
                        }
                    }
                }
            }
        }

        $layout_data_all = $this->rearrange_layout_data($layout_data, 
                                                        $layout_data_not_bkk, 
                                                        $layout_sum_groupa,
                                                        $layout_sum_groupb,
                                                        $layout_sum_groupab);

        $data = compact(
            'programCode',
            'user',
            'repname',
            'nowDateTH',
            'approve_date',
            'approve_date_th',
            'cigarette',
            'rework',
            'cust_type_arr',
            'column_cnt_pagebreak',
            'column_header_span',
            'layout_data_all'
        );

        $html = view('om.reports.omr0024.layout5', $data)->render();
        $mpdf = new \Mpdf\Mpdf([
            'tempDir'           => __DIR__ . '/tmp',
            'margin_left'       => 5,
            'margin_right'      => 5,
            'margin_top'        => 35,
            'margin_bottom'     => 25,
            'margin_header'     => 10,
            'format'            => 'A3-L',
            'mode'              => 'utf-8',
            'default_font'      => 'angsana',
            'margin_footer'     => 10
        ]);

        $mpdf->SetTitle("{$programCode}_5 - $repname");
        $mpdf->SetProtection(array('print'));
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($html);
        $mpdf->Output($programCode . '_5.pdf', \Mpdf\Output\Destination::INLINE);
        exit();
    }
}
