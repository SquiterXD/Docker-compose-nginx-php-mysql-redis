<?php

namespace App\Http\Controllers\CT\Reports;

use App\Exports\CT\CTR0012;
use App\Exports\CT\CTR0032;
use App\Exports\CT\PDR0003;
use App\Http\Controllers\Controller;
use App\Models\OM\CreditNote\CreditGroupModel;
use App\Models\OM\DebtDomV;
use App\Models\OM\PaymentDomV;
use App\Models\OM\PaymentHeader;
use App\Models\PD\PtpdDetailsWrappersBlendV;
use App\Models\PD\PtpdSummaryFMLCigaretteV;
use App\Models\ProgramInfo;
use Carbon\Carbon;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDO;

class OMR0071Controller extends Controller
{


    public function OMR0071($programcode, Request $request)
    {
        $arrData = $this->queryData($programcode, $request);
        $pdf = PDF::loadView('om.reports.omr0067.pdf.index',$arrData)
                ->setPaper('a4','landscape')
                ->setOption('header-right',"\n\n\n[page]/[topage] ")
                ->setOption('header-font-name',"THSarabunNew")
                ->setOption('header-font-size',13)
                ->setOption('header-spacing',3)
                ->setOption('margin-bottom', 10);
        // return view('om.reports.omr0067.pdf.index',$arrData);
        return $pdf->stream($programcode.'.pdf');
    }
    public function queryData($programCode, $request){
        $df         = $request['date_f'];
        $dt         = $request['date_t'];
        $bank       = $request['bank'];
        
        $date_f     = date('Y-m-d',strtotime(str_replace('/','-',$df)));
        $date_t     = date('Y-m-d',strtotime(str_replace('/','-',$dt)));
        $thDate_f   = parseToDateTh($df);
        $thDate_t   = parseToDateTh($dt);
        $remark     = $request['remark'];

        $progReport     = ProgramInfo::where('program_code',$programCode)->first();
        $progTitle      = $progReport->description;
        $progPara[0]    = "ประจำวันที่ $thDate_f";
        $sql_con        = ($bank!="")?" and d.bank_number='$bank'":"";
        $sql_con.=($df!="")?" and (trunc(h.payment_date) = to_date('{$date_f}','yyyy-mm-dd')) ":"";
        $tb_view = "
            select
                d.bank_number bank_no,
                d.bank_desc bank_name,
                sum(d.payment_amount) amt,
                currency,
                conversion_rate
            from ptom_payment_details d
            left join ptom_payment_headers h on (h.payment_header_id=d.payment_header_id)
            where h.sales_classification_code='Export'
                and h.payment_status='Confirm'
               {$sql_con}
            group by d.bank_number,d.bank_desc, currency, conversion_rate
            order by d.bank_number,d.bank_desc
        ";
        $data   = DB::table(DB::raw("({$tb_view}) a"))->get();
        $arrData  = compact('data','programCode','progTitle','progPara','remark');
        return $arrData;
    }
}
