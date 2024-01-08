<?php

namespace App\Models\PM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrintItemSetup extends Model
{
    use HasFactory;

    protected $table = 'ptpm_print_item_setup';
    public $primaryKey = 'pm_print_set_id';
}
