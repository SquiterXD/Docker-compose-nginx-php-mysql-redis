<?php

namespace App\Models\INV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoHeadersAll extends Model
{
    use HasFactory;
    protected $table = 'po_headers_all';
    protected $dates = ["creation_date"];
}
