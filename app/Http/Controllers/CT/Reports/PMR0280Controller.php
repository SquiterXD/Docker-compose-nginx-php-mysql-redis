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

class PMR0280Controller extends Controller
{
    protected $titleReport;
    protected $view = 'pm.reports.pmr0280.pdf.index';
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

    public function PDR0280($programcode, Request $request)
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
        $arrData['remark'] = request()->text;
        // return view($view,$arrData);
        $pdf = PDF::loadView($view,$arrData)
                ->setPaper('a4','landscape')
                ->setOption('header-right',"\n\n\n[page]/[topage] ")
                ->setOption('header-font-name',"THSarabunNew")
                ->setOption('header-font-size',11)
                ->setOption('header-spacing',3)
                ->setOption('margin-left', 5)
                ->setOption('margin-right', 5)
                ->setOption('margin-bottom', 10);
        // return view('om.reports.omr0067.pdf.index',$arrData);
        return $pdf->stream($programcode .'.pdf');
    }

    public function mappingDate($items) {
        return $items->map(function($item){
            $item->day = Carbon::createFromFormat('Y-m-d H:i:s', $item->payment_date)->format('d');
            return $item;
        });
    } 

    public function queryData($programCode, $request){
        $arrData = []; 
        $arrData['month'] = Carbon::createFromFormat('d/m/Y H:i:s', $request->month);
        $arrData['monthTh'] = $this->getMonthTh($arrData['month']->format('m'));
        $profie = getDefaultData();
        $departmentCode = optional($profie)->department_code ?? -9999;
        $organizationId = session('organization_id');

        $departmentdesc = '';
        $org = \App\Models\MtlParameter::where('organization_id', $organizationId)->first();
        if ($org) {
            $dept = \App\Models\PtglCoaDeptCodeAllV::where('department_code', $org->attribute11)->first();
            if ($dept) {
                $departmentdesc = $dept->description;
            }
        }

        $query = DB::table('PTPM_PRODUCT_PDR0280_V')
                    ->whereRaw("to_char(product_date, 'YYYYMM') = '" .$arrData['month']->format('Ym'). "'")
                    // ->where('item_number', '15012302')
                    ->where('organization_id', $organizationId)
                    ->orderBy('item_number')
                    ->get();
        $query2 = DB::table('PTPM_TRANSFER_G_PDR0280_V')
                    // ->where('transfer_date', 'LIKE', '%'.$arrData['month']->format('m-Y'))
                    ->whereRaw("to_char(to_date(transfer_date, 'DD-MM-YYYY'), 'YYYYMM') = '" .$arrData['month']->format('Ym'). "'")
                    ->where('organization_id', $organizationId)
                    ->get();
        $query1 = DB::table('PTPM_FREE_PDR0280_V')
                    // ->where('transaction_date', 'LIKE', '%'.$arrData['month']->format('m-Y'))
                    ->whereRaw("to_char(to_date(transaction_date, 'DD-MM-YYYY'), 'YYYYMM') = '" .$arrData['month']->format('Ym'). "'")
                    ->where('organization_id', $organizationId)
                    ->get();

        $sumLoss = DB::table('PTPM_LOSS_PDR0280_V')
                    // ->where('transaction_date', 'LIKE', '%'.$arrData['month']->format('m-Y'))
                    ->selectRaw("sum(loss_qty) loss_qty")
                    ->whereRaw("to_char(product_date, 'YYYYMM') = '" .$arrData['month']->format('Ym'). "'")
                    ->where('organization_id', $organizationId)
                    ->first();
        try {
            $arrData['maxDay'] = Carbon::createFromFormat('Y-m-d', substr($query->max('product_date'), 0, 10) )->format('d');
        } catch (\Throwable $th) {
            $arrData['maxDay'] = '1';
        }
        $arrData['items_free'] = $query1;
        $query = $query->map(function($i) use($query2){
            $obj = $query2->where('organization_id', $i->organization_id)->where('inventory_item_id', $i->inventory_item_id)->sum('send_qty');
            $i->transfer_v = $obj > 0 ? $obj : '0';
            return $i;
        });
        $arrData['items'] = $query->groupBy('cat_desc');
        $arrData['month'] = $arrData['month']->addYears(543);
        $arrData['departmentDesc'] = $departmentdesc;
        $arrData['sumLoss'] = optional($sumLoss)->loss_qty ?? 0;

        $firstDeptCode = substr($departmentCode, 0, 1);
        $arrData['showRemark'] = ($firstDeptCode != 2);
        return $arrData;
    }
}
