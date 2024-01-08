<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PM\PtmpProductPlanLine;

class PtmpProductPlanHeader extends Model
{
    use HasFactory;
    protected $table = 'PTPM_PRODUCT_PLAN_H';
    protected $primaryKey = 'plan_header_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];

    public function productPlanLines()
    {
        return $this->hasMany(PtmpProductPlanLine::class, 'plan_header_id', 'plan_header_id');
    }


}
