<?php

namespace App\Models\OM\Customers\Domestics;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DayModel extends Model
{
    use HasFactory;

    protected $table = "PTOM_DAY";
    public $primaryKey = '';
    public $timestamps = false;

    public function getOMPDays($request, $number, $customer, $periodId)
    {
        // -------- piyawut A. 20012022
        $addCondition = '';
        $deliveryDate = $request->delivery_date == 'all'? '': $request->delivery_date;
        if($request->order_number){
            $addCondition .= "and oh.order_number like '%{$request->order_number}%'";
        }

        if($request->payment && $request->payment != 'all'){
            $addCondition .= " and oh.payment_type_code = '{$request->payment}'";
        }

        if($request->status && $request->status != 'all' && $request->status != ''){
            $addCondition .= " and lower(h.order_status) = '{$request->status}'";
        }

        if($request->period_id && $request->period_id != 'all'){
            // $addCondition .= " and h.period_id = '{$request->period_id}'";
            $addCondition .= " and oh.period_id = '{$request->period_id}'";
        }else{
            // $addCondition .= " and h.period_id = '{$periodId}'";
            $addCondition .= " and oh.period_id = '{$periodId}'";
        }

        // if($request->delivery_date){
        //     $addCondition .= " and nvl(c.delivery_date,'-$$$') like '%{$deliveryDate}%'";
        // }

        if ($customer != null || $customer != '') {
            if($number != '0'){
                $addCondition .= " and oh.customer_id = '{$customer->customer_id}'";
            }
        }

        $sql = "
            SELECT
                d.lookup_code
                , c.delivery_date
                , count(c.delivery_date) as delivery_number
                , h.order_status
                , h.period_id
                , h.order_history_id
                , h.order_header_id
            FROM ptom_order_headers oh
                , ptom_customers c
                , ptom_order_history h
                , ptom_day d
            WHERE 1=1
            AND d.meaning = c.delivery_date
            AND c.sales_classification_code = 'Domestic'
            AND oh.customer_id = c.customer_id
            AND oh.order_header_id = h.order_header_id
            AND oh.order_number = h.order_number
            AND h.deleted_at is null
            AND oh.deleted_at is null
            AND oh.program_code <> 'OMP0020'
            AND h.order_history_id = (select max(h2.order_history_id)
                                        from PTOM_ORDER_HISTORY h2
                                        where 1=1
                                        and h2.order_header_id = h.order_header_id
                                    )
            AND d.enabled_flag = 'Y'
            ". $addCondition ."
            GROUP BY d.lookup_code
                , c.delivery_date
                , h.order_status
                , h.period_id
                , h.order_history_id
                , h.order_header_id
            ORDER BY d.lookup_code
                , h.order_history_id
                , h.order_header_id
        ";

        $result = \DB::select(\DB::raw($sql));
        return $result;

    }

    public function scopeCheckDayByCustomer($q, $number = 0)
    {
        if ($number != '0') {
            return $q->whereNotIn('lookup_code', ['55', '56', '60']);
        }
        return $q->whereNotIn('lookup_code', ['55', '56']);
    }
}
