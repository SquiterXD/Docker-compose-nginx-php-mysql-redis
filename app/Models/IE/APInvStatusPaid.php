<?php

namespace App\Models\IE;

use Illuminate\Database\Eloquent\Model;

class APInvStatusPaid extends Model
{
    protected $table = 'PTIE_AP_INV_PAID_STATUS_V';
    public $primaryKey = 'invoice_id';
}
