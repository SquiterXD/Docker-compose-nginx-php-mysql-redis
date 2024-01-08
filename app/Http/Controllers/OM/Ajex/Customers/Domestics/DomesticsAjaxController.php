<?php

namespace App\Http\Controllers\OM\Ajex\Customers\Domestics;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\OM\Customers;
use App\Models\OM\Customers\Domestics\Customer;
use App\Models\OM\Customers\Domestics\CustomerOwners;
use App\Models\OM\Customers\Domestics\CustomerPrevious;
use App\Models\OM\Customers\Domestics\CustomerQuotaHeaders;
use App\Models\OM\Customers\Domestics\CustomerQuotaLines;
use App\Models\OM\Customers\Domestics\CustomerShipSites;
use App\Models\OM\Customers\Domestics\CustomerContracts;
use App\Models\OM\Customers\Domestics\CustomerContractBooks;
use App\Models\OM\Customers\Domestics\CustomerContractGroups;
use App\Models\OM\Customers\Domestics\Territory;
use App\Models\OM\Customers\Domestics\CustomerAgentsModel;
use App\Models\OM\Customers\Domestics\SequenceEcom;
use App\Models\OM\Customers\Domestics\TaxAccountModel;
use App\Models\OM\Customers\Domestics\AgentVendorModel;
use App\Models\OM\SaleConfirmation\OrderHeaders;
use App\Models\OM\SaleConfirmation\OrderLines;
use App\Repositories\OM\CustomersRepo;
use App\Repositories\OM\GenerateNumberRepo;
use DateTime;
use Illuminate\Support\Facades\DB;

class DomesticsAjaxController extends Controller
{
    protected $perPage = 20;

    public function List()
    {
        $customer = Customer::where('SALES_CLASSIFICATION_CODE','Domestic')
                            ->where('status','Active')
                            ->whereNotNull('customer_number')
                            ->where(function($query){
                                $query->where('customer_type_id',30);
                                $query->orWhere('customer_type_id',40);
                            })
                            ->whereNull('deleted_at')
                            ->orderBy('customer_number','asc')
                            ->get();
        if($customer){

            $customer_id[] = 0;
            foreach($customer as $data_item){
                $customer_id[] = $data_item->customer_id;
            }

            $agent = CustomerAgentsModel::whereIn('customer_id',$customer_id)->whereNull('deleted_at')->get();

            $agent_list = [];
            foreach($agent as $agent_item){

                $agentvendor = AgentVendorModel::where('vendor_id',$agent_item->agent_code)->first();

                $agent_list[$agent_item->customer_id] = [
                    'id'            => $agent_item->agent_id,
                    'agent_code'    => $agent_item->agent_code,
                    'agent_code_lb' => $agentvendor->vendor_code,
                    'account_code'  => $agent_item->account_code,
                    'account_id'    => $agent_item->account_id
                ];
            }

            $customer_list = [];
            foreach($customer as $data_item){
                $customer_list[$data_item->customer_number] = [
                    'id'            => $data_item->customer_id,
                    'number'        => $data_item->customer_number,
                    'name'          => $data_item->customer_name,
                    'agent_id'      => !empty($agent_list[$data_item->customer_id])?$agent_list[$data_item->customer_id]['id'] : '',
                    'agent_code'    => !empty($agent_list[$data_item->customer_id])?$agent_list[$data_item->customer_id]['agent_code'] : '',
                    'agent_code_lb' => !empty($agent_list[$data_item->customer_id])?$agent_list[$data_item->customer_id]['agent_code_lb'] : '',
                    'acc_code'      => !empty($agent_list[$data_item->customer_id])?$agent_list[$data_item->customer_id]['account_code'] : '',
                    'acc_id'        => !empty($agent_list[$data_item->customer_id])?$agent_list[$data_item->customer_id]['account_id'] : ''
                ];
            }

        }else{
            $customer_list = [];
        }


        return response()->json(['data' => $customer_list]);
    }

