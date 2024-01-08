<?php

namespace App\Http\Controllers\OM\Reports;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;
use Illuminate\Support\Facades\DB;
use App\Models\OM\SoOutstandingV;
use App\Models\OM\SequenceEcoms;

class OMR0125Controller extends Controller
{
    public function export($programCode, Request $request)
    {
        $budget_year = $request->budget_year;
        $request_period = $request->period;
        $request_uom_code = $request->uom_code;
        $request_uom_nomal = $request->uom_nomal;
        $request_uom_weight = $request->uom_weight;
        $customer_from = $request->customer_from;
        $customer_to = $request->customer_to;

        if (!$budget_year || !$request_uom_code || !$request_uom_nomal || !$request_uom_weight) {
            return abort('404');
        }

        $sql = "
            select min(start_period) start_period
            from ptom_period_v
            where budget_year = '$budget_year'
            order by period_no asc
        ";

        $start_period = $request_period ? Carbon::createFromFormat('Y-m', $request_period)->startOfMonth() : Carbon::parse(optional(collect(DB::select($sql))->first())->start_period)->startOfMonth();

        $sql = "
            select max(end_period) end_period
            from ptom_period_v
            where budget_year = '$budget_year'
            order by period_no asc
        ";

        $end_period = $request_period ? Carbon::createFromFormat('Y-m', $request_period)->endOfMonth() : Carbon::parse(optional(collect(DB::select($sql))->first())->end_period)->endOfMonth();

        if(!$start_period || !$end_period){
            return 'ไม่มี period';
        }

        $sql = "
            select * 
            from ptom_uom_conversions_v
            where export = 'Y'
        ";

        $uom = collect(DB::select($sql));

        $start_date = Carbon::parse($start_period)->format('Y-m-d');
        $end_date = Carbon::parse($end_period)->format('Y-m-d');
        
        $add_sql = '';
        if(!!$customer_from && !!$customer_to){
            $add_sql = "and customer_number >= '$customer_from' and customer_number <= '$customer_to'";
        }elseif(!!$customer_from) {
            $add_sql = "and customer_number >= '$customer_from'";
        }elseif(!!$customer_to) {
            $add_sql = "and customer_number <= '$customer_to'";
        }

        $sql = "
            select 
                pick_release_no
                ,product_type_code
                ,customer_number
                ,customer_name
                ,item_code
                ,item_description
                ,sum(convert_uom) quantity
                ,to_unit uom
                ,trunc(pick_exchange_date) pick_release_approve_date
                ,sum(line_amount) amount
            from ptom_so_outstanding_exp_v V
            where trunc(pick_exchange_date)
            between to_date('$start_date', 'YYYY-MM-DD')
            and to_date('$end_date', 'YYYY-MM-DD')
            $add_sql
            group by pick_release_no, product_type_code, customer_number, customer_name, item_code, item_description, to_unit, pick_exchange_date
            order by customer_number asc, product_type_code asc, pick_exchange_date asc, pick_release_no asc
        ";

        $query = collect(DB::select($sql));

        // dd($query, $start_date, $end_date, $sql);

        $maxLine = 16;
        $page = 0;
        $line_num = 0;
        $data = [];

        $groupQuery = $query->groupBy([
            function($item){
                return in_array($item->product_type_code, ['10', '20']) ? $item->product_type_code : 0;
            }
        ]);
        
        // dd($groupQuery);
        foreach ($groupQuery as $product_type_code => $group) {

            if(in_array($product_type_code, ['10']))
                $request_uom = $uom->where('uom_code', $request_uom_code)->first();
            elseif(in_array($product_type_code, ['20'])){
                $request_uom = $uom->where('uom_code', $request_uom_nomal)->first();
            }else {
                $request_uom = $uom->where('uom_code', $request_uom_weight)->first();
            }

            $all_headers = $group->pluck('item_description', 'item_code')->sort();
            $groupPick = $group->groupBy(['pick_release_no']);

            foreach ($groupPick as $pick_release_no => $items) {

                $data[$page]['all_headers'] = $all_headers;
                $data[$page]['uom'] = $request_uom->unit_of_measure;
                $item = optional($items->first());
                $customer_number = $item->customer_number;
                $customer = optional(collect(DB::select("
                    select * from ptom_customers
                    where customer_number = '$customer_number'
                "))->first());

                foreach ($items as $index => $line) {

                    if($request_uom->uom_code != $line->uom){
                        $base = $uom->where('base_unit_code', $request_uom->base_unit_code)->first();
                        $line_uom = $uom->where('uom_code', $line->uom)->first();
                        $line->quantity = $line->quantity * $line_uom->conversion_rate / $request_uom->conversion_rate;
                    }

                    if($line_num >= $maxLine){
                        $line_num = 0;
                        $page++;
                        $data[$page]['all_headers'] = $all_headers;
                        $data[$page]['uom'] = $request_uom->unit_of_measure;
                    }

                    foreach($all_headers as $item_code => $desc){

                        $data[$page]['lines'][$pick_release_no]['headers'][$item_code] = $items->where('item_code', $item_code);
                    }

                    $data[$page]['lines'][$pick_release_no]['customer_number'] = $item->customer_number;
                    $data[$page]['lines'][$pick_release_no]['customer_name'] = $item->customer_name;
                    $data[$page]['lines'][$pick_release_no]['country_name'] = $customer->country_name;
                    $data[$page]['lines'][$pick_release_no]['pick_release_approve_date'] = $item->pick_release_approve_date;
                    $data[$page]['lines'][$pick_release_no]['data'] = $items;
                    $data[$page]['lines'][$pick_release_no]['show_sum'] = false;
                }

                $line_num++;
            }

            $page++;
            $line_num = 0;
        }

        // dd($data, $query);

        $pdf = PDF::loadView('om.reports.OMR0125._template', compact(
            'data',
            'start_date',
            'end_date',
            'uom'
        ))
        ->setPaper('a4')
        ->setOrientation('landscape')
        ->setOption('margin-bottom', 1);

        return $pdf->stream('OMR0125.pdf');
    }
}
