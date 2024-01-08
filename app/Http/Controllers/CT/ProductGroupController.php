<?php

namespace App\Http\Controllers\CT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CT\ItemCostingV;
class ProductGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('ct.product_group.index');
    }

    public function show($product_group, Request $request)
    {
        $cost_code =$request->cost_code;
        if (!$request->has('cost_code')) {
            return redirect()->back();
        }

        $rs = DB::table('ptct_product_group_v')->where('cost_code', $cost_code)->where('product_group', $product_group)->first();
        $product = DB::table('ptct_product_item_number_v')->where('cost_code', $cost_code)->where('product_group', $product_group)
                        ->orderBy('product_item_number')
                        ->orderBy('product_item_desc')
                        ->get();

        if ($product) {
            data_set($product, '*.is_delete', false);
        }

        $newProducts = collect(DB::select("
        SELECT DISTINCT
          product_item_id
          , product_item_number
          , description
          , product_item_id AS VALUE
          , product_item_number ||' : '|| description AS LABEL
        FROM
            oact.ptct_item_costing_v
        WHERE ROWNUM <= 100  
        ORDER BY
            label
        "));

        return view('ct.product_group.show')->with([
            'p_cost_code' => $cost_code,
            'p_product_group' => $product_group,
            'product_group' => $rs,
            'product' => $product,
            'new_products' => $newProducts
        ]);
    }
}
