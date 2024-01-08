<?php


namespace App\Models\PM;

use App\Models\PM\Cast\DateCast;
use App\Models\PM\Lookup\PtinvItemcatMatgroupV;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtpmSampleProductMes extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'PTPM_SAMPLE_PRODUCT_MES';
    public $timestamps = false;

      protected $fillable = [
        'create_date',
        'item',
        'description',
        'qty',
        'uom',
        'department_id',
        'department_name',
        'organization_id',
        'inventory_item_id', 

    ];

    protected $casts = [
        'create_date' => DateCast::class,
        //'send_date' => DateCast::class,
    ];

   
}
