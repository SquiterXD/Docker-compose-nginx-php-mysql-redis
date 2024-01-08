<?php

namespace App\Http\Controllers\OM;

use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\OM\AttachmentRepo;
use App\Models\OM\AttachFiles;
use Carbon\Carbon;
use App\Models\OM\Attachments;

class AttachmentController extends Controller
{
    public function uploadAttachmentMultiple(Request $request)
    {
        if($request->hasFile('attachment')) {

            $fileAttachment = $request->file('attachment');
            if($request->attachment_program_code != ''){
                $program_code = $request->attachment_program_code;
            }else{
                $program_code = 'OMP0066';
            }
            // dd($program_code, $request->all());

            if($request->order_header_id && $request->order_header_id != 'undefined'){
                $header_id = $request->order_header_id;

            }elseif($request->order_id && $request->order_id != 'undefined'){
                $header_id = $request->order_id;
                
            }else{
                $header_id = $request->header_id != 'undefined' ? $request->header_id : '';
            }

            return AttachmentRepo::uploadAttachmentMultiple($fileAttachment,$header_id,$program_code);
            // return response()->json(['data'=>$fileAttachment,'message' => '','status'=>true]);

        }else{
            return response()->json(['data'=>[],'message' => 'File not found','status'=>false]);
        }

    }

    public function removeAttachmentFile($id='')
    {
        $attachment = AttachFiles::where('attachment_id','=',$id)->first();

        $now = Carbon::now();

        if(isset($attachment) && !empty($attachment)){
            $attachment->deleted_at = $now;
            $attachment->save();
        }

    }
    
    public function image(Attachments $attachment)
    {
        // if ( !\File::exists(storage_path($attachment['path_name'].$attachment->file_name)) ) {
        //     return redirect()->back()->withErrors('ไม่พบไฟล์บน Server');
        // }
        // $img = Image::make(storage_path($attachment['path_name'].$attachment->file_name));
        // return $img->response();

        if ( !\File::exists($attachment['path_name'].$attachment->file_name) ) {
            return redirect()->back()->withErrors('ไม่พบไฟล์บน Server');
        }
        $img = Image::make($attachment['path_name'].$attachment->file_name);
        return $img->response();
    }

}


