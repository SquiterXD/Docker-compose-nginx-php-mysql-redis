<?php

namespace App\Http\Controllers\IR\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PolicyGroupController extends Controller
{
    public function index()
    {
        $btnTrans = trans('btn');
        return view('ir.settings.policy-group.index', compact('btnTrans'));
    }

    public function edit()
    {
        $btnTrans = trans('btn');
        return view('ir.settings.policy-group.edit', compact('btnTrans'));
    }
}
