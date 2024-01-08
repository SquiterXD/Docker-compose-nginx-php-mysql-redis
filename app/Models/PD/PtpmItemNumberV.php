<?php


namespace App\Models\PD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class PtpmItemNumberV extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'OAPM.PTPM_ITEM_NUMBER_V';
    public $timestamps = false;

    protected $fillable = [
    ];

    public static function getTableName()
    {
        return (new self())->getTable();
    }

    // organization_code,
    // item_classification_code,
    // item_classification,
    // organization_id,
    // inventory_item_id,
    // item_number,
    // item_desc,
    // item_type,
    // user_item_type,
    // primary_uom_code,
    // primary_unit_of_measure,
    // blend_no,
    // machine_min,
    // machine_max,
    // tobacco_group_code,
    // tobacco_group,
    // tobacco_type_code,
    // tobacco_type,
    // tobacco_group_detail_code,
    // tobacco_group_detail,
    // ingredient_type_code,
    // ingredient_type,
    // ingredient_group_code,
    // ingredient_group,
}
