<?php

namespace App\Http\Controllers\OM\Ajex\Customers\Export;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use App\Mail\CustomerActive;
use Illuminate\Support\Facades\Mail;

use App\Models\OM\Customers\Export\ForeignCustomerModel;
use App\Models\OM\Customers\Export\CustomerTypeExportListModel;
use App\Models\OM\Customers\Export\CountryVModel;
use App\Models\OM\Customers\Export\TerritoryModel;
use App\Models\OM\Customers\Export\CustomerContactModel;
use App\Models\OM\Customers\Export\CustomerShippingModel;

use App\Repositories\OM\GenerateNumberRepo;

class ExportAjaxController extends Controller
{
    protected $perPage = 20;

    public function List(Request $request)
    {
        $data  = ForeignCustomerModel::where('sales_classification_code','EXPORT')
                                        ->orWhere('sales_classification_code','Export')
                                        ->where('status','!=','Requested')
                                        ->search($request->all())
                                        ->orderBy('customer_name')
                                        ->get();

        $customer_type = CustomerTypeExportListModel::get();
        if(!empty($customer_type)){
            foreach($customer_type as $type_item){
                $type_list[$type_item->customer_type] = [
                    'description'       => $type_item->description,
                    'meaning'           => $type_item->meaning
                ];
            }
        }else{
            $type_list = [];
        }

        $territory = TerritoryModel::get();

        $territory_list = [];
        if(!empty($territory)){
            foreach($territory as $item){
                $territory_list['province'][$item->province_id] = [
                    'name_th'  => $item->province_thai,
                    'name_en'  => $item->province_eng
                ];
            }

            foreach($territory as $item_district){ //อำเภอ
                $territory_list['district'][$item_district->province_id][$item_district->district_id] = [
                    'id'            => $item_district->district_id,
                    'name_th'       => $item_district->district_thai,
                    'name_en'       => $item_district->district_eng,
                    'province_id'   => $item_district->province_id,
                ];
            }

            foreach($territory as $item_tambon){ //ตำบล
                $territory_list['tambon'][$item_tambon->district_id][$item_tambon->tambon_id] = [
                    'id'                    => $item_tambon->tambon_id,
                    'name_th'               => $item_tambon->tambon_thai,
                    'name_en'               => $item_tambon->tambon_eng,
                    'postcode_main'         => $item_tambon->postcode_main,
                    'postcode_all'          => $item_tambon->postcode_all,
                    'postal_code_remark'    => $item_tambon->postal_code_remark,
                    'province_id'           => $item_tambon->province_id,
                    'district_id'           => $item_tambon->district_id,
                ];

                $zipcode = explode('/',$item_tambon->postcode_all);

                foreach($zipcode as $zip_item){
                    $territory_list['postcode'][$item_tambon->tambon_id][] = $zip_item;
                }
            }
        }

        $foreigndata = [];
        if(!empty($data)){
            foreach($data as $item){
                if(!empty($item->created_by)){
                    $create  = DB::table('ptom_user_v')->where('user_id',$item->created_by)->first();
                    $name_create = !empty($create)? $create->name : 'Nodata / Ecom';
                }
                if(!empty($item->LAST_UPDATED_BY)){
                    $update  = DB::table('ptom_user_v')->where('user_id',$item->LAST_UPDATED_BY)->first();
                    $name_update = !empty($update)? $update->name : 'Nodata / Ecom';
                }else{
                    $name_update = 'No Update';
                }
                if($item->country_code == 'TH'){
                    $address = $item->address_line1.' '.$item->address_line2.' '.$item->address_line3.' '.$item->district.' '.$item->city.' '.$item->province_name.' '.$item->postal_code;
                }else{
                    $address = $item->address_line1.' '.$item->address_line2.' '.$item->address_line3.' '.$item->district.' '.$item->city.' '.$item->postal_code;
                }
                // if($item->country_code == 'TH'){
                //     $address = $item->address_line1;

                //     if(!empty($item->address_line2)){
                //         $address .= ' '.$item->address_line2;
                //     }

                //     if(!empty($item->address_line3)){
                //         $address .= ' '.$item->address_line3;
                //     }

                //     if(!empty($territory_list['tambon'][$item->citi_code][$item->district_code])){
                //         $address .= ' '.$item->district;
                //     }

                //     if(!empty($territory_list['district'][$item->province_code][$item->citi_code])){
                //         $address .= ' '.$item->city;
                //     }

                //     if(!empty($territory_list['province'][$item->province_code])){
                //         $address .= ' '.$item->province_name;
                //     }
                //     $address .= ' '.$item->postal_code;
                // }else{
                //     $address = $item->address_line1.' '.$item->address_line2.' '.$item->address_line3.' '.$item->district.' '.$item->city.' '.$item->province_code.' '.$item->postal_code;
                // }
                $foreigndata[] = [
                    'customer_id'       => $item->customer_id,
                    'radio'             => '<div class="i-checks"><label><input type="radio" value="option1" name="a"></label></div>',
                    'name'              => $item->customer_name,
                    'request_number'    => $item->request_number,
                    'customer_number'   => $item->customer_number,
                    'customer_type'     => !empty($type_list[$item->customer_type_id])?$type_list[$item->customer_type_id]['description'] : $item->customer_type_id,
                    'address'           => $address,
                    'contry'            => $item->country_name,
                    'btn_detail'        => '<a href="'.route('om.customers.exports.show',[$item->customer_id]).'" class="btn btn-link btn-sm text-info"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>',
                    'status'            => $item->status,
                    'history'           => '<a onclick="showHistoryCustomer('."'".$name_create."'".','."'".$item->creation_date."'".','."'".$name_update."'".','."'".$item->LAST_UPDATED_DATE."'".',)" ><i class="fa fa-history"></i></a>'
                ];
            }
        }else{
            $foreigndata = [];
        }

        return response()->json(['data' => $foreigndata]);
    }

