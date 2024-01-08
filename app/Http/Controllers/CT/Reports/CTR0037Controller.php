<?php

namespace App\Http\Controllers\CT\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use App\Models\CT\PtctCtr0037;
use App\Models\CT\PtPeriodsV;
use Maatwebsite\Excel\Facades\Excel;

class CTR0037Controller extends Controller
{
    public function CTR0037Export($programCode, $request)
    {
        $period = PtPeriodsV::where('period_name', $request->period_name)->first();
        $endDate = date('d-M-Y', strtotime($period->end_date));
        $header = (new PtctCtr0037)->getCigaretteHeader($endDate);
        $cigaretteDetails = (new PtctCtr0037)->getCigaretteDetail($endDate);

        $cigarettes = $cigaretteDetails->groupBy('item_code')->mapWithKeys(function ($item, $group) {
            $groupName = $item->first()->item_code;
            return [$groupName => $item->pluck('sum_actual_quantity', 'customer_type_id')->all()];
        })->toArray();


        // return view('ct.Reports.ctr0037.index',compact('header', 'cigarettes'))->render();

        $pdf = PDF::loadView('ct.Reports.ctr0037.index',compact('header', 'cigarettes', 'programCode', 'period'))
                        ->setPaper('a4')
                        ->setOption('margin-bottom', 10);

        return $pdf->stream($programCode. '.pdf');
    }
}
