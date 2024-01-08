<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use stdClass;
class PtirFaVehiclesView extends Model
{
    use HasFactory;

    protected $table = "ptir_fa_vehicles_v";
    public $primaryKey = 'asset_id';
    public $timestamps = false;

    private $limit = 50;


    /**
     * Get list license plate
     */
    public function getLicensePlateLov($license_plate)
    {
        $license_plate = (isset($license_plate)) ? $license_plate.'%' : '%';
        $collection = PtirFaVehiclesView::select('license_plate')
                                    ->where('license_plate', 'like', $license_plate)
                                    ->take($this->limit)
                                    ->orderBy('license_plate', 'asc')
                                    ->get();

        return $collection;
    }
    
    public function getPolicySetHeaderLov($id, $keyword)
    {
        $keyword    = (isset($keyword)) ? '%'.$keyword.'%' : '%';
        $collection = PtirFaVehiclesView::select('asset_id', 'policy_set_header_id', 'policy_set_number', 'policy_set_description')
                                        ->where('asset_id', $id)
                                        ->whereRaw('policy_set_number like ? or policy_set_description like ?', [$keyword, $keyword])
                                        ->get();

        return $collection;                
    }

    /**
     * Get list vehicle type
     */
    public function getVehicleTypeLov($id, $keyword)
    {
        $keyword    = (isset($keyword)) ? '%'.$keyword.'%' : '%';

        $collection = PtirFaVehiclesView::select(DB::raw("distinct(vehicle_type_code)"), 'vehicle_type_name')
                                         ->whereRaw("vehicle_type_code = nvl(?, vehicle_type_code)
                                                    and vehicle_type_code like ? or vehicle_type_name like ?", 
                                                [$id, $keyword, $keyword])
                                         ->take($this->limit)
                                         ->orderBy('vehicle_type_code', 'asc')
                                         ->get();

        return $collection;
    }

    /**
     * Get all vehicle
     */
    public function getAllVehicle($licensePlate, $typeCode, $returnVatFlag, $activeFlag) 
    {
        $collection = DB::table('ptir_fa_vehicles_v as a')->select('b.vehicle_id', 'a.asset_number', 'a.vehicle_type_code',
                                                                    'a.vehicle_brand_code', 'a.license_plate', 'b.return_vat_flag', 
                                                                    'b.vat_percent', 'b.revenue_stamp_percent', 'a.account_number',
                                                                    'b.active_flag', 'a.vehicle_brand_name', 'a.vehicle_type_name')
                                                          ->rightJoin('ptir_vehicles as b', 'a.asset_id', '=', 'b.asset_id')
                                                          ->whereRaw("(a.license_plate = nvl(?, a.license_plate) or a.license_plate is null)
                                                                      and (a.vehicle_type_code = nvl(?, a.vehicle_type_code) or a.vehicle_type_code is null)
                                                                      and (b.return_vat_flag = nvl(?, b.return_vat_flag) or b.return_vat_flag is null)
                                                                      and (b.active_flag = nvl(?, b.active_flag) or b.active_flag is null)",
                                                                      [$licensePlate, $typeCode, $returnVatFlag, $activeFlag])
                                                          ->orderBy('a.license_plate', 'asc')
                                                          ->get();

        return $collection;
    }

    /**
     * Get vehicle
     */
    public function getVehicle($id)
    {
        $collection = DB::table('ptir_fa_vehicles_v as a')->select('b.vehicle_id', 'a.license_plate', 'b.group_code', 
                                                                   'a.vehicle_type_code', 'a.vehicle_brand_code', 'a.vehicle_cc', 'a.engine_number',
                                                                   'a.tank_number', 'b.return_vat_flag', 'b.vat_percent', 'b.revenue_stamp_percent', 
                                                                   'b.insurance_type_code', 'a.asset_id', 'a.asset_number', 'a.account_description',
                                                                   'b.active_flag', 'a.account_id', 'a.account_number')
                                                          ->leftJoin('ptir_vehicles as b', 'a.asset_id', '=', 'b.asset_id')
                                                          ->where('b.vehicle_id', $id)
                                                          ->first();

        return $collection;
    }

    public function objectVehicle($id)
    {
        $data = $this->getVehicle($id);
        $obj = new stdClass();
        $obj->vehicle_id             = (isset($data->vehicle_id)) ? $data->vehicle_id : '';
        $obj->license_plate          = (isset($data->license_plate)) ? $data->license_plate : '';
        $obj->group_code             = (isset($data->group_code)) ? $data->group_code : '';
        $obj->vehicle_type_code      = (isset($data->vehicle_type_code)) ? $data->vehicle_type_code : '';
        $obj->vehicle_brand_code     = (isset($data->vehicle_brand_code)) ? $data->vehicle_brand_code : '';
        $obj->vehicle_cc             = (isset($data->vehicle_cc)) ? $data->vehicle_cc : '';
        $obj->engine_number          = (isset($data->engine_number)) ? $data->engine_number : '';
        $obj->tank_number            = (isset($data->tank_number)) ? $data->tank_number : '';
        $obj->return_vat_flag        = (isset($data->return_vat_flag)) ? $data->return_vat_flag : '';
        $obj->vat_percent            = (isset($data->vat_percent)) ? $data->vat_percent : '';
        $obj->revenue_stamp_percent  = (isset($data->revenue_stamp_percent)) ? $data->revenue_stamp_percent : '';
        $obj->insurance_type_code    = (isset($data->insurance_type_code)) ? $data->insurance_type_code : '';
        $obj->asset_id               = (isset($data->asset_id)) ? $data->asset_id : '';
        $obj->asset_number           = (isset($data->asset_number)) ? $data->asset_number : '';
        $obj->account_description    = (isset($data->account_description)) ? $data->account_description : '';
        $obj->active_flag            = (isset($data->active_flag)) ? $data->active_flag : '';
        $obj->account_id             = (isset($data->account_id)) ? $data->account_id : '';
        $obj->account_number         = (isset($data->account_number)) ? $data->account_number : '';

        return $obj;
    }

}
