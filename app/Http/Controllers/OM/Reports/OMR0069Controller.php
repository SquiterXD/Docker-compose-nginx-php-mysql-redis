<?php

namespace App\Http\Controllers\OM\Reports;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;
use Illuminate\Support\Facades\DB;
use App\Models\OM\SoOutstandingV;
use App\Models\OM\SequenceEcoms;

class OMR0069Controller extends Controller
{
    public function export($programCode, Request $request)
    {
        $start_date = Carbon::createFromFormat('d/m/Y', $request->date_from)->format('Y-m-d');
        $end_date = Carbon::createFromFormat('d/m/Y', $request->date_to)->format('Y-m-d');

        if (!$start_date || !$end_date) {
            return abort('404');
        }

        $sql = "
            select
                a.consignment_no
                ,a.pick_release_no
                ,a.product_type_code
                ,a.product_type_desc
                ,a.customer_id
                ,a.customer_name
                ,a.item_id
                ,a.item_code
                ,b.item_description
                ,a.consignment_quantity
                ,a.consignment_amount
                ,a.retail_price operand
                --,c.operand
                ,a.base_vat
                ,a.tax_amount
                ,a.retail_amount
                ,a.retail_price
            from oaom.ptom_so_outstanding_v a
            inner join oaom.ptom_sequence_ecoms b 
            on a.item_code = b.item_code
            -- inner join oaom.ptom_price_list_line_v c 
            -- on a.item_id = c.item_id
            -- inner join oaom.ptom_price_list_head_v d 
            -- on c.list_header_id = d.list_header_id
            where
                a.consignment_status = 'Confirm'
                and b.screen_number <> '0'
                and b.sale_type_code = 'DOMESTIC'
                -- and d.price_list_id = '2'
                and (
                    case when a.consignment_date is null then 
                        to_char(a.pick_release_approve_date, 'YYYY-MM-DD')
                    else 
                        to_char(a.consignment_date, 'YYYY-MM-DD')
                    end 
                ) between '$start_date' and '$end_date'
                and b.product_type_code in ('10')
                and a.customer_type_id in ('30', '40')
            order by a.consignment_no asc
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
        ->groupBy("product_type_code");

        // dd($all_lines);

        $maxLine = 23;
        $page = 0;
        $line_num = 0;
        $data = [];

        $groupQuery = $query->groupBy([
            'consignment_no'
        ]);

        // dd($groupQuery, $all_lines);

        foreach ($groupQuery as $consignment_no => $group) {
            $item = $group->first();
            $picks = $group->pluck('pick_release_no')->unique();

            $footer = 'ใบขนเลขที่ ';
            foreach($picks as $index => $pick){
                $footer .= $index > 0 ? ', '.$item->pick_release_no : $item->pick_release_no;
            }

            foreach ($all_lines as $product_type_code => $lines) {
                foreach ($lines as $index => $line) {
                    if ($line_num >= $maxLine) {
                        $line_num = 0;
                        $page++;
                        $data[$page]['all'] = $group;
                        $data[$page]['show_sum'] = false;
                    }

                    $data[$page]['show_sum'] = false;
                    $data[$page]['title'] = 'เลขที่ '.$item->consignment_no.'<br>'. $item->customer_name;
                    $data[$page]['footer'] = $footer;
                    $data[$page]['lines'][$line->report_item_display] = $group->where('item_code', $line->item_code);
                    $line_num++;
                }

                
                $data[$page]['show_sum'] = false;
                $data[$page]['all'] = $group;
                $line_num = 0;
                $page++;
            }
            $data[$page-1]['show_sum'] = true;
        }
        // dd($data, $query);

        $pdf = PDF::loadView('om.reports.OMR0069._template', compact(
            'data',
            'start_date',
            'end_date'
        ))
        ->setPaper('a4')
        ->setOrientation('landscape')
        ->setOption('margin-bottom', 1);

        return $pdf->stream('OMR0069.pdf');
    }
}
