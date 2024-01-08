<?php

namespace App\Http\Controllers\OM;

use App\Models\OM\Promotions\PromotionHeader;

use App\Models\OM\Customers\Domestics\Customer;
use App\Http\Controllers\Controller;
use App\Imports\OM\UserPromotion;
use App\Models\OM\Promotions\Oaom\Itemv;
use App\Models\OM\Promotions\PromotionCust;
use App\Models\OM\Promotions\PromotionDtl;
use App\Models\OM\Promotions\PromotionProduct;
use App\Models\OM\Promotions\PromotionProductGroup;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

// use App\Models\OM\Promotions\PromotionHeader;



class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        if(request()->ajax()) {
            $result = [];
            $excel = new UserPromotion($result);
            $import = Excel::import($excel, request()->file('file'));
            $result = $excel->resultData();
            return $result;
        }
        $promotionHeader = new PromotionHeader();

        $oaomItemV = Itemv::get();

        // var_dump($oaomItemV);

        $promotionGroup = PromotionProductGroup::get();

        $dtl = PromotionDtl::get();

        $product = PromotionProduct::get();

        $cust = PromotionCust::get();

        return view('om.promotions.index',compact('cust','oaomItemV'));
    }

    public function search()
    {
        $promotionHeader = new PromotionHeader();

        // PromotionCust::where('promotion_id',20)->delete();
        $oaomItemV = Itemv::get();

        // var_dump($oaomItemV);

        $promotionGroup = PromotionProductGroup::get();

        $dtl = PromotionDtl::get();

        $product = PromotionProduct::get();

        $cust = PromotionCust::get();

        return view('om.promotions.search',compact('cust','oaomItemV'));
    }

    public function copy()
    {
        $promotionHeader = new PromotionHeader();

        // PromotionCust::where('promotion_id',20)->delete();
        $oaomItemV = Itemv::get();

        // var_dump($oaomItemV);

        $promotionGroup = PromotionProductGroup::get();

        $dtl = PromotionDtl::get();

        $product = PromotionProduct::get();

        $cust = PromotionCust::get();

        return view('om.promotions.copy',compact('cust','oaomItemV'));
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

    public function storeHeader(Request $request)
    {
        $promotionHeader = new PromotionHeader();
        $promotionHeader->promotion_code = $request->promotion_code;
        $promotionHeader->start_date = $request->start_date;
        $promotionHeader->end_date = $request->end_date;
        $promotionHeader->status = $request->status;
        $promotionHeader->created_by = 1;
        $promotionHeader->last_updated_by = 1;
        $promotionHeader->program_code = 'OMS0003';
        $promotionHeader->save();
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
