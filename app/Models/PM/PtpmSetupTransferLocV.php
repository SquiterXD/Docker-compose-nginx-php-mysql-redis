<?php
namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtpmSetupTransferLocV extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'ptpm_setup_transfer_loc_v';
    public $timestamps = false;

    protected $fillable = [
    ];

    public function scopeSourcingOnhand($q, $params)
    {
        $tableName = self::getTable();
        $joinTableName = (new \App\Models\PM\Lookup\PtinvOnhandQuantitiesV)->getTable();

        return $q
            ->selectRaw("
                {$tableName}.from_organization_id,
                {$tableName}.from_locator_id,
                {$tableName}.from_locator_code,
                {$tableName}.from_subinventory_code,
                {$joinTableName}.lot_number,
                {$joinTableName}.inventory_item_id,
                {$joinTableName}.onhand_quantity
            ")
            ->join($joinTableName, function($join) use ($tableName, $joinTableName, $params) {
                $join->on("{$joinTableName}.organization_id", "{$tableName}.from_organization_id")
                        ->whereRaw("
                            {$joinTableName}.locator_id = {$tableName}.from_locator_id
                            and {$joinTableName}.subinventory_code = {$tableName}.from_subinventory_code
                        ");

                    if ($params->inventory_item_id) {
                        $join->whereRaw("{$joinTableName}.inventory_item_id = '{$params->inventory_item_id}'");
                    }

                    if ($params->lot_number) {
                        $join->whereRaw("{$joinTableName}.lot_number = '{$params->lot_number}'");
                    }
                    if ($params->tobacco_group_code) {
                        $join->whereRaw("{$joinTableName}.tobacco_group_code = '{$params->tobacco_group_code}'");
                    }
                    if ($params->subinventory_code) {
                        $join->whereRaw("{$joinTableName}.subinventory_code = '{$params->subinventory_code}'");
                    }
                    if ($params->locator_id) {
                        // $join->where("{$joinTableName}.locator_id", (string) $params->locator_id);
                        $join->whereRaw("to_char({$joinTableName}.locator_id) =  '{$params->locator_id}'");
                    }
            })
            ->groupByRaw("
                {$tableName}.from_organization_id,
                {$tableName}.from_locator_id,
                {$tableName}.from_locator_code,
                {$tableName}.from_subinventory_code,
                {$joinTableName}.lot_number,
                {$joinTableName}.inventory_item_id,
                {$joinTableName}.onhand_quantity
            ");
    }

    public function scopeProductOnhand($q, $params)
    {
        $tableName = self::getTable();
        $joinTableName = (new \App\Models\PM\Lookup\PtinvOnhandQuantitiesV)->getTable();

        return $q
            ->selectRaw("
                {$tableName}.to_organization_id,
                {$tableName}.to_locator_id,
                {$tableName}.to_locator_code,
                {$tableName}.to_subinventory_code,
                {$joinTableName}.lot_number,
                {$joinTableName}.inventory_item_id,
                {$joinTableName}.onhand_quantity
            ")
            ->join($joinTableName, function($join) use ($tableName, $joinTableName, $params) {
                $join->on("{$joinTableName}.organization_id", "{$tableName}.to_organization_id")
                        // ->where("{$joinTableName}.locator_id", "{$tableName}.to_locator_id")
                        // ->where("{$joinTableName}.subinventory_code", "{$tableName}.to_subinventory_code");
                        ->whereRaw("
                            {$joinTableName}.locator_id = {$tableName}.to_locator_id
                            and {$joinTableName}.subinventory_code = {$tableName}.to_subinventory_code
                        ");

                    if ($params->inventory_item_id) {
                        $join->whereRaw("{$joinTableName}.inventory_item_id = '{$params->inventory_item_id}'");
                    }

                    if ($params->lot_number) {
                        $join->whereRaw("{$joinTableName}.lot_number = '{$params->lot_number}'");
                    }
                    if ($params->tobacco_group_code) {
                        $join->whereRaw("{$joinTableName}.tobacco_group_code = '{$params->tobacco_group_code}'");
                    }
                    if ($params->subinventory_code) {
                        $join->whereRaw("{$joinTableName}.subinventory_code = '{$params->subinventory_code}'");
                    }
                    if ($params->locator_id) {
                        // $join->where("{$joinTableName}.locator_id", (string) $params->locator_id);
                        $join->whereRaw("to_char({$joinTableName}.locator_id) =  '{$params->locator_id}'");
                    }
            })
            ->groupByRaw("
                {$tableName}.to_organization_id,
                {$tableName}.to_locator_id,
                {$tableName}.to_locator_code,
                {$tableName}.to_subinventory_code,
                {$joinTableName}.lot_number,
                {$joinTableName}.inventory_item_id,
                {$joinTableName}.onhand_quantity
            ");
    }
}