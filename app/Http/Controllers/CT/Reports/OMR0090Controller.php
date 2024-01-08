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

class OMR0090Controller extends Controller
{


    public function OMR0090($programcode, Request $request)
    {
        $customerNumberFrom = $request->customer_number_from;
        $customerNumberTo   = $request->customer_number_to;
        $creditGroupCode    = $request->credit_group_id;
        $dateFrom           = Carbon::createFromFormat('d/m/Y', $request->date_from)->format('Y-m-d');
        $dateTo             = Carbon::createFromFormat('d/m/Y', $request->date_to)->format('Y-m-d');
       
        if(!empty($request->customer_number_from) && !empty($request->customer_number_to)) {
            $where = "AND CUSTOMER_NUMBER BETWEEN '{$request->customer_number_from}' AND '{$request->customer_number_to}'";
        } else {
            $where = "";
        }
        # ยอดยกมา
        $quotedSql = "
        WITH ph AS (
            select
                sum(total_payment_amount) total_payment_amount,
                customer_id
            from
                ptom_payment_headers
            where
                trunc(payment_date) < TO_DATE('{$dateFrom}', 'YYYY-MM-DD')
            GROUP BY
                customer_id
        ),
        domV as (
            select
                sum(debt_amount) debt_amount,
                customer_id
            from
                ptom_debt_dom_v C
            where
                trunc(consignment_date) < TO_DATE('{$dateFrom}', 'YYYY-MM-DD')
            GROUP BY
                customer_id
        ),
        quoted as (
            SELECT
                ph.total_payment_amount,
                domV.debt_amount,
                debt_amount - total_payment_amount as total_amount,
                nvl(ph.customer_id, domV.customer_id) customer_id
            FROM
                ph full
                join domV on ph.customer_id = domV.customer_id
        )
        SELECT
            q.*, c.customer_name, c.customer_number
        FROM
            quoted q JOIN ptom_customers c ON q.customer_id = c.customer_id
        WHERE
            total_amount > 0
            {$where}
        ";

        // ยอดยกมา
        $quoted = collect(DB::select($quotedSql));
        # case 18
        $sql =  "select customer_id, sum(payment_amount) - (select sum(debt_amount)
                        from ptom_debt_dom_v C
                    WHERE customer_id = 18
                    AND trunc(consignment_date) < TO_DATE('{$dateFrom}', 'YYYY-MM-DD')
                    ) total_moving
                    from ptom_payment_dom_v
                    WHERE customer_id = 18
                    AND invoice_number is not null
                    AND trunc(payment_date) < TO_DATE('{$dateFrom}', 'YYYY-MM-DD')
                    GROUP BY customer_id
                ";
        $resultsFollowGroup18 = collect(DB::select($sql));
        if(!empty($request->customer_number_from) && !empty($request->customer_number_to)) {
            $cWhere = "AND C.CUSTOMER_NUMBER BETWEEN '{$request->customer_number_from}' AND '{$request->customer_number_to}'";
        } else {
            $cWhere = "";
        }
        #รายการทั้งหมด
        $sql = "
                    SELECT
                        CUSTOMER_NUMBER,
                        CUSTOMER_ID,
                        CUSTOMER_NAME,
                        CONSIGNMENT_NO,
                        CONSIGNMENT_DATE AT_DATE,
                        C.CUSTOMER_TYPE_ID,
                        DEBT_AMOUNT,
                        0 TOTAL_PAYMENT_AMOUNT,
                        2 SORTING,
                        'GENARAL' TYPSIS
                    FROM
                        PTOM_DEBT_DOM_V C
                    WHERE
                        TRUNC(CONSIGNMENT_DATE) BETWEEN TO_DATE('{$dateFrom}', 'YYYY-MM-DD')
                        AND TO_DATE('{$dateTo}', 'YYYY-MM-DD')
                        {$where}
                        AND CUSTOMER_TYPE_ID in (30, 40)
                    UNION
                    SELECT
                        C.CUSTOMER_NUMBER,
                        C.CUSTOMER_ID,
                        C.CUSTOMER_NAME,
                        P.invoice_headers_number CONSIGNMENT_NO,
                        P.invoice_date AT_DATE,
                        C.CUSTOMER_TYPE_ID,
                        0 DEBT_AMOUNT,
                        P.invoice_amount TOTAL_PAYMENT_AMOUNT,
                        1 SORTING,
                        'GENARAL' TYPSIS
                    FROM
                        PTOM_INVOICE_HEADERS P
                        LEFT JOIN PTOM_CUSTOMERS C ON C.CUSTOMER_ID = P.CUSTOMER_ID
                    WHERE
                        TRUNC(P.invoice_date) BETWEEN TO_DATE('{$dateFrom}', 'YYYY-MM-DD')
                        AND TO_DATE('{$dateTo}', 'YYYY-MM-DD')
                        AND P.invoice_type='CN_TRANFER'
                        AND P.invoice_status='Confirm'
                        {$where}
                        AND C.CUSTOMER_ID != 18
                        AND CUSTOMER_TYPE_ID in (30, 40)
                    UNION
                    SELECT
                        C.CUSTOMER_NUMBER,
                        C.CUSTOMER_ID,
                        C.CUSTOMER_NAME,
                        P.payment_number CONSIGNMENT_NO,
                        p.payment_date AT_DATE,
                        C.CUSTOMER_TYPE_ID,
                        0 DEBT_AMOUNT,
                        p.TOTAL_PAYMENT_AMOUNT,
                        2 SORTING,
                        'GENARAL_FALSE' TYPSIS
                    FROM
                        ptom_payment_headers P
                        LEFT JOIN PTOM_CUSTOMERS C ON C.CUSTOMER_ID = P.CUSTOMER_ID
                        Left Join ( SELECT pv.*, debt.product_type_code FROM PTOM_PAYMENT_DOM_V pv 
                                LEFT JOIN 
                                PTOM_DEBT_DOM_V debt ON nvl(pv.prepare_order_number, pv.invoice_number) = nvl(debt.prepare_order_number, debt.consignment_no)) debt_vs
                        on debt_vs.payment_number = P.payment_number
                    WHERE
                        TRUNC(P.payment_date) BETWEEN TO_DATE('{$dateFrom}', 'YYYY-MM-DD')
                        AND TO_DATE('{$dateTo}', 'YYYY-MM-DD')
                        AND P.payment_status='Confirm'
                        AND debt_vs.product_type_code=10
                        AND C.CUSTOMER_ID = 18
                        {$cWhere}
                        AND C.CUSTOMER_TYPE_ID in (30, 40)
                ";

