<?php

namespace App\Models\QM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubinventoriesV extends Model
{
    use HasFactory;

    protected $table = 'ptqm_subinventories_v';
    public $primaryKey = false;
    public $timestamps = false;
}
