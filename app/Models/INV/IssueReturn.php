<?php

namespace App\Models\INV;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssueReturn extends Model
{
    use HasFactory;
    protected $primaryKey = 'issue_return_id';
    protected $table = "OAINV.PTINV_ISSUE_RETURNS";
    protected $dates = ['transaction_date'];

    protected $fillable = [
        'issue_header_id',
        'issue_number',
        'transaction_date',
        'description',
        'reason',
        'department_code',
        'subinventory_code',
        'gl_alias_name',
        'issue_status',
        'account_code',
        'organization_id',
        'gl_date',
        'created_by',
        'created_by_id',
        'updated_by_id',
        'deleted_by_id',
        'creation_date',
        'last_update_date',
        'last_updated_by',
        'last_update_login',
        'program_code',
        'acc_segment1',
        'acc_segment2',
        'acc_segment3',
        'acc_segment4',
        'acc_segment5',
        'acc_segment6',
        'acc_segment7',
        'acc_segment8',
        'acc_segment9',
        'acc_segment10',
        'acc_segment11',
        'acc_segment12',
        'record_status',
    ];

    public function issueHeader()
    {
        return $this->belongsTo('App\Models\INV\IssueHeader', 'issue_header_id', 'issue_header_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'user_id', 'created_by_id');
    }
}