    public function Type()
    {
        $customer_type = CustomerTypeExportListModel::where('enabled_flag','Y')->get();
        if(!empty($customer_type)){
            foreach($customer_type as $type_item){
                $type_list[] = [
                    'id'        => $type_item->customer_type,
                    'name'      => $type_item->description,
                    'meaning'   => $type_item->meaning
                ];
            }
        }else{
            $type_list = [];
        }


        return response()->json(['data' => $type_list]);
    }

    public function Country()
    {
        $country_list = CountryVModel::get();

        if(!empty($country_list)){
            foreach($country_list as $item){
                $data_list[] = [
                    'id'                => $item->country_code,
                    'geography_name'    => $item->country_name
                ];
            }
        }else{
            $data_list = [];
        }


        return response()->json(['data' => $data_list]);
    }

    public function Province()
    {
        $data = TerritoryModel::select('province_id','province_thai','province_eng','region_id','region_thai')->groupBy('province_id','province_thai','province_eng','region_id','region_thai')->orderBy('province_thai','asc')->get();

        $data_list = [];
        if(!empty($data)){
            foreach($data as $item){
                $data_list[] = [
                    'id'        => $item->province_id,
                    'name_th'   => $item->province_thai,
                    'name_en'   => $item->province_eng,
                    'region'    => $item->region_id,
                    'rg_name'   => $item->region_thai
                ];
            }
        }else{
            $data_list = [];
        }

        return response()->json(['data' => $data_list]);
    }

    public function District(Request $request)
    {
        $data = TerritoryModel::select('city_code','city_thai','city_eng')->where('province_id',$request->id)->groupBy('city_code','city_thai','city_eng')->orderBy('city_thai','asc')->get();

        $data_list = [];
        if(!empty($data)){
            foreach($data as $item_district){ //อำเภอ
                $data_list[] = [
                    'id'            => $item_district->city_code,
                    'name_th'       => $item_district->city_thai,
                    'name_en'       => $item_district->city_eng,
                    'province_id'   => $request->id,
                ];
            }
        }else{
            $data_list = [];
        }

        return response()->json(['data' => $data_list]);
    }

    public function Tambon(Request $request)
    {
        $data = TerritoryModel::where('city_code',$request->id)->orderBy('district_thai','asc')->get();

        $data_list = [];
        if(!empty($data)){
            foreach($data as $item_tambon){ //ตำบล
                $data_list['tumbon'][] = [
                    'id'                    => $item_tambon->district_code,
                    'name_th'               => $item_tambon->district_thai,
                    'name_en'               => $item_tambon->district_eng,
                    'postcode_main'         => $item_tambon->postcode_main,
                    'postcode_all'          => $item_tambon->postcode_all,
                    'postal_code_remark'    => $item_tambon->postal_code_remark,
                    'province_id'           => $item_tambon->province_id,
                    'district_id'           => $item_tambon->city_code,
                ];

                $zipcode = explode('/',$item_tambon->postcode_all);
                $data_list['datad']= $item_tambon->postcode_all;
                foreach($zipcode as $zip_item){
                    $data_list['postcode'][$item_tambon->district_code][] = $zip_item;
                }
            }
        }else{
            $data_list = [];
        }

        return response()->json(['data' => $data_list]);
    }

    public function checkContactActive($id)
    {
        $contact_data = CustomerContactModel::where('customer_id',$id)->where('status','Active')->whereNotNull('contact_email')->count();

        if($contact_data > 0){
            $rest = [
                'status'    => true,
                'data'      => $contact_data
            ];
        }else{
            $rest = [
                'status'    => false,
                'data'      => 'No Data'
            ];
        }


        return response()->json(['data' => $rest]);
    }

