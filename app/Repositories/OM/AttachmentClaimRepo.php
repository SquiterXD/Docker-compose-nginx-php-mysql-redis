<?php

namespace App\Repositories\OM;

use Illuminate\Support\Facades\DB;
use App\Models\OM\AttachFiles;

class AttachmentClaimRepo
{
    public static function uploadAttachmentMultiple($fileAttachment, $header_id, $line_id, $program_code, $attr)
    {
        $file_list = [];

        $dateNow = now();
        try {
            $dataUser = getDefaultData('/users');

        } catch (\Throwable $th) {
            $dataUser = new \stdClass();
            $dataUser->archive_directory = 'public';
            $dataUser->user_id = 0;
        }

        $location = $dataUser->archive_directory . '/'. $program_code . '/' . now()->format("Y") . "/". now()->format("m");
        foreach ($fileAttachment as $key => $file) {

            $extension = $file->getClientOriginalExtension();

            $filename = \Str::random(3).md5(time() . $key . $dataUser->user_id) . '.' . $extension;

            $validExtension = array("jpeg", "bmp", 'jpg', "png", "pdf", "doc", "docx", "xls", "xlsx", "rar", "zip", "csv", 'gif');
            // Check file extension
            if (in_array(strtolower($extension), $validExtension)) {
                // File upload location
                // switch ($key) {
                //     case 'fs_submit':
                //         $attr = 1;
                //         break;
                //     case 'bs_submit':
                //         $attr = 2;
                //         break;
                //     case 'gd_submit':
                //         $attr = 3;
                //         break;
                //     default:
                //         $attr = '';
                //         break;
                // }
                // Upload file

                $path = $file->store($location);
                
                $attachment = new AttachFiles();
                $attachment->attachment_program_code = $program_code;
                $attachment->header_id = $header_id;
                $attachment->line_id = $line_id;
                $attachment->file_name = $filename;
                $attachment->attribute1 = $attr;
                $attachment->path_name = $path;
                $attachment->program_code = $program_code;
                $attachment->creation_date = $dateNow;
                $attachment->created_by = $dataUser->user_id;
                $attachment->last_updated_by = $dataUser->user_id;
                $attachment->save();
                $file_list[] = $filename;
            }
        }

        // $orderAttachment = OrdersAttachment::where('header_id','=',$header_id)->get();
        return response()->json(
            [
                'data' => [
                    'file' => $file_list,
                    'path' => url($location.'/'. $filename ) ,
                ],
                'message' => 'File upload successfully',
                'status' => true
            ]
        );
    }
}
