<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Models\EAM\CheckOnHandImage;

class EamController extends Controller
{

    public function itemImage($itemId)
    {
        $image = CheckOnHandImage::find($itemId);
        $filename = $image->file_name;
        $path = storage_path('app/'.$image->path.$filename);
        if (!File::exists($path)) {
            // abort(404);
            dd('ไม่พบไฟล์');
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }
}