    public function confirmDataCustomer($id,Request $request)
    {
        DB::beginTransaction();
        try {
            $last = ForeignCustomerModel::where('sales_classification_code','EXPORT')
                                        ->orWhere('sales_classification_code','Export')
                                        ->whereNotNull('customer_number')
                                        ->orderBy('customer_number','desc')
                                        ->first();

            $last_number = explode('E',$last->customer_number);
            if(is_numeric($last_number[1])){
                $newnumber = sprintf('%04d', $last_number[1]+1);
            }else{
                $newnumber = sprintf('%04d', 1);
            }
            $customer_number = 'E'.$newnumber;

            $update = [
                'status'                => 'Active',
                'customer_number'       => $customer_number,
                'last_updated_by'       => optional(auth()->user())->user_id,
                'last_update_date'      => date('Y-m-d H:i:s'),
            ];

            if(ForeignCustomerModel::where('customer_id',$id)->update($update)){

                if(!empty($request->email)){
                    $send_email = $request->email;
                }else{
                    $contact_data = CustomerContactModel::where('customer_id',$id)->where('status','Active')->whereNotNull('contact_email')->orderBy('contact_no','asc')->first();
                    $send_email = $contact_data->contact_email;
                }

                $customer = ForeignCustomerModel::where('customer_id',$id)->first();

                $password = Str::random(8);

                $dataPost = [
                    'customer_id'           => $id,
                    'customer_number'       => $customer_number,
                    'email'                 => $send_email,
                    'password'              => Hash::make($password),
                    'status'                => 'Active',
                    'tax_register_number'   => $customer->tax_register_number,
                    'last_updated_by'       => optional(auth()->user())->user_id
                ];
                $response  = Http::post(env('APP_ECOM').'/api/v1/customer/update-status', $dataPost);
                $res = [
                    'status'        => $response->status(),
                    'success'       => $response->successful(),
                    'serverError'   => $response->serverError(),
                    'clientError'   => $response->clientError(),
                    'body'          => $response->body(),
                    'json'          => $response->json(),
                ];

                $dataMail = [
                    'title' => 'Customer Active',
                    'username'=> $customer_number,
                    'password'=> $password
                ];

                // Mail::to($send_email)->send(new CustomerActive($dataMail));

                $rest = [
                    'status'    => true,
                    'data'      => 'Success',
                    'response'  => $dataPost,
                    'code'      => $customer_number
                ];
            }else{
                $rest = [
                    'status'    => false,
                    'data'      => 'Someting Wrong'
                ];
            }
        } catch (\Exception $e) {
            DB::rollBack();
            $rest = [
                'status'    => false,
                'data'      => 'Someting Wrong',
                'message'   => $e->getMessage()
            ];
        }
        DB::commit();

        return response()->json(['data' => $rest]);

    }

