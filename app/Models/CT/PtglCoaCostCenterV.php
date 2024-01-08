<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtglCoaCostCenterV extends Model
{
    use HasFactory;
    protected $table = 'PTGL_COA_COST_CENTER_V';
    public $timestamps = false;

    protected $guarded = [];

}
