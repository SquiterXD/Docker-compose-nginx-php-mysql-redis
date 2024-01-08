<?php

namespace App\Models\Planning\StampMonthly;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtppStampItem extends Model
{
    use HasFactory;
    protected $table = "PTPP_STAMP_ITEMS";
    protected $primaryKey = false;
    public $incrementing = false;
    public $timestamps = false;
}