    public function updateCustomerData($id,Request $request)
    {
        $validate = Validator::make($request->all(),[
            // 'customer_number_tm'        => 'required|string',
            'currency'                  => 'required|string',
            // 'sales_classification_code' => 'required|string',
            'customer_type_id'          => 'required|string',
            'customer_name'             => 'required|string',
            // 'customer_short_name'       => 'required|string',
            'country_code'              => 'required|string',
            // 'address_line1'             => 'required|string',
            // 'address_line2'             => 'required|string',
            // 'address_line3'             => 'required|string',
            // 'province_code'             => 'required|string',
            // 'city'                      => 'required|string',
            // 'postal_code'               => 'required|string',
            'tax_register_number'       => 'required|string',
            // 'branch'                    => 'required|string',
            // 'vat_code'                  => 'required|string',
            // 'payment_method'            => 'required|string',
            // 'payment_method_id'         => 'required|string',
            // 'shipment_by_id'            => 'required|string',
            // 'shipment_by'               => 'required|string',
            // 'formula_id'                => 'required|string',
            // 'order_type'                => 'required|string',
            // 'incoterms_code'            => 'required|string',
            // 'price_list'                => 'required|string',
            // 'payment_type'              => 'required|string',
            // 'order_from'                => 'required|string',
            // 'status'                    => 'required|string',
        ]);

        if($validate->fails()){
            $rest = [
                'status'    => false,
                'type'      => 'validate',
                'data'      => $validate->errors()
            ];
            return response()->json(['data' => $rest]);
        }else{

            DB::beginTransaction();
            try {
                $update = [
                    'customer_code_tm'          => $request->customer_number_tm,
                    'currency'                  => $request->currency,
                    // 'sales_classification_code' => $request->sales_classification_code,
                    'customer_type_id'          => $request->customer_type_id,
                    'customer_name'             => $request->customer_name,
                    'bill_to_site_name'         => $request->customer_name,
                    'customer_short_name'       => $request->customer_short_name,
                    'country_code'              => $request->country_code,
                    'country_name'              => $request->customer_country,
                    'address_line1'             => $request->address_line1,
                    'address_line2'             => $request->address_line2,
                    'address_line3'             => $request->address_line3,
                    'state'                     => $request->state,
                    'province_code'             => ($request->country_code == 'TH')? $request->province_code : '',
                    'province_name'             => ($request->country_code == 'TH')? $request->province_name : '',
                    'city'                      => ($request->country_code == 'TH')? $request->city_name : $request->city,
                    'district'                  => $request->district_name,
                    'city_code'                 => $request->city_code,
                    'region_code'               => ($request->country_code == 'TH')? $request->province_region : '',
                    'district_code'             => $request->district_code,
                    'postal_code'               => !empty($request->postal_code_other) ? $request->postal_code_other :$request->postal_code,
                    'head_office_flag'          => !empty($request->head_office_flag)? $request->head_office_flag : 'N',
                    'tax_register_number'       => $request->tax_register_number,
                    'branch'                    => $request->branch,
                    'vat_code'                  => $request->vat_code,
                    'payment_method'            => $request->payment_method,
                    'payment_method_id'         => $request->payment_method_id,
                    'payment_term_id'           => $request->payment_terms_id,
                    'payment_terms'             => $request->payment_terms_name,
                    'shipment_by_id'            => $request->shipment_by_id,
                    'shipment_condition'        => $request->shipment_condition,
                    'shipment_by'               => $request->shipment_by,
                    'formula_id'                => $request->formula_id,
                    'formula'                   => $request->formula_name,
                    'order_type_id'             => $request->order_type_id,
                    'order_type'                => $request->order_type,
                    'incoterms_code'            => $request->incoterms_code,
                    'price_list_id'             => $request->price_list,
                    'price_list'                => $request->price_list_name,
                    'payment_type_id'           => $request->payment_type_id,
                    'payment_type'              => $request->payment_type,
                    'sales_channel_id'          => $request->sales_channel_id,
                    'sales_channel'             => $request->sales_channel,
                    'status'                    => !empty($request->status)? $request->status : '',
                    'last_updated_by'           => optional(auth()->user())->user_id,
                    'last_update_date'          => date('Y-m-d H:i:s'),
                ];

                if($request->status == 'Active' && $request->current_status == 'Draft'){
                    // $last = ForeignCustomerModel::where('sales_classification_code','EXPORT')
                    //                             ->orWhere('sales_classification_code','Export')
                    //                             ->whereNotNull('customer_number')
                    //                             ->orderBy('customer_number','desc')
                    //                             ->first();

                    // $last_number = explode('E',$last->customer_number);

                    // if(is_numeric($last_number[1])){
                    //     $newnumber = sprintf('%04d', $last_number[1]+1);
                    // }else{
                    //     $newnumber = sprintf('%04d', 1);
                    // }
                    // $customer_number = 'E'.$newnumber;
                    $customer_number = GenerateNumberRepo::generateCustomerNumberExport();

                    $update['customer_number'] = $customer_number;
                }

                if(ForeignCustomerModel::where('customer_id',$id)->update($update)){
                    if($request->status == 'Active' && $request->current_status == 'Draft'){

                        $password = Str::random(8);

                        if(!empty($request->email)){
                            $send_email = $request->email;
                        }else{
                            $contact_data = CustomerContactModel::where('customer_id',$id)->where('status','Active')->whereNotNull('contact_email')->orderBy('contact_no','asc')->first();
                            $send_email = $contact_data->contact_email;
                        }

                        GenerateNumberRepo::callPackageUpdateActiveCustomerExport($id);

                        $customer = ForeignCustomerModel::where('customer_id',$id)->first();
                        $dataPost = [
                            'customer_id'           => $id,
                            'customer_number'       => $customer_number,
                            'email'                 => $send_email,
                            'password'              => Hash::make($password),
                            'status'                => 'Active',
                            'tax_register_number'   => $customer->tax_register_number,
                            'last_updated_by'       => optional(auth()->user())->user_id
                        ];
                        $response  = Http::post(env('APP_ECOM').'/api/v1/customer/update-status', $dataPost);
                        $res = [
                            'status'        => $response->status(),
                            'success'       => $response->successful(),
                            'serverError'   => $response->serverError(),
                            'clientError'   => $response->clientError(),
                            'body'          => $response->body(),
                            'json'          => $response->json(),
                        ];

                        $dataMail = [
                            'title' => 'Customer Active',
                            'username'=> $customer_number,
                            'password'=> $password
                        ];

                        // Mail::to($send_email)->send(new CustomerActive($dataMail));

                        $rest = [
                            'status'    => true,
                            'data'      => 'Success',
                            'response'  => $res,
                            'code'      => $customer_number
                        ];


                    }else{
                        GenerateNumberRepo::callPackageUpdateCustomerExport($id);
                        $rest = [
                            'status'    => true,
                            'data'      => 'update success'
                        ];
                    }
                }else{
                    $rest = [
                        'status'    => false,
                        'data'      => 'Someting Wrong'
                    ];
                }
            } catch (\Exception $e) {
                DB::rollBack();
                $rest = [
                    'status'    => false,
                    'data'      => 'Someting Wrong',
                    'message'   => $e->getMessage()
                ];
            }
            DB::commit();
            return response()->json(['data' => $rest]);
        }
    }

