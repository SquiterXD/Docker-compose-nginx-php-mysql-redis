<?php

namespace App\Http\Controllers\PM\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PM\ImageUploadPostRawMetarialImageRequest;
use App\Http\Requests\PM\StorePostRawMtlRrN;
use App\Models\PM\PtpmItemCatImage;
use App\Repositories\PM\MaterialListRepository;
use App\Repositories\PM\PtpmItemCatImageRepository;
use App\Repositories\PM\PtpmRawMtlRrNRepository;
use Illuminate\Http\Request;

class RawMaterialListController extends Controller
{
    protected $repo, $repo_image, $repo_rec;
    public function __construct(MaterialListRepository $repo, PtpmItemCatImageRepository $repo_image, PtpmRawMtlRrNRepository $repo_rec)
    {
        $this->repo = $repo;
        $this->repo_image = $repo_image;
        $this->repo_rec = $repo_rec;
    }
    public function setJson($data, $statusCode = 200, $msg = 'Success')
    {
        return ['status_code' => $statusCode, 'data' => collect($data), 'message' => $msg];
    }
    public function index(Request $request)
    {
        $profile = getDefaultData('/pm/raw_material_list');

        $items = $this->repo->getAll($request, $profile->organization_id);
       
        return response()->json($this->setJson($items));
    }

    public function imageRemove(Request $request) {
        $this->repo_image->remove($request->organization_id, $request->organization_code, $request->item_cat_code);
        return response()->json($this->setJson([]));
    }
    public function imageUpload(ImageUploadPostRawMetarialImageRequest $request)
    {
        $result = $this->repo_image->upload($request);
        
        if($result === false) return response()->json($this->setJson([], 500, 'Upload image error'));

        return response()->json($this->setJson([]));
    }

    public function store(StorePostRawMtlRrN $request) {
        $this->repo_rec->store($request);
        return response()->json($this->setJson([]));
    }
    public function find(Request $request)
    {
        $profile = getDefaultData('/pm/raw_material_list');

        $items = $this->repo->find($request->item_cat_code, $profile->organization_id);

        return response()->json($this->setJson($items));
    }
}
