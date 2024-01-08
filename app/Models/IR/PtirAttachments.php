<?php

namespace App\Models\IR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtirAttachments extends Model
{
    use HasFactory;
    protected $table = "ptir_attachments";
    public $primaryKey = 'attachment_id';
}
