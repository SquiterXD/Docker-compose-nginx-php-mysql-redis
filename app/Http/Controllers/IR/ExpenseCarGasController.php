<?php

namespace App\Http\Controllers\IR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExpenseCarGasController extends Controller
{
    public function index()
    {
        return view('ir.expense-car-gas.index');
    }
}
