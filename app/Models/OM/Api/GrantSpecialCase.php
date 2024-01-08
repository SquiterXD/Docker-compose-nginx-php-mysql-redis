<?php

namespace App\Models\OM\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrantSpecialCase extends Model
{
    use HasFactory;

    protected $table = 'ptom_grant_special_case';
    public $primaryKey = 'grant_special_case_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_updated_date'];
    protected $guarded = [];
}