<?php

namespace App\Http\Controllers\INV\Ajax;

use App\Http\Controllers\Controller;
use App\Models\INV\MtlParameters;
use App\Models\INV\OrganizationUnits;
use Illuminate\Http\Request;

class HrOrganizationUnitController extends Controller
{
    public function index()
    {
        $organizationUnits = OrganizationUnits::selectRaw('ROWIDTOCHAR(rowid) as "rowid"')
            ->select('organization_id', 'name')
            ->when(request()->organization_code, function($q) {
                $q->whereHas('parameters', function($r) {
                    return $r->where("organization_code", request()->organization_code);
                });
            })
            ->where(function ($q) {
                $query = request()->text;
                if ($query) {
                    $q->where('organization_code', 'like', "%{$query}%");
                }
            })
            ->limit(20)
            ->get();

        foreach ($organizationUnits as $organizationUnit) {
            $organizationUnit->parameter = MtlParameters::where('organization_id', $organizationUnit->organization_id)
                ->select('organization_code')
                ->first();
        }
            
        return response()->json($organizationUnits);

    }
}
