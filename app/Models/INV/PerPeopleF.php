<?php

namespace App\Models\INV;

use App\Models\FndUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerPeopleF extends Model
{
    use HasFactory;
    protected $table = 'per_people_f';

    public function fndUser()
    {
        return $this->hasOne('App\Models\FndUser', 'employee_id', 'person_id');
    }
}
