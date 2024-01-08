<?php

namespace App\Models\QM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultSeverity extends Model
{
    use HasFactory;

    protected $table = 'ptqm_result_severity';
    public $primaryKey = 'lookup_code';
    public $timestamps = false;
}
