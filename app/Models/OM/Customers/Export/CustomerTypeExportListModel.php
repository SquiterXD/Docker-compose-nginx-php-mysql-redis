<?php

namespace App\Models\OM\Customers\Export;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerTypeExportListModel extends Model
{
    use HasFactory;
    protected $table = "PTOM_CUSTOMER_TYPE_EXPORT";
    public $primaryKey = 'CUSTOMER_ID';
    public $timestamps = false;
}
