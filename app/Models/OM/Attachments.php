<?php

namespace App\Models\OM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachments extends Model
{
    use HasFactory;

    protected $table = 'ptom_attachments';
    public $primaryKey = 'attachment_id';
    public $timestamps = false;

    public function create($parent, $requestFile, $type, $lineId)
    {
        if(is_array($requestFile)) {
            foreach ($requestFile as $file) {
                if ($file) {
                    $this->upload($parent, $file, $type, $lineId);
                }
            }
        }else{
            $this->upload($parent, $requestFile, $type, $lineId);
        }
    }

    private function upload($parent, $file, $type, $lineId)
    {
        $fileExt         = $file->getClientOriginalExtension();
        $fileName        = $file->getClientOriginalName();
        $attachmentName  = uniqid() . '.' . $fileExt;

        $year            = date('Y') ;
        $destinationPath = storage_path('app/attachments/'.$year.'/'.$parent['program_code'].'/');

        $isDir = \File::isDirectory($destinationPath);
        if(!$isDir){
            \Storage::makeDirectory('/attachments/'.$year.'/'.$parent['program_code'].'/');
        }
        $uploadSuccess                              = $file->move($destinationPath, $attachmentName);
        $attachment                                 = new Attachments();
        $attachment->attachment_program_code        = $parent['program_code'];
        $attachment->header_id                      = $parent['claim_header_id'];
        $attachment->line_id                        = $lineId;
        $attachment->file_name                      = $attachmentName;
        $attachment->path_name                      = $destinationPath;
        if($type == "picturePackage"){
            $attachment->attribute1                 = '1';
        }
        if($type == "pictureCase"){
            $attachment->attribute1                 = '2';
        }
        if($type == "pictureBroken"){
            $attachment->attribute1                 = '3';
        }
        $attachment->program_code                   = $parent['program_code'];
        $attachment->created_by                     = $parent['created_by'];
        $attachment->last_updated_by                = $parent['last_updated_by'];
        $attachment->last_update_date               = $parent['last_update_date'];
        $attachment->save();
    }
}
