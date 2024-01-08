<?php

namespace App\Models\IR\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtirSubGroups extends Model
{
    use HasFactory;
    protected $table = "ptir_sub_groups";
    public $primaryKey = 'sub_group_id';
    public $timestamps = false;
}
