<?php

namespace App\Models\QM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocatorSegment1V extends Model
{
    use HasFactory;

    protected $table = 'PTINV_LOCATOR_SEGMENT1_V';
    public $primaryKey = false;
    public $timestamps = false;
}

