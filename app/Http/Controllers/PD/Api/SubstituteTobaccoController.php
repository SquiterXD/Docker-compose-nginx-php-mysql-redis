<?php

namespace App\Http\Controllers\PD\Api;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\PD\SubstituteTobaccoRepository;

class SubstituteTobaccoController extends Controller
{
    public function store(Request $request)
    {
        try {
            $header = (new SubstituteTobaccoRepository)->store($request);
             $data = [
                'status' => 'S',
                // 'header' => $resHeader
                'header' => $header
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

    // public function modalCreateDetail()
    // {
    //     $budgetYear = request()->budget_year;
    //     $budgetYearVersion = request()->budget_year_version;

    //     $versionNo = PtpdAdjSalesForecastH::where('budget_year', $budgetYear - 543)
    //                 ->where('budget_year_version', $budgetYearVersion)
    //                 ->max('version_no');

    //     $versionNo = $versionNo + 1;

    //     $data = [
    //         'status' => 'S',
    //         'adj_version_no' => $versionNo,
    //     ];
    //     return response()->json([ 'data' => $data]);
    // }

    // public function modalSearchDetail()
    // {
    //     $budgetYear = request()->budget_year;
    //     $budgetYearVersion = request()->budget_year_version;

    //     $versionNo = PtpdAdjSalesForecastH::where('budget_year', $budgetYear - 543)
    //                 ->where('budget_year_version', $budgetYearVersion)
    //                 ->orderBy('version_no')
    //                 ->get();

    //     $versionList = [];
    //     if ($versionNo) {
    //         $versionList = $versionNo->pluck('version_no', 'version_no')->all();
    //     }

    //     $data = [
    //         'status' => 'S',
    //         'adj_version_no_list' => $versionList,
    //     ];
    //     return response()->json([ 'data' => $data]);
    // }

    // public function store(Request $request)
    // {
    //     try {
    //         \DB::beginTransaction();
    //         $header = (new AdjSalForecastRepository)->store($request);
    //         \DB::commit();
    //         $data = [
    //             'status' => 'S',
    //             'header' => $header,
    //             'redirect_page' => route('pd.adj-sal-forecasts.index', ['h_adj_sale_for_id' => $header->h_adj_sale_for_id])
    //         ];
    //     } catch (\Exception $e) {
    //         \Log::error($e);
    //         \DB::rollback();
    //         $data = [
    //             'status' => 'E',
    //             'msg' => $e->getMessage()
    //         ];
    //     }

    //     return response()->json(['data' => $data]);
    // }

    // public function update(PtpdAdjSalesForecastH $adjSalForecastHT)
    // {
    //     try {
    //         \DB::beginTransaction();
    //         $header = (new AdjSalForecastRepository)->update($adjSalForecastHT, request());
    //         \DB::commit();
    //         $data = [
    //             'status' => 'S',
    //             'header' => $header,
    //             'redirect_page' => route('pd.adj-sal-forecasts.index', ['h_adj_sale_for_id' => $header->h_adj_sale_for_id])
    //         ];
    //     } catch (\Exception $e) {
    //         \Log::error($e);
    //         \DB::rollback();
    //         $data = [
    //             'status' => 'E',
    //             'msg' => $e->getMessage()
    //         ];
    //     }

    //     return response()->json(['data' => $data]);
    // }
}
