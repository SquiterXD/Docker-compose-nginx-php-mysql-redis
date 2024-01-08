<?php

namespace App\Http\Controllers\PD\Api;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PD\AdjSalForecasts\PtpdAdjSalesForecastH;
use App\Repositories\PD\LldRepository;
use App\Models\PD\LLDBlendNoV;
use App\Models\PD\LLDCigarV;

class LldController extends Controller
{
    public function store(Request $request)
    {
        try {
            $res = (new LldRepository)->store($request);
            $data = $res;
            $data['status'] = 'S';
        } catch (\Exception $e) {
            \Log::error($e);
            $data = [
                'status' => 'E',
                'msg' => $e->getMessage()
            ];
        }

        return response()->json(['data' => $data]);
    }

    public function update()
    {
        try {
            $header = (new LldRepository)->update(request());
            $data = [
                'status' => 'S',
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

    public function findDataLov()
    {
        $listBlendNo    = LLDBlendNoV::orderBy('blend_no', 'DESC')->get();

        return response()->json([ 'listBlendNo' => $listBlendNo ]);
    }

    public function findItemCode()
    {
        $request    = request()->all();
        $arrValue   = [];
        foreach ($request['availableData'] as $key => $arr) {
            $arrValue[$key] = $arr['inventory_item_id'];
        }

        $listCigar      = LLDCigarV::whereNotIn('cigar_item_id', $arrValue)
                                    ->orderBy('cigar_item_code', 'DESC')
                                    ->get();

        return response()->json([ 'listCigar' => $listCigar ]);
    }

    // public function duplicate(PtpdAdjSalesForecastH $adjSalForecastHT)
    // {
    //     try {
    //         \DB::beginTransaction();
    //         $header = (new AdjSalForecastRepository)->duplicate($adjSalForecastHT, request());
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
