<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtpmItemCatImage extends Model
{
    use HasFactory;
    // protected $connection = 'oracle_oapm';
    protected $table = 'oapm.ptpm_item_cat_images';
    protected $primaryKey = 'ptpm_item_cat_images_id';
    
    public $timestamps = false;
}
