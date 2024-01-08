<?php

namespace App\Http\Controllers\IR\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\IR\PtirExpenseCarGas;
use App\Models\IR\Views\PtirGroupsView;
use App\Models\IR\Views\PtirVehiclesView;

class IRR0009_1Controller extends Controller
{
    public function getGroupCode()
    {
        $month       = date('Y-m-d', strtotime(request()->month));
        $monthFromTh = parseFromDateTh($month);
        $monthText   = date('M', strtotime(request()->month)).'-'.date('y', strtotime($monthFromTh));
        
        $lists = PtirExpenseCarGas::where('status', '!=', 'CANCELLED')
                                    ->where('expense_type_code', 'CAR001')
                                    ->where('period_name', $monthText)
                                    ->get();

        $groups = $lists->pluck('group_code')->unique()->toArray();

        $data = PtirGroupsView::selectRaw('lookup_code as value, meaning as label')
                                ->whereIn('lookup_code', $groups)
                                ->get();

        return response()->json([
            'data'          => $data,
        ]);
    }

    public function getRenewType()
    {        
        $month       = date('Y-m-d', strtotime(request()->month));
        $monthFromTh = parseFromDateTh($month);
        $monthText   = date('M', strtotime(request()->month)).'-'.date('y', strtotime($monthFromTh));

        $groupCode   = request()->group_code;
        
        $data = PtirExpenseCarGas::selectRaw('distinct renew_type as value, renew_type as label')
                                    ->where('status', '!=', 'CANCELLED')
                                    ->where('expense_type_code', 'CAR001')
                                    ->where('period_name', $monthText)
                                    ->where('group_code', $groupCode)
                                    ->get();

        return response()->json([
            'data'          => $data,
        ]);
    }

    public function export($programCode, $request)
    {
        // dd($programCode, $request->all());
        $month       = request()->month_value;
        $groupCode   = request()->group_code;
        $renewType   = request()->renew_type;
        $monthText   = date('M', strtotime(request()->month_value)).'-'.date('y', strtotime(request()->month_value));

        // $collection = "
        //     select 
        //         sum(net_amount) as total  
        //     from
        //         ptir_expense_car_gas 
        //     where expense_type_code = 'CAR001'
        //     and period_name = '{$monthText}'
        //     and group_code = '{$groupCode}'
        //     and renew_type = '{$renewType}'
        // ";

        // $data =  \DB::select($collection);

        $totalDebit = '';
        $getNetAmount = PtirExpenseCarGas::SelectRaw('sum (net_amount) as total')
                                    ->where('status', '!=', 'CANCELLED')
                                    ->where('expense_type_code', 'CAR001')
                                    ->where('period_name', $monthText)
                                    ->where('group_code', request()->group_code)
                                    ->where('renew_type', request()->renew_type)
                                    ->get();

        foreach ($getNetAmount as $value) {
            $totalDebit = $value->total;
        }

        // $dataDebit = PtirExpenseCarGas::where('status', '!=', 'CANCELLED')
        //                             ->where('expense_type_code', 'CAR001')
        //                             ->where('period_name', $monthText)
        //                             ->where('group_code', request()->group_code)
        //                             ->where('renew_type', request()->renew_type)
        //                             ->with('vehicle')
        //                             ->get()
        //                             ->groupBy(['department_name']);
        //                             // ->pluck('license_plate');

        $collection = "
            select 
                ecg.status, ecg.period_name, ecg.expense_type_code, ecg.group_code, ecg.department_code, 
                ecg.department_name, ecg.renew_type_code, ecg.renew_type, ecg.license_plate, ecg.net_amount, 
                ecg.start_date, ecg.end_date, ecg.total_days, ecg.expense_account_id, ecg.expense_account, 
                ecg.expense_account_desc, ecg.prepaid_account_id, ecg.prepaid_account, ecg.prepaid_account_desc,
                vh.vehicle_type_code, vh.vehicle_type_name, vh.vehicle_brand_code, vh.vehicle_brand_name
            from 
                ptir_expense_car_gas ecg,
                OAIR.ptir_vehicles_v vh
            where 1=1
            and ecg.license_plate = vh.license_plate
            and ecg.status != 'CANCELLED'
            and ecg.expense_type_code = 'CAR001'
            and ecg.period_name = '{$monthText}'
            and ecg.group_code = '{$groupCode}'
            and ecg.renew_type = '{$renewType}'
        ";

        $data      =  \DB::select($collection);
        $dataDebit = collect($data)->groupBy(['department_name', 'vehicle_type_name']);

        $dataCredit = PtirExpenseCarGas::selectRaw('distinct prepaid_account, prepaid_account_desc')
                                    ->where('status', '!=', 'CANCELLED')
                                    ->where('expense_type_code', 'CAR001')
                                    ->where('period_name', $monthText)
                                    ->where('group_code', request()->group_code)
                                    ->where('renew_type', request()->renew_type)
                                    ->get();

        $location = PtirVehiclesView::where('group_code', request()->group_code)->first();

        $getGroupCode = PtirGroupsView::where('lookup_code', request()->group_code)->first();
        $groupCodeDesc = $getGroupCode ? $getGroupCode->meaning : '';

        $thaimonths = ['01'=>'มกราคม','02'=>'กุมภาพันธ์','03'=>'มีนาคม','04'=>'เมษายน','05'=>'พฤษภาคม','06'=>'มิถุนายน',
                       '07'=>'กรกฎาคม','08'=>'สิงหาคม','09'=>'กันยายน','10'=>'ตุลาคม','11'=>'พฤศจิกายน','12'=>'ธันวาคม'];

        $fileName = date('Ymdhms');

        $pdf = \PDF::loadView('ir.reports.irr0009-1.main_page',compact('dataDebit', 'dataCredit', 'programCode', 'thaimonths', 'month', 'location', 'renewType', 'groupCode', 'monthText', 'totalDebit'))
                ->setOption('header-html',view('ir.reports.irr0009-1.header',compact('request', 'programCode', 'thaimonths', 'month', 'location', 'renewType', 'groupCode', 'monthText', 'groupCodeDesc')))
                ->setOption('margin-top','40')
                ->setOption('margin-bottom','25')
                ->setOption('encoding','UTF-8')
                ->setOption('lowquality', false)
                ->setOption('disable-javascript', true)
                ->setOption('disable-smart-shrinking', false)
                ->setOption('print-media-type', true)
                ->setPaper('a4','landscape')
                ->setOption('header-font-name',"THSarabunNew");

        return $pdf->stream();
    }
}
