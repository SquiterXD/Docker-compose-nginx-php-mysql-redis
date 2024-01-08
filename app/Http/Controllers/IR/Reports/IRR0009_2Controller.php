<?php

namespace App\Http\Controllers\IR\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\IR\PtirExpenseCarGas;
use App\Models\IR\Views\PtirGroupsView;
use App\Models\IR\Views\PtirVehiclesView;
use App\Models\IR\PtirCars;
use App\Models\IR\CarBalanceReport;

class IRR0009_2Controller extends Controller
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
        $month       = request()->month_value;
        $groupCode   = request()->group_code;
        $renewType   = request()->renew_type;
        $monthText   = date('M', strtotime(request()->month_value)).'-'.date('y', strtotime(request()->month_value));

        $result = $this->callPackage(request());

        $dataList = CarBalanceReport::where('web_batch_no', $result['web_batch_no'])
                    ->with('vehicle')
                    ->orderBy('department_name', 'asc')
                    ->orderBy('vehicle_type_code', 'asc')
                    ->orderBy('license_plate', 'asc')
                    ->get();

        $data = $dataList->groupBy(['department_name', 'vehicle_type_code']);
        $totalActivityAP = $dataList->sum('activity_ap_amount');
        $totalBeginning  = $dataList->sum('beginning_amount');
        $totalEnding     = $dataList->sum('ending_amount');

        // dd($result, $result['web_batch_no'], $data);

        // $data = PtirExpenseCarGas::where('status', '!=', 'CANCELLED')
        //                             ->where('expense_type_code', 'CAR001')
        //                             ->where('period_name', $monthText)
        //                             ->where('group_code', request()->group_code)
        //                             ->where('renew_type', request()->renew_type)
        //                             ->with('vehicle')
        //                             ->get()
        //                             ->groupBy(['department_name']);

        $location = PtirVehiclesView::where('group_code', request()->group_code)->first();

        $getGroupCode = PtirGroupsView::where('lookup_code', request()->group_code)->first();
        $groupCodeDesc = $getGroupCode ? $getGroupCode->meaning : '';

        $getNetAmount = PtirExpenseCarGas::where('status', '!=', 'CANCELLED')
                                    ->where('expense_type_code', 'CAR001')
                                    ->where('period_name', $monthText)
                                    ->where('group_code', request()->group_code)
                                    ->where('renew_type', request()->renew_type)
                                    ->get();

        // $totalNetAmount = $getNetAmount->sum('net_amount');
        $totalNetAmount = $dataList->sum('net_amount');

        $totalInsuranceExpense = 0;
        foreach ($getNetAmount as $list) {
            $car = PtirCars::whereRaw("to_char(start_date, 'YYYYMM')  = '{$monthText}'")
                        ->where('status', 'CONFIRMED')
                        ->where('license_plate', $list->license_plate)
                        ->where('renew_type', $list->renew_type)
                        ->first();

            $insurance_amount = $car ? $car->insurance_amount : 0;

            $totalInsuranceExpense += $insurance_amount;
        }

        // dd($totalNetAmount, $totalInsuranceExpense);

        $thaimonths = ['01'=>'มกราคม','02'=>'กุมภาพันธ์','03'=>'มีนาคม','04'=>'เมษายน','05'=>'พฤษภาคม','06'=>'มิถุนายน',
                       '07'=>'กรกฎาคม','08'=>'สิงหาคม','09'=>'กันยายน','10'=>'ตุลาคม','11'=>'พฤศจิกายน','12'=>'ธันวาคม'];

        $thaishortmonths = ['01'=>'ม.ค.','02'=>'ก.พ.','03'=>'มี.ค.','04'=>'เม.ย.','05'=>'พ.ค.','06'=>'มิ.ย.',
                            '07'=>'ก.ค.','08'=>'ส.ค.','09'=>'ก.ย.','10'=>'ต.ค.','11'=>'พ.ย.','12'=>'ธ.ค.'];

        $fileName = date('Ymdhms');

        $pdf = \PDF::loadView('ir.reports.irr0009-2.main_page',compact('data', 'programCode', 'thaimonths', 'thaishortmonths', 'month', 'location', 'renewType', 'groupCode', 'monthText', 'totalNetAmount', 'totalInsuranceExpense', 'totalBeginning', 'totalEnding', 'totalActivityAP'))
                ->setOption('header-html',view('ir.reports.irr0009-2.header',compact('request', 'programCode', 'thaimonths', 'thaishortmonths', 'month', 'location', 'renewType', 'groupCode', 'monthText', 'groupCodeDesc')))
                ->setOption('margin-top','30')
                ->setOption('margin-bottom','15')
                ->setOption('encoding','UTF-8')
                ->setOption('lowquality', false)
                ->setOption('disable-javascript', true)
                ->setOption('disable-smart-shrinking', false)
                ->setOption('print-media-type', true)
                ->setPaper('a4','landscape');

        return $pdf->stream();
    }

    public function callPackage($request)
    {
        $user_id = auth()->user()->fnd_user_id;
        $groupCode   = $request->group_code;
        $renewType   = $request->renew_type;
        $monthText   = date('M', strtotime($request->month_value)).'-'.date('y', strtotime($request->month_value));
        // dd('callPackage', $request->all(), $monthText, $groupCode, $renewType);

        $db = \DB::connection('oracle')->getPdo();
        $sql = "
            declare

                V_WEB_BATCH_NO     VARCHAR2(250) ;  
                V_RETURN_STATUS    VARCHAR2(1) ; 
                V_RETURN_MSG       VARCHAR2(4000) ; 
            
            begin 
            
            dbms_output.put_line('PTIR_CAR_BALANCE_RPT.BUILD_DATA ');
            
            PTIR_CAR_BALANCE_RPT.BUILD_DATA(
                                P_PERIOD_NAME => '{$monthText}' 
                                , P_GROUP_CODE  => '{$groupCode}' 
                                , P_RENEW_TYPE  => '{$renewType}'
                                , P_USER_ID     => '{$user_id}' 
                                
                                , O_WEB_BATCH_NO  => :v_web_batch_no
                                , O_RETURN_STATUS => :v_return_status
                                , O_RETURN_MSG    => :v_return_msg
                            );
                            
                    dbms_output.put_line(' V_WEB_BATCH_NO  = '||V_WEB_BATCH_NO );  
                    dbms_output.put_line(' V_RETURN_STATUS = '||V_RETURN_STATUS);
                    dbms_output.put_line(' V_RETURN_MSG    = '||V_RETURN_MSG);                 
            end ;
        ";
        \Log::info('IRR0009-2');
        \Log::info($sql);
        $result = [];
        $sql = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':v_web_batch_no', $result['web_batch_no'], \PDO::PARAM_STR, 4000);
        $stmt->bindParam(':v_return_status', $result['status'], \PDO::PARAM_STR, 100);
        $stmt->bindParam(':v_return_msg', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        \Log::info($result);

        return $result;
    }
}
