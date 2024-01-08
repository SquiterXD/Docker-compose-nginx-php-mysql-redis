<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TranspotModelView extends Model
{
    use HasFactory;

    protected $table = 'ptom_po_vendors_v';
    public $primaryKey = 'vendor_id';
}
