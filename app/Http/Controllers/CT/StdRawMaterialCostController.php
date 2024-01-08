<?php

namespace App\Http\Controllers\CT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StdRawMaterialCostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('ct.std_raw_material_cost.index');
    }

    public function create(){
        return view('ct.std_raw_material_cost.create');
    }
}
