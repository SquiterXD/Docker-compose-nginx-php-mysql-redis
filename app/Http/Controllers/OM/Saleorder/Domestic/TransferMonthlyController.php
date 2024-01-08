<?php

namespace App\Http\Controllers\OM\Saleorder\Domestic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\Saleorder\Domestic\TransferMonthlyModel;
use App\Models\Menu;


class TransferMonthlyController extends Controller
{
    public function index()
    {
        $menu = Menu::where('program_code', 'OMP0061')->first();

        return view('om.transfermonthly.domestics.index',compact('menu'));
    }
}
