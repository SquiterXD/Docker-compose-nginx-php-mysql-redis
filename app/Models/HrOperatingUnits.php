<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrOperatingUnits extends Model
{
    use HasFactory;
    protected $table = 'HR_OPERATING_UNITS';
    public $primaryKey = 'organization_id';
}
