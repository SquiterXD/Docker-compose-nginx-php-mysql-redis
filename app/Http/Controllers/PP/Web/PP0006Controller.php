<?php

namespace App\Http\Controllers\PP\Web;

class PP0006Controller extends BaseController
{
    /** @noinspection DuplicatedCode */
    public function index()
    {
        $user = auth()->user();
        return $this->vue('pp-0006', [
        ]);
    }
}
