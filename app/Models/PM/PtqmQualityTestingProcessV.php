<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtqmQualityTestingProcessV extends Model
{
    use HasFactory;
    protected $table  = 'ptqm_quality_testing_process_v';

    public function scopeActive($q)
    {
        $q->where('enabled_flag', 'Y');
        return $q;
    }
}
