<?php

namespace App\Models\PM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialGroup extends Model
{
    use HasFactory;

    protected $table  = 'PTPM_MATERIAL_GROUP';
    // protected $primaryKey = 'lookup_code';
    protected $primaryKey = false;
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [ 'dept_code', 'itemcat_group_code', 'comments', 'attribute1', 'attribute2',
                            'attribute3', 'attribute4', 'attribute5', 'attribute6', 'attribute7', 
                            'attribute8', 'attribute9', 'attribute10', 'program_code', 'created_at',
                            'updated_at', 'deleted_at', 'created_by_id', 'updated_by_id', 'deleted_by_id',
                            'created_by', 'last_updated_by', 'creation_date', 'last_update_date'];    
    
    public function coaDepartment() 
    {
        return $this->hasOne(CoaDeptCodeV::class, 'department_code' ,'dept_code');
    }

    public function itemcatMatGroupV() 
    {
        return $this->hasOne(ItemcatMatGroupV::class, 'type_code' ,'itemcat_group_code')->where('group_code', '10');
    }
}


