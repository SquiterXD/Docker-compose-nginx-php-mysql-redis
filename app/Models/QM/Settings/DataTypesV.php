<?php

namespace App\Models\QM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataTypesV extends Model
{
    use HasFactory;

    protected $table = 'ptqm_data_types_v';
    public $primaryKey = false;
    public $timestamps = false;
}
