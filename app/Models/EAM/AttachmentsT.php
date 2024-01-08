<?php

namespace App\Models\EAM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class AttachmentsT extends Model
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

    public static function getNextLineNo($tranId, $programCode)
    {
        $lineNo = WorkRequestImage::where('ema_program_code', $programCode)->where('tran_id', $tranId)->max('line_no');
        $lineNo = $lineNo + 1;
        return $lineNo;
    }

    public static function index($tranId, $programCode)
    {
        $data = WorkRequestImage::where('ema_program_code', $programCode)
            ->where('tran_id', $tranId)
            ->orderBy('line_no')
            ->get();
        return $data;
    }
}
