<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetAccountType extends Model
{
    use HasFactory;
    protected $table = 'OACT.PTCT_SET_ACCOUNT_TYPES';
    public $primaryKey = "set_account_type_id";
    public $timestamps = false;
    public $incrementing = false;
    protected $dates = ['creation_date', 'last_update_date'];

	protected $guarded = [];
}
