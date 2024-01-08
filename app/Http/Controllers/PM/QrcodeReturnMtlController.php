<?php

namespace App\Http\Controllers\PM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Http\JsonResponse;
use DB;

use App\Repositories\PM\MaterialRequestRepository;

class QrcodeReturnMtlController extends Controller
{
    public function index()
    {
        $data = (object)[];
        $url = (object)[];
        $url->ajax_detail = route('pm.ajax.qrcode-return-mtls.detail');
        $profile = getDefaultData('test');

        $prop = [
            "trans_btn" => trans('btn'),
            "trans_date" => trans('date'),
            "url" => $url,
            'profile' => $profile,
            "title" => 'คืนวัตถุดิบ'
        ];

        return view('pm.commons.qrcodes.index', [
            'vueComponent' => 'qrcode-return-mtls-index',
        ] + $prop);
    }
}
