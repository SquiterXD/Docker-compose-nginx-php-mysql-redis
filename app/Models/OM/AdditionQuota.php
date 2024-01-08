<?php

namespace App\Models\OM;

use App\Models\OM\Api\OrderHeader;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AdditionQuota extends Model
{
    use HasFactory;

    protected $table = 'ptom_addition_quota_headers';
    public $primaryKey = 'quota_header_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_updated_date'];
    protected $guarded = [];

    public function files()
    {
        return $this->hasMany(AttachFiles::class, 'header_id', 'quota_header_id');
    }
}
