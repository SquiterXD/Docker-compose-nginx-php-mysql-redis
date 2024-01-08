<?php 

namespace App\Repositories\IE;

use App\Models\IE\Attachment;

class AttachmentRepo
{
    public function create($parent, $requestFile)
    {
        if(is_array($requestFile)) {
            foreach ($requestFile as $file) {
                if ($file) {
                    $this->upload($parent, $file);
                }
            }
        }else{
            $this->upload($parent, $requestFile);
        }
    }

    private function upload($parent, $file)
    {
        $fileExt         = $file->getClientOriginalExtension();
        $attachmentName = uniqid() . '.' . $fileExt;

        $year            = date('Y') ;
        $destinationPath = storage_path('/app/attachments/'.$year.'/');
        $isDir = \File::isDirectory($destinationPath);
        if(!$isDir){
            \Storage::makeDirectory('/attachments/'.$year.'/');
        }
        $uploadSuccess   = $file->move($destinationPath, $attachmentName);

        $user_id = \Auth::user()->user_id;
        $attachment = new Attachment();
        $attachment->original_name = $file->getClientOriginalName();
        $attachment->path = '/app/attachments/'.$year.'/' ;
        $attachment->mime_type = $fileExt;
        $attachment->file_name =  $attachmentName;
        $attachment->last_updated_by = $user_id;
        $attachment->created_by = $user_id;

        $parent->attachments()->save($attachment);
    }

}
