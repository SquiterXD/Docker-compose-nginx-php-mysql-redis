<?php

namespace App\Http\Controllers\INV\Ajax;

use App\Http\Controllers\Controller;
use App\Models\INV\FndFlexValuesVl;
use App\Models\INV\SystemItemB;
use Illuminate\Http\Request;

class ToatInvFuelController extends Controller
{
    public function index()
    {
        $carFuels = SystemItemB::select('segment1', 'description')
            ->whereHas('parameters', function($q) {
                $q->where('organization_code', 'A32');
            })
            ->where('attribute5', 'Y')
            ->orderBy('segment1')
            ->get();

        return response()->json($carFuels);
    }
}