        // รายการทั้งหมด
        $results = collect(DB::select($sql));
        
        // $sql = "select  customer_id, sum(invoice_amount) - (SELECT sum(debt_amount)
        //                                                         FROM ptom_debt_dom_v p 
        //                                                         WHERE p.customer_id = H.customer_id
        //                                                         AND trunc(consignment_date) < TO_DATE('{$dateFrom}', 'YYYY-MM-DD')
        //                                                         ) total_moving
        //             from  PTOM_INVOICE_HEADERS H
        //             where invoice_type='CN_TRANFER'
        //             and invoice_status='Confirm'
        //             and  invoice_date < TO_DATE('{$dateFrom}', 'YYYY-MM-DD')
        //             -- AND H.customer_id = p.customer_id
        //             AND H.customer_id in ({$results->pluck('customer_id')->join(',')})
        //             GROUP BY customer_id
        // ";
        $sql = "SELECT
                    customer_id,
                    nvl((
                        SELECT
                            SUM (debt_amount)
                        FROM
                            ptom_debt_dom_v p
                        WHERE
                            p.customer_id = c.customer_id
                            AND TRUNC (consignment_date) < TO_DATE ('{$dateFrom}', 'YYYY-MM-DD')
                        GROUP BY
                            CUSTOMER_ID
                    ),0) - 
                    nvl((
                        SELECT
                            SUM (invoice_amount)
                        FROM
                            PTOM_INVOICE_HEADERS H
                        WHERE
                            invoice_type = 'CN_TRANFER'
                            AND invoice_status = 'Confirm'
                            AND invoice_date < TO_DATE ('{$dateFrom}', 'YYYY-MM-DD') 
                            AND H.customer_id = c.CUSTOMER_ID
                        GROUP BY
                            customer_id
                    ),0) total_moving
                FROM
                    PTOM_CUSTOMERS c
                WHERE
                    CUSTOMER_ID IN ({$results->pluck('customer_id')->join(',')})";
        
        $resultsFollowGroupNot18    = collect(DB::select($sql));
        $follow                     = $resultsFollowGroupNot18->merge($resultsFollowGroup18);
        $creditGroup                = CreditGroupModel::where('lookup_code', $creditGroupCode)->first();
        // return view('ct.Reports.omr0090.pdf.index_new',
        // compact('results', 'creditGroup', 'follow', 'quoted'));

        $pdf = PDF::loadView(
            'ct.Reports.omr0090.pdf.index_new',
            compact('results', 'creditGroup', 'follow', 'quoted')
        )
            ->setPaper('a4')
            ->setOrientation('landscape')
            ->setOption('margin-bottom', 0)
            ->setOption('header-font-size', 9)
            ->setOption('header-spacing', -21, 300)
            ->setOption('header-right', '[page]                                           ');
        return $pdf->stream($programcode . '.pdf');
       
