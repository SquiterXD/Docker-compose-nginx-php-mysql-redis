<?php

namespace App\Models\PM;

use App\Models\PM\PtpmOnhandNotice as PmPtpmOnhandNotice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtpmOnhandLog extends Model
{
    use HasFactory;
    protected $table        = 'ptpm_onhand_log';
    public $timestamps      = false;
    protected $primaryKey   = 'onhand_id';

    public function noti() {
        return $this->belongsTo(PmPtpmOnhandNotice::class, 'primary_uom_code','uom_code');
    }

    

}
