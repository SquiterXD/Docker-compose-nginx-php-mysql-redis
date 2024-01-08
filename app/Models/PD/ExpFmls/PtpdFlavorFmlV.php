<?php
namespace App\Models\PD\ExpFmls;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;
use PDO;

class PtpdFlavorFmlV extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'PTPD_FLAVOR_FML_V';

    public function flavorItems()
    {
        return $this->hasMany(PtpdFlavorFmlV::class, 'flavor_id','flavor_id');
    }
}
