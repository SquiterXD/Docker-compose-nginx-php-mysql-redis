<?php

namespace App\Http\Controllers\PP\Web;

use App\Http\Controllers\Controller;
use App\Models\PM\PtglCoaDeptCodeV;

class BaseController extends Controller
{

    protected function getOrganization($user)
    {
        if (!$user) return null;
        return PtglCoaDeptCodeV::query()
            ->where('department_code', $user->department_code)
            ->first();
    }

    public function vue($vueComponent, $params = [])
    {
        return view('pp.Vue', ['vueComponent' => $vueComponent] + $params);
    }
}
