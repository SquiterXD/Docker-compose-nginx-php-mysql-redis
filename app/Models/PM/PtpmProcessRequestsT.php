<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtpmProcessRequestsT extends Model
{
    use HasFactory;

    protected $table = 'OAPM.PTPM_PROCESS_REQUESTS_T';
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    protected $guarded = [];
}
