<?php

namespace App\Http\Controllers\OM\Reports;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;
use Illuminate\Support\Facades\DB;
use App\Models\OM\SoOutstandingV;
use App\Models\OM\DebtDomV;

class OMR0088Controller extends Controller
{
    public function export($programCode, Request $request)
    {
        $start_date = Carbon::createFromFormat('d/m/Y', $request->date_from);
		$end_date = Carbon::createFromFormat('d/m/Y', $request->date_to);
        $remark = $request->remark;
        $getRMA = (new OMR0060Controller)->getRMA(['start'=> $start_date->format('Y-m-d'), 'end' => $end_date->format('Y-m-d')]);

        if(!$start_date || !$end_date){
            return abort('404'); 
        }
        
        // $tax_payer_id = DB::table('ptom_toat_address_v')->first('tax_payer_id')->tax_payer_id;

        $query_Date = SoOutstandingV::selectRaw("
            distinct (case when customer_type_id in ('30', '40') and product_type_code in ('10')  then 
                consignment_date
            else 
                pick_release_approve_date
            end) doc_date
        ")
        ->where(function($q) use ($start_date, $end_date) {
            return $q->where(function($p) use ($start_date, $end_date) {
                return $p->where(function($r) use ($start_date, $end_date){
                    $start = $start_date->format('Y-m-d');
                    $end = $end_date->format('Y-m-d');
                    return $r->whereRaw(" 
                        to_char(pick_release_approve_date, 'YYYY-MM-DD') >= '$start'
                        and to_char(pick_release_approve_date, 'YYYY-MM-DD') <= '$end'
                    ");
                })
                ->whereRaw("
                    order_header_id not in (
                        select distinct order_header_id
                        from ptom_so_outstanding_v
                        where 1=1
                        and customer_type_id in ('30', '40')
                        and product_type_code in ('10')
                    )
                ");
            })
            ->orWhere(function($p) use ($start_date, $end_date) {
                return $p->where(function($r) use ($start_date, $end_date){
                    $start = $start_date->format('Y-m-d');
                    $end = $end_date->format('Y-m-d');
                    return $r->whereRaw(" 
                        to_char(consignment_date, 'YYYY-MM-DD') >= '$start'
                        and to_char(consignment_date, 'YYYY-MM-DD') <= '$end'
                    ");
                })
                ->whereRaw("
                    customer_type_id in ('30', '40')
                    and product_type_code in ('10')
                ");
            });
		})
        ->orderBy('doc_date')
        ->pluck('doc_date');
        
        $maxLine = 18;
        $page = 0;
        $line_num = 0;
        $data = [];

        foreach ($query_Date as $doc_date) {
            if($line_num >= $maxLine){
                $line_num = 0;
                $page++;
            }

            $date = Carbon::parse($doc_date)->format('Y-m-d');

            $case_credit_2 = DebtDomV::where('credit_group_code', '2')
            ->whereDate('pick_release_approve_date', $date)
            ->sum('debt_amount');

            $case_credit_3 = DebtDomV::where('credit_group_code', '3')
            ->whereDate('pick_release_approve_date', $date)
            ->sum('debt_amount');

            $case_consign_bkk = DebtDomV::where('credit_group_code', '0')
            ->whereIn('customer_type_id', ['30'])
            ->whereIn('product_type_code', ['10'])
            ->whereDate('consignment_date', $date)
            ->sum('debt_amount');

            $case_consign_region = DebtDomV::where('credit_group_code', '0')
            ->whereIn('customer_type_id', ['40'])
            ->whereIn('product_type_code', ['10'])
            ->whereDate('consignment_date', $date)
            ->sum('debt_amount');

            $case_cig = DebtDomV::where('credit_group_code', '0')
            ->whereNotIn('customer_type_id', ['30', '40', '80'])
            ->whereIn('product_type_code', ['10'])
            ->whereDate('pick_release_approve_date', $date)
            ->sum('debt_amount');

            $case_tobacco = DebtDomV::where('credit_group_code', '0')
            ->whereIn('product_type_code', ['20'])
            ->whereDate('pick_release_approve_date', $date)
            ->sum('debt_amount');

            $case_total = $case_credit_2 + $case_credit_3 + $case_consign_bkk + $case_consign_region + $case_cig + $case_tobacco;

            $case_cig_con_qty = SoOutstandingV::whereIn('customer_type_id', ['30', '40'])
            ->whereNotIn('customer_type_id', ['80'])
            ->whereIn('product_type_code', ['10'])
            ->where(function($q) use ($date){
                return $q->whereDate('consignment_date', $date);
            })
            ->sum('consignment_quantity');

            $case_cig_not_con_qty = SoOutstandingV::whereNotIn('customer_type_id', ['30', '40' ,'80'])
            ->whereIn('product_type_code', ['10'])
            ->where(function($q) use ($date){
                return $q->whereDate('pick_release_approve_date', $date);
            })
            ->sum('approve_quantity');

            $case_cig_qty = $case_cig_con_qty + $case_cig_not_con_qty;

            $case_tobacco_qty = SoOutstandingV::whereNotIn('customer_type_id', ['80'])
            ->whereIn('product_type_code', ['20'])
            ->whereDate('pick_release_approve_date', $date)
            ->sum('approve_quantity');

            $item = collect([
                "date" => $date,
                "credit_2_amt" => $case_credit_2,
                "credit_3_amt" => $case_credit_3,
                "consign_bkk_amt" => $case_consign_bkk,
                "consign_region_amt" => $case_consign_region,
                "cig_amt" => $case_cig,
                "tobacco_amt" => $case_tobacco,
                "total_amt" => $case_total,
                "cig_qty" => $case_cig_qty,
                "tobacco_qty" => $case_tobacco_qty
            ]);
            
            $data[$page][] = $item;
            $line_num++;
        }

        $pdf = PDF::loadView('om.reports.OMR0088._template', compact(
            'data',
            'start_date',
            'end_date',
            'remark',
            'getRMA'
        ))
        ->setPaper('a4')
        ->setOrientation('landscape')
        ->setOption('margin-bottom', 0);

        return $pdf->stream('OMR0088.pdf');
    }
}
