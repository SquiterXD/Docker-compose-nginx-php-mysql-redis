<?php

namespace App\Http\Controllers\CT\Reports;

use App\Exports\CT\CTR0012;
use App\Exports\CT\CTR0032;
use App\Exports\CT\PDR0003;
use App\Http\Controllers\Controller;
use App\Models\OM\CreditNote\CreditGroupModel;
use App\Models\OM\DebtDomV;
use App\Models\OM\Order;
use App\Models\OM\PaymentDomV;
use App\Models\PD\PtpdDetailsWrappersBlendV;
use App\Models\PD\PtpdSummaryFMLCigaretteV;
use Carbon\Carbon;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDO;

class OMP0046Controller extends Controller
{


    public function OMP0046($programcode, Request $request)
    {
        $customerNumberFrom = $request->customer_number_from;
        $customerNumberTo = $request->customer_number_to;
        $creditGroupCode = $request->credit_group_id;
        $dateFrom = Carbon::createFromFormat('d/m/Y', $request->date_from)->format('Y-m-d');
        $dateTo = Carbon::createFromFormat('d/m/Y', $request->date_to)->format('Y-m-d');
        // Case 1
        $debtDomV = DebtDomV::query()
            ->whereNotIn('customer_type_id', ['30', '40', '80'])
            ->whereIn('product_type_code', ['10'])
            ->where('credit_group_code', $creditGroupCode)
            ->whereRaw("TRUNC(pick_release_approve_date) BETWEEN to_date('{$dateFrom}') AND to_date('{$dateTo}')")
            ->when(!empty($customerNumberFrom) && !empty($customerNumberTo), function ($q) use ($customerNumberFrom, $customerNumberTo) {
                $q->whereRaw("customer_number BETWEEN '{$customerNumberFrom}' AND '{$customerNumberTo}'");
            })
            ->get();
            
        $paymentDomV = PaymentDomV::query()
            ->select(
                'ptom_payment_dom_v.*',
                'ptom_debt_dom_v.product_type_code'
            )
            ->whereNotIn('ptom_debt_dom_v.customer_type_id', ['30', '40', '80'])
            ->whereIn('ptom_debt_dom_v.product_type_code', ['10'])
            ->where('ptom_payment_dom_v.credit_group_code', $creditGroupCode)
            ->whereRaw("TRUNC(ptom_payment_dom_v.payment_date) BETWEEN to_date('{$dateFrom}', 'yyyy-mm-dd') AND to_date('{$dateTo}', 'yyyy-mm-dd')")
            ->when(!empty($customerNumberFrom) && !empty($customerNumberTo), function ($q) use ($customerNumberFrom, $customerNumberTo) {
                $q->whereRaw("ptom_payment_dom_v.customer_number BETWEEN '{$customerNumberFrom}' AND '{$customerNumberTo}'");
            })
            ->join('ptom_debt_dom_v', function ($q) use ($creditGroupCode) {
                $q->on('ptom_debt_dom_v.prepare_order_number', '=', 'ptom_payment_dom_v.prepare_order_number');
                $q->where('ptom_debt_dom_v.credit_group_code', '=', $creditGroupCode);
            })
            ->get();
        $creditGroup = CreditGroupModel::where('lookup_code', $creditGroupCode)->first();


        // รวมค่าที่ไม่มีอยู่ใน ส่วนแรก
        $customer_id_all = array_unique($debtDomV->pluck('customer_id')->toArray());
        $customer_id_all = implode(',', $customer_id_all);
        $sql = "select
        'othor' data_ty,
        c.*
    FROM
        (
            SELECT
                customer_id,
                customer_name,
                customer_number,
                (
                    SELECT
                        sum(debt_amount)
                    FROM
                        ptom_debt_dom_v
                    WHERE
                        1 = 1
                        AND customer_id = c.customer_id
                        AND credit_group_code = {$creditGroupCode}
                        AND TRUNC(pick_release_approve_date) < to_date('{$dateFrom}', 'yyyy-mm-dd')
                ) debt_amount,
                (
                    SELECT
                        sum(payment_amount)
                    FROM
                        ptom_payment_dom_v
                    WHERE
                        1 = 1
                        AND customer_id = c.customer_id
                        AND credit_group_code = {$creditGroupCode}
                        AND TRUNC(payment_date) < to_date('{$dateFrom}', 'yyyy-mm-dd')
                ) payment_amount
            FROM
                ptom_customers c
            WHERE 1=1
            ) c
        WHERE 1=1
        AND debt_amount > 0 OR Payment_amount> 0";
        $dataMerge = collect(DB::select($sql));
        $debtDomV = $debtDomV->mergeRecursive($dataMerge);
        $result = $debtDomV->sortBy('customer_number')->groupBy('customer_id');
        $result = $result->map(function ($i, $k) use ($creditGroupCode, $dateFrom, $dateTo) {
            $sumObj = $i->where('data_ty', 'othor');

            if (count($sumObj) > 0) {
                foreach ($i as $k) {
                    $k->sum = $sumObj->first()->debt_amount - $sumObj->first()->payment_amount ;
                }
            } else {
                $debtDomV = DebtDomV::query()
                    // ->whereNotIn('customer_type_id', ['30', '40', '80'])
                    ->whereNotIn('customer_type_id', ['30', '40'])
                    ->whereIn('product_type_code', ['10'])
                    ->where('credit_group_code', $creditGroupCode)
                    ->where('customer_id', $k)
                    ->whereRaw("TRUNC(due_date) BETWEEN to_date('{$dateFrom}', 'yyyy-mm-dd') AND to_date('{$dateTo}', 'yyyy-mm-dd')")
                    ->whereRaw("TRUNC(pick_release_approve_date) < to_date('{$dateFrom}', 'yyyy-mm-dd')")
                    ->orderBy('pick_release_approve_date', 'desc')
                    // ->take(1)
                    ->sum('debt_amount');
                // ->get();


                $order = Order::where('ORDER_STATUS', 'Confirm')
                    ->where('PICK_RELEASE_STATUS', 'Confirm')
                    ->where('CUSTOMER_ID', $i->first()->customer_id)
                    ->whereRaw("TRUNC(pick_release_approve_date) < to_date('{$dateFrom}', 'yyyy-mm-dd')")
                    ->sum('grand_total');

                $sql = "select 
               sum(payment_amount) payment_amount
                 from ptom_payment_dom_v PD
                where PD.customer_id = '{$i->first()->customer_id}'
                AND TRUNC(payment_date) < to_date('{$dateFrom}', 'yyyy-mm-dd')";
                $ptom_payment_dom_v = optional(collect(DB::select($sql))->first())->payment_amount;
                if ($i->first()->customer_id == 108) {
                    dump('order ' . $order);
                    dump('ptom_payment_dom_v ' . $ptom_payment_dom_v);
                }
                foreach ($i as $k) {
                    // $k->sum = $debtDomV;
                    $k->sum = $order- $ptom_payment_dom_v;

                }
            }

            return $i;
        });

        $pdf = PDF::loadView(
            'ct.Reports.omp0046.pdf.index',
            compact('result', 'creditGroup', 'paymentDomV')
        )
            ->setPaper('a4')
            ->setOrientation('landscape')
            ->setOption('margin-bottom', 0)
            ->setOption('header-font-size', 9)
            ->setOption('header-spacing', -21, 300)
            ->setOption('header-right', '[page]                      ');
        // return view(
        //     'ct.reports.omp0046.pdf.index',
        //     compact('result', 'creditGroup', 'paymentDomV')
        // );
        return $pdf->stream($programcode . '.pdf');
    }
}
