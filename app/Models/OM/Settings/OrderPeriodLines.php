<?php

namespace App\Models\OM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPeriodLines extends Model
{
    use HasFactory;

    protected $table      = 'ptom_order_period_lines';
    protected $primaryKey = 'period_line_id';

    public function orderPeriodHeader()
    {
        return $this->belongsTo(OrderPeriodHeaders::class, 'period_id', 'period_id');
    }
}
