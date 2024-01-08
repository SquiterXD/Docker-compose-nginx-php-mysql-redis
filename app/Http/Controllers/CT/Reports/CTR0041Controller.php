<?php

namespace App\Http\Controllers\CT\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;

use App\Exports\CT\CTR0041Export;

class CTR0041Controller extends Controller
{
    public function export($programCode, $request)
    {
        return \Excel::download(new CTR0041Export($programCode), "{$programCode}.xlsx");
    }
}
