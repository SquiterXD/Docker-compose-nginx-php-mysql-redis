<?php

namespace App\Models\OM\Saleorder\Domestic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerQuotaLineModel extends Model
{
    use HasFactory;
    protected $table = 'ptom_customer_quota_lines';
    public $primaryKey = 'quota_line_id';
    public $timestamps = false;

    protected $fillable = [
        'quota_header_id',
        'item_id',
        'item_code',
        'item_description',
        'received_quota',
        'minimum_quota',
        'remaining_quota',
        'program_code',
        'created_by',
        'creation_date',
        'last_updated_by',
        'last_update_date',
    ];
}
