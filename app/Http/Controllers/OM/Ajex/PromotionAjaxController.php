<?php

namespace App\Http\Controllers\OM\Ajex;

use App\Http\Controllers\Controller;
use App\Models\OM\Customers\Domestics\Customer;
use App\Models\OM\SequenceEcoms;
use App\Models\OM\Promotions\PromotionCust;
use App\Models\OM\Promotions\PromotionDtl;
use App\Models\OM\Promotions\PromotionHeader;
use App\Models\OM\Promotions\PromotionProduct;
use App\Models\OM\Promotions\PromotionProductGroup;
use App\Models\OM\Promotions\UomV;
use App\Repositories\OM\PromotionRepo;
use Illuminate\Http\Request;
use App\Http\Controllers\OM\Ajex\DB;

class PromotionAjaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allProduct()
    {
        $SequenceEcoms = SequenceEcoms::whereRaw("lower(sale_type_code) = 'domestic'")->get();
        return response()->json(['data' => $SequenceEcoms]);
    }

    public function allPromotion()
    {
        $Promotion = PromotionHeader::whereNull('deleted_at')->orderBy('promotion_id','DESC')->get();
        return response()->json(['data' => $Promotion]);
    }

    public function allCustomer()
    {
        $customers = Customer::where('customer_number','!=','""')->whereRaw("lower(sales_classification_code) = 'domestic'")->whereRaw("lower(status) = 'active'")->orderBy('customer_number','ASC')->get(['customer_id','customer_number','customer_name']);
        return response()->json(['data' => $customers]);
    }

    public function searchCustomer($customer_number='')
    {
        if ($customer_number != '') {
            $customers = Customer::where('customer_number','!=','""')->whereRaw("lower(customer_number) like '%".strtolower($customer_number)."%' ")->orderBy('customer_number','ASC')->get(['customer_id','customer_number','customer_name']);
        }else{
            $customers = Customer::where('customer_number','!=','""')->orderBy('customer_number','ASC')->get(['customer_id','customer_number','customer_name']);
        }

        return response()->json(['data' => $customers]);
    }

    public function setModalCustomerPromo($promotion_code)
    {
        $customers = Customer::where('customer_number','!=','""')
        ->whereRaw("lower(sales_classification_code) = 'domestic'")
        ->whereRaw("lower(status) = 'active'")
        ->orderBy('customer_number','ASC')
        ->leftJoin('ptom_customer_type_domestic', 'ptom_customer_type_domestic.customer_type', '=', 'ptom_customers.customer_type_id')
        ->select('ptom_customers.customer_id','ptom_customers.customer_number','ptom_customers.customer_name', 'ptom_customers.region_code', 'ptom_customers.province_name', 'ptom_customer_type_domestic.meaning')
        ->get();

        // $customers = Customer::where('customer_number','!=','""')
        // ->whereRaw("lower(sales_classification_code) = 'domestic'")
        // ->whereRaw("lower(status) = 'active'")
        // ->orderBy('customer_number','ASC')
        // ->get(['customer_id','customer_number','customer_name']);
        $response = [];
        $promotion = PromotionHeader::where('promotion_code',$promotion_code)->whereNull('deleted_at')->first();

        foreach ($customers as $key => $v) {

            $customerSelected = PromotionCust::where('promotion_id',$promotion->promotion_id)->where('customer_id',$v->customer_id)->whereNull('deleted_at')->first();

            $response[] = [
                'checked'=>(is_null($customerSelected)) ? false : true,
                'customer_id'=>$v->customer_id,
                'customer_number'=>$v->customer_number,
                'customer_name'=>$v->customer_name,
                'region_code' => $v->region_code,
                'province_name' => $v->province_name,
                'meaning' => $v->meaning,
                'amount'=>1,
                'uom'=>'CGK',
            ];
        }
        return response()->json(['data' => $response]);
    }
    
    public function setModalCustomer()
    {
        $customers = Customer::where('customer_number','!=','""')
        ->whereRaw("lower(sales_classification_code) = 'domestic'")
        ->whereRaw("lower(status) = 'active'")
        ->orderBy('customer_number','ASC')
        ->leftJoin('ptom_customer_type_domestic', 'ptom_customer_type_domestic.customer_type', '=', 'ptom_customers.customer_type_id')
        ->select('ptom_customers.customer_id','ptom_customers.customer_number','ptom_customers.customer_name', 'ptom_customers.region_code', 'ptom_customers.province_name', 'ptom_customer_type_domestic.meaning')
        ->get();
        $response = [];

        foreach ($customers as $key => $v) {

            $response[] = [
                'checked'=>false,
                'customer_id'=>$v->customer_id,
                'customer_number'=>$v->customer_number,
                'customer_name'=>$v->customer_name,
                'region_code' => $v->region_code,
                'province_name' => $v->province_name,
                'meaning' => $v->meaning,
                'amount'=>1,
                'uom'=>'CGK',
            ];
        }
        return response()->json(['data' => $response]);
    }

    public function allUom()
    {
        $uom = UomV::where('domestic','Y')->get();
        return response()->json(['data' => $uom]);
    }

    public function searchGroupProduct($itemId)
    {
        $SequenceEcoms = SequenceEcoms::whereRaw("lower(sale_type_code) = 'domestic'")->where('item_id','like','%'.$itemId.'%')->limit(15)->get();
        return response()->json(['data' => $SequenceEcoms]);
    }

    public function searchPromotion(Request $request)
    {
        $req = $request->all()[0];
        // $response = [];
        $promotion = PromotionHeader::whereNull('deleted_at')
        ->where(function($query) use ($req) {
            if($req['code'] && $req['code'] != ''){
                $query->where('promotion_code', $req['code']);
            }

            if($req['start_date'] && $req['start_date'] != ''){
                $query->where('start_date', (dateConvertThaiEng($req['start_date'])));
            }

            if($req['end_date'] && $req['end_date'] != ''){
                $query->where('end_date', (dateConvertThaiEng($req['end_date'])));
            }

            if($req['status'] && $req['status'] != ''){
                $query->where('status', $req['status']);
            }
        })
        ->orderBy('promotion_id','DESC')
        ->get();

        foreach($promotion as $v){
            $checkEnd = true;
            if(!is_null($v->end_date)){
                if($v->end_date < date('Y-m-d')){
                    $checkEnd = false;
                }
            }

            $response[] = [
                'promotion_id'=>$v->promotion_id,
                'promotion_code'=>$v->promotion_code,
                'start_date'=>dateFormatThai($v->start_date),
                'end_date'=>(!is_null($v->end_date)) ? dateFormatThai($v->end_date) : null,
                'fix_data'=>($v->start_date < date('Y-m-d') && $checkEnd) ? true : false,
                'status'=>$v->status,
            ];
        }

        return response()->json(['data' =>$response]);
    }
    public function search(Request $request)
    {
        $req = $request->all()[0];
        $response = [];
        $response['header'] = PromotionHeader::where('promotion_code',$req['code'])->whereNull('deleted_at')->orderBy('promotion_id','desc')->first();

        $checkEnd = false;
        if(!is_null($response['header']->end_date)){
            if($response['header']->end_date < date('Y-m-d')){
                $checkEnd = true;
            }
        }


        $response['header']->fix_data = ($response['header']->start_date < date('Y-m-d') && $checkEnd) ? true : false;
        $response['header']->start_date = dateFormatThai(date("Y-m-d", strtotime($response['header']->start_date)));
        $response['header']->end_date = (!is_null($response['header']->end_date)) ? dateFormatThai(date("Y-m-d", strtotime($response['header']->end_date))) : null;


        $promotionId = $response['header']->promotion_id;

        $response['group'] = [];
        $group = PromotionProductGroup::where('promotion_id',$promotionId)->whereNull('deleted_at')->get();
        foreach($group as $v){
            $response['group'][] = [
                'selected'=>0,
                'group'=>$v->product_group,
                'item_id'=>$v->item_id,
                'item_code'=>$v->item_code,
                'ecom_item_description'=>$v->item_description,
            ];
        }

        $response['dtl'] = [];
        $dtl = PromotionDtl::where('promotion_id',$promotionId)->whereNull('deleted_at')->get();
        foreach($dtl as $v){
            $response['dtl'][] = [
                'selected'=>0,
                'group'=>$v->sale_group,
                'group_product'=>$v->product_group,
                'order_amount'=>$v->sale_quantity,
                'order_unit'=>$v->sale_uom,
                'max_amount'=>$v->maximum_quantity,
                'max_unit'=>$v->maximum_uom,
                'condition'=>$v->condition
            ];
        }

        $response['product'] = [];
        $product = PromotionProduct::where('promotion_id',$promotionId)->whereNull('deleted_at')->get();
        foreach($product as $v){

            $response['product'][] = [
                'selected'=>0,
                'group'=>$v->support_group,
                'item_id'=>$v->item_id,
                'item_code'=>$v->item_code,
                'ecom_item_description'=>$v->item_description,
                'amount'=>$v->promotion_quantity,
                'unit'=>$v->promotion_uom
            ];
        }
        $response['customer'] = [];
        $cust = PromotionCust::where('promotion_id',$promotionId)->whereNull('deleted_at')->get();
        foreach($cust as $v){
            $customers = Customer::where('customer_id','=',$v->customer_id)->first(['customer_id','customer_number','customer_name']);
            // $response['customer'][] = $customers;
            $response['customer'][] = [
                'checked'=>true,
                'customer_id'=>$customers->customer_id,
                'customer_number'=>$customers->customer_number,
                'customer_name'=>$customers->customer_name,
                'amount'=>$v->start_promotion_qty,
                'uom'=>$v->uom_code,
            ];
        }

        $response['sysdate'] = date('Y-m-d');

        return response()->json(['data' =>$response]);
    }

    public function runNumber()
    {
        return response()->json(['data' => PromotionRepo::runNumber()]);
    }

    public function store(Request $request)
    {

        $resp = [];

        try {
            $promoHead = new PromotionHeader();
            $promoHead->promotion_code = PromotionRepo::runNumber();
            // $promoHead->promotion_code = $request->all()[0]['promotion']['number'];
            $promoHead->start_date =  date('Y-m-d',strtotime(dateConvertThaiEng($request->all()[0]['promotion']['start_date'])));
            $promoHead->all_cust_flag = ($request->all()[0]['customer_all']) ? 'Y' : 'N';
            $promoHead->end_date = (!is_null($request->all()[0]['promotion']['end_date'])) ? date('Y-m-d',strtotime(dateConvertThaiEng($request->all()[0]['promotion']['end_date']))) : '';
            $promoHead->status = $request->all()[0]['promotion']['status'];
            $promoHead->created_by = optional(auth()->user())->user_id ?? -1;
            $promoHead->last_updated_by = optional(auth()->user())->user_id ?? -1;
            $promoHead->program_code = 'OMS0003';
            $promoHead->attribute1 = $request->all()[0]['promotion']['detail'];
            $promoHead->save();

            $headerKey = $promoHead->getKey();

            foreach ($request->all()[0]['product'] as $key => $v) {
                // if($v['selected'] == 1){

                    $groupKey = PromotionRepo::updateGroup($v,$headerKey);

                    // foreach ($request->all()[0]['order'] as $key => $vp) {
                    //     if($vp['selected'] == 1 && $vp['group_product'] == $v['group']){

                    //         $dtlKey = PromotionRepo::updateDtl($vp,$headerKey,$groupKey);

                    //         foreach ($request->all()[0]['gift'] as $key => $vg) {
                    //             if($vg['selected'] == 1){
                    //                 PromotionRepo::updateProduct($vg,$headerKey,$dtlKey);
                    //             }
                    //         }
                    //     }
                    // }

                    // foreach ($request->all()[0]['customer'] as $key => $vc) {
                    //     PromotionRepo::updateCust($vc,$headerKey);
                    // }
                // }
            }

            foreach ($request->all()[0]['order'] as $key => $vp) {
                // if($vp['selected'] == 1){
                    $dtlKey = PromotionRepo::updateDtl($vp,$headerKey,0);
                // }
            }

            foreach ($request->all()[0]['gift'] as $key => $vg) {
                // if($vg['selected'] == 1){
                    PromotionRepo::updateProduct($vg,$headerKey,0);
                // }
            }


            if ($request->all()[0]['customer_all']) {
                $customers = Customer::where('customer_number','!=','""')->whereRaw("lower(sales_classification_code) = 'domestic'")->whereRaw("lower(status) = 'active'")->orderBy('customer_number','ASC')->get(['customer_id','customer_number','customer_name']);
                foreach ($customers as $key => $vc) {
                    PromotionRepo::updateCustAll($vc,$headerKey);
                }
            }else{
                foreach ($request->all()[0]['customer'] as $key => $vc) {
                    PromotionRepo::updateCust($vc,$headerKey);
                }
            }


            $resp['data'] = [
                'promotion_code' => $promoHead->promotion_code
            ];
            $resp['status'] = true;
            $resp['message'] = '';
        } catch (\Exception $e) {
            $resp['data'] = $request->all();
            $resp['status'] = false;
            $resp['message'] = $e->getMessage();
        }


        return response()->json($resp);
    }

    public function update(Request $request)
    {

        $resp = [];

        try {

            $promoHead = PromotionHeader::where('promotion_code',$request->all()[0]['promotion']['number'])->whereNull('deleted_at')->orderBy('promotion_id','desc')->first();
            $promotionId = $promoHead->promotion_id;
            $promoHead->start_date =  date('Y-m-d',strtotime(dateConvertThaiEng($request->all()[0]['promotion']['start_date'])));
            // $promoHead->end_date = date('Y-m-d',strtotime(dateConvertThaiEng($request->all()[0]['promotion']['end_date'])));
            $promoHead->end_date = (!is_null($request->all()[0]['promotion']['end_date'])) ? date('Y-m-d',strtotime(dateConvertThaiEng($request->all()[0]['promotion']['end_date']))) : '';
            $promoHead->status = $request->all()[0]['promotion']['status'];
            $promoHead->last_updated_by = optional(auth()->user())->user_id ?? -1;
            $promoHead->attribute1 = $request->all()[0]['promotion']['detail'];
            $promoHead->save();

            $headerKey = $promoHead->getKey();

            PromotionCust::where('promotion_id',$promotionId)->delete();
            PromotionProduct::where('promotion_id',$promotionId)->delete();
            PromotionDtl::where('promotion_id',$promotionId)->delete();
            PromotionProductGroup::where('promotion_id',$promotionId)->delete();

            foreach ($request->all()[0]['product'] as $key => $v) {
                // if($v['selected'] == 1){
                    $groupKey = PromotionRepo::updateGroup($v,$headerKey);

                // }
            }

            foreach ($request->all()[0]['order'] as $key => $vp) {
                // if($vp['group_product'] == $v['group']){
                    $dtlKey = PromotionRepo::updateDtl($vp,$headerKey,0);
                // }
            }

            foreach ($request->all()[0]['gift'] as $key => $vg) {
                // if($vg['selected'] == 1){
                    PromotionRepo::updateProduct($vg,$headerKey,0);
                // }
            }

            if ($request->all()[0]['customer_all']) {
                $customers = Customer::where('customer_number','!=','""')->whereRaw("lower(sales_classification_code) = 'domestic'")->whereRaw("lower(status) = 'active'")->orderBy('customer_number','ASC')->get(['customer_id','customer_number','customer_name']);
                foreach ($customers as $key => $vc) {
                    PromotionRepo::updateCustAll($vc,$headerKey);
                }
            }else{
                foreach ($request->all()[0]['customer'] as $key => $vc) {
                    PromotionRepo::updateCust($vc,$headerKey);
                }
            }
            // foreach ($request->all()[0]['customer'] as $key => $vc) {
            //     PromotionRepo::updateCust($vc,$headerKey);
            // }

            $resp['data'] = [
                'promotion_code' => $promoHead->promotion_code
            ];
            $resp['status'] = true;
            $resp['message'] = '';
        } catch (\Exception $e) {
            $resp['data'] = $request->all();
            $resp['status'] = false;
            $resp['message'] = $e->getMessage();
        }


        return response()->json($resp);
    }

    public function remove(Request $request)
    {
        $req = $request->all()[0]['promotion'];
        $promoHeader = PromotionHeader::where('promotion_code',$req['number'])->orderBy('promotion_id','desc')->first();

        $promotionId = $promoHeader->promotion_id;
        $promoHeader->deleted_at = now();
        $promoHeader->deleted_by_id = optional(auth()->user())->user_id ?? -1;
        $promoHeader->save();

        $promoGroup = PromotionProductGroup::where('promotion_id',$promotionId)->get();
        PromotionRepo::removePromotion($promoGroup);

        $promoDtl = PromotionDtl::where('promotion_id',$promotionId)->get();
        PromotionRepo::removePromotion($promoDtl);

        $promoProduct = PromotionProduct::where('promotion_id',$promotionId)->get();
        PromotionRepo::removePromotion($promoProduct);

        $promoCust = PromotionCust::where('promotion_id',$promotionId)->get();
        PromotionRepo::removePromotion($promoCust);

        return response()->json(['status'=>true,'data' => []]);
    }

    public function copyPromotion(Request $request)
    {
        // copy header
        $promoHead = PromotionHeader::where('promotion_code',$request->all()[0]['promotion']['number'])->whereNull('deleted_at')->orderBy('promotion_id','desc')->first()->toArray();
        $promoHeadCopy = new PromotionHeader();
        foreach ($promoHead as $key => $v) {
            if($key != 'promotion_id'){
                $resp[] = $v;
                if ($key == 'promotion_code') {
                    $promoHeadCopy[$key] = PromotionRepo::runNumber();
                }else{
                    $promoHeadCopy[$key] = $v;
                }
            }
        }
        $promoHeadCopy->save();
        $headerKey = $promoHeadCopy->getKey();

        // copy group
        $promoGroup = PromotionProductGroup::where('promotion_id',$promoHead['promotion_id'])->get()->toArray();

        for ($i=0; $i < count($promoGroup); $i++) {
            $promoGroupCopy = new PromotionProductGroup();
            foreach ($promoGroup[$i] as $key => $v) {
                if($key != 'promotion_product_group_id'){
                    $resp[$i] = $v;
                    if ($key == 'promotion_id') {
                        $promoGroupCopy[$key] = $headerKey;
                    }else{
                        $promoGroupCopy[$key] = $v;
                    }
                }
            }
            $promoGroupCopy->save();
            $groupKey = $promoGroupCopy->getKey();

            // copy dtl
            $promoDtl = PromotionDtl::where('promotion_id',$promoHead['promotion_id'])->where('promotion_product_group_id',$promoGroup[$i]['promotion_product_group_id'])->get()->toArray();
            for ($j=0; $j < count($promoDtl); $j++) {
                $promoDtlCopy = new PromotionDtl();
                foreach ($promoDtl[$j] as $key => $v) {
                    if($key != 'promotion_dtl_id'){
                        $resp[$j] = $v;
                        if ($key == 'promotion_id') {
                            $promoDtlCopy[$key] = $headerKey;
                        }elseif($key == 'promotion_product_group_id'){
                            $promoDtlCopy[$key] = $groupKey;
                        }else{
                            $promoDtlCopy[$key] = $v;
                        }
                    }
                }
                $promoDtlCopy->save();
                $dtlKey = $promoDtlCopy->getKey();

                $promoProduct = PromotionProduct::where('promotion_id',$promoHead['promotion_id'])->where('promotion_dtl_id',$promoDtl[$j]['promotion_dtl_id'])->get()->toArray();
                for ($k=0; $k < count($promoProduct); $k++) {
                    $promoProductCopy = new PromotionProduct();
                    foreach ($promoProduct[$k] as $key => $v) {
                        if($key != 'promotion_product_id'){
                            $resp[$k] = $v;
                            if ($key == 'promotion_id') {
                                $promoProductCopy[$key] = $headerKey;
                            }elseif($key == 'promotion_dtl_id'){
                                $promoProductCopy[$key] = $dtlKey;
                            }else{
                                $promoProductCopy[$key] = $v;
                            }
                        }
                    }
                    $promoProductCopy->save();
                }
            }
        }

        // copy cust
        $promoCust = PromotionCust::where('promotion_id',$promoHead['promotion_id'])->get()->toArray();
        for ($i=0; $i < count($promoCust); $i++) {
            $promoCustCopy = new PromotionCust();
            foreach ($promoCust[$i] as $key => $v) {
                if($key != 'promotion_cust_id'){
                    $resp[$i] = $v;
                    if ($key == 'promotion_id') {
                        $promoCustCopy[$key] = $headerKey;
                    }else{
                        $promoCustCopy[$key] = $v;
                    }
                }
            }
            $promoCustCopy->save();
        }

        return response()->json(['status'=>true,'data' => $promoHeadCopy]);
    }

}