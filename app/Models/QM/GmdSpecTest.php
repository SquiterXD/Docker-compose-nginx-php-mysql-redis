<?php

namespace App\Models\QM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GmdSpecTest extends Model
{
    use HasFactory;
    protected $table  = 'GMD_SPEC_TESTS';
    protected $connection   = 'oracle';

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('selectcolumn', function ($builder) {
            $builder->select(
                'spec_id',
                'test_id',
                'seq',
            );
        });
    }


    public function getMaxSeq($specId = null)
    {
        if (!$specId) {
            return 0;
        }

        return (new self)->where('spec_id', $specId)->max('seq');
    }
}
