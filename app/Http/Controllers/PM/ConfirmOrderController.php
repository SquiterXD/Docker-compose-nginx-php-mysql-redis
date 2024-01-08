<?php

namespace App\Http\Controllers\PM;

use App\Models\Example\User;
use App\Http\Requests\Example\StoreUserRequest;
use App\Exports\Example\UsersExport;
use App\Models\Example\UserInterface;

use App\Http\Controllers\Controller;
use App\Models\PM\PtmesProductHeader;
use App\Models\PM\PtmesProductLine;
use Illuminate\Http\Request;
use PDF;

class ConfirmOrderController extends Controller
{

    public function index()
    {
        $users = \App\Models\User::limit(5)->get();

        $url = (object)[];
        $url->ajax_confrim_order_store = route('pm.ajax.confirm-order.store-n');

        return view('pm.confirm-order.index1', compact('users', 'url'));
    }
}
