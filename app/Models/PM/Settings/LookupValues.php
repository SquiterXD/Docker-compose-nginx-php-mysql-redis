<?php

namespace App\Models\PM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LookupValues extends Model
{
    use HasFactory;

    protected $table = 'fnd_lookup_values';
    public $primaryKey = false;
    public $timestamps = false;
}
