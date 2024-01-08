<?php

namespace App\Models\OM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApproverOrder extends Model
{
    use HasFactory;

    protected $table = 'ptom_approver_orders';
    protected $primaryKey = 'approver_order_id';

    public function authoRity()
    {
        return $this->belongsTo(AuthoRityList::class, 'authority_id', 'authority_id');
    }
}
