<?php

namespace App\Models\OM\SaleOrder\Domestic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YearDistributeModel extends Model
{
    use HasFactory;
    protected $table="ptom_yearly_sales_forecast";
    public $primaryKey = 'yearly_id';
    public $timestamps = false;

    protected $fillable = [
        'org_id',
        'budget_year_no',
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
        'quantity',
        'amount',
        'unit_price',
        'approve_flag',
        'sales_class_type',
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
