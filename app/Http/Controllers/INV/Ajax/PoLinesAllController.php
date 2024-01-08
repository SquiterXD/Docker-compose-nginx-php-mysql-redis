<?php

namespace App\Http\Controllers\INV\Ajax;

use App\Http\Controllers\Controller;
use App\Models\INV\PoLinesAll;
use Illuminate\Http\Request;

class PoLinesAllController extends Controller
{
    public function index()
    {
        $poLinesAll = PoLinesAll::get();

        return response()->json($poLinesAll);
    }
}
