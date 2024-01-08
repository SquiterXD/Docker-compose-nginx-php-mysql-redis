<?php

namespace App\Http\Controllers\INV\Ajax;

use App\Models\INV\CoaDeptCodeV;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PtglCoaDeptCodeVController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $CoaDeptCodeV = CoaDeptCodeV::query()
            ->select('department_code', 'description',)
            ->when(request()->value_set_name, function($q) {
                $q->where('flex_value_set_name', request()->value_set_name);
            })
            ->where(function ($q) {
                $query = request()->text;
                if ($query) {
                    $q->where('department_code', 'like', "%{$query}%")
                        ->orWhere('description', 'like', "%{$query}%");
                }
            })
            ->whereNull('end_date_active')
            ->limit(20)
            ->get();
        return response()->json($CoaDeptCodeV);
    }
}
