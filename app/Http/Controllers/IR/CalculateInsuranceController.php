<?php

namespace App\Http\Controllers\IR;

use App\Models\IR\Views\PtirEffectiveDate;
use App\Models\IR\Views\PtirPolicyCategoryView;
use App\Models\IR\Settings\PtirPolicySetHeaders;
use App\Models\IR\Settings\PtirCompanies;
use App\Models\IR\PtirStockHeaders;
use App\Models\IR\PtirStockLines;
use App\Models\IR\PtirCalculateInsurances;
use PDF;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\IR\StockBalanceReport;
use App\Models\IR\Views\PtirStockLinesView;

class CalculateInsuranceController extends Controller
{
    protected $orgId;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->orgId = getDefaultData()->bu_id;
            // $this->orgId = 121;
            return $next($request);
        });
    }

    public function index()
    {
        $companyLists = PtirCompanies::where('active_flag', 'Y')->get()->unique('company_number')->values();
        $effectDateLists = PtirEffectiveDate::all();

        $categoryCodes = PtirPolicyCategoryView::where('description', 'like', '%สินค้า%')->pluck('lookup_code')->all();
        $policyLists = PtirPolicySetHeaders::whereIn('policy_category_code', $categoryCodes)->orderBy('policy_set_number')->get();
        $yearLists = $effectDateLists->map(function ($year, $key) {
            return convertYearToBBE($year->lookup_code);
        });

        return view('ir.calculate-insurance.index', 
                    compact(
                        'policyLists',
                        'companyLists',
                        'effectDateLists',
                        'yearLists'
                    ));
    }

    public function interface(Request $request)
    {
        ini_set('max_execution_time', 1800);
        $orgId = $this->orgId; // 81;
        $company = $request->company;
        $policyHeaderId = $request->insuranceNo;
        $year = (int)$request->year - 543;
        $dateStart = self::convertDateThToInter($request->dateStart)->format('d-M-Y');
        $dateEnd = self::convertDateThToInter($request->dateEnd)->format('d-M-Y');
        $invoiceDate = self::convertDateThToInter($request->invoiceDate)->format('d-M-Y');
        $batchNo = $request->invoiceBatch;

    	$result = self::callInterface($orgId, $company, $policyHeaderId, $year, $dateStart, $dateEnd, $invoiceDate, $batchNo);

        $data = [
            'status' => $result['status'],
            'msg' => $result['message'],
        ];

        return response()->json($data);
    }

    public function cancel()
    {
        return back()->with('success', 'Interface Success!');
    }

    public function checkReport(Request $request)
    {
        ini_set('max_execution_time', 1800);
        $orgId = $this->orgId; // 81;
        $company = $request->company;
        $policyHeaderId = $request->insuranceNo;
        $year = (int)$request->year - 543;
        $dateStart = self::convertDateThToInter($request->dateStart)->format('d-M-Y');
        $dateEnd = self::convertDateThToInter($request->dateEnd)->format('d-M-Y');
        
        $amount = 0;

    	$result = self::callReport($orgId, $company, $policyHeaderId, $year, $dateStart, $dateEnd);

        if($result['status'] == 'C'){
            $queryDateStart = self::convertDateThToInter($request->dateStart);
            $queryDateEnd = self::convertDateThToInter($request->dateEnd);

            $insurances = PtirCalculateInsurances::where('year', $year)
                ->selectRaw("sum(insurance_amount) as insurance_amount, sum(paid_amount) as paid_amount")
                ->whereDate('insurance_start_date', '>=', $queryDateStart)
                ->whereDate('insurance_end_date', '<=', $queryDateEnd)
                ->when($company, function($q, $company){
                    $q->where('company_code', $company);
                })
                ->when($policyHeaderId, function($q, $policyHeaderId){
                    $q->where('policy_set_header_id', $policyHeaderId);
                })
                ->with('header', 'line', 'company', 'assetGroup')
                ->where('interface_status', 'P')
                ->get();

            $amount = $insurances->sum('insurance_amount') - $insurances->sum('paid_amount');
        }

        $data = [
            'status' => $result['status'],
            'msg' => $result['message'],
            'amount' => $amount,
        ];

        return response()->json($data);
    }

    public function report(Request $request)
    {
        ini_set('max_execution_time', 1800);
        $company = $request->company;
        $policyHeaderId = $request->insuranceNo;
        $thYear = $request->year;
        $year = (int)$request->year - 543;

        $queryDateStart = self::convertDateThToInter($request->dateStart);
        $queryDateEnd = self::convertDateThToInter($request->dateEnd);

        $dateStart = self::convertMonthToTh($request->dateStart);
        $dateEnd = self::convertMonthToTh($request->dateEnd);

        $sumPaidAmountFromIRR0003 = 0; // self::getSumPaidAmount($year, $queryDateStart, $queryDateEnd, $company, $policyHeaderId);

        $balance = self::getSumAmountFromBalance($year, $queryDateStart, $queryDateEnd, $company, $policyHeaderId);

        $insuranceNos = self::getQuery($year, $queryDateStart, $queryDateEnd, $company, $policyHeaderId)
            ->select('policy_set_header_id')
            ->groupBy('policy_set_header_id')
            ->distinct()
            ->pluck('policy_set_header_id')
            ->toArray();
        $companyCodes = self::getQuery($year, $queryDateStart, $queryDateEnd, $company, $policyHeaderId)
            ->select('company_code')
            ->groupBy('company_code')
            ->distinct()
            ->pluck('company_code')
            ->toArray();
        $companies = PtirCompanies::whereIn('company_number' , $companyCodes)->get();

        $rate = 100;
        if($companies->count() == 1){
            $rate = self::getQuery($year, $queryDateStart, $queryDateEnd, $company, $policyHeaderId)
            ->whereNotNull('company_code')
            ->first()
            ->percent_remaining;
        }
        $rate = ((int)$rate) / 100;

        $headerSet = self::getQuery($year, $queryDateStart, $queryDateEnd, $company, $policyHeaderId)
            ->select('header_id')
            ->groupBy('header_id')
            ->distinct()
            ->pluck('header_id')
            ->toArray();
        $stocks = PtirStockHeaders::whereIn('header_id', $headerSet)
        ->select('policy_set_description')
        ->groupBy('policy_set_description')
        ->distinct()
        ->pluck('policy_set_description')
        ->toArray();

        $lineSet = self::getQuery($year, $queryDateStart, $queryDateEnd, $company, $policyHeaderId)
            ->select('line_id')
            ->groupBy('line_id')
            ->distinct()
            ->pluck('line_id')
            ->toArray();
        $premiumRate = PtirStockLines::select('premium_rate')->distinct()->whereIn('line_id', $lineSet)->pluck('premium_rate')->toArray();

        $insurances = PtirCalculateInsurances::selectRaw("
                ptir_calculate_insurances.asset_group_code,
                ptir_calculate_insurances.stock_list_description,
                (select nvl(b.actual_coverage_amount, 0) 
                    from ptir_cal_actual_coverage_v b
                    where b.asset_group_code = ptir_calculate_insurances.asset_group_code
                    and b.stock_list_description = ptir_calculate_insurances.stock_list_description
                ) actual_coverage_amount,
                sum(ptir_calculate_insurances.insurance_amount) insurance_amount,
                sum(ptir_calculate_insurances.paid_amount) paid_amount,
                sum(ptir_calculate_insurances.period_name_1) period_name_1,
                sum(ptir_calculate_insurances.period_name_2) period_name_2,
                sum(ptir_calculate_insurances.period_name_3) period_name_3,
                sum(ptir_calculate_insurances.period_name_4) period_name_4,
                sum(ptir_calculate_insurances.period_name_5) period_name_5,
                sum(ptir_calculate_insurances.period_name_6) period_name_6,
                sum(ptir_calculate_insurances.period_name_7) period_name_7,
                sum(ptir_calculate_insurances.period_name_8) period_name_8,
                sum(ptir_calculate_insurances.period_name_9) period_name_9,
                sum(ptir_calculate_insurances.period_name_10) period_name_10,
                sum(ptir_calculate_insurances.period_name_11) period_name_11,
                sum(ptir_calculate_insurances.period_name_12) period_name_12
            ")
            ->where('ptir_calculate_insurances.year', $year)
            ->where('ptir_calculate_insurances.interface_status', 'P')
            ->whereDate('ptir_calculate_insurances.insurance_start_date', '>=', $queryDateStart)
            ->whereDate('ptir_calculate_insurances.insurance_end_date', '<=', $queryDateEnd)
            ->when($company, function($q, $company) {
                $q->where(function($p) use ($company) {
                    $p->where('ptir_calculate_insurances.company_code', $company)
                    ->orWhereNull('ptir_calculate_insurances.company_code');
                });
            })
            ->when($policyHeaderId, function($q, $policyHeaderId){
                $q->where('ptir_calculate_insurances.policy_set_header_id', $policyHeaderId);
            })
            ->orderBy('ptir_calculate_insurances.asset_group_code')
            ->orderBy('ptir_calculate_insurances.stock_list_description')
            ->groupBy('ptir_calculate_insurances.asset_group_code')
            ->groupBy('ptir_calculate_insurances.stock_list_description')
            ->get();
        
        $data = $insurances->groupBy([function ($item) {
            return optional($item->assetGroup)->description;
        }, function ($item) {
            return $item->stock_list_description;
        }]);

        $groupDatas = [];
        $maxLine = 12;
        $page = 1;
        $lineNum = 0;

        foreach ($data as $assetGroup => $groupDescriptions) {
            if($lineNum >= $maxLine){
                $lineNum = 0;
                $page++;
            }
            $lineNum++;
            foreach ($groupDescriptions as $groupDescription => $lines) {
                if($lineNum >= $maxLine){
                    $lineNum = 1;
                    $page++;
                }
                $lineNum++;
                $groupDatas[$page][$assetGroup][$groupDescription] = $lines;
            }
        }
        // dd($groupDatas, $rate);

        $pdf = PDF::loadView('ir.calculate-insurance.report._template', 
                        compact(
                            'insurances',
                            'groupDatas',
                            'dateStart',
                            'dateEnd',
                            'thYear',
                            'premiumRate',
                            'insuranceNos',
                            'balance',
                            'sumPaidAmountFromIRR0003',
                            'stocks',
                            'rate',
                            'policyHeaderId',
                            'companies',
                        ))
                    ->setPaper('a4')
                    ->setOrientation('landscape')
                    ->setOption('margin-bottom', 0);
        return $pdf->stream('invoice.pdf');

        // return view('ir.calculate-insurance.report');
    }

    private static function getQuery($year, $queryDateStart, $queryDateEnd, $company, $policyHeaderId)
    {
        return PtirCalculateInsurances::where('year', $year)
        ->where('interface_status', 'P')
        ->whereDate('insurance_start_date', '>=', $queryDateStart)
        ->whereDate('insurance_end_date', '<=', $queryDateEnd)
        ->when($company, function($q, $company) {
            $q->where(function($p) use ($company) {
                $p->where('company_code', $company)
                ->orWhereNull('company_code');
            });
        })
        ->when($policyHeaderId, function($q, $policyHeaderId){
            $q->where('policy_set_header_id', $policyHeaderId);
        });
    }

    private static function convertDateThToInter($dateTime)
    {
        $year = (int)\DateTime::createFromFormat(trans('date.format'), $dateTime)->format('Y') - 543;
        $month = (int)\DateTime::createFromFormat(trans('date.format'), $dateTime)->format('m');
        $date = (int)\DateTime::createFromFormat(trans('date.format'), $dateTime)->format('d');

        $dateTime = new Carbon($year.'-'.$month.'-'.$date);

        return $dateTime;
    }

    private static function convertMonthToTh($dateTime)
    {
        $monthArray = array(
            "1"=>"มกราคม",
            "2"=>"กุมภาพันธ์",
            "3"=>"มีนาคม",
            "4"=>"เมษายน",
            "5"=>"พฤษภาคม",
            "6"=>"มิถุนายน", 
            "7"=>"กรกฎาคม",
            "8"=>"สิงหาคม",
            "9"=>"กันยายน",
            "10"=>"ตุลาคม",
            "11"=>"พฤศจิกายน",
            "12"=>"ธันวาคม"
        );

        $year = (int)\DateTime::createFromFormat(trans('date.format'), $dateTime)->format('Y');
        $month = (int)\DateTime::createFromFormat(trans('date.format'), $dateTime)->format('m');
        $date = (int)\DateTime::createFromFormat(trans('date.format'), $dateTime)->format('d');

        $dateTime = $date.' '.$monthArray[$month].' '.$year;

        return $dateTime;
    }

    private static function callReport($orgId, $company, $policyHeaderId, $year, $dateStart, $dateEnd)
    {
        $user_id = \Auth::user()->user_id;
        $dateStart = strtoupper($dateStart);
        $dateEnd = strtoupper($dateEnd);

        try {

            $db     =   \DB::connection('oracle')->getPdo();

            $sql    =   "
                        DECLARE
                            LV_RETURN_STATUS      VARCHAR2(100)   :=  NULL;
                            LV_RETURN_MSG         VARCHAR2(4000)  :=  NULL;
                        BEGIN
                            PTIR_WEB_CAL_INSURANCE_PKG.REPORT_CALCULATE_INSURANCE(
                                I_ORG_ID                    => :org_id              --  81
                                ,I_USER_ID                  => :user_id             --  25
                                ,I_COMPANY_CODE             => :company             --  '01'
                                ,I_POLICY_SET_HEADER_ID     => :policy_header_id    --  PTIR_POLICY_SET_HEADERS.POLICY_SET_HEADER_ID
                                ,I_YEAR                     => :year                --  2021
                                ,I_INSURANCE_START_DATE     => :start_date          --Format DD-MON-YYYY
                                ,I_INSURANCE_END_DATE       => :end_date            --Format DD-MON-YYYY
                                ,O_RETURN_STATUS            => :LV_RETURN_STATUS
                                ,O_RETURN_MSG               => :LV_RETURN_MSG
                            );                          
                        END;
                        ";

            // $sql = preg_replace("/[\r\n]*/","",$sql);
            $stmt = $db->prepare($sql);
            $result = [];
            $stmt->bindParam(':org_id', $orgId, \PDO::PARAM_STR);
            $stmt->bindParam(':user_id', $user_id, \PDO::PARAM_STR);
            $stmt->bindParam(':company', $company, \PDO::PARAM_STR);
            $stmt->bindParam(':policy_header_id', $policyHeaderId, \PDO::PARAM_STR);
            $stmt->bindParam(':year', $year, \PDO::PARAM_STR);
            $stmt->bindParam(':start_date', $dateStart, \PDO::PARAM_STR);
            $stmt->bindParam(':end_date', $dateEnd, \PDO::PARAM_STR);

            $stmt->bindParam(':LV_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 100);
            $stmt->bindParam(':LV_RETURN_MSG', $result['message'], \PDO::PARAM_STR, 4000);
            $stmt->execute();

            $db = null;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 1);
        }

        return $result;
    }

    private static function callInterface($orgId, $company, $policyHeaderId, $year, $dateStart, $dateEnd, $invoiceDate, $batchNo)
    {
        $user_id = \Auth::user()->user_id;
        $dateStart = strtoupper($dateStart);
        $dateEnd = strtoupper($dateEnd);
        $invoiceDate = strtoupper($invoiceDate);

        try {

            $db     =   \DB::connection('oracle')->getPdo();

            $sql    =   "
                        DECLARE
                            LV_RETURN_STATUS      VARCHAR2(100)   :=  NULL;
                            LV_RETURN_MSG         VARCHAR2(4000)  :=  NULL;
                        BEGIN
                            PTIR_WEB_CAL_INSURANCE_PKG.INTERFACE_CALCULATE_INSURANCE (
                                I_ORG_ID                    =>  :org_id
                                , I_USER_ID                 =>  :user_id
                                , I_COMPANY_CODE            =>  :company
                                , I_POLICY_SET_HEADER_ID    =>  :policy_header_id
                                , I_YEAR                    =>  :year
                                , I_INSURANCE_START_DATE    =>  :start_date     --Format DD-MON-YYYY
                                , I_INSURANCE_END_DATE      =>  :end_date       --Format DD-MON-YYYY
                                , I_INVOICE_DATE            =>  :invoice_date   --Format DD-MON-YYYY
                                , I_GL_DATE                 =>  :gl_date        --Format DD-MON-YYYY
                                , I_BATCH_NO                =>  :batch_no
                                , O_RETURN_STATUS           =>  :LV_RETURN_STATUS
                                , O_RETURN_MSG              =>  :LV_RETURN_MSG
                            );
                        END;
                        ";

            // $sql = preg_replace("/[\r\n]*/","",$sql);
            $stmt = $db->prepare($sql);
            $result = [];
            $stmt->bindParam(':org_id', $orgId, \PDO::PARAM_STR);
            $stmt->bindParam(':user_id', $user_id, \PDO::PARAM_STR);
            $stmt->bindParam(':company', $company, \PDO::PARAM_STR);
            $stmt->bindParam(':policy_header_id', $policyHeaderId, \PDO::PARAM_STR);
            $stmt->bindParam(':year', $year, \PDO::PARAM_STR);
            $stmt->bindParam(':start_date', $dateStart, \PDO::PARAM_STR);
            $stmt->bindParam(':end_date', $dateEnd, \PDO::PARAM_STR);
            $stmt->bindParam(':invoice_date', $invoiceDate, \PDO::PARAM_STR);
            $stmt->bindParam(':gl_date', $invoiceDate, \PDO::PARAM_STR);
            $stmt->bindParam(':batch_no', $batchNo, \PDO::PARAM_STR);

            $stmt->bindParam(':LV_RETURN_STATUS', $result['status'], \PDO::PARAM_STR, 100);
            $stmt->bindParam(':LV_RETURN_MSG', $result['message'], \PDO::PARAM_STR, 4000);
            $stmt->execute();

            $db = null;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 1);
        }

        return $result;
    }

    private static function getSumPaidAmount($year, $queryDateStart, $queryDateEnd, $company, $policyHeaderId)
    {
        $header = PtirStockHeaders::selectRaw('distinct header_id')
        ->where('program_code', 'IRP0001')
        ->where('year', $year)
        ->when($policyHeaderId, function($q) use ($policyHeaderId) {
            $q->where('policy_set_header_id', $policyHeaderId);
        })
        ->whereIn('status', ["INTERFACE", "CONFIRMED"])
        ->pluck('header_id')
        ->toArray();

        $data = PtirStockLinesView::selectRaw("
            sum(
                case 
                    when ptir_stock_lines_v.line_type = 'INVENTORY' then
                        ptir_stock_lines_v.coverage_amount * (ptir_policy_group_lines.premium_rate * 0.01) * (ptir_policy_group_lines.prepaid_insurance *0.01)
                    else 
                        ptir_stock_lines_v.coverage_amount * (ptir_policy_group_lines.premium_rate * 0.01) * (ptir_stock_lines_v.calculate_days / 365) * (ptir_policy_group_lines.prepaid_insurance *0.01)
                end 
            ) paid_amount
        ")
        ->leftJoin('ptir_stock_headers', 'ptir_stock_headers.header_id', 'ptir_stock_lines_v.header_id')
        ->leftJoin('ptir_policy_group_sets', 'ptir_policy_group_sets.policy_set_header_id', 'ptir_stock_headers.policy_set_header_id')
        ->leftJoin('ptir_policy_group_lines', function($join) use($year)
        {
            $join->on('ptir_policy_group_lines.group_header_id', 'ptir_policy_group_sets.group_header_id');
            $join->on('ptir_policy_group_lines.year', $year);
        })
        ->whereIn('ptir_stock_lines_v.header_id', $header)
        ->first()->paid_amount;

        return $data;
    }

    private static function getSumAmountFromBalance($year, $queryDateStart, $queryDateEnd, $company, $policyHeaderId)
    {
        $data = [];

        for ($loop = 0; $loop < 12; $loop++) {

            $month = (($loop+9)%12)+1;
            $period =  in_array($month, [10,11,12]) ? ((int)$year - 1) . '-' . $month .'-1' : ((int)$year) . '-' . $month.'-1';
            $periodName = Carbon::createFromFormat('Y-m-d', $period)->format('M-y');

            $from = $policyHeaderId ? $policyHeaderId : 1;
            $to = $policyHeaderId ? $policyHeaderId : 2;
            $result = self::callPackage($year, $periodName, $from, $to);

            $query = StockBalanceReport::where('web_batch_no', $result['web_batch_no']);

            $data[$loop+1] = $query->sum('net_amount');
        }

        return $data; 
    }

    private static function callPackage($year, $periodName, $policySetHeaderIdFrom, $policySetHeaderIdTo)
    {
        $userId                = auth()->user()->fnd_user_id;

        $db = \DB::connection('oracle')->getPdo();
        $sql = "
            declare

                V_WEB_BATCH_NO     VARCHAR2(250) ;  
                V_RETURN_STATUS    VARCHAR2(1) ; 
                V_RETURN_MSG       VARCHAR2(4000) ; 

            begin 
                
                dbms_output.put_line('PTIR_ASSET_BALANCE_RPT.BUILD_DATA ');
                
                PTIR_STOCK_BALANCE_RPT.BUILD_DATA(P_YEAR => '{$year}'
                                                , P_PERIOD_NAME => '{$periodName}'
                                                , P_POLICY_SET_H_FROM_ID =>  '{$policySetHeaderIdFrom}'
                                                , P_POLICY_SET_H_TO_ID   => '{$policySetHeaderIdTo}' 
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
        $result = [];
        $sql = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':v_web_batch_no', $result['web_batch_no'], \PDO::PARAM_STR, 4000);
        $stmt->bindParam(':v_return_status', $result['status'], \PDO::PARAM_STR, 100);
        $stmt->bindParam(':v_return_msg', $result['msg'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $result;
    }
}
