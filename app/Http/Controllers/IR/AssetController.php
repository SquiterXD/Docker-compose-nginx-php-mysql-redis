<?php

namespace App\Http\Controllers\IR;

use App\Http\Controllers\Controller;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\IR\AssetExport;

class AssetController extends Controller
{
    public function increase()
    {
        return view('ir.assets.increase.index');
    }

    public function plan()
    {
        return view('ir.assets.plan.index');
    }
    
    public function planEdit($id)
    {
        $data = $id;
        return view('ir.assets.plan.edit', compact('data'));
    }
    
    public function increaseEdit($id)
    {
        $data = $id;
        return view('ir.assets.increase.edit', compact('data'));
    }

    public function planExport()
    {
        return Excel::download(new AssetExport(), 'IRP0003'.'.xlsx');
    }

    public function increaseExport()
    {
        return Excel::download(new AssetExport(), 'IRP0004'.'.xlsx');
    }
}
