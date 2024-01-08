<?php

namespace App\Models\IE;

use Illuminate\Database\Eloquent\Model;

class APHeaderDFFContext extends Model
{
    protected $table = 'PTIE_AP_HEADER_DFF_CONTEXT_V';

    public function scopeGlobal($q)
    {
        return $q->where('global_flag', 'Y');
    }

    public function scopeNotGlobal($q)
    {
        return $q->where('global_flag', 'N');
    }

}
