<?php

namespace App\Http\Controllers\INV\Ajax;

use App\Http\Controllers\Controller;
use App\Models\INV\CarHistoryV;
use Illuminate\Http\Request;

class PtinvCarHistoryVController extends Controller
{
    public function index()
    {
        $carHistoryVs = CarHistoryV::get();

        return response()->json($carHistoryVs);
    }
}
