<?php

namespace App\Http\Controllers\PD;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\PD\SubstituteTobaccoRepository;

class SubstituteTobaccoController extends Controller
{
    public function index()
    {
        if (request()->ajax() || request()->test) {
            $data = $this->data(request());
            return response()->json(['data' => $data]);
        }
        $url = "/pd/substitute-tobaccos";
        $menu = getMenu($url);
        $getProgramCode = getProgramCodeView($menu)->render();
        $url = (new SubstituteTobaccoRepository)->url(request());
        return view('pd.substitute-tobaccos.index', compact('url', 'menu', 'getProgramCode'));
    }

    private function data($request)
    {
        try {
            $repo = new SubstituteTobaccoRepository;
            if($request->action == 'search') {
                $headers = $repo->search($request);
                $data = [
                    'status' => 'S',
                    'data' => $headers
                ];
            } elseif($request->action == 'search_get_param') {
                $data = [
                    'status' => 'S',
                    'data' => $repo->getParam($request)
                ];

            } elseif($request->action == 'search_instead_item') {
                $data = [
                    'status' => 'S',
                    'data' => $repo->searchInsteadItem($request)
                ];

            } elseif($request->action == 'search_blend') {
                $data = [
                    'status' => 'S',
                    'data' => $repo->searchBlend($request)
                ];

            } elseif($request->action == 'search_blend_get_param') {
                $data = [
                    'status' => 'S',
                    'data' => $repo->searchBlendGetParam($request)
                ];
            } elseif($request->action == 'search_brand') {
                $data = [
                    'status' => 'S',
                    'data' => $repo->searchBrand($request)
                ];

            } elseif($request->action == 'search_brand_get_param') {
                $data = [
                    'status' => 'S',
                    'data' => $repo->searchBrandGetParam($request)
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
