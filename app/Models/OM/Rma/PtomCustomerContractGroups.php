<?php

namespace App\Models\OM\Rma;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtomCustomerContractGroups extends Model
{
    use HasFactory;

    protected $table = 'PTOM_CUSTOMER_CONTRACT_GROUPS';
    protected $primaryKey = 'CONTRACT_GROUP_ID';
}
