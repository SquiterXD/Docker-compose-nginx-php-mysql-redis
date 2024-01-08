<?php

namespace App\Models\QM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtqmBrandCigaretteV extends Model
{
    use HasFactory;

    protected $table  = 'PTQM_BRAND_CIGARETTES_V';

    public function scopeGetListBrandCigarettes($query)
    {
        return $query->select('description')
        ->groupBy('description')
        ->orderBy('description');
    }

}
