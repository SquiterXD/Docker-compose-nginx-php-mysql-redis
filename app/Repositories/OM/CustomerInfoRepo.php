<?php

namespace App\Repositories\OM;

use App\Models\OM\Promotions\UomV;
use App\Models\OM\PtomCustomerInfoV;
use Illuminate\Support\Facades\DB;

class CustomerInfoRepo
{
    public function getCustomerInfo($request)
    {
        return PtomCustomerInfoV::query();
    }

    public function getCustomerDistinct($request) {
        $data =  PtomCustomerInfoV::when( $request->field, function($q) use($request) {
            $q->selectRaw('DISTINCT '. $request->field);
        })
        ->whereNotNull('customer_number')
        ->when(!empty($request->sale_type) && $request->sale_type != 'ALL', function($q) use($request) {
            $q->where('sales_classification_code', $request->sale_type);
        })
        ->when($request->region_code, function($q) use ($request) {
            $q->whereIn('region_code', explode(',', $request->region_code));
        })
        ->when($request->pronvice_code, function($q) use ($request) {
            $q->whereIn('province_code', explode(',', $request->pronvice_code));
        })
        ->when($request->store_code, function($q) use ($request) {
            $q->whereIn('customer_number', explode(',', $request->store_code));
        })
        ->when($request->store_name, function($q) use ($request) {
            $q->where('customer_name', 'LIKE', '%'. $request->store_name . '%');
        })
        ->when($request->type_code, function($q) use ($request) {
            $q->whereIn('customer_type_id', explode(',', $request->type_code));
        });


        return $data;
    }
}
