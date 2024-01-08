<?php

namespace App\Http\Controllers\OM\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\Settings\CustomerShipSiteV;
use App\Models\OM\Settings\Customer;

class ShipToSiteController extends Controller
{
    public function index()
    {
        // dd(request()->all());
        $data = CustomerShipSiteV::where('customer_id', request()->customer_id)->get();

        // dd($data);
        return response()->json($data);
    }
}
