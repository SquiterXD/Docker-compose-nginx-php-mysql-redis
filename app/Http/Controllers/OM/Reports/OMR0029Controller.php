<?php

namespace App\Http\Controllers\OM\Reports;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;
use Illuminate\Support\Facades\DB;
use App\Models\OM\SoOutstandingV;
use App\Models\OM\SequenceEcoms;

class OMR0029Controller extends Controller
{
    public function export($programCode, Request $request)
    {
        $start_date = Carbon::createFromFormat('d/m/Y', $request->date_from)->format('Y-m-d');
		$end_date   = Carbon::createFromFormat('d/m/Y', $request->date_to)->format('Y-m-d');
        $remark     = $request->remark;

        if(!$start_date || !$end_date){
            return abort('404'); 
        }
        
        $query = SoOutstandingV::selectRaw("
            ptom_customers.attribute10
            ,ptom_customers.region_code
            ,ptom_so_outstanding_v.customer_id
            ,ptom_so_outstanding_v.customer_type_id
            ,ptom_so_outstanding_v.customer_name
            ,ptom_so_outstanding_v.item_id
            ,ptom_so_outstanding_v.item_code
            ,ptom_sequence_ecoms.report_item_display
            ,ptom_sequence_ecoms.screen_number
            ,ptom_sequence_ecoms.product_type_code
            ,sum(ptom_so_outstanding_v.approve_quantity) as approve_quantity
            ,sum(ptom_so_outstanding_v.amount) as amount
            ,sum(ptom_so_outstanding_v.consignment_quantity) as consignment_quantity
            ,sum(ptom_so_outstanding_v.consignment_amount) as consignment_amount
        ")
        ->join('ptom_customers', 'ptom_customers.customer_id', '=', 'ptom_so_outstanding_v.customer_id')
        ->join('ptom_sequence_ecoms', 'ptom_sequence_ecoms.item_id', '=', 'ptom_so_outstanding_v.item_id')
        ->whereRaw("
            (
                nvl(trunc(ptom_so_outstanding_v.consignment_date), trunc(ptom_so_outstanding_v.pick_release_approve_date)) 
                between to_date('$start_date', 'YYYY-MM-DD')
                and to_date('$end_date', 'YYYY-MM-DD')
            )
            and (
                ptom_so_outstanding_v.customer_type_id <> '80'  
            )
            and ptom_sequence_ecoms.screen_number <> '0'
            and upper(ptom_sequence_ecoms.sale_type_code) = 'DOMESTIC'
        ")
        ->groupByRaw("
            ptom_customers.attribute10
            ,ptom_customers.region_code
            ,ptom_so_outstanding_v.customer_id
            ,ptom_so_outstanding_v.customer_type_id
            ,ptom_so_outstanding_v.customer_name
            ,ptom_so_outstanding_v.item_id
            ,ptom_so_outstanding_v.item_code
            ,ptom_sequence_ecoms.report_item_display
            ,ptom_sequence_ecoms.screen_number
            ,ptom_sequence_ecoms.product_type_code
        ")
        ->orderByRaw("
            ptom_customers.attribute10 desc nulls last
            ,ptom_customers.region_code asc
            ,ptom_so_outstanding_v.customer_id asc
            ,ptom_sequence_ecoms.screen_number asc
            ,ptom_sequence_ecoms.product_type_code asc
        ")
        ->get();

        $groupLines = SequenceEcoms::selectRaw("
            report_item_display
            ,product_type_code
            ,screen_number
        ")->whereRaw("
            upper(sale_type_code) = 'DOMESTIC'
        ")->orderByRaw("
            screen_number asc
            ,product_type_code asc
        ")
        ->get()
        ->groupBy("product_type_code");
        $maxLine    = 23;
        $page       = 0;
        $data       = [];

        $groupHeader = $query
        ->groupBy([
            function ($item) {
                return $item->attribute10 ?? $item->region_code;
            },
        ]);

        $all_headers    = $groupHeader->keys();
        $count_header   = $groupHeader->count();
        $chunk          = ($count_header+2) > 10 ? ( ceil(($count_header+2)/ceil(($count_header+2)/10)) ) : ($count_header+2);
        $chunkData      = $groupHeader->chunk($chunk);
        $count_chunk    = $chunkData->count();
        foreach ($groupLines as $type => $all_lines) {
            $line_num   = 0;
            $count_lines = $all_lines->count();
            foreach ($all_lines as $index => $line) {
                if($line_num >= $maxLine){
                    $line_num = 0;
                    $page = $page+$count_chunk;

                }

                foreach ($chunkData as $loop => $headers) {
                    foreach($headers as $header => $items){
                        $data[$page+$loop]['lines'][$line->report_item_display][$header] = $items->where("report_item_display", $line->report_item_display)->values();
                    }
                    $data[$page+$loop]['datas']             = $items;
                    $data[$page+$loop]['header']            = $headers->keys();
                    $data[$page+$loop]['last_page']         = ($loop+1) == $count_chunk;
                    $data[$page+$loop]['show_sum']          = false;
                    $data[$page+$loop]['product_type_code'] = $type;
                }

                if($count_lines == $index+1){
                    foreach ($chunkData as $loop => $headers) {
                        $data[$page+$loop]['show_sum'] = true;
                    }
                }
                $line_num++;
            }
            $page++;
        }

        $pdf = PDF::loadView('om.reports.OMR0029._template', compact(
            'data',
            'start_date',
            'end_date',
            'remark',
            'all_headers'
        ))
        ->setPaper('a4')
        ->setOrientation('landscape')
        ->setOption('margin-bottom', 1);

        return $pdf->stream('OMR0029.pdf');
    }
}
