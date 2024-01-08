<?php

namespace App\Http\Controllers\PM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class FileController extends Controller
{
    public function image(Request $request, $module, $menu, $feature, $fileName)
    {
        // $module = $request->module;
        // $menu = $request->menu;
        // $feature = $request->feature;
        // $fileName = $request->file_name;

        $filePath = storage_path("app/$module/$menu/$feature/images/$fileName");

        $image = Image::make($filePath);
        return $image->response();

    }

    public function imageThumbnail(Request $request, $module, $menu, $feature, $fileName)
    {
        // $module = $request->module;
        // $menu = $request->menu;
        // $feature = $request->feature;
        // $fileName = $request->file_name;

        $filePath = storage_path("app/$module/$menu/$feature/images/$fileName");

        $image = Image::make($filePath)->resize(null, 300, function ($constraint) {
            $constraint->aspectRatio();
        });
        return $image->response();

    }

    public function download(Request $request, $module, $menu, $feature, $fileType, $fileName)
    {

        // $module = $request->module;
        // $menu = $request->menu;
        // $feature = $request->feature;
        // $fileType = $request->file_type;
        // $fileName = $request->file_name;

        $filePath = "$module/$menu/$feature/$fileType/$fileName";

        return Storage::download("$filePath");

    }

}
