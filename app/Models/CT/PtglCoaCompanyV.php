<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtglCoaCompanyV extends Model
{
    use HasFactory;
    protected $table = "ptgl_coa_company_v";
    public $primaryKey = 'company_code';
}
