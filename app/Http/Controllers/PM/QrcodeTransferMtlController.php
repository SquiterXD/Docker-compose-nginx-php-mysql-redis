<?php

namespace App\Http\Controllers\PM;

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
        $url->ajax_detail = route('pm.ajax.qrcode-transfer-mtls.detail');
        $profile = getDefaultData('/pm/qrcode-transfer-mtls');

        $prop = [
            "trans_btn" => trans('btn'),
            "trans_date" => trans('date'),
            "url" => $url,
            'profile' => $profile,
            "title" => 'รับโอนวัตถุดิบ'
        ];

        return view('pm.commons.qrcodes.index', [
            'vueComponent' => 'qrcode-transfer-mtls-index',
        ] + $prop);
    }
}
