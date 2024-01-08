<?php

namespace App\Models\PM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngredientItem extends Model
{
    use HasFactory;

    protected $table  = 'ptpm_ingredient_item';
    protected $primaryKey = 'ingredient_line_id';

    // private $org = $this->ingredient->org_id;

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class, 'ingredient_id', 'ingredient_id');
    }

    public function ingredientStep()
    {
        return $this->belongsTo(IngredientStep::class, 'ingredient_step_id', 'ingredient_step_id');
    }

    public function item()
    {
        return $this->belongsTo(\App\Models\PM\PtpmItemNumberV::class, 'ingredient_item_id', 'inventory_item_id')
                    ->where('organization_id', $this->ingredient->org_id);
    }
}
