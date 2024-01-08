<?php

namespace App\Http\Controllers\PD;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PD\Lld\PtpdLldTempV;
use App\Repositories\PD\LldRepository;

class LldController extends Controller
{
    public function index()
    {
        if (request()->ajax() || request()->test) {
            $data = $this->data(request());
            return response()->json(['data' => $data]);
        }

        $url = LldRepository::url;
        $menu = getMenu($url);
        $getProgramCode = getProgramCodeView($menu)->render();

        $url = (new LldRepository)->url(request());
        return view('pd.lld.index', compact('url', 'menu', 'getProgramCode'));
    }

    private function data($request)
    {
        try {
            $repo = new LldRepository;
            if(data_get($request, 'lld_year', false)) {
                $info = $repo->show($request);
                $data = [
                    'status' => 'S',
                    'info' => $info
                ];
            } else if($request->action == 'search' || $request->action == 'search-get-param') {
                $headers = $repo->search($request);
                if ($request->action == 'search') {
                    $data = [
                        'status' => 'S',
                        'data' => $headers
                    ];
                }
                if ($request->action == 'search-get-param') {
                    $data = $headers;
                    $data['status'] = 'S';
                }
            } else {
                $info = $repo->info($request);
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
