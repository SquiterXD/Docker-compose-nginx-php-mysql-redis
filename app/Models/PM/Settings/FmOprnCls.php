<?php

namespace App\Models\PM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class FmOprnCls extends Model
{
    use HasFactory;
    protected $table  = 'fm_oprn_cls';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('selectcolumn', function (Builder $builder) {
            $builder->select('oprn_class', 'oprn_class_desc');
        });
    }
}
