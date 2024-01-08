<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtomPrintHistory extends Model
{
    use HasFactory;
    protected $table = "ptom_print_histories";
    public $primaryKey = 'print_id';
    public $timestamps = true;
    protected $guarded = [];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
