<?php

namespace App\Http\Controllers\CT\Ajax;

use App\Models\CT\OrgInv;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrgInvController extends Controller
{
    public function index()
    {
        $result = OrgInv::where(function ($q) {
            $query = request()->text;
            if ($query) {
                $q->where('operating_unit', 'like', "%{$query}%")
                    ->orWhere('organization_code', 'like', "%{$query}%")
                    ->orWhere('organization_name', 'like', "%{$query}%");
            }
        })
        ->get();
        return response()->json($result);
    }

    public function orgMaterail(){
        $result = OrgInv::whereNotNull('source_item_cost')->get();
        return response()->json($result);
    }
}
