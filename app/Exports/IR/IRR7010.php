<?php

namespace App\Exports\IR;
use FormatDate;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Models\CT\PtctMfgBatchGenWipend;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Arr;
use DB;
use PDO;
use App\Models\IR\ptir7010;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class IRR7010 implements FromView , WithStyles, ShouldAutoSize, WithColumnFormatting
{
    public function columnFormats(): array
    {
        return [
            'D' => '#,##0.00',
            'E' => '#,##0.00'//,
            // 'F' => '#,##0.000',
            // 'G' => '#,##0.000',
            // 'H' => '#,##0.00',
            // 'I' => '#,##0.000000000',
            // 'J' => '#,##0.00',
            // 'K' => '#,##0.000000000',
            // 'L' => '#,##0.00',
            // 'M' => '#,##0.000000000',
            // 'N' => '#,##0.00',
            // 'O' => '#,##0.000000000'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle(0)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        
    }
    public function view(): View
    {  
        $policy_set_header_from = Arr::get(request()->all(), 'policy_set_header_from');
            $policy_set_header_to = Arr::get(request()->all(), 'policy_set_header_to');
            $calculate_date = Arr::get(request()->all(), 'calculate_date');
            $company_from = Arr::get(request()->all(), 'company_from');
            $company_to = Arr::get(request()->all(), 'company_to');
            $location_code_from = Arr::get(request()->all(), 'location_code_from');
            $location_code_to = Arr::get(request()->all(), 'location_code_to');
            $status = Arr::get(request()->all(), 'status');
            $webBatchNo = date("YmdHis");
            
            $db = DB::connection('oracle')->getPdo();
            $sql  = "
                        DECLARE
                        P_RETURN_STATUS         varchar2(1) := NULL;
                        P_RETURN_MESSAGE        varchar2(1000) := NULL;
                        v_debug                 NUMBER :=1;
                        
                        BEGIN
                        dbms_output.put_line('---------------------  S T A R T. -------------------');
                        
                        ptir_irr7010_rpt_pkg.MAIN(  ERRBUF                      => :P_RETURN_STATUS
                                                    ,ERRMSG                     => :P_RETURN_MESSAGE
                                                    ,P_POLICY_from              => '{$policy_set_header_from}' 
                                                    ,P_POLICY_TO                =>  '{$policy_set_header_to}' 
                                                    ,P_calculate_date           =>  '{$calculate_date}' 
                                                    ,P_COMPANIES_CODE_FROM      =>  '{$company_from}' 
                                                    ,P_COMPANIES_CODE_TO        =>  '{$company_to}' 
                                                    ,P_LOCATION_CODE_FROM       =>  '{$location_code_from}' 
                                                    ,P_LOCATION_CODE_TO         =>  '{$location_code_to}' 
                                                    ,P_STATUS                   =>  '{$status}' 
                                                    ,P_WEB_BATCH_NO             =>  '{$webBatchNo}' 
                                                      ) ;

                        dbms_output.put_line('---------------------  E N D. -------------------');
                        EXCEPTION WHEN others THEN 
                            dbms_output.put_line(v_debug||'**call_error'||sqlerrm);                   
                        END ;
                    ";
            \Log::info($sql);
            $sql = preg_replace("/[\r\n]*/","",$sql);
            $stmt = $db->prepare($sql);

            $stmt->bindParam(':P_RETURN_STATUS', $result['P_RETURN_STATUS'], PDO::PARAM_STR, 20);
            $stmt->bindParam(':P_RETURN_MESSAGE', $result['P_RETURN_MESSAGE'], PDO::PARAM_STR, 2000);
            $stmt->execute();

            \Log::info('status', $result);
            
            $dataLists = ptir7010::where('web_batch_no',$webBatchNo)->get();
            
            
            $firstData = ptir7010::where('web_batch_no',$webBatchNo)->first();

            $toPage = ptir7010::select('policy_set')
                            ->where('web_batch_no',$webBatchNo)
                            ->groupBy('policy_set','company_name','user_policy_number','status')
                            ->get();
                            $toPage=count($toPage);
        
            $startDate=FormatDate::DateThai(substr($calculate_date,0,10));
            $endDate=FormatDate::DateThai(substr($calculate_date,22,10));
            $user = optional(auth()->user())->username ;

        return  view('ir.reports.irr7010.excel.index',compact('dataLists','firstData','startDate','endDate','user','toPage'));
    }

}
