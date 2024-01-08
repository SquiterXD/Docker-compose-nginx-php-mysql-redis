<?php

namespace App\Http\Controllers\PM\Api;

use App\Http\Controllers\Controller;
use App\Models\Lookup\PtpmItemNumberVLookup;
use App\Models\PM\PtpmPlanningJobDists;
use App\Models\PM\PtpmPlanningJobHeaders;
use App\Models\PM\PtpmPlanningJobLines;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PM0011ApiController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([

        ]);
    }

    public function getLines(Request $request)
    {
        $periodName = $request->get('periodName');
        $periodYear = $request->get('periodYear');
        $biweekly = $request->get('biweekly');

        $header = PtpmPlanningJobHeaders::query()
            //TODO remove comment condition
            ->where('period_name', $periodName)
            ->where('period_year', $periodYear)
            ->where('biweekly', $biweekly)
            ->first();

        if ($header) {
            $lines = PtpmPlanningJobLines::with(['dists', 'machineGroups', 'feeder'])
                ->where('plan_header_id', $header->plan_header_id)
                ->get();
        } else {
            $lines = [];
        }

        return response()->json([
            'header' => $header,
            'lines' => $lines,
        ]);
    }

    public function updateLines(Request $request)
    {
        $headerId = $request->input('headerId');
        $lines = $request->input('lines');

        try {
            DB::beginTransaction();

            foreach ($lines as $line) {
                PtpmPlanningJobLines::query()
                    ->find($line['plan_line_id'])
                    ->update([
                        'feeder_code' => $line['feeder_code'],
                    ]);

                foreach ($line['dists'] as $dist) {
                    PtpmPlanningJobDists::query()
                        ->find($dist['plan_distribution_id'])
                        ->update([
                            'inventory_item_id' => $dist['inventory_item_id'],
                            'plan_quantity' => $dist['plan_quantity'],
                        ]);
                }
            }

            $lines = PtpmPlanningJobLines::with(['dists', 'machineGroups', 'feeder'])
                ->where('plan_header_id', $headerId)
                ->get();

            DB::commit();
            return response()->json([
                'lines' => $lines,
            ]);
        } catch (Exception $e) {
            DB::rollback();
            //throw $e;
            return response()->json([
                'message' => $e
            ], 500);
        }
    }

    public function lookupBlendNo(Request $request)
    {
        $query = $request->get('query', '');
        $maxResults = $request->get('maxResults', 50);

        if (stripos($query, '%') === false) $query = "%$query%";
        $rows = PtpmItemNumberVLookup::query()
            ->whereNotNull('blend_no')
            ->orWhereRaw("LOWER(blend_no) like ?", [strtolower("%$query%")])
            ->take($maxResults)
            ->get();

        //remove row number (rn) which polluted our data object
        //the (rn) will be add to objects if take() is invoked
        foreach ($rows as $row) {
            unset($row['rn']);
        }

        return response()->json($rows);
    }
}
