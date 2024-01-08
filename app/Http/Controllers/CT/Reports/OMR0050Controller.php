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
use stdClass;

class OMR0050Controller extends Controller
{
    protected $titleReport;
    protected $view = 'ct.Reports.omr0050.pdf.index';
    protected $programe;
    protected $dateFormat = 'd/m/Y';

    public function getMonthTh($month) {
        $toInt = (int)($month);
        $months_th = [  '' ,
                        "มกราคม", 
                        "กุมภาพันธ์", 
                        "มีนาคม", 
                        "เมษายน", 
                        "พฤษภาคม", 
                        "มิถุนายน", 
                        "กรกฎาคม", 
                        "สิงหาคม", 
                        "กันยายน", 
                        "ตุลาคม", 
                        "พฤศจิกายน", 
                        "ธันวาคม"];
        return $months_th[$toInt];
    }

    public function calLoss($sa_number) {
        if($sa_number == '') {return [];}
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
    public function __construct()
    {
        $this->program      = ProgramInfo::where('program_code', request()->program_code)->first();
        $this->titleReport  = $this->program->description;
    }

    public function OMR0050($programcode, Request $request)
    {
        $program                    = $this->program;
        $titleReport                = $this->titleReport;
        $view                       = $this->view;
        $arrData                    = [];

        $arrData                    = $this->queryData($programcode, $request);
        $arrData['program']         = $program;
        $arrData['programCode']     = $program->program_code;
        $arrData['progTitle']       = $titleReport;

        $pdf = PDF::loadView($view,$arrData)
                ->setPaper('a4')
                ->setOption('header-right',"\n\n\n\n[page]/[topage]    ")
                ->setOption('header-font-name',"THSarabunNew")
                ->setOption('header-font-size',11)
                ->setOption('header-spacing',0)
                ->setOption('margin-top',3)
                ->setOption('margin-bottom', 10);
        return $pdf->stream($programcode .'.pdf');
    }
    
    public function addCNProcess($array_customer_id) {
        $set = [];
        foreach($array_customer_id as $i) {
            $set[] = "'". $i . "'";
        }
        $dateStart = request()->date_start;
        $dateEnd = request()->date_end;
        $implode = implode(',',$set);
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
        $builder = DB::select($sql);
        return $builder;
    }
    public function queryData($programCode, $request){
        $text1 = '';
        $text2 = '';
        if($programCode == 'OMR0051') {
            $payment_type_code = 20;
            $text1 = 'sum(ev.payment_amount)';
            $text1_1 = "sum(ev.payment_amount * ev.conversion_rate) as payment_amount";
            $text2 = 'sub_total';

        } elseif($programCode == 'OMR0050') {
            $payment_type_code = 10;
            $text1 = 'ev.payment_exclude_vat';
            $text1 = "(select sum(pdd.conversion_amount) from ptom_payment_details pdd where pdd.payment_header_id = ph.payment_header_id) - ((select sum(evv.vat)  from ptom_payment_exp_v evv where evv.payment_number = ev.payment_number )) as amount";
            $text1_1 = "(select sum(pdd.conversion_amount) from ptom_payment_details pdd where pdd.payment_header_id = ph.payment_header_id) - ((select sum(evv.vat)  from ptom_payment_exp_v evv where evv.payment_number = ev.payment_number )) as payment_amount ";
            $text2 = 'i.sub_total';
        }

        $arrData                = []; 
        $date_from              = Carbon::createFromFormat('d/m/Y', $request->date_start);
        $date_to                = Carbon::createFromFormat('d/m/Y', $request->date_end);
        $customer_from          = $request->customer_from;
        $customer_to            = $request->customer_to;
        $arrData['date_from']   = $date_from;
        $arrData['date_to']     = $date_to;



        $strBuilderPayment = "select
                                    ev.order_type_id
                                    ,null sa_number
                                    ,ev.product_type_code
                                    ,ev.description as product_type_desc
                                    ,trunc(ev.payment_date) as payment_date
                                    ,ev.payment_number as payment_number
                                    ,$text1_1
                                    ,ev.customer_number
                                    ,ev.customer_id
                                    ,ev.customer_name
                                    ,ev.currency
                                    ,'payment' as type_field     
                                from ptom_payment_exp_v ev
                                    left join PTOM_PAYMENT_HEADERS ph on ph.payment_number = ev.payment_number
                                    left join ptom_payment_details pd on ph.payment_header_id = pd.payment_header_id
                                where trunc(ev.payment_date)
                                    between to_date('{$date_from->format('m-d-Y')}', 'mm-dd-yyyy') 
                                    and to_date('{$date_to->format('m-d-Y')}', 'mm-dd-yyyy')
                                    and ev.payment_type_code = '{$payment_type_code}'
                                group by ev.customer_id, 
                                   -- ev.prepare_order_number ,
                                    ev.order_type_id, 
                                    ev.description, 
                                    ev.product_type_code, 
                                    ev.payment_date, 
                                    ev.payment_number, 
                                    ev.customer_number, 
                                    ev.customer_name, 
                                    ev.currency, 
                                    ph.payment_header_id";
        $queryBuilderPayment = DB::select($strBuilderPayment);
        $strBuilderOutstanding = "select  
                                    t.order_type_id
                                    ,i.sa_number
                                    ,i.product_type_code
                                    ,t.description as product_type_desc
                                    ,i.pick_exchange_date payment_date
                                    ,i.pick_release_no as payment_number
                                    ,sum($text2 * (select pick_exchange_rate from ptom_proforma_invoice_headers ph where ph.sa_number = i.sa_number and i.pick_release_no = ph.pick_release_no)) as payment_amount
                                    ,customer_number
                                    ,customer_id
                                    ,i.sa_number
                                    ,customer_name
                                    ,currency
                                    ,'outstanding' type_field
                                from ptom_so_outstanding_exp_v i
                                    ,ptom_transaction_types_v t
                                where payment_type_code = '{$payment_type_code}'
                                    and i.order_type_id = t.order_type_id
                                    and trunc(pick_exchange_date)
                                    between to_date('{$date_from->format('m-d-Y')}', 'mm-dd-yyyy') 
                                    and to_date('{$date_to->format('m-d-Y')}', 'mm-dd-yyyy')
                                group by t.order_type_id
                                , t.description
                                ,i.product_type_code
                                ,i.sa_number
                                , i.pick_exchange_date
                                , i.pick_release_no
                                , customer_number
                                , customer_name
                                , currency
                                , customer_id";
        $queryBuilderOutstanding = DB::select($strBuilderOutstanding);
        $data = collect(array_merge($queryBuilderPayment, $queryBuilderOutstanding));


        $raw_gain_loss = $this->calLoss($data->pluck('sa_number')->map(function($i) { return "'". $i ."'";})->unique()->join(', '));
        $arrData['raw_gain_loss'] = $raw_gain_loss;

        $data = $data->sortBy('customer_number');


        if(!!$customer_from && !!$customer_to){
            $data = $data->where('customer_number', '>=', $customer_from)->where('customer_number', '<=', $customer_to);
        }elseif(!!$customer_from) {
            $data = $data->where('customer_number', '>=', $customer_from);
        }elseif(!!$customer_to) {
            $data = $data->where('customer_number', '<=', $customer_to);
        }

        $arrData['data'] = $data->sortBy(function($q) {
            return $q->payment_date.$q->payment_number;
        });
        
        // ยอดยกมา 
        $strBroughtForwardPayment = "select
                                    ev.order_type_id
                                    ,null sa_number
                                    ,ev.product_type_code
                                    ,ev.description as product_type_desc
                                    ,trunc(ev.payment_date) as payment_date
                                    ,ev.payment_number as payment_number
                                    ,$text1
                                    ,ev.customer_number
                                    ,ev.customer_name
                                    ,ev.currency
                                    ,'payment' as type_field
                                from ptom_payment_exp_v ev
                                    left join PTOM_PAYMENT_HEADERS ph on ph.payment_number = ev.payment_number
                                    left join ptom_payment_details pd on ph.payment_header_id = pd.payment_header_id
                                where trunc(ev.payment_date) < to_date('{$date_from->format('m-d-Y')}', 'mm-dd-yyyy')
                                    and ev.payment_type_code = '{$payment_type_code}'
                                group by ev.order_type_id
                                , ev.description
                                -- ,ev.prepare_order_number 
                                ,ev.product_type_code
                                , ev.payment_date
                                , ev.payment_number
                                , ev.customer_number
                                , ev.customer_name
                                , ev.currency
                                , ph.payment_header_id ";
        $queryBroughtForwardPayment = DB::select($strBroughtForwardPayment);
        // dd($queryBroughtForwardPayment);
        $strBroughtForwardOutstanding = "select  
                                            t.order_type_id
                                        ,i.product_type_code
                                        ,i.sa_number
                                            ,t.description as product_type_desc
                                            ,i.pick_exchange_date payment_date
                                            ,i.pick_release_no as payment_number
                                            ,sum($text2 * (select pick_exchange_rate from ptom_proforma_invoice_headers ph where ph.sa_number = i.sa_number and i.pick_release_no = ph.pick_release_no)) as amount
                                            ,customer_number
                                            ,customer_name
                                            ,currency
                                            ,'invoice' type_field
                                        from ptom_so_outstanding_exp_v i
                                            ,ptom_transaction_types_v t
                                        where payment_type_code = '{$payment_type_code}'
                                            and i.order_type_id = t.order_type_id
                                            and trunc(pick_exchange_date) < to_date('{$date_from->format('m-d-Y')}', 'mm-dd-yyyy')
                                        group by  t.order_type_id
                                        , t.description
                                        , i.pick_exchange_date
                                    ,i.product_type_code
                                    ,i.sa_number
                                        , i.pick_release_no
                                        , customer_number
                                        , customer_name
                                        , currency";

        $queryBroughtForwardOutstanding = DB::select($strBroughtForwardOutstanding);
        $cusNumber = $arrData['data']->pluck('customer_number')->toArray();

        $forward = collect(array_merge($queryBroughtForwardOutstanding, $queryBroughtForwardPayment));
        
        $raw_gain_loss = $this->calLoss($forward->pluck('sa_number')->map(function($i) { return "'". $i ."'";})->unique()->join(', '));
        $merge_customers = array_merge($cusNumber, $forward->pluck('customer_number')->unique()->toArray());

        $arrData['addCn'] = collect($this->addCNProcess($merge_customers));

        if(!!$customer_from && !!$customer_to){
            $forward = $forward->where('customer_number', '>=', $customer_from)->where('customer_number', '<=', $customer_to);
        }elseif(!!$customer_from) {
            $forward = $forward->where('customer_number', '>=', $customer_from);
        }elseif(!!$customer_to) {
            $forward = $forward->where('customer_number', '<=', $customer_to);
        }

       

        $arrData['data'] = $arrData['data']->map(function($q) use($forward, $programCode, $raw_gain_loss) {
            $gain_loss = 0;
            $i = $forward->where('customer_number', $q->customer_number)
            ->where('order_type_id', $q->order_type_id);
            foreach($i as $f) {
                $set1 = $raw_gain_loss['result1']->where('prepare_order_number', $f->sa_number)->sum('conversion_amount_exclude_vat');
                $set2 = $raw_gain_loss['result2']->where('sa_number', $f->sa_number)->sum('exchange');
                $set3 = $raw_gain_loss['result3']->where('sa_number', $f->sa_number)->where('pick_release_no', $f->payment_number)->sum('sub_total') ?? 0;
                $set4 = $raw_gain_loss['result4']->where('sa_number', $f->sa_number)->where('pick_release_no', $f->payment_number)->sum('exchange');
                $check_set4 = $raw_gain_loss['result4']->where('sa_number', $f->sa_number)->first();
                
                if(optional($check_set4)->pick_exchange_rate != null) {
                    $gain_loss += (($set1 + $set2) * $set3)- $set4;
                    // dump("(($set1 + $set2) * $set3)- $set4",  $f->sa_number, $f->payment_number);
                }
            }
          
            $forward_amount = $forward->where('customer_number', $q->customer_number)
                ->where('order_type_id', $q->order_type_id)
                ->where('type_field', 'payment')
                ->sum('amount')
                ;

            $forward_grand = $forward->where('customer_number', $q->customer_number)
                ->where('order_type_id', $q->order_type_id)
                ->where('type_field', 'invoice')
                ->sum('amount')
                ;
            if($programCode == 'OMR0051') {
                $q->forward = $forward_grand - $forward_amount;
    
            } elseif($programCode == 'OMR0050') {
                $q->forward = $forward_amount - $forward_grand;
            }
            
            $decimal_part = @explode('.', $q->forward)[1];
            $num_decimal_digits = strlen($decimal_part);
            if($num_decimal_digits > 2) {
                $rounded = floor( $q->forward *100) / 100;
            } else {
                $rounded = $q->forward;
            }
            $rounded_gain_loss = floor(number_format($gain_loss,5, '.', '') *100) / 100;
            $q->forward = $rounded - $rounded_gain_loss;
            return $q;
        });

        $arrData['fo_data'] = $forward->whereNotIn('customer_number', $arrData['data']->pluck('customer_number')->toArray())->groupBy(function($q)  {return $q->customer_number. $q->order_type_id; })->map(function($i) use($raw_gain_loss, $programCode) {
            $b = new stdClass;
            $gain_loss = 0;
            foreach($i as $f) {
                $set1 = $raw_gain_loss['result1']->where('prepare_order_number', $f->sa_number)->sum('conversion_amount_exclude_vat');
                $set2 = $raw_gain_loss['result2']->where('sa_number', $f->sa_number)->sum('exchange');
                $set3 = $raw_gain_loss['result3']->where('sa_number', $f->sa_number)->where('pick_release_no', $f->payment_number)->sum('sub_total') ?? 0;
                $set4 = $raw_gain_loss['result4']->where('sa_number', $f->sa_number)->where('pick_release_no', $f->payment_number)->sum('exchange');
                $check_set4 = $raw_gain_loss['result4']->where('sa_number', $f->sa_number)->first();
                
                if(optional($check_set4)->pick_exchange_rate != null) {
                    $gain_loss += (($set1 + $set2) * $set3)- $set4;
                    // dump("(($set1 + $set2) * $set3)- $set4",  $f->sa_number, $f->payment_number);
                }
            }
           
            $forward_amount = $i
            ->where('type_field', 'payment')
            ->sum('amount');
            $forward_grand = $i
                ->where('type_field', 'invoice')
                ->sum('amount');
            if($programCode == 'OMR0051') {
                $b->forward = $forward_grand - $forward_amount;

            } elseif($programCode == 'OMR0050') {
                $b->forward = $forward_amount - $forward_grand;
                $decimal_part = @explode('.', $b->forward)[1];
                $num_decimal_digits = strlen($decimal_part);
                if($num_decimal_digits > 2) {
                    $rounded = floor( $b->forward *100) / 100;
                } else {
                    $rounded = $b->forward;
                }
                // $number = $b->forward;
                // $rounded = floor($number *100) / 100;
                $rounded_gain_loss = floor($gain_loss *100) / 100;
                $b->forward = $rounded - $rounded_gain_loss;
            }
           
            
            $b->order_type_id = $i->first()->order_type_id;
            $b->product_type_code = $i->first()->product_type_code;
            $b->product_type_desc = $i->first()->product_type_desc;
            $b->customer_number = $i->first()->customer_number;
            $b->customer_name = $i->first()->customer_name;
            $b->payment_date = $i->first()->payment_date;
            $b->currency = $i->first()->currency;
            return $b;
        });
        $arrData['fo_data'] = $arrData['fo_data']->filter(function($i) {
            return $i->forward > 0;
        });
        // $arrData['data'] = $arrData['data']->merge($fo_data);
        return $arrData;
    }
}
