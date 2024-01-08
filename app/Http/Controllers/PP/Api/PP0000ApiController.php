<?php

namespace App\Http\Controllers\PP\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DbLookupController;
use App\Models\Mock;
use App\Models\PM\PtmesJobOptRelations;
use App\Models\PM\PtpmStampHeader;
use App\Helpers\Utils;
use App\Models\PM\PtpmSummaryBatchV;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isNull;

class PP0000ApiController extends Controller
{
    /**
     * @var DbLookupController
     */
    private $lookupController;

    /**
     * PM0036ApiController constructor.
     * @param DbLookupController $lookupController
     */
    public function __construct(DbLookupController $lookupController)
    {
        $this->lookupController = $lookupController;
    }

    public function index(Request $request): JsonResponse
    {
        return response()->json([
            '$request' => $request->all(),
        ]);
    }

}
