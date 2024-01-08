<?php

namespace App\Models\OM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPeriodHeaders extends Model
{
    use HasFactory;

    protected $table      = 'ptom_order_period_headers';
    protected $primaryKey = 'period_id';

    public function orderPeriodLines()
    {
        return $this->hasMany(OrderPeriodLines::class, 'period_id', 'period_id');
    }
}
