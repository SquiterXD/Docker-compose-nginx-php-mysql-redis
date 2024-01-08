<?php

namespace App\Http\Controllers\OM\Reports;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;
use Illuminate\Support\Facades\DB;
use App\Models\OM\SoOutstandingV;
use App\Models\OM\SequenceEcoms;
use Str;
class OMR0026Controller extends Controller
{
    public function export($programCode, Request $request)
    {
        $start_date = Carbon::createFromFormat('d/m/Y', $request->date_from)->format('Y-m-d');
        $end_date = Carbon::createFromFormat('d/m/Y', $request->date_to)->format('Y-m-d');
        $remark = $request->remark;
        $getRMA = (new OMR0060Controller)->getRMA(['start'=> $start_date, 'end' => $end_date]);
        $getRMA = $getRMA->map(function($i) {
            $dayTxt = Str::upper(Carbon::createFromFormat('Y-m-d H:i:s', $i->invoice_date)->format('D'));
            $i->dayTxt = $dayTxt;
            $i->lines = $i->lines->map(function($c) use($dayTxt){
                $c->dayTxt = $dayTxt;
                return $c;
            });
            return $i;
        });
        if (!$start_date || !$end_date) {
            return abort('404');
        }

        $sql = "
            select 
                to_char(pick_release_approve_date, 'YYYY-MM-DD') pick_release_approve_date
                ,to_char(pick_release_approve_date, 'DY') day_of_week
                ,customer_type_meaning as customer_group
                ,product_type_code
                ,item_code
                ,item_description
                ,sum(approve_quantity) as qty
                ,sum(amount) as amount
            from ptom_so_outstanding_v
            where 1=1
            and customer_type_id not in ('30', '40', '80')
            and product_type_code in ('10', '20')
            and trunc(pick_release_approve_date) between to_date('$start_date', 'YYYY-MM-DD') and to_date('$end_date', 'YYYY-MM-DD')
            group by
                pick_release_approve_date
                ,customer_type_meaning
                ,item_code
                ,item_description
                ,product_type_code
            union
            select
                to_char(consignment_date, 'YYYY-MM-DD') pick_release_approve_date
                ,to_char(consignment_date, 'DY') day_of_week
                ,customer_type_desc as customer_group
                ,product_type_code
                ,item_code
                ,item_description
                ,sum(consignment_quantity) as qty
                ,sum(consignment_amount) as amount
            from ptom_so_outstanding_v
            where 1=1
            and customer_type_id in ('30', '40')
            and product_type_code in ('10')
            and trunc(consignment_date) between to_date('$start_date', 'YYYY-MM-DD') and to_date('$end_date', 'YYYY-MM-DD')
            group by
                consignment_date
                ,customer_type_desc
                ,item_code
                ,item_description
                ,product_type_code
            union
            select
                to_char(pick_release_approve_date, 'YYYY-MM-DD') pick_release_approve_date
                ,to_char(pick_release_approve_date, 'DY') day_of_week
                ,customer_type_meaning as customer_group
                ,product_type_code
                ,item_code
                ,item_description
                ,sum(approve_quantity) as qty
                ,sum(amount) as amount
            from ptom_so_outstanding_v
            where 1=1
            and customer_type_id in ('30', '40')
            and product_type_code in ('20')
            and trunc(pick_release_approve_date) between to_date('$start_date', 'YYYY-MM-DD') and to_date('$end_date', 'YYYY-MM-DD')
            group by
                pick_release_approve_date
                ,customer_type_meaning
                ,item_code
                ,item_description
                ,product_type_code
        ";

        $query = collect(DB::select($sql));
        // dd($query, $sql);

        $all_lines = SequenceEcoms::whereRaw("
            upper(sale_type_code) = 'DOMESTIC'
        ")->orderByRaw("
            product_type_code asc
            ,screen_number asc
        ")
        ->selectRaw('screen_number, sale_type_code, product_type_code, report_item_display, item_code')
        ->get()
        ->groupBy(['product_type_code']);

        // dd($query->groupBy(['product_type_code', 'day_of_week', 'item_code']));

        $headers = [
            'MON' => 'จันทร์',
            'TUE' => 'อังคาร',
            'WED' => 'พุธ',
            'THU' => 'พฤหัส',
            'FRI' => 'ศุกร์',
        ];

        // dd($all_lines);

        $maxLine = 22;
        $page = 0;
        $line_num = 0;
        $data = [];

        foreach ($all_lines as $product_type => $lines) {

            foreach ($lines as $index => $line) {
                if ($line_num >= $maxLine) {
                    $line_num = 0;
                    $page++;
                }

                $data[$page]['lines'][$line->report_item_display] = $query->where('item_code', $line->item_code);
                $line_num++;
            }

            $data[$page]['all'] = $query->where('product_type_code', $line->product_type_code);
            $data[$page]['product_type_code'] = $line->product_type_code;

            $page++;
            $line_num = 0;
        }
        // dd($data);

        $pdf = PDF::loadView('om.reports.OMR0026._template', compact(
            'data',
            'start_date',
            'end_date',
            'remark',
            'headers',
            'getRMA',
        ))
        ->setPaper('a4')
        ->setOrientation('landscape')
        ->setOption('margin-bottom', 1);

        return $pdf->stream('OMR0026.pdf');
    }
}
