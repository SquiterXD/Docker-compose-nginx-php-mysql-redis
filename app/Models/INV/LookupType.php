<?php

namespace App\Models\INV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LookupType extends Model
{
    use HasFactory;
    protected $table = 'FND_LOOKUP_TYPES';

    public function lookupValue()
    {
        return $this->hasMany('App\Models\INV\LookupValue', 'lookup_type', 'lookup_type');
    }
}
