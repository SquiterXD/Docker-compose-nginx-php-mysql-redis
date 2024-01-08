<?php

namespace App\Http\Controllers\CT\Ajax;

use App\Http\Controllers\Controller;
use App\Models\CT\PeriodYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\CT\ProductGroup;
use App\Models\CT\ProductGroupDetail;
use App\Models\CT\ProductGroupPlan;

class ProductPlanAmountController extends Controller
{
    /*
     *  Update Data In ProductGroup, ProductGroupDetail
     *
     */
    public function update(Request $request)
    {
        $dataProductGroup = $request->input('pg');
        $dataProductGroupDetails = $request->input('pg_detail');

        DB::beginTransaction();
        try {

            $productGroup = ProductGroup::find($dataProductGroup['product_group_id']);
            $productGroup->width = $dataProductGroup['width'];
            $productGroup->long = $dataProductGroup['long'];
            $productGroup->area = $dataProductGroup['area'];
            $productGroup->around = $dataProductGroup['around'];
            $productGroup->save();

            foreach ($dataProductGroupDetails as $key => $value) {
                $productGroupDetail = ProductGroupDetail::find($value['product_group_detail_id']);
                $productGroupDetail->qty_productivity = $value['qty_productivity'];
                $productGroupDetail->save();
            }
           
            DB::commit();
            return response()->json(['msg' => "success"], 200);
        } catch (\Exception $e) {
            // ERROR CREATE REIMBURSEMENT
            DB::rollBack();

            return response()->json([
                'msg' => 'error',
                'error' => $e->getMessage()
            ], 403);
        }
    }

    public function getYearForDropdown()
    {
        return ProductGroupPlan::selectRaw('distinct period_year AS period_year, period_year_thai AS label_year')
            ->orderBy('period_year', 'DESC')
            ->get();
    }
    
    public function getPeriodMonthDropdown($year)
    {
        return PeriodYear::select('period_num', 'period_year')
            ->select(DB::raw("substr(period_name,1,3)|| '-' ||to_number(substr(period_name,5,6)-1) AS period_name"))
            ->where('period_year', $year)
            ->where('adjustment_period_flag', "N")
            ->orderBy('period_num', 'DESC')
            ->get();
            
    }

}
