<?php

namespace App\Models\QM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtqmQmr0010V extends Model
{
    use HasFactory;

    protected $table  = 'PTQM_QMR0010_V';

    public function scopeSearch($query, $keywords)
    {
        
        // machine_set
        if (array_key_exists("machine_set", $keywords)) {
            if ($keywords['machine_set']) {
                $query->where('machine_set', $keywords['machine_set']);
            }
        }

        // brand_value
        if (array_key_exists("brand_value", $keywords)) {
            if ($keywords['brand_value']) {
                $query->where('brand_value', $keywords['brand_value']);
            }
        }

        // sample_date_from
        if (array_key_exists("sample_date_from", $keywords)) {
            if ($keywords['sample_date_from']) {
                $query->where('date_drawn', '>=', parseFromDateTh($keywords['sample_date_from'])." 00:00:00");
            }
        }
        // sample_date_to
        if (array_key_exists("sample_date_to", $keywords)) {
            if ($keywords['sample_date_to']) {
                $query->where('date_drawn', '<=', parseFromDateTh($keywords['sample_date_to'])." 23:59:59");
            }
        }
        
        return $query;
    }

    public function scopeGetListBrandValues($query)
    {
        return $query->select('brand_value')
        ->groupBy('brand_value')
        ->orderBy('brand_value');
    }

}
