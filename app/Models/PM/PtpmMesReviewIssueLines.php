<?php


namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\PM\MtlSystemItemB;
class PtpmMesReviewIssueLines extends Model
{
    use HasFactory, Notifiable ;
    // , SoftDeletes;

    protected $table = 'oapm.ptpm_mes_review_issue_lines';
    protected $primaryKey = 'issue_line_id';
    public $incrementing = false;
    public $timestamps = false;

    protected $guarded = [];

//    protected $fillable = [
//        'issue_header_id',
//        'organization_id',
//        'subinventory_code',
//        'locator_id',
//        'locator_id',
//        'line_num',
//        'formula_id',
//        'formula_vers',
//        'formulaline_id',
//        'inventory_item_id',
//        'lot_number',
//        'confirm_qty',
//        'confirm_uom_code',
//    ];

    public function mfgFormulaV()
    {
        return $this->belongsTo(PtpmMfgFormulaV::class, 'issue_line_id', 'formulaline_id');
    }


    public function mfgFormula()
    {
        return $this->belongsTo(PtpmMfgFormulaV::class, 'formulaline_id', 'formulaline_id');
    }

    public function ptctMfgFormula()
    {
        return $this->belongsTo(PtctMfgFormulaV::class, 'formulaline_id', 'formulaline_id');
    }

    public function header()
    {
        return $this->belongsTo(PtpmMesReviewIssueHeaders::class, 'issue_header_id', 'issue_header_id');
    }

    public function uom()
    {
        return $this->hasOne(\App\Models\PD\Lookup\MtlUnitsOfMeasureVl::class, 'uom_code', 'confirm_uom_code');
    }


    

}
