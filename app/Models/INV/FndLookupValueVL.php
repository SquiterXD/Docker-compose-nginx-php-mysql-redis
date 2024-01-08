<?php

namespace App\Models\INV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FndLookupValueVL extends Model
{
    use HasFactory;
    protected $table = 'FND_LOOKUP_VALUES_VL';

    public function users()
    {
        return $this->hasOne('App\Models\User', 'username', 'lookup_code');
    }

    public function fndLookupTypes()
    {
        return $this->belongsTo('App\Models\INV\FndLookupTypeVL', 'lookup_type', 'lookup_type')
            ->selectRaw('ROWIDTOCHAR(rowid) as "rowid"')
            ->select('lookup_type');
    }
}
