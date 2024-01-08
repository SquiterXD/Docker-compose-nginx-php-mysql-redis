<?php

namespace App\Http\Controllers\PM\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PM\Settings\PrintProductType;
use App\Models\PM\Settings\FndFlexValuesVl;

class PrintProductTypeController extends Controller
{
    public function index()
    {
        $btnTrans = trans('btn');
        $listProducts = [];
        $products = PrintProductType::paginate('20');
        data_set($products, '*.is_select', true);

        foreach ($products as $key => $product) {
            array_push($listProducts, [
                'flex_value_set_id'         => isset($product['flex_value_set_id']) ? $product['flex_value_set_id'] : '',
                'flex_value_id'             => isset($product['flex_value_id']) ? $product['flex_value_id'] : '',
                'start_date_active'         => isset($product['start_date_active']) ? parseToDateTh($product['start_date_active']) : '',
                'end_date_active'           => isset($product['end_date_active']) ? parseToDateTh($product['end_date_active']) : '', 
                'description'               => isset($product['description']) ? $product['description'] : '',
                'value_category'            => isset($product['value_category']) ? $product['value_category'] : '',
                'attribute26'               => isset($product['attribute26']) ? $product['attribute26'] : '',
                'attribute27'               => isset($product['attribute27']) ? $product['attribute27'] : '',
                'is_select'                 => isset($product['is_select']) ? $product['is_select'] : '',
            ]);
        }

        return view('pm.settings.print-product-type.index', compact('products', 'listProducts', 'btnTrans'));
    }

    public function update (Request $request)
    {
        // dd($request->all());
        $userId = optional(auth()->user())->user_id ?? -1;

        // $data = $request->validate([
        //     'machnie_group' => 'required',
        //     'feeder_code' => 'required',
        // ], [
        //     'machnie_group.required' => 'โปรดใส่กลุ่มชุดเครื่องจักร',
        //     'feeder_code.required' => 'โปรดใส่หัวจ่าย'
        // ]);

        \DB::beginTransaction();
        try {
            foreach($request->dataGroup as $data){
                $productType = FndFlexValuesVl::where('flex_value_id', $data['flex_value_id'])
                                                ->where('flex_value_set_id', $data['flex_value_set_id'])
                                                ->update([  'start_date_active'     =>  isset($data['start_date']) ? date('Y-M-d', strtotime(parseFromDateth($data['start_date']))) 
                                                                                        : ($data['start_date_active'] ? date('Y-M-d', strtotime(parseFromDateth($data['start_date_active'])))  : ''),
                                                            'end_date_active'       =>  isset($data['end_date']) ? date('Y-M-d', strtotime(parseFromDateth($data['end_date']))) 
                                                                                        : ($data['end_date_active'] ? date('Y-M-d', strtotime(parseFromDateth($data['end_date_active'])))  : ''),
                                                            'attribute26'           => $data['attribute26'] ]);
            }
            \DB::commit();

        } catch (\Exception $e) {
            \DB::rollBack();
            if($request->ajax()){
                $result['status'] = 'ERROR';
                $result['err_msg'] = $e->getMessage();
                return $result;
            }else{
                \Log::error($e->getMessage());
                return abort('403');
            }  
        }
        
        return redirect()->route('pm.settings.print-product-type.index')->with('success','ทำการเปลี่ยนข้อมูลกลุ่ม Product ประเภทสิ่งพิมพ์เรียบร้อยแล้ว');
        
    }
}
