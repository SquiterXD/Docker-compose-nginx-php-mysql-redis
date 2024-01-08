<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Role extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "ptw_roles";
    public $primaryKey = 'role_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'ptw_role_permission', 'role_id', 'permission_id');
    }

    public function assignPermission($permission)
    {
        return $this->permissions()->attach($permission);
    }

    public function dismissPermission($permission)
    {
        return $this->permissions()->detach($permission);
    }

    public function hasPermission($permission){
        if (is_string($permission)) {
            return $this->permissions->contains('name', $permission);
        }
        if (get_class($permission) === 'App\Models\Permission') {
           return $this->permissions->contains($permission);
        }
        return !! $permission->intersect($this->permissions)->count();
    }
}
