<?php

namespace App\Http\Controllers\INV\Ajax;

use App\Http\Controllers\Controller;
use App\Models\INV\PerPeopleF;
use App\Models\INV\WebFuelDist;
use Illuminate\Http\Request;

class PerPeopleFController extends Controller
{
    public function index()
    {
        $employees = PerPeopleF::query()
            ->select('person_id','effective_start_date','effective_end_date','person_type_id','title','first_name','last_name','employee_number')
            ->limit(10)
            ->get();

        return response()->json($employees);
    }
}
