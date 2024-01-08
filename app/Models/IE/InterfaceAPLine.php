<?php

namespace App\Models\IE;

use Illuminate\Database\Eloquent\Model;

class InterfaceAPLine extends Model
{
    protected $table = 'ptw_interface_ap_lines';
    public $primaryKey = 'interface_ap_line_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];
    
    public function header(){
    	return $this->belongsTo('App\Models\IE\InterfaceAPHeader', 'interface_ap_header_id');
    }

    public function wht()
    {
        return $this->belongsTo('App\Models\IE\WHT', 'pay_awt_group_id');
    }
}
