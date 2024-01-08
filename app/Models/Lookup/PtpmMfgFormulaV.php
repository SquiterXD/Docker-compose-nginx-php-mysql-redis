<?php


namespace App\Models\Lookup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class PtpmMfgFormulaV extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'Ptpm_Mfg_Formula_V';
    public $timestamps = false;

    protected $fillable = [
    ];

    public function scopeIsProductFlag($query){
        return $query->where('product_flag', 'Y');
    }
}
