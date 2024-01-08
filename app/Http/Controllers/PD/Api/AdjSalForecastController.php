<?php

namespace App\Http\Controllers\PD\Api;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PD\AdjSalForecasts\PtpdAdjSalesForecastH;
use App\Repositories\PD\AdjSalForecastRepository;

class AdjSalForecastController extends Controller
{
    public function modalCreateDetail()
    {
        $budgetYear = request()->budget_year;
        $budgetYearVersion = request()->budget_year_version;

        $versionNo = (new AdjSalForecastRepository)->getCurrentVersion($budgetYear - 543, $budgetYearVersion);
        $versionNo = $versionNo + 1;

        $data = [
            'status' => 'S',
            'adj_version_no' => $versionNo,
        ];
        return response()->json([ 'data' => $data]);
    }

    public function modalSearchDetail()
    {
        $budgetYear = request()->budget_year;
        $budgetYearVersion = request()->budget_year_version;

        $versionNo = PtpdAdjSalesForecastH::where('budget_year', $budgetYear - 543)
                    ->where('budget_year_version', $budgetYearVersion)
                    ->orderBy('version_no', 'desc')
                    ->whereNotNull('version_no')
                    ->get();

        $versionList = [];
        if ($versionNo) {
            $versionList = $versionNo->pluck('version_no', 'version_no')->all();
            $versionList = array_values($versionList);
        }

        $data = [
            'status' => 'S',
            'adj_version_no_list' => $versionList,
        ];
        return response()->json([ 'data' => $data]);
    }

    public function store(Request $request)
    {
        try {
            \DB::beginTransaction();
            $header = (new AdjSalForecastRepository)->store($request);
            \DB::commit();
            $data = [
                'status' => 'S',
                'header' => $header,
                'redirect_page' => route('pd.adj-sal-forecasts.index', ['h_adj_sale_for_id' => $header->h_adj_sale_for_id])
            ];
        } catch (\Exception $e) {
            \Log::error($e);
            \DB::rollback();
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }

        return response()->json(['data' => $data]);
    }

    public function update(PtpdAdjSalesForecastH $adjSalForecastHT)
    {
        try {
            \DB::beginTransaction();
            $header = (new AdjSalForecastRepository)->update($adjSalForecastHT, request());
            \DB::commit();
            $data = [
                'status' => 'S',
                'header' => $header,
                'redirect_page' => route('pd.adj-sal-forecasts.index', ['h_adj_sale_for_id' => $header->h_adj_sale_for_id])
            ];
        } catch (\Exception $e) {
            \Log::error($e);
            \DB::rollback();
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }

        return response()->json(['data' => $data]);
    }

    public function duplicate(PtpdAdjSalesForecastH $adjSalForecastHT)
    {
        try {
            \DB::beginTransaction();
            $header = (new AdjSalForecastRepository)->duplicate($adjSalForecastHT, request());
            \DB::commit();
            $data = [
                'status' => 'S',
                'header' => $header,
                'redirect_page' => route('pd.adj-sal-forecasts.index', ['h_adj_sale_for_id' => $header->h_adj_sale_for_id])
            ];
        } catch (\Exception $e) {
            \Log::error($e);
            \DB::rollback();
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }

        return response()->json(['data' => $data]);
    }
}
