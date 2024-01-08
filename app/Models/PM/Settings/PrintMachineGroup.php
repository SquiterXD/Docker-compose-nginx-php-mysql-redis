<?php

namespace App\Models\PM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrintMachineGroup extends Model
{
    use HasFactory;

    protected $table = "ptpm_print_machine_group";
    public $primaryKey = 'id';
    public $timestamps = false;
}
