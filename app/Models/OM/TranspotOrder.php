<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TranspotOrder extends Model
{
    use HasFactory;

    protected $table = 'ptom_order_lines';
    public $primaryKey = 'order_line_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_updated_date'];
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_updated_date';

    public function scopeJoinstable($query)
    {
        return $query->leftJoin('ptom_order_headers', 'ptom_order_lines.order_header_id', '=', 'ptom_order_headers.order_header_id')->leftJoin('ptom_shipment_by', 'ptom_order_headers.transport_type_code', '=', 'ptom_shipment_by.lookup_code')->leftJoin('ptom_customers', 'ptom_order_headers.customer_id', '=', 'ptom_customers.customer_id')->leftJoin('ptom_thailand_territory_v', 'ptom_customers.province_code', '=', 'ptom_thailand_territory_v.province_id')->leftJoin('ptom_product_type_domestic', 'ptom_order_headers.product_type_code', '=', 'ptom_product_type_domestic.lookup_code');
    }

    public function scopeNormal($query, $start, $end)
    {
        return $query->where('ptom_shipment_by.meaning', '\'บริษัทขนส่ง\'')->where('ptom_shipment_by.tag', '\'D\'')->whereNotNull('ptom_order_headers.pick_release_no')->whereNotNull('ptom_order_headers.pick_release_approve_date')->whereNotNull('ptom_order_headers.currency')->whereNotNull('ptom_order_lines.approve_quantity')->whereNull('ptom_order_lines.promotion_product_id')->whereRaw("ptom_order_headers.pick_release_approve_date between date '" . $start . "' and date '" . $end . "'");
    }

    public function scopePromotion($query, $start, $end)
    {
        return $query->where('ptom_shipment_by.meaning', '\'บริษัทขนส่ง\'')->where('ptom_shipment_by.tag', '\'D\'')->whereNotNull('ptom_order_headers.pick_release_no')->whereNotNull('ptom_order_headers.pick_release_approve_date')->whereNotNull('ptom_order_headers.currency')->whereNotNull('ptom_order_lines.approve_quantity')->whereNotNull('ptom_order_lines.promotion_product_id')->whereRaw("ptom_order_headers.pick_release_approve_date between date '" . $start . "' and date '" . $end . "'");
    }

    public function scopeGrouptable($query)
    {
        return $query->groupBy(['ptom_order_lines.promo_flag', 'ptom_order_headers.grand_total', 'ptom_customers.customer_id', 'ptom_order_headers.pick_release_no', 'ptom_order_headers.pick_release_status', 'ptom_order_headers.currency', 'ptom_order_headers.order_date', 'ptom_order_headers.pick_release_approve_date', 'ptom_order_lines.vat_code', 'ptom_thailand_territory_v.province_thai', 'ptom_thailand_territory_v.region_thai', 'ptom_thailand_territory_v.region_id', 'ptom_product_type_domestic.lookup_code', 'ptom_product_type_domestic.meaning', 'ptom_order_headers.close_sale_flag']);
    }

    public function scopeGetsdata($query)
    {
        return $query->get(['ptom_order_lines.promo_flag', 'ptom_order_headers.grand_total', 'ptom_customers.customer_id', 'ptom_order_headers.pick_release_no', 'ptom_order_headers.pick_release_status', 'ptom_order_headers.currency', 'ptom_order_headers.order_date', 'ptom_order_headers.pick_release_approve_date', 'ptom_order_lines.vat_code', 'ptom_thailand_territory_v.province_thai', 'ptom_thailand_territory_v.region_thai', 'ptom_thailand_territory_v.region_id', 'ptom_product_type_domestic.lookup_code', 'ptom_product_type_domestic.meaning', 'ptom_order_headers.close_sale_flag', DB::raw('sum(distinct ptom_order_lines.approve_quantity) as approve_quantity'), DB::raw('sum(distinct ptom_order_lines.total_amount) total_amount')]);
    }
}
