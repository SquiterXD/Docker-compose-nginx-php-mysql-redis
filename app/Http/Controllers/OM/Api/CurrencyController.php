<?php

namespace App\Http\Controllers\OM\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\Api\Currency;

class CurrencyController extends Controller
{
    public function index()
    {
        $currency = Currency::orderBy('description','ASC')->get();
        return response()->json(['data' => $currency]);
    }
}