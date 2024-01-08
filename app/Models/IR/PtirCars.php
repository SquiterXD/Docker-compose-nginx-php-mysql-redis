<?php

namespace App\Models\IR;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtirCars extends Model
{
    use HasFactory;
    protected $table = "ptir_cars";
    public $primaryKey = 'car_id';
    public $timestamps = false;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'document_number',
        'status',
        'asset_status',
        'year',
        'renew_type_code',
        'renew_type',
        'start_date',
        'end_date',
        'total_days',
        'department_code',
        'department_name',
        'license_plate',
        'group_code',
        'group_name',
        'insurance_amount',
        'discount',
        'duty_amount',
        'vat_amount',
        'net_amount',
        'vat_refund',
        'insurance_expense',
        'end_month_28_365',
        'end_month_29_366',
        'end_month_30_365',
        'end_month_30_366',
        'end_month_31_365',
        'end_month_31_366',
        'car_type_code',
        'car_type',
        'policy_number',
        'company_id',
        'company_name',
        'asset_id',
        'asset_number',
        'asset_description',
        'date_placed_in_service',
        'expense_account_id',
        'expense_account',
        'expense_account_desc',
        'expense_account_desc',
        'prepaid_account_id',
        'prepaid_account',
        'prepaid_account_desc',
        'policy_set_header_id',
        'policy_set_description',
        'car_brand_code',
        'car_brand',
        'car_cc',
        'engine_number',
        'tank_number',
        'line_type',
        'receivable_code',
        'receivable_name',
        'expense_flag',
        'row_type',
        'program_code',
        'created_at',
        'updated_at',
        'created_by_id',
        'created_by',
        'last_updated_by',
        'creation_date',
        'last_update_date',
    ]; 

    public function updateCars($data)
    {
        $db = PtirCars::find($data['car_id']);
        $db->document_number       = $data['document_number'];
        $db->status                = $data['status'];
        $db->asset_status          = $data['asset_status'];
        $db->license_plate         = $data['license_plate'];
        $db->renew_type_code       = $data['renew_type_code'];
        $db->renew_type            = $data['renew_type'];
        $db->start_date            = $data['start_date'];
        $db->end_date              = $data['end_date'];
        $db->department_code       = $data['department_code'];
        $db->insurance_amount      = $data['insurance_amount'];
        $db->discount              = $data['discount'];
        $db->duty_amount           = $data['duty_amount'];
        $db->vat_amount            = $data['vat_amount'];
        $db->vat_refund            = $data['vat_refund'];
        $db->net_amount            = $data['net_amount'];
        $db->company_id            = $data['company_id'];
        $db->company_name          = $data['company_name'];
        $db->policy_number         = $data['policy_number'];
        $db->expense_account_id    = $data['expense_account_id'];
        $db->expense_account       = $data['expense_account'];
        $db->expense_account_desc  = $data['expense_account_desc'];
        $db->prepaid_account_id    = $data['prepaid_account_id'];
        $db->prepaid_account       = $data['prepaid_account'];
        $db->prepaid_account_desc  = $data['prepaid_account_desc'];
        $db->policy_set_header_id  = $data['policy_set_header_id'];
        $db->policy_set_description = $data['policy_set_description'];
        $db->receivable_code       = $data['receivable_code'];
        $db->receivable_name       = $data['receivable_name'];
        $db->expense_flag          = $data['expense_flag'];
        $db->updated_at            = $data['updated_at'];
        $db->last_updated_by       = $data['last_updated_by'];
        $db->last_update_date      = $data['last_update_date'];
        $db->save();
    }

    public function vehicle()
    {
        return $this->belongsTo('\App\Models\IR\Settings\PtirVehicles', 'license_plate', 'license_plate');
    }
}
