<?php

namespace App\Http\Controllers\OM;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\OM\TranspotModel;
use Carbon\Carbon;

class TranspotReportController extends Controller
{
    public function index()
    {
        $owners = TranspotModel::where('stop_flag', '<>', 'Y')->where(function ($q) {
            $q->where('start_date', '<=', Carbon::now()->format('Y-m-d'))->where('end_date', '>=', Carbon::now()->format('Y-m-d'))->orWhereNull('end_date');
        })->get(['vendor_code', 'transport_owner_name']);

        $invoiceBatchs = DB::select("SELECT DISTINCT INVOICE_BATCH, INVOICE_DATE FROM  PTOM_AP_INTERFACES WHERE (INTERFACE_STATUS != ? OR INTERFACE_STATUS IS NULL) AND FROM_PROGRAM_CODE = ? ORDER BY INVOICE_DATE DESC, INVOICE_BATCH DESC", ['C', 'OMP0042']);

        return view('om.transpot_report.index', compact('owners', 'invoiceBatchs'));
    }
}
