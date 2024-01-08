<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OMVENDOR_SITES_V extends Model
{
    use HasFactory;

    protected $table = 'ptom_vendor_sites_v';
    public $primaryKey = 'vendor_id';
}
