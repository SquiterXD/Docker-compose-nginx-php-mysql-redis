<?php

namespace App\Http\Controllers\INV\Ajax;

use App\Http\Controllers\Controller;
use App\Models\INV\PoHeadersAll;
use Illuminate\Http\Request;

class PoHeadersAllController extends Controller
{
    public function index()
    {
        $poHeadersAll = PoHeadersAll::get();

        return response()->json($poHeadersAll);
    }
}
