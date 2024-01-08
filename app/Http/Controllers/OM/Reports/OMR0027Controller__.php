<?php

namespace App\Http\Controllers\OM\Reports;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;
use Illuminate\Support\Facades\DB;
use App\Models\OM\SoOutstandingV;
use App\Models\OM\SequenceEcoms;

class OMR0027Controller extends Controller
{
    public function export($programCode, Request $request)
    {
        $start_date = Carbon::createFromFormat('d/m/Y', $request->date_from)->format('Y-m-d');
        $end_date = Carbon::createFromFormat('d/m/Y', $request->date_to)->format('Y-m-d');
        $remark = $request->remark;

        if (!$start_date || !$end_date) {
            return abort('404');
        }
        $getRMA = (new OMR0060Controller)->getRMA(['start'=> $start_date, 'end' => $end_date]);

        // $tax_payer_id = DB::table('ptom_toat_address_v')->first('tax_payer_id')->tax_payer_id;

        $query = SoOutstandingV::selectRaw("
            (CASE WHEN ptom_customers.customer_type_id = 80 THEN 'บุหรี่/ยาเส้นไม่มีมูลค่า' ELSE ptom_customers.attribute10 END) attribute10
            ,ptom_customers.region_code
            ,ptom_so_outstanding_v.customer_id
            ,ptom_so_outstanding_v.customer_type_id
            ,ptom_so_outstanding_v.customer_name
            ,ptom_customers.market
            ,ptom_so_outstanding_v.item_id
            ,ptom_so_outstanding_v.item_code
            ,ptom_sequence_ecoms.report_item_display
            ,ptom_sequence_ecoms.screen_number
            ,ptom_sequence_ecoms.product_type_code
            ,sum(ptom_so_outstanding_v.approve_quantity) as approve_quantity
            ,sum(ptom_so_outstanding_v.amount) as amount
            ,sum(ptom_so_outstanding_v.consignment_quantity) as consignment_quantity
            ,sum(ptom_so_outstanding_v.consignment_amount) as consignment_amount
            ,(case when ptom_customers.province_name = ptom_customers.market then
                0
            else
                1
            end) p_order
        ")
        ->join('ptom_customers', 'ptom_customers.customer_id', '=', 'ptom_so_outstanding_v.customer_id')
        ->join('ptom_sequence_ecoms', 'ptom_sequence_ecoms.item_id', '=', 'ptom_so_outstanding_v.item_id')
        ->whereRaw("
            (
                nvl(trunc(ptom_so_outstanding_v.consignment_date), trunc(ptom_so_outstanding_v.pick_release_approve_date)) 
                between to_date('$start_date', 'YYYY-MM-DD')
                and to_date('$end_date', 'YYYY-MM-DD')
            )
            and ptom_sequence_ecoms.screen_number <> '0'
            and upper(ptom_sequence_ecoms.sale_type_code) = 'DOMESTIC'
        ")
        ->groupByRaw("
            (CASE WHEN ptom_customers.customer_type_id = 80 THEN 'บุหรี่/ยาเส้นไม่มีมูลค่า' ELSE ptom_customers.attribute10 END)
            ,ptom_customers.region_code
            ,ptom_so_outstanding_v.customer_id
            ,ptom_so_outstanding_v.customer_type_id
            ,ptom_so_outstanding_v.customer_name
            ,ptom_customers.province_name
            ,ptom_customers.market
            ,ptom_so_outstanding_v.item_id
            ,ptom_so_outstanding_v.item_code
            ,ptom_sequence_ecoms.report_item_display
            ,ptom_sequence_ecoms.screen_number
            ,ptom_sequence_ecoms.product_type_code
        ")
        ->orderByRaw("
            (CASE WHEN ptom_customers.customer_type_id = 80 THEN 'บุหรี่/ยาเส้นไม่มีมูลค่า' ELSE ptom_customers.attribute10 END) desc nulls last
            ,ptom_customers.region_code asc
            ,ptom_customers.province_name asc
            ,p_order asc
            ,ptom_customers.market asc
            ,ptom_so_outstanding_v.customer_id asc
            ,ptom_sequence_ecoms.screen_number asc
            ,ptom_sequence_ecoms.product_type_code asc
        ")
        ->get()
        ->groupBy([
            function ($item) {
                return $item->attribute10 ?? $item->region_code;
            },
        ]);

        $all_headers = SequenceEcoms::whereRaw("
            upper(sale_type_code) = 'DOMESTIC'
        ")->orderByRaw("
            product_type_code asc
            ,screen_number asc
        ")
            ->pluck("report_item_display");


        // จัด columns ใหม่
        // $all_headers = $all_headers->sortBy(function ($all_headers) {
        //     switch ($all_headers) {
        //         case 'กรุงทอง 90':
        //             return 0;
        //             break;
        //         case 'กรองทิพย์ 90':
        //             return 1;
        //             break;
        //         case 'สายฝน 90':
        //             return 2;
        //             break;
        //         case 'SMS (สีแดง)':
        //             return 3;
        //             break;
        //         case 'SMS (สีเขียว)':
        //             return 4;
        //             break;
        //         case 'สามิต 90':
        //             return 5;
        //             break;
        //         case 'Goal (สีแดง)':
        //             return 6;
        //             break;
        //         case 'Goal (สีเขียว)':
        //             return 7;
        //             break;
        //         case 'LINE 7.1 (สีแดง)':
        //             return 8;
        //             break;
        //         case 'LINE 7.1 (สีเขียว)':
        //             return 9;
        //             break;
        //         case 'LINE (สีแดง)':
        //             return 10;
        //             break;
        //         case 'LINE (สีเขียว)':
        //             return 11;
        //             break;
        //         case 'WONDER S (สีแดง)':
        //             return 12;
        //             break;
        //         case 'WONDER S (สีเขียว)':
        //             return 13;
        //             break;
        //         case 'KRONG THIP 7.1 S':
        //             return 14;
        //             break;
        //         case 'WONDER (สีแดง)':
        //             return 15;
        //             break;
        //         case 'KRONG THIP 7.1 (ซองแดง)':
        //             return 16;
        //             break;
        //         case 'WONDER (สีเขียว)':
        //             return 17;
        //             break;
        //         case 'KNIGHT (Blue)':
        //             return 18;
        //             break;
        //         case 'TUK TUK':
        //             return 19;
        //             break;
        //         case 'LINE':
        //             return 20;
        //             break;
        //         case 'อีแต๋น 1':
        //             return 21;
        //             break;
        //         case 'อีแต๋น 2':
        //             return 22;
        //             break;

        //         default:
        //             return $all_headers;
        //             break;
        //     }
        //     return $all_headers;
        // });

        $maxLine = 22;
        $page = 0;
        $line_num = 0;
        $data = [];

        foreach ($query as $region => $items) {

            $groupHeader = $all_headers; // $items->pluck("report_item_display")->unique()->values();

            $groupMarket = $items->groupBy("market");

            $count_header = $groupHeader->count();

            $chunk = ($count_header + 5) > 13 ? (ceil(($count_header + 5) / ceil(($count_header + 5) / 13))) : ($count_header + 5);

            $chunkData = $groupHeader->chunk($chunk);

            $count_chunk = $chunkData->count();

            foreach ($groupMarket as $market => $groupM) {
                if ($line_num >= $maxLine) {
                    $line_num = 0;
                    $page = $page + $count_chunk;
                }
                $line_num++;
                foreach ($groupM->sortBy('customer_name')->groupBy("customer_name") as $customer_name => $group) {
                    if ($line_num >= $maxLine) {
                        $line_num = 1;
                        $page = $page + $count_chunk;
                    }

                    foreach ($chunkData as $loop => $headers) {
                        foreach ($headers as $item_desc) {
                            $data[$page + $loop][$region]['lines'][$market][$customer_name][$item_desc] = $group->where("report_item_display", $item_desc)->values();
                        }

                        $data[$page + $loop][$region]['datas'] = $items;
                        $data[$page + $loop][$region]['header'] = $headers;
                        $data[$page + $loop][$region]['last_page'] = ($loop + 1) == $count_chunk;
                        $data[$page + $loop][$region]['show_sum'] = false;
                    }
                    $line_num++;
                }
            }
            foreach ($chunkData as $loop => $headers) {
                $data[$page + $loop][$region]['show_sum'] = true;
            }
            $page = $page + $count_chunk;
            $line_num = 0;
        }

        // dd($data);

        $pdf = PDF::loadView('om.reports.OMR0027._template', compact(
            'data',
            'start_date',
            'end_date',
            'remark',
            'all_headers',
            'getRMA',
        ))
        ->setPaper('a4')
        ->setOrientation('landscape')
        ->setOption('margin-bottom', 1);

        return $pdf->stream('OMR0027.pdf');
    }
}