        // Case 1
        $debtDomV = DebtDomV::query()
            ->where('credit_group_code', '0')
            ->whereRaw("pick_release_approve_date BETWEEN to_date('{$dateFrom}') AND to_date('{$dateTo}')")
            ->when(!empty($customerNumberFrom) && !empty($customerNumberTo), function ($q) use ($customerNumberFrom, $customerNumberTo) {
                $q->whereRaw("customer_number BETWEEN '{$customerNumberFrom}' AND '{$customerNumberTo}'");
            })
            ->get();
        $paymentDomV = PaymentDomV::query()
            ->select(
                'ptom_payment_dom_v.*',
                'ptom_debt_dom_v.product_type_code'
            )
            ->where('ptom_payment_dom_v.credit_group_code', 0)
            ->whereRaw("ptom_payment_dom_v.payment_date BETWEEN to_date('{$dateFrom}') AND to_date('{$dateTo}')")
            ->when(!empty($customerNumberFrom) && !empty($customerNumberTo), function ($q) use ($customerNumberFrom, $customerNumberTo) {
                $q->whereRaw("ptom_payment_dom_v.customer_number BETWEEN '{$customerNumberFrom}' AND '{$customerNumberTo}'");
            })
            ->leftjoin('ptom_debt_dom_v', function ($q) use ($creditGroupCode) {
                $q->on('ptom_debt_dom_v.prepare_order_number', '=', 'ptom_payment_dom_v.prepare_order_number');
                $q->where('ptom_debt_dom_v.credit_group_code', '=', '0');
            })
            ->get();

        $debtDomVmap = [];
        foreach ($debtDomV as $item) {
            // if ($item->customer_type_id == '30' && $item->product_type_code == '10') {
            // $debtDomVmap[] = [
            //     'date' => $item->consignment_date,
            //     'desc' => $item->consignment_no,
            //     'customer_number' => $item->customer_number,
            //     'customer_name' => $item->customer_name,
            //     'due_date' => $item->due_date,
            //     'debt_amount' => $item->debt_amount,
            //     'prepare_order_number' => $item->prepare_order_number,
            //     'payment_amount' => '',
            //     'case' => '1.2',
            //     'type' => '1'
            // ];
            // } else {
            if (($item->customer_type_id == '30' || $item->customer_type_id == '40') && $item->product_type_code == '10') {
                $debtDomVmap[] = [
                    'date'                  => $item->pick_release_approve_date,
                    'desc'                  => $item->pick_release_no,
                    'customer_number'       => $item->customer_number,
                    'customer_name'         => $item->customer_name,
                    'due_date'              => $item->due_date,
                    'prepare_order_number'  => $item->prepare_order_number,
                    'credit_group_code'     => $item->credit_group_code,
                    'debt_amount'           => $item->debt_amount,
                    'payment_amount'        => '',
                    'case'                  => '1.1',
                    'type'                  => '1'
                ];
            }
            // $debtDomVmap[] = [
            //     'date' => $item->pick_release_approve_date,
            //     'desc' => $item->pick_release_no,
            //     'customer_number' => $item->customer_number,
            //     'customer_name' => $item->customer_name,
            //     'due_date' => $item->due_date,
            //     'prepare_order_number' => $item->prepare_order_number,
            //     'debt_amount' => $item->debt_amount,
            //     'payment_amount' => '',
            //     'case' => '1.1',
            //     'type' => '1'
            // ];
            // }
        };
        foreach ($paymentDomV as $i) {
            // if ($i->customer_type_id == '30' && $i->product_type_code == '10') {
            //     $debtDomVmap[] = [
            //         'date' => $i->payment_date,
            //         'desc' => $i->payment_number,
            //         'customer_number' => $i->customer_number,
            //         'customer_name' => $i->customer_name,
            //         'due_date' => $i->payment_date,
            //         'debt_amount' => '',
            //         'prepare_order_number' => $i->prepare_order_number,
            //         'payment_amount' => $i->payment_amount,
            //         'case' => '2.2',
            //         'type' => '2'
            //     ];
            // } else {
            if (($i->customer_type == '30' || $i->customer_type == '40') && $i->product_type_code == '10') {
                $debtDomVmap[] = [
                    'date'                  => $i->payment_date,
                    'desc'                  => $i->payment_number,
                    'customer_number'       => $i->customer_number,
                    'customer_name'         => $i->customer_name,
                    'due_date'              => $i->payment_date,
                    'credit_group_code'     => $i->credit_group_code,
                    'debt_amount'           => '',
                    'prepare_order_number'  => $i->prepare_order_number,
                    'payment_amount'        => $i->payment_amount,
                    'case'                  => '2.1',
                    'type'                  => '2'

                ];
            }
            // }
        }

        $debtDomVmap = collect($debtDomVmap)->filter(function ($item) {
            if (!empty($item)) return true;
        });
        $creditGroup = CreditGroupModel::where('lookup_code', $creditGroupCode)->first();
        $result = $debtDomVmap->sortBy('date');
        $pdf = PDF::loadView(
            'ct.Reports.omp0041.pdf.index',
            compact('result', 'creditGroup')
        )
            ->setPaper('a4')
            ->setOrientation('landscape')
            ->setOption('margin-bottom', 0)
            ->setOption('header-font-size', 9)
            ->setOption('header-spacing', -21, 300)
            ->setOption('header-right', '[page]                                           ');
        return $pdf->stream($programcode . '.pdf');
    }
}
