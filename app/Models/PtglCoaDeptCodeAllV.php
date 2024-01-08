<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtglCoaDeptCodeAllV extends Model
{
    use HasFactory;
    protected $table = "ptgl_coa_dept_code_all_v";
    public $primaryKey = 'department_code';
}
