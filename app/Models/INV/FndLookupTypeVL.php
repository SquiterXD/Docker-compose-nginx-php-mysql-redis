<?php

namespace App\Models\INV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FndLookupTypeVL extends Model
{
    use HasFactory;
    protected $table = 'FND_LOOKUP_TYPES_VL';

    public function fndLookupValues()
    {
        return $this->hasMany('App\Models\INV\FndLookupValueVL', 'lookup_type', 'lookup_type')
            ->selectRaw('ROWIDTOCHAR(rowid) as "rowid"')
            ->select('lookup_type', 'lookup_code', 'meaning', 'tag', 'description', 'enabled_flag', 'start_date_active', 'end_date_active');
    }
}