    public function insertAgent(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'agent_code'        => 'required|array|min:1',
            'agent_code.*'      => 'required|string',
            'account_code'      => 'required|array|min:1',
            'account_code.*'    => 'required|string',
        ]);

        if($validate->fails()){
            $rest = [
                'status'    => false,
                'type'      => 'validate',
                'data'      => $validate->errors()
            ];
            return response()->json($rest);
        }else{
            $insertdata = $request->all();

            DB::beginTransaction();
            try {

                foreach($insertdata['agent_code'] as $key => $item){
                    if($insertdata['agent_id'][$key]){
                        $taxaccount = TaxAccountModel::where('account_id',$insertdata['account_id'][$key])->first();
                        $update = [
                            'agent_code'            => $insertdata['agent_code'][$key],
                            'account_code'          => $insertdata['account_code'][$key],
                            'account_id'            => $insertdata['account_id'][$key],
                            'account_desc'          => $taxaccount->description,
                            'segment1'              => $taxaccount->segment1,
                            'segment2'              => $taxaccount->segment2,
                            'segment3'              => $taxaccount->segment3,
                            'segment4'              => $taxaccount->segment4,
                            'segment5'              => $taxaccount->segment5,
                            'segment6'              => $taxaccount->segment6,
                            'segment7'              => $taxaccount->segment7,
                            'segment8'              => $taxaccount->segment8,
                            'segment9'              => $taxaccount->segment9,
                            'segment10'             => $taxaccount->segment10,
                            'segment11'             => $taxaccount->segment11,
                            'segment12'             => $taxaccount->segment12,
                            'segment13'             => $taxaccount->segment13,
                            'segment14'             => $taxaccount->segment14,
                            'segment15'             => $taxaccount->segment15,
                            'last_updated_by'       => optional(auth()->user())->user_id,
                            'last_update_date'      => date('Y-m-d H:i:s'),
                        ];

                        CustomerAgentsModel::where('agent_id',$insertdata['agent_id'][$key])->update($update);
                    }else{
                        $taxaccount = TaxAccountModel::where('account_id',$insertdata['account_id'][$key])->first();

                        $insert = [
                            'customer_id'           => $insertdata['customer_id'][$key],
                            'agent_code'           => $insertdata['agent_code'][$key],
                            'account_code'         => $insertdata['account_code'][$key],
                            'account_id'           => $insertdata['account_id'][$key],
                            'account_desc'         => $taxaccount->description,
                            'segment1'             => $taxaccount->segment1,
                            'segment2'             => $taxaccount->segment2,
                            'segment3'             => $taxaccount->segment3,
                            'segment4'             => $taxaccount->segment4,
                            'segment5'             => $taxaccount->segment5,
                            'segment6'             => $taxaccount->segment6,
                            'segment7'             => $taxaccount->segment7,
                            'segment8'             => $taxaccount->segment8,
                            'segment9'             => $taxaccount->segment9,
                            'segment10'            => $taxaccount->segment10,
                            'segment11'            => $taxaccount->segment11,
                            'segment12'            => $taxaccount->segment12,
                            'segment13'            => $taxaccount->segment13,
                            'segment14'            => $taxaccount->segment14,
                            'segment15'            => $taxaccount->segment15,
                            'program_code'         => 'OMM0008',
                            'created_by'           => optional(auth()->user())->user_id,
                            'creation_date'        => date('Y-m-d H:i:s'),
                            'last_updated_by'      => optional(auth()->user())->user_id,
                            'last_update_date'     => date('Y-m-d H:i:s'),
                         ];
                        CustomerAgentsModel::create($insert);
                    }
                }
                $rest = [
                    'status'    => true,
                    'data'      => 'success',
                ];

            } catch (\Exception $e) {
                DB::rollBack();
                $rest = [
                    'status'    => false,
                    'data'      => 'Someting Wrong',
                    'message'   => $e->getMessage(),
                ];
            }
            DB::commit();

            return response()->json($rest);
        }
    }

    public function deleteAgent(Request $request)
    {
        DB::beginTransaction();
        try {
            $update = [
                'deleted_by_id' => optional(auth()->user())->user_id,
                'deleted_at'    => date('Y-m-d H:i:s'),
            ];
            CustomerAgentsModel::where('agent_id',$request->id)->update($update);
            $rest = [
                'status'    => true,
                'data'      => 'success',
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            $rest = [
                'status'    => false,
                'data'      => 'Someting Wrong',
                'message'   => $e->getMessage(),
            ];
        }
        DB::commit();

        return response()->json(['data' => $rest]);
    }

    public function insertCustomersShipSites(Request $request)
    {
        $rest = [];

        $validate = Validator::make($request->all(),[
            'country_code'  => 'required|string',
            'province_id'   => 'required|string',
            'address_line1' => 'required|string',
            'alley'         => 'required|string',
            'city'          => 'required|string',
            'district'      => 'required|string',
            'region_code'   => 'required|string',
            'postal_code'   => 'required|string',
        ]);

        if($validate->fails()){
            $rest = [
                'status'    => false,
                'type'      => 'validate',
                'data'      => $validate->errors()
            ];
            return response()->json($rest);
        }else{
            $getID = CustomerShipSites::select('ship_to_site_id')->orderBy('ship_to_site_id', 'desc')->first();

            if(!empty($getID)){
                $shipLastID = $getID->ship_to_site_id+1;
            }else{
                $shipLastID = 1;
            }

            $getSiteNo = CustomerShipSites::select('site_no')->where('customer_id', '=', $request->customer_id)->whereNull('DELETED_AT')->orderBy('site_no', 'desc')->first();

            if ($request->attribute1 == 'on') {
                $shipsiteRemove = [
                    'attribute1'    => 'N'
                ];
                CustomerShipSites::where('customer_id', $request->customer_id)->update($shipsiteRemove);
            }

            if(!empty($getSiteNo)){
                $siteNo = $getSiteNo->site_no +1;
            }else{
                $siteNo = 1;
            }

            $insert = [
                'ship_to_site_id'       => $shipLastID,
                'customer_id'           => $request->customer_id,
                'site_no'               => $siteNo,
                'ship_to_site_code'     => 'SHIP_TO',
                'ship_to_site_name'     => $request->ship_to_site_name,
                'ship_contact_name'     => $request->ship_contact_name,
                'ship_contact_position' => $request->ship_contact_position,
                'country_code'          => $request->country_code,
                'country_name'          => $request->country_name,
                'province_id'           => $request->province_id,
                'province_code'         => $request->province_id,
                'province_name'         => $request->province_name,
                'address_line1'         => $request->address_line1,
                'alley'                 => $request->alley,
                'city'                  => $request->city,
                'city_code'             => $request->city_code,
                'district'              => $request->district,
                'district_code'         => $request->district_code,
                'region_code'           => $request->region_code,
                'region_id'             => $request->region_id,
                'postal_code'           => $request->postal_code,
                'status'                => $request->status,
                'attribute1'            => $request->attribute1 == 'on' ? 'Y' : 'N',
                'program_code'          => 'OMM0007',
                'created_by'            => optional(auth()->user())->user_id,
                'creation_date'         => date('Y-m-d H:i:s'),
                'last_updated_by'       => optional(auth()->user())->user_id,
            ];

            $customerInfo = Customer::where('customer_id', '=', $request->customer_id)->first();

            if($customerInfo->interface_status != 'C') {
                CustomersRepo::callWMSPackageCreateCustomers($customerInfo->customer_id);
            }

            if(CustomerShipSites::insert($insert)){

                CustomersRepo::callWMSPackageCreateCustomersShipTo($shipLastID);

                $dataList = CustomerShipSites::where('customer_id', '=', $request->customer_id)->whereNull('DELETED_AT')->orderBy('site_no', 'asc')->get();

                $rest = [
                    'status'    => true,
                    'data'      => 'Success',
                    'dataList'  => $dataList
                ];
            }else{
                $rest = [
                    'status'    => false,
                    'data'      => 'Someting Wrong'
                ];
            }
        }

        return response()->json(['data' => $rest]);
    }

    public function insertCustomersPrevious(Request $request)
    {
        $rest = [];

        // echo '<pre>';
        // print_r($request->all());
        // echo '</pre>';
        // exit();

        $validate = Validator::make($request->all(),[
            'previous_name'     => 'required|string',
            'country_code'      => 'required|string',
            'province_id'       => 'required|string',
            'address'           => 'required|string',
            'alley'             => 'required|string',
            'city'              => 'required|string',
            'district'          => 'required|string',
        ]);

        if($validate->fails()){
            $rest = [
                'status'    => false,
                'type'      => 'validate',
                'data'      => $validate->errors()
            ];
            return response()->json($rest);
        }else{

            // วันที่เร่ิมเปลี่ยนแปลง
            if(!empty($request->start_change_date)){
                $dateArr    = explode('/', $request->start_change_date);
                $day        = $dateArr[0];
                $month      = $dateArr[1];
                $year       = $dateArr[2] - 543;
                $newDate    = $month.'/'.$day.'/'.$year;

                $startTime = strtotime($newDate);
                $startDate = date('Y-m-d H:i:s',$startTime);
            }else{
                $startDate = '';
            }

            // วันที่สุดท้ายเปลี่ยนแปลง
            if(!empty($request->end_change_date)){
                $dateArr    = explode('/', $request->end_change_date);
                $day        = $dateArr[0];
                $month      = $dateArr[1];
                $year       = $dateArr[2] - 543;
                $newDate    = $month.'/'.$day.'/'.$year;

                $endTime = strtotime($newDate);
                $endDate = date('Y-m-d H:i:s',$endTime);
            }else{
                $endDate = '';
            }

            // วันที่สุดท้ายเปลี่ยนแปลง
            if(!empty($request->cancel_date)){
                $dateArr    = explode('/', $request->cancel_date);
                $day        = $dateArr[0];
                $month      = $dateArr[1];
                $year       = $dateArr[2] - 543;
                $newDate    = $month.'/'.$day.'/'.$year;

                $cancelTime = strtotime($newDate);
                $cancelDate = date('Y-m-d H:i:s',$cancelTime);
            }else{
                $cancelDate = '';
            }

            $getPreviousNo = CustomerPrevious::select('previous_no')->where('customer_id', '=', $request->customer_id)->whereNull('DELETED_AT')->orderBy('previous_no', 'desc')->first();
            if(!empty($getPreviousNo)){
                $previousNo = $getPreviousNo->previous_no +1;
            }else{
                $previousNo = 1;
            }

            $insert = [
                'customer_id'           => $request->customer_id,
                'previous_no'           => $previousNo,
                'country_name'          => $request->country_name,
                'province_name'         => $request->province_name,
                'previous_name'         => $request->previous_name,
                'start_change_date'     => $startDate,
                'end_change_date'       => $endDate,
                'country_code'          => $request->country_code,
                'province_id'           => $request->province_id,
                'address'               => $request->address,
                'alley'                 => $request->alley,
                'city'                  => $request->city,
                'district'              => $request->district,
                'region_id'             => $request->region_id,
                'region_code'           => $request->region_id,
                'postal_code'           => $request->postal_code,
                'cancel_reason'         => $request->cancel_reason,
                'cancel_date'           => $cancelDate,
                'program_code'          => 'OMM0007',
                'created_by'            => optional(auth()->user())->user_id,
                'creation_date'         => date('Y-m-d H:i:s'),
                'last_updated_by'       => optional(auth()->user())->user_id,
            ];

            // echo '<pre>';
            // print_r($insert);
            // echo '</pre>';
            // exit();

            if(CustomerPrevious::insert($insert)){
                $dataList = CustomerPrevious::where('customer_id', '=', $request->customer_id)->whereNull('DELETED_AT')->orderBy('previous_no', 'asc')->get();

                foreach ($dataList as $key => $value) {
                    $dataList[$key]->start_change_date = !empty($value->start_change_date) ? dateFormatThaiString($value->start_change_date) : '';
                    $dataList[$key]->end_change_date = !empty($value->end_change_date) ? dateFormatThaiString($value->end_change_date) : '';
                    $dataList[$key]->cancel_date = !empty($value->cancel_date) ? dateFormatThaiString($value->cancel_date) : '';
                }

            $rest = [
                'status'    => true,
                'data'      => 'Success',
                'dataList'  => $dataList
            ];
            }else{
                $rest = [
                    'status'    => false,
                    'data'      => 'Someting Wrong'
                ];
            }
        }

        return response()->json(['data' => $rest]);
    }

    public function insertCustomersOwner(Request $request)
    {
        $rest = [];

        $validate = Validator::make($request->all(),[
            'owner_first_name'  => 'required|string',
            'owner_last_name'   => 'required|string',
            'card_id'           => 'required|string',
            'taxpayer_id'       => 'required|string',
        ]);

        if($validate->fails()){
            $rest = [
                'status'    => false,
                'type'      => 'validate',
                'data'      => $validate->errors()
            ];
            return response()->json($rest);
        }else{

            // วัน-เดือน-ปี เกิด
            if(!empty($request->birth_date)){
                $dateArr    = explode('/', $request->birth_date);
                $day        = $dateArr[0];
                $month      = $dateArr[1];
                $year       = $dateArr[2] - 543;
                $newDate    = $month.'/'.$day.'/'.$year;

                $birthTime = strtotime($newDate);
                $birthDate = date('Y-m-d H:i:s',$birthTime);
            }else{
                $birthDate = '';
            }

            // วันที่เปลี่ยนแปลงสถานภาพ
            if(!empty($request->owner_change_date)){
                $dateArr    = explode('/', $request->owner_change_date);
                $day        = $dateArr[0];
                $month      = $dateArr[1];
                $year       = $dateArr[2] - 543;
                $newDate    = $month.'/'.$day.'/'.$year;

                $ownerTime  = strtotime($newDate);
                $ownerDate  = date('Y-m-d H:i:s',$ownerTime);
            }else{
                $ownerDate  = '';
            }

            $getOwnersNo = CustomerOwners::select('owner_no')->where('customer_id', '=', $request->customer_id)->whereNull('DELETED_AT')->orderBy('owner_no', 'desc')->first();
            if(!empty($getOwnersNo)){
                $ownerNo = $getOwnersNo->owner_no +1;
            }else{
                $ownerNo = 1;
            }

            $insert = [
                'owner_no'              => $ownerNo,
                'customer_id'           => $request->customer_id,
                'prefix'                => $request->prefix,
                'owner_first_name'      => $request->owner_first_name,
                'owner_last_name'       => $request->owner_last_name,
                'birth_date'            => $birthDate,
                'owner_status'          => $request->owner_status,
                'card_id'               => $request->card_id,
                'taxpayer_id'           => $request->taxpayer_id,
                'phone'                 => $request->phone,
                'fax_number'            => $request->fax_number,
                'mobile_number'         => $request->mobile_number,
                'owner_email'           => $request->owner_email,
                'owner_type'            => $request->owner_type,
                'owner_change_date'     => $ownerDate,
                'status'                => $request->status,
                'program_code'          => 'OMM0007',
                'created_by'            => optional(auth()->user())->user_id,
                'creation_date'         => date('Y-m-d H:i:s'),
                'last_updated_by'       => optional(auth()->user())->user_id,
            ];

            // echo '<pre>';
            // print_r($insert);
            // echo '<pre>';
            // exit();

            if(CustomerOwners::insert($insert)){
                $dataList = CustomerOwners::where('customer_id', '=', $request->customer_id)->whereNull('DELETED_AT')->orderBy('owner_no', 'asc')->get();

                $rest = [
                    'status'    => true,
                    'data'      => 'Success',
                    'dataList'  => $dataList
                ];
            }else{
                $rest = [
                    'status'    => false,
                    'data'      => 'Someting Wrong'
                ];
            }
        }

        return response()->json(['data' => $rest]);
    }

    public function insertCustomersContracts(Request $request)
    {
        $rest = [];

        // echo '<pre>';
        // print_r($request->all());
        // echo '</pre>';
        // exit();

        if (!empty($request->contract_number)) {
            $getID = CustomerContracts::select('contract_id')->orderBy('contract_id', 'desc')->first();

            if(!empty($getID)){
                $contractID = $getID->contract_id+1;
            }else{
                $contractID = 1;
            }

            foreach ($request->contract_number as $key => $value) {

                // วันเริ่ม
                if(!empty($request->start_date[$key])){
                    $dateArr    = explode('/', $request->start_date[$key]);
                    $day        = $dateArr[0];
                    $month      = $dateArr[1];
                    $year       = $dateArr[2] - 543;
                    $newDate    = $month.'/'.$day.'/'.$year;

                    $startTime = strtotime($newDate);
                    $startDate = date('Y-m-d H:i:s',$startTime);
                }else{
                    $startDate = '';
                }


                // วันสิ้นสุด
                if(!empty($request->end_date[$key])){
                    $dateArr    = explode('/', $request->end_date[$key]);
                    $day        = $dateArr[0];
                    $month      = $dateArr[1];
                    $year       = $dateArr[2] - 543;
                    $newDate    = $month.'/'.$day.'/'.$year;

                    $endTime = strtotime($newDate);
                    $endDate = date('Y-m-d H:i:s',$endTime);
                }else{
                    $endDate = '';
                }

                // Credit Limit
                if (!empty($request->guarantee_amount[$key])) {
                    $guaranteeReplace    = str_replace(',', '', $request->guarantee_amount[$key]);
                    $guaranteeExplode    = explode('.', $guaranteeReplace);
                    $guarantee           = !empty($guaranteeExplode[0]) ? $guaranteeExplode[0] : 0;
                }else{
                    $guarantee           = '';
                }

                if (empty($request->contract_id[$key])) {

                    $insert = [
                        'contract_id'           => $contractID,
                        'customer_id'           => $request->customer_id,
                        'contract_number'       => $value,
                        'start_date'            => $startDate,
                        'end_date'              => $endDate,
                        'guarantee_amount'      => $guarantee,
                        'program_code'          => 'OMM0007',
                        'created_by'            => optional(auth()->user())->user_id,
                        'creation_date'         => date('Y-m-d H:i:s'),
                        'last_updated_by'       => optional(auth()->user())->user_id
                    ];

                    CustomerContracts::insert($insert);
                    $contractID += 1;
                }else{

                    $update = [
                        'customer_id'           => $request->customer_id,
                        'contract_number'       => $value,
                        'start_date'            => $startDate,
                        'end_date'              => $endDate,
                        'guarantee_amount'      => $guarantee,
                        'last_updated_by'       => optional(auth()->user())->user_id,
                        'last_update_date'      => date('Y-m-d H:i:s')
                    ];

                    CustomerContracts::where('contract_id', $request->contract_id[$key])->update($update);
                }
            }

            $dataList = CustomerContracts::where('customer_id', '=', $request->customer_id)->whereNull('DELETED_AT')->orderBy('contract_id', 'asc')->get();

            foreach ($dataList as $key => $value) {

                $dataList[$key]->color_button      = '';
                if ($value->end_date != '') {
                    $strNow = new DateTime();
                    $dateEnd = new DateTime($value->end_date);
                    $dateEnd->setTime(23, 59, 59);
                    if ($strNow > $dateEnd) {
                        $dataList[$key]->color_button = 'text-danger';
                    }
                }

                $dataList[$key]->start_date         = !empty($value->start_date) ? dateFormatDMY(date('m/d/Y',strtotime($value->start_date))) : $value->start_date;
                $dataList[$key]->end_date           = !empty($value->end_date) ? dateFormatDMY(date('m/d/Y',strtotime($value->end_date))) : $value->end_date;
                $dataList[$key]->guarantee_amount   = !empty($value->guarantee_amount) ? number_format($value->guarantee_amount, 2) : '0.00';
            }

            $rest = [
                'status'    => true,
                'data'      => 'Success',
                'dataList'  => $dataList
            ];

        }else{
            $rest = [
                'status'    => false,
                'data'      => 'Someting Wrong'
            ];
        }



        return response()->json(['data' => $rest]);
    }

    public function insertCustomersContractBooks(Request $request)
    {
        $rest = [];

        // echo '<pre>';
        // print_r($request->all());
        // echo '</pre>';
        // exit();

        if (!empty($request->book_number)) {
            $getID = CustomerContractBooks::select('contract_book_id')->orderBy('contract_book_id', 'desc')->first();

            if(!empty($getID)){
                $contractBookID = $getID->contract_book_id+1;
            }else{
                $contractBookID = 1;
            }

            foreach ($request->book_number as $key => $value) {

                // วันเริ่ม
                if(!empty($request->book_start_date[$key])){
                    $dateArr    = explode('/', $request->book_start_date[$key]);
                    $day        = $dateArr[0];
                    $month      = $dateArr[1];
                    $year       = $dateArr[2] - 543;
                    $newDate    = $month.'/'.$day.'/'.$year;

                    $startTime = strtotime($newDate);
                    $startDate = date('Y-m-d H:i:s',$startTime);
                }else{
                    $startDate = '';
                }

                // วันสิ้นสุด
                if(!empty($request->book_end_date[$key])){
                    $dateArr    = explode('/', $request->book_end_date[$key]);
                    $day        = $dateArr[0];
                    $month      = $dateArr[1];
                    $year       = $dateArr[2] - 543;
                    $newDate    = $month.'/'.$day.'/'.$year;

                    $endTime = strtotime($newDate);
                    $endDate = date('Y-m-d H:i:s',$endTime);
                }else{
                    $endDate = '';
                }

                // Credit Limit
                if (!empty($request->credit_limit[$key])) {
                    $creditLimitReplace    = str_replace(',', '', $request->credit_limit[$key]);
                    $creditLimitExplode    = explode('.', $creditLimitReplace);
                    $creditLimit           = !empty($creditLimitExplode[0]) ? $creditLimitExplode[0] : 0;
                }else{
                    $creditLimit           = '';
                }

                if (empty($request->contract_book_id[$key])) {

                    $insert = [
                        'contract_book_id'      => $contractBookID,
                        'customer_id'           => $request->customer_id,
                        'book_number'           => $value,
                        'book_start_date'       => $startDate,
                        'book_end_date'         => $endDate,
                        'credit_limit'          => $creditLimit,
                        'program_code'          => 'OMM0007',
                        'created_by'            => optional(auth()->user())->user_id,
                        'creation_date'         => date('Y-m-d H:i:s'),
                        'last_updated_by'       => optional(auth()->user())->user_id,
                    ];

                    CustomerContractBooks::insert($insert);
                    $contractBookID += 1;

                }else{

                    $update = [
                        'customer_id'           => $request->customer_id,
                        'book_number'           => $value,
                        'book_start_date'       => $startDate,
                        'book_end_date'         => $endDate,
                        'credit_limit'          => $creditLimit,
                        'last_updated_by'       => optional(auth()->user())->user_id,
                        'last_update_date'      => date('Y-m-d H:i:s')
                    ];

                    CustomerContractBooks::where('contract_book_id', $request->contract_book_id[$key])->update($update);
                }
            }

            $dataList = CustomerContractBooks::where('customer_id', '=', $request->customer_id)->whereNull('DELETED_AT')->orderBy('contract_book_id', 'asc')->get();

            foreach ($dataList as $key => $value) {

                $dataList[$key]->color_button      = '';
                if ($value->book_end_date != '') {
                    $strNow = new DateTime();
                    $dateEnd = new DateTime($value->book_end_date);
                    $dateEnd->setTime(23, 59, 59);
                    if ($strNow > $dateEnd) {
                        $dataList[$key]->color_button = 'text-danger';
                    }
                }

                // if ($key == 2) {

                    // print_r($strNow);
                    // echo '<br>';
                    // print_r($dateEnd);
                    // exit();
                // }

                $dataList[$key]->credit_limit       = !empty($value->credit_limit) ? number_format($value->credit_limit, 2, '.', ',') : '0.00';
                $dataList[$key]->book_start_date    = !empty($value->book_start_date) ? dateFormatDMY(date('m/d/Y',strtotime($value->book_start_date))) : $value->book_start_date;
                $dataList[$key]->book_end_date      = !empty($value->book_end_date) ? dateFormatDMY(date('m/d/Y',strtotime($value->book_end_date))) : $value->book_end_date;
            }

            $rest = [
                'status'    => true,
                'data'      => 'Success',
                'dataList'  => $dataList
            ];

        }else{
            $rest = [
                'status'    => false,
                'data'      => 'Someting Wrong'
            ];
        }

        return response()->json(['data' => $rest]);
    }

    public function insertCustomersContractGroups(Request $request)
    {
        $rest = [];

        // echo '<pre>';
        // print_r($request->all());
        // echo '</pre>';
        // exit();

        if (!empty($request->credit_group_code)) {

            $getID = CustomerContractGroups::select('contract_group_id')->orderBy('contract_group_id', 'desc')->first();

            if(!empty($getID)){
                $contractGroupID = $getID->contract_group_id+1;
            }else{
                $contractGroupID = 1;
            }

            $sumContractBook = CustomerContractBooks::where('customer_id', $request->customer_id)
                                                    // ->whereRaw("nvl(book_start_date, sysdate+1) < sysdate")
                                                    // ->whereRaw("nvl(book_end_date, sysdate+1) > sysdate")
                                                    // ->where('book_start_date','<=',date('Y-m-d'))
                                                    // ->where(function ($query) {
                                                    //     $query->where('book_end_date','>=',date('Y-m-d'));
                                                    //     $query->orWhereNull('book_end_date');
                                                    // })
                                                    ->whereNull('deleted_at')
                                                    ->sum('credit_limit');

            $sumCreditLimit = 0;
            foreach ($request->credit_group_code as $key => $value) {
                $valCreditLimit = !empty($request->credit_amount[$key]) ? str_replace(',', '', $request->credit_amount[$key]) : 0;
                $sumCreditLimit = $sumCreditLimit + $valCreditLimit;
            }

            // print_r($sumContractBook);
            // echo ' -- ';
            // print_r($sumCreditLimit);
            // exit();

            if ($sumCreditLimit <= $sumContractBook ) {
                foreach ($request->credit_group_code as $key => $value) {

                    // Credit Amount
                    if (!empty($request->credit_amount[$key])) {
                        $creditAmountReplace    = str_replace(',', '', $request->credit_amount[$key]);
                        $creditAmountExplode    = explode('.', $creditAmountReplace);
                        $creditAmount           = !empty($creditAmountExplode[0]) ? $creditAmountExplode[0] : 0;
                    }else{
                        $creditAmount           = '';
                    }

                    if (empty($request->contract_group_id[$key])) {

                        $insert = [
                            'contract_group_id'     => $contractGroupID,
                            'customer_id'           => $request->customer_id,
                            'credit_group_code'     => $value,
                            'credit_percentage'     => $request->credit_percentage[$key],
                            'credit_amount'         => $creditAmount,
                            'remaining_amount'      => $creditAmount,
                            'day_amount'            => $request->day_amount[$key],
                            'program_code'          => 'OMM0007',
                            'created_by'            => optional(auth()->user())->user_id,
                            'creation_date'         => date('Y-m-d H:i:s'),
                            'last_updated_by'       => optional(auth()->user())->user_id,
                        ];

                        CustomerContractGroups::insert($insert);
                        $contractGroupID += 1;
                    }else{
                        $update = [
                            'customer_id'           => $request->customer_id,
                            'credit_group_code'     => $value,
                            'credit_percentage'     => $request->credit_percentage[$key],
                            'credit_amount'         => $creditAmount,
                            'remaining_amount'      => $creditAmount,
                            'day_amount'            => $request->day_amount[$key],
                            'last_updated_by'       => optional(auth()->user())->user_id,
                            'last_update_date'      => date('Y-m-d H:i:s')
                        ];

                        CustomerContractGroups::where('contract_group_id', $request->contract_group_id[$key])->update($update);
                    }

                }

                $contractGroupCount = 0;
                $dataList = CustomerContractGroups::where('customer_id', '=', $request->customer_id)->whereNull('DELETED_AT')->orderBy('contract_group_id', 'asc')->get();

                if (!empty($dataList)) {
                    foreach ($dataList as $key => $value) {
                        $contractGroupCount = $contractGroupCount + $value->credit_amount;
                        $dataList[$key]->credit_amount =  number_format($value->credit_amount,2);
                    }
                }
                $contractGroupCount = number_format($contractGroupCount,2);

                $rest = [
                    'status'    => true,
                    'data'      => 'Success',
                    'dataList'  => $dataList,
                    'count'     => $contractGroupCount
                ];
            }else{

                $contractGroupCount = 0;
                $dataList = CustomerContractGroups::where('customer_id', '=', $request->customer_id)->whereNull('DELETED_AT')->orderBy('contract_group_id', 'asc')->get();

                if (!empty($dataList)) {
                    foreach ($dataList as $key => $value) {
                        $contractGroupCount = $contractGroupCount + $value->credit_amount;
                        $dataList[$key]->credit_amount =  number_format($value->credit_amount,2);
                    }
                }
                $contractGroupCount = number_format($contractGroupCount,2);

                $rest = [
                    'status'    => false,
                    'data'      => 'Over',
                    'dataList'  => $dataList,
                    'count'     => $contractGroupCount
                ];
            }



        }else{
            $rest = [
                'status'    => false,
                'data'      => 'Someting Wrong'
            ];
        }
        return response()->json(['data' => $rest]);
    }

    public function insertCustomersQuota(Request $request)
    {
        $rest = [];
        $overlap = '';

        // echo '<pre>';
        // print_r($request->all());
        // echo '<pre>';
        // exit();

        $validate = Validator::make($request->all(),[
            'start_date'    => 'required|string',
            'end_date'      => 'required|string',
            'status'        => 'required|string',
        ]);

        if($validate->fails()){
            $rest = [
                'status'    => false,
                'type'      => 'validate',
                'data'      => $validate->errors()
            ];
            return response()->json($rest);
        }else{

            // วันที่เริ่มใช้งาน Post
            if(!empty($request->start_date)){
                $dateArr    = explode('/', $request->start_date);
                $day        = $dateArr[0];
                $month      = $dateArr[1];
                $year       = $dateArr[2] - 543;
                $newDate    = $month.'/'.$day.'/'.$year;

                $startTime = strtotime($newDate);
                $startDate = date('Y-m-d',$startTime);
            }else{
                $startDate = '';
            }

            // วันที่สิ้นสุดใช้งาน Post
            if(!empty($request->end_date)){
                $dateArr    = explode('/', $request->end_date);
                $day        = $dateArr[0];
                $month      = $dateArr[1];
                $year       = $dateArr[2] - 543;
                $newDate    = $month.'/'.$day.'/'.$year;

                $endTime = strtotime($newDate);
                $endDate = date('Y-m-d',$endTime);
            }else{
                $endDate = '';
            }

            $getQuotaData = CustomerQuotaHeaders::where('customer_id', $request->customer_id)->where('status', 'Active')->whereNull('deleted_at')->orderBy('start_date', 'desc')->get();

            if (!empty($getQuotaData)) {

                foreach ($getQuotaData as $key => $value) {

                    $startDate1 = $startDate;
                    $endDate1   = $endDate;
                    $startDate2 = removeTimeOnDate($value->start_date);
                    $endDate2   = removeTimeOnDate($value->end_date);

                    $resultCheck = checkDateOverlap($startDate1, $endDate1, $startDate2, $endDate2);

                    if ($resultCheck == 'overlap') {
                        $overlap = 'overlap';
                    }
                }
            }

            if ($overlap == 'overlap') {
                $rest = [
                    'status'    => 'overlap',
                    'data'      => 'Someting Wrong'
                ];
            }else{

                $getQuotaNumber = CustomerQuotaHeaders::select('quota_number')->where('customer_id', '=', $request->customer_id)->whereNull('DELETED_AT')->orderBy('quota_number', 'desc')->first();

                // echo '<pre>';
                // print_r($getQuotaNumber);
                // echo '<pre>';
                // exit();

                if (!empty($getQuotaNumber)) {
                    $quotaNumberInsert = $getQuotaNumber->quota_number+1;
                }else{
                    $quotaNumberInsert = 1;
                }

                // วันที่เริ่มใช้งาน
                if(!empty($request->start_date)){
                    $dateArr    = explode('/', $request->start_date);
                    $day        = $dateArr[0];
                    $month      = $dateArr[1];
                    $year       = $dateArr[2] - 543;
                    $newDate    = $month.'/'.$day.'/'.$year;

                    $startTime = strtotime($newDate);
                    $startDate = date('Y-m-d H:i:s',$startTime);
                }else{
                    $startDate = '';
                }

                // วันที่เริ่มใช้งาน
                if(!empty($request->end_date)){
                    $dateArr    = explode('/', $request->end_date);
                    $day        = $dateArr[0];
                    $month      = $dateArr[1];
                    $year       = $dateArr[2] - 543;
                    $newDate    = $month.'/'.$day.'/'.$year;

                    $endTime = strtotime($newDate);
                    $endDate = date('Y-m-d H:i:s',$endTime);
                }else{
                    $endDate = '';
                }

                $insert = [
                    'customer_id'       => $request->customer_id,
                    'quota_number'      => $quotaNumberInsert,
                    'start_date'        => $startDate,
                    'end_date'          => $endDate,
                    'status'            => $request->status,
                    'program_code'      => 'OMM0007',
                    'created_by'        => optional(auth()->user())->user_id,
                    'creation_date'     => date('Y-m-d H:i:s'),
                    'last_updated_by'   => optional(auth()->user())->user_id,
                    'last_update_date'  => date('Y-m-d H:i:s'),
                ];

                // echo '<pre>';
                // print_r($insert);
                // echo '<pre>';
                // exit();

                if(CustomerQuotaHeaders::insert($insert)){

                    $getPrimaryID = CustomerQuotaHeaders::select('QUOTA_HEADER_ID')->orderBy('QUOTA_HEADER_ID', 'desc')->first();

                    if (!empty($request->item_id)) {
                        foreach ($request->item_id as $key => $value) {
                            if(empty($request->quota_line_id[$key]))
                            {
                                $getID = CustomerQuotaLines::select('QUOTA_LINE_ID')->orderBy('QUOTA_LINE_ID', 'desc')->first();

                                if(!empty($getID)){
                                    $quotaLinesID = $getID->ship_to_site_id+1;
                                }else{
                                    $quotaLinesID = 1;
                                }

                                // Received
                                if (!empty($request->received_quota[$key])) {
                                    $receivedReplace    = str_replace(',', '', $request->received_quota[$key]);
                                    $receivedExplode    = explode('.', $receivedReplace);
                                    $received           = !empty($receivedExplode[0]) ? $receivedExplode[0] : 0;
                                }else{
                                    $received           = '';
                                }

                                // Minimum
                                if (!empty($request->minimum_quota[$key])) {
                                    $minimumReplace    = str_replace(',', '', $request->minimum_quota[$key]);
                                    $minimumExplode    = explode('.', $minimumReplace);
                                    $minimum           = !empty($minimumExplode[0]) ? $minimumExplode[0] : 0;
                                }else{
                                    $minimum           = '';
                                }

                                // Remaining
                                if (!empty($request->remaining_quota[$key])) {
                                    $remainingReplace    = str_replace(',', '', $request->remaining_quota[$key]);
                                    $remainingExplode    = explode('.', $remainingReplace);
                                    $remaining           = !empty($remainingExplode[0]) ? $remainingExplode[0] : 0;
                                }else{
                                    $remaining           = '';
                                }

                                $insert = [
                                    'quota_line_id'     => $quotaLinesID,
                                    'item_id'           => $value,
                                    'quota_header_id'   => $getPrimaryID->quota_header_id,
                                    'item_code'         => $request->item_code[$key],
                                    'item_description'  => $request->item_description[$key],
                                    'received_quota'    => $received,
                                    'minimum_quota'     => $minimum,
                                    'remaining_quota'   => $remaining,
                                    'program_code'      => 'OMM0007',
                                    'created_by'        => optional(auth()->user())->user_id,
                                    'creation_date'     => date('Y-m-d H:i:s'),
                                    'last_updated_by'   => optional(auth()->user())->user_id,
                                    'last_update_date'  => date('Y-m-d H:i:s'),
                                ];


                                CustomerQuotaLines::insert($insert);
                            }
                        }
                    }

                    $dataList = CustomerQuotaHeaders::where('customer_id', '=', $request->customer_id)->whereNull('DELETED_AT')->orderBy('start_date', 'desc')->get();

                    if (!empty($dataList[0]->start_date)) {
                        foreach ($dataList as $key => $value) {
                            $dataList[$key]->start_date = !empty($value->start_date) ? dateFormatThaiString($value->start_date) : '';
                            $dataList[$key]->end_date = !empty($value->end_date) ? dateFormatThaiString($value->end_date) : '';
                        }
                    }

                    $rest = [
                        'status'    => 'success',
                        'data'      => 'Success',
                        'dataList'  => $dataList
                    ];
                }else{
                    $rest = [
                        'status'    => 'false',
                        'data'      => 'Someting Wrong'
                    ];
                }
            }
        }

        return response()->json(['data' => $rest]);
    }

    public function insertCustomers(Request $request)
    {
        $rest = [];

        $validate = Validator::make($request->all(),[
            'customer_type_id'      => 'required|string',
            'customer_name'         => 'required|string',
            'customer_type_id'      => 'required|string',
            'customer_name'         => 'required|string',
            'province_code'         => 'required|string',
            'address_line1'         => 'required|string',
            'alley'                 => 'required|string',
            'city'                  => 'required|string',
            'district'              => 'required|string',
            'region_code'           => 'required|string',
            'postal_code'           => 'required|string',
            'taxpayer_id'           => 'required|string',
            'tax_register_number'   => 'required|string',
        ]);

        if($validate->fails()){
            $rest = [
                'status'    => false,
                'type'      => 'validate',
                'data'      => $validate->errors()
            ];
            return response()->json($rest);
        }else{
            // วันที่ทดลองการค้า
            if(!empty($request->test_date)){
                $dateArr    = explode('/', $request->test_date);
                $day        = $dateArr[0];
                $month      = $dateArr[1];
                $year       = $dateArr[2] - 543;
                $newDate    = $month.'/'.$day.'/'.$year;

                $testTime = strtotime($newDate);
                $testDate = date('Y-m-d H:i:s',$testTime);
            }else{
                $testDate = '';
            }
            // วันที่แต่งตั้งร้านค้า
            if(!empty($request->begin_date)){
                $dateArr    = explode('/', $request->begin_date);
                $day        = $dateArr[0];
                $month      = $dateArr[1];
                $year       = $dateArr[2] - 543;
                $newDate    = $month.'/'.$day.'/'.$year;

                $beginTime = strtotime($newDate);
                $beginDate = date('Y-m-d H:i:s',$beginTime);
            }else{
                $beginDate = '';
            }
            // ได้รับสิทธิ์เป็นร้านขายส่ง
            if(!empty($request->accepted_date)){
                $dateArr    = explode('/', $request->accepted_date);
                $day        = $dateArr[0];
                $month      = $dateArr[1];
                $year       = $dateArr[2] - 543;
                $newDate    = $month.'/'.$day.'/'.$year;

                $acceptedTime = strtotime($newDate);
                $acceptedDate = date('Y-m-d H:i:s',$acceptedTime);
            }else{
                $acceptedDate = '';
            }
            // หนังสือลงวันที่
            if(!empty($request->book_date)){
                $dateArr    = explode('/', $request->book_date);
                $day        = $dateArr[0];
                $month      = $dateArr[1];
                $year       = $dateArr[2] - 543;
                $newDate    = $month.'/'.$day.'/'.$year;

                $bookTime = strtotime($newDate);
                $bookDate = date('Y-m-d H:i:s',$bookTime);
            }else{
                $bookDate = '';
            }


            // วันที่ยกเลิกร้านค้า
            if(!empty($request->cancelled_date)){
                $dateArr    = explode('/', $request->cancelled_date);
                $day        = $dateArr[0];
                $month      = $dateArr[1];
                $year       = $dateArr[2] - 543;
                $newDate    = $month.'/'.$day.'/'.$year;

                $cancelledTime = strtotime($newDate);
                $cancelledDate = date('Y-m-d H:i:s',$cancelledTime);
            }else{
                $cancelledDate = '';
            }

            $getCustomerID = Customer::select('customer_id')->orderBy('customer_id', 'desc')->first();
            if(!empty($getCustomerID)){
                $billID = $getCustomerID->customer_id +1;
            }else{
                $billID = 1;
            }

            // Capital
            if (!empty($request->capital)) {
                $capitalReplace = str_replace(',', '', $request->capital);
                $capitalExplode = explode('.', $capitalReplace);
                $capital        = !empty($capitalExplode[0]) ? $capitalExplode[0] : 0;
            }else{
                $capital        = '';
            }

            // Credit limit
            if (!empty($request->credit_limit)) {
                $creditLimitReplace = str_replace(',', '', $request->credit_limit);
                $creditLimitExplode = explode('.', $creditLimitReplace);
                $creditLimit        = !empty($creditLimitExplode[0]) ? $creditLimitExplode[0] : 0;
            }else{
                $creditLimit        = '';
            }

            // $customerNumber = GenerateNumberRepo::generateCustomerNumberDomestics();

            $insert = [
                // 'customer_number'           => $customerNumber,
                'customer_code_tm'          => $request->customer_code_tm,
                'sales_classification_code' => $request->sales_classification_code,
                'customer_type_id'          => $request->customer_type_id,
                'customer_name'             => $request->customer_name,
                'customer_short_name'       => $request->customer_short_name,
                'contact_email'             => $request->contact_email,
                'contact_phone'             => $request->contact_phone,
                'fax_number'                => $request->fax_number,
                'bill_to_site_id'           => $billID,
                'bill_to_site_code'         => 'BILL_TO',
                'bill_to_site_name'         => $request->customer_name,
                'country_code'              => $request->country_code,
                'province_code'             => $request->province_code,
                'province_name'             => $request->province_name,
                'address_line1'             => $request->address_line1,
                'alley'                     => $request->alley,
                'city_code'                 => $request->city_code,
                'city'                      => $request->city,
                'district_code'             => $request->district_code,
                'district'                  => $request->district,
                'market'                    => $request->market,
                'region_code'               => $request->region_code,
                'postal_code'               => $request->postal_code,
                'taxpayer_id'               => $request->taxpayer_id,
                'tax_register_number'       => $request->tax_register_number,
                'payment_method_id'         => $request->payment_method_id,
                'payment_method'            => $request->payment_method,
                'shipment_by_id'            => $request->shipment_by_id,
                'shipment_by'               => $request->shipment_by,
                'order_type_id'             => $request->order_type_id,
                'order_type'                => $request->order_type,
                'price_list_id'             => $request->price_list_id,
                'price_list'                => $request->price_list,
                'payment_type_id'           => $request->payment_type_id,
                'payment_type'              => $request->payment_type,
                'credit_limit'              => $creditLimit,
                'test_date'                 => $testDate,
                'begin_date'                => $beginDate,
                'accepted_date'             => $acceptedDate,
                'book_number'               => $request->book_number,
                'book_date'                 => $bookDate,
                'cancelled_date'            => $cancelledDate,
                'capital'                   => $capital,
                'other_business'            => $request->other_business,
                'branch'                    => $request->branch,
                'currency'                  => 'THB',
                'head_office_flag'          => $request->head_office_flag == 'on' ? 'Y' : 'N',
                'delivery_date'             => $request->delivery_date,
                'sales_channel_id'          => $request->sales_channel_id,
                'sales_channel'             => $request->sales_channel,
                'market'                    => $request->market,
                'node_name'                 => $request->node_name,
                'status'                    => $request->status,
                'program_code'              => 'OMM0007',
                'created_by'                => optional(auth()->user())->user_id,
                'creation_date'             => date('Y-m-d H:i:s'),
                'last_updated_by'           => optional(auth()->user())->user_id,
                'last_update_date'          => date('Y-m-d H:i:s'),
            ];

            if(Customer::insert($insert)){
                $customerQuery = Customer::select('customer_id')->orderBy('customer_id', 'desc')->first();

                if($request['status'] != 'Draft'){
                    CustomersRepo::callWMSPackageCreateCustomers($customerQuery->customer_id);
                }

                $rest = [
                    'status'        => true,
                    'data'          => 'Success',
                    'customer_id'   => !empty($customerQuery->customer_id) ? $customerQuery->customer_id : 1
                ];
            }else{
                $rest = [
                    'status'    => false,
                    'data'      => 'Someting Wrong'
                ];
            }
        }

        return response()->json(['data' => $rest]);
    }

    public function updateCustomers($id,Request $request)
    {
        $rest = [];

        $validate = Validator::make($request->all(),[
            'customer_type_id'          => 'required|string',
            'customer_name'             => 'required|string',
            'country_code'              => 'required|string',
            'country_name'              => 'required|string',
            'province_code'             => 'required|string',
            'address_line1'             => 'required|string',
            'alley'                     => 'required|string',
            'city'                      => 'required|string',
            'district'                  => 'required|string',
            'region_code'               => 'required|string',
            'postal_code'               => 'required|string',
            'taxpayer_id'               => 'required|string',
            'tax_register_number'       => 'required|string',
        ]);

        if($validate->fails()){
            $rest = [
                'status'    => false,
                'type'      => 'validate',
                'data'      => $validate->errors()
            ];
            return response()->json($rest);
        }else{

            if($request->status == 'Active')
            {
                if($request->customer_number != ''){
                    $customerNumber = $request->customer_number;
                }else{
                    // $last = Customer::where('customer_number', 'LIKE', 'D'.'%')->whereNotNull('customer_number')->orderBy('customer_number','desc')->first();

                    // if (empty($last->customer_number)) {
                    //     $customerNumber = 'D00001';
                    // }else{
                    //     $last_number = explode('D',$last->customer_number);
                    //     if(empty(is_numeric($last_number[1]))){
                    //         $newnumber = sprintf('%05d', 1);
                    //     }
                    //     else if(is_numeric($last_number[1])){
                    //         $newnumber = sprintf('%05d', $last_number[1]+1);
                    //     }else{
                    //         $newnumber = sprintf('%05d', 1);
                    //     }
                    //     $customerNumber = 'D'.$newnumber;
                    // }

                    $customerNumber = GenerateNumberRepo::generateCustomerNumberDomestics();


                }

            }
            else if($request->status == 'Draft')
            {
                $customerNumber = '';
            }
            else{
                $customerNumber = $request->customer_number;
            }
            $customerInfo = Customer::where('customer_id', '=', $id)->first();

            if($customerInfo->status == 'Draft' && $request->status == 'Active' && $customerInfo->interface_status != 'C') {
                CustomersRepo::callWMSPackageCreateCustomers($customerInfo->customer_id);
            }

            // วันที่ทดลองการค้า
            if(!empty($request->test_date)){
                $dateArr    = explode('/', $request->test_date);
                $day        = $dateArr[0];
                $month      = $dateArr[1];
                $year       = $dateArr[2] - 543;
                $newDate    = $month.'/'.$day.'/'.$year;

                $testTime = strtotime($newDate);
                $testDate = date('Y-m-d H:i:s',$testTime);
            }else{
                $testDate = '';
            }

            // วันที่แต่งตั้งร้านค้า
            if(!empty($request->begin_date)){
                $dateArr    = explode('/', $request->begin_date);
                $day        = $dateArr[0];
                $month      = $dateArr[1];
                $year       = $dateArr[2] - 543;
                $newDate    = $month.'/'.$day.'/'.$year;

                $beginTime = strtotime($newDate);
                $beginDate = date('Y-m-d H:i:s',$beginTime);
            }else{
                $beginDate = '';
            }

            // ได้รับสิทธิ์เป็นร้านขายส่ง
            if(!empty($request->accepted_date)){
                $dateArr    = explode('/', $request->accepted_date);
                $day        = $dateArr[0];
                $month      = $dateArr[1];
                $year       = $dateArr[2] - 543;
                $newDate    = $month.'/'.$day.'/'.$year;

                $acceptedTime = strtotime($newDate);
                $acceptedDate = date('Y-m-d H:i:s',$acceptedTime);
            }else{
                $acceptedDate = '';
            }

            // หนังสือลงวันที่
            if(!empty($request->book_date)){
                $dateArr    = explode('/', $request->book_date);
                $day        = $dateArr[0];
                $month      = $dateArr[1];
                $year       = $dateArr[2] - 543;
                $newDate    = $month.'/'.$day.'/'.$year;

                $bookTime = strtotime($newDate);
                $bookDate = date('Y-m-d H:i:s',$bookTime);
            }else{
                $bookDate = '';
            }

            // วันที่ยกเลิกร้านค้า
            if(!empty($request->cancelled_date)){
                $dateArr    = explode('/', $request->cancelled_date);
                $day        = $dateArr[0];
                $month      = $dateArr[1];
                $year       = $dateArr[2] - 543;
                $newDate    = $month.'/'.$day.'/'.$year;

                $cancelledTime = strtotime($newDate);
                $cancelledDate = date('Y-m-d H:i:s',$cancelledTime);
            }else{
                $cancelledDate = '';
            }

            // Capital
            if (!empty($request->capital)) {
                $capitalReplace = str_replace(',', '', $request->capital);
                $capitalExplode = explode('.', $capitalReplace);
                $capital        = !empty($capitalExplode[0]) ? $capitalExplode[0] : 0;
            }else{
                $capital        = '';
            }

            // Credit limit
            if (!empty($request->credit_limit)) {
                $creditLimitReplace = str_replace(',', '', $request->credit_limit);
                $creditLimitExplode = explode('.', $creditLimitReplace);
                $creditLimit        = !empty($creditLimitExplode[0]) ? $creditLimitExplode[0] : 0;
            }else{
                $creditLimit        = '';
            }


            $update = [
                'customer_number'           => $customerNumber,
                'attribute2'                => $request->attribute2,
                'customer_code_tm'          => $request->customer_code_tm,
                'customer_type_id'          => $request->customer_type_id,
                'customer_name'             => $request->customer_name,
                'customer_short_name'       => $request->customer_short_name,
                'contact_email'             => $request->contact_email,
                'contact_phone'             => $request->contact_phone,
                'fax_number'                => $request->fax_number,
                'country_code'              => $request->country_code,
                'country_name'              => $request->country_name,
                'province_code'             => $request->province_code,
                'province_name'             => $request->province_name,
                'address_line1'             => $request->address_line1,
                'alley'                     => $request->alley,
                'city_code'                 => $request->city_code,
                'city'                      => $request->city,
                'district_code'             => $request->district_code,
                'district'                  => $request->district,
                'market'                    => $request->market,
                'region_code'               => $request->region_code,
                'postal_code'               => $request->postal_code,
                'taxpayer_id'               => $request->taxpayer_id,
                'tax_register_number'       => $request->tax_register_number,
                'payment_method_id'         => $request->payment_method_id,
                'payment_method'            => $request->payment_method,
                'shipment_by_id'            => $request->shipment_by_id,
                'shipment_by'               => $request->shipment_by,
                'order_type_id'             => $request->order_type_id,
                'order_type'                => $request->order_type,
                'price_list_id'             => $request->price_list_id,
                'price_list'                => $request->price_list,
                'payment_type_id'           => $request->payment_type_id,
                'payment_type'              => $request->payment_type,
                'credit_limit'              => $creditLimit,
                'test_date'                 => $testDate,
                'begin_date'                => $beginDate,
                'accepted_date'             => $acceptedDate,
                'book_number'               => $request->book_number,
                'book_date'                 => $bookDate,
                'cancelled_date'            => ($request->status == 'Inactive' && $cancelledDate == '') ? date('Y-m-d H:i:s') : $cancelledDate,
                'capital'                   => $capital,
                'other_business'            => $request->other_business,
                'branch'                    => $request->branch,
                'head_office_flag'          => $request->head_office_flag == 'on' ? 'Y' : 'N',
                'delivery_date'             => $request->delivery_date,
                'sales_channel_id'          => $request->sales_channel_id,
                'sales_channel'             => $request->sales_channel,
                'market'                    => $request->market,
                'node_name'                 => $request->node_name,
                'status'                    => $request->status,
                'program_code'              => 'OMM0007',
                'last_updated_by'           => optional(auth()->user())->user_id,
                'last_update_date'          => date('Y-m-d H:i:s'),
                // Piyawut A. Add bill_to_site_name 19012023
                'bill_to_site_name'         => $request->customer_name
            ];

            // echo '<pre>';
            // print_r($update);
            // echo '</pre>';
            // exit();

            if(Customer::where('customer_id', '=', $id)->update($update)){

                CustomersRepo::callWMSPackageUpdateCustomers($id);

                if($request->status == 'Active')
                {
                    $update['customer_web_id'] = $id;

                    // echo '<pre>';
                    // print_r($update);
                    // echo '</pre>';
                    // exit();

                    $response = Http::post(env('APP_ECOM').'/api/v1/customer/update-customers-domestic', $update);

                    // echo '<pre>';
                    // print_r($response['data']);
                    // echo '</pre>';
                    // exit();

                    $rest = [
                        'status'            => true,
                        'data'              => 'Success',
                        'customerNumber'    => $customerNumber,
                        'cancelledDate'     => '',
                        'password'          => !empty($response['data']['password']) ? $response['data']['password'] : ''
                    ];
                }
                else{

                    $cancelDate = Customers::where('customer_id', $id)->pluck('cancelled_date')->first();
                    $cancelledDate = !empty($cancelDate) ? dateFormatDMY(date('m/d/Y',strtotime($cancelDate))) : '';

                    $rest = [
                        'status'            => true,
                        'data'              => 'Success',
                        'customerNumber'    => $customerNumber,
                        'cancelledDate'     => $cancelledDate,
                        'password'          => ''
                    ];
                }
            }
            else{
                $rest = [
                    'status'    => false,
                    'data'      => 'Someting Wrong'
                ];
            }
        }

        return response()->json(['data' => $rest]);
    }

    public function updateCustomersPrevious($id,Request $request)
    {
        $rest = [];

        $validate = Validator::make($request->all(),[
            'country_code'      => 'required|string',
            'province_id'       => 'required|string',
            'address'           => 'required|string',
            'alley'             => 'required|string',
            'city'              => 'required|string',
            'district'          => 'required|string',
        ]);

        if($validate->fails()){
            $rest = [
                'status'    => false,
                'type'      => 'validate',
                'data'      => $validate->errors()
            ];
            return response()->json($rest);
        }else{

            // วันที่เร่ิมเปลี่ยนแปลง
            if(!empty($request->start_change_date)){
                $dateArr    = explode('/', $request->start_change_date);
                $day        = $dateArr[0];
                $month      = $dateArr[1];
                $year       = $dateArr[2] - 543;
                $newDate    = $month.'/'.$day.'/'.$year;

                $startTime = strtotime($newDate);
                $startDate = date('Y-m-d H:i:s',$startTime);
            }else{
                $startDate = '';
            }

            // วันที่สุดท้ายเปลี่ยนแปลง
            if(!empty($request->end_change_date)){
                $dateArr    = explode('/', $request->end_change_date);
                $day        = $dateArr[0];
                $month      = $dateArr[1];
                $year       = $dateArr[2] - 543;
                $newDate    = $month.'/'.$day.'/'.$year;

                $endTime = strtotime($newDate);
                $endDate = date('Y-m-d H:i:s',$endTime);
            }else{
                $endDate = '';
            }

            // วันที่สุดท้ายเปลี่ยนแปลง
            if(!empty($request->cancel_date)){
                $dateArr    = explode('/', $request->cancel_date);
                $day        = $dateArr[0];
                $month      = $dateArr[1];
                $year       = $dateArr[2] - 543;
                $newDate    = $month.'/'.$day.'/'.$year;

                $cancelTime = strtotime($newDate);
                $cancelDate = date('Y-m-d H:i:s',$cancelTime);
            }else{
                $cancelDate = '';
            }

            $update = [
                'previous_no'           => $request->previous_no,
                'previous_name'         => $request->previous_name,
                'start_change_date'     => $startDate,
                'end_change_date'       => $endDate,
                'country_code'          => $request->country_code,
                'province_id'           => $request->province_id,
                'address'               => $request->address,
                'alley'                 => $request->alley,
                'city'                  => $request->city,
                'district'              => $request->district,
                'region_id'             => $request->region_id,
                'postal_code'           => $request->postal_code,
                'cancel_reason'         => $request->cancel_reason,
                'cancel_date'           => $cancelDate,
                'last_updated_by'       => optional(auth()->user())->user_id,
                'last_update_date'      => date('Y-m-d H:i:s'),
            ];

            if(CustomerPrevious::where('previous_id', '=', $id)->update($update)){
                $dataList = CustomerPrevious::where('customer_id', '=', $request->customer_id)->whereNull('DELETED_AT')->orderBy('previous_no', 'asc')->get();

                foreach ($dataList as $key => $value) {
                    $dataList[$key]->start_change_date = !empty($value->start_change_date) ? dateFormatThaiString($value->start_change_date) : '';
                    $dataList[$key]->end_change_date = !empty($value->end_change_date) ? dateFormatThaiString($value->end_change_date) : '';
                    $dataList[$key]->cancel_date = !empty($value->cancel_date) ? dateFormatThaiString($value->cancel_date) : '';
                }

            $rest = [
                'status'    => true,
                'data'      => 'Success',
                'dataList'  => $dataList
            ];
            }else{
                $rest = [
                    'status'    => false,
                    'data'      => 'Someting Wrong'
                ];
            }
        }

        return response()->json(['data' => $rest]);
    }

    public function updateCustomersOwner($id,Request $request)
    {
        $rest = [];

        $validate = Validator::make($request->all(),[
            'owner_first_name'  => 'required|string',
            'owner_last_name'   => 'required|string',
            'card_id'           => 'required|string',
            'taxpayer_id'       => 'required|string',
            'owner_type'        => 'required|string',
        ]);

        if($validate->fails()){
            $rest = [
                'status'    => false,
                'type'      => 'validate',
                'data'      => $validate->errors()
            ];
            return response()->json($rest);
        }else{

            // วัน-เดือน-ปี เกิด
            if(!empty($request->birth_date)){
                $dateArr    = explode('/', $request->birth_date);
                $day        = $dateArr[0];
                $month      = $dateArr[1];
                $year       = $dateArr[2] - 543;
                $newDate    = $month.'/'.$day.'/'.$year;

                $birthTime = strtotime($newDate);
                $birthDate = date('Y-m-d H:i:s',$birthTime);
            }else{
                $birthDate = '';
            }

            // วันที่เปลี่ยนแปลงสถานภาพ
            if(!empty($request->owner_change_date)){
                $dateArr    = explode('/', $request->owner_change_date);
                $day        = $dateArr[0];
                $month      = $dateArr[1];
                $year       = $dateArr[2] - 543;
                $newDate    = $month.'/'.$day.'/'.$year;

                $ownerTime  = strtotime($newDate);
                $ownerDate  = date('Y-m-d H:i:s',$ownerTime);
            }else{
                $ownerDate  = '';
            }

            $update = [
                'owner_no'              => $request->owner_no,
                'prefix'                => $request->prefix,
                'owner_first_name'      => $request->owner_first_name,
                'owner_last_name'       => $request->owner_last_name,
                'birth_date'            => $birthDate,
                'owner_status'          => $request->owner_status,
                'card_id'               => $request->card_id,
                'taxpayer_id'           => $request->taxpayer_id,
                'phone'                 => $request->phone,
                'fax_number'            => $request->fax_number,
                'mobile_number'         => $request->mobile_number,
                'owner_email'           => $request->owner_email,
                'owner_type'            => $request->owner_type,
                'owner_change_date'     => $ownerDate,
                'status'                => $request->status,
                'last_updated_by'       => optional(auth()->user())->user_id,
                'last_update_date'      => date('Y-m-d H:i:s'),
            ];

            // echo '<pre>';
            // print_r($update);
            // echo '<pre>';
            // exit();

            if(CustomerOwners::where('customer_owner_id', '=', $id)->update($update)){
                $dataList = CustomerOwners::where('customer_id', '=', $request->customer_id)->whereNull('DELETED_AT')->orderBy('owner_no', 'asc')->get();

                $rest = [
                    'status'    => true,
                    'data'      => 'Success',
                    'dataList'  => $dataList
                ];
            }else{
                $rest = [
                    'status'    => false,
                    'data'      => 'Someting Wrong'
                ];
            }
        }

        return response()->json(['data' => $rest]);
    }

    public function updateCustomersShipSites($id,Request $request)
    {
        $rest = [];

        $validate = Validator::make($request->all(),[
            'country_code'  => 'required|string',
            'province_id'   => 'required|string',
            'address_line1' => 'required|string',
            'alley'         => 'required|string',
            'city'          => 'required|string',
            'district'      => 'required|string',
            'region_code'   => 'required|string',
            'postal_code'   => 'required|string',
        ]);

        if($validate->fails()){
            $rest = [
                'status'    => false,
                'type'      => 'validate',
                'data'      => $validate->errors()
            ];
            return response()->json($rest);
        }else{

            if ($request->attribute1 == 'on') {
                $shipsiteRemove = [
                    'attribute1'    => 'N'
                ];
                CustomerShipSites::where('customer_id', $request->customer_id)->update($shipsiteRemove);
            }

            $update = [
                'site_no'               => $request->site_no,
                'ship_to_site_name'     => $request->ship_to_site_name,
                'ship_contact_name'     => $request->ship_contact_name,
                'ship_contact_position' => $request->ship_contact_position,
                'country_code'          => $request->country_code,
                'country_name'          => $request->country_name,
                'province_id'           => $request->province_id,
                'province_code'         => $request->province_id,
                'province_name'         => $request->province_name,
                'address_line1'         => $request->address_line1,
                'alley'                 => $request->alley,
                'city'                  => $request->city,
                'city_code'             => $request->city_code,
                'district'              => $request->district,
                'district_code'         => $request->district_code,
                'region_code'           => $request->region_code,
                'region_id'             => $request->region_id,
                'postal_code'           => $request->postal_code,
                'status'                => $request->status,
                'attribute1'            => $request->attribute1 == 'on' && $request->status != 'Inactive' ? 'Y' : 'N',
                'last_updated_by'       => optional(auth()->user())->user_id,
                'last_update_date'      => date('Y-m-d H:i:s'),
            ];
            // echo '<pre>';
            // print_r($update);
            // echo '<pre>';
            // exit();

            
            $customerInfo = Customer::where('customer_id', '=', $request->customer_id)->first();

            if($customerInfo->interface_status != 'C') {
                CustomersRepo::callWMSPackageCreateCustomers($customerInfo->customer_id);
            }
            
            if(CustomerShipSites::where('ship_to_site_id', '=', $id)->update($update)){

                CustomersRepo::callWMSPackageUpdateCustomersShipTo($id);

                if($request->attribute1 == 'on' && $request->status = 'Inactive'){
                    $newSequence = CustomerShipSites::where('customer_id', $request->customer_id)->where('status', 'Active')->orderBy('site_no', 'ASC')->first();

                    $newSequenceData = [
                        'attribute1'    => 'Y'
                    ];

                    CustomerShipSites::where('ship_to_site_id', $newSequence->ship_to_site_id)->update($newSequenceData);

                    CustomersRepo::callWMSPackageUpdateCustomersShipTo($newSequence->ship_to_site_id);
                }

                $dataList = CustomerShipSites::where('customer_id', '=', $request->customer_id)->whereNull('DELETED_AT')->orderBy('site_no', 'asc')->get();

                $rest = [
                    'status'    => true,
                    'data'      => 'Success',
                    'dataList'  => $dataList
                ];
            }else{
                $rest = [
                    'status'    => false,
                    'data'      => 'Someting Wrong'
                ];
            }
        }

        return response()->json(['data' => $rest]);
    }

    public function updateCustomersQuota($id,Request $request)
    {
        $rest = [];
        $overlap = '';

        // echo $id;
        // echo '<pre>';
        // print_r($request->all());
        // echo '<pre>';
        // exit();

        $validate = Validator::make($request->all(),[
            // 'start_date'    => 'required|string',
            // 'end_date'      => 'required|string',
            // 'status'        => 'required|string',
        ]);

        if($validate->fails()){
            $rest = [
                'status'    => false,
                'type'      => 'validate',
                'data'      => $validate->errors()
            ];
            return response()->json($rest);
        }else{

            // วันที่เริ่มใช้งาน Post
            if(!empty($request->start_date)){
                $dateArr    = explode('/', $request->start_date);
                $day        = $dateArr[0];
                $month      = $dateArr[1];
                $year       = $dateArr[2] - 543;
                $newDate    = $month.'/'.$day.'/'.$year;

                $startTime = strtotime($newDate);
                $startDate = date('Y-m-d',$startTime);
            }else{
                $dateArr    = explode('/', $request->dis_quota_start_date);
                $day        = $dateArr[0];
                $month      = $dateArr[1];
                $year       = $dateArr[2] - 543;
                $newDate    = $month.'/'.$day.'/'.$year;

                $startTime = strtotime($newDate);
                $startDate = date('Y-m-d',$startTime);
            }

            // วันที่สิ้นสุดใช้งาน Post
            if(!empty($request->end_date)){
                $dateArr    = explode('/', $request->end_date);
                $day        = $dateArr[0];
                $month      = $dateArr[1];
                $year       = $dateArr[2] - 543;
                $newDate    = $month.'/'.$day.'/'.$year;

                $endTime = strtotime($newDate);
                $endDate = date('Y-m-d',$endTime);
            }else{
                $dateArr    = explode('/', $request->dis_quota_end_date);
                $day        = $dateArr[0];
                $month      = $dateArr[1];
                $year       = $dateArr[2] - 543;
                $newDate    = $month.'/'.$day.'/'.$year;

                $endTime = strtotime($newDate);
                $endDate = date('Y-m-d',$endTime);
            }

            $getQuotaData = CustomerQuotaHeaders::where('customer_id', $request->customer_id)->where('status', 'Active')->where('quota_header_id', '!=', $request->quota_header_id)->whereNull('deleted_at')->orderBy('start_date', 'desc')->get();

            if (!empty($getQuotaData)) {

                foreach ($getQuotaData as $key => $value) {

                    $startDate1 = $startDate;
                    $endDate1   = $endDate;
                    $startDate2 = removeTimeOnDate($value->start_date);
                    $endDate2   = removeTimeOnDate($value->end_date);

                    $resultCheck = checkDateOverlap($startDate1, $endDate1, $startDate2, $endDate2);

                    if ($resultCheck == 'overlap') {
                        $overlap = 'overlap';
                    }
                }
            }

            if ($overlap == 'overlap') {
                $rest = [
                    'status'    => 'overlap',
                    'data'      => 'Someting Wrong'
                ];
            }else{

                // วันที่เริ่มใช้งาน
                if(!empty($request->start_date)){
                    $dateArr    = explode('/', $request->start_date);
                    $day        = $dateArr[0];
                    $month      = $dateArr[1];
                    $year       = $dateArr[2] - 543;
                    $newDate    = $month.'/'.$day.'/'.$year;

                    $startTime = strtotime($newDate);
                    $startDate = date('Y-m-d H:i:s',$startTime);
                }else{
                    $dateArr    = explode('/', $request->dis_quota_start_date);
                    $day        = $dateArr[0];
                    $month      = $dateArr[1];
                    $year       = $dateArr[2] - 543;
                    $newDate    = $month.'/'.$day.'/'.$year;

                    $startTime = strtotime($newDate);
                    $startDate = date('Y-m-d H:i:s',$startTime);
                }

                // วันที่เริ่มใช้งาน
                if(!empty($request->end_date)){
                    $dateArr    = explode('/', $request->end_date);
                    $day        = $dateArr[0];
                    $month      = $dateArr[1];
                    $year       = $dateArr[2] - 543;
                    $newDate    = $month.'/'.$day.'/'.$year;

                    $endTime = strtotime($newDate);
                    $endDate = date('Y-m-d H:i:s',$endTime);
                }else{
                    $dateArr    = explode('/', $request->dis_quota_end_date);
                    $day        = $dateArr[0];
                    $month      = $dateArr[1];
                    $year       = $dateArr[2] - 543;
                    $newDate    = $month.'/'.$day.'/'.$year;

                    $endTime = strtotime($newDate);
                    $endDate = date('Y-m-d H:i:s',$endTime);
                }

                $update = [
                    'start_date'        => $startDate,
                    'end_date'          => $endDate,
                    'status'            => !empty($request->status) ? $request->status : $request->dis_quota_status,
                    'last_updated_by'   => optional(auth()->user())->user_id,
                    'last_update_date'  => date('Y-m-d H:i:s'),
                ];

                // echo '<pre>';
                // print_r($request->item_id);
                // echo '<pre>';
                // exit();

                if(CustomerQuotaHeaders::where('quota_header_id', '=', $id)->update($update)){


                    if(!empty($request->item_id)){
                        foreach ($request->item_id as $key => $value) {
                            if(empty($request->quota_line_id[$key]))
                            {
                                $getID = CustomerQuotaLines::select('QUOTA_LINE_ID')->orderBy('QUOTA_LINE_ID', 'desc')->first();

                                if(!empty($getID)){
                                    $quotaLinesID = $getID->ship_to_site_id+1;
                                }else{
                                    $quotaLinesID = 1;
                                }

                                // Received
                                if (!empty($request->received_quota[$key])) {
                                    $receivedReplace    = str_replace(',', '', $request->received_quota[$key]);
                                    $receivedExplode    = explode('.', $receivedReplace);
                                    $received           = !empty($receivedExplode[0]) ? $receivedExplode[0] : 0;
                                }else{
                                    $received           = '';
                                }

                                // Minimum
                                if (!empty($request->minimum_quota[$key])) {
                                    $minimumReplace    = str_replace(',', '', $request->minimum_quota[$key]);
                                    $minimumExplode    = explode('.', $minimumReplace);
                                    $minimum           = !empty($minimumExplode[0]) ? $minimumExplode[0] : 0;
                                }else{
                                    $minimum           = '';
                                }

                                // Remaining
                                if (!empty($request->remaining_quota[$key])) {
                                    $remainingReplace    = str_replace(',', '', $request->remaining_quota[$key]);
                                    $remainingExplode    = explode('.', $remainingReplace);
                                    $remaining           = !empty($remainingExplode[0]) ? $remainingExplode[0] : 0;
                                }else{
                                    $remaining           = '';
                                }

                                $insert = [
                                    'quota_line_id'     => $quotaLinesID,
                                    'item_id'           => $value,
                                    'quota_header_id'   => $id,
                                    'item_code'         => $request->item_code[$key],
                                    'item_description'  => $request->item_description[$key],
                                    'received_quota'    => $received,
                                    'minimum_quota'     => $minimum,
                                    'remaining_quota'   => $remaining,
                                    'program_code'      => 'OMM0007',
                                    'created_by'        => optional(auth()->user())->user_id,
                                    'creation_date'     => date('Y-m-d H:i:s'),
                                    'last_updated_by'   => optional(auth()->user())->user_id,
                                    'last_update_date'  => date('Y-m-d H:i:s'),
                                ];

                                // echo '<pre>';
                                // print_r($insert);
                                // echo '<pre>';
                                // exit();


                                CustomerQuotaLines::insert($insert);
                            }else{

                                // Received
                                if (!empty($request->received_quota[$key])) {
                                    $receivedReplace    = str_replace(',', '', $request->received_quota[$key]);
                                    $receivedExplode    = explode('.', $receivedReplace);
                                    $received           = !empty($receivedExplode[0]) ? $receivedExplode[0] : 0;
                                }else{
                                    $received           = '';
                                }

                                // Minimum
                                if (!empty($request->minimum_quota[$key])) {
                                    $minimumReplace    = str_replace(',', '', $request->minimum_quota[$key]);
                                    $minimumExplode    = explode('.', $minimumReplace);
                                    $minimum           = !empty($minimumExplode[0]) ? $minimumExplode[0] : 0;
                                }else{
                                    $minimum           = '';
                                }

                                // Remaining
                                if (!empty($request->remaining_quota[$key])) {
                                    $remainingReplace    = str_replace(',', '', $request->remaining_quota[$key]);
                                    $remainingExplode    = explode('.', $remainingReplace);
                                    $remaining           = !empty($remainingExplode[0]) ? $remainingExplode[0] : 0;
                                }else{
                                    $remaining           = '';
                                }

                                $update = [
                                    'item_id'           => $value,
                                    'item_code'         => $request->item_code[$key],
                                    'item_description'  => $request->item_description[$key],
                                    'received_quota'    => $received,
                                    'minimum_quota'     => $minimum,
                                    'remaining_quota'   => $remaining,
                                    'last_updated_by'   => optional(auth()->user())->user_id,
                                    'last_update_date'  => date('Y-m-d H:i:s'),
                                ];

                                CustomerQuotaLines::where('quota_header_id', $id)->where('quota_line_id', $request->quota_line_id[$key])->update($update);
                            }


                        }
                    }

                    $dataList = CustomerQuotaHeaders::where('customer_id', '=', $request->customer_id)->whereNull('DELETED_AT')->orderBy('start_date', 'desc')->get();

                    if (!empty($dataList[0]->start_date)) {
                        foreach ($dataList as $key => $value) {
                            $dataList[$key]->start_date = !empty($value->start_date) ? dateFormatThaiString($value->start_date) : '';
                            $dataList[$key]->end_date = !empty($value->end_date) ? dateFormatThaiString($value->end_date) : '';
                        }
                    }

                    $rest = [
                        'status'    => 'success',
                        'data'      => 'Success',
                        'dataList'  => $dataList
                    ];
                }else{
                    $rest = [
                        'status'    => 'false',
                        'data'      => 'Someting Wrong'
                    ];
                }
            }
        }

        return response()->json(['data' => $rest]);
    }

    public function showPrevious($id)
    {
        $getData = CustomerPrevious::where('previous_id',$id)->first();
        $data = [];
        if(!empty($getData)){
            $data = [
                'previous_id'           => $getData->previous_id,
                'customer_id'           => $getData->customer_id,
                'previous_no'           => $getData->previous_no,
                'previous_name'         => $getData->previous_name,
                'start_change_date'     => !empty($getData->start_change_date) ? dateFormatDMY(date('m/d/Y',strtotime($getData->start_change_date))) : $getData->start_change_date,
                'end_change_date'       => !empty($getData->end_change_date) ? dateFormatDMY(date('m/d/Y',strtotime($getData->end_change_date))) : $getData->end_change_date,
                'country_code'          => $getData->country_code,
                'country_name'          => $getData->country_name,
                'province_id'           => $getData->province_id,
                'province_name'         => $getData->province_name,
                'address'               => $getData->address,
                'alley'                 => $getData->alley,
                'city'                  => $getData->city,
                'district'              => $getData->district,
                'region_id'             => $getData->region_id,
                'region_code'           => $getData->region_code,
                'postal_code'           => $getData->postal_code,
                'cancel_reason'         => $getData->cancel_reason,
                'cancel_date'           => !empty($getData->cancel_date) ? dateFormatDMY(date('m/d/Y',strtotime($getData->cancel_date))) : $getData->cancel_date,
            ];
        }

        return response()->json(['data' => $data]);
    }

    public function showOwner($id)
    {
        $getData = CustomerOwners::where('customer_owner_id',$id)->first();
        $data = [];
        if(!empty($getData)){
            $data = [
                'customer_owner_id'     => $getData->customer_owner_id,
                'customer_id'           => $getData->customer_id,
                'owner_no'              => $getData->owner_no,
                'prefix'                => $getData->prefix,
                'owner_first_name'      => $getData->owner_first_name,
                'owner_last_name'       => $getData->owner_last_name,
                'birth_date'            => !empty($getData->birth_date) ? dateFormatDMY(date('m/d/Y',strtotime($getData->birth_date))) : $getData->birth_date,
                'owner_status'          => $getData->owner_status,
                'card_id'               => $getData->card_id,
                'taxpayer_id'           => $getData->taxpayer_id,
                'phone'                 => $getData->phone,
                'fax_number'            => $getData->fax_number,
                'mobile_number'         => $getData->mobile_number,
                'owner_email'           => $getData->owner_email,
                'owner_type'            => $getData->owner_type,
                'owner_change_date'     => !empty($getData->owner_change_date) ? dateFormatDMY(date('m/d/Y',strtotime($getData->owner_change_date))) : $getData->owner_change_date,
                'status'                => $getData->status,
            ];
        }

        return response()->json(['data' => $data]);
    }

    public function showQuotaHeaders($id)
    {
        $getData = CustomerQuotaHeaders::where('quota_header_id',$id)->first();
        $data = [];
        $dataList = [];
        $haveDataInline = 'N';
        if(!empty($getData)){
            $data = [
                'quota_header_id'   => $getData->quota_header_id,
                'customer_id'       => $getData->customer_id,
                'start_date'        => !empty($getData->start_date) ? dateFormatDMY(date('m/d/Y',strtotime($getData->start_date))) : $getData->start_date,
                'end_date'          => !empty($getData->end_date) ? dateFormatDMY(date('m/d/Y',strtotime($getData->end_date))) : $getData->end_date,
                'status'            => $getData->status,
            ];

            $getDataList = CustomerQuotaLines::where('quota_header_id', '=', $getData->quota_header_id)->get();

            if (!empty($getDataList)) {
                foreach ($getDataList as $value) {
                    $dataList[] = [
                        'quota_line_id'     => $value->quota_line_id,
                        'item_id'           => $value->item_id,
                        'item_code'         => $value->item_code,
                        'item_description'  => $value->item_description,
                        'received_quota'    => $value->received_quota,
                        'minimum_quota'     => $value->minimum_quota,
                        'remaining_quota'   => $value->remaining_quota,
                    ];

                    $checkLineQuota = OrderLines::join('ptom_order_headers', 'ptom_order_headers.order_header_id', '=', 'ptom_order_lines.order_header_id')
                                            ->select('ptom_order_lines.*', 'ptom_order_headers.order_status')
                                            ->where('ptom_order_lines.quota_line_id', $value->quota_line_id)
                                            ->where('ptom_order_headers.order_status', '!=', 'Cancelled')
                                            ->first();

                    if(!empty($checkLineQuota)){

                        // foreach ($checkLineQuota as $keyLine => $checkItem) {

                            // dd($checkLineQuota);
                            $checkHeader = OrderHeaders::where('order_header_id', $checkLineQuota->order_header_id)->whereNull('order_status')->whereNotNull('order_number')->first();

                            if(empty($checkHeader->order_header_id)){
                                $haveDataInline  = 'Y';
                            }
                        // }
                    }


                }
            }
        }

        return response()->json(['data' => $data, 'dataList' => $dataList, 'haveDataInline' => $haveDataInline]);
    }

    public function showShipSites($id)
    {
        $getData = CustomerShipSites::where('ship_to_site_id',$id)->first();

        // echo '<pre>';
        // print_r($id);
        // echo '</pre>';
        // exit();

        $data = [];
        if(!empty($getData)){
            $data = [
                'ship_to_site_id'       => $getData->ship_to_site_id,
                'site_no'               => $getData->site_no,
                'ship_to_site_code'     => $getData->ship_to_site_code,
                'ship_to_site_name'     => $getData->ship_to_site_name,
                'ship_contact_name'     => $getData->ship_contact_name,
                'ship_contact_position' => $getData->ship_contact_position,
                'region_id'             => $getData->region_id,
                'region_code'           => $getData->region_code,
                'country_code'          => $getData->country_code,
                'country_name'          => $getData->country_name,
                'address_line1'         => $getData->address_line1,
                'province_id'           => $getData->province_id,
                'province_code'         => $getData->province_code,
                'province_name'         => $getData->province_name,
                'alley'                 => $getData->alley,
                'city'                  => $getData->city,
                'state'                 => $getData->state,
                'district'              => $getData->district,
                'postal_code'           => $getData->postal_code,
                'status'                => $getData->status,
                'attribute1'            => $getData->attribute1
            ];
        }

        return response()->json(['data' => $data]);
    }

    public function showLinesItems($id)
    {
        $getData = SequenceEcom::where('item_code', $id)->first();

        $data = [];
        if(!empty($getData)){
            $data = [
                'item_id'           => $getData->item_id,
                'item_code'         => $getData->item_code,
                'item_description'  => $getData->item_description,
            ];
        }

        return response()->json(['data' => $data]);
    }

    public function deleteCustomersShipSites($shipID, $customerID)
    {
        $delete = [
            'deleted_at'        => date('Y-m-d H:i:s'),
            'deleted_by_id'     => optional(auth()->user())->user_id,
        ];

        if(CustomerShipSites::where('ship_to_site_id', '=', $shipID)->update($delete)){
            $dataList = CustomerShipSites::where('customer_id', '=', $customerID)->whereNull('DELETED_AT')->orderBy('site_no', 'asc')->get();

            $rest = [
                'status'    => true,
                'data'      => 'Success',
                'dataList'  => $dataList
            ];
        }else{
            $rest = [
                'status'    => false,
                'data'      => 'Someting Wrong'
            ];
        }

        return response()->json(['data' => $rest]);
    }

    public function deleteCustomersPrevious($previousID, $customerID)
    {
        $delete = [
            'deleted_at'        => date('Y-m-d H:i:s'),
            'deleted_by_id'     => optional(auth()->user())->user_id,
        ];

        if(CustomerPrevious::where('previous_id', '=', $previousID)->update($delete)){
            $dataList = CustomerPrevious::where('customer_id', '=', $customerID)->whereNull('DELETED_AT')->orderBy('previous_no', 'asc')->get();

            $rest = [
                'status'    => true,
                'data'      => 'Success',
                'dataList'  => $dataList
            ];
        }else{
            $rest = [
                'status'    => false,
                'data'      => 'Someting Wrong'
            ];
        }

        return response()->json(['data' => $rest]);
    }

    public function deleteCustomersOwner($ownerID, $customerID)
    {
        $delete = [
            'deleted_at'        => date('Y-m-d H:i:s'),
            'deleted_by_id'     => optional(auth()->user())->user_id,
        ];

        if(CustomerOwners::where('customer_owner_id', '=', $ownerID)->update($delete)){
            $dataList = CustomerOwners::where('customer_id', '=', $customerID)->whereNull('DELETED_AT')->orderBy('owner_no', 'asc')->get();

            $rest = [
                'status'    => true,
                'data'      => 'Success',
                'dataList'  => $dataList
            ];
        }else{
            $rest = [
                'status'    => false,
                'data'      => 'Someting Wrong'
            ];
        }

        return response()->json(['data' => $rest]);
    }

    public function deleteCustomersContracts($contractID, $customerID)
    {
        $delete = [
            'deleted_at'        => date('Y-m-d H:i:s'),
            'deleted_by_id'     => optional(auth()->user())->user_id,
        ];

        if(CustomerContracts::where('contract_id', '=', $contractID)->update($delete)){
            $dataList = CustomerContracts::where('customer_id', '=', $customerID)->whereNull('DELETED_AT')->orderBy('contract_id', 'asc')->get();

            if (!empty($dataList[0]->start_date)) {
                foreach ($dataList as $key => $value) {

                    $dataList[$key]->color_button      = '';
                    if ($value->end_date != '') {
                        $strNow = new DateTime();
                        $dateEnd = new DateTime($value->end_date);
                        $dateEnd->setTime(23, 59, 59);
                        if ($strNow > $dateEnd) {
                            $dataList[$key]->color_button = 'text-danger';
                        }
                    }

                    $dataList[$key]->start_date = !empty($value->start_date) ? dateFormatDMY(date('m/d/Y',strtotime($value->start_date))) : $value->start_date;
                    $dataList[$key]->end_date = !empty($value->end_date) ? dateFormatDMY(date('m/d/Y',strtotime($value->end_date))) : $value->end_date;
                    $dataList[$key]->guarantee_amount       = !empty($value->guarantee_amount) ? number_format($value->guarantee_amount, 2) : '0.00';
                }
            }

            $rest = [
                'status'    => true,
                'data'      => 'Success',
                'dataList'  => $dataList
            ];
        }else{
            $rest = [
                'status'    => false,
                'data'      => 'Someting Wrong'
            ];
        }

        return response()->json(['data' => $rest]);
    }

    public function deleteCustomersContractBooks($contractID, $customerID)
    {
        $delete = [
            'deleted_at'        => date('Y-m-d H:i:s'),
            'deleted_by_id'     => optional(auth()->user())->user_id,
        ];

        if(CustomerContractBooks::where('contract_book_id', '=', $contractID)->update($delete)){
            $dataList = CustomerContractBooks::where('customer_id', '=', $customerID)->whereNull('DELETED_AT')->orderBy('contract_book_id', 'asc')->get();

            if (!empty($dataList[0]->book_start_date)) {
                foreach ($dataList as $key => $value) {

                    $dataList[$key]->color_button      = '';
                    if ($value->book_end_date != '') {
                        $strNow = new DateTime();
                        $dateEnd = new DateTime($value->book_end_date);
                        $dateEnd->setTime(23, 59, 59);
                        if ($strNow > $dateEnd) {
                            $dataList[$key]->color_button = 'text-danger';
                        }
                    }

                    $dataList[$key]->credit_limit       = !empty($value->credit_limit) ? number_format($value->credit_limit, 2, '.', ',') : '0.00';
                    $dataList[$key]->book_start_date    = !empty($value->book_start_date) ? dateFormatDMY(date('m/d/Y',strtotime($value->book_start_date))) : $value->book_start_date;
                    $dataList[$key]->book_end_date      = !empty($value->book_end_date) ? dateFormatDMY(date('m/d/Y',strtotime($value->book_end_date))) : $value->book_end_date;
                }
            }

            $rest = [
                'status'    => true,
                'data'      => 'Success',
                'dataList'  => $dataList
            ];
        }else{
            $rest = [
                'status'    => false,
                'data'      => 'Someting Wrong'
            ];
        }

        return response()->json(['data' => $rest]);
    }

    public function deleteCustomersContractGroups($contractID, $customerID)
    {
        $delete = [
            'deleted_at'        => date('Y-m-d H:i:s'),
            'deleted_by_id'     => optional(auth()->user())->user_id,
        ];

        if(CustomerContractGroups::where('contract_group_id', '=', $contractID)->update($delete)){
            $contractGroupCount = 0;
            $dataList = CustomerContractGroups::where('customer_id', '=', $customerID)->whereNull('DELETED_AT')->orderBy('contract_group_id', 'asc')->get();

            if (!empty($dataList)) {
                foreach ($dataList as $key => $value) {
                    $contractGroupCount = $contractGroupCount + $value->credit_amount;
                    $dataList[$key]->credit_amount =  number_format($value->credit_amount,2);
                }
            }
            $contractGroupCount = number_format($contractGroupCount,2);

            $rest = [
                'status'    => true,
                'data'      => 'Success',
                'dataList'  => $dataList,
                'count'     => $contractGroupCount
            ];
        }else{
            $rest = [
                'status'    => false,
                'data'      => 'Someting Wrong'
            ];
        }

        return response()->json(['data' => $rest]);
    }

    public function deleteCustomersQuota($quotaID, $customerID)
    {
        $delete = [
            'deleted_at'        => date('Y-m-d H:i:s'),
            'deleted_by_id'     => optional(auth()->user())->user_id,
        ];

        if(CustomerQuotaHeaders::where('quota_header_id', '=', $quotaID)->update($delete)){

            CustomerQuotaLines::where('quota_header_id', $quotaID)->delete();

            $dataList = CustomerQuotaHeaders::where('customer_id', '=', $customerID)->whereNull('DELETED_AT')->orderBy('start_date', 'desc')->get();

            if (!empty($dataList[0]->start_date)) {
                foreach ($dataList as $key => $value) {
                    $dataList[$key]->start_date = !empty($value->start_date) ? dateFormatThaiString($value->start_date) : '';
                    $dataList[$key]->end_date = !empty($value->end_date) ? dateFormatThaiString($value->end_date) : '';
                }
            }

            $rest = [
                'status'    => true,
                'data'      => 'Success',
                'dataList'  => $dataList,
            ];
        }else{
            $rest = [
                'status'    => false,
                'data'      => 'Someting Wrong'
            ];
        }

        return response()->json(['data' => $rest]);
    }

    public function deleteCustomersQuotaLines($quotaID)
    {
        if(CustomerQuotaLines::where('quota_line_id', $quotaID)->delete()){

            $rest = [
                'status'    => 'success',
                'data'      => 'Success'
            ];
        }else{
            $rest = [
                'status'    => 'fail',
                'data'      => 'Someting Wrong'
            ];
        }

        return response()->json(['data' => $rest]);
    }

    public function provinceList($id)
    {
        // GET PROVINCE LIST
        $getProvince = Territory::select('province_id', 'province_thai')->where('region_id', $id)->orwhere('region_thai', $id)->orderBy('province_thai', 'ASC')->get();

        if (!empty($getProvince)) {
            foreach ($getProvince as $key => $value) {
                $dataList[$value->province_id] = [
                    'province_id'                     => $value->province_id,
                    'province_thai'                   => $value->province_thai
                ];
            }
        }else{
            $dataList = [];
        }

        // GET CITY LIST
        $getCity = Territory::select('region_id', 'region_thai', 'city_code', 'city_thai', 'city_thai_short')->where('region_id', $id)->orWhere('region_thai', $id)->orderBy('city_thai', 'ASC')->get();

        if (!empty($getCity)) {
            foreach ($getCity as $key => $value) {
                $dataCity[$value->city_code] = [
                    'city_code'                   => $value->city_code,
                    'city_thai'                 => $value->city_thai,
                    'city_thai_short'           => $value->city_thai_short
                ];
            }

        }else{
            $dataCity = [];
        }

        $rest = [
            'data'          => $dataList,
            'dataCity'      => $dataCity
        ];

        return response()->json(['data' => $rest]);
    }

    public function cityList($id, $shipID)
    {
        if($shipID != 0 && isset($shipID)){
            $data = CustomerShipSites::where('ship_to_site_id', $shipID)
                                    ->whereNull('deleted_at')
                                    ->first();
                
            if($id == $data['province_id']){
                $getDistrict = Territory::select('region_id', 'region_thai', 'city_code', 'city_thai', 'city_thai_short')
                                        ->where('province_id', $data['province_id'])
                                        ->orderBy('city_thai_short', 'ASC')
                                        ->get();
            }else{
                $getDistrict = Territory::select('region_id', 'region_thai', 'city_code', 'city_thai', 'city_thai_short')
                                        ->where('province_id', $id)
                                        ->orderBy('city_thai_short', 'ASC')
                                        ->get();
            }
        }else{
            $getDistrict = Territory::select('region_id', 'region_thai', 'city_code', 'city_thai', 'city_thai_short')
                                    ->where('province_id', $id)
                                    ->orderBy('city_thai_short', 'ASC')
                                    ->get();
        }

        $regionID   = 0;
        $regionText = '';

        if (!empty($getDistrict)) {
            foreach ($getDistrict as $key => $value) {
                $dataList[$value->city_code] = [
                    'city_code'             => $value->city_code,
                    'city_thai'             => $value->city_thai,
                    'city_thai_short'       => $value->city_thai_short
                ];
            }
            
            if(!empty($data)) {
                $regionID = $data->region_id;
                $regionText = $data->region_code;
            } else {
                $regionID   = $getDistrict[0]->region_id;
                $regionText = $getDistrict[0]->region_thai;
            }
        }else{
            $dataList = [];
        }

        $rest = [
            'data'          => $dataList,
            'regionID'      => $regionID,
            'regionText'    => $regionText,
            'cusShipSites'  => $shipID == 0 ? '' : $data
        ];

        return response()->json(['data' => $rest]);
    }

    public function districtList($id, $shipID)
    {
        if($shipID == 0){
            $getDistrict    = Territory::select('tambon_id', 'tambon_thai', 'tambon_thai_short')
                                        ->where('city_code', $id)
                                        ->orderBy('tambon_thai', 'ASC')
                                        ->get();
        }else{
            $data = CustomerShipSites::where('ship_to_site_id', $shipID)
                                    ->whereNull('deleted_at')
                                    ->first();
            if($id != $data['city_code']){
                $getDistrict    = Territory::query()
                                            ->select('tambon_id', 'tambon_thai', 'tambon_thai_short')
                                            ->where('city_code', $data['city_code'])
                                            ->where('province_id', $data['province_id'])
                                            ->where('district_code', $data['district_code'])
                                            ->orderBy('tambon_thai', 'ASC')
                                            ->get();
                if(count($getDistrict) == 0) {
                    $getDistrict    = Territory::query()
                                    ->select('tambon_id', 'tambon_thai', 'tambon_thai_short')
                                    ->where('city_code',$id)
                                    ->orderBy('tambon_thai', 'ASC')
                                    ->get();
                } else {
                    $getDistrict    = Territory::query()
                                            ->select('tambon_id', 'tambon_thai', 'tambon_thai_short')
                                            ->where('city_code', $data['city_code'])
                                            ->orderBy('tambon_thai', 'ASC')
                                            ->get();
                }
            }else{

                $getDistrict    = Territory::select('tambon_id', 'tambon_thai', 'tambon_thai_short')
                                            ->where('city_code', $id)
                                            ->orderBy('tambon_thai', 'ASC')
                                            ->get();

            }
        }

        if (!empty($getDistrict)) {
            foreach ($getDistrict as $key => $value) {
                $dataList[$value->tambon_id] = [
                    'tambon_id'               => $value->tambon_id,
                    'tambon_thai'             => $value->tambon_thai,
                    'tambon_thai_short'       => $value->tambon_thai_short
                ];
            }
        }else{
            $dataList = [];
        }
        
        return response()->json(['data' => $dataList]);
    }

    public function postCode($id, $shipID)
    {
        $getPostCode    = Territory::select('postcode_main')->where('tambon_id', $id)->first();
        $data           = CustomerShipSites::where('ship_to_site_id', $shipID)
                                            ->whereNull('deleted_at')
                                            ->first();

        if (!empty($getPostCode)) {
            if( $data != null && 
                $data['postal_code'] != $getPostCode['postcode_main'] && 
                $data['district_code'] == $id ){
                $postCode = $data['postal_code'];
            }else{
                $postCode = $getPostCode->postcode_main;
            }
        }else{
            $postCode = '';
        }

        return response()->json(['data' => $postCode]);
    }

    public function getShiptoSiteName($id, $shipID)
    {
        $rest = [];

        $dataList = CustomerShipSites::select('ship_to_site_name')->where('customer_id', $id)->where('ship_to_site_id', '!=', $shipID)->whereNull('deleted_at')->get();

        $rest = [
            'status'    => true,
            'dataList'  => $dataList
        ];

        return response()->json(['data' => $rest]);
    }

    public function getCustomerName($id)
    {
        $rest = [];

        $dataList = Customer::select('customer_name')->where('customer_id', '!=', $id)->where('sales_classification_code', 'Domestic')->whereNull('deleted_at')->get();

        $rest = [
            'status'    => true,
            'dataList'  => $dataList
        ];

        return response()->json(['data' => $rest]);
    }

}
