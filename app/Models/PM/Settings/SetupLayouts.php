<?php

namespace App\Models\PM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetupLayouts extends Model
{
    use HasFactory;

    protected $table = 'ptpm_setup_layouts';
    public $primaryKey = 'layout_id';
}
