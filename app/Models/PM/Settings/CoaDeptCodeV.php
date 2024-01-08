<?php

namespace App\Models\PM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class CoaDeptCodeV extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'ptgl_coa_dept_code_v';
    public $timestamps = false;
    protected $guarded = [];
}
