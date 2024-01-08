<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB; 
class PtirStockLinesView extends Model
{
    use HasFactory;
    protected $table = "ptir_stock_lines_v";
    public $primaryKey = 'line_id';
    public $timestamps = false;

    private $limit = 50;

     public function uomData() {
          return $this->belongsTo(PtirUomView::class, 'uom', 'uom_code');
     }

     public function assetGroup() {
          return $this->belongsTo(PtirAssetGroupView::class, 'asset_group_code', 'value');
     }

    public function getAllStockLine($id, 
                                    $periodYear, 
                                    $periodFrom, 
                                    $periodTo, 
                                    $status, 
                                    $subGroupCode,
                                    $programCode)
    {
            $collection = DB::table("ptir_stock_lines_v as a")->select(DB::raw("a.header_id, 
                                                              a.line_id,
                                                              a.line_number,
                                                              INITCAP(a.status) status, 
                                                              to_char(a.period_from, 'mm/yyyy') period_from,
                                                              to_char(a.period_to, 'mm/yyyy') period_to,
                                                              a.organization_id, 
                                                              a.organization_code, 
                                                              a.organization_name, 
                                                              a.subinventory_code, 
                                                              a.subinventory_desc, 
                                                              a.sub_group_code, 
                                                              a.sub_group_desc, 
                                                              a.item_id, 
                                                              a.item_code, 
                                                              a.item_description, 
                                                              b.description as uom,
                                                              b.uom_code,
                                                              a.original_qty, 
                                                              a.unit_price, 
                                                              a.amount, 
                                                              a.coverage_amount,
                                                              to_char(a.calculate_start_date, 'dd/mm/yyyy') calculate_start_date,
                                                              to_char(a.calculate_end_date, 'dd/mm/yyyy') calculate_end_date,
                                                              a.line_type,
                                                              to_char(add_months(a.creation_date, 6516), 'DD-MM-YYYY:MMSS') creation_date,
                                                              a.created_by, 
                                                              a.line_amount, 
                                                              a.period_name,
                                                              a.calculate_days,
                                                              a.premium_rate,
                                                              a.revenue_stamp,
                                                              a.prepaid_insurance,
                                                              a.tax,
                                                              a.asset_group_code,
                                                              d.description asset_group_name,
                                                              a.stock_list_description,
                                                              c.include_tax_flag,
                                                              nvl(a.expense_flag, 'N') expense_flag"))
                                            ->leftjoin('ptir_uom_v as b', 'uom', '=', 'b.uom_code')
                                            ->join('ptir_stock_headers_v as c', 'a.header_id', '=', 'c.header_id')
                                            ->leftjoin('ptir_asset_group_v as d', 'a.asset_group_code', '=', 'd.value')
                                            ->whereRaw("nvl(a.header_id, -1) = nvl(?, -1) 
                                                        and a.period_year = nvl(?, a.period_year)
                                                        and (a.period_from >= nvl(to_date(?, 'mm/yyyy'), a.period_from)
                                                             or a.period_from is null)
                                                        and (trunc(a.period_to) <= nvl(last_day(to_date(?, 'mm/yyyy')), trunc(a.period_to)) 
                                                             or a.period_to is null)
                                                        and (a.status = nvl(?, a.status)
                                                             or a.status is null)
                                                        and (a.sub_group_code = nvl(?, a.sub_group_code)
                                                             or a.sub_group_code is null)
                                                        and nvl(a.program_code, ?) = ?",
                                                        [$id, 
                                                         $periodYear, 
                                                         $periodFrom, 
                                                         $periodTo, 
                                                         $status, 
                                                         $subGroupCode,
                                                         $programCode,
                                                         $programCode])
                                            ->orderBy('line_type', 'asc')
                                            ->orderBy('line_id', 'asc')
                                            ->get();
                                                 
        return $collection;    
    }

    public function getSubGroupLov($id, $status, $subGroupCode) 
    {

        $subGroupCode = isset($subGroupCode) ? $subGroupCode.'%' : '%';
        $collection = DB::table('ptir_stock_lines_v as a')->select(DB::raw('distinct(a.sub_group_code), a.sub_group_desc'))
                                                            ->join('ptir_stock_lines as b', 'a.line_id', '=', 'b.line_id')
                                                            ->where('a.header_id', $id)
                                                            ->whereRaw('a.status = nvl(?, a.status)', [$status])
                                                            ->whereRaw('a.sub_group_code like ? or a.sub_group_desc like ?', [$subGroupCode, $subGroupCode])
                                                            ->get();

        return $collection;    
    }

    public function interestRate($policyLine, $rate=null)
    {
        // $rate = 100*0.01;
        if ($rate == null) {
            $rate = 100*0.01;
        }
        // (62,600.00 * (0.0849 * 0.01)) * 100% * 50%

        if ($this->line_type == 'INVENTORY') {
            $total = ($this->coverage_amount* ($policyLine->premium_rate * 0.01)) * $rate * (50*0.01);
            // $total = (($this->coverage_amount *  $policyLine->premium_rate) * (1)) * ($rate* $policyLine->prepaid_insurance*0.01);
            // dd($total , $policyLine->coverage_amount,  $policyLine->premium_rate);

            return $total;
        }
        // (62,600.00 * (0.0849 * 0.01)) * 150/365 * 100% * 50%
        $total = ($this->coverage_amount* ($policyLine->premium_rate * 0.01)) * ($this->calculate_days / 365) * $rate * (50*0.01);
        // $total = ($this->coverage_amount *  $policyLine->premium_rate) * ($this->calculate_days / 365) * ($rate* $policyLine->prepaid_insurance*0.01);
        return $total;
    }
                                             
}
