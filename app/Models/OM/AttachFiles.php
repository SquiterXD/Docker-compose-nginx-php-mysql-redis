<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttachFiles extends Model
{
    use HasFactory;

    protected $table = 'ptom_attachments';
    public $primaryKey = 'attachment_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_updated_date'];
    protected $guarded = [];
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_updated_date';
}
