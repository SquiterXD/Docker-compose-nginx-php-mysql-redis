<?php

namespace App\Models\OM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthoRityList extends Model
{
    use HasFactory;

    protected $table = 'ptom_authority_lists';
    protected $primaryKey = 'authority_id';
}
