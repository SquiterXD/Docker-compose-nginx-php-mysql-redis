<?php

namespace App\Models\OM\Rma;

use App\Models\OM\Rma\Domestic\PtomOrderHeaders;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;

    protected $table = 'PTOM_CUSTOMERS';
    protected $primaryKey = 'CUSTOMER_ID';

    public function ptomOrderHeaders()
    {
        return $this->hasMany(PtomOrderHeaders::class);
    }
}
