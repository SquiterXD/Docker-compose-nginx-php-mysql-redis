<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class PtctCtr0037 extends Model
{
    use HasFactory;

    public function getCigaretteHeader($endDate)
    {
        $results = collect(DB::select(
            " select distinct pse.item_code
                , pse.ecom_item_description
            from ptom_order_headers       poh
                , ptom_order_lines         pol
                , ptom_customers           pc
                , ptom_sequence_ecoms      pse
            where 1=1
            and poh.order_header_id         = pol.order_header_id 
            and poh.customer_id             = pc.customer_id
            and pc.customer_type_id         in ('30','40')
            and upper(pick_release_status)  = 'CONFIRM'
            and poh.product_type_code       = '10'
            and pol.item_id                 = pse.item_id
            and trunc(poh.pick_release_approve_date) <=  to_date('{$endDate}','DD-MON-YYYY')
            order by item_code"
        ));

        return $results;
    }

    public function getCigaretteDetail($endDate)
    {
        $results = collect(DB::select(
            " select pc.customer_type_id 
                , pse.item_code
                , pse.ecom_item_description
                , sum(approve_quantity) approve_quantity
                , actual_quantity
                , (sum(approve_quantity)   - actual_quantity) sum_actual_quantity
            from ptom_order_headers       poh
                , ptom_order_lines         pol
                , ptom_customers           pc
                , ptom_sequence_ecoms      pse
                , (select pc.customer_type_id 
                    , pse.item_code
                    , pse.ecom_item_description
                    , sum(actual_quantity) actual_quantity
                from ptom_consignment_headers pch
                    , ptom_consignment_lines   pcl
                    , ptom_customers           pc
                    , ptom_sequence_ecoms      pse
                where pch.consignment_header_id   = pcl.consignment_header_id
                and pch.customer_id               = pc.customer_id 
                and pc.customer_type_id           in ('30','40')
                and upper(pch.consignment_status) = 'CONFIRM'
                and pcl.item_id                   = pse.item_id
                and trunc(pch.consignment_date)   <= to_date('{$endDate}','DD-MON-YYYY')
                group by pse.item_code
                        , pse.ecom_item_description
                        , pc.customer_type_id
                order by pse.item_code,pc.customer_type_id
            ) pch
            where 1=1
            and poh.order_header_id         = pol.order_header_id 
            and poh.customer_id             = pc.customer_id
            and pc.customer_type_id         in ('30','40')
            and upper(pick_release_status)  = 'CONFIRM'
            and poh.product_type_code       = '10'
            and pol.item_id                 = pse.item_id
            and trunc(poh.pick_release_approve_date) <=  to_date('{$endDate}','DD-MON-YYYY')
            and pch.item_code    = pol.item_code
            and pc.customer_type_id  = pch.customer_type_id 
            group by pc.customer_type_id 
                    , pse.item_code
                    , pse.ecom_item_description
                    , actual_quantity
            order by item_code,pc.customer_type_id"
        ));

        return $results;
    }

}
