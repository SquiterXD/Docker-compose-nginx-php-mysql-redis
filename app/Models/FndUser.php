<?php

namespace App\Models;

use App\Models\INV\PerPeopleF;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FndUser extends Model
{
    use HasFactory;

    protected $table        = 'fnd_user';
    protected $connection   = 'oracle';
    protected $primaryKey   = 'user_id';
    protected $hidden       = ['encrypted_foundation_password', 'encrypted_user_password' , 'web_password'];

    public function scopeActive($q)
    {
        return $q->whereRaw('
                trunc(sysdate) between trunc(start_date) and nvl(trunc(end_date), trunc(sysdate))
            ');
    }

    public function employee()
    {
        return $this->hasOne(\App\Models\IE\Employee::class, 'employee_id', 'employee_id');
    }
    public function perPeopleF()
    {
        return $this->belongsTo(PerPeopleF::class, 'person_id', 'employee_id');
    }
}
