<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxAdjustModel extends Model
{
    use HasFactory;

    protected $table = 'ptom_tax_adjustments';
    public $primaryKey = 'interface_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_updated_date'];
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_updated_date';

    protected $fillable = [
        'interface_module',
        'from_program_code',
        'document_number',
        'customer_id',
        'customer_type_id',
        'group_id',
        'remark',
        'interface_flag',
        'order_header_id',
        'tax_amount',
        'consignment_date',
        'interface_date',
        'total_vat',
        'adjust_vat',
        'program_code',
        'created_by',
        'last_updated_by',
        'attribute1',
        'attribute2',
    ];
}
