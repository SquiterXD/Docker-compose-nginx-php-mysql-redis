<?php

namespace App\Http\Controllers\INV\Ajax;

use Illuminate\Http\Request;

use App\Models\INV\ItemLocation;
use App\Http\Controllers\Controller;
use App\Models\INV\SecondaryInventory;
use App\Models\INV\SubinventortV;

class PtirSubinventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = getDefaultData('/users');
        $subinventories = SubinventortV::get();

        return response()->json($subinventories);
    }
}
