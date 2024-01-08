<?php

namespace App\Http\Controllers\CT\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\CT\CTRP0097;
use App\Models\CT\PtctMfgBatchGenWipend;

class CTRP0097Controller extends Controller
{
    public function exportExcel($programCode , $request)
    {
        $dateS = \Carbon\Carbon::createFromFormat('d/m/Y', $request->date_start)->format('d-M-y');
        $dateE = \Carbon\Carbon::createFromFormat('d/m/Y', $request->date_end)->format('d-M-y');
        $tDate = ctDateText($request->date_start, $request->date_end);
        $mfgBatchGenWipendsAll = PtctMfgBatchGenWipend::selectField()
                                ->when($request->date_start, function($q) use ($dateS,$dateE){
                                    $q->whereRaw(" to_date(ct_accounting_date, 'DD-Mon-YY') BETWEEN  to_date('".$dateS."', 'DD-Mon-YY')  AND to_date('".$dateE."', 'DD-Mon-YY')");
                                })
                                ->where('ct_cc_code', $request->ct_cc_code)
                                ->when($request->ct_dept_code, function($q) use ($request) {
                                    $q->where('ct_dept_code', $request->ct_dept_code);
                                })
                                ->get();

        $mfgBatchGenWipends  = $mfgBatchGenWipendsAll
                                ->sortBy('ct_product_code')
                                ->groupBy('ct_product_code');
        $mfgBatchHeader = $mfgBatchGenWipendsAll->first() ?? new PtctMfgBatchGenWipend;

        // return view('ct.reports.ctrp0097.excel.index', compact('mfgBatchGenWipends', 'mfgBatchHeader',  'tDate'));
        return \Excel::download(new CTRP0097, $programCode.'.xlsx');
    }
}
