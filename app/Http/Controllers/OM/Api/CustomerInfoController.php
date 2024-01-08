<?php

namespace App\Http\Controllers\OM\Api;

use App\Http\Controllers\Controller;
use App\Repositories\OM\CustomerInfoRepo;
use Illuminate\Http\Request;

class CustomerInfoController extends Controller
{
    public function listCustomersInfo(Request $request)
    {
        $query = (new CustomerInfoRepo)->getCustomerInfo($request);

        return $query->get();
    }

    public function listCustomersInfoFiled(Request $request)
    {
        $query = (new CustomerInfoRepo)->getCustomerDistinct($request);

        return $query->get();
    }
}
