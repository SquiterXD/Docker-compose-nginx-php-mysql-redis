<?php

namespace App\Models\INV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssueDetail extends Model
{
    use HasFactory;
    public $primaryKey = 'issue_detail_id';
    protected $table = 'PTINV_ISSUE_DETAILS';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'issue_header_id',
        'line_no',
        'description',
        'inventory_item_id',
        'organization_id',
        'onhand_quantity',
        'transaction_quantity',
        'transaction_uom',
        'transaction_account',
        'transaction_account_id',
        'transaction_cost',
        'transaction_amount',
        'created_by',
        'program_code',
    ];

    public function inventoryItem()
    {
        return $this->belongsTo(SystemItemB::class, 'inventory_item_id', 'inventory_item_id');
    }

    public function issueApproveDetails()
    {
        return $this->hasMany(IssueApproveDetail::class, 'issue_detail_id');
    }

    public function issueHeader()
    {
        return $this->belongsTo(IssueHeader::class, 'issue_header_id');
    }
}
