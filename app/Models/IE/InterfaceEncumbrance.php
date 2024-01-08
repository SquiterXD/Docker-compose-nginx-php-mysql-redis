<?php

namespace App\Models\IE;

use Illuminate\Database\Eloquent\Model;

class InterfaceEncumbrance extends Model
{
    protected $table = 'ptw_interface_encumbrances';
    public $primaryKey = 'interface_encumbrance_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];

}
