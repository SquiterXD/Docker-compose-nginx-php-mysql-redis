<?php

namespace App\Models\OM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MappingAccount extends Model
{
    use HasFactory;

    protected $table      = 'ptom_mapping_account_code_gl';
    protected $primaryKey = 'account_id';
}
