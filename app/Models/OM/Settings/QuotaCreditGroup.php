<?php

namespace App\Models\OM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotaCreditGroup extends Model
{
    use HasFactory;

    protected $table = 'ptom_quota_and_credit_group';
    protected $primaryKey = 'quota_credit_id';

    public function item()
    {
        return $this->belongsTo(SalesTypeV::class, 'item_id', 'inventory_item_id');
    }

    public function quotaGroup()
    {
        return $this->belongsTo(QuotaGroup::class, 'quota_group_code', 'lookup_code');
    }

    public function creditGroup()
    {
        return $this->belongsTo(CreditGroup::class, 'credit_group_code', 'lookup_code');
    }
}
