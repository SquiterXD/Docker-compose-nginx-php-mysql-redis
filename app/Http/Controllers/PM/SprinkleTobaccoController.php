<?php

namespace App\Http\Controllers\PM;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\PM\SprinkleTobaccoRepository;

class SprinkleTobaccoController extends Controller
{
    public function index()
    {
        if (request()->ajax() || request()->test) {
            $data = $this->data(request());
            return response()->json(['data' => $data]);
        }

        $url = (new SprinkleTobaccoRepository)->url(request());
        $profile = getDefaultData('/pm/sprinkle-tobaccos');
        $menu = getMenu('/pm/sprinkle-tobaccos');

        $prop = [
            "url" => $url,
            'profile' => $profile,
            "title" => "{$menu->program_code} {$menu->menu_title}"
        ];

        return view('pm.commons.qrcodes.index', [
            'vueComponent' => 'sprinkle-tobaccos-index',
        ] + $prop);
    }

    private function data($request)
    {
        try {
            $sprinkleTobaccoRepository = new SprinkleTobaccoRepository;
            if($request->action == 'search_get_param') {
                $headers = $sprinkleTobaccoRepository->searchGetParam($request);
                $data = [
                    'status' => 'S',
                    'data' => $headers
                ];
            } elseif($request->action == 'search') {
                $headers = $sprinkleTobaccoRepository->search($request);
                $data = [
                    'status' => 'S',
                    'data' => $headers
                ];
            } elseif($request->action == 'get-blend-detail') {
                $data = $sprinkleTobaccoRepository->getBlendDetail($request);
                $data = [
                    'status' => 'S',
                    'data' => $data
                ];
            } else {
                $info = $sprinkleTobaccoRepository->info($request);
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
