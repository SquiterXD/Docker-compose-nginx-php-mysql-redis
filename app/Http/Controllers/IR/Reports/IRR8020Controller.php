<?php

namespace App\Http\Controllers\IR\Reports;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\IR\PtirExpenseCarGas;
use App\Models\IR\PtirExpenseStockAssets;
use App\Models\IR\PtirGlInterfaces;
use App\Models\IR\Settings\PtirAccountsMapping;

class IRR8020Controller extends Controller implements ReportInterface
{
    public function export($programCode, $search)
    {
        $period = $search->period_name;
        $status = $search->status;
        $defaultDate = date('m-d-Y', strtotime($period));
        $period_name = date('M-y', strtotime($defaultDate));
        $period_name_thai = getMonthTh(date('M', strtotime($defaultDate))).' '.convertYearToBBE(date('Y', strtotime($defaultDate)));
        $summaries = [];
        $account_mapping = [];
        $summaries = PtirGlInterfaces::selectRaw('period_name, interface_type, batch_name, account_id, account_code_combine, entered_dr, entered_cr, policy_set_header_id, je_header_id, ref_je_header_id, interface_status, group_code')
                                ->search($search, $period_name, $status)
                                ->orderBy('line_num')
                                ->get()
                                ->groupBy('je_header_id');

        $fileName = date('Ymdhms');
        $contentHtml = view('ir.reports.irr8020.main_page', compact('summaries', 'period_name_thai', 'programCode'))->render();
        return \PDF::loadHtml($contentHtml)->setOrientation('landscape')->stream($fileName.'.pdf');
    }
}
