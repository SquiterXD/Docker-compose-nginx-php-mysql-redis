<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PtirAssetAdjustHeadersView extends Model
{
    use HasFactory;
    protected $table = "oair.ptir_asset_adjust_headers_v";
    public $primaryKey = 'header_id';
    public $timestamps = false;

    private $limit = 50;

    public function getAllAssetHeaders($year, $revision, $policyIdFrom, $policyIdTo, $strCal, $endCal,
                                       $strAd, $endAd, $locationCode, $status)
    {
        $collection = DB::table('ptir_asset_adjust_headers_v as a')->select(DB::raw("a.header_id, 
                                                                                   a.document_number,
                                                                                   a.status, 
                                                                                   a.year,
                                                                                   a.policy_set_header_id, 
                                                                                   a.policy_set_number, 
                                                                                   a.policy_set_description,
                                                                                   a.count_asset,
                                                                                   to_char(a.start_calculate_date, 'dd/mm/yyyy') start_calculate_date, 
                                                                                   to_char(a.end_calculate_date, 'dd/mm/yyyy') end_calculate_date, 
                                                                                   to_char(a.start_addition_date, 'dd/mm/yyyy') start_addition_date, 
                                                                                   to_char(a.end_addition_date, 'dd/mm/yyyy') end_addition_date,
                                                                                   a.total_original_cost, 
                                                                                   a.total_adjustment_cost, 
                                                                                   a.total_insu_amount, 
                                                                                   a.total_cover_amount,
                                                                                   a.total_vat_amount, 
                                                                                   a.total_net_amount, 
                                                                                   a.total_rec_insu_amount, 
                                                                                   a.reference_document_number, 
                                                                                   a.revision,
                                                                                   a.total_duty_amount,
                                                                                   a.expense_flag,
                                                                                   d.group_code,
                                                                                   e.meaning as group_name"))
                                                 ->leftJoin('ptir_asset_headers as b', 'a.header_id', '=', 'b.header_id')
                                                 ->leftjoin('ptir_policy_set_headers as d', 'a.policy_set_header_id', '=', 'd.policy_set_header_id')
                                                ->leftjoin('ptir_groups as e', 'd.group_code', '=', 'e.lookup_code')
                                                 ->whereRaw("a.year = nvl(?, a.year)
                                                             and (a.revision = nvl(?, a.revision) or a.revision is null)
                                                             and (a.policy_set_header_id between nvl(?, a.policy_set_header_id) 
                                                                  and nvl(?, a.policy_set_header_id))
                                                             and ((a.start_calculate_date >= nvl(to_date(?, 'dd/mm/yyyy'), a.start_calculate_date) or a.start_calculate_date is null) 
                                                                  and (a.end_calculate_date <= nvl(to_date(?, 'dd/mm/yyyy'), a.end_calculate_date) or a.end_calculate_date is null))
                                                             and ((a.start_addition_date >= nvl(to_date(?, 'dd/mm/yyyy'), a.start_addition_date) or a.start_addition_date is null)
                                                                  and (a.end_addition_date <= nvl(to_date(?, 'dd/mm/yyyy'), a.end_addition_date)) or a.end_addition_date is null)
                                                             and (a.location_code = nvl(?, a.location_code) or a.location_code is null)
                                                             and (a.status = nvl(?, a.status) or a.status is null) ",
                                                             [$year, $revision, $policyIdFrom, $policyIdTo, $strCal, $endCal,
                                                              $strAd, $endAd, $locationCode, $status])
                                                 ->orderBy('a.document_number', 'asc')
                                             //     ->orderBy('b.updated_at', 'desc')
                                                 ->orderBy('a.revision')
                                                 ->orderBy('a.policy_set_number', 'asc')
                                                 ->get();
                
        return $collection;
    }

    public function getRevisionLov()
    {
          $collection = PtirAssetAdjustHeadersView::select(DB::raw('distinct nvl(revision,1) revision'))->get();

          return $collection;
    }
}
