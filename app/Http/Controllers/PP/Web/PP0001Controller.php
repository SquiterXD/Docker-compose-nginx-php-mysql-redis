<?php

namespace App\Http\Controllers\PP\Web;

 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PP0001Controller extends BaseController
{
 
    /** @noinspection DuplicatedCode */
    public function index()
    {
        $user = auth()->user();
        return $this->vue('pp-0001', [
            

        ]);
    }
}