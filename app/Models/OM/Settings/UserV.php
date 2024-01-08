<?php

namespace App\Models\OM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserV extends Model
{
    use HasFactory;
    
    protected $table = 'ptom_user_v';
    protected $primaryKey = 'user_id';
}
