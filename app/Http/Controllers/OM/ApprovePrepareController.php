<?php

namespace App\Http\Controllers\OM;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ApprovePrepareController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $match = DB::table('PTOM_PAYMENT_MATCH_INVOICES')
            ->selectRaw('PREPARE_ORDER_NUMBER,max(DUE_DATE) as maxdate,sum(PAYMENT_AMOUNT) as sumamount')
            ->groupBy('PREPARE_ORDER_NUMBER');

        $data = DB::table('ptom_order_headers as header')
            ->leftjoin('ptom_customers as c', 'c.customer_id', 'header.customer_id')
            ->where('header.order_status', 'Confirm')
            ->whereNotNull('header.PREPARE_ORDER_NUMBER')
            ->select([
                'header.order_header_id as id',
                'header.PAYMENT_HEADER_ID as payment_id',
                'header.PAYMENT_APPROVE_FLAG as confirm',
                'header.PREPARE_ORDER_NUMBER as number',
                'header.delivery_date',
                'header.credit_amount',
                'header.cash_amount',
                'c.customer_name',
                'c.customer_number',
                'header.grand_total',
                'header.PAYMENT_DUEDATE',
                'match.sumamount'
            ])
            ->leftJoinSub($match, 'match', 'match.PREPARE_ORDER_NUMBER', 'header.PREPARE_ORDER_NUMBER')
            ->get();

        foreach ($data as $item) {

            if ($item->credit_amount != 0) {
                if ($item->grand_total <= $item->sumamount) {
                    $item->statusAmount = 2;
                } else {
                    if ($item->payment_duedate == null || Carbon::now() < $item->payment_duedate) {
                        $item->statusAmount = 0;
                    } else {
                        $item->statusAmount = 1;
                    }
                }
            } else {
                if ($item->grand_total <= $item->sumamount && $item->cash_amount != 0) {
                    $item->statusAmount = 2;
                } else {
                    $item->statusAmount = 1;
                }
            }
        }

        $customer =  DB::table('PTOM_CUSTOMERS as c')
            ->select(['c.customer_name', 'c.CUSTOMER_NUMBER'])
            ->whereNotNull('c.CUSTOMER_NUMBER')
            ->get();

        return view('om.approveprepare.index', compact('data','customer'));
    }

    public function search(Request $request)
    {
        $match = DB::table('PTOM_PAYMENT_MATCH_INVOICES')
            ->selectRaw('PREPARE_ORDER_NUMBER,max(DUE_DATE) as maxdate,sum(PAYMENT_AMOUNT) as sumamount')
            ->groupBy('PREPARE_ORDER_NUMBER');

        $data = DB::table('ptom_order_headers as header')
            ->leftjoin('ptom_customers as c', 'c.customer_id', 'header.customer_id')
            ->where('header.order_status', 'Confirm')
            ->whereNotNull('header.PREPARE_ORDER_NUMBER')
            ->where(function ($query) use ($request) {
                if ($request->date_first != "" && $request->date_last != "") {
                    $query->whereBetween('header.delivery_date', [$request->date_first, $request->date_last]);
                }
                if ($request->order_number != "") {
                    $query->where('header.PREPARE_ORDER_NUMBER', '=', $request->order_number);
                }
                if ($request->customer_number != "") {
                    $query->where('c.customer_number', $request->customer_number);
                }
                if ($request->confirm != "") {
                    if ($request->confirm == "N")
                        $query->where(function ($query2) {
                            $query2->where('header.PAYMENT_APPROVE_FLAG', 'N')
                                ->orWhereNull('header.PAYMENT_APPROVE_FLAG');
                        });
                    else
                        $query->where('header.PAYMENT_APPROVE_FLAG', 'Y');
                }
                if ($request->status != "") {
                    if ($request->status == "1") {
                        $query->where(function ($query2) {
                            $query2->where('header.grand_total', '>', 'match.sumamount')
                                ->orWhere('header.credit_amount', 0)
                                ->orWhereNull('header.credit_amount')
                                ->orWhere('header.cash_amount', 0)
                                ->orWhereNull('header.cash_amount');
                        });
                    } else if ($request->status == "2") {
                        $query->whereNotNull('match.sumamount')
                            ->where('match.sumamount', '!=', 0)
                            ->Where('header.grand_total', '<=', 'match.sumamount');
                    }
                }
            })
            ->select([
                'header.order_header_id as id',
                'header.PAYMENT_HEADER_ID as payment_id',
                'header.PAYMENT_APPROVE_FLAG as confirm',
                'header.PREPARE_ORDER_NUMBER as number',
                'header.delivery_date',
                'header.credit_amount',
                'header.cash_amount',
                'c.customer_name',
                'c.customer_number',
                'header.grand_total',
                'header.PAYMENT_DUEDATE',
                'match.sumamount'
            ])
            ->leftJoinSub($match, 'match', 'match.PREPARE_ORDER_NUMBER', 'header.PREPARE_ORDER_NUMBER')
            ->get();


        if ($data) {

            foreach ($data as $item) {

                if ($item->credit_amount != 0) {
                    if ($item->grand_total <= $item->sumamount) {
                        $item->statusAmount = 2;
                    } else {
                        if ($item->payment_duedate == null || Carbon::now() < $item->payment_duedate) {
                            $item->statusAmount = 0;
                        } else {
                            $item->statusAmount = 1;
                        }
                    }
                } else {
                    if ($item->grand_total <= $item->sumamount && $item->cash_amount != 0) {
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
            // return $data->CUSTOMER_NAME;
        }
        return [
            'status' => 'failed',
            'result' => 'no data'
        ];
    }

    public function searchCustomer()
    {
        // return $request->all();
        // return 'asdads';
        $data = DB::table('PTOM_CUSTOMERS as c')
            ->select(['c.customer_name', 'c.CUSTOMER_NUMBER'])
            ->whereNotNull('c.CUSTOMER_NUMBER')
            ->get();

        if ($data) {
            return [
                'status' => 'success',
                'result' => $data
            ];
            // return $data->CUSTOMER_NAME;
        }
        return [
            'status' => 'failed',
            'result' => ''
        ];
    }

    public function confirmOrder(Request $request)
    {
        foreach ($request->key as $item) {

            DB::table('ptom_order_headers as header')
                ->where('header.PREPARE_ORDER_NUMBER', '=', $item)
                ->update(['PAYMENT_APPROVE_FLAG' => 'Y']);
        }

        $match = DB::table('PTOM_PAYMENT_MATCH_INVOICES')
            ->selectRaw('PREPARE_ORDER_NUMBER,max(DUE_DATE) as maxdate,sum(PAYMENT_AMOUNT) as sumamount')
            ->groupBy('PREPARE_ORDER_NUMBER');

        $data = DB::table('ptom_order_headers as header')
            ->leftjoin('ptom_customers as c', 'c.customer_id', 'header.customer_id')
            ->where('header.order_status', 'Confirm')
            ->whereNotNull('header.PREPARE_ORDER_NUMBER')
            ->select([
                'header.order_header_id as id',
                'header.PAYMENT_HEADER_ID as payment_id',
                'header.PAYMENT_APPROVE_FLAG as confirm',
                'header.PREPARE_ORDER_NUMBER as number',
                'header.delivery_date',
                'header.credit_amount',
                'header.cash_amount',
                'c.customer_name',
                'c.customer_number',
                'header.grand_total',
                'header.PAYMENT_DUEDATE',
                'match.sumamount'
            ])
            ->leftJoinSub($match, 'match', 'match.PREPARE_ORDER_NUMBER', 'header.PREPARE_ORDER_NUMBER')
            ->get();

        foreach ($data as $item) {

            if ($item->credit_amount != 0) {
                if ($item->grand_total <= $item->sumamount) {
                    $item->statusAmount = 2;
                } else {
                    if ($item->payment_duedate == null || Carbon::now() < $item->payment_duedate) {
                        $item->statusAmount = 0;
                    } else {
                        $item->statusAmount = 1;
                    }
                }
            } else {
                if ($item->grand_total <= $item->sumamount && $item->cash_amount != 0) {
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

    public function cancelOrder(Request $request)
    {
        foreach ($request->key as $item) {
            $match = DB::table('PTOM_PAYMENT_MATCH_INVOICES')
                ->where('PREPARE_ORDER_NUMBER', '=', $item)
                ->select(['PAYMENT_MATCH_ID as id'])
                ->get()->first();

            if ($match == null) {
                DB::table('ptom_order_headers as header')
                    ->where('header.PREPARE_ORDER_NUMBER', '=', $item)
                    ->update(['PAYMENT_APPROVE_FLAG' => 'N', 'order_status' => 'Cancel']);
            }
        }

        $match = DB::table('PTOM_PAYMENT_MATCH_INVOICES')
            ->selectRaw('PREPARE_ORDER_NUMBER,max(DUE_DATE) as maxdate,sum(PAYMENT_AMOUNT) as sumamount')
            ->groupBy('PREPARE_ORDER_NUMBER');

        $data = DB::table('ptom_order_headers as header')
            ->leftjoin('ptom_customers as c', 'c.customer_id', 'header.customer_id')
            ->where('header.order_status', 'Confirm')
            ->whereNotNull('header.PREPARE_ORDER_NUMBER')
            ->select([
                'header.order_header_id as id',
                'header.PAYMENT_HEADER_ID as payment_id',
                'header.PAYMENT_APPROVE_FLAG as confirm',
                'header.PREPARE_ORDER_NUMBER as number',
                'header.delivery_date',
                'header.credit_amount',
                'header.cash_amount',
                'c.customer_name',
                'c.customer_number',
                'header.grand_total',
                'header.PAYMENT_DUEDATE',
                'match.sumamount'
            ])
            ->leftJoinSub($match, 'match', 'match.PREPARE_ORDER_NUMBER', 'header.PREPARE_ORDER_NUMBER')
            ->get();

        foreach ($data as $item) {

            if ($item->credit_amount != 0) {
                if ($item->grand_total <= $item->sumamount) {
                    $item->statusAmount = 2;
                } else {
                    if ($item->payment_duedate == null || Carbon::now() < $item->payment_duedate) {
                        $item->statusAmount = 0;
                    } else {
                        $item->statusAmount = 1;
                    }
                }
            } else {
                if ($item->grand_total <= $item->sumamount && $item->cash_amount != 0) {
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
}
