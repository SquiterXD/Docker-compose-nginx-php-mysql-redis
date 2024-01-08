<?php

namespace App\Models\IE;
use Illuminate\Database\Eloquent\Model;

class HierarchySetup extends Model
{
    protected $table = 'ptw_hierarchy_setups';
    public $primaryKey = 'hierarchy_setup_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];

    public function department()
    {
        return $this->hasOne('\App\Models\IE\FNDChildListOfValues', 'value_code', 'department_code')->department();
    }

    public function topic()
    {
        return $this->hasOne('App\Models\IE\HierarchyTopic', 'hierarchy_topic_id', 'hierarchy_topic_id');
    }

    public function type()
    {
        return $this->hasOne('App\Models\IE\HierarchyType', 'hierarchy_type_id', 'hierarchy_type_id');
    }

    public function name()
    {
        return $this->hasOne('App\Models\IE\HierarchyName', 'hierarchy_name_id', 'hierarchy_name_id');
    }
}