<?php

namespace App\Http\Controllers\PM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PMP0031Controller extends Controller
{
    public function index()
    {
        // dd(route('pm.ajax.pmp0031.process'));
        $userProfile = getDefaultData('/pm/pmp_0031');
        $url         = (object)[];
        $programCode = 'PMP0053';
        $url->getSaleForecast = route('pm.ajax.get-sale-forecasts');
        $url->getBiweeklies = route('pm.ajax.get-biweeklies');
        $url->process          = route('pm.ajax.pmp0031.process');
        $url->openJob      = route('pm.ajax.pmp0031.open-Job');

        return view('pm.pmp0031.index', [
            'userProfile'               => $userProfile,
            'url'                       => $url,
            'programCode'               => $programCode,
            ]);
    }
}
