<?php

namespace App\Http\Controllers\OM\Ajex\ApproveSaleOrder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\ApproveSaleOrder\OrderHeaderModel;
use App\Models\OM\ApproveSaleOrder\CustomerModel;

class ApproveSaleOrderDebtAjaxController extends Controller
{
    public function serachSaleOrder(Request $request)
    {
        $order  = OrderHeaderModel::with('CustomerData')
                                    ->where(function($query) use ($request){
                                        if(!empty($request->delivary_date)){
                                            $delivary_global    = \explode('/',$request->delivary_date);
                                            $year_delivary      = $delivary_global[2] - 543;
                                            $new_delivary       = $year_delivary.'-'.$delivary_global[1].'-'.$delivary_global[0];
                                            $query->where('delivery_date','>=',$new_delivary);
                                        }
                                        if(!empty($request->delivary_date_to)){
                                            $delivaryto_global  = \explode('/',$request->delivary_date_to);
                                            $year_delivaryto    = $delivaryto_global[2] - 543;
                                            $new_delivaryto     = $year_delivaryto.'-'.$delivaryto_global[1].'-'.$delivaryto_global[0];
                                            $query->where('delivery_date','<=',$new_delivaryto);
                                        }
                                        if(!empty($request->prepare_number)){
                                            $query->where('prepare_order_number',$request->prepare_number);
                                        }
                                        if(!empty($request->customer_id)){
                                            $query->where('customer_id',$request->customer_id);
                                        }
                                    })
                                    ->get();

        if($order->count() > 0){
            $i = 1;
            foreach($order as $order_item){
                $output['data'][] = [
                    'number'            => $i,
                    'prepare_number'    => $order_item->prepare_order_number,
                    'delivary_date'     => $order_item->delivery_date,
                    'customer_name'     => $order_item->customer_name,
                    'credit'            => '',
                    'cash'              => '',
                    'total'             => '',
                    'status'            => '',
                    'approve'           => ''
                ];
                $i++;
            }
            $rest = [
                'status'    => true,
                'data'      => $output
            ];
        }else{
            $output['data'] = '';
            $rest = [
                'status'    => false,
                'data'      => $output,
                'message'   => 'No data'
            ];
        }

        return response()->json(['data' => $rest]);
    }
}
