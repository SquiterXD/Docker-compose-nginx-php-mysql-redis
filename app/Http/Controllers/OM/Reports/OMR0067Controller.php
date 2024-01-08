<?php

namespace App\Http\Controllers\OM\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProgramInfo;
use DB;
use PDF;

class OMR0067Controller extends Controller
{
    public function export($programCode, $request){
        $arrData = $this->queryData($programCode, $request);
        $pdf = PDF::loadView('om.reports.omr0067.pdf.index',$arrData)
                ->setPaper('a4','landscape')
                ->setOption('header-right',"\n\n\n[page]/[topage] ")
                ->setOption('header-font-name',"THSarabunNew")
                ->setOption('header-font-size',13)
                ->setOption('header-spacing',3)
                ->setOption('margin-bottom', 10);
        return $pdf->stream($programCode.'.pdf');
    }

    public function queryData($programCode, $request){
        $df         = $request['date_f'];
        $dt         = $request['date_t'];
        $bank       = $request['bank'];
        $date_f     = date('Y-m-d',strtotime(str_replace('/','-',$df)));
        $date_t     = date('Y-m-d',strtotime(str_replace('/','-',$dt)));
        $thDate_f   = parseToDateTh($df);
        $thDate_t   = parseToDateTh($dt);
        // $remark     = $request['remark'];

        $progReport     = ProgramInfo::where('program_code',$programCode)->first();
        $progTitle      = $progReport->description;
        $progPara[0]    = "วันที่ $thDate_f ถึงวันที่ $thDate_t";
        $sql_con        = ($bank!="")?" and d.bank_number='$bank'":"";
        $sql_con.=($df!="")?" and (trunc(h.payment_date) between to_date('{$date_f}','yyyy-mm-dd') and to_date('{$date_t}','yyyy-mm-dd')) ":"";
        $tb_view = "
            select
                d.bank_number bank_no,
                d.bank_desc bank_name,
                sum(d.payment_amount * d.conversion_rate) amt
            from ptom_payment_details d
            left join ptom_payment_headers h on (h.payment_header_id=d.payment_header_id)
            where h.sales_classification_code='Export'
                and h.payment_status='Confirm'
               {$sql_con}
            group by d.bank_number,d.bank_desc
            order by d.bank_number,d.bank_desc
        ";
        $data   = DB::table(DB::raw("({$tb_view}) a"))->get();
        $arrData  = compact('data','programCode','progTitle','progPara');
        return $arrData;
    }
}
