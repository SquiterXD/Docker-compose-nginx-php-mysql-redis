<?php

namespace App\Models\PD\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimuRawMaterials extends Model
{
    use HasFactory;

    protected $table  = 'ptpd_simu_raw_materials';

    protected $primaryKey = 'simu_raw_id';

    protected $fillable = ['simu_raw_id', 'simu_raw_num', 'description', 'simu_type', 
                            'price_per_unit', 'simu_uom', 'start_date', 'end_date',
                            'remark', 'status', 'created_by', 'last_updated_by', 'active_flag'];

    public function scopeSearch($q, $simuType, $simuRawNum)
    {
        return $q->when($simuType, function($q) use($simuType) {
            $q->where('simu_type', 'like', '%' . $simuType . '%');
        })->when($simuRawNum, function($q) use($simuRawNum) {
            $q->where('simu_raw_num', 'like', '%' . $simuRawNum . '%');
        });
    }

    public function uom()
    {
        return $this->belongsTo(\App\Models\Lookup\PtinvUomV::class, 'simu_uom', 'uom_code');
    }

    public function simulationType()
    {
        return $this->belongsTo(\App\Models\Lookup\SimulationType::class, 'simu_type', 'lookup_code');
    }

    public function rawmatStatus()
    {
        return $this->belongsTo(\App\Models\Lookup\RawmatStatus::class, 'status', 'lookup_code');
    }

    public function createInv($simuId)
    {
        $user = auth()->user();
        $db     =   \DB::connection('oracle')->getPdo();
        $sql    =   "
                    declare
                    v_return varchar2(100);
                    begin
                    
                        :v_return := PTPD_ITEM_SIMULATION_F(".$simuId.");
                    
                    end;
                ";


                
        \Log::info($sql);
        $stmt = $db->prepare($sql);
        $result = false;
        $stmt->bindParam(':v_return', $result['v_return'], \PDO::PARAM_STR, 4000);
        // $stmt->bindParam(':v_message', $result['message'], \PDO::PARAM_STR, 4000);
        \Log::info($result);
        $stmt->execute();

        return $result;
    }
}
