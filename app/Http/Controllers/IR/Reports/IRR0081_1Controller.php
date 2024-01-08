<?php

namespace App\Http\Controllers\IR\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\IR\PtirExpenseStockAssets;
use App\Models\IR\Settings\PtirPolicySetHeaders;
use App\Models\IR\PtirStockLines;

class IRR0081_1Controller extends Controller
{
    public function getPolicySet()
    {
        // dd('getPolicySet', request()->all());

        $month       = date('Y-m-d', strtotime(request()->month));
        $monthFromTh = parseFromDateTh($month);
        $monthText   = date('M', strtotime(request()->month)).'-'.date('y', strtotime($monthFromTh));
        
        // $lists = PtirExpenseStockAssets::where('period_name', $monthText)
        //                             // ->where('status', '!=', 'CANCELLED')
        //                             // ->where('expense_type_code', 'STOCK0001')
        //                             ->get();

        // $numbers = $lists->pluck('policy_set_header_id')->unique()->toArray();


        // $data = PtirPolicySetHeaders::selectRaw("policy_set_number as value, policy_set_number || ' : ' || policy_set_description as label")
        //                         ->whereIn('policy_set_number', $numbers)
        //                         ->orderBy('policy_set_number')
        //                         ->get();

        $data = PtirExpenseStockAssets::selectRaw("distinct policy_set_header_id value, policy_set_header_id || ' : ' || policy_set_description label")
                                    ->where('period_name', $monthText)
                                    ->where('expense_type_code', 'STOCK001')
                                    ->orderBy('policy_set_header_id')
                                    ->get();

        return response()->json([
            'data'          => $data,
        ]);
    }

    public function export($programCode, $request)
    {
        $month                 = request()->month_value;
        $policySetHaderIdFrom  = request()->policy_set_from;
        $policySetHaderIdTo    = request()->policy_set_to;
        $monthText             = date('M', strtotime(request()->month_value)).'-'.date('y', strtotime(request()->month_value));
        // dd('Export', request()->all(), $month, $policySetHaderIdFrom, $policySetHaderIdTo, $monthText, strtoupper($monthText));
        $data = PtirStockLines::where('period_name', strtoupper($monthText))
                                ->where('program_code', 'IRP0002')
                                ->where('status', 'CONFIRMED')
                                ->whereBetween('policy_set_header_id', [$policySetHaderIdFrom, $policySetHaderIdTo])
                                ->orderBy('policy_set_header_id', 'asc')
                                ->orderBy('department_code', 'asc')
                                ->orderBy('asset_group_code', 'asc')
                                ->get()
                                ->groupBy(['policy_set_header_id', 'department_code', 'asset_group_code', 'stock_list_description']);

        // dd('Export', request()->all(), $data);

        $thaimonths = ['01'=>'มกราคม','02'=>'กุมภาพันธ์','03'=>'มีนาคม','04'=>'เมษายน','05'=>'พฤษภาคม','06'=>'มิถุนายน',
                       '07'=>'กรกฎาคม','08'=>'สิงหาคม','09'=>'กันยายน','10'=>'ตุลาคม','11'=>'พฤศจิกายน','12'=>'ธันวาคม'];

        $thaishortmonths = ['01'=>'ม.ค.','02'=>'ก.พ.','03'=>'มี.ค.','04'=>'เม.ย.','05'=>'พ.ค.','06'=>'มิ.ย.',
                            '07'=>'ก.ค.','08'=>'ส.ค.','09'=>'ก.ย.','10'=>'ต.ค.','11'=>'พ.ย.','12'=>'ธ.ค.'];

        $fileName = date('Ymdhms');
        // $pdf = \PDF::loadView('ir.reports.irr0081-1.main_page',compact('request', 'data', 'programCode', 'thaimonths', 'thaishortmonths', 'month', 'monthText'))
        //         ->setOption('header-html',view('ir.reports.irr0081-1.header',compact('request', 'programCode', 'thaimonths', 'thaishortmonths', 'month', 'monthText')))
        //         ->setOption('margin-top','10')
        //         ->setOption('margin-bottom','15')
        //         ->setOption('encoding','UTF-8')
        //         ->setOption('lowquality', false)
        //         ->setOption('disable-javascript', true)
        //         ->setOption('disable-smart-shrinking', false)
        //         ->setOption('print-media-type', true)
        //         ->setPaper('a4','landscape');

        $pdf = \PDF::loadView('ir.reports.irr0081-1.main_page',compact('data', 'programCode', 'thaimonths', 'thaishortmonths', 'month', 'monthText'))
                ->setOption('header-html',view('ir.reports.irr0081-1.header',compact('request', 'programCode', 'thaimonths', 'thaishortmonths', 'month', 'monthText')))
                ->setOption('margin-top','35')
                ->setOption('margin-bottom','10')
                ->setOption('encoding','UTF-8')
                ->setOption('lowquality', false)
                ->setOption('disable-javascript', true)
                ->setOption('disable-smart-shrinking', false)
                ->setOption('print-media-type', true)
                ->setPaper('a4','landscape');

        return $pdf->stream();

        // $pdf = \PDF::loadView('ir.reports.irr0008_1.pdf.index',compact('data', 'programCode', 'thaimonths', 'thaishortmonths', 'month', 'monthText'))
        //     ->setPaper('a4','landscape')
        //     ->setOption('header-font-name',"THSarabunNew")
        //     ->setOption('header-font-size',12)
        //     ->setOption('header-spacing',3)
        //     ->setOption('header-right',"\n\n\n[page]/[topage] ")
        //     ->setOption('margin-bottom', 10);

        // return $pdf->stream($programCode. '.pdf');

    }
}
