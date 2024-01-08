<?php

namespace App\Http\Controllers\OM\Ajex;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RmaExportAjaxController extends Controller
{

    public function create($number)
    {
        $rest = [];

        return response()->json(['data' => $rest]);
    }

    public function search($number)
    {
        $rest = [];

        return response()->json(['data' => $rest]);
    }

    public function manage(Request $request)
    {
        $rest = [];

        return response()->json(['data' => $rest]);
    }
}
