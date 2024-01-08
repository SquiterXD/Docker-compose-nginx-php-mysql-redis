<?php

namespace App\Http\Controllers\OM;

use App\Http\Controllers\Controller;


class TomTTestController extends Controller
{
    public function index()
    {
        return view('om.tomtest.index');
    }
} 