    public function CustomerContactList($id)
    {
        $data = CustomerContactModel::where('customer_id',$id)->orderBy('contact_no')->whereNull('deleted_at')->get();
        $data_list = [];
        if(!empty($data)){
            foreach($data as $item){
                $data_list[$item->customer_contact_id] = [
                    'id'            => !empty($item->customer_contact_id) ?$item->customer_contact_id : '',
                    'number'        => !empty($item->contact_no) ?$item->contact_no : '',
                    'prefix'        => !empty($item->contact_prefix)? $item->contact_prefix : '',
                    'first_name'    => !empty($item->contact_first_name) ?$item->contact_first_name : '',
                    'last_name'     => !empty($item->contact_last_name) ? $item->contact_last_name : '',
                    'position'      => !empty($item->contact_position) ?$item->contact_position : '',
                    'phone'         => !empty($item->contact_phone) ?$item->contact_phone : '',
                    'attribute1'    => !empty($item->attribute1) ?$item->attribute1 : '',
                    'status'        => !empty($item->status) ?$item->status : '',
                    'email'         => !empty($item->contact_email) ?$item->contact_email : '',
                    'fax'           => !empty($item->fax_number) ?$item->fax_number : '',
                    'note'          => !empty($item->note) ?$item->note : ''
                ];
            }
        }else{
            $data_list = [];
        }

        return response()->json(['data' => $data_list]);
    }

    public function CustomerShippingList($id)
    {
        $data = CustomerShippingModel::where('customer_id',$id)->orderBy('site_no')->whereNull('deleted_at')->get();

        $country_list = CountryVModel::get();

        if(!empty($country_list)){
            foreach($country_list as $item_country){
                $country[$item_country->country_code] = [
                    'id'                => $item_country->country_code,
                    'geography_name'    => $item_country->country_name
                ];
            }
        }else{
            $country = [];
        }


        $data_list = [];
        if(!empty($data)){
            foreach($data as $item){
                $data_list[$item->site_no] = [
                    'id'            => $item->ship_to_site_id,
                    'number'        => !empty($item->site_no)? $item->site_no : '',
                    'name'          => !empty($item->ship_to_site_name)? $item->ship_to_site_name : '',
                    'name_contact'  => !empty($item->ship_contact_name)? $item->ship_contact_name : '',
                    'position'      => !empty($item->ship_contact_position)? $item->ship_contact_position : '',
                    'country'       => !empty($country[$item->country_code])? $country[$item->country_code]['geography_name'] : $item->country_code,
                    'country_code'  => !empty($item->country_code)? $item->country_code : '',
                    'country_name'  => !empty($item->country_name)? $item->country_name : '',
                    'address_1'     => !empty($item->address_line1)? $item->address_line1 : '',
                    'address_2'     => !empty($item->address_line2)? $item->address_line2 : '',
                    'address_3'     => !empty($item->address_line3)? $item->address_line3 : '',
                    'city'          => !empty($item->city)? $item->city : '',
                    'city_code'     => !empty($item->city_code)? $item->city_code : '',
                    'district_code' => !empty($item->district_code)? $item->district_code : '',
                    'state'         => !empty($item->state)? $item->state : '',
                    'province'      => !empty($item->province_code)? $item->province_code : '',
                    'province_name' => !empty($item->province_name)? $item->province_name: '',
                    'postal_code'   => !empty($item->postal_code)? $item->postal_code : '',
                    'status'        => !empty($item->status)? $item->status: '',
                    'mainaddr'      => !empty($item->attribute1)?  $item->attribute1 : 'N'
                ];
            }
        }else{
            $data_list = [];
        }

        return response()->json(['data' => $data_list,'customer' => $data]);
    }

