<?php

namespace App\Http\Controllers\PM;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\PM\WipRequestRepository;

class WipRequestController extends Controller
{
    public function index()
    {
        if (request()->ajax() || request()->test) {
            $data = $this->data(request());
            return response()->json(['data' => $data]);
        }
        $url = (new WipRequestRepository)->url(request());
        return view('pm.wip-requests.index', compact('url'));
    }

    private function data($request)
    {
        try {
            $wipRequestRepository = new WipRequestRepository;
            if($request->action == 'search_get_param') {
                $headers = $wipRequestRepository->searchGetParam($request);
                $data = [
                    'status' => 'S',
                    'data' => $headers
                ];
            } else if($request->action == 'search') {
                $headers = $wipRequestRepository->search($request);
                $data = [
                    'status' => 'S',
                    'data' => $headers
                ];
            } else {
                $info = $wipRequestRepository->info($request);
                $data = [
                    'status' => 'S',
                    'info' => $info
                ];
            }
        } catch (\Exception $e) {
            \Log::error($e);
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }

        return $data;
    }
}
