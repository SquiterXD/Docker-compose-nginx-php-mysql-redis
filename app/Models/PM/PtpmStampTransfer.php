<?php


namespace App\Models\PM;

use App\Models\PM\Cast\DateCast;
use App\Models\PM\Lookup\PtinvItemcatMatgroupV;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtpmStampTransfer extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'ptpm_stamp_transfer';
//    protected $primaryKey = ['USED_DATE', 'MACHINE_GROUP', 'DISCRIPTION1'];
    protected $primaryKey = 'stamp_transfer_id';
    public $incrementing = false;
    public $timestamps = false;

    protected $guarded = [];
}
