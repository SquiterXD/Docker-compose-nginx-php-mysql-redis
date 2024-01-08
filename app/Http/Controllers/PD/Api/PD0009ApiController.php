<?php

namespace App\Http\Controllers\PD\Api;

use App\Models\PD\PtpdExpandedTobaccoH;
use App\Models\PD\PtpdExpandedTobaccoL;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDO;

class PD0009ApiController extends Controller
{
    const URL_PATH = '/pd/expanded-tobacco';
    const MOCK_PROGRAM_CODE = 'PDP009';

    public function index(Request $request)
    {
        //
    }

    public function store(Request $request)
    {
        $defaultData = (array)getDefaultData($this::URL_PATH);
        DB::beginTransaction();
        try {
            $header = PtpdExpandedTobaccoH::create([
                'expanded_tobacco' => $request->input('expandedTobacco'),
                'description' => $request->input('description'),
                'inventory_item_code' => $request->input('inventoryItemCode'),
                'inventory_item_id' => $request->input('inventoryItemId'),
                'folmula_type' => $request->input('formulaType'),
                'quantity' => $request->input('quantity'),
                'uom' => $request->input('uom'),
                'formula_status' => $request->input('formulaStatus'),
                'remark' => $request->input('remark'),
                'formula_start_date' => $request->input('formulaStartDate'),
                'formula_approval_date' => $request->input('formulaApprovalDate'),
                'user_name' => $defaultData['user_name'],
                'formula_creation_date' => Carbon::now(),
                'formula_last_update_date' => Carbon::now(),
                'program_code' => $defaultData['program_code'] ? : $this::MOCK_PROGRAM_CODE
            ]);

            foreach ($request->input('lines') as $line) {
                $lines[] = $header->lines()->create([
                    'inventory_item_code' => $line['inventory_item_code'],
                    'inventory_item_id' => $line['inventory_item_id'],
                    'item_ratio' => $line['item_ratio'],
                    //'lot_number' => $line['lot_number'],
                ]);
            }

            DB::commit();

            $headers = PtpdExpandedTobaccoH::get();

            $expTobaccoId = $header->exp_tobacco_id;

            $packageResponse = $this->callPackage($expTobaccoId);

            return response()->json([
                'header' => $header,
                'headers' => $headers,
                'lines' => $lines,
                'histories' => [],
                'packageResponse' => $packageResponse,
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    private function callPackage($expTobaccoId): array
    {
        $sql = "
            DECLARE

                V_STATUS VARCHAR2(10);
                V_MSG VARCHAR2(4000);

            BEGIN
                        APPS.PTPD_EXP_FORMULA_PKG.MAIN_IMORT(P_EXP_TOBACCO_ID =>'$expTobaccoId'
                                                       , P_INTERFACE_STATUS => :V_STATUS
                                                       , P_INTERFACE_MSG    => :V_MSG);

            END ;
        ";

        $response = [];

        $stmt = DB::connection('oracle')->getPdo()->prepare($sql);
        $stmt->bindParam(":V_STATUS", $response['V_STATUS'], PDO::PARAM_STR, 10);
        $stmt->bindParam(":V_MSG", $response['V_MSG'], PDO::PARAM_STR, 4000);
        $stmt->execute();

        return $response;
    }

    public function show($id)
    {
        $header = PtpdExpandedTobaccoH::find($id);
        $lines = $header->lines()->get();
        $histories = $header->history()->orderBy('edit_no', 'DESC')->get();

        return response()->json([
            'header' => $header,
            'lines' => $lines,
            'histories' => $histories,
        ]);
    }

    public function search(Request $request)
    {
        $headerBuilder = PtpdExpandedTobaccoH::query();
        if ($inventory_item_code = $request->get('inventory_item_code', null)) {
            $headerBuilder->where('inventory_item_code', 'like', "%$inventory_item_code%");
        }
        if ($description = $request->get('description', null)) {
            $headerBuilder->where('description', 'like', "%$description%");
        }
        $headers = $headerBuilder->get();

        return response()->json([
            'headers' => $headers,
        ]);
    }

    public function update(Request $request, $id)
    {
        $defaultData = (array)getDefaultData($this::URL_PATH);
        $expTobaccoId = $id;

        DB::beginTransaction();
        try {
            $header = PtpdExpandedTobaccoH::find($id);
            $header->inventory_item_code = $request->input('inventoryItemCode');
            $header->inventory_item_id = $request->input('inventoryItemId');
            $header->remark = $request->input('remark');
            $header->description = $request->input('description');
            $header->folmula_type = $request->input('formulaType');
            $header->formula_status = $request->input('formulaStatus');
            $header->quantity = $request->input('quantity');
            $header->formula_start_date = $request->input('formulaStartDate');
            $header->formula_approval_date = $request->input('formulaApprovalDate');
            $header->user_name = $defaultData['user_name'];
            $header->last_updated_by = $defaultData['user_id'];
            $header->formula_last_update_date = Carbon::now();

            $header->save();

            $lines = [];

            foreach ($request->input('lines') as $line) {
                $lines[] = $header->lines()->updateOrCreate([
                    'exp_tobacco_line_id' => isset($line['exp_tobacco_line_id']) ? $line['exp_tobacco_line_id'] : '',
                ], [
                    'inventory_item_code' => $line['inventory_item_code'],
                    'inventory_item_id' => $line['inventory_item_id'],
                    'item_ratio' => $line['item_ratio'],
                    //'lot_number' => $line['lot_number'],
                ]);

            }
            DB::commit();

            DB::beginTransaction();
            $ids = collect($lines)->map(function ($line) {
                return isset($line->exp_tobacco_line_id) ? $line->exp_tobacco_line_id : null;
            })->filter()->join(',');

            if ($ids) {
                DB::delete("
                    DELETE FROM ptpd_expanded_tobacco_l
                    WHERE exp_tobacco_id = '{$id}' AND exp_tobacco_line_id not in ({$ids})
                ");
            }
            DB::commit();

            $histories = $header->history()->orderBy('edit_no', 'DESC')->get();
            $headers = PtpdExpandedTobaccoH::get();


            $packageResponse = $this->callPackage($expTobaccoId);

            return response()->json([
                'header' => $header,
                'headers' => $headers,
                'lines' => $lines,
                'histories' => $histories,
                '$ids' => $ids,
                'packageResponse' => $packageResponse,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    public function destroy(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $header = PtpdExpandedTobaccoH::find($id);

            foreach ($request->input('lines') as $line) {
                $header->lines()->find($line)->delete();
            }

            $lines = $header->lines()->get();

            $histories = $header->history()->orderBy('edit_no', 'DESC')->get();

            DB::commit();

            return response()->json([
                'header' => $header,
                'lines' => $lines,
                'histories' => $histories,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
        }
    }
}
