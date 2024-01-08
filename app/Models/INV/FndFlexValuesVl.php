<?php

namespace App\Models\INV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FndFlexValuesVl extends Model
{
    use HasFactory;
    protected $table = 'fnd_flex_values_vl';

    public function fndFlexValueSet()
    {
        return $this->belongsTo('App\Models\INV\FndFlexValueSets', 'flex_value_set_id', 'flex_value_set_id');
    }
}
