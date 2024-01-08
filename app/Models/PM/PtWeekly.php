<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtWeekly extends Model
{
    use HasFactory;

    protected $table = 'PT_WEEKLY';
    public $timestamps = false;

    protected $guarded = [];

}
