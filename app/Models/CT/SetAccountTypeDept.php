<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetAccountTypeDept extends Model
{
    use HasFactory;
    protected $table = 'OACT.ptct_set_account_dept';
    public $primaryKey = "set_account_dept_id";
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];

	protected $guarded = [];
}
