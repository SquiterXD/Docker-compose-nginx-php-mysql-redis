<?php

namespace App\Models\OM\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionQuotaHeader extends Model
{
    use HasFactory;

    protected $table = 'ptom_addition_quota_headers';
    public $primaryKey = 'quota_header_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_updated_date'];
    protected $guarded = [];
}
