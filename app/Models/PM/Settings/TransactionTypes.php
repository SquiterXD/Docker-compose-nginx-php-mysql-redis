<?php

namespace App\Models\PM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionTypes extends Model
{
    use HasFactory;

    protected $table = 'mtl_transaction_types';
    public $primaryKey = false;
    public $timestamps = false;
}
