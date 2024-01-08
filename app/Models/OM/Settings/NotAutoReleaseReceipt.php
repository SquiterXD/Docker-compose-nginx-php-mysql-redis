<?php

namespace App\Models\OM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotAutoReleaseReceipt extends Model
{
    use HasFactory;

    protected $table = 'ptom_not_auto_release_receipts';
    protected $primaryKey = 'release_id';

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }
}
