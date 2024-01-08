<?php

namespace App\Models\EAM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ApproverV extends Model
{
    use HasFactory, Notifiable;

    protected $table = "pteam_approver_v";

    public static function checkUser($userId)
    {
        $users = ApproverV::whereRaw("lower(user_id) like lower('{$userId}') ")->count();
        $response = $users > 0;
        return $response;
    }
}
