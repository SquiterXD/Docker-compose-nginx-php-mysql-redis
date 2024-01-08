<?php

namespace App\Http\Controllers\CT\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CT\PtctCcGroupV;

class PtctCcGroupVController extends Controller
{
    public function index()
    {
        $res = PtctCcGroupV::select('acc_group AS value', 'description AS label')->get();

        return response()->json($res);
    }
}
