<?php

namespace App\Models\INV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FndFlexValueSets extends Model
{
    use HasFactory;
    protected $table = 'fnd_flex_value_sets';

    public function fndFlexValuesVl()
    {
        return $this->hasMany('App\Models\INV\FndFlexValuesVl', 'flex_value_set_id', 'flex_value_set_id');
    }
}
