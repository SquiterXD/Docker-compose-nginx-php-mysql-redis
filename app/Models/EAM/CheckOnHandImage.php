<?php

namespace App\Models\EAM;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;


class CheckOnHandImage extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'pteam_attachments_t';
    public $primaryKey = 'attachment_id';
    public $timestamps = true;
    protected $dates = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ema_program_code',
        'tran_id',
        'line_no',
        'original_name',
        'path',
        'mime_type',
        'file_name',
        'work_request_number',
        'last_updated_by',
        'program_code',
        'created_by',
        'created_by_id',
        'web_batch_no'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'web_batch_no'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    public static function getNextLineNo($workRequestId)
    {
        $lineNo = CheckOnHandImage::where('ema_program_code','EAM0001')->where('tran_id',$workRequestId)->max('line_no');
        $lineNo = $lineNo + 1;
        return $lineNo;
    }

    public static function getWebBatchNo()
    {
        $dateTime = Carbon::now('Asia/Bangkok')->isoFormat('DD-MMM-YYYY h:mm:ss.SSSSSS A');
        return Str::upper('pteam_check_on_hand_v_' . $dateTime);
    }
}
