<?php

namespace App\Models\IR\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupStock extends Model
{
    use HasFactory;
    
    protected $table = "PTIR_GROUP_STOCKS";
    public $primaryKey = 'lookup_code';

    protected $fillable = ['lookup_code', 'meaning', 'description', 'start_date_active',
                            'end_date_active', 'enabled_flag'];

}
