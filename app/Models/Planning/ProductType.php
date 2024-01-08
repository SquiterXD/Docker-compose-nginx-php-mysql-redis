<?php

namespace App\Models\Planning;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    use HasFactory;
    protected $table = "ptpp_product_types_v";

    public function scopeActive($q)
    {
        $q->where('enabled_flag', 'Y')
            ->whereIn('attribute4', ['Domestic', 'Filter']); // Add New Condition 29092022
        return $q;
    }
}
