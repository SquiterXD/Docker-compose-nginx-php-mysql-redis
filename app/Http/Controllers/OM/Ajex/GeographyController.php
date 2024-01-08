<?php

namespace App\Http\Controllers\OM\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OM\Setting\HzGeography;

class GeographyController extends Controller
{
    public function index()
    {
        // dd('111');
        $geographies = HzGeography::selectRaw('geography_id, geography_type, geography_name, geography_code')->get();

        // dd($geographies);

        return response()->json(['data' => ['geographies' => $geographies]]);
    }
}
