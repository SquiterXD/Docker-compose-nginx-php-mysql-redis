<?php

namespace App\Models\Lookup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramType extends Model
{
    use HasFactory;

    protected $table  = 'pt_program_types';

    protected $primaryKey = 'program_type_name';

    public function programs()
    {
        return $this->hasMany(ProgramColumn::class, 'program_type_name');
    }
}
