<?php

namespace App\Models\PD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LLDCigarV extends Model
{
    use HasFactory;
    protected $table = 'PTPD_LLD_CIGAR_V';
    public $primaryKey = false;
    public $timestamps = false;
}
