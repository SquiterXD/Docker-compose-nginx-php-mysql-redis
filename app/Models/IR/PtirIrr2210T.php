<?php

namespace App\Models\IR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtirIrr2210T extends Model
{
    use HasFactory;
    protected $table = 'PTIR_IRR2210_T';
    public $primaryKey = 'policy_set_header_id';
}
