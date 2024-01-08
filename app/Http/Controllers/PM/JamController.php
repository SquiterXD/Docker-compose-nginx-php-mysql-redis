<?php

namespace App\Http\Controllers\PM;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\PM\JamRepository;

class JamController extends Controller
{
    public function index()
    {
        if (request()->ajax() || request()->test) {
            $data = $this->data(request());
            return response()->json(['data' => $data]);
        }
        $url = (new JamRepository)->url(request());
        return view('pm.jams.index', compact('url'));
    }

    private function data($request)
    {
        try {
            $sendCigaretteRepo = new JamRepository;
            if($request->action == 'search') {
                $headers = $sendCigaretteRepo->search($request);
                $data = [
                    'status' => 'S',
                    'data' => $headers
                ];
            } else {
                $info = $sendCigaretteRepo->info($request);
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
