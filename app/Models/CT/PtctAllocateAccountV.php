<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class PtctAllocateAccountV extends Model
{
    use HasFactory;

    protected $table = 'PTCT_ALLOCATE_ACCOUNT_V';
    public $timestamps = false;

    protected $guarded = [];

}
