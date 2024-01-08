<?php

namespace App\Http\Controllers\PM\Ajax;

use App\Models\Example\User;
use App\Http\Requests\Example\StoreUserRequest;
use App\Exports\Example\UsersExport;
use App\Models\Example\UserInterface;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConfirmOrderController extends Controller
{

    public function store()
    {
        try {
            $data = [
                'status' => 'S',
                'msg' => ''
            ];

        } catch (\Exception $e) {
            \Log::error($e);
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }

        return response()->json(['data' => $data]);
        dd('store', request()->all());
    }

}
