<?php

namespace App\Http\Controllers\CT\Reports;

use App\Exports\CT\CTR0012;
use App\Exports\CT\CTR0032;
use App\Exports\CT\PDR0003;
use App\Exports\OM\OMR0062;
use App\Exports\OM\OMR0082;
use App\Exports\OM\OMR0082MultiSheet;
use App\Http\Controllers\Controller;
use App\Http\Controllers\OM\Reports\OMR0060Controller;
use App\Models\OM\APInterface;
use App\Models\OM\CreditNote\CreditGroupModel;
use App\Models\OM\DebtDomV;
use App\Models\OM\PaymentDomV;
use App\Models\OM\PaymentHeader;
use App\Models\OM\ProformaInvoiceHeader;
use App\Models\OM\ProformaInvoiceLines;
use App\Models\PD\PtpdDetailsWrappersBlendV;
use App\Models\PD\PtpdSummaryFMLCigaretteV;
use App\Models\OM\GLInterfaceModel;
use App\Models\OM\ARInterface;
use App\Models\Planning\GLPeriodV;
use App\Models\ProgramInfo;
use Carbon\Carbon;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDO;

class OMR0062Controller extends Controller
{
    protected $titleReport;
    protected $view = 'om.reports.omr0062.pdf.index';
    protected $programe;
    protected $dateFormat = 'd/m/Y';

