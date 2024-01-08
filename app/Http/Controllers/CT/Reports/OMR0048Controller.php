<?php

namespace App\Http\Controllers\CT\Reports;

use App\Exports\CT\CTR0012;
use App\Exports\CT\CTR0032;
use App\Exports\CT\PDR0003;
use App\Exports\OM\OMR0082;
use App\Exports\OM\OMR0082MultiSheet;
use App\Http\Controllers\Controller;
use App\Models\OM\CreditNote\CreditGroupModel;
use App\Models\OM\DebtDomV;
use App\Models\OM\PaymentDomV;
use App\Models\OM\PaymentHeader;
use App\Models\OM\ProformaInvoiceHeader;
use App\Models\OM\ProformaInvoiceLines;
use App\Models\PD\PtpdDetailsWrappersBlendV;
use App\Models\PD\PtpdSummaryFMLCigaretteV;
use App\Models\ProgramInfo;
use Carbon\Carbon;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDO;

class OMR0048Controller extends Controller
{
    protected $titleReport;
    protected $view = 'om.reports.omr0048.pdf.index';
    protected $programe;
    protected $dateFormat = 'd/m/Y';

    public function getMonthTh($month) {
        $toInt = (int)($month);
        $months_th = ['' ,"มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
        return $months_th[$toInt];
    }
    public function __construct()
    {
        
        $this->program = ProgramInfo::where('program_code', request()->program_code)->first();
        $this->titleReport = $this->program->description;
    }

    public function OMR0048($programcode, Request $request)
    {
        
        $program     = $this->program;
        $titleReport = $this->titleReport;
        $view        = $this->view;
        $arrData       = [];

        $arrData       = $this->queryData($programcode, $request);
        $arrData['program']     = $program;
        $arrData['programCode']     = $program->program_code;
        $arrData['progTitle'] = $titleReport;
        // $arrData['date_from'] = Carbon::createFromFormat('d/m/Y H:i:s', $request->month);
        
        // return view($view,$arrData);
        $pdf = PDF::loadView($view,$arrData)
                ->setPaper('a4')
                ->setOption('header-right',"\n\n\n[page]/[topage] ")
                ->setOption('header-font-name',"THSarabunNew")
                ->setOption('header-font-size',11)
                ->setOption('header-spacing',0)
                ->setOption('margin-top',0)
                ->setOption('margin-bottom', 10);
        return $pdf->stream($programcode .'.pdf');
    }

    
    public function queryData($programCode, $request){
        $arrData = []; 
        $date_from = Carbon::createFromFormat('d/m/Y', $request->date_from);
        $date_to = Carbon::createFromFormat('d/m/Y', $request->date_to);
        $arrData['date_from'] = $date_from;
        $arrData['date_to'] = $date_to;
       
        $data = DB::select("select 
        product_type_code
        ,product_type_desc
        ,item_description
        ,sum(approve_quantity*10000) approve_quantity
        ,currency
        ,sum(grand_total) grand_total
        ,sum(tax) tax
        ,sum(sub_total) sub_total
        , (CASE WHEN product_type_code = 10 THEN 1 ELSE 2 END) group_product
        from ptom_so_outstanding_exp_v
        where trunc(pick_exchange_date) between to_date('{$date_from->format('m/d/Y')}','MM-DD-YYYY')
                                                                and to_date('{$date_to->format('m/d/Y')}','MM-DD-YYYY')
                                                                
        group by product_type_code
        ,product_type_desc
        ,item_description
        ,product_type_code
        ,currency
        ");
        
        $arrData['data']= collect($data);
        return $arrData;
    }
}
