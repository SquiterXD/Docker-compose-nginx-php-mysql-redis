<?php

namespace App\Models\OM\Saleorder\Domestic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyDistributeModel extends Model
{
    use HasFactory;
    protected $table = 'ptom_monthly_sale_forecast';
    public $primaryKey = 'monthly_id';
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
        'month_no',
        'sales_forecast_type',
        'uom',
        'sales_class_type',
        'quantity',
        'amount',
        'attribute1',
        'unit_price',
        'approve_flag',
        'approve_date',
        'mfg_flag',
        'mfg_date',
        'program_code',
        'created_by',
        'creation_date',
        'last_updated_by',
        'last_update_date',
    ];
}
