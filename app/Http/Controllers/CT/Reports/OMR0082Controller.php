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

class OMR0082Controller extends Controller
{
    protected $titleReport;
    protected $view = 'ct.Reports.omr0082.pdf.index';
    protected $programe;
    protected $dateFormat = 'd/m/Y';

    public function rangDate($startDate ='', $endDate ='') {
        $startDate = Carbon::createFromFormat('d/m/Y', $startDate)->addYears(543)->format($this->dateFormat);
        if($endDate != '') {
            $endDate = Carbon::createFromFormat('d/m/Y', $endDate)->addYears(543)->format($this->dateFormat);
            return 'ประจำวันที่ '.$startDate.' ถึงวันที่ '. $endDate;
        }
        return 'ประจำวันที่ '.$startDate;
    }

    public function __construct()
    {
        // parent::__construct();
        
        $this->program = ProgramInfo::where('program_code', request()->program_code)->first();
        $this->titleReport = $this->program->description;
    }

    public function OMR0082($programcode, Request $request)
    {
        $program     = $this->program;
        $titleReport = $this->titleReport;
        $view        = $this->view;
        $arrData       = $this->queryData($programcode, $request);
        $arrData['program']     = $program;
        $arrData['titleReport'] = $titleReport;
        
        $arrData['date'] = $this->rangDate(request()->date_from, request()->date_to);
        // return view($view,$arrData);
        return Excel::download(new OMR0082MultiSheet($view, $arrData), \Str::limit($program->program_code.$titleReport, 30).'.xlsx');
    }
    public function queryData($programCode, $request){
        $arrData = [];
        $date_from = Carbon::createFromFormat('d/m/Y', $request->date_from)->format('Y-m-d');
        $date_to = Carbon::createFromFormat('d/m/Y', $request->date_to)->format('Y-m-d');
        $arrData['data'] = ProformaInvoiceHeader::whereRaw("TRUNC(pick_exchange_date) BETWEEN to_date('{$date_from}') AND to_date('{$date_to}')")->get();
        $arrData['master_uom'] = \DB::table('ptom_uom_conversions_v')->get();
        // $calBaseUnit =  collect(DB::select("
        //             select  (apps.inv_convert.inv_um_convert (
        //                             item_id           => '{$item->item_id}',
        //                             organization_id   => '164',
        //                             PRECISION         => NULL,
        //                             from_quantity     => '{$item->total}',
        //                             from_unit         => '{$item->uom_code}',
        //                             to_unit           => '{$request->cigarette}' ,
        //                             from_name         => NULL,
        //                             to_name           => NULL)
        //                     ) convert_order_carton
        //             from dual
        //         "))->first();
        $pi_header_id_arr = $arrData['data']->pluck('pi_header_id')->toArray();
        $pinvoiceLines = ProformaInvoiceLines::whereIn('pi_header_id', $pi_header_id_arr)->get();
        $item_id_arr = $pinvoiceLines->pluck('item_id')->toArray();
        $sequeceEcom = \DB::table('ptom_sequence_ecoms')->whereIn('item_id', $item_id_arr)->get();
        $arrData['data'] = $arrData['data']->map(function($item) use ($pinvoiceLines, $sequeceEcom){
            $tran_type = \DB::table('ptom_transaction_types_all_v')->where('order_type_id', $item->order_type_id)->first();
            $item->tran_type = $tran_type;
            $item->lines = $pinvoiceLines->where('pi_header_id', $item->pi_header_id);
            $item->lines = $item->lines->map(function($line) use($sequeceEcom) {
                $line->item_obj = $sequeceEcom->where('item_id', $line->item_id)->first();
                return $line;
            });
            return $item;
        });
        return $arrData;
    }
}
