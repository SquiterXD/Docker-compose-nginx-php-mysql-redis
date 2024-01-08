<?php

namespace App\Models\QM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataTypeV extends Model
{
    use HasFactory;

    protected $table = 'ptqm_data_type_v';
    public $primaryKey = false;
    public $timestamps = false;
}
