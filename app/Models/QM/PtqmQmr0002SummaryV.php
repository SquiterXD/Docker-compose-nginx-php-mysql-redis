<?php

namespace App\Models\QM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtqmQmr0002SummaryV extends Model
{
    use HasFactory;

    protected $table  = 'PTQM_QMR0002_SUMMARY_V';

    public function scopeSearch($query, $keywords)
    {

        // qc_area
        if (array_key_exists("qc_area", $keywords)) {
            if ($keywords['qc_area']) {
                $query->where('qc_area', $keywords['qc_area']);
            }
        }
        
        // machine_set
        if (array_key_exists("machine_set", $keywords)) {
            if ($keywords['machine_set']) {
                $query->where('machine_set', $keywords['machine_set']);
            }
        }

        // brand
        if (array_key_exists("brand", $keywords)) {
            if ($keywords['brand']) {
                $query->where('brand', $keywords['brand']);
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

}
