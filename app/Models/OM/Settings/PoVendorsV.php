<?php

namespace App\Models\OM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoVendorsV extends Model
{
    use HasFactory;
    protected $table = 'PTOM_PO_VENDORS_V';
    protected $primaryKey = 'vendor_id';
}
