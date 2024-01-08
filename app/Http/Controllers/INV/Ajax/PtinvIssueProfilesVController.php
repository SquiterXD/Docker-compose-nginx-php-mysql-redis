<?php

namespace App\Http\Controllers\INV\Ajax;

use App\Http\Controllers\Controller;
use App\Models\INV\IssueProgramProfileV;
use Illuminate\Http\Request;

class PtinvIssueProfilesVController extends Controller
{
    public function index()
    {
        $issueProfilesV = IssueProgramProfileV::query()
            ->limit(20)
            ->get();
            
        return response()->json($issueProfilesV);
    }
}
