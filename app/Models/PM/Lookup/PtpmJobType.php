<?php


namespace App\Models\PM\Lookup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtpmJobType extends Model
{
    use HasFactory;

    protected $table = 'oapm.ptpm_job_type';
    public $timestamps = false;

    protected $fillable = [
    ];
}
