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

class OMP0040Controller extends Controller
{


    public function OMP0040($programcode, Request $request)
    {
        $customerNumberFrom = $request->customer_number_from;
        $customerNumberTo = $request->customer_number_to;
        $creditGroupCode = $request->credit_group_id;
        $dateFrom = Carbon::createFromFormat('d/m/Y', $request->date_from)->format('Y-m-d');
        $dateTo = Carbon::createFromFormat('d/m/Y', $request->date_to)->format('Y-m-d');
        // Case 1
        $debtDomV = DebtDomV::query()
            ->where('credit_group_code', $creditGroupCode)
            ->whereRaw("TRUNC(pick_release_approve_date) BETWEEN to_date('{$dateFrom}', 'yyyy-mm-dd') AND to_date('{$dateTo}', 'yyyy-mm-dd')")
            ->when(!empty($customerNumberFrom) && !empty($customerNumberTo), function ($q) use ($customerNumberFrom, $customerNumberTo) {
                $q->whereRaw("customer_number BETWEEN '{$customerNumberFrom}' AND '{$customerNumberTo}'");
            })
            ->get();
        $paymentDomV = PaymentDomV::query()
            ->select(
                'ptom_payment_dom_v.*',
                'ptom_debt_dom_v.product_type_code'
            )
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
        $debtDomVmap = [];
        foreach ($debtDomV as $item) {
            if ($item->customer_type_id == '30' && $item->product_type_code == '10') {
                $debtDomVmap[] = [
                    'date' => $item->consignment_date,
                    'desc' => $item->consignment_no,
                    'customer_number' => $item->customer_number,
                    'customer_name' => $item->customer_name,
                    'due_date' => $item->due_date,
                    'debt_amount' => $item->debt_amount,
                    'prepare_order_number' => $item->prepare_order_number,
                    'credit_group_code' => $item->credit_group_code,
                    'payment_amount' => '',
                    'case' => '1.2',
                    'type' => '1'
                ];
            } else {
                if (($item->customer_type_id == '30' || $item->customer_type_id == '40') && $item->product_type_code == '10') {
                    continue;
                }
                $debtDomVmap[] = [
                    'date' => $item->pick_release_approve_date,
                    'desc' => $item->pick_release_no,
                    'customer_number' => $item->customer_number,
                    'customer_name' => $item->customer_name,
                    'due_date' => $item->due_date,
                    'prepare_order_number' => $item->prepare_order_number,
                    'credit_group_code' => $item->credit_group_code,
                    'debt_amount' => $item->debt_amount,
                    'payment_amount' => '',
                    'case' => '1.1',
                    'type' => '1'
                ];
            }
        };
        foreach ($paymentDomV as $i) {
            if ($i->customer_type == '30' && $i->product_type_code == '10') {
                $debtDomVmap[] = [
                    'date' => $i->payment_date,
                    'desc' => $i->payment_number,
                    'customer_number' => $i->customer_number,
                    'customer_name' => $i->customer_name,
                    'due_date' => $i->payment_date,
                    'debt_amount' => '',
                    'prepare_order_number' => $i->prepare_order_number,
                    'payment_amount' => $i->payment_amount,
                    'credit_group_code' => $i->credit_group_code,
                    'case' => '2.2',
                    'type' => '2'
                ];
            } else {
                if (($i->customer_type == '30' || $i->customer_type == '40') && $i->product_type_code == '10') {
                    continue;
                }

                $debtDomVmap[] = [
                    'date' => $i->payment_date,
                    'desc' => $i->payment_number,
                    'customer_number' => $i->customer_number,
                    'customer_name' => $i->customer_name,
                    'due_date' => $i->payment_date,
                    'debt_amount' => '',
                    'prepare_order_number' => $i->prepare_order_number,
                    'payment_amount' => $i->payment_amount,
                    'credit_group_code' => $i->credit_group_code,
                    'case' => '2.1',
                    'type' => '2'
                ];
            }
        }

        $debtDomVmap = collect($debtDomVmap)->filter(function ($item) {
            if (!empty($item)) return true;
        });

        $creditGroup = CreditGroupModel::where('lookup_code', $creditGroupCode)->first();
        $result = $debtDomVmap->sortBy('date')
        // ->where('customer_number','D00199')
        ->groupby('customer_number');
        $result = $result->map(function($items, $customer_number) use($dateFrom, $creditGroupCode) {
            $depDomV = DebtDomV::where('customer_number', $customer_number)->where('credit_group_code', $creditGroupCode)->whereRaw("TRUNC(pick_release_approve_date) < to_date('{$dateFrom}', 'yyyy-mm-dd')")
            // ->toSql();
            ->sum('debt_amount');
            $paymentDomV = PaymentDomV::where('ptom_payment_dom_v.credit_group_code', $creditGroupCode)
            ->whereRaw("TRUNC(ptom_payment_dom_v.payment_date) < to_date('{$dateFrom}', 'yyyy-mm-dd')")
            ->where("ptom_payment_dom_v.customer_number", $customer_number)
            ->join('ptom_debt_dom_v', function ($q) use ($creditGroupCode) {
                $q->on('ptom_debt_dom_v.prepare_order_number', '=', 'ptom_payment_dom_v.prepare_order_number');
                $q->where('ptom_debt_dom_v.credit_group_code', '=', $creditGroupCode);
            })
            ->sum('payment_amount');
            // dd($depDomV, $paymentDomV);
            $items = $items->map(function($i) use($depDomV, $paymentDomV) {
                $i['depDomV'] = $depDomV - $paymentDomV;
                return $i;
            });
            return $items;
        });
        $pdf = PDF::loadView(
            'ct.Reports.omp0040.pdf.index',
            compact('result', 'creditGroup')
        )
            ->setPaper('a4')
            ->setOrientation('landscape')
            ->setOption('margin-bottom', 0)
            ->setOption('header-font-size', 9)
            ->setOption('header-spacing', -21, 300)
            ->setOption('header-right', '[page]               ');
        // return view(
        //     'ct.reports.omp0040.pdf.index',
        //     compact('result', 'creditGroup')
        // );
        return $pdf->stream($programcode . '.pdf');
    }
}
