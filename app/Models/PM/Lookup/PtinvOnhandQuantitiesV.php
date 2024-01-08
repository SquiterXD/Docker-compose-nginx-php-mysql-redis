<?php


namespace App\Models\PM\Lookup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Models\PM\PtpmMfgFormulaV;
use App\Models\PM\PtpmSetupMfgDepartmentsV;
use App\Models\PM\Lookup\PtpmItemConvUomV;


class PtinvOnhandQuantitiesV extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'TOAT.Ptinv_Onhand_Quantities_V';
    public $timestamps = false;

    protected $fillable = [
    ];

    public function formulaFromInvItem()
    {
        return $this->belongsTo(PtpmMfgFormulaV::class, 'inventory_item_id', 'inventory_item_id')
                ->where('receipe_type_code', "1");
    }



    public function setupMfgDepartmentsV()
    {
        return $this->belongsTo(PtpmSetupMfgDepartmentsV::class, 'locator_id', 'from_locator_id')
                ->where('wip_transaction_type_name', 'WIP Issue')
                ->where('organization_id' ,auth()->user()->organization_id);
    }

    public function scopeGetLotNumber($q, $formOrgId, $fromLocatorId, $invItemId)
    {
        return $q->where('organization_id', $formOrgId)
                    ->where('locator_id', $fromLocatorId)
                    ->where('inventory_item_id', $invItemId);
    }


    public function findFormularByInvItemAndGroup()
    {
        return PtpmMfgFormulaV::
                where('item_number', 100400016)
                ->where('receipe_type_code', "ใช้จริง")
                ->get();
    }


    public function itemConvUom()
    {
        $con = PtpmItemConvUomV::where('inventory_item_id', $this->inventory_item_id)
                ->where('organization_id', auth()->user()->organization_id)
                ->where('from_uom_code', $this->primary_uom_code)
                ->where('to_uom_code', 'KG')
                ->first();
        return $con;
    }

}
