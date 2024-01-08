<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtpmWipStep extends Model
{
    use HasFactory;

    protected $table = 'PTPM_WIP_STEP_T';
    protected $primaryKey ='WIP_STEP_ID';

}
