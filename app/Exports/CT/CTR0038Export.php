<?php

namespace App\Exports\CT;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

use DB;

use App\Models\CT\PtctCtr0038;

class CTR0038Export implements FromView, ShouldAutoSize
{
    public function view(): View
    {
        $programCode = request()->program_code;
        $year        = request()->period_year;
        $data        = [];

        $query_date = \DB::select("select min(start_date) start_date, max(end_date) end_date from PT_PERIODS_V where period_year = {$year}");

        $db = \DB::connection('oracle')->getPdo();

        $sql = "
            declare     
                v_rpt_id                    number;     
                v_status                    varchar2(50);       
                v_err_msg                   varchar2(2000);     
            begin       
                ptct_allocation_rpt.ctr0038_main(p_period_year => {$year},     
                                                p_rpt_id => :v_rpt_id,       
                                                p_status => :v_status,       
                                                p_err_msg => :v_err_msg);        
                dbms_output.put_line('RPT ID : ' || v_rpt_id);      
                dbms_output.put_line('Status : ' || v_status);      
                dbms_output.put_line('Error : ' || v_err_msg);      
            end;
        ";

        logger($sql);
        $stmt = $db->prepare($sql);

        $result = [];
        $stmt->bindParam(':v_rpt_id', $result['rpt_id'], \PDO::PARAM_INT);
        $stmt->bindParam(':v_status', $result['status'], \PDO::PARAM_STR, 20);
        $stmt->bindParam(':v_err_msg', $result['message'], \PDO::PARAM_STR, 2000);
        $stmt->execute();

        logger($result);

        if ($result['status'] == 'S') {
            $data = PtctCtr0038::where('rpt_id', $result['rpt_id'])
                        ->where('tobacco_type', '!=', 'ไม่ระบุ')
                        ->orderBy('line_no')
                        ->get()
                        ->groupBy('tobacco_type');

            $data_ryo = PtctCtr0038::where('rpt_id', $result['rpt_id'])
                        ->where('tobacco_type', 'ไม่ระบุ')
                        ->orderBy('line_no')
                        ->get();
        } else {
            // dd('error');
            $data     = [];
            $data_ryo = [];
        }
        

        // dd('CTR0038Export xxx', $result, $year, $data, $data_ryo);
        return view('ct.Reports.ctr0038.export', compact('year', 'data', 'data_ryo', 'programCode', 'query_date'));
    }


    // public function styles(Worksheet $sheet)
    // {
    //     $sheet->getStyle('B2')->getFont()->setBold(true);
    // }

}

//App\Models\IR\Views\PtirStockHeadersView