    public function insertCustomerContact($id,Request $request)
    {
        $validate = Validator::make($request->all(),[
            // 'contact_number'        => 'required|unique:PTOM_CUSTOMER_CONTACTS,contact_no',
            'contact_number'        => ['required',Rule::unique('PTOM_CUSTOMER_CONTACTS','CONTACT_NO')
                                                        ->using(function ($query) use ($request,$id) {
                                                            return $query->where('customer_id',$id)->whereNull('deleted_at');
                                                        })],
            // 'contact_prefix'        => 'required|string',
            'contact_first_name'    => 'required|string',
            // 'contact_last_name'     => 'required|string',
            'contact_email'         => 'string|email|nullable',
            // 'contact_position'      => 'required|string',
            'contact_phone'         => 'string|min:10|max:15|nullable',
            'contact_status'        => 'required|string',
        ]);

        if($validate->fails()){
            $rest = [
                'status'    => false,
                'type'      => 'validate',
                'data'      => $validate->errors()
            ];
            return response()->json($rest);
        }else{
            // $max_id                     = CustomerContactModel::max('customer_contact_id');
            $insert = [
                'customer_id'           => $id,
                'contact_no'            => $request->contact_number,
                'contact_prefix'        => $request->contact_prefix,
                'contact_first_name'    => $request->contact_first_name,
                'contact_last_name'     => $request->contact_last_name,
                'contact_email'         => $request->contact_email,
                'contact_position'      => $request->contact_position,
                'contact_phone'         => $request->contact_phone,
                'attribute1'            => $request->contact_attribute1,
                'fax_number'            => $request->contact_fax,
                'note'                  => $request->contact_note,
                'status'                => $request->contact_status,
                'program_code'          => 'OMM0006',
                'created_by'            => optional(auth()->user())->user_id,
                'creation_date'         => date('Y-m-d H:i:s'),
                'last_updated_by'       => optional(auth()->user())->user_id,
                'last_update_date'      => date('Y-m-d H:i:s'),
            ];

            if(CustomerContactModel::create($insert)){
                GenerateNumberRepo::callPackageUpdateActiveCustomerExport($id);
                $rest = [
                    'status'    => true,
                    'data'      => 'Success'
                ];
            }else{
                $rest = [
                    'status'    => false,
                    'data'      => 'Someting Wrong'
                ];
            }
        }

        return response()->json($rest);

    }

    public function updateCustomerContact($id,Request $request)
    {
        $validate = Validator::make($request->all(),[
            // 'contact_number'        => 'required|unique:PTOM_CUSTOMER_CONTACTS,contact_no,'.$id.',customer_contact_id,not null,deleted_at',
            'contact_number'        => ['required',Rule::unique('PTOM_CUSTOMER_CONTACTS','contact_no')
                                                        ->ignore($id,'customer_contact_id')
                                                        ->using(function ($query) use ($id,$request) {
                                                            return $query->where('customer_id',$request->customer_id)->whereNull('deleted_at');
                                                        })],
            // 'contact_prefix'        => 'required|string',
            'contact_first_name'    => 'required|string',
            // 'contact_last_name'     => 'required|string',
            'contact_email'         => 'string|email|nullable',
            // 'contact_position'      => 'required|string',
            'contact_phone'         => 'string|min:10|max:15|nullable',
            'contact_status'        => 'required|string',
        ]);

        if($validate->fails()){
            $rest = [
                'status'    => false,
                'type'      => 'validate',
                'data'      => $validate->errors()
            ];
            return response()->json($rest);
        }else{
            $update = [
                'contact_no'            => $request->contact_number,
                'contact_prefix'        => $request->contact_prefix,
                'contact_first_name'    => $request->contact_first_name,
                'contact_last_name'     => $request->contact_last_name,
                'contact_email'         => $request->contact_email,
                'contact_position'      => $request->contact_position,
                'contact_phone'         => $request->contact_phone,
                'attribute1'            => $request->contact_attribute1,
                'fax_number'            => $request->contact_fax,
                'note'                  => $request->contact_note,
                'status'                => $request->contact_status,
                'last_updated_by'       => optional(auth()->user())->user_id,
                'last_update_date'      => date('Y-m-d H:i:s'),
            ];

            if(CustomerContactModel::where('customer_contact_id',$id)->update($update)){
                GenerateNumberRepo::callPackageUpdateCustomerExport($request->customer_id);
                $rest = [
                    'status'    => true,
                    'data'      => 'Success'
                ];
            }else{
                $rest = [
                    'status'    => false,
                    'data'      => 'Someting Wrong'
                ];
            }
        }

        return response()->json($rest);
    }

    public function delCustomerContact($id)
    {
        $del = [
            'deleted_at'        => date('Y-m-d H:i:s'),
            'deleted_by_id'     => optional(auth()->user())->user_id,
        ];

        if(CustomerContactModel::where('customer_contact_id',$id)->update($del)){
            $rest = [
                'status'    => true,
                'data'      => 'Success'
            ];
        }else{
            $rest = [
                'status'    => false,
                'data'      => 'Someting Wrong'
            ];
        }

        return response()->json($rest);
    }

