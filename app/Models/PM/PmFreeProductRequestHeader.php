<?php


namespace App\Models\PM;

use App\Models\PM\Cast\DateCast;
use App\Models\PM\Lookup\PtinvItemcatMatgroupV;
use App\Models\PM\Lookup\PMFreeProductV;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PmFreeProductRequestHeader extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'PTPM_FREE_PRODUCT';
    public $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'organization_id',
        'inventory_item_id',
        'item',
        'description',
        'qty',
        'uom',
        'create_date', 
    ];

    protected $casts = [
        'request_date' => DateCast::class,
        'send_date' => DateCast::class,
    ];
}
