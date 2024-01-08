<?php

namespace App\Http\Controllers\CT\Reports;

use App\Exports\CT\CTR0012;
use App\Exports\CT\CTR0032;
use App\Exports\CT\PDR0003;
use App\Http\Controllers\Controller;
use App\Models\OM\CreditNote\CreditGroupModel;
use App\Models\OM\DebtDomV;
use App\Models\OM\PaymentDomV;
use App\Models\PD\PtpdDetailsWrappersBlendV;
use App\Models\PD\PtpdSummaryFMLCigaretteV;
use Carbon\Carbon;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDO;

class OMR0091Controller extends Controller
{


    public function OMR0091($programcode, Request $request)
    {
        $customerNumberFrom = $request->customer_number_from;
        $customerNumberTo = $request->customer_number_to;
        $creditGroupCode = $request->credit_group_id;
        $dateFrom = Carbon::createFromFormat('d/m/Y', $request->date_from)->format('Y-m-d');
        $dateTo = Carbon::createFromFormat('d/m/Y', $request->date_to)->format('Y-m-d');
        // Case 1
        $debtDomV = DebtDomV::query()
            ->whereIn('ptom_debt_dom_v.customer_type_id', ['30', '40'])
                // ->where('customer_number', 'D00012')
                ->whereIn('ptom_debt_dom_v.product_type_code', ['10'])
                ->where('ptom_debt_dom_v.credit_group_code', 0)
            ->whereRaw("TRUNC(ptom_debt_dom_v.consignment_date) BETWEEN to_date('{$dateFrom}', 'yyyy-mm-dd') AND to_date('{$dateTo}', 'yyyy-mm-dd')")
            ->when(!empty($customerNumberFrom) && !empty($customerNumberTo), function ($q) use ($customerNumberFrom, $customerNumberTo) {
                $q->whereRaw("ptom_debt_dom_v.customer_number BETWEEN '{$customerNumberFrom}' AND '{$customerNumberTo}'");
            })
            ->select('customer_type_id', 
            'customer_number',
            'customer_id',
            'debt_amount',
            'customer_name'
            )
            ->get();
        $paymentDomV = PaymentDomV::query()
            ->selectRaw(
                'ptom_payment_dom_v.customer_id ,
                 ptom_payment_dom_v.payment_amount ,
                 ptom_payment_dom_v.customer_type customer_type_id,
                 ptom_payment_dom_v.customer_number ,
                 ptom_payment_dom_v.customer_name',
            )
            ->whereIn('ptom_payment_dom_v.customer_type', ['30', '40'])
            ->where('ptom_payment_dom_v.credit_group_code', 0)
            ->whereNotNull('ptom_payment_dom_v.invoice_number')
            ->whereRaw("TRUNC(ptom_payment_dom_v.payment_date) BETWEEN to_date('{$dateFrom}', 'yyyy-mm-dd') AND to_date('{$dateTo}', 'yyyy-mm-dd')")
            ->when(!empty($customerNumberFrom) && !empty($customerNumberTo), function ($q) use ($customerNumberFrom, $customerNumberTo) {
                $q->whereRaw("ptom_payment_dom_v.customer_number BETWEEN '{$customerNumberFrom}' AND '{$customerNumberTo}'");
            })
            ->get();


            // ลูกหนี้ยกมา
            $subQuery = "SELECT customer_id cus_id, sum(payment_amount) payment_amount FROM ptom_payment_dom_v 
            WHERE TRUNC(ptom_payment_dom_v.payment_date) < to_date('{$dateFrom}', 'yyyy-mm-dd') 
            AND ptom_payment_dom_v.customer_type in ('30', '40')
            -- AND ptom_payment_dom_v.credit_group_code in ('2', '3')
            AND ptom_payment_dom_v.invoice_number is not null
            GROUP BY customer_id";

            $poured_over = DebtDomV::query()
            ->select('customer_id','customer_number', 'customer_name', 'customer_type_id',
                DB::raw('sum(debt_amount) debt_amount_poured_over'),
                DB::raw('payment_amount payment_amount_poured_over'),
                DB::raw('sum(ptom_debt_dom_v.debt_amount) -  nvl(payment_amount, 0) poured_over'),
            )
            ->leftjoin(DB::raw("({$subQuery}) sub"), function($join){
                $join->on('sub.cus_id', '=', 'ptom_debt_dom_v.customer_id');
            })
            ->whereRaw("TRUNC(ptom_debt_dom_v.consignment_date) < to_date('{$dateFrom}', 'yyyy-mm-dd')")
                // ->where('customer_number', 'D00012')
            ->whereIn('ptom_debt_dom_v.customer_type_id', ['30', '40'])
            ->whereIn('ptom_debt_dom_v.product_type_code', ['10'])
            // ->havingRaw("sum(ptom_debt_dom_v.debt_amount) -  payment_amount > 0")
            ->groupBy('customer_id', 'customer_number', 'customer_name', 'customer_type_id', 'payment_amount')
            ->get();
            // creditor
            $subQuery = "SELECT customer_id cus_id, sum(debt_amount) debt_amount FROM ptom_debt_dom_v 
            WHERE TRUNC(ptom_debt_dom_v.consignment_date) < to_date('{$dateFrom}', 'yyyy-mm-dd') 
            AND ptom_debt_dom_v.customer_type_id in ('30', '40')
            AND ptom_debt_dom_v.product_type_code in ('10')
            GROUP BY customer_id";

            $creditor = PaymentDomV::query()
            ->selectRaw(
                'ptom_payment_dom_v.customer_id ,
                 sum(ptom_payment_dom_v.payment_amount) - debt_amount creditor,
                 ptom_payment_dom_v.customer_type customer_type_id,
                 ptom_payment_dom_v.customer_number ,
                 ptom_payment_dom_v.customer_name',
            )
            ->join(DB::raw("({$subQuery}) sub"), function($join){
                $join->on('sub.cus_id', '=', 'ptom_payment_dom_v.customer_id');
            })
            ->whereIn('ptom_payment_dom_v.customer_type', ['30', '40'])
            ->where('ptom_payment_dom_v.credit_group_code', 0)
            ->whereNotNull('ptom_payment_dom_v.invoice_number')
            ->whereRaw("TRUNC(ptom_payment_dom_v.payment_date) < to_date('{$dateFrom}', 'yyyy-mm-dd')")
            ->havingRaw("sum(ptom_payment_dom_v.payment_amount) - debt_amount > 0")
            ->groupBy('customer_id', 'customer_type', 'customer_number', 'customer_name', 'debt_amount')
            ->get();

            $debtDomV = $debtDomV->map(function($i) {
                $i->payment_amount = 0;
                return $i;
            });

            $paymentDomV = $paymentDomV->map(function($i) {
                $i->debt_amount = 0;
                return $i;
            });

            $debtDomV = $debtDomV->mergeRecursive($paymentDomV);
            $debtDomV = $debtDomV->mergeRecursive($poured_over); // ลูกหนี้ยกมา
            $debtDomV = $debtDomV->mergeRecursive($creditor); // creditor
        $result = $debtDomV->sortBy('customer_type_id')->groupBy('customer_type_id');
        
        $result = $result->map(function($i, $k) use ($creditGroupCode, $dateFrom, $dateTo ){
            $i = $i->map(function($i) use($dateFrom, $dateTo){
                $debtDomV = DebtDomV::query()
                ->whereIn('customer_type_id', ['30', '40'])
                ->whereIn('product_type_code', ['10'])
                // ->where('customer_number', 'D00008')
                ->where('credit_group_code', 0)
                ->where('customer_id', $i->customer_id)
                ->whereRaw("TRUNC(due_date) BETWEEN to_date('{$dateFrom}', 'yyyy-mm-dd') AND to_date('{$dateTo}', 'yyyy-mm-dd')")
                ->whereRaw("TRUNC(consignment_date) < to_date('{$dateFrom}', 'yyyy-mm-dd')")
                ->sum('debt_amount');
                // ->get();
                $i->sum = $debtDomV;
                // foreach($i as $k) {
                //     $k->sum = $debtDomV;
                // } 
                return $i;
            });
            return $i;
        });

        // dd($result);
        $pdf = PDF::loadView(
            'ct.Reports.omp0091.pdf.index',
            compact('result', 'paymentDomV')
        )
            ->setPaper('a4')
            ->setOrientation('landscape')
            ->setOption('margin-bottom', 0)
            ->setOption('header-font-size', 9)
            ->setOption('header-spacing', -21, 300)
            ->setOption('header-right', '[page]                      ');
        // return view(
        //     'ct.reports.omp0091.pdf.index',
        //     compact('result', 'paymentDomV')
        // );
        return $pdf->stream($programcode . '.pdf');
    }
}
