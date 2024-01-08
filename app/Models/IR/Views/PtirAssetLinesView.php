<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PtirAssetLinesView extends Model
{
    use HasFactory;
    protected $table = "oair.ptir_asset_lines_v";
    public $primaryKey = 'line_id';
    public $timestamps = false;

    private $limit = 50;

    public function getAssetLine($headerId, $year, $status, $policyId, $input_status, $input_asset, $input_department)
    {
        $collection = DB::table('oair.ptir_asset_lines_v as a')
            ->select(DB::raw("
                a.line_id,
                a.line_number,
                a.document_number,
                a.asset_status,
                a.status,
                a.department_location_code,
                a.department_location_name,
                a.department_cost_code,
                a.department_cost_name,
                a.account_id,
                a.account_code,
                a.account_desc,
                a.account_code_desc,
                a.asset_number,
                a.department_code,
                a.department_name,
                a.location_id,
                a.location_code,
                a.location_name,
                a.category_id,
                a.category_code,
                a.category_description,
                a.quantity,
                a.current_cost,
                floor((adjustment_amount + 999)/1000)*1000 as coverage_amount,
                a.insurance_amount,
                a.vat_amount,
                a.net_amount,
                a.receivable_name,
                a.line_type,
                to_char(a.creation_date, 'DD-MM-YYYY : MMSS') creation_date,
                a.created_by,
                a.adjustment_source_type,
                to_char(a.adjustment_date, 'dd/mm/yyyy') adjustment_date,
                a.adjustment_amount,
                a.adjustment_type,
                a.adjustment_cost,
                nvl(a.expense_flag, 'N') expense_flag,
                a.adjustment_line_id,
                c.include_tax_flag,
                nvl(a.premium_rate, e.premium_rate) premium_rate,
                nvl(a.revenue_stamp, e.revenue_stamp) revenue_stamp,
                nvl(a.prepaid_insurance, e.prepaid_insurance) prepaid_insurance,
                nvl(a.tax, e.tax) tax,
                a.duty_amount,
                to_number(to_char(last_day(to_date('12'||'/'||a.year, 'mm/yyyy')), 'DDD')) day_of_year,
                to_number(to_char(last_day(a.date_placed_in_service), 'dd')) day_of_month"
            ))
            ->leftJoin('ptir_toat_fa_category_seg4_v as b', 'a.category_code', '=', 'b.value')
            ->leftjoin('ptir_policy_set_headers as c', 'a.policy_set_header_id', '=', 'c.policy_set_header_id')
            ->leftjoin('ptir_policy_group_sets as d', 'a.policy_set_header_id', '=', 'd.policy_set_header_id')
            ->leftjoin('ptir_policy_group_lines as e', 'd.group_header_id', '=', 'e.group_header_id')
            ->whereRaw("
                (nvl(a.header_id, '-1') = nvl(?, '-1'))
                and a.year = nvl(?, a.year)
                and (a.status = nvl(?, a.status)
                        or a.status is null)
                and (a.policy_set_header_id = nvl(?, a.policy_set_header_id)
                        or a.policy_set_header_id is null)
                and a.year = e.year",
                [$headerId, $year, $status, $policyId]
            );

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
            ->orderBy('a.line_id', 'asc')->get();

        return $collection;
    }
}
