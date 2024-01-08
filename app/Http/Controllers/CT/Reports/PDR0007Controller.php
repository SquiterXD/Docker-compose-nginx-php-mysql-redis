<?php

namespace App\Http\Controllers\CT\Reports;

use App\Exports\CT\PDR0007;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PDR0007Controller extends Controller
{
    public function PDR0007EXCEL($programcode,Request $request) {
        
        return \Excel::download(new PDR0007, 'PDR0007.xlsx');
        return (new PDR0007)->view();
    }
}
