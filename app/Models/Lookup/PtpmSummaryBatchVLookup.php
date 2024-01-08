<?php


namespace App\Models\Lookup;

use App\Models\PM\Cast\DateCast;
use App\Models\PM\Lookup\PtinvItemcatMatgroupV;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtpmSummaryBatchVLookup extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'OAPM.PTPM_SUMMARY_BATCH_V';
    protected $primaryKey = 'batch_no';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
    ];
}
