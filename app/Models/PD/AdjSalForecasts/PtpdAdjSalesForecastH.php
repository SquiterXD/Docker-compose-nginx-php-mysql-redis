<?php
namespace App\Models\PD\AdjSalForecasts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;
use PDO;

class PtpdAdjSalesForecastH extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'ptpd_adj_sales_forecast_h';
    public $primaryKey = 'h_adj_sale_for_id';
    public $timestamps = false;

    // protected $table = 'PTPD_ADJ_SALES_FORECAST_H';
    // public $primaryKey = 'h_adj_sale_for_id';
    // public $timestamps = false;


    public function createdBy()
    {
        return $this->hasOne(\App\Models\User::class, 'user_id', 'created_by_id');
    }
}