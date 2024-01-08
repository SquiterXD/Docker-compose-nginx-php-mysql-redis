<?php

namespace App\Models\PM;

use App\Models\PM\PtpmAdditiveTransferL;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtpmAdditiveTransferH extends Model
{
    use HasFactory;

    protected $table = 'ptpm_additive_transfer_h';

    protected $primaryKey = 'additive_header_id';

    protected $fillable = [
        'department_code',
        'department_desc',
        'transfer_number',
        'transfer_date',
        'status',
        'subinventory_from',
        'locator_id_from',
        'locator_from',
        'subinventory_to',
        'locator_id_to',
        'locator_to',
        'program_id',
        'web_batch_no',
        'interfac_msg',
        'record_status',
        'transaction_flag',
    ];

    public function lines()
    {
        return $this->hasMany(PtpmAdditiveTransferL::class, 'additive_header_id', 'additive_header_id');
    }
}
