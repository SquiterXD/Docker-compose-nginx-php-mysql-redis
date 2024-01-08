<?php

namespace App\Repositories\PM;

use App\Models\PM\PtpmItemCatImage;
use Illuminate\Support\Facades\Storage;

class PtpmItemCatImageRepository
{
    protected $table;

    public function __construct(PtpmItemCatImage $table)
    {
        $this->table = $table;
    }
    public function find($item_cat_code) {
       return $this->table
            ->where('item_cat_code', $item_cat_code)->first();
    }

    public function remove($organization_id, $organization_code, $item_cat_code) {
        $this->find($item_cat_code)->delete();
        return true;
    }

    public function checkHas($organization_id, $organization_code, $item_cat_code)
    {
        $data = $this->find($organization_id, $organization_code, $item_cat_code);
        return empty($data) ? false : true;
    }
    public function upload($request)
    {
        try {
            $profile = getDefaultData('/pm/raw_material_list');
            // dd($profile->archive_directory);
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            if($this->checkHas($request->organization_id, $request->organization_code,$request->item_cat_code)) 
                return false;


            // Upload Image
            // $request->file('image')->put($profile->archive_directory, $fileNameToStore);
            Storage::disk('public')->putFileAs($profile->archive_directory, $request->file('image'), $fileNameToStore);
            $path = $profile->archive_directory .'/' . $fileNameToStore;
            $data = $this->table;
            $data->item_cat_path = $path;
            $data->organization_id = 0;
            $data->organization_code = 0;
            $data->item_cat_code = $request->item_cat_code;
            $data->last_updated_by_id = $request->last_updated_by_id;
            $data->last_updated_by = $request->last_updated_by;
            $data->created_by = $request->created_by;
            $data->created_by_id = $request->created_by_id;
            $data->save();
            return $data;
        } catch (\Exception $ex) {
            dd($ex->getMessage());
            return false;
        }
    }
}
