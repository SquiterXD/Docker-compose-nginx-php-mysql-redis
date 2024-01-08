<?php

namespace App\Http\Controllers\PD;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\PD\SmlCostFmlRepository;

class SmlCostFmlController extends Controller
{
    public function index()
    {
        if (request()->ajax() || request()->test) {
            $data = $this->data(request());
            return response()->json(['data' => $data]);
        }

        $url = SmlCostFmlRepository::url;
        $menu = getMenu($url);
        $getProgramCode = getProgramCodeView($menu)->render();

        $url = (new SmlCostFmlRepository)->url(request());
        return view('pd.sml-cost-fmls.index', compact('url', 'menu', 'getProgramCode'));
    }

    private function data($request)
    {
        try {
            $repo = new SmlCostFmlRepository;
            if($request->action == 'search' || $request->action == 'search-get-param') {
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
            } else if($request->action == 'searchPd08') {
                $headers = $repo->searchPd08($request);
                $data = [
                    'status' => 'S',
                    'data' => $headers
                ];
            } else if($request->action == 'get-blend-no') {
                $itemList = $repo->getHeaderProductItem($request);
                $data = [
                    'status' => 'S',
                    // 'blend_no' => $blendNoList,
                    'product_item_id_list' => $itemList
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
