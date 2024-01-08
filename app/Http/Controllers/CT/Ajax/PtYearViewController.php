<?php

namespace App\Http\Controllers\CT\Ajax;

use App\Http\Controllers\Controller;
use App\Models\CT\PtYearV;
use Illuminate\Http\Request;

class PtYearViewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return PtYearV::orderBy('year_thai', 'desc')
            ->get();
    }
}
