<?php

namespace App\Models\OM\Customers\Export;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerContactModel extends Model
{
    use HasFactory;
    protected $table = "PTOM_CUSTOMER_CONTACTS";
    public $primaryKey = 'customer_contact_id';
    public $timestamps = false;

    protected $fillable = [
        'customer_id',
        'contact_no',
        'contact_prefix',
        'contact_first_name',
        'contact_last_name',
        'contact_email',
        'contact_position',
        'contact_phone',
        'fax_number',
        'note',
        'status',
        'program_code',
        'created_by',
        'creation_date',
        'last_updated_by',
        'last_update_date',
    ];
}
