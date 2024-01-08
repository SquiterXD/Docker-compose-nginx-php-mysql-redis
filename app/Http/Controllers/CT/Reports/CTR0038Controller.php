<?php

namespace App\Http\Controllers\CT\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;
use DB;

use App\Models\CT\PtPeriodsV;
use App\Models\CT\PtctCtr0038;

use App\Exports\CT\CTR0038Export;

class CTR0038Controller extends Controller
{
    public function CTR0038Excel($programCode, $request)
    {
        // $result = $this->callPackage($request);
        // $data   = [];
        // $status = $result['status'];

        // if ($result['status'] == 'S') {
        //     $data = PtctCtr0038::where('rpt_id', $result['rpt_id'])
        //                 ->orderBy('line_no')
        //                 ->get();

        //     // dd(request()->all(), $result, $data);

        // } else {
        //     # code...
        // }

        return \Excel::download(new CTR0038Export($programCode), "{$programCode}.xlsx");

    }

    public function callpackage($request) {
        $year = $request->period_year;
        
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
        // $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $result = [];
        $stmt->bindParam(':v_rpt_id', $result['rpt_id'], \PDO::PARAM_INT);
        $stmt->bindParam(':v_status', $result['status'], \PDO::PARAM_STR, 20);
        $stmt->bindParam(':v_err_msg', $result['message'], \PDO::PARAM_STR, 2000);
        $stmt->execute();

        return $result;
    }
}
