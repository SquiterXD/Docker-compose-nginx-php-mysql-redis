<?php


namespace App\Models\PM;

use App\Models\PM\Cast\DateCast;
use App\Models\PM\Lookup\PtinvItemcatMatgroupV;
use App\Models\PM\Lookup\PMFreeProductV;
use App\Models\PM\Lookup\PMItemNumberV;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PmFreeProductRequestItem extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'PTPM_ITEM_NUMBER_V';
    public $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'organization_code',
        'organization_id',
        'inventory_item_id',
        'item_number',
        'item_desc',
        'primary_unit_of_measure',
        'qty',
        'uom',
        'create_date', 
    ];

    protected $casts = [
        'request_date' => DateCast::class,
        'send_date' => DateCast::class,
    ];
}