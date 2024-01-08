<?php

namespace App\Http\Controllers\CT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CostRmController extends Controller
{
    public function index()
    {
      return view('ct.cost_rm.index');
    }
}
