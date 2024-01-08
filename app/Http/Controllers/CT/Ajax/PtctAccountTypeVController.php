<?php

namespace App\Http\Controllers\CT\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CT\PtctAccountTypeV;

class PtctAccountTypeVController extends Controller
{
    public function index()
    {
        $res = PtctAccountTypeV::select('account_type AS value', 'description AS label')->get();

        return response()->json($res);
    }
}
