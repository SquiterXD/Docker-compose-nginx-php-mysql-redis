<?php

namespace App\Models\IR\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use stdClass;
use Illuminate\Support\Facades\DB;

use App\Models\IR\Settings\PtirAccountsMapping;

class PtirGasStations extends Model
{
    use HasFactory;

    protected $table = "ptir_gas_stations";
    public $primaryKey = 'gas_station_id';
    public $timestamps = false;

    private $limit = 50;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type_code',
        'policy_set_header_id',
        'group_code',
        'return_vat_flag',
        'vat_percent',
        'revenue_stamp_percent',
        'active_flag',
        'account_id',
        'insurance_expire_date',
        'program_code',
        'created_at',
        'created_by_id',
        'created_by',
        'last_updated_by',
        'creation_date',
        'last_update_date',
        'insurance_date',
        'coverage_amount'
    ];


    /**
     * Lov search gas station type
     */
    public function getLovGasStaionsType($type)
    {
        $type            = (isset($type)) ? $type.'%' : '%';

        $collection = PtirGasStations::select('type_code')
                                      ->where('type_code', 'like', $type)
                                      ->take($this->limit)
                                      ->get();

        return $collection;
    }

    /**
     * Get list gas station
     */
    public function getAllGasStations($type, $return_vat_flag, $active_flag)
    {
        $collection = DB::table('ptir_gas_stations as a')->select('a.gas_station_id', 'c.meaning as group_name', 'a.return_vat_flag', 'a.vat_percent',
                                                                  'a.revenue_stamp_percent', 'b.account_combine', 'a.active_flag', 'a.type_code', 'a.insurance_date',
                                                                  'a.coverage_amount', 'a.policy_set_header_id')
                                                    ->leftJoin('ptir_accounts_mapping_v as b', 'a.account_id', '=', 'b.account_id')
                                                    ->leftJoin('ptir_groups as c', 'a.group_code', '=', 'c.lookup_code')
                                                    ->whereRaw("a.type_code = nvl(?, a.type_code)
                                                                and a.return_vat_flag = nvl(?, a.return_vat_flag)
                                                                and a.active_flag = nvl(?, a.active_flag)", 
                                                                [$type, $return_vat_flag, $active_flag])
                                                    ->orderBy('a.type_code', 'asc')
                                                    ->get();

        return $collection;
    }

    /**
     * Get specified gas station
     */
    public function getGasStations($id) 
    {
        $collection = PtirGasStations::select('gas_station_id', 'type_code', 'group_code', 'return_vat_flag', 'vat_percent', 'policy_set_header_id',
                                              'revenue_stamp_percent', 'account_id', 'active_flag', 'insurance_date', 'coverage_amount', DB::raw("to_char(add_months(insurance_expire_date, 6516), 'dd/mm/yyyy') insurance_expire_date"))
                                    ->where('gas_station_id', $id)
                                    ->first();

        return $collection;
    }

    public function objectGasStation($id)
    {
        $data = $this->getGasStations($id);
        $obj = new stdClass;
        $obj->gas_station_id        = (isset($data->gas_station_id)) ? $data->gas_station_id : '';
        $obj->type_code             = (isset($data->type_code)) ? $data->type_code : '';
        $obj->group_code            = (isset($data->group_code)) ? $data->group_code : '';
        $obj->policy_set_header_id  = (isset($data->policy_set_header_id)) ? $data->policy_set_header_id : '';
        $obj->return_vat_flag       = (isset($data->return_vat_flag)) ? $data->return_vat_flag : '';
        $obj->vat_percent           = (isset($data->vat_percent)) ? $data->vat_percent : '';
        $obj->revenue_stamp_percent = (isset($data->revenue_stamp_percent)) ? $data->revenue_stamp_percent : '';
        $obj->account_id            = (isset($data->account_id)) ? $data->account_id : '';
        $obj->insurance_expire_date = (isset($data->insurance_expire_date)) ? $data->insurance_expire_date : '';
        $obj->active_flag           = (isset($data->active_flag)) ? $data->active_flag : '';
        $obj->insurance_date        = (isset($data->insurance_date)) ? $data->insurance_date : '';
        $obj->coverage_amount       = (isset($data->coverage_amount)) ? $data->coverage_amount : '';

        return $obj;
    }
    
    public function updateGasStations($data)
    {
        $db = PtirGasStations::find($data['gas_station_id']);
        $db->group_code            = isset($data['group_code']) ? $data['group_code'] : '';;
        $db->return_vat_flag       = isset($data['return_vat_flag']) ? $data['return_vat_flag'] : '';;
        $db->vat_percent           = isset($data['vat_percent']) ? $data['vat_percent'] : '';
        $db->revenue_stamp_percent = isset($data['revenue_stamp_percent']) ? $data['revenue_stamp_percent'] : '';;
        $db->account_id            = isset($data['account_id']) ? $data['account_id'] : '';;
        $db->insurance_expire_date = isset($data['insurance_expire_date']) ? $data['insurance_expire_date'] : '';;
        $db->active_flag           = isset($data['active_flag']) ? $data['active_flag'] : '';;
        $db->policy_set_header_id  = isset($data['policy_set_header_id']) ? $data['policy_set_header_id'] : '';
        $db->last_updated_by       = isset($data['last_updated_by']) ? $data['last_updated_by'] : '';
        $db->updated_at            = isset($data['updated_at']) ? $data['updated_at'] : '';;
        $db->last_update_date      = isset($data['last_update_date']) ? $data['last_update_date'] : '';
        $db->insurance_date        = isset($data['insurance_date']) ? $data['insurance_date'] : '';;
        $db->coverage_amount       = isset($data['coverage_amount']) ? $data['coverage_amount'] : '';
        $db->save();
    }

    public function updateReturnVatFlag($data)
    {
        $db = PtirGasStations::find($data['gas_station_id']);
        $db->return_vat_flag   = $data['return_vat_flag'];
        $db->last_updated_by   = $data['last_updated_by'];
        $db->updated_at        = $data['updated_at'];
        $db->last_update_date  = $data['last_update_date'];
        $db->save();
    }

    public function updateActiveFlag($data)
    {
        $db = PtirGasStations::find($data['gas_station_id']);
        $db->active_flag       = $data['active_flag'];
        $db->last_updated_by   = $data['last_updated_by'];
        $db->updated_at        = $data['updated_at'];
        $db->last_update_date  = $data['last_update_date'];
        $db->save();
    }

    public static function duplicateCheck($typeCode)
    {
        $collection = PtirGasStations::where('type_code', $typeCode)->first();

        if ($collection == null) 
        {
            return true;
        }

        return false;
    }

    public function getGasStationsTypeLov($typeCode)
    {
        $collection = DB::table('ptir_gas_stations as a')->select(
            'a.type_code',
            'a.return_vat_flag as vat_refund',
            'a.group_code',
            'b.group_desc',
            'a.revenue_stamp_percent', 
            'a.vat_percent',
            'a.account_id',
            'c.account_combine',
            'c.account_combine_desc',
            'a.gas_station_id',
            'a.policy_set_header_id',
            'a.insurance_date',
            'a.coverage_amount',
            'a.revenue_stamp_percent'
        )
        ->join('ptir_policy_set_headers_v as b', 'a.policy_set_header_id', '=', 'b.policy_set_header_id')
        ->leftJoin('ptir_accounts_mapping as c', 'a.account_id', '=', 'c.account_id')
        ->whereRaw('type_code = nvl(?, type_code)', [$typeCode])
        ->where('a.active_flag', 'Y')
        ->get();

        return $collection;
    }

    public function scopeSearch($q, $search)
    {
        if ($search->type_code) {
            $q->where('type_code', $search->type_code);
        } else {
            $q;
        }

        if ($search->return_vat_flag) {
            $q->where('return_vat_flag', $search->return_vat_flag);
        } else {
            $q;
        }

        if ($search->active_flag) {
            $q->where('active_flag', $search->active_flag);
        } else {
            $q;
        }

        return $q;
    }

    public function group()
    {
        return $this->belongsTo('App\Models\IR\Views\PtirGroupsView', 'group_code', 'lookup_code');
    }

    public function accountMapping()
    {
        return $this->belongsTo(PtirAccountsMapping::class, 'account_id', 'account_id');
    }
}
