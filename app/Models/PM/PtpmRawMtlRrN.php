<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtpmRawMtlRrN extends Model
{
    use HasFactory;

    // protected $connection = 'oracle_oapm';
    protected $table = 'oapm.ptpm_raw_mtl_rr_n';
    protected $primaryKey = 'ptpm_raw_mtl_id';

    public $timestamps = false;

}
