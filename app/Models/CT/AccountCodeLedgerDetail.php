<?php

namespace App\Models\CT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountCodeLedgerDetail extends Model
{
    use HasFactory;
    protected $table = 'OACT.PTCT_AC_LEDGER_DETAILS';

    public $primaryKey = "ac_ledger_detail_id";
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];

    protected $fillable = [
        'ac_ledger_id',
        'code_segment3',
        'code_segment4',
        'organization_id',
        'tobacco_group',
        'product_group',
        'code_segment9',
        'code_segment10',
        'code_segment1',
        'code_segment2',
        'code_segment6',
        'code_segment7',
        'code_segment5',
        'code_segment8',
        'code_segment11',
        'code_segment12',
        'enable_flag',
        'start_date',
        'end_date',
    ];

    public function acLedger()
    {
        return $this->belongsTo(AccountCodeLedger::class, 'ac_ledger_id', 'ac_ledger_id');
    }
}
