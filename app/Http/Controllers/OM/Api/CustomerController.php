<?php

namespace App\Http\Controllers\OM\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Mail\Approval;
use Illuminate\Support\Facades\Crypt;
use App\Mail\CustomerForgot;
use App\Mail\CustomerActive;
use App\Models\OM\Api\Customer;
use App\Models\OM\Api\CustomerApproves;
use App\Models\OM\Api\CustomerApprovals;
use App\Models\OM\Customers\Export\CustomerContactModel;
use App\Models\OM\Customers\Domestics\CustomerShipSites;
use App\Models\OM\Api\TerritoryV;
use App\Repositories\OM\GenerateNumberRepo;

use App\Repositories\OM\ApprovalRepo;

use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer = Customer::whereRaw("lower(sales_classification_code) = 'domestic'")->whereRaw("lower(status) = 'active'")->orderBy('customer_number')->get();

        return response()->json(['data' => $customer]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function genReqNumber()
    {
        $number = GenerateNumberRepo::callWMSPackageReqNumberExport();
        return response()->json($number);
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
    public function byId($id)
    {
        $customer = Customer::where('customer_id',$id)->first();

        return response()->json(['data' => $customer]);
    }

    public function byTypeDomestic()
    {
        $customer = Customer::whereRaw("lower(sales_classification_code) = 'domestic'")->whereRaw("lower(status) = 'active'")->orderBy('customer_number')->get();

        return response()->json(['data' => $customer]);
    }

    public function prefix()
    {
        $prefix = DB::table('ptom_title_v')->get(['lookup_code','title']);

        return response()->json(['data' => $prefix]);
    }

    public function byCustomerNumber($number)
    {
        $customer = Customer::where('customer_number',$number)->first();

        return response()->json(['data' => $customer]);
    }
    /**
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

        $region = TerritoryV::where('province_id',$request->province_code)->first();
        $city = TerritoryV::where('district_id',$request->city_code)->first();
        $district = TerritoryV::where('tambon_id',$request->district_code)->first();
        // DB::beginTransaction();
        // try {
            // update customer
            $customer = new Customer();
            $customer->request_number = $request->request_number;
            $customer->customer_name = $request->customer_name;
            $customer->sales_classification_code = 'Export';
            $customer->customer_type_id = $request->customer_type;
            $customer->status = "Requested";

            $customer->address_line1 = $request->address_1;
            $customer->address_line2 = $request->address_2;
            $customer->address_line3 = $request->address_3;
            $customer->country_code = $request->country;
            $customer->country_name = $request->country_name;
            $customer->state = $request->state;

            if($request->country == 'TH'){
                $customer->region_code = $region->region_id;
            }

            if ($request->city != '') {
                $customer->city = $request->city;
            }else{
                $customer->city = $request->city_name;
            }

            if ($request->province_code != 0) {
                $customer->province_code = $request->province_code;
            }
            $customer->province_name = $request->province_name;

            if ($request->city_code != 0) {
                $customer->city_code = $request->city_code;
            }

            if ($request->district_code != 0) {
                $customer->district_code = $request->district_code;
            }

            $customer->district = $request->district_name;
            $customer->postal_code = $request->postal_code;

            $customer->bill_to_site_id = $request->bill_to_site_id;
            $customer->bill_to_site_code = $request->bill_to_site_code;

            $customer->branch = $request->branch;
            $customer->head_office_flag = $request->head_office;
            $customer->contact_prefix = $request->prefix;
            $customer->contact_first_name = $request->first_name;
            $customer->contact_last_name = $request->last_name;
            $customer->contact_email = $request->email;
            $customer->contact_phone = $request->phone_number;
            $customer->fax_number = $request->fax_number;
            $customer->contact_position = $request->position;
            $customer->currency = $request->currency;
            $customer->tax_register_number = $request->tax_register_number;

            $customer->creation_date = now();
            $customer->created_by = $request->created_by;

            $customer->program_code = $request->program_code;
            $customer->last_updated_by = $request->last_updated_by;

            $customer->save();

            // update contact
            $customerContact = new CustomerContactModel();
            $customerContact->customer_id = $customer->getKey();
            $customerContact->contact_no = 1;
            $customerContact->contact_prefix = $request->prefix;
            $customerContact->contact_first_name = $request->first_name;
            $customerContact->contact_last_name = $request->last_name;
            $customerContact->contact_email = $request->email;
            $customerContact->contact_position = $request->position;
            $customerContact->contact_phone = $request->phone_number;
            $customerContact->fax_number = $request->fax_number;
            $customerContact->status = 'Active';
            $customerContact->program_code = $request->program_code;
            $customerContact->creation_date = now();
            $customerContact->created_by = 1;
            $customerContact->last_updated_by = 1;
            $customerContact->save();

            $customerUpdate = Customer::where('customer_id',$customer->getKey())->first();
            $customerUpdate->bill_to_site_id = $customerUpdate->customer_id;
            $customerUpdate->bill_to_site_name = $customerUpdate->customer_name;
            $customerUpdate->save();

            // // update ship site
            $customerShipSite = new CustomerShipSites();
            $customerShipSite->customer_id = $customer->getKey();
            $customerShipSite->site_no = 1;
            $customerShipSite->ship_to_site_code = 'SHIP_TO';
            $customerShipSite->ship_to_site_name = $request->customer_name;
            $customerShipSite->ship_contact_name = $request->prefix.' '.$request->first_name.' '.$request->last_name;
            $customerShipSite->ship_contact_position = $request->position;
            $customerShipSite->country_code = $request->country;
            $customerShipSite->country_name = $request->country_name;
            $customerShipSite->address_line1 = $request->address_1;
            $customerShipSite->address_line2 = $request->address_2;
            $customerShipSite->address_line3 = $request->address_3;
            if($request->country == 'TH'){
                $customerShipSite->region_id = $region->region_id;
                $customerShipSite->region_code = $region->region_thai;

                if ($request->city_code != 0) {
                    $customerShipSite->city_code = $request->city_code;
                    $customerShipSite->city = $city->district_thai;
                }else{
                    $customerShipSite->city = $request->city_name;
                }

                if ($request->province_code != 0) {
                    $customerShipSite->province_id = $request->province_code;
                    $customerShipSite->province_code = $request->province_code;
                    $customerShipSite->province_name = $region->province_thai;
                }else{
                    $customerShipSite->province_name = $request->province_name;
                }

                if ($request->district_code != 0) {
                    $customerShipSite->district_code = $request->district_code;
                    $customerShipSite->district = $district->tambon_thai;
                }else{
                    $customerShipSite->district = $request->district_name;
                }

            }else{
                $customerShipSite->city = $request->city;
                $customerShipSite->province_name = $request->province_name;
                $customerShipSite->district = $request->district_name;
            }

            $customerShipSite->state = $request->state;
            $customerShipSite->postal_code = $request->postal_code;
            $customerShipSite->status = 'Active';
            $customerShipSite->program_code = $request->program_code;
            $customerShipSite->creation_date = now();
            $customerShipSite->created_by = 1;
            $customerShipSite->last_updated_by = 1;
            $customerShipSite->save();

            // // // where('customer_type','=','Exporter')->
            $customer_type = ApprovalRepo::byCustomerTypeGroupFirst($request->customer_type);

            $customerApproves = new CustomerApproves();
            $customerApproves->customer_id = $customer->getKey();
            // $customerApproves->from_user_id = 'sysadmin';
            // $customerApproves->to_user_id = $customer_type->employee_number;

            $customerApproves->from_user_nunber = 'sysadmin';
            $customerApproves->to_user_number = $customer_type->employee_number;

            $customerApproves->approver_comment = '';
            $customerApproves->status = $request->approval_status;

            foreach ($request->all()['attachment'] as $key => $v) {
                if($key < 5){
                    $customerApproves['attachment_file_'.($key+1)] = $v['file_name'];
                    $customerApproves['attachment_dir_'.($key+1)] = 'uploads/customers/'.$v['customer_id'].'/';
                }
            }

            $customerApproves->date_sent = $request->approval_date_sent;
            $customerApproves->program_code = $request->approval_program_code;
            $customerApproves->creation_date = now();
            $customerApproves->created_by = $request->created_by;
            $customerApproves->last_updated_by = $request->last_updated_by;
            $customerApproves->save();

            $token = Crypt::encryptString($request->tax_register_number);

            $user = [
                'title' => 'ขออนุมัติการสร้างลูกค้าใหม่ '.$request->request_number.' : '.$request->customer_name,
                'customer_name'=>$request->customer_name,
                'request_number'=>$request->request_number,
                'url'=>url('om/customers/approves/verify?token=').$token,
            ];

            try {
                if($customer_type->email != ''){
                    Mail::to($customer_type->email)->send(new Approval($user));
                }
            }catch (\Exception $e) {}

            // DB::commit();

            return response()->json(['status'=>true,'data' => $user,'message'=>'success']);

        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     return response()->json(['status'=>false,'data' => [],'message'=>$e->getMessage()]);
        // }
    }

    public function send_mail_forgot(Request $request)
    {
        $dataMail = [
            'title' => 'forgot',
            'url'=> $request->url
        ];

        Mail::to($request->email)->send(new CustomerForgot($dataMail));
    }

    public function send_mail_active(Request $request)
    {
        $dataMail = [
            'title' => 'Customer Active',
            'username'=> $request->username,
            'password'=>$request->password
        ];

        Mail::to($request->email)->send(new CustomerActive($dataMail));
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