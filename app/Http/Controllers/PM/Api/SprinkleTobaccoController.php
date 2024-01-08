<?php
namespace App\Http\Controllers\PM\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Arr;
use App\Models\PM\PtpmWipRequestHeader;
use App\Repositories\PM\SprinkleTobaccoRepository;

class SprinkleTobaccoController extends Controller
{

    public function getLines(Request $request)
    {
        $data = (new SprinkleTobaccoRepository)->getLines($request);
        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        try {
            $header = (new SprinkleTobaccoRepository)->store($request);

            $header->refresh();
            $resHeader = $header;
             $data = [
                'status' => 'S',
                'header' => $resHeader
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

    public function setStatus(Request $request)
    {
        try {
            $header = (new SprinkleTobaccoRepository)->confirm($request);
            $header->refresh();
            $resHeader = $header;
             $data = [
                'status' => 'S',
                'header' => $resHeader
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

    public function cancel(Request $request)
    {
        try {
            $header = (new SprinkleTobaccoRepository)->cancel($request);
            $header->refresh();
            $resHeader = $header;
             $data = [
                'status' => 'S',
                'header' => $resHeader
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
