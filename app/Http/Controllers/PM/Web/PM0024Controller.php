<?php

namespace App\Http\Controllers\PM\Web;


class PM0024Controller extends BaseController
{
    public function index()
    {
        $user = auth()->user();
        return $this->vue('pm0024', [
            'user' => $user,
        ]);
    }
}
