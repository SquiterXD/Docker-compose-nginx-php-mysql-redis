<?php

namespace App\Models\OM\DebitNote;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UomConversionModel extends Model
{
    use HasFactory;
    protected $table = 'ptom_uom_conversions_v';
}
