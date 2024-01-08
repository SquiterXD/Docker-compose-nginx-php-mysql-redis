<?php

namespace App\Http\Controllers\IR\Reports;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\IR\PtirApInvoiceInterfaces;

class IRR8010Controller extends Controller implements ReportInterface
{
    // Piyawut A. 07102021
    public function export($programCode, $request)
    {
        // เมื่อ call package สำเร็จแล้วจะ แสดง Output Report
        $invoiceDate = date('Y-m-d', strtotime($request->date));
        $status = $request->status;
        $type = $request->type;
        $apInterfaces = PtirApInvoiceInterfaces::search($request, $invoiceDate, $status)
                            ->orderByRaw('line_number, line_type, invoice_number')
                            ->get();

        $invoices = $apInterfaces->groupBy('invoice_number')->mapWithKeys(function ($item, $group) {
                    $groupName = $group;
                    return [$groupName => $item];
                })->toArray();

        $fileName = date('Ymdhms');
        $contentHtml = view('ir.reports.irr8010.main_page', compact('invoices', 'type', 'programCode'))->render();
        return \PDF::loadHtml($contentHtml)->setOrientation('landscape')->stream($fileName.'.pdf');
    }
}
