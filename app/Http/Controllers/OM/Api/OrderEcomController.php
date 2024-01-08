<?php

namespace App\Http\Controllers\OM\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\Api\OrderHeader;
use App\Models\OM\OrderHeaders;
use App\Models\OM\Api\OrderLines;
use App\Models\OM\Api\OrderStatusHistory;
use App\Models\OM\Api\Customer;
use App\Models\OM\Api\OrderDirectDebit;
use App\Models\OM\PeriodV;
use App\Models\OM\PostponeOrders;
use App\Repositories\OM\OrderRepo;
use App\Repositories\OM\GenerateNumberRepo;
use App\Repositories\OM\CreditAndQuotaRepo;
use App\Models\OM\Api\DirectDebit;
use App\Models\OM\Api\OrderCreditGroup;
use App\Models\OM\Api\OrderQuotaHistory;
use App\Models\OM\Api\GrantSpecialCase;
use App\Models\OM\Api\GrantSpecialCaseV;
use App\Models\OM\Api\CartonQuantityV;
use App\Models\OM\PnHolidayModel;
use App\Models\OM\Customers\Domestics\CustomerContractGroups;
use App\Models\OM\OutstandingDebtDomesticV;
use App\Models\OM\ReleaseCredit;
use App\Models\OM\AdditionQuota;
use App\Models\OM\AdditionQuotaLines;
use App\Models\OM\CustomerContractGroup;
use App\Models\OM\Customers\Domestics\CustomerQuotaLines;
use App\Models\OM\DebtDomV;
use App\Models\OM\FormOrderHeader;
use App\Models\OM\FormOrderLine;
use App\Models\OM\PenaltyRateDomesticV;
use App\Models\om\ptOmDebtDomV;
use App\Models\OM\SaleConfirmation\OrderHistory;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

class OrderEcomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function convertCGK()
    {
        $convertCGK = OrderRepo::convertCGK(15);
    }

    public function customerDomestic()
    {
        $customerDomestic = DB::table('ptom_customers')
        ->whereRaw("lower(sales_classification_code) = 'domestic' ")
        ->whereRaw("lower(status) = 'active' ")
        ->where('deleted_at',NULL)
        ->orderBy('customer_number')
        ->get(['customer_id','customer_number','customer_name','province_name']);
        return response()->json(['data' => $customerDomestic]);
    }

    public function remainingAmountCallback($customer_id, $date, $period_id) {
        $cusContractGroup = CustomerContractGroup::where('customer_id', $customer_id)->get();
        $period = PeriodV::where('period_line_id',$period_id)->first();
        $ptOmDebtDomV = DB::table('ptom_debt_dom_v')
        ->where('customer_id', $customer_id)
        ->whereNotNull('pick_release_no')
        ->get();
        
        $orderHeaders= OrderHeaders::where('ORDER_STATUS', '<>','Cancel')
                                    ->select('credit_group_code', 'prepare_order_number', 'amount', 'delivery_date')
                                    ->join('ptom_order_credit_groups',function($q) {
                                        $q->on('ptom_order_credit_groups.order_header_id','ptom_order_headers.order_header_id');
                                        $q->where('ptom_order_credit_groups.order_line_id','0');
                                    })
                                    ->where('ptom_order_headers.CREDIT_AMOUNT', ">", 0)
                                    ->whereNull('ptom_order_headers.PICK_RELEASE_NO')
                                    ->where('ptom_order_headers.order_status', 'Confirm')
                                    ->where('ptom_order_headers.customer_id', $customer_id)
                                    ->get();

        $debtDomV = DebtDomV::query()
                    ->where('customer_id', $customer_id)
                    ->whereRaw("TRUNC(due_date) <= TO_DATE('" . Carbon::createFromFormat('Y-m-d H:i:s',$period->end_period)->format("Y-m-d") . "', 'YYYY-MM-DD')")
                    ->where('outstanding_debt', ">", 0) 
                    ->where('CREDIT_GROUP_CODE', "<>", 0) 
                    ->get();

        return ['cusContractGroup'=>$cusContractGroup, 'ptOmDebtDomV'=> $ptOmDebtDomV, 'orderHeaders' => $orderHeaders, 'debtDomV' => $debtDomV];
    }

    public function reCalculateRemainingAmountV2($customer_id, $date, $period_id, $pick_release_no = []) {
        $cusContractGroup = CustomerContractGroup::where('customer_id', $customer_id)->get();
        $period = PeriodV::where('period_line_id',$period_id)->first();
        $ptOmDebtDomV = DB::table('ptom_debt_dom_v')
        ->where('customer_id', $customer_id)
        ->whereNotNull('pick_release_no')
        ->get();
        
        $orderHeaders = OrderHeaders::where('ORDER_STATUS', '<>','Cancel')
                        ->select('credit_group_code', 'prepare_order_number', 'amount', 'delivery_date')
                        ->join('ptom_order_credit_groups',function($q) {
                            $q->on('ptom_order_credit_groups.order_header_id','ptom_order_headers.order_header_id');
                            $q->where('ptom_order_credit_groups.order_line_id','0');
                        })
                        ->where('ptom_order_headers.CREDIT_AMOUNT', ">", 0)
                        ->whereNull('ptom_order_headers.PICK_RELEASE_NO')
                        ->where('ptom_order_headers.order_status', 'Confirm')
                        ->where('ptom_order_headers.customer_id', $customer_id)
                        ->get();
        $debtDomV = DebtDomV::query()
                    ->where('customer_id', $customer_id)
                    ->where('outstanding_debt', ">", 0) 
                    ->whereNotNull('pick_release_no')
                    ->where('CREDIT_GROUP_CODE', "<>", 0) 
                    ->whereIn('pick_release_no', $pick_release_no)
                    ->get();

        return ['cusContractGroup'=>$cusContractGroup, 'ptOmDebtDomV'=> $ptOmDebtDomV, 'orderHeaders' => $orderHeaders, 'debtDomV' => $debtDomV];
    }

    public function reCalculateRemainingAmountOrder($prepare_order_number) {
        $orderHeader = OrderHeaders::where('prepare_order_number', $prepare_order_number)->first();
        $cusContractGroup = CustomerContractGroup::select('credit_group_code','credit_amount')->where('customer_id', $orderHeader->customer_id)->get();
        $period = PeriodV::where('period_line_id',$orderHeader->period_id)->first();
        $releaseCredit = ReleaseCredit::where('attribute1', $orderHeader->order_header_id)->get()->pluck('invoice_num')->toArray();
        
        $ptOmDebtDomV = DB::table('ptom_debt_dom_v')
                        ->select('outstanding_debt', 'credit_group_code')
                        ->where('outstanding_debt', '>' , 0)
                        ->where('customer_id', $orderHeader->customer_id)
                        ->whereNotNull('pick_release_no')
                        ->get();
        
        $orderHeadersTarget = OrderHeaders::where('ORDER_STATUS', '<>','Cancel')
                        ->select('credit_group_code', 'prepare_order_number', 'amount', 'delivery_date')
                        ->join('ptom_order_credit_groups',function($q) {
                            $q->on('ptom_order_credit_groups.order_header_id','ptom_order_headers.order_header_id');
                            $q->where('ptom_order_credit_groups.order_line_id','0');
                        })
                        ->where('ptom_order_headers.prepare_order_number', $prepare_order_number)
                        ->where('ptom_order_headers.CREDIT_AMOUNT', ">", 0)
                        ->whereNull('ptom_order_headers.PICK_RELEASE_NO')
                        ->where('ptom_order_headers.order_status', 'Confirm')
                        ->where('ptom_order_headers.customer_id', $orderHeader->customer_id)
                        ->get();
        $orderHeaders = OrderHeaders::where('ORDER_STATUS', '<>','Cancel')
                        ->select('credit_group_code', 'prepare_order_number', 'amount', 'delivery_date')
                        ->join('ptom_order_credit_groups',function($q) {
                            $q->on('ptom_order_credit_groups.order_header_id','ptom_order_headers.order_header_id');
                            $q->where('ptom_order_credit_groups.order_line_id','0');
                        })
                        ->where('ptom_order_headers.prepare_order_number',"<", $prepare_order_number)
                        ->where('ptom_order_headers.CREDIT_AMOUNT', ">", 0)
                        ->whereNull('ptom_order_headers.PICK_RELEASE_NO')
                        ->where('ptom_order_headers.order_status', 'Confirm')
                        ->where('ptom_order_headers.customer_id', $orderHeader->customer_id)
                        ->get();
        $debtDomV = DebtDomV::query()
                    ->where('customer_id', $orderHeader->customer_id)
                    ->whereRaw("TRUNC(due_date) <= TO_DATE('" . Carbon::createFromFormat('Y-m-d H:i:s', $orderHeader->delivery_date)->format("Y-m-d") . "', 'YYYY-MM-DD')")
                    ->where('outstanding_debt', ">", 0) 
                    ->whereNotNull('pick_release_no')
                    ->where('CREDIT_GROUP_CODE', "<>", 0) 
                    ->get();
        DB::transaction(function () use($cusContractGroup, $ptOmDebtDomV, $orderHeaders, $orderHeadersTarget, $debtDomV,  $orderHeader) {
            foreach($cusContractGroup as $item) {
                $base = $item->credit_amount;
                $invoiceSum = $ptOmDebtDomV->where('credit_group_code', $item->credit_group_code)->sum('outstanding_debt');
                $soConfirmSum = $orderHeaders->where('credit_group_code', $item->credit_group_code)->sum('amount');
                $soConfirmTargetSum = $orderHeadersTarget->where('credit_group_code', $item->credit_group_code)->sum('amount');
                $debtDomSum = $debtDomV->where('credit_group_code', $item->credit_group_code)->sum('outstanding_debt');
                $recal = $base -$invoiceSum - $soConfirmSum + $debtDomSum;
                
                // Update OrderCreditGroup
                $credit_reaining = $recal;
                $remaining_amount = $recal - $soConfirmTargetSum;
                OrderCreditGroup::where('credit_group_code', $item->credit_group_code)->where('order_header_id', $orderHeader->order_header_id)->update(['remaining_amount' => $remaining_amount]);
    
                DB::table('oaom.ptom_order_remaining')->where('order_header_id',  $orderHeader->order_header_id)->update(['group'.$item->credit_group_code.'_amount' => $credit_reaining, 'group3_remaining' => $remaining_amount]);
            }
        });
        return back();
    }
    public function reCalculateRemainingAmountVal($customer_id) {
        $cusContractGroup = CustomerContractGroup::where('customer_id', $customer_id)->get();
        $ptOmDebtDomV = DB::table('ptom_debt_dom_v')
        ->whereNotNull('pick_release_no')
        ->where('customer_id', $customer_id)
        ->get();

        // ลบ 2
        // AMOUNT 
        $orderHeaders= OrderHeaders::where('ORDER_STATUS', '<>','Cancel')
        ->select('credit_group_code', 'amount', 'delivery_date', 'prepare_order_number')
        ->join('ptom_order_credit_groups',function($q) {
            $q->on('ptom_order_credit_groups.order_header_id','ptom_order_headers.order_header_id');
            $q->where('ptom_order_credit_groups.order_line_id','0');
        })
        ->where('ptom_order_headers.CREDIT_AMOUNT', ">", 0)
        ->whereNull('ptom_order_headers.PICK_RELEASE_NO')
        ->where('ptom_order_headers.order_status', 'Confirm')
        ->where('ptom_order_headers.customer_id', $customer_id)
        ->get();

        // บวก 3
        // OUTSTANDING_DEBT 
        $debtDomV = DebtDomV::query()
                    ->where('customer_id', $customer_id)
                    ->whereRaw("TRUNC(due_date) <= TO_DATE('" .now()->format('Y-m-d'). "', 'YYYY-MM-DD')")
                    // ->whereRaw("TRUNC(due_date) <= TO_DATE('" . request()->date . "', 'DD/MM/YYYY')")
                    ->where('outstanding_debt', ">", 0) 
                    ->whereNotNull('pick_release_no')
                    ->where('CREDIT_GROUP_CODE', "<>", 0) 
                    ->get();

        $result = [];
        foreach($cusContractGroup as $g) {
            $base =  $g->credit_amount * ($g->credit_percentage / 100);
            
            $process1 = $ptOmDebtDomV->where('credit_group_code', $g->credit_group_code);

            $process2 = $orderHeaders->where('credit_group_code', $g->credit_group_code);
            
            $process3 = $debtDomV->where('credit_group_code', $g->credit_group_code);
            
            $result[$g->credit_group_code] = $base - $process1->sum('outstanding_debt') - $process2->sum('amount')  - $process2->sum('credit_amount') + $process3->sum('outstanding_debt');
        }
        return $result;
    }

    public function reCalculateRemainingAmount($customer_id) {
        $cusContractGroup = CustomerContractGroup::where('customer_id', $customer_id)->get();
        $ptOmDebtDomV = DB::table('ptom_debt_dom_v')
        ->whereNotNull('pick_release_no')
        ->where('customer_id', $customer_id)
        ->get();

        // ลบ 2
        // AMOUNT 
        $orderHeaders= OrderHeaders::where('ORDER_STATUS', '<>','Cancel')
        ->select('credit_group_code', 'amount', 'delivery_date', 'prepare_order_number')
        ->join('ptom_order_credit_groups',function($q) {
            $q->on('ptom_order_credit_groups.order_header_id','ptom_order_headers.order_header_id');
            $q->where('ptom_order_credit_groups.order_line_id','0');
        })
        ->where('ptom_order_headers.CREDIT_AMOUNT', ">", 0)
        ->whereNull('ptom_order_headers.PICK_RELEASE_NO')
        ->where('ptom_order_headers.order_status', 'Confirm')
        ->where('ptom_order_headers.customer_id', $customer_id)
        ->get();

        // บวก 3
        // OUTSTANDING_DEBT 
        $debtDomV = DebtDomV::query()
                    ->where('customer_id', $customer_id)
                    ->whereRaw("TRUNC(due_date) <= TO_DATE('" .Carbon::createFromFormat('d/m/Y', request()->date)->format('Y-m-d'). "', 'YYYY-MM-DD')")
                    // ->whereRaw("TRUNC(due_date) <= TO_DATE('" . request()->date . "', 'DD/MM/YYYY')")
                    ->where('outstanding_debt', ">", 0) 
                    ->whereNotNull('pick_release_no')
                    ->where('CREDIT_GROUP_CODE', "<>", 0) 
                    ->get();


        foreach($cusContractGroup as $g) {
            // dump($g);
            $base =  $g->credit_amount * ($g->credit_percentage / 100);
            echo "<table style='width:90%;'>";
            echo "  <tr style='background-color: #ccc;'>";
            echo "      <td>กลุ่มวงเงินเชื่อ</td>";
            echo "      <td>{$g->credit_group_code}</td>";
            echo "      <td></td>";
            echo "      <td></td>";
            echo "      <td></td>";
            echo "      <td>วงเงิน</td>";
            echo "      <td align='right'>". number_format($base, 2) ."</td>";
            echo "  </tr>";
            
            echo "  <tr >";
            echo "      <td>2</td>";
            echo "      <td>INV Outstanding</td>";
            echo "      <td></td>";
            echo "      <td></td>";
            echo "      <td>INV Date</td>";
            echo "      <td>Due Date</td>";
            echo "      <td>Amount</td>";
            echo "  </tr>";
            $process1 = $ptOmDebtDomV->where('credit_group_code', $g->credit_group_code);

            foreach($process1 as $item) {
                if($item->outstanding_debt == 0 ) continue;
                echo "  <tr>";
                echo "      <td></td>";
                echo "      <td>". ($item->pick_release_no) ."</td>";
                echo "      <td></td>";
                echo "      <td></td>";
                echo "      <td>". (!empty($item->pick_release_approve_date) ? Carbon::createFromFormat('Y-m-d H:i:s',$item->pick_release_approve_date)->format('d/m/Y') : '') ."</td>";
                echo "      <td>". (!empty($item->due_date) ? Carbon::createFromFormat('Y-m-d H:i:s',$item->due_date)->format('d/m/Y') : '') ."</td>";
                echo "      <td align='right'>".number_format($item->outstanding_debt, 2)."</td>";
                echo "  </tr>";
            }
            echo "  <tr style='font-weight:bold'>";
            echo "      <td></td>";
            echo "      <td></td>";
            echo "      <td></td>";
            echo "      <td></td>";
            echo "      <td></td>";
            echo "      <td></td>";
            echo "      <td align='right'>". number_format($process1->sum('outstanding_debt'), 2) ."</td>";
            echo "  </tr>";

            echo "  <tr >";
            echo "      <td>3</td>";
            echo "      <td>SO Confirm</td>";
            echo "      <td></td>";
            echo "      <td></td>";
            echo "      <td></td>";
            echo "      <td></td>";
            echo "      <td></td>";
            echo "  </tr>";


            $process2 = $orderHeaders->where('credit_group_code', $g->credit_group_code);
            foreach($process2 as $item) {
                
                echo "  <tr>";
                echo "      <td></td>";
                echo "      <td>". ($item->prepare_order_number)."</td>";
                echo "      <td></td>";
                echo "      <td></td>";
                echo "      <td>". (!empty($item->delivery_date) ? Carbon::createFromFormat('Y-m-d H:i:s',$item->delivery_date)->format('d/m/Y') : '') ."</td>";
                echo "      <td>". (!empty($item->due_date) ? Carbon::createFromFormat('Y-m-d H:i:s',$item->due_date)->format('d/m/Y') : '') ."</td>";
                echo "      <td align='right'>". number_format($item->amount, 2) ."</td>";
                echo "  </tr>";
            }
            echo "  <tr style='font-weight:bold'>";
            echo "      <td></td>";
            echo "      <td></td>";
            echo "      <td></td>";
            echo "      <td></td>";
            echo "      <td></td>";
            echo "      <td></td>";
            echo "      <td align='right'>". number_format($process2->sum('amount'), 2) ."</td>";
            echo "  </tr>";

            echo "  <tr >";
            echo "      <td>4</td>";
            echo "      <td>Inv ถึง Due</td>";
            echo "      <td></td>";
            echo "      <td></td>";
            echo "      <td></td>";
            echo "      <td></td>";
            echo "      <td></td>";
            echo "  </tr>";
            $process3 = $debtDomV->where('credit_group_code', $g->credit_group_code);
            
            foreach($process3 as $item) {
                echo "  <tr>";
                echo "      <td></td>";
                echo "      <td>". ($item->pick_release_no)."</td>";
                echo "      <td></td>";
                echo "      <td></td>";
                echo "      <td>". (!empty($item->pick_release_approve_date) ? Carbon::createFromFormat('Y-m-d H:i:s',$item->pick_release_approve_date)->format('d/m/Y') : '') ."</td>";
                echo "      <td>". (!empty($item->due_date) ? Carbon::createFromFormat('Y-m-d H:i:s',$item->due_date)->format('d/m/Y') : '') ."</td>";
                echo "      <td align='right'>". number_format($item->outstanding_debt, 2)."</td>";
                echo "  </tr>";
            }
            echo "  <tr style='font-weight:bold'>";
            echo "      <td></td>";
            echo "      <td></td>";
            echo "      <td></td>";
            echo "      <td></td>";
            echo "      <td></td>";
            echo "      <td></td>";
            echo "      <td align='right'>". number_format($process3->sum('outstanding_debt'), 2) ."</td>";
            echo "  </tr>";

            echo "  <tr style='font-weight:bold'>";
            echo "      <td></td>";
            echo "      <td></td>";
            echo "      <td></td>";
            echo "      <td></td>";
            echo "      <td></td>";
            echo "      <td>Remaining Amount</td>";
            echo "      <td align='right'>". number_format($base - $process1->sum('outstanding_debt') - $process2->sum('amount')  - $process2->sum('credit_amount') + $process3->sum('outstanding_debt'), 2) ."</td>";
            echo "  </tr>";
            echo "</table>";
            echo "<hr>";


            // $deptOutS = $ptOmDebtDomV->where('credit_group_code', $g->credit_group_code)
            // ->sum('outstanding_debt')
            // ;
            // dump($deptOutS);
            // $orderHeader = $orderHeaders->where('credit_group_code', $g->credit_group_code)
            // ->sum('amount')
            // ;
            // dump($orderHeader);
            // dump('orderHeaders = '.$orderHeaders->where('credit_group_code', $g->credit_group_code)->sum('amount'));
            // $base = $g->credit_amount * ($g->credit_percentage / 100);
            // dump('base = '. $base);
            // $process1 = $base - @$deptOutS;
            // dump('sum_outstanding_debt = '.  @$deptOutS);

            // $process2= $process1 - $orderHeader;
            // dump('process2 = '. $process2);

            // dump('orderHeader = '.  @$orderHeader);
            // $g->remaining_amount = $process2;
            // dump($g, $process1, $process2);
            
        }
        
    }

    public function customerSelectedPaymentType($customer_id)
    {
        $customerSelectedPaymentType = DB::table('ptom_customers')
        ->where('customer_id',$customer_id)
        ->first(['payment_type_id']);

        $paymentType = DB::table('ptom_payment_type')->where('lookup_code',$customerSelectedPaymentType->payment_type_id)->first(['lookup_code','meaning','description']);
        $data = [
            'payment_type_id'=>$customerSelectedPaymentType->payment_type_id,
            'paymentType'=>$paymentType
        ];

        return response()->json(['data' => $data]);
    }

    public function productTypeDomestic()
    {
        $productTypeDomestic = DB::table('ptom_product_type_domestic')->get(['lookup_code','meaning','description']);
        return response()->json(['data' => $productTypeDomestic]);
    }

    public function paymentType()
    {
        $paymentType = DB::table('ptom_payment_type')->get(['lookup_code','meaning','description']);
        return response()->json(['data' => $paymentType]);
    }

    public function paymentMethodDomestic()
    {
        $paymentMethodDomestic = DB::table('ptom_payment_method_domestic')->get(['lookup_code','meaning','description','tag']);

        return response()->json(['data' => $paymentMethodDomestic]);
    }

    public function paymentMethodDomesticById($id)
    {
        $paymentMethodDomestic = DB::table('ptom_payment_method_domestic')->where('lookup_code',$id)->get(['lookup_code','meaning','description','tag']);

        return response()->json(['data' => $paymentMethodDomestic]);
    }

    // public function paymentMethodDomesticByCustomer($customer_id)
    // {
    //     $paymentMethodDomestic = DB::table('ptom_payment_method_domestic')->get(['lookup_code','meaning','description']);

    //     $directDebit = DB::table('ptce_bank_accounts_v as bav')
    //         ->join('ptom_direct_debit as dd','dd.bank_id','=','bav.bank_id')
    //         ->where('dd.customer_id',$customer_id)
    //         ->get(['bav.bank_name','bav.bank_account_name']);

    //     // $response = [];
    //     // foreach ($paymentMethodDomestic as $key => $item) {

    //     //     $directDebit = DB::table('ptom_direct_debit as dd')
    //     //     ->join('ptce_bank_accounts_v as bav', 'bav.bank_id', '=', 'dd.bank_id')
    //     //     ->where('dd.customer_id',$customer_id)
    //     //     ->get(['bav.bank_name','bav.bank_account_name']);

    //     //     if (isset($directDebit) && !empty($directDebit)) {
    //     //         $response[] = $directDebit;
    //     //     }

    //     // }

    //     return response()->json(['data' => $directDebit]);
    // }

    public function checkExpireBook($customer_id)
    {
        // $number = GenerateNumberRepo::docSequenceNumber('OMP0003_PO_NUM_CG_DOM','order_number');
        // var_dump($number);
        // exit();
        $response = [];
        $message = '';
        $contractBooks = OrderRepo::getCustomerContractBooks($customer_id);
        foreach ($contractBooks as $key => $v) {
            $date = Carbon::parse($v->book_end_date);

            $now = Carbon::now();
            $diff = $date->diffInDays($now);
            if ($diff >= 0) {
                $response[] = $v;
            }
            // else{
            //     $response[] = $v;
            // }
        }

        return response()->json(['data' => $response]);
    }

    public function paymentMethodExport()
    {
        $paymentMethodExport = DB::table('ptom_payment_method_export')->get(['lookup_code','meaning','description']);
        return response()->json(['data' => $paymentMethodExport]);
    }

    public function shipmentBy()
    {
        $shipmentBy = DB::table('ptom_shipment_by')->get(['lookup_code','meaning','description','tag']);
        return response()->json(['data' => $shipmentBy]);
    }

    public function shipmentByDomestic()
    {
        $shipmentBy = DB::table('ptom_shipment_by')->where('tag','D')->get(['lookup_code','meaning','description','tag']);
        return response()->json(['data' => $shipmentBy]);
    }

    public function directDebitByCustomer($customer_id,$bank_type)
    {
        $bank = DB::table('ptom_direct_debit')->where('customer_id',$customer_id)->where('short_bank_name',$bank_type)->get(['direct_debit_id','bank_account_name']);
        return response()->json(['data' => $bank]);
    }

    public function bankByCustomer($customer_id,$bank_type)
    {
        $bank = DB::table('ptom_direct_debit')
        ->where('customer_id',$customer_id)
        ->where('short_bank_name',$bank_type)
        ->where('start_date','<=',date('Y-m-d'))
        ->where(function($query){
            $query->whereNull('end_date');
            $query->orWhere('end_date','>=',date('Y-m-d'));
        })
        ->get(['direct_debit_id','bank_account_name']);
        return response()->json(['data' => $bank]);
    }

    public function bankById($number)
    {
        $bank = DB::table('ptce_bank_accounts_v')->where('bank_number',$number)->get(['bank_account_id','bank_account_name']);
        return response()->json(['data' => $bank]);
    }

    public function orderDataCustomer($customer_id)
    {
        $dateNow = now()->format('Y-m-d');
        $data['customer'] = Customer::where('customer_id',$customer_id)->first();
        $productTypeDomestic = DB::table('ptom_product_type_domestic')->get(['lookup_code','meaning','description']);
        $data['productTypeDomestic'] = [];
        foreach ($productTypeDomestic as $key => $v) {

            $priceList = DB::table('ptom_price_list_head_v as plh')
            ->join('ptom_price_list_line_v as pll', 'pll.list_header_id', '=', 'plh.list_header_id')
            ->join('ptom_sequence_ecoms as se', 'se.item_id', '=', 'pll.item_id')
            ->where('plh.list_header_id',$data['customer']->price_list_id)
            ->where('se.product_type_code',$v->lookup_code)
            ->first();

            if(!is_null($priceList)){
                $data['productTypeDomestic'][] = $v;
            }

        }

        $data['paymentType'] = DB::table('ptom_payment_type')->get(['lookup_code','meaning','description']);
        $data['paymentMethodDomestic'] = DB::table('ptom_payment_method_domestic')->get(['lookup_code','meaning','description','tag']);
        $data['shipmentBy'] = DB::table('ptom_shipment_by')->where('tag','D')->get(['lookup_code','meaning','description','tag']);
        $data['transportOwner'] = DB::table('ptom_transport_owners')->where('stop_flag', 'N')
        ->whereRaw("to_date('{$dateNow}', 'YYYY-MM-DD') BETWEEN start_date AND end_date")
        ->first();
        $data['installment'] = DB::table('ptom_period_v')->where('start_period','<=','2020-12-01')->where('end_period','>=','2020-12-10')->first();
        $data['new_period'] = DB::table('ptom_period_v')->where('budget_year','>=',(date('Y') - 1))->where('budget_year','<=',(date('Y') + 1))->get();
        $data['today'] = Carbon::today();

        $data['specialCase'] = null;
        $data['timeDelivery'] = null;
        $dateToday = date('Y-m-d', strtotime($data['today']));
        $fromHeaderOrder = FormOrderHeader::where('customer_id', $customer_id)
                                            ->where('approve_status', 'อนุมัติ')
                                            // ->where('to_period_date', date('Y-m-d'))
                                            ->whereRaw("trunc(to_period_date) >= to_date('{$dateToday}', 'YYYY-MM-DD')")
                                            ->where('form_type', 'SPECIAL')
                                            ->first();
        $GrantSpecialCase = GrantSpecialCaseV::where('grant_special_flag','Y')
                                            ->where('customer_id', $customer_id)
                                            ->whereRaw("trunc(allowed_order_date) >= to_date('{$dateToday}', 'YYYY-MM-DD')")
                                            ->first();
        $timeDelivery = GrantSpecialCaseV::selectRaw("to_char(allowed_order_date, 'YYYY-MM-DD') allowed_order_date")
                                            ->where('grant_special_flag','Y')
                                            ->where('customer_id', $customer_id)
                                            ->whereRaw("trunc(allowed_order_date) >= to_date('{$dateToday}', 'YYYY-MM-DD')")
                                            ->orderBy('grant_special_id', 'asc')
                                            ->get();
        $data['timeDelivery'] = $timeDelivery;
        if(!is_null($fromHeaderOrder) && !is_null($GrantSpecialCase)){
            $data['specialCase'] = $GrantSpecialCase;
        }
        if(!empty($data['specialCase'])) {
            $data['specialCase']->period_no = DB::table('ptom_period_v')->whereRaw("'{$data['specialCase']->allowed_order_date}' BETWEEN TRUNC(start_period) AND TRUNC(END_PERIOD)")->first();
        }
        $data['specialCase2'] = null;
        $GrantSpecialCase2 = GrantSpecialCase::where('second_order_flag','Y')->where('customer_id',$customer_id)->where('allowed_order_date',$data['today'])->first();
        if(!is_null($GrantSpecialCase2)){
            //
            $checkCase2Order = OrderHeader::where('attribute15','Y')
            ->where('customer_id',$customer_id)
            ->where('product_type_code',10)
            ->whereDate('order_date', Carbon::today())
            ->whereNotNull('order_number')
            ->whereNotNull('order_status')
            ->orderBy('order_header_id','DESC')->first();

            if(is_null($checkCase2Order)){
                $data['specialCase2'] = $GrantSpecialCase2;
            }else{
                if(strtolower($checkCase2Order->order_status) == 'cancelled'){
                    $data['specialCase2'] = $GrantSpecialCase2;
                }
            }
        }

        $data['expireBook'] = [];
        $contractBooks = OrderRepo::getCustomerContractBooks($customer_id);
        foreach ($contractBooks as $key => $v) {
            $date = Carbon::parse($v->book_end_date);
            $now = Carbon::now();

            if ($date->format('Y-m-d') >= $now->format('Y-m-d')) {
                $diff = $date->diffInDays($now);
                if ($diff >= 0) {
                    $data['expireBook'][] = $v;
                }
            }else{
                if (is_null($v->book_end_date)) {
                    $data['expireBook'][] = $v;
                }
            }

        }

        return response()->json(['data' => $data]);
    }

    public function orderPeriod($customer_number,$product_type='')
    {
        $customer = Customer::byCustomerNumber($customer_number);

        $checkOrder = [];
        $postponePeriod = PostponeOrders::where('customer_id',$customer->customer_id)->where('approve_status','อนุมัติ')->where('to_period_date',date('Y-m-d'))->first();

        // GrantSpecialCase2
        $specialCase2 = 'not_allow';
        $today = Carbon::today();
        $GrantSpecialCase2 = GrantSpecialCase::where('second_order_flag','Y')->where('customer_id',$customer->customer_id)->where('allowed_order_date',$today)->first();
        if(!is_null($GrantSpecialCase2)){

            $checkCase2Order = OrderHeader::where('attribute15','Y')
            ->where('customer_id',$customer->customer_id)
            ->where('product_type_code',$product_type)
            ->whereDate('order_date', Carbon::today())
            ->whereNotNull('order_number')
            ->whereNotNull('order_status')
            ->orderBy('order_header_id','DESC')->first();

            // if(is_null($checkCase2Order)){
                $specialCase2 = 'allow';
            // }else{
            //     if(strtolower($checkCase2Order->order_status) == 'cancelled'){
            //         $specialCase2 = 'allow';
            //     }
            // }

        }
        // GrantSpecialCase2

        if(!is_null($postponePeriod)){

            $checkOrder = OrderHeader::where('period_id',$postponePeriod->from_period_id)->where('customer_id',$customer->customer_id)
            ->whereRaw("lower(
                (
                    SELECT ptom_order_history.order_status
                    FROM ptom_order_history
                    WHERE ptom_order_headers.order_header_id = ptom_order_history.order_header_id AND ptom_order_history.deleted_at IS NULL
                    ORDER BY ptom_order_history.order_history_id DESC OFFSET 0 ROWS FETCH NEXT 1 ROWS ONLY
                )
            ) != 'cancelled' ")
            ->whereRaw("lower(order_status) != 'cancelled'")
            ->where("installment_type_code",10)
            ->where("product_type_code",$product_type)
            ->orderBy('order_header_id','DESC')->first();
        }

        if(!is_null($postponePeriod) && true){
            // if(!is_null($postponePeriod) && is_null($checkOrder)){
            // check days
            $period = DB::table('ptom_period_v as pvf')
            ->where('period_line_id', $postponePeriod->from_period_id)
            ->first();

            $checkBuy = 'not_allow';
            $periodBuy = OrderHeader::where('period_id', $period->period_line_id)->where('customer_id',$customer->customer_id)
            ->whereRaw("lower(
                (
                    SELECT ptom_order_history.order_status
                    FROM ptom_order_history
                    WHERE ptom_order_headers.order_header_id = ptom_order_history.order_header_id AND ptom_order_history.deleted_at IS NULL
                    ORDER BY ptom_order_history.order_history_id DESC OFFSET 0 ROWS FETCH NEXT 1 ROWS ONLY
                )
            ) != 'cancelled' ")
            ->whereRaw("lower(order_status) != 'cancelled'")
            ->where("installment_type_code",10)
            ->where("product_type_code",$product_type)
            ->orderBy('order_header_id','DESC')->first();

            if(is_null($periodBuy))
            {
                $checkBuy = 'allow';
            }else{
                $orderHis = OrderStatusHistory::where('order_number',$periodBuy->order_number)
                ->whereRaw("lower(order_status) != 'cancelled'")
                ->where("installment_type_code",10)
                ->where("product_type_code",$product_type)
                ->whereNull('deleted_at')
                ->orderBy('order_header_id','DESC')->first();
                if(!is_null($orderHis)){
                    $checkBuy = 'not_allow';
                }else{
                    $checkBuy = 'allow';
                }
            }
            // check days

            $response = [
                'period'=>$period,
                'periodNext'=>$period,
                'checkBuy'=>$checkBuy,
                'checkNextBuy'=>'not_allow',
                'specialCase2'=>$specialCase2
            ];
        }else{

            $compareDays = compareDaysTH($customer->delivery_date);
            $allDays = false;
            if($compareDays != 0){
                $status = 0;

                $date = nextDaysOfWeekNotPlus(compareDaysTH($customer->delivery_date));

                do {
                    if($compareDays == 0){
                        $compareDays = date('w',strtotime($date));
                        if($compareDays == 0 ||  $compareDays == 6){
                            $date = date('Y-m-d',strtotime($date . "+1 days"));
                            $compareDays = date('w',strtotime($date));
                        }
                    }else{
                        if(($compareDays == 6 || $compareDays == 7)){
                            $date = date('Y-m-d',strtotime($date . "+1 days"));
                            $compareDays = date('w',strtotime($date));
                        }else{
                            $status = 1;
                        }
                    }

                } while ($status == 0);
            }else{
                $allDays = true;
            }

            $datePeriod = nextDaysOfWeekNotPlus($compareDays);
            $postponePeriod = PostponeOrders::where('customer_id',$customer->customer_id)
                        ->where('approve_status','อนุมัติ')
                        ->where('from_period_date','<=',$datePeriod)
                        ->where('to_period_date','>=',now()->format('Y-m-d H:i:s'))
                        ->whereNull('deleted_at')
                        ->first();
            if($postponePeriod == null) {
                $statusPostpone = 0;
                do {
                    if($postponePeriod != null) {
                        $statusPostpone = 1;
                    }
                    $holiday = PnHolidayModel::where('hol_date',$datePeriod)->first();
                    if(!is_null($holiday)){
                        $datePeriod = date('Y-m-d',strtotime($datePeriod . "+1 days"));
                    }else{
                        if(date('w',strtotime($datePeriod)) == 6 || date('w',strtotime($datePeriod)) == 0){
                            $datePeriod = date('Y-m-d',strtotime($datePeriod . "+1 days"));
                        }else{
                            $statusPostpone = 1;
                        }
                    }
                } while ($statusPostpone == 0);
                $period = DB::table('ptom_period_v as pvf')
                    ->where('start_period','<=', $datePeriod)
                    ->where('end_period','>=', $datePeriod)
                    ->first();
            } else {

                $period = DB::table('ptom_period_v as pvf')
                    ->where('start_period','<=', $postponePeriod->from_period_date)
                    ->where('end_period','>=', $postponePeriod->from_period_date)
                    ->first();
            }
           
            $compareDaysTH = $compareDays;
            $numberDayNow = date('w',strtotime(date('Y-m-d')));

            if($compareDays < $numberDayNow && ($compareDays != 0)){
                $datePeriodNext = nextDaysOfWeek($compareDays);
            }else{
                $datePeriodNext = nextOfWeek($compareDays);
            }

            $statusPostponeNext = 0;
            do {
                $holiday = PnHolidayModel::where('hol_date',$datePeriodNext)->first();
                if(!is_null($holiday)){
                    $datePeriodNext = date('Y-m-d',strtotime($datePeriodNext . "+1 days"));
                }else{
                    if(date('w',strtotime($datePeriodNext)) == 6 || date('w',strtotime($datePeriodNext)) == 0){
                        $datePeriodNext = date('Y-m-d',strtotime($datePeriodNext . "+1 days"));
                    }else{
                        $statusPostponeNext = 1;
                    }
                }
            } while ($statusPostponeNext == 0);

            // $datePeriodNext = nextDaysOfWeek(compareDaysTH($customer->delivery_date));

            $periodNext = DB::table('ptom_period_v as pvf')
            ->where('start_period','<=', $datePeriodNext)
            ->where('end_period','>=', $datePeriodNext)
            ->first();

            $periodSys = DB::table('ptom_period_v as pvf')
            ->where('start_period','<=', '2023-01-01')
            ->where('end_period','>=', '2023-01-01')
            ->first();

            try {
                $periodBuy = OrderHeader::where('period_id',$period->period_line_id)->where('customer_id',$customer->customer_id)
                ->whereRaw("lower(
                    (
                        SELECT ptom_order_history.order_status
                        FROM ptom_order_history
                        WHERE ptom_order_headers.order_header_id = ptom_order_history.order_header_id AND ptom_order_history.deleted_at IS NULL
                        ORDER BY ptom_order_history.order_history_id DESC OFFSET 0 ROWS FETCH NEXT 1 ROWS ONLY
                    )
                ) != 'cancelled' ")
                ->whereRaw("lower(order_status) != 'cancelled'")
                ->where("installment_type_code",10)
                ->where("product_type_code",$product_type)
                ->first();
            } catch (\Exception $e) {
                $periodBuy = null;
            }

            if($allDays){
                $checkBuy = 'allow';
            }else{
                $flagDay = DB::table('ptom_day')
                ->where('meaning',$customer->delivery_date)
                ->first()->tag;
                if ($flagDay != 'Y') {

                    if(is_null($periodBuy))
                    {
                        $checkBuy = 'allow';
                    }else{
                        $orderHis = OrderStatusHistory::where('order_number',$periodBuy->order_number)
                        ->whereRaw("lower(order_status) != 'cancelled'")
                        ->where("installment_type_code",10)
                        ->where("product_type_code",$product_type)
                        ->whereNull('deleted_at')
                        ->orderBy('order_header_id','DESC')->first();
                        if(!is_null($orderHis)){
                            $checkBuy = 'not_allow';
                        }else{
                            $checkBuy = 'allow';

                        }

                    }

                }else{
                    if(is_null($periodBuy))
                    {
                        $checkBuy = 'allow';
                    }else{
                        $orderHis = OrderStatusHistory::where('order_number',$periodBuy->order_number)
                        ->whereRaw("lower(order_status) != 'cancelled'")
                        ->where("installment_type_code",10)
                        ->where("product_type_code",$product_type)
                        ->whereNull('deleted_at')
                        ->orderBy('order_header_id','DESC')->first();
                        if(!is_null($orderHis)){
                            $checkBuy = 'not_allow';
                        }else{
                            $checkBuy = 'allow';
                        }
                    }
                }
            }

            try {
                $periodNextBuy = OrderHeader::where('period_id',$periodNext->period_line_id)->where('customer_id',$customer->customer_id)
                ->whereRaw("lower(
                    (
                        SELECT ptom_order_history.order_status
                        FROM ptom_order_history
                        WHERE ptom_order_headers.order_header_id = ptom_order_history.order_header_id AND ptom_order_history.deleted_at IS NULL
                        ORDER BY ptom_order_history.order_history_id DESC OFFSET 0 ROWS FETCH NEXT 1 ROWS ONLY
                    )
                ) != 'cancelled' ")
                ->whereRaw("lower(order_status) != 'cancelled'")
                ->where("installment_type_code",10)
                ->where("product_type_code",$product_type)
                ->orderBy('order_header_id','DESC')->first();
            } catch (\Exception $e) {
                $periodNextBuy = null;
            }
            if(is_null($periodNextBuy) || $customer->customer_type_id == 20)
            {
                // OrderStatusHistory::where('period_id',$periodNextBuy->period_line_id)->where('customer_id',$customer->customer_id)->orderBy('order_header_id','DESC')->first();
                $checkNextBuy = 'allow';
            }else{
                $orderHis = OrderStatusHistory::where('order_number',$periodNextBuy->order_number)
                ->whereRaw("lower(order_status) != 'cancelled'")
                ->where("installment_type_code",10)
                ->where("product_type_code",$product_type)
                ->whereNull('deleted_at')
                ->orderBy('order_header_id','DESC')->first();
                if(!is_null($orderHis)){
                    $checkNextBuy = 'not_allow';
                }else{
                    $checkNextBuy = 'allow';
                }
                // $checkNextBuy = 'not_allow';
            }

            // check days

            $response = [
                'period'=>$period,
                'periodNext'=>$periodNext,
                'periodSys'=>$periodSys,
                'checkBuy'=>$checkBuy,
                'checkNextBuy'=>$checkNextBuy,
                'specialCase2'=>$specialCase2
            ];
        }

        return response()->json(['data' => $response]);
    }

    public function orderPeriodByLineId($period_line_id)
    {
        $period = DB::table('ptom_period_v as pvf')
        ->where('period_line_id','>=', $period_line_id)
        ->first();

        return response()->json(['data' => $period]);
    }

    public function installment()
    {
        // $installment = DB::table('ptom_period_v')->where('start_period','<=',now())->where('end_period','>=',now())->get();
        $installment = DB::table('ptom_period_v')->where('start_period','<=','2020-12-01')->where('end_period','>=','2020-12-10')->first();
        return response()->json(['data' => $installment]);
    }

    public function specialCase($customer_id)
    {
        $today = Carbon::today();
        $fromHeaderOrder = FormOrderHeader::where('customer_id',$customer_id)->where('approve_status','อนุมัติ')->where('to_period_date',$today)->where('form_type','SPECIAL')->first();
        $GrantSpecialCase = GrantSpecialCase::where('grant_special_flag','Y')->where('customer_id',$customer_id)->where('allowed_order_date',$today)->first();
        if(!is_null($fromHeaderOrder) && !is_null($GrantSpecialCase)){
            $specialCase = $GrantSpecialCase;
        }
        // $specialCase = GrantSpecialCase::where('grant_special_flag','Y')->where('customer_id',$customer_id)->where('allowed_order_date',$today)->first();
        return response()->json(['data' => $specialCase]);
    }

    public function specialCase2($customer_id)
    {
        $today = Carbon::today();
        $GrantSpecialCase2 = GrantSpecialCase::where('second_order_flag','Y')->where('customer_id',$customer_id)->where('allowed_order_date',$today)->first();
        if(!is_null($GrantSpecialCase2)){

            $checkCase2Order = OrderHeader::where('attribute15','Y')
            ->where('customer_id',$customer_id)
            ->whereDate('order_date', Carbon::today())
            ->orderBy('order_header_id','DESC')->first();

            if(is_null($checkCase2Order)){
                $specialCase2 = $GrantSpecialCase2;
            }else{
                if(strtolower($checkCase2Order->order_status) == 'cancelled'){
                    $specialCase2 = $GrantSpecialCase2;
                }
            }

        }
        // $specialCase = GrantSpecialCase::where('grant_special_flag','Y')->where('customer_id',$customer_id)->where('allowed_order_date',$today)->first();
        return response()->json(['data' => $specialCase2]);
    }


    public function checkPromotion(Request $request)
    {
        $date = date('Y-m-d');
        $promotionData = [];
        $promotionHeader = DB::table('ptom_promotion_header')
        ->where('start_date','<=',$date)
        // ->where('promotion_id',3)
        ->where(function($query) use ($date){
            $query->where('end_date','>=',$date);
            $query->orwhereNull('end_date');
        })
        ->whereRaw("lower(status) = 'active'")
        ->orderBy('promotion_id','DESC')
        ->get();

        if(count($promotionHeader) == 0){
            return response()->json(['status'=>false,'data' => [],'message' => 'ไม่มีโปรโมชั่น']);
        }

        $checkProduct = false;
        $promotionProductGroup = [];
        $productList = [];
        $dtlList = [];
        // $productList['data'][$vh->promotion_id]['first_support_group'] = '';
        $response = [];

        // $productList['data'][$vh->promotion_id]['support_group'] = [];

        $uom = [
            'CGK',
            'CGC',
            'CG2',
            'CL1',
            'CS1',
            'PTN'
        ];

        $gifMax = [];

        // $productList['data'][$vh->promotion_id]['gifAmount'] = 0;
        foreach ($promotionHeader as $key_h => $vh) {
            $rounds = 0;

            $productList[$vh->promotion_id]['data']['first_support_group'] = '';
            $productList[$vh->promotion_id]['data']['gifAmount'] = 0;
            $productList[$vh->promotion_id]['data']['support_group'] = [];
            $checkCondition = [];

            // echo 'asdad'.$vh->promotion_id;

            $promotionCust = DB::table('ptom_promotion_cust')
            ->where('promotion_id',$vh->promotion_id)
            ->where('customer_id',$request->customer_id)
            ->first();


            if (isset($promotionCust) && !empty($promotionCust)) {

                try{
                    $productGroup = DB::table('ptom_promotion_product_group')
                    ->where('promotion_id',$vh->promotion_id)
                    // ->where('product_group',$dtl->product_group)
                    ->get();

                    $productGroupItem = [];
                    $dtlList = DB::table('ptom_promotion_dtl')
                    ->where('promotion_id',$vh->promotion_id)
                    // ->where('product_group',$pg->product_group)
                    // ->where('sale_quantity','<=',$v['qty'])
                    // ->where('sale_uom',$v['uom'])
                    // ->where('maximum_quantity','>=',$v['qty'])
                    ->get();


                    foreach ($dtlList as $key => $v) {
                        $response[$vh->promotion_id]['group'][$v->product_group]['dtl'] = [
                            'promotion_id'=>$v->promotion_id,
                            'sale_group'=>$v->sale_group,
                            'product_group'=>$v->product_group,
                            'sale_quantity'=>$v->sale_quantity,
                            'sale_uom'=>$v->sale_uom,
                            'sale_uom_desc'=>$v->sale_uom_desc,
                            'maximum_quantity'=>$v->maximum_quantity,
                            'maximum_uom'=>$v->maximum_uom,
                            'maximum_uom_desc'=>$v->maximum_uom_desc
                        ];
                    }

                    $sumQty = 0;
                    // $checkGroup = [];
                    // foreach ($productGroup as $key_pg => $pg) {
                    //     $checkGroup[$pg->product_group][$pg->item_id] = false;
                    //     $checkGroup[$pg->product_group]['data'] = [];
                    //     foreach ($request->item as $key => $v) {
                    //         if($v['id'] == $pg->item_id){
                    //             $checkGroup[$pg->product_group][$pg->item_id] = true;
                    //             $checkGroup[$pg->product_group]['data'] = $pg;
                    //         }
                    //     }
                    // }

                    // $haveGroup = [];
                    // foreach ($checkGroup as $key => $v) {
                    //     if(array_search(false,$v) == ''){
                    //         $productGroup = DB::table('ptom_promotion_product_group')
                    //         ->where('promotion_id',$vh->promotion_id)
                    //         ->where('product_group',$key)
                    //         ->get();
                    //     }
                    // }

                    // var_dump($productGroup);
                    foreach ($productGroup as $key_pg => $pg) {

                        try {
                            $response[$vh->promotion_id]['group'][$pg->product_group]['total_product'] += 1;
                        }catch (\Exception $e) {
                            $response[$vh->promotion_id]['group'][$pg->product_group]['total_product'] = 1;
                        }

                        foreach ($request->item as $key => $v) {

                            // var_dump($v['id']);
                            // echo '<br>';
                            // var_dump($pg->item_id);
                            // echo '<br>-------------------------------';
                            if($v['id'] == $pg->item_id){
                                foreach ($uom as $key_uom => $v_uom) {
                                    if($response[$vh->promotion_id]['group'][$pg->product_group]['dtl']['sale_uom'] == $v_uom){
                                    if($v_uom == 'CGC'){
                                            $qty = $v['qty'] * 0.1;
                                        }elseif($v_uom == 'CG2'){
                                            $qty = $v['qty'] / 0.2;
                                        }else{
                                            $qty = $v['qty'];
                                        }

                                        $sumQty += $qty;
                                        try {
                                            $response[$vh->promotion_id]['group'][$pg->product_group]['sum_qty'] += $qty;
                                        } catch (\Throwable $th) {
                                            $response[$vh->promotion_id]['group'][$pg->product_group]['sum_qty'] = $qty;
                                        }

                                        $response[$vh->promotion_id]['group'][$pg->product_group]['product'][$v_uom][] = [
                                            'product_group'=>$pg->product_group,
                                            'item_id'=>$pg->item_id,
                                            'item_code'=>$pg->item_code,
                                            'item_description'=>$pg->item_description,
                                            'qty'=> $qty,
                                            'uom'=> $v_uom,
                                            // 'item' => $v
                                        ];


                                    }

                                }

                            //     $response[$vh->promotion_id]['group'][$pg->product_group]['status'] = true;

                            }
                            // else{
                            //     $response[$vh->promotion_id]['group'][$pg->product_group]['status'] = false;
                            // }

                        }

                    }

                    $checkConditionPro = collect($response[$vh->promotion_id]['group'])->groupBy('dtl.sale_group');
                    $checkValue = [];
                    $group_qty = [];
                    foreach($checkConditionPro as $item_condition) {
                        foreach($item_condition->groupBy('dtl.product_group') as $key => $item_group){
                            $group_qty[$key] = $item_group->first()['dtl']['sale_quantity'];
                            $checkValue[$key] = ($item_group->first()['dtl']['maximum_quantity'] > $item_group->sum('sum_qty')) ? $item_group->sum('sum_qty') :  $item_group->first()['dtl']['maximum_quantity'] ;
                            $checkValue[$key] = ($checkValue[$key] - $promotionCust->start_promotion_qty) + 1;
                        }
                        while (true) {
                            $allZero = true;
                            foreach ($checkValue as $k => $value) {
                                if ($checkValue[$k] <= 0) {
                                    $allZero= true;
                                    break;
                                } elseif ($checkValue[$key] > 0 ) {

                                    if($checkValue[$k] >= $group_qty[$k]) {
                                        $checkValue[$k] -= $group_qty[$k];
                                        $allZero = false;
                                    } else {
                                        $allZero= true;
                                        break;
                                    }
                                }
                            }
                            if ($allZero) {
                                break;
                            }
                            $rounds++;
                        }
                        
                    }
                    
                    foreach ($response[$vh->promotion_id]['group'] as $key => $v) {
                        if(isset($v['product'])) {
                            if($v['dtl']['sale_quantity'] <= $v['sum_qty'] && $v['dtl']['maximum_quantity'] >= $v['sum_qty']){
                                $gifMax['amount'][] = $v['sum_qty'] / $v['dtl']['sale_quantity'];
                                $gifMax['max'][] = $v['dtl']['maximum_quantity'] / $v['dtl']['sale_quantity'];
                                $checkCondition[] = true;
                            }elseif($v['dtl']['sale_quantity'] <= $v['sum_qty'] && $v['dtl']['maximum_quantity'] <= $v['sum_qty']){
                                $gifMax['amount'][] = $v['sum_qty'] / $v['dtl']['sale_quantity'];
                                $gifMax['max'][] = $v['dtl']['maximum_quantity'] / $v['dtl']['sale_quantity'];
                                $checkCondition[] = true;
                            }else{
                                $checkCondition[] = false;
                            }

                            // var_dump($v['sum_qty'],$v['dtl']['sale_quantity'],$v['dtl']['maximum_quantity']);
                            // if(count($v['product'][$v['dtl']['sale_uom']]) >= $v['total_product']) {
                            //     foreach ($v['product'][$v['dtl']['sale_uom']] as $key_p => $vp) {
                            //         if($v['dtl']['sale_quantity'] <= $vp['qty'] && $v['dtl']['maximum_quantity'] >= $vp['qty'])
                            //         {
                            //             $gifMax['amount'][] = $vp['qty'] / $v['dtl']['sale_quantity'];
                            //             $gifMax['max'][] = $v['dtl']['maximum_quantity'] / $v['dtl']['sale_quantity'];
                            //             $checkCondition[] = true;
                            //         }else{
                            //             $checkCondition[] = false;
                            //         }
                            //     }
                            // }else{
                            //     $checkCondition[] = false;
                            // }

                            // if(count($v['product'][$v['dtl']['sale_uom']]) >= $v['total_product']) {
                            //     foreach ($v['product'][$v['dtl']['sale_uom']] as $key_p => $vp) {
                            //         if($v['dtl']['sale_quantity'] <= $vp['qty'] && $v['dtl']['maximum_quantity'] >= $vp['qty'])
                            //         {
                            //             $gifMax['amount'][] = $vp['qty'] / $v['dtl']['sale_quantity'];
                            //             $gifMax['max'][] = $v['dtl']['maximum_quantity'] / $v['dtl']['sale_quantity'];
                            //             $checkCondition[] = true;
                            //         }else{
                            //             $checkCondition[] = false;
                            //         }
                            //     }
                            // }else{
                            //     $checkCondition[] = false;
                            // }
                        }else{
                            $checkCondition[] = false;
                        }
                    }
                    // แบ่งกลุ่มผลิตภัณฑ์ตามกลุ่ม
                }catch (\Exception $e) {
                }

                // $response['dtlList'][] = $dtlList;

                // แบ่งกลุ่มผลิตภัณฑ์ตามกลุ่ม

            }
            // var_dump($checkCondition);
            if(count($checkCondition) > 0 && !in_array(false,$checkCondition,true)){
                $promotionData[] = $vh->promotion_id;

                sort($gifMax['amount']);
                sort($gifMax['max']);
                // break;
            }
            try {
                if(@$gifMax['amount'][0] > @$gifMax['max'][0]){
                    $productList[$vh->promotion_id]['data']['gifAmount'] = (int)floor($rounds);
                }else{
                    $productList[$vh->promotion_id]['data']['gifAmount'] = (int)floor($rounds);
                }
            }catch (\Exception $e) {
            }

        }

        // dd($productList);
        array_unique($promotionData);

        $productList['promotion'] = $promotionData;

        foreach ($promotionData as $key => $vh) {

            $productList[$vh]['data']['promotion'] = DB::table('ptom_promotion_header')
            ->where('promotion_id',$vh)
            ->first();

            $promotionProduct = DB::table('ptom_promotion_product')
            ->where('promotion_id',$vh)
            ->get();

            foreach ($promotionProduct as $key_prod => $vprod) {


                if($productList[$vh]['data']['first_support_group'] == ''){
                    $productList[$vh]['data']['first_support_group'] = $vprod->support_group;
                }

                if (!in_array($vprod->support_group, $productList[$vh]['data']['support_group'])){
                    $productList[$vh]['data']['support_group'][] = $vprod->support_group;
                }

                $productList[$vh]['data']['item'][$vprod->support_group][$vprod->promotion_product_id] = $vprod;
            }
        }
        return response()->json(['status'=>true,'data' =>$productList,'message' => '']);
    }

    public function orderSpecialByNumber($order_header_id)
    {
        $response = [];

        $response['contractExpireBooks'] = [];
        $response['order'] = OrderHeader::where('order_header_id',$order_header_id)->orderBy('order_header_id','DESC')->first();
        $customer_id = $response['order']->customer_id;

        $response['formLineOrder'] = [];
        $response['orderLine'] = [];

        try {
            $dateToday = $response['order']->delivery_date? date('Y-m-d', strtotime($response['order']->delivery_date)): date('Y-m-d');
            $fromHeaderOrder = FormOrderHeader::where('customer_id',$customer_id)
                                            ->where('approve_status','อนุมัติ')
                                            // ->where('to_period_date',date('Y-m-d'))
                                            ->whereRaw("trunc(to_period_date) = to_date('{$dateToday}', 'YYYY-MM-DD')")
                                            ->where('form_type','SPECIAL')
                                            ->first();
            $response['fromHeaderOrder'] = $fromHeaderOrder;

            if(!is_null($fromHeaderOrder)){

                $response['formLineOrder'] = OrderRepo::getCustomerSpecialHeaders($customer_id,$response['order'],$fromHeaderOrder);

                foreach ($response['formLineOrder'] as $key => $v) {

                    $orderLine = OrderLines::where('order_header_id',$response['order']->order_header_id)->where('item_id',$v->item_id)->whereNull('promo_flag')->first();
                    $color_code = DB::table('ptom_sequence_ecoms as se')
                    ->where('item_code',$v->item_code)
                    ->first();
                    $v->color_code = $color_code->color_code;

                    if(!is_null($orderLine)){
                        $response['orderLine'][$v->item_id] = $orderLine;
                        $response['orderLine'][$v->item_id]->color_code = $color_code->color_code;
                    }



                }

            }else{
                $response['formLineOrder'] = OrderLines::where('order_header_id',$response['order']->order_header_id)->whereNull('promo_flag')->get();
                foreach ($response['formLineOrder'] as $key => $v) {

                    $color_code = DB::table('ptom_sequence_ecoms as se')
                    ->where('item_code',$v->item_code)
                    ->first();
                    $v->color_code = $color_code->color_code;

                    $response['orderLine'][$v->item_id] = $v;
                    $response['orderLine'][$v->item_id]->price_unit = $v->unit_price;
                    $response['orderLine'][$v->item_id]->color_code = $color_code->color_code;
                }
            }

        } catch (\Exception $e) {
            $response['fromHeaderOrder'] = [];
        }

        $response['customer'] = Customer::byCustomerId($customer_id);
        $response['productType'] = OrderRepo::getProcutTypeDomesticLookup($response['order']->product_type_code);
        $response['paymentType'] = OrderRepo::getPaymentTypeLookup($response['order']->payment_type_code);
        $response['paymentMethod'] = OrderRepo::getPaymentMethodLookup($response['order']->payment_method_code);
        $response['shipmentBy'] = OrderRepo::getShipmentLookup($response['order']->transport_type_code);
        $response['overdueDebt'] = [];
        $response['contractBooks'] = OrderRepo::getCustomerContractBooks($customer_id);

        $response['lastOrdersStatus'] = OrderRepo::lastOrdersStatus($response['order']->order_header_id)->order_status;
        $response['shipSites'] = OrderRepo::shipSites($customer_id);
        if($response['order']->installment_type_code == '20') {
            $response['order']->period_id = $fromHeaderOrder->to_period_id;
            $response['order']->delivery_date = $fromHeaderOrder->to_period_date;
            $response['order']->save();
        }
        $response['period'] = OrderRepo::getPeriodByLineId($response['order']->period_id);

        $cartonLov = CartonQuantityV::where('enabled_flag','Y')->get(['lookup_code','meaning']);
        $dataCarton = [];
        foreach ($cartonLov as $key => $v) {
            $dataCarton[] = $v;
        }
        sort($dataCarton);
        $response['cartonLov'] = $dataCarton;

        return response()->json(['data' => $response]);
    }

    public function orderByNumber($order_header_id)
    {
        $response = [];
        $response['contractExpireBooks'] = [];
        $response['order'] = OrderHeader::where('order_header_id',$order_header_id)->orderBy('order_header_id','DESC')->first();
        $dateNow = Carbon::createFromFormat('Y-m-d H:i:s', $response['order']->delivery_date)->format('Y-m-d');

        $customer_id = $response['order']->customer_id;

        $response['customer'] = Customer::byCustomerId($customer_id);

        $customer_type_id = $response['customer']->customer_type_id;

        $response['contractGroups'] = OrderRepo::getCustomerContractGroups($customer_id);

        $response['contractQuataNew'] = [];
        $additionQuota = AdditionQuota::where('order_header_id',$response['order']->order_header_id)
                                        ->where('customer_id',$customer_id)
                                        ->where('approve_status','อนุมัติ')
                                        ->orderBy('order_header_id','DESC')
                                        ->first();
        $dateNow = Carbon::createFromFormat('Y-m-d H:i:s', $response['order']->delivery_date)->format('Y-m-d');
        $response['transportOwner'] = DB::table('ptom_transport_owners')
                                        ->whereRaw("to_date('{$dateNow}', 'YYYY-MM-DD') BETWEEN start_date AND end_date")
                                        ->first();
        $response['additionQuota'] = false;
        if(!is_null($additionQuota)){
            $response['additionQuota'] = true;
        }
        $credit_amount = $response['order']->credit_amount;

        $remain_recal = $this->remainingAmountCallback($response['order']->customer_id, $response['order']->delivery_date, $response['order']->period_id);
        foreach ($response['contractGroups'] as $key => $item) {
            $item->use_amount = 0;

            $orderCredit = OrderCreditGroup::where('order_header_id',$response['order']->order_header_id)->where('credit_group_code',$item->credit_group_code)->where('order_line_id',0)->first();
            if(!is_null($orderCredit)){
                $item->view_amount = $orderCredit->amount;
                $item->view_received_amount = $orderCredit->received_amount;
                $item->view_remaining_amount = $orderCredit->remaining_amount;
            }else{
                $item->view_amount = 0;
                $item->view_received_amount = 0;
                $item->view_remaining_amount = 0;
            }
        }
        $orderRemaining= DB::table('OAOM.PTOM_ORDER_REMAINING')->where('order_header_id', $response['order']->order_header_id)->first();
        foreach ($response['contractGroups'] as $key => $item) {

            
            $orderCredit = OrderCreditGroup::where('order_header_id',$response['order']->order_header_id)->where('credit_group_code',$item->credit_group_code)->first();
            if(!is_null($orderCredit) && $orderCredit->amount != 0){
                if ($credit_amount != null && $credit_amount != 0) {
                    $credit_amount -= $item->remaining_amount;
                    if($credit_amount > 0){
                        $item->use_amount = $item->remaining_amount;
                    }else{
                        $item->use_amount = $item->remaining_amount + $credit_amount;
                        break;
                    }
                }else{
                    $item->use_amount = 0;
                }
            }

            // คำนวนใหม่
            $baseRemain = $remain_recal['cusContractGroup']->where('credit_group_code', $item->credit_group_code)->first()->credit_amount;
            $process1  = $remain_recal['ptOmDebtDomV']->where('credit_group_code', $item->credit_group_code)->sum('outstanding_debt');
            $process2  = $remain_recal['orderHeaders']->where('credit_group_code', $item->credit_group_code)->sum('amount');
            $item->remaining_amount = $baseRemain - $process1 -$process2;

        }
        foreach($response['contractGroups']  as $key => $item) {
            if($orderRemaining != null) {
                $item->view_remaining_amount = $orderRemaining->{'group'.$item->credit_group_code.'_remaining'};
            } else {
                $item->view_remaining_amount =0;
            }
        }
        
        $periodPostpone = DB::table('ptom_postpone_orders')
                            ->where('from_period_id', $response['order']->period_id)
                            ->where('customer_id', $response['order']->customer_id)
                            ->where('approve_status', 'อนุมัติ')
                            ->whereNull('deleted_at')
                            ->orderBy('postpone_order_id', 'DESC')
                            ->first(); 
        if($periodPostpone) {
            // check เลื่อนวันซ้อน
            $periodPostponeStep2 = DB::table('ptom_postpone_orders')
            ->where('to_period_date', Carbon::createFromFormat('Y-m-d H:i:s',$periodPostpone->from_period_date)->format('Y-m-d'))
            ->where('customer_id', $response['order']->customer_id)
            ->where('approve_status', 'อนุมัติ')
            ->whereNull('deleted_at')
            ->orderBy('postpone_order_id', 'DESC')
            ->first();
            if($periodPostponeStep2) {
                $periodPostpone = $periodPostponeStep2;
            }
        }
     
       
                            
        $response['periodPostpone'] = $periodPostpone;

        if($customer_type_id == 20){
            if(is_null($periodPostpone)){
                $response['contractQuata'] = OrderRepo::getCustomerQuotaHeadersMT($customer_id,$response['order']);
            }else{
                $response['contractQuata'] = OrderRepo::getCustomerQuotaHeadersByPeriodMT($customer_id,$periodPostpone);
            }
        }else{
            if(is_null($periodPostpone)){
                $response['contractQuata'] = OrderRepo::getCustomerQuotaHeaders($customer_id,$response['order']);
            }else{
                $response['contractQuata'] = OrderRepo::getCustomerQuotaHeadersByPeriod($customer_id,$periodPostpone);
            }
        }

        try {
            $response['orderLine'] = [];
            foreach($response['contractQuata'] as $val){

                $orderQuota = OrderQuotaHistory::where('order_header_id',$response['order']->order_header_id)
                                                ->where('quota_group_code',$val['group']->lookup_code)
                                                ->first();
                if(!is_null($orderQuota)){
                    $val['group']->view_spending_quota      = $orderQuota->spending_quota;
                    $val['group']->view_received_quota      = $orderQuota->received_quota;
                    $val['group']->view_remaining_quota     = $orderQuota->remaining_quota;
                }else{
                    $val['group']->view_spending_quota      = 0;
                    $val['group']->view_received_quota      = 0;
                    $val['group']->view_remaining_quota     = 0;
                }
                $val['group']->addition_quta                = 0;

                if(!is_null($additionQuota)){
                    $AdditionQuotaLines = AdditionQuotaLines::where('quota_header_id',$additionQuota->quota_header_id)
                                                            ->where('quota_group_id',(int)$val['group']->lookup_code)
                                                            ->first();

                    if(!is_null($AdditionQuotaLines)){
                        $val['group']->addition_quta = $AdditionQuotaLines->approve_quantity / 0.1;
                    }
                }

                foreach ($val['quota'] as $quota){

                    $orderLine = OrderLines::where('order_header_id',$response['order']->order_header_id)
                                            ->where('item_id',$quota->item_id)
                                            ->whereNull('promo_flag')
                                            ->get();
                    $quotaUse = 0;
                    foreach ($orderLine as $key => $item) {
                        $response['orderLine'][$val['group']->lookup_code][$quota->quota_line_id][$item->item_id] = $item;
                        $quotaUse += $item->order_quantity;
                    }

                    if($quotaUse > $quota->remaining_quota){
                        $quota->quota_use = $quota->remaining_quota;
                    }else{
                        $quota->quota_use = $quotaUse;
                    }
                    $contractQuataNew = $quota;
                    $contractQuataNew->group = $val['group'];
                    $response['contractQuataNew'][] = $contractQuataNew;
                }

            }
        } catch (\Exception $e) {
            $response['orderLine'] = [];
            foreach($response['contractQuata'] as $val){
                $val['group']->view_spending_quota = 0;
                $val['group']->view_received_quota = 0;
                $val['group']->view_remaining_quota = 0;
                foreach ($val['quota'] as $quota){
                    $quota->quota_use = 0;
                    $response['contractQuataNew'][] = $quota;
                }

                $val['group']->addition_quta = 0;


            }
        }

        if(count($response['contractQuataNew']) > 0){
            $keys = array_column($response['contractQuataNew'], 'screen_number');
            array_multisort($keys, SORT_ASC, $response['contractQuataNew']);
        }

        $response['productType']        = OrderRepo::getProcutTypeDomesticLookup($response['order']->product_type_code);
        $response['paymentType']        = OrderRepo::getPaymentTypeLookup($response['order']->payment_type_code);
        $response['paymentMethod']      = OrderRepo::getPaymentMethodLookup($response['order']->payment_method_code);
        $response['shipmentBy']         = OrderRepo::getShipmentLookup($response['order']->transport_type_code);
        $response['overdueDebt']        = [];
        $response['contractBooks']      = OrderRepo::getCustomerContractBooks($customer_id);

        $response['promotionProduct']   = OrderRepo::getPromotionProduct($response['order']->order_header_id);

        $expireBook = false;
        foreach ($response['contractBooks'] as $key => $v) {
            $date = Carbon::parse($v->book_end_date);
            if(!is_null($v->book_end_date)){
                $now = Carbon::now();
                $diff = $date->diffInDays($now);

                if ($diff <= 30) {
                    $response['contractExpireBooks'][] = $v;
                }
            }


        }

        $response['lastOrdersStatus']   = OrderRepo::lastOrdersStatus($response['order']->order_header_id)->order_status;
        $response['shipSites']          = OrderRepo::shipSites($customer_id);
        $response['period']             = OrderRepo::getPeriodByLineId($response['order']->period_id);

        $penaltyRate = PenaltyRateDomesticV::where('enabled_flag','Y')->first();
        if(is_null($penaltyRate)){
            $amountPenaltyRate = 0;
        }else{
            $amountPenaltyRate = $penaltyRate->description;
        }

        $daysInYear = Carbon::parse(date('Y'))->daysInYear;
        $response['Outstanding'] = [];
        if($response['lastOrdersStatus'] == 'Draft' || is_null($response['lastOrdersStatus'])){
            $Outstanding = OutstandingDebtDomesticV::where('customer_id',$customer_id)
                                                    ->where('outstanding_debt','>',0)
                                                    ->where('pick_release_status','Confirm')
                                                    ->get();
            foreach ($Outstanding as $key => $v) {
                try {
                    $delivery_date = OrderHeaders::where('order_header_id', $order_header_id)->first()->delivery_date;
                    if(is_null($delivery_date)){
                        $delivery_date = date('Y-m-d');
                    }
                }catch (\Exception $e) {
                    $delivery_date = date('Y-m-d');
                }

                $improveFines = DB::table('ptom_improve_fines')
                ->where('invoice_number',$v->pick_release_no)
                ->whereRaw("cancel_flag = 'Y'")->orderBy('invoice_number','ASC')->first();

                if(is_null($v->due_date)){
                    $date = date('Y-m-d');
                }else{
                    $date = $v->due_date;
                }

                $releaseCredit = ReleaseCredit::where('invoice_id',$v->order_header_id)->where('customer_id',$customer_id)->where('credit_group_code',$v->credit_group_code)->first();

                if(is_null($releaseCredit)){

                    // ค่าปรับ
                    $date = Carbon::parse($v->due_date);
                    $now = Carbon::parse(now());

                    if($date >= $now){
                        $diff = 0;
                    }else{
                        $diff = $date->diffInDays($now);
                    }

                    $penalty_day = (($v->outstanding_debt * $amountPenaltyRate) / 100) / $daysInYear;

                    if(is_null($improveFines)){
                        $penalty_total = $penalty_day * $diff;
                    }else{
                        $penalty_total = 0;
                    }
                    
                    if($customer_type_id != 20) {
                        $delivery_date = Carbon::createFromFormat("Y-m-d H:i:s", $delivery_date)->endOfWeek()->format('Y-m-d H:i:s');
                    }
                    // ค่าปรับ
                    $no = ((($v->customer_type_id == 30 || $v->customer_type_id == 40) && $v->product_type_code == 10) ? $v->consignment_no : $v->pick_release_no);
                    $response['Outstanding'][] = [
                        'no'=>$no.'_'.$v->credit_group_code,
                        'pick_release_no'=>$no,
                        'credit_group_code'=>$v->credit_group_code,
                        'description'=>(($v->credit_group_code == 0) ? 'เงินสด' : 'เงินเชื่อกลุ่ม '.$v->credit_group_code),
                        'amount'=>$v->outstanding_debt,
                        'due_days'=>$v->due_date,
                        'auto_check'=> ($v->due_date <= Carbon::createFromFormat('Y-m-d H:i:s', $delivery_date)->format('Y-m-d H:i:s')) ? true : false,
                        'date_th'=>dateFormatThai($date),
                        'penalty_percen'=>$amountPenaltyRate,
                        'penalty_day'=>$penalty_day,
                        'penalty_total'=>(!is_null($v->pick_release_no) || !is_null($v->consignment_no)) ? number_format((float)(($penalty_total < 0) ? 0 : $penalty_total), 2, '.', '') : 0,
                        'daysInYear'=>$daysInYear,
                        'flag'=>'N'  // ยังไม่ถูก select กับ order ไหน
                    ];
                }else{
                    // ค่าปรับ

                    $date = Carbon::parse($v->due_datedue_date);
                    $now = Carbon::parse($releaseCredit->creation_date);

                    if($date >= $now){
                        $diff = 0;
                    }else{
                        $diff = $date->diffInDays($now);
                    }

                    $penalty_day = (($v->outstanding_debt * $amountPenaltyRate) / 100) / $daysInYear;

                    if(is_null($improveFines)){
                        $penalty_total = $penalty_day * $diff;
                    }else{
                        $penalty_total = 0;
                    }
                    // ค่าปรับ

                    $no = ((($v->customer_type_id == 30 || $v->customer_type_id == 40) && $v->product_type_code == 10) ? $v->consignment_no : $v->pick_release_no);
                    if ($releaseCredit->attribute1 == $response['order']->order_header_id) {
                        $response['Outstanding'][] = [
                            'no'=>$no.'_'.$v->credit_group_code,
                            'pick_release_no'=>$no,
                            'credit_group_code'=>$v->credit_group_code,
                            'description'=>(($v->credit_group_code == 0) ? 'เงินสด' : 'เงินเชื่อกลุ่ม '.$v->credit_group_code),
                            'amount'=>$v->outstanding_debt,
                            'due_days'=>$v->due_days,
                            'auto_check'=>($v->due_date <= $delivery_date) ? true : false,
                            'date_th'=>dateFormatThai($v->due_date),
                            'penalty_percen'=>$amountPenaltyRate,
                            'penalty_day'=>$penalty_day,
                            'penalty_total'=>(!is_null($v->pick_release_no) || !is_null($v->consignment_no)) ? number_format((float)(($penalty_total < 0) ? 0 : $penalty_total), 2, '.', '') : 0,
                            'daysInYear'=>$daysInYear,
                            'flag'=>'Y' // select กับ order นี้
                        ];
                    }else{
                        // if($releaseCredit->payment_flag != 'Y'){
                            $response['Outstanding'][] = [
                                'no'=>$no.'_'.$v->credit_group_code,
                                'pick_release_no'=>$no,
                                'credit_group_code'=>$v->credit_group_code,
                                'description'=>(($v->credit_group_code == 0) ? 'เงินสด' : 'เงินเชื่อกลุ่ม '.$v->credit_group_code),
                                'amount'=>$v->outstanding_debt,
                                'due_days'=>$v->due_days,
                                'auto_check'=>($v->due_date <= $delivery_date) ? true : false,
                                'date_th'=>dateFormatThai($v->due_date),
                                'penalty_percen'=>$amountPenaltyRate,
                                'penalty_day'=>$penalty_day,
                                'penalty_total'=>(!is_null($v->pick_release_no) || !is_null($v->consignment_no)) ? number_format((float)(($penalty_total < 0) ? 0 : $penalty_total), 2, '.', '') : 0,
                                'daysInYear'=>$daysInYear,
                                'flag'=> 'M' // select กับ order อื่นแล้ว
                            ];
                        // }
                    }

                }
            }
        }else{
            $releaseCredit = ReleaseCredit::where('attribute1', $response['order']->order_header_id)->where('customer_id',$customer_id)->where('payment_flag','Y')->get();
            if(!is_null($releaseCredit)){
                foreach ($releaseCredit as $key => $v) {
                    try {
                        $delivery_date = $response['order']->delivery_date;
                        if(is_null($delivery_date)){
                            $delivery_date = date('Y-m-d');
                        }
                    }catch (\Exception $e) {
                        $delivery_date = date('Y-m-d');
                    }
                    // ค่าปรับ

                    $improveFines = DB::table('ptom_improve_fines')
                    ->where('invoice_number',$v->invoice_num)
                    ->whereRaw("cancel_flag = 'Y'")->orderBy('invoice_number','ASC')->first();

                    $date = Carbon::parse($v->due_date);
                    $now = Carbon::parse($v->creation_date);

                    if($date >= $now){
                        $diff = 0;
                    }else{
                        $diff = $date->diffInDays($now);
                    }

                    $penalty_day = (($v->amount * $amountPenaltyRate) / 100) / $daysInYear;

                    if(is_null($improveFines)){
                        $penalty_total = $penalty_day * $diff;
                    }else{
                        $penalty_total = 0;
                    }
                    // ค่าปรับ

                    $response['Outstanding'][] = [
                        'no'=>$v->invoice_num.'_'.$v->credit_group_code,
                        'pick_release_no'=>$v->invoice_num,
                        'credit_group_code'=>$v->credit_group_code,
                        'description'=>(($v->credit_group_code == 0) ? 'เงินสด' : 'เงินเชื่อกลุ่ม '.$v->credit_group_code),
                        'amount'=>$v->amount,
                        'due_days'=>null,
                        'auto_check'=>($v->due_date <= $delivery_date) ? true : false,
                        'date_th'=>dateFormatThai($v->due_date),
                        'penalty_percen'=>$amountPenaltyRate,
                        'penalty_day'=>$penalty_day,
                        'penalty_total'=>(!is_null($v->pick_release_no) || !is_null($v->consignment_no)) ? number_format((float)(($penalty_total < 0) ? 0 : $penalty_total), 2, '.', '') : 0,
                        'daysInYear'=>$daysInYear,
                        'flag'=>'Y'
                    ];
                }
            }
        }
        $cartonLov = CartonQuantityV::where('enabled_flag','Y')->get(['lookup_code','meaning']);
        $dataCarton = [];
        foreach ($cartonLov as $key => $v) {
            $dataCarton[] = $v;
        }
        sort($dataCarton);
        $response['cartonLov'] = $dataCarton;

        return response()->json(['data' => $response]);
    }

    public function orderPurchaseByNumber($order_header_id)
    {
        $response = [];
        $response['order'] = OrderHeader::where('order_header_id',$order_header_id)->orderBy('order_header_id','DESC')->first();
        
        $dateNow = Carbon::createFromFormat('Y-m-d H:i:s',$response['order']->delivery_date)->format('Y-m-d');
        $customer_id = $response['order']->customer_id;
        $response['transportOwner'] = DB::table('ptom_transport_owners')
        ->whereRaw("to_date('{$dateNow}', 'YYYY-MM-DD') BETWEEN start_date AND end_date")
        ->first();
        try {
            $response['orderLine'] = [];

            $orderLine = OrderLines::where('order_header_id',$response['order']->order_header_id)->whereNull('promo_flag')->get();
            foreach ($orderLine as $key => $item) {
                $response['orderLine'][$item->item_id] = $item;
            }
        } catch (\Exception $e) {
            $response['orderLine'] = [];
        }

        $response['customer'] = Customer::byCustomerId($customer_id);
        $response['productType'] = OrderRepo::getProcutTypeDomesticLookup($response['order']->product_type_code);
        $response['paymentType'] = OrderRepo::getPaymentTypeLookup($response['order']->payment_type_code);
        $response['paymentMethod'] = OrderRepo::getPaymentMethodLookup($response['order']->payment_method_code);
        $response['shipmentBy'] = OrderRepo::getShipmentLookup($response['order']->transport_type_code);
        $response['overdueDebt'] = [];
        $response['shipSites'] = OrderRepo::shipSites($customer_id);
        $response['period'] = OrderRepo::getPeriodByLineId($response['order']->period_id);
        $response['postponeorders'] = PostponeOrders::where('customer_id', $response['customer']->customer_id)->where('to_period_date', $response['order']->delivery_date)->first();
        $response['promotionProduct'] = OrderRepo::getPromotionProduct($response['order']->order_header_id);

        $response['productList'] = OrderRepo::getProductListTypeCode($customer_id,$response['order']->product_type_code,$response['order']);

        $response['lastOrdersStatus'] = OrderRepo::lastOrdersStatus($response['order']->order_header_id)->order_status;

        $penaltyRate = PenaltyRateDomesticV::where('enabled_flag','Y')->first();
        if(is_null($penaltyRate)){
            $amountPenaltyRate = 0;
        }else{
            $amountPenaltyRate = $penaltyRate->description;
        }

        $daysInYear = Carbon::parse(date('Y'))->daysInYear;

        $response['Outstanding'] = [];

        if($response['lastOrdersStatus'] == 'Draft' || is_null($response['lastOrdersStatus'])){
            $Outstanding = OutstandingDebtDomesticV::where('customer_id',$customer_id)
            ->where('outstanding_debt','>',0)
            ->where('due_date','<=',$response['period']->end_period)
            ->where('pick_release_status','Confirm')
            // ->where('due_date','<=',$response['order']->delivery_date)
            ->get();
            foreach ($Outstanding as $key => $v) {

                try {
                    $delivery_date = OrderHeaders::where('order_header_id', $order_header_id)->first()->delivery_date;
                    if(is_null($delivery_date)){
                        $delivery_date = date('Y-m-d');
                    }
                }catch (\Exception $e) {
                    $delivery_date = date('Y-m-d');
                }

                $improveFines = DB::table('ptom_improve_fines')
                ->where('invoice_number',$v->pick_release_no)
                ->whereRaw("cancel_flag = 'Y'")->orderBy('invoice_number','ASC')->first();

                if(is_null($v->due_date)){
                    $date = date('Y-m-d');
                }else{
                    $date = $v->due_date;
                }

                // var_dump($response['order']->order_header_id);
                // var_dump($v->order_header_id);
                // var_dump($customer_id);
                // var_dump($v->credit_group_code);
                // where('attribute1',$response['order']->order_header_id)->
                $releaseCredit = ReleaseCredit::where('invoice_id',$v->order_header_id)->where('customer_id',$customer_id)->where('credit_group_code',$v->credit_group_code)->first();

                // var_dump($releaseCredit);

                if(is_null($releaseCredit)){

                    // ค่าปรับ
                    $date = Carbon::parse($v->due_date);
                    $now = Carbon::parse(now());

                    if($date >= $now){
                        $diff = 0;
                    }else{
                        $diff = $date->diffInDays($now);
                    }

                    $penalty_day = (($v->outstanding_debt * $amountPenaltyRate) / 100) / $daysInYear;

                    if(is_null($improveFines)){
                        $penalty_total = $penalty_day * $diff;
                    }else{
                        $penalty_total = 0;
                    }

                    // ค่าปรับ
                    $no = ((($v->customer_type_id == 30 || $v->customer_type_id == 40) && $v->product_type_code == 10) ? $v->consignment_no : $v->pick_release_no);
                    $response['Outstanding'][] = [
                        'no'=>$no.'_'.$v->credit_group_code,
                        'pick_release_no'=>$no,
                        'credit_group_code'=>$v->credit_group_code,
                        'description'=>(($v->credit_group_code == 0) ? 'เงินสด' : 'เงินเชื่อกลุ่ม '.$v->credit_group_code),
                        'amount'=>$v->outstanding_debt,
                        'due_days'=>$v->due_date,
                        'auto_check'=>($v->due_date <= $delivery_date) ? true : false,
                        'date_th'=>dateFormatThai($date),
                        'penalty_percen'=>$amountPenaltyRate,
                        'penalty_day'=>$penalty_day,
                        'penalty_total'=>(!is_null($v->pick_release_no) || !is_null($v->consignment_no)) ? number_format((float)(($penalty_total < 0) ? 0 : $penalty_total), 2, '.', '') : 0,
                        'daysInYear'=>$daysInYear,
                        'flag'=>'N'  // ยังไม่ถูก select กับ order ไหน
                    ];
                }else{
                    // ค่าปรับ

                    $date = Carbon::parse($v->due_datedue_date);
                    $now = Carbon::parse($releaseCredit->creation_date);

                    if($date >= $now){
                        $diff = 0;
                    }else{
                        $diff = $date->diffInDays($now);
                    }

                    $penalty_day = (($v->outstanding_debt * $amountPenaltyRate) / 100) / $daysInYear;

                    if(is_null($improveFines)){
                        $penalty_total = $penalty_day * $diff;
                    }else{
                        $penalty_total = 0;
                    }
                    // ค่าปรับ

                    $no = ((($v->customer_type_id == 30 || $v->customer_type_id == 40) && $v->product_type_code == 10) ? $v->consignment_no : $v->pick_release_no);
                    if ($releaseCredit->attribute1 == $response['order']->order_header_id) {
                        $response['Outstanding'][] = [
                            'no'=>$no.'_'.$v->credit_group_code,
                            'pick_release_no'=>$no,
                            'credit_group_code'=>$v->credit_group_code,
                            'description'=>(($v->credit_group_code == 0) ? 'เงินสด' : 'เงินเชื่อกลุ่ม '.$v->credit_group_code),
                            'amount'=>$v->outstanding_debt,
                            'due_days'=>$v->due_days,
                            'auto_check'=>($v->due_date <= $delivery_date) ? true : false,
                            'date_th'=>dateFormatThai($v->due_date),
                            'penalty_percen'=>$amountPenaltyRate,
                            'penalty_day'=>$penalty_day,
                            'penalty_total'=>(!is_null($v->pick_release_no) || !is_null($v->consignment_no)) ? number_format((float)(($penalty_total < 0) ? 0 : $penalty_total), 2, '.', '') : 0,
                            'daysInYear'=>$daysInYear,
                            'flag'=>'Y' // select กับ order นี้
                        ];
                    }else{
                        // if($releaseCredit->payment_flag != 'Y'){
                            $response['Outstanding'][] = [
                                'no'=>$no.'_'.$v->credit_group_code,
                                'pick_release_no'=>$no,
                                'credit_group_code'=>$v->credit_group_code,
                                'description'=>(($v->credit_group_code == 0) ? 'เงินสด' : 'เงินเชื่อกลุ่ม '.$v->credit_group_code),
                                'amount'=>$v->outstanding_debt,
                                'due_days'=>$v->due_days,
                                'auto_check'=>($v->due_date <= $delivery_date) ? true : false,
                                'date_th'=>dateFormatThai($v->due_date),
                                'penalty_percen'=>$amountPenaltyRate,
                                'penalty_day'=>$penalty_day,
                                'penalty_total'=>(!is_null($v->pick_release_no) || !is_null($v->consignment_no)) ? number_format((float)(($penalty_total < 0) ? 0 : $penalty_total), 2, '.', '') : 0,
                                'daysInYear'=>$daysInYear,
                                'flag'=> 'M' // select กับ order อื่นแล้ว
                            ];
                        // }
                    }

                }
            }
        }else{
            $releaseCredit = ReleaseCredit::where('attribute1',$response['order']->order_header_id)->where('customer_id',$customer_id)->where('payment_flag','Y')->get();
            if(!is_null($releaseCredit)){
                foreach ($releaseCredit as $key => $v) {
                    try {
                        $delivery_date = $response['order']->delivery_date;
                        if(is_null($delivery_date)){
                            $delivery_date = date('Y-m-d');
                        }
                    }catch (\Exception $e) {
                        $delivery_date = date('Y-m-d');
                    }
                    // ค่าปรับ

                    $improveFines = DB::table('ptom_improve_fines')
                    ->where('invoice_number',$v->invoice_num)
                    ->whereRaw("cancel_flag = 'Y'")->orderBy('invoice_number','ASC')->first();

                    $date = Carbon::parse($v->due_date);
                    $now = Carbon::parse($v->creation_date);

                    if($date >= $now){
                        $diff = 0;
                    }else{
                        $diff = $date->diffInDays($now);
                    }

                    $penalty_day = (($v->amount * $amountPenaltyRate) / 100) / $daysInYear;

                    if(is_null($improveFines)){
                        $penalty_total = $penalty_day * $diff;
                    }else{
                        $penalty_total = 0;
                    }
                    // ค่าปรับ

                    $response['Outstanding'][] = [
                        'no'=>$v->invoice_num.'_'.$v->credit_group_code,
                        'pick_release_no'=>$v->invoice_num,
                        'credit_group_code'=>$v->credit_group_code,
                        'description'=>(($v->credit_group_code == 0) ? 'เงินสด' : 'เงินเชื่อกลุ่ม '.$v->credit_group_code),
                        'amount'=>$v->amount,
                        'due_days'=>null,
                        'auto_check'=>($v->due_date <= $delivery_date) ? true : false,
                        'date_th'=>dateFormatThai($v->due_date),
                        'penalty_percen'=>$amountPenaltyRate,
                        'penalty_day'=>$penalty_day,
                        'penalty_total'=>(!is_null($v->pick_release_no) || !is_null($v->consignment_no)) ? number_format((float)(($penalty_total < 0) ? 0 : $penalty_total), 2, '.', '') : 0,
                        'daysInYear'=>$daysInYear,
                        'flag'=>'Y'
                    ];
                }
            }
        }
        return response()->json(['data' => $response]);
    }

    public function checkDate(Request $request)
    {
        $customer = Customer::where('customer_id',$request->customer_id)->first();

        // $datePeriod = nextDaysOfWeekNotPlus(compareDaysTH($customer->delivery_date));

        $response = OrderRepo::checkHoliday($customer->delivery_date,0);

        return response()->json(['data' => $response]);
    }

    public function store(Request $request)
    {
        $logs[] = '############ OrderEcomController@store ,'. __LINE__;
        $logs[] = "Request =". json_encode($request->all());
        $orderHeader = new OrderHeader();

        DB::beginTransaction();
        try {
            $customer           = Customer::where('customer_id',$request->customer_id)->first();
            $logs[]             = "customer_id=". $request->customer_id;
            $customer_type_id   = $customer->customer_type_id;

            $shipSite = DB::table('ptom_customer_ship_sites')
                            ->where('customer_id',$request->customer_id)
                            ->whereRaw("lower(status) = 'active'")
                            ->orderBy('site_no','ASC')
                            ->first();

            $product_type = DB::table('ptom_product_type_domestic')
                                ->where('lookup_code',$request->product_type_code)->first();
            $logs[] = "Product type code =". $request->product_type_code;

            $order_type = DB::table('ptom_transaction_types_v')
                            ->where('sales_type','DOMESTIC')
                            ->where('product_type',$product_type->description)
                            ->first();
            $logs[] = "Product description =". $request->description;

            $orderHeader->org_id            = OrderRepo::orgId();
            $orderHeader->order_type_id     = $order_type->order_type_id;

            $orderHeader->customer_id       = $request->customer_id;
            $orderHeader->bill_to_site_id   = $request->customer_id;
            $orderHeader->ship_to_site_id   = $shipSite->ship_to_site_id;
            $orderHeader->currency          = 'THB';
            $orderHeader->source_system     = 'E-commerce';
            $orderHeader->product_type_code = $request->product_type_code;

            if($request->special_case2 == 1){
                $orderHeader->attribute15 = 'Y';
            }

            $periodPostpone = DB::table('ptom_postpone_orders')
                                ->where('from_period_id', $request->period_id)
                                ->where('customer_id', $request->customer_id)
                                ->where('to_period_date', '>=', now()->format('Y-m-d 00:00:00'))
                                ->where('approve_status', 'อนุมัติ')
                                ->whereNull('deleted_at')
                                ->orderBy('postpone_order_id', 'DESC')
                                ->first();

            $logs[] = 'Get periodPostpone '. json_encode($periodPostpone);
            $logs[] = "##### Check !is_null(periodPostpone)" . (!is_null($periodPostpone));

            if ($request->installment_type_code == 20) {
                $orderHeader->delivery_date = $request->delivery_date;
            }elseif (!is_null($periodPostpone)) {
                $orderHeader->delivery_date = $periodPostpone->to_period_date;
            }else{
                $logs[] = "Period set = ". $request->period_set;
                if($request->period_set){
                    $dateCur    = (compareDaysTH($customer->delivery_date));
                    $logs[]     = "Get dateCur=". $dateCur;
                    $period_set = DB::table('ptom_period_v')
                                    ->where('period_line_id',$request->period_id)
                                    ->orderBy('start_period','DESC')
                                    ->first();
                    $response['period_set'] = $period_set;

                    if($dateCur == 0){
                        if($period_set->end_period < date('Y-m-d')){
                            $orderHeader->delivery_date = $period_set->start_period;
                        }else{
                            $deliveryDateCal = OrderRepo::checkHoliday($customer->delivery_date,$request->skip_period);
                            $orderHeader->delivery_date = $deliveryDateCal['date'];
                        }
                    }else{
                        $startTime  = strtotime($period_set->start_period);
                        $endTime    = strtotime($period_set->end_period);

                        // Loop between timestamps, 24 hours at a time
                        for ( $i = $startTime; $i <= $endTime; $i = $i + 86400 ) {
                            if($dateCur == date( 'w', $i )){
                                $orderHeader->delivery_date = date( 'Y-m-d', $i );
                            }
                        }
                    }

                }else{
                    $dateCur = nextDaysOfWeekNotPlus(compareDaysTH($customer->delivery_date));
                    $deliveryDateCal = OrderRepo::checkHoliday($customer->delivery_date,$request->skip_period);
                    $orderHeader->delivery_date = $deliveryDateCal['date'];
                }
            }

            $orderHeader->installment_type_code     = $request->installment_type_code;
            $orderHeader->payment_direct_debit_code = $request->payment_direct_debit_code;
            if ($request->skip_period == 1) {
                $orderHeader->period_id         = $request->period_next_id;
                $orderHeader->skip_peroid_flag  = 'Y';
            }else{
                $orderHeader->period_id = $request->period_id;
            }

            $orderHeader->order_source          = $request->order_source;
            $orderHeader->cust_po_number        = $request->cust_po_number;
            $orderHeader->payment_type_code     = $request->payment_type_code;
            $orderHeader->payment_method_code   = $request->payment_method_code;

            $orderHeader->transport_type_code   = $request->transport_type_code;
            $orderHeader->order_date            = $request->order_date;
            $orderHeader->unlock_print_flag     = 'N';

            $orderHeader->order_status          = '';
            $orderHeader->program_code          = 'OMP0003';
            $orderHeader->created_by            = 1;
            $orderHeader->last_updated_by       = 1;

            $sdate = DB::table('ptom_period_v as pvf')
                        ->where('period_line_id','=', $orderHeader->period_id)
                        ->first(['start_period','end_period']);

            $start_period   = date_format(date_create($sdate->start_period),"Y-m-d");
            $end_period     = date_format(date_create($sdate->end_period),"Y-m-d");

            $checkQuota = DB::table('ptom_customer_quota_headers as cqh')
                            ->join( 'ptom_customer_quota_lines as cql', 
                                    'cql.quota_header_id', '=', 'cqh.quota_header_id')
                            ->where('cqh.start_date','>=',$start_period)
                            ->where('cqh.end_date','<=',$end_period)
                            ->whereRaw("lower(cqh.status) = 'active' ")
                            ->where('cqh.customer_id',$customer->customer_id)->get();
                            $logs = collect($logs)->map(function($i) {
                                return $i. PHP_EOL;
                            });
            if(count($checkQuota) == 0 && $orderHeader->installment_type_code != 20 && $request->product_type_code == 10 ){
                Log::debug($logs->join('#'));
                return response()->json(['status'=>true,'data' =>[],'message'=>'quota_empty']);
            }else{
                $orderHeader->save();
                $logs[] = 'Order Header data'. json_encode($orderHeader);
                $response['order_header_id'] =$orderHeader->getKey();

                OrderRepo::insertOrdersHistoryv2($orderHeader,'Draft');

                DB::commit();
                Log::debug($logs->join('#'));
                return response()->json(['status'=>true,'data' => $response,'message'=>'']);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status'=>false,'data' => [],'message'=>$e->getMessage()]);
        }

    }

    public function test_insert()
    {
        DB::table('oaom.ptom_order_quota_history')->insert([
            'order_header_id'=>1,
            'quota_group_code' => 2,
            'received_quota' => 1000,
            'remaining_quota' => 10000,
            'spending_quota' => 0,
            'program_code' => 'OMP0003',
            'created_by' => 1,
            'CREATION_DATE' => now(),
            'LAST_UPDATE_DATE'=> now(),
            'last_updated_by' => 1
        ]);
    }

    public function updateSpecial(Request $request)
    {
        DB::beginTransaction();
        try {
            $orderHeader = OrderHeader::where('order_header_id',$request->order_header_id)->orderBy('order_header_id','DESC')->first();
            $orderHeader->cust_po_number = $request->cust_po_number;

            $orderHeader->ship_to_site_id = $request->ship_to_site_id;

            $orderHeader->cash_amount = $request->cash_amount;
            $orderHeader->credit_amount = 0;
            $orderHeader->grand_total = $request->grand_total;
            $orderHeader->remark = $request->remark;

            $response = [];

            $response['order_number'] = '';
            if(is_null($orderHeader->order_number)){
                if ($orderHeader->product_type_code == 10) {
                    $orderNumber = GenerateNumberRepo::docSequenceNumber('OMP0003_PO_NUM_CG_DOM','order_number');
                }else if($orderHeader->product_type_code == 20){
                    $orderNumber = GenerateNumberRepo::docSequenceNumber('OMP0003_PO_NUM_L_DOM','order_number');
                }else{
                    $orderNumber = GenerateNumberRepo::docSequenceNumber('OMP0003_PO_NUM_O_DOM','order_number');
                }

                $orderHeader->order_number = $orderNumber;
                $response['order_number'] = $orderNumber;
            }else{
                $response['order_number'] = $orderHeader->order_number;
            }

            $fines_amount = 0;
            $customer_id = $orderHeader->customer_id;

            $customer = Customer::byCustomerId($customer_id);

            $orderHeader->remaining_amount = OrderRepo::sumNotMatch($customer_id);

            $orderHeader->price_list_id = $customer->price_list_id;

            $diff = false;
            $checked_product = $request->checked_product;
            $response['diff'] = false;

            $runLine = 1;
            $tax_amount = 0;

            $dateToday = $orderHeader->delivery_date? date('Y-m-d', strtotime($orderHeader->delivery_date)): date('Y-m-d');
            $fromHeaderOrder = FormOrderHeader::where('customer_id',$customer_id)
                                            ->where('approve_status','อนุมัติ')
                                            // ->where('to_period_date',date('Y-m-d'))
                                            ->whereRaw("trunc(to_period_date) = to_date('{$dateToday}', 'YYYY-MM-DD')")
                                            ->where('form_type','SPECIAL')
                                            ->first();

            if(!is_null($fromHeaderOrder)){
                $formLineOrder = OrderRepo::getCustomerSpecialHeaders($customer_id,$orderHeader,$fromHeaderOrder);

                foreach($formLineOrder as $val){
                    if(in_array($val->item_id,$checked_product)){

                        $orderLine = OrderLines::where('order_header_id',$orderHeader->order_header_id)->whereNull('promo_flag')->where('item_id',$val->item_id)->first();

                        if (!isset($orderLine) || empty($orderLine)) {
                            $orderLine = new OrderLines();
                        }

                        $order_cardboardbox = $request->items['chest_amount'][$val->item_id];
                        $order_carton = $request->items['wrap_amount'][$val->item_id];
                        $order_quantity = $request->items['order_quantity'][$val->item_id];
                        $max_amount = $request->items['max_amount'][$val->item_id];
                        $sum_amount = $request->items['sum_amount'][$val->item_id];
                        $total_amount = $request->items['sum_amount'][$val->item_id];

                        $orderLine->order_header_id = $orderHeader->order_header_id;
                        $orderLine->line_number = $runLine;
                        $orderLine->quota_line_id = 0;
                        $orderLine->item_id = $val->item_id;
                        $orderLine->item_code = $val->item_code;
                        $orderLine->item_description = $val->item_description;
                        $orderLine->unit_price = $request->items['unit_price'][$val->item_id];
                        $orderLine->uom_code = 'CGK';
                        $orderLine->uom = 'พันมวน';
                        $orderLine->quota_credit_id = 0;
                        $orderLine->order_quantity = $order_quantity;
                        $orderLine->left_quantity = $order_quantity;


                        $orderLine->diff_quantity = 0;
                        $orderLine->order_cardboardbox = $order_cardboardbox;
                        $orderLine->order_carton = $order_carton;

                        // day amount
                        $dayAmountRepo = OrderRepo::setTermDayAmount($orderHeader,$customer,0);

                        $orderLine->day_amount = $dayAmountRepo['day_amount'];
                        $orderLine->credit_group_code = $dayAmountRepo['credit_group_code'];
                        // day amount

                        $tax = 0;
                        if(!is_null($orderHeader->order_type_id)){
                            $calTax = OrderRepo::calTaxDomestic($orderLine->order_quantity,$orderLine->item_id,$orderHeader->order_type_id,$orderHeader->customer_id);
                            $orderLine->tax_amount = number_format((float)$calTax['amount'], 5, '.', '');
                            $orderLine->attribute1 = $calTax['operand'];
                            $tax_amount += $calTax['amount'];
                        }else{
                            if(!is_null($customer->order_type_id)){
                                $calTax = OrderRepo::calTaxDomestic($orderLine->order_quantity,$orderLine->item_id,$customer->order_type_id,$orderHeader->customer_id);
                                $orderLine->tax_amount = number_format((float)$calTax['amount'], 5, '.', '');
                                $orderLine->attribute1 = $calTax['operand'];
                                $tax_amount += $calTax['amount'];
                            }
                        }

                        $orderLine->amount = $sum_amount;
                        // $orderLine->total_amount = $total_amount + $tax;
                        $orderLine->total_amount = $total_amount;
                        $orderLine->program_code = 'OMP0003';
                        $orderLine->created_by = 1;
                        $orderLine->last_updated_by = 1;

                        $orderLine->save();

                        $formOrderLine = FormOrderLine::where('form_header_id',$fromHeaderOrder->form_header_id)->where('item_code',$val->item_code)->first();
                        $formOrderLine->approve_quantity = $order_cardboardbox;
                        $formOrderLine->attribute2 = $order_carton;
                        $formOrderLine->save();

                        $runLine += 1;

                        if ($request->status == 'Confirm' && $request->over_order != 'over') {

                            OrderRepo::amountCreditGroupCash(
                                $orderHeader->order_header_id,
                                $orderLine->getKey(),
                                $total_amount,
                                'OMP0003'
                            );
                        }


                    }else{
                        if (isset($orderLine) && !empty($orderLine)) {
                            $orderLine->delete();
                        }
                    }
                }

                ############### start create order credit line id 0
                // get order line credit group
                $creditGroups = OrderLines::where('order_header_id',$orderHeader->order_header_id)->whereNull('promo_flag')->select('credit_group_code')
                ->groupBy('credit_group_code')
                ->get()
                ->toArray();

                // tempdata 
                $tempOrderCreditGroups = collect(DB::table('ptom_order_credit_groups')->where('order_header_id',$orderHeader->order_header_id)->get());
                foreach($creditGroups as $creditGroup) :
                    $item = $tempOrderCreditGroups->where('credit_group_code', $creditGroup['credit_group_code']);
                     $objOrderCreditLine = [
                        'order_line_id'=> 0,
                        'order_header_id'=> $orderHeader->order_header_id,
                        'credit_group_code'=> $creditGroup['credit_group_code'],
                        'program_code'=> $item->first()->program_code,
                        'created_by'=> $item->first()->created_by,
                        'creation_date'=> $item->first()->creation_date,
                        'last_updated_by'=> $item->first()->last_updated_by,
                        'last_update_date'=> $item->first()->last_update_date,
                        'amount'=> $item->sum('amount'),
                        'period_id'=> $item->first()->period_id,
                        'received_amount'=> 0,
                        'remaining_amount'=> 0,
                    ];
                    $orderCreditLine = DB::table('ptom_order_credit_groups')->where('order_header_id',$orderHeader->order_header_id)->where('order_line_id', 0)->first();

                    if (!isset($orderCreditLine) || empty($orderCreditLine)) {
                        DB::table('ptom_order_credit_groups')->insert($objOrderCreditLine);
                    }


                    DB::table('ptom_order_credit_groups')->where('order_header_id',$orderHeader->order_header_id)->where('order_line_id', 0)->update($objOrderCreditLine);
                endforeach;

               
                
                ############### end create order credit line id 0.
            }

            if ($request->status == 'Confirm') {
                if(is_null($orderHeader->prepare_order_number)){
                    if ($orderHeader->product_type_code == 10) {
                        $prepareNumber = GenerateNumberRepo::docSequenceNumber('OMP0019_SO_NUM_CG_DOM','prepare_order_number');
                    }else if($orderHeader->product_type_code == 20){
                        $prepareNumber = GenerateNumberRepo::docSequenceNumber('OMP0019_SO_NUM_L_DOM','prepare_order_number');
                    }else{
                        $prepareNumber = GenerateNumberRepo::docSequenceNumber('OMP0019_SO_NUM_O_DOM','prepare_order_number');
                    }

                    $orderHeader->prepare_order_number = $prepareNumber;
                    $orderHeader->order_status = 'Draft';
                }
            }

            OrderRepo::insertOrdersHistoryv2($orderHeader,'Release');


            $orderHeader->tax = number_format((float)$tax_amount, 2, '.', '');
            $orderHeader->sub_total = $request->grand_total - number_format((float)$tax_amount, 2, '.', '');
            // $orderHeader->fines_amount = $fines_amount;
            $orderHeader->fines_amount = number_format((float)$request->fines_amount, 2, '.', '');
            $orderHeader->save();
            // OrderRepo::insertOrdersHistory($orderHeader);

            DB::commit();

            return response()->json(['status'=>true,'data' =>$response,'message'=>'']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status'=>false,'data' => [],'message'=>$e->getMessage()]);
        }
    }

    public function update(Request $request)
    {
        $logs[] = '########### function OrderEcomController@update';
        $logs[] = "Request =". json_encode($request->all());

        DB::beginTransaction();
        try {
            $logs[] = 'Get order header id ='. $request->order_header_id;
            $orderHeader = OrderHeader::where('order_header_id',$request->order_header_id)->orderBy('order_header_id','DESC')->first();
            $orderHeader->cust_po_number = $request->cust_po_number;
            $orderHeader->attribute6 = $request->attribute6;
            $response = [];
            $response['order_number'] = '';
            
            $logs[] = 'check order number is_null | order_number ='. $orderHeader->order_number. ' , product_type_code = '. $orderHeader->product_type_code;
            if(is_null($orderHeader->order_number)){
                if ($orderHeader->product_type_code == 10) {
                    $orderNumber = GenerateNumberRepo::docSequenceNumber('OMP0003_PO_NUM_CG_DOM','order_number');
                }else if($orderHeader->product_type_code == 20){
                    $orderNumber = GenerateNumberRepo::docSequenceNumber('OMP0003_PO_NUM_L_DOM','order_number');
                }else{
                    $orderNumber = GenerateNumberRepo::docSequenceNumber('OMP0003_PO_NUM_O_DOM','order_number');
                }

                $orderHeader->order_number = $orderNumber;
                $response['order_number'] = $orderNumber;
            }else{
                $response['order_number'] = $orderHeader->order_number;
            }
            if(!empty($request->delivery_date)) {
                $orderHeader->delivery_date = Carbon::createFromFormat('Y-m-d', $request->delivery_date);
            }
            $orderHeader->ship_to_site_id = $request->ship_to_site_id;

            $cash = 0;
            $logs[] = 'check payment type code = '. $orderHeader->payment_type_code;
            if($orderHeader->payment_type_code == 10){
                $orderHeader->cash_amount = $request->grand_total;
                $cash = $request->grand_total;
            }else{
                $orderHeader->cash_amount = $request->cash_amount;
                $cash = $request->cash_amount;
            }

            $orderHeader->credit_amount = $request->credit_amount;
            $orderHeader->grand_total = $request->grand_total;
            $orderHeader->remark = $request->remark;



            $fines_amount = 0;
            $customer_id = $orderHeader->customer_id;
            $logs[] = 'get infomation customer data id='. $customer_id;
            $customer = Customer::byCustomerId($customer_id);

            $orderHeader->remaining_amount = OrderRepo::sumNotMatch($customer_id);
            $logs[] = 'call function OrderRepo::sumNotMatch value is '. $orderHeader->remaining_amount ;

            $customer_type_id = $customer->customer_type_id;
            $logs[] = 'customer_type_id='. $customer_type_id;
            try {
                
                $logs[] = 'loop outstanding_rm count = ';
                foreach ($request->outstanding_rm as $key => $val) {
                    if(!is_null($val)){
                        $exp = explode('_',$val);

                        $outstandingData = OutstandingDebtDomesticV::where('pick_release_no',$exp[0])->where('credit_group_code',$exp[1])->where('pick_release_status','Confirm')->first();

                        $release = ReleaseCredit::where('attribute1',$orderHeader->order_header_id)->where('customer_id',$customer->customer_id)->where('invoice_id',$outstandingData->order_header_id)->where('credit_group_code',$exp[1])->first();

                        if(!is_null($release)){
                            $customerContractGroups = CustomerContractGroups::where('credit_group_code',$release->credit_group_code)->where('customer_id',$customer->customer_id)->whereNull('deleted_at')->first();
                            $remaining_amount = $customerContractGroups->remaining_amount - $release->amount;
                            
                            $logs[] = 'table ptom_customer_contract_groups WHEREcredit_group_code='. $outstandingData->credit_group_code. ", customer_id=". $customer->customer_id. ' update remaining_amount= '. (($remaining_amount < 0) ? 0 : $remaining_amount);
                            if ($request->status == 'Confirm'){
                                DB::table('ptom_customer_contract_groups')
                                ->where('credit_group_code',$outstandingData->credit_group_code)
                                ->where('customer_id',$customer->customer_id)
                                ->whereNull('deleted_at')
                                ->update(array(
                                    'remaining_amount'=>(($remaining_amount < 0) ? 0 : $remaining_amount),
                                ));
                            }

                            $release->delete();
                        }

                    }
                }

                $amountRelease = [];
                $contractGroups = OrderRepo::getCustomerContractGroups($customer_id);
                $logs[] = 'call OrderRepo@getCustomerContractGroups count' . count($contractGroups);
                if(count($contractGroups) > 0 && $orderHeader->payment_type_code != 10){
                    foreach($contractGroups as $val){
                        $amountRelease[$val->credit_group_code] = 0;
                    }
                }


                $logs[] = "Loop request->outstanding_id ". count($request->outstanding_id);
                foreach ($request->outstanding_id as $key => $val) {
                    if(!is_null($val)){
                        $exp = explode('_',$val);

                        $outstandingData = OutstandingDebtDomesticV::where(function($query) use ($exp){
                            $query->where('pick_release_no',$exp[0]);
                            $query->orWhere('consignment_no',$exp[0]);
                        })->where('credit_group_code',$exp[1])->where('pick_release_status','Confirm')->first();
                        $logs[] = "Checkoutstanding data credit group code != 0";
                        if($outstandingData->credit_group_code != 0){
                            $releaseCredit = ReleaseCredit::where('customer_id',$customer->customer_id)->where('invoice_id',$outstandingData->order_header_id)->where('credit_group_code',$exp[1])->first();
                            if(is_null($releaseCredit)){
                                $releaseCredit = new ReleaseCredit();
                            }else{
                                if(!is_null($outstandingData->attribute1)){
                                    $releaseCredit = new ReleaseCredit();
                                }
                            }

                            $releaseCredit->customer_id = $customer->customer_id;
                            $releaseCredit->attribute1 = $orderHeader->order_header_id;
                            $releaseCredit->invoice_id = $outstandingData->order_header_id;
                            $releaseCredit->invoice_num = $outstandingData->pick_release_no;
                            $releaseCredit->due_date = $outstandingData->due_date;
                            $releaseCredit->amount = $outstandingData->outstanding_debt;
                            $releaseCredit->credit_group_code = $outstandingData->credit_group_code;
                            $releaseCredit->charge_amount = 0.00;
                            if ($request->status == 'Confirm'){
                                $releaseCredit->payment_flag = 'Y';
                            }
                            $releaseCredit->created_by = 1;
                            $releaseCredit->last_updated_by = 1;
                            $releaseCredit->program_code = 'OMP0003';
                            $releaseCredit->save();
                            $logs[] = "Check Request status = Confirm |". $request->status;
                            if ($request->status == 'Confirm'){

                                $customerContractGroups = CustomerContractGroups::where('credit_group_code',$outstandingData->credit_group_code)->where('customer_id',$customer->customer_id)->whereNull('deleted_at')->first();
                                $logs[] = 'Get customer contract groups ='. json_encode($customerContractGroups);
                                $remaining_amount = $customerContractGroups->remaining_amount + $outstandingData->outstanding_debt;
                                if($remaining_amount > $customerContractGroups->credit_amount){
                                    $remaining_amount = $customerContractGroups->credit_amount;
                                }

                                $logs[] = "Update ptom_customer_contract_groups @ remaining_amount= ".(($remaining_amount < 0) ? 0 : $remaining_amount);
                                DB::table('ptom_customer_contract_groups')
                                ->where('credit_group_code',$outstandingData->credit_group_code)
                                ->where('customer_id',$customer->customer_id)
                                ->whereNull('deleted_at')
                                ->update(array(
                                    'remaining_amount'=>(($remaining_amount < 0) ? 0 : $remaining_amount),
                                ));
                            }
                        }

                        // $amountRelease[$outstandingData->credit_group_code] += $outstandingData->outstanding_debt;
                        $fines_amount += $outstandingData->outstanding_debt;

                    }
                }
            }catch (\Exception $e) {
                $logs[] = "Error Message =". $e->getMessage() . " Line" . $e->getLine();
                $amountRelease = [];
                $contractGroups = OrderRepo::getCustomerContractGroups($customer_id);
                if(count($contractGroups) > 0 && $orderHeader->payment_type_code != 10){
                    foreach($contractGroups as $val){
                        $amountRelease[$val->credit_group_code] = 0;
                    }
                }
            }

            $orderHeader->price_list_id = $customer->price_list_id;

            $periodPostpone = DB::table('ptom_postpone_orders')
            ->where('from_period_id', $orderHeader->period_id)
            ->where('customer_id', $orderHeader->customer_id)
            ->where('approve_status', 'อนุมัติ')
            ->whereNull('deleted_at')
            ->first();
            if($periodPostpone) {
                // check เลื่อนวันซ้อน
                $periodPostponeStep2 = DB::table('ptom_postpone_orders')
                ->where('to_period_date', Carbon::createFromFormat('Y-m-d H:i:s',$periodPostpone->from_period_date)->format('Y-m-d'))
                ->where('customer_id', $orderHeader->customer_id)
                ->where('approve_status', 'อนุมัติ')
                ->whereNull('deleted_at')
                ->orderBy('postpone_order_id', 'DESC')
                ->first();
                if($periodPostponeStep2) {
                    $periodPostpone = $periodPostponeStep2;
                }
            }
            $logs[] = 'Get PedriodPostpon '. json_encode($periodPostpone);
            $logs[] = 'Check customer type = 20';
            if($customer_type_id == 20){
                $logs[] = '- Condition is true';
                $logs[] = 'Check periodPostpone is_null';
                if(is_null($periodPostpone)){
                    $logs[] = '- Condition is true';
                    $contractQuata = OrderRepo::getCustomerQuotaHeadersMT($customer_id,$orderHeader);
                }else{
                    $logs[] = '- Condition is false';
                    $contractQuata = OrderRepo::getCustomerQuotaHeadersByPeriodMT($customer_id,$periodPostpone);
                }
            }else{
                $logs[] = '- Condition is false';
                $logs[] = 'Check periodPostpone is_null';
                if(is_null($periodPostpone)){
                    $logs[] = '- Condition is true';
                    $contractQuata = OrderRepo::getCustomerQuotaHeaders($customer_id,$orderHeader);
                }else{
                    $logs[] = '- Condition is false';
                    $contractQuata = OrderRepo::getCustomerQuotaHeadersByPeriod($customer_id,$periodPostpone);
                }
            }
            $logs[] = 'Get contract Quata' . json_encode($contractQuata);

            $diff = false;
            $checked_product = $request->checked_product;
            $response['diff'] = false;
            $creditAmount = [];

            $contractGroups = OrderRepo::getCustomerContractGroups($customer_id);
            $logs[] = 'Get contract Group' . json_encode($contractGroups);
            $logs[] = 'Check count contract Group > 0 AND paymeny_type_code != 10' ;
            if(count($contractGroups) > 0 && $orderHeader->payment_type_code != 10){
                $creditGroupsRemaining = [];
                $creditGroups = [];

                $logs[] = 'Loop contractGroups '. count($contractGroups);
                foreach($contractGroups as $val){
                    $creditGroupsRemaining[$val->credit_group_code] = $val->remaining_amount;
                    $creditGroups[$val->credit_group_code] = $val;

                    $orderCredit = OrderCreditGroup::where('order_header_id',$orderHeader->order_header_id)->where('order_line_id',0)->where('credit_group_code',$val->credit_group_code)->first();
                    $logs[] = 'Get orderCredit'. json_encode($orderCredit);

                    $logs[] = "Check request status". $request->status;
                    if ($request->status == 'Confirm'){
                        CreditAndQuotaRepo::setOrderCredit($orderCredit,$orderHeader,$val,'OMP0003',0);
                        $logs[] = "Set order credit " . json_encode([$val, 'OMP0003', '0']);
                    }else{
                        // CreditAndQuotaRepo::setOrderCredit($orderCredit,$orderHeader,$val,'OMP0003',$amountRelease[$val->credit_group_code]);
                    }

                    $creditAmount[$val->credit_group_code] = 0;
                }
                $logs[] = "request cash_amount > 0 | " . $request->cash_amount;
                if($request->cash_amount > 0){
                    $orderCredit = OrderCreditGroup::where('order_header_id',$orderHeader->order_header_id)->where('order_line_id',0)->where('credit_group_code',0)->first();
                    $logs[] = "Get order creite ". json_encode($orderCredit);

                    if ($request->status == 'Confirm'){
                        CreditAndQuotaRepo::setOrderCash($orderCredit,$orderHeader,$request->cash_amount,'OMP0003');
                        $logs[] = "CreditAndQuotaRepo@setOrderCash". json_encode([$request->cash_amount, 'OMP0003']);
                    }

                }
            }else{
                $orderCredit = OrderCreditGroup::where('order_header_id',$orderHeader->order_header_id)->where('order_line_id',0)->where('credit_group_code',0)->first();
                $logs[] = "Get order creite ". json_encode($orderCredit);
                if ($request->status == 'Confirm'){
                    CreditAndQuotaRepo::setOrderCash($orderCredit,$orderHeader,0,'OMP0003');
                    $logs[] = "CreditAndQuotaRepo@setOrderCash". json_encode(['0', 'OMP0003']);
                }

                $creditAmount[0] = 0;
            }

            $runLine = 1;
            $tax_amount = 0;


            $logs[] = 'Loop contractQuata '. __Line__;
            foreach($contractQuata as $val){
                $overQuota[$val['group']->lookup_code] = 0;

                $logs[] = 'Get order quata history ,Line:'. __Line__ . ',Lookup_code = '. $val['group']->lookup_code;
                $orderQuota = OrderQuotaHistory::where('order_header_id',$orderHeader->order_header_id)->where('quota_group_code', $val['group']->lookup_code)->first();

                CreditAndQuotaRepo::setCustomerQuota($orderHeader,$val);

                $spending_quota = 0;

                // $orderQuota->save();

                foreach ($val['quota'] as $quota){
                    
                    $logs[] = 'Loop val quota , Line:'. __Line__. ", Quota itemm_id :". $quota->item_id;
                    $orderLine = OrderLines::where('order_header_id',$orderHeader->order_header_id)->whereNull('promo_flag')->where('item_id',$quota->item_id)->first();

                    if(in_array($quota->item_id,$checked_product)){

                        if (!isset($orderLine) || empty($orderLine)) {
                            $orderLine = new OrderLines();
                        }

                        $order_cardboardbox = $request->items['chest_amount'][$val['group']->lookup_code][$quota->quota_line_id][$quota->item_id];
                        $order_carton = $request->items['wrap_amount'][$val['group']->lookup_code][$quota->quota_line_id][$quota->item_id];
                        $order_quantity = $request->items['order_quantity'][$val['group']->lookup_code][$quota->quota_line_id][$quota->item_id];
                        $max_amount = $request->items['max_amount'][$val['group']->lookup_code][$quota->quota_line_id][$quota->item_id];
                        $sum_amount = $request->items['sum_amount'][$val['group']->lookup_code][$quota->quota_line_id][$quota->item_id];
                        $total_amount = $request->items['sum_amount'][$val['group']->lookup_code][$quota->quota_line_id][$quota->item_id];

                        $overQuota[$val['group']->lookup_code] += $order_quantity;

                        $orderLine->order_header_id = $orderHeader->order_header_id;
                        $orderLine->line_number = $runLine;
                        $orderLine->quota_line_id = $quota->quota_line_id;
                        $orderLine->item_id = $quota->item_id;
                        $orderLine->item_code = $quota->item_code;
                        $orderLine->item_description = $quota->item_description;
                        $orderLine->attribute2 = $quota->price_unit;
                        $orderLine->unit_price = $request->items['unit_price'][$val['group']->lookup_code][$quota->quota_line_id][$quota->item_id];
                        $orderLine->uom_code = 'CGK';
                        $orderLine->uom = 'พันมวน';
                        $orderLine->quota_credit_id = $quota->quota_credit_id;
                        $orderLine->order_quantity = $order_quantity;
                        $orderLine->left_quantity = $order_quantity;
                        $orderLine->diff_quantity = 0;
                        $orderLine->order_cardboardbox = $order_cardboardbox;
                        $orderLine->order_carton = $order_carton;

                        // day amount
                        $dayAmountRepo = OrderRepo::setTermDayAmount($orderHeader,$customer,$quota->credit_group_code);
                        $logs[] = "OrderRepo::setTermDayAmount , Line=". __LINE__. ", credit group=". $quota->credit_group_code;

                        $orderLine->day_amount = $dayAmountRepo['day_amount'];
                        if($orderHeader->payment_type_code == 10){
                            $orderLine->credit_group_code = 0;
                        }else{
                            $orderLine->credit_group_code = $dayAmountRepo['credit_group_code'];
                        }

                        // day amount

                        $spending_quota += $order_quantity;

                        try {
                            // if (isset($request->promotion) && isset($request->promotion[$quota->item_id])) {
                            //     $promotion = explode('_',$request->promotion[$quota->item_id]);
                            //     $orderLine->promotion_id = $promotion[1];
                            //     $orderLine->promotion_product_id = $promotion[2];
                            // }
                        } catch (\Exception $e) {}

                        $tax = 0;
                        if(!is_null($orderHeader->order_type_id)){
                            $calTax = OrderRepo::calTaxDomestic($orderLine->order_quantity,$orderLine->item_id,$orderHeader->order_type_id,$orderHeader->customer_id);
                            $orderLine->tax_amount = number_format((float)$calTax['amount'], 5, '.', '');
                            $orderLine->attribute1 = $calTax['operand'];
                            $tax_amount += $calTax['amount'];
                        }else{
                            if(!is_null($customer->order_type_id)){
                                $calTax = OrderRepo::calTaxDomestic($orderLine->order_quantity,$orderLine->item_id,$customer->order_type_id,$orderHeader->customer_id);
                                $orderLine->tax_amount = number_format((float)$calTax['amount'], 5, '.', '');
                                $orderLine->attribute1 = $calTax['operand'];
                                $tax_amount += $calTax['amount'];
                            }
                        }

                        $orderLine->amount = $sum_amount;
                        $orderLine->total_amount = $total_amount;
                        $orderLine->program_code = 'OMP0003';
                        $orderLine->created_by = 1;
                        $orderLine->last_updated_by = 1;

                        $orderLine->save();

                        $runLine += 1;

                        try {
                            if(count($contractGroups) > 0 && $orderHeader->payment_type_code != 10){
                                $creditAmount[$quota->credit_group_code] += $total_amount;
                            }else{
                                $creditAmount[0] += $total_amount;
                            }
                        } catch (\Exception $e) {}

                        $logs[] = '### Check request status Confirm and over_order Over';
                        if ($request->status == 'Confirm' && $request->over_order != 'over') {
                            $logs[] = "#Check is null order prepare_order_number". (is_null($orderHeader->prepare_order_number));
                            if (is_null($orderHeader->prepare_order_number)) {
                                $logs[] = "#Check product_type_code = 10 ro 20 |". $orderHeader->product_type_code;
                                if ($orderHeader->product_type_code == 10) {
                                    $prepareNumber = GenerateNumberRepo::docSequenceNumber('OMP0019_SO_NUM_CG_DOM','prepare_order_number');
                                }else if($orderHeader->product_type_code == 20){
                                    $prepareNumber = GenerateNumberRepo::docSequenceNumber('OMP0019_SO_NUM_L_DOM','prepare_order_number');
                                }else{
                                    $prepareNumber = GenerateNumberRepo::docSequenceNumber('OMP0019_SO_NUM_O_DOM','prepare_order_number');
                                }
                                // $response['creditGroupsRemaining'][] = $creditGroupsRemaining;
                                $orderHeader->prepare_order_number = $prepareNumber;
                                $logs[] = 'Prepare_order_number = '. $prepareNumber;
                            }


                            // order_credit_groups
                            $logs[] = "#### Check credit_amount and cash or credit_group_code = 0 |". (($request->credit_amount == 0 && $cash != 0) || $quota->credit_group_code == 0);
                            if(($request->credit_amount == 0 && $cash != 0) || $quota->credit_group_code == 0){
                                OrderRepo::amountCreditGroupCash(
                                    $orderHeader->order_header_id,
                                    $orderLine->getKey(),
                                    $total_amount,
                                    'OMP0003'
                                );
                            }else{
                                OrderRepo::amountCreditGroupv2(
                                    $orderHeader->order_header_id,
                                    $orderLine->getKey(),
                                    $creditGroupsRemaining,
                                    $quota,
                                    $creditGroups,
                                    $total_amount,
                                    'OMP0003'
                                );

                                $creditGroupsRemaining[$quota->credit_group_code] -= $total_amount;
                                if($creditGroupsRemaining[$quota->credit_group_code] < 0){
                                    $creditGroupsRemaining[$quota->credit_group_code] = 0;
                                }
                            }

                            // $response['creditGroupsRemainingBB'][] = $creditGroupsRemaining;
                            // order_credit_groups
                        }


                    }else{
                        if (isset($orderLine) && !empty($orderLine)) {
                            $orderLine->delete();
                        }
                    }
                }

                if($orderHeader->installment_type_code == 10){
                    $orderQuota = OrderQuotaHistory::where('order_header_id',$orderHeader->order_header_id)->where('quota_group_code',$val['group']->lookup_code)->first();
                    $orderQuota->spending_quota = $spending_quota;
                    $orderQuota->save();
                }


                if($overQuota[$val['group']->lookup_code] > $val['remaining_quota']){
                    $response['diff'] = true;
                }else{
                   
                }
            }
            if($response['diff'] === false) {
                if ($request->status == 'Confirm' && $request->over_order != 'over') {

                    if($orderHeader->installment_type_code == 10){
                        foreach($contractQuata as $val){
                            foreach ($val['quota'] as $quota){
                                if(in_array($quota->item_id,$checked_product)){
                                    $order_quantity = $request->items['order_quantity'][$val['group']->lookup_code][$quota->quota_line_id][$quota->item_id];
                                    $remaining_quota = $quota->remaining_quota - $order_quantity;
                                    CustomerQuotaLines::where('quota_header_id',$quota->quota_header_id)
                                    ->where('quota_line_id',$quota->quota_line_id)
                                    ->where('item_id',$quota->item_id)
                                    ->whereNull('deleted_at')
                                    ->update(array(
                                        'remaining_quota'=>$remaining_quota,
                                    ));

                                }
                            }

                        }
                    }

                }
            }

            if(isset($request->promotion)){
                
                OrderLines::where('order_header_id',$orderHeader->order_header_id)->where('promo_flag','Y')->whereNotNull('promotion_product_id')->delete();
                foreach ($request->promotion as $key => $v) {

                        $promotionProduct = DB::table('ptom_promotion_product')
                            ->where('promotion_product_id',$key)
                            // ->where('support_group',$request->promotion_support_group[$v])
                            ->first();

                        if(!is_null($promotionProduct)){

                            $orderPromotion = OrderLines::where('order_header_id',$orderHeader->order_header_id)->where('promotion_product_id',$key)->first();
                            if (!isset($orderPromotion) || empty($orderPromotion)) {
                                $orderPromotion = new OrderLines();
                            }

                            $orderPromotion->order_header_id = $orderHeader->order_header_id;
                            $orderPromotion->promotion_id = $promotionProduct->promotion_id;
                            $orderPromotion->promotion_product_id = $promotionProduct->promotion_product_id;
                            $orderPromotion->promo_flag = 'Y';
                            $orderPromotion->line_number = $runLine;
                            $orderPromotion->quota_line_id = 0;
                            $orderPromotion->unit_price = 0;
                            $orderPromotion->item_id = $promotionProduct->item_id;
                            $orderPromotion->item_code = $promotionProduct->item_code;
                            $orderPromotion->item_description = $promotionProduct->item_description;
                            $orderPromotion->total_amount = 0;

                            // keep promotion by type
                            $promotionCheckTypeProduct = DB::table('ptom_sequence_ecoms')->where('item_code', $promotionProduct->item_code)->first();
                            $promotion_object = [];
                            foreach($request->promotion as $prodItemId => $item) {
                                $promotion_object[] = ['promotion_id' => $item, 'amount' => $request->promotion_amount[$prodItemId], 'product_id' => $prodItemId, 'promotion_group' => $request->promotion_group[$prodItemId]];
                            }
                            $promotion_object = collect($promotion_object);
                            $targetItem = $promotion_object->where('product_id', $key)->first();
                            
                            if($promotionCheckTypeProduct->product_type_code == 10){
                                $checkDuplicat = $promotion_object->where('promotion_id', $targetItem['promotion_id'])->where('promotion_group', $targetItem['promotion_group']);
                                if(count($checkDuplicat) > 1) {
                                    $targetPromoAmount = $checkDuplicat->first()['amount'];
                                } else {
                                    $targetPromoAmount = $targetItem['amount'];
                                }
                                if($promotionProduct->promotion_uom == 'CG2'){
                                    $carton = $promotionProduct->promotion_quantity * $targetPromoAmount;
                                    $orderPromotion->order_quantity = $carton * 0.2;
                                    $orderPromotion->approve_quantity = $carton * 0.2;
                                }elseif($promotionProduct->promotion_uom == 'CGC'){
                                    $cardboardbox = $promotionProduct->promotion_quantity * $targetPromoAmount;
                                    $orderPromotion->order_quantity = $cardboardbox / 0.1;
                                    $orderPromotion->approve_quantity = $cardboardbox / 0.1;
                                }else{
                                    $quantity = $promotionProduct->promotion_quantity * $targetPromoAmount;
                                    $orderPromotion->order_quantity = $quantity;
                                    $orderPromotion->approve_quantity = $quantity;
                                }
                                $orderPromotion->uom_code = 'CGK';
                                $orderPromotion->uom = 'พันมวน';
                                
                                $convertCGK = OrderRepo::convertCGK($orderPromotion->order_quantity);

                                $orderPromotion->order_cardboardbox = $convertCGK['cardboardbox'];
                                $orderPromotion->approve_cardboardbox = $convertCGK['cardboardbox'];
                                $orderPromotion->order_carton = $convertCGK['carton'];
                                $orderPromotion->approve_carton = $convertCGK['carton'];

                            }else{

                                $uomData = DB::table('ptom_uom_conversions_v')
                                ->where('uom_code','=', $promotionProduct->promotion_uom)
                                ->where('domestic','Y')
                                ->first();

                                $uomDataCB = DB::table('ptom_uom_v')
                                ->where('uom_code','=', $promotionProduct->promotion_uom)
                                ->where('domestic','Y')
                                ->where('name_for_report_exp','CARDBOARD BOXES')
                                ->first();

                                if(!is_null($uomDataCB)){
                                    $orderPromotion->order_cardboardbox = $targetItem['amount'] * $promotionProduct->promotion_quantity;
                                    $orderPromotion->approve_cardboardbox = $targetItem['amount'] * $promotionProduct->promotion_quantity;
                                }

                                $uomDataCAR = DB::table('ptom_uom_v')
                                ->where('uom_code','=', $promotionProduct->promotion_uom)
                                ->where('domestic','Y')
                                ->where('name_for_report_exp','CARTONS')
                                ->where('base_uom_carton_l','Y')
                                ->first();

                                if(!is_null($uomDataCAR)){
                                    $orderPromotion->order_carton = $targetItem['amount'] * $promotionProduct->promotion_quantity;
                                    $orderPromotion->approve_carton = $targetItem['amount'] * $promotionProduct->promotion_quantity;
                                }

                                if(!is_null($uomData)){
                                    $orderPromotion->order_quantity = $targetItem['amount'] * $uomData->conversion_rate;
                                    $orderPromotion->approve_quantity = $targetItem['amount'] * $uomData->conversion_rate;
                                }

                                if($promotionProduct->promotion_uom == 'PTN'){
                                    $orderPromotion->order_carton = $targetItem['amount'] * 12;
                                    $orderPromotion->approve_carton = $targetItem['amount'] * 12;
                                }

                                $orderPromotion->uom_code = $promotionProduct->promotion_uom;
                                $orderPromotion->uom = $promotionProduct->promotion_uom_desc;
                            }
                            // keep promotion by type

                            $promotionHeader = DB::table('ptom_promotion_header')
                            ->where('promotion_id',$promotionProduct->promotion_id)
                            ->first();

                            $orderPromotion->remark = $promotionHeader->attribute1;

                            // $orderPromotion->order_carton = $promotionProduct->promotion_quantity * 5;
                            $orderPromotion->quota_credit_id = 0;
                            $orderPromotion->program_code = 'OMP0003';
                            $orderPromotion->created_by = 1;
                            $orderPromotion->last_updated_by = 1;

                            if($orderPromotion->order_quantity > 0 && $orderPromotion->approve_quantity > 0) {
                                $orderPromotion->save();
                            }

                        }

                        $runLine++;


                }

            }

            if(count($contractGroups) > 0 && $orderHeader->payment_type_code != 10){
                foreach($contractGroups as $val){
                //     // $creditGroupsRemaining[$val->credit_group_code] = $val->remaining_amount;
                //     // $creditGroups[$val->credit_group_code] = $val;
                    $orderCredit = OrderCreditGroup::where('order_header_id',$orderHeader->order_header_id)->where('order_line_id',0)->where('credit_group_code',$val->credit_group_code)->first();
                //     // $orderCredit->amount = $creditAmount[$val->credit_group_code];
                //     // $orderCredit->remaining_amount = $orderCredit->remaining_amount - $creditAmount[$val->credit_group_code];
                //     // $orderCredit->save();
                    if ($request->status == 'Confirm' && $request->over_order != 'over') {
                        $sumCredit = OrderCreditGroup::where('order_header_id',$orderHeader->order_header_id)->where('order_line_id','!=',0)->where('credit_group_code',$val->credit_group_code)->sum('amount');
                        if ($request->status == 'Confirm') {
                            DB::table('ptom_order_credit_groups')
                            ->where('order_header_id',$orderHeader->order_header_id)
                            ->where('credit_group_code',$val->credit_group_code)
                            ->where('order_line_id',0)
                            ->update(array(
                                'amount'=>(($sumCredit < 0) ? 0 : $sumCredit),
                                // 'remaining_amount' => $orderCredit->remaining_amount - $creditAmount[$val->credit_group_code],
                            ));
                        }
                    }

                    // else{
                    //     $sumCredit = ($creditAmount[$val->credit_group_code] >= $orderCredit->remaining_amount) ? $orderCredit->remaining_amount : $creditAmount[$val->credit_group_code];
                    // }

                    // $response['$sumCredit'][] = $sumCredit;

                }
            }else{
                if ($request->status == 'Confirm') {
                    DB::table('ptom_order_credit_groups')
                    ->where('order_header_id',$orderHeader->order_header_id)
                    ->where('order_line_id',0)
                    ->where('credit_group_code',0)
                    ->update(array(
                        'amount'=>(($creditAmount[0] < 0) ? 0 : $creditAmount[0])
                    ));
                }
            }

            // if($response['diff']){
            //     $orderHeader->order_status = '';
            // }else{
                if ($request->status == 'Confirm' && $request->over_order != 'over') {
                    $orderHeader->order_status = 'Draft';
                }
                // $orderHeader->order_status = $request->status;
            // }

            if ($request->status == 'Confirm' && $request->over_order != 'over') {

                $contractGroups = OrderRepo::getCustomerContractGroups($customer_id);

                if($orderHeader->payment_type_code == 20){
                    if(count($contractGroups) > 0){
                        foreach($contractGroups as $valc){

                            $orderCreditD = OrderCreditGroup::where('order_header_id',$orderHeader->order_header_id)->where('order_line_id',0)->where('credit_group_code',$valc->credit_group_code)->first();

                            if(!is_null($orderCredit)){

                                $customerContractGroups = CustomerContractGroups::where('credit_group_code',$valc->credit_group_code)->where('customer_id',$orderHeader->customer_id)->whereNull('deleted_at')->first();

                                $sumCredit = OrderCreditGroup::where('order_header_id',$orderHeader->order_header_id)->where('order_line_id','!=',0)->where('credit_group_code',$valc->credit_group_code)->sum('amount');
                                // $remaining_amount = $valc->remaining_amount - $sumCredit;

                                // if($remaining_amount <= 0){
                                //     $remaining_amount = $customerContractGroups->remaining_amount - $valc->remaining_amount;
                                // }

                                if($valc->remaining_amount > $sumCredit){
                                    $remaining_amount = $valc->remaining_amount - $sumCredit;
                                }else{
                                    $remaining_amount = $customerContractGroups->remaining_amount - $valc->remaining_amount;
                                }

                                DB::table('ptom_customer_contract_groups')
                                ->where('customer_id',$customer_id)
                                ->where('credit_group_code',$valc->credit_group_code)
                                ->whereNull('deleted_at')
                                ->update(array(
                                    'remaining_amount'=>(($remaining_amount < 0) ? 0 : $remaining_amount)
                                ));
                            }

                        }

                    }
                }

                OrderRepo::insertOrdersHistoryv2($orderHeader,'Release');
            }



            $orderHeader->tax = number_format((float)$tax_amount, 2, '.', '');
            $orderHeader->sub_total = $request->grand_total - number_format((float)$tax_amount, 2, '.', '');
            $orderHeader->fines_amount = number_format((float)$request->fines_amount, 2, '.', '');

            if ($request->status == 'Confirm' && $request->over_order == 'over') {
                $orderHeader->order_status = 'Draft';
                OrderRepo::insertOrdersHistoryv2($orderHeader,'Release');
            }

            $orderHeader->save();


            // OrderRepo::insertOrdersHistory($orderHeader);

            DB::commit();
            $logs = collect($logs)->map(function($i) {
                return $i. PHP_EOL;
            });
            Log::debug($logs->join('#'));
            return response()->json(['status'=>true,'data' =>$response,'message'=>'']);

        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            $logs[] = "$$$$$$$$ ERROR =". $e->getMessage();
            $logs = collect($logs)->map(function($i) {
                return $i. PHP_EOL;
            });
            Log::error($logs->join('#'));
            return response()->json(['status'=>false,'data' => [],'message'=>$e->getMessage()]);
        }
    }

    public function addOver(Request $request)
    {
        $orderHeader = OrderHeader::where('order_header_id',$request->order_header_id)->orderBy('order_header_id','DESC')->first();

        $customer_id = $orderHeader->customer_id;

        $customer = Customer::byCustomerId($customer_id);

        // $contractQuata = OrderRepo::getCustomerQuotaHeaders($customer_id);

        $periodPostpone = DB::table('ptom_postpone_orders')
        ->where('to_period_id', $orderHeader->period_id)
        ->where('customer_id', $orderHeader->customer_id)
        ->where('approve_status', 'อนุมัติ')
        ->whereNull('deleted_at')
        ->first();

        if(is_null($periodPostpone)){
            $contractQuata = OrderRepo::getCustomerQuotaHeaders($customer_id,$orderHeader);
        }else{
            $contractQuata = OrderRepo::getCustomerQuotaHeadersByPeriod($customer_id,$periodPostpone);
        }

        $response = [];
        $diff = false;
        $checked_product = $request->checked_product;
        $response['diff'] = false;

        foreach($contractQuata as $val){
            $overQuota[$val['group']->lookup_code] = 0;
            $inData = false;
            foreach ($val['quota'] as $quota){

                if(in_array($quota->item_id,$checked_product)){

                    $inData = true;

                    $order_cardboardbox = $request->items['chest_amount'][$val['group']->lookup_code][$quota->quota_line_id][$quota->item_id];
                    $order_carton = $request->items['wrap_amount'][$val['group']->lookup_code][$quota->quota_line_id][$quota->item_id];
                    $order_quantity = $request->items['order_quantity'][$val['group']->lookup_code][$quota->quota_line_id][$quota->item_id];
                    $max_amount = $request->items['max_amount'][$val['group']->lookup_code][$quota->quota_line_id][$quota->item_id];
                    $sum_amount = $request->items['sum_amount'][$val['group']->lookup_code][$quota->quota_line_id][$quota->item_id];
                    $total_amount = $request->items['sum_amount'][$val['group']->lookup_code][$quota->quota_line_id][$quota->item_id];

                    $overQuota[$val['group']->lookup_code] += $order_quantity;

                }
            }

            if($overQuota[$val['group']->lookup_code] > $val['remaining_quota']){
                OrderRepo::additionQuota($orderHeader->order_header_id,$customer,$val,$overQuota);
            }
        }

        return response()->json(['status'=>true,'data' =>$response,'message'=>'']);

    }

    public function checkOver(Request $request)
    {
        $orderHeader    = OrderHeader::where('order_header_id',$request->order_header_id)->orderBy('order_header_id','DESC')->first();
        $customer_id    = $orderHeader->customer_id;
        $customer       = Customer::byCustomerId($customer_id);
        $periodPostpone = DB::table('ptom_postpone_orders')
                            ->where('to_period_id', $orderHeader->period_id)
                            ->where('customer_id', $orderHeader->customer_id)
                            ->where('approve_status', 'อนุมัติ')
                            ->whereNull('deleted_at')
                            ->first();

        if(is_null($periodPostpone)){
            $contractQuata = OrderRepo::getCustomerQuotaHeaders($customer_id,$orderHeader);
        }else{
            $contractQuata = OrderRepo::getCustomerQuotaHeadersByPeriod($customer_id,$periodPostpone);
        }

        $response                   = [];
        $diff                       = false;
        $checked_product            = $request->checked_product;
        $response['diff']           = false;
        $response['diff_message']   = '';

        if($customer->customer_type_id != 20){
            foreach($contractQuata as $val){
                $overQuota[$val['group']->lookup_code] = 0;

                $additionQuota = AdditionQuota::where('order_header_id', $orderHeader->order_header_id)
                                                ->where('customer_id', $customer_id)
                                                ->where('approve_status','อนุมัติ')
                                                ->orderBy('order_header_id','DESC')
                                                ->first();

                if(!is_null($additionQuota)){
                    $AdditionQuotaLines = AdditionQuotaLines::where('quota_header_id',$additionQuota->quota_header_id)
                    ->where('quota_group_id',(int)$val['group']->lookup_code)
                    ->first();

                    if(!is_null($AdditionQuotaLines)){
                        $amountAddition = ($AdditionQuotaLines->approve_quantity);
                        $val['remaining_quota'] = ($val['remaining_quota'] < 0) ? 0 : $val['remaining_quota'];
                        $val['remaining_quota'] += ($AdditionQuotaLines->approve_quantity / 0.1);

                    }
                }

                $inData = false;
                foreach ($val['quota'] as $quota){

                    if(in_array($quota->item_id,$checked_product)){

                        $inData = true;
                        try {
                            $order_cardboardbox = $request->items['chest_amount'][$val['group']->lookup_code][$quota->quota_line_id][$quota->item_id];
                            $order_carton = $request->items['wrap_amount'][$val['group']->lookup_code][$quota->quota_line_id][$quota->item_id];
                            $order_quantity = $request->items['order_quantity'][$val['group']->lookup_code][$quota->quota_line_id][$quota->item_id];
                            $max_amount = $request->items['max_amount'][$val['group']->lookup_code][$quota->quota_line_id][$quota->item_id];
                            $sum_amount = $request->items['sum_amount'][$val['group']->lookup_code][$quota->quota_line_id][$quota->item_id];
                            $total_amount = $request->items['sum_amount'][$val['group']->lookup_code][$quota->quota_line_id][$quota->item_id];

                            $overQuota[$val['group']->lookup_code] += $order_quantity;
                        } catch (\Exception $e) {

                        }

                    }
                }

                if($overQuota[$val['group']->lookup_code] > $val['remaining_quota'] && $inData){
                    if(!is_null($additionQuota)){
                        $response['diff'] = true;
                        $response['diff_message'] = 'โปรดระบุจำนวนสั่งซื้อตาม'.$val['group']->meaning.' ให้ตรงกับโควต้าที่ได้รับอนุมัติ จำนวน '.$amountAddition.' หีบ';
                    }else{
                        $response['diff'] = true;
                        $response['diff_message'] = '';
                    }
                }

            }
        }

        return response()->json(['status'=>true,'data' =>$response,'message'=>'']);
    }

    public function updatePurchase(Request $request)
    {
        DB::beginTransaction();
        try {

            $fines_amount = 0;

            $orderHeader = OrderHeader::where('order_header_id',$request->order_header_id)->orderBy('order_header_id','DESC')->first();
            $orderHeader->ship_to_site_id = $request->ship_to_site_id;
            $orderHeader->cust_po_number = $request->cust_po_number;
            $orderHeader->grand_total = $request->grand_total;
            $orderHeader->cash_amount = $request->grand_total;

            $orderHeader->credit_amount = 0;
            $orderHeader->remark = $request->remark;

            $response = [];

            $response['order_number'] = '';
            if(is_null($orderHeader->order_number)){
                if ($orderHeader->product_type_code == 10) {
                    $orderNumber = GenerateNumberRepo::docSequenceNumber('OMP0003_PO_NUM_CG_DOM','order_number');
                }else if($orderHeader->product_type_code == 20){
                    $orderNumber = GenerateNumberRepo::docSequenceNumber('OMP0003_PO_NUM_L_DOM','order_number');
                }else{
                    $orderNumber = GenerateNumberRepo::docSequenceNumber('OMP0003_PO_NUM_O_DOM','order_number');
                }

                $orderHeader->order_number = $orderNumber;
                $response['order_number'] = $orderNumber;
            }else{
                $response['order_number'] = $orderHeader->order_number;
            }

            if ($request->status == 'Confirm') {
                $orderHeader->order_status = 'Draft';
                if(is_null($orderHeader->prepare_order_number)){
                    if ($orderHeader->product_type_code == 10) {
                        $prepareNumber = GenerateNumberRepo::docSequenceNumber('OMP0019_SO_NUM_CG_DOM','prepare_order_number');
                    }else if($orderHeader->product_type_code == 20){
                        $prepareNumber = GenerateNumberRepo::docSequenceNumber('OMP0019_SO_NUM_L_DOM','prepare_order_number');
                    }else{
                        $prepareNumber = GenerateNumberRepo::docSequenceNumber('OMP0019_SO_NUM_O_DOM','prepare_order_number');
                    }

                    $orderHeader->prepare_order_number = $prepareNumber;
                }
            }


            $customer_id = $orderHeader->customer_id;

            $customer = Customer::byCustomerId($customer_id);

            $orderHeader->price_list_id = $customer->price_list_id;

            $orderHeader->remaining_amount = OrderRepo::sumNotMatch($customer_id);

            $checked_product = $request->checked_product;

            $productList = OrderRepo::getProductListTypeCode($customer_id,$orderHeader->product_type_code,$orderHeader);

            $runLine = 1;
            $tax_amount = 0;

            try {

                foreach ($request->outstanding_rm as $key => $val) {
                    if(!is_null($val)){
                        $exp = explode('_',$val);

                        $outstandingData = OutstandingDebtDomesticV::where('pick_release_no',$exp[0])->where('credit_group_code',$exp[1])->where('pick_release_status','Confirm')->first();

                        $release = ReleaseCredit::where('attribute1',$orderHeader->order_header_id)->where('customer_id',$customer->customer_id)->where('invoice_id',$outstandingData->order_header_id)->where('credit_group_code',$exp[1])->first();

                        if(!is_null($release)){
                            $customerContractGroups = CustomerContractGroups::where('credit_group_code',$release->credit_group_code)->where('customer_id',$customer->customer_id)->whereNull('deleted_at')->first();
                            $remaining_amount = $customerContractGroups->remaining_amount - $release->amount;

                            if ($request->status == 'Confirm'){
                                DB::table('ptom_customer_contract_groups')
                                ->where('credit_group_code',$outstandingData->credit_group_code)
                                ->where('customer_id',$customer->customer_id)
                                ->whereNull('deleted_at')
                                ->update(array(
                                    'remaining_amount'=>(($remaining_amount < 0) ? 0 : $remaining_amount),
                                ));
                            }

                            $release->delete();
                        }

                    }
                }

                $amountRelease = [];
                $contractGroups = OrderRepo::getCustomerContractGroups($customer_id);
                if(count($contractGroups) > 0 && $orderHeader->payment_type_code != 10){
                    foreach($contractGroups as $val){
                        $amountRelease[$val->credit_group_code] = 0;
                    }
                }

                foreach ($request->outstanding_id as $key => $val) {
                    if(!is_null($val)){
                        $exp = explode('_',$val);

                        $outstandingData = OutstandingDebtDomesticV::where(function($query) use ($exp){
                            $query->where('pick_release_no',$exp[0]);
                            $query->orWhere('consignment_no',$exp[0]);
                        })->where('credit_group_code',$exp[1])->where('pick_release_status','Confirm')->first();

                        if($outstandingData->credit_group_code != 0){
                            $releaseCredit = ReleaseCredit::where('customer_id',$customer->customer_id)->where('invoice_id',$outstandingData->order_header_id)->where('credit_group_code',$exp[1])->first();
                            if(is_null($releaseCredit)){
                                $releaseCredit = new ReleaseCredit();
                            }else{
                                if(!is_null($outstandingData->attribute1)){
                                    $releaseCredit = new ReleaseCredit();
                                }
                            }

                            $releaseCredit->customer_id = $customer->customer_id;
                            $releaseCredit->attribute1 = $orderHeader->order_header_id;
                            $releaseCredit->invoice_id = $outstandingData->order_header_id;
                            $releaseCredit->invoice_num = $outstandingData->pick_release_no;
                            $releaseCredit->due_date = $outstandingData->due_date;
                            $releaseCredit->amount = $outstandingData->outstanding_debt;
                            $releaseCredit->credit_group_code = $outstandingData->credit_group_code;
                            $releaseCredit->charge_amount = 0.00;
                            if ($request->status == 'Confirm'){
                                $releaseCredit->payment_flag = 'Y';
                            }
                            $releaseCredit->created_by = 1;
                            $releaseCredit->last_updated_by = 1;
                            $releaseCredit->program_code = 'OMP0003';
                            $releaseCredit->save();

                            if ($request->status == 'Confirm'){

                                $customerContractGroups = CustomerContractGroups::where('credit_group_code',$outstandingData->credit_group_code)->where('customer_id',$customer->customer_id)->whereNull('deleted_at')->first();

                                $remaining_amount = $customerContractGroups->remaining_amount + $outstandingData->outstanding_debt;
                                if($remaining_amount > $customerContractGroups->credit_amount){
                                    $remaining_amount = $customerContractGroups->credit_amount;
                                }


                                DB::table('ptom_customer_contract_groups')
                                ->where('credit_group_code',$outstandingData->credit_group_code)
                                ->where('customer_id',$customer->customer_id)
                                ->whereNull('deleted_at')
                                ->update(array(
                                    'remaining_amount'=>(($remaining_amount < 0) ? 0 : $remaining_amount),
                                ));
                            }
                        }

                        // $amountRelease[$outstandingData->credit_group_code] += $outstandingData->outstanding_debt;
                        $fines_amount += $outstandingData->outstanding_debt;

                    }
                }
            }catch (\Exception $e) {
                $amountRelease = [];
                $contractGroups = OrderRepo::getCustomerContractGroups($customer_id);
                if(count($contractGroups) > 0 && $orderHeader->payment_type_code != 10){
                    foreach($contractGroups as $val){
                        $amountRelease[$val->credit_group_code] = 0;
                    }
                }
            }

            foreach($productList as $item){

                $orderLine = OrderLines::where('order_header_id',$orderHeader->order_header_id)->whereNull('promo_flag')->where('item_id',$item->item_id)->first();

                if(in_array($item->item_id,$checked_product)){

                    if (!isset($orderLine) || empty($orderLine)) {
                        $orderLine = new OrderLines();
                    }

                    $orderLine->line_number = $runLine;
                    $orderLine->order_header_id = $orderHeader->order_header_id;
                    $orderLine->item_id = $item->item_id;
                    $orderLine->item_code = $item->item_code;
                    $orderLine->item_description = $item->item_description;
                    $orderLine->attribute2 = $item->price_unit;
                    // $orderLine->unit_price = $item->price_unit;

                    $orderLine->unit_price = number_format((float)$request->items['unit_price'][$item->item_id], 2, '.', '');

                    // $orderLine->uom_code = $item->product_uom_code;
                    // $orderLine->uom = $item->unit_of_measure;

                    $orderLine->uom_code = $request->items['uom_code'][$item->item_id];
                    $orderLine->uom = $request->items['unit_of_measure'][$item->item_id];

                    $orderLine->order_quantity = $request->items['amount'][$item->item_id];
                    $orderLine->diff_quantity = 0;

                    // if (isset($request->promotion) && isset($request->promotion[$item->item_id])) {
                    //     $promotion = explode('_',$request->promotion[$item->item_id]);
                    //     $orderLine->promotion_id = $promotion[1];
                    //     $orderLine->promotion_product_id = $promotion[2];
                    // }

                    // day amount
                    $dayAmountRepo = OrderRepo::setTermDayAmount($orderHeader,$customer,0);

                    $orderLine->day_amount = $dayAmountRepo['day_amount'];
                    $orderLine->credit_group_code = $dayAmountRepo['credit_group_code'];
                    // day amount

                    $tax = 0;
                    if(!is_null($orderHeader->order_type_id)){
                        $calTax = OrderRepo::calTaxDomestic($orderLine->order_quantity,$orderLine->item_id,$orderHeader->order_type_id,$orderHeader->customer_id);
                        $orderLine->tax_amount = number_format((float)$calTax['amount'], 5, '.', '');
                        $orderLine->attribute1 = $calTax['operand'];
                        $tax_amount += $calTax['amount'];
                    }else{
                        if(!is_null($customer->order_type_id)){
                            $calTax = OrderRepo::calTaxDomestic($orderLine->order_quantity,$orderLine->item_id,$customer->order_type_id,$orderHeader->customer_id);
                            $orderLine->tax_amount = number_format((float)$calTax['amount'], 5, '.', '');
                            $orderLine->attribute1 = $calTax['operand'];
                            $tax_amount += $calTax['amount'];
                        }
                    }

                    $orderLine->amount = number_format((float)$request->items['sum_amount'][$item->item_id], 2, '.', '');
                    $orderLine->total_amount = number_format((float)$request->items['sum_amount'][$item->item_id], 2, '.', '');
                    $orderLine->program_code = 'OMP0003';
                    $orderLine->created_by = 1;
                    $orderLine->last_updated_by = 1;

                    $orderLine->save();

                    $runLine += 1;

                }else{
                    if (isset($orderLine) && !empty($orderLine)) {
                        $orderLine->delete();
                    }
                }
            }

            $orderHeader->tax = number_format((float)$tax_amount, 2, '.', '');
            $orderHeader->sub_total = $request->grand_total - number_format((float)$tax_amount, 2, '.', '');
            $orderHeader->fines_amount = number_format((float)$request->fines_amount, 2, '.', '');

            $orderHeader->save();
            if(isset($request->promotion)){
                OrderLines::where('order_header_id', $orderHeader->order_header_id)->whereNotNull('promotion_product_id')->delete();

                foreach ($request->promotion as $key => $v) {
                        $promotionProduct = DB::table('ptom_promotion_product')
                            ->where('promotion_product_id',$key)
                            // ->where('support_group',$request->promotion_support_group[$v])
                            ->first();
                        if(!is_null($promotionProduct)){

                            $orderPromotion = OrderLines::where('order_header_id',$orderHeader->order_header_id)->where('promotion_product_id',$key)->first();
                            if (!isset($orderPromotion) || empty($orderPromotion)) {
                                $orderPromotion = new OrderLines();
                            }

                            $orderPromotion->order_header_id = $orderHeader->order_header_id;
                            $orderPromotion->promotion_id = $promotionProduct->promotion_id;
                            $orderPromotion->promotion_product_id = $promotionProduct->promotion_product_id;
                            $orderPromotion->promo_flag = 'Y';
                            $orderPromotion->line_number = $runLine;
                            $orderPromotion->quota_line_id = 0;
                            $orderPromotion->unit_price = 0;
                            $orderPromotion->item_id = $promotionProduct->item_id;
                            $orderPromotion->item_code = $promotionProduct->item_code;
                            $orderPromotion->item_description = $promotionProduct->item_description;
                            $orderPromotion->total_amount = 0;

                            $uomConversions = DB::table('ptom_uom_conversions_v')
                            ->where('uom_code',$promotionProduct->promotion_uom)
                            ->first();

                          
                            // keep promotion by type
                            $promotionCheckTypeProduct = DB::table('ptom_sequence_ecoms')->where('item_code', $promotionProduct->item_code)->first();


                            if($promotionCheckTypeProduct->product_type_code == 10){
                                if($promotionProduct->promotion_uom == 'CG2'){
                                    $carton = $promotionProduct->promotion_quantity * $request->promotion_amount[$key];
                                    $orderPromotion->order_quantity = $carton * 0.2;
                                    $orderPromotion->approve_quantity = $carton * 0.2;
                                }elseif($promotionProduct->promotion_uom == 'CGC'){
                                    $cardboardbox = $promotionProduct->promotion_quantity * $request->promotion_amount[$key];
                                    $orderPromotion->order_quantity = $cardboardbox / 0.1;
                                    $orderPromotion->approve_quantity = $cardboardbox / 0.1;
                                }else{
                                    $quantity = $promotionProduct->promotion_quantity * $request->promotion_amount[$key];
                                    $orderPromotion->order_quantity = $quantity;
                                    $orderPromotion->approve_quantity = $quantity;
                                }
                                $orderPromotion->uom_code = 'CGK';
                                $orderPromotion->uom = 'พันมวน';

                                $convertCGK = OrderRepo::convertCGK($orderPromotion->order_quantity);

                                $orderPromotion->order_cardboardbox = $convertCGK['cardboardbox'];
                                $orderPromotion->approve_cardboardbox = $convertCGK['cardboardbox'];
                                $orderPromotion->order_carton = $convertCGK['carton'];
                                $orderPromotion->approve_carton = $convertCGK['carton'];

                            }else{

                                $uomData = DB::table('ptom_uom_conversions_v')
                                ->where('uom_code','=', $promotionProduct->promotion_uom)
                                ->where('domestic','Y')
                                ->first();

                                $uomDataCB = DB::table('ptom_uom_v')
                                ->where('uom_code','=', $promotionProduct->promotion_uom)
                                ->where('domestic','Y')
                                ->where('name_for_report_exp','CARDBOARD BOXES')
                                ->first();

                                if(!is_null($uomDataCB)){
                                    $orderPromotion->order_cardboardbox = $request->promotion_amount[$key];
                                    $orderPromotion->approve_cardboardbox = $request->promotion_amount[$key];
                                }

                                $uomDataCAR = DB::table('ptom_uom_v')
                                ->where('uom_code','=', $promotionProduct->promotion_uom)
                                ->where('domestic','Y')
                                ->where('name_for_report_exp','CARTONS')
                                ->where('base_uom_carton_l','Y')
                                ->first();

                                if(!is_null($uomDataCAR)){
                                    $orderPromotion->order_carton = $request->promotion_amount[$key] * $promotionProduct->promotion_quantity;
                                    $orderPromotion->approve_carton = $request->promotion_amount[$key] * $promotionProduct->promotion_quantity;
                                }
                                $promotion_object = [];
                                foreach($request->promotion as $prodItemId => $item) {
                                    $promotion_object[] = ['promotion_id' => $item, 'amount' => $request->promotion_amount[$prodItemId], 'product_id' => $prodItemId, 'promotion_group' => $request->promotion_group[$prodItemId]];
                                }
                                $promotion_object = collect($promotion_object);

                                if(!is_null($uomData)){
                                    
                                    $promotion_group = collect($request->promotion_group);
                                    $groupProduct = [];
                                    foreach ($promotion_group as $key_set => $value) {
                                        if (array_key_exists($value, $groupProduct)) {
                                            $groupProduct[$value][] = $key_set;
                                        } else {
                                            $groupProduct[$value] = [$key_set];
                                        }
                                    }
                                    $targetItem = $promotion_object->where('product_id', $key)->first();
                                    $checkDuplicat = $promotion_object->where('promotion_id', $targetItem['promotion_id'])->where('promotion_group', $targetItem['promotion_group']);
                                    if(count($checkDuplicat) > 1) {
                                        if($checkDuplicat->first()['amount'] > 0 ) {
                                            $orderPromotion->order_quantity = $checkDuplicat->first()['amount'] * $promotionProduct->promotion_quantity;
                                            $orderPromotion->approve_quantity = $checkDuplicat->first()['amount'] * $promotionProduct->promotion_quantity;
                                            if(!is_null($uomDataCAR)){
                                                $orderPromotion->order_carton = $checkDuplicat->first()['amount']* $promotionProduct->promotion_quantity;
                                                $orderPromotion->approve_carton = $checkDuplicat->first()['amount']* $promotionProduct->promotion_quantity;
                                            }
                                        }
                                    } else {
                                        $orderPromotion->order_quantity = $request->promotion_amount[$key] * $promotionProduct->promotion_quantity;
                                        $orderPromotion->approve_quantity = $request->promotion_amount[$key] * $promotionProduct->promotion_quantity;
                                    }
                                    // if($groupProduct[])
                                }

                                if($promotionProduct->promotion_uom == 'PTN'){
                                    if(count($checkDuplicat) > 1) {
                                        if($targetItem['amount'] == 0 && $checkDuplicat->first()['amount'] > 0 ) {
                                            $orderPromotion->order_carton = $checkDuplicat->first()['amount'] * 12;
                                            $orderPromotion->approve_carton = $checkDuplicat->first()['amount']  * 12;
                                        }
                                    } else {
                                        $orderPromotion->order_carton = $request->promotion_amount[$key] * 12;
                                        $orderPromotion->approve_carton = $request->promotion_amount[$key] * 12;
                                    }
                                }

                                $orderPromotion->uom_code = $promotionProduct->promotion_uom;
                                $orderPromotion->uom = $promotionProduct->promotion_uom_desc;
                            }
                            $promotionHeader = DB::table('ptom_promotion_header')
                            ->where('promotion_id',$promotionProduct->promotion_id)
                            ->first();

                            $orderPromotion->remark = $promotionHeader->attribute1;

                            $orderPromotion->quota_credit_id = 0;
                            $orderPromotion->program_code = 'OMP0003';
                            $orderPromotion->created_by = 1;
                            $orderPromotion->last_updated_by = 1;
                            if($orderPromotion->order_quantity > 0 && $orderPromotion->approve_quantity > 0) {
                                $orderPromotion->save();
                            }

                        }

                        $runLine++;


                }

            }
            if ($request->status == 'Confirm') {
                OrderRepo::insertOrdersHistoryv2($orderHeader,'Release');
            }

            // $orderHistory = new OrderStatusHistory();
            // foreach ($orderHeader->toArray() as $key => $v) {
            //     if ($key != 'requestor_code' && $key != 'payment_approve_flag') {
            //         $orderHistory[$key] = $v;
            //     }
            // }
            // $orderHistory->save();

            DB::commit();

            return response()->json(['status'=>true,'data' =>$response,'message'=>'']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status'=>false,'data' => [],'message'=>$e->getMessage()]);
        }
    }
    // CODE EXCEPTION 
    // 100001 ไม่สามารถทำรายการยกเลิกได้ เนื่องจากต้องยกเลิกในระบบ OMP0019 ก่อน
    public function cancel(Request $request)
    {
        DB::beginTransaction();
        try {
            $orderHeader = OrderHeader::where('order_header_id',$request->order_header_id)->orderBy('order_header_id','DESC')->first();
            $resp = [];
            $orderCreditGroup = OrderCreditGroup::where('order_header_id',$orderHeader->order_header_id)->where('order_line_id',0)->where('credit_group_code','!=',0)->get();
            $lastOrder = OrderRepo::lastOrdersStatus($orderHeader->order_header_id);
            // ตรวจสอบว่าใบที่ยกเลิกมีการยืนยันส่งไป OMP0019 แล้วหรือยัง
            $orderHistory2Check = DB::table('PTOM_ORDER_HISTORY')
                                ->where('order_header_id', '<>', $orderHeader->order_header_id)
                                ->where('order_number', $orderHeader->order_number)
                                ->orderBy('order_history_id', 'desc')
                                ->first();
            if(empty($orderHistory2Check)) {
                if(!empty($orderHeader->prepare_order_number)) {
                    throw new Exception("ไม่สามารถทำรายการยกเลิกได้ เนื่องจากต้องยกเลิกในระบบ OMP0019 ก่อน", 100001);
                }
            } else {
                if($orderHistory2Check->order_status != "Cancelled") throw new Exception("ไม่สามารถทำรายการยกเลิกได้ เนื่องจากต้องยกเลิกในระบบ OMP0019 ก่อน", 100001);
            }
            if($orderHeader->installment_type_code == 10){
                if($lastOrder->order_status != 'Draft'){
                    $orderQuota = OrderRepo::getCustomerQuotaRemaining($orderHeader->customer_id,$orderHeader->delivery_date);

                    foreach ($orderQuota as $key => $v) {
                        $orderLine = OrderLines::where('order_header_id',$orderHeader->order_header_id)->whereNull('promo_flag')->where('item_code',$v->item_code)->first();
                        if(!is_null($orderLine)){
                            $remaining_quota = $v->remaining_quota + $orderLine->order_quantity;

                            if($remaining_quota >= $v->received_quota){
                                $remaining_quota = $v->received_quota;
                            }

                            DB::table('ptom_customer_quota_lines')
                            ->where('quota_line_id',$v->quota_line_id)
                            ->update(array(
                                'remaining_quota'=>$remaining_quota,
                            ));
                        }
                    }

                    OrderQuotaHistory::where('order_header_id',$orderHeader->order_header_id)->delete();

                    foreach ($orderCreditGroup as $key => $v) {
                        $customerContractGroups = CustomerContractGroups::where('credit_group_code',$v->credit_group_code)->where('customer_id',$orderHeader->customer_id)->whereNull('deleted_at')->first();

                        $releaseCredit = ReleaseCredit::where('attribute1',$orderHeader->order_header_id)->where('customer_id',$orderHeader->customer_id)->where('credit_group_code',$v->credit_group_code)->where('payment_flag','Y')->sum('amount');
                        $remaining_amount = $customerContractGroups->remaining_amount + $v->amount - $releaseCredit;

                        if($v->amount >= $customerContractGroups->credit_amount){
                            $remaining_amount = $customerContractGroups->credit_amount;
                        }

                        $c = $this->remainingAmountCallback($orderHeader->customer_id, '', $orderHeader->period_id);
                        $remaining_base = $c['cusContractGroup']->where('credit_group_code', $v->credit_group_code)->first();
                        $remaining_base =  $remaining_base->credit_amount * ($remaining_base->credit_percentage / 100);
                        $ptOmDebtDomV = $c['ptOmDebtDomV']->where('credit_group_code', $v->credit_group_code)->sum('outstanding_debt');
                        $debtDomV = $c['debtDomV']->where('credit_group_code', $v->credit_group_code)->sum('outstanding_debt');
                        $orderHeaders = $c['orderHeaders']->where('credit_group_code', $v->credit_group_code)->where('prepare_order_number', '!=', $orderHeader->prepare_order_number)->sum('amount');
                        $new_remaining_amount = $remaining_base - $ptOmDebtDomV - $orderHeaders + $debtDomV;
                        $remaining_amount = $new_remaining_amount;
                        DB::table('ptom_customer_contract_groups')
                        ->where('credit_group_code',$v->credit_group_code)
                        ->where('customer_id',$orderHeader->customer_id)
                        ->whereNull('deleted_at')
                        ->update(array(
                            'remaining_amount'=>(($remaining_amount < 0) ? 0 : $remaining_amount),
                        ));
                    }

                    OrderCreditGroup::where('order_header_id',$orderHeader->order_header_id)->delete();
                }

                $releaseCredit = ReleaseCredit::where('attribute1',$orderHeader->order_header_id)->where('customer_id',$orderHeader->customer_id)->delete();
            }

            $orderHeader->order_status = 'Cancelled';
            $orderHeader->po_cancel_reason = $request->po_cancel_reason;
            $orderHeader->last_updated_by = 1;
            $orderHeader->last_update_date = now();
            $orderHeader->save();
            $getIdRef =  OrderHeader::where('order_number', $orderHeader->order_number)->get(['order_header_id']);
            DB::table('ptom_addition_quota_headers')->whereIn('order_header_id', $getIdRef->pluck('order_header_id')->toArray())->update(['approve_status' => 'ไม่อนุมัติ']);
            
            OrderRepo::insertOrdersHistoryv2($orderHeader,'Cancelled');

            DB::commit();

            return response()->json(['status'=>true,'data' =>[],'message'=>$resp, 'code' => 200]);

        } catch (\Exception $e) {
            \Log::error($e);
            DB::rollBack();
            return response()->json(['status'=>false,'data' => [],'message'=>$e->getMessage(), 'code' => $e->getCode()]);
        }
    }

    // Piyawut A. Add func remove order ecom
    public function removeOrder($id)
    {
        DB::beginTransaction();
        try {
            $orderHeader = OrderHeader::where('order_header_id', $id)
                                    ->whereNull('order_status')
                                    ->whereNull('pick_release_status')
                                    ->first();
            if ($orderHeader) {
                OrderLines::where('order_header_id', $id)->delete();
                OrderStatusHistory::where('order_header_id', $id)->delete();
                $orderHeader->delete();
                DB::commit();
            }
            return response()->json(['status' => 'S', 'message' => '']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status'=> 'E', 'message'=>$e->getMessage()]);
        }
    }

}