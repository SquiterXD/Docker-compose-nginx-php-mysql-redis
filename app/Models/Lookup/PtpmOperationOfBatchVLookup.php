<?php


namespace App\Models\Lookup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtpmOperationOfBatchVLookup extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'OAPM.ptpm_operation_of_batch_v';
    public $timestamps = false;

    protected $fillable = [
    ];
}