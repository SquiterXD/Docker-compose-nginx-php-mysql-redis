<?php

namespace App\Http\Controllers\CT\Reports;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

use DB;
use PDO;

use App\Exports\CT\CTR0039;
use App\Exports\CT\CTR0040;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class CTR0040Controller extends Controller
{
    const PROGRAME_CODE = 'CTR0040';

    public function getData($request)
    {
        $data   = [];
        $result = array();
        $db     = DB::connection('oracle')->getPdo();
        $p_period_year = $request['period_year'];

        $sql = "declare		
        v_rpt_id                    number := NULL;		
        v_status                    varchar2(50) := NULL;		
        v_err_msg                   varchar2(2000) := NULL;		
        begin		
            ptct_allocation_rpt.ctr0040_main(p_period_year => {$p_period_year},		
                                            p_rpt_id => :v_rpt_id,		
                                            p_status => :v_status,		
                                            p_err_msg => :v_err_msg);
        end;
        ";

        $sql  = preg_replace("/[\r\n]*/", "", $sql);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':v_rpt_id', $result['v_rpt_id'], PDO::PARAM_INT);
        $stmt->bindParam(':v_status', $result['v_status'], PDO::PARAM_STR);
        $stmt->bindParam(':v_err_msg', $result['v_err_msg'], PDO::PARAM_STR);
        $stmt->execute();
        if($result['v_rpt_id'] != '') {
            $data = \DB::table('ptct_ctr0040_rpt')->where('rpt_id', $result['v_rpt_id'])->get();
        } 
        return $data = collect($data);
    }
    public function CTR0040EXCEL()
    {
        $request = request()->all();
        $data =$this->getData(request()->all());
        return Excel::download(new CTR0040($data), self::PROGRAME_CODE . '.xlsx');
    }
}
