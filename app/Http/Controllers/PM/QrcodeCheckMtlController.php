<?php

namespace App\Http\Controllers\PM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PM\PtpmRequestHeader;
use App\Models\PM\PtpmRequestLine;

use Illuminate\Http\JsonResponse;
use DB;

use App\Repositories\PM\MaterialRequestRepository;

class QrcodeCheckMtlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = (object)[];
        $header = (object)[];
        $url = (object)[];
        $url->ajax_qrcode_check_materials_detail = route('pm.ajax.qrcode-check-mtls.detail');
        $profile = getDefaultData('test');

        $qrcode = [];
        $qrcode['item_id'] = 10937;
        $qrcode['org_id'] = 171;
        $qrcode['ref_line_id'] = 0;
        // dd(json_encode($qrcode));

        return view('pm.qrcode-check-mtls.index', compact(
            "header", "data",
            'url', 'profile'
        ));
    }
}
