<?php

namespace App\Http\Controllers\OM;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use App\Models\OM\PtomPaoPercent;
use App\Models\OM\PtomCustomer;
use App\Models\OM\Api\TerritoryV;

class PaoPercentController extends Controller
{
    public function index()
    {
        return view('om.pao_percent.index');
    }

    public function store(Request $request)
    {
        $dataList = $request->data_list;
        $customer_id = $request->customer_id;

        \DB::beginTransaction();
        try {

            $now = Carbon::now();
            $user_id = getDefaultData('/users')->user_id;
            
            $dataList = collect($dataList)->filter(function ($item, $key) {
                return !!($item['province_code']) && ($item['tax_pao_percent'] > 0);
            });
            $array_pao_percent_ids = $dataList->pluck('pao_percent_id')->filter()->toArray();

            PtomPaoPercent::where('customer_id', $customer_id)->whereNotIn('pao_percent_id', $array_pao_percent_ids)->delete();

            foreach($dataList as $list){
                $paoPercent                     = !!($list['pao_percent_id']) ? PtomPaoPercent::find($list['pao_percent_id']) : new PtomPaoPercent;
                $paoPercent->customer_id        = $list['customer_id'];
                $paoPercent->customer_number    = $list['customer_number'];
                $paoPercent->province_code      = $list['province_code'];
                $paoPercent->province_name      = $list['province_name'];
                $paoPercent->tax_pao_percent    = $list['tax_pao_percent'];
                $paoPercent->program_code       = 'OMS0044';
                $paoPercent->created_by         = $user_id;
                $paoPercent->creation_date      = $now;
                $paoPercent->last_updated_by    = $user_id;
                $paoPercent->last_update_date   = $now;
                $paoPercent->created_at         = $now;
                $paoPercent->created_by_id      = $user_id;
                $paoPercent->updated_by_id      = $user_id;
                $paoPercent->save();
            }

            \DB::commit();

            $data = [
                'status' => 'S',
                'msg' => 'success',
            ];

        }catch (\Exception $e) {
            \DB::rollBack();

            \Log::error($e->getMessage());
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage(),
            ];
        }
        
        return response()->json($data);
    }

    public function getCustomerList(Request $request)
    {
        $query = $request->search;

        $customerLists = PtomCustomer::whereNotNull('customer_number')
        ->where(function($q) use ($query){
            return $q->where('customer_number', 'like', '%'.$query.'%')
            ->orWhere('customer_name', 'like', '%'.$query.'%');
        })
        ->where('status', 'Active')
        ->orderBy('customer_number')
        ->limit(50)
        ->get();
        
        return response()->json($customerLists);
    }

    public function getDataCustomer(Request $request)
    {
        $customer_id = $request->customer_id;

        $data = PtomPaoPercent::select(
            'pao_percent_id', 
            'customer_id', 
            'customer_number', 
            'province_code', 
            'province_name', 
            'tax_pao_percent'
        )
        ->where('customer_id', $customer_id)
        ->with('customer')
        ->orderBy('pao_percent_id')
        ->get();
        
        return response()->json($data);
    }

    public function getProvinceList()
    {
        $provinceLists = DB::select(DB::raw('
            SELECT distinct 
                pcss.province_code,
                ptt.province_thai province_name
            FROM ptom_customer_ship_sites pcss
                ,ptom_thailand_territory ptt
            WHERE ptt.province_id = pcss.province_code
            ORDER BY province_code
        '));

        return response()->json($provinceLists);
    }
    
}