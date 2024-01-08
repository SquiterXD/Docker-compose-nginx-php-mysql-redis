<?php

namespace App\Models\PM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\PM\Settings\HrAllOrganizationUnits;

class Parameters extends Model
{
    use HasFactory;

    protected $table = 'mtl_parameters';
    public $primaryKey = false;
    public $timestamps = false;

    public function HrAllOrganizationUnits(){
        return $this->hasOne(HrAllOrganizationUnits::class, 'organization_id', 'organization_id');
    }
}
