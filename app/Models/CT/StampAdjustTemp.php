<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StampAdjustTemp extends Model
{
    use HasFactory;
    protected $table = "OAPM.ptpm_stamp_temp";
    public $primaryKey = 'stamp_gl_id';
    public $timestamps = false;
}
