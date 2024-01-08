<?php

namespace App\Repositories\PM;

use App\Models\PM\PtpmItemCatByOrgV;
use App\Models\PM\PtpmItemGroup;

// use DB;
// use Illuminate\Database\Eloquent\Collection;
// use Illuminate\Support\Facades\DB ;

class MaterialListRepository
{
    protected $table, $repo_image;

    public function __construct(PtpmItemGroup $table, PtpmItemCatImageRepository $repo_image)
    {
        $this->table = $table;
        $this->repo_image = $repo_image;
    }

    public function getAll($request, $organization_id)
    {
        $items = $this->table;

        if (!empty($request->item_cat_code))
            $items->where('item_cat_code', $request->item_cat_code);

        $items = $items->get();
        $items->map(function ($item) {
            $img = $this->repo_image->find( $item->item_cat_code);

            $item->img = !empty($img) ? asset('storage/'.$img->item_cat_path) : '';
            $item->name = $item->item_cat_segment2_desc;
            return $item;
        });

        return $items;
    }


    public function find($item_cat_code)
    {
        $items = $this->table->where('item_cat_code', $item_cat_code)->first();
        $img = $this->repo_image->find($items->organization_id, $items->organization_code, $items->item_cat_code);
            $items->img = !empty($img) ? asset('storage/'.$img->item_cat_path) : '';
            // $items->img = !empty($img) ? asset($img->item_cat_path) : '';

        $items->name = $items->item_cat_segment2_desc;

        return $items;
    }

    public function save($request, $organization_id)
    {
    }
}
