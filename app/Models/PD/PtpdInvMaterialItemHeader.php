<?php


namespace App\Models\PD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Models\PD\Cast\DateCast;
use App\Models\PD\Lookup\PtpdInvMaterialItemV;

class PtpdInvMaterialItemHeader extends Model
{
  use HasFactory, Notifiable;

  protected $table = 'PTPD_INV_MATERIAL_ITEM';

  public $primaryKey = 'raw_material_id';
  public $timestamps = false;

  protected $fillable = [
  'inventory_item_id',
  'inventory_item_code',
  'raw_material_type_code',
  'raw_material_type',
  'blend_num',
  'description',
  'created_by',
  'creation_date',
  'last_updated_by',
  'last_update_date'
  ];

  protected $casts = [
    'creation_date' => DateCast::class,
  ];
}