    public function insertCustomerShipping($id,Request $request)
    {
        $validate = Validator::make($request->all(),[
            // 'shipping_number'           => 'required|unique:PTOM_CUSTOMER_SHIP_SITES,site_no',
            'shipping_number'        => ['required',Rule::unique('PTOM_CUSTOMER_SHIP_SITES','site_no')
                                                        ->using(function ($query) use ($id,$request) {
                                                            return $query->where('customer_id',$id)->whereNull('deleted_at');
                                                        })],
            'shipping_place_name'       => ['required',Rule::unique('PTOM_CUSTOMER_SHIP_SITES','ship_to_site_name')
                                                                    ->using(function ($query) use ($id,$request) {
                                                                        return $query->where('customer_id',$id)->whereNull('deleted_at');
                                                                    })],
            // 'shipping_contact_name'     => 'required|string',
            // 'shipping_position'         => 'required|string',
            // 'shipping_country'          => 'required|string',
            'shipping_addr_line_1'      => 'required|string',
            // 'shipping_postal'           => 'required|string',
            'shipping_status'           => 'required|string',
        ]);

        if($validate->fails()){
            $rest = [
                'status'    => false,
                'type'      => 'validate',
                'data'      => $validate->errors()
            ];
            return response()->json($rest);
        }else{
            if(!empty($request->shipping_main_addr)){
                $customerShip = CustomerShippingModel::where('attribute1','Y')
                                                        ->where('customer_id',$request->id)
                                                        ->whereNull('deleted_at')
                                                        ->first();
                if($customerShip){
                    $rest = [
                        'status'    => false,
                        'type'      => 'validate',
                        'data'      => [
                            'สถานที่จัดส่งหลัก'  => 'สามารถเลือกสถานที่จัดส่งหลักได้แค่ 1 สถานที่เท่านั้น กรุณายกเลิกสถานที่จัดส่งหลักเดิมก่อน'
                        ]
                    ];
                    return response()->json($rest);
                }
            }

            $insert = [
                'customer_id'               => $id,
                'ship_to_site_code'         => 'SHIP_TO',
                'site_no'                   => $request->shipping_number,
                'ship_to_site_name'         => $request->shipping_place_name,
                'ship_contact_name'         => $request->shipping_contact_name,
                'ship_contact_position'     => $request->shipping_position,
                'country_code'              => $request->shipping_country,
                'country_name'              => $request->shipping_country_name,
                'address_line1'             => $request->shipping_addr_line_1,
                'address_line2'             => $request->shipping_addr_line_2,
                'address_line3'             => $request->shipping_addr_line_3,
                'region_id'                 => ($request->shipping_country == 'TH')? $request->shipping_province_region : '',
                'region_code'               => ($request->shipping_country == 'TH')? $request->shipping_province_region_name : '',
                'city'                      => ($request->shipping_country == 'TH')? $request->shipping_city_name : $request->shipping_city,
                'state'                     => $request->shipping_state,
                'city_code'                 => ($request->shipping_country == 'TH')? $request->shipping_city_code : '',
                'district_code'             => ($request->shipping_country == 'TH')? $request->shipping_district_code : '',
                'district'                  => ($request->shipping_country == 'TH')? $request->shipping_district_name : '',
                'province_code'             => ($request->shipping_country == 'TH')? $request->shipping_province_th : '',
                'province_id'               => ($request->shipping_country == 'TH')? $request->shipping_province_th : '',
                'province_name'             => ($request->shipping_country == 'TH')? $request->shipping_province_name : '',
                'postal_code'               => !empty($request->shipping_postal)? $request->shipping_postal : $request->shipping_postal_th,
                'status'                    => $request->shipping_status,
                'attribute1'                => !empty($request->shipping_main_addr)? 'Y' : 'N',
                'program_code'              => 'OMM0006',
                'created_by'                => optional(auth()->user())->user_id,
                'creation_date'             => date('Y-m-d H:i:s'),
                'last_updated_by'           => optional(auth()->user())->user_id,
                'last_update_date'          => date('Y-m-d H:i:s'),
            ];

            if($shiptosite = CustomerShippingModel::create($insert)){
                GenerateNumberRepo::callPackageCreateCustomerShiptoSiteExport($shiptosite->ship_to_site_id);
                $rest = [
                    'status'    => true,
                    'data'      => 'Success'
                ];
            }else{
                $rest = [
                    'status'    => false,
                    'data'      => 'Someting Wrong'
                ];
            }

            return response()->json($rest);
        }
    }

