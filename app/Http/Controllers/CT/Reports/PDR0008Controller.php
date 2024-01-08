<?php

namespace App\Http\Controllers\CT\Reports;

use App\Exports\CT\PDR0008;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PDR0008Controller extends Controller
{
    public function PDR0008EXCEL($programcode,Request $request) {
        // return (new PDR0008($request))->view();
        return \Excel::download(new PDR0008($request), 'PDR0008.xlsx');
    }
}
