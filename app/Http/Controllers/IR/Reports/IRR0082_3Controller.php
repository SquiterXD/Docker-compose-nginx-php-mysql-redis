<?php

namespace App\Http\Controllers\IR\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\IR\PtirExpenseCarGas;
use App\Models\IR\Views\PtirGroupsView;
use App\Models\IR\Views\PtirVehiclesView;
use App\Models\IR\PtirCars;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

class IRR0082_3Controller extends Controller
{
    public function export($programCode, $request)
    {
        if(!$request->year || !$request->period){
            return abort('404');
        }

        $year = $request->year;
		$period = Carbon::parse($request->period)->format('M-y');
        $req_period = $request->period;
		$policy_from = $request->policy_from;
        $policy_to = $request->policy_to;
        $user_id = auth()->user()->user_id;

        // dd($year, $period, $policy_from, $policy_to, $user_id);
        
        $range = DB::table('ptir_period_year_v')
        ->where('period_year', $year)
        ->first();

        $begin_header = Carbon::parse($request->period)->subMonth()->endOfMonth()->format('Y-m-d');
        $end_header = Carbon::parse($request->period)->endOfMonth()->format('Y-m-d');

        $result = [];
        // $result['batch_no'] = 70;

        $db = DB::connection('oracle')->getPdo();

        $sql = "
            declare

                V_WEB_BATCH_NO     VARCHAR2(250)    :=  NULL;
                V_RETURN_STATUS    VARCHAR2(1)      :=  NULL;
                V_RETURN_MSG       VARCHAR2(4000)   :=  NULL;

            begin 
            
                PTIR_ASSET_BALANCE_RPT.BUILD_DATA(
                    P_YEAR                      => :year --- 2023
                    , P_PERIOD_NAME             => :period --- 'Oct-22'
                    , P_POLICY_SET_H_FROM_ID    => :policyFrom --- 9
                    , P_POLICY_SET_H_TO_ID      => :policyTo --- 9 
                    , P_USER_ID                 => :userId --- 0 
                    -----------
                    , O_WEB_BATCH_NO            => :V_WEB_BATCH_NO
                    , O_RETURN_STATUS           => :V_RETURN_STATUS
                    , O_RETURN_MSG              => :V_RETURN_MSG
                );
           
            end ;
        ";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':year', $year, \PDO::PARAM_STR);
        $stmt->bindParam(':period', $period, \PDO::PARAM_STR);
        $stmt->bindParam(':policyFrom', $policy_from, \PDO::PARAM_STR);
        $stmt->bindParam(':policyTo', $policy_to, \PDO::PARAM_STR);
        $stmt->bindParam(':userId', $user_id, \PDO::PARAM_STR);

        $stmt->bindParam(':V_WEB_BATCH_NO', $result['batch_no'], \PDO::PARAM_STR, 250);
        $stmt->bindParam(':V_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 1);
        $stmt->bindParam(':V_RETURN_MSG', $result['message'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        $query = DB::table("oair.ptir_asset_balance_report as asset")
        ->join("oair.ptir_policy_set_headers as policy", "asset.policy_set_header_id", "=", "policy.policy_set_header_id")
        ->where('asset.web_batch_no', '=', $result['batch_no'])
        ->orderByRaw("policy_set_number asc, user_policy_number asc, department_name asc, category_name asc, expense_account asc")
        ->get()
        ->groupBy([
            function($item){
                return 'ชุดที่ '. $item->policy_set_number . ' : ' . $item->policy_set_description;
            },
            function($item){
                return $item->user_policy_number;
            },
            function($item){
                return $item->department_name;
            },
            function($item){
                return $item->category_name;
            },
            function($item){
                return $item->expense_account;
            },
        ]);

        // dd($query, $result, $result['batch_no']);

        $maxLine = 25;
        $page = 0;
        $line_num = 0;
        $data = [];

        foreach ($query as $policy => $groupUser) {
            $line_num = 0;
            foreach($groupUser as $user => $groupDepartment){
                $countDep = 1;
                if($line_num > $maxLine){
                    $line_num = 0;
                    $page++;
                    $data[$page]['show_sum_all'] = false;
                }
                $line_num++;

                foreach($groupDepartment as $department => $groupCategory){
                    $deptName = $countDep.'. '.$department;
                    if($line_num > $maxLine){
                        $line_num = 1;
                        $page++;
                        $data[$page]['show_sum_dept'][$deptName] = false;
                        $data[$page]['show_sum_all'] = false;
                    }
                    $line_num++;

                    foreach($groupCategory as $category => $groupExpense){
                        if($line_num > $maxLine){
                            $line_num = 2;
                            $page++;
                            $data[$page]['show_sum_dept'][$deptName] = false;
                            $data[$page]['show_sum_all'] = false;
                        }
                        foreach($groupExpense as $account => $items){
                            if($line_num > $maxLine){
                                $line_num = 2;
                                $page++;
                                $data[$page]['show_sum_dept'][$deptName] = false;
                                $data[$page]['show_sum_all'] = false;
                            }
                            $line_num++;
            
                            $data[$page]['show_sum_dept'][$deptName] = false;
                            $data[$page]['show_sum_all'] = false;
                            $data[$page]['data'][$policy][$user][$deptName][$category][$account] = $items;
                        }
                    }
                    $data[$page]['show_sum_dept'][$deptName] = true;
                    $line_num++;
                    $countDep++;
                }
            }
            $data[$page]['show_sum_all'] = true;
            $page++;
        }
        // dd($data);

        $thaimonths = ['01'=>'มกราคม','02'=>'กุมภาพันธ์','03'=>'มีนาคม','04'=>'เมษายน','05'=>'พฤษภาคม','06'=>'มิถุนายน',
                       '07'=>'กรกฎาคม','08'=>'สิงหาคม','09'=>'กันยายน','10'=>'ตุลาคม','11'=>'พฤศจิกายน','12'=>'ธันวาคม'];

        $thaishortmonths = ['01'=>'ม.ค.','02'=>'ก.พ.','03'=>'มี.ค.','04'=>'เม.ย.','05'=>'พ.ค.','06'=>'มิ.ย.',
                            '07'=>'ก.ค.','08'=>'ส.ค.','09'=>'ก.ย.','10'=>'ต.ค.','11'=>'พ.ย.','12'=>'ธ.ค.'];

        $pdf = PDF::loadView('ir.reports.IRR0082_3._template', compact(
            'data', 'programCode', 'thaimonths', 'thaishortmonths', 'req_period', 'year', 'range', 'begin_header',
            'end_header'
        ))
        ->setPaper('a4')
        ->setOrientation('landscape')
        ->setOption('margin-bottom', 0);

        return $pdf->stream();
    }
}
