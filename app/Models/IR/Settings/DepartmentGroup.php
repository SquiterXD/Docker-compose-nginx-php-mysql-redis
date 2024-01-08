<?php

namespace App\Models\IR\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentGroup extends Model
{
    use HasFactory;

    protected $table = "ptir_department_groups";
    public $primaryKey = 'department_id';

    protected $fillable = ['department_id', 'email_id', 'department_group_code', 'department_group_desc', 
                            'program_code', 'created_by_id', 'created_by', 'last_updated_by'];
}
