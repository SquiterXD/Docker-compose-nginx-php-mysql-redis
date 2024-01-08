<?php

namespace App\Models\INV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssueHeader extends Model
{
    use HasFactory;
    public $primaryKey = 'issue_header_id';
    protected $table = 'PTINV_ISSUE_HEADERS';
    // protected $dates = ['transaction_date', 'gl_date'];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'issue_number',
        'transaction_date',
        'description',
        'department_code',
        'subinventory_code',
        'gl_alias_name',
        'issue_status',
        'account_code',
        'organization_id',
        'gl_date',
        'created_by',
        'created_by_id',
        'creation_date',
        'last_update_date',
        'last_updated_by',
        'last_update_login',
        'updated_by_id',
        'deleted_by_id',
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
        'cancel_date',
        'cancel_by_id',
        'reason_name',
    ];

    public function details()
    {
        return $this->hasMany(IssueDetail::class, 'issue_header_id');
    }

    public function getThaiStatusAttribute()
    {
        if ($this->issue_status == 'WAITING' || $this->issue_status == 'UPDATE') {
            return  "รอตัดจ่าย";
        }
        if ($this->issue_status == 'APPROVED') {
            return  "ตัดจ่ายสำเร็จ";
        }
        if ($this->issue_status == 'CANCELLED') {
            return  "ยกเลิก";
        }
        if ($this->issue_status == 'DRAFT') {
            return  "ร่างรายการเบิก";
        }
        if ($this->issue_status == 'RETURN') {
            return  "ยกเลิก (Return)";
        }

        return $this->issue_status;
    }

    public function coaDeptCode()
    {
        return $this->belongsTo('App\Models\INV\CoaDeptCodeV', 'department_code', 'department_code');
    }

    public function issueProgramProfileV()
    {
        return $this->belongsTo('App\Models\INV\IssueProgramProfileV', 'organization_id', 'organization_id');
    }

    public function organizationUnits()
    {
        return $this->belongsTo('App\Models\INV\OrganizationUnits', 'organization_id', 'organization_id');
    }

    public function secondaryInventory()
    {
        return $this->belongsTo('App\Models\INV\SecondaryInventory', 'subinventory_code', 'secondary_inventory_name');
    }

    public function issueReturn()
    {
        return $this->hasOne('App\Models\INV\IssueReturn', 'issue_header_id', 'issue_header_id');
    }

    public function cancelUser()
    {
        return $this->hasOne('App\Models\User', 'user_id', 'cancel_by_id');
    }
}
