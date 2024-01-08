<?php

namespace App\Http\Controllers\OM\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\OM\AttachmentRepo;
use App\Models\OM\AttachFiles;
use Carbon\Carbon;
use Illuminate\Support\Str;

class AttachmentController extends Controller
{

    public function uploadAttachmentMultiple(Request $request)
    {

        if($request->hasFile('attachment')) {

            $file_list = [];

            if ($file = $request->file('attachment')) {

                $program_code = $request->program_code;
                $header_id = $request->header_id;
                $location = 'uploads/ecom/'.$header_id.'/'.$program_code.'/';

                $dateNow = now();

                // foreach($request->file('attachment') as $key => $file)
                // {
                    $extension = $file->getClientOriginalExtension();

                    $filename = $request->file_name;
                    // $header_id.(Str::random(10))$header_id.(Str::random(10))

                    $validExtension = array("jpeg",'jpg', "bmp", "png", "pdf", "doc", "docx", "xls", "xlsx", "rar", "zip", "csv");

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
                        $attachment->created_by = 1;
                        $attachment->last_updated_by = 1;
                        $attachment->save();

                        $file_list[] = $filename;
                    }
                // }

            }

            return response()->json(['data'=>$file_list,'message' => '','status'=>true]);

        }else{
            return response()->json(['data'=>[],'message' => 'File not found','status'=>false]);
        }

    }

    public function removeAttachmentFile(Request $request)
    {
        $attachment = AttachFiles::where('header_id','=',$request->header_id)->where('file_name','=',$request->file_name)->first();

        $now = Carbon::now();

        if(isset($attachment) && !empty($attachment)){
            $attachment->deleted_at = $now;
            $attachment->save();
        }

    }
}