<?php

namespace App\Models\QM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualityAssuranceL extends Model
{
    use HasFactory;

    protected $table = 'ptqm_quality_assurance_l';
    public $primaryKey = 'quality_assurance_line_id';
    public $timestamps = false;
    protected $guarded = [];
}
