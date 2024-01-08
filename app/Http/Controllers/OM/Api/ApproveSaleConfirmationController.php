<?php

namespace App\Http\Controllers\OM\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OM\Api\Customer;
use App\Models\OM\Api\OrderHeader;
use App\Models\OM\Api\ApproverOrder;
use App\Models\OM\Api\OrderStatusHistory;
use App\Repositories\OM\OrderRepo;
use App\Repositories\OM\GenerateNumberRepo;
use App\Models\OM\AttachFiles;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

class ApproveSaleConfirmationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response['customers'] = Customer::byCustomerExport();
        $response['approver'] = DB::table('ptom_approver_orders')
        ->whereNotNull('employee_id')
        ->where('attribute1','EXPORT')
        ->where('start_date','<=',now())
        ->where(function($query) {
            $query->where('end_date','>=',now());
            $query->orWhereNull('end_date');
        })
        ->get();
        // $response['orderNumber'] = OrderHeader::whereRaw("lower(order_status) = 'draft'")->whereRaw("lower(sales_classification_code) = 'export'")->whereNotNull("order_number")->get();

        $selectStatusHistory = OrderRepo::selectStatusHistory();

        $response['orderNumber'] = DB::table('ptom_order_headers')
        ->select(
            'ptom_order_headers.*'
        )
        ->join('ptom_customers', 'ptom_customers.customer_id', '=', 'ptom_order_headers.customer_id')
        ->join('ptom_payment_type', 'ptom_payment_type.lookup_code', '=', 'ptom_order_headers.payment_type_code')
        ->whereRaw("lower(sales_classification_code) = 'export'")
        // ->whereRaw("lower(order_status) = 'draft'")
        ->whereRaw("lower(${selectStatusHistory}) != 'draft'")
        ->whereRaw("lower(${selectStatusHistory}) != 'cancelled'")
        ->whereRaw("lower(${selectStatusHistory}) != 'cancel'")
        ->whereNotNull("grand_total")
        ->whereRaw("grand_total != '0'")
        ->whereNotNull("order_number")
        ->orderBy('ptom_order_headers.order_date','DESC')
        ->get();


        // $response['orders'] = OrderHeader::join('ptom_customers as c', 'c.customer_id', '=', 'ptom_order_headers.customer_id')

        $order_history = DB::raw("(SELECT ptom_order_history.order_status FROM ptom_order_history
             WHERE ptom_order_headers.order_header_id = ptom_order_history.order_header_id AND deleted_at IS NULL ORDER BY ptom_order_history.order_history_id DESC OFFSET 0 ROWS FETCH NEXT 1 ROWS ONLY) as history_status"); // สถานะล่าสุด


        $response['orders'] = DB::table('ptom_order_headers')
        ->select(
            'ptom_order_headers.*',
            'ptom_customers.*',
            'ptom_payment_type.*',
            $order_history
        )
        ->join('ptom_customers', 'ptom_customers.customer_id', '=', 'ptom_order_headers.customer_id')
        ->join('ptom_payment_type', 'ptom_payment_type.lookup_code', '=', 'ptom_order_headers.payment_type_code')
        ->whereRaw("lower(sales_classification_code) = 'export'")
        // ->whereRaw("lower(order_status) = 'draft'")
        ->whereRaw("lower(${selectStatusHistory}) != 'draft'")
        ->whereRaw("lower(${selectStatusHistory}) != 'cancelled'")
        ->whereRaw("lower(${selectStatusHistory}) != 'cancel'")
        ->whereNotNull("grand_total")
        ->whereRaw("grand_total != '0'")
        ->whereNotNull("order_number")
        ->where(function($query) {
            if(request()->order_number && request()->order_number != ''){
                $query->whereRaw("ptom_order_headers.order_number like '%".request()->order_number."%' ");
            }

            if(request()->customer_number && request()->customer_number != ''){
                $query->where('ptom_customers.customer_number', request()->customer_number);
            }

            if(request()->from_date && request()->from_date != ''){
                if (request()->to_date == '') {
                    $query->where('ptom_order_headers.order_date','>=', request()->from_date.' 00:00:00');
                    $query->where('ptom_order_headers.order_date','<=', request()->from_date.' 23:59:59');
                }else{
                    $query->where('ptom_order_headers.order_date', '>=', request()->from_date.' 00:00:00');
                }
            }

            if(request()->to_date && request()->to_date != ''){
                $query->where('ptom_order_headers.order_date', '<=', request()->to_date.' 23:59:59');
            }

            if(request()->status && request()->status != ''){
                if(request()->status == 'N'){
                    $query->whereNull("ptom_order_headers.sale_confirm_flag");
                }else{
                    $query->whereRaw("ptom_order_headers.sale_confirm_flag = '".request()->status."' ");
                }
            }

        })
        ->orderBy('ptom_order_headers.order_date','DESC')
        ->get();

        return response()->json(['data' => $response]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function uploadAttachment(Request $request)
    {

        if($request->all()){
            $file_list = [];

            $dateNow = now();

            $attachment = new AttachFiles();
            $attachment->attachment_program_code = $request->program_code;
            $attachment->header_id = $request->header_id;
            $attachment->file_name = $request->file_name;
            $attachment->path_name = $request->path_name;
            $attachment->program_code = $request->program_code;
            $attachment->creation_date = $dateNow;
            $attachment->created_by = 1;
            $attachment->last_updated_by = 1;
            $attachment->save();

            $file_list[] = $filename;
        }

        return response()->json(['data'=>$file_list,'message' => 'File','status'=>true]);

    }

    public function removeAttachment(Request $request)
    {

        if($request->all()){
            $attachment = AttachFiles::where('header_id','=',$request->header_id)->where('file_name',$request->file_name)->where('attachment_program_code','=',$request->program_code)->first();

            $now = Carbon::now();

            if(isset($attachment) && !empty($attachment)){
                $attachment->deleted_at = $now;
                $attachment->save();
            }
        }

        return response()->json(['data'=>[],'message' => 'File','status'=>true]);

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        foreach ($request->list as $key => $item) {

            $orderHeader = OrderHeader::where('order_header_id',$item['order_header_id'])->first();

            if($item['sale_confirm_flag'] == 'Y'){

                if(is_null($orderHeader->prepare_order_number)){
                    $newSaNumber = GenerateNumberRepo::generateSaleConfirmation('OMP0064_SA_NUM_EXP');
                    $orderHeader->prepare_order_number = $newSaNumber;
                    $orderHeader->save();
                }

                if($item['sale_confirm_date'] != ''){
                    $orderHeader->sale_confirm_date = $item['sale_confirm_date'];
                }

                $orderHeader->sale_confirm_flag = $item['sale_confirm_flag'];
                $orderHeader->sale_confirm_document_no = $item['sale_confirm_document_no'];
                $orderHeader->sale_confirm_by = $item['sale_confirm_by'];
                $orderHeader->sa_status = 'Draft';
                $orderStatus = 'Inprocess';
                $orderHeader->order_status = 'Confirm';

                OrderRepo::insertOrdersHistoryv2($orderHeader,$orderStatus);

                $orderHeader->save();
            }else{
                $orderHeader->prepare_order_number = '';
                $orderHeader->sale_confirm_flag = $item['sale_confirm_flag'];
                $orderHeader->sale_confirm_by = $item['sale_confirm_by'];
                $orderHeader->sa_status = '';
                $orderHeader->order_status = 'Draft';
                $orderStatus = 'Draft';

                $orderHeader->save();

                $order_history = OrderStatusHistory::where('order_header_id',$orderHeader->order_header_id)->where('order_status','!=','Draft')->whereNull('deleted_at')->orderBy('order_history_id','DESC')->get();

                foreach ($order_history as $key => $v) {
                    $v->deleted_at = Carbon::now();
                    $v->save();
                }

            }

        }

        return response()->json(['data' => $request->list]);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}