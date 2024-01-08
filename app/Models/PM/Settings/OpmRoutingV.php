<?php

namespace App\Models\PM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpmRoutingV extends Model
{
    use HasFactory;

    protected $table  = 'ptpm_opm_routing_v';
    protected $primaryKey = 'oprn_id';


    public function scopeActive($q)
    {
        return $q->whereRaw("nvl(active_flag, 'N') = 'Y'");
    }

    public function scopeIsWipIssue($q)
    {
        return $q->whereRaw("nvl(attribute4, 'N') = 'Y'");
    }

}
