<?php

namespace App\Http\Controllers\PD;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\PD\AdjSalForecastRepository;

class AdjSalForecastController extends Controller
{
    public function index()
    {
        if (request()->ajax() || request()->test) {
            $data = $this->data(request());
            return response()->json(['data' => $data]);
        }
        // $lookupCode = request()->lookup_code;
        $url = "/pd/adj-sal-forecasts";
        // if ($lookupCode) {
        //     $url = "/pd/exp-formulas?lookup_code={$lookupCode}";
        // }
        $menu = getMenu($url);
        $getProgramCode = getProgramCodeView($menu)->render();
        $url = (new AdjSalForecastRepository)->url(request());
        return view('pd.adj-sal-forecasts.index', compact('url', 'menu', 'getProgramCode'));
    }

    private function data($request)
    {
        try {
            $repo = new AdjSalForecastRepository;
            if($request->action == 'search') {
                $headers = $repo->search($request);
                $data = [
                    'status' => 'S',
                    'data' => $headers
                ];
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
