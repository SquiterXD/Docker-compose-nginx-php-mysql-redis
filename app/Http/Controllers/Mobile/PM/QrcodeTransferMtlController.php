<?php

namespace App\Http\Controllers\Mobile\PM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Http\JsonResponse;
use DB;

class QrcodeTransferMtlController extends Controller
{
    public function index()
    {
        $data = (object)[];
        $url = (object)[];
        $url->ajax_detail = route('mobiles.pm.ajax.qrcode-transfer-mtls.detail');
        $profile = getDefaultData('/pm/qrcode-transfer-mtls');

        $prop = [
            "trans_btn" => trans('btn'),
            "trans_date" => trans('date'),
            "url" => $url,
            'profile' => $profile,
            "title" => 'ส่งวัตถุดิบ'
        ];

        return view('mobile.pm.commons.qrcodes.index', [
            'vueComponent' => 'mb-qrcode-transfer-mtls-index',
        ] + $prop);
    }
}
