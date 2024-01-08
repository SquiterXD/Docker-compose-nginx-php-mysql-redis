<?php

namespace App\Models\QM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtqmTestsV extends Model
{
    use HasFactory;

    protected $table  = 'PTQM_TESTS_V';
    protected $primaryKey = false;
    public $incrementing = false;
    public $timestamps = false;

    

}
