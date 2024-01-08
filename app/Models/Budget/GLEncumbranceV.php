<?php

namespace App\Models\Budget;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GLEncumbranceV extends Model
{
    use HasFactory;
    protected $table        = 'gl_all_enc_types_view';
    protected $connection   = 'oracle';
}
