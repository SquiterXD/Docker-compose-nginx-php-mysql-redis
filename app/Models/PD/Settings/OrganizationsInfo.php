<?php

namespace App\Models\PD\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationsInfo extends Model
{
    use HasFactory;

    protected $table  = 'ptinv_organizations_info';
    protected $primaryKey = 'organization_id';
}
