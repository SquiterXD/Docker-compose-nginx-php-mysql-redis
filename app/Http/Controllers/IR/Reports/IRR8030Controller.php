<?php

namespace App\Http\Controllers\IR\Reports;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\IR\PtirArInvoiceInterfaces;

class IRR8030Controller extends Controller implements ReportInterface
{
    // Piyawut A. 14122021
    public function export($programCode, $request)
    {
        $type = $request->interface_type_code;
        $arInterfaces = PtirArInvoiceInterfaces::search($request)
                            ->orderByRaw('invoice_number, line_number')
                            ->get();
        $invoices = $arInterfaces->groupBy('invoice_number')->mapWithKeys(function ($item, $group) {
                    $groupName = $group;
                    return [$groupName => $item];
                })->toArray();

        $fileName = date('Ymdhms');
        $contentHtml = view('ir.reports.irr8030.main_page', compact('invoices', 'type', 'programCode'))->render();
        return \PDF::loadHtml($contentHtml)
                    ->setOrientation('landscape')
                    ->setOption('margin-top', 4)
                    ->stream($fileName.'.pdf');
    }
}
