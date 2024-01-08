<?php
namespace App\Http\Controllers\OM\Reports;
use App\Http\Controllers\Controller;
use App\Models\ProgramInfo;
use DB;
use PDF;

class OMR0057Controller extends Controller{
	public function export($programCode, $request){
        $cus_id = $request['cs_customer'];
        $cs_delivery=$request['cs_delivery'];
        $cs_bank=$request['cs_bank'];
        $remark = $request['cs_remark'];

        $progReport = ProgramInfo::where('program_code',$programCode)->first();
        $progTitle = $progReport->description;
        $progPara[0]="";

        $tb_view="
            select
                d.customer_id cs_customer,
                c.delivery_date,
                c.customer_number,
                c.customer_name,
                c.province_name,
                d.account_number,
                d.bank_name,
                d.branch_name,
                d.short_bank_name bank
            from ptom_direct_debit d
            left join ptom_customers c on c.customer_id=d.customer_id
            where sale_channel='DOMESTIC'
            order by d.short_bank_name asc,c.delivery_date asc, c.customer_number asc
        ";

        $data = DB::table(DB::raw("({$tb_view}) a"))
            ->when($cus_id>0 && $cus_id<>'',function($q) use ($cus_id){ return $q->where('a.cs_customer',$cus_id);})
            ->when($cs_bank<>'',function($q) use ($cs_bank){ return $q->where('a.bank',$cs_bank);})
            ->when($cs_delivery<>'',function($q) use ($cs_delivery){ return $q->where('a.delivery_date',$cs_delivery);})
            ->get();

        $pdf = PDF::loadView('om.reports.omr0057.pdf.index',compact('data','programCode','progTitle','progPara','remark'))
            ->setPaper('a4','landscape')
            ->setOption('header-right',"\n\n\n[page]/[toPage] ")
            ->setOption('header-font-name',"THSarabunNew")
            ->setOption('header-font-size',13)
            ->setOption('header-spacing',3)
            ->setOption('margin-bottom', 10);
        return $pdf->stream($programCode. '.pdf');
    }
}
