<?php

namespace App\Http\Controllers\OM;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\OM\SequenceEcoms\ProductCategoryCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SequenceFortnightlyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $menu = Menu::where('program_code', 'OMP0053')->first();
        // dd($menu);
        view()->share('menu', $menu);
    }

    public function index()
    {
        $default = 1;
        $sequenceEcoms = DB::table('ptom_sequence_ecoms as se')
        ->join('ptom_taste_v as t', 't.value', '=', 'se.taste_code')
        ->where(function($query) use($default) {
            if(!empty($default == 1)) {
                $query->where('se.sale_type_code', 'DOMESTIC');
            }
            if(!empty($default == 2)) {
                $query->where('se.sale_type_code', 'EXPORT');
            }
        })
        ->whereRaw("nvl(se.start_date,sysdate+1) < sysdate")
        ->whereRaw("nvl(se.end_date,sysdate+1) > sysdate")
        ->whereNull('deleted_at')
        ->orderBy('se.forecast_screen_no','asc')
        ->get(['se.sequence_ecom_id', 'se.item_code', 'se.item_description', 'se.forecast_screen_no', 'se.forecast_stamp', 'se.filter_flag', 'se.taste_code', 't.description']);

        foreach ($sequenceEcoms as $key => $value) {
            $value->filter_flag = $value->filter_flag == 'Y' ? 'มีก้นกรอง' : 'ไม่มีก้นกรอง';
        }

        $productCategoryCode = ProductCategoryCode::get();

        // echo '<pre>';
        // print_r($sequenceEcoms);
        // echo '</pre>';
        // exit();

        return view('om.sequencefortnightly/index',compact('sequenceEcoms', 'productCategoryCode'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
