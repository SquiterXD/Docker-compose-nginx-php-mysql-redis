<?php

namespace App\Http\Controllers\IR\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IRR2030AController extends Controller
{
    public function export($programCode, $request)
    {
        dd($programCode, $request);
        $period = $search->period_name;
        $defaultDate = date('m-d-Y', strtotime($period));
        $period_name = date('M-Y', strtotime($defaultDate));
        $period_name_thai = getMonthTh(date('M', strtotime($defaultDate))).' '.convertYearToBBE(date('Y', strtotime($defaultDate)));
        $summaries = $expenseAssets = PtirExpenseStockAssets::selectRaw('period_name, expense_type_code, prepaid_account_id, prepaid_account, prepaid_account_desc, net_amount')
                        ->where('period_name', $period_name)
                        ->where('expense_type_code', $request->expense_type)
                        ->where('prepaid_account_id', $request->prepaid_type)
                        ->get();

        $expenseCars = PtirExpenseCarGas::selectRaw('period_name, expense_type_code, prepaid_account_id, prepaid_account, prepaid_account_desc, net_amount')
                        ->where('period_name', $request)
                        ->where('expense_type_code', $request)
                        ->where('prepaid_account_id', $request)
                        ->get();

        if (count($expenseCars)) {
            $summaries = array_merge($summaries, $expenseCars);
        }

        $fileName = date('Ymdhms');
        $contentHtml = view('ir.reports.irr2030.main_page', compact('summaries', 'period_name_thai'))->render();
        return \PDF::loadHtml($contentHtml)->stream($fileName.'.pdf');
    }
}
