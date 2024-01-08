<?php

namespace App\Models\OM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerApproval extends Model
{
    use HasFactory;

    protected $table   = 'ptom_customer_approvals';
    public $primaryKey = 'customer_approval_id';


    public function employee()
    {
        return $this->belongsTo(EmployeePosV::class, 'employee_id', 'person_id');
    }
}
