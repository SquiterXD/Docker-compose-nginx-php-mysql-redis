<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtwUsers extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'TOAT.PTW_USERS';
    public $timestamps = false;

    protected $fillable = [
    ];

    protected $hidden = [
        'password',
        'email_verified_at',
    ];

    // 'user_id',
    // 'name',
    // 'email',
    // 'username',
    // 'department_code',
    // 'password',
    // 'email_verified_at',
    // 'remember_token',
    // 'last_updated_by',
    // 'last_update_date',
    // 'created_by',
    // 'creation_date',
    // 'active',
    // 'fnd_user_id',
    // 'position_code',
    // 'role_options',
    // 'department_options',
}
