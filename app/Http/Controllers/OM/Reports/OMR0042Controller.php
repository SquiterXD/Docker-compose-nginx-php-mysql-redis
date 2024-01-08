<?php

namespace App\Http\Controllers\OM\Reports;

use App\Http\Controllers\Controller;
use App\Models\OM\DebtDomV;
use App\Models\OM\PaymentDomV;
use Illuminate\Http\Request;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class OMR0042Controller extends Controller
{
    public function OMR0042PDF($programcode, $request){
        $request = request();
        $from_date = Carbon::createFromFormat('d/m/Y', $request->from_date)->format('Y-m-d');
        $to_date = Carbon::createFromFormat('d/m/Y', $request->to_date)->format('Y-m-d');
        $items = DebtDomV::query()
        ->where('credit_group_code', '0')
        ->whereRaw("TRUNC(pick_release_approve_date) BETWEEN to_date('{$from_date}', 'yyyy-mm-dd') AND to_date('{$to_date}', 'yyyy-mm-dd')")
        ->whereNotIn('customer_type_id', ['30', '40', '80'])
        ->whereIn('product_type_code', ['10'])
        ->with(['outstandingDebt' => function($q) use ($from_date) {
            return $q->where('pick_release_approve_date', '<', $from_date);
        }])
        ->get();
        $user = auth()->user();
        $fileName = date('Y/m/d');
        $paymentDomV = PaymentDomV::query()
        ->select(
            'ptom_payment_dom_v.*',
            'ptom_debt_dom_v.product_type_code'
        )
        ->whereNotIn('ptom_debt_dom_v.customer_type_id', ['30', '40', '80'])
        ->whereIn('ptom_debt_dom_v.product_type_code', ['10'])
        ->where('ptom_payment_dom_v.credit_group_code', '0')
        ->whereRaw("TRUNC(ptom_payment_dom_v.payment_date) BETWEEN to_date('{$from_date}', 'yyyy-mm-dd') AND to_date('{$to_date}', 'yyyy-mm-dd')")
        ->join('ptom_debt_dom_v', function ($q) {
            $q->on('ptom_debt_dom_v.prepare_order_number', '=', 'ptom_payment_dom_v.prepare_order_number');
            $q->where('ptom_debt_dom_v.credit_group_code', '=', '0');
        })
        ->get();
        $result = $items->sortBy('customer_number')->groupBy('customer_id');
        $result = $result->map(function($i, $k) use ( $from_date, $to_date){
            $debtDomV = DebtDomV::query()
                ->whereNotIn('customer_type_id', ['30', '40', '80'])
                ->whereIn('product_type_code', ['10'])
                ->where('credit_group_code', '0')
                ->where('customer_id', $k)
                ->whereRaw("TRUNC(due_date) BETWEEN to_date('{$from_date}', 'yyyy-mm-dd') AND to_date('{$to_date}', 'yyyy-mm-dd')")
                ->whereRaw("TRUNC(pick_release_approve_date) < to_date('{$from_date}', 'yyyy-mm-dd')")
                ->sum('outstanding_debt');
                // ->get();
            foreach($i as $k) {
                $k->sum = $debtDomV;
            } 
            return $i;
        });



        $contentHtml = view('om.reports.omr0042.main_page', compact('programcode', 'request', 'result', 'paymentDomV'))->render();
        // return view('om.reports.omr0042.main_page', compact('programcode', 'request', 'result', 'paymentDomV'));
        return PDF::loadHtml($contentHtml)
            ->setPaper('a4')
            ->setOrientation('landscape')
            ->setOption('margin-bottom', 0)
            ->setOption('header-font-size', 9)
            ->setOption('header-spacing', -21, 300)
            ->setOption('header-right', '[page]                      ')
            ->stream($fileName.'.pdf');

        /////////// ร้านค้า รหัสร้านค้า /////////
        $sql_1 = 'select
        PDDV.customer_number, PDDV.customer_name, pick_release_approve_date
        from
        ptom_debt_dom_v PDDV
        where
        customer_type_id = \'10\'
        ';

        //////////// ลูกนี้ \\\\\\\\\\\\\\\\\\
        $sql_2 = 'select
        sum(PD.outstanding_debt)
        from
        ptom_debt_dom_v PD
        where
        credit_group_code = \'0\'
        and product_type_code = \'10\'
        group by
        customer_id
        ';

        //////////// เจ้าหนี้ \\\\\\\\\\\\\\\\\\\\
        $sql_3 = 'select
        payment_date, sum(PD.payment_amount)-sum(PM.payment_amount)
        from
        ptom_payment_headers PH,
        ptom_payment_details PD,
        ptom_payment_match_invoices PM
        where
        PH.payment_header_id = PD.payment_header_id
        and PH.payment_header_id = PM.payment_header_id
        and PM.match_flag = \'Y\'
        and PH.payment_status = \'Confirm\'
        and sales_classification_code = \'Domestic\'
        group by
        payment_date
        ';

        //////////// ยอดจำหน่าย \\\\\\\\\\\\\\\\\\\\
        $sql_4 = 'select
        sum(PDDV.outstanding_debt)
        from
        ptom_debt_dom_v PDDV
        where
        PDDV.credit_group_code = \'0\'
        and PDDV.product_type_code = \'10\'
        group by
        customer_id
        ';


        //////////// ยอดชำระเงิน \\\\\\\\\\\\\\\\\\\\
        $sql_5 = 'select
        sum(B.payment_amount)
        from
        ptom_payment_headers A,
        ptom_payment_details B
        where
        A.payment_header_id = B.payment_header_id
        and B.payment_method_code = \'10\'
        and A.payment_status = \'Confirm\'
        and sales_classification_code = \'Domestic\'
        group by
        customer_id
        ';

        $data_1 =  DB::select($sql_1);
        $data_2 =  DB::select($sql_2);
        $data_3 =  DB::select($sql_3);
        $data_4 =  DB::select($sql_4);
        $data_5 =  DB::select($sql_5);


        // dd( $request->all() ,$data_2 , $sql_1);

        $user = auth()->user();
        $fileName = date('Y/m/d');
        $contentHtml = view('om.reports.omr0042.main_page', compact('programcode', 'request', 'data_1', 'data_2'))->render();
        return view('om.reports.omr0042.main_page', compact('programcode', 'request', 'data_1', 'data_2'));
        return PDF::loadHtml($contentHtml)
        ->setOrientation('landscape')
        ->setOption('margin-top', '20')
        ->setOption('header-html', view('om.reports.omr0042.header', compact('user'))->render())
        ->setOption('margin-top', '30')
        ->stream($fileName.'.pdf');

    }

    public function OMR0042EXCEL($programcode, $request)
    {
        // $apIn= PtctMfgBatchGenWipend::get();
        // return Excel::download(new OMR0121, $programcode.'.xlsx');
    }
}
