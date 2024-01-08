<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OM\Api\OrderLines;

class ConsignmentHeader extends Model
{
    // use HasFactory;
    protected $table = "PTOM_CONSIGNMENT_HEADERS";
    public $primaryKey = "CONSIGNMENT_HEADER_ID";
    public $timestamps = false;

    protected $dates = ['creation_date', 'last_updated_date'];
    protected $guarded = [];

    public function orderamounts()
    {
        return $this->hasMany(OrderLines::class, 'order_header_id', 'order_header_id')->selectRaw("SUM(ptom_order_lines.total_amount) as total_amount");
    }

    public function producttype()
    {
        return $this->hasOne(OrderHeaders::class, 'order_header_id', 'order_header_id');
    }

}
