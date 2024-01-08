<?php

namespace App\Models\IR\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubGroupsV extends Model
{
    use HasFactory;

    protected $table = "ptir_sub_group_v";
    public $primaryKey = 'sub_group_id';
}
