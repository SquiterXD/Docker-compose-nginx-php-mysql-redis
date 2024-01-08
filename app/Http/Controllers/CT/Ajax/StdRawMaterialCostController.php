<?php

namespace App\Http\Controllers\CT\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CT\CostCenter;
use App\Models\CT\StdCostHead;
use App\Models\CT\StdCostHeadV;
use App\Models\CT\StdCostItem;
use App\Models\CT\StdMaterialCostHeader;
use App\Models\CT\StdMaterialCostLine;
use App\Models\CT\StdRawMeterialCostHead;
use App\Models\CT\StdRawMeterialCostLine;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDO;

use App\Models\CT\ProductGroupPlan;
use App\Models\CT\StdCostPrdsV;
use App\Models\CT\StdCostProd;

class StdRawMaterialCostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $planVersion = ProductGroupPlan::selectRaw("prdgrp_year_id, plan_version_no")
          ->where('period_year', $request->input('period_year'))
          ->where('plan_version_no', $request->input('plan_version_no'))
          ->orderBy('period_year', 'desc')
          ->orderBy('plan_version_no', 'desc')
          ->first();
        // dd($planVersion);

        $cost_head = $this->getStdCostHead([
          'cost_code' => $request->input('cost_code'),
          'period_year' => $request->input('period_year'),
          'version_no' => $request->input('version_no'),
          'prdgrp_year_id' => $planVersion->prdgrp_year_id
        ]);
        $rs = $this->getRawMaterialCost([
            'cost_code'       => $request->input('cost_code'),
            'period_year'     => $request->input('period_year'),
            'version_no'      => $request->input('version_no'),
            'plan_version_no' => $request->input('plan_version_no'),
        ]);

        return response()->json([
            'std_cost_head' => $cost_head,
            'data' => $rs,
            'msg' => "success"
        ], 200);
    }

    public function planVersionCostHead(Request $request)
    {
      $rs = StdCostHeadV::select('plan_version_no')->where('period_year', $request->period_year)
      ->whereNotNull('plan_version_no')
      ->groupBy('plan_version_no')
      ->orderBy('plan_version_no')
      ->get();

      return response()->json([
        'message' => "success",
        'plan_version_no' => $rs
    ]);
    }

    public function version(Request $request)
    {
        $stdCostHead = StdCostHead::version([
            // 'cost_code' => $request->input('cost_code'),
            'period_year' => $request->input('period_year'),
        ])->get();

        return response()->json([
            'message' => "success",
            'version' => $stdCostHead
        ]);
    }

    /**
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function find(Request $request)
    {
        return StdCostItem::where('allocate_year_id', $request->input('allocate_year_id'))
            ->where('product_group', $request->input('product_group'))
            ->where('product_item_number', $request->input('product_item_number'))
            ->get();
    }

    /**
     * Approve Status
     *
     * $request['std_rm_ch_ids'] Value of array are std_rm_ch_id Ex: ['12', '13']
     * @return \Illuminate\Http\Response
     */
    public function approve(Request $request)
    {
        DB::beginTransaction();
        try {
            $planVersion = ProductGroupPlan::selectRaw("prdgrp_year_id, plan_version_no")
                ->where('period_year', $request->period_year)
                ->where('plan_version_no', $request->plan_version)
                ->orderBy('period_year', 'desc')
                ->orderBy('plan_version_no', 'desc')
                ->first();

            $stdActive = StdCostHead::where('cost_code', $request->cost_code)
                  ->where('period_year', $request->period_year)
                  ->where('approved_status', 'Active')
                  ->where('prdgrp_year_id', $planVersion->prdgrp_year_id)
                  ->orderBy('version_no', 'desc')
                  ->first();
                  

            $stdRawMeterialCostHead = StdCostHead::where('cost_code', $request->cost_code)
                                                ->where('period_year', $request->period_year)
                                                ->where('version_no', $request->version)
                                                ->where('prdgrp_year_id', $planVersion->prdgrp_year_id)
                                                ->first();

            // dd($request->all(), $stdRawMeterialCostHead);
            
            $st1 = $stdActive ? parseFromDateTh($stdActive->start_date_thai) : '';
            $st2 = parseFromDateTh($request['start_date_thai']);
            if ($st2 <= $st1) {
                return response()->json([
                    "msg" => "กรุณาระบุวันที่เริ่มใช้งานให้มากกว่า Version ที่อนุมัติก่อนหน้า",
                    "status" => 'E'
                ], 200);
            }

            $stdRawMeterialCostHead->approved_status = "Active";
            $stdRawMeterialCostHead->save();

            $allocate_year_id = $stdRawMeterialCostHead->allocate_year_id;



            $UpdateY = DB::table('oact.ptct_std_cost_prds')->where('cost_code', $request['cost_code'])
                                ->whereIn('product_item_number', $request['enable_flag'])
                                ->where('allocate_year_id', $allocate_year_id)
                                ->update(['enable_flag' => 'Y']);

            $UpdateN = DB::table('oact.ptct_std_cost_prds')->where('cost_code', $request['cost_code'])
                      ->whereNotIn('product_item_number', $request['enable_flag'])
                      ->where('allocate_year_id', $allocate_year_id)
                      ->update(['enable_flag' => 'N']);

            DB::commit();


            $stdRawMeterialCostPrdsV = StdCostPrdsV::selectRaw("distinct allocate_year_id")
                                                ->where('cost_code', $request->cost_code)
                                                ->where('period_year', $request->period_year)
                                                ->where('version_no', $request->version)
                                                ->where('prdgrp_year_id', $planVersion->prdgrp_year_id)
                                                ->first();

            $p_allocate_year_id = $stdRawMeterialCostPrdsV->allocate_year_id;



            $db     =   DB::getPdo();
            $sql = "declare
            l_msg       varchar2(1000);
            l_status    varchar2(100);
            BEGIN
            PTCT_M014_PKG.UPDATE_OLD_APPROVED(P_ALLOCATE_YEAR_ID  => $p_allocate_year_id
            ,x_status => l_status
            ,x_message => l_msg
            );
            end;";

            \Log::info($sql);
            $stmt = $db->prepare($sql);
            $stmt->execute();

            return response()->json([
                'msg' => 'success',
                'data' => $stdRawMeterialCostHead->approved_status
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'msg' => 'error',
                'error' => $e->getMessage()
            ], 403);
        }
    }

    public function approveLineData(Request $request)
    {
        DB::beginTransaction();
        try {

            $UpdateY = DB::table('oact.ptct_std_cost_prds')->where('cost_code', $request['cost_code'])
                                ->where('product_item_number', $request['product_item_number'])
                                ->where('allocate_year_id', $request['allocate_year_id'])
                                ->update(['approved_status' => 'Active']);

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

    public function enableFlag(Request $request)
    {
      DB::beginTransaction();
      try {
          $stdRawMeterialCostHead = StdCostHead::where('cost_code', $request->cost_code)
                                              ->where('period_year', $request->period_year)
                                              ->where('version_no', $request->version)
                                              ->first();

          $allocate_year_id = $stdRawMeterialCostHead->allocate_year_id;

          $UpdateY = DB::table('oact.ptct_std_cost_prds')->where('cost_code', $request['cost_code'])
                              ->whereIn('product_item_number', $request['enable_flag'])
                              ->where('allocate_year_id', $allocate_year_id)
                              ->update(['enable_flag' => 'Y']);

          $UpdateN = DB::table('oact.ptct_std_cost_prds')->where('cost_code', $request['cost_code'])
                    ->whereNotIn('product_item_number', $request['enable_flag'])
                    ->where('allocate_year_id', $allocate_year_id)
                    ->update(['enable_flag' => 'N']);

          DB::commit();

          return response()->json([
              'msg' => 'success',
          ], 200);
      } catch (\Exception $e) {
          DB::rollBack();

          return response()->json([
              'msg' => 'error',
              'error' => $e->getMessage()
          ], 403);
      }
    }


    public function getStdCostHead($param)
    {
      return StdCostHead::where('cost_code', $param['cost_code'])
                  ->where('period_year', $param['period_year'])
                  ->where('version_no', $param['version_no'])
                  ->where('prdgrp_year_id', $param['prdgrp_year_id'])
                  ->first();
    }

    /**
     *
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function getRawMaterialCost($param)
    {
        return StdCostPrdsV::where('cost_code', $param['cost_code'])
                            ->where('period_year', $param['period_year'])
                            ->where('version_no', $param['version_no'])
                            ->where('plan_version_no', $param['plan_version_no'])
                            ->orderBy('product_group', 'asc')
                            ->orderBy('product_item_number', 'asc')
                            ->get();
    }

    public function getUnionRawMaterialCost($param)
    {
      $beforePeriodYear = $param['period_year'] - 1;

      $maxCostPrdsV = StdCostPrdsV::where('cost_code', $param['cost_code'])
                        ->where('period_year', $beforePeriodYear)
                        ->orderBy('plan_version_no', 'desc')->first();

      $maxPlanVersion = "";
      if ($maxCostPrdsV && isset($maxCostPrdsV))
      {
        $maxPlanVersion = $maxCostPrdsV->plan_version_no;
      }

      $previousCost = StdCostPrdsV::query()->where('cost_code', $param['cost_code'])
                                    ->where('period_year', $beforePeriodYear)
                                    ->where('plan_version_no', $maxPlanVersion);



      $nowCost = StdCostPrdsV::where('cost_code', $param['cost_code'])
                            ->where('period_year', $param['period_year'])
                            ->where('plan_version_no', $param['version_no']);

      $unionQuery =  $nowCost->union($previousCost);

      $rs = DB::query()->fromSub($unionQuery, 'unionQuery')
                      ->orderBy('product_item_number', 'asc')
                      ->orderBy('product_group', 'asc')
                      ->orderBy('prdgrp_lot_number', 'asc')
                      ->get();

      return $rs;
    }

    public function getVersion()
    {
      $rs = StdCostHead::select('version_no')
            ->where('period_year', request()->period_year)
            ->orderBy('period_year', 'desc')
            ->orderBy('version_no', 'desc')
            ->first();

      $data = $rs->version_no;

      return response()->json($data);
    }

    public function getPlanVersion()
    {
        // dd(request()->all());
        $planVersion = ProductGroupPlan::selectRaw("prdgrp_year_id, plan_version_no")
                ->where('period_year', request()->period_year)
                ->orderBy('period_year', 'desc')
                ->orderBy('plan_version_no', 'desc')
                ->first();

        $data = $planVersion->plan_version_no;

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $db     =   DB::getPdo();
        $planVersion = ProductGroupPlan::selectRaw("prdgrp_year_id, plan_version_no")
                ->where('period_year', $request->input('period_year'))
                ->where('plan_version_no', $request->input('plan_version'))
                ->orderBy('period_year', 'desc')
                ->orderBy('plan_version_no', 'desc')
                ->first();

        $user       = auth()->user();
        $periodYear = $request->input('period_year');
        $costCode   = $request->input('cost_code');
        $version    = $request->input('version');

        $stdCostHeadIsExist =  StdCostHead::checkVersionExist([
            'cost_code'      => $request->input('cost_code'),
            'period_year'    => $request->input('period_year'),
            'prdgrp_year_id' => $planVersion->prdgrp_year_id,
            'version_no'     => $version
        ]);


        if ($stdCostHeadIsExist) {
          $stdCostHead = StdCostHead::where('cost_code', $request->input('cost_code'))
          ->where('period_year', $request->input('period_year'))
          ->where('version_no', $version)
          ->where('prdgrp_year_id', $planVersion->prdgrp_year_id)
          ->first();

            $sql = "
                DECLARE
                    v_debug           NUMBER :=0;
                    v_status          varchar2(20);
                    v_message         varchar2(2000);

                    v_main_rec        APPS.PTCT_M014_PKG.WEB_MAIN_PARAMETERS;
                    O_main_rec        APPS.PTCT_M014_PKG.WEB_MAIN_PARAMETERS;
                BEGIN
                    dbms_output.put_line('------  S T A R T ------');

                    APPS.PTCT_M014_PKG.BUILD_STD_COST(  P_ALLOCATE_YEAR_ID      => '".$stdCostHead->allocate_year_id."'
                                                        , P_RETURN_STATUS       => v_status
                                                        , P_RETURN_MESSAGE      => v_message ) ;

                    :v_status := v_status;
                    :v_message := v_message;

                    dbms_output.put_line('v_status '|| v_status);
                    dbms_output.put_line('v_message '|| v_message);
                EXCEPTION WHEN OTHERS THEN
                    dbms_output.put_line('***ERROR-'||sqlerrm);
                END;
            ";
        } else {
            $sql = "
                    DECLARE
                        v_debug           NUMBER :=0;
                        v_status          varchar2(20);
                        v_message         varchar2(2000);
                        P_YEAR_MAIN_ID    NUMBER :=0;
                        v_main_rec        apps.PTCT_M014_PKG.WEB_MAIN_PARAMETERS;
                        O_main_rec        apps.PTCT_M014_PKG.WEB_MAIN_PARAMETERS;

                    BEGIN
                        dbms_output.put_line('------  S T A R T ------');

                            v_main_rec  := NULL;
                            v_main_rec.PERIOD_YEAR          := '".$periodYear."';
                            v_main_rec.PRDGRP_YEAR_ID       := '".$planVersion->prdgrp_year_id."';
                            v_main_rec.COST_CODE            := '".$costCode."';
                            v_main_rec.VERSION_NO           := '".$version."';

                            v_main_rec.PROGRAM_CODE         := 'CTM0014';

                            v_main_rec.CREATED_BY           := '".$user->user_id."';

                            ---- output

                            O_main_rec := apps.PTCT_M014_PKG.CREATE_MAIN(P_MAIN_PARAM  => v_main_rec);

                            :v_status := O_main_rec.return_status;
                            :v_message := O_main_rec.return_message;


                        dbms_output.put_line('OUTPUT : '||O_main_rec.return_status );
                        dbms_output.put_line('OUTPUT : '||O_main_rec.return_message );
                        dbms_output.put_line('OUTPUT ALLOCATE_YEAR_ID  : '||O_main_rec.ALLOCATE_YEAR_ID  );
                        dbms_output.put_line('------  E N D ------');
                    EXCEPTION WHEN OTHERS THEN
                        dbms_output.put_line('***Error-'||sqlerrm);
                    END;
                ";
        }


        \Log::info($sql);
        $stmt = $db->prepare($sql);
        $result = false;
        $stmt->bindParam(':v_status', $result['status'], \PDO::PARAM_STR, 4000);
        $stmt->bindParam(':v_message', $result['data'], \PDO::PARAM_STR, 4000);
        \Log::info($result);
        $stmt->execute();

        \Log::info($result['status']);
        \Log::info($result['data']);

        if ($result['status'] === "C") {

            $data = $this->getRawMaterialCost([
                'cost_code' => $costCode,
                'period_year' => $periodYear,
                'plan_version_no' => $request->input('plan_version'),
                'version_no' => $version,
            ]);

            \Log::info($data);

            return response()->json([
                'msg' => "success"
            ], 200);
        } else {
            return response()->json([
                'error' => 'Something wrong',
                'msg' => "error",
                'data' => $result
            ], 404);
        }

    }

    public function getCostCenter()
    {
        $costCodeList = StdCostHead::where('version_no', request()->version_no)
                ->orderBy('cost_code', 'asc')
                ->get()
                ->pluck('cost_code');

        return DB::table('ptct_cost_center_v')->whereIn('cost_code', $costCodeList)->get();
    }

    public function date(Request $request)
    {
        $planVersion = ProductGroupPlan::selectRaw("prdgrp_year_id, plan_version_no")
                ->where('period_year', $request->period_year)
                ->where('plan_version_no', $request->plan_version)
                ->orderBy('period_year', 'desc')
                ->orderBy('plan_version_no', 'desc')
                ->first();

        $stdActive = StdCostHead::where('cost_code', $request['cost_code'])
                  ->where('period_year', $request['period_year'])
                  ->where('approved_status', 'Active')
                  ->where('prdgrp_year_id', $planVersion->prdgrp_year_id)
                  ->orderBy('version_no', 'desc')
                  ->first();
                  

        $st1 = $stdActive ? parseFromDateTh($stdActive->start_date_thai) : '';
        $st2 = parseFromDateTh($request['start_date_thai']);
        if ($st2 <= $st1) {
            return response()->json([
                "msg" => "กรุณาระบุวันที่เริ่มใช้งานให้มากกว่า Version ที่อนุมัติก่อนหน้า",
                "status" => 'E'
            ], 200);
        }

        $data = StdCostHead::where('cost_code', $request['cost_code'])
                  ->where('period_year', $request['period_year'])
                  ->where('version_no', $request['version_no'])
                  ->where('prdgrp_year_id', $planVersion->prdgrp_year_id)
                  ->first();
                  
      if ($data && $request['start_date_thai'] && $request['end_date_thai']) {
        $start_date_array = explode("/", $request['start_date_thai']);
        $end_date_array = explode("/", $request['end_date_thai']);

        if (count($start_date_array)!= 3 || count($end_date_array)!= 3) {
          return response()->json([
            "message" => "wrong_format",
            "status" => false
          ], 200);
        }

        $d_start_date = $start_date_array[0];
        $m_start_date = $start_date_array[1];
        $y_start_date = $start_date_array[2] - 543;

        $d_end_date = $end_date_array[0];
        $m_end_date = $end_date_array[1];
        $y_end_date = $end_date_array[2] - 543;

        $start_date = date_create("${y_start_date}-${m_start_date}-${d_start_date}");
        $start_date_format = date_format($start_date,"d M Y");

        $end_date = date_create("${y_end_date}-${m_end_date}-${d_end_date}");
        $end_date_format = date_format($end_date,"d M Y");
      } else {
        return response()->json([
          "message" => "error",
          "status" => false
        ], 200);
      }
      DB::beginTransaction();
        if ($start_date_format && $end_date_format) {
          $allocate_year_id = $data->allocate_year_id;
          $data = $data->update([
            'start_date' => date("Y-m-d",strtotime($start_date_format)),
            'end_date' => date("Y-m-d",strtotime($end_date_format)),
            'start_date_thai' => $request['start_date_thai'],
            'end_date_thai' => $request['end_date_thai']
          ]);

          StdCostProd::where('allocate_year_id', $allocate_year_id)->update([
            'start_date' => date("Y-m-d",strtotime($start_date_format)),
            'end_date' => date("Y-m-d",strtotime($end_date_format)),
          ]);
        }
      DB::commit();
      return response()->json([
        "message" => "success",
        "status" => true
      ], 200);
    }
}
