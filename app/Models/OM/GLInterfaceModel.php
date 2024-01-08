<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GLInterfaceModel extends Model
{
    use HasFactory;

    protected $table = 'ptom_gl_interfaces';
    public $primaryKey = 'interface_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_updated_date'];
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_updated_date';

    protected $fillable = [
        'document_header_id',
        'document_line_id',
        'group_id',
        'interface_module',
        'org_id',
        'ledger_name',
        'accounting_date',
        'period_name',
        'currency_code',
        'actual_flag',
        'encumbrance_type',
        'user_je_category_name',
        'user_je_source_name',
        'batch_name',
        'batch_description',
        'journal_name',
        'journal_description_head',
        'user_currency_conversion_type',
        'currency_conversion_rate',
        'currency_conversion_date',
        'je_line_num',
        'code_combination_id',
        'segment1',
        'segment2',
        'segment3',
        'segment4',
        'segment5',
        'segment6',
        'segment7',
        'segment8',
        'segment9',
        'segment10',
        'segment11',
        'segment12',
        'entered_dr',
        'entered_cr',
        'accounted_dr',
        'accounted_cr',
        'journal_description_line',
        'program_code',
        'created_by',
        'last_updated_by',
        'web_batch_no',
        'interface_status',
        'interfaced_msg',
        'line_attribute1',
        'line_attribute2',
        'line_attribute3',
        'line_attribute4',
        'line_attribute5',
        'line_attribute6',
    ];
}
