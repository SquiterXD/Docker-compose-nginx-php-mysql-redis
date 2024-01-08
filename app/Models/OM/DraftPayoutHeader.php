<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DraftPayoutHeader extends Model
{
    use HasFactory;

    protected $table = 'ptom_order_headers';
    public $primaryKey = 'order_header_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_updated_date'];
    protected $guarded = [];
    protected $with = ['customers', 'orderlines', 'ordertype'];

    public function customers()
    {
        return $this->hasOne(Customers::class, 'customer_id', 'customer_id');
    }

    public function orderlines()
    {
        return $this->hasMany(DraftPayoutLine::class, 'order_header_id', 'order_header_id');
    }

    public function ordertype()
    {
        return $this->hasOne(OrderType::class, 'order_type_id', 'order_type_id');
    }

    public function scopeStatusnotconfirm($query)
    {
        return $query->where('ptom_order_headers.order_status', '!=', 'Draft');
    }

    public function scopeDomestic($query)
    {
        return $query->where('ptom_customers.sales_classification_code', 'Domestic');
    }
}
