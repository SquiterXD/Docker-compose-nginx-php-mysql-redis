<?php

namespace App\Models\Lookup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $table  = 'pt_programs_info';

    // protected $primaryKey = 'program_code';

    public function programColumns()
    {
        return $this->hasMany(ProgramColumn::class, 'program_code', 'program_code')
                            ->where('enable_flag', 'Y')
                            ->orderBy('column_seq_num');
    }

    public function program()
    {
        return $this->belongsTo(ProgramType::class, 'program_type_name', 'program_type_name');
    }

}
