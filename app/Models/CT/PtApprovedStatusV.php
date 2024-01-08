<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtApprovedStatusV extends Model
{
    use HasFactory;
    protected $table = 'PT_APPROVED_STATUS_V';
    public $timestamps = false;

    protected $guarded = [];

    public function scopeGetStatuses($query)
    {
        return $query->where('enabled_flag','Y');
    }
}
