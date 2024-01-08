<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PtirAssetAdjustLinesView extends Model
{
    use HasFactory;
    protected $table = "oair.ptir_asset_adjust_lines_v";
    public $primaryKey = 'line_id';
    public $timestamps = false;

    public function getAssetLines($id, $status, $year, $policyId, $input_status, $input_asset, $input_department)
    {
        $collection = DB::table('oair.ptir_asset_adjust_lines_v as a')
            ->select(DB::raw("
                a.line_id,
                a.header_id,
                a.status,
                a.asset_status,
                a.department_location_code,
                a.department_location_name,
                a.department_cost_code,
                a.department_cost_name,
                a.account_id,
                a.account_code,
                a.account_desc,
                a.asset_number,
                a.asset_description,
                a.department_code,
                a.department_name,
                a.location_id,
                a.location_code,
                a.location_name,
                a.category_id,
                a.cat_segment4 category_code,
                a.cat_segment4_desc category_description,
                a.original_quantity,
                a.original_cost,
                floor((adjustment_amount + 999)/1000)*1000 as coverage_amount,
                a.insurance_amount,
                a.vat_amount,
                a.net_amount,
                a.receivable_name,
                a.line_type,
                to_char(a.creation_date, 'DD-MM-YYYY : MMSS') creation_date,
                a.created_by,
                a.created_by_name,
                a.adjustment_source_type,
                to_char(a.adjustment_date, 'dd/mm/yyyy') adjustment_date,
                a.adjustment_amount,
                a.line_number,
                a.interface_status,
                a.ap_interface_status,
                a.ar_interface_status,
                a.gl_interface_status,
                nvl(a.expense_flag, 'N') expense_flag,
                c.include_tax_flag,
                a.revision,
                nvl(a.premium_rate, f.premium_rate) premium_rate,
                nvl(a.revenue_stamp, f.revenue_stamp) revenue_stamp,
                nvl(a.prepaid_insurance, f.prepaid_insurance) prepaid_insurance,
                nvl(a.tax, f.tax) tax,
                ((d.end_calculate_date - d.start_calculate_date))+1 calculate_days,
                a.duty_amount,
                to_number(to_char(last_day(to_date('12'||'/'||a.year, 'mm/yyyy')), 'DDD')) day_of_year,
                to_number(to_char(last_day(a.date_placed_in_service), 'dd')) day_of_month
            "))
            ->leftJoin('ptir_toat_fa_category_seg4_v as b', 'a.category_id', '=', 'b.value')
            ->leftjoin('ptir_policy_set_headers as c', 'a.policy_set_header_id', '=', 'c.policy_set_header_id')
            ->join('ptir_asset_adjust_headers_v as d', 'a.header_id', '=', 'd.header_id')
            ->leftjoin('ptir_policy_group_sets as e', 'a.policy_set_header_id', '=', 'e.policy_set_header_id')
            ->leftjoin('ptir_policy_group_lines as f', 'e.group_header_id', '=', 'f.group_header_id')
            ->whereRaw("nvl(a.header_id, '-1') = nvl(?, '-1')
                and a.status = nvl(?, a.status)
                and a.year = nvl(?, a.year)
                and a.policy_set_header_id = nvl(?, a.policy_set_header_id)
                and f.year = a.year",
                [$id, $status, $year, $policyId]);
        if (!empty($input_status)) {
            $collection->where('a.status', '=', $input_status);
        }
        if (!empty($input_asset)) {
            $collection->where('a.asset_number', '=', $input_asset);
        }
        if (!empty($input_department)) {
            $collection->where('a.department_code', '=', $input_department);
        }
        $collection = $collection->orderBy('a.line_type', 'asc')
            ->orderBy('a.line_id', 'asc')
            ->get();


        return $collection;
    }
}
