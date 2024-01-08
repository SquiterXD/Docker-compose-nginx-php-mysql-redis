<?php

namespace App\Models\OM\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class OrderHeader extends Model
{
    use HasFactory;
    protected $table = 'PTOM_ORDER_HEADERS';
    public $primaryKey = 'order_header_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_updated_date'];

    public static function getLastOrderNumber()
    {
        $number = self::whereNotNull('order_number')
                    ->where('order_number', 'LIKE', "%POC%")
                    ->orderBy('order_header_id','desc')
                    ->first()
                    ->order_number;

        return $number;
    }

    public function orderlines()
    {
        return $this->hasMany(OrderLines::class, 'order_header_id', 'order_header_id');
    }

    public function lines()
    {
        return $this->hasMany('App\Models\OM\Api\OrderLines', 'order_header_id', 'order_header_id')->orderBy('order_line_id');
    }

    public function customer()
    {
        return $this->hasOne('App\Models\OM\Customers', 'customer_id', 'customer_id');
    }

    public function billTo()
    {
        return $this->hasOne('App\Models\OM\Customers', 'bill_to_site_id', 'bill_to_site_id');
    }

    public function shipTo()
    {
        return $this->hasOne('App\Models\OM\Customers\Domestics\CustomerShipSites', 'ship_to_site_id', 'ship_to_site_id');
    }

    public function consignments()
    {
        return $this->hasMany('App\Models\OM\Consignment', 'order_header_id', 'order_header_id')->success();
    }

    public function transactionType()
    {
        return $this->hasOne('App\Models\OM\TransactionTypeAllV', 'order_type_id', 'order_type_id');
    }

    public function getTotalApproveQty()
    {
        $lines = $this->lines()->whereNull('promo_flag')->get();
        return $lines ? $lines->sum('approve_quantity') : 0;
    }

    public function getTotalApproveQtyCGK()
    {
        $lines = $this->lines()->whereNull('promo_flag')->get();
        $qty_cgk = 0;
        foreach($lines as $line) {
            $qty_cgk += (float)convertUom($line->item_id, $line->approve_quantity, $line->uom_code, 'CGK');
        }
        return $qty_cgk;
    }

    public function getTotalActualQty()
    {
        $sum = 0;
        $consignments = $this->consignments()->confirm()->get();

        foreach ($consignments as $index => $consignment) {
            $lines = $consignment->lines()->get();
            $sum += $lines ? $lines->sum('actual_quantity') : 0;
        }

        return $sum;
    }

    public function issues()
    {
        return $this->morphMany('App\Models\OM\IssueStockHeaders', 'issueable');
    }
}