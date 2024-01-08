<?php

namespace App\Http\Controllers\OM\Reports;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;
use Illuminate\Support\Facades\DB;
use App\Models\OM\Consignment;

class OMR0079Controller extends Controller
{
    public function export($programCode, Request $request)
    {
        $start_date = Carbon::createFromFormat('d/m/Y', $request->date_from);
		$end_date = Carbon::createFromFormat('d/m/Y', $request->date_to);
        $remark = $request->remark;

        if(!$start_date || !$end_date){
            return abort('404'); 
        }
        
        $tax_payer_id = DB::table('ptom_toat_address_v')->first('tax_payer_id')->tax_payer_id;

        $query_date = Consignment::selectRaw('customer_id, max(consignment_date) as consignment_date')
        ->whereRaw("UPPER(consignment_status) = UPPER('Confirm')")
        ->where(function($q) use ($start_date, $end_date) {
			return $q->whereDate('consignment_date', '>=', $start_date)
			->whereDate('consignment_date', '<=', $end_date);
		})
        ->groupByRaw('customer_id')
        ->orderByRaw("consignment_date asc")
        ->distinct()
        ->get();

        $query = Consignment::whereRaw("UPPER(consignment_status) = UPPER('Confirm')")
        ->where(function($q) use ($start_date, $end_date) {
			return $q->whereDate('consignment_date', '>=', $start_date)
			->whereDate('consignment_date', '<=', $end_date);
		})
        ->orderByRaw("customer_id asc, consignment_date asc")
        ->get()
        ->groupBy('customer_id');

        // dd($query, $query_date);
        
        $maxLine = 15;
        $page = 0;
        $line_num = 0;
        $data = [];

        foreach ($query_date as $key => $i) {

            $item = $query[$i->customer_id]->where('consignment_date', $i->consignment_date)->first();
            if($line_num >= $maxLine){
                $line_num = 0;
                $page++;
            }

            $data[$page][] = $item;
            $line_num++;
        }

        // dd($data);

        $pdf = PDF::loadView('om.reports.OMR0079._template', compact(
            'data',
            'start_date',
            'end_date',
            'remark',
            'tax_payer_id'
        ))
        ->setPaper('a4')
        ->setOrientation('landscape')
        ->setOption('margin-bottom', 0);

        return $pdf->stream('OMR0078.pdf');
    }
}
