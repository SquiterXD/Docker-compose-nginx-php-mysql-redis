<?php

namespace App\Models\PM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetupTransferLocations extends Model
{
    use HasFactory;

    protected $table = "ptpm_setup_transfer_locations";
    public $primaryKey = 'setup_trans_id';
}
