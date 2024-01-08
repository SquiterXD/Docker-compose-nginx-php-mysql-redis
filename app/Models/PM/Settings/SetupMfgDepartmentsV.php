<?php

namespace App\Models\PM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetupMfgDepartmentsV extends Model
{
    use HasFactory;

    protected $table = 'ptpm_setup_mfg_departments_v';
    public $primaryKey = 'id';
    public $timestamps = false;

    public function scopeSearch($q, $request)
    {    
        if ($request){
            
            if ($request['wipTransaction'] != null) {
                $q->where('wip_transaction_type_id', $request['wipTransaction'])->get();
            } else {
                $q;
            }

            if ($request['itemcat'] != null) {
                $q->where('tobacco_group_code', $request['itemcat'])->get();
            } else {
                $q;
            }

            if ($request['transaction'] != null) {
                $q->where('transaction_type_id', $request['transaction'])->get();
            } else {
                $q;
            }

        }

        return $q;
    }
}
