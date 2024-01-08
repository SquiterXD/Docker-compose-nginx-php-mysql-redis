<?php

namespace App\Models\IE;

use Illuminate\Database\Eloquent\Model;

class APInvStatusCancel extends Model
{
    protected $table = 'PTIE_AP_INV_CANCELLED_V';
    public $primaryKey = 'invoice_id';
}