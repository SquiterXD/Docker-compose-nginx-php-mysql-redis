<?php

namespace App\Http\Controllers\EAM;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SetupController extends Controller
{
    public function machine()
    {
        $user = getDefaultData('/eam/setup/machine');
        return view('eam.setup.machine', ['user'=>$user]);
    }
}
