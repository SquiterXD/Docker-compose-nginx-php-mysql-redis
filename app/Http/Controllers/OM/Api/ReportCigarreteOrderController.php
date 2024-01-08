<?php

namespace App\Http\Controllers\OM\Api;

use App\Http\Controllers\Controller;
use App\Models\OM\Api\OrderCreditGroup;
use App\Models\OM\reports\PtomSoOutstandingV;
use App\Models\OM\Rma\Customers;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportCigarreteOrderController extends Controller
{
    public function fetchSoOutStanding(Request $request)
    {
        $results = [];
        $query = [];
        $sum = [];
        if (empty($request['customer_number']) || empty($request['pick_release_approve_date_start']) || empty($request['pick_release_approve_date_end'])) {
            return ['data' =>  $results, 'count' => count($query), 'sum' => $sum];
        }
        // ---------------------------------------------------
        $start_date = Carbon::createFromFormat('Y-m-d', $request['pick_release_approve_date_start'])->format('Y-m-d');
        $end_date = Carbon::createFromFormat('Y-m-d', $request['pick_release_approve_date_end'])->format('Y-m-d');
        $query = \DB::select("SELECT a.customer_number,
                                   SUM( approve_quantity ),
                                   a.item_id,
                                   a.item_code,
                                   a.item_description,
                                   a.screen_number,
                                   SUM( order_quantity ) AS order_quantity,
                                   SUM( approve_quantity ) AS approve_quantity ,
                                   SUM( amount ) AS amount ,
                                   SUM( amount_1) as  amount_1,
                                   SUM( amount_2 ) AS amount_2,
                                   SUM(order_cardboardbox)      order_cardboard_box,
                                   SUM(order_carton )           order_cartons,
                                   SUM(approve_cardboardbox)    approve_cardboard_box,
                                   SUM(approve_carton )         approve_cartons,
                                   uom_code,
                                   quota_group_code,
                                   meaning
                            FROM
                               (
                               SELECT
                                   c.customer_number,
                                   c.order_line_id,
                                   c.item_id,
                                   c.item_code,
                                   c.item_description,
                                   screen_number,
                                   SUM( c.order_quantity ) AS order_quantity,
                                   SUM( c.approve_quantity ) AS approve_quantity,
                                   SUM( c.amount ) AS amount,
                                   ( SELECT SUM( b.amount ) FROM ptom_order_credit_groups b WHERE b.credit_group_code = '0' AND b.order_line_id = c.order_line_id ) AS amount_1,
                                   ( SELECT SUM( a.amount ) FROM ptom_order_credit_groups a WHERE a.credit_group_code <> '0' AND a.order_line_id = c.order_line_id ) AS amount_2,
                                   c.UOM_CODE,
                                    sum(nvl(line.order_cardboardbox,0))    order_cardboardbox
                                   ,sum(nvl(line.approve_cardboardbox,0))  approve_cardboardbox
                                   ,sum(nvl(line.order_carton,0))          order_carton
                                   ,sum(nvl(line.approve_carton,0))        approve_carton
                            FROM
                                ptom_so_outstanding_v        c
                                ,ptom_order_lines            line
                            WHERE 1=1
                            AND line.order_header_id = c.order_header_id
                            AND line.item_id         = c.item_id
                            AND customer_number = '{$request['customer_number']}'
                            AND TRUNC(pick_release_approve_date) BETWEEN TO_DATE('{$start_date}', 'yyyy-mm-dd') AND TO_DATE('{$end_date}', 'yyyy-mm-dd')
                            GROUP BY
                                   customer_number,
                                   c.order_line_id,
                                   c.item_id,
                                   c.item_code,
                                   c.item_description ,
                                   screen_number,
                                   c.UOM_CODE,
                                   product_type_code
                                ) a
                                ,PTOM_QUOTA_AND_CREDIT_GROUP pqa
                                ,PTOM_QUOTA_GROUP            pqg
                            WHERE 1=1
                            AND quota_group_code = lookup_code
                            AND a.item_id =   pqa.item_id(+)
                            GROUP BY
                               customer_number,
                               a.item_id,
                               a.item_code,
                               a.screen_number,
                               a.item_description,
                               a.uom_code,
                               quota_group_code ,
                               meaning
                            ORDER BY 
                               screen_number
                            ");
        if ($query) {
            $data = collect($query);
            $sum['order_cardboard_box'] = $data->sum('order_cardboard_box');
            $sum['order_cartons'] = $data->sum('order_cartons');
            $sum['order_quantity'] = $data->sum('order_quantity');
            $sum['approve_cardboard_box'] = $data->sum('approve_cardboard_box');
            $sum['approve_cartons'] = $data->sum('approve_cartons');
            $sum['approve_quantity'] = $data->sum('approve_quantity');
            $sum['amount'] = $data->sum('amount');
            $sum['amount_1'] = $data->sum('amount_1');
            $sum['amount_2'] = $data->sum('amount_2');

            $slice = $data->slice($request->start)->take($request->length);
            $data = $slice->map(function($item) {
                $item->order_cardboard_box = number_format($item->order_cardboard_box, 2);
                $item->order_cartons = number_format($item->order_cartons, 2);
                $item->order_quantity = number_format($item->order_quantity, 2);
                $item->approve_cardboard_box = number_format($item->approve_cardboard_box, 2);
                $item->approve_cartons = number_format($item->approve_cartons, 2);
                $item->approve_quantity = number_format($item->approve_quantity, 2);
                $item->amount = number_format($item->amount, 2);
                $item->amount_1 = number_format($item->amount_1, 2);
                $item->amount_2 = number_format($item->amount_2, 2);
                return $item;
            });

            foreach($data as $item) {
                $results[] = $item;
            }
        }

        return ['data' =>  $results, 'count' => count($query), 'sum' => $sum];

        // ----------------------------------------------------------------------------
        $query = PtomSoOutstandingV::query()
            ->select('customer_number', 'order_line_id', 'item_code', 'item_description', \DB::raw('SUM(order_quantity) as order_quantity'), \DB::raw('SUM(approve_quantity) as approve_quantity'), \DB::raw('SUM(amount) as amount'))
            ->join((new OrderCreditGroup)->getTable(), (new OrderCreditGroup)->getTable() . '.order_line_id', '=', (new PtomSoOutstandingV)->getTable() . '.order_line_id');
        $start_date = Carbon::createFromFormat('d/m/Y', $request['pick_release_approve_date_start'])->addYears('-543')->format('Y-m-d');
        $end_date = Carbon::createFromFormat('d/m/Y', $request['pick_release_approve_date_end'])->addYears('-543')->format('Y-m-d');


        $query->whereNotNull((new PtomSoOutstandingV())->getTable() . '.order_line_id');

        if ((!empty($request->start) || $request->start == '0') && !empty($request->length)) {
            $query->skip($request->start)->take($request->length);
        }

        $query->where('customer_number', $request['customer_number']);
        $query->whereRaw("TRUNC(pick_release_approve_date) BETWEEN TO_DATE('{$start_date}', 'yyyy-mm-dd') AND TO_DATE('{$end_date}', 'yyyy-mm-dd')");
        $result = $query
            ->groupBy('customer_number', 'order_line_id', 'item_code', 'item_description')
            ->get();



        $result = $result->map(function ($item) {
            // $item->amout_1 = number_format(OrderCreditGroup::where('order_line_id', $item->order_line_id)->where('credit_group_code', '0')->sum('amount'));
            // $item->amout_2 = number_format(OrderCreditGroup::where('order_line_id', $item->order_line_id)->where('credit_group_code', '<>', '0')->sum('amount'));
            $item->amount = number_format($item->amount);
            $item->order_quantity = number_format($item->order_quantity);
            $item->approve_quantity = number_format($item->approve_quantity);
            return $item;
        });
        if ((!empty($request->start) || $request->start == '0') && !empty($request->length)) {
            $dateStart = \Carbon\Carbon::createFormFormat('Y-m-d', $request->year .'-'. $request->month.'-01');
            return ['data' => $result, 'count' => count(PtomSoOutstandingV::where('customer_number', $request['customer_number'])
                ->whereRaw("TRUNC(pick_release_approve_date) BETWEEN TO_DATE('{$start_date}', 'yyyy-mm-dd') AND TO_DATE('{$end_date}', 'yyyy-mm-dd')")
                ->select('customer_number', 'item_code', 'item_description', \DB::raw('SUM(order_quantity) as order_quantity'), \DB::raw('SUM(approve_quantity) as approve_quantity'), \DB::raw('SUM(amount) as amount'))
                ->groupBy('customer_number', 'item_code', 'item_description')->get())];
        }
        return $result;
    }

    public function fetchCustomers(Request $request)
    {
        $query = Customers::query();
        $query->where('status', 'Active');
        return $query->get();
    }
}
