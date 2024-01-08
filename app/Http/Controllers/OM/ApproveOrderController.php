<?php

namespace App\Http\Controllers\OM;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\OM\Order;
use App\Models\OM\Invoice;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ApproveOrderController extends Controller
{
    //
    public function index() {

        $customerList = DB::table('PTOM_CUSTOMERS')->get();
        $match = DB::table('PTOM_PAYMENT_MATCH_INVOICES')
            ->selectRaw('INVOICE_ID as invoice,PREPARE_ORDER_NUMBER,max(DUE_DATE) as maxdate,sum(PAYMENT_AMOUNT) as sumamount')
            ->groupBy('PREPARE_ORDER_NUMBER', 'INVOICE_ID');
        $order = Order::where('PERIOD_ID','!=',1)
            ->leftJoin('PTOM_APPROVER_ORDERS', 'PTOM_ORDER_HEADERS.PICK_RELEASE_APPROVE_BY', '=', 'PTOM_APPROVER_ORDERS.APPROVER_ORDER_ID')
            ->leftJoinSub($match, 'match', 'match.PREPARE_ORDER_NUMBER', 'PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER')
            ->where('PAYMENT_APPROVE_FLAG', 'Y')
            ->select([
                'PTOM_ORDER_HEADERS.*',
                'PTOM_APPROVER_ORDERS.APPROVER_NAME as approver_name',
                'match.*'
            ])
            ->get();
        foreach($order as $item) {
            $item->is_over_quota = false;
            $customer_quota = [];

            $quota_group = DB::table('ptom_quota_group as cg')->where('tag','Y')->get(['cg.lookup_code','cg.meaning']);
    
            $priceUnit = DB::raw("(SELECT operand FROM ptom_price_list_line_v
                WHERE ptom_price_list_line_v.list_header_id = plh.list_header_id
                AND ptom_price_list_line_v.item_id = cql.item_id
            ) as price_unit");
            foreach($quota_group as $qitem){
                $quota = DB::table('ptom_customer_quota_headers as cqh')
                ->select(
                    'cqh.quota_header_id',
                    'cqh.quota_number',
                    'cqh.start_date',
                    'cqh.end_date',
                    'cqh.status',
    
                    'plh.list_header_id',
                    'plh.name as price_header_name',
                    // 'pll.operand',
    
                    'qcg.quota_credit_id',
                    'qcg.credit_group_code',
    
                    'cql.quota_line_id',
                    'cql.item_id',
                    'cql.item_code',
                    'cql.item_description',
                    'cql.received_quota',
                    'cql.minimum_quota',
                    'cql.remaining_quota',
                    $priceUnit
                )
                ->join('ptom_customer_quota_lines as cql', 'cql.quota_header_id', '=', 'cqh.quota_header_id')
                ->leftJoin('ptom_quota_and_credit_group as qcg', 'qcg.item_id', '=', 'cql.item_id')
    
                ->join('ptom_customers as c', 'c.customer_id', '=', 'cqh.customer_id')
                ->join('ptom_price_list_head_v as plh', 'plh.list_header_id', '=', 'c.price_list_id')
                // ->join('ptom_price_list_line_v as pll', 'pll.list_header_id', '=', 'plh.list_header_id')
                ->where('cqh.start_date','<=',date('Y-m-d'))
                ->where('cqh.end_date','>=',date('Y-m-d'))
                ->where('cqh.customer_id', $item->customer_id)
                ->where('qcg.quota_group_code',$qitem->lookup_code)
                ->get();
                if(count($quota) > 0){
                    foreach ($quota as $_q) {$customer_quota[] = $_q;}
                    // $customer_quota[] = $quota;
                }
    
            }
            $line_item = DB::table('PTOM_ORDER_LINES')->where('ORDER_HEADER_ID', $item->order_header_id)->get();
            foreach ($line_item as $line) {
                $quantity = $line->total_amount/1000;
                $sum = 0;
                foreach($customer_quota as $_q) {
                    if($_q->item_code==$line->item_code) $sum+=$_q->remaining_quota;
                }
                if($quantity>$sum) {
                    $item->is_over_quota = true;
                }
            }
            

            if ($item->credit_amount != 0) {
                if ($item->credit_amount == $item->sumamount) {
                    $item->statusAmount = 2;
                } else {
                    if ($item->payment_duedate == null || Carbon::now() < $item->payment_duedate) {
                        $item->statusAmount = 0;
                    } else {
                        $item->statusAmount = 1;
                    }
                }
            } else {
                if ($item->cash_amount <= $item->sumamount && $item->cash_amount!=0) {
                    $item->statusAmount = 2;
                } else {
                    $item->statusAmount = 1;
                }
            }
        }
        $approver = DB::table('PTOM_APPROVER_ORDERS')->select(['APPROVER_NAME', 'APPROVER_ORDER_ID'])->get();
        return view('om.approve.index', compact(['order','approver','customerList']));
    }
    public function searchItem (Request $request) {
        // return $request->customer_id;
        // return $request->all();
        $match = DB::table('PTOM_PAYMENT_MATCH_INVOICES')
        ->selectRaw('INVOICE_ID as invoice,PREPARE_ORDER_NUMBER,max(DUE_DATE) as maxdate,sum(PAYMENT_AMOUNT) as sumamount')
        ->groupBy('PREPARE_ORDER_NUMBER', 'INVOICE_ID');
        $data = DB::table('PTOM_ORDER_HEADERS')->leftJoin('PTOM_CUSTOMERS', 'PTOM_ORDER_HEADERS.CUSTOMER_ID', '=', 'PTOM_CUSTOMERS.CUSTOMER_ID')->where('PTOM_ORDER_HEADERS.PERIOD_ID','!=',1);
        if($request->customer_id) {
            $data = $data->where('PTOM_ORDER_HEADERS.CUSTOMER_ID', $request->customer_id);
        }
        if($request->preparation) {
            $data = $data->where('PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER', $request->preparation);
        }
        if($request->invoice_number) {
            $data = $data->where('PTOM_ORDER_HEADERS.PICK_RELEASE_NO', $request->invoice_number);
        }
        if($request->invoice_status) {
            $data = $data->where('PTOM_ORDER_HEADERS.PICK_RELEASE_STATUS', $request->invoice_status=='Confirm' ? 'Y' : NULL);
        }
        if($request->order_status) {
            $data = $data->where('PTOM_ORDER_HEADERS.PICK_RELEASE_APPROVE_FLAG', $request->order_status=='อนุมัติ' ? 'Y' : NULL);
        }
        
        if($request->startdate && $request->enddate) {
            $data = $data->whereBetween('PTOM_ORDER_HEADERS.DELIVERY_DATE', [$request->startdate, $request->enddate]);
        }
        
        // return 'asdads';
        // return $request->all();
        $data = $data
            ->leftJoin('PTOM_APPROVER_ORDERS', 'PTOM_ORDER_HEADERS.PICK_RELEASE_APPROVE_BY', '=', 'PTOM_APPROVER_ORDERS.APPROVER_ORDER_ID')
            ->leftJoinSub($match, 'match', 'match.PREPARE_ORDER_NUMBER', 'PTOM_ORDER_HEADERS.PREPARE_ORDER_NUMBER')
            ->where('PAYMENT_APPROVE_FLAG', 'Y')
            ->select([
                'PTOM_ORDER_HEADERS.*',
                'PTOM_APPROVER_ORDERS.APPROVER_NAME as approver_name',
                'match.*'
            ])->get();
        
            foreach($data as $item) {
                $item->is_over_quota = false;
                $customer_quota = [];
    
                $quota_group = DB::table('ptom_quota_group as cg')->where('tag','Y')->get(['cg.lookup_code','cg.meaning']);
        
                $priceUnit = DB::raw("(SELECT operand FROM ptom_price_list_line_v
                    WHERE ptom_price_list_line_v.list_header_id = plh.list_header_id
                    AND ptom_price_list_line_v.item_id = cql.item_id
                ) as price_unit");
                foreach($quota_group as $qitem){
                    $quota = DB::table('ptom_customer_quota_headers as cqh')
                    ->select(
                        'cqh.quota_header_id',
                        'cqh.quota_number',
                        'cqh.start_date',
                        'cqh.end_date',
                        'cqh.status',
        
                        'plh.list_header_id',
                        'plh.name as price_header_name',
                        // 'pll.operand',
        
                        'qcg.quota_credit_id',
                        'qcg.credit_group_code',
        
                        'cql.quota_line_id',
                        'cql.item_id',
                        'cql.item_code',
                        'cql.item_description',
                        'cql.received_quota',
                        'cql.minimum_quota',
                        'cql.remaining_quota',
                        $priceUnit
                    )
                    ->join('ptom_customer_quota_lines as cql', 'cql.quota_header_id', '=', 'cqh.quota_header_id')
                    ->leftJoin('ptom_quota_and_credit_group as qcg', 'qcg.item_id', '=', 'cql.item_id')
        
                    ->join('ptom_customers as c', 'c.customer_id', '=', 'cqh.customer_id')
                    ->join('ptom_price_list_head_v as plh', 'plh.list_header_id', '=', 'c.price_list_id')
                    // ->join('ptom_price_list_line_v as pll', 'pll.list_header_id', '=', 'plh.list_header_id')
                    ->where('cqh.start_date','<=',date('Y-m-d'))
                    ->where('cqh.end_date','>=',date('Y-m-d'))
                    ->where('cqh.customer_id', $item->customer_id)
                    ->where('qcg.quota_group_code',$qitem->lookup_code)
                    ->get();
                    if(count($quota) > 0){
                        foreach ($quota as $_q) {$customer_quota[] = $_q;}
                        // $customer_quota[] = $quota;
                    }
        
                }
                $line_item = DB::table('PTOM_ORDER_LINES')->where('ORDER_HEADER_ID', $item->order_header_id)->get();
                foreach ($line_item as $line) {
                    $quantity = $line->total_amount/1000;
                    $sum = 0;
                    foreach($customer_quota as $_q) {
                        if($_q->item_code==$line->item_code) $sum+=$_q->remaining_quota;
                    }
                    if($quantity>$sum) {
                        $item->is_over_quota = true;
                    }
                }
                if ($item->credit_amount != 0) {
                    if ($item->credit_amount == $item->sumamount) {
                        $item->statusAmount = 2;
                    } else {
                        if ($item->payment_duedate == null || Carbon::now() < $item->payment_duedate) {
                            $item->statusAmount = 0;
                        } else {
                            $item->statusAmount = 1;
                        }
                    }
                } else {
                    if ($item->cash_amount <= $item->sumamount && $item->cash_amount!=0) {
                        $item->statusAmount = 2;
                    } else {
                        $item->statusAmount = 1;
                    }
                }
            }
        return [
            'status' => 'success',
            'result' => $data
        ];
    }
    public function approve (Request $request) {
        foreach ($request->data as $_data) {
            $order_data = DB::table('PTOM_ORDER_HEADERS')
                ->where('ORDER_HEADER_ID', $_data['order_header'])
                ->leftJoin('PTOM_PERIOD_V', 'PTOM_ORDER_HEADERS.PERIOD_ID', '=', 'PTOM_PERIOD_V.PERIOD_LINE_ID')
                ->leftJoin('PTOM_TRANSACTION_TYPES_V', 'PTOM_ORDER_HEADERS.ORDER_TYPE_ID' ,'=', 'PTOM_TRANSACTION_TYPES_V.ORDER_TYPE_ID')
                ->select([
                    'PTOM_ORDER_HEADERS.*',
                    'PTOM_PERIOD_V.BUDGET_YEAR as year',
                    'PTOM_TRANSACTION_TYPES_V.PRODUCT_TYPE as product_type'
                ])
                ->get()[0];
            // return $order_data;
            if(!isset($order_data->pick_release_approve_flag) || $order_data->pick_release_approve_flag!='Y')
            {
                $year = strval(($order_data->year + 543)-2500);
                // $symbol = 
                if(!$order_data->year) $year = '64';
                $symbol = '';
                if(str_contains($order_data->product_type, 'บุหรี่')) {
                    $symbol = 'IL';
                }
                else if(str_contains($order_data->product_type, 'ยาเส้น')) {
                    $symbol = 'IO';
                }
                else {
                    $symbol = 'C';
                }
                $running_number = sprintf("%06d", $order_data->order_header_id);
                $invoice_no = $year . $symbol . $running_number;
                DB::table('PTOM_ORDER_HEADERS')->where('ORDER_HEADER_ID', $_data['order_header'])->update([
                    'PICK_RELEASE_APPROVE_FLAG' => 'Y',
                    'PICK_RELEASE_APPROVE_DATE' => Carbon::now(),
                    'PICK_RELEASE_APPROVE_BY' => $_data['approver_id'],
                    // 'PICK_RELEASE_APPROVE_BY' => Auth::user()->user_id,
                    'PICK_RELEASE_STATUS' => 'Confirm',
                    'PICK_RELEASE_ID' => $order_data->order_header_id,
                    'PICK_RELEASE_NO' => $invoice_no
                ]);
            }
                
        }
        $data = DB::table('PTOM_ORDER_HEADERS')->leftJoin('PTOM_CUSTOMERS', 'PTOM_ORDER_HEADERS.CUSTOMER_ID', '=', 'PTOM_CUSTOMERS.CUSTOMER_ID')->where('PTOM_ORDER_HEADERS.PERIOD_ID','!=',1);
        
        
        $data = $data
            ->leftJoin('PTOM_APPROVER_ORDERS', 'PTOM_ORDER_HEADERS.PICK_RELEASE_APPROVE_BY', '=', 'PTOM_APPROVER_ORDERS.APPROVER_ORDER_ID')
            ->select([
                'PTOM_ORDER_HEADERS.*',
                'PTOM_CUSTOMERS.CUSTOMER_NAME as customer_name',
                'PTOM_APPROVER_ORDERS.APPROVER_NAME as approver_name'
            ])->get();
        return [
            'status' => 'success',
            'result' => $data
        ];
        // return $request->all();
    }

    public function cancel (Request $request) {
        foreach ($request->data as $_data) {
                DB::table('PTOM_ORDER_HEADERS')->where('ORDER_HEADER_ID', $_data['order_header'])->update([
                    'PICK_RELEASE_APPROVE_FLAG' => 'N',
                    'PICK_RELEASE_APPROVE_DATE' => NULL,
                    'PICK_RELEASE_APPROVE_BY' => NULL,
                    'PICK_RELEASE_STATUS' => 'Cancel',
                    'PICK_RELEASE_ID' => NULL,
                    'PICK_RELEASE_NO' => NULL
                ]);
                
        }
        $data = DB::table('PTOM_ORDER_HEADERS')
            ->leftJoin('PTOM_CUSTOMERS', 'PTOM_ORDER_HEADERS.CUSTOMER_ID', '=', 'PTOM_CUSTOMERS.CUSTOMER_ID')
            ->where('PTOM_ORDER_HEADERS.PERIOD_ID','!=',1)
            ->leftJoin('PTOM_APPROVER_ORDERS', 'PTOM_ORDER_HEADERS.PICK_RELEASE_APPROVE_BY', '=', 'PTOM_APPROVER_ORDERS.APPROVER_ORDER_ID')
            ->select([
                'PTOM_ORDER_HEADERS.*',
                'PTOM_CUSTOMERS.CUSTOMER_NAME as customer_name',
                'PTOM_APPROVER_ORDERS.APPROVER_NAME as approver_name'
            ])->get();
        return [
            'status' => 'success',
            'result' => $data
        ];
    }
}
