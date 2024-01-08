<?php

namespace App\Models\IE;
use Illuminate\Database\Eloquent\Model;

class HierarchyName extends Model
{
    protected $table = 'ptw_hierarchy_names';
    public $primaryKey = 'hierarchy_name_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];

    public function namePositions()
    {
        return $this->hasMany('App\Models\IE\HierarchyNamePosition', 'hierarchy_name_id', 'hierarchy_name_id')->orderBy('seq');
    }
}