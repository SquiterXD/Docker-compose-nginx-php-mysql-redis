<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtglCoaReserved2V extends Model
{
    use HasFactory;

    protected $table = "ptgl_coa_reserved2_v";
    public $primaryKey = 'reserved2';
}
