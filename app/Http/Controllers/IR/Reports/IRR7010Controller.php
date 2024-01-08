<?php

namespace App\Http\Controllers\IR\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\IR\IRR7010;
use Maatwebsite\Excel\Facades\Excel;

use DB;
use PDO;

use App\Exports\CT\CTM0015;
class IRR7010Controller extends Controller
{
    
    
    public function export($programCode, $request)
    {   
        
        return Excel::download(new IRR7010, $programCode.'.xlsx');
        
    }
}
