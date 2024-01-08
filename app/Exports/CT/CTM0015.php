<?php

namespace App\Exports\CT;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Models\CT\PtctMfgBatchGenWipend;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Arr;
use DB;
use PDO;

use App\Models\CT\CTM0015RPT;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use App\Models\CT\PtctCostCenterV;

class CTM0015 implements FromView, ShouldAutoSize, WithColumnFormatting
{
    public function columnFormats(): array
    {
        return [
            'D' => '#,##0.00',
            'E' => '#,##0.00',
            'F' => '#,##0.000',
            'G' => '#,##0.000',
            'H' => '#,##0.00',
            'I' => '#,##0.000000000',
            'J' => '#,##0.00',
            'K' => '#,##0.000000000',
            'L' => '#,##0.00',
            'M' => '#,##0.000000000',
            'N' => '#,##0.00',
            'O' => '#,##0.000000000'
        ];
    }

    public function view(): View
    {   
        $year = Arr::get(request()->all(), 'year');
        $cc_code_from       = Arr::get(request()->all(), 'cc_code_from');
        $cc_code_to         = Arr::get(request()->all(), 'cc_code_to');
        $version_no         = Arr::get(request()->all(), 'version_no');
        $plan_version_no    = Arr::get(request()->all(), 'plan_version_no');
        $nowDateTh = parseToDateTh(now());
        $yearTh = date("Y",strtotime($year+543));
        // $quantity_cc = PtctCostCenterV::whereBetween('cost_code', [$cc_code_from , $cc_code_to]  )->value('quantity');
        $webBatchNo = date("YmdHis");
      
        $db = DB::connection('oracle')->getPdo();
        $sql  = "
                    DECLARE
                    P_RETURN_STATUS         varchar2(1) := NULL;
                    P_RETURN_MESSAGE        varchar2(1000) := NULL;
                    v_debug                 NUMBER :=1;
                    
                    BEGIN
                    dbms_output.put_line('---------------------  S T A R T. -------------------');
                    
                    PTCT_CTM0015_RPT_PKG.MAIN(  ERRBUF                  => :P_RETURN_STATUS
                                                ,P_YEAR                 => '{$year}'                 
                                                ,P_cc_code_from           => '{$cc_code_from}'
                                                ,P_cc_code_to              => '{$cc_code_to}'
                                                ,P_version_no              => '{$version_no}'
                                                ,P_plan_version_no      => '{$plan_version_no}'
                                                ,P_WEB_BATCH_NO         => '{$webBatchNo}'  ) ;
                    
                    dbms_output.put_line('OUTPUT :'||  :P_RETURN_STATUS 
                                        ||' MSG  :'||  :P_RETURN_MESSAGE  );
                                                
                    
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
    
        // $quantity_cc = CTM0015RPT::where('web_batch_no',$webBatchNo)->value('cost_uom_code');
      

        $dataList = CTM0015RPT::where('web_batch_no',$webBatchNo)->get();
        $dataListHeader = CTM0015RPT::select('code_dis','cost_uom_code')
                                        ->where('web_batch_no',$webBatchNo)
                                        ->groupBy('code_dis','cost_code','cost_uom_code')
                                        ->orderByRaw('cost_code')
                                        ->get();
        $time =date("H:i");
        $nowDateTh =$nowDateTh.' '.$time;
        return  view('ct.reports.ctr0015.excel.index', compact( 'dataList', 
                                                                'nowDateTh', 
                                                                'yearTh', 
                                                                // 'quantity_cc',
                                                                'dataListHeader'));
    }

}
