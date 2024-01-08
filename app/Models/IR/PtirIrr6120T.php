<?php

namespace App\Models\IR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtirIrr6120T extends Model
{
    use HasFactory;
    protected $table = 'PTIR_IRR6120_T';
    public $primaryKey = 'policy_set_header_id';
}
