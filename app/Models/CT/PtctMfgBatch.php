<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtctMfgBatch extends Model
{
    use HasFactory;
    protected $table = 'PTCT_MFG_BATCH';
    
    // public $primaryKey = 'batch_no';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];

    protected $fillable = [];

}