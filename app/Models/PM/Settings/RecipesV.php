<?php

namespace App\Models\PM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipesV extends Model
{
    use HasFactory;

    protected $table  = 'ptpm_recipes_v';
    // protected $dates = ['start_date', 'end_date'];
    protected $appends = [
        // 'start_date_format',
        // 'end_date_format',
        'creation_date_format'
    ];

    public function ingredientSteps()
    {
        return $this->hasMany(IngredientStep::class, 'ingredient_id', 'ingredient_id');
    }

    public function ingredientItems()
    {
        return $this->hasMany(IngredientItem::class, 'ingredient_id', 'ingredient_id');
    }

    public function item()
    {
        return $this->belongsTo(\App\Models\PM\PtpmItemNumberV::class, 'inventory_item_id', 'inventory_item_id')
                ->where('organization_id', $this->org_id);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\FndUser::class, 'created_by', 'user_id');
    }

    public function machineType()
    {
        return $this->belongsTo(MachineType::class, 'machine', 'lookup_code');
    }

    public function machineGroupF()
    {
        return $this->belongsTo(MachineGroupF::class, 'machine', 'lookup_code');
    }

    public function opmRouting()
    {
        return $this->belongsTo(OpmRoutingV::class, 'wip', 'oprn_id');
    }

    public function routing()
    {
        return $this->belongsTo(OpmRoutingV::class, 'routing_id', 'routing_id');
    }


    public function organization()
    {
        return $this->belongsTo(OrganizationCodeV::class, 'org_id', 'organization_id');
    }

    public function FormulaType()
    {
        return $this->belongsTo(FormulaType::class, 'folmula_type', 'lookup_code');
    }

    public function uomHeader()
    {
        return $this->belongsTo(ItemConvUomV::class, 'uom', 'from_uom_code')
                ->where('organization_id', $this->org_id);
    }

    public function uomLine()
    {
        return $this->belongsTo(ItemConvUomV::class, 'ingredient_uom', 'from_uom_code')
                ->where('organization_id', $this->org_id);
    }

    public function getStartDateFormatAttribute()
    {
        return parseToDateTh($this->start_date);
    }

    public function getEndDateFormatAttribute()
    {
        return parseToDateTh($this->end_date);
    }

    public function getCreationDateFormatAttribute()
    {
        return parseToDateTh($this->creation_date);
    }

    public function getSecureIdAttribute()
    {
        return \Crypt::encryptString($this->recipe_id);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'Approved for General Use');
    }

    public function periodYear()
    {
        return $this->belongsTo(YearsV::class, 'period_year', 'year_thai');
    }
}
