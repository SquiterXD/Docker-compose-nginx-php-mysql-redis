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

class OMR0049Controller extends Controller
{
    protected $titleReport;
    protected $view = 'ct.Reports.omr0049.pdf.index';
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

    public function OMR0049($programcode, Request $request)
    {

        $program     = $this->program;
        $titleReport = $this->titleReport;
        $view        = $this->view;
        $arrData       = [];

        $arrData       = $this->queryData($programcode, $request);
        $arrData['program']     = $program;
        $arrData['programCode']     = $program->program_code;
        $arrData['progTitle'] = $titleReport;


        if(env('APP_ENV') == "local") {
            return view($view,$arrData);
        }
        $pdf = PDF::loadView($view, $arrData)
            ->setPaper('a4')
            ->setOption('header-right', "\n\n\n\n[page]/[topage]    ")
            ->setOption('header-font-name', "THSarabunNew")
            ->setOption('header-font-size', 11)
            ->setOption('header-spacing', 0)
            ->setOption('margin-top', 3)
            ->setOption('margin-bottom', 10);
        return $pdf->stream($programcode . '.pdf');
    }

    public function addCNProcess($array_customer_id)
    {
        $set = [];
        if (empty($array_customer_id)) return collect([]);
        foreach ($array_customer_id as $i) {
            $set[] = "'" . $i . "'";
        }
        $dateStart = request()->date_start;
        $dateEnd = request()->date_end;
        $implode = implode(',', $set);
        $sql = "SELECT	oh.product_type_code,
        (CASE
            WHEN ih.currency <> 'THB'
            THEN
                ih.exchange_rate * pac.invoice_amount
            ELSE
                pac.invoice_amount
        END)
            invoice_amount_convert, c.customer_number
        FROM			ptom_payment_apply_cndn pac
                LEFT JOIN
                    ptom_invoice_headers ih
                ON pac.invoice_number = ih.invoice_headers_number
                LEFT JOIN
                    PTOM_ORDER_HEADERS oh
                ON oh.order_header_id = pac.order_header_id
                LEFT JOIN
                    ptom_customers c
                ON c.customer_id = ih.customer_id
        WHERE		 1 = 1
                AND pac.attribute1 = 'Y'
                AND c.customer_number in ($implode)
                AND pac.attribute3 IS NOT NULL
                AND pac.attribute2 = 'CN_OTHER'
                AND ih.invoice_status = 'Confirm'
                AND TRUNC (pac.last_update_date) <=	TO_DATE ('{$dateEnd}',
                                                                        'dd/mm/yyyy')
                                                                ";

        // dd($sql);

        $builder = DB::select($sql);
        return $builder;
    }
    public function calLoss_10($sa_number)
    {
        if ($sa_number == '') {
            return [];
        }
        $result1 = collect(DB::select("SELECT   prepare_order_number,
                            SUM (conversion_amount_exclude_vat) conversion_amount_exclude_vat
                    FROM   ptom_payment_exp_v
                    WHERE   prepare_order_number IN ($sa_number)
                    GROUP BY   prepare_order_number"));

        $result2 = collect(DB::select("SELECT   ptom_payment_apply_cndn.attribute3 sa_number,
                                 SUM (ptom_payment_apply_cndn.invoice_amount
                            * ptom_invoice_headers.exchange_rate)
                                            exchange
                                FROM 	  ptom_payment_apply_cndn
                                        LEFT JOIN
                                            ptom_invoice_headers
                                        ON ptom_payment_apply_cndn.invoice_header_id =
                                                ptom_invoice_headers.invoice_headers_id
                                WHERE   ptom_payment_apply_cndn.attribute3 IN
                                                ($sa_number)
                                        AND ptom_payment_apply_cndn.attribute1 = 'Y'
                                GROUP BY   ptom_payment_apply_cndn.attribute3"));
        $result3 = collect(DB::select("SELECT	sa_number,
                                            ptom_proforma_invoice_headers.sub_total
                                            / ptom_order_headers.sub_total
                                                sub_total,
                                                ptom_proforma_invoice_headers.sub_total a,
                                                ptom_order_headers.sub_total b,
                                                ptom_proforma_invoice_headers.pick_release_no
                                    FROM		ptom_proforma_invoice_headers
                                            LEFT JOIN
                                                PTOM_ORDER_HEADERS
                                            ON PTOM_ORDER_HEADERS.order_header_id =
                                                    ptom_proforma_invoice_headers.order_header_id
                                    WHERE	ptom_proforma_invoice_headers.sa_number IN
                                                    ($sa_number)"));
       
        $result4 = collect(DB::select("SELECT	sa_number, ROUND(ptom_proforma_invoice_headers.sub_total
        * ptom_proforma_invoice_headers.pick_exchange_rate, 2) exchange,
                                        ptom_proforma_invoice_headers.pick_exchange_rate
                                            pick_exchange_rate
                                            ,
                                                ptom_proforma_invoice_headers.pick_release_no
                                FROM	ptom_proforma_invoice_headers
                                WHERE	ptom_proforma_invoice_headers.sa_number IN
                                                ($sa_number)"));

        return compact('result1', 'result2', 'result3', 'result4');
    }
    public function calLoss_20($sa_number)
    {
        if ($sa_number == '') {
            return [];
        }
        $result1 = collect(DB::select("SELECT   prepare_order_number,
                            SUM (conversion_amount) conversion_amount_exclude_vat
                    FROM   ptom_payment_exp_v
                    WHERE   prepare_order_number IN ($sa_number)
                    GROUP BY   prepare_order_number"));

        $result2 = collect(DB::select("SELECT   ptom_payment_apply_cndn.attribute3 sa_number,
                                 SUM (round(ptom_payment_apply_cndn.invoice_amount, 2)
                            * round(ptom_invoice_headers.exchange_rate, 2))
                                            exchange
                                FROM 	  ptom_payment_apply_cndn
                                        LEFT JOIN
                                            ptom_invoice_headers
                                        ON ptom_payment_apply_cndn.invoice_header_id =
                                                ptom_invoice_headers.invoice_headers_id
                                WHERE   ptom_payment_apply_cndn.attribute3 IN
                                                ($sa_number)
                                        AND ptom_payment_apply_cndn.attribute1 = 'Y'
                                GROUP BY   ptom_payment_apply_cndn.attribute3"));

        $result3 = collect(DB::select("SELECT	sa_number, ROUND(ptom_proforma_invoice_headers.grand_total
                                        * ptom_proforma_invoice_headers.pick_exchange_rate, 2) exchange,
                                        ptom_proforma_invoice_headers.pick_exchange_rate
                                            pick_exchange_rate
                                            ,
                                                ptom_proforma_invoice_headers.pick_release_no
                                FROM	ptom_proforma_invoice_headers
                                WHERE	ptom_proforma_invoice_headers.sa_number IN
                                                ($sa_number)"));
        return compact('result1', 'result2', 'result3');
    }
    public function queryData($programCode, $request)
    {

        $arrData = [];
        $date_from = Carbon::createFromFormat('d/m/Y', $request->date_start);
        $date_to = Carbon::createFromFormat('d/m/Y', $request->date_end);
        $arrData['date_from'] = $date_from;
        $arrData['date_to'] = $date_to;
        $arrData['payment_type_code'] = $request->payment_type;
        $arrData['payment_type'] = DB::table('ptom_payment_type')->where('lookup_code', $arrData['payment_type_code'])->where('enabled_flag', 'Y')->first();

        $text1 = '';
        $text2 = '';
        if ($arrData['payment_type_code'] == '20') {
            $text1 = 'payment_amount';
            $text1_1 = '(select sum(pdd.conversion_amount) from ptom_payment_details pdd where pdd.payment_header_id = ph.payment_header_id) ';
            $text2 = 'i.line_amount';
        } elseif ($arrData['payment_type_code'] == '10') {
            $text1 = 'payment_exclude_vat';
            $text1_1 = '(select sum(pdd.conversion_amount) from ptom_payment_details pdd where pdd.payment_header_id = ph.payment_header_id) - sum(ev.vat * ev.conversion_rate)';
            $text2 = 'i.sub_total';
        }

        $sql = "
            select  
                ev.order_type_id
                ,null sa_number
                ,ev.product_type_code
                ,ev.description as product_type_desc
                ,trunc(ev.payment_date) as payment_date
                ,ev.payment_number as payment_number
                ,$text1_1 as payment_amount
                ,ev.customer_number
                ,ev.customer_name
                ,'payment' as type_field
            from ptom_payment_exp_v ev
                left join PTOM_PAYMENT_HEADERS ph on ph.payment_number = ev.payment_number
            where trunc(ev.payment_date)
            between to_date('{$date_from->format('m-d-Y')}','mm-dd-yyyy')
            and to_date('{$date_to->format('m-d-Y')}','mm-dd-yyyy')
            and ev.payment_type_code = '{$arrData['payment_type_code']}'
            group by ev.order_type_id, 
                ev.product_type_code,
            ev.description, ev.payment_date, ev.payment_number, ev.customer_number, ev.customer_name, ev.currency, ph.payment_header_id
            union
            select  
                t.order_type_id
                ,i.sa_number
                , i.product_type_code
                ,t.description as product_type_desc
                ,i.pick_exchange_date payment_date
                ,i.pick_release_no as payment_number
                ,sum($text2 * (select pick_exchange_rate from ptom_proforma_invoice_headers ph where ph.pick_release_no = i.pick_release_no)) as payment_amount
                ,customer_number
                ,customer_name
                ,'outstanding' type_field
            from ptom_so_outstanding_exp_v i
                ,ptom_transaction_types_v t
            where payment_type_code = '{$arrData['payment_type_code']}'
            and i.order_type_id = t.order_type_id
            and trunc(pick_exchange_date) 
            between to_date('{$date_from->format('m-d-Y')}', 'mm-dd-yyyy') 
            and to_date('{$date_to->format('m-d-Y')}', 'mm-dd-yyyy')
            group by i.sa_number, t.order_type_id, i.product_type_code, t.description, i.pick_exchange_date, i.pick_release_no, customer_number, customer_name
        ";

        $data = collect(DB::select($sql));
        if ($arrData['payment_type_code'] == '20') {
            $raw_gain_loss = $this->calLoss_20($data->pluck('sa_number')->map(function ($i) {
                return "'" . $i . "'";
            })->unique()->join(', '));
        } elseif ($arrData['payment_type_code'] == '10') {
            $raw_gain_loss = $this->calLoss_10($data->pluck('sa_number')->map(function ($i) {
                return "'" . $i . "'";
            })->unique()->join(', '));
        }

        $arrData['data'] = $data->sortBy(function ($q) {
            return $q->payment_date . $q->payment_number;
        });
        // ยอดยกมา 
        $cusNumber = $arrData['data']->pluck('customer_number')->unique()->toArray();
        $sql = "
            select
                ev.order_type_id
                , '' sa_number
                ,ev.product_type_code
                ,ev.description as product_type_desc
                ,trunc(ev.payment_date) as payment_date
                ,ev.payment_number as payment_number
                ,$text1_1 as amount
                ,ev.customer_number
                ,ev.customer_name
                ,'payment' as type_field
            from ptom_payment_exp_v ev
                left join PTOM_PAYMENT_HEADERS ph on ph.payment_number = ev.payment_number
            where trunc(ev.payment_date) < to_date('{$date_from->format('m-d-Y')}', 'mm-dd-yyyy')
            and ev.payment_type_code = '{$arrData['payment_type_code']}'
            group by ev.order_type_id, ev.product_type_code, ev.description, ev.payment_date, ev.payment_number, ev.customer_number, ev.customer_name, ev.currency, ph.payment_header_id
            union
            select  
                t.order_type_id
                ,i.sa_number
                ,i.product_type_code
                ,t.description as product_type_desc
                ,i.pick_exchange_date payment_date
                ,i.pick_release_no as payment_number
                ,sum($text2 * (select pick_exchange_rate from ptom_proforma_invoice_headers ph where ph.pick_release_no = i.pick_release_no)) as amount
                ,customer_number
                ,customer_name
                ,'invoice' type_field
            from ptom_so_outstanding_exp_v i
                ,ptom_transaction_types_v t
            where payment_type_code = '{$arrData['payment_type_code']}'
            and i.order_type_id = t.order_type_id
            and trunc(pick_exchange_date) < to_date('{$date_from->format('m-d-Y')}', 'mm-dd-yyyy')
            group by i.sa_number, t.order_type_id,  i.product_type_code, t.description, i.pick_exchange_date, i.pick_release_no, customer_number, customer_name
        ";
        $forward = collect(DB::select($sql));

        if ($arrData['payment_type_code'] == '20') {
            $raw_gain_loss_for = $this->calLoss_20($forward->pluck('sa_number')->map(function ($i) {
                return "'" . $i . "'";
            })->unique()->join(', '));
        } elseif ($arrData['payment_type_code'] == '10') {
            $raw_gain_loss_for = $this->calLoss_10($forward->pluck('sa_number')->map(function ($i) {
                return "'" . $i . "'";
            })->unique()->join(', '));
        }

        $merge_customers = array_merge($cusNumber, $forward->pluck('customer_number')->unique()->toArray());
        $arrData['addCn'] = collect($this->addCNProcess($merge_customers));

        // dd($arrData['data']->where('customer_number', 'E00004'));
        $set1 = $arrData['data']->map(function ($q) use ($forward, $arrData, $raw_gain_loss_for, $raw_gain_loss) {
            $gain_loss = 0;
            $gain_loss_for = 0;
            $forward_amount = $forward->where('customer_number', $q->customer_number)
                ->where('order_type_id', $q->order_type_id)
                ->where('type_field', 'payment')
                ->sum('amount');
            foreach($forward->where('customer_number', $q->customer_number) as $i) {
                if ($arrData['payment_type_code'] == '20') {
                    //สำหรับยอดยกมา
                    $set1 = !empty($raw_gain_loss_for['result1']) ? $raw_gain_loss_for['result1']->where('prepare_order_number', $i->sa_number)->sum('conversion_amount_exclude_vat') : 0;
                    $set2 = !empty($raw_gain_loss_for['result2']) ? $raw_gain_loss_for['result2']->where('sa_number', $i->sa_number)->sum('exchange') : 0;
                    $set3 = !empty($raw_gain_loss_for['result3']) ? $raw_gain_loss_for['result3']->where('sa_number', $i->sa_number)->where('pick_release_no', $i->payment_number)->sum('exchange') : 0;
                    $check_set1 = !empty($raw_gain_loss_for['result1']) ? $raw_gain_loss_for['result1']->where('prepare_order_number', $i->sa_number)->first() : null;
                    $check_set4 = !empty($raw_gain_loss_for['result3']) ? $raw_gain_loss_for['result3']->where('sa_number', $i->sa_number)->first() : null;

                    if (optional($check_set4)->pick_exchange_rate != null && $check_set1 !== null) {
                        $gain_loss_for += (($set1 + $set2) - $set3);
                    }
                } elseif ($arrData['payment_type_code'] == '10') {
                    //สำหรับยอดยกมา

                    $set1 = !empty($raw_gain_loss_for['result1']) ? $raw_gain_loss_for['result1']->where('prepare_order_number', $i->sa_number)->sum('conversion_amount_exclude_vat') : 0;
                    $set2 = !empty($raw_gain_loss_for['result2']) ? $raw_gain_loss_for['result2']->where('sa_number', $i->sa_number)->sum('exchange') : 0;
                    $set3 = !empty($raw_gain_loss_for['result3']) ? $raw_gain_loss_for['result3']->where('sa_number', $i->sa_number)->where('pick_release_no', $i->payment_number)->sum('sub_total') : 0;
                    $set4 = !empty($raw_gain_loss_for['result4']) ? $raw_gain_loss_for['result4']->where('sa_number', $i->sa_number)->where('pick_release_no', $i->payment_number)->sum('exchange') : 0;
                    $check_set4 = !empty($raw_gain_loss_for['result4']) ? $raw_gain_loss_for['result4']->where('sa_number', $i->sa_number)->first() : null;


                    if (optional($check_set4)->pick_exchange_rate != null) {
                        $gain_loss_for += (($set1 + $set2) * $set3) - $set4;
                    }
                }
                
            }

            if ($arrData['payment_type_code'] == '20') {

                //สำหรับค่าปกติ
                $set1 = !empty($raw_gain_loss['result1']) ? $raw_gain_loss['result1']->where('prepare_order_number', $q->sa_number)->sum('conversion_amount_exclude_vat') : 0;
                $set2 = !empty($raw_gain_loss['result2']) ? $raw_gain_loss['result2']->where('sa_number', $q->sa_number)->sum('exchange') : 0;
                $set3 = !empty($raw_gain_loss['result3']) ? $raw_gain_loss['result3']->where('sa_number', $q->sa_number)->where('pick_release_no', $q->payment_number)->sum('exchange') : 0;
                $check_set1 = !empty($raw_gain_loss['result1']) ? $raw_gain_loss['result1']->where('prepare_order_number', $q->sa_number)->first() : null;
                $check_set4 = !empty($raw_gain_loss['result3']) ? $raw_gain_loss['result3']->where('sa_number', $q->sa_number)->first() : null;

                if (optional($check_set4)->pick_exchange_rate != null && $check_set1 !== null) {
                    $gain_loss += (($set1 + $set2) - $set3);
                }
            } elseif ($arrData['payment_type_code'] == '10') {


                //สำหรับค่าปกติ
                $set1 = !empty($raw_gain_loss['result1']) ? $raw_gain_loss['result1']->where('prepare_order_number', $q->sa_number)->sum('conversion_amount_exclude_vat') : 0;
                $set2 = !empty($raw_gain_loss['result2']) ? $raw_gain_loss['result2']->where('sa_number', $q->sa_number)->sum('exchange') : 0;
                $set3 = !empty($raw_gain_loss['result3']) ? $raw_gain_loss['result3']->where('sa_number', $q->sa_number)->where('pick_release_no', $q->payment_number)->sum('sub_total') : 0;
                $set4 = !empty($raw_gain_loss['result4']) ? $raw_gain_loss['result4']->where('sa_number', $q->sa_number)->where('pick_release_no', $q->payment_number)->sum('exchange') : 0;
                $check_set4 = !empty($raw_gain_loss['result4']) ? $raw_gain_loss['result4']->where('sa_number', $q->sa_number)->first() : null;

                if (optional($check_set4)->pick_exchange_rate != null) {
                    $gain_loss += (($set1 + $set2) * $set3) - $set4;
                }
            }
            

            $forward_grand = $forward->where('customer_number', $q->customer_number)
                ->where('order_type_id', $q->order_type_id)
                ->where('type_field', 'invoice')
                ->sum('amount');

            if ($arrData['payment_type_code'] == '20') {
                $q->forward = $forward_grand - $forward_amount;
            } elseif ($arrData['payment_type_code'] == '10') {
                $q->forward = $forward_amount - $forward_grand;
            }
            $decimal_part = @explode('.', $q->forward)[1];
            $num_decimal_digits = strlen($decimal_part);
            if ($num_decimal_digits > 2) {
                $rounded = floor($q->forward * 100) / 100;
            } else {
                $rounded = $q->forward;
            }
            $q->gain_loss = $gain_loss;
            $q->gain_loss_for = $gain_loss_for;
            $q->gain_forward = $q->forward - $q->gain_loss;
            $q->forward = $rounded;
            return $q;
        });
        $set2 = $forward->whereNotIn('customer_number', $set1->pluck('customer_number')->toArray())->map(function ($q) use ($forward, $arrData, $raw_gain_loss_for) {
            $forward_amount = $forward->where('customer_number', $q->customer_number)
                ->where('order_type_id', $q->order_type_id)
                ->where('type_field', 'payment')
                ->sum('amount');
            $q->gain_loss = 0;
            $q->gain_loss_for = 0;
            $gain_loss_for = 0;
            
            if ($arrData['payment_type_code'] == '20') {
                //สำหรับยอดยกมา
                $set1 = !empty($raw_gain_loss_for['result1']) ? $raw_gain_loss_for['result1']->where('prepare_order_number', $q->sa_number)->sum('conversion_amount_exclude_vat') : 0;
                $set2 = !empty($raw_gain_loss_for['result2']) ? $raw_gain_loss_for['result2']->where('sa_number', $q->sa_number)->sum('exchange') : 0;
                $set3 = !empty($raw_gain_loss_for['result3']) ? $raw_gain_loss_for['result3']->where('sa_number', $q->sa_number)->where('pick_release_no', $q->payment_number)->sum('exchange') : 0;
                $check_set1 = !empty($raw_gain_loss_for['result1']) ? $raw_gain_loss_for['result1']->where('prepare_order_number', $q->sa_number)->first() : null;
                $check_set4 = !empty($raw_gain_loss_for['result3']) ? $raw_gain_loss_for['result3']->where('sa_number', $q->sa_number)->first() : null;
               
                if (optional($check_set4)->pick_exchange_rate != null && $check_set1 !== null) {
                    $gain_loss_for += (($set1 + $set2) - $set3);
                }
            } elseif ($arrData['payment_type_code'] == '10') {
                //สำหรับยอดยกมา
                $set1 = !empty($raw_gain_loss_for['result1']) ? $raw_gain_loss_for['result1']->where('prepare_order_number', $q->sa_number)->sum('conversion_amount_exclude_vat') : 0;
                $set2 = !empty($raw_gain_loss_for['result2']) ? $raw_gain_loss_for['result2']->where('sa_number', $q->sa_number)->sum('exchange') : 0;
                $set3 = !empty($raw_gain_loss_for['result3']) ? $raw_gain_loss_for['result3']->where('sa_number', $q->sa_number)->where('pick_release_no', $q->payment_number)->sum('sub_total') : 0;
                $set4 = !empty($raw_gain_loss_for['result4']) ? $raw_gain_loss_for['result4']->where('sa_number', $q->sa_number)->where('pick_release_no', $q->payment_number)->sum('exchange') : 0;
                $check_set4 = !empty($raw_gain_loss_for['result4']) ? $raw_gain_loss_for['result4']->where('sa_number', $q->sa_number)->first() : null;
                

                if (optional($check_set4)->pick_exchange_rate != null) {
                    $gain_loss_for += (($set1 + $set2) * $set3) - $set4;
                }
            }
          
            $forward_grand = $forward->where('customer_number', $q->customer_number)
                ->where('order_type_id', $q->order_type_id)
                ->where('type_field', 'invoice')
                ->sum('amount');

            if ($arrData['payment_type_code'] == '20') {
                $q->forward = round($forward_grand - $forward_amount, 10);
            } elseif ($arrData['payment_type_code'] == '10') {
                $q->forward = round($forward_amount - $forward_grand, 10);
            }
            $decimal_part = @explode('.', $q->forward)[1];
            $num_decimal_digits = strlen($decimal_part);
            if ($num_decimal_digits > 2) {
                $rounded = floor($q->forward * 100) / 100;
            } else {
                $rounded = $q->forward;
            }

            // $q->forward = $rounded;
            $q->gain_forward = $q->forward - $q->gain_loss;
            $q->gain_loss_for = $gain_loss_for;
            return $q;
        });
        $arrData['data'] = $set1;
        $arrData['data'] = $arrData['data']->merge($set2->where('gain_forward', "<>", 0));
        // dd($arrData['data']);
        return $arrData;
    }
}
