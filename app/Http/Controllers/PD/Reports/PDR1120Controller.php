<?php

namespace App\Http\Controllers\PD\Reports;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;
use Illuminate\Support\Facades\DB;
use App\Models\PM\PtpmPdr1120LineV;
use App\Models\PM\PtpmPdr1120HeaderV;

class PDR1120Controller extends Controller
{
    public function export($programCode, Request $request)
    {
        $start_date = Carbon::createFromFormat('d/m/Y', $request->date_from);
		$end_date = Carbon::createFromFormat('d/m/Y', $request->date_to);
		$cost_code = $request->cost_code;
		$order_type = $request->order_type;
		
		$attempt = DB::select('select OAPD.PTPD_PDR1120_RPT_S.NEXTVAL from DUAL')[0]->nextval;

		$data_headers = PtpmPdr1120HeaderV::where(function($q) use ($start_date, $end_date) {
            return $q->whereDate('product_date', '>=', $start_date)
            ->whereDate('product_date', '<=', $end_date);
		})
		->when($cost_code, function($q) use($cost_code){
			return $q->where('cost_code', $cost_code);
		})
		->when($order_type, function($q) use($order_type) {
			if($order_type == 'CT'){
				return $q->orderByRaw("cost_code asc, product_group asc, batch_no asc, item_product asc");
			}else {
				return $q->orderByRaw("product_group asc, item_product asc, batch_no asc");
			}
		})
        ->get();

        $case_transfer = DB::select("
            select transfer_wip, product_date, batch_no
            from ptpm_product_batch_v yok
            where 1=1
            and wip_step = 'WIP01'
            and product_date = (
                select max(product_date)
                from ptpm_product_batch_v
                where  batch_no = yok.batch_no
                and wip_step = 'WIP01'
                and product_date <= to_date('$request->date_from','DD/MM/YYYY')
            )
        ");

        foreach($case_transfer as $case){

            $find = $data_headers->where('batch_no', $case->batch_no)->where('product_date', $case->product_date);

            if(!$find->count() && round($case->transfer_wip, 2) > 0){
                $query = PtpmPdr1120HeaderV::whereDate('product_date', $case->product_date)
                ->where('batch_no', $case->batch_no)
                ->when($cost_code, function($q) use($cost_code){
                    return $q->where('cost_code', $cost_code);
                })
                ->when($order_type, function($q) use($order_type) {
                    if($order_type == 'CT'){
                        return $q->orderByRaw("cost_code asc, product_group asc, batch_no asc, item_product asc");
                    }else {
                        return $q->orderByRaw("product_group asc, item_product asc, batch_no asc");
                    }
                })
                ->first();

                if($query){
                    $query->receive_wip = $query->transfer_wip;
                    $query->product_qty = 0;
                    $query->loss_qty = 0;
                    $query->transfer_qty = 0;
                    $data_headers = $data_headers->push($query);
                }
                
            }
        }

        $data_headers = $data_headers->sortBy(function($item) use($order_type) {
            if($order_type == 'CT'){
                return sprintf('%s%s%s%s', $item->cost_code, $item->product_group, $item->batch_no, $item->item_product);
            }else {
                return sprintf('%s%s%s', $item->product_group, $item->item_product, $item->batch_no);
            }
        })->values();

		$batchs = $data_headers->pluck('batch_no')->unique()->values();

		$data_lines = PtpmPdr1120LineV::where(function($q) use ($start_date, $end_date) {
			return $q->whereDate('issue_date', '>=', $start_date)
			->whereDate('issue_date', '<=', $end_date);
		})
		->whereIn('batch_no', $batchs)
		->orderByRaw("batch_no asc, segment1 asc")
		->get();

		$groupHeader = $data_headers->groupBy('batch_no');

		// dd($groupHeader, $data_lines);

        $maxLine = 19;
        $line_num = 0;
        $page = 0;
        $data = [];
		foreach ($groupHeader as $batch => $headers) {
			$groupLine = $data_lines->where('batch_no', $batch);

            // $transfer = DB::select("
            //     select transfer_wip,product_date 
            //     from ptpm_product_batch_v yok
            //     where 1=1
            //     and wip_step = 'WIP01'
            //     and product_date = (
            //         select max(product_date)
            //         from ptpm_product_batch_v
            //         where batch_no = yok.batch_no
            //         and wip_step = 'WIP01'
            //         --and transfer_wip > 0
            //         and product_date <= to_date('$request->date_from','DD-MM-YYYY')
            //     )
            //     and batch_no = '$batch'
            // ");

			$groupDesc = $groupLine->groupBy('description');
			$head = $headers->where('batch_no', $batch)->first();
			$start = $headers->where('batch_no', $batch)->sortBy('product_date')->first();
            // $start->receive_wip = count($transfer) ? $transfer[0]->transfer_wip : $start->receive_wip;
			$end = $headers->where('batch_no', $batch)->sortByDesc('product_date')->first();

			if(!$groupLine->count()) {
				if($line_num >= $maxLine){
					$line_num = 0;
					$page++;
				}
				$data[$page][$batch]['groupHeader'] = $headers;
				$data[$page][$batch]['head'] = $head;
				$data[$page][$batch]['start'] = $start;
				$data[$page][$batch]['end'] = $end;
				$data[$page][$batch]['gropDesc'] = [];
				$line_num++;

				continue;
			}

            foreach ($groupDesc as $desc => $lines) {  
                if($line_num >= $maxLine){
                    $line_num = 1;
                    $page++;
                }
				foreach($lines as $line){
					$data[$page][$batch]['gropDesc'][$desc][] = $line;
				}
				$data[$page][$batch]['groupHeader'] = $headers;
				$data[$page][$batch]['head'] = $head;
				$data[$page][$batch]['start'] = $start;
				$data[$page][$batch]['end'] = $end;
                $line_num++;
            }
		}
		// dd($data);

    	$pdf = PDF::loadView('pd.reports.PDR1120._template', compact('data', 'attempt', 'start_date', 'end_date', 'order_type'))
			->setPaper('a4')
			->setOrientation('landscape')
            ->setOption('margin-top', 4)
            ->setOption('margin-left', 4)
            ->setOption('margin-right', 4)
			->setOption('margin-bottom', 4);

        return $pdf->stream($programCode. '.pdf');
    }
}
