<?php

namespace App\Http\Controllers\OM\Reports;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OM\ARInvoiceReportTemp;
use PDF;
use Illuminate\Support\Facades\DB;

class OMR0113Controller extends Controller
{
    public function export($programCode, Request $request)
    {
        $group_id = $request->group_id;
        $date = Carbon::parse($request->document_date);

        if(!$date){
           return abort('404'); 
        }

        $max_line = 15;
        $page = 0;
        $data = [];

        $invoice_reports = ARInvoiceReportTemp::select(DB::raw("   
            *
        "))
        ->whereRaw("
            1 = 1
            and ptom_ar_invoice_report_temp.gl_date = ?
            and batch_source_name = 'ระบบขายต่างประเทศ'
        ", [
            strtoupper($date->format('d-M-Y'))
        ])
        ->when($group_id, function ($q) use($group_id) {
            return $q->where('group_id', $group_id);
        });

        $query = $invoice_reports
            ->orderByRaw("group_id asc, currency asc, invoice_number asc")
            ->get()
            ->groupBy(['group_id', 'currency', 'invoice_number']);

        if($query->count()){
            $set_data = $this->setDataReport($query, $data, $group_id, $page, $max_line);
            $data = $set_data['data'];
            $page = $set_data['page'];
        }

        // dd($data);

        $pdf = PDF::loadView('om.reports.OMR0113._template', compact(
            'data',
            'date'
        ))
        ->setPaper('a4')
        ->setOrientation('landscape')
        ->setOption('margin-bottom', 0);

        return $pdf->stream('close-daily-sale.pdf');
    }

    private static function setDataReport($groupData, $array_data, $group_id, $current_page, $max_line)
    {
        $data = $array_data;
        $page = $current_page+1;
        $maxLine = $max_line;
        $line_num = 0;

        // dd($groupData);

        foreach($groupData as $group_id => $groupCurrency){
            $line_num = 0;
            foreach ($groupCurrency as $currency => $groupDoc) {
                foreach($groupDoc as $docNum => $items){
                    if($line_num > $maxLine){
                        $line_num = 0;
                        $page++;
                    }

                    $data[$page]['end_flag'] = false;
                    $data[$page]['group_id'] = $group_id;
                    $data[$page]['lines'][$currency][$docNum] = $items;
                    $line_num++;
                }
            }
            $data[$page]['end_flag'] = true;
            $page++;
        }

        return [
            'data' => $data,
            'page' => $page,
        ];
    }
}
