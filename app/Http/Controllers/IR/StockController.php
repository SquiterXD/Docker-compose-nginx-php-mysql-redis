<?php

namespace App\Http\Controllers\IR;

use App\Http\Controllers\Controller;

use App\Models\IR\PtirStockHeaders;
use App\Models\IR\PtirStockLines;

use Maatwebsite\Excel\Facades\Excel;

use App\Exports\IR\StockExport;
class StockController extends Controller
{
    public function yearly()
    {
        return view('ir.stocks.yearly.index');
    }

    public function yearlyEdit($id)
    {
        $data = $id;
        return view('ir.stocks.yearly.edit', compact('data'));
    }

    public function monthly()
    {
        return view('ir.stocks.monthly.index');
    }

    public function monthlyEdit($id)
    {
        $data = $id;
        return view('ir.stocks.monthly.edit', compact('data'));
    }

    public function yearlyExport()
    {
        return Excel::download(new StockExport(), 'IRP0001'.'.xlsx');
        // $header = PtirStockHeaders::find(request()->id);
        // dd('Export', request()->all(), $header);
    }

    public function monthlyExport()
    {
        return Excel::download(new StockExport(), 'IRP0002'.'.xlsx');
    }
    
}
