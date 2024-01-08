<?php

namespace App\Http\Controllers\INV\Ajax;

use App\Http\Controllers\Controller;
use App\Models\INV\PoDistributionsAll;
use Illuminate\Http\Request;

class PoDistributionsAllController extends Controller
{
    public function index()
    {
        $poDistributionsAll = PoDistributionsAll::query()
            ->with(['poHeadersAll', 'poLinesAll'])
            ->get();

        return response()->json($poDistributionsAll);
    }
}
