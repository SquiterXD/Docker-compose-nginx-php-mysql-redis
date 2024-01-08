<?php

namespace App\Http\Controllers\IE\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HierarchyController extends Controller
{
    public function index(Request $request)
    {

        return view('ie.settings.hierarchy.index');
    }
}
