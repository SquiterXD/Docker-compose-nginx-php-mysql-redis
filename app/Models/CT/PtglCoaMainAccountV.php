<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtglCoaMainAccountV extends Model
{
    use HasFactory;

    protected $table = "ptgl_coa_main_account_v";
    public $primaryKey = 'main_account';
}
