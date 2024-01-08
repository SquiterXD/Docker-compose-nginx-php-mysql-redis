<?php

namespace App\Models\PM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\PM\Settings\MtlTransactionTypes;

class OrgTransfer extends Model
{
    use HasFactory;

    protected $table = 'ptpm_org_transfer';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    // protected $guarded = [];

    protected $fillable = [ 'department_code', 'item_type', 'from_organization_id', 'from_locator_id',
                            'from_subinventory', 'to_organization_id', 'to_locator_id', 'to_subinventory', 
                            'transaction_type_id', 'start_date', 'end_date', 'enable_flag', 'created_by',
                            'creation_date'];

    public function MtlTransactionTypes(){
        return $this->hasOne(MtlTransactionTypes::class, 'transaction_type_id', 'transaction_type_id');
    }

}
