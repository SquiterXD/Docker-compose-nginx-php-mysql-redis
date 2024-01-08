<?php
namespace App\Models\PD\ExpFmls;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;
use PDO;
use App\Repositories\PD\ExpFormulaRepository;

class PtpdFormulaHV extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'PTPD_FORMULA_H_V';
    public $primaryKey = 'formula_id';
    public $timestamps = false;
    protected $dates = ['formula_approval_date', 'formula_start_date', 'formula_creation_date', 'formula_last_update_date'];

    protected $appends = [
        'formula_approval_date_format',
        'formula_start_date_format',
        'formula_creation_date_format',
        'formula_last_update_date_format',
        'invoice_flag_icon_html'
    ];


    public function uomDetail()
    {
        return $this->hasOne(\App\Models\PD\Lookup\MtlUnitsOfMeasureVl::class, 'uom_code', 'uom');
    }


    public function getFormulaApprovalDateFormatAttribute()
    {
        if ($this->formula_approval_date) {
            return parseToDateTh($this->formula_approval_date);
        }
        return;
    }

    public function getFormulaStartDateFormatAttribute()
    {
        if ($this->formula_start_date) {
            return parseToDateTh($this->formula_start_date);
        }
        return;
    }

    public function getFormulaCreationDateFormatAttribute()
    {
        if ($this->formula_creation_date) {
            return parseToDateTh($this->formula_creation_date);
        }
        return;
    }

    public function getFormulaLastUpdateDateFormatAttribute()
    {
        if ($this->formula_last_update_date) {
            return parseToDateTh($this->formula_last_update_date);
        }
        return;
    }

    function getInvoiceFlagIconHtmlAttribute()
    {
        return view('shared._status_active', ['isActive' => optional($this)->invoice_flag == 'Y', 'size' =>1])->render();
    }
}
