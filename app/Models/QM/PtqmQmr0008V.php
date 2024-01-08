<?php

namespace App\Models\QM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtqmQmr0008V extends Model
{
    use HasFactory;

    protected $table  = 'PTQM_QMR0008_V';

    public function scopeSearch($query, $keywords)
    {
        
        // machine_set
        if (array_key_exists("machine_set", $keywords)) {
            if ($keywords['machine_set']) {
                $query->where('machine_set', $keywords['machine_set']);
            }
        }

        // qm_process
        if (array_key_exists("qm_process", $keywords)) {
            if ($keywords['qm_process']) {
                $query->where('qm_process', $keywords['qm_process']);
            }
        }

        // check_list
        if (array_key_exists("check_list", $keywords)) {
            if ($keywords['check_list']) {
                $query->where('check_list', $keywords['check_list']);
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
