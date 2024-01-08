<?php

namespace App\Http\Controllers\IR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConfirmToARController extends Controller
{
    public function index()
    {
        return view('ir.confirm-to-ar.index');
    }
}
