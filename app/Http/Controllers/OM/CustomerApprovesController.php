<?php

namespace App\Http\Controllers\OM;

use App\Http\Controllers\Controller;
use App\Mail\Approval;
use Illuminate\Http\Request;

use App\Models\OM\Customers\CustomerApproves;
use App\Models\OM\Api\CustomerApprovals;
use App\Models\OM\Api\Customer;

use App\Repositories\OM\ApprovalRepo;
use Exception;
use Illuminate\Support\Facades\Crypt;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\Mail;

class CustomerApprovesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inArr = [];
        $userData = getDefaultData('/users');

        if (optional(auth()->user())->username == 'sysadmin' || optional(auth()->user())->username == 'om') {
            $approves = Customer::joinCustomerApprovesByAdmin($userData->user_id);
        }else{
            $approves = Customer::joinCustomerApproves($userData->user_name);

            foreach ($approves as $key => $appr) {
                $appr->approves_as_status = CustomerApproves::where('customer_id',$appr->customer_id)->orderBy('approve_id','DESC')->first()->status;
            }
        }

        return view('om.customers/approves.index',compact('approves','inArr'));
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userData = getDefaultData('/users');

        // dd($userData);

        $checkLastStatus = [];
        $checkRoleUser = [];
        $allow = false;
        $allowUser = false;
        if (optional(auth()->user())->username == 'sysadmin' || optional(auth()->user())->username == 'om') {
            $allow = true;
            $allowUser = true;
            $approves = CustomerApproves::joinCustomerAdmin($id)[0];
        }else{
            try {
                // ,$userData->user_id
                $approves = CustomerApproves::joinCustomer($id)[0];

                $checkRoleUser = CustomerApproves::where('to_user_number',$userData->user_name)->where('customer_id',$approves->customer_id)->orderBy('approve_id','DESC')->first();
                $checkLastStatus = CustomerApproves::where('customer_id',$approves->customer_id)->orderBy('approve_id','DESC')->first();


                if ($checkRoleUser) {
                    $approves->approves_as_status = CustomerApproves::where('customer_id',$approves->customer_id)->orderBy('approve_id','DESC')->first()->status;
                    if ($checkLastStatus->to_user_number == $userData->user_name) {
                        $allowUser = true;
                    }
                    $allow = true;
                }else{
                    $allow = false;
                }

            } catch (\Exception $e) {
                $allow = false;
            }
        }

        if ($allow) {

            $basePath = '';
            if( strpos( env('APP_ECOM'), 'http://' ) !== false){
                $basePath = env('APP_ECOM');
            }else{
                $basePath = 'http://'.env('APP_ECOM');
            }

            $from = ApprovalRepo::getFromUser($approves->from_user_nunber);

            $approvesHistory = CustomerApproves::approvesHistory($id);

            foreach ($approvesHistory as $key => $v) {
                $fromHistory[$key] = ApprovalRepo::getFromUser($v->from_user_nunber);
                $toHistory[$key] = ApprovalRepo::getFromUser($v->to_user_number);
            }

            $customerApproval = ApprovalRepo::byCustomerApprovalReassign($approves->customer_type_id,$approves->to_user_number);

            return view('om.customers.approves.view',compact('approves','from','customerApproval','approvesHistory','fromHistory','toHistory','basePath','allowUser'));
        }else{
            abort(404);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    // public function send()
    // {
    //     $customer = Customer::where('customer_id',1)->first();

    //     $user = [
    //         'title' => 'Request New Customer',
    //         'customer_name' => $customer->customer_name,
    //         'request_number'=>$customer->request_number,
    //         'url'=>'url',
    //     ];

    //     Mail::to('thawatchai.jumpila@gmail.com')->send(new Approval($user));
    //     // Mail::send('mailView', $details, function($message) use ($details) {
	//     //     $message->to($details['email']);
	//     //     $message->subject('Testing Mailgun');
	//     // });
    // }
    

    public function updateEcom($request_number, $status) {
        $http = Http::get(env('APP_ECOM'). "/ecom/api/customer-approved-update", compact('request_number', 'status'));

        if($http->failed()) {
            throw new Exception("ส่งข้อมูลไปยัง Ecom ผิดพลาด", 1);
        }

        return $http->body();
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
        DB::beginTransaction();
        try {
            $customerApproves = CustomerApproves::where('approve_id',$id)->first();
            $customerInfo = Customer::where('customer_id', $customerApproves->customer_id)->first();

            if($customerInfo == null) throw new Exception("ไม่พบข้อมูลลูกค้า", 1);

            $callback = $this->updateEcom($customerInfo->request_number, $request->status);
            
            if($request->status == "Reassign"){
                $customerType = CustomerApprovals::where('customer_type','=','Exporter')->where('employee_number','>',$customerApproves->to_user_id)->where('status','=','Active')->first();

                if(empty($customerType)){
                    return response()->json(['data' => [],'status'=>false,'message'=>'ไม่พบข้อมูลผู้อนุมัติในลำดับถัดไป']);
                }
            }

            if($request->status == "Approved"){
                $customer = Customer::where('customer_id',$customerApproves->customer_id)->first();
                $customer->status = 'Draft';
                $customer->save();
            }

            if($request->status == "Rejected"){
                // $customer = Customer::where('customer_id',$customerApproves->customer_id)->first();
                // $customer->status = 'Inactive';
                // $customer->save();
            }

            $customerApproves->approver_comment = $request->comment;
            $customerApproves->status = $request->status;
            $customerApproves->save();
            DB::commit();

            return response()->json(['data' => $customerApproves,'status'=>true,'message'=>'']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status'=>false,'data' => [],'message'=>$e->getMessage()]);
        }
    }


    public function verify()
    {
        if(request()->token){
            $decrypt= Crypt::decryptString(request()->token);

            $customer = Customer::where('tax_register_number','=', $decrypt)->first();

            if($customer){
                $customerApproves = CustomerApproves::where('customer_id',$customer->customer_id)->first();
                return redirect()->route('om.customers.approves.view',$customer->customer_id);
            }else{
                abort(404);
            }
        }else{
            abort(404);
        }
    }

    public function reassign(Request $request,$id)
    {
        $customerApprovesOld = CustomerApproves::where('approve_id',$id)->first();

        $customer = Customer::where('customer_id',$customerApprovesOld->customer_id)->first();

        $customerApprovesOld->status = 'Reassign';
        $customerApprovesOld->save();

        $customerApproves = new CustomerApproves();
        $customerApproves->customer_id = $customerApprovesOld->customer_id;
        // $customerApproves->from_user_id = $customerApprovesOld->to_user_number;
        // $customerApproves->to_user_id = $request->reassign_approval;

        $customerApproves->from_user_nunber = $customerApprovesOld->to_user_number;
        $customerApproves->to_user_number = $request->reassign_approval;

        $customerApproves->approver_comment = '';
        $customerApproves->status = 'Awaiting Approval';
        $customerApproves->attachment_file_1 = $customerApprovesOld->attachment_file_1;
        $customerApproves->attachment_file_2 = $customerApprovesOld->attachment_file_2;
        $customerApproves->attachment_file_3 = $customerApprovesOld->attachment_file_3;
        $customerApproves->attachment_file_4 = $customerApprovesOld->attachment_file_4;
        $customerApproves->attachment_file_5 = $customerApprovesOld->attachment_file_5;

        $customerApproves->attachment_dir_1 = $customerApprovesOld->attachment_dir_1;
        $customerApproves->attachment_dir_2 = $customerApprovesOld->attachment_dir_2;
        $customerApproves->attachment_dir_3 = $customerApprovesOld->attachment_dir_3;
        $customerApproves->attachment_dir_4 = $customerApprovesOld->attachment_dir_4;
        $customerApproves->attachment_dir_5 = $customerApprovesOld->attachment_dir_5;

        $customerApproves->date_sent = date('Y-m-d H:i:s');
        $customerApproves->program_code = $customerApprovesOld->program_code;
        $customerApproves->creation_date = now();
        $customerApproves->created_by = 1;
        $customerApproves->last_updated_by = 1;
        $customerApproves->save();

        $token = Crypt::encryptString($customer->tax_register_number);

        $customer_type = CustomerApprovals::where('status','=','Active')->where('employee_number','=',$request->reassign_approval)->first();

        $user = [
            'title' => 'Request New Customer',
            'customer_name'=>$customer->customer_name,
            'request_number'=>$customer->request_number,
            'url'=>url('om/customers/approves/verify?token=').$token,
        ];

        if ($customer_type->email != '') {
            try {
                Mail::to($customer_type->email)->send(new Approval($user));
            } catch (\Exception $e) {}
        }

        return response()->json(['status'=>true,'data' => $user]);
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
