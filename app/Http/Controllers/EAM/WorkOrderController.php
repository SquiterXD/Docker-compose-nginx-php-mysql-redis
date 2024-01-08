<?php

namespace App\Http\Controllers\EAM;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkOrderController extends Controller
{
    public function create(Request $request)
    {
        $user = Auth::user();
        return view('eam.work-orders.create', ['workOrderId' => $request->workOrderId,'user'=>$user,'fn'=>$request->fn,'default'=>$request->default]);
    }

    public function waitingOpenWork()
    {
        $user = Auth::user();
        return view('eam.work-orders.waiting-open-work', ['user'=>$user]);
    }

    public function listAllRepairJobs()
    {
        $user = Auth::user();
        return view('eam.work-orders.list-all-repair-jobs', ['user'=>$user]);
    }

    public function listRepairJobsWaitingClose(Request $request)
    {
        $wipEntityName = $request['wip_entity_name'] ?? '';
        $wipEntityId = $request['wip_entity_id'] ?? '';
        $user = Auth::user();
        return view('eam.work-orders.list-repair-jobs-waiting-close', [ 'user'=>$user,
                                                                        'wipEntityName'=>$wipEntityName,
                                                                        'wipEntityId'=>$wipEntityId ]);
    }

    public function confirmedListRepairWork()
    {
        return view('eam.work-orders.confirmed-list-repair-work');
    }
}
