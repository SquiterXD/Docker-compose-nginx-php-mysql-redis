<?php

namespace App\Models\OM\Saleorder\Domestic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerQuotaHeaderModel extends Model
{
    use HasFactory;
    protected $table = 'ptom_customer_quota_headers';
    public $primaryKey = 'quota_header_id';
    public $timestamps = false;

    protected $fillable = [
        'customer_id',
        'quota_number',
        'start_date',
        'end_date',
        'status',
        'program_code',
        'created_by',
        'creation_date',
        'last_updated_by',
        'last_update_date',
    ];
}
