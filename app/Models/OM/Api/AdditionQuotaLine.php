<?php

namespace App\Models\OM\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionQuotaLine extends Model
{
    use HasFactory;

    protected $table = 'ptom_addition_quota_lines';
    public $primaryKey = 'quota_line_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_updated_date'];
    protected $guarded = [];
}
