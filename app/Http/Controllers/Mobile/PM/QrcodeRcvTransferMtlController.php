<?php

namespace App\Http\Controllers\Mobile\PM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Http\JsonResponse;
use DB;


class QrcodeRcvTransferMtlController extends Controller
{
    public function index()
    {
        $data = (object)[];
        $url = (object)[];
        $url->ajax_detail = route('mobiles.pm.ajax.qrcode-rcv-transfer-mtls.detail');
        $profile = getDefaultData('/pm/qrcode-rcv-transfer-mtls');

        $prop = [
            "trans_btn" => trans('btn'),
            "trans_date" => trans('date'),
            "url" => $url,
            'profile' => $profile,
            "title" => getMenu('/pm/qrcode-rcv-transfer-mtls')->menu_title ?? 'ส่งวัตถุดิบหน้าจุดพัก'
        ];

        return view('mobile.pm.commons.qrcodes.index', [
            'vueComponent' => 'mb-qrcode-rcv-transfer-mtls-index',
        ] + $prop);
    }
}
