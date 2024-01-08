<?php

namespace App\Models\IR\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PolicySetHeader extends Model
{
    use HasFactory;

    protected $table = "PTIR_POLICY_SET_HEADERS";
    public $primaryKey = 'policy_set_header_id';

    
}
