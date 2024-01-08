<?php

namespace App\Http\Controllers\EAM\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

use App\Models\EAM\WorkRequestImage;
use App\Models\EAM\AssetT;

class SetupController extends Controller
{
    
    public function images($id)
    {
        $programCode = 'EAM0003';
        $images = WorkRequestImage::select([
            'attachment_id',
            'original_name',
        ])
            ->where('ema_program_code', $programCode)
            ->where('tran_id', $id)
            ->orderBy('line_no')
            ->get();
        return response()->json(['data' => $images]);
    }

    public function uploadImage(Request $request, $id)
    {
        $year = date("Y");
        try {
            $programCode = $request->program_code;
            /* store image file */
            $imageName = uniqid() . '.' . $request->image->extension();
            $originalName = $request->image->getClientOriginalName();
            $imagePath = 'attachments/'.$year.'/'.$request['program_code'];
            $request->image->storeAs($imagePath, $imageName);

            /* store image name in database */
            $image = new WorkRequestImage();
            $image->ema_program_code = $programCode;
            $image->tran_id = $id;
            $image->line_no = WorkRequestImage::getNextLineNo($id, $programCode);
            $image->original_name = $originalName;
            $image->path = $imagePath;
            $image->mime_type = $request->image->extension();
            $image->file_name = $imageName;
            $image->program_code = $programCode;
            $image->created_by = auth()->user()->fnd_user_id;
            $image->created_by_id = auth()->user()->user_id;
            $image->last_updated_by = auth()->user()->fnd_user_id;
            $image->web_batch_no = AssetT::getWebBatchNo();
            $image->save();

            return response()->json(['data' => $image]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 400);
        }
    }

    public function showImage($imageId)
    {
        $image = WorkRequestImage::find($imageId);
        $filename = $image->file_name;
        $path = storage_path('app/'. $image->path .'/'. $filename);
        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    public function deleteImage($imageId)
    {
        $image = WorkRequestImage::find($imageId);
        if (Storage::exists($image->path .'/'. $image->file_name)) {
            Storage::delete($image->path .'/'. $image->file_name);
            $image->delete();
            return response()->json(['message' => 'Success.', 'code' => 200]);
        } else {
            $image->delete();
            return response()->json(['message' => 'File does not exists.', 'code' => 400]);
        }
    }
}
