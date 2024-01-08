<?php

namespace App\Http\Controllers\EAM;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkRequestController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('eam.work-requests.index', ['user'=>$user]);
    }
    public function create(Request $request)
    {
        $user = Auth::user();
        return view('eam.work-requests.create', ['workRequestNumber' => $request->id,'user'=>$user]);
    }

    public function waitingApprove()
    {
        $user = Auth::user();
        return view('eam.work-requests.waiting-approves', ['user'=>$user]);
    }
}
