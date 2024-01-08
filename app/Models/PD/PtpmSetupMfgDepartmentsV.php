<?php


namespace App\Models\PD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class PtpmSetupMfgDepartmentsV extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'OAPM.PTPM_SETUP_MFG_DEPARTMENTS_V';
    public $timestamps = false;

    protected $fillable = [
    ];

    public static function getTableName()
    {
        return (new self())->getTable();
    }

    // 'department_code',
    // 'department_desc',
    // 'from_organization_id',
    // 'from_organization_code',
    // 'from_subinventory',
    // 'from_locator_id',
    // 'from_locator_code',
    // 'from_location_code',
    // 'location_desc',
    // 'to_organization_id',
    // 'to_organization_code',
    // 'to_subinventory',
    // 'to_locator_id',
    // 'to_locator_code',
    // 'tobacco_group_code',
    // 'tobacco_group',
    // 'transaction_type_id',
    // 'transaction_type_name',
    // 'wip_transaction_type_id',
    // 'wip_transaction_type_name',
    // 'start_date',
    // 'end_date',
    // 'enable_flag',
}
