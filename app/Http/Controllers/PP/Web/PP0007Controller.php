<?php

namespace App\Http\Controllers\PP\Web;


class PP0007Controller extends BaseController
{

    /** @noinspection DuplicatedCode */
    public function index()
    {
        $user = auth()->user();
        return $this->vue('pp-0007', [
        ]);
    }
}
