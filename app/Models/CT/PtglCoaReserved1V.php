<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtglCoaReserved1V extends Model
{
    use HasFactory;

    protected $table = "ptgl_coa_reserved1_v";
    public $primaryKey = 'reserved1';
}
