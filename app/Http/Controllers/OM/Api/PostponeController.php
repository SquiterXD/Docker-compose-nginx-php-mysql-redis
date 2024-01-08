<?php

namespace App\Http\Controllers\OM\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\Api\Postpone;
use App\Models\OM\Customers\Domestics\CustomerOwners;
use App\Models\OM\PeriodV;
use App\Models\OM\PostponeOrders;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PostponeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $postpone = DB::table('ptom_postpone_orders as po')
        ->select('po.*','c.customer_number','c.customer_name','pvf.start_period as from_date','pvt.start_period as to_date')
        ->join('ptom_customers as c', 'c.customer_id', '=', 'po.customer_id')
        ->join('ptom_period_v as pvf', 'pvf.period_line_id', '=', 'po.from_period_id')
        ->join('ptom_period_v as pvt', 'pvt.period_line_id', '=', 'po.to_period_id')
        ->where(function($query) use ($request) {
            if($request->customer_number && $request->customer_number != ''){
                $query->where('c.customer_number', $request->customer_number);
            }

            if($request->date){
                $query->where('po.from_period_date', $request->date);
            }

            if($request->status && $request->status != ''){
                $query->where('po.approve_status', $request->status);
            }
        })
        ->orderBy('po.creation_date','DESC')
        ->get();

        return response()->json(['data' => $postpone]);
    }

    public function searchById(Request $request)
    {
        $postpone = DB::table('ptom_postpone_orders as po')
        ->select(
            'po.*',
            'c.customer_number','c.customer_name','c.province_name','c.contact_prefix','c.contact_first_name','c.contact_last_name',
            'pvf.start_period as from_date','pvt.start_period as to_date'
        )
        ->join('ptom_customers as c', 'c.customer_id', '=', 'po.customer_id')
        ->join('ptom_period_v as pvf', 'pvf.period_line_id', '=', 'po.from_period_id')
        ->join('ptom_period_v as pvt', 'pvt.period_line_id', '=', 'po.to_period_id')
        ->where('po.postpone_order_id', $request->id)
        ->orderBy('po.creation_date','DESC')
        ->first();

        return response()->json(['data' => $postpone]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data = [
            'budget_year'       =>'2021',
            'start_buget_year'  =>'01 MAR 2021',
            'period_line_id'    =>1,
            'period_no'         =>1,
            'start_period'      =>'01 MAR 2021',
            'end_period'        =>'05 MAR 2021',
        ];

        DB::table('ptom_period_v')->insert($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $postpone       = new Postpone();
        $from_date      = date_format(date_create($request->from_period_id),"Y-m-d");
        $to_date        = date_format(date_create($request->to_period_id),"Y-m-d");
        $from_period_id = DB::table('ptom_period_v')
                            ->select('period_line_id')
                            ->whereDate('start_period','<=',$from_date)
                            ->whereDate('end_period','>=',$from_date)
                            ->first();

        $to_period_id   = DB::table('ptom_period_v')
                            ->select('period_line_id')
                            ->whereDate('start_period','<=',$to_date)
                            ->whereDate('end_period','>=',$to_date)
                            ->first();

        if(!isset($to_period_id)){
            return response()->json(['data' => [],'status'=>false,'message'=>'ไม่พบข้อมูลงวดที่']);
        }

        $customerOwners     = CustomerOwners::where("customer_id",$request->customer_id)->whereRaw("lower(status) = 'active'")->orderBy('owner_no')->first();
        $customer_owner_id  = '';

        if (isset($customerOwners) && !empty($customerOwners)) {
            $customer_owner_id = $customerOwners->customer_owner_id;
        }

        DB::beginTransaction();
        try {

            $postpone->org_id               = DB::table('ptom_operating_units_v')
                                                ->where('short_code','TOAT')
                                                ->first()->organization_id;
            $postpone->org_name             = '';
            $postpone->customer_id          = $request->customer_id;
            $postpone->from_period_id       = $request['default_period_id'] ? 
                                              $request['default_period_id'] : 
                                              $from_period_id->period_line_id;
            $postpone->from_period_date     = $from_date;
            $postpone->to_period_id         = $request['default_period_id'] ? 
                                              $request['default_period_id'] : 
                                              $to_period_id->period_line_id;
            $postpone->to_period_date       = $to_date;
            $postpone->order_quantity       = $request->order_quantity;
            $postpone->customer_owner_id    = $customer_owner_id;
            $postpone->uom                  = $request->uom;
            $postpone->order_quantity_2     = $request->order_quantity2;
            $postpone->uom_2                = $request->uom2;
            $postpone->reason               = $request->reason;
            $postpone->approve_status       = 'รอการอนุมัติ';
            $postpone->program_code         = 'OMP0007';
            $postpone->created_by           = $request->customer_id;
            $postpone->last_updated_by      = $request->customer_id;
            
            $postpone->save();

            DB::commit();

            return response()->json(['data' =>$postpone,'status'=>true,'message'=>'ขอเลื่อนการสั่งซื้อสำเร็จ']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status'=>false,'data' => [],'message'=>$e->getMessage()]);
        }


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
    public function update(Request $request, $id)
    {
        $postpone = Postpone::where('postpone_order_id',$id)->first();

        if(!$postpone){
            return response()->json(['data' => [],'status'=>false,'message'=>'ไม่พบข้อมูล']);
        }
        $postpone->approve_status = $request->approve_status;
        $postpone->last_updated_by = $request->last_updated_by;
        $postpone->save();

        return response()->json(['data' => $postpone,'status'=>false,'message'=>'สำเร็จ']);
    }

    public function update_remark(Request $request)
    {
        foreach ($request->postpone as $key => $v) {
            $postpone = Postpone::where('postpone_order_id',$key)->first();
            $postpone->attribute1 = $v;
            $postpone->save();
        }

        return response()->json(['data' => [],'status'=>true,'message'=>'สำเร็จ']);
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

    public function defaultPostPone(Request $request)
    {
        $nowDate = date('m-d-Y', strtotime(Carbon::now()));
        $defaultPeriod = collect(\DB::select("
                            SELECT  *
                            FROM    PTOM_PERIOD_V
                            WHERE   1=1
                            AND start_period <= TO_DATE('{$nowDate}', 'MM/DD/YYYY')
                            AND end_period >= TO_DATE('{$nowDate}', 'MM/DD/YYYY')
                        "))->first();
        $customersPostpone = PostponeOrders::where('from_period_id', $defaultPeriod->period_line_id)
                            // ->where('to_period_id', $defaultPeriod->period_line_id)
                            ->where('approve_status', 'อนุมัติ')
                            ->whereNull('deleted_at')
                            ->where('customer_id', $request['customer']['customer_id'])
                            ->orderBy('postpone_order_id', 'DESC')
                            ->get();
                            
        return response()->json(['data' => $customersPostpone]);
    }
}
