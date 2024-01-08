<?php

namespace App\Models\IR\Views;

use App\Models\IR\Settings\PtirVehicles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PtirCarsView extends Model
{
    use HasFactory;

    protected $table = "oair.ptir_cars_v";
    public $primaryKey = 'car_id';
    public $timestamps = false;

    public function vehicle() {
        return $this->belongsTo(PtirVehicles::class, 'license_plate', 'license_plate');
    }

    public function policy() {
        return $this->belongsTo(PtirPolicySetHeadersView::class, 'policy_set_header_id', 'policy_set_header_id');
    }

    public function renewCar() {
        return $this->belongsTo(PtirRenewCarInsurancesView::class, 'renew_type_code', 'lookup_code');
    }

    public function getAllCar($year, $renewCode, $groupCode, $licensePlate, $departmentFrom,
                              $departmentTo, $status)
    {
        if ($renewCode == '') {
            $renewCode = '-';
        }
        $collection = DB::table('ptir_cars_v as a')
            ->select(DB::raw("
                distinct d.description  as car_type, 
                a.car_id, 
                INITCAP(a.status) status, 
                a.asset_status, 
                a.document_number, 
                nvl(a.renew_type_code, b.insurance_type_code) renew_type_code,
                (select description from ptir_renew_car_insurances where lookup_code = nvl(a.renew_type_code, b.insurance_type_code)) renew_type, 
                to_char(add_months(a.start_date, 6516), 'dd/mm/yyyy') start_date, 
                to_char(add_months(a.end_date , 6516), 'dd/mm/yyyy') end_date, 
                (a.end_date - a.start_date) total_days, 
                a.department_code, 
                a.department_name, 
                a.license_plate, 
                c.group_code, 
                c.group_desc as group_name, 
                a.duty_amount,
                a.insurance_amount, 
                nvl(a.discount, 0) discount, 
                to_number(b.revenue_stamp_percent) revenue_stamp_percent, 
                to_number(a.vat_amount) as vat_amount, 
                to_number(a.net_amount) as net_amount, 
                nvl(b.return_vat_flag, 'N') as vat_refund, 
                b.vehicle_type_code as car_type_code, 
                a.policy_number, 
                a.company_id,
                a.company_name,
                b.asset_number, 
                nvl(a.expense_account, b.account_number) expense_account, 
                nvl(a.expense_account_id, b.account_id) expense_account_id,
                nvl(a.expense_account_desc, b.account_description) expense_account_desc, 
                a.car_brand, 
                a.car_brand_code, 
                a.car_cc, 
                a.engine_number, 
                a.tank_number, 
                a.line_type,
                to_number(a.year)+543 year,
                nvl(a.expense_flag, 'N') expense_flag,
                b.vat_percent,
                a.receivable_code,
                a.receivable_name,
                a.ar_interface_status
            "))
            ->leftjoin('ptir_vehicles as b', 'a.license_plate', '=', 'b.license_plate')
            ->leftjoin('ptir_policy_set_headers_v as c', 'b.policy_set_header_id', '=', 'c.policy_set_header_id')
            ->leftjoin('ptir_toat_fa_category_seg5_v as d', 'b.vehicle_type_code', '=', 'd.value')
            ->leftjoin('ptir_cars as e', 'a.car_id', '=', 'e.car_id')
            ->whereRaw("
                a.year = nvl(to_number(?)-543, a.year)
                and ? = (case when ? = '-' then
                            ?
                            else 
                            a.renew_type_code
                        end)
                and (a.group_code = nvl(?, a.group_code) or a.group_code is null) 
                and a.license_plate = nvl(?, a.license_plate)
                and a.department_code between nvl(?, a.department_code) and nvl(?, a.department_code)
                and a.status = nvl(?, a.status)
                and a.asset_number = b.asset_number
                and d.parent_flex_value_low = b.category_segment4",
                [$year, $renewCode, $renewCode, $renewCode, $groupCode, $licensePlate, $departmentFrom, 
                    $departmentTo, $status]
            ) 
            ->orderByRaw("a.document_number desc nulls last")
            ->get();

        return $collection;
    }

    public function getProgramCodeAttribute()
    {
        return $this->fixProgramCode()[$this->row_type];
    }

    private static function fixProgramCode()
    {
        return [
            'INSURANCE_TYPE_CODE' => 'IRS0002',
            'PTIR_RENEW_CAR_INSURANCES' => 'IRS0002',
            'RENEW_CAR_ACT' => 'IRS0003',
            'PTIR_RENEW_CAR_ACT' => 'IRS0003',
            'RENEW_CAR_LICENSE_PLATE' => 'IRS0004',
            'PTIR_RENEW_CAR_LICENSE_PLATE' => 'IRS0004',
            'RENEW_CAR_INSPECTION' => 'IRS0005',
            'PTIR_RENEW_CAR_INSPECTION' => 'IRS0005',
        ];
    }
}
