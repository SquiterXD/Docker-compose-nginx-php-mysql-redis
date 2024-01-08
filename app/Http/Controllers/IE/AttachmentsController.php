<?php

namespace App\Http\Controllers\IE;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\DropzoneStoreRequest;

use App\Models\IE\Attachment;
use Image;

use App\Repositories\AttachmentRepo;
use Response;
use File;

class AttachmentsController extends Controller {

    //

    public function download($attachment_id){

        $attachment = Attachment::find($attachment_id);
        $filePath = storage_path() . $attachment->path . $attachment->file_name ;
        return response()->download($filePath, $attachment->original_name);

    }

    public function image($attachment_id)
    {
        $attachment = Attachment::find($attachment_id);
        $img = Image::make(storage_path($attachment->path.$attachment->file_name));

        return $img->response();

    }

    public function imageModal($attachment_id)
    {
        $attachment = Attachment::find($attachment_id);

        return view('attachments._image_modal',compact('attachment'));
    }

    public function remove(Request $request, $attachment_id){
        
        $attachment = Attachment::find($attachment_id);
        if($attachment){
            if (File::exists(storage_path($attachment->path.$attachment->file_name))){
                File::Delete(storage_path($attachment->path.$attachment->file_name));
            }
            $attachment->delete();
        }
        if($request->ajax()){
            return Response::json("success", 200);
        }else{
            return redirect()->back()->withInput();
        }
    }

}
