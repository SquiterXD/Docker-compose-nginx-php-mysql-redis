<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PTOM_GL_INTERFACES_REPORT extends Model
{
    use HasFactory;
    protected $table = 'ptom_gl_interfaces_report';
    public $primaryKey = 'interface_report_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_updated_date'];
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_updated_date';

    protected $guarded = [];
}
