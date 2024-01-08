<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrgOrganizationDefinition extends Model
{
    use HasFactory;
    protected $table = "ORG_ORGANIZATION_DEFINITIONS";
    public $primaryKey = 'organization_id';
    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();
        $tableName = (new self)->getTable();
        static::addGlobalScope('selectcolumn', function ($builder) use($tableName) {
            $builder->selectRaw("{$tableName}.*, organization_code ||' : '|| organization_name display");
        });
    }
}
