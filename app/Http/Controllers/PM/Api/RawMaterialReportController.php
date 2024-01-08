<?php

namespace App\Http\Controllers\PM\Api;

use App\Http\Controllers\Controller;
use App\Repositories\PM\PtpmRawMtlRrNRepository;
use Illuminate\Http\Request;

class RawMaterialReportController extends Controller
{
    protected $repo;
    public function __construct(PtpmRawMtlRrNRepository $repo)
    {
        $this->repo = $repo;
    }
    public function setJson($data, $statusCode = 200, $msg = 'Success')
    {
        return ['status_code' => $statusCode, 'data' => collect($data), 'message' => $msg];
    }
    public function index(Request $request) {
        $data = $this->repo->getAll($request);

        return response()->json($this->setJson($data));
    }

    public function updateFlag(Request $request){
        $data = $this->repo->confirmOrder($request);
        return response()->json($this->setJson($data));
    }
}
