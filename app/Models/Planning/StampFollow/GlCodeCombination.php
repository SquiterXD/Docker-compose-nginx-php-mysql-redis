<?php

namespace App\Models\Planning\StampFollow;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class GlCodeCombination extends Model
{
    use HasFactory;

    protected $table = "gl_code_combinations_kfv";
    protected $primaryKey = 'code_combination_id';

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('selectcolumn', function (Builder $builder) {
            $builder->select('code_combination_id', 'concatenated_segments', 'padded_concatenated_segments', 'enabled_flag');
        });
    }
}
