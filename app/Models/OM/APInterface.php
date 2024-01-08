<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class APInterface extends Model
{
    use HasFactory;

    protected $table = 'ptom_ap_interfaces';
    // public $primaryKey = 'ar_interface_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_updated_date'];
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_updated_date';

}
