<?php

namespace App\Models\IE;
use Illuminate\Database\Eloquent\Model;

class HierarchyNamePosition extends Model
{
    protected $table = 'ptw_hierarchy_name_positions';
    public $primaryKey = 'hierarchy_name_position_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];

    public function position()
    {
        return $this->hasOne('App\Models\IE\HierarchyPosition', 'hierarchy_position_id', 'hierarchy_position_id');
    }
}