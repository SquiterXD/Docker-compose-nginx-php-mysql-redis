<?php
namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class PtpmItemProductTransfer extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'ptpm_item_product_transfer';
    public $timestamps = false;

    public function uom()
    {
        return $this->hasOne(\App\Models\PD\Lookup\MtlUnitsOfMeasureVl::class, 'uom_code', 'primary_uom_code');
    }

    public function scopeJoinSetupMfgDept($q, $departmentCode)
    {
        $tableName = self::getTable();
        $joinTableName = (new \App\Models\PM\PtpmSetupMfgDepartmentsV)->getTable();

        $columns =[
            "{$tableName}.inventory_item_id",
            "{$tableName}.product_item_id",
            "{$tableName}.product_item_number",
            "{$tableName}.item_number",
            "{$tableName}.item_desc",
            "{$tableName}.detail_uom",
            "{$tableName}.tobacco_group_code",
            "{$tableName}.item_classification_code",
            "{$tableName}.tobacco_type_code",
            "{$tableName}.default_lot_no",
            "{$tableName}.organization_id",
            "{$tableName}.require_qty",
            "{$tableName}.ratio_require_per_unit as ratio_require_per_unit",
            // "1 as from_organization_id",
            // "1 as from_subinventory",
            // "1 as from_locator_id",
            // "{$joinTableName}.from_organization_id",
            // "{$joinTableName}.from_subinventory",
            // "{$joinTableName}.from_locator_id",
        ];

        return $q->select($columns)->addSelect(
                \DB::raw("'' as from_organization_id"),
                \DB::raw("'' as from_subinventory"),
                \DB::raw("'' as from_locator_id"),
            );

        return $q->select($columns)
                    ->leftJoin($joinTableName, function($join) use ($tableName, $joinTableName, $departmentCode) {
                        $join->on("{$joinTableName}.tobacco_group_code", "{$tableName}.tobacco_group_code")
                                ->where("{$joinTableName}.department_code", $departmentCode);
                    });
    }

}
