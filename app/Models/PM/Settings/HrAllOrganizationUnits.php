<?php

namespace App\Models\PM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrAllOrganizationUnits extends Model
{
    use HasFactory;

    protected $table = 'hr_all_organization_units';
    public $primaryKey = false;
    public $timestamps = false;
}
