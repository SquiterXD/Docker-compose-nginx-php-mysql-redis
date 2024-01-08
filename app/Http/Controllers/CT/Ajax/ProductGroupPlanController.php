<?php

namespace App\Http\Controllers\CT\Ajax;

use App\Http\Controllers\Controller;
use App\Models\CT\ProductGroupItem;
use App\Models\CT\ProductGroupPlan;
use App\Models\CT\PrdgrpPlanGroupV;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;

class ProductGroupPlanController extends Controller
{
    /**
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $productGroupPlan = ProductGroupPlan::with('productGroupItems')
            ->where('period_year', $request->period_year)
            ->where('plan_version_no', $request->plan_version_no)
            ->orderBy('prdgrp_year_id', 'desc')
            ->firstOrFail();

        $prdGrpPlanGroupV = PrdgrpPlanGroupV::where('period_year', $request->period_year)
            ->where('plan_version_no', $request->plan_version_no)
            ->orderBy('prdgrp_year_id', 'desc')
            ->get();

        // $data = $this->setTreeFormat($productGroupPlan->productGroupItems);
        $productGroupPlan = ProductGroupPlan::with('productGroupItems')->find($productGroupPlan->prdgrp_year_id);
        $data = $this->setTreeFormat($productGroupPlan->productGroupItems);
        // dd('productGroupItems', $data['productGroupItems'][51], $data['productGroupItems'][51]['children'], $data['productGroupItems']);

        return response()->json([
            'productGroupPlan' => $productGroupPlan,
            'productGroupItems' => $data['productGroupItems'],
            'prdGrpPlanGroupV' => $prdGrpPlanGroupV,
            'costCenters' => $data['costCenters'],
            'msg' => "success"
        ], 200);
    }

    public function uom() 
    {
      $data = DB::table('PTINV_UOM_V')
            ->select('unit_of_measure', 'uom_code')
            ->get();

      return response()->json([
        'data' => $data,
        'status' => true,
        'message' => 'success'
      ], 200);
    }

    /**
     * Call Package to create data
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $productGroupPlan = ProductGroupPlan::where('period_year', $request->input('period_year'))
            ->where('period_year', $request->input('period_year'))
            ->where('plan_version_no', $request->input('plan_version_no'));

        if ($productGroupPlan->exists()) {
          $prdGrpYearId = $productGroupPlan->first()->prdgrp_year_id;
        } else {
            $newProductGroupPlan = ProductGroupPlan::create([
                'period_year' => $request->input('period_year'),
                'plan_version_no' => $request->input('plan_version_no'),
            ]);
            $prdGrpYearId = $newProductGroupPlan->prdgrp_year_id;
        }

        $result = [];
        $db     =   DB::getPdo();

        $sql    =   "
                        DECLARE
                            V_RETURN_STATUS    varchar2(4000):= null;    
                            V_RETURN_MESSAGE   varchar2(4000):= null;    
                            
                            P_PRDGRP_YEAR_ID      NUMBER := 0;
                        BEGIN
                        
                            P_PRDGRP_YEAR_ID  := {$prdGrpYearId};
                            
                            SELECT PRDGRP_YEAR_ID  
                                INTO P_PRDGRP_YEAR_ID
                            FROM PTCT_PRDGRP_PLAN_V          V
                            WHERE 1=1
                                AND  PRDGRP_YEAR_ID      = P_PRDGRP_YEAR_ID ;
                            
                            PTCT_M009_PKG.BUILD_DATA(P_PRDGRP_YEAR_ID         => P_PRDGRP_YEAR_ID
                                                        , P_RETURN_STATUS       => :V_RETURN_STATUS 
                                                        , P_RETURN_MESSAGE      => :V_RETURN_MESSAGE );
                                                        
      
                        
                            dbms_output.put_line('P_RETURN_STATUS : '||V_RETURN_STATUS);
                            dbms_output.put_line('P_RETURN_MESSAGE : '||V_RETURN_MESSAGE);
                        
                        end;
                    ";

        $sql = preg_replace("/[\r\n]*/", "", $sql);

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':V_RETURN_STATUS', $result['status'], PDO::PARAM_STR, 1);
        $stmt->bindParam(':V_RETURN_MESSAGE', $result['data'], PDO::PARAM_STR, 1000);
        $stmt->execute();

        $productGroupPlan = ProductGroupPlan::with('productGroupItems')->find($prdGrpYearId);
        $data = $this->setTreeFormat($productGroupPlan->productGroupItems);

        if ($result['status'] === "C") {
            return response()->json([
                'productGroupPlan' => $productGroupPlan,
                'productGroupItems' => $data['productGroupItems'],
                'costCenters' => $data['costCenters'],
                'msg' => "success"
            ], 200);
        } else {
            return response()->json([
                'error' => 'Something wrong',
                'msg' => "error"
            ], 404);
        }
    }

     /**
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function setTreeFormat($items)
    {
        $costCenters = [];
        $productGroupItems = [];

        $prdgrpYearId = $items->first()->prdgrp_year_id;
        $planVersionNo = $items->first()->plan_version_no;

        $prdGrpPlanGroupV = PrdgrpPlanGroupV::where('prdgrp_year_id', $prdgrpYearId)
                            ->where('plan_version_no', $planVersionNo)
                            ->get();

        foreach ($items as $key => $item) {
            $costCenters[$item->cost_code]['cost_code'] = $item->cost_code;
            $costCenters[$item->cost_code]['name'] = $item->cost_code . ' - ' . $item->cost_description;

            if (data_get($productGroupItems, "$item->cost_code.children.pg-$item->product_group") == null) {
                $prdGrpPlanGroupV = PrdgrpPlanGroupV::where('prdgrp_year_id', $prdgrpYearId)
                            ->where('plan_version_no', $planVersionNo)
                            ->where('cost_code', $item->cost_code)
                            ->where('product_group', $item->product_group)
                            ->first();

                $productGroupItems[$item->cost_code]['children']['pg-'.$item->product_group]['prd_productivity_qty'] = number_format($prdGrpPlanGroupV->prd_productivity_qty ?? 0, 2);
            }
            $productGroupItems[$item->cost_code]['cost_code'] = $item->cost_code;
            $productGroupItems[$item->cost_code]['name'] = $item->cost_code . ' - ' . $item->cost_description;
            $productGroupItems[$item->cost_code]['children']['pg-'.$item->product_group]['prdgrp_year_id'] = $item->prdgrp_year_id;
            $productGroupItems[$item->cost_code]['children']['pg-'.$item->product_group]['pg_code'] = $item->product_group;
            $productGroupItems[$item->cost_code]['children']['pg-'.$item->product_group]['name'] = $item->product_group . ' - ' . $item->product_group_description;
            $productGroupItems[$item->cost_code]['children']['pg-'.$item->product_group]['ratio'] = number_format($item->ratio, 2);
            $productGroupItems[$item->cost_code]['children']['pg-'.$item->product_group]['width'] = number_format($item->width, 2);
            $productGroupItems[$item->cost_code]['children']['pg-'.$item->product_group]['length'] = number_format($item->length, 2);
            $productGroupItems[$item->cost_code]['children']['pg-'.$item->product_group]['around'] = number_format($item->around, 2);
            $productGroupItems[$item->cost_code]['children']['pg-'.$item->product_group]['area'] = number_format($item->area, 2);
            $productGroupItems[$item->cost_code]['children']['pg-'.$item->product_group]['uom_code_prd'] = $item->uom_code_prd;
            $productGroupItems[$item->cost_code]['children']['pg-'.$item->product_group]['quantity_prd'] = number_format($item->quantity_prd, 2);
            // $productGroupItems[$item->cost_code]['children']['pg-'.$item->product_group]['prd_productivity_qty'] = number_format($item->prd_productivity_qty, 2);

            $productGroupItems[$item->cost_code]['children']['pg-'.$item->product_group]['children'][$item->product_item_number]['name'] = $item->product_item_number. ' - ' . $item->product_item_desc;
            $productGroupItems[$item->cost_code]['children']['pg-'.$item->product_group]['children'][$item->product_item_number]['qty'] = number_format($item->qty_productivity);  
        }

        ksort($productGroupItems);

        return [
            'costCenters' => $costCenters,
            'productGroupItems' => $productGroupItems,
        ];
    }

    public function updateItem(Request $request)
    {
        $productGroupPlan = ProductGroupPlan::where('period_year', $request->period_year)
            ->where('plan_version_no', $request->plan_version_no)
            ->firstOrFail();

        $result = [];
        $input = (object) [];
        try {
            foreach ($request->data as $key => $item) {
                $item = (object) $item;
                $input->prdgrp_year_id      = $productGroupPlan->prdgrp_year_id;
                $input->cost_code           = $request->cost_code;
                $input->product_group       = $item->product_group;
                $input->product_item_number = $item->product_item_number;
                $input->qty_productivity    = $item->qty;

                $db = DB::getPdo();
                $sql = "
                    DECLARE
                        P_RETURN_STATUS         varchar2(1) := NULL;
                        P_RETURN_MESSAGE        varchar2(4000) := NULL;
                        v_debug                 NUMBER :=1;

                        v_param_rec        PTCT_M009_PKG.CTM09_PARAM_REC;
                        /*
                        select * from PTCT_PRODUCT_ITEMS WHERE PRDGRP_YEAR_ID   = 345;
                        */
                    BEGIN
                    dbms_output.put_line('---------------------  S T A R T. -------------------');
                        v_param_rec := NULL;

                        v_param_rec.PRDGRP_YEAR_ID          :=  :p_prdgrp_year_id;
                        v_param_rec.COST_CODE               :=  :p_cost_code;
                        v_param_rec.product_group           :=  :p_product_group;
                        v_param_rec.product_item_number     :=  :p_product_item_number;
                        v_param_rec.qty_productivity        :=  :p_qty_productivity;

                        v_param_rec.old_qty_productivity     :=  0;   ---- ค่าเดิม

                        v_debug := 9;
                        PTCT_M009_PKG.WEB_CTM09 ( P_PARAM_DATA      =>  v_param_rec   ) ;

                        dbms_output.put_line('OUTPUT :'||v_param_rec.RETURN_STATUS
                                         ||' MSG :'||v_param_rec.RETURN_MESSAGE
                                                );

                        :P_RETURN_STATUS := v_param_rec.RETURN_STATUS;
                        :P_RETURN_MESSAGE := v_param_rec.RETURN_MESSAGE;

                    dbms_output.put_line('---------------------  E N D. -------------------');
                    EXCEPTION WHEN others THEN
                        dbms_output.put_line(v_debug||'**call_error'||sqlerrm);
                    END ;
                ";

                // $sql = preg_replace("/[\r\n]*/", "", $sql);
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':p_prdgrp_year_id',       $input->prdgrp_year_id, PDO::PARAM_STR, 100);
                $stmt->bindParam(':p_cost_code',            $input->cost_code, PDO::PARAM_STR, 100);
                $stmt->bindParam(':p_product_group',        $input->product_group, PDO::PARAM_STR, 100);
                $stmt->bindParam(':p_product_item_number',  $input->product_item_number, PDO::PARAM_STR, 100);
                $stmt->bindParam(':p_qty_productivity',     $input->qty_productivity, PDO::PARAM_STR, 100);


                $stmt->bindParam(':P_RETURN_STATUS', $result['status'], PDO::PARAM_STR, 1);
                $stmt->bindParam(':P_RETURN_MESSAGE', $result['message'], PDO::PARAM_STR, 4000);
                $stmt->execute();

                if ($result['status'] != 'C') {
                    throw new \Exception($result['message']);
                }
            }

            $data = [
                'status' => 'C',
                'msg' => ''
            ];

        } catch (\Exception $e) {
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }

        return response()->json($data);
    }

    public function planVersion(Request $request) 
    {
      if ($request->period_year) {
        $data = ProductGroupPlan::where('period_year', $request->period_year)->select('plan_version_no')->orderBy('plan_version_no')->get();

        return response()->json([
          "message" => "success",
          "status" => true,
          "data" => $data
        ], 200);
      } else {
        return response()->json([
          "message" => "not found",
          "status" => false,
        ], 500);
      }
    }
}
