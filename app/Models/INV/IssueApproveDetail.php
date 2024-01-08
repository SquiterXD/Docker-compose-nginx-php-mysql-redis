<?php

namespace App\Models\INV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssueApproveDetail extends Model
{
    use HasFactory;
    protected $primaryKey = 'issue_approve_id';
    protected $table = "OAINV.PTINV_ISSUE_APPROVE_DETAILS";

    protected $fillable = [
        'issue_approve_id',
        'issue_detail_id',
        'inventory_item_id',
        'locator',
        'lot_number',
        'quantity', 
        'record_status',
        'program_code',
    ];

    public function issueDetails()
    {
        return $this->belongsTo(issueDetails::class, 'issue_detail_id');
    }
}
