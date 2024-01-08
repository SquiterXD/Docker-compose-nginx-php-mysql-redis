<?php

namespace App\Models\QM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemNumberV extends Model
{
    use HasFactory;

    protected $table = 'ptpm_item_number_v';
    public $primaryKey = false;
}
