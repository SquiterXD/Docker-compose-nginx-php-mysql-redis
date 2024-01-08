<?php

namespace App\Http\Controllers\CT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SetAccountTypeController extends Controller
{
    public function index()
    {
        return view('ct.set_account_type.index');
    }
}
