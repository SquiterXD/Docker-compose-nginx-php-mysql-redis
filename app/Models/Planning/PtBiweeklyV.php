<?php

namespace App\Models\Planning;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtBiweeklyV extends Model
{
    use HasFactory;
    protected $table = "pt_biweekly_v";
    public $primaryKey = 'biweekly_id';
}