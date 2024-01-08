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

class OMR0089Controller extends Controller
{
    protected $titleReport;
    protected $view = 'om.reports.omr0089.pdf.index';
    protected $programe;
    protected $dateFormat = 'd/m/Y';

    // public function rangDate($startDate ='', $endDate ='') {
    //     $startDate = Carbon::createFromFormat('d/m/Y', $startDate)->addYears(543)->format($this->dateFormat);
    //     if($endDate != '') {
    //         $endDate = Carbon::createFromFormat('d/m/Y', $endDate)->addYears(543)->format($this->dateFormat);
    //         return 'ประจำวันที่ '.$startDate.' ถึงวันที่ '. $endDate;
    //     }
    //     return 'ประจำวันที่ '.$startDate;
    // }

    public function __construct()
    {
        
        $this->program = ProgramInfo::where('program_code', request()->program_code)->first();
        $this->titleReport = $this->program->description;
    }

    public function OMR0089($programcode, Request $request)
    {
        $program     = $this->program;
        $titleReport = $this->titleReport;
        $view        = $this->view;
        $arrData       = [];
        $arrData       = $this->queryData($programcode, $request);
        $arrData['program']     = $program;
        $arrData['programCode']     = $program;
        $arrData['progTitle'] = $titleReport;
        $arrData['remark'] = request()->text;
        $arrData['month'] = request()->month_value;

        $arrData['thaimonths'] = ['01'=>'มกราคม','02'=>'กุมภาพันธ์','03'=>'มีนาคม','04'=>'เมษายน','05'=>'พฤษภาคม','06'=>'มิถุนายน',
                       '07'=>'กรกฎาคม','08'=>'สิงหาคม','09'=>'กันยายน','10'=>'ตุลาคม','11'=>'พฤศจิกายน','12'=>'ธันวาคม'];
        // $arrData['date'] = $this->rangDate(request()->date_from, request()->date_to);
        // return view($view,$arrData);
        $pdf = PDF::loadView($view,$arrData)
                ->setPaper('a4','landscape')
                ->setOption('header-right',"\n\n\n[page]/[topage] ")
                ->setOption('header-font-name',"THSarabunNew")
                ->setOption('header-font-size',13)
                ->setOption('header-spacing',3)
                ->setOption('margin-bottom', 10);
        // return view('om.reports.omr0067.pdf.index',$arrData);
        return $pdf->stream($programcode .'.pdf');
    }
    public function mappingCDate($items) {
        return $items->map(function($item){
            $item->day = Carbon::createFromFormat('Y-m-d H:i:s', $item->payment_date)->format('d');
            return $item;
        });
    } 
    public function mappingDate($items) {
        return $items->map(function($item){
            $item->day = Carbon::createFromFormat('Y-m-d H:i:s', $item->payment_date)->format('d');
            return $item;
        });
    } 

    public function queryData($programCode, $request){
        $arrData = [];
        $month = Carbon::createFromFormat('d/m/Y H:i:s', request()->month);
        $query =  DB::table('ptom_payment_dom_v')
        ->select("ptom_payment_dom_v.*", 'ptom_debt_dom_v.product_type_code', DB::raw("(select product_type_code FROM ptom_debt_dom_v ddv WHERE (CASE WHEN ptom_payment_dom_v.INVOICE_NUMBER <> '' THEN ddv.PICK_RELEASE_NO ELSE ddv.PREPARE_ORDER_NUMBER END) =(CASE WHEN ptom_payment_dom_v.INVOICE_NUMBER <> '' THEN ptom_payment_dom_v.INVOICE_NUMBER ELSE ptom_payment_dom_v.PREPARE_ORDER_NUMBER END)) p_product_type_code"))
        ->leftJoin('ptom_debt_dom_v', function($q) {
            $q->on('ptom_debt_dom_v.consignment_no', '=', 'ptom_payment_dom_v.invoice_number');
            $q->on('ptom_debt_dom_v.credit_group_code', '=', 'ptom_payment_dom_v.credit_group_code');
        })
        ->where('ptom_payment_dom_v.customer_type', '30')
        ->where('ptom_payment_dom_v.payment_number', 'not like', '%CN%')
        ->whereRaw("TO_CHAR(payment_date,'MM-YYYY') = '{$month->format('m-Y')}'")
        ->get();

        // dd($query);
        $query1 =  DB::table('ptom_payment_dom_v')
        ->select("ptom_payment_dom_v.*", 'ptom_debt_dom_v.product_type_code', 'ptom_debt_dom_v.debt_amount', 'ptom_debt_dom_v.pick_release_approve_date')
        ->leftJoin('ptom_debt_dom_v', function($q) {
            $q->on('ptom_debt_dom_v.prepare_order_number', '=', 'ptom_payment_dom_v.prepare_order_number');
            $q->on('ptom_debt_dom_v.credit_group_code', '=', 'ptom_payment_dom_v.credit_group_code');
        })
        ->whereNotIn('ptom_payment_dom_v.customer_type', ['30', '80'])
        // ->where('ptom_debt_dom_v.product_type_code',20)
        // ->whereNotIn('ptom_debt_dom_v.customer_type_id', ['30', '80'])
        ->where('ptom_payment_dom_v.payment_number', 'not like', '%CN%')
        ->whereRaw("TO_CHAR(payment_date,'MM-YYYY') = '{$month->format('m-Y')}'")
        // ->whereRaw("trunc(pick_release_approve_date) between to_date('10/28/2022' , 'MM-DD-YYYY') and to_date(' 10/28/ 2022' , 'MM-DD-YYYY')")
        ->get();
        // ทั่วไป'
        // $arrData['storeTypeGE'] = $query1->whereNotIn('customer_type', ['30', '80', '40']);
        $arrData['storeTypeGE'] = $query1;
        $arrData['storeTypeGE'] = $this->mappingCDate($arrData['storeTypeGE'])->sortBy('day');
        // สโมสร
        $arrData['storeTypeC'] = $query->where('customer_type', '30');
        $invoice_number_lists = $arrData['storeTypeC']->pluck('invoice_number')->toArray();
        $prepare_order_number_lists = $arrData['storeTypeC']->pluck('prepare_order_number')->toArray();
        $debtV = DB::table('ptom_debt_dom_v')->whereIn('consignment_no', $invoice_number_lists)->OrWhereIn('prepare_order_number', $prepare_order_number_lists)->get();
        $arrData['storeTypeC'] = $arrData['storeTypeC']->map(function($i) use($debtV){
            if($i->customer_type == 30 && $i->product_type_code == 10) {
                // $i = collect($i)->merge($debtV->where('consignment_no', $i->invoice_number)->first());
            }

            if($i->customer_type == 30 && $i->product_type_code == 20) {
                // $i = collect($i)->merge($debtV->where('prepare_order_number', $i->prepare_order_number)->first());
            }
            return $i;
        });
        $arrData['storeTypeC'] = $this->mappingDate($arrData['storeTypeC'])->sortBy('day');
        return $arrData;
    }
}
