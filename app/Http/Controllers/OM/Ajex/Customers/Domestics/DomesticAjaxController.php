<?php

namespace App\Http\Controllers\OM\Ajex\Customers\Domestics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


use App\Models\OM\Customers\Domestics\Customer;
use App\Models\OM\Customers\Domestics\CustomerAgentsModel;

class DomesticAjaxController extends Controller
{
    public function List()
    {
        $customer = Customer::where('sales_classification_code','Domestic')
                            ->where('customer_type_id','30')
                            ->where('customer_type_id','40')
                            ->where('status','Active')
                            ->get();
        if($customer){

            $customer_id[] = 0;
            foreach($customer as $data_item){
                $customer_id[] = $data_item->customer_id;
            }

            $agent = CustomerAgentsModel::whereIn('customer_id',$customer_id)->whereNull('deleted_at')->get();

            $agent_list = [];
            foreach($agent as $agent_item){
                $agent_list[$agent_item->customer_id] = [
                    'id'            => $agent_item->agent_id,
                    'agent_code'    => $agent_item->agent_code,
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

            foreach($insertdata['agent_id'] as $key => $item){
                if($insertdata['agent_id'][$key]){
                    $update = [
                        'agent_id'          => $insertdata['agent_id'][$key],
                        'agent_code'        => $insertdata['agent_code'][$key],
                        'account_code'      => $insertdata['account_code'][$key],
                        'account_id'        => $insertdata['account_id'][$key],
                        'last_updated_by'   => optional(auth()->user())->user_id,
                        'last_update_date'  => date('Y-m-d H:i:s'),
                    ];

                    CustomerAgentsModel::where('agent_id',$insertdata['agent_id'][$key])->update($update);
                }else{
                    $insert = [
                         'agent_code'        => $insertdata['agent_code'][$key],
                         'account_code'      => $insertdata['account_code'][$key],
                         'account_id'        => $insertdata['account_id'][$key],
                         'customer_id'       => $insertdata['customer_id'][$key],
                         'created_by'        => optional(auth()->user())->user_id,
                         'creation_date'     => date('Y-m-d H:i:s'),
                         'last_updated_by'   => optional(auth()->user())->user_id,
                         'last_update_date'  => date('Y-m-d H:i:s'),
                     ];
                    CustomerAgentsModel::create($insert);
                }
            }
            $rest = [
                'status'    => true,
                'data'      => 'Success'
            ];
        }

        return response()->json($rest);
    }

}
