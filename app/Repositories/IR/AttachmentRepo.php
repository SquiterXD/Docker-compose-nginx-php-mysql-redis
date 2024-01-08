<?php

namespace App\Repositories\IR;

use App\Models\IR\PtirAttachments;
use Carbon\Carbon;
use Intervention\Image\ImageManagerStatic as Image;

class AttachmentRepo
{
    public function create($model, $request, $pahtConfig, $profile)
    {
        $fileInsurance = $request->file('fileListInsurance');
        $fileAprrove = $request->file('fileListApprove');
        if(is_array($fileInsurance)) {
            foreach ($fileInsurance as $file) {
                if ($file) {
                    $type = 'insurance';
                    $this->upload($model, $file, $pahtConfig, $type, $profile);
                }
            }
        }
        if(is_array($fileAprrove)) {
            foreach ($fileAprrove as $file) {
                if ($file) {
                    $type = 'approve';
                    $this->upload($model, $file, $pahtConfig, $type, $profile);
                }
            }
        }
    }

    private function upload($model, $file, $pahtConfig, $type, $profile)
    {
        $fileExt = $file->getClientOriginalExtension();
        $originalName = $file->getClientOriginalName();
        $attachmentName = uniqid().'.'.$fileExt;
        $destinationPath = storage_path().'/app/public/'.$pahtConfig;
        // mkdir
        $isDir = \File::isDirectory($destinationPath);
        if(!$isDir){
            \Storage::makeDirectory($destinationPath);
        }
        // move to path
        $file->move(storage_path().'/app/public/'.$pahtConfig, $attachmentName);
        // store
        $attachment                     = new PtirAttachments;
        $attachment->from_program_code  = $profile->program_code;
        $attachment->document_header_id = $model->claim_header_id;
        $attachment->original_file_name = $originalName;
        $attachment->original_file_path = '/app/public/'.$pahtConfig;
        $attachment->path               = '/app/public/'.$pahtConfig.'/'.$attachmentName;
        $attachment->mine_type          = $fileExt;
        $attachment->model_path         = 'App\Models\IR';
        $attachment->file_name          = $attachmentName;
        $attachment->program_code       = $profile->program_code;
        $attachment->file_type          = $type;
        $attachment->created_by_id      = $profile->user_id;
        $attachment->created_by         = $profile->user_id;
        $attachment->last_updated_by    = $profile->user_id;
        $model->attachments()->save($attachment);
    }
}
