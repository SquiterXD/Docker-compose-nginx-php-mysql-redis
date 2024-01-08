<?php


namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtpmOperationOfBatchV extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'oapm.ptpm_operation_of_batch_v';
    public $timestamps = false;

    protected $fillable = [
        'oprn_class_desc',
        'oprn_class',
        'oprn_desc',
        'oprn_no',
        'oprn_id',
        'batch_no',
        'batch_id',
        'organization_id',
    ];
}
