<?php

namespace App\Models\PM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngredientStep extends Model
{
    use HasFactory;

    protected $table  = 'ptpm_ingredient_step';
    protected $primaryKey = 'ingredient_step_id';

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class, 'ingredient_id', 'ingredient_id');
    }

    public function ingredientItems()
    {
        return $this->hasMany(IngredientItem::class, 'ingredient_step_id', 'ingredient_step_id');
    }

    public function wipStep()
    {
        return $this->belongsTo(OpmRoutingV::class, 'wip_step_id', 'oprn_id')
                    ->where('owner_organization_id', $this->ingredient->org_id);
    }
}
