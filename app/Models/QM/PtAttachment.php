<?php

namespace App\Models\QM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class PtAttachment extends Model
{
    use HasFactory;

    protected $table  = 'PT_ATTACHMENTS';

    protected $primaryKey = false;
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['attachment_id', 'attachment_type', 'module_name', 'table_source_name', 
                            'table_source_id', 'file_name', 'description', 'attribute_category', 
                            'attribute1', 'attribute2', 'attribute3', 'attribute4', 'attribute5', 
                            'attribute6', 'attribute7', 'attribute8', 'attribute9', 'attribute10', 
                            'attribute11', 'attribute12', 'attribute13', 'attribute14', 'attribute15', 
                            'program_code', 'created_at', 'updated_at', 'deleted_at', 'created_by_id', 
                            'updated_by_id', 'deleted_by_id', 'web_batch_no', 'interface_status', 'interfaced_msg', 
                            'created_by', 'creation_date', 'last_updated_by',	'last_update_date'];


    public static function addSampleResultQualityLineImage($webBatchNo, $userId, $fndUserId, $programCode, $sampleNo, $resultId, $resultLineId, $imageNames) {

        // attribute1 => $sampleNo
        // attribute2 => $resultId

        $dateNow = Carbon::now();

        // IF ALREADY EXISTS => MARK AS DELETED
        PtAttachment::where('module_name', 'QM')
            ->where('table_source_name', 'PTQM_RESULT_QUALITY_LINES')
            ->where('program_code', $programCode)
            ->where('attribute1', $sampleNo)
            ->where('attribute2', $resultId)
            ->update([
                'deleted_at'    => $dateNow,
                'deleted_by_id' => $userId
            ]);

        // IF NOT EXISTS => RE-CREATE
        foreach($imageNames as $imageName) {

            $attachment = new PtAttachment;
            $attachment->attachment_type    = "image/jpeg";
            $attachment->module_name        = "QM";
            $attachment->table_source_name  = "PTQM_RESULT_QUALITY_LINES";
            $attachment->table_source_id    = $resultLineId;
            $attachment->file_name          = $imageName;
            $attachment->attribute1         = $sampleNo;
            $attachment->attribute2         = $resultId;
            $attachment->program_code       = $programCode;
            $attachment->created_by_id      = $userId;
            $attachment->updated_by_id      = $userId;
            $attachment->created_by         = $fndUserId;
            $attachment->last_updated_by    = $fndUserId;
            $attachment->created_at         = $dateNow;
            $attachment->updated_at         = $dateNow;
            $attachment->last_update_date   = $dateNow;
            $attachment->web_batch_no       = $webBatchNo;
            $attachment->save();

        }

    }

}
