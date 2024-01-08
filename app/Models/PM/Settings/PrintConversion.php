<?php

namespace App\Models\PM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Arr;

class PrintConversion extends Model
{
    use HasFactory;

    protected $table = "ptpm_print_conversion";
    
    protected $primaryKey = false;
    public $timestamps = false;
    public $incrementing = false;

    public function lookupValues()
    {
        return $this->hasMany(LookupValues::class, 'lookup_code', 'tobacco_size')
                    ->where('lookup_type', 'PTPP_PRODUCT_TYPES');
    }

    public function scopeSearch($q, $request)
    {    
        if ($request){
            if ($request['printItemCat'] != null) {
                $q->where('cost_category_segment1', $request['printItemCat'])
                  ->get();
            } else {
                $q;
            }

            if ($request['category'] != null) {
                $segment = explode('.', $request['category']);
                $segment1 = Arr::get($segment, '0');
                $segment2 = Arr::get($segment, '1');
                $q->where('category_segment1', $segment1)
                  ->where('category_segment2', $segment2)
                  ->get();
            } else {
                $q;
            }

            if ($request['tobaccoSize'] != null) {
                $q->where('tobacco_size', $request['tobaccoSize'])->get();
            } else {
                $q;
            }
        }
        return $q;
    }
}
