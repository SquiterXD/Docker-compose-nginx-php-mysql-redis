<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PtirAssetHeadersView extends Model
{
    use HasFactory;
    protected $table = "oair.ptir_asset_headers_v";
    public $primaryKey = 'header_id';
    public $timestamps = false;

    private $limit = 50;

    public function getAllAssetHeaders($year, $strDate, $endDate, $strPolicy, $endPolicy, $asOfdate, $locationCode, $status)
    {
        $collection = DB::table('ptir_asset_headers_v as a')
            ->select(DB::raw("
                a.header_id,
                a.document_number,
                a.asset_status,
                a.status,
                a.year,
                a.policy_set_header_id,
                a.policy_set_number,
                a.policy_set_description,
                a.count_asset,
                a.total_cost,
                a.total_cover_amount,
                a.total_insu_amount,
                a.total_vat_amount,
                a.total_net_amount,
                a.total_rec_insu_amount,
                a.reference_document_number,
                to_char(nvl(a.as_of_date, sysdate), 'dd/mm/yyyy') as_of_date,
                to_char(b.start_date_active, 'dd/mm/yyyy') insurance_start_date,
                to_char(add_months(b.start_date_active, 12), 'dd/mm/yyyy') insurance_end_date,
                a.total_duty_amount,
                a.expense_flag,
                d.group_code,
                e.meaning as group_name
            "))
            ->leftjoin('ptir_effective_date as b', 'a.year', '=', 'b.lookup_code')
            ->leftjoin('ptir_asset_headers as c', 'a.header_id', '=', 'c.header_id')
            ->leftjoin('ptir_policy_set_headers as d', 'a.policy_set_header_id', '=', 'd.policy_set_header_id')
            ->leftjoin('ptir_groups as e', 'd.group_code', '=', 'e.lookup_code')
            ->whereRaw("
                a.year = nvl(?, a.year)
                and a.insurance_start_date >= nvl(to_date(?, 'dd/mm/yyyy'), a.insurance_start_date)
                and a.insurance_end_date <= nvl(to_date(?, 'dd/mm/yyyy'), a.insurance_end_date)
                and a.policy_set_header_id between nvl(?, a.policy_set_header_id) and nvl(?, a.policy_set_header_id)
                and a.as_of_date = nvl(to_date(?, 'dd/mm/yyyy'), a.as_of_date)
                and (a.location_code = nvl(?, a.location_code) or a.location_code is null)
                and a.status = nvl(?, a.status)",
                [$year, $strDate, $endDate, $strPolicy, $endPolicy, $asOfdate, $locationCode, $status]
            )
            // ->orderBy('a.document_number', 'asc')
            // ->orderBy('c.updated_at', 'desc')
            ->orderBy('a.policy_set_number', 'asc')
            ->get();

        return $collection;
    }
}
