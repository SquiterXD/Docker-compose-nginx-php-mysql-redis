<?php

namespace App\Repositories\OM;

use Illuminate\Support\Facades\DB;
use App\Models\OM\AttachFiles;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AttachmentRepo
{
    public static function uploadAttachmentMultiple($fileAttachment,$header_id,$program_code)
    {
        $file_list = [];
        $file_id_list = [];

        $dateNow = now();

        $dataUser = getDefaultData('/users');

        $location = $dataUser->archive_directory.'/';

        foreach($fileAttachment as $key => $file) {

            $extension = $file->getClientOriginalExtension();

            // $filename = md5(time().$key.$dataUser->user_id).'.'.$extension;

            $filename = $file->getClientOriginalName();

            // $filename = $header_id.(Str::random(10)).'.'.$extension;

            $validExtension = array("jpeg","jpg", "bmp", "png", "pdf", "doc", "docx", "xls", "xlsx", "rar", "zip", "csv");

            // Check file extension
            if(in_array(strtolower($extension),$validExtension)){
                // File upload location

                // Upload file
                $file->move($location,$filename);

                $attachment = new AttachFiles();
                $attachment->attachment_program_code = $program_code;
                $attachment->header_id = $header_id;
                $attachment->file_name = $filename;
                $attachment->path_name = $location.$filename;
                $attachment->program_code = $program_code;
                $attachment->creation_date = $dateNow;
                $attachment->created_by = $dataUser->user_id;
                $attachment->last_updated_by = $dataUser->user_id;
                $attachment->save();

                $file_list[] = $attachment;
                $file_id_list[] = $attachment->attachment_id;              
                

                if ($program_code != 'OMP0038') {
                    $dataPost = [
                        'program_code' => $program_code,
                        'header_id' => $header_id,
                        'attachment' => $file,
                        'file_name' => $filename
                    ];

                    Http::attach(
                        'attachment' ,fopen($location.$filename, 'r'), '.'.$extension
                    )->post(env('APP_ECOM') . '/api/v1/upload-attachment-multiple',$dataPost);
                }
            }



        }
        
        // dd($file_id_list);
        if ($header_id) {
            $orderAttachment = AttachFiles::where('header_id','=',$header_id)->where('attachment_program_code', $program_code)->whereNull('deleted_at')->get();
        } else {
            $orderAttachment = AttachFiles::whereIn('attachment_id', $file_id_list)->where('attachment_program_code', $program_code)->whereNull('deleted_at')->get();
        }
        // dd($file_id_list, $orderAttachment);

        // $orderAttachment = AttachFiles::where('header_id','=',$header_id)->where('attachment_program_code', $program_code)->whereNull('deleted_at')->get();

        return response()->json(
            [
                'data'=>[
                    'file'=>$orderAttachment,
                    'path'=>url('/').'/'.$location,
                    'ids'=>$file_id_list,
                ],
                'message' => 'File upload successfully',
                'status'=>true
            ]
        );
    }
}