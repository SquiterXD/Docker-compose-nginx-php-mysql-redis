<?php

namespace App\Http\Controllers\OM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

class TaxAdjustmentsBKKController extends Controller
{
    public function index()
    {
        $btnTrans = trans('btn');
        $formatDate = 'DD/MM/YYYY';

        return view('om.tax-adjustments-bkk.index', compact('btnTrans', 'formatDate'));
    }
}
