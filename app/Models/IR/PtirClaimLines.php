<?php

namespace App\Models\IR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtirClaimLines extends Model
{
    use HasFactory;
    protected $table = "ptir_claim_lines";
    public $primaryKey = 'claim_line_id';
}
