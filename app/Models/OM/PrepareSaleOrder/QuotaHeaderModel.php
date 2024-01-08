<?php

namespace App\Models\OM\PrepareSaleOrder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotaHeaderModel extends Model
{
    use HasFactory;
    protected $table = 'ptom_customer_quota_headers';
}
