<?php

namespace App\Http\Controllers\PM\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DbLookupController;
use App\Models\Lookup\PtBiweeklyLookup;
use App\Models\Mock;
use App\Models\PM\PtmesJobOptRelations;
use App\Models\PM\PtpmStampHeader;
use App\Helpers\Utils;
use App\Models\PM\PtpmSummaryBatchV;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;
use function PHPUnit\Framework\isNull;

class PM0036ApiController extends Controller
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
        $startDate = $request->get('startDate');
        $endDate = $request->get('endDate');

        if ($startDate && $endDate) {
            $summaryBatches = PtpmSummaryBatchV::query()
                ->whereDate('actual_start_date', '>=', $startDate)
                ->whereDate('actual_start_date', '<=', $endDate)
                ->where('organization_code', '=', 'M02')
                ->get();
        } else {
            $summaryBatches = [];
        }

        return response()->json([
            'summaryBatches' => $summaryBatches,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }

    public function getJobOptRelations(Request $request)
    {
        $batchId = $request->get('batchId');
        $organizationId = $request->get('organizationId');

        if (!$batchId || !$organizationId) return response()->json([
            'message' => 'params batchId or organizationId not found'
        ], 400);

        $jobOptRelations = PtmesJobOptRelations::query()
            ->where('batch_id', $batchId)
            ->where('organization_id', $organizationId)
            ->get();

        return response()->json([
            'jobOptRelations' => $jobOptRelations,
        ]);
    }

    public function execCloseBatch(Request $request)
    {
        $user = Mock::getMockUser();

        $summaryBatches = $request->input('summaryBatches');
        $userName = $user->username;

        $data = getDefaultData('/users');
        // TODO: $fndUserName = $data->fnd_user_name;
        $fndUserName = 'MERCURY';

        $res = [];

        DB::beginTransaction();
        try {
            foreach ($summaryBatches as $summaryBatch) {
                $date = date('Y-m-d');

                $sql = "
                    declare
                        v_status varchar2(20);
                        v_err_msg varchar2(2000);
                    begin
                        ptpm_main.close_job(
                            p_organization_id => {$summaryBatch['organization_id']},
                            p_batch_id => '{$summaryBatch['batch_id']}',
                            p_close_date => to_date('{$date}', 'yyyy-mm-dd'),
                            p_user_name => '{$fndUserName}',
                            p_program_code => 'PMP0017',
                            p_status =>  :v_status,
                            p_err_msg => :v_err_msg
                        );
                        dbms_output.put_line(:v_status);
                        dbms_output.put_line(:v_err_msg);
                    end;
                ";

                //echo $sql;

                $response = [];

                $stmt = DB::connection('oracle')->getPdo()->prepare($sql);

                $stmt->bindParam(":v_status", $response['v_status'], PDO::PARAM_STR, 20);
                $stmt->bindParam(":v_err_msg", $response['v_err_msg'], PDO::PARAM_STR, 2000);
                $stmt->execute();

                $res[] = $response;
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            //throw $e;
            return response()->json([
                'err' => $e,
            ], 500);
        }

        return response()->json([
            'res' => $res,
        ]);
    }
}
