<?php


namespace App\Models\PM\Cast;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class DateCast implements CastsAttributes
{
    public function get($model, $key, $value, $attributes)
    {
        return date('Y-m-d', strtotime($value));
    }

    public function set($model, $key, $value, $attributes)
    {
        return date('Y-m-d H:i:s', strtotime($value));
    }
}
