<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtpmJobWipStep extends Model
{
    use HasFactory;

    protected $table = 'PTPM_JOB_WIP_STEP';
    public $timestamps = false;

    protected $fillable = [
    ];

}
