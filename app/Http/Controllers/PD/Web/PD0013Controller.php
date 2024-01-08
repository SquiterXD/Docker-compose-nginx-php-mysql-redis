<?php

namespace App\Http\Controllers\PD\Web;

class PD0013Controller extends BaseController
{
    public function index()
    {
        $user = auth()->user();

        return $this->vue('pd-0013', [
            'user' => $user,
        ]);
    }
}
