<?php

namespace App\Models\IR\Views;

use App\Models\IR\PtirStockLines;
use App\Models\IR\Settings\PtirPolicySetHeaders;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class PtirStockHeadersView extends Model
{
    use HasFactory;
    protected $table = "ptir_stock_headers_v";
    public $primaryKey = 'header_id';
    public $timestamps = false;

    private $limit = 50;

    public function policy() {
        return $this->belongsTo(PtirPolicySetHeaders::class, 'policy_set_header_id', 'policy_set_header_id');
    }

    public function effectiveDate() {
        return $this->belongsTo(PtirEffectiveDate::class, "period_year", 'lookup_code');
    }

    public function stockLine() {
        return $this->hasMany(PtirStockLinesView::class, 'header_id', 'header_id');
    } 

    public function getLineCountAttribute () {
        return $this->stockLine()->count();
    }

    public function getAllStockHeader($year, 
                                      $periodName, 
                                      $insuStr, 
                                      $insuEnd, 
                                      $policyId, 
                                      $status, 
                                      $strDate, 
                                      $endDate, 
                                      $departmentFrom, 
                                      $departmentTo,
                                      $programCode)
    {
        $collection = DB::table('ptir_stock_headers_v as a')->select(DB::raw("a.header_id,
                                                            a.document_number,
                                                            INITCAP(a.status) status,
                                                            a.period_year,
                                                            a.period_name,
                                                            to_char(a.period_from, 'mm/yyyy') period_from,
                                                            to_char(a.period_to, 'mm/yyyy') period_to,
                                                            a.policy_set_header_id,
                                                            c.policy_set_number,
                                                            a.policy_set_description,
                                                            a.department_code,
                                                            a.department_desc,
                                                            to_char(b.start_date_active, 'dd/mm/yyyy') insurance_start_date,
                                                            to_char(add_months(b.start_date_active, 12), 'dd/mm/yyyy') insurance_end_date,
                                                            a.include_tax_flag,
                                                            a.inventory_amount,
                                                            a.inventory_cover_amount,
                                                            a.inventory_insu_amount,
                                                            a.manual_amount,
                                                            a.manual_cover_amount,
                                                            a.manual_insu_amount,
                                                            a.total_amount,
                                                            a.total_cover_amount,
                                                            a.total_insu_amount,
                                                            nvl(a.expense_flag, 'N') expense_flag,
                                                            a.reference_document_number,
                                                            (select count(*)
                                                             from ptir_stock_lines_v
                                                             where header_id = a.header_id) total_rec,
                                                            a.total_duty_amount,
                                                            a.total_vat_amount,
                                                            a.total_net_amount,
                                                            a.manual_vat_amount,
                                                            a.manual_duty_amount,
                                                            a.manual_net_amount,
                                                            a.inventory_vat_amount,
                                                            a.inventory_duty_amount,
                                                            a.inventory_net_amount"))
                                            ->leftjoin('ptir_effective_date as b', 'period_year', '=', 'b.lookup_code')
                                            ->leftjoin('ptir_policy_set_headers as c', 'a.policy_set_header_id', '=', 'c.policy_set_header_id')
                                            ->leftjoin('ptir_stock_headers as d', 'a.header_id', '=', 'd.header_id')
                                            ->whereRaw("a.period_year = nvl(?, a.period_year)
                                                        and (to_char(to_date(a.period_name, 'MON-yy'), 'mm/yyyy') = nvl(?, to_char(to_date(a.period_name, 'MON-yy'), 'mm/yyyy')) or a.period_name is null)
                                                        and a.insurance_start_date >= nvl(to_date(?, 'dd/mm/yyyy'), a.insurance_start_date)
                                                        and a.insurance_end_date <= nvl(to_date(?, 'dd/mm/yyyy'), a.insurance_end_date)
                                                        and a.policy_set_header_id = nvl(?, a.policy_set_header_id)
                                                        and a.status = nvl(?, a.status)
                                                        and a.period_from >= nvl(to_date(?, 'mm/yyyy'), a.period_from)
                                                        and trunc(a.period_to) <= nvl(last_day(to_date(?, 'mm/yyyy')), trunc(a.period_to))
                                                        and a.department_code between nvl(?, a.department_code) and nvl(?, a.department_code)
                                                        and nvl(a.program_code, ?) = ?",
                                                        [$year,
                                                         $periodName,
                                                         $insuStr,
                                                         $insuEnd,
                                                         $policyId,
                                                         $status,
                                                         $strDate,
                                                         $endDate,
                                                         $departmentFrom,
                                                         $departmentTo,
                                                         $programCode,
                                                         $programCode])
                                            ->orderBy('a.document_number', 'asc')
                                            ->orderBy('d.updated_at', 'desc')
                                            ->orderBy('c.policy_set_number', 'asc')
                                            ->get();

        return $collection;
    }

    public function ptirStockLines()
    {
        return $this->hasMany(PtirStockLinesView::class, 'header_id', 'header_id');
    }
    public function lines($id)
    {
       return  $ptirStockLinesView = (new PtirStockLinesView())->getAllStockLine($id,
        null,
        null,
        null,
        null,
        null,
        'IRP0001');
    }

}
