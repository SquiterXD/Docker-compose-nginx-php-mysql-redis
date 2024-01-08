<?php

namespace App\Http\Controllers\PD;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\PD\ExpFmlRepository;

class ExpFmlController extends Controller
{
    public function index()
    {

        if (request()->ajax() || request()->test) {
            $data = $this->data(request());
            return response()->json(['data' => $data]);
        }
        // $lookupCode = request()->lookup_code;
        $url = "/pd/exp-fmls";
        // if ($lookupCode) {
        //     $url = "/pd/exp-formulas?lookup_code={$lookupCode}";
        // }
        $menu = getMenu($url);
        $getProgramCode = getProgramCodeView($menu)->render();
        $url = (new ExpFmlRepository)->url(request());
        return view('pd.exp-fmls.index', compact('url', 'menu', 'getProgramCode'));
    }

    private function data($request)
    {
        try {
            $repo = new ExpFmlRepository;
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
            } else if($request->action == 'get-blend-no') {
                $itemList = $repo->getHeaderProductItem($request);
                $data = [
                    'status' => 'S',
                    // 'blend_no' => $blendNoList,
                    'product_item_id_list' => $itemList
                ];
            } else if($request->action == 'validate-blend-no') {
                $result = $repo->validateBlendNo($request);
                $data = [
                    'status' => 'S',
                    'result' => $result
                ];
            } else if($request->action == 'get-history') {
                $itemList = $repo->getHistory($request);
                $data = [
                    'status' => 'S',
                    'data' => $itemList
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
