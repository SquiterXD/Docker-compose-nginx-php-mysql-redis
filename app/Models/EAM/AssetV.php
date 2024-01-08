<?php

namespace App\Models\EAM;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class AssetV extends Model
{
    use HasFactory, Notifiable;

    protected $table = "pteam_asset_v";
    public $primaryKey = 'asset_id';
    public $timestamps = true;

    protected $appends = [
        'machine_speed_unit',
    ];

    protected $dates = [
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [  
    ];
   
    public function searchAssetNumber($request)
    {
        $limit = $request->p_limit ?? $this->limit;
        $query = $this;
        $query = $this->select('pteam_asset_v.*','pteam_departments_v.description as owning_department_description')
        	          ->leftJoin('pteam_departments_v', 'pteam_asset_v.owning_department', '=', 'pteam_departments_v.department_code');
        $query = $this->scopeSearchAssetNumber($query, $request->all());
        $query = $query->orderBy('asset_number', 'asc');
        $result = $query->paginate($limit);


        return $result;
    }

    public function scopeSearchAssetNumber($q, $params)
    {
        $mapColumns = ['asset_number', 'asset_description', 'asset_serial_number'];
        foreach ($params as $key => $value) {
            $key = substr($key, 2);
            $value = strtolower(trim($value));
            if ($value) {
                if (in_array($key, $mapColumns)) {
                    $q = $q->whereRaw(" lower(pteam_asset_v.{$key}) like '{$value}' ");
                }
            }
        }

        return $q;
    }

    public function getMachineSpeedUnitAttribute()
    {
        if ($this->wip_step_desc) {
            return (new \App\Repositories\PM\MachineRelationRepository)->getMachineSpeedUnit($this->wip_step_desc);
        }

        return '';
    }
    
}
