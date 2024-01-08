<?php

namespace App\Models\IE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model
{
    use HasFactory;
    protected $table = "ptw_user_accounts";
    public $primaryKey = 'user_account_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'user_id');
    }
}
