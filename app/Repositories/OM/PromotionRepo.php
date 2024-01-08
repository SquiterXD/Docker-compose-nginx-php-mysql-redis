<?php

namespace App\Repositories\OM;

use App\Models\OM\Promotions\PromotionHeader;
use App\Models\OM\Promotions\PromotionProductGroup;
use App\Models\OM\Promotions\PromotionDtl;
use App\Models\OM\Promotions\PromotionProduct;
use App\Models\OM\Promotions\PromotionCust;
use App\Models\OM\Promotions\UomV;

class PromotionRepo
{
    public static function runNumber()
    {

        try {
            $number = PromotionHeader::whereNotNull('promotion_code')->where('promotion_code', 'LIKE', "%P%")->orderBy('promotion_id','desc')->first()->promotion_code;

            $last_number = explode('P', $number);
            if (is_numeric($last_number[1])) {
                $newnumber = sprintf('%04d', $last_number[1] + 1);
            } else {
                $newnumber = sprintf('%04d', 1);
            }
        } catch (\Exception $e) {
            $newnumber = sprintf('%04d', 1);
        }

        return 'P'.$newnumber;

    }

    public static function updateGroup($data,$headerKey)
    {
        $promoGroup = new PromotionProductGroup();
        $promoGroup->promotion_id = $headerKey;
        $promoGroup->product_group = $data['group'];
        $promoGroup->item_id = $data['item_id'];
        $promoGroup->item_code = $data['item_code'];
        $promoGroup->item_description = $data['ecom_item_description'];
        $promoGroup->created_by = optional(auth()->user())->user_id ?? -1;
        $promoGroup->last_updated_by = optional(auth()->user())->user_id ?? -1;
        $promoGroup->program_code = 'OMS0003';
        $promoGroup->save();

        return $promoGroup->getKey();
    }

    public static function updateDtl($data,$headerKey,$groupKey)
    {
        $uom_sale = UomV::where('uom_code',$data['order_unit'])->first();
        $uom_max = UomV::where('uom_code',$data['max_unit'])->first();

        $promoDtl = new PromotionDtl();
        $promoDtl->promotion_product_group_id = '';
        $promoDtl->promotion_id = $headerKey;
        $promoDtl->sale_group = $data['group'];
        $promoDtl->product_group = $data['group_product'];
        $promoDtl->sale_quantity = $data['order_amount'];
        $promoDtl->sale_uom = $uom_sale->uom_code;
        $promoDtl->sale_uom_desc = $uom_sale->unit_of_measure;
        $promoDtl->maximum_quantity = $data['max_amount'];
        $promoDtl->maximum_uom = $uom_max->uom_code;
        $promoDtl->maximum_uom_desc = $uom_max->unit_of_measure;
        $promoDtl->condition = $data['condition'];
        $promoDtl->created_by = optional(auth()->user())->user_id ?? -1;
        $promoDtl->last_updated_by = optional(auth()->user())->user_id ?? -1;
        $promoDtl->program_code = 'OMS0003';
        $promoDtl->save();

        return $promoDtl->getKey();
    }

    public static function updateProduct($data,$headerKey,$dtlKey)
    {
        $uom = UomV::where('uom_code',$data['unit'])->first();

        $promoProduct = new PromotionProduct();
        $promoProduct->promotion_dtl_id = $dtlKey;
        $promoProduct->promotion_id = $headerKey;
        $promoProduct->support_group = $data['group'];
        $promoProduct->item_id = $data['item_id'];
        $promoProduct->item_code = $data['item_code'];
        $promoProduct->item_description = $data['ecom_item_description'];
        $promoProduct->promotion_quantity = $data['amount'];
        $promoProduct->promotion_uom = $uom->uom_code;
        $promoProduct->promotion_uom_desc = $uom->unit_of_measure;
        $promoProduct->created_by = optional(auth()->user())->user_id ?? -1;
        $promoProduct->last_updated_by = optional(auth()->user())->user_id ?? -1;
        $promoProduct->program_code = 'OMS0003';
        $promoProduct->save();
        return true;
    }

    public static function updateCust($data,$headerKey)
    {
        $uom = UomV::where('uom_code',$data['uom'])->first();

        $promoCust = new PromotionCust();
        $promoCust->promotion_id = $headerKey;
        $promoCust->customer_id = $data['customer_id'];
        $promoCust->customer_number = $data['customer_number'];
        $promoCust->customer_name = $data['customer_name'];
        $promoCust->start_promotion_qty = $data['amount'];
        $promoCust->uom_code = $data['uom'];
        $promoCust->uom = $uom->unit_of_measure;
        $promoCust->created_by = optional(auth()->user())->user_id ?? -1;
        $promoCust->last_updated_by = optional(auth()->user())->user_id ?? -1;
        $promoCust->program_code = 'OMS0003';
        $promoCust->save();
        return true;

    }

    public static function updateCustAll($customer,$headerKey)
    {
        $uom = UomV::where('uom_code','CGK')->first();

        $promoCust = new PromotionCust();
        $promoCust->promotion_id = $headerKey;
        $promoCust->customer_id = $customer->customer_id;
        $promoCust->customer_number = $customer->customer_number;
        $promoCust->customer_name = $customer->customer_name;
        $promoCust->start_promotion_qty = 1;
        $promoCust->uom_code = 'CGK';
        $promoCust->uom = $uom->unit_of_measure;
        $promoCust->created_by = optional(auth()->user())->user_id ?? -1;
        $promoCust->last_updated_by = optional(auth()->user())->user_id ?? -1;
        $promoCust->program_code = 'OMS0003';
        $promoCust->save();
        return true;

    }

    public static function removePromotion($data)
    {
        foreach($data as $v){
            $v->deleted_at = now();
            $v->deleted_by_id = optional(auth()->user())->user_id ?? -1;
            $v->save();
        }
    }

}