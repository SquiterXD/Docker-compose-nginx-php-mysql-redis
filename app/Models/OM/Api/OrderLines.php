<?php

namespace App\Models\OM\Api;

use App\Events\OrderLinesDeleted;
use App\Events\OrderLinesSaved;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class OrderLines extends Model
{
    use HasFactory;
    protected $table = 'PTOM_ORDER_LINES';
    public $primaryKey = 'order_line_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_updated_date'];
    protected $guarded = [];

    public function consignmentLines()
    {
        return $this->hasMany('App\Models\OM\ConsignmentLines', 'order_line_id', 'order_line_id');
    }

    public function header()
    {
        return $this->hasOne('App\Models\OM\Api\OrderHeader', 'order_header_id', 'order_header_id');
    }

    public function seqEcom()
    {
        return $this->hasOne('App\Models\OM\SequenceEcoms', 'item_id', 'item_id')->where('sale_type_code', 'DOMESTIC');
    }

    public function getRemainQtyAttribute()
    {
        $use = $this->consignmentLines()->whereHas('header', function($q) {
            return $q->where('consignment_status', 'Confirm')->success();
        })->sum('actual_quantity');
        return $this->approve_quantity - $use;
    }

    public function onHands()
    {
        return $this->hasMany('App\Models\OM\OnHandV', 'item_code', 'item_code')->orderBy('lot_number');
    }

    public function issues()
    {
        return $this->morphMany('App\Models\OM\IssueStockLines', 'issueable');
    }

    
    protected $dispatchesEvents = [
        'created' => OrderLinesSaved::class,
        'deleted' => OrderLinesDeleted::class,
    ];
}
