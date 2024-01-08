<?php

namespace App\Http\Controllers\CT\Ajax;

use App\Http\Controllers\Controller;
use App\Models\CT\StdMaterialCostHeader;
use App\Models\CT\StdMaterialCostLine;
use App\Models\CT\MtlSystemItemsB;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use PDO;

class PurchasePriceInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $version =  $request->input('version');
        $periodYear =  $request->input('period_year');
        $periodName =  $request->input('period_name');
        $organizationCode = strtoupper($request->input('organization_code'));

        $result = StdMaterialCostHeader::with('materialCostLines')
            ->where('period_name', $periodName)
            ->where('period_year', $periodYear)
            ->where('organization_code', $organizationCode)
            ->where('version', $version)
            ->first();

        return response()->json($result);
    }


    public static function store(Request $request)
    {
        $user = getDefaultData('/users');

        $periodYear =  $request->input('period_year');
        $periodName =  $request->input('period_name');
        $organizationCode = strtoupper($request->input('organization_code'));
        $createdById = $user->fnd_user_id;

        $result = [];

        $db     =   DB::getPdo();
        $sql    =   "
                        DECLARE
                            P_RETURN_STATUS         varchar2(1) := NULL;
                            P_RETURN_MESSAGE        varchar2(1000) := NULL;
                            v_debug                 NUMBER :=1;
                
                            v_param_rec        PTCT_ITEMCOST_PKG.WEB_PARAMETER_REC;
                                        
                        BEGIN
                            dbms_output.put_line('---------------------  S T A R T. -------------------');
                            
                            v_param_rec := NULL;
                            v_param_rec.PERIOD_YEAR         := '{$periodYear}';
                            v_param_rec.organization_code   := '{$organizationCode}';
                            v_param_rec.period_name         := '{$periodName}';
                            v_param_rec.created_by_id       := '{$createdById}';
                            
                            v_debug := 9;
                            PTCT_ITEMCOST_PKG.BUILD_COST( P_PARAM_REC      =>  v_param_rec          
                                                        , P_RETURN_STATUS       => :P_RETURN_STATUS  
                                                        , P_RETURN_MESSAGE      => :P_RETURN_MESSAGE ) ;
                            
                            dbms_output.put_line('OUTPUT : ' || :P_RETURN_STATUS);
                            dbms_output.put_line('MSG :' || :P_RETURN_MESSAGE);
                
                            dbms_output.put_line('---------------------  E N D. -------------------');
                        EXCEPTION WHEN others THEN 
                            dbms_output.put_line(:v_debug||'**call_error'||sqlerrm);                   
                        END ;
                    ";
        $sql = preg_replace("/[\r\n]*/","",$sql);

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':P_RETURN_STATUS', $result['status'], PDO::PARAM_STR, 1);
        $stmt->bindParam(':P_RETURN_MESSAGE', $result['data'], PDO::PARAM_STR, 1000);
        $stmt->bindParam(':v_debug', $result['v_debug'], PDO::PARAM_INT, 1);
        $stmt->execute();

        
        if ($result['status'] == 'C') 
        {
            $data_array = array('stdMaterialCostHeader', 'version');
            $data_query = null;
            foreach ($data_array as $key => $item) 
            {
                $data_query[$item] = StdMaterialCostHeader::query();
                $data_query[$item] = $data_query[$item]->where('period_name', $periodName)
                ->where('period_year', $periodYear)
                ->where('organization_code', $organizationCode)
                ->where('created_by_id', $createdById)
                ->orderByDesc('version');

                if ($item == 'stdMaterialCostHeader') 
                {
                    $data_query[$item] = $data_query[$item]->with('materialCostLines')->first();
                }
                elseif($item == 'version')
                {
                    $data_query[$item] = $data_query[$item]->select('version')->get();
                }
            }

            return response()->json([
                'packageRes' => $result,
                'data' => $data_query['stdMaterialCostHeader'],
                'version' => $data_query['version']
            ]);
        }

        return response()->json([
            'error' => "error",
            'packageRes' => $result,
        ]);
    }

    public function version(Request $request)
    {
        $user = getDefaultData('/users');

        $periodYear =  $request->input('period_year');
        $periodName =  $request->input('period_name');
        $organizationCode = strtoupper($request->input('organization_code'));
        $createdById = $user->fnd_user_id;
        
        $data_query['version'] = StdMaterialCostHeader::query();

        if ($periodName) {
          $data_query['version'] = $data_query['version']->where('period_name', $periodName);
        }else{
          $data_query['version'] = $data_query['version']->whereNull('period_name');
        }
          $data_query['version'] = $data_query['version']->where('period_year', $periodYear)
              ->where('organization_code', $organizationCode)
              ->orderByDesc('version')->select('version')->get();
                
        return response()->json([
            'message' => "success",
            'version' => $data_query['version']
        ]);
    }

    public static function updateLine($std_line_id, Request $request)
    {
        $stdMaterialCostLine = StdMaterialCostLine::find($std_line_id);

        if ($request->has('lot_number')) {
            $stdMaterialCostLine->lot_number = $request->input('lot_number');
        }

        if ($request->has('unit_cost')) {
            $stdMaterialCostLine->unit_cost = $request->input('unit_cost');

            if ($request->input('unit_cost') > 0) {
                $stdMaterialCostLine->error = null;
            }
        }

        if ($request->has('freight_cost')) {
            $stdMaterialCostLine->freight_cost = $request->input('freight_cost');
        }
        
        if ($request->has('dm_std_unitcost')) {
            $stdMaterialCostLine->dm_std_unitcost = $request->input('dm_std_unitcost');
        }
        
        if ($request->has('subtotal')) {
            $stdMaterialCostLine->subtotal = $request->input('subtotal');
        }

        if ($request->has('material_percent')) {
            $stdMaterialCostLine->material_percent = $request->input('material_percent');
        }

        if ($request->has('date_from')) {
            $stdMaterialCostLine->date_from = $request->input('date_from');
        }

        if ($request->has('date_to')) {
            $stdMaterialCostLine->date_to = $request->input('date_to');
        }

        DB::beginTransaction();
        try {
            $stdMaterialCostLine->save();

            DB::commit();

            return response()->json([
                'msg' => 'success',
                'data' => $stdMaterialCostLine
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'msg' => 'error',
                'error' => $e->getMessage()
            ], 403);
        }
    }

    public static function updateStatus($std_head_id)
    {
        $stdMaterialCostHeader = StdMaterialCostHeader::with('materialCostLines')->find($std_head_id);
        $chkErrorMaterialCostLine = $stdMaterialCostHeader->materialCostLines->filter(function ($value, $key) {
            return $value->error != null;
        })->count();

        if ($chkErrorMaterialCostLine > 0) {
            return response()->json([
                'msg' => 'error',
                'error' => 'Have Some Error In Error Field'
            ], 403);
        }

        DB::beginTransaction();
        try {
            $stdMaterialCostHeader->status = "Y";
            $stdMaterialCostHeader->save();

            StdMaterialCostLine::where('std_head_id', $std_head_id)->update(['status' => "Y"]);

            DB::commit();

            return response()->json([
                'msg' => 'success',
                'data' => $stdMaterialCostHeader
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'msg' => 'error',
                'error' => $e->getMessage()
            ], 403);
        }
    }

    public static function updateImport(Request $request)
    {
        $successResponse = [];
        $user = getDefaultData('/users');
        
        $validated = $request->validate([
            "lines"    => "required|array",
        ]);
        $std_head_id = $request->lines[0]['std_head_id'];
        $stdMaterialCostHead = StdMaterialCostHeader::find($std_head_id);
        DB::beginTransaction();

        foreach (array_chunk($validated['lines'], 100) as $key => $lines) {
            foreach ($lines as $key => $line) {
                unset($line['validate']);

                try {
                    if (isset($line['std_line_id'])) {
                        unset($line['item_number']);
                        StdMaterialCostLine::where('std_line_id', $line['std_line_id'])->update([
                            'lot_number' => isset($line['lot_number']) ? $line['lot_number'] : null,
                            'unit_cost' => isset($line['unit_cost']) ? $line['unit_cost'] : 0,
                            'freight_cost' => isset($line['freight_cost']) ? $line['freight_cost'] : 0,
                            'subtotal' => isset($line['subtotal']) ? $line['subtotal'] : 0,
                            'material_percent' => isset($line['material_percent']) ? $line['material_percent'] : 0,
                            'dm_std_unitcost' => isset($line['dm_std_unitcost']) ? $line['dm_std_unitcost'] : 0,
                            'item_descrtiption' => isset($line['item_descrtiption']) ? $line['item_descrtiption'] : '',
                            'date_from' => isset($line['date_from']) ? $line['date_from'] : null,
                            'date_to' => isset($line['date_to']) ? $line['date_to'] : null,
                            'status' => isset($stdMaterialCostHead) ? $stdMaterialCostHead->status : 'N'
                        ]);
                    } else {

                      unset($line['std_line_id']);
                      
                      $stdMaterialCostLine = StdMaterialCostLine::select('stg_no')
                        ->where('std_head_id', $line['std_head_id'])
                        ->orderBy('stg_no', 'desc')
                        ->first();
                        
                        $stgNo = 1;
                        if ($stdMaterialCostLine != null) {
                          $stgNo = $stdMaterialCostLine->stg_no + 1;
                        }

                        StdMaterialCostLine::create([
                          'lot_number' => isset($line['lot_number']) ? $line['lot_number'] : null,
                          'item_number' => isset($line['item_number'])? $line['item_number'] : 0,
                          'unit_cost' => isset($line['unit_cost']) ? $line['unit_cost'] : 0,
                          'item_descrtiption' => isset($line['item_descrtiption']) ? $line['item_descrtiption'] : '',
                          'freight_cost' => isset($line['freight_cost']) ? $line['freight_cost'] : 0,
                          'subtotal' => isset($line['subtotal']) ? $line['subtotal'] : 0,
                          'material_percent' => isset($line['material_percent']) ? $line['material_percent'] : 0,
                          'dm_std_unitcost' => isset($line['dm_std_unitcost']) ? $line['dm_std_unitcost'] : 0,
                          'created_by_id' => $user->fnd_user_id,
                          'updated_by_id' => $user->fnd_user_id,
                          'created_by' => $user->fnd_user_id,
                          'last_updated_by' => $user->fnd_user_id,
                          'std_head_id' => isset($line['std_head_id']) ? $line['std_head_id'] : null,
                          'stg_no' => $stgNo,
                          'interface_name' => 'CTM0012',
                          'record_status' => 'N',
                          'date_from' => isset($line['date_from']) ? $line['date_from'] : null,
                          'date_to' => isset($line['date_to']) ? $line['date_to'] : null,
                          'status' => isset($stdMaterialCostHead) ? $stdMaterialCostHead->status : 'N'
                        ]);
                    }
                    DB::commit();

                    $successResponse = [
                        'msg' => 'success',
                    ];
                } catch (\Exception $e) {
                    DB::rollBack();

                    return response()->json([
                        'msg' => 'error',
                        'error' => $e->getMessage(),
                        'line' => $line,
                    ], 403);
                }
            }
        }

        return response()->json($successResponse, 200);
    }

    public static function checkItemNumber(Request $request)
    {
        $user = getDefaultData('/users');
        $result = MtlSystemItemsB::select('inventory_item_id', 'segment1 AS item_number', 'description')
                      ->where('segment1', $request['itemNumber'])
                      ->first();
            
        if ($result === null) {
            return response()->json([
                'msg' => 'Data not found',
                'data' => []
            ], 404);
        } else {
            return response()->json([
                'data' => $result
            ]);
        }
    }

    public function deleteLine($std_line_id) 
    {
      $stdMaterialCostLine = StdMaterialCostLine::find($std_line_id);
        DB::beginTransaction();
        try {
            $stdMaterialCostLine->delete();

            DB::commit();

            return response()->json([
                'msg' => 'success',
                'data' => $stdMaterialCostLine
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'msg' => 'error',
                'error' => $e->getMessage()
            ], 403);
        }
    }

    public function deleteAll($std_head_id)
    {
      $stdMaterialCostLine = StdMaterialCostLine::where('std_head_id', $std_head_id)->get();
      DB::beginTransaction();
      try {
          $stdMaterialCostLine->each->delete();

          DB::commit();

          return response()->json([
              'msg' => 'success'
          ], 200);
      } catch (\Exception $e) {
          DB::rollBack();

          return response()->json([
              'msg' => 'error',
              'error' => $e->getMessage()
          ], 403);
      }
    }
}
