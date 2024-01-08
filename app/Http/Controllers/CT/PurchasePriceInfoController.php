<?php

namespace App\Http\Controllers\CT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PurchasePriceInfoController extends Controller
{
    public function index()
    {
        return view('ct.purchase_price_info.index');
    }

    public function importXls()
    {
      return view('ct.purchase_price_info.import_xlsx');
    }

    public function create()
    {
        return view('ct.purchase_price_info.create');
    }
}
