<?php

namespace App\Models\PP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StampMonthly extends Model
{
    use HasFactory;
    protected $table = "PTPP_STAMP_MONTHLY";
    public $primaryKey = 'monthly_id';
}
