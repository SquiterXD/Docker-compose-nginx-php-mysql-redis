<?php


namespace App\Models\PM;

use App\Models\PM\Cast\DateCast;
use App\Models\PM\Lookup\PtinvItemcatMatgroupV;
use App\Models\PM\PtpmMfgFormulaV;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

use DB;

class PtpmSetupMfgDepartmentsV extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'ptpm_setup_mfg_departments_v';
    public $timestamps = false;

    protected $guarded = [];

    public function scopeWipCompleteType($q)
    {
        $tableName = (new self)->getTable();
        // return $q->where("{$tableName}.wip_transaction_type_id", 44);
        return $q->where("{$tableName}.wip_transaction_type_name", 'WIP Completion');
    }

    public function invOnhand()
    {
        return $this->belongsTo(\App\Models\PM\Lookup\PtinvOnhandQuantitiesV::class, 'from_organization_code' , 'organization_code');
    }

    public function formulas()
    {
        return $this->hasMany(PtpmMfgFormulaV::class, 'tobacco_group_code' , 'tobacco_group_code');
    }


    public function scopeFormulaByOrgId($q, $org_id)
    {
        return $q->formulas
            ->where('organization_id', $org_id)
            ->where('wip_transaction_type_name', 'WIP Issue');
    }

    public function scopeGetTransferLocators($q, $organizationId) {

        $q->select(DB::raw("to_organization_id, to_subinventory, to_locator_id, to_locator_code"))
            ->wipCompleteType()
            ->where('organization_id', $organizationId)
            ->where('enable_flag', 'Y')
            ->groupBy('to_organization_id', 'to_subinventory', 'to_locator_id', 'to_locator_code');
        return $q;
    }

    public function isWipCompletion() {
        return $this->wip_transaction_type_name == 'WIP Completion';
    }
}


