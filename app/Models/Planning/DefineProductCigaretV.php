<?php

namespace App\Models\Planning;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefineProductCigaretV extends Model
{
    use HasFactory;
    protected $table = 'ptpp_define_product_cigaret_v';

    public function scopeActive($q)
    {
        $q->where('enabled_flag', 'Y');
        return $q;
    }
}
