<?php

namespace App\Http\Controllers\INV\Ajax;

use App\Http\Controllers\Controller;
use App\Models\INV\LookupType;
use Illuminate\Http\Request;

class FndLookupTypesController extends Controller
{
    public function index()
    {
        $lookupTypes = LookupType::query()
            ->limit(10)
            ->get();

        return response()->json($lookupTypes);
    }
}
