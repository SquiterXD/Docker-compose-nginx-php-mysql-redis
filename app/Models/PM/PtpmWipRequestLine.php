<?php
namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class PtpmWipRequestLine extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'PTPM_WIP_REQUEST_LINES';
    public $primaryKey = 'wip_req_line_id';
    public $timestamps = false;

    protected $casts = [
    ];
    protected $appends = [
        'can_cancel_line'
    ];

    public function header()
    {
        return $this->belongsTo(PtpmWipRequestHeader::class, 'wip_req_header_id','wip_req_header_id');
    }

    public function scopeIsInfSuccess($q)
    {
        return $q->where('interface_status', 'S');
    }


    function getCanCancelLineAttribute()
    {
        if ($this->cancel_flag == 'Y' && $this->interface_status == 'S') {
            return false;
        }
        return true;
    }
}
