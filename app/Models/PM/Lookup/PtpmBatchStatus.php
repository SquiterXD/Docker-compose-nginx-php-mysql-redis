<?php


namespace App\Models\PM\Lookup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtpmBatchStatus extends Model
{
    use HasFactory;

    protected $table = 'Ptpm_Batch_Status';
    public $timestamps = false;

    protected $fillable = [
    ];
}
