<?php

namespace App\Http\Controllers\OM\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\Api\CustomerTypeExport;

class CustomerTypeExportController extends Controller
{
    public function index()
    {
        $customer_type = CustomerTypeExport::get();
        return response()->json(['data' => $customer_type]);
    }

    public function byTypeId($id='')
    {
        $customer_type = CustomerTypeExport::where('customer_type',$id)->get();
        return response()->json(['data' => $customer_type]);
    }
}