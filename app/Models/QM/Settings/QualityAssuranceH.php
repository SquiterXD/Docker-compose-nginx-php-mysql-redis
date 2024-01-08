<?php

namespace App\Models\QM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualityAssuranceH extends Model
{
    use HasFactory;

    protected $table = 'ptqm_quality_assurance_h';
    public $primaryKey = 'quality_assurance_id';
    public $timestamps = false;
}
