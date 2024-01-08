<?php

namespace App\Http\Controllers\IR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IR\PtirApInvoiceInterfaces;
use App\Models\IR\Views\PtirApInterfaceTypeView;

class ConfirmToAPController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('ir.confirm-to-ap.index');
    }

}
