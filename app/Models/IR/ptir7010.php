<?php

namespace App\Models\IR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\IR\Settings;
class ptir7010 extends Model
{
    use HasFactory;
    protected $table = "PTIR_IRR7010_RPT_T";
    public $primaryKey = 'id';
    
}
