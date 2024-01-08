<?php

namespace App\Http\Controllers\IR\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\IR\PtirExpenseStockAssets;
use App\Models\IR\StockBalanceReport;
use App\Models\IR\Views\GlPeriodYearView;
use App\Models\IR\Views\PtirEffectiveDate;
use App\Models\Lookup\ValueSetup;

class IRR0081_3Controller extends Controller
{
    public function getPolicySet()
    {
        $month       = date('Y-m-d', strtotime(request()->month));
        $monthFromTh = parseFromDateTh($month);
        $monthText   = date('M', strtotime(request()->month)).'-'.date('y', strtotime($monthFromTh));


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
        $policySetHaderIdFrom  = request()->policy_set_header_id_from;
        $policySetHaderIdTo    = request()->policy_set_header_id_to;
        $monthText             = date('M', strtotime(request()->month_value)).'-'.date('y', strtotime(request()->month_value));
        
        $periodYear = (new GlPeriodYearView())->getYear($monthText);
        $year       = $periodYear ? $periodYear->period_year : '';
        $date       = ValueSetup::where('lookup_type', 'PTIR_EFFECTIVE_DATE')->where('lookup_code', $year)->first();
        $start_date = $date ? $date->start_date_active : '';
        $end_date   = $date ? date('d-m-Y', strtotime($date->start_date_active . " +1 year")) : '';

        // dd($start_date, $end_date);

        $result = $this->callPackage(request(), $year);
        
        // dd('export', request()->all(), $result);

        $dataList = StockBalanceReport::where('web_batch_no', $result['web_batch_no'])
                    ->with(['policyType', 'stocklines'])
                    ->orderBy('policy_set_header_id', 'asc')
                    ->orderBy('department_name', 'asc')
                    ->get();

        $data = $dataList->groupBy(['policy_set_header_id']);

        $policySetHeaderList = $dataList->pluck('policy_set_header_id')->unique()->toArray();
        // dd($dataList, $data, $policySetHeaderList);
        // dd($periodYear,$year, $date);


        $thaimonths = ['01'=>'มกราคม','02'=>'กุมภาพันธ์','03'=>'มีนาคม','04'=>'เมษายน','05'=>'พฤษภาคม','06'=>'มิถุนายน',
                       '07'=>'กรกฎาคม','08'=>'สิงหาคม','09'=>'กันยายน','10'=>'ตุลาคม','11'=>'พฤศจิกายน','12'=>'ธันวาคม'];

        $thaishortmonths = ['01'=>'ม.ค.','02'=>'ก.พ.','03'=>'มี.ค.','04'=>'เม.ย.','05'=>'พ.ค.','06'=>'มิ.ย.',
                            '07'=>'ก.ค.','08'=>'ส.ค.','09'=>'ก.ย.','10'=>'ต.ค.','11'=>'พ.ย.','12'=>'ธ.ค.'];

        $fileName = date('Ymdhms');

        $pdf = \PDF::loadView('ir.reports.irr0081-3.main_page',compact('data', 'programCode', 'thaimonths', 'thaishortmonths', 'month', 'monthText'))
                ->setOption('header-html',view('ir.reports.irr0081-3.header',compact('request', 'programCode', 'thaimonths', 'thaishortmonths', 'month', 'monthText', 'policySetHeaderList', 'date', 'start_date', 'end_date')))
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

    public function callPackage($request, $year)
    {
        $userId                = auth()->user()->fnd_user_id;
        $policySetHaderIdFrom  = request()->policy_set_header_id_from;
        $policySetHaderIdTo    = request()->policy_set_header_id_to;
        $monthText             = date('M', strtotime($request->month_value)).'-'.date('y', strtotime($request->month_value));
        // dd('callPackage', $request->all(), $monthText, $policySetHaderIdFrom, $policySetHaderIdTo, $year);

        $db = \DB::connection('oracle')->getPdo();
        $sql = "
            declare

                V_WEB_BATCH_NO     VARCHAR2(250) ;  
                V_RETURN_STATUS    VARCHAR2(1) ; 
                V_RETURN_MSG       VARCHAR2(4000) ; 

            begin 
                
                dbms_output.put_line('PTIR_ASSET_BALANCE_RPT.BUILD_DATA ');
                
                PTIR_STOCK_BALANCE_RPT.BUILD_DATA(P_YEAR => '{$year}'
                                                , P_PERIOD_NAME => '{$monthText}'
                                                , P_POLICY_SET_H_FROM_ID =>  '{$policySetHaderIdFrom}'
                                                , P_POLICY_SET_H_TO_ID   => '{$policySetHaderIdTo}' 
                                                , P_USER_ID => '{$userId}' 
                                                
                                                , O_WEB_BATCH_NO  => :v_web_batch_no
                                                , O_RETURN_STATUS => :v_return_status
                                                , O_RETURN_MSG    => :v_return_msg
                );
                                            
                dbms_output.put_line(' V_WEB_BATCH_NO  = '||V_WEB_BATCH_NO );  
                dbms_output.put_line(' V_RETURN_STATUS = '||V_RETURN_STATUS);
                dbms_output.put_line(' V_RETURN_MSG    = '||V_RETURN_MSG);                 
            end;
        ";
        \Log::info('IRR0081-3');
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
