<?php
namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class PtpmSendCigaretteLT extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'PTPM_SEND_CIGARETTE_L_T';
    public $primaryKey = 'storage_line_id';
    public $timestamps = false;

    protected $casts = [
    ];

    public function header()
    {
        return $this->belongsTo(PtpmWipRequestHeader::class, 'wip_req_header_id','wip_req_header_id');
    }

    public function scopeIsInfSuccess($q)
    {
        return $q->where('interface_status', 'S');
    }
}
