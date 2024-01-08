<?php

namespace App\Models\QM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramsInfoV extends Model
{
    use HasFactory;

    protected $table = 'pt_programs_info_v';
    public $primaryKey = false;
    public $timestamps = false;
}
