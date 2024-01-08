<?php

namespace App\Http\Controllers\IR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GovernorController extends Controller
{
    public function index()
    {
        return view('ir.governors.index');
    }
}
