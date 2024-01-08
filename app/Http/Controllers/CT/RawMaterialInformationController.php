<?php

namespace App\Http\Controllers\CT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CT\PtctCostCenterV;
use App\Models\CT\Ctp0002HeadersV;
use App\Models\CT\Ctp0002LinesV;

class RawMaterialInformationController extends Controller
{
    public function index()
    {
        $costs       = PtctCostCenterV::selectRaw("distinct cost_code, description")
                            ->orderBy('cost_code')
                            ->get();
                            
        $departments = collect(\DB::select("
            SELECT 
                distinct dept_code  
                ,apps.gl_flexfields_pkg.get_description_sql  
                (V.COA_ID, 3,  DEPT_CODE)     DEPT_DESC
            FROM PTCT_account_dept_v V
            ORDER BY dept_code asc
        "));

        return view('ct.raw_material_information.index', [
            'costs'       => $costs,
            'departments' => $departments,
        ]);
    }
}
