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

use App\Models\OM\ProductType;

class OMP0041Controller extends Controller
{


    public function OMP0041($programcode, Request $request)
    {
        // dd($request->all());
        $customerNumberFrom = $request->customer_number_from;
        $customerNumberTo = $request->customer_number_to;
        $creditGroupCode = $request->credit_group_id;
        $dateFrom = Carbon::createFromFormat('d/m/Y', $request->date_from)->format('Y-m-d');
        $dateTo = Carbon::createFromFormat('d/m/Y', $request->date_to)->format('Y-m-d');
        $productTypeCode = $request->product_type;
        $productType     = '';

        if ($productTypeCode) {
            $checkProductType = ProductType::where('lookup_code', $productTypeCode)->first();
            $productType = $checkProductType ? $checkProductType->meaning : '';
        }

        // Case 1
        $debtDomV = DebtDomV::query()
            ->where('credit_group_code', 0)
            ->whereRaw("TRUNC(pick_release_approve_date) BETWEEN to_date('{$dateFrom}', 'yyyy-mm-dd') AND to_date('{$dateTo}', 'yyyy-mm-dd')")
            // ->whereRaw("TRUNC(pick_release_approve_date) < to_date('{$dateFrom}', 'yyyy-mm-dd')")
            ->when(!empty($customerNumberFrom) && !empty($customerNumberTo), function ($q) use ($customerNumberFrom, $customerNumberTo) {
                $q->whereRaw("customer_number BETWEEN '{$customerNumberFrom}' AND '{$customerNumberTo}'");
            })
            ->when($productTypeCode, function ($q) use ($productTypeCode) {
                $q->where('product_type_code', $productTypeCode);
            })
            // ->where('customer_type_id', '<>', '40')
            ->get();
        $paymentDomV = PaymentDomV::query()
            ->select(
                'ptom_payment_dom_v.*',
                'ptom_debt_dom_v.product_type_code'
            )
            // ->where('ptom_payment_dom_v.customer_type', '<>', '40')
            ->where('ptom_payment_dom_v.credit_group_code', 0)
            ->whereRaw("TRUNC(ptom_payment_dom_v.payment_date) BETWEEN to_date('{$dateFrom}', 'yyyy-mm-dd') AND to_date('{$dateTo}', 'yyyy-mm-dd')")
            // ->whereRaw("TRUNC(ptom_payment_dom_v.payment_date) < to_date('{$dateFrom}', 'yyyy-mm-dd')")
            ->when(!empty($customerNumberFrom) && !empty($customerNumberTo), function ($q) use ($customerNumberFrom, $customerNumberTo) {
                $q->whereRaw("ptom_payment_dom_v.customer_number BETWEEN '{$customerNumberFrom}' AND '{$customerNumberTo}'");
            })
            
            ->when(!empty(request()->product_type), function($q) {
                return $q->where('ptom_debt_dom_v.product_type_code', request()->product_type);
            })
            ->leftjoin('ptom_debt_dom_v', function ($q) use ($creditGroupCode) {
                $q->on('ptom_debt_dom_v.prepare_order_number', '=', 'ptom_payment_dom_v.prepare_order_number');
                $q->where('ptom_debt_dom_v.credit_group_code', '=', 0);
            })
            ->get();
        // dd($paymentDomV->toArray());
        $debtDomVmap = [];
        foreach ($debtDomV as $item) {

            if ($item->customer_type_id == '30' && $item->product_type_code == '10') {
                $debtDomVmap[] = [
                    'date'                  => parseToDateTh(Carbon::parse($item->consignment_date)->format('Y-m-d')),
                    'desc'                  => $item->consignment_no,
                    'customer_number'       => $item->customer_number,
                    'customer_name'         => $item->customer_name,
                    'due_date'              => parseToDateTh(Carbon::parse($item->due_date)->format('Y-m-d')),
                    'debt_amount'           => $item->debt_amount,
                    'prepare_order_number'  => $item->prepare_order_number,
                    'credit_group_code'     => $item->credit_group_code,
                    'payment_amount'        => '0',
                    'case'                  => '1.2',
                    'type'                  => '1'
                ];
            } else {
                if (($item->customer_type_id == '30' || $item->customer_type_id == '40') && $item->product_type_code == '10') {
                    continue;
                }
                
                $debtDomVmap[] = [
                    'date'                  => parseToDateTh(Carbon::parse($item->pick_release_approve_date)->format('Y-m-d')),
                    'desc'                  => $item->pick_release_no,
                    'customer_number'       => $item->customer_number,
                    'customer_name'         => $item->customer_name,
                    'due_date'              => parseToDateTh(Carbon::parse($item->due_date)->format('Y-m-d')),
                    'desc'                  => $item->pick_release_no,
                    'prepare_order_number'  => $item->prepare_order_number,
                    'debt_amount'           => $item->debt_amount,
                    'credit_group_code'     => $item->credit_group_code,
                    'payment_amount'        => '0',
                    'case'                  => '1.1',
                    'type'                  => '1'
                ];
            }
        };
        foreach ($paymentDomV as $i) {
            if ($i->customer_type == '30' && $i->product_type_code == '10') {
                $debtDomVmap[] = [
                    'date'                  => parseToDateTh(Carbon::parse($item->payment_date)->format('Y-m-d')),
                    'desc'                  => $i->payment_number,
                    'customer_number'       => $i->customer_number,
                    'customer_name'         => $i->customer_name,
                    'due_date'              => parseToDateTh(Carbon::parse($item->payment_date)->format('Y-m-d')),
                    'debt_amount'           => '0',
                    'prepare_order_number'  => $i->prepare_order_number,
                    'payment_amount'        => $i->payment_amount,
                    'credit_group_code'     => $i->credit_group_code,
                    'case'                  => '2.2',
                    'type'                  => '2'
                ];
            } else {
                if (($i->customer_type == '30' || $i->customer_type == '40') && $i->product_type_code == '10') {
                    continue;
                }
                $debtDomVmap[] = [
                    'date'                  => parseToDateTh(Carbon::parse($i->payment_date)->format('Y-m-d')),
                    'desc'                  => $i->payment_number,
                    'customer_number'       => $i->customer_number,
                    'customer_name'         => $i->customer_name,
                    'due_date'              => parseToDateTh(Carbon::parse($i->payment_date)->format('Y-m-d')),
                    'debt_amount'           => '0',
                    'prepare_order_number'  => $i->prepare_order_number,
                    'payment_amount'        => $i->payment_amount,
                    'credit_group_code'     => $i->credit_group_code,
                    'case'                  => '2.1',
                    'type'                  => '2'
                ];
            }
        }

        $debtDomVmap = collect($debtDomVmap)->filter(function ($item) {
            if (!empty($item)) return true;
        });

        $creditGroup = CreditGroupModel::where('lookup_code', $creditGroupCode)->first();
        $result = $debtDomVmap->sortBy('date');
        #############
        $forwardPaymentValue = [];
        $forwarddeptVal = [];
        $forwarddebtDomV = DebtDomV::query()
                            ->select('product_type_code', 'customer_type_id', 'debt_amount', 'customer_number')
                            ->where('credit_group_code', 0)
                            ->where('product_type_code', 20)
                            ->whereRaw("TRUNC(pick_release_approve_date) < to_date('{$dateFrom}', 'yyyy-mm-dd')")
                            ->when(!empty($customerNumberFrom) && !empty($customerNumberTo), function ($q) use ($customerNumberFrom, $customerNumberTo) {
                                $q->whereRaw("customer_number BETWEEN '{$customerNumberFrom}' AND '{$customerNumberTo}'");
                            })
                            ->get()
                            ->groupBy('customer_number');
        foreach($forwarddebtDomV as $group => $data) {
            $forwarddeptVal[$group] = 0;
            foreach ($data as $item) {
                if ($item->customer_type_id == '30' && $item->product_type_code == '10') {
                    $forwarddeptVal[$group] += $item->debt_amount;
                } else {
                    if (($item->customer_type_id == '30' || $item->customer_type_id == '40') && $item->product_type_code == '10') {
                        continue;
                    }
                    $forwarddeptVal[$group] += $item->debt_amount;
                }
            };
        }

        $forwardpaymentDomV = PaymentDomV::query()
                            ->select(
                                'ptom_payment_dom_v.*',
                                'ptom_debt_dom_v.product_type_code'
                            )
                            ->where('product_type_code', 20)
                            ->where('ptom_payment_dom_v.credit_group_code', 0)
                            ->whereRaw("TRUNC(ptom_payment_dom_v.payment_date) < to_date('{$dateFrom}', 'yyyy-mm-dd')")
                            ->when(!empty($customerNumberFrom) && !empty($customerNumberTo), function ($q) use ($customerNumberFrom, $customerNumberTo) {
                                $q->whereRaw("ptom_payment_dom_v.customer_number BETWEEN '{$customerNumberFrom}' AND '{$customerNumberTo}'");
                            })
                            ->leftjoin('ptom_debt_dom_v', function ($q) use ($creditGroupCode) {
                                $q->on('ptom_debt_dom_v.prepare_order_number', '=', 'ptom_payment_dom_v.prepare_order_number');
                                $q->where('ptom_debt_dom_v.credit_group_code', '=', 0);
                            })
                            ->get()
                            ->groupBy('customer_number');

        foreach($forwardpaymentDomV as $num => $data) {
            $forwardPaymentValue[$num] = 0;
            foreach ($data as $i) {
                if ($i->customer_type == '30' && $i->product_type_code == '10') {
                    $forwardPaymentValue[$num] += $i->payment_amount;
                } else {
                    if (($i->customer_type == '30' || $i->customer_type == '40') && $i->product_type_code == '10') {
                        continue;
                    }
                    $forwardPaymentValue[$num] += $i->payment_amount;
                }
            }
        }
        // dump($forwardPaymentValue,$forwarddeptVal);
        #######################
        $pdf = PDF::loadView(
            'ct.Reports.omp0041.pdf.index',
            compact('result', 'creditGroup','forwardPaymentValue', 'forwarddeptVal', 'productType')
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
