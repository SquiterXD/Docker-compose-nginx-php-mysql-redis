<?php

namespace App\Models\IR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtirIrr2120T extends Model
{
    use HasFactory;
    protected $table = 'PTIR_IRR2120_T';
    public $primaryKey = 'policy_set_header_id';
}
