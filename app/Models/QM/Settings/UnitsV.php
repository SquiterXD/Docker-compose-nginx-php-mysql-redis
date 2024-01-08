<?php

namespace App\Models\QM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitsV extends Model
{
    use HasFactory;

    protected $table = 'PTQM_UNITS_V';
    public $primaryKey = false;
    public $timestamps = false;
}

