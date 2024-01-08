<?php

namespace App\Http\Controllers\IR\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InventoryNotInsuranceContrller extends Controller
{
    public function index()
    {
        return view('ir.settings.inventory-not-insurance.index');
    }

    public function export()
    {
        dd('export');
    }
}
