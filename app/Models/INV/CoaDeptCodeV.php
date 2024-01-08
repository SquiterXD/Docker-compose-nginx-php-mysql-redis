<?php

namespace App\Models\INV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoaDeptCodeV extends Model
{
    use HasFactory;
    protected $table = 'PTGL_COA_DEPT_CODE_V';

    public function issueHeader()
    {
        return $this->hasMany('App\Models\INV\IssueHeader', 'department_code', 'department_code');
    }

    public function CarInfo()
    {
        return $this->hasMany('App\Models\INV\CarInfoV', 'department_code', 'default_dept_code');
    }
}
