<?php

namespace App\Http\Controllers\IR\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IR\PtirTuReportAssetV;

class IRR1001Controller extends Controller
{
    public function export($programCode, $request)
    {
       // dd($programCode, $request);
        $document_number = $request->document_number;

        
        $summaries =  PtirTuReportAssetV::selectRaw('document_number,status,year')
                        ->where('document_number', $document_number)
                        ->get();

        // $expenseCars = PtirExpenseCarGas::selectRaw('period_name, expense_type_code, prepaid_account_id, prepaid_account, prepaid_account_desc, net_amount')
        //                 ->where('period_name', $request)
        //                 ->where('expense_type_code', $request)
        //                 ->where('prepaid_account_id', $request)
        //                 ->get();

        // if (count($expenseCars)) {
        //     $summaries = array_merge($summaries, $expenseCars);
        // }
        
        $fileName = date('Ymdhms');
        $contentHtml = view('ir.reports.irr1001.pdf.index', compact('summaries', 'document_number'))->render();
        return \PDF::loadHtml($contentHtml)->stream($fileName.'.pdf');
    }
}
