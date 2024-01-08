<?php

namespace App\Models\OM\Customers\Domestics;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAgentsModel extends Model
{
    use HasFactory;

    protected $table = "PTOM_CUSTOMER_AGENTS";
    public $primaryKey = 'AGENT_ID';
    public $timestamps = false;

    protected $fillable = [
        'customer_id',
        'agent_code',
        'account_code',
        'account_id',
        'account_desc',
        'segment1',
        'segment2',
        'segment3',
        'segment4',
        'segment5',
        'segment6',
        'segment7',
        'segment8',
        'segment9',
        'segment10',
        'segment11',
        'segment12',
        'segment13',
        'segment14',
        'segment15',
        'program_code',
        'created_by',
        'creation_date',
        'last_updated_by',
        'last_update_date',
        'deleted_at',
        'deleted_by_id'
    ];
}
