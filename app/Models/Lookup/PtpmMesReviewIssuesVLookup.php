<?php


namespace App\Models\Lookup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class PtpmMesReviewIssuesVLookup extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'Ptpm_Mes_Review_Issues_V';
    public $timestamps = false;

    protected $fillable = [
    ];

    public function operationOfBatchV()
    {
        return $this->hasOne(PtpmOperationOfBatchVLookup::class, 'oprn_class_desc', 'wip_step');
    }
}
