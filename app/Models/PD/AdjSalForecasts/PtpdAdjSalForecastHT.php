<?php
namespace App\Models\PD\AdjSalForecasts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;
use PDO;

class PtpdAdjSalForecastHT extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'PTPD_ADJ_SAL_FORECAST_H_T';
    public $primaryKey = 'h_web_id';
    public $timestamps = false;

    // protected $table = 'PTPD_ADJ_SALES_FORECAST_H';
    // public $primaryKey = 'h_adj_sale_for_id';
    // public $timestamps = false;


}