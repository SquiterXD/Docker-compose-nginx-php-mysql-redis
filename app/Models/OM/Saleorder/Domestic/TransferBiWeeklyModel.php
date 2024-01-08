<?php

namespace App\Models\OM\Saleorder\Domestic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferBiWeeklyModel extends Model
{
    use HasFactory;

    protected $table = 'PTOM_SALES_FORECAST';
    public $primaryKey = 'SALES_FORECAST_ID';
    public $timestamps = false;

    protected $fillable = [
        'org_id',
        'budget_year',
        'version',
        'file_name',
        'path_name',
        'item_id',
        'item_code',
        'item_description',
        'biweekly_id',
        'sales_forecast_type',
        'product_category_code',
        'sales_class_type',
        'uom',
        'biweekly_no',
        'quantity',
        'amount',
        'unit_price',
        'mfg_flag',
        'mfg_date',
        'approve_flag',
        'approve_date',
        'program_code',
        'created_by',
        'creation_date',
        'last_updated_by',
        'last_update_date',
        'mfg_flag'
    ];
}
