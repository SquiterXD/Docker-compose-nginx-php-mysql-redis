<?php

namespace App\Models\OM\DomesticMatching;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditGroup extends Model
{
    use HasFactory;

    protected $table = 'ptom_credit_group';
    public $primaryKey = 'lookup_code';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_updated_date'];
    protected $guarded = [];
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_updated_date';
}
