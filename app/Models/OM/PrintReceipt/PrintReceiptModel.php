<?php

namespace App\Models\OM\PrintReceipt;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrintReceiptModel extends Model
{
    use HasFactory;

    protected $table = "ptom_release_receipts";
    public $primaryKey = 'receipt_id';
    public $timestamps = false;

    protected $fillable = [
        'release_flag',
        'reprint_flag',
        'print_flag',
        'printed_flag',
        'status',
        'last_updated_by',
        'last_update_date',
    ];
}
