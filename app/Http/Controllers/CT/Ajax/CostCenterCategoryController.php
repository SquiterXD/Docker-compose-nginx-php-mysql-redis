<?php

namespace App\Http\Controllers\CT\Ajax;

use App\Models\CT\CostCenterCategory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CostCenterCategoryController extends Controller
{
    public function index()
    {
        $query = request()->text;
        $result = CostCenterCategory::where(function ($q) {
            $query = request()->text;
            if ($query) {
                $q->where('code', 'like', "%{$query}%")
                    ->orWhere('name', 'like', "%{$query}%");
            }
        })
        ->get();
        return response()->json($result);
    }
}
