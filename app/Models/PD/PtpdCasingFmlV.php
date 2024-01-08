<?php
namespace App\Models\PD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PtpdCasingFmlV extends Model
{
    use HasFactory;

    protected $table = 'PTPD_CASING_FML_V';

    public function casingItems()
    {
        return $this->hasMany(PtpdCasingFmlV::class, 'casing_id','casing_id');
    }
}
