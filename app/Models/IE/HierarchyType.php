<?php

namespace App\Models\IE;
use Illuminate\Database\Eloquent\Model;

class HierarchyType extends Model
{
    protected $table = 'ptw_hierarchy_types';
    public $primaryKey = 'hierarchy_type_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];
}