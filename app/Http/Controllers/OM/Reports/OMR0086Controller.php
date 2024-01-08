<?php
namespace App\Http\Controllers\OM\Reports;
use App\Http\Controllers\Controller;
use App\Models\ProgramInfo;
use DB;
use PDF;

class OMR0086Controller extends Controller{
	public function export($programCode, $request){
        $datas=$this->create($programCode, $request);
        $pdf = PDF::loadView('om.reports.omr0086.pdf.index',$datas)
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
        $cus_f=$request['customer_f'];
        $cus_t=$request['customer_t'];
        $date_f = date('Y-m-d',strtotime(str_replace('/','-',$df)));
        $date_t = date('Y-m-d',strtotime(str_replace('/','-',$dt)));
        $thDate_f = parseToDateTh($df);
        $thDate_t = parseToDateTh($dt);
        $remark = $request['remark'];

        $progReport = ProgramInfo::where('program_code',$programCode)->first();
        $progTitle = $progReport->description;
        $progPara[0]="ประจำวันที่ $thDate_f ถึงวันที่ $thDate_t";
        $sql_con=($cus_f!="" && $cus_t!="")?" and (c.customer_number between '$cus_f' and '$cus_t') ":"";

        $tb_view="
            select
                h.invoice_headers_number doc_no,
                TO_CHAR(h.invoice_date, 'dd/mm/yyyy','NLS_CALENDAR=''THAI BUDDHA'' NLS_DATE_LANGUAGE=THAI') pay_date,
                c.customer_number cus_no,
                c.customer_name cus_name,
                h.company_code office_no,
                a.meaning office_name,
                h.invoice_amount amt
            from ptom_invoice_headers h
            left join ptom_customers c on (c.customer_id=h.customer_id)
            left join ptom_club_association_v a on (a.lookup_code=h.company_code)
            where h.invoice_type='CN_TRANFER' and h.invoice_status='Confirm'  {$sql_con}
                and (trunc(h.invoice_date) between to_date('{$date_f}','yyyy-mm-dd') and to_date('{$date_t}','yyyy-mm-dd'))
            order by h.invoice_headers_number
        ";

        $tb_sum="
            select
                h.company_code office_no,
                a.meaning office_name,
                sum(h.invoice_amount) amt
            from ptom_invoice_headers h
            left join ptom_customers c on (c.customer_id=h.customer_id)
            left join ptom_club_association_v a on (a.lookup_code=h.company_code)
            where h.invoice_type='CN_TRANFER' and h.invoice_status='Confirm'  {$sql_con}
                and (trunc(h.invoice_date) between to_date('{$date_f}','yyyy-mm-dd') and to_date('{$date_t}','yyyy-mm-dd'))
            group by h.company_code,a.meaning
            order by h.company_code
        ";
        $data = DB::table(DB::raw("({$tb_view}) a"))->get();
        $sum= DB::table(DB::raw("({$tb_sum}) a"))->get();
        $datas=compact('data','sum','programCode','progTitle','progPara','remark');
        return $datas;
    }
}
