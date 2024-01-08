<?php

namespace App\Http\Controllers\OM\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\Api\OrderHeader;
use App\Models\OM\Api\OrderLines;
use App\Models\OM\Api\OrderStatusHistory;
use App\Models\OM\Api\Customer;
use App\Models\OM\PeriodV;
use App\Models\OM\FollowDomesticOrdersV;
use App\Models\OM\FollowExportOrdersV;
use App\Models\OM\Customers\Domestics\DayModel;

use App\Repositories\OM\OrderRepo;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderTrackingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function searchExport($number)
    {
        $response = [];

        $response['customers'] = [];
        $response['customer'] = [];
        $response['payment'] = OrderRepo::getPaymentType();
        $response['orderList'] = [];
        $response['customers'] = OrderRepo::getByTypeCustomer('export');

        if($number != '0'){
            $customer = Customer::where('customer_number',$number)->orderBy('customer_id','ASC')->first();
            $response['orderList'] = OrderHeader::where('customer_id',$customer->customer_id)->whereNull('deleted_at')->whereNotNull('order_number')->whereRaw("ptom_order_headers.program_code != 'OMP0020'")->orderBy('order_number','DESC')->get();
        }else{
            $response['orderList'] = OrderHeader::join('ptom_customers', 'ptom_customers.customer_id', '=', 'ptom_order_headers.customer_id')
            ->whereRaw("lower(ptom_customers.sales_classification_code) = 'export'")
            ->whereNotNull('ptom_order_headers.order_number')
            ->whereNull('ptom_order_headers.deleted_at')
            ->whereRaw("ptom_order_headers.program_code != 'OMP0020'")
            ->orderBy('ptom_order_headers.order_number','DESC')
            ->get();
        }

        $customer = request()->customer_number ?? $number;
        if(request()->all() && array_key_exists('order_number', request()->all())){
            if($number != '0'){

                $customer = Customer::where('customer_number',$number)->orderBy('customer_id','ASC')->first();
                $response['customer'] = $customer;
                // NEW QUERY 26092022
                $response['order'] = FollowExportOrdersV::where('customer_id', $customer->customer_id)
                                ->where(function($query) {
                                    if(request()->order_number && request()->order_number != ''){
                                        $query->whereRaw("order_number like '%".request()->order_number."%' ");
                                    }

                                    if(request()->payment && request()->payment != 'all'){
                                        $query->where('payment_type_code', request()->payment);
                                    }

                                    if(request()->status && request()->status != 'all' && request()->status != ''){
                                        $query->whereRaw("lower(order_status) = '".request()->status."' ");
                                    }
                                })
                                ->orderBy('order_number', 'DESC')
                                ->paginate(10);
            }else{
                // NEW QUERY 26092022
                $response['order'] = FollowExportOrdersV::where(function($query) {
                                    if(request()->order_number && request()->order_number != ''){
                                        $query->whereRaw("order_number like '%".request()->order_number."%' ");
                                    }

                                    if(request()->payment && request()->payment != 'all'){
                                        $query->where('payment_type_code', request()->payment);
                                    }

                                    if(request()->status && request()->status != 'all' && request()->status != ''){
                                        $query->whereRaw("lower(order_status) = '".request()->status."' ");
                                    }
                                })
                                ->orderBy('order_number', 'DESC')
                                ->paginate(10);
            }
        }else{
            $response['order'] = [];
            // NEW QUERY 26092022
            $customer = Customer::where('customer_number',$number)->orderBy('customer_id','ASC')->first();
            $response['order'] = FollowExportOrdersV::where(function($query) use ($customer) {
                                    if($customer){
                                        $query->where('customer_id', $customer->customer_id);
                                    }
                                })
                                ->orderBy('order_number', 'DESC')
                                ->paginate(10);
            if($number != '0'){
                $response['customer'] = $customer;
            }
        }

        return response()->json(['data' => $response]);
    }

    public function searchDomestic($number)
    {
        // dd(request()->all());
        if(request()->action == 'get_transport_owners') {
            return DB::table('PTOM_TRANSPORT_OWNERS')->where('stop_flag', 'N')->first();
        }
        $response               = [];
        $response['customers']  = [];
        $response['customer']   = [];
        $response['payment']    = OrderRepo::getPaymentType();
        $response['customers']  = OrderRepo::getByTypeCustomer('domestic');

        // New Condition Period Piyawut A. 19012022
        $periods                    = PeriodV::selectRaw("  budget_year+543||'/'||period_no as period_name, 
                                                            start_period, 
                                                            end_period, 
                                                            period_line_id                                      ");
        $currentDate                = date('d-m-Y');
        $response['periods']        = $periods->get();
        $current                    = $periods->whereRaw("  TO_DATE('{$currentDate}','dd-mm-YYYY') BETWEEN 
                                                            trunc(start_period) AND trunc(end_period)           ")
                                              ->first();
        $response['default_period'] = $current ? $current->period_line_id : '';
        $customer                   = request()->customer_number ?? $number;

        if($number != '0'){
            $customer = Customer::where('customer_number',$customer)->orderBy('customer_id','ASC')->first();
            $response['orderList'] = OrderHeader::where('customer_id',$customer->customer_id)
                                    ->whereNull('deleted_at')
                                    ->whereNotNull('order_number')
                                    ->whereRaw("ptom_order_headers.program_code != 'OMP0020'")
                                    ->orderBy('order_number','DESC')
                                    ->take(1000)
                                    ->get();

            // New Condition delivery date Piyawut A. 19012022
            $ompDays = (new DayModel)->getOMPDays(request(), $number, $customer, $response['default_period']);
            $lookupDays = DayModel::selectRaw('lookup_code, meaning, description, enabled_flag')
                                    ->where('enabled_flag', 'Y')
                                    ->checkDayByCustomer($number)
                                    ->orderBy('lookup_code')
                                    ->get();
            $days = $this->mapOMDays($ompDays, $lookupDays);
            $response['default_delivery_date'] = '';
            $response['delivery_date'] = $days;
        }else{
            if (isset(request()->customer_number)) {
                $customer = Customer::where('customer_number',$customer)
                                    ->orderBy('customer_id','ASC')
                                    ->first();
            }

            $response['orderList'] = OrderHeader::join('ptom_customers', 'ptom_customers.customer_id', '=', 'ptom_order_headers.customer_id')
                                                ->whereRaw("lower(ptom_customers.sales_classification_code) = 'domestic'")
                                                ->whereNotNull('ptom_order_headers.order_number')
                                                ->whereNull('ptom_order_headers.deleted_at')
                                                ->whereRaw("ptom_order_headers.program_code != 'OMP0020'")
                                                ->orderBy('ptom_order_headers.order_number','DESC')
                                                ->take(500)
                                                ->get(['order_number']);

            // New Condition delivery date Piyawut A. 19012022
            $ompDays = (new DayModel)->getOMPDays(request(), $number, $customer=null, $response['default_period']);
            $lookupDays = DayModel::selectRaw('lookup_code, meaning, description, enabled_flag')
                                    ->where('enabled_flag', 'Y')
                                    ->checkDayByCustomer()
                                    ->orderBy('lookup_code')
                                    ->get();

            $days = $this->mapOMDays($ompDays, $lookupDays);
            $response['default_delivery_date'] = $customer? $customer->delivery_date: '';
            $response['delivery_date'] = $days;
        }

        if(request()->all() && array_key_exists('period_id', request()->all())){
            if($number != '0'){
                // NEW QUERY 25092022
                $response['order'] = FollowDomesticOrdersV::where('customer_id', $customer->customer_id)
                                ->where(function($query) {
                                    if(request()->order_number){
                                        $query->whereRaw("order_number like '%".request()->order_number."%' ");
                                    }

                                    if(request()->payment && request()->payment != 'all'){
                                        $query->where('lookup_code', request()->payment);
                                    }

                                    if(request()->status && request()->status != 'all' && request()->status != 'active' && request()->status != ''){
                                        $query->whereRaw("lower(order_status) = '".request()->status."' ");
                                    }elseif (request()->status && request()->status == 'active') {
                                        $query->whereRaw("lower(order_status) in ('draft', 'release', 'inprocess', 'wait pay', 'invoice')");
                                    }

                                    if(request()->period_id && request()->period_id != 'all'){
                                        $query->where('period_id', request()->period_id);
                                    }

                                    $deliveryDate = request()->delivery_date == 'all'? '': request()->delivery_date;
                                    if(request()->delivery_date){
                                        // $query->whereRaw("trim(to_char(cust_delivery_date, 'Day', 'nls_date_language=Thai')) like '%{$deliveryDate}%'");
                                        $query->whereRaw("cust_delivery_date like '%{$deliveryDate}%'");
                                    }
                                })
                                ->orderBy('order_number', 'DESC')
                                ->get();
                                // ->paginate(10);
            }else{
                // NEW QUERY 25092022
                $response['order'] = FollowDomesticOrdersV::where(function($query) {
                                    if(request()->order_number){
                                        $query->whereRaw("order_number like '%".request()->order_number."%' ");
                                    }

                                    if(request()->payment && request()->payment != 'all'){
                                        $query->where('payment_type_code', request()->payment);
                                    }

                                    if(request()->status && request()->status != 'all' && request()->status != 'active' && request()->status != ''){
                                        $query->whereRaw("lower(order_status) = '".request()->status."' ");
                                    }elseif (request()->status && request()->status == 'active') {
                                        $query->whereRaw("lower(order_status) in ('draft', 'release', 'inprocess', 'wait pay', 'invoice')");
                                    }

                                    if(request()->period_id && request()->period_id != 'all'){
                                        $query->where('period_id', request()->period_id);
                                    }

                                    $deliveryDate = request()->delivery_date == 'all'? '': request()->delivery_date;
                                    if(request()->delivery_date){
                                        $query->whereRaw("cust_delivery_date like '%{$deliveryDate}%'");
                                    }
                                })
                                ->orderBy('order_number', 'DESC')
                                ->get();
                                // ->paginate(10);
            }
        }else{
            $response['order'] = [];
            // NEW QUERY 25092022
            $response['order'] = FollowDomesticOrdersV::where(function($query) use ($response, $customer) {
                                    $query->where('period_id', $response['default_period']);

                                    if($customer){
                                        $query->where('customer_id', $customer->customer_id);
                                    }
                                })
                                ->orderBy('order_number', 'DESC')
                                ->get();
                                // ->paginate(10);
            if($number != '0'){
                $customer = Customer::where('customer_number',$number)->orderBy('customer_id','ASC')->first();
                $response['customer'] = $customer;
            }
        }

        $additionQuota = DB::table('ptom_addition_quota_headers')->whereIn('order_header_id', $response['order']->pluck('order_header_id'))->get();

        $response['order'] = $response['order']->map(function($i) use($additionQuota) {
            $i->over_quota = $additionQuota->where('order_header_id', $i->order_header_id);
            return $i;
        });

        return response()->json(['data' => $response]);
    }

    public function history($number,$type)
    {
        $response = [];

        $response['customer'] = [];

        $response['payment'] = OrderRepo::getPaymentType();
        $response['order'] = [];
        $response['orderHistory'] = [];

        // if ($number == '0') {
            $response['customer'] = OrderRepo::getByTypeCustomer($type);
        // }
        $response['orderList'] = [];
        if($number != '0'){
            $customer = Customer::where('customer_number',$number)->orderBy('customer_id','ASC')->first();

            $orderList = OrderHeader::join('ptom_customers', 'ptom_customers.customer_id', '=', 'ptom_order_headers.customer_id')
            ->whereRaw("lower(ptom_customers.sales_classification_code) = '".$type."'")
            ->where('ptom_order_headers.customer_id',$customer->customer_id)
            ->whereNull('ptom_order_headers.deleted_at')
            ->whereNotNull('ptom_order_headers.order_number')
            ->whereRaw("ptom_order_headers.program_code != 'OMP0020'")
            ->orderBy('ptom_order_headers.order_header_id','DESC')
            ->when(!empty(request()->search), function($q) {
                $q->where('order_number', "LIKE", "%". request()->search.'%');
            })
            ->when(!empty(request()->period_id), function($q) {
                $q->where('period_id', request()->period_id);
            })
            ->orderBy('order_header_id', 'desc')
            ->take('50')
            ->get();
        }else{
            $orderList = OrderHeader::join('ptom_customers', 'ptom_customers.customer_id', '=', 'ptom_order_headers.customer_id')
            ->whereRaw("lower(ptom_customers.sales_classification_code) = '".$type."'")
            ->whereNotNull('ptom_order_headers.order_number')
            ->whereNull('ptom_order_headers.deleted_at')
            ->whereRaw("ptom_order_headers.program_code != 'OMP0020'")
            ->orderBy('ptom_order_headers.order_header_id','DESC')
            ->orderBy('order_header_id', 'desc')
            ->when(!empty(request()->search), function($q) {
                $q->where('order_number', "LIKE", "%". request()->search.'%');
            })
            ->when(!empty(request()->period_id), function($q) {
                $q->where('period_id', request()->period_id);
            })  
            ->take('50')
            ->get();
        }
        $periods = PeriodV::selectRaw("budget_year+543||'/'||period_no as period_name, start_period, end_period, period_line_id");
        $response['periods'] = $periods->get();
        if(request()->type == 'order_number') {
            return response()->json($orderList);
        }
        if(request()->all()){
            if ($number != '0') {
                $customer = Customer::where('customer_number',$number)->orderBy('customer_id','DESC')->first();

                $response['order'] = DB::table('ptom_order_headers as oh')
                ->select(
                    'oh.order_header_id',
                    'oh.order_number',
                    'oh.pick_release_no',
                    'oh.order_date',
                    'oh.product_type_code',
                    'oh.remark',
                    'oh.order_status',
                    'oh.cash_amount',
                    'oh.credit_amount',
                    'oh.grand_total',
                    'oh.remaining_amount',
                    'oh.fines_amount',
                    'oh.pick_release_approve_date',
                    'oh.payment_type_code',
                    'c.customer_number',
                    'c.customer_name',
                    'c.customer_type_id',
                )
                ->join('ptom_customers as c','c.customer_id','=','oh.customer_id')
                ->where('oh.customer_id',$customer->customer_id)
                ->whereRaw("lower(c.sales_classification_code) = '".$type."' ")
                ->whereNull('oh.deleted_at')
                ->when(!empty(request()->period_id), function($q) {
                    $q->where('period_id', request()->period_id);
                })
                ->whereNotNull('oh.order_number')
                ->whereRaw("oh.program_code != 'OMP0020'")
                // ->whereNotNull('oh.order_status')
                ->where(function($query) {
                    if(request()->order_number){
                        $query->whereRaw("oh.order_number like '%".request()->order_number."%' ");
                    }

                    // if(request()->status){
                    //     $query->whereRaw("lower(
                    //         (
                    //             SELECT ptom_order_history.order_status
                    //             FROM ptom_order_history
                    //             WHERE oh.order_header_id = ptom_order_history.order_header_id AND ptom_order_history.deleted_at IS NULL
                    //             ORDER BY ptom_order_history.order_history_id DESC OFFSET 0 ROWS FETCH NEXT 1 ROWS ONLY
                    //         )
                    //     ) = '".request()->status."' ");
                    //     // $query->whereRaw("lower(oh.order_status) = '".request()->status."' ");
                    // }
                })
                ->take(200)
                ->orderBy('oh.order_header_id','DESC')
                ->get();

                $response['orderHistory'] = [];
                foreach($response['order'] as $item){
                    $orderHistory = OrderStatusHistory::where('order_header_id',$item->order_header_id)->whereNull('deleted_at')->orderBy('order_history_id','ASC')->get();
                    $dataHistory = [];
                    foreach($orderHistory as $item_h){
                        if(!in_array($item_h->order_status,$dataHistory)){
                            $dataHistory[] = $item_h->order_status;
                            $response['orderHistory'][$item->order_header_id][str_replace(' ', '_', strtolower($item_h->order_status))] = $item_h;
                        }
                    }

                }
            }else{
                $response['order'] = DB::table('ptom_order_headers as oh')
                ->select(
                    'oh.order_header_id',
                    'oh.order_number',
                    'oh.pick_release_no',
                    'oh.order_date',
                    'oh.product_type_code',
                    'oh.remark',
                    'oh.order_status',
                    'oh.cash_amount',
                    'oh.credit_amount',
                    'oh.grand_total',
                    'oh.remaining_amount',
                    'oh.fines_amount',
                    'oh.pick_release_approve_date',
                    'oh.payment_type_code',
                    'c.customer_number',
                    'c.customer_name',
                    'c.customer_type_id',
                )
                ->join('ptom_customers as c','c.customer_id','=','oh.customer_id')
                ->whereRaw("lower(c.sales_classification_code) = '".$type."' ")
                ->whereNull('oh.deleted_at')
                ->when(!empty(request()->period_id), function($q) {
                    $q->where('period_id', request()->period_id);
                })
                ->whereNotNull('oh.order_number')
                ->whereRaw("oh.program_code != 'OMP0020'")
                // ->whereNotNull('oh.order_status')
                ->where(function($query) {
                    if(request()->order_number){
                        $query->whereRaw("oh.order_number like '%".request()->order_number."%' ");
                    }

                    // if(request()->status){
                    //     $query->whereRaw("lower(
                    //         (
                    //             SELECT ptom_order_history.order_status
                    //             FROM ptom_order_history
                    //             WHERE oh.order_header_id = ptom_order_history.order_header_id AND ptom_order_history.deleted_at IS NULL
                    //             ORDER BY ptom_order_history.order_history_id DESC OFFSET 0 ROWS FETCH NEXT 1 ROWS ONLY
                    //         )
                    //     ) = '".request()->status."' ");
                    //     // $query->whereRaw("lower(oh.order_status) = '".request()->status."' ");
                    // }
                })
                ->orderBy('oh.order_header_id','DESC')
                ->take(200)
                ->get();

                $response['orderHistory'] = [];
                foreach($response['order'] as $item){
                    $orderHistory = OrderStatusHistory::where('order_header_id',$item->order_header_id)->whereNull('deleted_at')->orderBy('order_history_id','DESC')->get();
                    $dataHistory = [];
                    foreach($orderHistory as $item_h){
                        if(!in_array($item_h->order_status,$dataHistory)){
                            $dataHistory[] = $item_h->order_status;
                            $response['orderHistory'][$item->order_header_id][str_replace(' ', '_', strtolower($item_h->order_status))] = $item_h;
                        }
                    }

                }
            }


        }else{
            $response['orderHistory'] = [];
            $response['order'] = [];
        }

        return response()->json(['data' => $response]);
    }

    public function search($number)
    {
        $response = [];

        $response['customer'] = [];

        $response['payment'] = OrderRepo::getPaymentType();

        if ($number == 0) {
            $response['customer'] = OrderRepo::getAllCustomer();
            $response['order'] = [];
        }else{

            $customer = Customer::where('customer_number',$number)->orderBy('customer_id','DESC')->first();

            $response['order'] = DB::table('ptom_order_headers as oh')
            ->join('ptom_customers as c','c.customer_id','=','oh.customer_id')
            ->join('ptom_payment_type as p','p.lookup_code','=','oh.payment_type_code')
            ->where('oh.customer_id',$customer->customer_id)
            ->where('lower(c.sales_classification_code)','domestic')
            ->whereNull('oh.deleted_at')
            ->whereNotNull('oh.order_status')
            ->whereRaw("oh.program_code != 'OMP0020'")
            ->orderBy('order_date','DESC')
            ->get([
                'oh.order_header_id',
                'oh.order_number',
                'oh.pick_release_no',
                'oh.order_date',
                'oh.remark',
                'oh.order_status',
                'oh.cash_amount',
                'oh.credit_amount',
                'oh.grand_total',
                'oh.payment_type_code',
                'p.meaning as payment_type',
                'c.customer_number',
                'c.customer_name',
                'c.customer_type_id',
            ]);
        }

        return response()->json(['data' => $response]);
    }

    public function poNumberByCustomer($id)
    {
        $response = DB::table('ptom_order_headers as oh')
        ->join('ptom_customers as c','c.customer_id','=','oh.customer_id')
        ->where('oh.customer_id',$id)
        ->whereNull('oh.deleted_at')
        ->whereNotNull('oh.order_status')
        ->whereRaw("oh.program_code != 'OMP0020'")
        ->orderBy('oh.order_header_id','DESC')
        ->get([
            'oh.order_header_id',
            'oh.order_number',
            'oh.pick_release_no',
            'oh.order_date',
            'oh.remark',
            'oh.order_status',
            'oh.cash_amount',
            'oh.credit_amount',
            'oh.grand_total',
            'oh.payment_type_code',

            'c.customer_number',
            'c.customer_name',
            'c.customer_type_id',
        ]);

        return response()->json(['data' => $response]);
    }

    public function store(Request $request)
    {

    }

    public function update(Request $request)
    {

    }

    public function cancel(Request $request)
    {
        // DB::beginTransaction();
        // try {
        //     $orderHeader = OrderHeader::where('order_number',$request->order_number)->first();
        //     $orderHeader->order_status = $request->status;
        //     $orderHeader->last_updated_by = 1;
        //     $orderHeader->last_update_date = now();
        //     $orderHeader->save();

        //     DB::commit();

        //     return response()->json(['status'=>true,'data' =>[]]);

        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     return response()->json(['status'=>false,'data' => [],'message'=>$e->getMessage()]);
        // }
    }

    public function mapOMDays($ompDays, $lookupDays)
    {
        $result = [];
        // pluck
        $orderHistories = collect($ompDays)->pluck('order_history_id', 'order_header_id')->toArray();
        $status = ['Draft', 'Release', 'Inprocess', 'Wait Pay', 'Invoice', 'Cancelled'];
        foreach ($lookupDays as $day) {
            $val = 0;
            foreach ($ompDays as $value) {
                foreach ($orderHistories as $historyVal) {
                    if ($value->order_history_id == $historyVal && in_array($value->order_status, $status)) {
                        if ($day->meaning == $value->delivery_date) {
                            $val += (int)$value->delivery_number;
                        }
                    }
                }
            }
            $result[$day->meaning] = $val;
        }

        return $result;
    }

}
