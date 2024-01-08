<?php

namespace App\Http\Controllers\IR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExpenseStockAssetController extends Controller
{
    public function index()
    {
        return view('ir.expense-stock-asset.index');
    }
}
