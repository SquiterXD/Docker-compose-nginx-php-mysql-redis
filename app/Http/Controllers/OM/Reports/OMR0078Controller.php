<?php

namespace App\Http\Controllers\OM\Reports;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;
use Illuminate\Support\Facades\DB;
use App\Models\OM\Consignment;

class OMR0078Controller extends Controller
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

        $query = Consignment::whereRaw("UPPER(consignment_status) = UPPER('Confirm')")
        ->whereHas('customer', function($q){
            return $q->whereIn('customer_type_id', [30]);
        })
        ->where(function($q) use ($start_date, $end_date) {
			return $q->whereDate('consignment_date', '>=', $start_date)
			->whereDate('consignment_date', '<=', $end_date);
		})
        ->orderByRaw("consignment_date asc")
        ->get();
        
        $maxLine = 15;
        $page = 0;
        $line_num = 0;
        $data = [];

        foreach ($query as $key => $item) {
            if($line_num >= $maxLine){
                $line_num = 0;
                $page++;
            }
            
            $data[$page][] = $item;
            $line_num++;
        }

        // dd($data);

        $pdf = PDF::loadView('om.reports.OMR0078._template', compact(
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
