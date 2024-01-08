<?php
namespace App\Http\Controllers\OM\Reports;
use App\Http\Controllers\Controller;
use App\Models\ProgramInfo;
use DB;
use PDF;

class OMR0068Controller extends Controller{
	public function export($programCode, $request){
        $datas=$this->create($programCode, $request);
        $pdf = PDF::loadView('om.reports.omr0068.pdf.index',$datas)
            ->setPaper('a4','landscape')
            ->setOption('header-right',"\n\n\n[page]/[topage] ")
            ->setOption('header-font-name',"THSarabunNew")
            ->setOption('header-font-size',13)
            ->setOption('header-spacing',3)
            ->setOption('margin-bottom', 10);
        return $pdf->stream($programCode.'.pdf');
    }

	public function create($programCode, $request){
        $df=$request['date_f'];
        $dt=$request['date_t'];
        $bank=$request['bank'];
        $date_f = date('Y-m-d',strtotime(str_replace('/','-',$df)));
        $date_t = date('Y-m-d',strtotime(str_replace('/','-',$dt)));
        $thDate_f = parseToDateTh($df);
        $thDate_t = parseToDateTh($dt);
        $remark = $request['remark'];

        $progReport = ProgramInfo::where('program_code',$programCode)->first();
        $progTitle = $progReport->description;
        $progPara[0]="วันที่ $thDate_f ถึงวันที่ $thDate_t";
        $sql_con=($bank!="")?" and d.bank_number='$bank'":"";
        $sql_con.=($df!="")?" and (trunc(h.payment_date) between to_date('{$date_f}','yyyy-mm-dd') and to_date('{$date_t}','yyyy-mm-dd')) ":"";
        
        $tb_view="
            select
                r.lookup_code bank_no,
                r.meaning bank_name,
                sum(d.payment_amount) amt
            from ptom_payment_details d
            left join ptom_payment_headers h on (h.payment_header_id=d.payment_header_id)
            left join ptom_receipt_rept_bank_desc_v r on r.description =d.bank_desc
            where h.sales_classification_code='Domestic'
                and h.payment_status='Confirm'
               {$sql_con}
               group by r.lookup_code,r.meaning
               order by r.lookup_code,r.meaning
        ";
        $data = DB::table(DB::raw("({$tb_view}) a"))->get();
        $datas=compact('data','programCode','progTitle','progPara','remark');
        return $datas;
    }
}
