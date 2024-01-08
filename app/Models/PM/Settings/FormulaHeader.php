<?php

namespace App\Models\PM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;

class FormulaHeader extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('selectcolumn', function (Builder $builder) {
            $builder->select('recipe_id',
                            'organization_code',
                            'organization_id as org_id',
                            'flag',
                            'recipe_description',
                            'recipe_no',
                            'recipe_version as version',
                            'status',
                            'routing_id',
                            'formula_id',
                            'product_qty as qty',
                            'product_uom as uom',
                            'product_item_id',
                            'product_segment1',
                            'product_description',
                            'receipe_type',
                            'wip',
                            'machine_type',
                            'start_date',
                            'end_date',
                            'created_by',
                            'creation_date',
                            'routingstep_id',
                            'routingstep_no',
                            'formulaline_id',
                            'line_no',
                            'inventory_item_id',
                            'segment1',
                            'description',
                            'scrap_factor',
                            'require_qty',
                            'detail_uom');
        });

        // static::addGlobalScope('selectcolumn', function (Builder $builder) {
        //     $builder->select('recipe_id',
        //                     'organization_code',
        //                     'organization_id as org_id',
        //                     'flag',
        //                     'recipe_description',
        //                     'recipe_no',
        //                     'recipe_version as version',
        //                     'status',
        //                     'routing_id',
        //                     'formula_id',
        //                     'product_qty as qty',
        //                     'product_uom as uom',
        //                     'product_item_id as inventory_item_id',
        //                     'product_segment1',
        //                     'product_description',
        //                     'receipe_type as folmula_type',
        //                     'wip',
        //                     'machine_type as machine',
        //                     'start_date',
        //                     'end_date',
        //                     'created_by',
        //                     'creation_date as created_at',
        //                     'routingstep_id',
        //                     'routingstep_no',
        //                     'formulaline_id',
        //                     'line_no',
        //                     'inventory_item_id',
        //                     'segment1',
        //                     'description',
        //                     'qty',
        //                     'scrap_factor',
        //                     'require_qty',
        //                     'detail_uom');
        // });
    }

    protected $table  = 'ptpm_recipes_v';

}
