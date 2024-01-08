<?php

namespace App\Models\EAM\LOV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PTWUsers extends Model
{
    use HasFactory, Notifiable;

    protected $table = "ptw_users";

    public $primaryKey = 'user_id';
    
}
