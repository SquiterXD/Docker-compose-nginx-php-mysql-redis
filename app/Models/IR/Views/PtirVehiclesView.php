<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use stdClass;
use Illuminate\Support\Facades\DB;

class PtirVehiclesView extends Model
{
    use HasFactory;

    protected $table = "OAIR.ptir_vehicles_v";
    public $primaryKey = 'vehicle_id';
    public $timestamps = false;

    public function policySet()
    {
        return $this->belongsTo(PtirPolicySetHeadersView::class, 'policy_set_header_id', 'policy_set_header_id');
    }

    public function policyGroupSet()
    {
        // return $this->hasmany(\App\Models\IR\Settings\PtirPolicyGroupSets::class, 'policy_set_header_id', 'policy_set_header_id');
        return $this->belongsTo(\App\Models\IR\Settings\PtirPolicyGroupSets::class, 'policy_set_header_id', 'policy_set_header_id');
    }

    public function policyGroupLines()
    {
        return $this->hasmany(\App\Models\IR\Settings\PtirPolicyGroupLines::class, 'group_header_id', 'group_header_id');
    }

    public function scopeSearch($q, $search)
    {
        if ($search->license_plate) {
            $q->where('license_plate', $search->license_plate);
        } else {
            $q;
        }

        if ($search->vehicle_type_code) {
            $q->where('vehicle_type_code', $search->vehicle_type_code);
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

        if ($search->insurance_type_code) {
            $q->where('insurance_type_code', $search->insurance_type_code);
        } else {
            $q;
        }

        if ($search->location_code) {
            $q->where('location_code', $search->location_code);
        } else {
            $q;
        }

        return $q;
    }


    public function getAllVehicle($licensePlate, $typeCode, $returnVatFlag, $activeFlag, $insuranceType)
    {
        $insuranceType = isset($insuranceType) ? $insuranceType : '-';

        $collection = DB::table('OAIR.ptir_vehicles_v as a')->select(
            'a.vehicle_id',
            'a.license_plate',
            DB::raw('nvl(a.group_code, b.group_code) group_code'),
            DB::raw('nvl(a.group_desc, b.group_desc) group_desc'),
            DB::raw('nvl(a.policy_set_header_id, b.policy_set_header_id) policy_set_header_id'),
            DB::raw('nvl(a.policy_set_description, b.policy_set_description) policy_set_description'),
            DB::raw('nvl(a.policy_set_number, b.policy_set_number) policy_set_number'),
            'a.vehicle_type_code',
            'a.vehicle_type_name',
            'a.vehicle_brand_code',
            'a.vehicle_brand_name',
            'a.vehicle_cc',
            'a.engine_number',
            'a.tank_number',
            DB::raw("nvl(a.return_vat_flag, 'Y') return_vat_flag"),
            DB::raw("nvl(a.vat_percent, d.tax) vat_percent"),
            DB::raw("nvl(a.revenue_stamp_percent, d.revenue_stamp) revenue_stamp_percent"),
            'a.insurance_type_code',
            'a.asset_id',
            'a.asset_number',
            'a.account_description',
            DB::raw("nvl(a.active_flag, 'Y') active_flag"),
            'a.account_id',
            'a.account_number',
            'a.category_segment4',
            DB::raw("to_char(add_months(a.insurance_expire_date, 6516), 'dd/mm/yyyy') insurance_expire_date,
                                                to_char(add_months(a.license_plate_expire_date, 6516), 'dd/mm/yyyy') license_plate_expire_date,
                                                to_char(add_months(a.acts_expire_date, 6516), 'dd/mm/yyyy') acts_expire_date,
                                                to_char(add_months(a.car_inspection_expire_date, 6516), 'dd/mm/yyyy') car_inspection_expire_date"),
            'a.insurance_type_desc',
            'a.sold_flag',
            DB::raw("to_char(add_months(a.sold_date, 6516), 'dd/mm/yyyy') sold_date"),
            'a.reason',
            'a.location_code',
            'a.location_description',
            'a.renew_car_act',
            'a.renew_car_license_plate',
            'a.renew_car_inspection'
        )
            ->leftJoin('ptir_policy_set_headers_v as b', 'a.policy_set_header_id', '=', 'b.policy_set_header_id')
            ->leftJoin('ptir_policy_group_sets as c', 'a.policy_set_header_id', '=', 'c.policy_set_header_id')
            ->leftJoin('ptir_policy_group_lines as d', 'c.group_header_id', '=', 'd.group_header_id')
            ->whereRaw(
                "a.license_plate = nvl(?, license_plate)
                                                    and a.vehicle_type_code = nvl(?, a.vehicle_type_code)
                                                    and (a.return_vat_flag = nvl(?, a.return_vat_flag) or a.return_vat_flag is null)
                                                    and (a.active_flag = nvl(?, a.active_flag) or a.active_flag is null)
                                                    and ? = (case when ? = '-' then
                                                                            ?
                                                                         else
                                                                            a.insurance_type_code
                                                                        end)
                                                    and (d.group_line_id = (select max(group_line_id)
                                                                        from ptir_policy_group_sets ppgs join ptir_policy_group_lines ppgl on ppgs.group_header_id = ppgl.group_header_id
                                                                        where ppgs.policy_set_header_id = nvl(a.policy_set_header_id, ppgs.policy_set_header_id))
                                                        or d.group_line_id is null)",
                [$licensePlate, $typeCode, $returnVatFlag, $activeFlag, $insuranceType, $insuranceType, $insuranceType]
            )
            ->orderBy('a.license_plate', 'asc')
            ->get();

        return $collection;
    }

    public function getVehicle($id, $vehicleId)
    {
        $id = isset($id) ? (int)$id : null;
        $vehicleId = isset($vehicleId) ? (int)$vehicleId : null;
        $collection = DB::table('ptir_vehicles_v a')->select(
            'a.vehicle_id',
            'a.license_plate',
            'a.group_code',
            'a.policy_set_header_id',
            'a.vehicle_type_code',
            'a.vehicle_brand_code',
            'a.vehicle_cc',
            'a.engine_number',
            'a.tank_number',
            'a.return_vat_flag',
            'c.tax as vat_percent',
            'c.revenue_stamp as revenue_stamp_percent',
            'a.insurance_type_code',
            'a.asset_id',
            'a.asset_number',
            'a.account_description',
            'a.active_flag',
            'a.account_id',
            'a.account_number',
            'a.category_segment4',
            DB::raw("to_char(add_months(a.insurance_expire_date, 6516), 'dd/mm/yyyy') insurance_expire_date,
                                                to_char(add_months(a.license_plate_expire_date, 6516), 'dd/mm/yyyy') license_plate_expire_date,
                                                to_char(add_months(a.acts_expire_date, 6516), 'dd/mm/yyyy') acts_expire_date,
                                                to_char(add_months(a.car_inspection_expire_date, 6516), 'dd/mm/yyyy') car_inspection_expire_date"),
            'a.insurance_type_desc',
            'a.sold_flag',
            DB::raw("to_char(add_months(a.sold_date, 6516), 'dd/mm/yyyy') sold_date"),
            'a.reason',
            'a.location_code',
            'a.location_description',
            'a.renew_car_act',
            'a.renew_car_license_plate',
            'a.renew_car_inspection'
        )
            ->leftJoin('ptir_policy_group_sets b', 'a.policy_set_header_id', '=', 'b.policy_set_header_id')
            ->leftJoin('ptir_policy_group_lines c', 'b.group_header_id', '=', 'c.group_header_id')
            ->whereRaw("a.vehicle_id = nvl(?, a.vehicle_id)
                                                     and (a.asset_id = nvl(?, a.asset_id) or a.asset_id is null)
                                                     and group_line_id = (select max(group_line_id)
                                                                        from ptir_policy_group_sets d join ptir_policy_group_lines e on d.group_header_id = e.group_header_id
                                                                        where d.policy_set_header_id = nvl(a.policy_set_header_id, d.policy_set_header_id))", [$vehicleId, $id])
            ->first();

        return $collection;
    }

    public function objectVehicle($id, $vehicleId)
    {
        // $data = $this->getVehicle($id, $vehicleId);
        $id = isset($id) ? $id : null;
        $vehicleId = isset($vehicleId) ? $vehicleId : null;
        $data = self::find($vehicleId);
        $obj = new stdClass();
        $obj->vehicle_id             = (isset($data->vehicle_id)) ? $data->vehicle_id : '';
        $obj->policy_set_header_id   = (isset($data->policy_set_header_id)) ? $data->policy_set_header_id : '';
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
        $obj->insurance_type_desc    = (isset($data->insurance_type_desc)) ? $data->insurance_type_desc : '';
        $obj->asset_id               = (isset($data->asset_id)) ? $data->asset_id : '';
        $obj->asset_number           = (isset($data->asset_number)) ? $data->asset_number : '';
        $obj->account_description    = (isset($data->account_description)) ? $data->account_description : '';
        $obj->active_flag            = (isset($data->active_flag)) ? $data->active_flag : '';
        $obj->account_id             = (isset($data->account_id)) ? $data->account_id : '';
        $obj->account_number         = (isset($data->account_number)) ? $data->account_number : '';
        $obj->insurance_expire_date  = (isset($data->insurance_expire_date)) ? parseToDateTh($data->insurance_expire_date) : '';
        $obj->license_plate_expire_date = (isset($data->license_plate_expire_date)) ? parseToDateTh($data->license_plate_expire_date) : '';
        $obj->acts_expire_date           = (isset($data->acts_expire_date)) ? parseToDateTh($data->acts_expire_date) : '';
        $obj->car_inspection_expire_date = (isset($data->car_inspection_expire_date)) ? parseToDateTh($data->car_inspection_expire_date) : '';
        $obj->category_segment4          = (isset($data->category_segment4)) ? $data->category_segment4 : '';
        $obj->sold_flag              = (isset($data->sold_flag)) ? $data->sold_flag : '';
        $obj->sold_date              = (isset($data->sold_date)) ? $data->sold_date : '';
        $obj->reason                 = (isset($data->reason)) ? $data->reason : '';
        // New Requirement 09012022
        $obj->location_code         = (isset($data->location_code)) ? $data->location_code : '';
        $obj->location_description  = (isset($data->location_description)) ? $data->location_description : '';
        $obj->renew_car_act         = (isset($data->renew_car_act)) ? $data->renew_car_act : '';
        $obj->renew_car_license_plate  = (isset($data->renew_car_license_plate)) ? $data->renew_car_license_plate : '';
        $obj->renew_car_inspection  = (isset($data->renew_car_inspection)) ? $data->renew_car_inspection : '';

        return $obj;
    }

    public function getLicensePlate($licensePlate, $renewTypeCode, $group, $deptFrom, $deptTo)
    {
        // SELECT DISTINCT 	PTIR_VEHICLES_V.LICENSE_PLATE FROM 	PTIR_VEHICLES_V
        $query = self::query();
        if ($licensePlate) {
            $query->where('license_plate', 'like', '%'.$licensePlate.'%');
        }
        if ($renewTypeCode) {
            $query->where('insurance_type_code', $renewTypeCode);
        }
        if ($group) {
            $query->where('group_code', $group);
        }
        $collection = $query->limit(50)->get();
        // $collection = $collection->groupBy('license_plate');
        // dd($collection);
        /* This is a simple query to find a vehicle with the license plate
        . */
        // $collection = self::where('license_plate', $licensePlate)
        //     ->where('insurance_type_code', $renewTypeCode)
        //     ->where('group_code', $group)
        //     // ->whereNotNull('group_code', $group)
        //     ->whereNotNull('group_code')
        //     // ->whereNotNull('license_plate', $group)
        //     ->whereNotNull('license_plate')
        //     // ->whereNotNull('policy_set_header_id', $group)
        //     ->whereNotNull('policy_set_header_id')
        //     // ->whereNotNull('vehicle_brand_code', $group)
        //     ->whereNotNull('vehicle_brand_code')
        //     // ->whereNotNull('vehicle_type_code', $group)
        //     ->whereNotNull('vehicle_type_code')
        //     // ->whereNotNull('category_segment4', $group)
        //     ->whereNotNull('category_segment4')
        //     ->get();
        // dd($collection);
        // $collection = PtirVehiclesView::select('license_plate',
        //                                         'insurance_type_code as renew_type_code',
        //                                         'insurance_type_desc as renew_type',
        //                                         'group_code',
        //                                         'group_desc',
        //                                         'return_vat_flag as vat_refund',
        //                                         'vehicle_type_code as car_type_code',
        //                                         'vehicle_type_name as car_type',
        //                                         'asset_id',
        //                                         'asset_number',
        //                                         'account_id as expense_account_id',
        //                                         'account_number as expense_account',
        //                                         'account_description as expense_account_desc',
        //                                         'vehicle_brand_code as car_brand_code',
        //                                         'vehicle_brand_name as car_brand',
        //                                         'vehicle_cc',
        //                                         'engine_number',
        //                                         'tank_number',
        //                                         'revenue_stamp_percent',
        //                                         'vat_percent',
        //                                         'location_code',
        //                                         'location_description',
        //                                         'renew_car_act',
        //                                         'renew_car_license_plate',
        //                                         'renew_car_inspection',
        //                                         DB::raw("regexp_substr(replace(account_number, '.', '-'), '[^-]+', 1, 3) as department_code,
        //                                         regexp_substr(replace(account_description, '.', '-'), '[^-]+', 1, 3) as department_desc"))
        //                                 ->whereRaw('license_plate = nvl(?, license_plate)
        //                                             and (insurance_type_code = nvl(?, insurance_type_code) or insurance_type_code is null)
        //                                             and group_code = nvl(?, group_code)
        //                                             and group_code is not null
        //                                             and license_plate is not null
        //                                             and policy_set_header_id is not null
        //                                             and vehicle_brand_code is not null
        //                                             and vehicle_type_code is not null
        //                                             and category_segment4 is not null',
        //                                             [$licensePlate, $renewTypeCode, $group])
        //                                 ->get();
        // $collection = $collection->unique('license_plate')->toArray();
        /* Creating a new collection of the same type as the original collection. */
        // dd($collection);
        return $collection;
    }

    public function scopeSearchReport($q, $search)
    {
        // dd($search);
        if ($search['group_code']) {
            $q->where('group_code', $search['group_code']);
        } else {
            $q;
        }

        if ($search['month']) {
            $q->whereRaw("to_char(insurance_expire_date, 'YYYYMM')  = '{$search['month']}'")
                ->orWhereRaw("to_char(license_plate_expire_date, 'YYYYMM')  = '{$search['month']}'")
                ->orWhereRaw("to_char(acts_expire_date, 'YYYYMM')  = '{$search['month']}'")
                ->orWhereRaw("to_char(car_inspection_expire_date, 'YYYYMM')  = '{$search['month']}'");
        //         ->orWhereRaw("to_char(license_plate_expire_date, 'YYYYMM')", $search['month'])
        //         ->orWhereRaw("to_char(acts_expire_date, 'YYYYMM')", $search['month'])
        //         ->orWhereRaw("to_char(car_inspection_expire_date, 'YYYYMM')", $search['month']);
        } else {
            $q;
        }

        // if ($search->return_vat_flag) {
        //     $q->where('return_vat_flag', $search->return_vat_flag);
        // } else {
        //     $q;
        // }

        // if ($search->active_flag) {
        //     $q->where('active_flag', $search->active_flag);
        // } else {
        //     $q;
        // }

        // if ($search->insurance_type_code) {
        //     $q->where('insurance_type_code', $search->insurance_type_code);
        // } else {
        //     $q;
        // }

        // if ($search->location_code) {
        //     $q->where('location_code', $search->location_code);
        // } else {
        //     $q;
        // }

        return $q;
    }

    public function expenseCarGas()
    {
        return $this->hasOne('App\Models\IR\PtirExpenseCarGas'::class, 'license_plate', 'license_plate');
    }
}
