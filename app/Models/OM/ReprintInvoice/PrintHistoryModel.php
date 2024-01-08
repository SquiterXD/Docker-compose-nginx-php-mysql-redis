<?php

namespace App\Models\OM\ReprintInvoice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrintHistoryModel extends Model
{
    use HasFactory;

    protected $table = "PTOM_PRINT_HISTORY";
    public $primaryKey = 'print_id';
    public $timestamps = false;

    protected $fillable = [
        'from_program_code',
        'print_revision'   ,
        'document_id'      ,
        'print_date'       ,
        'print_by'         ,
        'print_flag'       ,
        'program_code'     ,
        'attribute1'       ,
        'created_by'       ,
        'creation_date'    ,
        'last_updated_by'  ,
        'last_update_date' ,
    ];
}