    public function updateCustomerShipping($id,Request $request)
    {
        $validate = Validator::make($request->all(),[
            // 'shipping_number'           => 'required|unique:PTOM_CUSTOMER_SHIP_SITES,site_no,'.$id.',ship_to_site_id',
            'shipping_number'        => ['required',Rule::unique('PTOM_CUSTOMER_SHIP_SITES','site_no')
                                                        ->ignore($id,'ship_to_site_id')
                                                        ->using(function ($query) use ($id,$request) {
                                                            return $query->where('customer_id',$request->customer_id)->whereNull('deleted_at');
                                                        })],
            'shipping_place_name'       => 'required|string',
            // 'shipping_contact_name'     => 'required|string',
            // 'shipping_position'         => 'required|string',
            'shipping_country'          => 'required|string',
            'shipping_addr_line_1'      => 'required|string',
            // 'shipping_postal'           => 'required|string',
            'shipping_status'           => 'required|string',
        ]);

        if($validate->fails()){
            $rest = [
                'status'    => false,
                'type'      => 'validate',
                'data'      => $validate->errors()
            ];
            return response()->json($rest);
        }else{
            if(!empty($request->shipping_main_addr)){
                $customerShip = CustomerShippingModel::where('attribute1','Y')
                                                        ->where('customer_id',$request->customer_id)
                                                        ->whereNull('deleted_at')
                                                        ->first();
                if($customerShip){
                    if($customerShip->ship_to_site_id != $id){
                        $rest = [
                            'status'    => false,
                            'type'      => 'validate',
                            'data'      => [
                                'สถานที่จัดส่งหลัก'  => 'สามารถเลือกสถานที่จัดส่งหลักได้แค่ 1 สถานที่เท่านั้น กรุณายกเลิกสถานที่จัดส่งหลักเดิมก่อน'
                            ]
                        ];
                        return response()->json($rest);
                    }
                }
            }

            $update = [
                'site_no'                   => $request->shipping_number,
                'ship_to_site_name'         => $request->shipping_place_name,
                'ship_contact_name'         => $request->shipping_contact_name,
                'ship_contact_position'     => $request->shipping_position,
                'country_code'              => $request->shipping_country,
                'country_name'              => $request->shipping_country_name,
                'address_line1'             => $request->shipping_addr_line_1,
                'address_line2'             => $request->shipping_addr_line_2,
                'address_line3'             => $request->shipping_addr_line_3,
                'region_id'                 => ($request->shipping_country == 'TH')? $request->shipping_province_region : '',
                'region_code'               => ($request->shipping_country == 'TH')? $request->shipping_province_region_name : '',
                'city'                      => ($request->shipping_country == 'TH')? $request->shipping_city_name : $request->shipping_city,
                'state'                     => $request->shipping_state,
                'district'                  => ($request->shipping_country == 'TH')? $request->shipping_district_name : '',
                'city_code'                 => ($request->shipping_country == 'TH')? $request->shipping_city_code : '',
                'district_code'             => ($request->shipping_country == 'TH')? $request->shipping_district_code : '',
                'province_code'             => ($request->shipping_country == 'TH')? $request->shipping_province_th : '',
                'province_id'               => ($request->shipping_country == 'TH')? $request->shipping_province_th : '',
                'province_name'             => ($request->shipping_country == 'TH')? $request->shipping_province_name : '',
                'postal_code'               => !empty($request->shipping_postal)? $request->shipping_postal : $request->shipping_postal_th ,
                'status'                    => $request->shipping_status,
                'attribute1'                => !empty($request->shipping_main_addr)? 'Y' : 'N',
                'last_updated_by'           => optional(auth()->user())->user_id,
                'last_update_date'          => date('Y-m-d H:i:s'),
            ];

            if(CustomerShippingModel::where('ship_to_site_id',$id)->update($update)){
                $test = GenerateNumberRepo::callPackageUpdateCustomerShiptoSiteExport($id);
                $rest = [
                    'status'    => true,
                    'data'      => 'Success',
                    'test'      => $test
                ];
            }else{
                $rest = [
                    'status'    => false,
                    'data'      => 'Someting Wrong'
                ];
            }

            return response()->json($rest);
        }
    }

    public function delCustomerShipping($id)
    {
        $del = [
            'deleted_at'        => date('Y-m-d H:i:s'),
            'deleted_by_id'     => optional(auth()->user())->user_id,
        ];

        if(CustomerShippingModel::where('ship_to_site_id',$id)->update($del)){
            $rest = [
                'status'    => true,
                'data'      => 'Success'
            ];
        }else{
            $rest = [
                'status'    => false,
                'data'      => 'Someting Wrong'
            ];
        }

        return response()->json($rest);
    }


}
