<?php

namespace App\Models\EAM\LOV;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Issue extends Model
{
    use Notifiable;

    protected $table = "pteam_issue_v";

    public function getLookupCodeAttribute($value)
    {
        return ($value+0);
    }    
}
