<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtglCoaEvmV extends Model
{
    use HasFactory;
    
    protected $table = "ptgl_coa_evm_v";
    public $primaryKey = 'evm_code';
}
