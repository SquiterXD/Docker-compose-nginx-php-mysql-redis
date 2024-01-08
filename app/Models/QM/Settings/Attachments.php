<?php

namespace App\Models\QM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\QM\Settings\ProgramsInfoV;

class Attachments extends Model
{
    use HasFactory;

    protected $table = 'pt_attachments';
    public $primaryKey = 'attachment_id';
    public $timestamps = false;

    protected $fillable = [
        'attachment_id',
        'attachment_type',
        'module_name',
        'table_source_name',
        'table_source_id',
        'file_name',
        'description',
        'attribute_category',
        'program_code',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by_id',
        'updated_by_id',
        'web_batch_no',
        'interface_status',
        'interfaced_msg',
        'created_by',
        'last_updated_by',
        'last_update_date'
    ];

    public function createFileDefineTests($parent, $requestFile)
    {
        if(is_array($requestFile)) {
            foreach ($requestFile as $file) {
                if ($file) {
                    $this->uploadFileDefineTests($parent, $file);
                }
            }
        }else{
            $this->uploadFileDefineTests($parent, $requestFile);
        }
    }

    private function uploadFileDefineTests($parent, $file)
    {
        if(     $parent->program_code=='QMS0007' || $parent->program_code=='QMS0012' || $parent->program_code=='QMS0009'
            ||  $parent->program_code=='QMS0010' ||  $parent->program_code=='QMS0011'){
            $fileExt = $file->getClientOriginalExtension();
            $attachmentName = uniqid() . '.' . $fileExt;
            $destinationPath = storage_path('app/attachments/'.$parent['program_code'].'/');
            $isDir = \File::isDirectory($destinationPath);
            if(!$isDir){
                \Storage::makeDirectory('/attachments/'.$parent['program_code'].'/');
            }
            $uploadSuccess   = $file->move($destinationPath, $attachmentName);
            $parent->image_file_name    =   $attachmentName;

            $parent->save();
        }
    }

    public function createCheckPoints($parent, $requestFile)
    {
        $this->uploadFileCheckPoints($parent, $requestFile);
    }

    private function uploadFileCheckPoints($parent, $file)
    {
        $fileExt         = $file->getClientOriginalExtension();
        $attachmentName  = uniqid() . '.' . $fileExt;
        $moduleName = ProgramsInfoV::where('program_code',$parent['program_code'])
                                    ->value('module_name');
        $tableSourceName = ProgramsInfoV::where('program_code',$parent['program_code'])
                                    ->value('source_name');
        $destinationPath = storage_path('app/attachments/'.$parent['program_code'].'/');
        $isDir = \File::isDirectory($destinationPath);
        if(!$isDir){
            \Storage::makeDirectory('/attachments/'.$parent['program_code'].'/');
        }
        $uploadSuccess = $file->move($destinationPath, $attachmentName);

        $parent->image_file_name = $attachmentName;
        $parent->save();
    }

}
