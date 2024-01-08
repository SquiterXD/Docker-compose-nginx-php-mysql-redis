<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountDept extends Model
{
    use HasFactory;

    protected $table = 'ptct_account_dept';
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
      'account_code'            ,
      'sub_acc_code'            ,
      'account_code_disp'       ,
      'dept_code'               ,
      'account_group_type'      ,
      'account_type'            ,
      'transfer_account_flag'   ,
      'allocation_criteria_flag',
      'enabled_flag'            ,
  ];
}
