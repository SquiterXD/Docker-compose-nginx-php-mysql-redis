<?php


namespace App\Models\PM;

use App\Models\Lookup\PtpmItemNumberVLookup;
use App\Models\Lookup\PtpmMachineGroupsLookup;
use App\Models\Lookup\PtpmManufactureStepLookup;
use App\Models\PM\Cast\DateCast;
use App\Models\PM\Lookup\PtpmMatInternalStatusLookup;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class PtpmIngredientRequestH extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'oapm.ptpm_ingredient_request_h';
    protected $primaryKey = 'ingreq_header_id';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'department_code',
        'department_name',
        'request_num',
        'machine_group',
        'item',
        'user_id',
        'request_date',
        'manufacture_step',
        'status',
        'organization_id',
        'inventory_item_id',
        'program_id',
        'created_by',
        'creation_date',
        'last_updated_by',
        'last_update_date',
    ];

    public function ptpmItemNumberV(): BelongsTo
    {
        return $this->belongsTo(PtpmItemNumberVLookup::class, 'item', 'item_number');
    }

    public function ptpmMachineGroups(): BelongsTo
    {
        return $this->belongsTo(PtpmMachineGroupsLookup::class, 'machine_group', 'lookup_code');
    }

    public function ptpmManufactureStep(): BelongsTo
    {
        return $this->belongsTo(PtpmManufactureStepLookup::class, 'manufacture_step', 'lookup_code');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(PtpmMatInternalStatusLookup::class, 'status', 'lookup_code');
    }

    protected $casts = [
        'request_date' => DateCast::class,
    ];
}
