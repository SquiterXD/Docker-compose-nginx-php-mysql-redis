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
use Carbon\Carbon;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDO;

class OMR0066Controller extends Controller
{


    public function OMR0066($programcode, Request $request)
    {
        $dateFrom = Carbon::createFromFormat('d/m/Y', $request->date_start)->format('Y-m-d');
        $dateTo = Carbon::createFromFormat('d/m/Y', $request->date_end)->format('Y-m-d');
        

        $sql = "WITH dbl as (
        select payment_number AS Doc 
        ,'Receipt' as doc_type
        ,C.customer_id
        ,(select SUM(approve_quantity) FROM PTOM_ORDER_LINES pol where pol.ORDER_HEADER_ID=S.order_header_id )  as approve_quantity
        ,payment_date as Tax_Date
        ,c.customer_name
        ,S.CURRENCY as CURRENCY
        ,CAST(PY.conversion_rate AS NUMBER (7, 5)) as  CONVERSION_RATE
        ,PY.conversion_amount_exclude_vat  as Base
        ,PY.conversion_amount - PY.conversion_amount_exclude_vat as vat
        ,payment_amount as Amount
        ,S.vat_code  as VAT_TYPE
        ,P.description as product_type_desc
        ,P.order_type_id

        from  ptom_payment_exp_v PY,
        ptom_customers C,
        PTOM_ORDER_HEADERS S,
        PTOM_TRANSACTION_TYPES_V P
        where  PY.payment_type_code='10'
        and   PY.prepare_order_number=S.prepare_order_number
        and   S.order_type_id   =P.order_type_id
        and    C.customer_id=PY.customer_id
        and   trunc(payment_date) between to_date('{$dateFrom}', 'YYYY-MM-DD')
                and to_date('{$dateTo}', 'YYYY-MM-DD')
        and S.vat_code <>'SVAT-G0'
        union

        select 
        I.pick_release_no AS Doc
        ,'Invoice' as doc_type
        ,C.customer_id
        ,(select SUM(approve_quantity) FROM PTOM_ORDER_LINES pol where pol.ORDER_HEADER_ID=order_header_id )  as approve_quantity
        ,PP.pick_release_approve_date as Tax_Date
        ,c.customer_name
        ,I.CURRENCY as CURRENCY
        ,pp.pick_exchange_rate  as  CONVERSION_RATE
        ,I.sub_total as Base
        ,I.tax as vat
        ,I.grand_total as Amount
        ,I.vat_code as VAT_TYPE
        ,P.description as product_type_desc
        ,P.order_type_id
        from ptom_so_outstanding_exp_v I
        ,ptom_customers C
        ,PTOM_TRANSACTION_TYPES_V P
        ,ptom_proforma_invoice_headers  PP
        where C.customer_id=I.customer_id
        and   I.order_type_id   =P.order_type_id
        and   PP.pick_release_no=I.pick_release_no
        and   trunc(PP.pick_exchange_date) between to_date('{$dateFrom}', 'YYYY-MM-DD')
         and to_date('{$dateTo}', 'YYYY-MM-DD') 
        
        and I.payment_type_code=20
        and I.pick_release_status ='Confirm'
        and I.vat_code<>'SVAT-G0'

        union

        (select 
        I.pick_release_no AS Doc
        ,'Invoice' as doc_type
        ,C.customer_id
        ,(select SUM(approve_quantity) FROM PTOM_ORDER_LINES pol where pol.ORDER_HEADER_ID=order_header_id )  as approve_quantity
        ,PP.pick_release_approve_date as Tax_Date
        ,c.customer_name
        ,I.CURRENCY as CURRENCY
        ,pp.pick_exchange_rate as  CONVERSION_RATE
        ,sum(I.sub_total) as Base
        ,I.tax as vat
        ,sum(I.grand_total) as Amount
        ,I.vat_code as VAT_TYPE
        ,P.description as product_type_desc
        ,P.order_type_id
        from ptom_so_outstanding_exp_v I
        ,ptom_customers C
        ,PTOM_TRANSACTION_TYPES_V P
        ,ptom_proforma_invoice_headers  PP
        where C.customer_id=I.customer_id
        and   I.order_type_id   =P.order_type_id
        and   PP.pick_release_no=I.pick_release_no
        and   trunc(PP.pick_exchange_date) between to_date('{$dateFrom}', 'YYYY-MM-DD')
                and to_date('{$dateTo}', 'YYYY-MM-DD') 
        and I.pick_release_status ='Confirm'
        and I.vat_code='SVAT-G0'
        GROUP BY 
         I.pick_release_no
        ,C.customer_id
        ,I.order_header_id
        ,PP.pick_release_approve_date
        ,c.customer_name
        ,I.CURRENCY
        ,pp.pick_exchange_rate
        ,I.tax 
        ,I.vat_code
        ,P.description
        ,P.order_type_id
        
        )
        )

        SELECT 
        round(nvl(dbl.base * dbl.conversion_rate,0) , 2) convert_base
        ,round(nvl(dbl.vat * dbl.conversion_rate,0) , 2) convert_vat
        ,round(nvl(dbl.amount * dbl.conversion_rate,0) , 2) convert_amount
        , dbl.*
        FROM dbl";

        $result = \DB::select($sql);
         $tax_payer_id = DB::table('ptom_toat_address_v')->first();
        $result = collect($result);
        $customers = DB::table('ptom_customers')->whereIn('customer_id', $result->pluck('customer_id')->toArray())->get();
        $result = $result->map(function($i) use ($customers) {
            $i->customer = $customers->where('customer_id', $i->customer_id)->first();
            return $i;
        });
        $results = $result->groupBy(function($q){
            return $q->product_type_desc.$q->vat_type;
        });
        $pdf = PDF::loadView(
            'ct.Reports.omr0066.pdf.index',
            compact('results', 'tax_payer_id')
        )
            ->setPaper('a4')
            ->setOrientation('landscape')
            ->setOption('margin-bottom', 0)
            ->setOption('header-font-size', 9)
            ->setOption('header-spacing', -19, 430)
            ->setOption('header-right', '[page]   ');
        // return view(
        //     'ct.reports.omr0066.pdf.index',
        //     compact('results', 'tax_payer_id')
        // );
        return $pdf->stream($programcode . '.pdf');
    }
}
