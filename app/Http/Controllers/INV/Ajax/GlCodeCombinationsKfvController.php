<?php

namespace App\Http\Controllers\INV\Ajax;

use App\Http\Controllers\Controller;
use App\Models\INV\GlCodeCombinationsKfv;
use Illuminate\Http\Request;

class GlCodeCombinationsKfvController extends Controller
{
    public function index()
    {
        $glCodeCombinations = GlCodeCombinationsKfv::select('concatenated_segments')
            ->when(request()->text, function($q) {
                $q->where('concatenated_segments', request()->text);
            })
            ->get();
        return response()->json($glCodeCombinations);
    }
}
