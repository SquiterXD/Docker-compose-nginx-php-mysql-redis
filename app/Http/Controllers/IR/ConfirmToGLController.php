<?php

namespace App\Http\Controllers\IR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\IR\PtirGlInterfaces;
use App\Models\IR\Views\GlPeriodYearView;
use App\Models\IR\Views\GlCodeCombinationView;

class ConfirmToGLController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('ir.confirm-to-gl.index');
    }
}
