<?php

namespace App\Models\PM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtpmConvertItemsInfo extends Model
{
    use HasFactory;

    protected $table = 'ptpm_convert_items_info';
    public $primaryKey = 'convert_item_id';
    public $timestamps = false;

    public function scopeActive($query)
    {
        return $query->where('enable_flag', 'Y');
    }

}
