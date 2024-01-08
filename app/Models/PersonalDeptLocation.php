<?php

namespace App\Models;

use App\Models\IE\Location;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalDeptLocation extends Model
{
    use HasFactory;

    protected $table = 'personal_dept_location';

    public function user()
    {
        return $this->hasOne(User::class, 'username', 'pnps_psnl_no');
    }

    public function department()
    {
        return $this->hasOne(\App\Models\IE\FNDListOfValues::class, 'flex_value', 'dept_cd_f02')->department();
    }

    public static function getLocation()
    {
        $locations = PersonalDeptLocation::select(\DB::raw("dept_location AS location"))->distinct()->pluck('location');
        return $locations;
    }

    public function location()
    {
        return $this->hasOne(\App\Models\IE\Location::class, 'name', 'dept_location');
    }
}
