<?php

namespace App\Http\Controllers\EAM;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function billMaterials()
    {
        $user = Auth::user();
        return view('eam.report.bill-materials', ['user'=>$user]);
    }

    public function summaryMonth()
    {
        return view('eam.report.summary-month');
    }

    public function summaryMonthExcel()
    {
        return view('eam.report.summary-month-excel');
    }

    public function payable()
    {
        return view('eam.report.payable');
    }
    
    public function issueMatExcel()
    {
        return view('eam.report.issue-mat-excel');
    }

    public function closedWo()
    {
        return view('eam.report.closed-wo');
    }

    public function closedWo2()
    {
        return view('eam.report.closed-wo2');
    }

    public function closedWoJp()
    {
        return view('eam.report.closed-wo-jp');
    }

    public function mntHistory()
    {
        return view('eam.report.mnt-history');
    }
    public function maintenance()
    {
        return view('eam.report.maintenance');
    }

    public function jobAccountDel()
    {
        return view('eam.report.job-account-del');
    }

    public function purchase()
    {
        return view('eam.report.purchase');
    }

    public function requestMatInv()
    {
        return view('eam.report.request-mat-inv');
    }

    public function requestMatNon()
    {
        return view('eam.report.request-mat-non');
    }

    public function jobAccount()
    {
        return view('eam.report.job-account');
    }

    public function laborAccount()
    {
        return view('eam.report.labor-account');
    }

    public function woComStatus()
    {
        return view('eam.report.wo-com-status');
    }
    
    public function labor()
    {
        return view('eam.report.labor');
    }

    public function woCost()
    {
        return view('eam.report.wo-cost');
    }

    public function summaryLabor()
    {
        return view('eam.report.summary-labor');
    }

    public function receiptMat()
    {
        return view('eam.report.receipt-mat');
    }

    public function summaryMatStatus()
    {
        return view('eam.report.summary-mat-status');
    }
}

