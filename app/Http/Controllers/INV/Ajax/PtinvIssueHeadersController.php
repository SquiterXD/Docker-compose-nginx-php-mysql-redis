<?php

namespace App\Http\Controllers\INV\Ajax;

use App\Models\INV\IssueHeader;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PtinvIssueHeadersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $IssueHeader = IssueHeader::all();
        return response()->json($IssueHeader);
    }
}
