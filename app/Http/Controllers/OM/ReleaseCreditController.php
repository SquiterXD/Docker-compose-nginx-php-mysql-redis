<?php

namespace App\Http\Controllers\OM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\ReleaseCredit;
use App\Models\OM\Customers\Domestics\Customer;
use App\Models\OM\Customers\Domestics\CustomerContractGroups;
use App\Models\OM\OutstandingDebtDomesticV;
use App\Models\OM\PenaltyRateDomesticV;
use App\Repositories\OM\OrderRepo;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReleaseCreditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // if (!canEnter('/om/release-credit') || !canView('/om/release-credit')) {
        //     return redirect()->back()->withErrors(trans('403'));
        // }

        if(request()){
            $customersFind = Customer::where('customer_number','=',request()->customer_number)->whereRaw("lower(sales_classification_code) = 'domestic'")->whereRaw("lower(status) = 'active'")->first();


            try {
                $Outstanding = OrderRepo::setOutstanding($customersFind->customer_id);
            //     $Outstanding = [];

            //     $penaltyRate = PenaltyRateDomesticV::where('enabled_flag','Y')->first();
            //     if(is_null($penaltyRate)){
            //         $amountPenaltyRate = 0;
            //     }else{
            //         $amountPenaltyRate = $penaltyRate->description;
            //     }

            //     $daysInYear = Carbon::parse(date('Y'))->daysInYear;

            //     $OutstandingData = OutstandingDebtDomesticV::where('customer_id',$customersFind->customer_id)->where('outstanding_debt','>',0)->get();

            //     // dd($OutstandingData);
            //     foreach ($OutstandingData as $key => $v) {

            //         $releaseCredit = ReleaseCredit::where('invoice_id',$v->order_header_id)->where('customer_id',$customersFind->customer_id)->where('credit_group_code',$v->credit_group_code)->first();
            //         if(!is_null($releaseCredit)){

            //             // ค่าปรับ
            //             $date = Carbon::parse($v->due_date);
            //             $now = Carbon::parse($releaseCredit->creation_date);
            //             $diff = $date->diffInDays($now);
            //             $penalty_day = (($v->outstanding_debt * $amountPenaltyRate) / 100) / $daysInYear;
            //             $penalty_total = $penalty_day * $diff;
            //             // ค่าปรับ

            //             if($releaseCredit->payment_flag == 'Y'){
            //                 $Outstanding[] = [
            //                     'no'=>$v->pick_release_no.'_'.$v->credit_group_code,
            //                     'pick_release_no'=>$v->pick_release_no,
            //                     'credit_group_code'=>$v->credit_group_code,
            //                     'description'=>'เงินเชื่อกลุ่ม '.$v->credit_group_code,
            //                     'amount'=>$v->outstanding_debt,
            //                     'due_days'=>$v->due_days,
            //                     'date_th'=>dateFormatThai($v->due_date),
            //                     'penalty_percen'=>$amountPenaltyRate,
            //                     'penalty_day'=>$penalty_day,
            //                     'penalty_total'=>number_format((float)$penalty_total, 2, '.', ''),
            //                     'daysInYear'=>$daysInYear,
            //                     'checked'=>'Y',
            //                     'flag'=>'Y'
            //                 ];
            //             }else{
            //                 $Outstanding[] = [
            //                     'no'=>$v->pick_release_no.'_'.$v->credit_group_code,
            //                     'pick_release_no'=>$v->pick_release_no,
            //                     'credit_group_code'=>$v->credit_group_code,
            //                     'description'=>'เงินเชื่อกลุ่ม '.$v->credit_group_code,
            //                     'amount'=>$v->outstanding_debt,
            //                     'due_days'=>$v->due_days,
            //                     'date_th'=>dateFormatThai($v->due_date),
            //                     'penalty_percen'=>$amountPenaltyRate,
            //                     'penalty_day'=>$penalty_day,
            //                     'penalty_total'=>number_format((float)$penalty_total, 2, '.', ''),
            //                     'daysInYear'=>$daysInYear,
            //                     'checked'=>'Y',
            //                     'flag'=>'N'
            //                 ];
            //             }

            //         }else{

            //              // ค่าปรับ
            //              $date = Carbon::parse($v->due_date);
            //              $now = Carbon::parse(now());
            //              $diff = $date->diffInDays($now);
            //              $penalty_day = (($v->outstanding_debt * $amountPenaltyRate) / 100) / $daysInYear;
            //              $penalty_total = $penalty_day * $diff;
            //              // ค่าปรับ

            //             $Outstanding[] = [
            //                 'no'=>$v->pick_release_no.'_'.$v->credit_group_code,
            //                 'pick_release_no'=>$v->pick_release_no,
            //                 'credit_group_code'=>$v->credit_group_code,
            //                 'description'=>'เงินเชื่อกลุ่ม '.$v->credit_group_code,
            //                 'amount'=>$v->outstanding_debt,
            //                 'due_days'=>$v->due_days,
            //                 'date_th'=>dateFormatThai($v->due_date),
            //                 'penalty_percen'=>$amountPenaltyRate,
            //                 'penalty_day'=>$penalty_day,
            //                 'penalty_total'=>number_format((float)$penalty_total, 2, '.', ''),
            //                 'daysInYear'=>$daysInYear,
            //                 'checked'=>'N',
            //                 'flag'=>'N'
            //             ];
            //         }
            //     }

                $releaseCredit = ReleaseCredit::where('customer_id',$customersFind->customer_id)->where('payment_flag','N')->get();
            } catch (\Exception $e) {
                $releaseCredit = [];
                $Outstanding = [];
            }

        }else{
            $releaseCredit = [];
            $Outstanding = [];
        }

        // dd($Outstanding);

        $customers = Customer::whereRaw("lower(sales_classification_code) = 'domestic'")->whereRaw("lower(status) = 'active'")->orderBy('customer_number')->get();

        return view('om.release_credit.index',compact('releaseCredit','Outstanding','customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $releaseCredit = new ReleaseCredit();
        $releaseCredit->customer_id = 1;
        $releaseCredit->invoice_id = rand(1,100);
        $releaseCredit->invoice_num = rand(100522144,200100000);
        $releaseCredit->due_date = '2021-03-03';
        $releaseCredit->amount = rand(10000,1000000);
        $releaseCredit->charge_amount = 0.00;
        $releaseCredit->payment_flag = 'N';
        $releaseCredit->created_by = 1;
        $releaseCredit->last_updated_by = 1;
        $releaseCredit->program_code = 2;
        $releaseCredit->save();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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

        // if (!canEnter('/release-credit')) {
        //     return redirect()->back()->withErrors(trans('403'));
        // }

        $releaseCredit = explode(',',$request->release_credit);
        $charge = explode(',',$request->charge_amount);

        foreach($releaseCredit as $key => $item){

            $exp = explode('_',$item);

            $outstandingData = OutstandingDebtDomesticV::where('pick_release_no',$exp[0])->where('credit_group_code',$exp[1])->first();

            // $releaseCredit = ReleaseCredit::where('release_credit_id',$item)->first();
            $releaseCredit = ReleaseCredit::where('invoice_num',$exp[0])->where('credit_group_code',$exp[1])->first();

            if (is_null($releaseCredit)) {
                $releaseCredit = new ReleaseCredit();
            }

            $releaseCredit->customer_id = $outstandingData->customer_id;
            // $releaseCredit->attribute1 = $orderHeader->order_header_id;
            $releaseCredit->invoice_id = $outstandingData->order_header_id;
            $releaseCredit->invoice_num = $outstandingData->pick_release_no;
            $releaseCredit->due_date = $outstandingData->pick_release_approve_date;
            $releaseCredit->amount = $outstandingData->outstanding_debt;
            $releaseCredit->credit_group_code = $outstandingData->credit_group_code;
            $releaseCredit->charge_amount = $charge[$key];
            $releaseCredit->payment_flag = 'Y';
            $releaseCredit->created_by = 1;
            $releaseCredit->last_updated_by = 1;
            $releaseCredit->program_code = 'OMP0004';
            $releaseCredit->save();

            // $customerContractGroups = CustomerContractGroups::where('credit_group_code',$releaseCredit->credit_group_code)->where('customer_id',$releaseCredit->customer_id)->first();

            // $remaining_amount = $customerContractGroups->remaining_amount + $releaseCredit->amount;

            // if($releaseCredit->amount >= $customerContractGroups->credit_amount){
            //     $remaining_amount = $customerContractGroups->credit_amount;
            // }

            // DB::table('ptom_customer_contract_groups')
            // ->where('credit_group_code',$releaseCredit->credit_group_code)
            // ->where('customer_id',$releaseCredit->customer_id)
            // ->whereNull('deleted_at')
            // ->update(array(
            //     'remaining_amount'=>$remaining_amount,
            // ));
        }

        return response()->json(['data' => $charge]);
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