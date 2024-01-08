<?php

namespace App\Models\OM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemV extends Model
{
    use HasFactory;

    protected $table = 'ptom_item_v';
    protected $primaryKey = 'inventory_item_id';

}
