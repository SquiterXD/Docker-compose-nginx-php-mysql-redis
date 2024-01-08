<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TTMEmpPostion extends Model
{
    use HasFactory;

    protected $table = 'pnmgr.employee_helpdesk_view';
    public $primaryKey = 'pnps_psnl_no';

}
