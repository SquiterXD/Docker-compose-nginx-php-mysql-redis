<?php

namespace App\Models\OM;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PTOM_AUTHORITY_LISTS extends Model
{
    use HasFactory;

    protected $table = 'ptom_authority_lists';
    public $primaryKey = 'authority_id';

    public function usernameGetname()
    {
        return $this->hasOne(User::class, 'username', 'employee_number');
    }
}
