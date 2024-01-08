<?php
namespace App\Models\PD\AdjSalForecasts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;
use PDO;

class PtpdAdjSalesForecastL extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'PTPD_ADJ_SALES_FORECAST_L';
    public $primaryKey = 'l_adj_sale_for_id';
    public $timestamps = false;

    // protected $table = 'PTPD_ADJ_SALES_FORECAST_L';
    // public $primaryKey = 'l_adj_sale_for_id';
    // public $timestamps = false;

}