    public function getMonthTh($month)
    {
        $toInt = (int)($month);
        $months_th = ['', "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
        return $months_th[$toInt];
    }
    public function __construct()
    {

        $this->program = ProgramInfo::where('program_code', request()->program_code)->first();
        $this->titleReport = $this->program->description;
    }

    public function migrateArrRma($rma) {
        $data = collect();
        $rma = $rma->map(function($i) {
            $customer = $i->customer;
            $i->lines = $i->lines->map(function($l) use($customer) {
                $l->customer = $customer;
                return $l;
            });
            return $i;
        });
        foreach($rma->pluck('lines') as $lines) {
            foreach($lines as $line) {
                // ราคาขาย ณ โรงงาน (บาท)
                $price_fact = $line->rma_quantity * $line->orderLine->unit_price *(-1);
                // ภาษีมูลค่าเพิ่ม (บาท)
                $tax = (($line->rma_quantity * $line->orderLine->attribute1) * 7 / 107)  * (-1);
                // ภาษีอบจ. (บาท)
                $org_tax = 0;
                if($line->customer->customer_type_id != 20 && $line->customer->province_code != 10) {
                    $org_tax = $line->rma_quantity * 93 * (-1);
                }
                // รายได้หลังหักภาษี อบจ. (บาท)
                $poa_tax = $price_fact - $tax - $org_tax;
                $item = [
                    'item_code' => $line->orderLine->item_code,
                    'item_description' => $line->orderLine->item_description,
                    'total_sale' => $line->rma_quantity * 1000 *(-1),  // ยอดจำหน่าย (มวน)
                    'price_fact' => $price_fact,  // ราคาขาย ณ โรงงาน (บาท)
                    'tax' => $tax,  // ภาษีมูลค่าเพิ่ม (บาท)
                    'price_less_tax' => $price_fact - $tax,  // รายได้ขายหักภาษีมูลค่าเพิ่ม (บาท)
                    'org_tax' => $org_tax,  // ภาษีอบจ. (บาท)
                    'poa_tax' => $poa_tax,  //รายได้หลังหักภาษี อบจ. (บาท)
                ];
                $data->push($item);
            }
        }
        return $data;
    }
    public function getRma($date) {
        $arSelect = ['quantity', 'amount', 'oaom_tax_adjust', 'description', 'pao_line_amount', 'item_code'];
        $result = ARInterface::select($arSelect)
        ->where('interface_type', 'Credit Memo')
        ->where('batch_source_name', 'ระบบขายในประเทศ')
        ->where('interface_status', 'C')
        ->whereNotNull('item_code')
        ->whereRaw("trunc(invoice_date) between to_date('{$date['start']}','yyyy-mm-dd') and to_date('{$date['end']}','yyyy-mm-dd')")
        ->get();
        $data = collect();
        foreach($result as $i) {
            $price_fact = $i->amount;
            $tax = $i->oaom_tax_adjust * (-1);
            $org_tax = $i->pao_line_amount * (-1);
            $poa_tax = $price_fact - $tax - $org_tax;
            $item = [
                'item_code' => $i->item_code,
                'item_description' => $i->description,
                'total_sale' => $i->quantity * 1000 *(-1),  // ยอดจำหน่าย (มวน)
                'price_fact' => $price_fact,  // ราคาขาย ณ โรงงาน (บาท)
                'tax' => $tax,  // ภาษีมูลค่าเพิ่ม (บาท)
                'price_less_tax' => $price_fact - $tax,  // รายได้ขายหักภาษีมูลค่าเพิ่ม (บาท)
                'org_tax' => $org_tax,  // ภาษีอบจ. (บาท)
                'poa_tax' => $poa_tax,  //รายได้หลังหักภาษี อบจ. (บาท)
            ];
            $data->push($item);
        }
        if(count($data) >0) {
            return $data;
        }
        $getRMA = (new OMR0060Controller)->getRMA($date);
        $rma = $this->migrateArrRma($getRMA);

        return $rma;
    }


    public function OMR0062($programcode, Request $request)
    {
        $program     = $this->program;
        $titleReport = $this->titleReport;
        $view        = $this->view;
        $arrData       = [];

        $arrData       = $this->queryData($programcode, $request);
        $arrData['program']     = $program;
        $arrData['programCode']     = $program->program_code;
        $arrData['progTitle'] = $titleReport;
        $arrData['remark'] = request()->note;
        $arrData['date_from'] = Carbon::createFromFormat('d/m/Y H:i:s', $request->month);
        $arrData['rma'] = $this->getRma(['start' => $arrData['date_from']->clone()->startOfMonth()->format('Y-m-d'), 'end' => $arrData['date_from']->clone()->endOfMonth()->format('Y-m-d')]);
       

        // Request By Cake 25112022 -- Piyawut A.
        $month = date('M-y', strtotime($arrData['date_from']));
        $date = date('Y-m-d', strtotime($arrData['date_from']));
        $period = GLPeriodV::selectRaw('start_date, end_date')->whereRaw("TRUNC(TO_DATE('{$date}','YYYY-MM-DD')) BETWEEN START_DATE AND END_DATE")->first();
      
       
        $arrData['month'] = "ประจำเดือน " . $this->getMonthTh($arrData['date_from']->format('m')) . " พ.ศ." . $arrData['date_from']->addYears(543)->format("Y");

        if (request()->output === "excel") : // check output
            // return (new OMR0062('OMR0062', $request, 'ยอดจำหน่ายบุหรี่ในประเทศ', $arrData))->view();
            return Excel::download(new OMR0062('OMR0062', $request, 'ยอดจำหน่ายบุหรี่ในประเทศ', $arrData), 'OMR0062.xlsx');
        endif;
        // return view($view, $arrData);
        $pdf = PDF::loadView($view, $arrData)
            ->setPaper('a4', 'landscape')
            ->setOption('header-right', "\n\n\n\n[page]/[topage] ")
            ->setOption('header-font-name', "THSarabunNew")
            ->setOption('header-font-size', 9)
            ->setOption('header-spacing', 3)
            ->setOption('margin-bottom', 10);
        return $pdf->stream($programcode . '.pdf');
    }

    public function mappingDate($items)
    {
        return $items->map(function ($item) {
            $item->day = Carbon::createFromFormat('Y-m-d H:i:s', $item->payment_date)->format('d');
            return $item;
        });
    }

    public function queryData($programCode, $request)
    {
        $arrData              = [];
        $arrData['date_from'] = Carbon::createFromFormat('d/m/Y H:i:s', $request->month);
        $date                 = date('Y-m-d', strtotime($arrData['date_from']));
        $period               = GLPeriodV::selectRaw('start_date, end_date')->whereRaw("TRUNC(TO_DATE('{$date}','YYYY-MM-DD')) BETWEEN START_DATE AND END_DATE")->first();
        $startDate            = date('Y-m-d', strtotime($period->start_date));
        $endDate              = date('Y-m-d', strtotime($period->end_date));


        $month = Carbon::createFromFormat('d/m/Y H:i:s', $request->month);
        $arrData['data'] = DB::table('ptom_so_outstanding_v po')
            ->selectRaw("sum(
                CASE
                when po.program_code = 'OMP0019'
                then approve_quantity * 1000
                      ELSE 0
                   END +  CASE 
                when po.program_code = 'OMP0038'
                THEN consignment_quantity * 1000
                       ELSE 0
                   END
               ) AS all_qty,
               ----------------------
               sum(
                CASE
                when po.program_code = 'OMP0019'
                then amount
                      ELSE 0
                   END + CASE 
                when po.program_code = 'OMP0038'
                THEN consignment_amount
                       ELSE 0
                   END
               ) AS all_amount,
               ----------------------
               sum(
                CASE
                when po.program_code = 'OMP0019'
                then tax_amount
                      ELSE 0
                   END + CASE 
                when po.program_code = 'OMP0038'
                THEN consignment_tax_amount
                       ELSE 0
                   END
               ) AS tax_amount,

           
               ptom_sequence_ecoms.item_code,
               ptom_sequence_ecoms.report_item_display,
               ptom_sequence_ecoms.sub_account_code,
               sum(
                pao_amount
               ) AS pao_line_amount,
               (
                   select
                    sum(actual_quantity*93)
                   from ptom_consignment_headers CH,
                   ptom_consignment_lines CL
                   where CH.consignment_header_id = CL.consignment_header_id
                   and   consignment_status       = 'Confirm'
                       and customer_id not in '18'
                       AND CL.item_id = po.item_id
                       and trunc(consignment_date) between to_date('{$month->startOfMonth()->format('d-m-Y')}', 'DD-MM-YYYY')
                       and to_date('{$month->endOfMonth()->format('d-m-Y')}', 'DD-MM-YYYY')
               ) pao_line_amount2,
               ( 
                select 
                            sum(adjust_amount)
                            from  PTOM_PAO_TAX_MT MT
                            where MT.item_id = po.item_id
                            AND   MONTH_NO   = '{$month->format('m')}'
                            and   MT.year    = '{$month->format('Y')}'
                ) mt_pao_line_amount,
                nvl((select sum(nvl(entered_dr, 0)- nvl(entered_cr, 0)) 
                from ptom_gl_interfaces
                where program_code = 'OMP0043'
                and  trunc(accounting_date) between to_date('{$month->startOfMonth()->format('Y-m-d')}', 'YYYY-MM-DD')
                                        and to_date('{$month->endOfMonth()->format('Y-m-d')}', 'YYYY-MM-DD')
                and segment9 = '411100'
                group by segment9,segment10),0) entered_cr
            ")
            ->join('ptom_sequence_ecoms', 'ptom_sequence_ecoms.item_id', '=', 'po.item_id')
            ->whereNotIn('po.customer_type_id', ['80'])
            ->where('ptom_sequence_ecoms.screen_number', "<>", '0')
            ->where('ptom_sequence_ecoms.sale_type_code', 'DOMESTIC')
            ->where('po.product_type_code', '10')
            ->whereRaw("nvl(consignment_date ,trunc(pick_release_approve_date)) BETWEEN to_date('{$month->startOfMonth()->format('m-d-Y')}','MM-DD-YYYY') AND to_date('{$month->endOfMonth()->format('m-d-Y')}', 'MM-DD-YYYY')")
            ->groupBy('ptom_sequence_ecoms.report_item_display', 'ptom_sequence_ecoms.item_code', 'po.item_id', 'ptom_sequence_ecoms.sub_account_code')
            ->orderBy('sub_account_code')
            ->get();
        $arrData['glInt'] = GLInterfaceModel::selectRaw('sum(ENTERED_DR)- sum(ENTERED_CR) total')
            ->where('program_code', 'OMP0043')
            ->where('segment10', '111')
            ->where('interface_status', 'C')
            ->where('period_name', strtoupper($month))
            ->first();

        $arrData['apInterface'] = APInterface::selectRaw("ptom_pao_tax_mt.item_id, ptom_pao_tax_mt.item_code, sum(ptom_pao_tax_mt.adjust_amount) ppt_adjust_amount")->join('ptom_pao_tax_mt', 'ptom_pao_tax_mt.ap_web_batch_no', '=', 'ptom_ap_interfaces.group_id')
                            ->where('ptom_pao_tax_mt.ap_interface_status', 'S')
                            ->where('ptom_ap_interfaces.from_program_code', 'OMP0089')
                            ->where('year', $month->format('Y'))
                            ->where('month_no', $month->format('m'))
                            // ->whereRaw("trunc(gl_date) between TO_DATE('{$startDate}','YYYY-mm-dd') and TO_DATE('{$endDate}','YYYY-mm-dd')")
                            ->groupBy('ptom_pao_tax_mt.item_id', 'ptom_pao_tax_mt.item_code')
                            ->get();
        $arrData['arInterface'] = ARInterface::selectRaw("item_code, sum(quantity*1000) sum_qty, sum(amount) sum_amount, sum(oaom_tax_adjust) sum_oaom_tax_adjust, sum(pao_line_amount) sum_pao_line_amount")
            ->where('product_type_code', 10)
            ->whereIn('from_program_code', ['OMP0019', 'OMP0038'])
            ->whereRaw("group_id not in (SELECT group_id FROM ptom_ar_interfaces WHERE interface_status = 'E' GROUP BY GROUP_ID)")
            ->whereRaw("trunc(invoice_date) between TO_DATE('{$startDate}','YYYY-mm-dd') and TO_DATE('{$endDate}','YYYY-mm-dd')")
            ->groupBy('item_code')
            ->get();

        $arrData['gl_adjust'] = collect(DB::select("select
                                            item_id,
                                            item_code,
                                            segment9,
                                            segment10,
                                            sum(entered_dr) as Dr,
                                            sum(accounted_cr) as Cr
                                        from
                                            ptom_gl_interfaces GL,
                                            ptom_sequence_ecoms ITEM
                                        where
                                            segment9 = main_account_code
                                            and segment10 = sub_account_code
                                            and currency_code = 'THB'
                                            AND trunc(accounting_date) BETWEEN to_date('{$month->startOfMonth()->format('m-d-Y')}', 'MM-DD-YYYY') AND to_date('{$month->endOfMonth()->format('m-d-Y')}', 'MM-DD-YYYY')
                                            and segment9 = '411100'
                                            and GL.program_code = 'OMP0043'
                                        group by
                                            item_id,
                                            item_code,
                                            segment9,
                                            segment10"));
        return $arrData;
    }
}
