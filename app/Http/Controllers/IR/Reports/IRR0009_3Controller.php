<?php

namespace App\Http\Controllers\IR\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\IR\PtirExpenseCarGas;
use App\Models\IR\Views\PtirGroupsView;
use App\Models\IR\Views\PtirVehiclesView;
use App\Models\IR\PtirCars;
use App\Models\IR\GasBalanceReport;

class IRR0009_3Controller extends Controller
{
    public function getGroupCode()
    {  
        $month       = date('Y-m-d', strtotime(request()->month));
        $monthFromTh = parseFromDateTh($month);
        $monthText   = date('M', strtotime(request()->month)).'-'.date('y', strtotime($monthFromTh));
        
        $lists = PtirExpenseCarGas::where('status', '!=', 'CANCELLED')
                                    ->where('expense_type_code', 'GAS001')
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

    public function getGasStationType()
    {      
        $month       = date('Y-m-d', strtotime(request()->month));
        $monthFromTh = parseFromDateTh($month);
        $monthText   = date('M', strtotime(request()->month)).'-'.date('y', strtotime($monthFromTh));

        $groupCode   = request()->group_code;
        
        $data = PtirExpenseCarGas::selectRaw('distinct gas_station_type_code as value, gas_station_type_name as label')
                                    ->where('status', '!=', 'CANCELLED')
                                    ->where('expense_type_code', 'GAS001')
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
        $month            = request()->month_value;
        $groupCode        = request()->group_code;
        $gasStationType   = request()->gas_station_type;
        $monthText        = date('M', strtotime(request()->month_value)).'-'.date('y', strtotime(request()->month_value));

        $result = $this->callPackage(request());

        $dataList = GasBalanceReport::where('web_batch_no', $result['web_batch_no'])
                    ->orderBy('department_name', 'asc')
                    ->orderBy('gas_station_type_name', 'asc')
                    ->get();

        $data = $dataList->groupBy('department_name');


        $totalBeginning  = $dataList->sum('beginning_amount');
        $totalActivity   = $dataList->sum('activity_ap_amount');
        $totalNetAmount  = $dataList->sum('net_amount');
        $totalEnding     = $dataList->sum('ending_amount');

        $location      = PtirVehiclesView::where('group_code', request()->group_code)->first();
        $getGroupCode  = PtirGroupsView::where('lookup_code', request()->group_code)->first();
        $groupCodeDesc = $getGroupCode ? $getGroupCode->meaning : '';

        $thaimonths = ['01'=>'มกราคม','02'=>'กุมภาพันธ์','03'=>'มีนาคม','04'=>'เมษายน','05'=>'พฤษภาคม','06'=>'มิถุนายน',
            '07'=>'กรกฎาคม','08'=>'สิงหาคม','09'=>'กันยายน','10'=>'ตุลาคม','11'=>'พฤศจิกายน','12'=>'ธันวาคม'];

        $thaishortmonths = ['01'=>'ม.ค.','02'=>'ก.พ.','03'=>'มี.ค.','04'=>'เม.ย.','05'=>'พ.ค.','06'=>'มิ.ย.',
                            '07'=>'ก.ค.','08'=>'ส.ค.','09'=>'ก.ย.','10'=>'ต.ค.','11'=>'พ.ย.','12'=>'ธ.ค.'];

        $fileName = date('Ymdhms');

        $pdf = \PDF::loadView('ir.reports.irr0009-3.main_page',compact('data', 'programCode', 'thaimonths', 'thaishortmonths', 'month', 'location', 'groupCode', 'monthText', 'groupCodeDesc', 'totalBeginning', 'totalActivity', 'totalNetAmount', 'totalEnding'))
                ->setOption('header-html',view('ir.reports.irr0009-3.header',compact('request', 'programCode', 'thaimonths', 'thaishortmonths', 'month', 'location', 'groupCode', 'monthText', 'groupCodeDesc')))
                ->setOption('margin-top','35')
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
        $user_id         = auth()->user()->fnd_user_id;
        $groupCode       = $request->group_code;
        $gasStationType  = $request->gas_station_type;
        $monthText       = date('M', strtotime($request->month_value)).'-'.date('y', strtotime($request->month_value));

        $db = \DB::connection('oracle')->getPdo();
        $sql = "
            declare

                V_WEB_BATCH_NO     VARCHAR2(250) ;  
                V_RETURN_STATUS    VARCHAR2(1) ; 
                V_RETURN_MSG       VARCHAR2(4000) ; 

            begin 
            
                dbms_output.put_line('PTIR_GAS_BALANCE_RPT.BUILD_DATA ');
                
                PTIR_GAS_BALANCE_RPT.BUILD_DATA(
                            P_PERIOD_NAME              => '{$monthText}' 
                            , P_GROUP_CODE             => '{$groupCode}' 
                            , P_GAS_STATION_TYPE_CODE  => '{$gasStationType}'
                            , P_USER_ID                => '{$user_id}' 
                            
                            , O_WEB_BATCH_NO  => :v_web_batch_no
                            , O_RETURN_STATUS => :v_return_status
                            , O_RETURN_MSG    => :v_return_msg
                            );
                        
                dbms_output.put_line(' V_WEB_BATCH_NO  = '||V_WEB_BATCH_NO );  
                dbms_output.put_line(' V_RETURN_STATUS = '||V_RETURN_STATUS);
                dbms_output.put_line(' V_RETURN_MSG    = '||V_RETURN_MSG);                 
            end ;
            
        ";
        \Log::info('IRR0009-3');
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
