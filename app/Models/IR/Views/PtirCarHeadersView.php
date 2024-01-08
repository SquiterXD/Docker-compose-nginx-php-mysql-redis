<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtirCarHeadersView extends Model
{
    use HasFactory;

    protected $table = "ptir_car_headers_v";
    public $primaryKey = 'header_id';
    public $timestamps = false;

    public function getAllCarHeaders()
    {
        $collection = PtirCarView::select('header_id', 'status', 'document_number', 'asset_status',
                                          'renew_type', 'start_date', 'end_date', 'total_days', 
                                          'department_code', 'department_name', 'license_plate', 'insurance_amount',
                                          'discount', 'duty_amount', 'vat_amount', 'net_amount', 
                                          'vat_refund', 'car_type', 'policy_set_header_id', 'company_id',
                                          'company_name', 'asset_number', 'expense_account', 'expense_account_des',
                                          'car_brand', 'car_cc', 'engine_number', 'tank_number')
                                   ->whereRaw("year = nvl(?, year)
                                               and renew_type = nvl(?, renew_type)
                                               and license_plate = nvl(?, license_plate)
                                               and department_code = nvl(?, department_code)
                                               and asset_status = nvl(?, asset_status)
                                               and status = nvl(?, status)") 
                                   ->get();

        return $collection;
    }
}
