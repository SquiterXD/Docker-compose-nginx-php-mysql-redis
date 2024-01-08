<?php

namespace App\Models\OM\CreditNote;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerContractGroupModel extends Model
{
    use HasFactory;
    protected $table = 'ptom_customer_contract_groups';
    public $primaryKey = 'contract_group_id';
    public $timestamps = false;
}
