<?php

namespace App\Repositories\OM;

use App\Models\Ptom\PtomClaimStatusV;

class ClaimStatusVRepo
{
    protected $model;
    public function __construct(PtomClaimStatusV $model)
    {
        $this->model = $model;
    }
    
    public function getList() {
        return $this->model->get();
    }
    public static function findById($id) {
        $model = new PtomClaimStatusV;
        return $model->where('lookup_code', $id)->first()->meaning ?? '';
    }
}
