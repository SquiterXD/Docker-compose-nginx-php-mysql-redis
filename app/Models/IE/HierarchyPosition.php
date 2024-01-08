<?php

namespace App\Models\IE;
use Illuminate\Database\Eloquent\Model;

class HierarchyPosition extends Model
{
    protected $table = 'ptw_hierarchy_positions';
    public $primaryKey = 'hierarchy_position_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];

    public function positionUsers()
    {
        return $this->hasMany('App\Models\IE\HierarchyPositionUser', 'hierarchy_position_id', 'hierarchy_position_id')->orderBy('hierarchy_position_user_id');
    }

    public function getUserList()
    {
        $list = [];
        foreach ($this->positionUsers as $positionUser) {
            $list[] = $positionUser->user;
        }

        return $list;
    }

    public function getDefaultApproverAttribute()
    {
        $default = $this->positionUsers->where('default_flag', true)->first() ?? $this->positionUsers->first();
        return $default;
    }
}