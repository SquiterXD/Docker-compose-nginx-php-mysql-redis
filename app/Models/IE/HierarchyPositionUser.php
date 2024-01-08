<?php

namespace App\Models\IE;
use Illuminate\Database\Eloquent\Model;

class HierarchyPositionUser extends Model
{
    protected $table = 'ptw_hierarchy_position_users';
    public $primaryKey = 'hierarchy_position_user_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'user_id', 'user_id');
    }
}