<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RunningNumberLine extends Model
{
    use HasFactory;

    protected $table = "pt_doc_seq_lines";
}
