<?php

namespace App\Models\INV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LookupValue extends Model
{
    use HasFactory;
    protected $table = 'FND_LOOKUP_VALUES';

    public function lookupType()
    {
        return $this->belongsTo('App\Models\INV\LookupType', 'lookup_type', 'lookup_type');
    }
}
