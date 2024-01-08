<?php


namespace App\Models\PM;

use App\Models\Lookup\PtpmItemNumberVLookup;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtpmPlanningJobDists extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'PTPM_PLANNING_JOB_DISTS';
    protected $primaryKey = 'plan_distribution_id';
    public $timestamps = false;

    protected $fillable = [
        'inventory_item_id',
        'plan_quantity',
    ];

    public function itemNumberV()
    {
        return $this->belongsTo(PtpmItemNumberVLookup::class, 'inventory_item_id', 'inventory_item_id');
    }
}
