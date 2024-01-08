<?php

namespace App\Http\Controllers\PM\Api;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\PM\ConversTransactionRepository;

class ConversTransactionController extends Controller
{
    public function store(Request $request)
    {
        try {
            $header = (new ConversTransactionRepository)->store($request);
             $data = [
                'status' => 'S',
                // 'header' => $resHeader
                'header' => $header
            ];

        } catch (\Exception $e) {
            \Log::error($e);
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }

        return response()->json(['data' => $data]);
    }
}
