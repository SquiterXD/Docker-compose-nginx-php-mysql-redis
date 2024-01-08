<?php


namespace App\Models\PM;

use App\Models\PM\Cast\DateCast;
use App\Models\PM\Lookup\PtinvItemcatMatgroupV;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtpmSampleproduct extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'PTPM_SAMPLE_PRODUCT';
    public $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'create_date',
        'department_code',
        'department_name',
        'item',
        'description',
        'qty',
        'uom',
        'organization_id',
        'inventory_item_id',
        'create_date',
        'created_by_id',
        'updated_at',
        'updated_by_id' 
    ];

   protected $casts = [
    ];

    // public function ingredientGroup()
    // {
    //     return $this
    //         ->hasMany(PtinvItemcatMatgroupV::class, 'type_code', 'ingedient_group');
    // }
}
