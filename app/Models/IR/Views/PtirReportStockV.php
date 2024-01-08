<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lookup\PtpmItemNumberVLookup;
use App\Models\PM\MtlUnitsOfMeasureTl;

class PtirReportStockV extends Model
{
    use HasFactory;
    protected $table = 'OAIR.PTIR_REPORT_STOCK_V';

    public function itemNumberV()
    {
        return $this->belongsTo(PtpmItemNumberVLookup::class,'item_code', 'item_number');
    }
    public function uom()
    {
        return $this->belongsTo(MtlUnitsOfMeasureTl::class,'uom_code', 'uom_code');
    }
    public function scopeSelectField($q)
    {
        return $q->selectRaw("DISTINCT line_id , program_code, status, year, department_code,policy_set_header_id,sub_inventory_code,location_code,company_id
                    item_code,item_description,organization_code,organization_name,item_cat_code,item_cat_desc,original_quantity,primary_unit_of_measure,unit_price,
                    line_amount,coverage_amount"
                );

    }
}
