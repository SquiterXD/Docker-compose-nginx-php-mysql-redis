<?php
namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class PtpmPmp0044ListJobsV extends Model
{
    use HasFactory;

    protected $table = 'ptpm_pmp0044_list_jobs_v';
    public $timestamps = false;

    public function invItem()
    {
        return $this->belongsTo(PtpmItemNumberV::class, 'inventory_item_id', 'inventory_item_id');
    }

}