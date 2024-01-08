<?php

namespace App\Http\Controllers\EAM\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EAM\CheckOnHandV;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Models\EAM\CheckOnHandImage;

class CheckOnHandController extends Controller
{
    protected $imageFolder = 'attachments/2020/';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function search(Request $request)
    {
        try {
            $result = (new CheckOnHandV())->Search($request->all());
            return response()->json(['data' => $result]);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function uploadImage(Request $request, $itemCode)
    {
        try {
            $userId = optional(auth()->user())->user_id ?? -1;
            $request->validate([
                'image' => 'required',
                'program_code' => 'required'
            ]);
            $programCode = $request->program_code;
            /* store image file */
            $imageName = uniqid() . '.' . $request->image->extension();
            $originalName = $request->image->getClientOriginalName();
            $imagePath = $this->imageFolder;
            $request->image->storeAs($imagePath, $imageName);
            /* store image name in database */
            $image = new CheckOnHandImage();
            $image->ema_program_code = $programCode;
            $image->tran_id = $itemCode;
            $image->line_no = CheckOnHandImage::getNextLineNo($itemCode, $programCode);
            $image->original_name = $originalName;
            $image->path = $imagePath;
            $image->mime_type = $request->image->extension();
            $image->file_name = $imageName;
            $image->program_code = $programCode;
            $image->created_by = $userId;
            $image->created_by_id = $userId;
            $image->last_updated_by = $userId;
            $image->web_batch_no = CheckOnHandImage::getWebBatchNo();
            $image->save();

            return response()->json(['data' => $image]);
        } catch (\Throwable $th) {
            return $th->getMessage();
            // return back()->withErrors($th->getMessage());
        }
    }

    public function showImage($imageId)
    {
        $image = CheckOnHandImage::find($imageId);
        // $filename = 'DhajhdOUEAACDy4.jpg';
        // $path = storage_path('app/eam/work_request/12/'. $filename);
        $filename = $image->file_name;
        $path = storage_path('app/' . $image->path . $filename);
        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    public function images($itemCode)
    {
        $images = CheckOnHandImage::select([
            'attachment_id',
            'original_name',
        ])
            ->where('ema_program_code', 'EAM0001')
            ->where('tran_id', $itemCode)
            ->orderBy('line_no')
            ->get();
        return response()->json(['data' => $images]);
    }

    public function deleteImage($imageId)
    {
        $image = CheckOnHandImage::find($imageId);
        if (Storage::exists($image->path . $image->file_name)) {
            Storage::delete($image->path . $image->file_name);
            $image->delete();
            return response()->json(['message' => 'Success.', 'code' => 200]);
        } else {
            $image->delete();
            return response()->json(['message' => 'File does not exists.', 'code' => 400]);
        }
    }
}
