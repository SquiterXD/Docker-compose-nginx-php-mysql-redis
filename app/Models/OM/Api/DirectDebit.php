<?php

namespace App\Models\OM\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirectDebit extends Model
{
    use HasFactory;

    protected $table = 'ptom_direct_debit';
    public $primaryKey = 'direct_debit_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_updated_date'];
    protected $guarded = [];

}