<?php

namespace App\Models\EAM;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use App\Models\EAM\AssetV;

class AssetT extends Model
{
    use HasFactory, Notifiable;

    protected $table = "pteam_asset_t";
    public $primaryKey = 'asset_id';
    public $timestamps = true;
    protected $dates = [
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'asset_id',
        'eam_organization',
        'active_status',
        'asset_number',
        'asset_description',
        'asset_group',
        'asset_serial_number',
        'asset_category',
        'owning_department',
        'area',
        'wip_accounting_class',
        'parent_asset_number',
        'production_organization',
        'jp_status',
        'resource_code',
        'resource_description',
        'usage_uom',
        'usage_uom_desc',
        'locator',
        'work_procedure',
        'machine_type',
        'machine_speed',
        'performance_percent',
        'machine_installation_date',
        'fa_number',
        'attribute1',
        'attribute2',
        'attribute3',
        'attribute4',
        'attribute5',
        'attribute6',
        'attribute7',
        'attribute8',
        'attribute9',
        'attribute10',
        'attribute11',
        'attribute12',
        'attribute13',
        'attribute14',
        'attribute15',
        'or_eam_organization_id',
        'or_production_organization_id',
        'or_inventory_item_id',
        'or_instance_id',
        'program_code',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by_id',
        'updated_by_id',
        'deleted_by_id',
        'created_by',
        'last_updated_by',
        'creation_date',
        'last_update_date',
        'file_name',
        'interface_name',
        'tran_id',
        'stg_no',
        'web_batch_no',
        'web_status',
        'interface_status',
        'interface_msg'
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


    public static function getWebBatchNo()
    {
        $dateTime = Carbon::now('Asia/Bangkok')->isoFormat('DD-MMM-YYYY h:mm:ss.SSSSSS A');
        return Str::upper('pteam_asset_t_'.$dateTime);
    }

    public static function saveData($data)
    {
        $asset = AssetT::where('asset_number', $data['asset_number'])
                            ->first();
        $assetV = AssetV::where('asset_number', $data['asset_number'])
                        ->first();
        $data['last_updated_by'] = auth()->user()->user_id ?? -1;
        $data['web_batch_no'] = AssetT::getWebBatchNo();
        $data['program_code'] =  "EAM0003";
        $data['machine_installation_date'] = parseFromDateTh($data['machine_installation_date']);
        if ($assetV !== null) {
            $webStatus = 'UPDATE';
            if (data_get($data, 'web_status') == 'CREATE') {
                $webStatus = 'CREATE';
            }

            if ($asset !== null) {
	            $data['updated_by'] = auth()->user()->fndUserId ?? -1;
	            $data['updated_by_id'] = auth()->user()->user_id ?? -1;
	            $data['web_status'] = $webStatus;
	            $asset->update($data);
        	} else {
                $data['created_by'] = auth()->user()->fndUserId ?? -1;
                $data['created_by_id'] = auth()->user()->user_id ?? -1;
                $data['updated_by'] = auth()->user()->fndUserId ?? -1;
                $data['updated_by_id'] = auth()->user()->user_id ?? -1;
                $data['web_status'] = $webStatus;
                $asset = AssetT::create($data);           
            }
        } else {
            if ($asset !== null) {
                $data['updated_by'] = auth()->user()->fndUserId ?? -1;
                $data['updated_by_id'] = auth()->user()->user_id ?? -1;
                $data['web_status'] = "CREATE";
                $asset->update($data);  
            } else {
                $data['created_by'] = auth()->user()->fndUserId ?? -1;
	            $data['created_by_id'] = auth()->user()->user_id ?? -1;
	            $data['web_status'] = "CREATE";
	            $asset = AssetT::create($data);
            }
        }
        return $asset;
    }
   
}
