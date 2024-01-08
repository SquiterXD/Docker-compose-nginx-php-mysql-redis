<?php

namespace App\Models\OM\Customers\Domestics;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentVendors extends Model
{
    use HasFactory;

    protected $table = "PTOM_AGENT_VENDORS_V";
    public $primaryKey = 'AGENT_ID';
    public $timestamps = false;
}
